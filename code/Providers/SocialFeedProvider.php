<?php

class SocialFeedProvider extends DataObject
{
	private static $db = array(
		'Label' => 'Varchar(100)',
		'Enabled' => 'Boolean'
	);

	private static $summary_fields = array(
		'Label',
		'Enabled'
	);

	/**
	 * Then length of time it takes for the cache to expire
	 *
	 * @var int
	 */
	private static $default_cache_lifetime = 900; // 15 minutes (900 seconds)

	/**
	 * @return FieldList
	 */
	public function getCMSFields() {
		if (Controller::has_curr())
		{
			if (isset($_GET['socialfeedclearcache']) && $_GET['socialfeedclearcache'] == 1 && $this->canEdit()) {
				$this->clearFeedCache();
				$url =  Controller::curr()->getRequest()->getVar('url');
				$urlAndParams = explode('?', $url);
				Controller::curr()->redirect($urlAndParams[0]);
			}

			$this->beforeUpdateCMSFields(function($fields) {
				$cache = $this->getFeedCache();
				if ($cache !== null && $cache !== false) {
					$url = Controller::curr()->getRequest()->getVar('url');
					$url .= '?socialfeedclearcache=1';
					$fields->addFieldToTab('Root.Main', LiteralField::create('cacheclear', '<a href="'.$url.'" class="field ss-ui-button ui-button" style="max-width: 100px;">Clear Cache</a>'));
				}
			});
		}
		$fields = parent::getCMSFields();
		return $fields;
	}

	/**
	 * Get feed from provider, will automatically cache the result.
	 *
	 * If QueuedJobs module is installed, it will also create a job to update the cache
	 * 5 minutes before it expires.
	 *
	 * @return SS_List
	 */
	public function getFeed() {
		$feed = $this->getFeedCache();
		if (!$feed) {
		    $feed = $this->getFeedUncached();
		    $this->setFeedCache($feed);
		    if (class_exists('AbstractQueuedJob')) {
		    	singleton('SocialFeedCacheQueuedJob')->createJob($this);
		    }
		}

		$data = array();
		if ($feed) {
			foreach ($feed as $post) {
				$created = SS_Datetime::create();
				$created->setValue($this->getPostCreated($post));

				$data[] = array(
					'Type' => $this->getType(),
					'Content' => $this->getPostContent($post),
					'Created' => $created,
					'URL' => $this->getPostUrl($post),
					'Data' => $post,
				);
			}
		}
		$result = ArrayList::create($data);
		$result = $result->sort('Created', 'DESC');
		return $result;
	}

	/**
	 * Retrieve the providers feed without checking the cache
	 * first.
	 *
	 * @return array
	 */
	public function getFeedUncached() {
		throw new Exception($this->class.' missing implementation for '.__FUNCTION__);
	}

	/**
	 * Get the providers feed from the cache. If there is no cache
	 * then return false.
	 *
	 * @return array
	 */
	public function getFeedCache() {
		$cache = $this->getCacheFactory();
		$feedStore = $cache->load($this->ID);
		if (!$feedStore) {
			return false;
		}
		$feed = unserialize($feedStore);
		if (!$feed) {
			return false;
		}
		return $feed;
	}

	/**
	 * Get the time() that the cache expires at.
	 *
	 * @return int
	 */
	public function getFeedCacheExpiry() {
		$cache = $this->getCacheFactory();
		$metadata = $cache->getMetadatas($this->ID);
		if ($metadata && isset($metadata['expire'])) {
			return $metadata['expire'];
		}
		return false;
	}

	/**
	 * Set the cache.
	 */
	public function setFeedCache(array $feed) {
		$cache = $this->getCacheFactory();
		$feedStore = serialize($feed);
		$result = $cache->save($feedStore, $this->ID);
		return $result;
	}

	/**
	 * Clear the cache that holds this providers feed.
	 */
	public function clearFeedCache() {
		$cache = $this->getCacheFactory();
		return $cache->remove($this->ID);
	}

	/**
	 * @return Zend_Cache_Frontend_Output
	 */
	protected function getCacheFactory() {
		$cache = SS_Cache::factory('SocialFeedProvider');
		$cache->setLifetime($this->config()->default_cache_lifetime);
		return $cache;
	}
}

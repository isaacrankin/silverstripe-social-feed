<?php

class SocialFeedControllerExtension extends DataExtension
{
	public function __construct()
	{
		parent::__construct();
		$this->siteConfig = SiteConfig::current_site_config();
	}

	public function onBeforeInit() 
	{
		if (Director::isDev()) {
			// Allow easy clearing of the cache in dev mode
			if (isset($_GET['socialfeedclearcache']) && $_GET['socialfeedclearcache'] == 1) {
				foreach (SocialFeedProvider::get() as $prov) {
					$prov->clearFeedCache();
				}
			}
		}
	}

	public function SocialFeed()
	{
		$combinedData = array();
		$combinedData = $this->getProviderFeed(SocialFeedProviderInstagram::get(), $combinedData);
		$combinedData = $this->getProviderFeed(SocialFeedProviderFacebook::get(), $combinedData);
		$combinedData = $this->getProviderFeed(SocialFeedProviderTwitter::get(), $combinedData);

		$result = new ArrayList($combinedData);
		$result = $result->sort('Created', 'DESC');
		return $result;
	}

	private function getProviderFeed($providers, $data = array())
	{
		foreach ($providers as $prov) {

			if (is_subclass_of($prov, 'SocialFeedProvider')) {
				$feed = $prov->getFeedCache();

				if (!$feed) {
				    $feed = $prov->getFeed();
				    $prov->setFeedCache($feed);
				    if (class_exists('AbstractQueuedJob')) {
				    	singleton('SocialFeedCacheQueuedJob')->createJob($prov);
				    }
				}

				if ($feed) {
					foreach ($feed as $post) {
						$created = SS_Datetime::create();
						$created->setValue($prov->getPostCreated($post));

						array_push($data, array(
							'Type' => $prov->getType(),
							'Data' => $post,
							'Created' => $created,
							'URL' => $prov->getPostUrl($post)
						));
					}
				}
			}
		}
		return $data;
	}
}

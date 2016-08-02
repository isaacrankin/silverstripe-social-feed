<?php

if (!class_exists('AbstractQueuedJob')) {
	return;
}

class SocialFeedCacheQueuedJob extends AbstractQueuedJob {
	/**
	 * Set queued job execution time to be 5 minutes before the cache expires
	 * by default.
	 */
	private static $cache_time_offset = -300;

	public function createJob($prov) {
		$time = $prov->getFeedCacheExpiry();
		$runDate = date('Y-m-d H:i:s', time());
		if ($time) {
			$timeOffset = intval(Config::inst()->get(__CLASS__, 'cache_time_offset'));
			$time += $timeOffset;
			$runDate = date('Y-m-d H:i:s', $time);
		}
		$class = get_class();
		singleton('QueuedJobService')->queueJob(new $class($prov), $runDate);
	}

	public function __construct($provider = null) {
		if ($provider) {
			$this->setObject($provider);
			$this->totalSteps = 1;
		}
	}

	public function getTitle() {
		$provider = $this->getObject();
		return _t(
			'SocialFeed.SCHEDULEJOBTITLE',
			'Social Feed - Update cache for "{label}" ({class})',
			'',
			array(
				'class' => $provider->ClassName,
				'label' => $provider->Label
			)
		);
	}

	public function process() {
		if ($prov = $this->getObject()) {
			$feed = $prov->getFeed();
			$prov->setFeedCache($feed);
		}
		$this->currentStep = 1;
		$this->isComplete = true;
	}

	/**
	 * Called when the job is determined to be 'complete'
	 */
	public function afterComplete() {
		$prov = $this->getObject();
		if ($prov)
		{
			// Create next job
			singleton(__CLASS__)->createJob($prov);
		}
	}
}
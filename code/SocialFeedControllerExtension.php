<?php

class SocialFeedControllerExtension extends DataExtension
{
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
				if ($feed = $prov->getFeed()) {
					foreach ($feed->toArray() as $post) {
						$data[] = $post;
					}
				}
			}
		}
		return $data;
	}
}

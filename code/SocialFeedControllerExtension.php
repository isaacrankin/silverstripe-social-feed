<?php

class SocialFeedControllerExtension extends DataExtension
{
	public function __construct()
	{
		parent::__construct();
		$this->siteConfig = SiteConfig::current_site_config();
	}

	public function SocialFeed()
	{
		$combinedData = $this->getProviderFeed(SocialFeedProviderInstagram::get()->filter('Enabled', 1));
		$combinedData = $this->getProviderFeed(SocialFeedProviderFacebook::get()->filter('Enabled', 1), $combinedData);
		$combinedData = $this->getProviderFeed(SocialFeedProviderTwitter::get()->filter('Enabled', 1), $combinedData);

		//TODO: normalize and order by creation time

		return new ArrayList($combinedData);
	}

	private function getProviderFeed($providers, $data = array())
	{
		foreach ($providers as $prov) {

			if (is_subclass_of($prov, 'SocialFeedProvider')) {

				$feed = $prov->getFeed();

				foreach ($feed as $post) {
					array_push($data, array(
						'Type' => $prov->getType(),
						'Data' => $post,
						'Created' => $prov->getPostCreated($post),
						'URL' => $prov->getPostUrl($post)
					));
				}
			}
		}
		return $data;
	}
}

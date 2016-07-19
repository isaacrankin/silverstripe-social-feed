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
		// Facebook data
		$facebookProviders = SocialFeedProviderFacebook::get();
		$fbData = array();

		foreach ($facebookProviders as $fbProv) {
			array_push($fbData, $fbProv->getFeed());
		}

		// Twitter data
		$twitterProviders = SocialFeedProviderTwitter::get();
		$twData = array();

		foreach ($twitterProviders as $twProv) {
			array_push($twData, $twProv->getFeed());
		}

		// Instagram data
		$instagramProviders = SocialFeedProviderInstagram::get();
		$instData = array();

		foreach ($instagramProviders as $instProv) {
			array_push($instData, $instProv->getFeed());
		}

		//TODO: combine data together - include a "type" property

		return new ArrayList(array());
	}
}

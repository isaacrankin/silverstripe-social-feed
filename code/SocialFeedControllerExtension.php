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
		var_dump($this->getFacebookFeed());
		die();
		return new ArrayData($this->getFacebookFeed());
	}

	private function combineFeeds($feeds)
	{

	}
	
	public function getFacebookFeed()
	{

		$fbSession = new Facebook\Facebook([
			'app_id' => $this->siteConfig->SocialFeedFacebookAppID,
			'app_secret' => $this->siteConfig->SocialFeedFacebookAppSecret
		]);

		// For an App Access Token we can just use our App ID and App Secret piped together
		// https://developers.facebook.com/docs/facebook-login/access-tokens#apptokens
		$fbSession->setDefaultAccessToken($fbSession->getApp()->getId() . '|' . $fbSession->getApp()->getSecret());

		// Get all data for the FB page
		$request = $fbSession->get('/' . $this->siteConfig->SocialFeedFacebookPageID . '/feed');

		// Just return the data (there's loads of meta data in the whole request)
		return json_decode($request->getBody());
	}
}

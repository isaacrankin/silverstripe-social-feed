<?php

use \Abraham\TwitterOAuth\TwitterOAuth;
use \League\OAuth2\Client\Provider\Facebook;
use \League\OAuth2\Client\Provider\Instagram;

class SocialFeedControllerExtension extends DataExtension
{
	public function __construct()
	{
		parent::__construct();
		$this->siteConfig = SiteConfig::current_site_config();
	}

	public function SocialFeed()
	{
//		$twitterData = $this->getTwitter();
//		$facebookData = $this->getFacebook();
		$instagramData = $this->getInstagram();

		return new ArrayList(array());
	}

	private function getTwitter()
	{
		$connection = new TwitterOAuth($this->siteConfig->SocialFeedTwitterConsumerKey, $this->siteConfig->SocialFeedTwitterConsumerSecret, $this->siteConfig->SocialFeedTwitterAccessToken, $this->siteConfig->SocialFeedTwitterAccessTokenSecret);
		return $connection->get('statuses/user_timeline', ['count' => 25, 'exclude_replies' => true]);
	}

	private function getFacebook()
	{
		$provider = new Facebook([
			'clientId' => $this->siteConfig->SocialFeedFacebookAppID,
			'clientSecret' => $this->siteConfig->SocialFeedFacebookAppSecret,
			// https://github.com/thephpleague/oauth2-facebook#graph-api-version
			'graphApiVersion' => 'v2.6'
		]);

		// For an App Access Token we can just use our App ID and App Secret pipped together
		// https://developers.facebook.com/docs/facebook-login/access-tokens#apptokens
		$accessToken = $this->siteConfig->SocialFeedFacebookAppID . '|' . $this->siteConfig->SocialFeedFacebookAppSecret;

		// Get all data for the FB page
		$request = $provider->getRequest('GET', 'https://graph.facebook.com/'. $this->siteConfig->SocialFeedFacebookPageID .'/feed?access_token=' . $accessToken);
		$result = $provider->getResponse($request);

		return $result['data'];
	}

	private function getInstagram()
	{
		$provider = new Instagram([
			'clientId' => $this->siteConfig->SocialFeedInstagramClientID,
			'clientSecret' => $this->siteConfig->SocialFeedInstagramClientSecret
		]);

		$accessToken = $this->siteConfig->SocialFeedInstagramClientID . '|' . $this->siteConfig->SocialFeedInstagramClientSecret;

		// Get all data for the FB page
		$request = $provider->getRequest('GET', 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' . $accessToken);
		$result = $provider->getResponse($request);

		var_dump($result);
		die();
//
//		return $result['data'];
	}
}

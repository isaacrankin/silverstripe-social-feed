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
		return new ArrayList($this->getFacebookFeed());
	}

	public function getFacebookFeed()
	{
		$provider = new \League\OAuth2\Client\Provider\Facebook([
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
}

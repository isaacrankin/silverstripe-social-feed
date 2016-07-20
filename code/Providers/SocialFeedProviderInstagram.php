<?php

use \League\OAuth2\Client\Provider\Instagram;

class SocialFeedProviderInstagram extends SocialFeedProvider
{
	private static $db = array(
		'ClientID' => 'Varchar(400)',
		'ClientSecret' => 'Varchar(400)',
		'AccessToken' => 'Varchar(400)'
	);

	private static $singular_name = 'Instagram Provider';
	private static $plural_name = 'Instagram Provider\'s';

	private $authBaseURL = 'https://api.instagram.com/oauth/authorize/';

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->addFieldsToTab('Root.Main', new LiteralField('sf_html_1', '<h4>To get the necessary Instagram API credentials you\'ll need to create an <a href="https://www.instagram.com/developer/clients/manage/" target="_blank">Instagram Client.</a></h4>'), 'Label');
		$fields->addFieldsToTab('Root.Main', new LiteralField('sf_html_2', '<p>You\'ll need to add the following redirect URI <code>' . $this->getRedirectUri() . '</code> in the settings for the Instagram App.</p>'), 'Label');

		if ($this->ClientID && $this->ClientSecret) {
			$url = $this->authBaseURL . '?client_id=' . $this->ClientID . '&response_type=code&redirect_uri=' . $this->getRedirectUri() . '?provider_id=' . $this->ID;
			$fields->addFieldsToTab('Root.Main', new LiteralField('sf_html_3', '<p><a href="' . $url . '"><button type="button">Authorize App to get Access Token</a></button>'), 'Label');
		}

		return $fields;
	}

	public function getCMSValidator()
	{
		return new RequiredFields(array('ClientID', 'ClientSecret'));
	}

	/**
	 * Construct redirect URI using current class name - used during OAuth flow.
	 * @return string
	 */
	private function getRedirectUri()
	{
		return Director::absoluteBaseURL() . 'admin/social-feed/' . $this->ClassName . '/';
	}

	/**
	 * Fetch access token using code, used in the second step of OAuth flow.
	 *
	 * @param $accessCode
	 * @return \League\OAuth2\Client\Token\AccessToken
	 */
	public function fetchAccessToken($accessCode)
	{
		$provider = new Instagram([
			'clientId' => $this->ClientID,
			'clientSecret' => $this->ClientSecret,
			'redirectUri' => $this->getRedirectUri() . '?provider_id=' . $this->ID
		]);

		//TODO: handle token expiry
		//TODO: save returned user data?
		return $token = $provider->getAccessToken('authorization_code', [
			'code' => $accessCode
		]);
	}

	/**
	 * Fetch Instagram data for authorized user
	 *
	 * @return mixed
	 */
	public function getFeed()
	{
		$provider = new Instagram([
			'clientId' => $this->ClientID,
			'clientSecret' => $this->ClientSecret,
			'redirectUri' => $this->getRedirectUri() . '?provider_id=' . $this->ID
		]);

		$request = $provider->getRequest('GET', 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' . $this->AccessToken);
		$result = $provider->getResponse($request);
		return $result['data'];
	}
}

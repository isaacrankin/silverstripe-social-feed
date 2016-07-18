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

	public function getCMSFields()
	{
		//		echo '<a href="';
//		echo 'https://api.instagram.com/oauth/authorize/?client_id=' . $this->siteConfig->SocialFeedInstagramClientID . '&redirect_uri='. 'http://isaacrankin.com' . '&response_type=code';
//		echo '">Authorize</a>';

		$fields = parent::getCMSFields();
		$fields->addFieldsToTab('Root.Main', new LiteralField('sf_html_7', '<h4>To get the necessary Instagram API credentials you\'ll need to create an <a href="https://www.instagram.com/developer/clients/manage/" target="_blank">Instagram Client.</a></h4><p>&nbsp;</p>'), 'Label');
		return $fields;
	}

	public function getCMSValidator()
	{
		return new RequiredFields(array('ClientID', 'ClientSecret'));
	}

	public function getFeed()
	{
		$provider = new Instagram([
			'clientId' => $this->ClientID,
			'clientSecret' => $this->ClientSecret,
			'redirectUri' => 'http://isaacrankin.com'
		]);

		$token = $provider->getAccessToken('authorization_code', [
			'code' => $this->AccessToken
		]);

		// Get all data for the FB page
		$request = $provider->getRequest('GET', 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' . $token);
		$result = $provider->getResponse($request);
		return $result;
	}
}

<?php

use \League\OAuth2\Client\Provider\Facebook;

class SocialFeedProviderFacebook extends SocialFeedProvider implements SocialFeedProviderInterface
{
	private static $db = array(
		'FacebookPageID' => 'Varchar(100)',
		'FacebookAppID' => 'Varchar(400)',
		'FacebookAppSecret' => 'Varchar(400)',
		'AccessToken' => 'Varchar(400)'
	);

	private static $singular_name = 'Facebook Provider';
	private static $plural_name = 'Facebook Provider\'s';

	private static $summary_fields = array(
		'Label',
		'Enabled',
		'FacebookPageID'
	);

	private $type = 'facebook';

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->addFieldsToTab('Root.Main', new LiteralField('sf_html_1', '<h4>To get the necessary Facebook API credentials you\'ll need to create a <a href="https://developers.facebook.com/apps" target="_blank">Facebook App.</a></h4><p>&nbsp;</p>'), 'Label');
		$fields->removeByName('AccessToken');
		return $fields;
	}

	public function getCMSValidator()
	{
		return new RequiredFields(array('FacebookPageID', 'FacebookAppID', 'FacebookAppSecret'));
	}

	public function onBeforeWrite()
	{
		if ($this->FacebookAppID && $this->FacebookAppSecret) {
			$this->AccessToken = $this->FacebookAppID . '|' . $this->FacebookAppSecret;
		}

		parent::onBeforeWrite();
	}

	/**
	 * Return the type of provider
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	public function getFeed()
	{
		$provider = new Facebook([
			'clientId' => $this->FacebookAppID,
			'clientSecret' => $this->FacebookAppSecret,
			// https://github.com/thephpleague/oauth2-facebook#graph-api-version
			'graphApiVersion' => 'v2.6'
		]);

		// For an App Access Token we can just use our App ID and App Secret pipped together
		// https://developers.facebook.com/docs/facebook-login/access-tokens#apptokens
		$accessToken = ($this->AccessToken) ? $this->AccessToken : $this->siteConfig->SocialFeedFacebookAppID . '|' . $this->siteConfig->SocialFeedFacebookAppSecret;

		// Get all data for the FB page
		$request = $provider->getRequest('GET', 'https://graph.facebook.com/' . $this->FacebookPageID . '/feed?access_token=' . $accessToken);
		$result = $provider->getResponse($request);

		return $result['data'];
	}

	/**
	 * Get the creation time from a post
	 *
	 * @param $post
	 * @return mixed
	 */
	public function getPostCreated($post)
	{
		return $post['created_time'];
	}

	/**
	 * Get the post URL from a post
	 *
	 * @param $post
	 * @return mixed
	 */
	public function getPostUrl($post)
	{
		return ($post['actions'][0]['name'] === 'Share') ? $post['actions'][0]['link'] : '';
	}


}

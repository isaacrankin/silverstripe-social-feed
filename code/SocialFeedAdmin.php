<?php

class SocialFeedAdmin extends ModelAdmin
{
	private static $managed_models = array(
		'SocialFeedProviderFacebook',
		'SocialFeedProviderTwitter',
		'SocialFeedProviderInstagram'
	);

	private static $url_segment = 'social-feed';

	private static $menu_title = 'Social Feed';

	public function init()
	{
		parent::init();

		// get the currently managed model
		$model = $this->getRequest()->param('ModelClass');

		// Instagram OAuth flow in action
		if($model === 'SocialFeedProviderInstagram' && isset($_GET['provider_id']) && is_numeric($_GET['provider_id']) && isset($_GET['code'])) {
			// Find provider
			$instagramProvider = DataObject::get_by_id('SocialFeedProviderInstagram', $_GET['provider_id']);

			// Fetch access token using code
			$accessToken = $instagramProvider->fetchAccessToken($_GET['code']);

			// Set and save access token
			$instagramProvider->AccessToken = $accessToken->getToken();
			$instagramProvider->write();

			// Send user back to edit page
			// TODO: show user a notification?
			header('Location: ' . Director::absoluteBaseURL() . 'admin/social-feed/' . $model . '/EditForm/field/' . $model . '/item/' . $_GET['provider_id'] . '/edit');
			exit;
		}
	}
}

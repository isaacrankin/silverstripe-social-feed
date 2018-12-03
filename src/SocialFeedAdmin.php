<?php

namespace IsaacRankin\SocialFeed;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Control\Director;
use IsaacRankin\SocialFeed\Providers\SocialFeedProviderFacebook;
use IsaacRankin\SocialFeed\Providers\SocialFeedProviderTwitter;
use IsaacRankin\SocialFeed\Providers\SocialFeedProviderInstagram;


class SocialFeedAdmin extends ModelAdmin
{
	private static $managed_models = array(
		SocialFeedProviderFacebook::class,
		SocialFeedProviderTwitter::class,
		SocialFeedProviderInstagram::class
	);

	private static $url_segment = 'social-feed';

	private static $menu_title = 'Social Feed';
	
	private static $menu_icon_class = 'font-icon-share';

	public function init()
	{
		parent::init();

		// get the currently managed model
		$model = $this->getRequest()->param('ModelClass');

		// Instagram OAuth flow in action
		if($model === SocialFeedProviderInstagram::class && isset($_GET['provider_id']) && is_numeric($_GET['provider_id']) && isset($_GET['code'])) {
			// Find provider
			$instagramProvider = SocialFeedProviderInstagram::get()->byID($_GET['provider_id']);

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





    public function getList()
    {
        $context = $this->getSearchContext();
        $params = $this->getRequest()->requestVar('q');

        if (is_array($params)) {
            $params = ArrayLib::array_map_recursive('trim', $params);

            // Parse all DateFields to handle user input non ISO 8601 dates
            foreach ($context->getFields() as $field) {
                if ($field instanceof DatetimeField && !empty($params[$field->getName()])) {
                    $params[$field->getName()] = date('Y-m-d', strtotime($params[$field->getName()]));
                }
            }
        }


        $list = $context->getResults($params);

        $this->extend('updateList', $list);

        return $list;
    }








}

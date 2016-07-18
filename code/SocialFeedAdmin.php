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
}

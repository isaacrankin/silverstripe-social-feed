<?php

class SocialFeedProviderTwitter extends SocialFeedProvider
{
	private static $db = array (
		'ConsumerKey' => 'Varchar(400)',
		'ConsumerSecret' => 'Varchar(400)',
		'AccessToken' => 'Varchar(400)',
		'AccessTokenSecret' => 'Varchar(400)'
	);

	private static $singular_name = 'Twitter Provider';
	private static $plural_name = 'Twitter Provider\'s';

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->addFieldsToTab('Root.Main', new LiteralField('sf_html_4', '<h4>To get the necessary Twitter API credentials you\'ll need to create a <a href="https://apps.twitter.com" target="_blank">Twitter App.</a></h4><p>&nbsp;</p>'), 'Label');
		return $fields;
	}

}

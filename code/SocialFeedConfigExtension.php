<?php

class SocialFeedConfigExtension extends DataExtension
{
	static $db = array(
		'SocialFeedFacebookPageID' => 'Varchar(400)',
		'SocialFeedFacebookAppID' => 'Varchar(400)',
		'SocialFeedFacebookAppSecret' => 'Varchar(400)'
	);

	public function updateCMSFields(FieldList $fields)
	{
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new LiteralField('html_1', '<h2>Facebook</h2>'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new TextField('SocialFeedFacebookPageID', 'Facebook Page ID'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new TextField('SocialFeedFacebookAppID', 'App ID'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new TextField('SocialFeedFacebookAppSecret', 'App Secret'));

		// TODO: Twitter
		// TODO: Instagram
	}
}

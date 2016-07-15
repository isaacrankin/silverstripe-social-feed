<?php

class SocialFeedConfigExtension extends DataExtension
{
	static $db = array(
		// Facebook
		'SocialFeedFacebookPageID' => 'Varchar(400)',
		'SocialFeedFacebookAppID' => 'Varchar(400)',
		'SocialFeedFacebookAppSecret' => 'Varchar(400)',
		// Twitter
		'SocialFeedTwitterConsumerKey' => 'Varchar(400)',
		'SocialFeedTwitterConsumerSecret' => 'Varchar(400)',
		'SocialFeedTwitterAccessToken' => 'Varchar(400)',
		'SocialFeedTwitterAccessTokenSecret' => 'Varchar(400)',
		// Instagram
		'SocialFeedInstagramClientID' => 'Varchar(400)',
		'SocialFeedInstagramClientSecret' => 'Varchar(400)'
	);

	public function updateCMSFields(FieldList $fields)
	{
		$fields->addFieldsToTab('Root.SocialFeed', new LiteralField('sf_html_1', '<h2>Facebook</h2>'));
		$fields->addFieldsToTab('Root.SocialFeed', new LiteralField('sf_html_2', '<p>To get the necessary Facebook API credentials you\'ll need to create a <a href="https://developers.facebook.com/apps" target="_blank">Facebook App.</a></p>'));
		$fields->addFieldsToTab('Root.SocialFeed', new TextField('SocialFeedFacebookPageID', 'Facebook Page ID'));
		$fields->addFieldsToTab('Root.SocialFeed', new TextField('SocialFeedFacebookAppID', 'App ID'));
		$fields->addFieldsToTab('Root.SocialFeed', new TextField('SocialFeedFacebookAppSecret', 'App Secret'));

		$fields->addFieldsToTab('Root.SocialFeed', new LiteralField('sf_html_3', '<h2>Twitter</h2>'));
		$fields->addFieldsToTab('Root.SocialFeed', new LiteralField('sf_html_4', '<p>To get the necessary Twitter API credentials you\'ll need to create a <a href="https://apps.twitter.com" target="_blank">Twitter App.</a></p>'));
		$fields->addFieldsToTab('Root.SocialFeed', new TextField('SocialFeedTwitterConsumerKey', 'Consumer Key'));
		$fields->addFieldsToTab('Root.SocialFeed', new TextField('SocialFeedTwitterConsumerSecret', 'Consumer Secret'));
		$fields->addFieldsToTab('Root.SocialFeed', new LiteralField('sf_html_5', '<h5>Access tokens for your Twitter account:</h5>'));
		$fields->addFieldsToTab('Root.SocialFeed', new TextField('SocialFeedTwitterAccessToken', 'Access Token'));
		$fields->addFieldsToTab('Root.SocialFeed', new TextField('SocialFeedTwitterAccessTokenSecret', 'Access Token Secret'));

		$fields->addFieldsToTab('Root.SocialFeed', new LiteralField('sf_html_6', '<h2>Instagram</h2>'));
		$fields->addFieldsToTab('Root.SocialFeed', new LiteralField('sf_html_7', '<p>To get the necessary Instagram API credentials you\'ll need to create an <a href="https://www.instagram.com/developer/clients/manage/" target="_blank">Instagram Client.</a></p>'));
		$fields->addFieldsToTab('Root.SocialFeed', new TextField('SocialFeedInstagramClientID', 'Client ID'));
		$fields->addFieldsToTab('Root.SocialFeed', new TextField('SocialFeedInstagramClientSecret', 'Client Secret'));
	}
}

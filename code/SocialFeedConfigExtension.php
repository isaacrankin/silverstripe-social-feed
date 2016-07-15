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
		'SocialFeedTwitterAccessTokenSecret' => 'Varchar(400)'
		// Instagram
	);

	public function updateCMSFields(FieldList $fields)
	{
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new LiteralField('sf_html_1', '<h2>Facebook</h2>'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new LiteralField('sf_html_2', '<p>To get the necessary Facebook API credentials you\'ll need to create a <a href="https://developers.facebook.com/apps" target="_blank">Facebook App.</a></p>'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new TextField('SocialFeedFacebookPageID', 'Facebook Page ID'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new TextField('SocialFeedFacebookAppID', 'App ID'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new TextField('SocialFeedFacebookAppSecret', 'App Secret'));

		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new LiteralField('sf_html_3', '<h2>Twitter</h2>'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new LiteralField('sf_html_4', '<p>To get the necessary Twitter API credentials you\'ll need to create a <a href="https://apps.twitter.com" target="_blank">Twitter App.</a></p>'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new TextField('SocialFeedTwitterConsumerKey', 'Consumer Key'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new TextField('SocialFeedTwitterConsumerSecret', 'Consumer Secret'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new LiteralField('sf_html_5', '<h5>Access tokens for your Twitter account:</h5>'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new TextField('SocialFeedTwitterAccessToken', 'Access Token'));
		$fields->addFieldsToTab('Root.SocialFeed.Facebook', new TextField('SocialFeedTwitterAccessTokenSecret', 'Access Token Secret'));

		// TODO: Instagram
	}
}

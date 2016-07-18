<?php

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
		$fields = parent::getCMSFields();
		$fields->addFieldsToTab('Root.Main', new LiteralField('sf_html_7', '<h4>To get the necessary Instagram API credentials you\'ll need to create an <a href="https://www.instagram.com/developer/clients/manage/" target="_blank">Instagram Client.</a></h4><p>&nbsp;</p>'), 'Label');
		return $fields;
	}

	public function getCMSValidator()
	{
		return new RequiredFields(array('ClientID', 'ClientSecret'));
	}
}

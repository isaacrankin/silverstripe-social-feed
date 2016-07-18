<?php

class SocialFeedProviderFacebook extends SocialFeedProvider
{
	private static $db = array (
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

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->addFieldsToTab('Root.Main', new LiteralField('sf_html_2', '<h4>To get the necessary Facebook API credentials you\'ll need to create a <a href="https://developers.facebook.com/apps" target="_blank">Facebook App.</a></h4><p>&nbsp;</p>'), 'Label');
		// For an App Access Token we can just use our App ID and App Secret pipped together
		// https://developers.facebook.com/docs/facebook-login/access-tokens#apptokens
		$fields->removeByName('AccessToken');
		return $fields;
	}
}

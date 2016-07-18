<?php

class SocialFeedProvider extends DataObject
{
	private static $db = array(
		'Label' => 'Varchar(100)',
		'Enabled' => 'Boolean'
	);

	private static $summary_fields = array(
		'Label',
		'Enabled'
	);
}

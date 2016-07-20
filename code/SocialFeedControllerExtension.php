<?php

class SocialFeedControllerExtension extends DataExtension
{
	public function __construct()
	{
		parent::__construct();
		$this->siteConfig = SiteConfig::current_site_config();
	}

	public function SocialFeed()
	{
		$combinedData = array();

		// get data for all FB providers
		$facebookProviders = SocialFeedProviderFacebook::get();

		foreach ($facebookProviders as $fbProv) {

			$feed = $fbProv->getFeed();

			foreach ($feed as $post) {
				array_push($combinedData, array(
					'Type' => 'facebook',
					'Created' => $post['created_time'],
					'Data' => $post,
					'URL' => ($post['actions'][0]['name'] === 'Share') ? $post['actions'][0]['link'] : false
				));
			}

		}

		// get data for all Twitter providers
		$twitterProviders = SocialFeedProviderTwitter::get();
		foreach ($twitterProviders as $twProv) {

			$feed = $twProv->getFeed();

			foreach ($feed as $post) {
				array_push($combinedData, array(
					'Type' => 'twitter',
					'Created' => $post->created_at,
					'Data' => $post,
					'URL' => 'https://twitter.com/' . (string) $post->user->id .'/status/' . (string) $post->id
				));
			}

		}



//		// Twitter data
//		$twitterProviders = SocialFeedProviderTwitter::get();
//		$twData = array();
//
//		foreach ($twitterProviders as $twProv) {
//			array_push($twData, $twProv->getFeed());
//		}
//
//		// Instagram data
//		$instagramProviders = SocialFeedProviderInstagram::get();
//		$instData = array();
//
//		foreach ($instagramProviders as $instProv) {
//			array_push($instData, $instProv->getFeed());
//		}

		//TODO: combine data together - include a "type" property - order by date



		return new ArrayList($combinedData);
	}
}

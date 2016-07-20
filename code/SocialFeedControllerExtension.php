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

		// Get data for all Instagram providers
		$instagramProviders = SocialFeedProviderInstagram::get();
		foreach ($instagramProviders as $instProv) {

			$feed = $instProv->getFeed();

			foreach ($feed as $post) {
				array_push($combinedData, array(
					'Type' => 'instagram',
					'Created' => $post['created_time'],
					'Data' => $post,
					'URL' => $post['link']
				));
			}

		}

		// Get data for all FB providers
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

		// Get data for all Twitter providers
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

		return new ArrayList($combinedData);
	}
}

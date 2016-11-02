# SilverStripe Social Feed
Combine social media posts from Facebook, Twitter and Instagram into a single feed.
Each feed is available separately also.

## Installation
```composer require isaacrankin/silverstripe-social-feed```

## Usage

```<% include SocialFeed %>```

Alternatively you can call the `SocialFeed` method directly like so:

```
<ol>
	<% loop SocialFeed %>
		<li>
			<a href="$URL" target="_blank">
				<h4>Type: $Type</h4>
				<p>Created: $Created</p>
				<!-- Use $Data attribute for provider specific data -->
			</a>
		</li>
	<% end_loop %>
</ol>
```

[See a more detailed example](https://github.com/isaacrankin/silverstripe-social-feed/blob/master/templates/includes/SocialFeed.ss)

The posts are ordered from newest to oldest. 

Within the `SocialFeed` control loop the following values are available:

- `$URL` - a URL for the social media post
- `$Type` - the type of post, either "facebook", "twitter" or "instagram"
- `$Created` - the creation/posted date of the post
- `$Data` - all of the data for a single post in the original structure returned from the API's. Read documentation for the API's to see what's available. 
 
## Caching

All SocialMediaProvider::getFeed() calls are cached for 15 minutes and can be cleared either in the CMS or by appending **?socialfeedclearcache=1** in developer mode.

There is also a SocialFeedCacheTask that you can setup as a cronjob on your server to ensure that the end-user never has to wait for your server to make its API calls to Facebook, Twitter, etc and update the various social feed caches.

Alternatively, if you're using the [QueuedJobs](https://github.com/silverstripe-australia/silverstripe-queuedjobs) module, this process will be handled automatically for you, as a queued job is setup to update the cache every 10 minutes.

## Requirements

SilverStripe 3.1 or newer

## Twitter

The Twitter data is a collection of the most recent Tweets posted by the user.
The following API endpoint is used `https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=twitterapi`

[Twitter API documentation for user timeline](https://dev.twitter.com/rest/reference/get/statuses/user_timeline)

### Credentials
You'll need to create a Twitter app here [https://apps.twitter.com/app/](https://apps.twitter.com/app/)

## Facebook

The Facebook data returned is the most recent posts for a given Facebook Page.
The following API endpoint is used `https://graph.facebook.com/PAGE_ID/feed?access_token=ACCESS_TOKEN`

[Facebook API documentation](https://developers.facebook.com/docs/graph-api/using-graph-api)
 
### Credentials
To get the necessary Facebook API credentials you'll need to [create a Facebook App](https://developers.facebook.com/apps).

## Instagram
The most recent media published for a user.
The following API endpoint is used `https://api.instagram.com/v1/users/self/media/recent/?access_token=ACCESS_TOKEN`
[Instagram API documentation for resent user media](https://www.instagram.com/developer/endpoints/users/#get_users_media_recent_self)

### Credentials
To get the necessary Instagram API credentials you'll need to [create an Instagram Client](https://www.instagram.com/developer/clients/manage/).

You'll need to add the correct redirect URI in the settings for the Instagram App, such as http://yoursite.com/admin/social-feed/SocialFeedProviderInstagram/ 

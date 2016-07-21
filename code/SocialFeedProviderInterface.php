<?php

interface SocialFeedProviderInterface
{
	public function getType();
	public function getFeed();
	public function getPostCreated($post);
	public function getPostUrl($post);
}

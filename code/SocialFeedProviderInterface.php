<?php

interface SocialFeedProviderInterface
{
	public function getType();
	public function getFeed();
	public function getPostContent($post);
	public function getPostCreated($post);
	public function getPostUrl($post);
	public function getUserName($post);
	public function getImage($post);
}

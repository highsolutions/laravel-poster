<?php

namespace HighSolutions\Poster\Services\Socials;

use HighSolutions\Poster\Models\FacebookPost;
use HighSolutions\Poster\Models\FacebookSocialToken;

class FacebookPoster extends AbstractPoster
{

	protected static $social = 'facebook';

	public function __construct($params)
	{
		parent::__construct($params);
	}

	protected function isResponseInvalid($json)
	{
		return !isset($json->posts) || !isset($json->posts->data);
	}

	protected function getUrl($page)
	{
		$token = $this->getToken();
		return 'https://graph.facebook.com/v2.9/' . $page . '/?fields=posts&access_token='. $token;
	}

	protected function getSocialToken()
	{
		return FacebookSocialToken::getToken();
	}

	protected function getToken()
	{
		$token = $this->getSocialToken();
		if($token != null)
			return $token->token;

		return null;
	}

	protected function save($page, $json)
	{
		$data = collect($json->posts->data)->reverse();
		return FacebookPost::createNewPosts($page, $data);
	}

	protected function isEmpty($page)
	{
		return FacebookPost::getLastPublishedDate($page) === null;
	}
}

<?php

namespace HighSolutions\Poster\Services\Socials;

use HighSolutions\Poster\Models\FacebookPost;

class FacebookPoster extends AbstractPoster
{

	public function __construct($params)
	{
		parent::__construct($params);
	}

	protected function isResponseInvalid($json)
	{
		return isset($json->posts) && isset($json->posts->data);
	}

	protected function getUrl($page)
	{
		return 'https://graph.facebook.com/v2.9/' . $page . '/?fields=posts&access_token='. $this->params['token'];
	}

	protected function save($page, $json)
	{
		$data = $json->posts->data;
		return FacebookPost::createNewPosts($page, $data);
	}
}
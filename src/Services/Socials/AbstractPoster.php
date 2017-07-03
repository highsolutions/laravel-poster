<?php

namespace HighSolutions\Poster\Services\Socials;

use HighSolutions\Poster\Notifications\SlackNotification;

abstract class AbstractPoster 
{

	protected $params;

	public function __construct($params)
	{
		$this->params = $params;
	}

	public function fetchAll()
	{
		foreach($this->getList() as $page => $params) {
			$this->fetch($page, $params);
		}
	}

	protected function getList()
	{
		return $this->params['list'];
	}

	public function fetch($page, $params)
	{
		$json = $this->getResponse($page);

		if($this->isResponseInvalid($json))
			\Log::debug('Laravel-Poster: Page "'. $page .'" receive invalid JSON from: '. $this->getUrl($page) . PHP_EOL);

		$posts = $this->save($page, $json);

		foreach($posts as $post) {
			$post->notify(new SlackNotification($params));
		}
	}

	protected function getResponse($page)
	{
		$url = $this->getUrl($page);
		$response = file_get_contents($url);
		return json_decode($response);
	}

}
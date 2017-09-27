<?php

namespace HighSolutions\Poster\Services\Socials;

use Carbon\Carbon;
use HighSolutions\Poster\Exceptions\InvalidSocialTokenException;
use HighSolutions\Poster\Models\FacebookSocialToken;
use HighSolutions\Poster\Notifications\SlackInvalidNotification;
use HighSolutions\Poster\Notifications\SlackNotification;
use GuzzleHttp\Exception\ConnectException;

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
		try {
			$json = $this->getResponse($page);
		} catch(InvalidSocialTokenException $e) {
			return $this->sendNotificationAboutToken($params);
		}

		if($this->isResponseInvalid($json))
			\Log::debug('Laravel-Poster: Page "'. $page .'" receive invalid JSON from: '. $this->getUrl($page) . PHP_EOL);

		$isEmpty = $this->isEmpty($page);
		$posts = $this->save($page, $json);

		if($isEmpty)
			return;
		
		foreach($posts as $post) {
			try {
				$post->notify(new SlackNotification($params));			
			} catch (ConnectException $e) {
			}			
		}

		$this->checkTokens($params);
	}

	protected function getResponse($page)
	{
		$url = $this->getUrl($page);
		$response = @file_get_contents($url, true);
		if($response === false)
			throw new InvalidSocialTokenException;

		return json_decode($response);
	}

	protected function sendNotificationAboutToken($params)
	{
		$token = $this->getSocialToken();
		if(!$token->isNotifiedToday()) {
			try {
				$token->notify(new SlackInvalidNotification($params));
				$token->notified();
			} catch (ConnectException $e) {
			}
		}
	}

	protected function checkTokens($params)
	{
		$token = $this->getSocialToken();
		if(!$token->isNotifiedToday() && $token->isExpiringSoon()) {
			try {
				$token->notify(new SlackInvalidNotification($params));
				$token->notified();
			} catch (ConnectException $e) {
			}			
		}
	}

}
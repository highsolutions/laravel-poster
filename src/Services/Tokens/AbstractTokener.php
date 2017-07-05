<?php

namespace HighSolutions\Poster\Services\Tokens;

use HighSolutions\Poster\Models\SocialToken;

abstract class AbstractTokener
{

	protected $credentials;

	public function __construct($credentials)
	{
		$this->credentials = $credentials;
	}

	public function manageToken($token, $date)
	{
		$socialToken = SocialToken::firstOrCreate([
			'social' => $this->social
		]);

		$socialToken->token = $token;
		$socialToken->expired_at = $date;
		$socialToken->save();
	}

}
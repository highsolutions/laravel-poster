<?php

namespace HighSolutions\Poster\Models;

use Carbon\Carbon;

class FacebookSocialToken extends SocialToken
{

    protected static $social = 'facebook';

    public static function getToken()
    {
        $token = static::where('social', static::$social)->latest()->first();

        if($token == null)
            return static::create([
                'social' => static::$social,
                'token' => '',
                'expired_at' => Carbon::now(),
                'notified_at' => null,
            ]);

        return $token;
    }

    public function getLink()
    {
    	return route('laravel_poster.fb_token_get');
    }

    public function getText()
    {
        if($this->expired_at == null)
            return "Facebook Access Token requires action!";

    	if($this->expired_at->isPast())
    		return "Facebook Access Token is expired!";
    	
    	return "Facebook Access Token is expiring soon!";
    }

}
<?php 

namespace HighSolutions\Poster\Controllers;

use HighSolutions\Poster\Services\Tokens\FacebookTokener;
use Illuminate\Routing\Controller as BaseController;

class PosterController extends BaseController
{

    /** @var \HighSolutions\Poster\Services\Tokens\FacebookTokener  */
    protected $service;

    protected $credentials;

    public function __construct()
    {
        $this->credentials = [
			'app_id' => config('laravel-poster.socials.facebook.credentials.app_id'),
			'app_secret' => config('laravel-poster.socials.facebook.credentials.app_secret'),
			'redirectUrl' => route('laravel_poster.fb_token_obtained'),
        ];
        $this->service = new FacebookTokener($this->credentials);
    }

    public function fb_token()
    {
    	return view('laravel-poster::fb_token');
    }

    public function fb_token_obtained()
    {
    	$code = request('code', null);

		if(is_null($code))
			return $this->service->testAccess();

		return $this->service->extendToken($code);
    }    

}
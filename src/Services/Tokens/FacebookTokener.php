<?php

namespace HighSolutions\Poster\Services\Tokens;

use Carbon\Carbon;

class FacebookTokener extends AbstractTokener
{

	protected $social = 'facebook';

	public function testAccess()
    {
	    $dialog_url = $this->getDialogUrl();
	    echo("<script> top.location.href='" . $dialog_url . "'</script>"); 	
    }

    protected function getDialogUrl()
    {
    	return "https://www.facebook.com/dialog/oauth" .
    			"?client_id=" . $this->credentials['app_id'] . 
    			"&redirect_uri=" . urlencode($this->credentials['redirectUrl']) . 
    			"&state=" . md5(uniqid(rand(), true));
    }

    public function extendToken($code)
    {
	    $response = $this->getToken($code);

	    if($response === false)
	      	return redirect()->route('laravel_poster.fb_token_get');

	    $token = json_decode($response)->access_token;
	    $this->manageToken($token, Carbon::parse('+2 months'));  

    	return view('laravel-poster::fb_token_obtained');
    }

    protected function getToken($code)
    {
    	$token_url = $this->getTokenUrl($code);
	    return @file_get_contents($token_url, true);
    }

    protected function getTokenUrl($code)
    {
    	return "https://graph.facebook.com/oauth/access_token" .
		       "?client_id=" . $this->credentials['app_id'] .
		       "&redirect_uri=" . urlencode($this->credentials['redirectUrl']) .
		       "&client_secret=" . $this->credentials['app_secret'] .
		       "&code=" . $code;
    }

}
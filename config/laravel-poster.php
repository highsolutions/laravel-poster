<?php

return [

    /*
    |--------------------------------------------------------------------------
    | LaravelPoster Configuration
    |--------------------------------------------------------------------------
    |
    */

    'socials' => [
    	'facebook' => [
            'credentials' => [
                'app_id' => '',
                'app_secret' => '',
            ],
    		'list' => [
                
            ],
            'api_version' => 'v5.0',
	    ],
    ],

    'slack' => [
        'default_channel' => '',
        'webhook_url' => '',
    ],
];

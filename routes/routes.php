<?php

	Route::group(
	    [
	        'prefix' => 'laravel-poster/fb_token',
	        'namespace' => '\HighSolutions\Poster\Controllers',
	    ],
	    function () {

			Route::get('/', ['as' => 'laravel_poster.fb_token_get', 'uses' => 'PosterController@fb_token']);
			Route::get('/obtained', ['as' => 'laravel_poster.fb_token_obtained', 'uses' => 'PosterController@fb_token_obtained']);

		}
	);
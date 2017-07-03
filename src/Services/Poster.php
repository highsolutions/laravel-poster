<?php

namespace HighSolutions\Poster\Services;

use HighSolutions\Poster\Services\Socialer;
use Illuminate\Foundation\Application;

class Poster
{

    /** @var \Illuminate\Foundation\Application  */
    protected $app;

    protected $config;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->config = app()['config']['laravel-poster'];
    }

	public function fetchAll()
	{
		foreach($this->getSocials() as $social => $params) {
			$service = Socialer::get($social, $params);
			$service->fetchAll();
		}
	}

	protected function getSocials() 
	{
		if(!isset($this->config['socials']) || !is_array($this->config['socials']))
			throw new \Exception("Invalid configuration in LaravelPoster - socials");

		return $this->config['socials'];
	}

}
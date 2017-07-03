<?php 

namespace HighSolutions\Poster\Services;

use HighSolutions\Poster\Services\Socials\FacebookPoster;
use Illuminate\Foundation\Application;

class Socialer
{

    private static $socials = [
        'facebook' => FacebookPoster::class,
    ];

    public static function get($social, $params)
    {
        if(!isset(self::$socials[$social]))
            throw new Exception("Unsupported social service.");

        return new self::$socials[$social]($params);
    }

}

<?php

namespace HighSolutions\Poster\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class FacebookPost extends Model
{
	use PostTrait, Notifiable;

	protected $table = 'lp_posts';
	protected $dates = ['posted_at'];
	protected $guarded = [];
	protected static $social = 'facebook';

	protected static function isOldPost($lastPublishedDate, $row)
	{
		return $lastPublishedDate !== null && $lastPublishedDate >= static::parseDate($row->created_time);
	}
	
	protected static function isWrongPost($row)
	{
		return !isset($row->message);
	}

	protected static function parseDate($date)
	{
		$parsed = Carbon::parse($date);
		$parsed->timezone = config('app.timezone');
		return $parsed;
	}

	protected static function createNew($page, $row)
	{			
		return static::create([
			'social' => static::$social,
			'address' => $page,
			'text' => $row->message,
			'identifier' => explode('_', $row->id)[1],
			'posted_at' => static::parseDate($row->created_time),
		]);
	}

	public function getPermalink()
	{
		return 'https://www.facebook.com/'. $this->address . '/posts/'. $this->identifier;
	}

}
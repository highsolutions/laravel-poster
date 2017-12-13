<?php

namespace HighSolutions\Poster\Models;

trait PostTrait
{

	public static function createNewPosts($page, $data)
	{
		$new = [];
		$lastPublishedDate = static::getLastPublishedDate($page);

		foreach($data as $row) {
			if(static::isOldPost($lastPublishedDate, $row) || static::isWrongPost($row))
				continue;

			$new []= static::createNew($page, $row);
		}

		return $new;
	}

	protected static function getLastPublishedDate($page)
	{
		$last = static::where('social', static::$social)
			->where('address', $page)
			->latest('posted_at')
			->first();

		if($last === null)
			return null;

		return $last->posted_at;
	}

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return config('laravel-poster.slack.webhook_url');
    }

}
<?php

namespace HighSolutions\Poster\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SocialToken extends Model
{
	use Notifiable;

	protected $table = 'lp_tokens';
	protected $dates = ['expired_at', 'notified_at'];
	protected $guarded = [];

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return config('laravel-poster.slack.webhook_url');
    }

    public function isNotifiedToday()
    {
        if($this->notified_at === null)
            return false;
    	return $this->notified_at->isToday();
    }

    public function isExpiringSoon()
    {
    	return Carbon::now()->gte($this->expired_at->subDays(5));
    }

    public function notified()
    {
    	$this->update([
    		'notified_at' => Carbon::now(),
    	]);
    }

}
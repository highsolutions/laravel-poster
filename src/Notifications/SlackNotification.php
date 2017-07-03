<?php

namespace HighSolutions\Poster\Notifications;

use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class SlackNotification extends Notification
{

	protected $config = [
		'channel' => '',
		'sender' => '',
	];

	public function __construct($params)
    {
        $this->config['channel'] = isset($params['channel']) ? $params['channel'] : config('laravel-poster.slack.default_channel');
        $this->config['sender'] = $params['name'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->success()
            ->from($this->config['sender'])
            ->to($this->config['channel'])
            ->attachment(function ($attachment) use ($notifiable) {
                $attachment->fields([
                    'Permalink' => $notifiable->getPermalink(),
                    'Posted' => $notifiable->posted_at->format('Y-m-d H:i'),
                ])
                ->title($notifiable->text . PHP_EOL);
            });
    }

}
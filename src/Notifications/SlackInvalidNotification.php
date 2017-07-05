<?php

namespace HighSolutions\Poster\Notifications;

use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class SlackInvalidNotification extends Notification
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
        $fields = [
            'Refresh Access Token' => $notifiable->getLink(),
        ];

        if($notifiable->token != '') {
            $fields['Expiration Date'] = $notifiable->expired_at->format('Y-m-d H:i');
        }

        return (new SlackMessage)
            ->error()
            ->from($this->config['sender'])
            ->to($this->config['channel'])
            ->attachment(function ($attachment) use ($notifiable, $fields) {
                $attachment->fields($fields)
                ->title($notifiable->getText() . PHP_EOL);
            });
    }

}
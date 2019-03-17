Larevel Poster
================

Easy creation of Slack notifications about posts published on subscribed Facebook's fanpages.

![Laravel-Poster by HighSolutions](https://raw.githubusercontent.com/highsolutions/laravel-poster/master/intro.jpg)

Installation
------------

Add the following line to the `require` section of your Laravel webapp's `composer.json` file:

```javascript
    "require": {
        "HighSolutions/Poster": "1.*"
    }
```

Run `composer update` to install the package.

This package uses Laravel 5.5 Package Auto-Discovery.
For previous versions of Laravel, you need to update `config/app.php` by adding an entry for the service provider:

```php
'providers' => [
    // ...
    HighSolutions\Poster\PosterServiceProvider::class,
];
```

Next, publish all package resources:

```bash
    php artisan vendor:publish --provider="HighSolutions\Poster\PosterServiceProvider"
```

This will add to your project:

    - migration - database table for storing posts and tokens
    - configuration - package configurations
    - views - configurable views for token refreshing

Remember to launch migration: 

```bash
    php artisan migrate
```

Next step is to add cron task via Scheduler (`app\Console\Kernel.php`):

```php
    protected function schedule(Schedule $schedule)
    {
    	// ...
        $schedule->command('poster:fetch')->hourly();
    }
```

Remember to assign cron tasks to artisan.

Configuration
-------------

| Setting name                            | Description                       | Default value |
|-----------------------------------------|-----------------------------------|---------------|
| socials.facebook.credentials.app_id     | Facebook's app identifier         | ''            |
| socials.facebook.credentials.app_secret | Facebook's app secret             | ''            |
| socials.facebook.list                   | List of Facebook pages            | []            |
| slack.default_channel                   | Default channel for notifications | ''            |
| slack.webhook_url                       | Slack's webhook url               | ''            |

Facebook lists are defined like:

```php
<?php

return [
    'socials' => [
        'facebook' => [
            'credentials' => [
                // ...
            ],
            'list' => [
                'highsolutions' => [
                    'name' => 'HighSolutions daily',
                    'channel' => '#general',
                ],
                // ...
            ],
        ],
    ],

    // ...
];
```

Facebook app
-------------

You need to provide Facebook's app id and secret. Moreover, you have to define redirect url for your application.
E.g. `http://yourdomain.com/laravel-poster/fb_get/obtained`

Facebook Access Token
-------------

To fetch Facebook page's posts you need Facebook Access Token. Any Facebook user can use his account to store Access Token. It's valid for 2 months.

When Access Token is going to expire, any user has to click on provided link and connect with Facebook via link on website. The same operation is needed for first time.

For now there is no way to make it fully automatic. Thanks to Facebook.

Changelog
---------

1.0.7
- Debug information about wrong JSON was fired when JSON was valid

1.0.6
- Handle problem when post is share of another post

1.0.5
- Support Package Auto-Discovery

1.0.4
- Fix timezone problems

1.0.3
- Little fixes on readme
- Check if SocialToken->notified_at is null

1.0.0
- Create package
- Slack support
- Facebook posts support

Roadmap
-------

* Not only Facebook fanpages support.
* Not only Slack notifications support.
* Trigger events
* Comments
* Unit tests!

Credits
-------

This package is developed by [HighSolutions](https://highsolutions.org), software house from Poland in love in Laravel.

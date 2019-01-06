<?php

namespace App\Providers;

use App\Listeners\UserEventsListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // add your listeners (aka providers) here
            'SocialiteProviders\\Weixin\\WeixinExtendSocialite@handle',
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // add your listeners (aka providers) here
            'SocialiteProviders\\WeixinWeb\\WeixinWebExtendSocialite@handle',
        ],
        Registered::class => [
            SendEmailVerificationNotification::class
        ]
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        UserEventsListener::class,
    ];
}

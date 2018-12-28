<?php
/**
 * Created by PhpStorm.
 * User: Lixing
 * Date: 2018-12-21
 * Time: 20:38
 */

namespace App\Listeners;


use App\Events\UserEvents\UserCreatedEvent;
use App\Mails\WelcomeEmail;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;

class UserEventsListener
{
    /**
     * Handle the user created event
     *
     * @param UserCreatedEvent $event
     */
    public function onUserCreatedEvent($event)
    {
        $user = $event->user;
        //send welcome email to the user
        Mail::to($user)->send(new WelcomeEmail($user));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            UserCreatedEvent::class,
            'App\Listeners\UserEventsListener@onUserCreatedEvent'
        );
    }
}
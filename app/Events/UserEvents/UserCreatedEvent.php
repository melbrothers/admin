<?php
/**
 * Created by PhpStorm.
 * User: Lixing
 * Date: 2018-12-21
 * Time: 20:41
 */

namespace App\Events\UserEvents;

use App\Events\Event;
use App\User;

class UserCreatedEvent extends Event
{
    /**
     * Instance of User
     *
     * @var User
     */
    public $user;
    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
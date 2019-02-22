<?php

namespace App;

use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\VerifyEmail;
use App\Traits\SluggableHelpers;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    MustVerifyEmailContract
{
    use Authenticatable,
        Authorizable,
        Notifiable,
        CanResetPassword,
        MustVerifyEmail,
        HasApiTokens,
        Sluggable,
        SluggableHelpers;

    const ROLE_SENDER = 'ADMIN_USER';
    const ROLE_RUNNER = 'BASIC_USER';

    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'password',
    ];

    public function senderTasks()
    {
        return $this->hasMany(Task::class, 'sender_id');
    }

    public function runnerTasks()
    {
        return $this->hasMany(Task::class, 'runner_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function linkedSocialAccounts()
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'default_location_id');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function reply(Comment $comment, string $body)
    {
        $newComment = new Comment;
        $newComment->body = $body;
        $newComment->commentable_id = $comment->commentable_id;
        $newComment->commentable_type = $comment->commentable_type;
        $newComment->author()->associate($this);
        $comment->replies()->save($newComment);

        return $newComment;
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['last_name', 'first_name'],
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return (isset($this->role) ? $this->role : self::ROLE_RUNNER) == self::ROLE_RUNNER;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

}

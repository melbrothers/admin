<?php

namespace App\Models;

use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\VerifyEmail;
use App\Traits\Rateable;
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

    protected $appends = [
        'posted_tasks_count',
        'run_tasks_count',
        'average_rating',
        'runner_review_statistics',
        'sender_review_statistics',
        'received_reviews_count'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'password',
    ];

    public function postedTasks()
    {
        return $this->hasMany(Task::class, 'sender_id');
    }

    public function runTasks()
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

    public function paymentMethod()
    {
        return $this->hasOne(PaymentMethod::class);
    }

    public function disbursementMethod()
    {
        return $this->hasOne(DisbursementMethod::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class);
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
        if ($this->local == 'en') {
            return "{$this->first_name} {$this->last_name}";
        } else {
            return "{$this->last_name}{$this->first_name}";
        }
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function senderRatings()
    {
        return $this->hasManyThrough(Rating::class, Task::class, 'sender_id', 'rateable_id', 'id', 'id')->where('rateable_type', Task::class);
    }

    public function runnerRatings()
    {
        return $this->hasManyThrough(Rating::class, Task::class, 'runner_id', 'rateable_id', 'id', 'id')->where('rateable_type', Task::class);
    }

    public function receivedRatings()
    {
        return $this->senderReceivedRatings()->union($this->runnerReceivedRatings()->select('rating'))->select('rating');
    }

    public function senderSentRatings()
    {
        return $this->senderRatings()->where('author_id', $this->id);
    }

    public function senderReceivedRatings()
    {
        return $this->senderRatings()->where('author_id', '!=', $this->id);
    }

    public function runnerSentRatings()
    {
        return $this->runnerRatings()->where('author_id', $this->id);
    }

    public function runnerReceivedRatings()
    {
        return $this->runnerRatings()->where('author_id', '!=', $this->id);
    }

    public function senderRatingBreakdown()
    {
        return $this->senderReceivedRatings()
            ->selectRaw('rating, COUNT(rating) as ratingCount')
            ->groupBy('rating')
            ->pluck('ratingCount', 'rating')->union([
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0
            ]);
    }

    public function runnerRatingBreakdown()
    {
        return $this->runnerReceivedRatings()
                    ->selectRaw('rating, COUNT(rating) as ratingCount')
                    ->groupBy('rating')
                    ->pluck('ratingCount', 'rating')->union([
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0
            ]);
    }

    public function senderAverageRating()
    {
        return (float) $this->senderReceivedRatings()->average('rating');
    }

    public function runnerAverageRating()
    {
        return (float) $this->runnerReceivedRatings()->average('rating');
    }

    public function getRunnerReviewStatisticsAttribute()
    {
        return [
            'average_rating' => $this->runnerAverageRating(),
            'rating_breakdown' => $this->runnerRatingBreakdown(),
            'received_reviews' => $this->runnerReceivedRatings()->count(),
            'sent_reviews' => $this->runnerSentRatings()->count(),
        ];
    }

    public function getSenderReviewStatisticsAttribute()
    {
        return [
            'average_rating' => $this->senderAverageRating(),
            'rating_breakdown' => $this->senderRatingBreakdown(),
            'received_reviews' => $this->senderReceivedRatings()->count(),
            'sent_reviews' => $this->senderSentRatings()->count(),
        ];
    }

    //Mutators
    public function getPostedTasksCountAttribute()
    {
        return $this->postedTasks()->count();
    }

    public function getRunTasksCountAttribute()
    {
        return $this->runTasks()->count();
    }


    public function getAverageRatingAttribute()
    {
        return (float) $this->receivedRatings()->average('rating');
    }

    public function getReceivedReviewsCountAttribute()
    {
        return (float) $this->receivedRatings()->count();
    }
}

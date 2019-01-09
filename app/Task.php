<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const STATE_POSTED = 'posted';
    const STATE_ASSIGNED = 'assigned';
    const STATE_COMPLETED = 'completed';
    const STATE_OVERDUE = 'overdue';
    const STATE_CLOSED = 'closed';

    const STATES = [self::STATE_POSTED, self::STATE_ASSIGNED, self::STATE_CLOSED, self::STATE_COMPLETED, self::STATE_OVERDUE];


    /**
     * @var array
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
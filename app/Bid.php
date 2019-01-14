<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    const RATE_FEE = 0.2;
    const RATE_GST = 0.1;

    protected $with = ['user'];

    /**
     * @var array
     */
    protected $guarded = [];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }

    public static function fee($price)
    {
        return static::RATE_FEE * $price;
    }

    public static function gst($price)
    {
        return static::RATE_GST * self::fee($price);
    }
}
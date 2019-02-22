<?php

namespace App;


use App\Traits\Commentable;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use Commentable;

    const RATE_FEE = 0.2;
    const RATE_GST = 0.1;

    protected $with = ['runner'];

    /**
     * @var array
     */
    protected $guarded = [];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function runner()
    {
        return $this->belongsTo(User::class, 'runner_id');
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

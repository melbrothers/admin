<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    const RATE_FEE = 0.2;
    const RATE_GST = 0.1;
    /**
     * @var array
     */
    protected $guarded = [];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
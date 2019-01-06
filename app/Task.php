<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    /**
     * @var array
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function addOffer($offer)
    {
        $this->offers()->create($offer);
    }
}
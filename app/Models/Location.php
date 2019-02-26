<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function getDisplayNameAttribute()
    {
        return sprintf('%s, %s', $this->suburb, $this->state);
    }

}

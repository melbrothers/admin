<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}

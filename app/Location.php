<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Location extends Model
{
    use Searchable;
    
    public $timestamps = false;

    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

<?php

namespace App;

use App\IndexConfigurator\LocationIndexConfigurator;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;

    protected $indexConfigurator = LocationIndexConfigurator::class;

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

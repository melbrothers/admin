<?php

namespace App;


use App\IndexConfigurator\LocationIndexConfigurator;
use App\ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use Searchable;
    
    public $timestamps = false;

    protected $indexConfigurator = LocationIndexConfigurator::class;

    protected $guarded = [];

    protected $mapping = [
        'properties' => [
            'display_name' => [
                'type' => 'text',
            ],
            'latitude' => [
                'type' => 'float'
            ],
            'longitude' => [
                'type' => 'float'
            ]
        ]
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

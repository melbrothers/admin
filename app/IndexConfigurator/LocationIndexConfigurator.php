<?php

namespace App\IndexConfigurator;


use App\ScoutElastic\IndexConfigurator;

class LocationIndexConfigurator extends IndexConfigurator
{
    // You can specify any settings you want, for example, analyzers.
    protected $settings = [
        'index.mapping.single_type' => true
    ];
}

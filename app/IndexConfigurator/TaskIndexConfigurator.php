<?php

namespace App\IndexConfigurator;


use App\ScoutElastic\IndexConfigurator;

class TaskIndexConfigurator extends IndexConfigurator
{
    // You can specify any settings you want, for example, analyzers.
    protected $settings = [
        'index.mapping.ignore_malformed' => true,
        'analysis' => [
            'analyzer' => [
                'std_chinese' => [
                    'type' => 'standard',
                    'stopwords' => '_english_'
                ]
            ]
        ]
    ];
}

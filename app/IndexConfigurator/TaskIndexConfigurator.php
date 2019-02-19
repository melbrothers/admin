<?php

namespace App\IndexConfigurator;


use App\ScoutElastic\IndexConfigurator;

class TaskIndexConfigurator extends IndexConfigurator
{
    // You can specify any settings you want, for example, analyzers.
    protected $settings = [
        'index.mapping.single_type' => true,
        'analysis' => [
            'analyzer' => [
                'std_chinese' => [
                    'type' => 'smartcn',
                    'tokenizer' => 'smartcn_tokenizer'
                ]
            ]
        ]
    ];
}

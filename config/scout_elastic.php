<?php

return [
    'update_mapping' => env('SCOUT_ELASTIC_UPDATE_MAPPING', false),
    'indexer' => env('SCOUT_ELASTIC_INDEXER', 'single'),
    'document_refresh' => env('SCOUT_ELASTIC_DOCUMENT_REFRESH'),
    'hosts' => [
        env('SCOUT_ELASTIC_HOST', 'localhost:9200')
    ]
];

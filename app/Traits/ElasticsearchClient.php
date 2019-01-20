<?php

namespace App\Traits;

use Elasticsearch\ClientBuilder;

trait ElasticsearchClient
{
    /**
     * Get ElasticSearch Client
     *
     * @return \Elasticsearch\Client
     */
    public function getElasticsearchClient()
    {
        $hosts = config('scout.elasticsearch.hosts');
        $client = ClientBuilder::create()
                               ->setHosts($hosts)
                               ->build();
        return $client;
    }
}
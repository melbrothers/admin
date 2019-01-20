<?php

namespace App\Providers;


use App\Console\Commands\FlushCommand;
use App\Console\Commands\ImportCommand;
use App\Services\Elasticsearch\ElasticsearchEngine;
use Elasticsearch\ClientBuilder as ElasticBuilder;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;

class ElasticsearchServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // 注册命令
        if ($this->app->runningInConsole()) {
            $this->commands([
                ImportCommand::class,
                FlushCommand::class,
            ]);
        }

        app(EngineManager::class)->extend('elasticsearch', function ($app) {
            return new ElasticsearchEngine(
                ElasticBuilder::create()
                              ->setHosts(config('scout.elasticsearch.hosts'))
                              ->build(),
                config('scout.elasticsearch.index')
            );
        });
    }
}
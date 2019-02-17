<?php

namespace App\Providers;


use App\Console\Commands\ElasticUpdateMappingCommand;
use App\ScoutElastic\ElasticEngine;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Laravel\Scout\EngineManager;

class ScoutElasticServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // 注册命令
        if ($this->app->runningInConsole()) {
            $this->commands([
               ElasticUpdateMappingCommand::class
            ]);
        }

        $this
            ->app
            ->make(EngineManager::class)
            ->extend('elastic', function () {
                $indexerType = config('scout_elastic.indexer', 'single');
                $updateMapping = config('scout_elastic.update_mapping', true);
                $indexerClass = '\\App\\ScoutElastic\\Indexers\\'.ucfirst($indexerType).'Indexer';
                if (!class_exists($indexerClass)) {
                    throw new InvalidArgumentException(sprintf(
                        'The %s indexer doesn\'t exist.',
                        $indexerType
                    ));
                }
                return new ElasticEngine(new $indexerClass(), $updateMapping);
            });
    }

    public function register()
    {
        $this
            ->app
            ->singleton('scout_elastic.client', function() {
                $config = config('scout_elastic.client');
                return ClientBuilder::fromConfig($config);
            });
    }
}

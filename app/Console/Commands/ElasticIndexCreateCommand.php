<?php

namespace App\Console\Commands;


use App\Console\Commands\Features\RequiresIndexConfiguratorArgument;
use App\ScoutElastic\Facades\ElasticClient;
use App\ScoutElastic\Migratable;
use App\ScoutElastic\Payloads\IndexPayload;
use Illuminate\Console\Command;

class ElasticIndexCreateCommand extends Command
{
    use RequiresIndexConfiguratorArgument;
    /**
     * @var string
     */
    protected $name = 'elastic:create-index';
    /**
     * @var string
     */
    protected $description = 'Create an Elasticsearch index';

    protected function createIndex()
    {
        $configurator = $this->getIndexConfigurator();
        $payload = (new IndexPayload($configurator))
            ->setIfNotEmpty('body.settings', $configurator->getSettings())
            ->setIfNotEmpty('body.mappings._default_', $configurator->getDefaultMapping())
            ->get();
        ElasticClient::indices()
                     ->create($payload);
        $this->info(sprintf(
            'The %s index was created!',
            $configurator->getName()
        ));
    }
    protected function createWriteAlias()
    {
        $configurator = $this->getIndexConfigurator();
        if (!in_array(Migratable::class, class_uses_recursive($configurator))) {
            return;
        }
        $payload = (new IndexPayload($configurator))
            ->set('name', $configurator->getWriteAlias())
            ->get();
        ElasticClient::indices()
                     ->putAlias($payload);
        $this->info(sprintf(
            'The %s alias for the %s index was created!',
            $configurator->getWriteAlias(),
            $configurator->getName()
        ));
    }
    public function handle()
    {
        $this->createIndex();
        $this->createWriteAlias();
    }
}

<?php

namespace App\Console\Commands;


use App\Console\Commands\Features\RequiresIndexConfiguratorArgument;
use App\ScoutElastic\Facades\ElasticClient;
use App\ScoutElastic\Migratable;
use App\ScoutElastic\Payloads\IndexPayload;
use App\ScoutElastic\Payloads\RawPayload;
use Exception;
use Illuminate\Console\Command;
use LogicException;

class ElasticIndexUpdateCommand extends Command
{
    use RequiresIndexConfiguratorArgument;
    /**
     * @var string
     */
    protected $name = 'elastic:update-index';
    /**
     * @var string
     */
    protected $description = 'Update settings and mappings of an Elasticsearch index';

    /**
     * @throws Exception
     */
    protected function updateIndex()
    {
        $configurator = $this->getIndexConfigurator();
        $indexPayload = (new IndexPayload($configurator))->get();
        $indices = ElasticClient::indices();
        if (!$indices->exists($indexPayload)) {
            throw new LogicException(sprintf(
                'Index %s doesn\'t exist',
                $configurator->getName()
            ));
        }
        try {
            $indices->close($indexPayload);
            if ($settings = $configurator->getSettings()) {
                $indexSettingsPayload = (new IndexPayload($configurator))
                    ->set('body.settings', $settings)
                    ->get();
                $indices->putSettings($indexSettingsPayload);
            }
            if ($defaultMapping = $configurator->getDefaultMapping()) {
                $indexMappingPayload = (new IndexPayload($configurator))
                    ->set('type', '_default_')
                    ->set('body._default_', $defaultMapping)
                    ->get();
                $indices->putMapping($indexMappingPayload);
            }
            $indices->open($indexPayload);
        } catch (Exception $exception) {
            $indices->open($indexPayload);
            throw $exception;
        }
        $this->info(sprintf(
            'The index %s was updated!',
            $configurator->getName()
        ));
    }
    protected function createWriteAlias()
    {
        $configurator = $this->getIndexConfigurator();
        if (!in_array(Migratable::class, class_uses_recursive($configurator))) {
            return;
        }
        $indices = ElasticClient::indices();
        $existsPayload = (new RawPayload())
            ->set('name', $configurator->getWriteAlias())
            ->get();
        if ($indices->existsAlias($existsPayload)) {
            return;
        }
        $putPayload = (new IndexPayload($configurator))
            ->set('name', $configurator->getWriteAlias())
            ->get();
        $indices->putAlias($putPayload);
        $this->info(sprintf(
            'The %s alias for the %s index was created!',
            $configurator->getWriteAlias(),
            $configurator->getName()
        ));
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $this->updateIndex();
        $this->createWriteAlias();
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Lixing
 * Date: 2019-02-18
 * Time: 22:53
 */

namespace App\Console\Commands;


use App\Console\Commands\Features\RequiresIndexConfiguratorArgument;
use App\ScoutElastic\Facades\ElasticClient;
use App\ScoutElastic\Payloads\IndexPayload;
use Illuminate\Console\Command;

class ElasticIndexDropCommand extends Command
{
    use RequiresIndexConfiguratorArgument;
    /**
     * @var string
     */
    protected $name = 'elastic:drop-index';
    /**
     * @var string
     */
    protected $description = 'Drop an Elasticsearch index';

    public function handle()
    {
        $configurator = $this->getIndexConfigurator();
        $payload = (new IndexPayload($configurator))
            ->get();
        ElasticClient::indices()
                     ->delete($payload);
        $this->info(sprintf(
            'The index %s was deleted!',
            $configurator->getName()
        ));
    }
}

<?php

namespace App\ScoutElastic\Indexers;

use App\ScoutElastic\Facades\ElasticClient;
use App\ScoutElastic\Migratable;
use App\ScoutElastic\Payloads\RawPayload;
use App\ScoutElastic\Payloads\TypePayload;
use Illuminate\Database\Eloquent\Collection;

class BulkIndexer implements IndexerInterface
{

    /**
     * @param Collection $models
     *
     * @return array|void
     * @throws \Exception
     */
    public function update(Collection $models)
    {
        $model = $models->first();
        $indexConfigurator = $model->getIndexConfigurator();
        $bulkPayload = new TypePayload($model);
        if (in_array(Migratable::class, class_uses_recursive($indexConfigurator))) {
            $bulkPayload->useAlias('write');
        }
        if ($documentRefresh = config('scout_elastic.document_refresh')) {
            $bulkPayload->set('refresh', $documentRefresh);
        }
        $models->each(function ($model) use ($bulkPayload) {
            if ($model::usesSoftDelete() && config('scout.soft_delete', false)) {
                $model->pushSoftDeleteMetadata();
            }
            $modelData = array_merge(
                $model->toSearchableArray(),
                $model->scoutMetadata()
            );
            if (empty($modelData)) {
                return true;
            }
            $actionPayload = (new RawPayload())
                ->set('index._id', $model->getKey());
            $bulkPayload
                ->add('body', $actionPayload->get())
                ->add('body', $modelData);
        });
        ElasticClient::bulk($bulkPayload->get());
    }

    /**
     * @param Collection $models
     *
     * @return array|void
     * @throws \Exception
     */
    public function delete(Collection $models)
    {
        $model = $models->first();
        $bulkPayload = new TypePayload($model);
        $models->each(function ($model) use ($bulkPayload) {
            $actionPayload = (new RawPayload())
                ->set('delete._id', $model->getKey());
            $bulkPayload->add('body', $actionPayload->get());
        });
        ElasticClient::bulk($bulkPayload->get());
    }
}

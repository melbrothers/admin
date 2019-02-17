<?php

namespace App\ScoutElastic\Payloads;

use App\ScoutElastic\Searchable;
use Exception;
use Illuminate\Database\Eloquent\Model;

class TypePayload extends IndexPayload
{
    /**
     * @var Model
     */
    protected $model;
    /**
     * @param Model $model
     * @throws Exception
     */
    public function __construct(Model $model)
    {
        if (!in_array(Searchable::class, class_uses_recursive($model))) {
            throw new Exception(sprintf(
                'The %s model must use the %s trait.',
                get_class($model),
                Searchable::class
            ));
        }
        $this->model = $model;
        $this->payload['type'] = $model->searchableAs();
        $this->protectedKeys[] = 'type';
        parent::__construct($model->getIndexConfigurator());
    }
}

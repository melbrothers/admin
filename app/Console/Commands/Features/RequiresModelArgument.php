<?php

namespace App\Console\Commands\Features;

use App\ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;

trait RequiresModelArgument
{
    /**
     * @return Model
     */
    protected function getModel()
    {
        $modelClass = trim($this->argument('model'));
        $modelInstance = new $modelClass;
        if (
            !($modelInstance instanceof Model) ||
            !in_array(Searchable::class, class_uses_recursive($modelClass))
        ) {
            throw new InvalidArgumentException(sprintf(
                'The %s class must extend %s and use the %s trait.',
                $modelClass,
                Model::class,
                Searchable::class
            ));
        }
        return $modelInstance;
    }
    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            [
                'model',
                InputArgument::REQUIRED,
                'The model class'
            ]
        ];
    }
}

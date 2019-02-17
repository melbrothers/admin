<?php

namespace App\Filters;


use App\Task;

class TaskFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'query',
        'location_name',
        'min_price',
        'max_price',
        'type',
        'limit',
        'lat',
        'lon',
        'sort_by',
        'radius',
        'task_states'
    ];

    /**
     * @param $query
     *
     * @return \Laravel\Scout\Builder
     */
    public function query($query)
    {
        return Task::search($query);
    }

    public function type($type)
    {

    }

    public function limit($limit)
    {
        return $this->builder->take($limit);
    }

    public function sortBy($sortBy)
    {
        return $this->builder->orderBy($sortBy);
    }

}

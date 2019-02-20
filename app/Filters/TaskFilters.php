<?php

namespace App\Filters;



class TaskFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'location_name',
        'min_price',
        'max_price',
        'lat',
        'lon',
        'sort_by',
        'radius',
        'task_states',
        'task_types'
    ];

    public function sortBy($field)
    {
        if ($field == 'recent') {
            return $this->builder->orderBy('created_at');
        }

        return $this->builder;
    }

    public function radius($radius)
    {
        return $this->builder->whereGeoDistance('location.coordinate',
            [$this->request->get('lat'), $this->request->get('lon')], $radius . 'm');
    }

    public function minPrice($price){
        return $this->builder->where('price', '>=', $price);
    }

    public function maxPrice($price){
        return $this->builder->where('price', '<=', $price);
    }

}

<?php

namespace App\Filters;

use App\ScoutElastic\Builders\FilterBuilder;
use App\ScoutElastic\Builders\SearchBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Scout\Builder;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * The Laravel Scout builder.
     *
     * @var FilterBuilder | SearchBuilder
     */
    protected $builder;
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [];
    /**
     * Create a new ThreadFilters instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

    }
    /**
     * Apply the filters.
     *
     * @return FilterBuilder | SearchBuilder
     */
    public function apply()
    {
        foreach ($this->getFilters() as $filter => $value) {
            $method = Str::camel($filter);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this->builder;
    }

    /**
     * Fetch all relevant filters from the request.
     *
     * @return array
     */
    public function getFilters()
    {
        return array_filter($this->request->only($this->filters));
    }
}

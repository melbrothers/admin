<?php

namespace App\Filters;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        'task_types',
        'role',
        'my_tasks',
        'limit',
        'after_time'
    ];

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $searchTerm = $request->get('query', '*');
        $this->builder = Task::search($searchTerm);
    }

    public function sortBy($field)
    {
        if ($field == 'recent') {
            return $this->builder->orderBy('created_at', 'desc');
        }

        return $this->builder;
    }

    public function radius($radius)
    {
        return $this->builder->whereGeoDistance('location.coordinate',
            [$this->request->get('lat'), $this->request->get('lon')], $radius . 'm');
    }

    public function minPrice($price)
    {
        return $this->builder->where('price', '>=', $price);
    }

    public function maxPrice($price)
    {
        return $this->builder->where('price', '<=', $price);
    }

    public function role($role)
    {
        if (!Auth::check()) {
            abort(401);
        }

        if ($role == 'sender') {
            return $this->builder->where('sender_id', Auth::user()->id);
        } else if ($role == 'runner') {
            return $this->builder->where('runner_id', Auth::user()->id);
        }

        return $this->builder;
    }

    public function taskStates($taskStates)
    {
        $taskStates = explode(',', $taskStates);

        if (!empty($taskStates)) {
            return $this->builder->whereIn('state', $taskStates);
        }

        return $this->builder;
    }

    public function myTasks($myTasks)
    {
        if ($myTasks) {
            if (!Auth::check()) {
                abort(401);
            }
            return $this->builder->where('sender_id', Auth::user()->id);
        }

        return $this->builder;
    }

    public function limit($limit)
    {
        return $this->builder->limit($limit);
    }

    public function afterTime($afterTime)
    {
        $afterTime = Carbon::createFromFormat(Carbon::RFC3339, $afterTime);
        return $this->builder->searchAfter($afterTime->timestamp);
    }
}

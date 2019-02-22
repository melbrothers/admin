<?php

namespace App\Http\Controllers;


use App\Task;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    public function __construct()
    {
    }


    /**
     * @param Request $request
     * @param Task    $task
     */
    public function store(Request $request, Task $task)
    {
        $task->rating([

        ], $request->user());
    }

    public function rules()
    {
        return [
            'rating' => 'required',
            'body'   => 'required'
        ];
    }
}

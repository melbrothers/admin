<?php

namespace App\Http\Controllers;


use App\Task;
use Illuminate\Http\Request;

/**
 * Class TaskController
 *
 * @package App\Http\Controllers
 * @group Task Management
 */
class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {

    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
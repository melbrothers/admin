<?php
/**
 * Created by PhpStorm.
 * User: Lixing
 * Date: 2018-12-21
 * Time: 20:27
 */

namespace App\Http\Controllers;


use App\Task;
use Illuminate\Http\Request;

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

    public function me()
    {
        return Auth::user();
    }
}
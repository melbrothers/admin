<?php

namespace App\Http\Controllers;


use App\Task;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\Task as TaskResource;

/**
 * Class CommentController
 *
 * @package App\Http\Controllers
 * @group Comment Management
 */
class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    public function index()
    {

    }

    /**
     * @param Request $request
     * @param Task    $task
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Task $task)
    {
        /** @var User $user */
        $user = $request->user();
        $user->comment($task, $request->get('body'));

        return (new TaskResource($task))->response()->setStatusCode(201);
    }
}
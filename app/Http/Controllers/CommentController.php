<?php

namespace App\Http\Controllers;


use App\Comment;
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
        $this->middleware('auth:api');
    }

    /**
     * @param Request $request
     * @param Task    $task
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Task $task)
    {
        $this->validate($request, $this->rules());

        $data = $this->extractInputFromRules($request, $this->rules());

        /** @var User $user */
        $user = $request->user();
        $task->comment($data['body']);

        return (new TaskResource($task))->response()->setStatusCode(201);
    }

    /**
     * @param Request $request
     * @param Comment $comment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reply(Request $request, Comment $comment)
    {
        $this->validate($request, $this->rules());

        $data = $this->extractInputFromRules($request, $this->rules());

        $comment->reply($data['body']);

        return (new TaskResource($comment->task))->response()->setStatusCode(201);
    }

    private function rules()
    {
        return [
            'body' => 'string|required'
        ];
    }
}

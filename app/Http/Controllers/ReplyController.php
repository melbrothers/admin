<?php

namespace App\Http\Controllers;


use App\Comment;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * @param Request $request
     * @param Comment $comment
     *
     * @return JsonResponse
     */
    public function store(Request $request, Comment $comment)
    {
        /** @var User $user */
        $user = $request->user();

        $comment = $user->reply($comment, $request->get('body'));
        return (new CommentResource($comment))->response()->setStatusCode(201);
    }
}
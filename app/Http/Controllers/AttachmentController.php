<?php

namespace App\Http\Controllers;


use App\Attachment;
use App\Comment;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function comment(Comment $comment, Request $request)
    {
        $path = $request->file('attachment')->store('attachments');

        $comment->attach($path);

        return response()->json();
    }

    public function task(Request $request, Task $task)
    {
        $path = $request->file('attachment')->store('attachments');

        $task->attach($path);
        return response()->json();
    }

    public function destroy(Attachment $attachment)
    {
        Storage::delete($attachment->path);

        $attachment->delete();

        return response()->json([], 204);
    }
}
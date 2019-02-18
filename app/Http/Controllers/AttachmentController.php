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


    /**
     *
     * @OA\Post(
     *     path="/comments/{id}/attachments",
     *     tags={"Comment"},
     *     summary="Upload attachment to a comment",
     *     @OA\Parameter(
     *         description="Id of comment",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"file"},
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="attachment",
     *                     type="string",
     *                     format="file",
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return success"
     *     ),
     * )
     * @param Comment $comment
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function comment(Comment $comment, Request $request)
    {
        $path = $request->file('attachment')->store('attachments');

        $comment->attach($path);

        return response()->json();
    }

    /**
     * @OA\Post(
     *     path="/tasks/{slug}/attachments",
     *     tags={"Task"},
     *     summary="Upload attachment to a task",
     *     @OA\Parameter(
     *         description="Slug of task",
     *         in="path",
     *         name="slug",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"file"},
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="attachment",
     *                     type="string",
     *                     format="file",
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return success"
     *     ),
     * )
     *
     * @param Request $request
     * @param Task    $task
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function task(Request $request, Task $task)
    {
        $path = $request->file('attachment')->store('attachments');

        $task->attach($path);
        return response()->json();
    }

    /**
     * @OA\Delete(
     *     path="/attachment/{id}",
     *     tags={"Task"},
     *     summary="Remove an attachment",
     *     @OA\Parameter(
     *         description="Id of attachment",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return success"
     *     ),
     * )
     *
     * @param Attachment $attachment
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Attachment $attachment)
    {
        Storage::delete($attachment->path);

        $attachment->delete();

        return response()->json([], 204);
    }
}

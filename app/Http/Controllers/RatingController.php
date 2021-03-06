<?php

namespace App\Http\Controllers;


use App\Models\Task;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * @OA\Post(
     *     path="/tasks/{task}/ratings",
     *     tags={"Rating"},
     *     summary="Create a new task rating",
     *     @OA\RequestBody(
     *         description="Create data format",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="rating",
     *                      description="Task's rating",
     *                      type="integer",
     *                      format="int32"
     *                  ),
     *                  @OA\Property(
     *                      property="body",
     *                      description="Task's rating comment",
     *                      type="string",
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Create a task successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     * )
     *
     * @param Request $request
     * @param Task    $task
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Task $task)
    {

        if (!in_array($request->user()->id, [$task->sender_id, $task->runner_id])) {
            abort(403);
        }

        $task->rating([
            'body' => $request->get('body'),
            'rating' => $request->get('rating'),
        ], $request->user());

        return response()->json();
    }

    public function rules()
    {
        return [
            'rating' => 'required',
            'body'   => 'required'
        ];
    }
}

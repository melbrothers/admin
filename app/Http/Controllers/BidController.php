<?php

namespace App\Http\Controllers;


use App\Models\Bid;
use App\Events\BidCreated;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\Bid as BidResource;

/**
 * Class BidController
 *
 * @package App\Http\Controllers
 * @group Bid Management
 */
class BidController extends Controller
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
     * @param Task $task
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Task $task)
    {
        $this->authorize('index', [Bid::class, $task]);

        return BidResource::collection($task->bids);
    }

    public function show()
    {

    }

    /**
     * @OA\Post(
     *     path="/tasks/{slug}/bids",
     *     tags={"Task"},
     *     summary="Create a new bid",
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
     *          description="Create data format",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="comment",
     *                      description="Bid's body",
     *                      type="string",
     *                      example="This is a bid comment"
     *                  ),
     *                  @OA\Property(
     *                      property="price",
     *                      description="Bid's price",
     *                      type="integer",
     *                      format="int64",
     *                      example="100"
     *                  ),
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Createa a comment successfully"
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Validation error"
     *     )
     * )
     *
     * @bodyParam price string required
     * @bodyParam comment string required
     *
     * @param Request $request
     * @param Task    $task
     *
     * @return BidResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Task $task)
    {
        $this->validate($request, $this->rules());

        $data = $this->extractInputFromRules($request, $this->rules());

        $this->authorize('store', [Bid::class, $task]);

        $bid = $task->bid($data['price'], $data['comment']);

        event(new BidCreated($bid));

        return new BidResource($bid);
    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    private function rules()
    {
        return [
            'price' => 'numeric|required',
            'comment' => 'string|required'
        ];
    }
}

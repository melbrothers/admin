<?php

namespace App\Http\Controllers;


use App\Events\TaskCreated;
use App\Filters\TaskFilters;
use App\Models\Location;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\Task as TaskResource;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\Bid as BidResource;

/**
 * Class TaskController
 *
 * @package App\Http\Controllers
 * @group Task Management
 */
class TaskController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * @OA\Get(
     *     path="/tasks",
     *     tags={"Task"},
     *     summary="Get list of tasks",
     *     @OA\Parameter(
     *          name="limit",
     *          description="Limit the return result",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example="50"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="min_price",
     *          description="Min task's price",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example="100"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="max_price",
     *          description="Max task's price",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *               example="500"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="task_states",
     *          description="Task's current state",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="posted, assigned, draft"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="query",
     *          description="Task's search term",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="task",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="sort_by",
     *          description="Task's order",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="recent"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="my_tasks",
     *          description="Tasks belong to current user",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="boolean",
     *              example="true",
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="role",
     *          description="Task's role of current user",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="sender"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="after",
     *          description="The start point of next batch of task",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="recent"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return list of tasks"
     *     ),
     * )
     *
     * Get a list of tasks
     *
     * @param Request $request
     *
     * @return TaskCollection
     */
    public function index(Request $request)
    {
        $filters = new TaskFilters($request);
        //dd($filters->apply()->explain());exit;
        //return $filters->apply(Task::search($searchTerm))->paginate($request->get('limit'));
        return new TaskCollection($filters->apply()->get());
    }

    /**
     * @OA\Post(
     *     path="/tasks",
     *     tags={"Task"},
     *     summary="Create a new task",
     *     @OA\RequestBody(
     *         description="Create data format",
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="name",
     *                      description="Task's name",
     *                      type="string",
     *                      example="This is a task name"
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Task's description",
     *                      type="string",
     *                      example="This is a task description"
     *                  ),
     *                  @OA\Property(
     *                      property="price",
     *                      description="Task's price",
     *                      type="integer",
     *                      format="int32",
     *                      example="100"
     *                  ),
     *                  @OA\Property(
     *                      property="deadline",
     *                      description="Task's deadline",
     *                      type="string",
     *                      format="date",
     *                      example="2019-02-26T12:23:21+11:00"
     *                  ),
     *                  @OA\Property(
     *                      property="online_or_phone",
     *                      description="Task's mode",
     *                      type="boolean",
     *                      example="true"
     *                  ),
     *                  @OA\Property(
     *                      property="specified_times",
     *                      description="Task's specified times",
     *                      type="object",
     *                      @OA\Property(
     *                          property="morning",
     *                          type="boolean",
     *                          example="true"
     *                      ),
     *                      @OA\Property(
     *                          property="midday",
     *                          type="boolean",
     *                          example="true"
     *                      ),
     *                      @OA\Property(
     *                          property="afternoon",
     *                          type="boolean",
     *                          example="true"
     *                      ),
     *                      @OA\Property(
     *                          property="evening",
     *                          type="boolean",
     *                          example="true"
     *                      ),
     *                  ),
     *                  @OA\Property(
     *                      property="default_location",
     *                      description="Task's default location",
     *                      type="object",
     *                      @OA\Property(
     *                          property="state",
     *                          type="string",
     *                          example="VIC"
     *                      ),
     *                      @OA\Property(
     *                          property="postcode",
     *                          type="string",
     *                          example="3000"
     *                      ),
     *                      @OA\Property(
     *                          property="suburb",
     *                          type="string",
     *                          example="Melbourne"
     *                      ),
     *                      @OA\Property(
     *                          property="longtitude",
     *                          type="number",
     *                          format="float",
     *                          example="-37.780000"
     *                      ),
     *                      @OA\Property(
     *                          property="latitude",
     *                          type="number",
     *                          format="float",
     *                          example="144.920000"
     *                      ),
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
     *
     * @return TaskResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules());

        $data = $this->extractInputFromRules($request, $this->rules());
        $user = $request->user();

        /** @var Location $location */
        $location = Location::firstOrCreate($data['default_location']);
        $deadline = Carbon::createFromFormat(Carbon::RFC3339, $data['deadline']);
        $task = new Task;
        $task->name = $data['name'];
        $task->price = $data['price'];
        $task->description = $data['description'];
        $task->deadline = $deadline;
        $task->online_or_phone = $data['online_or_phone'];
        $task->specified_times = $data['specified_times'];
        $task->location()->associate($location);
        $user->senderTasks()->save($task);

        event(new TaskCreated($task));

        return new TaskResource($task);
    }

    /**
     * @OA\GET(
     *     path="/tasks/{slug}",
     *     tags={"Task"},
     *     summary="Get a single task by slug",
     *     @OA\Parameter(
     *          name="slug",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return a single task by slug"
     *     ),
     * )
     *
     * Get a task by its slug
     *
     * @param Task $task
     *
     * @return TaskResource
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update a task
     *
     * @param Request $request
     * @param Task    $task
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $this->validate($request, [
            'name' => 'string',
            'description' => 'string',
            'price' => 'numeric',
            'deadline' => 'string',
        ]);

        $task->update($request->all());

        return (new TaskResource($task))->response()->setStatusCode(202);
    }

    /**
     * @param Task $task
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function complete(Task $task)
    {
        $this->authorize('update', $task);

        $task->state = Task::STATE_COMPLETED;
        $task->save();

        return response()->json();
    }

    /**
     * @param Task $task
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function close(Task $task)
    {
        $this->authorize('update', $task);

        $task->state = Task::STATE_CLOSED;
        $task->save();

        return response()->json();
    }

    /**
     * Delete a task
     *
     * @param Task    $task
     *
     * @return int
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $this->authorize('destroy', $task);
        $task->delete();
        return response()->json(null, 204);
    }

    private function rules()
    {
        return [
            'name' => 'string|required',
            'description' => 'string|required',
            'price' => 'numeric|required',
            'deadline' => 'date|date_format:Y-m-d\TH:i:sP|required|after:today',
            'online_or_phone' => 'boolean|required',
            'specified_times.morning' => 'boolean',
            'specified_times.afternoon' => 'boolean',
            'specified_times.evening' => 'boolean',
            'default_location.state' => 'string|required',
            'default_location.suburb' => 'string|required',
            'default_location.postcode' => 'string|required',
            'default_location.latitude' => 'numeric|required',
            'default_location.longitude' => 'numeric|required',
        ];
    }

    /**
     * @OA\GET(
     *     path="/tasks/{id}/bids",
     *     tags={"Task"},
     *     summary="Get all bids by task by slug",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return a single task by slug"
     *     ),
     * )
     * @param Task $task
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function bids(Task $task)
    {
        return BidResource::collection($task->bids);
    }

}

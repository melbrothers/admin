<?php

namespace App\Http\Controllers;


use App\Events\TaskCreated;
use App\Filters\TaskFilters;
use App\Location;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Resources\Task as TaskResource;
use OpenApi\Annotations\OpenApi;

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
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $searchTerm = $request->get('query', '*');

        $filters = new TaskFilters($request);

        //return $filters->apply(Task::search($searchTerm))->paginate($request->get('limit'));
        return TaskResource::collection($filters->apply(Task::search($searchTerm))->paginate($request->get('limit', 10)));
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
     *                  ),
     *                  @OA\Property(
     *                      property="description",
     *                      description="Task's description",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="price",
     *                      description="Task's price",
     *                      type="integer",
     *                      format="int32"
     *                  ),
     *                  @OA\Property(
     *                      property="deadline",
     *                      description="Task's deadline",
     *                      type="string",
     *                      format="date"
     *                  ),
     *                  @OA\Property(
     *                      property="online_or_phone",
     *                      description="Task's mode",
     *                      type="boolean",
     *                  ),
     *                  @OA\Property(
     *                      property="specified_times",
     *                      description="Task's specified times",
     *                      type="object",
     *                      @OA\Property(
     *                          property="morning",
     *                          type="boolean",
     *                      ),
     *                      @OA\Property(
     *                          property="midday",
     *                          type="boolean",
     *                      ),
     *                      @OA\Property(
     *                          property="afternoon",
     *                          type="boolean",
     *                      ),
     *                      @OA\Property(
     *                          property="evening",
     *                          type="boolean",
     *                      ),
     *                  ),
     *                  @OA\Property(
     *                      property="default_location",
     *                      description="Task's default location",
     *                      type="object",
     *                      @OA\Property(
     *                          property="display_name",
     *                          type="string",
     *                      ),
     *                      @OA\Property(
     *                          property="longtitude",
     *                          type="number",
     *                          format="float"
     *                      ),
     *                      @OA\Property(
     *                          property="latitude",
     *                          type="number",
     *                          format="float"
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
        $location = Location::firstOrNew(['display_name' => $data['default_location']['display_name']]);
        $location->latitude = $data['default_location']['latitude'];
        $location->longitude = $data['default_location']['longitude'];
        $location->save();
        $task = new Task;
        $task->name = $data['name'];
        $task->price = $data['price'];
        $task->description = $data['description'];
        $task->deadline = $data['deadline'];
        $task->online_or_phone = $data['online_or_phone'];
        $task->specified_times = $data['specified_times'];
        $task->location()->associate($location);
        $user->tasks()->save($task);

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
            'default_location.display_name' => 'string|required',
            'default_location.latitude' => 'numeric|required',
            'default_location.longitude' => 'numeric|required',
        ];
    }
}

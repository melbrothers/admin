<?php

namespace App\Http\Controllers;


use App\Events\TaskCreated;
use App\Location;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Resources\Task as TaskResource;

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
     * Get a list of tasks
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return TaskResource::collection(Task::paginate(100));
    }

    /**
     * Create a Task
     *
     * @bodyParam name string required
     * @bodyParam description text required
     * @bodyParam price double required
     * @bodyParam deadline date required
     * @bodyParam online_or_phone boolean required
     * @bodyParam specific_times array
     * @bodyParam default_location array
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

    protected function rules()
    {
        return [
            'name' => 'string|required',
            'description' => 'string|required',
            'price' => 'numeric|required',
            'deadline' => 'date|date_format:Y-m-d|required|after:tomorrow',
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

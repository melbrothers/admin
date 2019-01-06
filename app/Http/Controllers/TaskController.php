<?php

namespace App\Http\Controllers;


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

    public function index()
    {
        return TaskResource::collection(Task::paginate());
    }

    /**
     * @bodyParam title string required
     * @bodyParam description string required
     * @bodyParam budget double required
     * @bodyParam location string required
     *
     * @param Request $request
     *
     * @return TaskResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules());

        $data = $request->only(['title', 'description', 'budget', 'location', 'due_date', 'due_time']);
        $user = $request->user();

        $task = $user->tasks()->create([
            'title' => $data['title'],
            'budget' => $data['budget'],
            'description' => $data['description'],
            'location' => $data['location'],
            'due_date' => $data['due_date'],
            'due_time' => $data['due_time'],
        ]);

        return new TaskResource($task);
    }

    /**
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
     * @param Request $request
     * @param Task    $task
     *
     * @return TaskResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, $this->rules());

        $task->update($request->all());

        return new TaskResource($task);
    }

    /**
     * @param Task $task
     *
     * @return int
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(null, 204);
    }

    protected function rules()
    {
        return [
            'title' => 'string|required',
            'description' => 'string|required',
            'budget' => 'numeric|required',
            'location' => 'string|required',
            'due_date' => 'string|required',
            'due_time' => 'string|required'
        ];
    }
}
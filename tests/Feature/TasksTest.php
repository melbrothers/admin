<?php

namespace Tests\Feature;


use App\Task;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TasksTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function an_authenticated_user_can_create_tasks()
    {
        $this->signIn();
        $task = factory(Task::class)->raw();
        $this->post('/v1/tasks', $task);
        $this->seeStatusCode(201);
        $this->seeJson(['name' => $task['name']]);
    }

    /** @test */
    public function a_guest_user_can_view_all_tasks()
    {
        $task = factory(Task::class)->create();
        $this->get('/v1/tasks');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data',
            'links',
            'meta'
        ]);
        $this->seeJsonContains([
            'name' => $task->name,
            'description' => $task->description,
            'price' => $task->price,
        ]);
    }

    /** @test */
    public function an_unauthorized_user_may_not_delete_tasks()
    {
        $this->signIn();
        $task = factory(Task::class)->create();
        $this->delete('v1/tasks/'. $task->id);
        $this->seeStatusCode(403);
    }

    /** @test */
    public function an_authorized_user_can_delete_tasks()
    {
        // authenticate
        $task = factory(Task::class)->create();
        $this->signIn($task->user);
        $this->delete('v1/tasks/'. $task->id);
        $this->seeStatusCode(204);
    }

    /** @test */
    public function an_authorized_user_can_update_task_name()
    {
        $task = factory(Task::class)->create();
        $this->signIn($task->user);
        $this->put('v1/tasks/'. $task->id, [
            'name' => 'new task name'
        ]);
        $this->seeStatusCode(202);
        $this->seeJsonContains([
            'name' => 'new task name',
        ]);
    }

}
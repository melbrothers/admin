<?php

namespace Tests\Feature;


use App\Task;
use App\User;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Passport\Token;

class TasksTest extends \TestCase
{
    use DatabaseTransactions;

    public function setup(): void
    {
        parent::setUp();
        $user = factory(User::class)->create();
        // authenticate
        $user->withAccessToken(new Token(['scopes' => ['*']]));
        $this->actingAs($user, 'api');
    }

    /** @test */
    public function create_a_task()
    {
        $task = factory(Task::class)->raw();
        $this->post('/v1/tasks', $task);
        $this->seeStatusCode(201);
        $this->seeJson(['title' => $task['title']]);
    }

    /** @test */
    public function user_can_view_all_tasks()
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
            'title' => $task->title,
            'description' => $task->description,
            'budget' => $task->budget,
            'location' => $task->location,
            'due_time' => $task->due_time
        ]);
    }

    /** @test */
    public function unauthorized_user_may_not_delete_tasks()
    {
        $task = factory(Task::class)->create();
        $this->delete('v1/tasks/'. $task->id);
        $this->seeStatusCode(403);
    }

    /** @test */
    public function authorized_user_can_delete_tasks()
    {
        // authenticate
        $task = factory(Task::class)->create();
        /** @var User $user */
        $user = $task->user;
        $user->withAccessToken(new Token(['scopes' => ['*']]));
        $this->actingAs($user);
        $this->delete('v1/tasks/'. $task->id);
        $this->seeStatusCode(204);
    }

}
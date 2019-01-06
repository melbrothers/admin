<?php

namespace Tests\Feature;


use App\Task;
use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\Token;

class TasksTest extends \TestCase
{
    use DatabaseMigrations;

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
    public function get_all_tasks()
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

}
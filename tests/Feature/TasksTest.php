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

    /**
     * @throws \Exception
     */
    public function testCreateATask()
    {
        $this->post('/v1/tasks', [
            'title' => 'Task Title',
            'description' => 'Task Description',
            'budget' => 100,
            'location' => 'Melbourne, Victoria',
            'due_date' => '2018-01-01',
            'due_time' => 'afternoon'
        ]);
        $this->seeStatusCode(201);
        $this->seeJsonContains([
            'title' => 'Task Title',
            'description' => 'Task Description',
            'budget' => 100,
            'location' => 'Melbourne, Victoria',
            'due_time' => 'afternoon'
        ]);
    }

    public function testGetTasks()
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
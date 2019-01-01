<?php

namespace Tests\Feature;


use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\Token;

class TasksTest extends \TestCase
{
    use DatabaseMigrations;

    public function testCreateATask()
    {
        $user = factory(User::class)->create();
        // authenticate
        $user->withAccessToken(new Token(['scopes' => ['*']]));
        $this->actingAs($user, 'api');

        // should work
        $this->call('POST', '/v1/tasks', [
            'title' => 'Task Title',
            'description' => 'Task Description',
            'budget' => 100,
            'location' => 'Melbourne, Victoria',
            'due_date' => new \DateTime(),
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
}
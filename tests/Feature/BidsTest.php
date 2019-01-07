<?php

namespace Tests\Feature;


use App\Bid;
use App\Task;
use App\User;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Passport\Token;

class BidsTest extends \TestCase
{
    use DatabaseTransactions;

    public function setup(): void
    {
        parent::setUp();
        $user = factory(User::class)->create();
        // authenticate
        $user->withAccessToken(new Token(['scopes' => ['*']]));
        $this->actingAs($user);
    }

   /** @test */
    public function authorized_user_can_create_a_bid()
    {
        $task = factory(Task::class)->create();
        $this->post(sprintf('/v1/tasks/%s/bids', $task->id), [
            'price' => 100,
            'comment' => 'test comment'
        ]);
        $this->seeStatusCode(201);
        $this->seeJson(['comment' => 'test comment']);
    }

    /** @test */
    public function task_creator_can_not_create_a_bid()
    {
        $task = factory(Task::class)->create();
        /** @var User $user */
        $user = $task->user;
        $user->withAccessToken(new Token(['scopes' => ['*']]));
        $this->actingAs($user, 'api');
        $this->post(sprintf('/v1/tasks/%s/bids', $task->id), [
            'price' => 100,
            'comment' => 'test comment'
        ]);
        $this->seeStatusCode(403);
    }

    /** @test */
    public function task_creator_can_view_bids()
    {
        $bid = factory(Bid::class)->create();
        /** @var User $user */
        $user = $bid->task->user;
        $user->withAccessToken(new Token(['scopes' => ['*']]));
        $this->actingAs($user, 'api');
        $this->get(sprintf('/v1/tasks/%s/bids', $bid->task->id));
        $this->seeStatusCode(200);
        $this->seeJson(['comment' => $bid->comment]);
    }

}
<?php

namespace Tests\Feature;


use App\Bid;
use App\Task;
use App\User;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BidsTest extends \TestCase
{
    use DatabaseTransactions;

   /** @test */
    public function an_authenticated_user_can_create_bids()
    {
        $this->signIn();
        $task = factory(Task::class)->create();
        $this->post(sprintf('/v1/tasks/%s/bids', $task->id), [
            'price' => 100,
            'comment' => 'test comment'
        ]);
        $this->seeStatusCode(201);
        $this->seeJson(['price' => 100]);
    }

    /** @test */
    public function task_creator_can_not_create_bids_for_his_tasks()
    {
        $task = factory(Task::class)->create();
        /** @var User $user */
        $this->signIn($task->user);
        $this->post(sprintf('/v1/tasks/%s/bids', $task->id), [
            'price' => 100,
            'comment' => 'test comment'
        ]);
        $this->seeStatusCode(403);
    }

    /** @test */
    public function task_creator_can_view_bids_for_his_tasks()
    {
        $bid = factory(Bid::class)->create();
        $this->signIn( $bid->task->user);
        $this->get(sprintf('/v1/tasks/%s/bids', $bid->task->id));
        $this->seeStatusCode(200);
        $this->seeJson(['price' => $bid->price]);
    }

}
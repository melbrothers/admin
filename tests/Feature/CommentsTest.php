<?php

namespace Tests\Feature;


use App\Comment;
use App\Task;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CommentsTest extends \TestCase
{
    use DatabaseTransactions;

    public function setup(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /** @test */
    public function a_user_can_post_a_comment_to_a_task()
    {
        $task = factory(Task::class)->create();
        $this->post(sprintf('/v1/tasks/%s/comments', $task->id), [
            'body' => 'test body'
        ]);
        $this->seeStatusCode(201);
        $this->seeInDatabase('comments', ['body' => 'test body']);
    }

    /** @test */
    public function a_user_can_reply_a_comment()
    {
        $comment = factory(Comment::class)->state('task')->create();

        $this->post(sprintf('/v1/comments/%s/replies', $comment->id), [
            'body' => 'test reply'
        ]);
        $this->seeStatusCode(201);
        $this->seeInDatabase('comments', ['body' => 'test reply', 'parent_id' => $comment->id]);
    }
}
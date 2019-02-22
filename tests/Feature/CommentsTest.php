<?php

namespace Tests\Feature;


use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\UploadedFile;
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
        $task = create(Task::class);
        $this->post(sprintf('/v1/tasks/%s/comments', $task->slug), [
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

    /** @test */
    public function authenticated_user_can_attach_image_to_comment()
    {
        $comment = create(Comment::class);
        $this->seeInDatabase('comments', ['body' => $comment->body, 'id' => $comment->id]);

        $this->call('POST', sprintf('/v1/comments/%s/attachments', $comment->id), [], [], [
            'attachment' => UploadedFile::fake()->image('attachment.jpg')
        ]);

        $this->seeStatusCode(200);
    }
}

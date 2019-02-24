<?php

namespace Tests\Feature;


use App\Models\Task;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RatingsTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function an_authenticated_user_can_create_rating()
    {
        $task = create(Task::class);
        $this->signIn($task->sender);
        $this->post(sprintf('/v1/tasks/%s/ratings', $task->id), [
            'body' => 'A good tasker',
            'rating' => '5'
        ]);
        $this->seeStatusCode(200);
        $this->seeInDatabase('ratings', ['body' => 'A good tasker', 'rating' => '5']);
    }
}

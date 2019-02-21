<?php

namespace Tests\Feature;


use App\Location;
use App\Task;
use Illuminate\Http\UploadedFile;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TasksTest extends \TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_guest_user_can_view_a_task()
    {
        $task = create(Task::class);
        $this->get(sprintf('/v1/tasks/%s', $task->slug));
        $this->seeStatusCode(200);
        $this->seeJson(['name' => $task->name]);
    }

    /** @test */
    public function an_authenticated_user_can_create_tasks()
    {
        $this->signIn();
        $task = factory(Task::class)->raw();
        $location = factory(Location::class)->create();
        $task['default_location'] = $location;
        $this->post('/v1/tasks', $task);
        $task = json_decode($this->response->getContent(), true);
        $this->seeStatusCode(201);
        $this->seeJsonContains([
            'name' => $task['name'],
            'location' => $task['location']
        ]);

    }

    /** @test */
    public function a_guest_user_can_view_all_tasks()
    {
        $task = create(Task::class);
        $this->get('/v1/tasks');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data',
            'links',
            'meta'
        ]);
//        $this->seeJsonContains([
//            'name' => $task->name,
//            'description' => $task->description,
//            'price' => $task->price,
//        ]);
    }

    /** @test */
    public function an_unauthorized_user_may_not_delete_tasks()
    {
        $this->signIn();
        $task = create(Task::class);
        $this->delete('v1/tasks/'. $task->slug);
        $this->seeStatusCode(403);
    }

    /** @test */
    public function an_authorized_user_can_delete_tasks()
    {
        // authenticate
        $task = create(Task::class);
        $this->signIn($task->user);
        $this->delete('v1/tasks/'. $task->slug);
        $this->seeStatusCode(204);
    }

    /** @test */
    public function an_authorized_user_can_update_task_name()
    {
        $task = create(Task::class);
        $this->signIn($task->user);
        $this->put('v1/tasks/'. $task->slug, [
            'name' => 'new task name'
        ]);
        $this->seeStatusCode(202);
        $this->seeJsonContains([
            'name' => 'new task name',
        ]);
    }

    /** @test */
    public function authenticated_user_can_attach_image_to_task()
    {
        $task = create(Task::class);
        $this->signIn($task->user);

        $this->call('POST', sprintf('/v1/tasks/%s/attachments', $task->slug), [], [], [
            'attachment' => UploadedFile::fake()->image('attachment.jpg')
        ]);

        $this->seeStatusCode(200);
    }

}

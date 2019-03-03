<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        factory(App\Models\User::class, 50)->create()->each(function (App\Models\User $user) {
            /** @var \App\Models\Task $task */
            $task = factory(App\Models\Task::class)->make();
            $user->postedTasks()->save($task);
            $comments = factory(\App\Models\Comment::class, 2)->make();
            $comments->each(function (\App\Models\Comment $comment) use ($task) {
                $task->comments()->save($comment);
            });
            $bids = factory(\App\Models\Bid::class, 2)->make();
            $bids->each(function (\App\Models\Bid $bid) use ($task) {
                $task->bids()->save($bid);
                $bid->comments()->save(factory(\App\Models\Comment::class)->make());
            });

            factory(\App\Models\Rating::class, 10)->create([
                'rateable_id' => $user->id,
            ]);
        });

    }
}

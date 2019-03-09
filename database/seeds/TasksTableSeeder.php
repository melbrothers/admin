<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        factory(App\Models\User::class, 25)->create()->each(function (App\Models\User $user) {
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

        });

        factory(App\Models\User::class, 25)->create()->each(function (App\Models\User $user) {
            /** @var \App\Models\Task $task */

            $tasks = factory(App\Models\Task::class, 3)->create([
                'state' => 'completed',
                'sender_id' => $user->id,
            ]);

            $tasks->each(function (\App\Models\Task $task) {
                $comments = factory(\App\Models\Comment::class, 2)->make();
                $comments->each(function (\App\Models\Comment $comment) use ($task) {
                    $task->comments()->save($comment);
                });
                $bids = factory(\App\Models\Bid::class, 2)->make();
                $bids->each(function (\App\Models\Bid $bid) use ($task) {
                    $task->bids()->save($bid);
                    $bid->comments()->save(factory(\App\Models\Comment::class)->make());
                });

                $bid = factory(\App\Models\Bid::class)->create([
                    'accepted' => true,
                    'task_id' => $task->id
                ]);

                $task->runner_id = $bid->runner_id;

                $task->save();

                factory(\App\Models\Rating::class)->create([
                    'rateable_id' => $task->id,
                    'author_id' => $task->runner_id
                ]);

                factory(\App\Models\Rating::class)->create([
                    'rateable_id' => $task->id,
                    'author_id' => $task->sender_id
                ]);
            });
        });
    }
}

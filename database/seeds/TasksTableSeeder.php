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
            $user->senderTasks()->save(factory(App\Models\Task::class)->make());
        });
    }
}

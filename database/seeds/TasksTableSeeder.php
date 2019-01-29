<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        factory(App\User::class, 50)->create()->each(function (App\User $user) {
            $user->tasks()->save(factory(App\Task::class)->make());
        });
    }
}

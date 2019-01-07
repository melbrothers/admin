<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Bid::class, function (Faker $faker) {
    return [
        'price' => $faker->numberBetween(0, 1000),
        'fee' => $faker->numberBetween(0, 100),
        'gst' => $faker->numberBetween(0, 10),
        'comment' => $faker->paragraph,
        'task_id' => function() {
            return factory(\App\Task::class)->create()->id;
        },
        'user_id' => function() {
            return factory(\App\User::class)->create()->id;
        }
    ];
});
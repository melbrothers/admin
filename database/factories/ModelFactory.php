<?php

use Faker\Generator as Faker;
use \Carbon\Carbon;
use App\Models\Task;

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

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => new \DateTime(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Task::class, function (Faker $faker) {
    return [
        'name' => $faker->realText(30),
        'description' => $faker->realText(400),
        'price' => $faker->numberBetween(0, 100),
        'deadline' => Carbon::now(config('app.timezone'))->addDays(rand(1, 100)),
        'online_or_phone' => $faker->boolean(),
        'specified_times' => [
            'morning' => true,
            'midday' => false,
            'afternoon' => false,
            'evening' => false
        ],
        'location_id' => function() {
            return \App\Models\Location::find(rand(1,1000))->id;
        },
        'state' => \App\Models\Task::STATE_POSTED,
        'sender_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        }
    ];
});

$factory->state(App\Models\Task::class, Task::STATE_POSTED, function (Faker $faker) {
    return [
        'name' => $faker->realText(30),
        'description' => $faker->realText(400),
        'price' => $faker->numberBetween(0, 100),
        'deadline' => Carbon::now(config('app.timezone'))->format(Carbon::RFC3339),
        'online_or_phone' => $faker->boolean(),
        'specified_times' => [
            'morning' => true,
            'midday' => false,
            'afternoon' => false,
            'evening' => false

        ],
        'location_id' => function() {
            return \App\Models\Location::find(rand(1,1000))->id;
        },
        'state' => Task::STATE_POSTED,
        'sender_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        }
    ];
});


$factory->define(App\Models\Bid::class, function (Faker $faker) {
    return [
        'price' => $faker->numberBetween(0, 1000),
        'fee' => $faker->numberBetween(0, 100),
        'gst' => $faker->numberBetween(0, 10),
        'task_id' => function() {
            return factory(App\Models\Task::class)->create()->id;
        },
        'runner_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        }
    ];
});

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [
        'author_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'body' => $faker->paragraph,
        'commentable_id' => function() {
            return factory(App\Models\Task::class)->create()->id;
        },
        'commentable_type' => \App\Models\Task::class
    ];
});

$factory->state(App\Models\Comment::class, 'task', function (Faker $faker) {
    return [
        'author_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'body' => $faker->paragraph,
        'commentable_id' => function() {
            return factory(App\Models\Task::class)->create()->id;
        },
        'commentable_type' => \App\Models\Task::class
    ];
});

$factory->state(App\Models\Comment::class, 'bid', function (Faker $faker) {
    return [
        'author_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'body' => $faker->paragraph,
        'commentable_id' => function() {
            return factory(App\Models\Bid::class)->create()->id;
        },
        'commentable_type' => \App\Models\Bid::class
    ];
});


$factory->state(App\Models\Comment::class, 'reply', function (Faker $faker) {

    return [
        'author_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'body' => $faker->paragraph,
        'commentable_id' => function() {
            return factory(App\Models\Task::class)->create()->id;
        },
        'commentable_type' => \App\Models\Task::class,

        'parent_id' => function() {
            return factory(App\Models\Comment::class)->create()->id;
        }
    ];
});


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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => new \DateTime(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'price' => $faker->numberBetween(0, 100),
        'deadline' => (new \DateTime())->add(new DateInterval('P2D'))->format('c'),
        'online_or_phone' => $faker->boolean(),
        'specified_times' => [
            'morning' => true
        ],
        'location_id' => function() {
            return factory(App\Location::class)->create()->id;
        },
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        }
    ];
});

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'display_name' => $faker->city(),
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
    ];
});

$factory->define(App\Bid::class, function (Faker $faker) {
    return [
        'price' => $faker->numberBetween(0, 1000),
        'fee' => $faker->numberBetween(0, 100),
        'gst' => $faker->numberBetween(0, 10),
        'task_id' => function() {
            return factory(App\Task::class)->create()->id;
        },
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        }
    ];
});

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'body' => $faker->paragraph,
        'commentable_id' => function() {
            return factory(App\Task::class)->create()->id;
        },
        'commentable_type' => \App\Task::class
    ];
});

$factory->state(App\Comment::class, 'task', function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'body' => $faker->paragraph,
        'commentable_id' => function() {
            return factory(App\Task::class)->create()->id;
        },
        'commentable_type' => \App\Task::class
    ];
});

$factory->state(App\Comment::class, 'bid', function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'body' => $faker->paragraph,
        'commentable_id' => function() {
            return factory(App\Bid::class)->create()->id;
        },
        'commentable_type' => \App\Bid::class
    ];
});


$factory->state(App\Comment::class, 'reply', function (Faker $faker) {

    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'body' => $faker->paragraph,
        'commentable_id' => function() {
            return factory(App\Task::class)->create()->id;
        },
        'commentable_type' => \App\Task::class,

        'parent_id' => function() {
            return factory(App\Comment::class)->create()->id;
        }
    ];
});


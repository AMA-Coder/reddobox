<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'fname' => $faker->userName,
        'lname' => $faker->userName,
        'full_name' => $faker->name,
        'gender' => 'male',
        'confirmation_code' => $faker->password,
        'dof' => '122141241',
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
    ];
});

$factory->define(App\Rate::class, function (Faker\Generator $faker) {
    $cats = ['social', 'personal'];
    return [
        'user_id' => rand(1, 10000),
        'from_id' => rand(1, 10000),
        'category' => $cats[rand(0, 1)],
        'rate_trait_id' => rand(0, 24),
        'rate' => rand(0, 100),
        'review' => str_random(100)
    ];
});

// factory(App\Rate::class)->make();
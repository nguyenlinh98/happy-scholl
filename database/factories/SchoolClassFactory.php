<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\SchoolClass;
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

$factory->define(SchoolClass::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'calendar_id' => 1,
    ];
});

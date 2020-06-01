<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Student;
use Faker\Generator as Faker;
use Faker\Provider\Japanese as Japanese;

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

$factory->define(Student::class, function (Faker $faker) {
    $faker->addProvider(new Japanese($faker));

    return [
        'name' => $faker->name(),
        'gender' => $faker->randomElement([0, 1]),
        'first_name' => $faker->firstKanaName,
        'last_name' => $faker->lastKanaName,
    ];
});

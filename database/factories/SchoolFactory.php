<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\School;
use Faker\Generator as Faker;

$factory->define(School::class, function (Faker $faker) {
    return [
        'name' => $faker->lexify('School ???'),
        'calendar_id' => 1,
    ];
});

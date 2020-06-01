<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Letter;
use Faker\Generator as Faker;

$factory->define(Letter::class, function (Faker $faker) {
    return [
        'subject' => $faker->name,
        'body' => $faker->name,
        'status'=> random_int(0,3)
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\ClassGroup;
use Faker\Generator as Faker;

$factory->define(ClassGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});

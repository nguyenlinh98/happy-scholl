<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'subject' => $faker->name,
        'body' => $faker->name,
        'school_id'=>1
    ];
});

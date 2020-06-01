<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\MessageReadStatus;
use Faker\Generator as Faker;

$factory->define(MessageReadStatus::class, function (Faker $faker) {
    return [
        'read' => 0,
        'school_id'=>1
    ];
});

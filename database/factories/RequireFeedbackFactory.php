<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\RequireFeedback::class, function (Faker $faker) {
    return [
        'subject' => $faker->realText(20),
        'body' => $faker->realText(200),
        'sender' => $faker->name,
        'deadline' => $faker->date('Y-m-d H:i:s','2030-01-01 00:00:00'),
        'scheduled_at' => $faker->date('Y-m-d H:i:s'),
        'status' => random_int(0, 1),
        'school_id' => 1,
        'clean_up_at' => $faker->date('Y-m-d H:i:s'),
    ];
});

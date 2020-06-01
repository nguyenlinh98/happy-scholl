<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\RequireFeedbacksReceiver::class, function (Faker $faker) {
    return [
        'status' => random_int(0, 3)
    ];
});

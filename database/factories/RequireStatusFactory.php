<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\RequireFeedbackStatuses::class, function (Faker $faker) {
    return [
        'feedback' => random_int(0, 2)
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\SchoolPasscode::class, function (Faker $faker) {
    return [
        'passcode' => $faker->regexify('[a-z]{1}[0-9]{4}'),
        'active' => 1
    ];
});

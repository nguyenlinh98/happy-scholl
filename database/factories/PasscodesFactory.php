<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\PassCode::class, function (Faker $faker) {
    return [
        'passcode' => $faker->regexify('[0-9]{7}'),
        'used' => 0
    ];
});

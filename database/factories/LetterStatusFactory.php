<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\LetterReadStatus;
use Faker\Generator as Faker;

$factory->define(LetterReadStatus::class, function (Faker $faker) {
    return [
        'read' => 0,
        'favorist_flag' => 0,
        'school_id'=>1
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\SchoolSetting::class, function (Faker $faker) {
    return [
        'letter_active' => 1,
        'message_active' => 1,
        'require_feedback_active' => 1,
        'organization_active' => 1,
        'recycle_active' => 1,
        'happy_school_plus_active' => 1,
        'contact_book_active' => 1,
        'urgent_contact_active' => 1,
        'seminar_active' => 1,
        'event_active' => 1
    ];
});

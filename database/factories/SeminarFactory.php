<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Seminar;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Faker\Provider\Japanese as Japanese;

$factory->define(Seminar::class, function (Faker $faker) {
    $faker->addProvider(new Japanese($faker));

    $all_class = $faker->boolean(20);
    if (true === $faker->boolean()) {
        // fake distributed Seminar
        $scheduled_date = $faker->dateTimeBetween('last year', 'yesterday');
        $deadline_date = $faker->dateTimeBetween($scheduled_date, '+1 month');
        $status = Seminar::STATUS_DISTRIBUTED;
    } else {
        $scheduled_date = $faker->dateTimeBetween('now', '+1 month');
        $deadline_date = $faker->dateTimeBetween($scheduled_date, '+1 month');
        $status = Seminar::STATUS_RESERVATION;
    }
    if (true === $faker->boolean()) {
        $help_scheduled_at = $faker->dateTimeBetween($scheduled_date, '+1 month');
        $help_deadline_at = $faker->dateTimeBetween($help_scheduled_at, '+1 month');
        $help_max_people = $faker->numberBetween(1, 100);
        $reason = $faker->realText;
    }
    $scheduled_time = $faker->randomElement(hsp_time_generator());
    $help_scheduled_time = $faker->randomElement(hsp_time_generator());

    return [
        'subject' => $faker->realText,
        'body' => $faker->realText,
        'sender' => $faker->name,
        'tel' => $faker->phone,
        'instructor' => $faker->name,
        'fee' => $faker->randomNumber(3),
        'address' => $faker->address,
        'scheduled_at' => Carbon::parse($scheduled_date->format('Y-m-d').' '.$scheduled_time),
        'deadline_at' => $deadline_date->format('Y-m-d'),
        'status' => $status,
        'all_class' => $all_class,
        'school_id' => 1,
        'max_people' => $faker->numberBetween(1, 100),
        'max_help_people' => isset($help_max_people) ? $help_max_people : null,
        'help_scheduled_at' => isset($help_scheduled_at) ? $help_scheduled_at->format('Y-m-d').' '.$help_scheduled_time : null,
        'help_deadline_at' => isset($help_deadline_at) ? $help_deadline_at->format('Y-m-d') : null,
        'reason' => isset($reason) ? $reason : '',
    ];
});

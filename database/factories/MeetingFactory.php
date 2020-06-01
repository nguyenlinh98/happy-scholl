<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\ClassGroup;
use App\Models\Department;
use App\Models\Meeting;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use Faker\Generator as Faker;
use Faker\Provider\Japanese as Japanese;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

$factory->define(Meeting::class, function (Faker $faker) {
    $faker->addProvider(new Japanese($faker));
    $school = School::inRandomOrder()->first();
    $scheduled_at = $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d H:i:s');

    return [
        'subject' => $faker->realText,
        'body' => Collection::times($faker->randomDigitNotNull, function () use ($faker) { return $faker->realText; })->join("\n"),
        'sender' => $faker->name,
        'contact_email' => $faker->email,
        'zoom_link' => $faker->url,
        'school_id' => $school->id,
        'type' => $faker->randomElement(['GROUP', 'DEPARTMENT', 'INDIVIDUAL', 'CLASS']),
        'status' => $scheduled_at > now() ? 0 : 1,
        'scheduled_at' => $scheduled_at,
    ];
});

$factory->afterCreating(Meeting::class, function ($meeting, $faker) {
    if ('GROUP' === $meeting->type) {
        $collectionQuery = (new ClassGroup())->newQuery();
    }

    if ('DEPARTMENT' === $meeting->type) {
        $collectionQuery = (new Department())->newQuery();
    }

    if ('CLASS' === $meeting->type) {
        $collectionQuery = (new SchoolClass())->newQuery();
    }

    if ('INDIVIDUAL' === $meeting->type) {
        $collectionQuery = (new Student())->newQuery();
    }

    $collection = $collectionQuery->where('school_id', $meeting->school_id)->inRandomOrder()->limit($faker->randomDigitNotNull)->get()->map(function ($item) use ($meeting) {
        return [
            'meeting_id' => $meeting->id,
            'receiver_type' => get_class($item),
            'receiver_id' => $item->id,
            'school_id' => $meeting->school_id,
            'status' => 0,
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ];
    });
    DB::table('meeting_receivers')->insert($collection->toArray());

    if (1 === $meeting->status) {
        $students = $meeting->students()->get()->map(function ($student) use ($meeting, $faker) {
            return [
                'meeting_id' => $meeting->id,
                'student_id' => $student->id,
                'school_id' => $meeting->school_id,
                'favorist_flag' => $faker->boolean,
                'read' => $faker->boolean,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ];
        });
        DB::table('meeting_statuses')->insert($students->toArray());
    }
});

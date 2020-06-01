<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\SchoolEvent;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

$factory->define(SchoolEvent::class, function (Faker $faker) {
    $school = School::inRandomOrder()->first();
    if (true === $faker->boolean()) {
        // fake distributed SchoolEvent
        $scheduled_date = $faker->dateTimeBetween('last year', 'yesterday');
        $deadline_date = $faker->dateTimeBetween($scheduled_date, '+1 month');
        $status = SchoolEvent::STATUS_DISTRIBUTED;
    } else {
        $scheduled_date = $faker->dateTimeBetween('now', '+1 month');
        $deadline_date = $faker->dateTimeBetween($scheduled_date, '+1 month');
        $status = SchoolEvent::STATUS_RESERVATION;
    }
    if (true === $faker->boolean()) {
        $help_scheduled_at = $faker->dateTimeBetween($scheduled_date, '+1 month');
        $help_deadline_at = $faker->dateTimeBetween($help_scheduled_at, '+1 month');
        $help_max_people = $faker->numberBetween(1, 100);
        $reason = $faker->paragraphs($faker->randomDigitNotNull, true);
    }
    $scheduled_time = $faker->randomElement(hsp_time_generator());
    $help_scheduled_time = $faker->randomElement(hsp_time_generator());

    return [
        'subject' => $faker->sentence,
        'body' => $faker->paragraphs(3, true),
        'max_people' => $faker->numberBetween(1, 100),
        'sender' => $faker->name,
        'status' => $status,
        'scheduled_at' => Carbon::parse($scheduled_date->format('Y-m-d').' '.$scheduled_time),
        'deadline_at' => $deadline_date->format('Y-m-d'),
        'need_help' => isset($reason),
        'reason' => isset($reason) ? $reason : '',
        'max_help_people' => isset($help_max_people) ? $help_max_people : 0,
        'help_scheduled_at' => isset($help_scheduled_at) ? $help_scheduled_at->format('Y-m-d').' '.$help_scheduled_time : null,
        'help_deadline_at' => isset($help_deadline_at) ? $help_deadline_at->format('Y-m-d') : null,
        'school_id' => $school->id,
        'email' => $faker->email,
        'tel' => $faker->phoneNumber,
    ];
});

$factory->afterCreating(SchoolEvent::class, function ($schoolEvent, $faker) {
    if (is_dir(storage_path("app/public/uploads/{$schoolEvent->getTable()}/{$schoolEvent->id}/images"))) {
        hsp_unlink_dir(storage_path("app/public/uploads/{$schoolEvent->getTable()}/{$schoolEvent->id}/images"));
    }

    // Making fake images

    $schoolEvent->image1 = $faker->boolean ? str_replace('lorempixel.com', 'picsum.photos', $faker->imageUrl($faker->numberBetween(400, 640), $faker->numberBetween(400, 640))) : '';
    $schoolEvent->image2 = $faker->boolean ? str_replace('lorempixel.com', 'picsum.photos', $faker->imageUrl($faker->numberBetween(400, 640), $faker->numberBetween(400, 640))) : '';
    $schoolEvent->image3 = $faker->boolean ? str_replace('lorempixel.com', 'picsum.photos', $faker->imageUrl($faker->numberBetween(400, 640), $faker->numberBetween(400, 640))) : '';

    foreach ($schoolEvent->getImageArray() as $imageKey => $url) {
        if ($url) {
            $image = file_get_contents($url);
            $fileName = Str::random(40).'.jpg';
            $path = Storage::disk('public')->put("uploads/{$schoolEvent->getTable()}/{$schoolEvent->id}/images/{$fileName}", $image);
            $schoolEvent->$imageKey = $fileName;
        }
    }

    // making fake receivers

    $schoolClassesData = SchoolClass::where('school_id', $schoolEvent->school_id)->get()->pluck('id');
    $data = $faker->randomElements($schoolClassesData, $faker->numberBetween(1, $schoolClassesData->count()));
    $schoolClasses = collect($data)->mapWithKeys(function ($schoolClass) use ($schoolEvent) {
        return [$schoolClass => ['school_id' => $schoolEvent->school_id]];
    });
    $schoolEvent->schoolClasses()->sync($schoolClasses);

    $schoolEvent->save();
});

<?php

use App\Models\Calendar;
use App\Models\Event;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Database\Seeder;

class AllDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $calendar = new Calendar();
        $calendar->name = 'hsp';
        $calendar->type = 'hsp';
        $calendar->save();
        $faker = Faker\Factory::create();

        foreach (range(1, 5) as $index) {
            $school = factory(\App\Models\School::class)->withoutEvents()->make();
            $calendar = Calendar::generate($school->name.'のカレンダー', $index + 1, School::class);
            $school->calendar_id = $calendar->id;
            $school->save();
        }
        $schools = \App\Models\School::get();

        foreach ($schools as $school) {
            factory(\App\Models\SchoolSetting::class)->withoutEvents()->create([
                'school_id' => $school->id,
            ]);
            factory(\App\Models\SchoolPasscode::class)->withoutEvents()->create([
                'school_id' => $school->id,
            ]);
            foreach (range(1, 3) as $index) {
                $calendar = Calendar::generate("{$index}年1組のカレンダー", $school->id, SchoolClass::class);

                factory(SchoolClass::class)->withoutEvents()->create([
                    'name' => "{$index}年1組",
                    'school_id' => $school->id,
                    'calendar_id' => $calendar->id,
                ]);
                $calendar = Calendar::generate("{$index}年2組のカレンダー", $school->id, SchoolClass::class);

                factory(SchoolClass::class)->withoutEvents()->create([
                    'name' => "{$index}年2組",
                    'school_id' => $school->id,
                    'calendar_id' => $calendar->id,
                ]);
                $calendar = Calendar::generate("{$index}年3組のカレンダー", $school->id, SchoolClass::class);

                factory(SchoolClass::class)->withoutEvents()->create([
                    'name' => "{$index}年3組",
                    'school_id' => $school->id,
                    'calendar_id' => $calendar->id,
                ]);
            }
        }
        foreach (SchoolClass::withoutGlobalScopes()->get() as $class) {
            factory(Student::class, 10)->withoutEvents()->create([
                'school_class_id' => $class->id,
                'school_id' => $class->school_id,
            ]);
        }
        $students = DB::table('students')->get();

        foreach ($students as $student) {
            $passcodes = factory(\App\Models\PassCode::class)->withoutEvents()->create([
                'student_id' => $student->id,
                'used' => 0,
            ]);
            $requireFeedback = factory(\App\Models\RequireFeedback::class, random_int(5, 10))->withoutEvents()->create([
                'school_id' => $student->school_id,
            ]);
            foreach ($requireFeedback as $feedback) {
                $receiverId = $student->id;
                $receiverType = random_int(1, 3);

                if (2 == $receiverType) {
                    $receiverId = $student->school_class_id;
                }

                factory(\App\Models\RequireFeedbackStatuses::class)->withoutEvents()->create([
                    'require_feedback_id' => $feedback->id,
                    'student_id' => $student->id,
                    'feedback' => random_int(0, 2),
                    'school_id' => $student->school_id,
                ]);
                factory(\App\Models\RequireFeedbacksReceiver::class)->withoutEvents()->create([
                    'require_feedback_id' => $feedback->id,
                    'school_id' => $feedback->school_id,
                    'receiver_id' => $receiverId,
                    'receiver_type' => $receiverType,
                    'status' => random_int(0, 3),
                ]);
            }
        }

        // calendar + event
        // $arr_color = ['blue', 'red', 'yellow'];
        // foreach (range(1, 5) as $index) {
        //     factory(\App\Models\Calendar::class)->withoutEvents()->create([
        //         'school_id' => 1,
        //         'event_bgcolor' => $arr_color[random_int(0, 2)],

        //     ]);
        // }

        foreach (range(1, 5) as $index) {
            factory(\App\Models\Event::class)->create([
                'type' => 1,
                'start' => date('Y-m-d H:i:s'),
                'end' => date('Y-m-d H:i:s'),
                'calendar_id' => random_int(1, 5),
                'remind' => random_int(1, 5),
            ]);
        }

        // letter
        $users = DB::table('users')->get();
        foreach (range(1, 5) as $index) {
            // foreach ($users as $user) {
            factory(\App\Models\Letter::class)->withoutEvents()->create([
                'sender' => random_int(1, 10),
                'file' => 'doc.doc',
                'school_id' => $faker->randomElement($schools->pluck('id')->toArray()),
            ]);
            //}
        }
        $letters = DB::table('letters')->get();
        foreach (range(1, 5) as $index) {
            foreach ($letters as $letter) {
                //foreach ($students as $student) {
                factory(\App\Models\LetterReadStatus::class)->withoutEvents()->create([
                    'student_id' => random_int(1, 19),
                    'letter_id' => $letter->id,
                ]);
                // }
            }
        }

        // for messages
        foreach (range(1, 15) as $index) {
            // foreach ($users as $user) {
            factory(\App\Models\Message::class)->withoutEvents()->create([
                'sender' => random_int(1, 10),
            ]);
            //}
        }
        $messages = DB::table('messages')->get();
        foreach (range(1, 15) as $index) {
            foreach ($messages as $message) {
                //foreach ($students as $student) {
                factory(\App\Models\MessageReadStatus::class)->withoutEvents()->create([
                    'student_id' => random_int(1, 19),
                    'message_id' => $message->id,
                ]);
                // }
            }
        }
    }
}

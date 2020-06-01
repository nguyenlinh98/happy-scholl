<?php

use App\Models\Calendar;
use App\Models\ParentStudent;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentAndParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $school = School::first();

        $role = new Role();
        $role->display_name = 'Parent';
        $role->name = 'parents';
        $role->save();
        $students = DB::table('students')->get();
        $students = $faker->randomElements($students, intval($students->count() / 3 * 2));
        // make random parents for 2/3 of the students
        foreach ($students as $student) {
            foreach (range(1, $faker->numberBetween(1, 2)) as $index) {
                $parent = factory(User::class)->withoutEvents()->make([
                    'role_id' => $role->id,
                    'school_id' => $school->id,
                ]);

                $calendar = Calendar::generate($parent->name.'のカレンダー', $school->id, User::class);
                $parent->calendar_id = $calendar->id;
                $parent->save();

                Db::table('user_settings')->insert([
                    'user_id' => $parent->id,
                    'push_letter' => $faker->boolean(),
                    'push_notice' => $faker->boolean(),
                ]);
                $parentStudent = new ParentStudent();
                $parentStudent->user_id = $parent->id;
                $parentStudent->student_id = $student->id;
                $parentStudent->save();
            }
        }
    }
}

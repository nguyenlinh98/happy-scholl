<?php

use App\Models\Contact;
use App\Models\School;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker\Factory::create('ja_JP');

        $school = School::first();
        $students = Student::all()->pluck('id');
        $fakerRelationships = [
            '母',
            '父',
            '祖父',
            '祖母',
            'その他',
        ];

        foreach ($students as $student) {
            if (!$faker->boolean(70)) {
                continue;
            }

            $relationships = $faker->randomElements($fakerRelationships, $faker->numberBetween(1, count($fakerRelationships)));
            foreach ($relationships as $relationship) {
                factory(Contact::class)->create([
                    'student_id' => $student,
                    'relationship' => $relationship,
                    'school_id' => $school->id,
                ]);
            }
        }
    }
}

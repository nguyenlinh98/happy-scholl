<?php

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class SeminarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $schoolClasses = SchoolClass::all();
        factory(App\Models\Seminar::class, 50)->withoutEvents()->create()->each(function ($seminar) use ($schoolClasses) {
            if ($seminar->all_class) {
                $seminar->schoolClasses()->attach($schoolClasses->pluck('id')->toArray());
            } else {
                $seminar->schoolClasses()->attach($schoolClasses->random(mt_rand(1, $schoolClasses->count())));
            }
        });
    }
}

<?php

use App\Models\Parents;
use App\Models\RecycleProduct;
use App\Models\School;
use Illuminate\Database\Seeder;

class RecycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker\Factory::create('ja_JP');

        $school = School::first();
        $users = Parents::whereHas('student')->where('school_id', $school->id)->get()->pluck('id');
        $recyclePlaces = $school->recyclePlaces->pluck('id');

        foreach (range(0, 20) as $index) {
            factory(RecycleProduct::class)->create([
                'school_id' => $school->id,
                'user_id' => $faker->randomElement($users),
                'recycle_place_id' => 0 === count($recyclePlaces) ? 1 : $faker->randomElement($recyclePlaces),
                'created_at' => $faker->dateTimeThisYear(),
            ]);
        }
    }
}

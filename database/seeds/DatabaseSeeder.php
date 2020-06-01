<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(AllDataSeeder::class);
        $this->call(StudentAndParentSeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(RecycleSeeder::class);
        $this->call(RoleAndTopAdminSeeder::class);
        $this->call(SeminarSeeder::class);

        $this->call(UsersTableSeeder::class);
    }
}

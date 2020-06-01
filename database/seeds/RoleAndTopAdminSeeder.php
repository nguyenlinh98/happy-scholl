<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleAndTopAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $role = new Role();
        $role->display_name = 'School Admin';
        $role->name = 'school_admin';
        $role->save();

        $teacher = factory(User::class)->make([
            'role_id' => $role->id,
            'school_id' => 1,
            'school_login_id' => 'teacher_test',
        ]);

        $teacher->save();

        $role = new Role();
        $role->display_name = 'Top Admin';
        $role->name = 'top_admin';
        $role->save();

        $topAdmin = factory(User::class)->make();
        $topAdmin->role_id = $role->id;
        $topAdmin->save();

        $role = new Role();
        $role->display_name = 'Teacher';
        $role->name = 'teacher';
        $role->save();
    }
}

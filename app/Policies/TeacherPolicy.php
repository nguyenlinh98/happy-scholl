<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determie whether the uses is School Admin or Teacher
     */
    public function before($user, $ability)
    {
        if ($user->isSchoolAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any teachers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can view the teacher.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Teacher  $teacher
     * @return mixed
     */
    public function view(User $user, Teacher $teacher)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create teachers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can update the teacher.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Teacher  $teacher
     * @return mixed
     */
    public function update(User $user, Teacher $teacher)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the teacher.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Teacher  $teacher
     * @return mixed
     */
    public function delete(User $user, Teacher $teacher)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the teacher.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Teacher  $teacher
     * @return mixed
     */
    public function restore(User $user, Teacher $teacher)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the teacher.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Teacher  $teacher
     * @return mixed
     */
    public function forceDelete(User $user, Teacher $teacher)
    {
        //
        return true; // TODO add valid conditions
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolClassPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determie whether the uses is School Admin or Teacher
     */
    public function before($user, $ability)
    {
        if ($user->isSchoolAdmin()||$user->isTeacher()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any SchoolClasses.
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
     * Determine whether the user can view the SchoolClass.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SchoolClass  $SchoolClass
     * @return mixed
     */
    public function view(User $user, SchoolClass $SchoolClass)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create SchoolClasses.
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
     * Determine whether the user can update the SchoolClass.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SchoolClass  $SchoolClass
     * @return mixed
     */
    public function update(User $user, SchoolClass $SchoolClass)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the SchoolClass.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SchoolClass  $SchoolClass
     * @return mixed
     */
    public function delete(User $user, SchoolClass $SchoolClass)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the SchoolClass.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SchoolClass  $SchoolClass
     * @return mixed
     */
    public function restore(User $user, SchoolClass $SchoolClass)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the SchoolClass.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SchoolClass  $SchoolClass
     * @return mixed
     */
    public function forceDelete(User $user, SchoolClass $SchoolClass)
    {
        //
        return true; // TODO add valid conditions
    }
}

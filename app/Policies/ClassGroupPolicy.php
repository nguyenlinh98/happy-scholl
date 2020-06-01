<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClassGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassGroupPolicy
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
     * Determine whether the user can view any class groups.
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
     * Determine whether the user can view the class group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClassGroup  $classGroup
     * @return mixed
     */
    public function view(User $user, ClassGroup $classGroup)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create class groups.
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
     * Determine whether the user can update the class group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClassGroup  $classGroup
     * @return mixed
     */
    public function update(User $user, ClassGroup $classGroup)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the class group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClassGroup  $classGroup
     * @return mixed
     */
    public function delete(User $user, ClassGroup $classGroup)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the class group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClassGroup  $classGroup
     * @return mixed
     */
    public function restore(User $user, ClassGroup $classGroup)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the class group.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClassGroup  $classGroup
     * @return mixed
     */
    public function forceDelete(User $user, ClassGroup $classGroup)
    {
        //
        return true; // TODO add valid conditions
    }
}

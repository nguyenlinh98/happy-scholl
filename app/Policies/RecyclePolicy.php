<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Recycle;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecyclePolicy
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
     * Determine whether the user can view any recycles.
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
     * Determine whether the user can view the recycle.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Recycle  $recycle
     * @return mixed
     */
    public function view(User $user, Recycle $recycle)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create recycles.
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
     * Determine whether the user can update the recycle.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Recycle  $recycle
     * @return mixed
     */
    public function update(User $user, Recycle $recycle)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the recycle.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Recycle  $recycle
     * @return mixed
     */
    public function delete(User $user, Recycle $recycle)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the recycle.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Recycle  $recycle
     * @return mixed
     */
    public function restore(User $user, Recycle $recycle)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the recycle.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Recycle  $recycle
     * @return mixed
     */
    public function forceDelete(User $user, Recycle $recycle)
    {
        //
        return true; // TODO add valid conditions
    }
}

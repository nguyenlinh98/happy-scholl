<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Corporate;
use Illuminate\Auth\Access\HandlesAuthorization;

class CorporatePolicy
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
     * Determine whether the user can view any corporates.
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
     * Determine whether the user can view the corporate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Corporate  $corporate
     * @return mixed
     */
    public function view(User $user, Corporate $corporate)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create corporates.
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
     * Determine whether the user can update the corporate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Corporate  $corporate
     * @return mixed
     */
    public function update(User $user, Corporate $corporate)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the corporate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Corporate  $corporate
     * @return mixed
     */
    public function delete(User $user, Corporate $corporate)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the corporate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Corporate  $corporate
     * @return mixed
     */
    public function restore(User $user, Corporate $corporate)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the corporate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Corporate  $corporate
     * @return mixed
     */
    public function forceDelete(User $user, Corporate $corporate)
    {
        //
        return true; // TODO add valid conditions
    }
}

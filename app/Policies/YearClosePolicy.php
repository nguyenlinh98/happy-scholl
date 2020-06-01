<?php

namespace App\Policies;

use App\Models\User;
use App\Models\YearClose;
use Illuminate\Auth\Access\HandlesAuthorization;

class YearClosePolicy
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
     * Determine whether the user can view any year closes.
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
     * Determine whether the user can view the year close.
     *
     * @param  \App\Models\User  $user
     * @param  \App\YearClose  $yearClose
     * @return mixed
     */
    public function view(User $user, YearClose $yearClose)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create year closes.
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
     * Determine whether the user can update the year close.
     *
     * @param  \App\Models\User  $user
     * @param  \App\YearClose  $yearClose
     * @return mixed
     */
    public function update(User $user, YearClose $yearClose)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the year close.
     *
     * @param  \App\Models\User  $user
     * @param  \App\YearClose  $yearClose
     * @return mixed
     */
    public function delete(User $user, YearClose $yearClose)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the year close.
     *
     * @param  \App\Models\User  $user
     * @param  \App\YearClose  $yearClose
     * @return mixed
     */
    public function restore(User $user, YearClose $yearClose)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the year close.
     *
     * @param  \App\Models\User  $user
     * @param  \App\YearClose  $yearClose
     * @return mixed
     */
    public function forceDelete(User $user, YearClose $yearClose)
    {
        //
        return true; // TODO add valid conditions
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Orgnization;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrgnizationPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determie whether the uses is School Admin or Teacher
     */
    public function before($user, $ability)
    {
        if ($user->isSupperAdmin()) {
            return true;
        }
    }
    
    /**
     * Determine whether the user can view any orgnizations.
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
     * Determine whether the user can view the orgnization.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Orgnization  $orgnization
     * @return mixed
     */
    public function view(User $user, Orgnization $orgnization)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create orgnizations.
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
     * Determine whether the user can update the orgnization.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Orgnization  $orgnization
     * @return mixed
     */
    public function update(User $user, Orgnization $orgnization)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the orgnization.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Orgnization  $orgnization
     * @return mixed
     */
    public function delete(User $user, Orgnization $orgnization)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the orgnization.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Orgnization  $orgnization
     * @return mixed
     */
    public function restore(User $user, Orgnization $orgnization)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the orgnization.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Orgnization  $orgnization
     * @return mixed
     */
    public function forceDelete(User $user, Orgnization $orgnization)
    {
        //
        return true; // TODO add valid conditions
    }
}

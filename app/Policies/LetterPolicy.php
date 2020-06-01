<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Letter;
use Illuminate\Auth\Access\HandlesAuthorization;

class LetterPolicy
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
     * Determine whether the user can view any letters.
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
     * Determine whether the user can view the letter.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Letter  $letter
     * @return mixed
     */
    public function view(User $user, Letter $letter)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create letters.
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
     * Determine whether the user can update the letter.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Letter  $letter
     * @return mixed
     */
    public function update(User $user, Letter $letter)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the letter.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Letter  $letter
     * @return mixed
     */
    public function delete(User $user, Letter $letter)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the letter.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Letter  $letter
     * @return mixed
     */
    public function restore(User $user, Letter $letter)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the letter.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Letter  $letter
     * @return mixed
     */
    public function forceDelete(User $user, Letter $letter)
    {
        //
        return true; // TODO add valid conditions
    }
}

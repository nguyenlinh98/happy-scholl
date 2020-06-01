<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RequireFeedback;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequireFeedbackPolicy
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
     * Determine whether the user can view any require feedback.
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
     * Determine whether the user can view the require feedback.
     *
     * @param  \App\Models\User  $user
     * @param  \App\RequireFeedback  $requireFeedback
     * @return mixed
     */
    public function view(User $user, RequireFeedback $requireFeedback)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create require feedback.
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
     * Determine whether the user can update the require feedback.
     *
     * @param  \App\Models\User  $user
     * @param  \App\RequireFeedback  $requireFeedback
     * @return mixed
     */
    public function update(User $user, RequireFeedback $requireFeedback)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the require feedback.
     *
     * @param  \App\Models\User  $user
     * @param  \App\RequireFeedback  $requireFeedback
     * @return mixed
     */
    public function delete(User $user, RequireFeedback $requireFeedback)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the require feedback.
     *
     * @param  \App\Models\User  $user
     * @param  \App\RequireFeedback  $requireFeedback
     * @return mixed
     */
    public function restore(User $user, RequireFeedback $requireFeedback)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the require feedback.
     *
     * @param  \App\Models\User  $user
     * @param  \App\RequireFeedback  $requireFeedback
     * @return mixed
     */
    public function forceDelete(User $user, RequireFeedback $requireFeedback)
    {
        //
        return true; // TODO add valid conditions
    }
}

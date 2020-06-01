<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentSettingPolicy
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
     * Determine whether the user can view any student settings.
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
     * Determine whether the user can view the student setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\StudentSetting  $studentSetting
     * @return mixed
     */
    public function view(User $user, StudentSetting $studentSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create student settings.
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
     * Determine whether the user can update the student setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\StudentSetting  $studentSetting
     * @return mixed
     */
    public function update(User $user, StudentSetting $studentSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the student setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\StudentSetting  $studentSetting
     * @return mixed
     */
    public function delete(User $user, StudentSetting $studentSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the student setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\StudentSetting  $studentSetting
     * @return mixed
     */
    public function restore(User $user, StudentSetting $studentSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the student setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\StudentSetting  $studentSetting
     * @return mixed
     */
    public function forceDelete(User $user, StudentSetting $studentSetting)
    {
        //
        return true; // TODO add valid conditions
    }
}

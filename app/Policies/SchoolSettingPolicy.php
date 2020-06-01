<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SchoolSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolSettingPolicy
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
     * Determine whether the user can view any school settings.
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
     * Determine whether the user can view the school setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SchoolSetting  $schoolSetting
     * @return mixed
     */
    public function view(User $user, SchoolSetting $schoolSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create school settings.
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
     * Determine whether the user can update the school setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SchoolSetting  $schoolSetting
     * @return mixed
     */
    public function update(User $user, SchoolSetting $schoolSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the school setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SchoolSetting  $schoolSetting
     * @return mixed
     */
    public function delete(User $user, SchoolSetting $schoolSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the school setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SchoolSetting  $schoolSetting
     * @return mixed
     */
    public function restore(User $user, SchoolSetting $schoolSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the school setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SchoolSetting  $schoolSetting
     * @return mixed
     */
    public function forceDelete(User $user, SchoolSetting $schoolSetting)
    {
        //
        return true; // TODO add valid conditions
    }
}

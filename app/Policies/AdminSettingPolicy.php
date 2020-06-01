<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AdminSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminSettingPolicy
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
     * Determine whether the user can view any admin settings.
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
     * Determine whether the user can view the admin setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AdminSetting  $adminSetting
     * @return mixed
     */
    public function view(User $user, AdminSetting $adminSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create admin settings.
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
     * Determine whether the user can update the admin setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AdminSetting  $adminSetting
     * @return mixed
     */
    public function update(User $user, AdminSetting $adminSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the admin setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AdminSetting  $adminSetting
     * @return mixed
     */
    public function delete(User $user, AdminSetting $adminSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the admin setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AdminSetting  $adminSetting
     * @return mixed
     */
    public function restore(User $user, AdminSetting $adminSetting)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the admin setting.
     *
     * @param  \App\Models\User  $user
     * @param  \App\AdminSetting  $adminSetting
     * @return mixed
     */
    public function forceDelete(User $user, AdminSetting $adminSetting)
    {
        return true; // TODO add valid conditions
    }
}

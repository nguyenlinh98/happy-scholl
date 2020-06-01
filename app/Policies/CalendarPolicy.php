<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Calendar;
use Illuminate\Auth\Access\HandlesAuthorization;

class CalendarPolicy
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
     * Determine whether the user can view any calendars.
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
     * Determine whether the user can view the calendar.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Calendar  $calendar
     * @return mixed
     */
    public function view(User $user, Calendar $calendar)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can create calendars.
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
     * Determine whether the user can update the calendar.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Calendar  $calendar
     * @return mixed
     */
    public function update(User $user, Calendar $calendar)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can delete the calendar.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Calendar  $calendar
     * @return mixed
     */
    public function delete(User $user, Calendar $calendar)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can restore the calendar.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Calendar  $calendar
     * @return mixed
     */
    public function restore(User $user, Calendar $calendar)
    {
        //
        return true; // TODO add valid conditions
    }

    /**
     * Determine whether the user can permanently delete the calendar.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Calendar  $calendar
     * @return mixed
     */
    public function forceDelete(User $user, Calendar $calendar)
    {
        //
        return true; // TODO add valid conditions
    }
}

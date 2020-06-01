<?php

namespace App\Models;

use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class SchoolAdmin extends User
{
    use Notifiable;
    use SchoolScopeTrait;
    use HasRelationships;

    const ROLE_IDENTITY = 'school_admin';

    const ACTIVE = 1;

    protected $table = 'users';

    protected $guard = 'schooladmin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'role_id', 'activate', 'school_id', 'school_login_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->role_id = $model->getRolesId();

            return $model;
        });

        static::addGlobalScope('school_admin', function (Builder $builder) {
            $parent = new self();
            $builder->where('role_id', $parent->getRolesId());
        });
    }

    /**
     * Function to load all accessible calendar in school for school Admin
     * from School where `id` equal current admin `school_id`
     * from SchoolClass where `school_id` equal current admin `school_id`
     * from Departments where `school_id` equal current admin `school_id`
     * from Calendar where calendar type equal 'hsp'.
     */
    public function accessibleCalendars()
    {
        return Calendar::where('type', 'hsp')
            ->orWhereRaw('calendars.id IN (SELECT schools.calendar_id FROM schools WHERE schools.id = ? GROUP BY schools.calendar_id)', [$this->school_id])
            ->orWhereRaw('calendars.id IN (SELECT school_classes.calendar_id FROM school_classes WHERE school_classes.school_id = ? GROUP BY school_classes.calendar_id)', [$this->school_id])
            ->orWhereRaw('calendars.id IN (SELECT departments.calendar_id FROM departments WHERE departments.school_id = ? GROUP BY departments.calendar_id)', [$this->school_id]);
    }

    /**
     * Make new Teacher instance from request input and save to database.
     * Extract password and hashing it before saving.
     *
     * @param $data Extracted from $request
     *
     * @version 1.0.0
     */
    public function makeFromRequest(array $data)
    {
        $this->fill($data);
        $this->password = Hash::make($data['password']);
        $this->save();
    }

    /**
     * Combine first_name and last_name field to long name.
     *
     * @return string
     *
     * @version 1.0.0
     */
    public function getNameAttribute()
    {
        return "{$this->name}";
    }

    public function isSchoolAdmin()
    {
        return true;
    }

    public function isTopAdmin()
    {
        return false;
    }

    private function getRolesId()
    {
        $role = Role::where('name', self::ROLE_IDENTITY)->first();
        if (!isset($role->id)) {
            return 0;
        }

        return $role->id;
    }
}

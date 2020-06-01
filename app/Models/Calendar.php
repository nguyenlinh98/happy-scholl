<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Calendar extends Model
{
    use HasRelationships;
    // use SoftDeletes;

    protected $fillable = [
        'name',
        'school_id',
        'event_bgcolor',
    ];
    const TYPE_CALENDAR_HSP = 'hsp';

    const TYPE_CALENDAR_SCHOOL_CLASS = 'class';

    const TYPE_CALENDAR_DEPARTMENT = 'department';

    const TYPE_CALENDAR_SCHOOL = 'school';

    const TYPE_CALENDAR_PARENT = 'user';

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get users in calendar, based on calendar type.
     *
     * !important: never call this relationship by Eloquent 'with' helpers on jobs
     */
    public function users()
    {
        if ($this->type === static::TYPE_CALENDAR_SCHOOL_CLASS) {
            return $this->schoolClassUsersRelation();
        }

        if ($this->type === static::TYPE_CALENDAR_DEPARTMENT) {
            return $this->departmentUsersRelation();
        }

        if ($this->type === static::TYPE_CALENDAR_SCHOOL) {
            return $this->schoolUsersRelation();
        }
        if ($this->type === static::TYPE_CALENDAR_PARENT) {
            return $this->hasMany(User::class, 'calendar_id');
        }

        return collect();
    }

    /**
     * Deep loading users on SchoolClass Model has this calendar
     * relation route Calendar -> hasMany SchoolClass -> hasMany Student -> hasMany Parents.
     */
    public function schoolClassUsersRelation()
    {
        return $this->hasManyDeep(Parents::class,
        [
            SchoolClass::class, Student::class, ParentStudent::class,
        ],
        [
            'calendar_id', 'school_class_id', 'student_id', 'id',
        ],
        [
            'id', 'id', 'id', 'user_id',
        ])->distinct();
    }

    /**
     * Deep loading users on SchoolClass Model has this calendar
     * relation route Calendar -> hasMany Department -> hasMany Student -> hasMany Parents.
     */
    public function departmentUsersRelation()
    {
        return $this->hasManyDeep(Parents::class,
        [
            Department::class, 'department_students', Student::class, ParentStudent::class,
        ],
        [
            'calendar_id', 'department_id', 'student_id', 'id',
        ],
        [
            'id', 'id', 'id', 'user_id',
        ])->distinct();
    }

    /**
     * Deep loading student's parents[users] who is a student of School with calendar_id equal this calendar id;
     * relation route Calendar -> hasOne School -> hasMany Student -> hasMany Parents.
     */
    public function schoolUsersRelation()
    {
        return $this->hasManyDeep(Parents::class,
        [
            School::class, Student::class, ParentStudent::class,
        ],
        [
            'calendar_id', 'school_id', 'student_id', 'id',
        ],
        [
           'id', 'id', 'id', 'user_id',
        ])->distinct();
    }

    /**
     * Make Calendar instance named 'default' for newly created school.
     *
     * @version 1.0.0
     */
    public static function generate(string $name, int $school_id, string $class = '')
    {
        $calendar = new self();
        $calendar->name = $name ?: config('app.calendar.default', 'Default');
        $calendar->school_id = $school_id;
        $calendar->event_bgcolor = 'blue';
        $calendar->type = '' === $class ? config('app.calendar.type', 'default') : Str::lower(Str::singular(class_basename($class)));
        $calendar->save();

        return $calendar;
    }
}

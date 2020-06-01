<?php

namespace App\Models;

use App\Traits\Models\PreparableModel;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    // use SoftDeletes;
    use PreparableModel;
    protected $fillable = [
        'name', 'namekana', 'postcode', 'prefectures', 'address', 'representative_emails', 'tel', 'domain', 'issue_date',
    ];
    protected $with = [
        'setting',
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            SchoolSetting::generate($model->id);
            $calendar = Calendar::generate($model->name, $model->id, self::class);
            $model->calendar_id = $calendar->id;
            $model->save();
            RecyclePlace::generate($model->id);
        });
    }

    /*************************************************/
    /*** RELATIONSHIPS *******************************/
    /*************************************************/
    public function setting()
    {
        return $this->hasOne(SchoolSetting::class, 'school_id');
    }

    public function student()
    {
        return $this->hasManyThrough(
            Student::class,
            SchoolClass::class,
            'school_id',
            'school_class_id'
        );
    }

    public function schoolClasses()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function classGroups()
    {
        return $this->hasMany(ClassGroup::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function schoolPasscode()
    {
        return $this->hasOne(SchoolPasscode::class);
    }

    public function recyclePlaces()
    {
        return $this->hasMany(RecyclePlace::class);
    }

    /*************************************************/
    /*** END RELATIONSHIPS ***************************/
    /*************************************************/

    public function getCalendarsForEventsArray()
    {
        return Calendar::where('school_id', $this->id)->where('type', '<>', 'user')->get()->mapWithKeys(function ($item) {
            return [$item->id => $item->name];
        });
    }

    public function getSchoolClassesAttribute()
    {
        $this->loadMissing('schoolClasses');

        return $this->getRelation('schoolClasses');
    }

    public function getClassGroupsAttribute()
    {
        $this->loadMissing('classGroups');

        return $this->getRelation('classGroups');
    }
}

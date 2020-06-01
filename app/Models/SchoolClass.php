<?php

namespace App\Models;

use App\Traits\Models\PreparableModel;
use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class SchoolClass extends Model
{
    use PreparableModel;
    use HasRelationships;
    // use SoftDeletes;
    use Notifiable;
    use SchoolScopeTrait;

    protected $fillable = [
        'name',
    ];

    public static function boot()
    {
        parent::boot();
    }

    /**
     *  Save SchoolClass instance to database based on information from request.
     *
     * @version 1.0.0
     */
    public function make(array $data)
    {
        $this->name = $data['name'];
        $this->save();
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'school_class_id');
    }

    public function parents()
    {
        return $this->hasManyDeep(
            User::class,
            [Student::class, 'parent_students'],
            ['school_class_id', 'student_id', 'id'],
            [null, 'id', 'user_id']
        )->distinct();
    }

    public function managers()
    {
        return $this->morphMany(SchoolAdminManage::class, 'manage');
    }

    public function todayAttendances()
    {
        return $this->hasManyThrough(Attendance::class, Student::class)->whereDate('attendances.created_at', today());
    }

    public function homeroomTeachers()
    {
        return $this->hasManyDeep(
            Teacher::class,
            [SchoolAdminManage::class],
            ['manage_id', null, 'id'],
            [
                null, null, 'user_id',
            ]
        )->where('school_admin_manages.class_teacher', 1);
    }

    public function scopeHasHomeroomTeachers()
    {
        return $this->whereHas('managers', function ($query) {
            $query->where('class_teacher', true);
        })->with('managers.teacher');
    }
}

<?php

namespace App\Models;

use App\Traits\Models\PreparableModel;
use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;

class Student extends Model
{
    // use SoftDeletes;

    //Add relationships if need
    use PreparableModel;
    use SchoolScopeTrait;
    protected $table = 'students';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $fillable = [
        'name', 'first_name', 'last_name',
        'school_class_id', 'avatar', 'gender',
    ];
    protected $with = ['class', 'parents'];

    const GENDER_BOY = 1;
    const GENDER_GIRL = 0;

    /**************************
     * RELATIONSHIPS **********
     **************************/
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function schoolClass()
    {
        return $this->belongsTo(
            SchoolClass::class,
            'school_class_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parentStudent()
    {
        return $this->hasOne(ParentStudent::class);
    }

    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'department_students',
            'student_id',
            'department_id'
        );
    }

    public function contact()
    {
        return $this->hasMany(Contact::class, 'student_id');
    }

    public function todayAttendance()
    {
        return $this->hasOne(Attendance::class)->whereDate('created_at', now())->latest();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function parents()
    {
        return $this->hasManyThrough(Parents::class, ParentStudent::class, 'student_id', 'id', 'id', 'user_id');
    }

    /**************************
     * END RELATIONSHIPS ******
     **************************/

    /**
     * @param $user_id
     *
     * @return mixed
     */
    public function getStudentByUser($user_id)
    {
        return $this->where('user_id', $user_id)->get();
    }

    public function getStudentBySchoolClass($schoolClassId)
    {
        return $this->where('school_class_id', $schoolClassId)->get();
    }

    public function sortStudentByName($schoolClassId, $sort = 'desc')
    {
        return $this->where('school_class_id', $schoolClassId)->orderBy('name', $sort)->get();
    }

    public function sortStudentByNameHasContact($schoolClassId, $sort = 'desc')
    {
        return $this->where('school_class_id', $schoolClassId)->whereHas('contact')->orderBy('name', $sort)->get();
    }

    public function getHasParentsAttribute()
    {
        if ($this->relationLoaded('parents')) {
            return filled($this->getRelationValue('parents'));
        }

        return true === $this->parent()->exists();
    }

    public function getRegistrationStatusAttribute()
    {
        return $this->hasParents;
    }

    /**
     * Process uploaded excels file.
     *
     * @version 1.0.0
     */
    public static function importCSV(UploadedFile $uploadedFile)
    {
    }
}

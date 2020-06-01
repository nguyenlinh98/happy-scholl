<?php

namespace App\Models;

use App\Traits\Models\DepartmentSettingTrait;
use App\Traits\Models\HasClassDepartmentGroupRelationshipTrait;
use App\Traits\Models\LocalizeDateTimeTrait;
use App\Traits\Models\PreparableModel;
use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Department extends Model
{
    // use SoftDeletes;
    use PreparableModel;
    use DepartmentSettingTrait;
    use SchoolScopeTrait;
    use LocalizeDateTimeTrait;
    use HasClassDepartmentGroupRelationshipTrait;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $fillable = [
        'name',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $calendar = Calendar::generate($model->name.'のカレンダー', hsp_school()->id, self::class);
            $model->calendar_id = $calendar->id;
        });
    }

    //Add relationships if need
    // public function classes()
    // {
    //     return $this->hasMany(DepartmentClass::class, 'department_id');
    // }


    public function managers()
    {
        return $this->morphMany(SchoolAdminManage::class, 'manage');
    }

    //Add relationships if need

    public function getListDepartmentBySchool($schoolId)
    {
        return $this->where('school_id', $schoolId)->get();
    }

    public function getDisplayOrderSchoolClass($schoolId)
    {
    }

    public function confirm()
    {
        $this->confirmClassDepartmentGroupRelationship('department_setting_', true);

        $this->name = request()->input('name');
        // $this->department_setting_select = request()->input('department_setting_select');
        // hsp_debug($this->department_setting_school_classes);
    }

    public function createFromRequest(Request $request, $schoolId)
    {
        $this->name = $request->name;
        $this->school_id = $schoolId;
        $this->save();
        // $this->classesSync(SchoolClass::class, $request->department_setting_school_classes, 'classes', 'department_id');
    }

    public function updateFromRequest(Request $request)
    {
        $this->name = $request->name;

        $this->save();
        // $this->classesSync(SchoolClass::class, $request->department_setting_school_classes, 'classes', 'department_id');
    }

    public function prepareForEdit()
    {
        $this->prepare();

        if (is_null(old('_token'))) {
            session()->flash('_old_input', null);
            // session(['_old_input.department_setting_school_classes' => $this->classes->pluck('id')->toArray()]);
        }
    }

    public function scopeWithManagers()
    {
        return $this->whereHas('managers')->with('managers.teacher');
    }
}

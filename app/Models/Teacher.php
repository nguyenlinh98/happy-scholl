<?php

namespace App\Models;

use App\Traits\Models\HasClassDepartmentGroupRelationshipTrait;
use App\Traits\Models\PreparableModel;
use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Teacher extends User
{
    use PreparableModel;
    use HasClassDepartmentGroupRelationshipTrait;
    // use SchoolScopeTrait;
    use HasRelationships;
    const ROLE_IDENTITY = 'teacher';

    protected $table = 'users';

    protected $fillable = [
        'name',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $role = cache()->remember('hsp_role_'.static::ROLE_IDENTITY, 10, function () {
                return Role::where('name', static::ROLE_IDENTITY)->first();
            });
            $model->role_id = $role->id;

            $calendar = new Calendar();
            $calendar->name = $model->email;
            $calendar->school_id = hsp_school()->id;
            $calendar->event_bgcolor = '#FFF';
            $calendar->save();

            $model->calendar_id = $calendar->id;
        });
        static::addGlobalScope('teacher', function (Builder $builder) {
            // limit query for users with teacher role only
            $builder->whereHas('role', function ($query) {
                $query->where('name', self::ROLE_IDENTITY);
            });
        });
    }

    /**
     * Morphed object relation this teacher is in charge of.
     */
    public function manages()
    {
        return $this->hasMany(SchoolAdminManage::class, 'user_id');
    }

    /**
     * Relation loading all classes this teacher is in charge of.
     */
    public function schoolClasses()
    {
        return $this->hasManyDeep(
            SchoolClass::class,
            [SchoolAdminManage::class],
            ['user_id', 'id'],
            [null,  ['manage_type', 'manage_id']]
        );
    }

    /**
     * Scope for homeroom teachers.
     */
    public function scopeHomeroom(Builder $builder)
    {
        return $builder->whereHas('manages', function ($query) {
            return $query->where('class_teacher', true);
        })->with('schoolClasses');
    }

    /**
     * Scope for teachers who is not responsible to manage.
     */
    public function scopeFree(Builder $builder)
    {
        return $builder->doesntHave('manages');
    }

    /**
     * Create new Teacher instance from request input and save to database.
     * Extract password and hashing it before saving.
     *
     * @version 2.0.0
     */
    public function createFromRequest(Request $request)
    {
        $mockTeacher = factory(User::class)->make();

        $this->fill($request->only($this->fillable));
        $this->email = $mockTeacher->email;
        $this->password = Hash::make('password');
        $this->activate = 1;
        $this->save();

        $this->processResponsibilities();
    }

    /**
     * Update Teacher instance from request input and save to database.
     *
     * @param $data Extracted from $request
     *
     * @version 1.0.0
     */
    public function updateFromRequest(Request $request)
    {
        $this->fill($request->only($this->fillable));
        $this->processResponsibilities();
        $this->save();
    }

    /**
     * Preload data for confirm page.
     */
    public function prepareForConfirm()
    {
        $this->fill(request()->only($this->fillable));
        $this->confirmClassDepartmentGroupRelationship('responsibility_');
        $this->is_homeroom_teacher = 'yes' === request()->input('homeroom');
        $this->responsibility_select = request('responsibility_select');
    }

    /**
     * Preload data for edit page.
     */
    public function prepareForEdit()
    {
        $this->prepare();
        if (null === old('_token')) {
            $this->prepareClassDepartmentGroupRelationship('manages', 'responsibility_', 'manage');

            session(['_old_input.homeroom' => $this->has_homeroom_responsibility ? 'yes' : null]);
        }
    }

    public function getHasHomeroomResponsibilityAttribute()
    {
        $this->loadMissing('manages');

        return $this->manages->sum('class_teacher') > 0;
    }

    /**
     * Check all responsibility and creating record if found.
     */
    private function processResponsibilities()
    {
        $this->processClassDepartmentGroupRelationship('manages', SchoolAdminManage::class, 'manage', 'responsibility_');
    }
}

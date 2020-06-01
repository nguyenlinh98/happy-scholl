<?php

namespace App\Models;

use App\Traits\Models\HasClassDepartmentGroupRelationshipTrait;
use App\Traits\Models\PreparableModel;
use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class ClassGroup extends Model
{
    use PreparableModel;
    // use SoftDeletes;
    use SchoolScopeTrait;
    use HasClassDepartmentGroupRelationshipTrait;
    protected $fillable = [
        'name',
    ];

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_group_members', 'class_group_id', 'school_class_id');
    }

    public function confirm()
    {
        $this->confirmClassDepartmentGroupRelationship('class_group_selection_', true);

        $this->name = request()->input('name');
        $this->class_group_selection_select = request()->input('class_group_selection_select');
    }

    public function createFromRequest(Request $request)
    {
        $this->name = $request->name;
        $this->save();
        $this->classes()->sync($request->input('class_group_selection_school_classes'));
    }

    public function updateFromRequest(Request $request)
    {
        $this->name = $request->name;
        $this->save();
        $this->classes()->sync($request->input('class_group_selection_school_classes'));
    }

    public function prepareForEdit()
    {
        hsp_debug($this->toArray());

        $this->prepare();
        if (is_null(old('_token'))) {
            session()->flash('_old_input', null);
            session(['_old_input.class_group_selection_school_classes' => $this->classes->pluck('id')->toArray()]);
        }
    }

    /**
     * Determize school_id for query scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfSchoolId($query, $school_id)
    {
        return $query->where('school_id', $school_id);
    }
}

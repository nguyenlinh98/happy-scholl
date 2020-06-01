<?php

namespace App\Models;

use App\Traits\Models\HasClassDepartmentGroupRelationshipTrait;
use App\Traits\Models\HasImagesTrait;
use App\Traits\Models\LocalizeDateTimeTrait;
use App\Traits\Models\PreparableModel;
use App\Traits\Models\SchoolScopeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SchoolEvent extends Model
{
    use SchoolScopeTrait;
    use HasImagesTrait;
    use PreparableModel;
    use LocalizeDateTimeTrait;
    use HasClassDepartmentGroupRelationshipTrait;

    const TOTAL_IMAGES = 3;
    const STATUS_RESERVATION = 0;
    const STATUS_DISTRIBUTED = 1;
    protected $fillable = [
        'subject',
        'body',
        'max_people',
        'reason',
        'max_help_people',
        'sender',
        'tel',
        'email',
    ];

    public function schoolClasses()
    {
        return $this->morphedByMany(SchoolClass::class, 'receiver', 'school_events_receivers')->withPivot(['school_id']);
    }

    /**
     * Mapping schoolClasses id with current school_id of user
     * return [["'schoolCLassId'" => ["school_id" => "'current_user_school_id'"],].
     *
     * @version 1.0.0
     *
     * @return Illuminate\Support\Collection;
     */
    private function getSchoolClassesWithSchoolId(array $schoolClassIds = [])
    {
        $school_id = $this->exists ? $this->school_id : auth()->user()->school_id;

        return collect($schoolClassIds)->mapWithKeys(function ($schoolClassId) use ($school_id) {
            return [$schoolClassId => ['school_id' => $school_id]];
        });
    }

    public function confirm(Request $request)
    {
        $this->confirmClassDepartmentGroupRelationship('school_event_for_', true);
        $this->fill($request->only($this->fillable));
        $this->confirmImages = $this->prepareImageForConfirm($request, 'images');

        $this->scheduled_at = $this->parseFromLocalizeDateTime("{$request->scheduled_date} {$request->scheduled_time}");
        $this->deadline_at = $this->parseFromLocalizeDateTime("{$request->deadline_date}");
        $this->scheduled_date = $request->scheduled_date;
        $this->scheduled_time = $request->scheduled_time;
        $this->deadline_date = $request->deadline_date;
        $this->need_help = 'on' === $request->input('enable_help');

        $this->school_event_for_select = $request->school_event_for_select;

        if ($this->need_help) {
            // two function from LocalizeDateTimeTrait;
            $this->help_scheduled_at = $this->parseFromLocalizeDateTime("{$request->help_scheduled_date} {$request->help_scheduled_time}");
            $this->help_scheduled_date = $request->help_scheduled_date;
            $this->help_scheduled_time = $request->help_scheduled_time;
            $this->help_deadline_at = $this->parseFromLocalizeDateTime($request->help_deadline_date);
            $this->help_deadline_date = $request->help_deadline_date;
        } else {
            // reset help fields
            $this->reason = null;
            $this->help_scheduled_at = null;
            $this->help_deadline_at = null;
            $this->max_help_people = null;
        }
    }

    public function makeFromRequest(Request $request)
    {
        $this->fill($request->only($this->fillable));
        $this->scheduled_at = $this->parseFromLocalizeDateTime("{$request->scheduled_date} {$request->scheduled_time}");
        $this->deadline_at = $this->parseFromLocalizeDateTime("{$request->deadline_date}");
        $this->status = static::STATUS_RESERVATION;
        $this->need_help = 'on' === $request->input('enable_help');

        if ($this->need_help) {
            // two function from LocalizeDateTimeTrait;
            $this->help_scheduled_at = $this->parseFromLocalizeDateTime("{$request->help_scheduled_date} {$request->help_scheduled_time}");
            $this->help_deadline_at = $this->parseFromLocalizeDateTime($request->help_deadline_date);
        } else {
            // reset help fields
            $this->reason = '';
            $this->help_scheduled_at = null;
            $this->help_deadline_at = null;
            $this->max_help_people = 0;
        }
    }

    public function createNew(Request $request)
    {
        $this->makeFromRequest($request);
        $this->save();
        // create many-to-many morphed relation
        $schoolClassesData = $this->getSchoolClassesWithSchoolId($request->input('school_event_for_school_classes'));
        $this->schoolClasses()->attach($schoolClassesData);
        $this->saveImages($request, 'images_paths');
        $this->save();
    }

    public function updateFrom(Request $request)
    {
        $this->makeFromRequest($request);
        if ($request->filled('images_paths')) {
            $this->deleteImages();
            $this->saveImages($request, 'images_paths');
        }

        $this->save();

        $schoolClassesData = $this->getSchoolClassesWithSchoolId($request->input('school_event_for_school_classes'));
        $this->schoolClasses()->sync($schoolClassesData);
    }

    public function prepareForEdit()
    {
        if (is_null(old('_token'))) {
            $this->prepareSimpleClassDepartmentGroupRelationship('schoolClasses', 'school_event_for_', 'school_classes');
        }
    }

    // Getters

    public function getScheduledAtAttribute()
    {
        if (!$this->scheduled_at_cache) {
            $this->scheduled_at_cache = Carbon::parse($this->attributes['scheduled_at']);
        }

        return $this->scheduled_at_cache;
    }

    public function getHelpScheduledAtAttribute()
    {
        if (!$this->help_scheduled_at_cache) {
            $this->help_scheduled_at_cache = Carbon::parse($this->attributes['help_scheduled_at']);
        }

        return $this->help_scheduled_at_cache;

        return Carbon::parse($this->attributes['help_scheduled_at']);
    }

    public function getDeadlineAtAttribute()
    {
        if (!$this->deadline_at_cache) {
            $this->deadline_at_cache = Carbon::parse($this->attributes['deadline_at']);
        }

        return $this->deadline_at_cache;
    }

    public function getHelpDeadlineAtAttribute()
    {
        if (!$this->help_deadline_at_cache) {
            $this->help_deadline_at_cache = Carbon::parse($this->attributes['help_deadline_at']);
        }

        return $this->help_deadline_at_cache;
    }
}

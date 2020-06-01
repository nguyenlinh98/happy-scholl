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
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use DB;
class Seminar extends Model
{
    use LocalizeDateTimeTrait;
    use SchoolScopeTrait;
    use HasRelationships;
    use PreparableModel;
    use HasClassDepartmentGroupRelationshipTrait;
    use HasImagesTrait;

    const STATUS_RESERVATION = 0;
    const STATUS_DISTRIBUTED = 1;
    const TOTAL_IMAGES = 3;

    protected $fillable = [
        'subject',
        'body',
        'max_people',
        'reason',
        'max_help_people',
        'sender',
        'tel',
        'help_tel',
        'instructor',
        'fee',
        'address',
    ];

    public function schoolClasses()
    {
        return $this->morphedByMany(SchoolClass::class, 'receiver', 'seminar_receivers')->withPivot(['school_id']);
    }

    public function students()
    {
        return $this->hasManyDeep(
            Student::class,
            ['seminar_receivers', SchoolClass::class],
            [null, 'id'],
            [null, ['receiver_type', 'receiver_id']]
        );
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
            $this->reason = null;
            $this->help_scheduled_at = null;
            $this->help_deadline_at = null;
            $this->max_help_people = null;
        }
    }

    public function confirm(Request $request)
    {
        $this->confirmClassDepartmentGroupRelationship('seminar_for_', true);
        $this->fill($request->only($this->fillable));
        $this->confirmImages = $this->prepareImageForConfirm($request, 'images');

        $this->scheduled_at = $this->parseFromLocalizeDateTime("{$request->scheduled_date} {$request->scheduled_time}");
        $this->deadline_at = $this->parseFromLocalizeDateTime("{$request->deadline_date}");
        $this->scheduled_date = $request->scheduled_date;
        $this->scheduled_time = $request->scheduled_time;
        $this->deadline_date = $request->deadline_date;
        $this->need_help = 'on' === $request->input('enable_help');

        $this->seminar_for_select = $request->seminar_for_select;

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

    public function createNew(Request $request)
    {
        $this->makeFromRequest($request);
        $this->save();
        // create many-to-many morphed relation
        $schoolClassesData = $this->getSchoolClassesWithSchoolId($request->input('seminar_for_school_classes'));
        $this->schoolClasses()->attach($schoolClassesData);
        $this->saveImages($request, 'images_paths');
        $this->save();
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

    public function updateFrom(Request $request)
    {
        $this->makeFromRequest($request);
        if ($request->filled('images_paths')) {
            $this->deleteImages();
            $this->saveImages($request, 'images_paths');
        }

        $this->save();

        $schoolClassesData = $this->getSchoolClassesWithSchoolId($request->input('seminar_for_school_classes'));
        $this->schoolClasses()->sync($schoolClassesData);
    }

    public function prepareForEdit()
    {
        if (is_null(old('_token'))) {
            $this->prepareSimpleClassDepartmentGroupRelationship('schoolClasses', 'seminar_for_', 'school_classes');
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

    // code for Front-end
    public static function getSeminarBySchool($school_id)
    {
        return Seminar::where('school_id', $school_id)->orderBy('start_time', 'ASC')->get();
    }

    public static function getSeminarByDay($school_id, $date=null)
    {
        $rs = Seminar::where('school_id', $school_id)->whereDate('start_time', $date)
              ->orderBy('start_time', 'ASC')->get();
        return $rs;
    }

    public static function countUserApplySeminar($seminar_id)
    {
        return SeminarStatus::where('apply_status', SeminarStatus::APPLY_STATUS_APPLY)
                ->where('seminar_id',$seminar_id)->count();
    }

    public static function countUserHelpSeminar($seminar_id)
    {
        return SeminarStatus::where('apply_type', SeminarStatus::APPLY_TYPE_SEMINAR_HELP)
            ->where('seminar_id',$seminar_id)->count();
    }

    public function seminarStatus()
    {
        return $this->hasMany(SeminarStatus::class, 'seminar_id');
    }

    public function getImageUrl()
    {
        $urls = [];
        for ($idx = 1; $idx <= 3; ++$idx) {
            $attribute = "image$idx";
            if (!$this->$attribute) {
                continue;
            }
            $urls[] = asset('storage/uploads/'.$this->getTable().'/'.$this->id.'/'.'images/'.$this->$attribute);
        }
        return $urls;
    }
}
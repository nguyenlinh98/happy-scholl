<?php

namespace App\Models;

use App\Jobs\RequireFeedback\DistributingRequireFeedbackJob;
use App\Traits\Models\HasClassDepartmentGroupRelationshipTrait;
use App\Traits\Models\HasReceiverTrait;
use App\Traits\Models\LocalizeDateTimeTrait;
use App\Traits\Models\PreparableModel;
use App\Traits\Models\SchoolScopeTrait;
use BadMethodCallException;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class RequireFeedback extends Model
{
    // use SoftDeletes;
    use LocalizeDateTimeTrait;
    use SchoolScopeTrait;
    use HasReceiverTrait;
    use HasRelationships;
    use HasClassDepartmentGroupRelationshipTrait;
    use PreparableModel {
        prepare as prepareTrait;
    }
    const STATUS_NOT_YET = 0;
    const STATUS_DISTRIBUTED = 2;
    const STATUS_CLEANED = 3;
    protected $table = 'require_feedbacks';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $fillable = [
        'subject',
        'body',
        'sender',
        'deadline',
        'clean_up_at',
    ];

    protected $casts = [
        'deadline' => 'date:Y-m-d',
        'clean_up_at' => 'date:Y-m-d',
        'scheduled_at' => 'datetime',
    ];

    protected $withCount = [
        'receivers',
    ];

    //Add relationships if need

    public function receivers()
    {
        return $this->hasMany(RequireFeedbacksReceiver::class, 'require_feedback_id');
    }

    public function statuses()
    {
        return $this->hasMany(RequireFeedbackStatuses::class, 'require_feedback_id');
    }

    /**
     * Eager loading students using hasManyDeep package.
     *
     * @version 1.0.0
     */
    public function students()
    {
        return $this->hasManyDeep(
            Student::class,
            [RequireFeedbacksReceiver::class, SchoolClass::class],
            ['require_feedback_id', 'id', 'school_class_id'],
            ['id', 'receiver_id', 'id']
        );
    }

    /**
     * Prepare value for creating or editing instance.
     */
    public function prepare()
    {
        $this->prepareTrait([
            'scheduled_date' => old('scheduled_date', $this->scheduled_at ? $this->scheduled_at->format('Y-m-d') : now()->format('Y-m-d')),
            'scheduled_time' => old('scheduled_time', $this->scheduled_at ? $this->scheduled_at->format('H:i') : ''),
            'deadline_date' => Carbon::parse(old('deadline_date', $this->deadline ?: now())),
            'clean_up_date' => Carbon::parse(old('clean_up_date', $this->clean_up_at ?: now())),
        ]);
    }

    /**
     * Prepare instance for confirmation.
     */
    public function prepareToConfirm(Request $request)
    {
        $this->fill($request->only($this->fillable));
        $date = empty($request->input('scheduled_date')) ? date("Y-m-d") : $request->input('scheduled_date');
        $time = empty($request->input('scheduled_time')) ? date("H:i:s") : $request->input('scheduled_time');
        if ($request->checkDateSetting == 1) {
            $this->scheduled_at = now();
        } else {
            $this->scheduled_at = $this->parseFromLocalizeDateTime($date . ' ' . $time);
        }
        $this->confirmClassDepartmentGroupRelationship('required_feedback_for_', true);
        $this->required_feedback_for_select = request()->required_feedback_for_select;
        $this->deadline_at = Carbon::parse($request->input('deadline_date'));
        $this->clean_up_at = Carbon::parse($request->input('clean_up_date'));
    }

    public function createFromRequest(Request $request, $schoolId)
    {
        $this->fill($request->only($this->fillable));
        $this->school_id = $schoolId;
        $date = empty($request->input('scheduled_date')) ? date("Y-m-d") : $request->input('scheduled_date');
        $time = empty($request->input('scheduled_time')) ? date("H:i:s") : $request->input('scheduled_time');
        if ($request->checkDateSetting == 1) {
            $this->scheduled_at = now();
        } else {
            $this->scheduled_at = $this->parseFromLocalizeDateTime($date . ' ' . $time);
        }
        $this->deadline = $request->deadline_date;
        $this->clean_up_at = $request->clean_up_date;
        $this->status = static::STATUS_NOT_YET;
        $this->save();

        $this->processClassDepartmentGroupRelationship('receivers', RequireFeedbacksReceiver::class, 'receiver', 'required_feedback_for_', true);

        $this->shouldDispatchNotification();
    }

    public function updateFromRequest(Request $request)
    {
        $this->fill($request->only($this->fillable));
        $date = empty($request->input('scheduled_date')) ? date("Y-m-d") : $request->input('scheduled_date');
        $time = empty($request->input('scheduled_time')) ? date("H:i:s") : $request->input('scheduled_time');
        if ($request->checkDateSetting == 1) {
            $this->scheduled_at = now();
        } else {
            $this->scheduled_at = $this->parseFromLocalizeDateTime($date . ' ' . $time);
        }
        $this->deadline = $request->deadline_date;
        $this->clean_up_at = $request->clean_up_date;

        $this->save();

        $this->processClassDepartmentGroupRelationship('receivers', RequireFeedbacksReceiver::class, 'receiver', 'required_feedback_for_', true);
    }

    /**
     * Change status to distributed stage.
     *
     * @version 1.0.0
     */
    public function markAsDistributed()
    {
        try {
            $this->status = static::STATUS_DISTRIBUTED;
            throw_unless($this->save(), Exception::class, 'Model update failed');
        } catch (Exception $e) {
            report($e);
        }
    }

    /**
     * Change status to cleaned stage.
     *
     * @version 1.0.0
     */
    public function markAsCleaned()
    {
        try {
            $this->status = static::STATUS_CLEANED;
            throw_unless($this->save(), Exception::class, 'Model update failed');
        } catch (Exception $e) {
            report($e);
        }
    }

    /**
     * Clean up feedback's responses.
     *
     * @version 1.0.0
     */
    public function cleaningResponse()
    {
        throw_if($this->clean_up_at->greaterThanOrEqualTo(today()), BadMethodCallException::class, 'Clean up time still not up yet');
        // one simple line
        $this->statuses()->forceDelete();

        $this->markAsCleaned();
    }

    /**
     * get receiver type
     * return localized text.
     */
    public function getReceiverTypeAttribute()
    {
        return hsp_school()->school_classes_count === $this->receivers_count ? '全体' : 'クラス';
    }

    /**
     * Check if we should dispatch immediately.
     */
    private function shouldDispatchNotification()
    {
        if (now()->greaterThanOrEqualTo($this->scheduled_at)) {
            info([self::class, 'shouldDispatchNotification', 'manually dispatching notification for this letter']);
            dispatch(new DistributingRequireFeedbackJob($this));
        }
    }

    public function getReceiversListAttribute()
    {
        $this->loadMissing('receivers.receiver');

        return $this->receivers->pluck('receiver.name');
    }

    public function scopeWithStudentStatusForClass(Builder $builder, SchoolClass $schoolClass)
    {
        return $builder->with(['statuses' => function ($query) use ($schoolClass) {
            $query->whereHas('student', function ($studentQuery) use ($schoolClass) {
                $studentQuery->where('school_class_id', $schoolClass->id);
            });
        }, 'statuses.student']);
    }
}

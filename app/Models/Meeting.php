<?php

namespace App\Models;

use App\Jobs\Meeting\DistributeMeetingJob;
use App\Traits\Models\HasClassDepartmentGroupRelationshipTrait;
use App\Traits\Models\LocalizeDateTimeTrait;
use App\Traits\Models\PreparableModel;
use App\Traits\Models\SchoolScopeTrait;
use BadMethodCallException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Meeting extends Model
{
    use SchoolScopeTrait;
    use HasRelationships;
    use LocalizeDateTimeTrait;
    use PreparableModel;
    use HasClassDepartmentGroupRelationshipTrait;

    const TYPE_GROUP = 'GROUP';
    const TYPE_DEPARTMENT = 'DEPARTMENT';
    const TYPE_STUDENTS = 'INDIVIDUAL';
    const TYPE_CLASS = 'CLASS';

    const STATUS_CREATED = 0;
    const STATUS_SENT = 1;

    protected $fillable = [
        'contact_email',
        'zoom_link',
        'subject',
        'sender',
        'body',
    ];
    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function receivers()
    {
        return $this->hasMany(MeetingReceiver::class, 'meeting_id');
    }

    public function readStatuses()
    {
        return $this->hasMany(MeetingReadStatus::class, 'meeting_id');
    }

    public function studentReceivers()
    {
        return $this->morphedByMany(Student::class, 'receiver', 'meeting_receivers');
    }

    /**
     * Eager query to load read status for student in $schoolClass.
     */
    public function scopeWithStudentStatusForClass(Builder $builder, SchoolClass $schoolClass)
    {
        return $builder->with(['readStatuses' => function ($query) use ($schoolClass) {
            $query->whereHas('student', function ($studentQuery) use ($schoolClass) {
                $studentQuery->where('school_class_id', $schoolClass->id);
            });
        }, 'readStatuses.student']);
    }

    /**
     * Get students record from database based on type.
     *
     * return Eloquent Query Builder
     *
     * @version 1.0.0
     */
    public function students()
    {
        if ($this->type === static::TYPE_STUDENTS) {
            return $this->hasManyThrough(Student::class, MeetingReceiver::class, 'meeting_id', 'id', 'id', 'receiver_id');
        }
        if ($this->type === static::TYPE_GROUP) {
            return $this->hasManyDeep(
                Student::class,
                [MeetingReceiver::class, ClassGroup::class, 'class_group_members', SchoolClass::class],
                ['meeting_id', 'id', 'class_group_id', 'id', 'school_class_id'],
                [null, ['receiver_type', 'receiver_id'], 'id', 'school_class_id']
            )->distinct();
        }

        if ($this->type === static::TYPE_CLASS) {
            return $this->hasManyDeep(
                Student::class,
                [MeetingReceiver::class, SchoolClass::class],
                ['meeting_id', 'id', 'school_class_id'],
                [null, ['receiver_type', 'receiver_id'], 'id']
            )->distinct();
        }

        if ($this->type === static::TYPE_DEPARTMENT) {
            return $this->hasManyDeep(
                Student::class,
                [MeetingReceiver::class, Department::class, 'department_students'],
                ['meeting_id', 'id', 'department_id', 'id'],
                [null, ['receiver_type', 'receiver_id'], 'id', 'student_id']
            )->distinct();
        }
    }

    /**
     * Fill data for edit.
     */
    public function prepareForEdit()
    {
        $this->prepare();

        $this->date = old('date', $this->scheduled_at->format('Y-m-d'));
        $this->time = old('time', $this->scheduled_at->format('H:i'));

        if ($this->type === static::TYPE_STUDENTS) {
            if (is_null(old('individual_receivers'))) {
                $students = [];
                $this->loadMissing('receivers.receiver.class');
                foreach ($this->receivers as $receiver) {
                    $students[] = [
                        'id' => $receiver->receiver_id,
                        'value' => $receiver->receiver->name.'・'.$receiver->receiver->class->name,
                    ];
                }
                hsp_debug('individual_receivers', json_encode($students));
                $this->individual_receivers = json_encode($students);
            }
        } else {
            $this->prepareClassDepartmentGroupRelationship('receivers', 'send_to_', 'receiver');
            if (is_null(old('send_to_select'))) {
                switch ($this->type) {
                    case static::TYPE_GROUP:
                        $type = 'class_groups';

                        break;
                    case static::TYPE_DEPARTMENT:
                        $type = 'departments';

                        break;
                    case static::TYPE_CLASS:
                        $type = 'school_classes';

                        break;
                    default:
                        $type = 'school_classes';

                        break;
                }
                session(['_old_input.send_to_select' => $type]);
            }
        }
    }

    /**
     * Fill data for confirm view.
     */
    public function prepareForConfirm(Request $request)
    {
        $this->fillAttributes($request);
        $this->date = $request->input('date');
        $this->time = $request->input('time');

        if (strtolower(static::TYPE_STUDENTS) === strtolower($request->input('meeting_type'))) {
            $collection = collect(json_decode($request->input('individual_receivers')))->pluck('id');

            $this->receiversCollection = Student::whereIn('id', $collection)->get();

            $this->individual_receivers = $request->input('individual_receivers');
        } else {
            $this->confirmClassDepartmentGroupRelationship('send_to_', true);
            $this->send_to_select = $request->input('send_to_select');
        }
        $this->meeting_type = $request->input('meeting_type');
    }

    /**
     * Fill letter attributes with request input.
     */
    public function fillAttributes(Request $request)
    {
        $this->fill($request->only($this->fillable));
        $this->scheduled_at = $this->parseFromLocalizeDateTime("{$request->input('date')} {$request->input('time')}");

        $this->type = $this->setType($request);
        if (1 === $request->checkDateSetting) {
            $this->scheduled_at = now();
            $this->status = static::STATUS_SENT;
        } else {
            $this->status = static::STATUS_CREATED;
        }
    }

    /**
     * Create new meeting instance and save to database.
     *
     * @version 1.0.0
     */
    public function createNew(Request $request)
    {
        throw_if($this->exists, BadMethodCallException::class, 'This method must be called by an unsaved instance.');
        $this->fillAttributes($request);
        $this->save();
        $this->processReceivers($request);
        $this->shouldDispatchNotification();
    }

    /**
     * Update this meeting instance and save to database.
     *
     * @version 1.0.0
     */
    public function updateFrom(Request $request)
    {
        throw_if(!$this->exists, BadMethodCallException::class, 'This method must be called by an exiting instance');
        $this->fillAttributes($request);
        $this->save();
        $this->processReceivers($request);
        $this->shouldDispatchNotification();
    }

    /**
     * Processing different receiver type.
     *
     * @version 1.0.0
     */
    private function processReceivers(Request $request)
    {
        if (strtolower($request->input('letter_type')) === strtolower(static::TYPE_STUDENTS)) {
            // when send to student
            $this->processIndividuals($request);
        } else {
            $this->processClassDepartmentGroupRelationship('receivers', MeetingReceiver::class, 'receiver', 'send_to_', true);
        }
    }

    /**
     * Processing data for student receivers.
     */
    public function processIndividuals(Request $request)
    {
        $individual_receivers = json_decode($request->input('individual_receivers', '[]'));

        $students = collect($individual_receivers)->pluck('id');
        // clear old data
        $this->receivers()->delete();
        foreach ($students as $studentId) {
            $studentModel = new Student();
            $studentModel->id = $studentId;
            $this->receivers()->save(MeetingReceiver::createFor($studentModel));
        }
    }

    public function getIsForStudentsAttribute()
    {
        return $this->type === static::TYPE_STUDENTS;
    }

    public function getReceiversListAttribute()
    {
        if ($this->type === static::TYPE_STUDENTS) {
            return $this->students->pluck('name');
        }
        $this->loadMissing('receivers.receiver');

        return $this->receivers->pluck('receiver.name');
    }

    /**
     * Guest meeting receiver type based on selection.
     *
     * @version 1.0.0
     *
     * @return string type
     */
    private function setType(Request $request)
    {
        if ($request->has('individual_receivers')) {
            return static::TYPE_STUDENTS;
        }
        if ('school_classes' === $request->input('send_to_select')) {
            return static::TYPE_CLASS;
        }
        if ('departments' === $request->input('send_to_select')) {
            return static::TYPE_DEPARTMENT;
        }

        if ('class_groups' === $request->input('send_to_select')) {
            return static::TYPE_GROUP;
        }
    }

    /**
     * Check if user select to send immediately
     * Create queue for dispatching this meeting.
     *
     * @version 1.0.0
     */
    private function shouldDispatchNotification()
    {
        if (now()->greaterThanOrEqualTo($this->scheduled_at)) {
            hsp_debug('manually dispatching notification for this meeting');
            dispatch(new DistributeMeetingJob($this));
        }
    }
}

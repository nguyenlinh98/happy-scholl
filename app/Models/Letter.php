<?php

namespace App\Models;

use App\Jobs\Letter\DistributeLetterJob;
use App\Traits\Models\HasClassDepartmentGroupRelationshipTrait;
use App\Traits\Models\HasReceiverTrait;
use App\Traits\Models\LocalizeDateTimeTrait;
use App\Traits\Models\SchoolScopeTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Letter extends Model
{
    use SoftDeletes;
    use LocalizeDateTimeTrait;
    use HasReceiverTrait;
    use HasClassDepartmentGroupRelationshipTrait;
    use HasRelationships;
    use SchoolScopeTrait;

    const TYPE_GROUP = 'GROUP';
    const TYPE_DEPARTMENT = 'DEPARTMENT';
    const TYPE_STUDENTS = 'INDIVIDUAL';
    const TYPE_CLASS = 'CLASS';
    const STATUS_CREATED = 0;
    const STATUS_SENT = 1;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $fillable = [
        'subject',
        'sender',
        'body',
    ];
    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
    protected $appends = [
        'file_url',
    ];

    /**
     * RELATIONSHIPS.
     */
    public function receivers()
    {
        return $this->hasMany(LetterReceiver::class, 'letter_id');
    }

    public function readStatuses()
    {
        return $this->hasMany(LetterReadStatus::class, 'letter_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sender');
    }

    public function letterReceive()
    {
        return $this->hasOne(LetterReceiver::class, 'letter_id');
    }

    public function letterStatus()
    {
        return $this->hasOne(LetterReadStatus::class, 'letter_id');
    }

    /**
     * Get students record from database based on type.
     */
    public function students()
    {
        if ($this->type === static::TYPE_STUDENTS) {
            return $this->hasManyThrough(Student::class, LetterReceiver::class, 'letter_id', 'id', 'id', 'receiver_id');
        }
        if ($this->type === static::TYPE_GROUP) {
            return $this->hasManyDeep(
                Student::class,
                [LetterReceiver::class, ClassGroup::class, 'class_group_members', SchoolClass::class],
                ['letter_id', 'id', 'class_group_id', 'id', 'school_class_id'],
                [null, ['receiver_type', 'receiver_id'], 'id', 'school_class_id']
            )->distinct();
        }

        if ($this->type === static::TYPE_CLASS) {
            return $this->hasManyDeep(
                Student::class,
                [LetterReceiver::class, SchoolClass::class],
                ['letter_id', 'id', 'school_class_id'],
                [null, ['receiver_type', 'receiver_id'], 'id']
            )->distinct();
        }

        if ($this->type === static::TYPE_DEPARTMENT) {
            return $this->hasManyDeep(
                Student::class,
                [LetterReceiver::class, Department::class, 'department_students'],
                ['letter_id', 'id', 'department_id', 'id'],
                [null, ['receiver_type', 'receiver_id'], 'id', 'student_id']
            )->distinct();
        }
    }

    /**
     * SCOPE.
     */

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

    public static function updateLetterType($id, $receiver_type)
    {
        $letter = LetterReadStatus::find($id);
        $letter->favorist_flag = $receiver_type;
        $letter->save();
    }

    public static function removeLetterFavorite($id)
    {
        $letter = LetterReadStatus::find($id);
        $letter->favorist_flag = 0;
        $letter->save();
    }

    public static function deleteOneLetter($id)
    {
        $letter = Letter::find($id);
        $letter->delete();
    }

    public static function removeLetterTrash($id, $student_id)
    {
        Letter::withTrashed()
            ->where('id', $id)
            ->restore()
        ;
        $rs = LetterReadStatus::where('letter_id', $id)->where('student_id', $student_id)->first();
        static::removeLetterFavorite($rs->id);
    }

    public static function getLetterFavorite($student_id)
    {
        return Letter::with('user')
            ->select(['letters.id AS letter_id', 'letters.*', 'lrs.*'])
            ->join('letter_statuses AS lrs', 'lrs.letter_id', '=', 'letters.id')
            //->join('letter_receivers AS lr', 'lr.letter_id', '=', 'letters.id')
            ->where('lrs.student_id', $student_id)
            ->where('lrs.favorist_flag', 1)
            ->orderBy('letters.created_at', 'DESC')
            ->get()
        ;
    }

    public static function getLetterTrash($student_id)
    {
        return Letter::onlyTrashed()
            ->select(['letters.id AS letter_id', 'letters.*'])
            //->with('user','letterReceive')
            ->with('user')
            ->join('letter_statuses AS lrs', 'lrs.letter_id', '=', 'letters.id')
            ->where('student_id', $student_id)
            ->orderBy('letters.created_at', 'DESC')
            ->get()
        ;
    }

    public static function getLetterAll($student_id)
    {
        return Letter::withoutTrashed()
            ->select(['letters.id AS letter_id', 'letters.*', 'lrs.*'])
            ->join('letter_statuses AS lrs', 'lrs.letter_id', '=', 'letters.id')
            ->where('student_id', $student_id)
            ->orderBy('letters.created_at', 'DESC')
            ->get()
        ;
    }

    public static function viewLetterDetail($student_id, $id)
    {
        return Letter::withTrashed()
            ->select(['letters.id AS letter_id', 'letters.*', 'lrs.*'])
            ->join('letter_statuses AS lrs', 'lrs.letter_id', '=', 'letters.id')
            ->where('letters.id', $id)
            ->where('lrs.student_id', $student_id)
            ->first()
        ;
    }

    public static function checkLetterRead($letter_id, $student_id)
    {
        return LetterReadStatus::where('letter_id', $letter_id)
            ->where('student_id', $student_id)
            ->where('read', 0)
            ->first()
        ;
    }

    public static function updateLetterRead($id)
    {
        $letter = LetterReadStatus::find($id);
        $letter->read = 1;
        $letter->save();
    }

    public static function countLetterByStudent($student_id)
    {
        return LetterReadStatus::where('student_id', $student_id)
            ->where('read', LetterReadStatus::STATUS_UNREAD)
            ->count()
        ;
    }

    public function getClassForLetterAttribute()
    {
        if ($this->type === static::TYPE_STUDENTS) {
            return $this->receivers->first()->receiver->class->name;
        }
        if ($this->type === static::TYPE_CLASS) {
            return $this->receivers->first()->receiver->name;
        }

        return false;
    }

    public function processIndividuals(Request $request)
    {
        $individual_receivers = json_decode($request->input('individual_receivers', '[]'));

        $students = collect($individual_receivers)->pluck('id');

        $this->receiversSync(Student::class, $students->toArray(), 'receivers', 'letter_id');
    }

    /**
     * Get file path from input and move to laravel storage folder.
     */
    public function storeFile(Request $request)
    {
        // move file from /tmp to laravel folder if file_path exists in request inputs
        if ($request->has('file_path')) {
            try {
                if ($this->exists && $this->file === $request->input('file_path')) {
                    // if we are in edit mode and file does not change
                    hsp_debug('keeping old file', $this->file);

                    return true;
                }
                if ($this->exists && $this->file !== $request->input('file_path')) {
                    // removing old file
                    //throw_if(Storage::exists($this->file), FileNotFoundException::class, 'File in path::'.$this->file.':: not found');
                    Storage::delete($this->file);
                    Storage::deleteDirectory(dirname($this->file));
                    hsp_debug('delete old file', $this->file);

                    if (null === $request->input('file_path')) {
                        // delete path stored in 'file' attribute
                        $this->file = null;
                    }
                }
                if (null === $request->input('file_path')) {
                    hsp_debug('does not have any path, returning');

                    return false;
                }
                throw_unless(Storage::disk('temp')->exists($request->input('file_path')), FileNotFoundException::class, 'File in temp disk::'.$request->input('file_path').':: not found');

                $filePath = 'public/letters/'.Str::random(40);
                hsp_debug('storing file path', $filePath);

                $temporaryFile = new File(Storage::disk('temp')->path($request->input('file_path')));

                $this->file = Storage::putFileAs($filePath, $temporaryFile, $request->input('file_name'));
                hsp_debug('file path after move', $this->file);
            } catch (FileNotFoundException $e) {
                report($e);
            }
        }
    }

    /**
     * Fill letter attributes with request input.
     */
    public function fillAttributes(Request $request)
    {
        $this->fill($request->only($this->fillable));
        $this->scheduled_at = $this->parseFromLocalizeDateTime("{$request->input('date')} {$request->input('time')}");
    }

    /**
     * Create new letter.
     */
    public function createLetter(Request $request)
    {
        $this->storeFile($request);
        $this->fillAttributes($request);
        $this->type = $this->setType($request);
        if($request->checkDateSetting == 1) {
            $this->scheduled_at = now();
        }
        $this->status = now()->greaterThanOrEqualTo($this->scheduled_at) ? static::STATUS_SENT : static::STATUS_CREATED;
        $this->save();
        $this->processReceivers($request);
        $this->shouldDispatchNotification();
    }

    /**
     * Update letter base on request.
     */
    public function updateLetter(Request $request)
    {
        hsp_debug('updating letter with inputs', $request->all());
        $this->storeFile($request);
        $this->fillAttributes($request);
        $this->type = $this->setType($request);
        if($request->checkDateSetting == 1) {
            $this->scheduled_at = now();
        }
        $this->status = now()->greaterThanOrEqualTo($this->scheduled_at) ? static::STATUS_SENT : static::STATUS_CREATED;
        $this->save();
        $this->processReceivers($request);
        $this->shouldDispatchNotification();
    }

    /**
     * Generate data for confirm view.
     */
    public function prepareForConfirm()
    {
        $request = request();
        $this->fill($request->only($this->fillable));
        $this->sender = $request->input('sender');
        $this->scheduled_at = $this->parseFromLocalizeDateTime("{$request->input('date')} {$request->input('time')}");
        $this->date = $request->input('date');
        $this->time = $request->input('time');
        // if user upload a file
        if ($request->hasFile('file')) {
            // store it in temp folder
            // and return new path
            $this->filePath = $request->file('file')->store('/letter-temp', 'temp');
            $this->uploadedFileName = $request->file('file')->getClientOriginalName();
        } else {
            // get old file path
            $this->filePath = $request->input('file_path');
            $this->uploadedFileName = $request->input('file_name');
        }
        if (strtolower(static::TYPE_STUDENTS) === strtolower($request->input('letter_type'))) {
            $collection = collect(json_decode($request->input('individual_receivers')))->pluck('id');
            hsp_debug('collection', $collection);
            $this->receiversCollection = Student::whereIn('id', $collection)->get();

            $this->individual_receivers = $request->input('individual_receivers');
        } else {
            $this->confirmClassDepartmentGroupRelationship('send_to_', true);
            $this->send_to_select = $request->input('send_to_select');
        }
        $this->letter_type = $request->input('letter_type');
    }

    /**
     * Preload data for edit form.
     */
    public function prepareForEdit()
    {
        $this->subject = old('subject', $this->subject);
        $this->body = old('body', $this->body);
        $this->sender = old('sender', $this->sender);
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

        if (old('file_path', $this->file) === $this->file) {
            if (null === $this->file) {
                $this->uploaded_file_name = '';
                $this->file_path = '';
            } else {
                $this->uploaded_file_name = $this->fileName.' （変更されていません）';
                $this->file_path = $this->file;
            }
            hsp_debug('file_path', $this->file);
        }
    }

    // public function getScheduledAtAttribute()
    // {
    //     return Carbon::parse($this->attributes['scheduled_at']);
    // }

    public function getFileNameAttribute()
    {
        return basename($this->file);
    }

    public function getFileUrlAttribute()
    {
        return filled($this->file) ? url(Storage::url($this->file)) : '';
    }

    public function getIsIndividualsAttribute()
    {
        return $this->type === static::TYPE_STUDENTS;
    }

    /**
     * Return link to edit page, base on letter type.
     */
    public function getEditLinkAttribute()
    {
        return route('admin.letter.edit', ['letter' => $this]);
    }

    /**
     * Processing send to classes, groups or departments.
     */
    private function processReceivers(Request $request)
    {
        if (strtolower($request->input('letter_type')) === strtolower(static::TYPE_STUDENTS)) {
            $this->processIndividuals($request);
        } else {
            $this->processClassDepartmentGroupRelationship('receivers', LetterReceiver::class, 'receiver', 'send_to_', true);
        }
    }

    private function shouldDispatchNotification()
    {
        if (now()->greaterThanOrEqualTo($this->scheduled_at)) {
            hsp_debug('manually dispatching notification for this letter');
            dispatch(new DistributeLetterJob($this));
        }
    }

    /**
     * Set letter type based on selection.
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

    public function getReceiversListAttribute()
    {
        if ($this->type === static::TYPE_STUDENTS) {
            return $this->students->pluck('name');
        }
        $this->loadMissing('receivers.receiver');

        return $this->receivers->pluck('receiver.name');
    }
}

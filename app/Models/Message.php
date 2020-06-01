<?php

namespace App\Models;

use App\Jobs\Message\DistributeMessageJob;
use App\Traits\Models\HasClassDepartmentGroupRelationshipTrait;
use App\Traits\Models\LocalizeDateTimeTrait;
use App\Traits\Models\PreparableModel;
use App\Traits\Models\SchoolScopeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    // use SoftDeletes;
    use PreparableModel {
        prepare as prepareTrait;
    }
    use SchoolScopeTrait;
    use LocalizeDateTimeTrait;
    use HasClassDepartmentGroupRelationshipTrait;
    const STATUS_NOT_YET = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_FINISH = 2;
    const STATUS_ERROR = 3;

    /**
     * Return an array of predefined list for message destination.
     *
     * @return array
     *
     * @version 1.0.0
     */
    protected $fillable = [
        'subject',
        'body',
        'sender',
        'receivers',
    ];

    protected $casts = [
        'receivers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'sender');
    }

    public function receivers()
    {
        return $this->hasMany(MessageReceiver::class, 'message_id');
    }

    public function readStatuses()
    {
        return $this->hasMany(MessageReadStatus::class, 'message_id');
    }

    public function readStatusesWithStudent($studentId)
    {
        return $this->hasMany(MessageReadStatus::class, 'message_id')->where('student_id', $studentId);
    }

    public function confirm()
    {
        $this->confirmClassDepartmentGroupRelationship('message_send_to_', true);

        $this->scheduled_at = $this->parseFromLocalizeDateTime(request()->input('scheduled_date') . ' ' . request()->input('scheduled_time'));
        $this->scheduled_date = request('scheduled_date');
        $this->scheduled_time = request('scheduled_time');
        $this->sender = request('sender');
        $this->subject = request('subject');
        $this->body = request('body');
        $this->message_send_to_select = request('message_send_to_select');
    }

    public function prepare()
    {
        $this->prepareTrait([
            'scheduled_date' => old('scheduled_date', $this->scheduled_at ? $this->scheduled_at->format('Y-m-d') : ''),
            'scheduled_time' => old('scheduled_time', $this->scheduled_at ? $this->scheduled_at->format('H:i') : ''),
        ]);
    }

    public function prepareForEdit()
    {
        $this->prepare();
        $this->prepareClassDepartmentGroupRelationship('receivers', 'message_send_to_', 'receiver');
    }

    /**
     * Map model attribute with request form data then save model.
     *
     * @version 1.0.0
     */
    public function createFromRequest(Request $request)
    {
        $this->subject = $request->subject;
        $this->body = $request->body;
        $date = empty($request->input('scheduled_date')) ? date("Y-m-d") : $request->input('scheduled_date');
        $time = empty($request->input('scheduled_time')) ? date("H:i:s"): $request->input('scheduled_time');
        $this->sender = $request->sender;
        if($request->checkDateSetting == 1) {
            $this->scheduled_at = now();
        } else {
            $this->scheduled_at = $this->parseFromLocalizeDateTime("$date $time");
        }
        
        $this->status = static::STATUS_NOT_YET;
        $this->save();

        $this->processClassDepartmentGroupRelationship('receivers', MessageReceiver::class, 'receiver', 'message_send_to_', true);

        $this->shouldDispatchNotificationImmediately();
    }

    public static function getMessageByStudent($student_id)
    {
        return DB::table('messages AS m')
            ->leftJoin('message_read_statuses AS mrs', 'mrs.message_id', '=', 'm.id')
            ->where('mrs.student_id', $student_id)
            ->select(['m.id AS message_id', 'm.*', 'mrs.*', 'm.school_id AS s1', 'mrs.school_id as s2'])
//            ->select(['m.id AS message_id', 'm.*', 'm.school_id AS s1', 'mrs.school_id as s2'])
            ->orderBy('m.created_at', 'DESC')
            ->get();
        /*return Message::with('user')
            ->select(['messages.id AS message_id', 'messages.*','messages.school_id AS s1','mrs.school_id as s2'])
            ->leftJoin('message_read_statuses AS mrs', 'mrs.message_id', '=', 'messages.id')
            ->where('mrs.student_id', $student_id)
            ->orderBy('messages.created_at', 'DESC')
            ->get()
        ;*/
    }

    public static function checkMessageRead($id)
    {
        return MessageReadStatus::where('student_id', $id)
            ->where('read', 0)
            ->count();
    }

    public static function countMessageByStudent($student_id)
    {
        return MessageReadStatus::where('student_id', $student_id)->where('read', MessageReadStatus::STATUS_UNREAD)->count();
    }

    public function getSendToAllClassesAttribute()
    {
        $this->loadCount('receivers');

        return $this->receivers_count === hsp_school()->school_classes_count;
    }

    public function getClassList()
    {
        $this->loadMissing('receivers.receiver');

        return $this->receivers->pluck('receiver.name')->join('、');
    }

    public function getScheduledAtAttribute()
    {
        if (!$this->exists) {
            return false;
        }

        return Carbon::parse($this->attributes['scheduled_at']);
    }

    private function shouldDispatchNotificationImmediately()
    {
        if (now()->greaterThanOrEqualTo($this->scheduled_at)) {
            dispatch(new DistributeMessageJob($this));
        }
    }
}

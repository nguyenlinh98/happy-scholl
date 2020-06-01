<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolEvents extends Model
{
    use SoftDeletes;

    protected $table = 'school_events';
    protected $fillable = [
        'subject',
        'body',
        'scheduled_at',
        'deadline_at',
        'need_help',
        'help_deadline_at',
    ];

    public static function boot()
    {
        parent::boot();
    }
    // code for Front-end
    public static function getEventBySchool($school_id)
    {
        return SchoolEvents::where('school_id', $school_id)->orderBy('scheduled_at', 'ASC')->get();
    }

    public static function getEventByDay($school_id, $date = null)
    {
        $rs = SchoolEvents::where('school_id', $school_id)->whereDate('scheduled_at', $date)
            ->orderBy('scheduled_at', 'ASC')->get();
        return $rs;
    }

    public static function countUserApplyEvent($school_event_id)
    {
        return SchoolEventStatus::where('apply_status', SchoolEventStatus::APPLY_STATUS_APPLY)->where('school_event_id', $school_event_id)->count();
    }

    public static function countUserHelpEvent($school_event_id)
    {
        return SchoolEventStatus::where('apply_type', SchoolEventStatus::APPLY_TYPE_EVENT_HELP)->where('school_event_id', $school_event_id)->count();
    }

    public function eventStatus()
    {
        return $this->hasMany(SchoolEventStatus::class, 'school_event_id');
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

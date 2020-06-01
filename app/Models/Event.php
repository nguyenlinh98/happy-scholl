<?php

namespace App\Models;

use App\Traits\Models\LocalizeDateTimeTrait;
use App\Traits\Models\PreparableModel;
use BadMethodCallException;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    use PreparableModel {
        prepare as automaticPrepare;
    }
    use LocalizeDateTimeTrait;
    // use SoftDeletes;
    const REPEATABLE = [
        'none',
        'daily',
        'weekly',
        'monthly',
        'yearly',
    ];
    const TYPE_ALL_DAY = 0;
    const TYPE_NORMAL = 1;

    protected $fillable = [
        'title',
        'detail',
        'location',
        'calendar_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
       // 'calendar_id',
    ];
    protected $appends = [
        'allDay',
    ];

    public function scopeAwaitingReminds(Builder $builder)
    {
        return $builder->where('events.reminder_sent', 0);
    }

    public function scopeWithoutHSPCalendar(Builder $builder)
    {
        return $builder->whereHas('calendar', function ($query) {
            $query->where('type', '<>', 'hsp');
        });
    }

    public function prepare()
    {
        $this->automaticPrepare();
        $this->single_date = old('single_date');

        // set start day = nearest half hour time
        // e.g: if now is 11:35 => set time to 12:00
        // if now is 11:25 => set time to 11h:30
        if (null === old('_token')) {
            if (!$this->exists) {
                $minutes = now()->minute >= 30 ? 0 : 30;
                $hours = 0 === $minutes ? now()->hour + 1 : now()->hour;
                $start = today()->hour($hours)->minute($minutes);
                $end = $start->clone()->addMinutes(30);
            } else {
                $start = $this->start;
                $end = $this->end;
            }
        } else {
            // fallback
            $start = today();
            $end = today();
        }

        $this->start_date = old('start_date', old('single_date', $start->format('Y年m月d日')));
        $this->start_time = old('start_time', $start->format('H:i'));
        $this->end_date = old('end_date', old('single_date', $end->format('Y年m月d日')));
        $this->end_time = old('end_time', $end->format('H:i'));
        $this->all_day_event = old('all_day', self::TYPE_ALL_DAY === $this->type ? 'on' : false);
    }

    public function createFromRequest(array $data)
    {
        $this->fillData($data);
        $this->save();
    }

    public function updateFromRequest(array $data)
    {
        $this->fillData($data);
        $this->save();
    }

    public function getAllDayAttribute()
    {
        return self::TYPE_ALL_DAY === $this->type;
    }

    public function getDescriptionAttribute()
    {
        return $this->detail;
    }

    public function getExtendedPropsAttribute()
    {
        return [
            'location' => $this->location,
        ];
    }

    private function fillData(array $data)
    {
        $this->calendar_id = $data['calendar'];
        $this->title = $data['title'];
        $this->detail = isset($data['detail']) ? $data['detail'] : '';

        $this->remind = isset($data['remind']) ? $data['remind'] : 5;

        $this->location = isset($data['location']) ? $data['location'] : '';
        $this->type = isset($data['all_day']) ? self::TYPE_ALL_DAY : self::TYPE_NORMAL;
        if (self::TYPE_ALL_DAY === $this->type) {
            // set time to midnight at 00:00:00
            if (isset($data['single_date'])) {
                $this->start = Carbon::parse($data['single_date'])->hour(0)->minute(0)->second(0);
                $this->end = $this->start->clone()->addDay();
            } else {
                $this->start = $this->parseFromLocalizeDate($data['start_date'])->hour(0)->minute(0)->second(0);
                $this->end = $this->parseFromLocalizeDate($data['end_date'])->hour(0)->minute(0)->second(0);
            }
        } else {
            if (isset($data['single_date'])) {
                $this->start = Carbon::parse("{$data['single_date']} {$data['start_time']}");
                $this->end = Carbon::parse("{$data['single_date']} {$data['end_time']}");
            } else {
                $this->start = $this->parseFromJapaneseDateTime("{$data['start_date']} {$data['start_time']}");
                $this->end = $this->parseFromJapaneseDateTime("{$data['end_date']} {$data['end_time']}");
            }
        }
    }

    // get data event for student
    public function calendars()
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }

    public function calendar()
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'calendar_id', 'calendar_id');
    }

    public function calendar_class()
    {
        return $this->belongsTo(SchoolClass::class, 'calendar_id', 'calendar_id');
    }

    // get all event from user id
    public static function filterEventByStudent($calendar_id)
    {
        return Event::with('calendars')->whereIn('calendar_id', $calendar_id)->orderBy('start', 'DESC')->get();
    }

    public static function getCalendarIdByDepartment($student_id)
    {
        $departments = DB::table('departments AS d')
            ->join('department_students AS ds', 'ds.department_id', '=', 'd.id')
            ->whereIn('ds.student_id', $student_id)
            ->select('d.calendar_id', 'd.name')
            ->orderBy('d.name', 'ASC')
            ->get();

        return $departments;
    }

    public static function getCalendarTheme($user_id)
    {
        $calendarTheme = CalendarTheme::select('user_calendar_setting.*', 'user_calendar_themes.*')
            ->join('user_calendar_settings AS user_calendar_setting', 'user_calendar_setting.calendar_theme_id', '=', 'user_calendar_themes.id')
            ->where('user_calendar_setting.user_id', $user_id)
            ->first();

        return $calendarTheme;
    }

    public static function getCalendarIdByType()
    {
        return Calendar::where('type', Calendar::TYPE_CALENDAR_HSP)->get();
    }

    /*****************/
    /**** METHODS ****/
    /*****************/
    public function markAsReminded()
    {
        try {
            throw_if($this->reminder_sent, BadMethodCallException::class, 'Event reminder already sent, please check again');
        } catch (Exception $e) {
            logger()->warning($e->getMessage());

            return false;
        }
        $this->reminder_sent = 1;
        $this->save();
    }

    /**
     * Check if current event is due to remind.
     *
     * @return bool true if 'start' - 'remind' < now()
     */
    public function dueToRemind()
    {
        return $this->start->subMinutes($this->remind)->lessThan(now());
    }

    /***************************/
    /**** ATTRIBUTE CASTING ****/
    /***************************/

    public function getStartAttribute()
    {
        if (!$this->start_attribute_cache) {
            $this->start_attribute_cache = Carbon::parse($this->attributes['start']);
        }

        return $this->start_attribute_cache;
    }

    public function getEndAttribute()
    {
        if (!$this->end_attribute_cache) {
            $this->end_attribute_cache = Carbon::parse($this->attributes['end']);
        }

        return $this->end_attribute_cache;
    }
}

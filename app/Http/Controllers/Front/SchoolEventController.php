<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\SchoolEvents;
use App\Models\SchoolEventStatus;
use App\Models\Seminar;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Calendar;
use Carbon\Carbon;

class SchoolEventController extends Controller
{
    public function index($school_id)
    {
        return view('front/school_event.index', compact('school_id'));
    }

    public function calendar(Request $request, $school_id)
    {
        $arr_calendarIdSpecial = [];
        $calendarIdSpecial = Event::getCalendarIdByType();
        if($calendarIdSpecial->count()) {
            foreach($calendarIdSpecial as $calendar) {
                $arr_calendarIdSpecial[] = $calendar->id;
            }
        }
        // show all event by special day
        $events = Event::filterEventByStudent($arr_calendarIdSpecial);
        $schoolEvents = SchoolEvents::getEventBySchool($school_id);
        $schools_color = hsp_getConfig('schools_color');
        foreach($events as $e) {
            if ($e['calendars']['type'] == \App\Models\Calendar::TYPE_CALENDAR_HSP) {
                $e->title_color = 'red';
                $e->bg_color = $e->calendars->event_bgcolor;
                $e->date_color = 'red';
            } else {
                $e->title_color = '';
                $e->date_color = '';
                if($e->bg_color == '' || $e->bg_color == null) {
                    $e->bg_color = $e->calendars->event_bgcolor;
                }
            }
        }
        return view('front.school_event.calendar', compact('schoolEvents',
                    'events','schools_color', 'school_id'));
    }

    public function showEventByClickCalendar(Request $request)
    {
        $start_date = $request['start_date'];
        $school_id = $request['school_id'];// dd($school_id);

        $arr_calendarIdSpecial = [];
        $calendarIdSpecial = Event::getCalendarIdByType();
        if($calendarIdSpecial->count()) {
            foreach($calendarIdSpecial as $calendar) {
                $arr_calendarIdSpecial[] = $calendar->id;
            }
        }
        $events = Event::filterEventByStudent($arr_calendarIdSpecial);
        $schoolEvents = SchoolEvents::getEventBySchool($school_id);

        $schools_color = hsp_getConfig('schools_color');

        foreach($events as $key => $item) {
            if($start_date != date('Y-m-d', strtotime($item->start))) {
                unset($events[$key]);
            }
        }
        foreach($schoolEvents as $k => $itemS) {
            if($start_date != date('Y-m-d', strtotime($itemS->scheduled_at))) {
                unset($schoolEvents[$k]);
            }
        }

        foreach($events as $e) {
            if ($e['calendars']['type'] == \App\Models\Calendar::TYPE_CALENDAR_HSP) {
                $e->title_color = 'red';
                $e->bg_color = $e->calendars->event_bgcolor;
                $e->date_color = 'red';
            } else {
                $e->title_color = '';
                $e->date_color = '';
                if($e->bg_color == '' || $e->bg_color == null) {
                    $e->bg_color = $e->calendars->event_bgcolor;
                }
            }
        }

        $current_date = $date_format = Carbon::parse($start_date)->locale('ja_JA')->isoFormat('ll');
        $html = '<div class="show-event">
        <div class="bar-title">'.$current_date. '</div><div class="list-event">';
        foreach($events as $e) {
            $html .= '<div class="event"><div class="time-to">';
            $time = date('H:i', strtotime($e->start)) . '<br>' . date('H:i', strtotime($e->end));
            if($e->allDay !=1) {
                $time = '終日';
            }
            $html .= '<span>' . $time . '</span></div>
            <div class="content-event" style="background-color:' . $e->bg_color .';">';
            $title = '<span>' . $e->title . '</span></div> </div>';
            $html .= $title;

        }
        foreach($schoolEvents as $s) {
            $html .= '<div class="event"><div class="time-to">';
            $time = date('H:i', strtotime($s->scheduled_at)) . '<br>' . date('H:i', strtotime($s->deadline_at));
            /*if($s->allDay !=1) {
                $time = '終日';
            }*/
            $html .= '<span>' . $time . '</span></div>
            <div class="content-event" style="background-color:' . $schools_color['event_color'] .';">';
            $title = '<span>' . $s->subject . '</span></div> </div>';
            $html .= $title;
        }
        $html .=  '</div></div>';

        return $html;
    }

    // filter event by user in list view
    public function eventByMonth(Request $request)
    {
        $date_now = $request['date'];
        $type = $request['type'];
        $school_id = $request['school'];
        $current_month = $request['month'];
        $arr_calendarIdSpecial = [];
        $calendarIdSpecial = Event::getCalendarIdByType();
        if($calendarIdSpecial->count()) {
            foreach($calendarIdSpecial as $calendar) {
                $arr_calendarIdSpecial[] = $calendar->id;
            }
        }
        // show all event by user id
        $events = Event::filterEventByStudent($arr_calendarIdSpecial);
        $schoolEvents = SchoolEvents::getEventBySchool($school_id);
        $events->map(function($item) {
            $item->subject = $item['title'];
            $item->scheduled_at = Carbon::parse($item['start'])->isoFormat('YYYY-MM-DD HH:mm:ss');
            $item->deadline_at = Carbon::parse($item['end'])->isoFormat('YYYY-MM-DD HH:mm:ss');
            return $item;
        });

        foreach($events as $key => $event) {
            if($current_month != date('m', strtotime($event->start))) {
                unset($events[$key]);
            }
        }
        foreach($schoolEvents as $key => $schoolEvent) {
            if($current_month != date('m', strtotime($schoolEvent->scheduled_at))) {
                unset($schoolEvents[$key]);
            }
        }

        // get all date by one month
        $start_date = "01-". date('m', strtotime($date_now)). '-' .
            date('Y', strtotime($date_now));
        $start_time = strtotime($start_date);
        $end_time = strtotime("+1 month", $start_time);
        $arr_date = []; // array all date with event + without event
        for($j = $start_time; $j < $end_time; $j+=86400) {
            $arr_date[date('Y-m-d', $j)] = date('Y-m-d', $j);
        }

        $arr_event = []; // array date with event
        foreach($events as $k => $e) {
            if ($e['calendars']['type'] == \App\Models\Calendar::TYPE_CALENDAR_HSP) {
                $e->title_color = 'red';
                $e->bg_color = $e->calendars->event_bgcolor;
                $e->date_color = 'red';
            } else {
                $e->title_color = '';
                $e->date_color = '';
                if($e->bg_color == '' || $e->bg_color == null) {
                    $e->bg_color = $e->calendars->event_bgcolor;
                }
            }

            $date1 = date('Y-m-d', strtotime($e->start));
            if(in_array($date1, $arr_date)) {
                $arr_event[$date1][] = $e->toArray();
            }
        }

        $arr_link = [];
        foreach($schoolEvents as $se => $schoolEvent) {
            $date1 = date('Y-m-d', strtotime($schoolEvent->scheduled_at));
            if(in_array($date1, $arr_date)) {
                $arr_event[$date1][] = $schoolEvent->toArray();
                $arr_link[$date1] = route('schoolevent.eventbyday')
                                    . "?date=" . $date1 . "&school=" . $school_id;
            }
        }
        $arr_date = array_merge($arr_date, $arr_event);

        // check color for special event
        $arr_special_color = [];
        foreach($arr_date as $k => $event1) {
            if (isset($event1) && is_array($event1)) {
                foreach ($event1 as $event) {
                    if (isset($event['calendars'])) {
                        if ($event['calendars']['type'] == \App\Models\Calendar::TYPE_CALENDAR_HSP) {
                            $arr_special_color[$k] = 'red';
                            //$arr_date[$k]['color'] = 'red';
                        } else {
                           // $arr_date[$k]['color'] = '';
                            $arr_special_color[$k] = '';
                        }
                    }
                }
            }
        }
        $schools_color = hsp_getConfig('schools_color');
        return view('front.school_event.by_month', compact('schools_color','arr_special_color',
                'arr_date','date_now','school_id', 'arr_link'));
    }

    public function eventByDay(Request $request) {
        $date_select = $request->get('date');
        $school_id = $request->get('school');
        $arr_calendarIdSpecial = [];
        $calendarIdSpecial = Event::getCalendarIdByType();
        if($calendarIdSpecial->count()) {
            foreach($calendarIdSpecial as $calendar) {
                $arr_calendarIdSpecial[] = $calendar->id;
            }
        }
        // show all event by user id
        $events = Event::filterEventByStudent($arr_calendarIdSpecial);
        $schoolEvents = SchoolEvents::getEventByDay($school_id, $date_select);
        $events->map(function($item) {
            $item->subject = $item['title'];
            $item->scheduled_at = $item['start'];
            $item->deadline_at = $item['end'];
            return $item;
        });
        return view('front.school_event.by_day', compact('date_select', 'schoolEvents', 'school_id'));
    }

    public function detail(Request $request, $id)
    {
        $schoolEvent = SchoolEvents::findOrFail($id);
        $count_event = SchoolEvents::countUserApplyEvent($id);
        $count_event_help = SchoolEvents::countUserHelpEvent($id);
        $seminar_relationship = hsp_getConfig('seminar_relationship');
        $user_id = \Auth::guard('parents')->user()->id;
        $event_student = SchoolEventStatus::where('school_event_id', $id)
                                ->where('user_id', $user_id)->first();

        $parents = \Auth::guard('parents')->user();
        $studentParents = $parents->student;
        $studentParents = $studentParents->unique('id');

        $popup_1 = 'このイベントに' . '<br>' . '申込をして' . '<br>' . 'よろしいですか？';
        $popup_2 = 'このイベントに' . '<br>' . 'イベントの申込とお手伝いの' . '<br>' . '参加連絡をして' . '<br>'. 'よろしいですか？';
        $popup_3 = 'このイベントに' . '<br>' . 'お手伝い参加の' . '<br>' . '連絡をして' . '<br>'. 'よろしいですか？';
        $popup_4 = 'このイベントに' . '<br>' . '未定の連絡をして' . '<br>' . 'よろしいですか？';
        $popup_5 = 'このイベントに' . '<br>' . '欠席連絡をして' . '<br>' . 'よろしいですか？';

        return view('front.school_event.event_detail', compact('schoolEvent','id','count_event',
                    'seminar_relationship','count_event_help','event_student', 'studentParents',
                    'popup_1', 'popup_2', 'popup_3', 'popup_4','popup_5'));
    }

    public function saveJoinEvent(Request $request, $id)
    {
        $seminar_apply_status = $request->get('seminar_apply_status');
        $seminar_apply_type = $request->get('seminar_apply_type');
        if($seminar_apply_status == 'apply' && is_null($seminar_apply_type))
        {
            $apply_status = SchoolEventStatus::APPLY_STATUS_APPLY;
            $apply_type = SchoolEventStatus::APPLY_TYPE_EVENT;
            $message = '申込むが完了しました。';
        }
        elseif ($seminar_apply_status == 'apply' && $seminar_apply_type == 'help')
        {
            $apply_status = SchoolEventStatus::APPLY_STATUS_APPLY;
            $apply_type = SchoolEventStatus::APPLY_TYPE_EVENT_HELP;
            $message = 'イベント申込とお手伝い参加の連絡が完了しました。';
        }
        elseif ($seminar_apply_type == 'help' && is_null($seminar_apply_status))
        {
            $apply_type = SchoolEventStatus::APPLY_TYPE_EVENT_HELP;
            $apply_status = SchoolEventStatus::APPLY_STATUS_NOTFIXED;
            $message = 'お手伝い参加連絡が完了しました。';
        }
        elseif ($seminar_apply_status == 'not_fix' && is_null($seminar_apply_type))
        {
            $apply_status = SchoolEventStatus::APPLY_STATUS_NOTFIXED;
            $apply_type = SchoolEventStatus::APPLY_TYPE_EVENT;
            $message = '未定の連絡通知が完了しました。';
        }
        elseif ($seminar_apply_status == 'cancel' && is_null($seminar_apply_type))
        {
            $apply_status = SchoolEventStatus::APPLY_STATUS_CANCEL;
            $apply_type = SchoolEventStatus::APPLY_TYPE_EVENT;
            $message = '未定の連絡通知が完了しました。';
        }

        $user_id = \Auth::guard('parents')->user()->id;
        $eventStatus = new SchoolEventStatus;
        $eventStatus::updateOrCreate(
            ['school_event_id' => $id, 'user_id' => $user_id, 'school_id' => $request->get('school_id')],
            [
                'apply_status' => $apply_status,
                'apply_type' => $apply_type,
                'student_id' => $request->get('student_id'),
                'relationship' => $request->get('relationship')
            ]
        );
        return view('front.school_event.join_success', ['id' => $id, 'message' => $message]);
    }

    public function getEventRegister(Request $request)
    {
        $user_id = \Auth::guard('parents')->user()->id;
        $events = SchoolEvents::with('eventStatus')->whereHas('eventStatus', function($q) use($user_id){
                        $q->where('school_events_statuses.user_id', $user_id)
                            ->where('school_events_statuses.apply_status', SchoolEventStatus::APPLY_STATUS_APPLY);
                     })->get();
        return view('front.school_event.register', compact('events'));
    }

    public function getEventNotRegister(Request $request)
    {
        $user_id = \Auth::guard('parents')->user()->id;
        $events = SchoolEvents::with('eventStatus')->whereHas('eventStatus', function($q) use($user_id){
                    $q->where('school_events_statuses.user_id', $user_id)
                        ->whereIn('school_events_statuses.apply_status',
                        [SchoolEventStatus::APPLY_STATUS_NOTFIXED, SchoolEventStatus::APPLY_STATUS_CANCEL]);
                //$q->where('school_events_statuses.apply_status', SchoolEventStatus::APPLY_STATUS_NOTFIXED)
                //->orWhere('school_events_statuses.apply_status', SchoolEventStatus::APPLY_STATUS_CANCEL);
        })->get();
        return view('front.school_event.not_register', compact('events'));
    }
}

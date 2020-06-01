<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\Seminar;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Calendar;
use Carbon\Carbon;
use App\Models\SeminarStatus;

class SeminarController extends Controller
{
    public function index($school_id)
    {
        return view('front/seminars.index', compact('school_id'));
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
        $seminars = Seminar::getSeminarBySchool($school_id);
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

        return view('front.seminars.calendar', compact('seminars','events','schools_color', 'school_id'));
    }

    public function showEventByClickCalendar(Request $request)
    {
        $start_date = $request['start_date'];
        $school_id = $request['school_id'];

        $arr_calendarIdSpecial = [];
        $calendarIdSpecial = Event::getCalendarIdByType();
        if($calendarIdSpecial->count()) {
            foreach($calendarIdSpecial as $calendar) {
                $arr_calendarIdSpecial[] = $calendar->id;
            }
        }
        $events = Event::filterEventByStudent($arr_calendarIdSpecial);
        $seminars = Seminar::getSeminarBySchool($school_id);

        $schools_color = hsp_getConfig('schools_color');

        foreach($events as $key => $item) {
            if($start_date != date('Y-m-d', strtotime($item->start))) {
                unset($events[$key]);
            }
        }
        foreach($seminars as $k => $itemS) {
            if($start_date != date('Y-m-d', strtotime($itemS->start_time))) {
                unset($seminars[$k]);
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
        foreach($seminars as $s) {
            $html .= '<div class="event"><div class="time-to">';
            $time = date('H:i', strtotime($s->start_time)) . '<br>' . date('H:i', strtotime($s->end_time));
            /*if($s->allDay !=1) {
                $time = '終日';
            }*/
            $html .= '<span>' . $time . '</span></div>
            <div class="content-event" style="background-color:' . $schools_color['seminar_color'] .';">';
            $title = '<span>' . $s->subject . '</span></div> </div>';
            $html .= $title;
        }
        $html .=  '</div></div>';

        return $html;
    }

    // filter event by user in list view
    public function seminarByMonth(Request $request)
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
        $seminars = Seminar::getSeminarBySchool($school_id);
        $events->map(function($item) {
            $item->subject = $item['title'];
            $item->start_time = Carbon::parse($item['start'])->isoFormat('YYYY-MM-DD HH:mm:ss');
            $item->end_time = Carbon::parse($item['end'])->isoFormat('YYYY-MM-DD HH:mm:ss');
            return $item;
        });

        foreach($events as $key => $event) {
            if($current_month != date('m', strtotime($event->start))) {
                unset($events[$key]);
            }
        }
        foreach($seminars as $key => $seminar) {
            if($current_month != date('m', strtotime($seminar->start_time))) {
                unset($seminars[$key]);
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
        foreach($seminars as $se => $seminar) {
            $date1 = date('Y-m-d', strtotime($seminar->start_time));
            if(in_array($date1, $arr_date)) {
                $arr_event[$date1][] = $seminar->toArray();
                $arr_link[$date1] = route('seminar.seminarbyday')
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
        } // echo '<pre>';print_r($arr_date);die;
        $schools_color = hsp_getConfig('schools_color');
        return view('front.seminars.by_month', compact('schools_color','arr_special_color',
            'arr_date','date_now','school_id', 'arr_link'));
    }

    public function seminarByDay(Request $request) {
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
        $seminars = Seminar::getSeminarByDay($school_id, $date_select);
        $events->map(function($item) {
            $item->subject = $item['title'];
            $item->start_time = $item['start'];
            $item->address = $item['location'];
            return $item;
        });
        return view('front.seminars.by_day', compact('date_select', 'seminars', 'school_id'));
    }

    public function detail(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        $user_id = \Auth::guard('parents')->user()->id;
        $seminar_student = SeminarStatus::where('seminar_id', $id)
                                ->where('user_id', $user_id)->first();
        //  echo '<pre>';print_r($a);die;
        $count_seminar = Seminar::countUserApplySeminar($id);
        $count_seminar_help = Seminar::countUserHelpSeminar($id);
        $seminar_relationship = hsp_getConfig('seminar_relationship');
        $parents = \Auth::guard('parents')->user();
        $studentParents = $parents->student;
        $studentParents = $studentParents->unique('id');

        $popup_1 = 'この講座に' . '<br>' . '申込をして' . '<br>' . 'よろしいですか？';
        $popup_2 = 'この講座に' . '<br>' . '講座の申込とお手伝いの' . '<br>' . '参加連絡をして' . '<br>'. 'よろしいですか？';
        $popup_3 = 'この講座に' . '<br>' . 'お手伝い参加の' . '<br>' . '連絡をして' . '<br>'. 'よろしいですか？';
        $popup_4 = 'この講座に' . '<br>' . '未定の連絡をして' . '<br>' . 'よろしいですか？';
        $popup_5 = 'この講座に' . '<br>' . '欠席連絡をして' . '<br>' . 'よろしいですか？';

        return view('front.seminars.seminar_detail', compact('seminar','id','count_seminar','seminar_student',
                    'seminar_relationship', 'count_seminar_help','studentParents','user_id',
                    'popup_1', 'popup_2', 'popup_3', 'popup_4','popup_5'));
    }

    public function saveJoinSeminar(Request $request, $id)
    {
        $seminar_apply_status = $request->get('seminar_apply_status');
        $seminar_apply_type = $request->get('seminar_apply_type');
        if($seminar_apply_status == 'apply' && is_null($seminar_apply_type))
            {
                $apply_status = SeminarStatus::APPLY_STATUS_APPLY;
                $apply_type = SeminarStatus::APPLY_TYPE_SEMINAR;
                $message = '申込むが完了しました。';
            }
        elseif ($seminar_apply_status == 'apply' && $seminar_apply_type == 'help')
            {
                $apply_status = SeminarStatus::APPLY_STATUS_APPLY;
                $apply_type = SeminarStatus::APPLY_TYPE_SEMINAR_HELP;
                $message = '講座申込とお手伝い参加の連絡が完了しました。';
            }
        elseif ($seminar_apply_type == 'help' && is_null($seminar_apply_status))
            {
                $apply_type = SeminarStatus::APPLY_TYPE_SEMINAR_HELP;
                $apply_status = SeminarStatus::APPLY_STATUS_NOTFIXED;
                $message = 'お手伝い参加連絡が完了しました。';
            }
        elseif ($seminar_apply_status == 'not_fix' && is_null($seminar_apply_type))
            {
                $apply_status = SeminarStatus::APPLY_STATUS_NOTFIXED;
                $apply_type = SeminarStatus::APPLY_TYPE_SEMINAR;
                $message = '未定の連絡通知が完了しました。';
            }
        elseif ($seminar_apply_status == 'cancel' && is_null($seminar_apply_type))
            {
                $apply_status = SeminarStatus::APPLY_STATUS_CANCEL;
                $apply_type = SeminarStatus::APPLY_TYPE_SEMINAR;
                $message = '欠席通知が完了しました。';
            }

        $user_id = \Auth::guard('parents')->user()->id;
        $seminarStatus = new SeminarStatus;
        $seminarStatus::updateOrCreate(
            ['seminar_id' => $id, 'user_id' => $user_id, 'school_id' => $request->get('school_id')],
            [
                'apply_status' => $apply_status,
                'apply_type' => $apply_type,
                'student_id' => $request->get('student_id'),
                'relationship' => $request->get('relationship')
            ]
        );
        return view('front.seminars.join_success', ['id' => $id, 'message' => $message]);
    }

    public function getSeminarRegister(Request $request)
    {
        $user_id = \Auth::guard('parents')->user()->id;
        $seminars = Seminar::with('seminarStatus')->whereHas('seminarStatus', function($q) use($user_id){
                        $q->where('seminar_statuses.user_id', $user_id)
                            ->where('seminar_statuses.apply_status', SeminarStatus::APPLY_STATUS_APPLY);
                    })->get();
        return view('front.seminars.register', compact('seminars'));
    }

    public function getSeminarNotRegister(Request $request)
    {
        $user_id = \Auth::guard('parents')->user()->id;
        $seminars = Seminar::with('seminarStatus')->whereHas('seminarStatus', function($q) use($user_id){
                        $q->where('seminar_statuses.user_id', $user_id)
                            ->whereIn('seminar_statuses.apply_status',
                                [SeminarStatus::APPLY_STATUS_NOTFIXED, SeminarStatus::APPLY_STATUS_CANCEL]);
                        //$q->where('seminar_statuses.apply_status', SeminarStatus::APPLY_STATUS_NOTFIXED)
                          //  ->orWhere('seminar_statuses.apply_status', SeminarStatus::APPLY_STATUS_CANCEL);
                    })->get();
        return view('front.seminars.not_register', compact('seminars'));
    }
}

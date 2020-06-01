<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\School;
use App\Models\Event;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\UserCalendarSetting;
use App\Models\CalendarTheme;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\UserCalendarDisplaySetting;

class CalendarController extends Controller
{

    public function index(Request $request)
    {
        Log::info('[CalendarController.index] Start...');
        $calendarId = \Auth::guard('parents')->user()->calendar_id;
        $user_id = \Auth::guard('parents')->user()->id;
        $arr_calendarIdSpecial = [];
        $calendarIdSpecial = Event::getCalendarIdByType();
        if ($calendarIdSpecial->count()) {
            foreach ($calendarIdSpecial as $calendar) {
                $arr_calendarIdSpecial[] = $calendar->id;
            }
        }
        // filter event by school, class, department
        if ($request->filter) {
            // array of calendar_id from url
            $arr_filter = explode(',', $request->filter);
            array_push($arr_filter, $calendarId);
            $arr_filter = array_merge($arr_filter, $arr_calendarIdSpecial);
            $events = Event::filterEventByStudent($arr_filter);
        } else {
            // get all calendar id from save filter in first calendar view.
            $filter_save = UserCalendarDisplaySetting::select('calendar_id')->where('user_id', $user_id)->first();
            $arr_id_filter_save = [];
            if(isset($filter_save->calendar_id)) {
                $arr_id_filter_save = explode(',', $filter_save->calendar_id);
            }
            if(count($arr_id_filter_save) > 0) {
                $arr_calendar_id = $arr_id_filter_save;
            }
            else {
                $arr_calendar_id = $this->getCalendarIdByUser();
            }
            // end get all id calendar save filter

            // get all school, class of user id
            //$arr_calendar_id = $this->getCalendarIdByUser();
            array_push($arr_calendar_id, $calendarId);
            $arr_calendar_id = array_merge($arr_calendar_id, $arr_calendarIdSpecial);
            // show all event by user id
            $events = Event::filterEventByStudent($arr_calendar_id);
        }
        $arr_event_color = Calendar::all()->pluck('event_bgcolor', 'id')->toArray();
        foreach ($events as $e) {
            if ($e['calendars']['type'] == \App\Models\Calendar::TYPE_CALENDAR_HSP) {
                $e->bg_color = $arr_event_color[$e->calendar_id];
            } else {
                if (!isset($e->bg_color) || $e->bg_color == null || $e->bg_color == '') {
                    $e->bg_color = $arr_event_color[$e->calendar_id];
                }
            }
        }
        // get calendar theme
        $getCalendarTheme = Event::getCalendarTheme($user_id);
        $arrListImage = [];
        $theme_calendar = '';
        if ($getCalendarTheme){
            $arrListImage = $getCalendarTheme->getListArrImg();
            $theme_calendar = $getCalendarTheme->background_image;
        }
        Log::info('[CalendarController.index] End...');
        return view('front.calendars.index', compact('arr_event_color', 'events', 'getCalendarTheme', 'theme_calendar', 'arrListImage'));
    }

    // get all calendar id from user id
    function getCalendarIdByUser()
    {
        Log::info('[CalendarController.getCalendarIdByUser] Start...');
        $parents = \Auth::guard('parents')->user();
        $studentParents = $parents->student;
        $studentParents = $studentParents->unique('id');
        $arr_calendar_id = $arr_student_id = [];
        if ($studentParents->count() > 0) {
            foreach ($studentParents as $item) {
                $calendar_school_id = School::findOrFail($item->school_id)->calendar_id;
                $calendar_class_id = SchoolClass::findOrFail($item->school_class_id)->calendar_id;
                array_push($arr_calendar_id, $calendar_school_id, $calendar_class_id);
                $arr_student_id[] = $item->id;
            }
        }
        $depart_calendar = Event::getCalendarIdByDepartment($arr_student_id);
        if ($depart_calendar) {
            foreach ($depart_calendar as $d) {
                array_push($arr_calendar_id, $d->calendar_id);
            }
        }
        Log::info('[CalendarController.getCalendarIdByUser] End...');
        return $arr_calendar_id;
    }

    // view for filter event
    public function share()
    {
        Log::info('[CalendarController.share] Start...');
        $user_id = \Auth::guard('parents')->user()->id;
        $parents = \Auth::guard('parents')->user();
        $studentParents = $parents->student;
        $studentParents = $studentParents->unique('id');
        $arr = $arr_student_id = $arr_key = $arr_key_value = [];
        $studentParents = $studentParents->sortBy("school_id");
        if ($studentParents->count() > 0) {
            foreach ($studentParents as $item) {
                $arr_student_id[] = $item->id;
                $itemS = School::findOrFail($item->school_id);
                $itemC = SchoolClass::findOrFail($item->school_class_id);

                $school_key = 'school' . $item->school_id;
                $class_key = 'class' . $item->school_class_id;

                $arr[$item->id][$school_key][$itemS->calendar_id] = $itemS->name;
                $arr[$item->id][$class_key][$itemC->calendar_id] = $itemC->name;
                $arr_key[$item->id][$school_key] = $school_key;
                $arr_key[$item->id][$class_key] = $class_key;

                $depart_calendar = Student::with('departments')->where('id', $item->id)->first();
                if ($depart_calendar->departments) {
                    foreach ($depart_calendar->departments as $d) {
                        $department_key = 'department' . $d->id;
                        $arr[$item->id][$department_key][$d->calendar_id] = $d->name;
                        $arr_key[$item->id][$department_key] = $department_key;
                    }
                }
            }
        }
        // $arr_key_value is array of all key: school, class, department
        foreach ($arr_key as $j => $item) {
            foreach ($item as $k => $item1) {
                $arr_key_value[$j . '_' . $k] = $item1;
            }
        }
        $arr_key_value_unique = array_unique($arr_key_value);
        // array of different key that remove
        $diff = array_diff_key($arr_key_value, $arr_key_value_unique);
        foreach ($diff as $key => $i) {
            $key1 = explode('_', $key);
            // remove from begin array with diff key
            unset($arr[$key1[0]][$key1[1]]);
        }

        // get all id save when filter event
        $filter_save = UserCalendarDisplaySetting::select('calendar_id')->where('user_id', $user_id)->first();
        $arr_id_filter_save = [];
        if(isset($filter_save->calendar_id)) {
            $arr_id_filter_save = explode(',', $filter_save->calendar_id);
        }

        Log::info('[CalendarController.share] End...');
        return view('front.calendars.share_option', compact('arr', 'arr_id_filter_save'));
    }

    public function shareSave(Request $request)
    {
        $user_id = \Auth::guard('parents')->user()->id;
        $userCalendarSetting = new UserCalendarDisplaySetting();
        if($request->get('filters')) {
            $filter = implode(',', $request->get('filters'));
        }
        else {
            // when user don't select any checkbox for filter, save 0 to calendar_id
            $filter = '0';
            //UserCalendarDisplaySetting::where('user_id', $user_id)->delete();
        }
        $userCalendarSetting::updateOrCreate(
            ['user_id' => $user_id],
            ['calendar_id' => $filter, 'school_id' => 0]
        );

        return view('front.calendars.filter_complete', compact('filter'));
    }

    public function filterComplete(Request $request)
    {
        $filter = '';
        if(isset($request->filter)) {
            $filter = $request->filter;
        }
        return view('front.calendars.filter_complete', compact('filter'));
    }

    public function edit()
    {
        Log::info('[CalendarController.edit] Start...');
        $themes = CalendarTheme::get();
        Log::info('[CalendarController.edit] End...');
        return view('front.calendars.edit', compact('themes'));
    }

    // update theme without original
    public function updateTheme(Request $request)
    {
        Log::info('[CalendarController.updateTheme] Start...');
        $user_id = \Auth::guard('parents')->user()->id;
        $calendar_theme_id = $request->calendar_theme_id;
        if ($calendar_theme_id > 0) {
            $userTheme = new UserCalendarSetting;
            $userTheme::updateOrCreate(
                ['user_id' => $user_id], ['calendar_theme_id' => $calendar_theme_id]
            );
            Log::info('[CalendarController.updateTheme] End...');
            return view('front.calendars.theme_complete');
        } else {
            Log::info('[CalendarController.updateTheme] End...');
            return redirect()->route('front.calendar.edit')->with(['message' => '最初に1つのテーマを選択します!',
                'flash_type' => 'alert-danger']);
        }
    }

    public function uploadImage($id)
    {
        Log::info('[CalendarController.uploadImage] Start...');
        $user_id = \Auth::guard('parents')->user()->id;
        $theme = UserCalendarSetting::where('user_id', $user_id)->where('calendar_theme_id', $id)->first();
        Log::info('[CalendarController.uploadImage] End...');
        return view('front.calendars.upload_image', compact('id', 'theme'));
    }

    // store 3 image for theme original
    public function storeImage(Request $request, $id)
    {
        Log::info('[CalendarController.storeImage] Start...');
        // get old image if not change to select file
        $imageName_1 = $request->old_img_1;
        $imageName_2 = $request->old_img_2;
        $imageName_3 = $request->old_img_3;
        // get image if not use camera
        request()->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif',
        ],
            [
                'image' => '',
                'mimes' => 'jpeg, png, jpg, gifタイプのファイルを指定してください。'
            ]);
        $cover_1 = $request->file('image_1');
        $cover_2 = $request->file('image_2');
        $cover_3 = $request->file('image_3');

        if ($cover_1) {
            $extension_1 = $cover_1->getClientOriginalExtension();
            $imageName_1 = date('Y_m_d') . time() . '.' . $extension_1;
            $request->image_1->move(public_path('storage/uploads'), $imageName_1);
        }
        if ($cover_2) {
            $extension_2 = $cover_2->getClientOriginalExtension();
            $imageName_2 = date('Y_m_d') . time() . '.' . $extension_2;
            $request->image_2->move(public_path('storage/uploads'), $imageName_2);
        }
        if ($cover_3) {
            $extension_3 = $cover_3->getClientOriginalExtension();
            $imageName_3 = date('Y_m_d') . time() . '.' . $extension_3;
            $request->image_3->move(public_path('storage/uploads'), $imageName_3);
        }

        $userTheme = new UserCalendarSetting;
        $user_id = \Auth::guard('parents')->user()->id;

        $userTheme::updateOrCreate(
            ['user_id' => $user_id],
            ['calendar_theme_id' => $id, 'image2' => $imageName_2, 'image3' => $imageName_3, 'image1' => $imageName_1]
        );
        Log::info('[CalendarController.storeImage] End...');
        return view('front.calendars.theme_complete');
    }

    public function userEventCreate(Request $request)
    {
        Log::info('[CalendarController.userEventCreate] Start...');
        $date = $request->date;
        Log::info('[CalendarController.userEventCreate] End...');
        return view('front.calendars.user_event_create', compact('date'));
    }

    public function userEventStore(Request $request)
    {
        Log::info('[CalendarController.userEventStore] Start...');
        $request->validate([
            'title' => 'required',
        ], [
            'required' => 'タイトルご入力をお願いします'
        ]);
        if (!$request->get('all_day_event')) {
            $request->validate([
                'start_date' => 'required',
            ], [
                'required' => '時間ご入力をお願いします。'
            ]);
            $request->validate([
                'end_date' => 'required|string|after:start_date',
            ], [
                'required' => '時間ご入力をお願いします。',
                'after' => '終了時間は開始時間より長くなければなりません。'
            ]);
        }

        $date = date('Y-m-d', strtotime($request->get('startdate')));
        $month = date('m', strtotime($request->get('startdate')));
        $params = 'type=month&month=' . $month . '&date=' . $date;

        $calendarId = \Auth::guard('parents')->user()->calendar_id;
        $event = new Event();
        if ($request->get('all_day_event')) {
            $event->type = Event::TYPE_NORMAL;
        } else {
            $event->type = Event::TYPE_ALL_DAY;
        }
        $event->title = $request->get('title');
        //$event->start = Carbon::parse($request->get('startdate') . ' ' . $request->get('start_date'));
        //$event->end = Carbon::parse($request->get('startdate') . ' ' . $request->get('end_date'));
        $event->start = Carbon::parse($request->get('start_date'));
        $event->end = Carbon::parse($request->get('end_date'));
        $event->detail = '';
        $event->calendar_id = $calendarId;
        $event->bg_color = $request->get('data_color');
        $event->remind = $request->get('event_remind');
        $event->save();
        Log::info('[CalendarController.userEventStore] End...');
        return view('front.calendars.event_complete');
    }

    public function userEventEdit($id)
    {
        Log::info('[CalendarController.userEventEdit] Start...');
        $event = Event::findOrFail($id);
        $date_start = date('Y-m-d', strtotime($event->start));
        $date_end = date('Y-m-d', strtotime($event->end));
        Log::info('[CalendarController.userEventEdit] End...');
        return view('front.calendars.user_event_edit', compact('event', 'date_start', 'date_end', 'id'));
    }

    public function userEventUpdate(Request $request, $id)
    {
        Log::info('[CalendarController.userEventUpdate] Start...');
        $where = array('id' => $id);
        $request->validate([
            'title' => 'required',
        ], [
            'required' => 'タイトルご入力をお願いします'
        ]);
        if (!$request->get('all_day_event')) {
            $request->validate([
                'start_date' => 'required',
            ], [
                'required' => '時間ご入力をお願いします。'
            ]);
            $request->validate([
                'end_date' => 'required|string|after:start_date',
            ], [
                'required' => '時間ご入力をお願いします。',
                'after' => '終了時間は開始時間より長くなければなりません。'
            ]);
        }
        if ($request->input('all_day_event')) {
            $type = Event::TYPE_NORMAL;
        } else {  // ON - input: [all_day_event] => 0
            $type = Event::TYPE_ALL_DAY;
        }
        $updateArr = ['title' => $request->title, 'detail' => '', 'type' => $type,
            'start' => Carbon::parse($request->get('start_date')),
            'end' => Carbon::parse($request->get('end_date')),
            'bg_color' => $request->get('data_color'),
            'remind' => $request->get('event_remind')
        ];
        Event::where($where)->update($updateArr);
        $date = date('Y-m-d', strtotime($request->startdate));
        $month = date('m', strtotime($request->startdate));
        $params = 'type=month&month=' . $month . '&date=' . $date;
        Log::info('[CalendarController.userEventUpdate] Start...');
        return view('front.calendars.event_complete');
    }

    public function userEventDestroy(Request $request, $id)
    {
        Log::info('[CalendarController.userEventDestroy] Start...');
        $date = date('Y-m-d', strtotime($request->startdate));
        $month = date('m', strtotime($request->startdate));
        $params = 'type=month&month=' . $month . '&date=' . $date;
        Event::where('id', $id)->delete();
        Log::info('[CalendarController.userEventDestroy] End...');
        return view('front.calendars.event_complete');
    }

    // click calendar one day to show events
    public function showEventByClickCalendar(Request $request)
    {
        Log::info('[CalendarController.showEventByClickCalendar] Start...');
        $user_id = \Auth::guard('parents')->user()->id;
        $start_date = $request['start_date'];
        $calendarId = \Auth::guard('parents')->user()->calendar_id;
        $arr_calendarIdSpecial = [];
        $calendarIdSpecial = Event::getCalendarIdByType();
        if ($calendarIdSpecial->count()) {
            foreach ($calendarIdSpecial as $calendar) {
                $arr_calendarIdSpecial[] = $calendar->id;
            }
        }

        // get all calendar id from save filter
        $filter_save = UserCalendarDisplaySetting::select('calendar_id')->where('user_id', $user_id)->first();
        $arr_id_filter_save = [];
        if(isset($filter_save->calendar_id)) {
            $arr_id_filter_save = explode(',', $filter_save->calendar_id);
        }
        if(count($arr_id_filter_save) > 0) {
            $arr_calendar_id = $arr_id_filter_save;
        }
        else {
            $arr_calendar_id = $this->getCalendarIdByUser();
        }

        //$arr_calendar_id = $this->getCalendarIdByUser();
        array_push($arr_calendar_id, $calendarId);
        $arr_calendar_id = array_merge($arr_calendar_id, $arr_calendarIdSpecial);
        // show all event by user id
        $events = Event::filterEventByStudent($arr_calendar_id);
        foreach ($events as $key => $item) {
            if ($start_date != date('Y-m-d', strtotime($item->start))) {
                unset($events[$key]);
            }
        }

        $arr_event_color = Calendar::all()->pluck('event_bgcolor', 'id')->toArray();
        foreach ($events as $e) {
            if ($e['calendars']['type'] == \App\Models\Calendar::TYPE_CALENDAR_HSP) {
                $e->bg_color = $arr_event_color[$e->calendar_id];
            } else {
                if (!isset($e->bg_color) || $e->bg_color == null || $e->bg_color == '') {
                    $e->bg_color = $arr_event_color[$e->calendar_id];
                }
            }
        }
        $current_date = $date_format = Carbon::parse($start_date)->locale('ja_JA')->isoFormat('ll');
        $html = '<div class="show-event">
        <div class="bar-title">' . $current_date . '</div><div class="list-event">';
        foreach ($events as $e) {
            $html .= '<a href="'. route("front.calendar.event-detail", [$e->id]) . '">';
            $html .= '<div class="event"><div class="time-to">';
            $time = date('H:i', strtotime($e->start)) . '<br>' . date('H:i', strtotime($e->end));
            if ($e->allDay != 1) {
                $time = '終日';
            }
            $html .= '<span>' . $time . '</span></div>
            <div class="content-event" style="background-color:' . $e->bg_color . ';">';
            $title = '<span>' . $e->title . '</span></div> </div></a>';
            $html .= $title;
        }
        $html .= '</div></div>';
        Log::info('[CalendarController.showEventByClickCalendar] End...');
        return $html;
    }

    // filter event by user in list view
    public function showEventByMonth(Request $request)
    {
        Log::info('[CalendarController.ShowEventByMonth] Start...');
        $user_id = \Auth::guard('parents')->user()->id;
        $date_now = $request['date'];
        $type = $request['type'];
        $calendarId = \Auth::guard('parents')->user()->calendar_id;
        $arr_calendarIdSpecial = [];
        $calendarIdSpecial = Event::getCalendarIdByType();
        if ($calendarIdSpecial->count()) {
            foreach ($calendarIdSpecial as $calendar) {
                $arr_calendarIdSpecial[] = $calendar->id;
            }
        }

        // get all calendar id from save filter
        $filter_save = UserCalendarDisplaySetting::select('calendar_id')->where('user_id', $user_id)->first();
        $arr_id_filter_save = [];
        if(isset($filter_save->calendar_id)) {
            $arr_id_filter_save = explode(',', $filter_save->calendar_id);
        }
        if(count($arr_id_filter_save) > 0) {
            $arr_calendar_id = $arr_id_filter_save;
        }
        else {
            $arr_calendar_id = $this->getCalendarIdByUser();
        }
        //$arr_calendar_id = $this->getCalendarIdByUser();
        array_push($arr_calendar_id, $calendarId);
        $arr_calendar_id = array_merge($arr_calendar_id, $arr_calendarIdSpecial);
        // show all event by user id
        $events = Event::filterEventByStudent($arr_calendar_id);

        foreach ($events as $e) {
            if ($e['calendars']['type'] == \App\Models\Calendar::TYPE_CALENDAR_HSP) {
                $e->title_color = 'red';
                $e->bg_color = $e->calendars->event_bgcolor;
                $e->date_color = 'red';
            } else {
                $e->title_color = '';
                $e->date_color = '';
                if ($e->bg_color == '' || $e->bg_color == null) {
                    $e->bg_color = $e->calendars->event_bgcolor;
                }
            }
        }

        if ($type == 'month') {
            $current_month = $request['month'];
            foreach ($events as $key => $item) {
                if ($current_month != date('m', strtotime($item->start))) {
                    unset($events[$key]);
                }
            }
        } elseif ($type == 'week') {
            $current_day = $request['date'];
            $arr_week = getCurrentWeekDates($current_day);
        } else {
            foreach ($events as $key => $item) {
                if ($date_now != date('Y-m-d', strtotime($item->start))) {
                    unset($events[$key]);
                }
            }
        }

        // get all date by one month
        $start_date = "01-" . date('m', strtotime($date_now)) . '-' .
            date('Y', strtotime($date_now));
        $start_time = strtotime($start_date);
        $end_time = strtotime("+1 month", $start_time);
        $arr_date = []; // array all date with event + without event

        for ($j = $start_time; $j < $end_time; $j += 86400) {
            $arr_date[date('Y-m-d', $j)] = date('Y-m-d', $j);
        }

        $arr_event = []; // array date with event
        foreach ($events as $k => $i) {
            $date1 = date('Y-m-d', strtotime($i->start));
            if (in_array($date1, $arr_date)) {
                $arr_event[$date1][] = $i->toArray();
            }
        }

        $arr_date = array_merge($arr_date, $arr_event);
        if ($type == 'date') {
            foreach ($arr_date as $k => $item) {
                if (!is_array($item)) {
                    unset($arr_date[$k]);
                }
            }
        }
        // check color for special event
        $arr_special_color = [];
        foreach ($arr_date as $k => $event1) {
            if (isset($event1) && is_array($event1)) {
                foreach ($event1 as $event) {
                    if ($event['calendars']['type'] == \App\Models\Calendar::TYPE_CALENDAR_HSP) {
                        $arr_special_color[$k] = 'red';
                    } else {
                        $arr_special_color[$k] = '';
                    }
                }
            }
        }

        $arr_event_color = Calendar::all()->pluck('event_bgcolor', 'id')->toArray();
        Log::info('[CalendarController.ShowEventByMonth] End...');
        return view('front.calendars.event_by_month', compact('arr_special_color', 'arr_event_color', 'calendarId', 'arr_date', 'date_now'));
    }

    public function eventDetail($id)
    {
        $calendar_user = \Auth::guard('parents')->user()->calendar_id;
        $event = Event::findOrFail($id);
        $date_start = date('Y-m-d', strtotime($event->start));
        $date_end = date('Y-m-d', strtotime($event->end));
        return view('front.calendars.event_detail', compact('event','id','date_start','date_end','calendar_user'));
    }
}

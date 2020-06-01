<?php

namespace App\Http\Controllers\TopAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\School\SchoolRequest;
use App\Http\Requests\School\TopAdminRequest;
use App\Models\Calendar;
use App\Models\Event;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\SchoolPasscode;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ResetsPasswords;
use MongoDB\Driver\Session;
use URL;
use Log;
use DB;

class CalendarController extends Controller
{
    use ResetsPasswords;
    private $school;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(School $school)
    {
        $this->middleware('auth:topadmin');
        $this->school = $school;
    }

    public function calendar(){
        return view('top_admin.calendar.index');
    }

    public function create(Request $request)
    {
        for ($i = 0; $i <= 5; $i++) {
            $year = 'year' . $i;
            $month = 'month' . $i;
            $date = 'date' . $i;
            $subject = 'subject' . $i;
            $datetime = $request->$year . '-' . $request->$month . '-' . $request->$date;
            $content = $request->$subject;
            if (empty($content)){
                continue;
            }
            $event = new Event();
            $calendarId = Calendar::query()->where('type', '=', 'hsp')->pluck('id')->first();
            $event->detail = $content;
            $event->calendar_id = $calendarId;
            $event->type = 1;
            $event->start = $datetime;
            $event->title = $content;
            $event->remind = 0;
            $event->reminder_sent = 0;
            $event->save();
        }
        session()->flash('message', __('calendar.topadmin.action.created'));
        return redirect()->route('top_admin.calendar.index');
    }

    public function edit()
    {
        $calendar = Calendar::where('type', 'hsp')->firstOrfail();
        $detail = [];
        foreach ($calendar->events as $event) {
            $date = \Carbon\Carbon::parse($event->start)->format('Y-m-d');
            $detail[$event->id]['id'] = $event->id;
            $detail[$event->id]['date'] = $date;
            $detail[$event->id]['title'] = $event->title;
        }
        return view('top_admin.calendar.edit', ['detail' => $detail]);
    }

    public function update(Request $request, $id){
        $params = $request->all();
        $event = Event::query()->find($id);
        // $event->start = $params['year'];
        $event->title = $params['title'];
        $event->save();
        session()->flash('message', __('calendar.topadmin.action.updated'));
        return redirect()->route('top_admin.calendar.edit_calendar');
    }

    public function destroy(Request $request)
    {
        Log::info('[CalendarController.destroy] Start...');
        Event::find($request->id)->delete();
        // dd($request->id);
        // $school->delete();

        session()->flash('message', __('calendar.topadmin.action.deleted'));

        Log::info('[CalendarController.destroy] Delete...');
        return redirect()->route('top_admin.calendar.edit_calendar');
    }
}

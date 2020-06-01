<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;

class CalendarController extends Controller
{
    public function index()
    {
        $calendars = auth()->user()->accessibleCalendars()->get();
        $events = Event::whereIn('calendar_id', $calendars->pluck('id'))->with('calendar')->get();

        return view('admin.calendar.index', ['events' => $events]);
    }
}

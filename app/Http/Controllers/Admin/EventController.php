<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\CreateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $event = new Event();
        $event->prepare();

        return view('admin.calendar.event.form', ['event' => $event]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEventRequest $request)
    {
        if ('continue' === $request->input('action')) {
            return redirect()->route('admin.event.create')->withInput();
        }
        $event = new Event();
        $event->createFromRequest($request->all());

        session()->flash('message', __('event.action.created'));

        return redirect()->route('admin.calendar.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $event->prepare();

        return view('admin.calendar.event.form', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $event->updateFromRequest($request->all());

        session()->flash('message', __('event.action.updated'));

        return redirect()->route('admin.calendar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        session()->flash('message', __('event.action.deleted'));

        return redirect()->route('admin.calendar.index');
    }
}

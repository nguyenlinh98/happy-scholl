<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolEvent\CreateSchoolEventRequest;
use App\Http\Requests\SchoolEvent\UpdateSchoolEventRequest;
use App\Models\SchoolEvent;
use Illuminate\Http\Request;

class SchoolEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = 'reservation' === $request->query('view', 'reservation') ? SchoolEvent::STATUS_RESERVATION : SchoolEvent::STATUS_DISTRIBUTED;
        $schoolEvents = SchoolEvent::where('status', $status)->get();

        return view('admin.school-event.index')->with(['schoolEvents' => $schoolEvents]);
    }

    public function confirm(CreateSchoolEventRequest $request, SchoolEvent $schoolEvent = null)
    {
        if (is_null($schoolEvent)) {
            $schoolEvent = new SchoolEvent();
        }
        $schoolEvent->confirm($request);

        return view('admin.school-event.confirm', ['schoolEvent' => $schoolEvent]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schoolEvent = new SchoolEvent();
        $schoolEvent->prepare();

        return view('admin.school-event.create', ['schoolEvent' => $schoolEvent]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSchoolEventRequest $request)
    {
        if ($request->filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.school_event.create')->withInput();
        }

        $schoolEvent = new SchoolEvent();
        $schoolEvent->createNew($request);

        session()->flash('action', 'created');

        return redirect()->route('admin.school_event.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolEvent $schoolEvent)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolEvent $schoolEvent)
    {
        $schoolEvent->prepareForEdit();

        return view('admin.school-event.edit', ['schoolEvent' => $schoolEvent]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSchoolEventRequest $request, SchoolEvent $schoolEvent)
    {
        if ($request->filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.school_event.edit', $schoolEvent)->withInput();
        }
        $schoolEvent->updateFrom($request);

        session()->flash('action', 'updated');

        return redirect()->route('admin.school_event.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolEvent $schoolEvent)
    {
        $schoolEvent->clearImageFolder();
        $schoolEvent->delete();

        session()->flash('action', 'deleted');

        return redirect()->route('admin.school_event.index');
    }
}

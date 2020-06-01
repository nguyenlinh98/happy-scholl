<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Meeting\CreateMeetingRequest;
use App\Http\Requests\Meeting\UpdateMeetingRequest;
use App\Models\Meeting;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meetings = Meeting::where('status', Meeting::STATUS_SENT)->with('receivers.receiver')->get();

        return view('admin.meeting.index', ['meetings' => $meetings]);
    }

    /**
     * Display listing of scheduling letters.
     */
    public function scheduling()
    {
        $meetings = Meeting::where('status', Meeting::STATUS_CREATED)->with('receivers.receiver')->get();

        return view('admin.meeting.scheduling', ['meetings' => $meetings, 'editable' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pageTitle = 'collection' === $request->query('type', 'collection') ? 'お手紙' : '個別のお手紙';

        $meeting = new Meeting();
        $meeting->prepare([
            'is_individuals' => 'collection' !== $request->query('type', 'collection'),
        ]);

        return view('admin.meeting.create', ['title' => $pageTitle, 'meeting' => $meeting]);
    }

    public function showSelectPeople(Request $request)
    {
        $students = $request->query('class_id') ? Student::where('school_class_id', $request->query('class_id'))->get() : [];

        return view('admin.meeting.select', ['students' => $students]);
    }

    public function confirm(CreateMeetingRequest $request, Meeting $meeting)
    {
        if (is_null($meeting)) {
            $meeting = new Meeting();
        }

        $meeting->prepareForConfirm($request);
        $pageTitle = strtolower(Meeting::TYPE_STUDENTS) === strtolower(request()->input('letter_type')) ? '個別のお手紙' : 'お手紙';

        return view('admin.meeting.confirm', ['meeting' => $meeting, 'title' => $pageTitle]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMeetingRequest $request)
    {
        if ($request->filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.meeting.create', ['type' => $request->input('meeting_type', 'collection')])->withInput();
        }

        $meeting = new Meeting();
        $meeting->createNew($request);
        session()->flash('action', 'created');

        return redirect()->route('admin.meeting.index');
    }

    public function students(Meeting $meeting)
    {
        $meeting->loadMissing('receivers.receiver');
        $students = $meeting->receivers->pluck('receiver');

        return view('admin.meeting.students', ['receivers' => $meeting, 'meeting' => $meeting, 'isIndividual' => true]);
    }

    public function classes(Meeting $meeting)
    {
        $meeting->loadMissing('receivers.receiver');
        $classes = $meeting->receivers->pluck('receiver');

        return view('admin.meeting.classes', ['schoolClasses' => $classes, 'meeting' => $meeting]);
    }

    /**
     * Load students for specified class in letter.
     */
    public function class(int $meeting_id, SchoolClass $class)
    {
        $meeting = Meeting::where('id', $meeting_id)->withStudentStatusForClass($class)->first();

        return view('admin.meeting.class', ['schoolClass' => $class, 'meeting' => $meeting]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {
        $meeting->prepareForEdit();

        return view('admin.meeting.edit', ['meeting' => $meeting]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        info(self::class.'::update:start');
        if ($request->filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.meeting.create', ['type' => $request->input('meeting_type', 'collection')])->withInput();
        }

        $meeting->updateFrom($request);

        // auto load html from view 'admin.letter.action.updated'
        session()->flash('action', 'updated');
        // redirect back to scheduling view
        info(self::class.'::update:end');

        return redirect()->route('admin.meeting.scheduling');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
    }
}

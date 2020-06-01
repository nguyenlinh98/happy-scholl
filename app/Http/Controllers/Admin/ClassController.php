<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolClass\SaveSchoolClassRequest;
use App\Models\Calendar;
use App\Models\Event;
use App\Models\PassCode;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Notifications\ClassInformationUpdatedNotification;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $classes = SchoolClass::with(['homeroomTeachers'])->withCount(['parents', 'todayAttendances'])->get();
        $classes = hsp_school()->schoolClasses()->withCount(['students', 'parents', 'todayAttendances'])->with(['homeroomTeachers'])->get();

        return view('admin.class.index', ['classes' => $classes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $class = new SchoolClass();
        $class->prepare();

        return view('admin.class.form', ['class' => $class]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SaveSchoolClassRequest $request)
    {
        $user = Auth::user();

        // Add default calendar for school
        $calendar = new Calendar();
        $calendar->name = $request->name;
        $calendar->school_id = $user->school_id;
        $calendar->type = Calendar::TYPE_CALENDAR_SCHOOL_CLASS;
        $calendar->save();

        $schoolClass = new SchoolClass();
        $schoolClass->fill($request->all());
        $schoolClass->school_id = $user->school_id;
        $schoolClass->calendar_id = $calendar->id;
        $schoolClass->save();

        session()->flash('message', __('class.action.created'));

        return redirect()->route('admin.class.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolClass $class)
    {
        $students = $class->students()->with(['todayAttendance'])->get();

        return view('admin.class.show', ['class' => $class, 'students' => $students]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolClass $class)
    {
        $class->prepare();

        return view('admin.class.form', ['class' => $class]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SaveSchoolClassRequest $request, SchoolClass $class)
    {
        $class->make($request->all());

        // $class->notify(new ClassInformationUpdatedNotification($class));

        session()->flash('message', __('class.action.updated'));

        return redirect()->route('admin.class.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolClass $class)
    {
        DB::transaction(function () use ($class) {
            //TODO delete student id contact, class letter, class message ...
            Student::where('school_class_id', $class->id)->delete();
            Event::where('calendar_id', $class->calendar_id)->delete();
            Calendar::find($class->calendar_id)->delete();
            $class->delete();
            session()->flash('message', __('class.action.deleted'));
        });

        return redirect()->route('admin.class.index');
    }

    public function getStudent($id)
    {
        $students = Student::query('name')->where('school_class_id', '=', $id)->get();
        $class = SchoolClass::query()->where('id', '=', $id)->first();

        return view('admin.class.student', ['class' => $class, 'students' => $students]);
    }

    public function passcode(Request $request, SchoolClass $class)
    {
        if ('generate' === $request->input('action')) {
            $student = Student::find($request->input('student_id'));
            $passcode = PassCode::generate($student->id);
            $pdf = PDF::loadView('admin.class.pdf.single', ['student' => $student, 'passcode' => $passcode->passcode, 'title' => $student->name]);

            return $pdf->download("{$student->name}.pdf");

            return view('admin.class.pdf.single', ['student' => $student, 'passcode' => $passcode->passcode, 'title' => $student->name]);
        }
        if ('generateAll' === $request->input('action')) {
            $class->loadMissing('students');
            $passcodeList = [];
            foreach ($class->students as $student) {
                $passcode = PassCode::generate($student->id);
                $passcodeList[$student->id] = $passcode;
            }

            $pdf = PDF::loadView('admin.class.pdf.class', ['passcodeList' => $passcodeList, 'class' => $class, 'title' => $class->name]);

            return $pdf->download("{$class->name}.pdf");
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\CreateTeacherRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display teacher index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.teacher.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ('teachers' === $request->query('view')) {
            $teachers = Teacher::free()->get();

            return view('admin.teacher.list', ['teachers' => $teachers]);
        }
        if ('departments' === $request->query('view')) {
            $departments = Department::withManagers()->orderBy('name', 'ASC')->get();

            return view('admin.teacher.list', ['departments' => $departments]);
        }
        if ('homeroom' === $request->query('view', 'homeroom')) {
            $classes = SchoolClass::hasHomeroomTeachers()->orderBy('name', 'ASC')->get();

            return view('admin.teacher.list', ['classes' => $classes]);
        }

        return view('admin.teacher.list');
    }

    public function confirm(CreateTeacherRequest $request, Teacher $teacher = null)
    {
        if (is_null($teacher)) {
            $teacher = new Teacher();
        }

        $teacher->prepareForConfirm();

        return view('admin.teacher.confirm', ['teacher' => $teacher]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teacher = new Teacher();
        $teacher->prepare();

        return view('admin.teacher.create', ['teacher' => $teacher]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTeacherRequest $request)
    {
        if ($request->filled('reject_x')) {
            return redirect()->route('admin.teacher.create')->withInput();
        }
        $teacher = new Teacher();
        $teacher->createFromRequest($request);

        session()->flash('message', __('teacher.action.created'));

        return redirect()->route('admin.teacher.list');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        $teacher->prepareForEdit();

        return view('admin.teacher.edit', ['teacher' => $teacher]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        if ($request->filled('reject_x')) {
            return redirect()->route('admin.teacher.edit', $teacher)->withInput();
        }

        $teacher->updateFromRequest($request);

        session()->flash('message', __('teacher.action.updated'));

        return redirect()->route('admin.teacher.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        session()->flash('message', __('teacher.action.destroyed'));

        return redirect()->route('admin.teacher.list');
    }
}

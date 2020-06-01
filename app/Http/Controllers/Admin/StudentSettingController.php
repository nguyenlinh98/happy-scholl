<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CSVFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ImportStudentRequest;
use App\Http\Requests\Student\StudentRequest;
use App\Models\SchoolClass;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StudentSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $students = Student::all();
        $schoolClasses = hsp_school()->schoolClasses()->withCount(['students', 'parents', 'todayAttendances'])->with(['homeroomTeachers'])->get();

        return view('admin.student-setting.index', ['schoolClasses' => $schoolClasses]);
    }

    public function viewClass(Request $request, SchoolClass $schoolClass)
    {
        $students = $schoolClass->students()->withCount(['parents'])->with('todayAttendance')->get();

        return view('admin.student-setting.class')->with([
            'students' => $students,
            'schoolClass' => $schoolClass,
            'title' => $schoolClass->name,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        $student = new Student();
        $student->fill($request->all());
        $user = Auth::user();
        $student->school_id = $user->school_id;
        $student->save();

        session()->flash('message', __('student.action.created'));

        return redirect()->route('admin.student_setting.class', ['class' => $request->school_class_id]);
    }

    public function massDelete(Request $request)
    {
        try {
            DB::beginTransaction();
            if (filled($request->input('delete_student_ids'))) {
                Student::destroy($request->input('delete_student_ids'));
                session()->flash('message', __('student.action.deleted'));
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw($e);
        }

        return redirect()->back();
    }

    public function import(ImportStudentRequest $request, SchoolClass $schoolClass)
    {
        if ($request->filled('reject_x')) {
            return redirect()->route('admin.student_setting.class', $schoolClass);
        }
        try {
            $students = collect();
            foreach ($request->input('students') as $student) {
                if ('false' === $student['is_invalid']) {
                    $studentModel = new Student();
                    $studentModel->fill($student);
                    $students->push($studentModel);
                }
            }
            $schoolClass->students()->saveMany($students);
            session()->flash('message', __('student.action.imported'));
        } catch (Exception $e) {
            report($e);
            session()->flash('message', __('student.action.import_failed'));
        }

        return redirect()->route('admin.student_setting.class', $schoolClass);
    }

    /**
     * Read data from csv file and prepare for confirmation.
     */
    public function verify(Request $request, SchoolClass $schoolClass)
    {
        if (!$request->hasFile('csv_file')) {
            return redirect()->route('admin.student_setting.confirm', $schoolClass)->withErrors(['csv_file' => 'Invalid file']);
        }
        $csv = new CSVFile($request->file('csv_file'));
        // comparing headers
        // TODO: Fix utf-8 comparing string
        // TODO: remove || true when done
        if ($csv->header === ['お子様', 'ｾｲ', 'ﾒｲ', '性別'] || true) {
            $students = [];
            foreach ($csv->data as $row) {
                $students[] = [
                    'name' => $row[0],
                    'first_name' => $row[1],
                    'last_name' => $row[2],
                    'gender' => '男性' === $row[3] ? 1 : 0,
                    'is_invalid' => (in_array('', $row) || in_array(null, $row)) ? true : false,
                ];
            }

            return redirect()->route('admin.student_setting.confirm', $schoolClass)->withInput([
                'students' => $students,
                'school_class_id' => $request->input('school_class_id'),
            ]);
        } else {
            throw ValidationException::withMessages(['csv_file' => 'File header invalid'])->redirectTo(route('admin.student_setting.confirm', $schoolClass));
        }

        return redirect()->back();
    }

    public function confirm(SchoolClass $schoolClass)
    {
        // if (is_null(old('students'))) {
        //     return redirect()->route('admin.student_setting.class', $schoolClass);
        // }

        return view('admin.student-setting.confirm')->with(['schoolClass' => $schoolClass]);
    }
}

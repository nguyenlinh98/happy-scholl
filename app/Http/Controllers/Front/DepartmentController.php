<?php
/**
 * User: JohnAVu
 * Date: 2020-01-15
 * Time: 09:55
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{
    const GUARD = 'parents';

    /**
     * @var School
     */
    protected $school;

    protected $department;

    protected $student;

    /**
     * DepartmentController constructor.
     * @param School $school
     * @param Department $department
     * @param Student $student
     */
    public function __construct(
        School $school,
        Department $department,
        Student $student
    )
    {
        $this->school = $school;
        $this->department = $department;
        $this->student = $student;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        Log::info('[DepartmentController.index] Start...');
        if (!Session::get('school_id')) {
            return redirect()->route('front.school.choose');
        }

        $students = getStudent();

        if (!$students) {
            return redirect()->route('front.school.choose');
        }


        if (count($students) == 1) {
            return redirect()->route('departments.list', $students->first()->id);
        }

        $school = $this->getSchool(Session::get('school_id'));
        Log::info('[DepartmentController.index] End...');
        return view('front.departments.index', compact('students', 'school'));
    }

    /**
     * @param $studentId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getList($studentId)
    {
        Log::info('[DepartmentController.getList] Start...');
        if (!Session::get('school_id')) {
            return redirect()->route('front.school.choose');
        }
        $listDepartment = $this->department->getListDepartmentBySchool(Session::get('school_id'));

        $student = $this->getStudent($studentId);

        $departmentChoose = $student->departments->pluck('id');
        Log::info('[DepartmentController.getList] Start...');
        return view('front.departments.list', compact('listDepartment', 'studentId', 'departmentChoose'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function success(Request $request)
    {
        Log::info('[DepartmentController.success] Start...');
        if (!Session::get('school_id')) {
            return redirect()->route('front.school.choose');
        }

        $data = $request->all();
        $student = $this->getStudent($request['studentId']);

        $listDepartments = [];
        if (isset($data['department'])) {
            foreach ($data['department'] as $department) {
                $listDepartments[$department] = [
                    'school_id' => Session::get('school_id')
                ];
            }
        }

        $student->departments()->sync($listDepartments);
        Log::info('[DepartmentController.success] End...');

        return view('front.departments.success', compact('data'));
    }

    /**
     * @param $id
     * @return mixed
     */
    private function getSchool($id)
    {
        return $this->school->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    private function getStudent($id)
    {
        return $this->student->find($id);
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Parents;
use App\Models\ParentStudent;
use App\Models\PassCode;
use App\Models\SchoolPasscode;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class StudentController extends Controller
{
    /**
     * @var passcode
     */
    protected $passCode;
    protected $schoolPasscode;

    /**
     * @var parent
     */
    protected $parent;
    /**
     * @var parentStudent
     */
    protected $parentStudent;
    /**
     * @var Student
     */
    protected $student;
    /**
     * @var School
     */
    protected $school;


    /**
     * StudentController constructor.
     * @param PassCode $passCode
     * @param Parents $parent
     * @param ParentStudent $parentStudent
     * @param Student $student
     */
    public function __construct(PassCode $passCode, Parents $parent, ParentStudent $parentStudent,
                                SchoolPasscode $schoolPasscode, Student $student, School $school)
    {
        $this->passCode = $passCode;
        $this->parent = $parent;
        $this->parentStudent = $parentStudent;
        $this->student = $student;
        $this->school = $school;
        $this->schoolPasscode = $schoolPasscode;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('front.students.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function passcodeSchool()
    {
        return view('front.students.passcode_school');
    }

    public function postSchoolPassCode(Request $request)
    {
        // validate
        Log::info('[StudentController.index] Start...');
        $request->validate([
            'schoolPasscode' => 'required|size:5|regex:/^(?=.*?[a-z]{1})(?=.*?[0-9]{4})/',
        ], [
            'required' => 'パスコードが必要です',
            'size' => 'パスコードは5文字が含まれます',
            'regex' => 'パスコードには4桁の数字と1つの小文字が含まれます'
        ]);

        //validate passcode is not exist or used
        $passCode = $this->schoolPasscode->getActivePasscode($request->get('schoolPasscode'));
        if (!$passCode) {
            Log::info('[StudentController.index] End...');
            return redirect()->route('student.passcodeschool')
                ->withErrors(['パスコードがアクティブではありません']);
        }
        //save data to Session
        \Session::put('create_student', $request->all());
        Log::info('[StudentController.index] End...');

        return redirect()->route('student.passcode');
    }

    public function passcodeShow(Request $request)
    {
        Log::info('[StudentController.passcodeShow] Start...');
        $data = \Session::get('create_student');
        $schoolName = $this->schoolPasscode->getSchoolName($data['schoolPasscode']);

        if (!isset($data['schoolPasscode'])) {
            Log::info('[StudentController.passcodeShow] End...');
            return redirect()->route('student.passcodeschool');
        }
        Log::info('[StudentCotroller.passcodeShow] End...');
        return view('front.students.passcode_show')->with(['schoolName' => $schoolName]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function passcodeComplete(Request $request)
    {
        Log::info('[StudentController.passcodeComplete] Start...');
        $request->validate([
            'passcode' => 'required|size:7|regex:/^(?=.*?[0-9a-zA-Z]{7})/',
        ], [
            'required' => 'パスコードが必要です',
            'size' => 'パスコードには7桁が含まれます',
            'regex' => 'パスコードには7桁が含まれます',
        ]);
        $passCode = $this->passCode->getActivePasscode($request['passcode']);
        if (!$passCode) {
            Log::info('[StudentController.passcodeComplete] End...');
            return redirect()->route('student.passcode')
                ->withErrors(['パスコードが使用されているか存在しない']);
        }
        if (!$passCode->student) {
            Log::info('[StudentController.passcodeComplete] End...');
            return redirect()->route('student.passcode')->withErrors(['パスコードはこの学生のものではありません']);
        }

        $data = \Session::get('create_student');
        $schoolId = $this->schoolPasscode->getSchoolByPasscode($passCode->student->school_id, $data['schoolPasscode']);
        if ($schoolId == 0) {
            Log::info('[StudentController.passcodeComplete] End...');
            return redirect()->route('student.passcode')->withErrors(['学生はこの学校のものではありません']);
        }

        DB::transaction(function () use ($passCode) {
            $parent = Auth::guard('parents')->user();
            $parent->student()->attach($passCode->student->id);
            // Comment for changed spec - no need to deactive
            //$passCode->used = $passCode->used + 1;
            $passCode->save();
        });
        Log::info('[StudentController.passcodeComplete] End...');
        return view('front.students.passcode_complete');
    }


    public function showEdit()
    {
        Log::info('[StudentController.showEdit] Start...');
        $schoolId = Session::get('school_id');
        $school = $this->getSchool($schoolId);
        $studentSchool = $school->student;
        $parents = Auth::guard('parents')->user();
        $studentParents = $parents->student;
        $students = $this->checkStudentOfParents($studentParents, $studentSchool);
        // remove duplicate if data dumpy
        $students = $students->unique('id');
        Log::info('[StudentController.showEdit] End...');

        return view('front.students.showedit', compact('students'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function edit($id)
    {
        Log::info('[StudentController.edit] Start...');
        $student = $this->student->findOrFail($id);
        Log::info('[StudentController.edit] End...');
        return view('front.students.edit', compact('student'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function confirmEdit(Request $request, $id)
    {
        Log::info('[StudentController.confirmEdit] Start...');
        $validatedData = Validator::make($request->all(), [
            'name' => ['required',],
            'class' => ['required'],
            'sex' => ['required'],
            'image' => ['mimes:jpeg,png,heif,heic'],
            'file_patch' => ['sometimes'],
        ])->validate();
        $student = $this->student->findOrFail($id);
        $imageName_1 = $student->avatar;
        $file_input_status = '';

        if ($request->file('image_camera')) {
            $cover_1 = $request->file('image_camera');
            $extension_1 = $cover_1->getClientOriginalExtension();
            $imageName_1 = pathinfo($cover_1->getClientOriginalName(), PATHINFO_FILENAME) . date('Y_m_d') . time() . '.' . $extension_1;
            Storage::disk('public')->put('uploads/' . $imageName_1, File::get($cover_1));
            $file_input_status = 1;
        }

        if ($request->file('image')) {
            $cover_1 = $request->file('image');
            $extension_1 = $cover_1->getClientOriginalExtension();
            $imageName_1 = pathinfo($cover_1->getClientOriginalName(), PATHINFO_FILENAME) . date('Y_m_d') . time() . '.' . $extension_1;
            Storage::disk('public')->put('uploads/' . $imageName_1, File::get($cover_1));
            $file_input_status = 1;
        }

        if (!$student) {
            Log::info('[StudentController.confirmEdit] End...');
            return redirect()->route('student.edit')->withErrors(['Student not found']);
        }
        Log::info('[StudentController.confirmEdit] End...');
        return view('front.students.confirm_edit',
            [
                'id' => $id,
                'data' => $validatedData,
                'student' => $student,
                'avatar' => $imageName_1,
                'file_input_status' => $file_input_status,
                'class' => SchoolClass::find($validatedData['class'])
            ]);
    }

    public function confirmDelete(Request $request, $id)
    {
        Log::info('[StudentController.confirmDelete] Start...');
        $student = $this->student->findOrFail($id);
        if (!$student) {
            Log::info('[StudentController.confirmDelete] End...');
            return redirect()->route('student.edit')->withErrors(['Student not found']);
        }
        Log::info('[StudentController.confirmDelete] End...');
        return view('front.students.confirm_delete',
            [
                'id' => $id,
                'student' => $student,
                'class' => SchoolClass::find($student->school_class_id)
            ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request, $id)
    {
        Log::info('[StudentController.update] Start...');
        $data = $request->only('name', 'school_class_id', 'gender', 'avatar');
        $act = 1;
        $student = $this->student->find($id);
        if (!$student) {
            Log::info('[StudentController.update] End...');
            return redirect()->route('student.edit')->withErrors(['Student not found']);
        }

        if ($request->get('cancel') != 'cancel') {
            $student->update($data);
            Log::info('[StudentController.update] End...');
            return view('front.students.success', compact('student', 'act'));
        } else {
            if (isset($data['avatar'])) {
                $file = public_path() . '/storage/uploads/' . $data['avatar'];
                if (is_file($file) && $request->input('file_input_status') == 1) {
                    unlink($file);
                }
            }
            Log::info('[StudentController.update] End...');
            return redirect()->route('student.edit', [$id]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Log::info('[StudentController.destroy] Start...');
        $student = $this->student->findOrFail($id);
        $user_id = \Auth::guard('parents')->user()->id;
        // // delete this because dumpy data
        // $arr = ParentStudent::withTrashed()->where('user_id', $user_id)->where('student_id', $id)->get();
        // foreach ($arr as $item) {
        //     ParentStudent::where('id', $item->id)->forcedelete();
        // }

        try {
            DB::transaction(function () use ($student, $user_id, $id) {
                $arr = ParentStudent::where('user_id',$user_id)->where('student_id',$id)->get();
                foreach($arr as $item) {
                    ParentStudent::where('id',$item->id)->delete();
                }
            });
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        Log::info('[StudentController.destroy] End...');
        return view('front.students.success', compact('student'));
    }

    /**
     * @param $param
     * @param $folder
     * @return string
     */
    protected function saveImgBase64($param, $folder)
    {
        Log::info('[StudentController.saveImgBase64] Start...');
        list($extension, $content) = explode(';', $param);
        $tmpExtension = explode('/', $extension);
        preg_match('/.([0-9]+) /', microtime(), $m);
        $fileName = sprintf('img%s%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);
        $content = explode(',', $content)[1];
        $storage = Storage::disk('public');
        $checkDirectory = $storage->exists($folder);

        if (!$checkDirectory) {
            $storage->makeDirectory($folder);
        }
        $storage->put($folder . '/' . $fileName, base64_decode($content), 'public');
        Log::info('[StudentController.saveImgBase64] End...');
        return $fileName;
    }

    private function getSchool($id)
    {
        return $this->school->find($id);
    }

    private function checkStudentOfParents($studentParents, $studentSchool)
    {
        Log::info('[StudentController.checkStudentOfParents] Start...');
        $studentDupes = collect([]);
        $studentParents->each(function ($item) use ($studentSchool, $studentDupes) {
            if ($studentSchool->contains($item) !== false) {
                $studentDupes->push($item);
            }
        });
        Log::info('[StudentController.checkStudentOfParents] End');
        return $studentDupes;
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Contact;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    protected $school;

    protected $student;

    protected $currentStudent;

    protected $contact;

    public function __construct(
        School $school,
        Student $student,
        Contact $contact
    )
    {
        $this->school = $school;
        $this->student = $student;
        $this->contact = $contact;
    }

    public function index()
    {
        Log::info('[ContactController.index] Start...');
        if (!Session::get('school_id')) {
            Log::info('[ContactController.index] End...');
            return redirect()->route('front.school.choose');
        }

        $students = getStudent();

        if (!$students) {
            Log::info('[ContactController.index] End...');
            return redirect()->route('front.school.choose');
        }

        if (count($students) == 1) {
            Log::info('[ContactController.index] End...');
            return redirect()->route('front.contact.list', $students->first()->id);
        }

        $school = $this->getSchool(Session::get('school_id'));
        Log::info('[ContactController.index] End...');
        return view('front.contacts.index', compact('students', 'school'));
    }


    public function getList($studentId, Request $request)
    {
        Log::info('[ContactController.getList] Start...');
        if (!Session::get('school_id')) {
            return redirect()->route('front.school.choose');
        }
        $currentStudent = $this->getCurrentStudent($studentId);


        $sort = 'asc';
        if ($request->get('sort') == 'desc') {
            $sort = $request->get('sort');
        }
        $listStudent = $this->student->sortStudentByNameHasContact($currentStudent->school_class_id, $sort);
        Log::info('[ContactController.getList] End...');
        return view('front.contacts.list', compact('listStudent', 'currentStudent', 'sort'));
    }

    public function create($studentId)
    {
        Log::info('[ContactController.create] Start...');
        $currentStudent = $this->getCurrentStudent($studentId);
        $contactOfCurrentStudent = $currentStudent->contact;

        $translation = [
            'startWithZero' => translate('電話番号は0桁の数字の開始が含まれます。'),
        ];
        Log::info('[ContactController.create] End...');
        return view('front.contacts.create', compact('studentId', 'translation', 'contactOfCurrentStudent'));
    }

    public function complete(Request $request, $studentId)
    {
        Log::info('[ContactController.complete] Start...');
        $data = $request->validate(
            [
                'tel' => ['required', 'regex:/^[0-9]{10,12}$/'],
                'relationship' => 'required|string',
            ],
            [
                // 'required' => translate('パスコードが必要です。'),// default 必須項目です OK
                'regex' => translate('電話番号形式が無効です。'),
                // 'numeric' => translate('電話番号は数字のみが含まれます。'),
                // 'size' => translate('電話番号は8文字以上が含まれます。'),
                // 'unique' => translate('電話番号は既に存在しています。'),
            ]);
        $data = $request->all();
        $contact = $this->contact;
        $contact->student_id = $studentId;
        $contact->relationship = $data['relationship'];
        $contact->tel = $data['tel'];
        $contact->school_id = Session::get('school_id');
        $contact->save();
        Log::info('[ContactController.complete] End...');
        return view('front.contacts.complete',compact('studentId'));

    }

    public function show($currentStudentId, $studentId)
    {
        Log::info('[ContactController.show] Start...');
        $student = $this->getCurrentStudent($studentId);

        $contacts = $student->contact;
//       dd ($contacts);
        Log::info('[ContactController.show] End...');
        return view('front.contacts.show', compact('contacts', 'student', 'currentStudentId'));
    }

    public function edit($studentId, $contactId)
    {
        Log::info('[ContactController.edit] Start...');
        $contact = $this->getCurrentContact($contactId);

        $student = $this->getCurrentStudent($studentId);

        $translation = [
            'startWithZero' => translate('電話番号は0桁の数字の開始が含まれます。'),
        ];
        Log::info('[ContactController.edit] End...');
        return view('front.contacts.edit', compact('contact', 'student', 'translation'));
    }

    public function save(Request $request, $studentId, $contactId)
    {
        Log::info('[ContactController.save] Start...');
        $data = $request->validate([
            'tel' => ['required', 'regex:/^[0-9]{10,12}$/'],
        ],
            [
                // 'required' => translate('パスコードが必要です。'),// default 必須項目です OK
                'regex' => translate('電話番号形式が無効です。'),
                // 'numeric' => translate('電話番号は数字のみが含まれます。'),
                // 'size' => translate('電話番号は8文字以上が含まれます。'),
                // 'unique' => translate('電話番号は既に存在しています。'),
            ]);

        $student = $this->getCurrentStudent($studentId);

        $contact = $this->getCurrentContact($contactId);
        $contact->tel = $data['tel'];
        $contact->save();
        Log::info('[ContactController.save] End...');
        return view('front.contacts.complete_edit', compact('student'));
    }

    public function delete($studentId, $contactId)
    {
        Log::info('[ContactController.delete] Start...');
        $student = $this->getCurrentStudent($studentId);

        $contact = $this->getCurrentContact($contactId);
        $contact->delete();
        Log::info('[ContactController.delete] End...');

        return view('front.contacts.complete_delete', compact('student'));
    }

    private function getCurrentStudent($studentId)
    {
        return $this->student->with('contact')->find($studentId);
    }

    private function getCurrentContact($contactId)
    {
        return $this->contact->find($contactId);
    }

    /**
     * @param $id
     * @return mixed
     */
    private function getSchool($id)
    {
        return $this->school->find($id);
    }
}

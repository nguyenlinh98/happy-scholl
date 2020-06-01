<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Letter\CreateLetterRequest;
use App\Http\Requests\Letter\UpdateLetterRequest;
use App\Models\Letter;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $letters = Letter::where('status', Letter::STATUS_SENT)->get();

        return view('admin.letter.index', ['letters' => $letters]);
    }

    /**
     * Display listing of scheduling letters.
     */
    public function scheduling()
    {
        $letters = Letter::where('status', Letter::STATUS_CREATED)->get();

        return view('admin.letter.scheduling', ['letters' => $letters, 'editable' => true]);
    }

    public function students(Letter $letter)
    {
        $letter->loadMissing('receivers.receiver');
        $students = $letter->receivers->pluck('receiver');

        return view('admin.letter.students', ['receivers' => $students, 'letter' => $letter, 'isIndividual' => true]);
    }

    public function classes(Letter $letter)
    {
        $letter->loadMissing('receivers.receiver');
        $classes = $letter->receivers->pluck('receiver');

        return view('admin.letter.classes', ['schoolClasses' => $classes, 'letter' => $letter]);
    }

    /**
     * Load students for specified class in letter.
     */
    public function class(int $letter_id, SchoolClass $class)
    {
        $letter = Letter::where('id', $letter_id)->withStudentStatusForClass($class)->first();

        return view('admin.letter.class', ['schoolClass' => $class, 'letter' => $letter]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'collection' === request()->query('type', 'collection') ? 'お手紙' : '個別のお手紙';

        return view('admin.letter.create', ['title' => $pageTitle]);
    }

    /**
     * Confirm before updating/creating resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm(CreateLetterRequest $request, Letter $letter = null)
    {
        if (is_null($letter)) {
            $letter = new Letter();
        }

        $letter->prepareForConfirm();
        $pageTitle = strtolower(LETTER::TYPE_STUDENTS) === strtolower(request()->input('letter_type')) ? '個別のお手紙' : 'お手紙';

        return view('admin.letter.confirm', ['letter' => $letter, 'title' => $pageTitle]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLetterRequest $request)
    {
        if ($request->filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.letter.create', ['type' => $request->input('letter_type', 'group-class')])->withInput();
        }

        $letter = new Letter();
        $letter->createLetter($request);
        session()->flash('action', 'created');

        return redirect()->route('admin.letter.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Letter $letter)
    {
        $letter->loadMissing(['readStatuses', 'readStatuses.student']);

        return view('admin.letter.show', ['letter' => $letter]);
    }

    // Query students from class and generate html
    public function showSelectPeople(Request $request)
    {
        $students = $request->query('class_id') ? Student::where('school_class_id', $request->query('class_id'))->get() : [];

        return view('admin.letter.select', ['students' => $students]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Letter $letter)
    {
        $letter->prepareForEdit();

        return view('admin.letter.edit', ['letter' => $letter]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLetterRequest $request, Letter $letter)
    {
        info(self::class.'::update:start');
        if ($request->filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page

            return redirect()->route('admin.letter.edit', ['type' => $request->input('letter_type', 'group-class'), 'letter' => $letter])->withInput();
        }
        $letter->updateLetter($request);

        // auto load html from view 'admin.letter.action.updated'
        session()->flash('action', 'updated');
        // redirect back to scheduling view
        info(self::class.'::update:end');

        return redirect()->route('admin.letter.scheduling');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schoolClasses = SchoolClass::with('homeroomTeachers')->withCount(['students' => function ($query) {
            return $query->whereHas('contact');
        }])->get();

        return view('admin.contact.index')->with(['schoolClasses' => $schoolClasses]);
    }

    public function class(SchoolClass $schoolClass)
    {
        $students = Student::whereHas('contact')->where('school_class_id', $schoolClass->id)->with('contact')->get();

        return view('admin.contact.class')->with(['students' => $students, 'schoolClass' => $schoolClass]);
    }

    public function massDelete(Request $request)
    {
        if ($request->filled('contacts')) {
            foreach ($request->input('contacts') as $contact_id) {
                Contact::destroy($contact_id);
            }
            session()->flash('action', 'destroyed');
        }

        return back();
    }
}

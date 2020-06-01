<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Notifications\MailContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\School;
use Illuminate\Support\Facades\Session;

class MailController extends Controller
{

    public function index()
    {
        if (!Session::get('school_id')) {
            return redirect()->route('front.school.choose');
        }

        $schoolId = Session::get('school_id');
        $school = School::find($schoolId);

        return view('front.mail.index', compact('school'));
    }

    public function postEmail(Request $request)
    {
        Log::info('[MailController.postEmail] Start...');
        // validate
        $request->validate([
            'email' => 'required|string|email|max:255',
            'school_name' => 'required',
            'name' => 'required',
            'name_kata' => 'required',
            'detail' => 'required',

        ], [
            // 'required' => '必要です',
            // 'string' => 'メールは文字列です',
            // 'email' => 'メールが間違っています',
            // 'unique' => 'メールが存在します',
            'confirmed' => 'メールアドレス上記のものと違います。'
        ]);
        $input = $request->all();
        $input = array(
            'name' => $input['name'],
            'name_kata' => $input['name_kata'],
            'school_name' => $input['school_name'],
            'year' => $input['year'],
            'class_name' => $input['class_name'],
            'tel' => $input['tel'],
            'email' => $input['email'],
            'detail' => $input['detail'],
        );
        Mail::to($input['email'])->send(new MailContact($input));

        Log::info('[MailController.postEmail] End...');
        return redirect()->route('verification.notice')->with('resent', true);
    }
}

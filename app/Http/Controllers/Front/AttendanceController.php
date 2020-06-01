<?php

namespace App\Http\Controllers\Front;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Student;

class AttendanceController extends Controller
{

    protected $attendance;

    public function __construct(
        Attendance $attendance
    )
    {
        $this->attendance = $attendance;
    }

    public function attendance($studentId)
    {
        Log::info('[AttendanceController.attendance] Start...');
        $type = 'attendance';
        $avatar = '';
        $msg = '出席通知';
        $avatar = $this->getAvatar($studentId);
        Log::info('[AttendanceController.attendance] End...');
        return view('front.attendances.create', compact('studentId', 'type', 'avatar', 'msg'));
    }

    public function absence($studentId)
    {
        Log::info('[AttendanceController.absence] Start...');
        $type = 'absence';
        $avatar = '';
        $msg = '欠席通知';
        $avatar = $this->getAvatar($studentId);
        Log::info('AttendanceController.absence');
        return view('front.attendances.create', compact('studentId', 'type', 'avatar', 'msg'));
    }

    public function complete(Request $request, $studentId)
    {
        Log::info('[AttendanceController.complete] Start...');
        $request->validate([
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|max:30'
        ],
            [
                'required' => '必須です。',
                'max' => '30 文字以内で入力してください',
            ]);

        $data = $request->all();

        $attendance = $this->attendance;
        $attendance->type = $data['type'];
        $attendance->content = $data['content'];
        $attendance->student_id = $studentId;
        $attendance->school_id = Session::get('school_id');
        if ($request->has('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $attendance->image = $imageName;
        }

        $attendance->save();
        Log::info('[AttendanceController.complete] End...');
        return redirect()->route('front.attendance.success', $attendance->id);

    }

    public function success($attendanceId)
    {
        Log::info('[AttendanceController.success] Start...');
        $attendance = $this->attendance->find($attendanceId);
        if ($attendance->type == 'attendance') {
            $msg_type = '出席通知';
        } else {
            $msg_type = '欠席通知';
        }
        if (!$attendance) {
            Log::info('[AttendanceController.success] End...');
            return redirect()->route('front.mypage.index');
        }
        Log::info('[AttendanceController.success] End...');
        return view('front.attendances.complete', compact('attendance', 'msg_type'));
    }

    function getAvatar($student_id)
    {
        return Student::findOrFail($student_id);
    }
}

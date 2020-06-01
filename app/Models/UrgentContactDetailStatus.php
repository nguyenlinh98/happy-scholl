<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UrgentContactDetailStatus extends Model
{
    use SoftDeletes;
    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;
    const TYPE_YESNO = 1;
    const TYPE_INPUT = 2;

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function urgentContact()
    {
        return $this->belongsTo(UrgentContact::class);
    }

    public static function getQuestionsByStudent($student_id)
    {
        return UrgentContactDetailStatus::with('urgentContact')->where('student_id', $student_id)->where('status', 0)->get();
    }

    public static function getQuestionsByContactAndStudent($contact_id, $student_id)
    {
        return UrgentContactDetailStatus::where('urgent_contact_id', $contact_id)->where('student_id', $student_id)->where('status', 0)->get();
    }
}
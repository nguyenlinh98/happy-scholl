<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class RequireFeedbackStatuses extends Model
{

    // use SoftDeletes;

    const STATUS_NOTYET = 0;
    const STATUS_OK = 1;
    const STATUS_NG = 2;

    protected $table = 'require_feedback_statuses';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function requireFeedback()
    {
        return $this->belongsTo(RequireFeedback::class, 'require_feedback_id');
    }

    public function getDataByFeedBackIdAndStudentId($feedbackId, $studentId)
    {
        return $this->where('require_feedback_id', $feedbackId)->where('student_id', $studentId)->first();
    }

    public function getCountNotReadByStudent($studentId)
    {
//        dd($studentId);
//        dd($this->where('student_id', $studentId)
//            ->where('feedback', '!=', 0)
//            ->whereHas('requireFeedback', function ($q) {
//                $q->where('deadline', '>=', date('Y-m-d'));
//            })->toSql());
        return $this->where('student_id', $studentId)
            ->where('feedback', RequireFeedbackStatuses::STATUS_NOTYET)
            ->whereHas('requireFeedback', function ($q) {
                $q->where('deadline', '>=', date('Y-m-d'));
            })->count();
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getCountReadByStudent($studentId)
    {
        return $this->where('student_id', $studentId)
            ->where('feedback','!=', RequireFeedbackStatuses::STATUS_NOTYET)
            ->whereHas('requireFeedback', function ($q) {
                $q->where('deadline', '>=', date('Y-m-d'));
            })->count();
    }

    public function getStatusAttribute()
    {
        if ($this->feedback === static::STATUS_OK) {
            return 'ok';
        } else if ($this->feedback === static::STATUS_NG) {
            return 'ng';
        } else {
            return 'notyet';
        }
    }
}

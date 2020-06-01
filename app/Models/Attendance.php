<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'type',
        'student_id',
        'school_id',
        'content',
        'image',
    ];

    const TYPE_ATTENDING = 'attendance';
    const TYPE_ABSENCE = 'absence';

    public function getIsAbsenceAttribute()
    {
        return $this->type === static::TYPE_ABSENCE;
    }
}

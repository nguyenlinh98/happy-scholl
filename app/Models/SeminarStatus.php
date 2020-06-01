<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeminarStatus extends Model
{
    use SoftDeletes;
    protected $table = 'seminar_statuses';
    protected $fillable = [
        'seminar_id',
        'user_id',
        'school_id',
        'apply_status',
        'apply_type',
        'relationship',
        'student_id'
    ];
    //
    const APPLY_STATUS_NOTYET = 0;
    const APPLY_STATUS_APPLY = 1;
    const APPLY_STATUS_ABSENCE = 2;
    const APPLY_STATUS_NOTFIXED = 3;
    const APPLY_STATUS_CANCEL = 4;
    const APPLY_TYPE_SEMINAR = 1;
    const APPLY_TYPE_SEMINAR_HELP = 2;

}

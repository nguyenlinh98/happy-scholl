<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\SchoolScopeTrait;

class Contact extends Model
{
    // use SoftDeletes;
    use SchoolScopeTrait;

    protected $table = 'contacts';

    protected $fillable = [
        'student_id',
        'relationship',
        'tel',
        'school_id',
    ];

    public function student(){
        return $this->belongsTo(Student::class,'student_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentStudent extends Model
{
    // use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    //Add relationships if need

    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }

    public function profile()
    {
         return $this->belongsTo(Student::class,'student_id')->with('schoolClass');
    }
}

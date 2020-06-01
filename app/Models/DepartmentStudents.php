<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\SchoolScopeTrait;

class DepartmentStudents extends Model
{
    // use SoftDeletes;
    use SchoolScopeTrait;

    protected $table = 'department_students';

    public static function boot()
    {
        parent::boot();
    }

}

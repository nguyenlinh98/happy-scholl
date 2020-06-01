<?php

namespace App\Models;

use App\Traits\Models\PreparableModel;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolPasscode extends Model
{
    use PreparableModel;
    // use SoftDeletes;
    protected $table = 'school_passcodes';

    public function getActivePasscode($passcode)
    {
        return $this->where('passcode', $passcode)
            ->where('active', 1)
            ->first();
    }

    public function getSchoolByPasscode($school_id, $passcode)
    {
        return $this->where('passcode', $passcode)->where('school_id', $school_id)->count();
    }

    public function getSchoolName($passcode)
    {
        $rs = School::join('school_passcodes AS sp', 'sp.school_id', '=', 'schools.id')
            ->where('sp.passcode', $passcode)
            ->first();
        return $rs;
    }
}

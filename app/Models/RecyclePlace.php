<?php

namespace App\Models;

use App\Traits\Models\GetConstantsTrait;
use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\PreparableModel;
use Illuminate\Http\Request;

class RecyclePlace extends Model
{
    use GetConstantsTrait;
    use SchoolScopeTrait;
    use PreparableModel;
    protected $table = 'recycle_places';

    protected $fillable = [
        'place',
        'school_id',
    ];
    const DATE_WEEKDAYS = 'weekdays';
    const DATE_WEEKDAYS_AND_SATURDAY = 'weekdays_and_saturdays';
    const DATE_WEEKENDS_AND_HOLIDAYS = 'weekends_and_holidays';
    const DATE_SUNDAYS_AND_HOLIDAYS = 'sundays_and_holidays';
    const DATE_EVERYDAY = 'everyday';

    public function getListPlaceBySchool($schoolId)
    {
        return $this->where('school_id', $schoolId)->get();
    }

    public function recycleProduct()
    {
        return  $this->hasMany(RecyclePlace::class);
    }

    public function createNew(Request $request)
    {
        $this->place = $request->recycle_place_name;
        $this->date = $request->recycle_place_date;
        $this->start_time = $request->recycle_place_start_time;
        $this->end_time = $request->recycle_place_end_time;

        $this->save();
    }

    /**
     * Generate school setting model with provided school $school_id.
     *
     * @param int $school_id ID of school Model in database
     *
     * @version 1.0.0
     */
    public static function generate(int $school_id)
    {
        $model = new self();
        $model->place = '未設定';
        $model->date = '平日';
        $model->start_time = '09:00';
        $model->end_time = '18:00';
        $model->school_id = $school_id;
        $model->save();
    }
}

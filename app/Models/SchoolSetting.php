<?php

namespace App\Models;

use App\Traits\Models\PreparableModel;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\SchoolScopeTrait;

class SchoolSetting extends Model
{
    use PreparableModel;
    use SchoolScopeTrait;
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
        $model->school_id = $school_id;
        $model->save();
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function getBySchoolId($schoolId){
        return $this->where('school_id',$schoolId)->first();
    }

    /**
     * Update Teacher instance from request input and save to database.
     *
     * @param $data Extracted from $request
     *
     * @version 1.0.0
     */
    public function updateFromRequest(array $data)
    {
        $this->fill($data);
        $this->save();
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}

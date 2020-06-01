<?php

namespace App\Models;

use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Model;

class SchoolAdminManage extends Model
{
    use SchoolScopeTrait;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->class_teacher = SchoolClass::class === $model->manage_type && 'yes' === request()->input('homeroom');
        });
    }

    public function schoolClasses()
    {
        return $this->morphedByMany(SchoolClass::class, 'manage');
    }

    public function manage()
    {
        return $this->morphTo();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'user_id');
    }
}

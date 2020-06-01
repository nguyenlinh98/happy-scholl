<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;
use Log;

trait SchoolScopeTrait
{
    use BelongsToSchool;

    public static function bootSchoolScopeTrait()
    {
        if (auth()->check() && auth()->user()->isSchoolAdmin()) {
            static::addGlobalScope('withSchool', function (Builder $builder) {
                $builder->where(self::getTableName().'.school_id', auth()->user()->school_id);
            });
        }

        if (auth()->check() && !auth()->user()->isTopAdmin()) {
            static::creating(function ($model) {
                $model->school_id = auth()->user()->school_id;
            });
        }
    }

    public static function getTableName()
    {
        return (new self())->getTable();
    }
}

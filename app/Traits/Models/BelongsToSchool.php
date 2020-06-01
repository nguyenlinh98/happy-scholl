<?php

namespace App\Traits\Models;

use App\Models\School;

trait BelongsToSchool
{
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}

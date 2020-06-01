<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\SchoolScopeTrait;

class UrgentContactReceiver extends Model
{
    use SchoolScopeTrait;

    const STATUS_NOT_YET = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_FINISH = 2;
    const STATUS_ERROR = 3;

    protected $guarded = [];

    public function receiver()
    {
        return $this->morphTo();
    }

    public function urgentContact()
    {
        return $this->belongsTo(UrgentContact::class);
    }
}

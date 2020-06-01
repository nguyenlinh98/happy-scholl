<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertises extends Model
{
    use SoftDeletes;

    protected $table = 'require_feedbacks';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    //Add relationships if need

    public function receiver()
    {
        return $this->hasMany(RequireFeedbacksReceiver::class, 'require_feedback_id');
    }

    public function status()
    {
        return $this->hasMany(RequireFeedbackStatuses::class, 'require_feedback_id');
    }
}

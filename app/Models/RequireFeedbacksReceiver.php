<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Models\SchoolScopeTrait;

class RequireFeedbacksReceiver extends Model
{
    // use SoftDeletes;
    use SchoolScopeTrait;

    protected $table = 'require_feedbacks_receivers';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public $fillable = [
        'receiver_id',
        'receiver_type',
        'require_feedback_id',
    ];

    public function receiver()
    {
        return $this->morphTo();
    }
}

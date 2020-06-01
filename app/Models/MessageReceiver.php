<?php

namespace App\Models;

use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Model;

class MessageReceiver extends Model
{
    use SchoolScopeTrait;
    public $fillable = [
        'receiver_id',
        'receiver_type',
        'message_id',
    ];

    public function receiver()
    {
        return $this->morphTo();
    }
}

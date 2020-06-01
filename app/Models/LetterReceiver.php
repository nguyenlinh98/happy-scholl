<?php

namespace App\Models;

use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Model;

class LetterReceiver extends Model
{
    use SchoolScopeTrait;
    protected $fillable = [
        'letter_id',
        'receiver_type',
        'receiver_id',
    ];

    public function receiver()
    {
        return $this->morphTo();
    }

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}

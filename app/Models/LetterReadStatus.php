<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\LocalizeDateTimeTrait;

class LetterReadStatus extends Model
{
    use LocalizeDateTimeTrait;
    protected $table = 'letter_statuses';
    //
    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }

    public function getStatusAttribute()
    {
        return $this->read === static::STATUS_READ ? 'read' : 'unread';
    }
}

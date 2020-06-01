<?php

namespace App\Models;

use App\Traits\Models\LocalizeDateTimeTrait;
use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Model;

class MeetingReadStatus extends Model
{
    use SchoolScopeTrait;
    use LocalizeDateTimeTrait;
    protected $table = 'meeting_statuses';

    const STATUS_UNREAD = 0;
    const STATUS_READ = 1;

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function getStatusAttribute()
    {
        return $this->read === static::STATUS_READ ? 'read' : 'unread';
    }
}

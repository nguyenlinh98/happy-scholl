<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageReadStatus extends Model
{
    const STATUS_READ = 1;
    const STATUS_UNREAD = 0;
}

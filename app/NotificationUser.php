<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationUser extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    //Add relationships if need

    public function notificationSetting()
    {
        return $this->belongsTo(NotificationSetting::class, 'app_id');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'user_id', 'user_id');
    }

    public function scopeForCurrentUser(Builder $builder)
    {
        return $builder->where('user_id', auth()->user()->id);
    }

    public function scopeWithNotificationSetting(Builder $builder)
    {
        return $builder->with(['notificationSetting']);
    }
}

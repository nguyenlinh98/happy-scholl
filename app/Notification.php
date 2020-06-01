<?php

namespace App;

use App\Jobs\NotifyViaFirebaseJob;
use App\Traits\Models\UserInteractionModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use UserInteractionModelTrait;
    use SoftDeletes;

    const STATUS_DISABLED = 0;
    const STATUS_CREATED = 1;
    const STATUS_SENT = 2;
    const STATUS_READ = 3;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $with = ['userFrom', 'userTo'];

    public static function boot()
    {
        parent::boot();
        static::creating(function (self $model) {
            $model->status = self::STATUS_CREATED;
        });
        static::created(function (self $model) {
            dispatch(new NotifyViaFirebaseJob($model));
        });
    }

    /**
     *  scope to filter only current notifications.
     *
     * @return Builder
     *  */
    public function scopeForMe(Builder $query)
    {
        return $query->where('user_to', auth()->user()->id);
    }

    public function scopeWithApp(Builder $builder)
    {
        return $builder->with(['app']);
    }

    public function userFrom()
    {
        return $this->belongsTo("App\User", 'user_from');
    }

    public function userTo()
    {
        return $this->belongsTo("App\User", 'user_to');
    }

    public function app()
    {
        return $this->belongsTo(NotificationSetting::class, 'app_id', 'id');
    }

    public function markNotificationAsSent()
    {
        $this->status = self::STATUS_SENT;
        $this->save();
    }

    public function markNotificationAsRead()
    {
        $this->status = self::STATUS_READ;
        $this->save();
    }
}

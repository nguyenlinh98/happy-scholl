<?php

namespace App\Transformers;

// We need to reference the NotificationUser Model
use App\NotificationUser;
// Dingo includes Fractal to help with transformations
use App\Traits\Transformers\RelationAttributeTrait;
use League\Fractal\TransformerAbstract;

class NotificationUserTransformer extends TransformerAbstract
{
    use RelationAttributeTrait;
    protected $defaultIncludes = ['app'];

    public function transform(NotificationUser $item)
    {
        // Specify what elements are going to be visible to the API
        return [
            'id' => $item->id,
            'app_id' => $item->app_id,
            'user_id' => $item->user_id,
            'notification_flag' => $item->notification_flag,
            'created_at' => $item->created_at,
        ];
    }

    public function includeApp(NotificationUser $notificationUser)
    {
        return $this->relationAttribute($notificationUser, 'notificationSetting', NotificationSettingTransformer::class);
    }
}

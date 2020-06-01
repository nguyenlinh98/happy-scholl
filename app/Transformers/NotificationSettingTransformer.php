<?php

namespace App\Transformers;

// We need to reference the NotificationSetting Model
use App\NotificationSetting;
// Dingo includes Fractal to help with transformations
use League\Fractal\TransformerAbstract;

class NotificationSettingTransformer extends TransformerAbstract
{
    public function transform(NotificationSetting $item)
    {
        // Specify what elements are going to be visible to the API
        return [
            'id' => $item->id,
            'app_name' => $item->app_name,
            'notification_content' => $item->notification_content,
            'app_name_jp' => $item->app_name_jp,
            'description' => $item->description,
        ];
    }
}

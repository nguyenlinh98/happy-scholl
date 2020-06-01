<?php

namespace App\Transformers;

// We need to reference the Notification Model
use App\Notification;
// Dingo includes Fractal to help with transformations
use App\Traits\Transformers\RelationAttributeTrait;
use App\Traits\Transformers\UserInteractionTransformerTrait;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    use UserInteractionTransformerTrait;
    use RelationAttributeTrait;
    protected $defaultIncludes = [
        'user_from',
        'user_to',
        'app',
    ];

    public function transform(Notification $item)
    {
        // Specify what elements are going to be visible to the API
        return [
            'id' => $item->id,
            'content' => $item->content,
            'status' => $item->status,
            'created_at' => $item->created_at,
            'app_id' => $item->app_id,
        ];
    }

    public function includeApp(Notification $notification)
    {
        return $this->relationAttribute($notification, 'app', NotificationSettingTransformer::class);
    }
}

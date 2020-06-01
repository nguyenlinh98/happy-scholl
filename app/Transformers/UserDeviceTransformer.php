<?php

namespace App\Transformers;

// We need to reference the Notification Model
use App\Notification;
// Dingo includes Fractal to help with transformations
use App\Traits\Transformers\RelationAttributeTrait;
use App\Traits\Transformers\UserInteractionTransformerTrait;
use League\Fractal\TransformerAbstract;

class UserDeviceTransformer extends TransformerAbstract
{
    public function transform(Notification $item)
    {
        // Specify what elements are going to be visible to the API
        return [
            'id' => $item->id,
            'user_id' => $item->user_id,
            'device_token' => $item->device_token,
        ];
    }
}

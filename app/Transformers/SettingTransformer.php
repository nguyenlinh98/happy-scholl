<?php

namespace App\Transformers;

// We need to reference the Setting Model
use App\Models\Setting;

// Dingo includes Fractal to help with transformations
use League\Fractal\TransformerAbstract;

class SettingTransformer extends TransformerAbstract
{
    public function transform(Setting $item)
    {
        // Specify what elements are going to be visible to the API
        return [
            'id' => $item->id,
            'key' => $item->key,
            'display_name' => $item->display_name,
            'value' => $item->value,
        ];
    }
}

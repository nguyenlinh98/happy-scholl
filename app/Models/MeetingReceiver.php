<?php

namespace App\Models;

use App\Traits\Models\SchoolScopeTrait;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class MeetingReceiver extends Model
{
    use SchoolScopeTrait;

    public function receiver()
    {
        return $this->morphTo('receiver');
    }

    public static function createFor($morphModel)
    {
        $className = get_class($morphModel);
        throw_if(!class_exists($className), InvalidArgumentException::class, json_encode($morphModel).' is not an object');
        $model = new self();
        $model->receiver_type = $className;
        $model->receiver_id = $morphModel->id;

        return $model;
    }
}

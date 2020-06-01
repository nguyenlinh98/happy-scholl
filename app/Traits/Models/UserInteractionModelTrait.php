<?php

namespace App\Traits\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait UserInteractionModelTrait
{
    //Add relationships if need
    public function userFrom()
    {
        return $this->belongsTo(User::class, 'user_from');
    }

    public function userTo()
    {
        return $this->belongsTo(User::class, 'user_to');
    }

    public function scopeForCurrentUser(Builder $builder)
    {
        return $builder->where('user_to', auth()->user()->id);
    }

    public function scopeUsers(Builder $builder)
    {
        return $builder->with(self::GET_USER_RELATIONSHIP_CONSTANTS());
    }

    public static function GET_USER_RELATIONSHIP_CONSTANTS()
    {
        return ['userFrom', 'userTo'];
    }
}

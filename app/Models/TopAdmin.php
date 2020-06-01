<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Models\PreparableModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class TopAdmin extends User
{
    use Notifiable;

    const ROLE_IDENTITY = 'top_admin';

    const ACTIVE = 1;

    protected $table = 'users';

    protected $guard = 'topadmin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'role_id', 'activate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->role_id = $model->getRolesId();
            return $model;
        });

        static::addGlobalScope('top-admin', function (Builder $builder) {
            $parent = new self();
            $builder->where('role_id', $parent->getRolesId());
        });
    }

    /**
     * Make new Teacher instance from request input and save to database.
     * Extract password and hashing it before saving.
     *
     * @param $data Extracted from $request
     *
     * @version 1.0.0
     */
    public function makeFromRequest(array $data)
    {
        $this->fill($data);
        $this->password = Hash::make($data['password']);
        $this->save();
    }

    /**
     * Combine first_name and last_name field to long name.
     *
     * @return string
     *
     * @version 1.0.0
     */
    public function getNameAttribute()
    {
        return "{$this->name}";
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)
            ->first();
    }

    private function getRolesId()
    {
        $role = Role::where('name', self::ROLE_IDENTITY)->first();
        if (!isset($role->id))
            return 0;
        return $role->id;
    }

    public function isTopAdmin()
    {
        return true;
    }

}


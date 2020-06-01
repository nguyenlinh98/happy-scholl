<?php

namespace App\Models;

use App\Notifications\EmailNotifyCustomer;
use App\Traits\Models\PreparableModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Parents extends User implements MustVerifyEmail
{
    use Notifiable;
    use PreparableModel;
    use HasRelationships;

    const ROLE_IDENTITY = 'parents';

    const ACTIVE = 1;

    protected $table = 'users';

    protected $guard = 'parents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'role_id', 'activate', 'school_id', 'calendar_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->role_id = $model->getRolesId();

            return $model;
        });
        static::addGlobalScope('parents', function (Builder $builder) {
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
     * Update Teacher instance from request input and save to database.
     *
     * @param $data Extracted from $request
     *
     * @version 1.0.0
     */
    public function updateFromRequest(array $data)
    {
        $this->fill($data);
        $this->save();
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)
            ->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function student()
    {
        return $this->belongsToMany(
            'App\Models\Student',
            'parent_students',
            'user_id',
            'student_id'
        );
    }

    public function unreadLetters()
    {
        return $this->hasManyDeep(LetterReadStatus::class,
        [
            'parent_students', Student::class,
        ],
        [
            'user_id', 'id', 'student_id',
        ],
        [
            'id', 'student_id', 'id',
        ])->distinct()->where('letter_statuses.read', 0);
    }

    public function unreadMessages()
    {
        return $this->hasManyDeep(MessageReadStatus::class,
        [
            'parent_students', Student::class,
        ],
        [
            'user_id', 'id', 'student_id',
        ],
        [
            'id', 'student_id', 'id',
        ])->distinct()->where('message_read_statuses.read', 0);
    }

    public function getUnreadCount()
    {
        $this->loadMissing('setting');
        $badgeCounts = 0;
        if ($this->settings->push_letter) {
            $badgeCounts += $this->unreadLetters()->count();
        }

        if ($this->settings->push_notice) {
            $badgeCounts += $this->unreadMessages()->count();
        }

        return $badgeCounts;
    }

    public function parentStudents()
    {
        return $this->hasMany(ParentStudent::class, 'user_id', 'id')->with(['profile']);
    }

    public function setting()
    {
        return $this->hasMany(UserSetting::class, 'user_id', 'id');
    }

    private function getRolesId()
    {
        $role = Role::where('name', self::ROLE_IDENTITY)->first();
        if (!isset($role->id)) {
            return 0;
        }

        return $role->id;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailNotifyCustomer());
    }
}

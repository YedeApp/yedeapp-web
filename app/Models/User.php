<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'introduction', 'avatar', 'weixin_openid', 'weixin_unionid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function isSubscriberOf($course)
    {
        foreach($this->subscriptions as $subscription) {
            if ($subscription->course_id == $course->id) {
                return true;
            }
        }
        return false;
    }

    public function isSuperAdmin()
    {
        if ($this->hasRole('SuperAdmin')) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        if ($this->hasAnyRole(['Admin', 'SuperAdmin'])) {
            return true;
        }
        return false;
    }
}

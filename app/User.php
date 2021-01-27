<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('project_id', 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('project_id', 'user_id', 'role_id');
    }

    public function backlogItems()
    {
        return $this->hasMany(BacklogItem::class);
    }

    public function userRoles()
    {
        return $this->belongsTo(Users_role::class);
    }

    public function profiles()
    {
        return $this->hasOne(Profile::class);
    }

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_role_id'
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
}

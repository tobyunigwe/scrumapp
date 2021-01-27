<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    public function backlogItems()
    {
        return $this->hasMany(BacklogItem::class);
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('project_id', 'user_id', 'role_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('project_id', 'user_id', 'role_id');
    }



    protected $fillable = [
        'id', 'title', 'description', 'deadline'
    ];
}

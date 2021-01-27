<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('project_id', 'user_id', 'role_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('project_id', 'user_id', 'role_id');
    }
}

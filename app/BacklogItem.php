<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class backlogItem extends Model
{
    protected $fillable =[
        'id','role', 'activity', 'story_point', 'project_id', 'sprint_id', 'type', 'status', 'user_id'
    ];

    public function sprints()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}

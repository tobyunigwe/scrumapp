<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retrospective extends Model
{
    protected $fillable =[
        'description', 'status' , 'sprint_id'
    ];

    public function sprints()
    {
        return $this->belongsTo(Sprint::class);
    }
}

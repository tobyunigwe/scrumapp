<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{

    protected $dates = ['start_date', 'end_date'];

    protected $fillable = [
        'id', 'name', 'description', 'start_date', 'end_date', 'project_id'
    ];

    public function backlogItems()
    {
        return $this->hasMany(BacklogItem::class);
    }

    public function formattedDate()
    {
        return $this->start_date->format('M d Y');
        return $this->end_date->format('M d Y');
    }

    public function retrospective()
    {
        return $this->hasOne(Retrospective::class);
    }
}

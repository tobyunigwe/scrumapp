<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $dates = ['scrumExperienceSince'];

    protected $fillable =[
        'hobby', 'scrumExperienceSince' , 'user_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}

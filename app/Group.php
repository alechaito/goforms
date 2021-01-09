<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'id_user', 'name', 'resume'
    ];

    public $timestamps = false;
}

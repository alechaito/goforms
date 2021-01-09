<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'id_user', 'id_group', 'name', 'status', 'block_index' 
    ];

    public $timestamps = false;
}

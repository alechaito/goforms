<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'id_user', 'id_block', 'question', 'type'
    ];

    public $timestamps = false;
}

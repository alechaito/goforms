<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'id_user', 'id_quiz', 'name', 'question_index'
    ];

    public $timestamps = false;
}

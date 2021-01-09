<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name', 'birthday', 'age', 'sex'
    ];

    public $timestamps = false;
}

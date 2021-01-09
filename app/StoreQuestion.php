<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreQuestion extends Model
{
    protected $table = 'store_questions';

    protected $fillable = [
        'id_user', 'question', 'type', 'category'
    ];

    public $timestamps = true;

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    //
    protected $table = "content";
    protected $fillable = [
        'id',
        'name',
        'content',
        'script_id',
        'created_id',
        'updated_at'
    ];
}

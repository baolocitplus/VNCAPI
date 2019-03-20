<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    //
    protected $table = "computer";
    protected $fillable = [
        'id',
        'name',
        'ip',
        'description',
        'system',
        'memory',
        'cpu',
        'created_at',
        'updated_at'
    ];
}

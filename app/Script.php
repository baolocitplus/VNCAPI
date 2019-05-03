<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    //
    protected $table = 'script';
    protected $fillable = [
        'id',
        'name',
        'description',
        'user_id'
    ];

    public function IpAddress(){
        return $this->hasMany(address_Ip::class, 'script_id', 'id');
    }
    public function contents(){
        return $this->hasMany(Content::class, 'script_id', 'id');
    }
}

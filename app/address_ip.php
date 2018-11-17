<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class address_ip extends Model
{
    //
    protected $table = 'address_IP';
    protected $fillable = ['id', 'name', 'ip', 'port'];

}

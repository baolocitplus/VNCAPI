<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class address_Ip extends Model
{
    //
    protected $table = 'address_ip';
    protected $fillable = [
      'id',
      'name',
      'ip',
      'port',
      'protocol'
    ];

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services'; 
    public $primaryKey = 'service_id'; 
    public $timestamps = true; 
}

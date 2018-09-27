<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datetimes extends Model
{
    protected $table = 'datetimes'; 
    public $primaryKey = 'datetime_id'; 
    public $timestamps = true; 
}

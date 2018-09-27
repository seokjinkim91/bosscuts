<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_datetimes extends Model
{
    protected $table = 'users_datetimes'; 
    public $timestamps = true; 
    
    public function users(){
        return $this->hasMany('App\User');
    }
  
    public function datetimes(){
        return $this->hasMany('App\Datetimes');
    }
  
}

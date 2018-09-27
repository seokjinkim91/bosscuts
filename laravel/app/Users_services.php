<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_services extends Model
{
    protected $table = 'users_services'; 
    public $timestamps = true; 
    
     public function users(){
        return $this->hasMany('App\User');
    }
  
    public function services(){
        return $this->hasMany('App\Services');
    }
}

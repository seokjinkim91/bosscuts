<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table = 'bookings'; 
    public $primaryKey = 'booking_id'; 
    public $timestamps = true; 
}

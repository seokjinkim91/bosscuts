<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicants extends Model
{
    protected $table = 'applicants'; 
    public $primaryKey = 'applicant_id'; 
    public $timestamps = true; 
}

// abstract class IApplicant{
//     public $firstname;
//     public $surname;
//     public $contact;
//     public $email;
//     public $type;
    
// }

// class Applicant extends IApplicant{
    
//     public $firstname="test";
//     public $surname="test";
//     public $contact="test";
//     public $email="test";
//     public $type="test";

    
// }
<?php 
 
namespace factories;
 
 
 class ApplicantFactory{
 
 private $firstname;
 private $lastname;
 private $contact;
 private $email;
 private $type;
 
 public function __construct($firstname,$surname,$contact,$email,$jobtype){

  $this->firstname = $firstname;
  $this->lastname = $surname;
  $this->contact = $contact;
  $this->email = $email;
  $this->jobtype = $jobtype;
 
 }
 
 
 public function Save(){
     
               DB::table('applicants')-> insert(
                ['applicant_firstname' => $firstname,
                'applicant_surname' => $lastname,
                'applicant_email' => $email,
                'applicant_contact' => $contact,
                'applicant_type' => $type ]
                
                );
     
 }
 
     
 }
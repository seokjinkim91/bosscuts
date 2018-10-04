<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Factories;


class MainController extends Controller
{
    //
    public function index(){ 
        
        $services=\DB::table('services')->orderBy('service_priority', 'asc')->get(); 

        return (view('index',compact('services')))->with('page_name',"main"); 
     
    }
    
    public function booking(){ 

        return view('booking')->with('page_name',"booking"); 
    }
    
    //available dates
    public function bookingDate(){

       //
       $arr = explode('/', $_GET['date']);
       $date= $arr[2].$arr[0].$arr[1];
       
       $booking=\DB::select('select users.user_id as id,users_datetimes.datetime_id datetimeid,SUBSTRING_INDEX(users.name, \' \', 1) as employee,
                             DATE_FORMAT( STR_TO_DATE(users_datetimes.datetime_id,\'%Y%m%d%H%i\'), \'%d/%M/%Y %H:%i\') datetime
                             from users left join users_datetimes on users.user_id = users_datetimes.user_id 
                             where users_datetimes.status=\'available\' and enable=1 and left(users_datetimes.datetime_id,8) ='.$date);            
                    
        
        return json_encode($booking);
    }
    
    
    //services provided
    public function bookingServices(){
        
        
       $empid=  request('empid');
       
       $services=\DB::select('select services.service_id,CONCAT(SUBSTRING_INDEX(services.service_title,\' \',2),\' - $\',
                             services.service_price) as service from users_services left join services on users_services.service_id=services.service_id   
                             where users_services.user_id='.$empid.'  
                             group by services.service_id,CONCAT(SUBSTRING_INDEX(services.service_title,\' \',2),\' - $\',
                             services.service_price)
                             ');
                             
     
      return json_encode($services);
    }
    
    //submit booking
    public function bookingSubmit(){
        
        $returnvalue=false;
        
        $userid=$_POST['userid'];
        $datetimeid=$_POST['datetimeid'];
        $service=$_POST['service'];
        $email=$_POST['email'];
        $contact=$_POST['contact'];
        $name=$_POST['name'];
        
       $insert=  \DB::table('bookings')->insert(['datetime_id' => $datetimeid,
                                        'user_id' => $userid,
                                        'booking_name' => $name,
                                        'booking_contact' => $contact,
                                        'booking_email' => $email,
                                        'service_id' => $service,
                                        'booking_status'=>'waiting',
                                        'created_at' =>date('Y-m-d H:i:s')
                                        
                                        ]);
       
        $bookingcontroller = new BookingController;
        $bookingcontroller -> updateUserDatetime($userid, $datetimeid, "waiting");
        
        if(!empty($insert)){
        $returnvalue=true;
        }
        
        return json_encode($returnvalue);
        
    }
    
    public function career(){ 
       
       return view("career", ["page_name"=>"career","success"=>false]);
    }
    
    public function careersubmit(){

             $file = request()->file('fileurl');

             $fileName = time().'.'.$file->getClientOriginalName();
             $file->move(public_path('/public_uploads'), $fileName);
   
            // if(!Storage::disk('public_uploads')->put($path, $file_content)) {
            //     return false;
            // }
   
                     
              \DB::table('applicants')-> insert(
                ['applicant_firstname' => request('firstname'),
                'applicant_surname' => request('surname'),
                'applicant_email' => request('email'),
                'applicant_contact' => request('contact'),
                'applicant_type' => request('jobtype'),
                'applicant_memo' => request('comment'),
                
                //Validation not added yet
                'applicant_file_url' =>$fileName,
                'created_at' =>date('Y-m-d H:i:s')
                ]
                );
                
       
        //  return view('career')->with('page_name',"career"); 
         return view("career", ["page_name"=>"career","success"=>true]);
    }
    
}

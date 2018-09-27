<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicants;
use App\Services;
use App\User; 
use App\Datetimes;
use App\Users_datetimes; 
use App\Users_services; 
use App\Bookings;

use DateTime; 

class DBSeedController extends Controller
{
    //
    
    public function insertAll(){ 
        
         $msg ='<h1>Succeed</h1>'; 

          $this->insertServices(); 
          $this->insertUsers(); 
          $this->insertDatetimes();
          $this->insertApplicants();
          $this->insertBookings();
          $this->insertUsersDatetimes();
          $this->insertUsersServices();
          
        return $msg; 
    }
    
    public function truncateAll(){
        
         $msg ='<h1>Succeed</h1>'; 
        
          $this->truncateServices(); 
          $this->truncateUsers(); 
          $this->truncateDatetimes();
          $this->truncateApplicants();
          $this->truncateBookings();
          $this->truncateUsersDatetimes();
          $this->truncateUsersServices();
          
         return $msg; 
    }
    
    public function insertUsers(){ 
        
        $msg ='<h1>Succeed</h1>'; 
        
        //`password`, `name`, `contact`, `email`, `role`, `enable`, `photo_url`
        
        //Staff3 is Disable
        $data = [
            ['1111','Brian Admin','0271111111','admin1@bosscut.com','admin',0,'https://kr.seaicons.com/wp-content/uploads/2015/07/user-man-fav-icon.png'],
            ['1111','Nick Staff1','0272222222','staff1@bosscut.com','staff',0,'https://cdn.icon-icons.com/icons2/11/PNG/256/person_user_customer_female_people_1689.png'],
            ['2222','James Staff2','0273333333','staff2@bosscut.com','staff',0,'https://kr.seaicons.com/wp-content/uploads/2015/07/user-man-fav-icon.png'],
            ['3333','Ken Staff3','0273333333','staff3@bosscut.com','staff',1,'https://kr.seaicons.com/wp-content/uploads/2015/07/user-man-fav-icon.png']

        ]; 
        
        $usr = \DB::table('users');
        
        foreach($data as $row) { 
           

            $temp = [ 'password' => \Hash::make($row[0]), 
                      'name' => $row[1],
                      'contact' => $row[2],
                      'email' => $row[3],
                      'role' => $row[4],
                      'enable' => $row[5],
                      'photo_url' => $row[6]];
                      
            $usr->insert($temp); 
        }
        
        return $msg; 
    }
    
     public function truncateUsers(){ 
        
        $msg ='<h1>Succeed</h1>'; 

        User::query()->truncate(); 
        
        return $msg; 
     }
     
     
    public function insertServices(){
       
        $msg ='<h1>Succeed</h1>'; 
       
        //`service_id`, `service_title`, `service_mins`, `service_type`, `service_price`, `service_desc`
        $data = [
            ['Mens cut & style',30,'normal',30,'Mens cut & style desc',5],
            ['Kids cut & style 1 to 16 years',25,'normal',25,'Kids cut & style 1 to 16 years desc',4],
            ['Clipper cut ( Clipper all over only)',20,'normal',20,'Clipper cut ( Clipper all over only) desc',3],
            ['Mens cut, style & beard trim',15,'normal',15,'Mens cut, style & beard trim decs',2],
            ['Beard trim only',10,'normal',10,'Beard trim only desc',1]
        ];
       
        foreach($data as $row) { 
           
            $service = new Services; 
            
            $service->service_title = $row[0]; 
            $service->service_mins = $row[1]; 
            $service->service_type = $row[2]; 
            $service->service_price = $row[3]; 
            $service->service_desc = $row[4]; 
            $service->service_priority = $row[5]; 
            $service->save(); 
        }
        
        return $msg; 
    }
    
    public function truncateServices(){ 
        
        $msg ='<h1>Succeed</h1>'; 
        
        Services::query()->truncate();
        
        return $msg; 
     }
    
    public function insertDatetimes(){ 

        $msg ='<h1>Succeed</h1>'; 
        
        $now = new DateTime("2018-09-18 00:00:00", new \DateTimeZone("Pacific/Auckland"));
        
        //create 2 years data 
        for($i = 0; $i < (48*365*1); $i++) {
            
            $row = new Datetimes; 
            
             //`datetime_id`, `data_time`, `year`, `month`, `month_name`, `day`, `day_name`, `hour`, `minute`, `week_str`
            $row->datetime_id = $now-> format("YmdHi");
            $row->date_time = $now->format('Y-m-d H:i:s');
            $row->year = $now->format("Y");
            $row->month = intval($now->format("m"));
            $row->month_name = $now->format("F");
            $row->day = intval($now->format("d"));
            $row->day_name = $now->format("l");
            $row->hour = $now->format("Hi");
            
            if(intval($row->day)==1 &&  intval($row->month)==12)
                    $row->week_str=(intval($row->year)+1)."w".$now->format('W'); 
            else $row->week_str= $row->year."w".$now->format('W'); 
            
            $row->save(); 
            
            $now->modify('+30 minutes'); 
        }
        
        return $msg; 
        
    }

    public function truncateDatetimes(){ 
        
        $msg ='<h1>Succeed</h1>'; 
        
        Datetimes::query()->truncate();
        
        return $msg; 
     }


    public function insertUsersDatetimes(){ 
        
        $msg ='<h1>Succeed</h1>';
        
        //staff 1 = tuesday, wednesday, thursday, friday 09:00 ~ 18:00 
        //statt 2 = wednesday, thursday, saturday, sunday 09:00 ~ 18:00
        $staff1 = array("Tue","Wed","Fri","Sun"); 
        $staff2 = array("Tue","Fri","Sat","Sun"); 
        
        $now = new DateTime("2018-09-18 00:00:00", new \DateTimeZone("Pacific/Auckland"));
        
        //create 3 mothes data  
        
        for($i = 0; $i < (48*90); $i++) {
            
            $hour = number_format($now->format("H"));
            $datetime_id = $now-> format("YmdHi");
            
            //Time 09:00 ~ 17:00 except 12:00 ~13:00
            if($hour >=9 and $hour <18 and $hour!=12) {
             
                    if(in_array($now->format("D"),$staff1)) {
                        
                        $row1 =new Users_datetimes; 
                        //`datetime_id`, `user_id`, `status`
                        $row1->datetime_id = $datetime_id; 
                        $row1->user_id = 2; 
                        $row1->status = 'available'; 
                        $row1->save(); 
                    }
                    
                    if(in_array($now->format("D"),$staff2)) {
                        
                        $row2 =new Users_datetimes; 
                        //`datetime_id`, `user_id`, `status`
                        $row2->datetime_id = $datetime_id; 
                        $row2->user_id = 3; 
                        $row2->status = 'available'; 
                        $row2->save(); 
                    }
                
            }
            
            
            $now->modify('+30 minutes'); 
        }
        
        return $msg;
    }
    
    public function truncateUsersDatetimes(){ 
        
        $msg ='<h1>Succeed</h1>'; 
        
        Users_datetimes::query()->truncate();
        
        
        return $msg; 
     }
     
     

    public function insertApplicants(){ 
        
        $msg ='<h1>Succeed</h1>';
        
        //`applicant_id`, `applicant_email`, `applicant_firstname`, `applicant_surname`, `applicant_contact`, `applicant_password`, `applicant_type`, `applicant_file_url`, `created`, `modified`, `applicant_memo`,
        
        return $msg; 
    }

    public function truncateApplicants(){ 
        
        $msg ='<h1>Succeed</h1>'; 
        
        Applicants::query()->truncate();
        
        return $msg; 
     }
     
     
    public function insertBookings(){
         
        $msg ='<h1>Succeed</h1>';
        // 30 days - 100 random bookings (80 booked / 20 waiting)
        
        $from_date =  (new \DateTime('now', new \DateTimeZone('Pacific/Auckland')))->format('Y-m-d');
		$to_date = (new \DateTime('+30 day', new \DateTimeZone('Pacific/Auckland')))->format('Y-m-d');
        
        $results = \DB::table("users_datetimes")->select("users_datetimes.datetime_id", "users_datetimes.user_id")
                                     ->join("datetimes","users_datetimes.datetime_id","=","datetimes.datetime_id")
                                     ->where("datetimes.date_time",">",$from_date)
                                     ->where("datetimes.date_time","<",$to_date)
                                     ->where("users_datetimes.status","available")
                                     ->orderBy('users_datetimes.datetime_id', 'asc')
                                     ->get(); 
        
        //100 random number generating with no redundancy
        $nums = array();
        
        while(count($nums)<100){ 
            $num = rand(0,count($results)-1); 
            if(!in_array($num,$nums)) array_push($nums,$num); 
        }
        
    
        //`booking_id`, `datetime_id`, `user_id`, `booking_name`, `booking_contact`, `booking_email`, `service_id`, `booking password`, `booking_memo`
        $i=0; 
        
        foreach($nums as $num){ 
            
            $bookings = new Bookings; 
            $bookings->datetime_id = $results[$num]->datetime_id.''; 
            $bookings->user_id = $results[$num]->user_id; 
            $bookings->booking_contact = rand(0,9).rand(0,9).rand(0,9).rand(0,9). rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9); 
            $bookings->booking_name = "customer".$i; 
            $bookings->booking_email = "customer ".$i."@gmail.com"; 
            $bookings->service_id = rand(1,5); 
            $bookings->booking_memo  = str_shuffle("abcdefghijklmnopqrstuvwxyz abcdefghijklmnopqrstuvwxyz abcdefghijklmnopqrstuvwxyz  abcdefghijklmnopqrstuvwxyz"); 
            
            if($i<80) { 
                        $bookings->booking_status = "booked"; //waiting, booked, cancelled
                        Users_datetimes::where('datetime_id',$results[$num]->datetime_id) 
                        ->where('user_id',$results[$num]->user_id) 
                        ->update(['status' => 'booked']);
            }
                else{ 
                    
                    $bookings->booking_status = "waiting"; //waiting, booked, cancelled
                        Users_datetimes::where('datetime_id',$results[$num]->datetime_id) 
                        ->where('user_id',$results[$num]->user_id) 
                        ->update(['status' => 'waiting']);
                }
                
            $bookings->save(); 
            
            $i++; 
        }
        
        return $msg;
    }
    
    public function truncateBookings(){ 
        
        $msg ='<h1>Succeed</h1>'; 
        
        Bookings::query()->truncate(); 
        
        Users_datetimes::where('status',"!=","available")
                        ->update(['status' => 'available']);
                
        return $msg; 
     }
    

    
    public function insertUsersServices(){ 
        
        $msg ='<h1>Succeed</h1>';
        //Staff1 user_id:2 - Services ("1"->enable, "2"->enable, "3"->enable, "4"->disable, "5"->enable); 
        //Staff2 user_id:3 - Services ("1"->enable, "2"->enable, "3"->enable, "4"->enable, "5"->diable); 
        //Staff2 user_id:4 - Services ("1"->disable, "2"->disable, "3"->enable, "4"->enable, "5"->enble); 
        
        // user_id, service_id, status 
        $data= [
                [2,1,"enable"], [2,2,"enable"], [2,3,"enable"], [2,4,"disable"], [2,5,"enable"], 
                [3,1,"enable"], [3,2,"enable"], [3,3,"enable"],  [3,4,"enable"], [3,5,"enable"], 
                [4,1,"disable"], [4,2,"disable"], [4,3,"enable"], [4,4,"enable"], [4,5,"enable"]
            ];
            
        foreach($data as $row) { 
           
            $users_services = new Users_services; 
            $users_services->user_id = $row[0]; 
            $users_services->service_id = $row[1]; 
            $users_services->status = $row[2]; 
            $users_services->save(); 
        }
        
        return $msg;
    }
    
    public function truncateUsersServices(){ 
        
        $msg ='<h1>Succeed</h1>'; 
        
        Users_services::query()->truncate();  
        
        return $msg; 
     }
}

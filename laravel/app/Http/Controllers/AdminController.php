<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User; 
use DateTime; 
use DateTimeZone; 

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $staffs = $this-> getStaffList(); 
       $msg = ''; 
       
       if($request->has('msg')) $msg = $request->msg; 
       
       if($request->has('staff_id')) $staff_id = $request->staff_id; 
       else if(strcmp(\Auth::user()->role,"admin")!=0) $staff_id = \Auth::user()->user_id; 
            else  $staff_id = $staffs[0]->user_id; 
            
        //Week Str    
        if($request->has('week_str')) $week_str = request('week_str'); 
           else $week_str = $this->getCurrentWeekStr(); 
        
        $bookings = ""; 
         
        //Page controll!
        if($request->has('page_direction')){ 
            if(strcmp((string)$request->page_direction,"prev")==0) $week_str = $this->getPrevWeekStr($week_str); 
            if(strcmp((string)$request->page_direction,"next")==0) $week_str = $this->getNextWeekStr($week_str); 
        }


        $bookingcontroller = new BookingController;
        $schedule_str = $bookingcontroller->getScheduleStr($staff_id,$week_str); 
        $bookings = $bookingcontroller->getUserBookedByWeek($staff_id,$week_str); 
        $no_of_waitings = $bookingcontroller->getNumberOfWaitByWeek($staff_id,$week_str); 

        return view('admin.schedule', compact('staffs','staff_id','week_str','schedule_str','bookings','no_of_waitings','msg')); 
    }
    
    
    public function schedule(){
        
        return redirect('admin'); 
    }
    
    public function saveSchedule(Request $request){

        //initialize page variables 
        $staff_id = $request->staff_id;
        $week_str = $request->week_str;
        $msg =''; 
        
        
        //Functional Variables 
        $json = json_decode($request->json_str); 
        $bookingcontroller = new BookingController;
        $datetimes = $bookingcontroller->getDatetimesList($json); //array Datetimes IDS from Json
        $user_datetimes = $bookingcontroller->getUserDatetimesByWeek($staff_id,$week_str); //get existing users_datetimes table data
        $user_datetime_ids=array(); //users_datetimes -> datetime_id List
        
        $datetimes_insert=array();  //In order to insert users_datetimes
        $datetimes_remove=array();  //In order to remove users_datetimes 
        
        //Process remove list with error of waiting/booked status 
        foreach($user_datetimes as $user_datetime){ 
                
                $datetime_id = $user_datetime->datetime_id; 
                $status = $user_datetime->status; 
                array_push($user_datetime_ids,$datetime_id); 
                
                if(in_array($datetime_id, $datetimes))  $is_on_the_list = true; 
                    else if($status =="waiting" || $status =="booked"){ 
                       
                        $msg = "ERROR: You should not remove this schedule(s) because booking(s) is already existed."; 
                        
                        return \Redirect::route('admin', ['staff_id'=>$staff_id,'week_str'=>$week_str,'msg'=>$msg]); 
                    }
                    else array_push($datetimes_remove,$datetime_id); 
                
        }
        
        //Process insert list
        foreach($datetimes as $datetime_id) 
            if(!in_array($datetime_id,$user_datetime_ids)) array_push($datetimes_insert,$datetime_id); 
        
        
        $bookingcontroller->insertSchedules($staff_id,$datetimes_insert); 
        $bookingcontroller->removeSchedules($staff_id,$datetimes_remove); 
        
        
        $msg ="SUCCESS: "; 
        if(count($datetimes_insert)>0) $msg .= count($datetimes_insert)." schedule(s) has been activated.";
        if(count($datetimes_insert)>0 && count($datetimes_remove)>0) $msg .= " / ";
        if(count($datetimes_remove)>0) $msg .= count($datetimes_remove)." schedule(s) has been removed.";
        if(count($datetimes_insert)==0 && count($datetimes_remove)==0) $msg = "INFORMATION: Schedule update(s) does not exist!";
   
        return \Redirect::route('admin', ['staff_id'=>$staff_id,'week_str'=>$week_str,'msg'=>$msg]); 
        //return $datetimes_remove; 
        //redirect()->back()->with('msg',$msg); 
    }
    
    public function enableSchedule(Request $request){
        
        //initialize page variables 
        $staff_id = $request->staff_id;
        $week_str = $request->week_str;
        $msg =''; 
        
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $from_hour = $request->from_hour;
        $to_hour = $request->to_hour; 
        $days = Input::get('days'); 
        
        $bookingcontroller = new BookingController;
        
        $datetime_ids = $bookingcontroller->getDatetimesIds($from_date,$to_date,$from_hour,$to_hour,$days); 
        $msg = $bookingcontroller->insertUserDatetimes($staff_id, $datetime_ids); 
        
        //return $datetime_ids;
        return \Redirect::route('admin', ['staff_id'=>$staff_id,'week_str'=>$week_str,'msg'=>$msg]);  
    }
    
    public function disableSchedule(Request $request){
        
        //initialize page variables 
        $staff_id = $request->staff_id;
        $week_str = $request->week_str;
        $msg =''; 
        
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $from_hour = $request->from_hour;
        $to_hour = $request->to_hour; 
        $days = Input::get('days'); 
        
        $bookingcontroller = new BookingController;
        
        $datetime_ids = $bookingcontroller->getDatetimesIds($from_date,$to_date,$from_hour,$to_hour,$days); 
        $msg = $bookingcontroller->deleteUserDatetimes($staff_id, $datetime_ids); 
        
        //return $datetime_ids;
        return \Redirect::route('admin', ['staff_id'=>$staff_id,'week_str'=>$week_str,'msg'=>$msg]); 
    }
    
    public function getStaffList(){
        $staffs = \DB::table("users")->select("user_id","name") 
                                  ->where("role","staff")
                                  ->where("enable",0)
                                  ->get(); 
                                  
        return $staffs; 
        
    }
    
    
    function queryBookings($status=null){
        
       return \DB::select('SELECT  DATE_FORMAT(STR_TO_DATE(datetime_id,\'%Y%m%d%H%i\'), \'%Y-%m-%d(%a) %h:%i %p\') displaydate,
                            b.booking_id,
                            u.name barber,
                            s.service_title,
                            b.booking_name client,
                            b.booking_contact contact,
                            b.booking_email email
                            from bookings b 
                            left join users u on u.user_id=b.user_id
                            left join services s on b.service_id=s.service_id'. 
                            ((empty($status))?'':' where b.booking_status=\''.$status.'\'').
                            ' order by b.datetime_id');  
    }
    
 
    
     public function getBooking($status=null){
                    
        $bookings = self::queryBookings($status);
        return view('admin.bookings',['bookings'=> $bookings]);
    }
    
    
    public function getBookings(){
        
        $tab=request('tab');
        switch($tab){
            case 'cancel': return self::getBooking('cancelled');
            case 'history':return self::getBooking('history');
            default: return self::getBooking('booked');
        }
    }
    
    
    public function updateBookings(){
        //Tab check
        
        $bookingid=request('bookingid');
        $status=request('status');
        
        \DB::table('bookings')
            ->where('booking_id', $bookingid)
            ->update(['booking_status' => $status,
                      'updated_at' => date('Y-m-d H:i:s')
            ]);
            
        return self::getBookings();
        
    }

    
    public function profile(){
        return view('admin.profile');
    }
    
    private function getServices(){
        return \DB::table('services')->orderBy('service_priority', 'asc')->get();
        
    }
    
    public function services(){
        return view('admin.services') -> with('services',self::getServices());
    }
    
    
    private function checkService($id){
        return \DB::table('services')->where('service_id',$id)->first();
    }

    public function editService(){
        
        $id=request('serviceid');
        $title=request('title');
        $mins=request('duration');
        $price=request('price');
        $desc=request('message');
        
        if(self::checkService($id)){
         \DB::table('services')
            ->where('service_id',$id)
            ->update(['service_title' => $title,'service_mins' => $mins,'service_price' => $price,'service_desc' => $desc ]);
            
        }
        else{
            \DB::table('services')->insert(['service_title' => $title,'service_mins' => $mins,'service_price' => $price,'service_desc' => $desc ]);
            
        }

        return self::services(); 
    }
    
    
    public function deleteService(){
        
       $result= \DB::table('services')
            ->where('service_id','=',request('serviceid'))
            ->delete();
            
        return self::services();  
    }
    
    public function deleteApplicants(){
        
        $applicant=request('applicant_id');
       // dump(request('applicant_id'));
          $result= \DB::table('applicants')
            ->where('applicant_id','=',$applicant)
            ->delete();
            
       return redirect()->action('AdminController@applicants');
            
    }
    
    // Applicants GET
    public function applicants(){ 
        $applicants= \DB::table('applicants')->orderBy('applicant_id', 'asc')->get();
        return view('admin.applicants')->with('applicants',$applicants); 
    }
    
    public function users(){

         $users=\DB::select('select users.user_id,users.name,users.contact,users.email,users.role,users.photo_url,
                             users.enable, group_concat(services.service_title) as title
                             from users 
                             left join users_services on users.user_id = users_services.user_id 
                             left join services on users_services.service_id = services.service_id
                             group by users.user_id,users.name,users.contact,users.email,users.role,users.photo_url,users.enable');
         
    
        
         return view('admin.users')->with('users',$users);
    }
    
    public function userstatus(){
        $userid=request('userid');
        $enable=request('enable');
        
        \DB::table('users')
            ->where('user_id', $userid)
            ->update(['enable' => $enable]);
        
        
       return redirect()->action('AdminController@users');
    }
    
    public function updateUsers(){
        
        $userid=request('userid');
        $name=request('name');
        $email=request('email');
        $contact=request('contact');
        $role=request('role');
       //$services=request('services');
        
       \DB::table('users')
        ->where('user_id', $userid)
        ->update(['name' => $name,
                  'email' => $email,
                  'contact' =>$contact,
                  'role' =>$role,
                  'updated_at' => date('Y-m-d H:i:s')
        ]);
        
     return redirect()->action('AdminController@users');
    }
    
    public function getCurrentWeekStr(){ 
        
         $now = new DateTime('now', new DateTimeZone('Pacific/Auckland')); 
         $week_str = ""; 
         $year = $now->format("Y");
         $month = $now->format("m"); 
         $week_no = $now->format("W");
         
         if($month==12 && intval($week_no==1)){ 
             $week_str = ($year+1)."w".$week_no; 
         }
         else $week_str = $year."w".$week_no;
         
         return $week_str; 
    }
    
    public function getNextWeekStr($week_str){
        
        $year = substr($week_str,0,4); 
        
        $week_no = substr($week_str,-2); 
        
        if(intval($week_no)==52){  
            $week_no = "01"; 
            $year = intval($year)+1; 
        }
        else if(intval($week_no)<9) $week_no = "0".(intval($week_no)+1); 
        else $week_no = intval($week_no)+1; 
        
        return $year."w".$week_no; 
    }
    
    public function getPrevWeekStr($week_str){
        
        $year = substr($week_str,0,4); 
        
        $week_no = substr($week_str,-2); 
        
        if(intval($week_no)==1){  
            $week_no = "52"; 
            $year = intval($year)-1; 
        }
        else if(intval($week_no)<11) $week_no = "0".(intval($week_no)-1); 
        else $week_no = intval($week_no)-1; 
        
        return $year."w".$week_no; 
    }
    
}

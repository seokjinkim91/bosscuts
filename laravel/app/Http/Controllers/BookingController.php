<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookings; 
use App\Users_datetimes; 
use App\Datetimes; 

class BookingController extends Controller
{

    
    function insertUserDatetimes($user_id, $datetime_ids){
     
        $user_datetime_ids = array(); 
        
        $user_datetimes = \DB::table("users_datetimes")->select("datetime_id")
                        ->where("user_id",$user_id)
                        ->whereIn("datetime_id",$datetime_ids)->get(); 
        
        foreach($user_datetimes as $user_datetime) array_push($user_datetime_ids, $user_datetime->datetime_id); 
        
        $update_cnt =0; 
        
        foreach($datetime_ids as $datetime_id){ 
            
            if(!in_array($datetime_id, $user_datetime_ids)){ 
                 $row =new Users_datetimes; 
                 $row->datetime_id = $datetime_id; 
                 $row->user_id = $user_id; 
                 $row->status = 'available'; 
                 $row->save(); 
                 $update_cnt++; 
            }
        }
        
        if($update_cnt==0) $msg = "INFORMATION: Schedule update(s) does not exist!";
            else $msg = "SUCCESS: ".$update_cnt." schedule(s) has been activated.";
            
        return $msg; 
    }
    
    function updateUserDatetime($user_id, $datetime_id, $status){ 
         
         Users_datetimes::where('user_id',$user_id)
                  ->where('datetime_id',$datetime_id)
                  ->update(['status' => $status]); 
        
    } 
    
    
    function deleteUserDatetimes($user_id, $datetime_ids){
     
        
        $user_datetimes = \DB::table("users_datetimes")->select("datetime_id","status")
                        ->where("user_id",$user_id)
                        ->whereIn("status",["waiting","booked"])
                        ->whereIn("datetime_id",$datetime_ids)->get(); 
        
        
        if(count($user_datetimes)>0) return "ERROR: You should not remove this schedule(s) because booking(s) is already existed."; 
        
        $this -> removeSchedules($user_id, $datetime_ids); 
        
    
        return "SUCCESS: ".count($datetime_ids)." schedule(s) has been removed.";; 
    }
    
    
    
    function insertSchedules($user_id, $datetime_ids){ 
            
        foreach($datetime_ids as $datetime_id){ 
        
            $row =new Users_datetimes; 
            $row->datetime_id = $datetime_id; 
            $row->user_id = $user_id; 
            $row->status = 'available'; 
            $row->save();    
        } 
        
    }
    
    function removeSchedules($user_id, $datetime_ids){ 
        
        foreach($datetime_ids as $datetime_id){ 
        
            $row = Users_datetimes::where('user_id',$user_id)
                  ->where('datetime_id',$datetime_id)
                  ->delete(); 
        } 
        
    }
    
    function getDatetimesList($datetimes){ 
         
        $results = array(); 
        
        foreach($datetimes as $datetime){ 
                
              $rows = \DB::table("datetimes")->select("datetime_id")
                        ->where("datetime_id",">=",$datetime->start)
                        ->where("datetime_id","<",$datetime->end)
                        ->get(); 
                        
              foreach($rows as $row) array_push($results,$row->datetime_id); 
        }
                                                 
        return $results; 
        
    }
    
    function getDatetimesIds($from_date,$to_date,$from_hour,$to_hour,$days){ 
         
        $results = array(); 
 
 
        $newDate = new \Datetime($to_date); 
        date_modify($newDate, '+1 day');
        $to_date = $newDate->format("Y-m-d");
        
 
        $rows = \DB::table("datetimes")->select("datetime_id")
                ->where("date_time",">=",$from_date)
                ->where("date_time","<",$to_date)
                ->where("hour",">=",$from_hour)
                ->where("hour","<",$to_hour)
                ->whereIn("day_name",$days)
                ->get(); 
                        
        foreach($rows as $row) array_push($results,$row->datetime_id); 
   
                                                 
        return $results; 
        
    }
    
    function getUserDatetimesByWeek($user_id,$week_str){
    
        $results = \DB::table("users_datetimes")->select("users_datetimes.datetime_id", "users_datetimes.status")
                                                ->join("datetimes","users_datetimes.datetime_id","=","datetimes.datetime_id")
                                                ->where("datetimes.week_str",$week_str)
                                                ->where("users_datetimes.user_id",$user_id)
                                                ->get(); 
                                                
        return $results; 
    } 
    
    function getUserBookedByWeek($user_id,$week_str){
        
        ////`booking_id`, `datetime_id`, `user_id`, `booking_name`, `booking_contact`, `booking_email`, `service_id`, `booking password`, `booking_memo`
        $bookings = \DB::table("bookings")->select("bookings.booking_id", "bookings.datetime_id", "bookings.booking_name", "bookings.booking_contact", "services.service_title", "bookings.booking_memo")
                                     ->join("datetimes","bookings.datetime_id","=","datetimes.datetime_id")
                                     ->join("services","bookings.service_id","=","services.service_id")
                                     ->where("datetimes.week_str",$week_str)
                                     ->where("bookings.user_id",$user_id)
                                     ->where("bookings.booking_status","booked")
                                     ->orderBy('bookings.datetime_id', 'asc')
                                     ->get(); 
        return $bookings; 
    }
    
    
    function getNumberOfWaitByWeek($user_id, $week_str){
        
        $bookings = \DB::table("bookings")->select("bookings.datetime_id")
                                     ->join("datetimes","bookings.datetime_id","=","datetimes.datetime_id")
                                     ->where("datetimes.week_str",$week_str)
                                     ->where("bookings.user_id",$user_id)
                                     ->where("bookings.booking_status","waiting")
                                     ->get(); 
        return count($bookings); 
        
    }
    
    function getScheduleStr($user_id, $week_str){
        
        
         $datetime_ids = \DB::table("users_datetimes")->select("users_datetimes.datetime_id","datetimes.day_name")
                                     ->join("datetimes","users_datetimes.datetime_id","=","datetimes.datetime_id")
                                     ->where("datetimes.week_str",$week_str)
                                     ->where("users_datetimes.user_id",$user_id)
                                     ->orderBy('users_datetimes.datetime_id', 'asc')
                                     ->get(); 
        $result="";
        
        if(count($datetime_ids)>0){ 
            
                $day_no = 0; 
                $day_array = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']; 
                
                foreach($datetime_ids as $row){
                    
                    $day_name = (string)$row->day_name; 
                    $id = (string)$row->datetime_id; 
                    $cnt=0; 
                    $last_day_no = $day_no; 
                    
                    foreach($day_array as $day){
                        if($day ==  $day_name) $day_no =$cnt; 
                        $cnt++;
                    }
                    
                    if(strlen($result)==0) $result.=$day_no.":[";
                    
                    else if($last_day_no != $day_no){
                        $result=substr($result,0,strlen($result)-1);
                        $result.="],".$day_no.":[";
                    }
                    
                     $hour = substr($id,8,2); 
                     $min = substr($id,-2); 
                            
                      if(intval($min)==0) $result .="['" .$hour.":00','".$hour.":30'],";
                        else{
                           if(intval($hour)<9) $result .= "['" .$hour.":30','0".(intval($hour)+1).":00'],";
                                else $result .= "['" .$hour.":30','".(intval($hour)+1).":00'],";
                        } 
                
                }
                
                if(strlen($result)>0) $result=substr($result,0,strlen($result)-1)."]";  
        }
        
       
        return $result; 
       
    }
    
  
    
    function getWeekStr($yyyymmdd){ 
        
        //date("YW", strtotime("2011-01-07"))
        
        $year = substr($yyyymmdd,0,4); 
        $month = substr($yyyymmdd,3,2);
        $day = substr($yyyymmdd,-2);
        
        $week_no = date("W",strtotime($year."-".$month."-".$day)); 
        
        $result = ""; 
        
        if(intval($month)==12 && intval($week_no)==1) $result = (intval($year)+1)."w01"; 
            else $result= $year."w".$week_no; 
            
        return $result;    
    }

    
}

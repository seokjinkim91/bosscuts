@extends('layouts.admin')

@section('content')

  <?php
  
    $weekday_list = array(); 
    
    $current_date = new DateTime('now', new DateTimeZone('Pacific/Auckland')); 
    $week_start =  new DateTime('now', new DateTimeZone('Pacific/Auckland')); 
    
    $_is_past = false; //_is_fast

    if($current_date->format('Y')>=intval(substr($week_str,0,4)) 
        && $current_date->format('W')>=intval(substr($week_str,-2))) $_is_past=true; 
        
    $week_start->setISODate(intval(substr($week_str,0,4)), intval(substr($week_str,-2)));

    $seven_day_week = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
    $week_days = array(); 
    $schedule_head = ""; 
    
    for ($i = 0; $i < 7; $i++) {
  
        $yyyymmdd = $week_start->format('Ymd');
        $date_str = $week_start->format('Y/m/j')." (". $seven_day_week[$i].")";
        
        
        $schedule_head .="'".$week_start->format('m/j')." ". $seven_day_week[$i]."',";
        array_push($week_days,['yyyymmdd'=>$yyyymmdd,'date_str'=>$date_str]); 
        
        $week_start->modify('+1 day');
    }
    
    $schedule_head = substr($schedule_head,0,strlen($schedule_head)); 
    
   // echo($bookings); 
  ?>
 
 	  <section class="module-small">
	      
       <div class="container">
         <form id="schedule_form" action="admin" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                 <div class="form-group">
                    <h4 class="font-alt mb-0">Schedule</h4>
                    <hr class="divider-w mt-10 mb-20">
                 </div>
                 @if(strcmp(Auth::user()->role,"admin")==0)
                 <div class="form-group">
                   <div role="tabpanel">
                      <ul class="nav nav-tabs font-alt" role="tablist">
                        @foreach($staffs as $staff)
                      
                         
                         <li <?php if($staff_id==$staff->user_id){ ?> class="active" <?php } ?>>
                            <a href="#staff_{{$staff->user_id}}" data-toggle="tab">
                            <span class="icon-profile-male"></span>{{$staff->name}}</a>
                          </li>
                        @endforeach
                        
                      </ul>
                    </div>
                </div>
                @endif 
              
               @if(strlen($msg)>0)
               <!--### alert Message for updating--> 
               <div class="form-group">
                @if(substr($msg,0,3)=='SUC')
                <div class="alert alert-success" role="alert" style="text-align: center;">
                  <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-calendar"></i> {{$msg}}
                </div>
                @endif
                @if(substr($msg,0,3)=='ERR')
                 <div class="alert alert-danger" role="alert" style="text-align: center;">
                  <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-exclamation-circle"></i> {{$msg}}
                </div>
                @endif
                @if(substr($msg,0,3)=='INF')
                 <div class="alert alert-info" role="alert" style="text-align: center;">
                  <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-info-circle"></i> {{$msg}}
                </div>
                @endif
               </div>
               @endif
               
               <div class="form-group">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title font-alt"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#advance_setup">
                          <span class="icon-tools-2"></span> Advanced Setting</a>
                        </h4>
                      </div>
                      <div class="panel-collapse collapse" id="advance_setup">
                        <div class="panel-body">
					           
					           <?php 
					                //default for 7 days
					                $from_default_date =  (new DateTime('now', new DateTimeZone('Pacific/Auckland')))->format('Y-m-d');
					                $to_defulat_date = (new DateTime('+7 day', new DateTimeZone('Pacific/Auckland')))->format('Y-m-d');
					           ?>
					           
					            <input name="from_date" type="date" value="{{$from_default_date}}" /> to <input name="to_date" type="date" value="{{$to_defulat_date}}"/>&nbsp;&nbsp;&nbsp;  
                        
						          <select name="from_hour">
						            <?php 
						                $from_hour = New DateTime('08:00:00'); 
						                
						                for($i=0;$i<22;$i++){ 
						                  
						                  $selected_str = ""; 
						                  if($i==0) $selected_str= "selected";
						                  echo "<option value='".$from_hour->format('Hi')."' ".$selected_str." >".$from_hour->format('H:i')."</option>"; 
						                  $from_hour->modify("+30 minutes"); 
						                }
						            ?>
                        </select> to
					 	            <select name="to_hour">
                         <?php 
						                $to_hour = New DateTime('08:00:00'); 
						                
						                for($i=0;$i<23;$i++){ 
						                  
						                  $selected_str = ""; 
						                  if($i==22) $selected_str= "selected";
						                  echo "<option value='".$to_hour->format('Hi')."' ".$selected_str." >".$to_hour->format('H:i')."</option>"; 
						                  $to_hour->modify("+30 minutes"); 
						                }
						            ?>
                        </select>&nbsp;&nbsp;&nbsp;  
                        
            						<input type="checkbox" name="days[]" value="Monday" checked>Mon 
            						<input type="checkbox" name="days[]" value="Tuesday" checked>Tue 
            						<input type="checkbox" name="days[]" value="Wednesday" checked>Wed
            						<input type="checkbox" name="days[]" value="Thursday" checked>Thu 
            						<input type="checkbox" name="days[]" value="Friday" checked>Fri 
            						<input type="checkbox" name="days[]" value="Saturday" checked>Sat
            						<input type="checkbox" name="days[]" value="Sunday" checked>Sun<br><br>
						
            						<button id="enable-schedule" class="btn btn-g btn-round btn-sm" type="button">Enable</button>
            						<button id="disable-schedule" class="btn btn-g btn-round btn-sm" type="button">Disable</button>
            						<button class="btn btn-g btn-round btn-sm" type="reset">Reset</button>
                      </div>
                    </div>
                </div>
              </div>
            
                <div class="form-group row multi-columns-row">
                    <input type="hidden" id="week_str" name="week_str" value="{{$week_str}}" />
                    <input type="hidden" id="staff_id" name="staff_id" value="{{$staff_id}}"/>
                    <input type="hidden" id="page_direction" name="page_direction" value="current" />
                    <input type="hidden" id="json_str" name="json_str" />
                    
                    <div class="col-sm-7">
                       		<div class="nav font-alt"> 
                       		   @if(!$_is_past)
                  					 <button class="btn btn-g btn-circle btn-sm" id="prev-week" type="button"><</button>
                  					 @endif
                  					 <button class="btn btn-g btn-circle btn-sm" id="next-week" type="button">></button>
                  					 <button class="btn btn-b btn-circle btn-sm" id="save-schedule" type="button">SAVE</button>
                  				
			                    </div>
                				<BR>
                	      <div id="day-schedule"></div>
                   </div>
                   <div class="col-sm-4">
                     <!--widget-->
                     <br><br>
                    <div class="widget">
                      <h5 class="widget-title font-alt">Weekly Bookings</h5>
                      
                      
                      @if($no_of_waitings>0)
                      <div class="alert alert-warning" role="alert">
                        <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <a href="admin/bookings"><i class="fa fa-cog fa-spin"></i><strong>{{$no_of_waitings}} bookings on the wait list</strong></a>
                      </div>
                      @endif 
                      
                      @if(count($bookings)<1) 
                      
                      <ul class="icon-list">
                        <li><strong><a></a></strong>No bookings existed</li>
                      </ul>
                      
                      @endif
                     
                     <?php 
                        $last_yyyymmdd= ""; 
                     ?>
                     
                     @foreach($bookings as $booking)    
                      
                      <?php 
                        $booking_yyyymmdd = substr($booking->datetime_id,0,8); 
                        $booking_hour = substr($booking->datetime_id,8,2).":".substr($booking->datetime_id,-2); 
                        
                        if(strlen($booking->service_title)>10) $service_name = substr($booking->service_title,0,9);
                          else  $service_name = $booking->service_title; 
                          
                        if(strcmp($last_yyyymmdd,$booking_yyyymmdd)!=0) { 
                     
                          foreach($week_days as $week_day){ 
                            
                            if(strcmp($week_day['yyyymmdd'],$booking_yyyymmdd)==0){ 
                      ?>
                      
                      <ul class="icon-list">
                        <li><strong><a>{{$week_day['date_str']}}</a></strong></li>
                      </ul>
                      
                      <?php 
                          
                            }
                          }    
                            
                        } 
                        $last_yyyymmdd = $booking_yyyymmdd; 
                      ?>
                      <ul class="widget-posts-meta">
                          <li>&nbsp;&nbsp;&nbsp;&nbsp;{{$booking_hour}} [{{$service_name}}] {{$booking->booking_name}} ({{$booking->booking_contact}}) 
                      
                      <!--    
                          @if(intval($booking->datetime_id) > intval($current_date->format("YmdHi")))
                            <a class="btn-xs" title="Cancel"><i class="fa fa-times"></i></a>
                          @endif 
                      -->      
                          </li>
                      </ul>
                      
                      @endforeach
                    </div>
                   </div>
                     <div id="day-schedule"></div>
                  </div>
             
                </div>
          
          </div>  
          </form>
	  	</div>
	  </section>
    
    
    <script src="{{ asset('js/weekly_schedule.js') }}"></script>
    <script>
    
    (function ($) {
      $("#day-schedule").dayScheduleSelector({
  
         days        : [0, 1, 2, 3, 4, 5, 6],  // Mon - Sun
   		   startTime   : '08:00',                // HH:mm format
   		   endTime     : '19:00',                // HH:mm format
    	   interval    : 30,                     // minutes
    	   stringDays  : [<?php echo(htmlspecialchars_decode($schedule_head, ENT_QUOTES)); ?>],
    	  
    	  
    	   template    : '<div class="day-schedule-selector">'         +
                       	 '<table class="schedule-table">'            +
                      	 		 '<thead class="schedule-header"></thead>' +
                      			 		 '<tbody class="schedule-rows"></tbody>'   +
                    	 '</table>'                                  +
                  		 '<div>'
      });
      
      $("#day-schedule").on('selected.artsy.dayScheduleSelector', function (e, selected) {
        console.log(selected);
      });
      
      $("#day-schedule").data('artsy.dayScheduleSelector').deserialize({
          <?php echo(htmlspecialchars_decode($schedule_str, ENT_QUOTES)); ?>
          
      });
      
      //####### Save Page Control variables ####### 
      $("#save-schedule").click(function() {
       
        if(confirm("Are you sure to update?")){ 
           
            start_date = {{$week_days[0]['yyyymmdd']}}; 
            
            hours = $("#day-schedule").data('artsy.dayScheduleSelector').serialize();
    
            json = '[';
    
            for (i = 0; i < 7; i++) {           
                for (y = 0; y < hours[i].length; y++) {
                    
                    start_hour = ((start_date+i)+hours[i][y][0]).replace( /:/g, "" ); 
                    end_hour =((start_date+i)+hours[i][y][1]).replace( /:/g, "" );
                   
                    json += '{"start":"'+ start_hour+'","end":"'+end_hour+'"},';
                }
            }
    
           json = json.slice(0, -1)+']';
    
            $("#json_str").attr("value", json);
            
            $("#schedule_form").attr("action", "admin/schedule/save");
            $("#schedule_form").submit(); 
            
        }
        
      });
      
      $("#enable-schedule").click(function() {
         if(confirm("Are you sure to update?")){ 
            $("#schedule_form").attr("action", "admin/schedule/enable");
            $("#schedule_form").submit(); 
         }
      });
      
      $("#disable-schedule").click(function() {
          if(confirm("Are you sure to update?")){ 
            $("#schedule_form").attr("action", "admin/schedule/disable");
            $("#schedule_form").submit(); 
          }
      });
      
      
      $("#prev-week").click(function(){
          $("#page_direction").attr("value", "prev");
          $("#schedule_form").submit(); 
      });
      
      $("#next-week").click(function(){
          $("#page_direction").attr("value", "next");
          $("#schedule_form").submit(); 
      });
      
    
      //need some PHP codes here
      @foreach($staffs as $staff)
      
      $('a[href="#staff_{{$staff->user_id}}"]').click(function(){
          $("#staff_id").attr("value", "{{$staff->user_id}}");
          $("#schedule_form").submit(); 
      }); 
      
      @endforeach
    
      
      
    })($);
    
    
    
   </script>
   
@endsection

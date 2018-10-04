@extends('layouts.admin')
@section('content')
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>  

<?php
    $current_date = (new DateTime('now', new DateTimeZone('Pacific/Auckland')))-> format("YmdHi");
?>

 	  <section class="module-small">
	      
       <div class="container">
    
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="form-group">
                <h4 class="font-alt mb-0">Bookings</h4> 
                <hr class="divider-w mt-10 mb-20">
            </div>
            
            @if (\Auth::user()->role=='admin')
            <div class="form-group">
              <button data-target="#addBooking" data-toggle="modal" class="btn btn-d btn-round" type="submit"><i class="fa fa-calendar"></i> New Booking</button>
            </div>
            @endif
            
            <div class="form-group">
            <div class="form-group">
                      <ul class="nav nav-pills" role="tablist">
                  
                         <li class="active">
                            <a href="#current" data-toggle="tab">
                              <span class="icon-clock"></span> Current</a>
                         </li>
                         <li>
                            <a href="#history" data-toggle="tab">
                              <span class="icon-layers"></span> History</a>
                         </li>
                          <li>
                            <a href="#cancel" data-toggle="tab">
                              <span class="icon-caution"></span> Cancelled</a>
                         </li>
                      </ul>
                      
              @php  
              $bookingArr=$bookings;
              @endphp       
              
               <div class="tab-content clearfix">
                <div id="current" class="tab-pane active">
                         <table class="table">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Date Time</th>
                                @if(strcmp(Auth::user()->role,"admin")==0)
                                <th>Barber</th> <!-- admin only-->
                                @endif
        					            	<th>Services</th>
        					            	<th>Client Name</th>
        						            <th>Contact</th>
        						            <th>Email</th>
        						            <th></th>
                              </tr>
                            </thead>
                            
                            <!--content-->
                            <tbody>
                              
                              @foreach($bookingArr as $booking)
        
                              @if(intval($booking->datetime_id) >= intval($current_date) && ($booking-> status == 'waiting' || $booking-> status == 'booked'))
                              
                              
                               @if($booking-> status == 'waiting') 
                                  <tr class="bg-warning" title="{{ $booking-> booking_memo }}"> 
                                    <td><i class="fa fa-cog fa-spin"></i></td>
                                @else
                                <tr title="{{ $booking-> booking_memo }}"> 
                                    <td></td>
                                @endif
                                    
                                    <td>{{ $booking-> displaydate }}</td>
                                    @if(strcmp(Auth::user()->role,"admin")==0)
                                    <td>{{ $booking-> barber }}</td>
                                    @endif
                                    <td>{{ $booking-> service_title }}</td>
                                    <td>{{ $booking-> client}}</td>
            						            <td>{{ $booking-> contact}}</td>
            						            <td>{{ $booking-> email}}</td>
            						          
            						          
            						          
            						            <td>
            						               @if($booking-> status == 'waiting') 
            						               <a href="{{ route('updateBookings', ['bookingid'=>$booking->booking_id,'status'=>'booked']) }}" class="btn-xs btn-success" title="Accept"><i class="fa fa-check"></i></a>
            						               <a href="{{ route('deleteBookings', ['bookingid'=>$booking->booking_id]) }}" onclick="return confirm('Press OK to remove booking')" class="btn-xs btn-danger" title="Remove"><i class="fa fa-times"></i></a>
            						               @else
            						               <a href="{{ route('updateBookings', ['bookingid'=>$booking->booking_id,'status'=>'cancelled']) }}" onclick="return confirm('Press OK to cancel booking')" class="btn-xs btn-warning" title="Cancel"><i class="fa fa-minus"></i></a>
            						               @endif
            						            </td>
                                  </tr>
                              @endif    
                              @endforeach
                            
                            </tbody>
                          </table>
                   </div>
                   
                   <!--History-->
                  <div id="history" class="tab-pane fade">
                    
                           <table class="table table-striped">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Date Time</th>
                                @if(strcmp(Auth::user()->role,"admin")==0)
                                <th>Barber</th> <!-- admin only-->
                                @endif
        					            	<th>Services</th>
        					            	<th>Client Name</th>
        						            <th>Contact</th>
        						            <th>Email</th>
                              </tr>
                            </thead>
                            
                            <!--content-->
                            <tbody>
                              
                              @foreach($bookingArr as $booking)
                              @if(intval($booking->datetime_id) < intval($current_date) && ($booking-> status == 'waiting' || $booking-> status == 'booked'))
                                  <tr title="{{$booking->booking_memo}}">
                                    <td></td>
                                    <td>{{ $booking-> displaydate }}</td>
                                    @if(strcmp(Auth::user()->role,"admin")==0)
                                    <td>{{ $booking-> barber }}</td>
                                    @endif
                                    <td>{{ $booking-> service_title }}</td>
                                    <td>{{ $booking-> client}}</td>
            						            <td>{{ $booking-> contact}}</td>
            						            <td>{{ $booking-> email}}</td>
                                  </tr>
                                  @endif
                              @endforeach
                            
                            </tbody>
                          </table>
                    
                  </div>
                  
                  <!--Cancel-->
                  <div id="cancel" class="tab-pane fade">
                    
                   <table class="table table-striped">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Date Time</th>
                                @if(strcmp(Auth::user()->role,"admin")==0)
                                <th>Barber</th> <!-- admin only-->
                                @endif
        					            	<th>Services</th>
        					            	<th>Client Name</th>
        						            <th>Contact</th>
        						            <th>Email</th>
                              </tr>
                            </thead>
                            
                            <!--content-->
                            <tbody>
                              
                              @foreach($bookingArr as $booking)
                                 @if( $booking->status == 'cancelled')
                                  <tr title="{{$booking->booking_memo}}">
                                    <td></td>
                                    <td>{{ $booking-> displaydate }}</td>
                                    @if(strcmp(Auth::user()->role,"admin")==0)
                                    <td>{{ $booking-> barber }}</td>
                                    @endif
                                    <td>{{ $booking-> service_title }}</td>
                                    <td>{{ $booking-> client}}</td>
            						            <td>{{ $booking-> contact}}</td>
            						            <td>{{ $booking-> email}}</td>
                                  </tr>
                                  @endif
                              @endforeach
                            
                            </tbody>
                          </table>
                    
                  </div>
                  
                  
                </div>
              </div>
            </div>
            
   

            </div>    
            </div>    
              
	  	</div>
	  </section>
	  
	  
  <div id="addBooking" class="modal fade"  data-backdrop="false">    
    	   <div class="modal-dialog container" style="background-color: #F5F5F5;">
    	     
                <form id="userForm" role="form" action="{{ action('AdminController@insertBooking') }}" method="post" >
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" type="text" id="name" name="name"/>
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" id="email" name="email"/>
                    <p class="help-block text-danger"></p>
                  </div>
				          <div class="form-group">
                    <label for="role">Contact</label>
                    <input class="form-control" type="number" id="contact" name="contact"/>
                    <p class="help-block text-danger"></p>
                  </div>
            
                 <div class="form-group">
                    <label >Booking Date</label>
                    <div class='input-group date'>
                     <input id="inlineDatepicker" class="timepicker form-control" type="text">
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                   </div>
                 </div>
                 
                <div class="form-group">
                    <label for="employees">Barber</label>
                    <select id="employees" name="employee_date" class="form-control"></select>
                 </div>
                 
                <div class="form-group">
                    <label for="services">Service</label>
                    <select id="services" name="service" class="form-control"></select>
                 </div>
                 
                  <div class="form-group">
                    <label for="comments">Comments</label>
                    <input class="form-control" type="text" id="comments" name="comment"/>
                    <p class="help-block text-danger"></p>
                  </div>
                
                  <!--<div class="form-group">-->
                  <!--  <textarea class="form-control" rows="4" id="service" name="service"></textarea>-->
                  <!--  <p class="help-block text-danger"></p>-->
                  <!--</div>-->
                  <div class="text-center">
                    <button class="btn btn-block btn-round btn-d" id="cfsubmit" type="submit">Submit</button>
                  </div>
                  <div>
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="userid" id="userid"/>
                  </div>
                </form>
            
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                
                </div>
            </div> 
            
            
	  
  <meta name="csrf-token" content="{{ csrf_token() }}" />
   	<script type="text/javascript">
	 
//09/29/2018
	   $('.timepicker').datetimepicker({
            format: 'MM/DD/YYYY'
      }).on("dp.change", function (e) {
      
      //console.log($(this).val());
      $date=$(this).val();
      // Load Barbers
      if($date!=null && $date!=''){
           console.log('check');
            LoadEmployees($date);
      }
      
      }); 
      
      


	  
	</script>  

@endsection
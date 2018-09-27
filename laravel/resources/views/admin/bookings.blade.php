@extends('layouts.admin')

@section('content')

 	  <section class="module-small">
	      
       <div class="container">
        <form>
    
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="form-group">
                <h4 class="font-alt mb-0">Bookings</h4> 
                <hr class="divider-w mt-10 mb-20">
            </div>
            <div class="form-group">
              <button class="btn btn-d btn-round" type="submit"><i class="fa fa-calendar"></i> New Booking</button>
            </div>
            <div class="form-group">
                   <div role="tabpanel">
                      <ul class="nav nav-tabs font-alt" role="tablist">
                  
                         
                         <li id="current" class="active">
                            <a href="#" data-target="#current" data-toggle="tab">
                              <span class="icon-clock"></span>Current</a>
                         </li>
                         <li id="history">
                            <a href="#history" data-target="#history" data-toggle="tab">
                              <span class="icon-layers"></span>History</a>
                         </li>
                          <li id="cancel">
                            <a href="#current" data-toggle="tab">
                              <span class="icon-caution"></span>Canceled</a>
                         </li>
          
                        
                      </ul>
                    </div>
            </div>
            <div id="current" class="form-group">
                         <table class="table">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Date Time</th>
                                <th>Barber</th> <!-- admin only-->
        					            	<th>Services</th>
        					            	<th>Client Name</th>
        						            <th>Contact</th>
        						            <th>Email</th>
        						            <th></th>
                              </tr>
                            </thead>
                            
                            <!--content-->
                            <tbody>
                              
                              @foreach($bookings as $booking)
                 
                                  <tr class="bg-warning" title="description here">
                                    <td><i class="fa fa-cog fa-spin"></i></td>
                                    <td>{{ $booking-> displaydate }}</td>
                                    <td>{{ $booking-> barber }}</td>
                                    <td>{{ $booking-> service_title }}</td>
                                    <td>{{ $booking-> client}}</td>
            						            <td>{{ $booking-> contact}}</td>
            						            <td>{{ $booking-> email}}</td>
            						            <td>
            						               <a href="{{ route('updateBookings', ['bookingid'=>$booking->booking_id,'status'=>'accepted']) }}" class="btn-xs btn-success" title="Accept"><i class="fa fa-check"></i></a>
            						               <a href="{{ route('updateBookings', ['bookingid'=>$booking->booking_id,'status'=>'cancelled']) }}" class="btn-xs btn-warning" title="Remove"><i class="fa fa-minus"></i></a>
            						            </td>
                                  </tr>
                              @endforeach
                            
                            </tbody>
                          </table>
                   </div>
                   
                  <div id="history" class="form-group">
                    
                  </div>

            </div>    
            </div>    
          </form>
              
	  	</div>
	  </section>
	  
  <meta name="csrf-token" content="{{ csrf_token() }}" />
	<script type="text/javascript">
	  
	    $(function() {
	      
	      $('li').click(function(){
	        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	       // alert(this.id);
               $.ajax({
                      type: "POST",
                      url: "bookings",
                      contentType: "application/json; charset=utf-8",
                      //dataType: "json",
                      data: {tab:this.id,_token: CSRF_TOKEN},
                      success: function(response){
                        if (response.success){
                          console.log( response);
                        }
                      },
                      error: function (XMLHttpRequest, textStatus, errorThrown){
                       console.log(errorThrown);
                      }
                    }).done(function( msg ) {
                    // console.log(msg);
                 });
        });
	      
    });
	  
	</script>  

@endsection
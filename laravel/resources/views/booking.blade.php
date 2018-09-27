@extends('layouts.main')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

     	<section class="module-small bg-dark">
          <div class="container">
            <div class="align-center">
                  <h1 class="module-title">Want to have original boss style?</h1>
                  <div class="module-subtitle font-serif">Bosscuts Hamilton is the best barbershop in New Zealand.</div>
            </div>
          </div>
      	</section>
        <section class="module-small">
          <div class="container">
          <!--<form>-->
		  <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <div class="row multi-columns-row">
                  <div class="col-md-6 col-lg-6">
				   	   <div id="inlineDatepicker"></div><br>
			 	  </div>
				   <div class="col-md-6 col-lg-6">
				      <br>
						  <select id="employees" class="form-control" >
						  </select>
						  <br>
						  <select id="services" class="form-control">
 						  </select>
 						  <br>
 						  <input id="email" class="form-control" type="email" placeholder="Email"/>
 						  <br>
 						  <input id="contact" class="form-control" type="tel" placeholder="Contact" required/>
 						  <br>
 						  <input id="customer" class="form-control" type="text" placeholder="Name" required/>
 						  <br>
  				  </div>
  				 </div>
  				 <div="row col-sm-offset-0 mb-sm-50 align-center">
				  	
				  	 <div class="text-center">
					  	<textarea id="comment" class="form-control" rows="7" placeholder="Make a comment here if you need"></textarea>
					  	<br>
            	<button class="btn btn-block btn-round btn-d" id="cfsubmit" type="submit">Submit</button>
          	 </div>
					   
  				  </div>
				</div>	
			  </div>
			 <!--</form>-->
          </div>
        </section>
        
	 
	  <div id="calendar"></div>
	  
    <div id="alert" class="alert alert-success collapse" role="alert" style="text-align: center;">
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-folder-open"></i>Booked successfully!
    </div>  
      
      <script src="js/jquery.datepick.js"></script>
      <script>
          $(function() {

              InitialLoadEmployees();

            	$('#inlineDatepicker').datepick({
            	            minDate: 0,
            	            maxDate: +90,
                        	//dateFormat: 'yyyymmdd',
                        	onSelect: function(date){
                      	  $date=$.datepick.formatDate(date[0]);  
                      	  LoadEmployees($date);
                      	}
            	    
            	});
            	
            
            	//Users load
            	$('#employees').change(function() {
            	  $val = ($(this).val());
                LoadServices($val.substring(0, $val.indexOf('_')));
            	
            	});
            
            
            //submit button
            $('#cfsubmit').click(function(){
             event.preventDefault();
             $val=$('#employees').val();
             
             $userid=$.trim($val.substring(0, $val.indexOf('_')));
             $datetimeid=$.trim($val.substring($val.indexOf('_')+1));
             $service=$('#services').val();
             $email=$('#email').val();
             $contact=$('#contact').val();
             $name=$('#customer').val();
             
             console.log($userid,',',$datetimeid,',',$service,',',$email,',',$contact,',',$name);
             $.ajax({
               type:'POST',
               url:'bookingSubmit/{userid}/{datetimeid}/{service}/{email}/{contact}/{name}',
               data:{
                 _token: '{{csrf_token()}}', 
                 userid:$userid,
                 datetimeid:$datetimeid,
                 service:$service,
                 email:$email,
                 contact:$contact,
                 name:$name
                 
               },
               success:function(result){
                  // console.log(result);
                 if(result){
                   
                    $('#email').val('');
                    $('#contact').val('');
                    $('#customer').val('');
                    $('#comment').val('');
                
                    $('#alert').show(); 
                 }
                
                
               }
             });
             
            // console.log($userid,',',$service,',',$email,',',$contact,',',$name);
              
            });
            
            
          });
          
          function InitialLoadEmployees(){
            $date=$("#inlineDatepicker").val();
              if( $date === "" || $date === null) 
              LoadEmployees($.datepick.formatDate('mm/dd/yyyy', new Date()));
            
          }
          
          function InitialLoadServices(){
             $val=$('#employees').val();
             $services = $('#services').val();
             
             if( $services=== null || $services==="")
             LoadServices($val.substring(0, $val.indexOf('_')));
            
            
          }
          
          
          //employees
          function LoadEmployees($date){
            
                	$.ajax({
                          type: 'GET', 
                          url: 'bookingDate/{date}',
                          data:{date:$date},
                          dataType:'json',
                          success: function(response){
                            // console.log(response);
                             var options = $("#employees");
                             options.empty();
                             
                              $.each(response, function() {
                                options.append(new Option(this.employee+' - '+this.datetime, this.id+'_'+this.datetimeid));
                             });

                          },
                          error: function (XMLHttpRequest, textStatus, errorThrown){
                          //  console.log(errorThrown);
                          },
                          complete:function(data){
                             InitialLoadServices();  
                          }
                      });
                        
                        
           }
           
           
           //services offered
           function LoadServices($employeeid){
             
                 $.ajax({
                  type:'GET',
                  url:'bookingServices/{empid}',
                  data:{empid:$employeeid},
                  dataType:'json',
                  success:function(result){
                // console.log(result);
                    
                    var options=$('#services');
                     options.empty();
                     $.each(result, function() {
                          options.append(new Option(this.service, this.service_id));
                     });
                  }
                   
                 });
             
           }
          
          
          
     </script>
	
@endsection
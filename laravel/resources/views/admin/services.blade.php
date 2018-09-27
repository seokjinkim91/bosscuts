@extends('layouts.admin')

@section('content')



 <section class="module-small">
	      
 
       <div class="container">
        <form>
    
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="form-group">
                <h4 class="font-alt mb-0">Services</h4>
                <hr class="divider-w mt-10 mb-20">
            </div>
            <div class="form-group">
                <button class="btn btn-d btn-round" data-target="#editDialog" data-toggle="modal" type="button"><i class="fa fa-cut"></i> New Service</button>
            </div>
            <div class="form-group">
                  <table class="table table-striped">
                    <thead>
                      
                      <tr>
                        <th>Title</th>
                        <th>Duration</th>
                        <th>Price</th>
            						<th>Type</th>
            						<!--<th>Priority</th>-->
            						<th>Description</th>
            						<th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      @foreach($services as $i=> $service)
                      
                      <tr>
                        <td>{{ $service-> service_title}}</td>
                        <td>{{ $service-> service_mins}}</td>
                        <td>{{ $service-> service_price}}</td>
						            <td>{{ $service-> service_type}}</td>
						            <!--<th>{{ $service-> service_priority}}</th>-->
					            	<td>{{ $service-> service_desc}}</td>
            						<td>
            						  <?php
            						  $id=$service -> service_id;
            						  $title=$service-> service_title;
            						  $mins=$service-> service_mins;
            						  $price=$service-> service_price;
            						  $type=$service-> service_type;
            						  // $priority=$service-> service_priority;
            						  $desc=$service-> service_desc;
            						  
            						  echo "<button data-target='#editDialog' data-toggle='modal' data-id='$id' data-title='$title' data-mins='$mins' data-price='$price' data-type='$type' data-desc='$desc' class='btn btn-d btn-circle btn-xs open-popup-link' type='button'>Edit</button>
            							<button data-target='#deleteDialog' data-toggle='modal' data-id='$id' data-title='$title' class='btn btn-danger btn-circle btn-xs open-popup-link' type='button'>Remove</button>";
            						  ?>
            					  </td>
                      </tr>
                      
                      @endforeach

                        </tbody>
                      </table>
                     </div>
       

                </div>    
                </div>    
         </form>
                  
    	</div>
    	

    </section>
   
       	 <!--<div id="edit_1" class="white-popup mfp-hide">  -->
       	 <!--<div id="editDialog" class="modal fade" tabindex="-1" data-backdrop="false" style="z-index:1200;">   
       	     <div class="modal-dialog modal-md modal-dialog-centered" role="document">
    	          <div class="modal-content">

       	 -->
       	 

    	 <div id="editDialog" class="modal fade"  data-backdrop="false"> 
    	  <div class="modal-dialog container" style="background-color: #F5F5F5;">
              <br>
                <form id="contactForm" role="form" action="{{ action('AdminController@editService') }}" method="post" >
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" id="title" name="title" placeholder="Add title" />
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <label for="duration">Duration (Min)</label>
                    <input class="form-control" type="number" id="duration" name="duration" placeholder="Total duration"/>
                    <p class="help-block text-danger"></p>
                  </div>
				          <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input class="form-control" type="number" id="price" name="price" placeholder="Price details" />
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" rows="7" placeholder="Add description" id="message" name="message"></textarea>
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-block btn-round btn-d" id="cfsubmit" type="submit">Submit</button>
                  </div>
                  
                  <div>
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="serviceid" id="serviceid"/>
                  </div>
                </form>
                
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               <br>
            </div>  
        </div>
        
        
        <div id="deleteDialog" class="modal fade" tabindex="-1"  data-backdrop="false" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="post" action="{{ action('AdminController@deleteService') }}">
               {{ csrf_field() }}
              {{ method_field('DELETE') }}
              
              <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                <!--  <span aria-hidden="true">&times;</span>-->
                <!--</button>-->
              </div>
              <div class="modal-body" >
               
              </div>
               <div>
                    <!--<input name="_token" type="hidden" value="{{ csrf_token() }}"/>-->
                    <input type="hidden" name="serviceid" id="serviceid"/>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger" >Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              </div>
            </form>
            
            </div>
          </div>
     </div>

@endsection

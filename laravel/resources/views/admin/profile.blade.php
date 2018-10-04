@extends('layouts.admin')

@section('content')

   <section class="module-small">
          <div class="container">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
                  
                  
              <form action="{{ action('AdminController@addProfile') }}" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}
                    <div class="form-group">
                        <h4 class="font-alt mb-0">Profile</h4>
                        <hr class="divider-w mt-10 mb-20">
                    </div>
                    
                    @php
                    
                    $isstaff=(strcmp(Auth::user()->role,"admin")!=0);
                    @endphp
                    
                    <div class="form-group row multi-columns-row">
                         <div class="col-md-3 col-lg-3"><input class="form-control" type="text" name="fname" value="{{ $isstaff? explode(" ",$users->name)[0]:null }}" placeholder="FirstName"/></div>
                         <div class="col-md-3 col-lg-3"><input class="form-control" type="text" value="{{ $isstaff?explode(" ",$users->name)[1]:null }}" name="lname" placeholder="Surname"/></div>
                         <div class="col-md-6 col-lg-6"><input class="form-control" type="text" name="email" value="{{$isstaff?$users->email:null}}" placeholder="Email" readonly/></div>
                            
                    </div>
                    <div class="form-group row multi-columns-row">
                
                         <div class="col-md-6 col-lg-6"><input class="form-control" name="contact" value="{{$isstaff?$users->contact:null}}" type="text" placeholder="Contact"/></div>
                         <div class="col-md-6 col-lg-6">
                             
                          @if(!$isstaff)      
                         <select name="role" class="form-control">
          					<option value="admin">Admin</option>
        					<option value="staff">Staff</option>
         				  </select>
         				 @endif
         				 
         				 
         				 
         				 @if($isstaff)
         				 <select name="role" class="form-control"disabled>
         				     <option>{{$users->role}}</option>
         				 </select>
         				 
         				  @endif
                         
                         
                         </div>  
                    </div>
                    <div class="form-group row multi-columns-row">
                         <div class="col-md-6 col-lg-6"><input class="form-control" name="password" type="password" placeholder="Enter password" required/></div>
                         <div class="col-md-6 col-lg-6"><input class="form-control" name="cpassword" type="password" placeholder="Confirm password" required/></div>
                    </div>
                    
                    @if(strcmp(Auth::user()->role,"admin")!=0)
                 
      				<div class="form-group mt-10">
      				     @foreach($services as $service)
                          <input name="service[]" type="checkbox" value="{{$service->service_id}}" {{$service->user_serviceid!=null?'checked':''}}> {{$service->service_title}} <br>
                        @endforeach                    
      			  
                    </div>
      			                     
      			   @endif
      			   
    				<div class="form-group">
    					<button class="btn btn-block btn-round btn-d" id="cfsubmit" type="submit">Save</button>
    				</div>
  				
  				
	            </form>
	            </div>
	       </div>
          </div>
      </section>


@endsection
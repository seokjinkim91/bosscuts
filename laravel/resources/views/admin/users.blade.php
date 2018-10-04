@extends('layouts.admin')

@section('content')
 <section class="module-small">
	      
       <div class="container">
        <form>
    
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="form-group">
                <h4 class="font-alt mb-0">Users</h4>
                <hr class="divider-w mt-10 mb-20">
             
            </div>
             <div class="form-group">
                <button type="button" data-target="#addDialog"  data-toggle="modal" class="btn btn-d btn-round" ><i class="fa fa-male"></i> New User</button>
            </div>
          <!--`name`, `contact`, `email`, `role`, `enable`, `photo_url`-->
            <div class="form-group">
                  <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
            						<th>Contact</th>
            						<th style="width:20%">Service</th>
            						<th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                            @foreach($users as $user)
                          
                              @php
                  						$id= $user->user_id;
                  						$enable = !$user->enable;
                  						$btnValue= $enable?'Enable':'Disable';
                  						$btnStyle= $enable?'btn-primary':'btn-danger';
                  						$trStyle= $enable?'background-color: #D3D3D3;':'background-color: #FFFFFF;';
                  						
                  						$name=$user->name;
                  						$email=$user->email;
                  						$role=$user->role;
                  						$contact=$user->contact;
                  						$title=$user->title;
                  						
                  						$imgpath=$user->photo_url;
                  						@endphp
                              
                            <tr style='{{$trStyle}}'>
                              
                              <td><span class="icon-profile-male"></span></td>
                              <td>{{$name}}</td>
                              <td>{{$email}}</td>
                  						<td>{{$role}}</td>
                  						<td>{{$contact}}</td>
                  						<td> 
                  					   @if(strlen($title)>0)   
                  					    <?php  $services = explode(',', $title); ?>
                  					      <ul>
                  					        @foreach($services as $service)
                  					          <li>{{$service}}</li>
                  					        @endforeach
                  					      </ul>	  
                  					  @endif
                  					 </td>
                  						
                  	
                  						
                  						<td>
                						    <a id="" href="#" data-target="#editDialog" data-toggle="modal" data-values='{{$name}},{{$email}},{{$role}},{{$contact}},{{$id}}' class="btn btn-d btn-circle btn-xs open-popup-link" role="button">Edit</a>
                						  	<a href="{{ route('userstatus', ['userid'=>$id,'enable'=>$enable])}}" class="btn {{$btnStyle}} btn-circle btn-xs open-popup-link" role="button">{{$btnValue}}</a>
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
    	
    	
    		<div id="addDialog" class="modal fade"  data-backdrop="false">    
    	   <div class="modal-dialog container" style="background-color: #F5F5F5;">
    	     
                <form id="addForm" role="form" action="{{ action('AdminController@addUsers') }}" method="post" >
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" type="text" placeholder="Full Name" name="name" required/>
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" required/>
                    <p class="help-block text-danger"></p>
                  </div>
                   <div class="form-group">
                    <label for="contact">Contact</label>
                    <input class="form-control" type="number" name="contact"/>
                    <p class="help-block text-danger"></p>
                  </div>
                  
                   <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password"name="password"/>
                    <p class="help-block text-danger"></p>
                  </div>
                  
				          <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" class="form-control" >
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                    </select>
                    <p class="help-block text-danger"></p>
                  </div>
                  
				          <div class="form-group">
                    <label for="role">Services</label>
                    <select multiple name="services[]" class="form-control" >
                    <option value="1">Mens cut & style</option>
                    <option value="2">Kids cut & style 1 to 16 years</option>
                    <option value="3">Clipper cut ( Clipper all over only)</option>
                    <option value="4">Mens cut, style & beard trim</option>
                    <option value="5">Beard trim only</option>
                    
                    </select>
                    <p class="help-block text-danger"></p>
                  </div>
                  

                 
                  <div class="text-center">
                    <button class="btn btn-block btn-round btn-d" id="cfsubmit" type="submit">Submit</button>
                  </div>
                  <div>
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <!--<input type="hidden" name="userid" id="add_userid"/>-->
                  </div>
                </form>
            
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                 </div>
            </div>
    	
    	
    	
    	   <div id="editDialog" class="modal fade"  data-backdrop="false">    
    	   <div class="modal-dialog container" style="background-color: #F5F5F5;">
    	     
                <form id="editForm" role="form" action="{{ action('AdminController@updateUsers') }}" method="post" >
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" type="text" id="name" placeholder="Full Name" name="name" required/>
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" id="email" name="email" required/>
                    <p class="help-block text-danger"></p>
                  </div>
                   <div class="form-group">
                    <label for="contact">Contact</label>
                    <input class="form-control" type="number" id="contact" name="contact"/>
                    <p class="help-block text-danger"></p>
                  </div>
                  
                   <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" id="password" name="password"/>
                    <p class="help-block text-danger"></p>
                  </div>
                  
				          <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" class="form-control" >
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                    </select>
                    <p class="help-block text-danger"></p>
                  </div>
                  
				          <div class="form-group">
                    <label for="role">Services</label>
                    <select multiple name="services[]" class="form-control" >
                    <option value="1">Mens cut & style</option>
                    <option value="2">Kids cut & style 1 to 16 years</option>
                    <option value="3">Clipper cut ( Clipper all over only)</option>
                    <option value="4">Mens cut, style & beard trim</option>
                    <option value="5">Beard trim only</option>
                    
                    </select>
                    <p class="help-block text-danger"></p>
                  </div>
                  

                 
                  <div class="text-center">
                    <button class="btn btn-block btn-round btn-d" id="editsubmit" type="submit">Submit</button>
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
    </section>
   
   <script type="text/javascript">
     $(function(){
        $('#editDialog').on('show.bs.modal', function (event) {
          
          var values = $(event.relatedTarget); 
          $arr =values.data('values').split(",");
        
          
          $('#name').val($arr[0]);
          $('#email').val($arr[1]);
          $('#role').val($arr[2]);
          $('#contact').val($arr[3]);
          $("#userid").val($arr[4]);

        });
});
     
   </script>
      
@endsection
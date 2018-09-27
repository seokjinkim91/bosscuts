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
                <button class="btn btn-d btn-round" type="submit"><i class="fa fa-male"></i> New User</button>
            </div>
          <!--`name`, `contact`, `email`, `role`, `enable`, `photo_url`-->
            <div class="form-group">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Photo</th>
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
                            <tr>
                              @php
                  						$id= $user->user_id;
                  						$enable = !$user->enable;
                  						$btnValue= $enable?'Enable':'Disable';
                  						$btnStyle= $enable?'btn-primary':'btn-danger';
                  						
                  						$name=$user->name;
                  						$email=$user->email;
                  						$role=$user->role;
                  						$contact=$user->contact;
                  						$title=$user->title;
                  						@endphp
                              
                              
                              <td><img src="{{$user->photo_url}}" height="10" width="15"></img></td>
                              <td>{{$name}}</td>
                              <td>{{$email}}</td>
                  						<td>{{$role}}</td>
                  						<td>{{$contact}}</td>
                  						<td>{{$title}}</td>
                  						
                  	
                  						
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
    	   <div id="editDialog" class="modal fade"  data-backdrop="false">    
    	   <div class="modal-dialog container" style="background-color: #F5F5F5;">
    	     
                <form id="userForm" role="form" action="{{ action('AdminController@updateUsers') }}" method="post" >
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
                    <label for="role">Role</label>
                    <input class="form-control" type="text" id="role" name="role"/>
                    <p class="help-block text-danger"></p>
                  </div>
                  <div class="form-group">
                    <label for="contact">Contact</label>
                    <input class="form-control" type="tel" id="contact" name="contact"/>
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
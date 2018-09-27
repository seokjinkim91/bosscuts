@extends('layouts.admin')

@section('content')
 <section class="module-small">
	      
       <div class="container">
        <form>
    
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="form-group">
                <h4 class="font-alt mb-0">Applicants</h4>
                <hr class="divider-w mt-10 mb-20">
            </div>
            <div class="form-group">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Contact</th>
            						<th>Email</th>
            						<th>Type</th>
            						<th>File</th>
            						<th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      @foreach($applicants as $applicant)
                      <tr>
                                    <td>{{$applicant->created_at }}</td>
                                    <td>{{$applicant->applicant_firstname }}</td>
                                    <td>{{$applicant->applicant_surname}}</td>
                                    <td>{{$applicant->applicant_contact}}</td>
            						<td>{{$applicant->applicant_email }}</td>
            						<th>{{$applicant->applicant_type }}</th>
            						
            						<td><a href="{{ public_path('/public_uploads/1537668769.lalalala.pptx ')}}" download><i class="fa fa-save"></i></a></td>
            						<td>
            							<button data-target="#deleteApplicantDialog" data-toggle="modal" data-id="{{$applicant->applicant_id }}" type="button" class="btn btn-danger btn-circle btn-xs open-popup-link">Remove</button>
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
        
        
         <div id="deleteApplicantDialog" class="modal fade" tabindex="-1"  data-backdrop="false" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="post" action="{{ action('AdminController@deleteApplicants') }}">
               {{ csrf_field() }}
               {{ method_field('DELETE') }}
              
              <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                <!--  <span aria-hidden="true">&times;</span>-->
                <!--</button>-->
              </div>
              <div class="modal-body" >
               Are you sure?
              </div>
               <div>
                    <!--<input name="_token" type="hidden" value="{{ csrf_token() }}"/>-->
                    <input type="hidden" name="applicant_id" id="applicant_id"/>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger" >Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              </div>
            </form>
            
            </div>
          </div>
     </div>

    </section>
   <script type="text/javascript" >
       $(function(){
          $('#deleteapplicantDialog').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget); 
             $('#applicant_id').val(button.data('id'));
             
            });
           
       });
       
   </script>
   
      
@endsection
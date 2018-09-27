@extends('layouts.main')

@section('content')
    
    <section class="module-small bg-dark">
          <div class="container">
            <div class="align-center">
                  <h1 class="module-title">Want to join with us?</h1>
                  <div class="module-subtitle font-serif">We are always open to your challenge.</div>
            </div>
          </div>
      </section>
      
      @if($success)
      
      <div class="alert alert-success" role="alert" style="text-align: center;">
        <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-folder-open"></i>Successfully submitted!
      </div>

      @endif
      
      <section class="module-small">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
              <form action="career" method="post" enctype="multipart/form-data">
                   {{ csrf_field() }}
                    <div class="form-group row multi-columns-row">
                         <div class="col-md-3 col-lg-3"><input class="form-control" name="firstname" type="text" placeholder="FirstName"/></div>
                         <div class="col-md-3 col-lg-3"><input class="form-control" name="surname" type="text" placeholder="Surname"/></div>
                         <div class="col-md-6 col-lg-6"><input class="form-control" name="email" type="text" placeholder="Email"/></div>
                            
                    </div>
                    <div class="form-group row multi-columns-row">
                
                         <div class="col-md-6 col-lg-6"><input class="form-control" name="contact" type="text" placeholder="Contact"/></div>
                         <div class="col-md-6 col-lg-6">
                         <select class="form-control" name="jobtype">
          					<option value="full">Full-Time</option>
        					<option value="part">Part-Time</option>
         				  </select>
                         </div>  
                    </div>
      				
      			                       
  				    <div class="form-group">
                         <input class="form-control" name="fileurl" type="file" placeholder="CV file 1"/>
    				</div>
    				<div class="form-group">
                        <textarea class="form-control" name="comment" rows="7" placeholder="Make a comment here if you need"></textarea>
                    </div>
    				<div class="form-group">
    					<button class="btn btn-block btn-round btn-d" id="cfsubmit" type="submit">Submit</button>
    				</div>
  				
  				
	            </form>
	            </div>
	       </div>
          </div>
      </section>


@endsection
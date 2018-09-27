@extends('layouts.admin')

@section('content')

   <section class="module-small">
          <div class="container">
            <div class="row">
              <div class="col-sm-10 col-sm-offset-1">
              <form>
                    <div class="form-group">
                        <h4 class="font-alt mb-0">Profile</h4>
                        <hr class="divider-w mt-10 mb-20">
                    </div>
                    <div class="form-group row multi-columns-row">
                         <div class="col-md-3 col-lg-3"><input class="form-control" type="text" placeholder="FirstName"/></div>
                         <div class="col-md-3 col-lg-3"><input class="form-control" type="text" placeholder="Surname"/></div>
                         <div class="col-md-6 col-lg-6"><input class="form-control" type="text" placeholder="Email"/></div>
                            
                    </div>
                    <div class="form-group row multi-columns-row">
                
                         <div class="col-md-6 col-lg-6"><input class="form-control" type="text" placeholder="Contact"/></div>
                         <div class="col-md-6 col-lg-6">
                         <select class="form-control">
          					<option value="Manager">Manager</option>
        					<option value="Barber">Barber</option>
         				  </select>
                         </div>  
                    </div>
      				<div class="form-group">
                        <input type="checkbox"> Buzzcut<br>
                        <input type="checkbox"> Menscut<br>
                        <input type="checkbox"> SpecialCut<br>
                       
                    </div>
      			                       
  				    <div class="form-group">
                         <input class="form-control" type="file" placeholder="CV file 1"/>
    				</div>
    				<div class="form-group">
                        <textarea class="form-control" rows="7" placeholder="Make a comment here if you need"></textarea>
                    </div>
    				<div class="form-group">
    					<button class="btn btn-block btn-round btn-d" id="cfsubmit" type="submit">Save</button>
    				</div>
  				
  				
	            </form>
	            </div>
	       </div>
          </div>
      </section>


@endsection
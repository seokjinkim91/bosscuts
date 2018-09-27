@extends('layouts.admin')

@section('content')

<section class="module">
	      
       <div class="container">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                 </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                @csrf
            <div class="row">
               <div class="col-sm-6 col-sm-offset-3">
                 <div class="form-group">
                    <h4 class="font-alt">{{ __('E-Mail Address') }}</h4>
                    <hr class="divider-w mb-10">
                 </div>
                 <div class="form-group">
                   <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                              <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                     @endif
                         
                    
                </div>
                <div class="form-group">
                            
                   <button type="submit" class="btn btn-round btn-b">
                          {{ __('Send Password Reset Link') }}
                    </button>
                            
                </div>
            </div>    
        </div>    
        </form>
              
	  	</div>
</section>

@endsection

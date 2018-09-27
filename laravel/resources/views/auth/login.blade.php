@extends('layouts.admin')

@section('content')



	  <section class="module">
	      
       <div class="container">
            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                @csrf
            <div class="row">
               <div class="col-sm-6 col-sm-offset-3">
                 <div class="form-group">
                    <h4 class="font-alt">Staff Login</h4>
                    <hr class="divider-w mb-10">
                 </div>
                 <div class="form-group">
                     <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                  </div>
                  <div class="form-group">
                         <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                         
                  </div>
                  <div class="form-group">
                            
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                             <label class="form-check-label" for="remember">
                                  {{ __('Remember Me') }}
                             </label>
                         </div>
                   </div>

                   <div class="form-group">
                      <button type="submit" class="btn btn-round btn-b"> {{ __('Login') }}</button>
                      <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                            
                    </div>
                </div>    
            </div>    
            </form>
              
	  	</div>
	  	</section>


@endsection

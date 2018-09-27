<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bosscuts - Admin Page</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    
    <!-- Default stylesheets-->
    <link rel="stylesheet" href="{{ asset('lib/bootstrap/dist/css/bootstrap.min.css') }}">
    
	  <!-- Template specific stylesheets--> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Volkhov:400i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
    
    <link rel="stylesheet" href="{{ asset('lib/animate.css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/components-font-awesome/css/font-awesome.min.css') }}">
    

    <link rel="stylesheet" href="{{ asset('lib/et-line-font/et-line-font.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/flexslider/flexslider.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/magnific-popup/dist/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/simple-text-rotator/simpletextrotator.css') }}">

  	<!-- Main stylesheet and color file-->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link id="color-scheme" rel="stylesheet" href="{{ asset('css/colors/default.css') }}">
	  
	<link href="{{ asset('css/weekly_schedule.css') }}" rel="stylesheet">
   
   <!--  
    JavaScripts
    =============================================
    -->
	<script src="{{ asset('lib/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lib/wow/dist/wow.js') }}"></script>
    <script src="{{ asset('lib/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js') }}"></script>
    <script src="{{ asset('lib/isotope/dist/isotope.pkgd.js') }}"></script>
    <script src="{{ asset('lib/imagesloaded/imagesloaded.pkgd.js') }}"></script>
    <script src="{{ asset('lib/flexslider/jquery.flexslider.js') }}"></script>
    <script src="{{ asset('lib/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/smoothscroll.js') }}"></script>
    <script src="{{ asset('lib/magnific-popup/dist/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('lib/simple-text-rotator/jquery.simple-text-rotator.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/instafeed.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/services.js') }}"></script>
   
</head>

<body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    <main>
      <div class="page-loader">
        <div class="loader">Loading...</div>
      </div>
      <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
            <div class="container">
                  <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse">
            			<span class="sr-only">Toggle navigation</span>
            			<span class="icon-bar"></span>
            			<span class="icon-bar"></span><span class="icon-bar"></span>
        			</button>
        			<a class="navbar-brand" href="{{ asset('') }}">Boss cuts</a>     			
                  </div>

                  <div class="collapse navbar-collapse" id="custom-collapse">
                     @guest
                     @else
                     <ul class="nav navbar-nav navbar-left">
                            <li><a href="{{asset('admin')}}">Schedule</a>
		                    <li><a href="{{asset('admin/bookings')}}">Bookings</a></li>
		                	<li><a href="{{asset('admin/profile')}}">Profile</a></li>
                            
                            <!--### Admin User Only Menu ###-->
                            @if(strcmp(Auth::user()->role,"admin")==0)
                                <li><a href="{{asset('admin/services')}}">Services</a></li>
			                    <li><a href="{{asset('admin/applicants')}}">Applicants</a></li>
				                <li><a href="{{asset('admin/users')}}">Users</a></li>
				            @endif
                     </ul>
                     
                     @endguest
                     <ul class="nav navbar-nav navbar-right">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ asset('career') }}">Careers</a>
                            </li>

                        @else
                                
                            <li>
                            
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                       {{ Auth::user()->name }} <i class="fa fa-minus-circle"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
                  
            </div>
        </nav>

        <div class="main">    
            @yield('content')
        </div>    
    </main>
 
</body>
</html>

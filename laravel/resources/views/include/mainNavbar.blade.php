<?php
    $nav_url=''; 
    
    if($page_name != 'main') $nav_url = asset(''); 
?>

<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container">
          <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse">
    			<span class="sr-only">Toggle navigation</span>
    			<span class="icon-bar"></span>
    			<span class="icon-bar"></span><span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="https://comps710-seokjinkim.c9users.io/laravel/public/">Boss Cuts</a>   
			
			<a class="navbar-brand" href="https://www.facebook.com/bosscutsnz/"><i class="fa fa-facebook"></i></a>
			<a class="navbar-brand" href="https://www.instagram.com/bosscutnzbarber/"><i class="fa fa-instagram"></i></a>
    </div>
    <div class="collapse navbar-collapse" id="custom-collapse">
            <ul class="nav navbar-nav navbar-right">
	            <li class="dropdown"><a href="{{$nav_url}}#totop">About us</a></li>
				  		<li class="dropdown"><a href="{{$nav_url}}#services">Service</a></li>
				  		<li class="dropdown"><a href="{{$nav_url}}#gallery">Gallery</a></li>
	         	 		<li class="dropdown"><a href="{{$nav_url}}#contact">Contact</a></li>
				  		<li class="dropdown"><a href="{{asset('')}}booking">Booking</a></li>
				  		<li class="dropdown"><a href="{{asset('')}}career">Career</a></li>
				  		<li><a href="{{asset('')}}admin"><i class="fa fa-user"></i>&nbsp;staff</a></li>
            </ul>
      </div>
    </div>
</nav>
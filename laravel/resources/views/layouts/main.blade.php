<!DOCTYPE html>
<html lang="en-US" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bosscuts Barbershop - Hamilton NZ</title>

    <!-- Default stylesheets-->
    <link rel="stylesheet" href="lib/bootstrap/dist/css/bootstrap.min.css">
    
	<!-- Template specific stylesheets--> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Volkhov:400i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
    
    <link rel="stylesheet" href="lib/animate.css/animate.css">
    <link rel="stylesheet" href="lib/components-font-awesome/css/font-awesome.min.css">
    

    <link rel="stylesheet" href="lib/et-line-font/et-line-font.css">
    <link rel="stylesheet" href="lib/flexslider/flexslider.css">
    <link rel="stylesheet" href="lib/owl.carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="lib/owl.carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="lib/magnific-popup/dist/magnific-popup.css">
    <link rel="stylesheet" href="lib/simple-text-rotator/simpletextrotator.css">
    
    <!-- Calendar CSS-->
  	<link href="css/jquery.datepick.css" rel="stylesheet">
	<!-- Main stylesheet and color file-->
    <link rel="stylesheet" href="css/style.css">
    <link id="color-scheme" rel="stylesheet" href="css/colors/default.css">
    
    <!--  
    JavaScripts
    =============================================
    -->
 
    <script src="lib/jquery/dist/jquery.js"></script>
    <script src="lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="lib/wow/dist/wow.js"></script>
    <script src="lib/jquery.mb.ytplayer/dist/jquery.mb.YTPlayer.js"></script>
    <script src="lib/isotope/dist/isotope.pkgd.js"></script>
    <script src="lib/imagesloaded/imagesloaded.pkgd.js"></script>
    <script src="lib/flexslider/jquery.flexslider.js"></script>
    <script src="lib/owl.carousel/dist/owl.carousel.min.js"></script>
    <!--<script src="lib/smoothscroll.js"></script>-->
    <script src="lib/magnific-popup/dist/jquery.magnific-popup.js"></script>
    <script src="lib/simple-text-rotator/jquery.simple-text-rotator.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/instafeed.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/jquery.plugin.min.js"></script>
  
  </head>
  <body data-spy="scroll" data-target=".onpage-navigation" data-offset="60">
    
    <main>
      <div class="page-loader">
        <div class="loader">Loading...</div>
      </div>
      <!-- Main Navbar is here... -->
      @include('include.mainNavbar')
      <div class="main">
         @yield('content')
	  </div>
        <hr class="divider-d">
        <footer class="footer bg-dark">
          <div class="container">
            <div class="row">
              <div class="col-sm-6">
                <p class="copyright font-alt">&copy; 2018&nbsp;Bosscuts Barbershop, All Rights Reserved</p>
              </div>
            </div>
          </div>
        </footer>
      <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
    </main>


  </body>

</html>
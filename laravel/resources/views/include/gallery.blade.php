  <section class="module bg-dark" id="gallery">
  <div class="container">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h2 class="module-title font-alt">Gallery</h2>
                <div class="module-subtitle font-serif">Photos from instagram</div>
              </div>
            </div>
            <div id="instagram" class="row multi-columns-row"></div>
            
  </div>
  
  <?php
    $insta_template = '<div class="col-sm-6 col-md-3 col-lg-3"> '.
                     ' <div class="gallery-item"> '.
                     ' <div class="gallery-image"><a class="gallery" href="{{link}}" title="{{caption}}"><img src="{{image}}" alt="{{caption}}"/> ' .
                     ' <div class="gallery-caption">'.
                     ' <div class="gallery-icon"><span class="icon-magnifying-glass"></span></div> '.
                     ' </div></a></div> '.
                     ' </div>'.
                     ' </div>';
                     
                     
  ?>
  
  
  <script>
  
        $(document).ready(function() {

        /* ---------------------------------------------- /*
          * Instagram Loader 
         /* ---------------------------------------------- */
           var feed = new Instafeed({
            		get: 'user',
            		userId: 8595272311,
            		accessToken: '8595272311.26a5fab.af17578d05544d5d834baac9d5f6d4dd',
            		target: 'instagram',
            		resolution: 'standard_resolution',
            		sortBy: 'most-recent', 
            		template: '<?php echo htmlspecialchars_decode($insta_template, ENT_NOQUOTES); ?>',
            
            });
           
           feed.run()
           
        }); 

    
  </script>
  
  </section>
  <section class="module bg-dark" id="gallery">
  <div class="container">
      <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
               <h2 class="module-title font-alt">Gallery</h2>
            </div>
      </div>
      
      <div class="row multi-columns-row">
        <div id="instagram"> </div>
      </div>
      <!-- <button id="btn-instafeed-load" class="btn">Load more</button> -->

            
  </div>
  
  
  
  <?php
    
    $insta_template =  '<div class="works-grid works-grid-masonry works-hover-w works-grid-5">'.
                     ' <div class="work-item" > '.
                     ' <div class="work-image"><a class="gallery" target="_blank" href="{{link}}" title="{{caption}}"><img src="{{image}}" alt="{{caption}}"/> ' .
                     ' <div class="work-caption">'.
                     ' <span class="fa fa-heart"></span>&nbsp;{{likes}}&nbsp;&nbsp;<span class="fa  fa-comment"></span>&nbsp;{{comments}}<br>{{caption}}'.
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
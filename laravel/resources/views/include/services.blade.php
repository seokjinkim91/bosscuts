	<section class="module" id="services">
          <div class="container">
          	 <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <h2 class="module-title font-alt">Our Services</h2>
                <div class="module-subtitle font-serif">A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</div>
              </div>
             </div>
            <div class="row multi-columns-row">
            <?php 
              $cnt = count($services); 
              $colspan = round($cnt/2);
              $i = 0;    
            ?>
            @foreach($services as $service)
             
            <?php 
            if($i==0){ ?>
            <div class="col-sm-6">
            <?php }else if($i==$colspan){ ?>
            </div>
            <div class="col-sm-6">
            <?php }?>
                <div class="menu">
                  <div class="row">
                    <div class="col-sm-8">
                      <h4 class="menu-title font-alt">{{$service->service_title}}</h4>
                      <div class="menu-detail font-serif">{{$service->service_desc}} ({{$service->service_mins}} min)</div>
                    </div>
                    <div class="col-sm-4 menu-price-detail">
                      <h4 class="menu-price font-alt">${{$service->service_price}}</h4>
                    </div>
                  </div>
                </div>
            <?php $i++;  ?>
            @endforeach
            </div>
             
            </div>
            <div class="text-center"><a class="btn btn-border-d mt-50" href="https://comps710-seokjinkim.c9users.io/laravel/public/booking">Book Now</a></div>
          </div>
    </section>
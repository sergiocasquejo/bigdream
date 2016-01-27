<!-- start header -->
<div class="navbar navbar-top navbar-fixed-top">
  <div class="container nav-mobile">
    <div class="navbar-header">
      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a href="<?php bloginfo('url'); ?>" class="brand navbar-brand"></a>
    </div>
   <!-- <div class="navbar-right">
      <?php echo do_shortcode('[google-translator]'); ?>
    </div>-->
    <div class="navbar-right">
      <nav class="collapse navbar-collapse">
        <?php wp_nav_menu( array(
          'theme_location' => 'primary_navigation',
          'menu_class' => 'nav navbar-nav'
        ) ); ?>
      </nav>
    </div>
  </div>
</div>
<div class="header_mobile" id="header_content">
  <div class="container">
      <!-- HEADER LOGO -->
      <div class="header_logo">
          <a href="#"><img src="images/logo-header.png" alt=""></a>
      </div>
      <!-- END / HEADER LOGO -->
      
      <!-- HEADER MENU -->
      <nav class="header_menu active" style="top: 147px;">
          <ul class="menu">
              <li>
                  <a href="index.html">Home <span class="fa fa-caret-down"></span></a>
                  <ul class="sub-menu">
                      <li><a href="index.html">Home 1</a></li>
                      <li><a href="index-2.html">Home 2</a></li>
                  </ul>
              </li>
              <li><a href="about.html">About</a></li>
              
              <li>
                  <a href="#">Room <span class="fa fa-caret-down"></span></a>
                  <ul class="sub-menu">
                      <li><a href="room-1.html">Room 1</a></li>
                      <li><a href="room-2.html">Room 2</a></li>
                      <li><a href="room-3.html">Room 3</a></li>
                      <li><a href="room-4.html">Room 4</a></li>
                      <li><a href="room-5.html">Room 5</a></li>
                      <li><a href="room-6.html">Room 6</a></li>
                      <li><a href="room-detail.html">Room Detail</a></li>
                  </ul>
              </li>
              <li>
                  <a href="#">Restaurant <span class="fa fa-caret-down"></span></a>
                  <ul class="sub-menu">
                      <li><a href="restaurants-1.html">Restaurant 1</a></li>
                      <li><a href="restaurants-2.html">Restaurant 2</a></li>
                      <li><a href="restaurants-3.html">Restaurant 3</a></li>
                      <li><a href="restaurants-4.html">Restaurant 4</a></li>
                  </ul>
              </li>
              <li class="current-menu-item">
                  <a href="#">Reservation <span class="fa fa-caret-down"></span></a>
                  <ul class="sub-menu">
                      <li><a href="reservation-step-1.html">Reservation Step 1</a></li>
                      <li><a href="reservation-step-2.html">Reservation Step 2</a></li>
                      <li class="current-menu-item"><a href="reservation-step-3.html">Reservation Step 3</a></li>
                      <li><a href="reservation-step-4.html">Reservation Step 4</a></li>
                      <li><a href="reservation-step-5.html">Reservation Step 5</a></li>
                  </ul>
              </li>
              <li>
                  <a href="#">Page <span class="fa fa-caret-down"></span></a>
                  <ul class="sub-menu">
                      <li>
                          <a href="#">Guest Book <span class="fa fa-caret-right"></span></a>
                          <ul class="sub-menu">
                              <li><a href="guest-book.html">Guest Book 1</a></li>
                              <li><a href="guest-book-2.html">Guest Book 2</a></li>
                          </ul>
                      </li>
                      
                      <li>
                          <a href="#">Event <span class="fa fa-caret-right"></span></a>
                          <ul class="sub-menu">
                              <li><a href="events.html">Events</a></li>
                              <li><a href="events-fullwidth.html">Events Fullwidth</a></li>
                              <li><a href="events-detail.html">Events Detail</a></li>
                          </ul>
                      </li>
                      <li>
                          <a href="attractions.html">Attractions</a>
                      </li>
                      <li>
                          <a href="#">Term Condition <span class="fa fa-caret-right"></span></a>
                          <ul class="sub-menu">
                              <li><a href="term-condition.html">Term Condition 1</a></li>
                              <li><a href="term-condition-2.html">Term Condition 2</a></li>
                          </ul>
                      </li>
                      <li>
                          <a href="">Activiti <span class="fa fa-caret-down"></span></a>
                          <ul class="sub-menu">
                              <li><a href="activiti.html">Activiti</a></li>
                              <li><a href="activiti-detail.html">Activiti Detail</a></li>
                          </ul>
                      </li>
                      <li><a href="check-out.html">Check Out</a></li>
                      <li><a href="shortcode.html">ShortCode</a></li>
                      <li><a href="page-404.html">404 Page</a></li>
                      <li><a href="comingsoon.html">Comming Soon</a></li>
                  </ul>
              </li>
              <li>
                  <a href="#">Gallery <span class="fa fa-caret-down"></span></a>
                  <ul class="sub-menu">
                      <li><a href="gallery.html">Gallery Style 1</a></li>
                      <li><a href="gallery-2.html">Gallery Style 2</a></li>
                      <li><a href="gallery-3.html">Gallery Style 3</a></li>
                  </ul>
              </li>
              <li>
                  <a href="#">Blog <span class="fa fa-caret-down"></span></a>
                  <ul class="sub-menu">
                      <li><a href="blog.html">Blog</a></li>
                      <li><a href="blog-detail.html">Blog Detail</a></li>
                      <li><a href="blog-detail-fullwidth.html">Blog Detail Fullwidth</a></li>
                  </ul>
              </li>
              <li><a href="contact.html">Contact</a></li>
          </ul>
      </nav>
      <!-- END / HEADER MENU -->
  
      <!-- MENU BAR -->
      <span class="menu-bars active">
          <span></span>
      </span>
      <!-- END / MENU BAR -->
  
  </div>
</div>

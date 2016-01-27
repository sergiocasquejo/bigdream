
  <div class="header_top">
    <div class="container">
        <div class="header_left navbar-left">
            <span><i class="hillter-icon-location"></i> Mandaue City 6015, Cebu Phils.</span>
            <span><i class="hillter-icon-phone"></i> (032) 222-222-22</span>
            <span><i class="hillter-icon-phone"></i> 236-434-3434</span>
        </div>
        <div class="header_right navbar-right">
    
            <ul class="social-media-icon navbar-right">
              <li><a href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            </ul> 
    
        </div>
    </div>
  </div>


<div class="header-sticky header_content" id="header_content">
  <div class="container">
      <!-- HEADER LOGO -->
      <div class="header_logo">
          <a href="<?php bloginfo('url'); ?>"><img src="<?php echo get_template_directory_uri() . '/dist/images/logo.png'; ?>" alt=""></a>
      </div>
      <!-- END / HEADER LOGO -->
      
      <!-- HEADER MENU -->
      <nav class="header_menu">
           <?php wp_nav_menu( array(
            'theme_location' => 'primary_navigation',
            'menu_class' => 'menu'
          ) ); ?>
      </nav>
      <!-- END / HEADER MENU -->

      <!-- MENU BAR -->
      <span class="menu-bars">
          <span></span>
          <span></span>
          <span></span>
      </span>
      <!-- END / MENU BAR -->

  </div>
</div>

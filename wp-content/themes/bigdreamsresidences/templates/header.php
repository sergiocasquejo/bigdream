<div class="header-sticky header_content" id="header_content">
  <div class="container">
    <div class="header_top">
        <div class="row">
          <div class="col-md-12">
            <div class="header_left pull-left">
                <span><i class="hillter-icon-location"></i> Mandaue City 6015, Cebu Phils.</span>
                <span><i class="hillter-icon-phone"></i> (032) 222-222-22</span>
                <span><i class="hillter-icon-phone"></i> 236-434-3434</span>
            </div>
            <div class="header_right pull-right">
                <ul class="social-media-icon">
                  <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                </ul> 
            </div>
          </div>
      </div>
    </div>
    <div class="header_bottom">
      <div class="header_logo">
          <a href="<?php bloginfo('url'); ?>"><img src="<?php echo get_template_directory_uri() . '/dist/images/logo.png'; ?>" alt=""></a>
      </div>
      <nav class="header_menu">
           <?php wp_nav_menu( array(
            'theme_location' => 'primary_navigation',
            'menu_class' => 'menu'
          ) ); ?>
      </nav>
      <span class="menu-bars">
          <span></span>
          <span></span>
          <span></span>
      </span>
    </div>
  </div>
</div>

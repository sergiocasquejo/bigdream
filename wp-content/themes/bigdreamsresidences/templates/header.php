<div class="header-sticky header_content" id="header_content">
  <div class="header_top">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="header_left pull-left">
              <span><i class="hillter-icon-location"></i> <?php echo get_theme_mod( 'bdr_contact_us_address' ); ?></span>
              <span><i class="hillter-icon-phone"></i> <?php echo get_theme_mod( 'bdr_contact_us_phone' ); ?></span>
              <span><i class="hillter-icon-phone"></i> <?php echo get_theme_mod( 'bdr_contact_us_toll_free' ); ?></span>
          </div>

          <div class="header_right pull-right">
              <ul class="social-media-icon">
                <li><a href="<?php echo get_theme_mod( 'bdr_social_media_facebook' ); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="<?php echo get_theme_mod( 'bdr_social_media_twitter' ); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <li class="ml-15"><a title="Your Cart" href="<?php echo get_permalink( get_page_by_path( 'review' ) ); ?>"><i class="fa fa-shopping-cart"></i></a></li>
              </ul> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="header_bottom">
      <div class="header_logo">
          <a href="<?php bloginfo('url'); ?>"><img src="<?php echo get_theme_mod( 'bdr_logo' ); ?>" alt=""></a>
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

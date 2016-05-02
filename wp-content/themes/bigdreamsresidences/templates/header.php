<div class="header-sticky header_content" id="header_content">
 
  <div class="container">
    <div class="header_bottom">
      <div class="header_logo">
          <a href="<?php bloginfo('url'); ?>" class="desktop-logo">
            <img src="<?php echo get_theme_mod( 'bdr_logo' ); ?>" height="100px" alt="">
          </a>
          <a href="<?php bloginfo('url'); ?>" class="mobile-logo">
            <img src="<?php echo get_theme_mod( 'bdr_mobile_logo' ); ?>" height="100px" alt="">
          </a>
      </div>
      <nav class="header_menu">
           <?php wp_nav_menu( array(
            'theme_location' => 'primary_navigation',
            'menu_class' => 'menu'
          ) ); ?>
      </nav>
      <span class="menu-bars">
          <span></span>
      </span>
    </div>
  </div>
</div>

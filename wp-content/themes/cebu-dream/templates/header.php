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

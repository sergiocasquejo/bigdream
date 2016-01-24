<?php while (have_posts()) : the_post(); ?>
  <div class="col-md-9">
    <h1><?php the_title(); ?></h1>
    <p><?php the_content(); ?></p>
  </div>
  <div class="col-md-3">
  </div>

<?php endwhile; ?>

<div class="section-room bg-white">
    <div class="container">

		<div class="room-wrap-1 animatedParent" data-sequence="500">
			<div class="row">
				<?php get_template_part('templates/page', 'header'); ?>
				<?php if (!have_posts()) : ?>
				  <div class="alert alert-warning">
				    <?php _e('Sorry, no results were found.', 'sage'); ?>
				  </div>
				  <?php get_search_form(); ?>
				<?php endif; ?>

				<?php global $wp_query; while (have_posts()) : the_post(); ?>
				  <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
				<?php  endwhile; ?>

				<?php the_posts_navigation(); ?>
			</div>
		</div>
	</div>
</div>
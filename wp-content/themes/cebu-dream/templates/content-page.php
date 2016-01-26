<div class="section-room bg-white">
	<div class="container">
		<?php the_content(); ?>
		<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
	</div>
</div>
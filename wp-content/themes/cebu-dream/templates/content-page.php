<?php if (!is_front_page() && !is_home()): ?>
<section class="room-banner bdr-parallax" style="background:#eee url('http://localhost/cebu-dream/wp-content/uploads/2016/01/4.jpg');">
	<div class="bdr-overlay"></div>
	<div class="sub-banner">
		<div class="container">
			<div class="text text-center">
				<h2>Lorem ipsum dolor 5</h2>
				<p>Lorem ipsum dolor sit amit</p>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
<div class="section-room bg-white">
	<div class="container">
		<?php the_content(); ?>
		<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
	</div>
</div>
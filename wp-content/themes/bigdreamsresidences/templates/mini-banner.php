<?php if ( ! is_front_page() && ! is_home() ): ?>
	<section class="room-banner bdr-parallax" style="background:#eee url('<?php echo wp_upload_dir()['baseurl'] . '/2016/01/slider-bg.jpg'; ?>;">
		<div class="bdr-overlay"></div>
		<div class="sub-banner">
			<div class="container">
				<div class="text text-center">
					<h2><?php the_title(); ?></h2>
					<p>Lorem ipsum dolor sit amit</p>
				</div>
			</div>
		</div>
	</section>
	<?php 
	site_notices(); 
endif; ?>
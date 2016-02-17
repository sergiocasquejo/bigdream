<?php if ( ! is_front_page() && ! is_home() ): ?>
	<section class="room-banner bdr-parallax" style="background:#ffffff url('<?php echo get_theme_mod('bdr_banner_background'); ?>') no-repeat center top; background-size:cover;">
		<div class="bdr-overlay"></div>
		<div class="sub-banner">
			<div class="container">
				<div class="text text-center">
					<h2><?php the_title(); ?></h2>
					
				</div>
			</div>
		</div>
	</section>
	<?php 
	site_notices(); 
endif; ?>
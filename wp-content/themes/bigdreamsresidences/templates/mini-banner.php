<?php if ( ! is_front_page() && ! is_home() ): ?>
	<section class="room-banner bdr-parallax" style="background:#eee; ?>;">
		<div class="bdr-overlay"></div>
		<div class="sub-banner">
			<div class="container">
				<div class="text text-center">
					<h2><?php 
					if ( is_single() ) {
						the_title(); 
						echo '<p>Lorem ipsum dolor sit amit</p>';
					}

					?></h2>
					
				</div>
			</div>
		</div>
	</section>
	<?php 
	site_notices(); 
endif; ?>
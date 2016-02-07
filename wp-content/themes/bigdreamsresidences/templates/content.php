<div class="col-md-6">
   	<div class="room_item-1">
   		<h2><a href="<?php the_permalink(); ?>"><?php the_title() ; ?></a></h2>
   		<div class="img">
   			<a href="<?php the_permalink(); ?>"><img src="<?php echo  featured_image( get_the_ID(), 'gallery-post-thumbnails' ) ; ?>" alt=""></a>
   		</div>
   		<div class="desc">
   			<p><?php echo  wp_trim_words( get_the_content(), 20) ; ?></p>
   			<ul>
   			<li><i class="fa fa-male"></i>Max: <?php the_field( 'max_person' ) ; ?> Person(s)</li>
			<li><i class="fa fa-bed"></i>Bed: <?php the_field( 'bed' ) ; ?></li>
			<li><i class="fa fa-eye"></i>View: <?php the_field( 'view' ) ; ?></li>
   			</ul>
   		</div>
   		<div class="bot">
   			<span class="price">Starting <?php the_room_price_html( get_the_ID() ) ; ?> /days</span>
   			<a href="<?php the_permalink(); ?>" class="bdr-btn bdr-btn-fill-black">VIEW DETAILS</a>
   		</div>
   </div>
</div>
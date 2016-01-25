<?php


function banner_slider_shortcode_handler($atts, $content = null, $tag) {
	global $post;
	extract(shortcode_atts( array(
	), $atts));

	$output = '';

	$gallery = get_field('gallery', $post->ID);

	$output .= '<div class="images-slider">';
    	$output .= '<section class="slider">';
			$output .= '<div class="flexslider">';
				$output .= '<ul class="slides">';
					foreach ($gallery as $i => $g) {
					$output .= '<li style="background:url('. $g['banner'] .');">';
						$output .= '<div class="banner-info">';
							$output .= '<h4 class="title">'. $g['title'] .'</h4>';
							$output .= '<h5 class="title1">'. $g['excerpt'] .'</h5>';
						$output .= '</div>';
					$output .= '</li>';
					}
				$output .= '</ul>';
			$output .= '</div>';
		$output .= '</section>';
	$output .= '</div>';

	return $output;
}

add_shortcode('banner-slider', 'banner_slider_shortcode_handler');


function online_reservation_form_shortcode_handler($atts, $content = null, $tag) {
	global $post;
	extract(shortcode_atts( array(
		'title' => 'Book A Room Online',
		'intro' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry'
	), $atts));
	$output = '';

	$output .= '<div class="online_reservation">';
		$output .= '<div class="b_room">';
			$output .= '<div class="booking_room col-md-3">';
				$output .= '<h4>'. $title .'</h4>';
				$output .= '<p>'. $intro .'</p>';
			$output .= '</div>';
			$output .= '<div class="reservation_form col-md-9">';
			$output .= '<form method="post">';
					$output .= '<ul>';
						$output .= '<li class="col-md-4">';
							$output .= '<div class="form-group">';
								$output .= '<h5>check-in-date:</h5>';
								$output .= '<input class="date form-control" name="date_in" id="date_in" type="text" value="DD/MM/YY" onfocus="this.value = \'\';" onblur="if (this.value == \'\') {this.value = \'DD/MM/YY\';}">';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li  class="col-md-4">';
							$output .= '<div class="form-group">';
								$output .= '<h5>check-out-date:</h5>';
								$output .= '<input class="date form-control" name="date_out" id="date_out" type="text" value="DD/MM/YY" onfocus="this.value = \'\';" onblur="if (this.value == \'\') {this.value = \'DD/MM/YY\';}">';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li class="col-md-2">';
							$output .= '<div class="form-group">';
								$output .= '<h5>Adults:</h5>';
								$output .= '<select name="no_of_adults" id="no_of_adults" onchange="change_country(this.value)" class="frm-field required  form-control">';
									for($i = 1; $i <= 10; $i++) {
									$output .= '<option value="'. $i .'">'. $i .'</option>';
									}
				        		$output .= '</select>';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li class="col-md-2">';
							$output .= '<div class="date_btn">';
									$output .= '<input type="hidden" name="action" value="check_availability" />';
									$output .= '<input type="submit" value="book now" class="bdr-btn bdr-btn-fill-red" />';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<div class="clear"></div>';
					$output .= '</ul>';
				$output .= '</form>';
			$output .= '</div>';
			$output .= '<div class="clear"></div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;
}

add_shortcode('reservation-form', 'online_reservation_form_shortcode_handler');


function featured_room_shortcode_handler($atts, $content = null) {
	$output = '';

	$q = get_posts(array(
		'post_type' => 'room',
		'showposts' => 4
		));

	$output .= '<div class="section-featured-room">';
		$output .= '<h2 class="room-featured_title">Featured Rooms</h2>';
		$output .= '<div class="room-content">';
			$output .= '<div class="row">';

				foreach($q as $i => $p) {
					$image = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'post-thumbnail')[0];

					$output .= '<div class="col-sm-6 col-md-4 col-lg-3">';
						$output .= '<div class="room-item">';
							$output .= '<div class="img">';
								$output .= '<a href="'. get_permalink($p->ID) .'">';
									$output .= '<img src="'. $image .'" alt="" />';
								$output .= '</a>';
							$output .= '</div>';
							$output .= '<div class="text">';
							$output .= '<h2><a href="'. get_permalink($p->ID) .'">'. $p->post_title .'</a></h2>';
							$output .= '<ul>';
							$output .= '<li><i class="fa fa-male"></i>Max: 2 Person(s)</li>';
							$output .= '<li><i class="fa fa-bed"></i>Bed: King-size or twin beds</li>';
							$output .= '<li><i class="fa fa-eye"></i>View: Ocen</li>';
							$output .= '</ul>';
							$output .= '<a href="'. get_permalink($p->ID) .'" class="bdr-btn bdr-btn-default">View Details</a>';;
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				}
				$output .= '<div class="clear"></div>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';
	return $output;
}

add_shortcode('featured-room', 'featured_room_shortcode_handler');

function room_listings_shortcode_handler($atts, $content = null) {
	$output = '';

	$q = get_posts(array(
		'post_type' => 'room',
		'showposts' => -1
		));

	$output .= '<div class="room-wrap-1">';
        $output .= '<div class="row">';
        	foreach($q as $i => $t){
            $output .= '<div class="col-md-6">';
               	$output .= '<div class="room_item-1">';
               		$output .= '<h2><a href="'.get_permalink($t->ID).'">'. $t->post_title .'</a></h2>';
               		$output .= '<div class="img">';
               			$output .= '<a href="'.get_permalink($t->ID).'"><img src="'. wp_get_attachment_image_src(get_post_thumbnail_id($t->ID), 'gallery-post-thumbnails')[0] .'" alt=""></a>';
               		$output .= '</div>';
               		$output .= '<div class="desc">';
               			$output .= '<p>'. wp_trim_words($t->post_content, 20) .'</p>';
               			$output .= '<ul>';
               			$output .= '<li>Max: 4 Person(s)</li>';
               			$output .= '<li>Size: 35 m2 / 376 ft2</li>';
               			$output .= '<li>View: Ocen</li>';
               			$output .= '<li>Bed: King-size or twin beds</li>';
               			$output .= '</ul>';
               		$output .= '</div>';
               		$output .= '<div class="bot">';
               			$output .= '<span class="price">Starting <span class="amout">$260</span> /days</span>';
               			$output .= '<a href="'.get_permalink($t->ID).'" class="bdr-btn bdr-btn-fill-red">VIEW DETAILS</a>';
               		$output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';
        	}
        $output .= '</div>';
    $output .= '</div>';


	return $output;
}

add_shortcode('room-listings', 'room_listings_shortcode_handler');
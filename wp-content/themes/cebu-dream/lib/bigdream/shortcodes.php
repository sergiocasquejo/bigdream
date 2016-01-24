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
			$output .= '<div class="reservation col-md-9">';
			$output .= '<form method="post">';
					$output .= '<ul>';
						$output .= '<li class="col-md-4">';
							$output .= '<h5>check-in-date:</h5>';
							$output .= '<div class="book_date">';
									$output .= '<input class="date" name="date_in" id="datepicker" type="text" value="DD/MM/YY" onfocus="this.value = \'\';" onblur="if (this.value == \'\') {this.value = \'DD/MM/YY\';}">';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li  class="col-md-4">';
							$output .= '<h5>check-out-date:</h5>';
							$output .= '<div class="book_date">';
									$output .= '<input class="date" name="date_out" id="datepicker1" type="text" value="DD/MM/YY" onfocus="this.value = \'\';" onblur="if (this.value == \'\') {this.value = \'DD/MM/YY\';}">';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li class="col-md-2">';
							$output .= '<h5>Adults:</h5>';
							$output .= '<div class="section_room">';
								$output .= '<select id="country" onchange="change_country(this.value)" class="frm-field required">';
									for($i = 1; $i <= 10; $i++) {
									$output .= '<option value="'. $i .'">'. $i .'</option>';
									}
				        		$output .= '</select>';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li class="col-md-2">';
							$output .= '<div class="date_btn">';
									$output .= '<input type="hidden" name="action" value="check_availability" />';
									$output .= '<input type="submit" value="book now" />';
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
		'showposts' => 3
		));


	$output .= '<div class="grids_of_3">';

		foreach($q as $i => $p) {
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'post-thumbnail')[0];

			$output .= '<div class="grid1_of_3">';
				$output .= '<div class="grid1_of_3_img">';
					$output .= '<a href="'. get_permalink($p->ID) .'">';
						$output .= '<img src="'. $image .'" alt="" />';
						$output .= '<span class="next"> </span>';
					$output .= '</a>';
				$output .= '</div>';
				$output .= '<h4><a href="'. get_permalink($p->ID) .'">'. $p->post_title .'<span>120$</span></a></h4>';
				$output .= '<p>'. wp_trim_words($p->post_content, 40) .'</p>';
			$output .= '</div>';
		}
		$output .= '<div class="clear"></div>';
	$output .= '</div>';

	return $output;
}

add_shortcode('featured-room', 'featured_room_shortcode_handler');
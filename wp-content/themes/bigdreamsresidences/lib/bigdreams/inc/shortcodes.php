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
		$output .= do_shortcode('[reservation-form]');
	$output .= '</div>';

	return $output;
}

add_shortcode('banner-slider', 'banner_slider_shortcode_handler');


function online_reservation_form_shortcode_handler($atts, $content = null, $tag) {
	global $post;
	extract(shortcode_atts( array(
		'title' => 'Check availability',
	), $atts));
	$output = '';

	$output .= '<div class="online_reservation">';
		$output .= '<div class="container">';
			$output .= '<div class="booking_room col-md-12 col-lg-3">';
				$output .= '<h2>'. $title .'</h2>';
			$output .= '</div>';
			$output .= '<div class="reservation_form col-md-12 col-lg-9">';
			$output .= '<div class="row">';
			$output .= '<form method="post">';
					$output .= '<ul>';
						$output .= '<li class="col-md-3">';
							$output .= '<div class="form-group">';
								$output .= '<h5>check-in-date:</h5>';
								$output .= '<input class="date form-control" name="date_in" id="date_in" type="text" value="'. booking_data('date_in', 'MM/DD/YYYY') .'" onfocus="this.value = \'\';" onblur="if (this.value == \'\') {this.value = \'MM/DD/YYYY\';}">';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li  class="col-md-3">';
							$output .= '<div class="form-group">';
								$output .= '<h5>check-out-date:</h5>';
								$output .= '<input class="date form-control" name="date_out" id="date_out" type="text" value="'. booking_data('date_out', 'MM/DD/YYYY') .'" onfocus="this.value = \'\';" onblur="if (this.value == \'\') {this.value = \'MM/DD/YYYY\';}">';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li class="col-md-2">';
							$output .= '<div class="form-group">';
								$output .= '<h5>Adults:</h5>';
								$output .= '<select name="no_of_adult" id="no_of_adult" class="frm-field required  form-control">';
									for($i = 1; $i <= 10; $i++) {
									$output .= '<option value="'. $i .'">'. $i .'</option>';
									}
				        		$output .= '</select>';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li class="col-md-2">';
							$output .= '<div class="form-group">';
								$output .= '<h5>Child:</h5>';
								$output .= '<select name="no_of_child" id="no_of_child" class="frm-field required  form-control">';
									for($i = 1; $i <= 10; $i++) {
									$output .= '<option value="'. $i .'">'. $i .'</option>';
									}
				        		$output .= '</select>';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li class="col-md-2">';
							$output .= '<div class="date_btn">';
									$output .= '<input type="hidden" name="action" value="check_availability" />';
									$output .= '<input type="submit" value="book now" class="bdr-btn bdr-btn-fill-black" />';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<div class="clear"></div>';
					$output .= '</ul>';
				$output .= '</form>';
				$output .= '</div>';
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
               			$output .= '<span class="price">Starting '. get_room_price_html($t->ID) .' /days</span>';
               			$output .= '<a href="'.get_permalink($t->ID).'" class="bdr-btn bdr-btn-fill-black">VIEW DETAILS</a>';
               		$output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';
        	}
        $output .= '</div>';
    $output .= '</div>';


	return $output;
}

add_shortcode('room-listings', 'room_listings_shortcode_handler');


function booking_review_shortcode_handler($atts, $content = null) {
	$output = '';



	$countries = json_decode(COUNTRY);

	$output .= '<div class="reservation-page">';
		//$output .= get_booking_steps();
		$output .= '<div class="row">';
			$output .='<form method="post">';
				$output .= '<div class="col-md-4 col-lg-3">';
					$output .= '<div class="reservation-sidebar">';
						$output .= '<div class="reservation-date bg-gray">';
	                        $output .= '<h2 class="reservation-heading">Dates</h2>';
	                        $output .= '<ul>';
	                       		$output .= '<li>';
	                       			$output .= '<span>Check-In</span>';
	                       			$output .= '<span>'. format_date(booking_data('date_in')) .'</span>';
	                       		$output .= '</li>';
	                       		$output .= '<li>';
	                       			$output .= '<span>Check-Out</span>';
	                       			$output .= '<span>'. format_date(booking_data('date_out')) .'</span>';
	                       		$output .= '</li>';
	                       		$output .= '<li>';
		                       		$output .= '<span>Total Nights</span>';
		                       		$output .= '<span>2</span>';
	                       		$output .= '</li>';
	                            $output .= '<li>';
	                            	$output .= '<span>Total Guests</span>';
	                            	$output .= '<span>'. booking_data('no_of_adult') .' Adults '. booking_data('no_of_child') .' Children</span>';
	                            $output .= '</li>';
	                        $output .= '</ul>';
	                    $output .= '</div>';
	                    $output .= '<div class="reservation-room-selected bg-gray">';
	                    	$output .= '<h2 class="reservation-heading">Selected Room</h2>';
	                    	$output .= '<div class="reservation-room-seleted_item">';
		                    	$output .= '<div class="reservation-room-seleted_name has-package">';
		                    		$output .= '<h2><a href="'. get_the_permalink(booking_data('room_ID')) .'">'. get_the_title(booking_data('room_ID')) .'</a></h2>';
		                    	$output .= '</div>';
		                    	$output .= '<ul>';
	                       		$output .= '<li>';
	                       			$output .= '<span>Max</span>';
	                       			$output .= '<span>4 Person(s)</span>';
	                       		$output .= '</li>';
	                       		$output .= '<li>';
	                       			$output .= '<span>Size</span>';
	                       			$output .= '<span>35 m2 / 376 ft2</span>';
	                       		$output .= '</li>';
	                       		$output .= '<li>';
		                       		$output .= '<span>Bed</span>';
		                       		$output .= '<span>King-size or twin beds</span>';
	                       		$output .= '</li>';
	                        $output .= '</ul>';
		                    $output .= '</div>';
	                                   
		                    $output .= '<div class="reservation-room-seleted_total bg-black">';
		                    	$output .= '<label>TOTAL</label>';
		                    	$output .= '<span class="reservation-total">'.  format_price(booking_data('amount'), false) .'</span>';
		                    $output .= '</div>';
		                $output .= '</div>';
	                $output .= '</div>';
	            $output .= '</div>';
				$output .= '<div class="col-md-8 col-lg-9">';
					$output .= '<div class="reservation_content">';
						$output .= '<div class="reservation-billing-detail">';
							//$output .= '<p class="reservation-login">Returning customer? <a href="'. wp_login_url( get_permalink(get_page_by_path('review')) )  .'">Click here to login</a></p>';
							$output .= '<h4>BILLING DETAILS</h4>';
							$output .= '<div class="row">';
								$output .= '<div class="col-sm-8">';
									$output .= '<label>Country <sup>*</sup></label>';
									$output .= '<select name="country" class="form-control">';
									foreach ($countries as $i => $c) {
			                            $output .= '<option value="'. $c .'" '. selected(booking_data('country'), $c, false) .'>'. $c .'</option>';
									}
			                       	$output .= '</select>';
		                       	$output .= '</div>';
		                       	$output .= '<div class="col-sm-4">';
		                       		$output .= '<label>Salutation <sup>*</sup></label>';
			                       	$output .= '<select name="salutation" class="form-control">';
										foreach (array('Mr', 'Ms', 'Mrs') as $i => $c) {
				                            $output .= '<option value="'. $c .'" '. selected(booking_data('salutation'), $c, false) .'>'. $c .'</option>';
										}
									$output .= '</select>';
		                    	$output .= '</div>';   	
	                       	$output .= '</div>';
	                       	$output .= '<div class="row">';
	                       		$output .= '<div class="col-sm-4">';
	                       			$output .= '<label for="first_name">First Name<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="first_name" class="form-control" value="'. booking_data('first_name') .'" required>';
	                       		$output .= '</div>';
	                       		$output .= '<div class="col-sm-4">';
	                       			$output .= '<label for="middle_name">Middle Name<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="middle_name" class="form-control" value="'. booking_data('middle_name') .'" required>';
	                       		$output .= '</div>';
	                       		$output .= '<div class="col-sm-4">';
	                       			$output .= '<label for="last_name">Last Name<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="last_name" class="form-control" value="'. booking_data('last_name') .'" required>';
	                       		$output .= '</div>';
	                       	$output .= '</div>';
	                       	$output .= '<label>Date of Birth<sup>*</sup></label>';
	                       	$output .= '<input type="text" name="birth_date" class="form-control bdr-calendar" value="'. booking_data('birth_date') .'" required>';
	                       	$output .= '<label>Nationality<sup>*</sup></label>';
	                       	$output .= '<input type="text" name="nationality" class="form-control" value="'. booking_data('nationality') .'" required>';
	                       	$output .= '<div class="row">';
	                       		$output .= '<div class="col-sm-6">';
	                       			$output .= '<label>Email Address<sup>*</sup></label>';
	                       			$output .= '<input type="email" name="email_address" class="form-control" value="'. booking_data('email_address') .'">';
	                       		$output .= '</div>';
	                       		$output .= '<div class="col-sm-6">';
	                       			$output .= '<label>Phone<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="primary_phone" class="form-control" value="'. booking_data('primary_phone') .'">';
	                       		$output .= '</div>';
	                       	$output .= '</div>';
	                       	$output .= '<label>Address<sup>*</sup></label>';
	                       	$output .= '<input type="text" name="address_1" class="form-control" placeholder="Street Address" value="'. booking_data('address_1') .'">';
	                       	$output .= '<br><br>';
	                       	$output .= '<input type="text" name="address_2" class="form-control" placeholder="Apartment, suite, unit etc. (Optional)" value="'. booking_data('address_2') .'">';
	                       	$output .= '<div class="row">';
	                       		$output .= '<div class="col-sm-4">';
	                       			$output .= '<label>Town / City<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="city" class="form-control" value="'. booking_data('city') .'">';
	                       		$output .= '</div>';
	                       		$output .= '<div class="col-sm-4">';
	                       			$output .= '<label>Province<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="province" class="form-control" value="'. booking_data('province') .'">';
	                       		$output .= '</div>';
	                       		$output .= '<div class="col-sm-4">';
	                       		$output .= '<label>Zip Code<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="zipcode" class="form-control" value="'. booking_data('zipcode') .'">';
	                       		$output .= '</div>';
	                       	$output .= '</div>';
	                       
	                       	$output .= '<label>Notes</label>';
	                       	$output .= '<textarea type="text" name="notes" class="form-controlarea form-control" placeholder="Notes about your book, eg. special notes for room">'. booking_data('notes') .'</textarea>';
	                       	/*$output .= '<label class="label-radio">';
	                       		$output .= '<input type="checkbox" class="input-radio create-accnt-radio"> ';
	                       		$output .= 'Create an account?';
	                       	$output .= '</label>';
	                       	$output .= '<div class="create-account-box hidden">';
		                       	$output .= '<div class="row">';
		                       		$output .= '<div class="col-sm-6">';
		                       			$output .= '<label>Password<sup>*</sup></label>';
		                       			$output .= '<input type="password" name="password" class="form-control">';
		                       		$output .= '</div>';
		                       		$output .= '<div class="col-sm-6">';
		                       			$output .= '<label>Confirm Password<sup>*</sup></label>';
		                       			$output .= '<input type="password" name="password2" class="form-control">';
		                       		$output .= '</div>';
		                       	$output .= '</div>';
	                       	$output .= '</div>';*/

	                       	$output .= '<input type="hidden" name="action" value="make_reservation" >';
	                       	$output .= '<button type="submit" class="bdr-btn bdr-btn-fill-black">BOOK NOW</button>';
	                  	$output .= '</div>';
	                $output .= '</div>';
				$output .= '</div>';
			$output .= '</form>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;
}
add_shortcode('booking_review', 'booking_review_shortcode_handler');


function success_message_shortcode_handler($atts, $content = '') {
	$output = '';
	$output .= '<div class="reservation_content">
                                
	                <div class="reservation-success-message bg-gray text-center">
	                    <h4>Thank you.</h4>
	                    <p>You have successfully booked, <br />we will review your booking information and contact you shortly for confirmation.</p>
	                    <a href="'. get_permalink(get_page_by_path('rooms-suits')) .'" class="bdr-btn bdr-btn-fill-black">Find Rooms</a>
	                </div>

	            </div>';

	$output .= success_booking_details();
    return $output;
}
add_shortcode('success_message', 'success_message_shortcode_handler');


function gallery_isotope_shortcode_handler($atts, $content = '') {
	$output = '';

	$terms = get_terms('galleria-cat');
	$output .= '<div class="gallery">';
		$output .= '<div class="gallery-cat text-center">';
			$output .= '<ul class="list-inline">';
			$output .= '<li><a class="active" href="#" data-filter="*">All</a></li>';
			foreach ($terms as $term) {
				$output .= '<li><a href="#" data-filter=".'. $term->slug .'">'. $term->name .'</a></li>';
			}
			$output .= '</ul>';
		$output .= '</div>';

		$q = get_posts(array('post_type' => 'galleria', 'showposts' => -1));
		$output .= '<div class="gallery-content">';
			$output .= '<div class="row">';
				$output .= '<div class="grid gallery-grid">';
				foreach ($q as $i => $t) {

					$terms = wp_get_post_terms( $t->ID, 'galleria-cat', array('fields' => 'slugs') );

					$image = wp_get_attachment_image(get_post_thumbnail_id($t->ID), 'gallery-thumbnail');
				  	$output .= '<div class="grid-item '. implode(' ', $terms) .'">'. $image .'</div>';
				}
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;
}

add_shortcode('gallery_isotope', 'gallery_isotope_shortcode_handler');

function contact_us_shortcode_handler() {
	

	$output = '';

	$output .= '<div class="contact">
                    <div class="row">

                        <div class="col-md-6 col-lg-5">

                            <div class="text">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries.</p>
                                <ul>
                                    <li><i class="fa fa-map-marker"></i> 225 Alang-Alang Mandaue City, Cebu</li>
                                    <li><i class="fa fa-phone"></i> +63 9 2321 652</li>
                                    <li><i class="fa fa-envelope-o"></i> info@bigdreamresidences.com</li>
                                </ul>
                            </div>

                        </div>

                        <div class="col-md-6 col-lg-6 col-lg-offset-1">
                            <div class="contact-form">';
                                $output .= do_shortcode('[contact-form-7 id="76" title="Contact Us"]');
                            $output .= '</div>
                        </div>

                    </div>  
                </div>';
	

	return $output;
}

add_shortcode('contact-us', 'contact_us_shortcode_handler');


function success_booking_details() {

	if (is_empty_booking()) {
		exit(wp_redirect(get_bloginfo('url')));
	}

	$d = get_booking_by_id(get_booking_session('booking_ID'));


	$output = '';

	$output .= '<div id="successBookingDetails">';
		$output .= '<a href="#" class="pull-right print-booking"><i class="fa fa-print"></i></a>';
		$output .= '<div  id="bookingDetailContent">';
		$output .= '<div class="success-booking-details">';
			
			$output .= '<div class="row">';
					$output .= '<div class="col-md-4 col-lg-3">';
						$output .= '<div class="reservation-sidebar">';
							$output .= '<div class="reservation-date">';
		                        $output .= '<h2 class="reservation-heading">Dates</h2>';
		                        $output .= '<ul>';
		                        	
		                       		$output .= '<li>';
		                       			$output .= '<span>Check-In</span>';
		                       			$output .= '<span>'. format_date($d['date_in']) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Check-Out</span>';
		                       			$output .= '<span>'. format_date($d['date_out']) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Total Nights</span>';
			                       		$output .= '<span>2</span>';
		                       		$output .= '</li>';
		                            $output .= '<li>';
		                            	$output .= '<span>Total Guests</span>';
		                            	$output .= '<span>'. $d['no_of_adult'] .' Adults '. $d['no_of_child'] .' Children</span>';
		                            $output .= '</li>';
		                        $output .= '</ul>';
		                    $output .= '</div>';
		                    $output .= '<div class="reservation-room-selected">';
		                    	$output .= '<h2 class="reservation-heading">Selected Room</h2>';
		                    	$output .= '<div class="reservation-room-seleted_item">';
			                    	$output .= '<div class="reservation-room-seleted_name has-package">';
			                    		$output .= '<h2><a href="'. get_the_permalink($d['room_ID']) .'">'. get_the_title($d['room_ID']) .'</a></h2>';
			                    	$output .= '</div>';
			                    	$output .= '<ul>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Max</span>';
		                       			$output .= '<span>4 Person(s)</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Size</span>';
		                       			$output .= '<span>35 m2 / 376 ft2</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Bed</span>';
			                       		$output .= '<span>King-size or twin beds</span>';
		                       		$output .= '</li>';
		                        $output .= '</ul>';
			                    $output .= '</div>';
		                                   
			                    $output .= '<div class="reservation-room-seleted_total">';
			                    	$output .= '<label>TOTAL</label>';
			                    	$output .= '<span class="reservation-total">'.  format_price($d['amount'], false) .'</span>';
			                    $output .= '</div>';
			                $output .= '</div>';
		                $output .= '</div>';
		            $output .= '</div>';
					$output .= '<div class="col-md-8 col-lg-9">';
						$output .= '<div class="reservation_content">';
							$output .= '<div class="reservation-billing-detail success-details">';
								$output .= '<h4>BILLING DETAILS</h4>';
								$output .= '<ul>';
									$output .= '<li>';
		                       			$output .= '<span>Booking #</span>';
		                       			$output .= '<span>'. format_date($d['booking_no']) .'</span>';
		                       		$output .= '</li>';
									$output .= '<li>';
			                       		$output .= '<span>Country</span>';
			                       		$output .= '<span>'. $d['country'] .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Full Name</span>';
			                       		$output .= '<span>'. $d['salutation'] .' '. $d['first_name'] .' '. $d['middle_name'] .' '. $d['last_name'] .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Date of Birth</span>';
			                       		$output .= '<span>'. $d['birth_date'] .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Nationality</span>';
			                       		$output .= '<span>'. $d['nationality'] .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Email Address</span>';
			                       		$output .= '<span>'. $d['email_address'] .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Phone</span>';
			                       		$output .= '<span>'. $d['primary_phone'] .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Address</span>';
			                       		$output .= '<span>'. $d['address_1'] .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Apartment, suite, unit etc.</span>';
			                       		$output .= '<span>'. $d['address_2'] .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Town / City</span>';
			                       		$output .= '<span>'. $d['city'] .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Province</span>';
			                       		$output .= '<span>'. $d['province'] .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Zip Code</span>';
			                       		$output .= '<span>'. $d['zipcode'] .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Notes</span><br />';
			                       		$output .= '<span>'. $d['notes'] .'</span>';
		                       		$output .= '</li>';
								$output .= '</ul>';
		                  	$output .= '</div>';
		                $output .= '</div>';
					$output .= '</div>';
				$output .= '</form>';
			$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	empty_booking();
	return $output;
}
<?php


function banner_slider_shortcode_handler( $atts, $content = null, $tag) {
	global $post;
	extract(shortcode_atts( array(
	), $atts) );

	$output = '';

	$gallery = get_field( 'gallery', $post->ID );

	$output .= '<div class="images-slider">';
    	$output .= '<section class="slider">';
			$output .= '<div class="flexslider">';
				$output .= '<ul class="slides">';
					foreach ( $gallery as $i => $g) {
					$output .= '<li style="background:url( '. $g['banner'] .' );">';
						// $output .= '<div class="banner-info">';
						// 	$output .= '<h4 class="title">'. $g['title'] .'</h4>';
						// 	$output .= '<h5 class="title1">'. $g['excerpt'] .'</h5>';
						// $output .= '</div>';
					$output .= '</li>';
					}
				$output .= '</ul>';
			$output .= '</div>';
		$output .= '</section>';
		$output .= do_shortcode( '[reservation-form]' );
	$output .= '</div>';

	return $output;
}

add_shortcode( 'banner-slider', 'banner_slider_shortcode_handler' );


function online_reservation_form_shortcode_handler( $atts, $content = null, $tag) {
	global $post;
	extract(shortcode_atts( array(
		'title' => 'Check availability',
	), $atts) );
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
								$output .= '<input class="date form-control" autocomplete="false" name="date_in" id="date_in" type="text" value="'. booking_data( 'date_in', 'MM/DD/YYYY' ) .'" onfocus="this.value = \'\';" onblur="if (this.value == \'\' ) {this.value = \'MM/DD/YYYY\';}" autocomplete="false" readonly>';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li  class="col-md-3">';
							$output .= '<div class="form-group">';
								$output .= '<h5>check-out-date:</h5>';
								$output .= '<input class="date form-control" autocomplete="false" name="date_out" id="date_out" type="text" value="'. booking_data( 'date_out', 'MM/DD/YYYY' ) .'" onfocus="this.value = \'\';" onblur="if (this.value == \'\' ) {this.value = \'MM/DD/YYYY\';}" autocomplete="false" readonly>';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li class="col-md-2">';
							$output .= '<div class="form-group">';
								$output .= '<h5>Adults:</h5>';
								$output .= '<select name="no_of_adult" id="no_of_adult" class="frm-field required  form-control">';
									for( $i = 1; $i <= 10; $i++) {
									$output .= '<option value="'. $i .'">'. $i .'</option>';
									}
				        		$output .= '</select>';
							$output .= '</div>';
						$output .= '</li>';
						$output .= '<li class="col-md-2">';
							$output .= '<div class="form-group">';
								$output .= '<h5>Child:</h5>';
								$output .= '<select name="no_of_child" id="no_of_child" class="frm-field required  form-control">';
								$output .= '<option value="0"></option>';
									for( $i = 1; $i <= 10; $i++) {
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

add_shortcode( 'reservation-form', 'online_reservation_form_shortcode_handler' );

function accommodations_shortcode_handler( $atts, $content = null ) {
	$output = '';

	$q = get_terms( 'room_type-cat', array( 'hide_empty' => false ) );

	$output .= '<div class="section-featured-room animatedParent" data-sequence="500">';
		$output .= '<h2 class="room-featured_title animated fadeInDown" data-id="1">ACCOMMODATIONS</h2>';
		$output .= '<div class="room-content">';
			$output .= '<div class="row">';

				foreach( $q as $i => $p) {
					$image = category_featured_image( $p->term_id, 'gallery-thumbnail' );

					$output .= '<div class="col-sm-6 col-md-4 col-lg-4">';
						$output .= '<div class="room-item animated fadeInLeft" data-id="'. ( $i + 1 ).'">';
							$output .= '<a href="'. get_term_link( $p ) .'">';
							$output .= '<div class="img" style="background:#F1F1F1 url(\''. $image  .'\') no-repeat top right;">';
							$output .= '</div>';
							$output .= '</a>';
							$output .= '<div class="text">';
							$output .= '<h2><a href="'. get_term_link( $p ) .'">'. $p->name .'</a></h2>';
							$output .= '<p class="desc">'. $p->description .'</p>';
							$output .= '<p class="price">'. format_price( get_field( 'category_price', 'room-cat_'. $p->term_id ), false ) .' /days</p>';
							$output .= '<a href="'. get_term_link( $p ) .'" class="bdr-btn bdr-btn-default pull-right">View Rooms</a>';
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

add_shortcode( 'accommodations', 'accommodations_shortcode_handler' );



function featured_room_shortcode_handler( $atts, $content = null ) {
	$output = '';

	$q = get_posts(array(
		'post_type' => 'room_type',
		'showposts' => 4
		) );

	$output .= '<div class="section-featured-room">';
		$output .= '<h2 class="room-featured_title">ACCOMMODATIONS</h2>';
		$output .= '<div class="room-content">';
			$output .= '<div class="row">';

				foreach( $q as $i => $p) {
					$image = featured_image( $p->ID, 'post-thumbnail' );

					$output .= '<div class="col-sm-6 col-md-4 col-lg-3">';
						$output .= '<div class="room-item">';
							$output .= '<div class="img">';
								$output .= '<a href="'. get_permalink( $p->ID ) .'">';
									$output .= '<img src="'. $image .'" alt="" />';
								$output .= '</a>';
							$output .= '</div>';
							$output .= '<div class="text">';
							$output .= '<h2><a href="'. get_permalink( $p->ID ) .'">'. $p->post_title .'</a></h2>';
							$output .= '<ul>';
							$output .= '<li><i class="fa fa-male"></i>Max: '. get_field( 'max_person', $p->ID ) .' Person(s)</li>';
							$output .= '<li><i class="fa fa-bed"></i>Bed: '. get_field( 'bed', $p->ID ) .'</li>';
							$output .= '<li><i class="fa fa-arrows-alt"></i>Size: '. get_field( 'room_size', $p->ID ) .'</li>';
		
							$output .= '</ul>';
							
							$output .= '<a href="'. get_permalink( $p->ID ) .'" class="bdr-btn bdr-btn-default">View Details</a>';
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

add_shortcode( 'featured-room', 'featured_room_shortcode_handler' );

function room_listings_shortcode_handler( $atts, $content = null ) {
	$output = '';

	$q = get_posts(array(
		'post_type' => 'room_type',
		'showposts' => -1
		) );

	$output .= '<div class="room-wrap-1 animatedParent" data-sequence="500">';
        $output .= '<div class="row">';
        	foreach( $q as $i => $t){
            $output .= '<div class="col-md-6">';
               	$output .= '<div class="room_item-1 animated bounceInDown" data-id="'. $i .'">';
               		$output .= '<h2><a href="'.get_permalink( $t->ID ).'">'. $t->post_title .'</a></h2>';
               		$output .= '<div class="img">';
               			$output .= '<a href="'.get_permalink( $t->ID ).'"><img src="'. featured_image( $t->ID, 'gallery-post-thumbnails' ) .'" alt=""></a>';
               		$output .= '</div>';
               		$output .= '<div class="desc">';
               			$output .= '<p>'. wp_trim_words( $t->post_content, 20) .'</p>';
               			$output .= '<ul>';
               			$output .= '<li><i class="fa fa-male"></i>Max: '. get_field( 'max_person', $t->ID ) .' Person(s)</li>';
						$output .= '<li><i class="fa fa-bed"></i>Bed: '. get_field( 'bed', $t->ID ) .'</li>';
						$output .= '<li><i class="fa fa-arrows-alt"></i>Size: '. get_field( 'room_size', $t->ID ) .'</li>';
               			$output .= '</ul>';
               		$output .= '</div>';
               		$output .= '<div class="bot">';
               			$output .= '<span class="price">Starting '. get_room_price_html( $t->ID ) .' /days</span>';
               			$output .= '<a href="'.get_permalink( $t->ID ).'" class="bdr-btn bdr-btn-fill-black">VIEW DETAILS</a>';
               		$output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';
        	}
        $output .= '</div>';
    $output .= '</div>';


	return $output;
}

add_shortcode( 'room-listings', 'room_listings_shortcode_handler' );


function booking_review_shortcode_handler( $atts, $content = null ) {
	$output = '';

	if (is_empty_booking() ) {
		empty_booking();
		redirect_js_script( get_bloginfo( 'url' ) );
	}

	$room_type_ID = booking_data( 'room_type_ID' );

	$countries = countries();
	$nights = count_nights( booking_data( 'date_in' ), booking_data( 'date_out' ) );
	$room_price = booking_data( 'room_price' );

	$output .= '<div class="reservation-page animatedParent"  data-sequence="500">';
		//$output .= get_booking_steps();
		$output .= '<div class="row">';
			$output .='<form method="post">';
				$output .= '<div class="col-md-4 col-lg-3">';
					$output .= '<div class="reservation-sidebar animated fadeInLeft" data-id="1">';
						$output .= '<div class="reservation-date bg-gray">';
	                        $output .= '<h2 class="reservation-heading">Dates</h2>';
	                        $output .= '<ul>';
	                       		$output .= '<li>';
	                       			$output .= '<span>Check-In</span>';
	                       			$output .= '<span>'. format_date( booking_data( 'date_in' ) ) .'</span>';
	                       		$output .= '</li>';
	                       		$output .= '<li>';
	                       			$output .= '<span>Check-Out</span>';
	                       			$output .= '<span>'. format_date( booking_data( 'date_out' ) ) .'</span>';
	                       		$output .= '</li>';
	                       		$output .= '<li>';
		                       		$output .= '<span>Total Nights</span>';
		                       		$output .= '<span>'. $nights .'</span>';
	                       		$output .= '</li>';
	                            $output .= '<li>';
	                            	$output .= '<span>Total Guests</span>';
	                            	$output .= '<span>'. booking_data( 'no_of_adult' ) .' Adults '. booking_data( 'no_of_child' ) .' Children</span>';
	                            $output .= '</li>';
	                        $output .= '</ul>';
	                    $output .= '</div>';
	                    $output .= '<div class="reservation-room-selected bg-gray">';
	                    	$output .= '<h2 class="reservation-heading">Selected Room</h2>';
	                    	$output .= '<div class="reservation-room-seleted_item">';
		                    	$output .= '<div class="reservation-room-seleted_name has-package">';
		                    		$output .= '<h2><a href="'. get_the_permalink( $room_type_ID ) .'">'. get_the_title( $room_type_ID ) .'</a></h2>';
		                    	$output .= '</div>';
			                    $output .= '<ul>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Room Price</span>';
		                       			$output .= '<span>'. nf( $room_price ) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Max</span>';
		                       			$output .= '<span>'. get_field( 'max_person', $room_type_ID ) .' Person(s)</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Size</span>';
		                       			$output .= '<span>'. get_field( 'room_size', $room_type_ID ) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Bed</span>';
			                       		$output .= '<span>'. get_field( 'bed', $room_type_ID ) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>View</span>';
			                       		$output .= '<span>'. get_field( 'view', $room_type_ID ) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Total Room '. booking_data( 'no_of_room' ).'</span>';
		                       			$output .= '<span>'. nf( $room_price * booking_data( 'no_of_room' ) ).'</span>';
		                       		$output .= '</li>';
		                        $output .= '</ul>';
		                    $output .= '</div>';
	                                   
		                    $output .= '<div class="reservation-room-seleted_total bg-black">';
		                    	$output .= '<label>TOTAL</label>';
		                    	$output .= '<span class="reservation-total">'.  format_price( booking_data( 'amount' ), false ) .'</span>';
		                    $output .= '</div>';
		                $output .= '</div>';
	                $output .= '</div>';
	            $output .= '</div>';
				$output .= '<div class="col-md-8 col-lg-9">';
					$output .= '<div class="reservation_content animated fadeInRight" data-id="2">';
						$output .= '<div class="reservation-billing-detail">';
							$output .= '<h4>BILLING DETAILS</h4>';
							$output .= '<div class="row">';
								$output .= '<div class="col-sm-8">';
									$output .= '<label>Country <sup>*</sup></label>';
									$output .= '<select name="country" class="form-control">';
									foreach ( $countries as $i => $c) {
			                            $output .= '<option value="'. $c .'" '. selected( booking_data( 'country' ), $c, false ) .'>'. $c .'</option>';
									}
			                       	$output .= '</select>';
		                       	$output .= '</div>';
		                       	$output .= '<div class="col-sm-4">';
		                       		$output .= '<label>Salutation <sup>*</sup></label>';
			                       	$output .= '<select name="salutation" class="form-control">';
										foreach (array( 'Mr', 'Ms', 'Mrs' ) as $i => $c) {
				                            $output .= '<option value="'. $c .'" '. selected( booking_data( 'salutation' ), $c, false ) .'>'. $c .'</option>';
										}
									$output .= '</select>';
		                    	$output .= '</div>';   	
	                       	$output .= '</div>';
	                       	$output .= '<div class="row">';
	                       		$output .= '<div class="col-sm-4">';
	                       			$output .= '<label for="first_name">First Name<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="first_name" class="form-control" value="'. booking_data( 'first_name' ) .'" required>';
	                       		$output .= '</div>';
	                       		$output .= '<div class="col-sm-4">';
	                       			$output .= '<label for="middle_name">Middle Name<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="middle_name" class="form-control" value="'. booking_data( 'middle_name' ) .'" required>';
	                       		$output .= '</div>';
	                       		$output .= '<div class="col-sm-4">';
	                       			$output .= '<label for="last_name">Last Name<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="last_name" class="form-control" value="'. booking_data( 'last_name' ) .'" required>';
	                       		$output .= '</div>';
	                       	$output .= '</div>';
	                       	$output .= '<label>Date of Birth<sup>*</sup></label>';
	                       	$output .= '<input type="text" name="birth_date" class="form-control bdr-calendar" value="'. booking_data( 'birth_date' ) .'" required>';
	                       	$output .= '<label>Nationality<sup>*</sup></label>';
	                       	$output .= '<input type="text" name="nationality" class="form-control" value="'. booking_data( 'nationality' ) .'" required>';
	                       	$output .= '<div class="row">';
	                       		$output .= '<div class="col-sm-6">';
	                       			$output .= '<label>Email Address<sup>*</sup></label>';
	                       			$output .= '<input type="email" name="email_address" class="form-control" value="'. booking_data( 'email_address' ) .'">';
	                       		$output .= '</div>';
	                       		$output .= '<div class="col-sm-6">';
	                       			$output .= '<label>Phone<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="primary_phone" class="form-control" value="'. booking_data( 'primary_phone' ) .'">';
	                       		$output .= '</div>';
	                       	$output .= '</div>';
	                       	$output .= '<label>Address<sup>*</sup></label>';
	                       	$output .= '<input type="text" name="address_1" class="form-control" placeholder="Street Address" value="'. booking_data( 'address_1' ) .'">';
	                       	$output .= '<br><br>';
	                       	$output .= '<input type="text" name="address_2" class="form-control" placeholder="Apartment, suite, unit etc. (Optional )" value="'. booking_data( 'address_2' ) .'">';
	                       	$output .= '<div class="row">';
	                       		$output .= '<div class="col-sm-4">';
	                       			$output .= '<label>Town / City<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="city" class="form-control" value="'. booking_data( 'city' ) .'">';
	                       		$output .= '</div>';
	                       		$output .= '<div class="col-sm-4">';
	                       			$output .= '<label>Province<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="province" class="form-control" value="'. booking_data( 'province' ) .'">';
	                       		$output .= '</div>';
	                       		$output .= '<div class="col-sm-4">';
	                       		$output .= '<label>Zip Code<sup>*</sup></label>';
	                       			$output .= '<input type="text" name="zipcode" class="form-control" value="'. booking_data( 'zipcode' ) .'">';
	                       		$output .= '</div>';
	                       	$output .= '</div>';
	                       
	                       	$output .= '<label>Notes</label>';
	                       	$output .= '<textarea type="text" name="notes" class="form-controlarea form-control" placeholder="Notes about your book, eg. special notes for room">'. booking_data( 'notes' ) .'</textarea>';


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
add_shortcode( 'booking_review', 'booking_review_shortcode_handler' );


function success_message_shortcode_handler( $atts, $content = '' ) {
	$output = '';
	$output .= '<div class="reservation_content">
	                <div class="reservation-success-message bg-gray text-center">
	                    <h4>Thank you.</h4>
	                    <p>You have successfully booked, <br />we will review your booking information and contact you shortly for confirmation.</p>
	                    <a href="'. page_permalink( 'rooms-suits' ) .'" class="bdr-btn bdr-btn-fill-black">Find Rooms</a>
	                </div>
	            </div>';

	$output .= success_booking_details();
    return $output;
}
add_shortcode( 'success_message', 'success_message_shortcode_handler' );


function gallery_isotope_shortcode_handler( $atts, $content = '' ) {
	$output = '';

	$terms = get_terms( 'galleria-cat' );
	$output .= '<div class="gallery">';
		$output .= '<div class="gallery-cat text-center">';
			$output .= '<ul class="list-inline">';
			$output .= '<li><a class="active" href="#" data-filter="*">All</a></li>';
			foreach ( $terms as $term) {
				$output .= '<li><a href="#" data-filter=".'. $term->slug .'">'. $term->name .'</a></li>';
			}
			$output .= '</ul>';
		$output .= '</div>';

		$q = get_posts(array( 'post_type' => 'galleria', 'showposts' => -1) );
		$output .= '<div class="gallery-content">';
				$output .= '<div class="grid gallery-grid">';
				foreach ( $q as $i => $t) {

					$terms = wp_get_post_terms( $t->ID, 'galleria-cat', array( 'fields' => 'slugs' ) );

					$image = featured_image( $t->ID, 'gallery-thumbnail' );
				  	$output .= '<div class="grid-item '. implode( ' ', $terms) .'"><img src="'. $image .'" /></div>';
				}
				$output .= '</div>';
		$output .= '</div>';
	$output .= '</div>';

	return $output;
}

add_shortcode( 'gallery_isotope', 'gallery_isotope_shortcode_handler' );

function contact_us_shortcode_handler() {
	

	$output = '';

	$output .= '<div class="contact animatedParent"  data-sequence="500">
                    <div class="row">

                        <div class="col-md-6 col-lg-5 animated fadeInLeft" data-id="1">

                            <div class="text">
                                <p>'. get_theme_mod( 'bdr_contact_us_text' ) .'</p>
                                <ul>
                                    <li><i class="fa fa-map-marker"></i> '. get_theme_mod( 'bdr_contact_us_address' ) .'</li>
                                    <li><i class="fa fa-phone"></i> '. get_theme_mod( 'bdr_contact_us_phone' ) .'</li>
                                    <li><i class="fa fa-envelope-o"></i> '. get_theme_mod( 'bdr_contact_us_email' ) .'</li>
                                </ul>
                            </div>

                        </div>

                        <div class="col-md-6 col-lg-6 col-lg-offset-1 animated fadeInRight" data-id="2">
                            <div class="contact-form">';
                                $output .= do_shortcode( '[contact-form-7 id="76" title="Contact Us"]' );
                            $output .= '</div>
                        </div>

                    </div>  
                </div>';
	

	return $output;
}

add_shortcode( 'contact-us', 'contact_us_shortcode_handler' );


function success_booking_details() {

	if (is_empty_booking() ) {
		empty_booking();
		redirect_js_script( get_bloginfo( 'url' ) );
	}

	$d = get_booking_by_id( booking_data( 'booking_ID' ) );

	$room_price = $d['room_price'];
	$nights = $d['no_of_night'];

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
		                       			$output .= '<span>'. format_date( $d['date_in']) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Check-Out</span>';
		                       			$output .= '<span>'. format_date( $d['date_out'] ) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Total Nights</span>';
			                       		$output .= '<span>'. count_nights( $d['date_in'], $d['date_out']) .'</span>';
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
			                    		$output .= '<h2><a>'. get_the_title( $d['room_type_ID']) .'</a></h2>';
			                    	$output .= '</div>';
			                    	$output .= '<ul>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Room Price</span>';
		                       			$output .= '<span>'. nf( $room_price) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Max</span>';
		                       			$output .= '<span>'. get_field( 'max_person', $d['room_type_ID']) .' Person(s)</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Size</span>';
		                       			$output .= '<span>'. get_field( 'room_size', $d['room_type_ID']) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>Bed</span>';
			                       		$output .= '<span>'. get_field( 'bed', $d['room_type_ID']) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
			                       		$output .= '<span>View</span>';
			                       		$output .= '<span>'. get_field( 'view', $d['room_type_ID']) .'</span>';
		                       		$output .= '</li>';
		                       		$output .= '<li>';
		                       			$output .= '<span>Total Room '. booking_data( 'no_of_room' ).'</span>';
		                       			$output .= '<span>'. nf( $room_price * booking_data( 'no_of_room' ) ).'</span>';
		                       		$output .= '</li>';
		                       		
		                        $output .= '</ul>';
			                    $output .= '</div>';
		                                   
			                    $output .= '<div class="reservation-room-seleted_total">';
			                    	$output .= '<label>TOTAL</label>';
			                    	$output .= '<span class="reservation-total">'.  format_price( $d['amount'], false) .'</span>';
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
		                       			$output .= '<span>'. $d['booking_no'] .'</span>';
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



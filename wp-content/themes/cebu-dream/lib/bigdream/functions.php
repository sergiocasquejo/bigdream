<?php

add_filter('show_admin_bar', '__return_false');

if(!function_exists('nf')) {
	function nf($number , $decimals = 0 , $dec_point = "." , $thousands_sep = ",") {
		return number_format($number, $decimals, $dec_point, $thousands_sep);
	}
}


add_action('admin_enqueue_scripts', 'bigdream_admin_scripts');
function bigdream_admin_scripts() {
	wp_enqueue_style('admin-style', CDR_SYSTEM_DIR_URI . '/assets/style/admin.css');	
}



function bigdream_add_notices($type, $message) {
	$_SESSION['bigdream_notices'][] = array('type' => $type, 'message' => $message);
}

function bigdream_redirect_script($url) {
	echo '<script>';
	echo 'window.location.replace("'. $url .'")';
	echo '</script>';
}

function has_notices() {
  return count(get_notices()) != 0;
}

function get_notices() {
  return isset($_SESSION['bigdream_notices']) ? $_SESSION['bigdream_notices'] : array();
}

if (!function_exists('bigdream_notices')) {
	function bigdream_notices($echo = true) {

		$output = '';
		if (has_notices()) {
			$notices = get_notices();
			
			foreach ($notices as $i => $n) {
				$output .= '<div class="'. (!isset($n['type']) ? 'updated' : $n['type']) .'">';
			        $output .= '<p>'. $n['message'] .'</p>';
			    $output .= '</div>';
			}
			unset($_SESSION['bigdream_notices']);
		}
		if (!$echo) return $output;
		
	    echo $output;
	}
}


function modal_notices() {
  $output = '';
  $output .= '<div class="modal fade bs-notice-modal-sm" tabindex="-1" role="dialog" aria-labelledby="bigdreamNoticeModal">';
    $output .= '<div class="modal-dialog modal-sm">';
      $output .= '<div class="modal-content">';
      $output .= bigdream_notices(false);
      $output .= '</div>';
    $output .= '</div>';
  $output .= '</div>';
  echo $output;
}

add_filter('set-screen-option', 'bigdream_booking_list_set_option', 10, 3);
function bigdream_booking_list_set_option($status, $option, $value) {
  return $value;
}

function push_to_booking_session($args) {
  $_SESSION['_bdr_booking'] = array_merge((array)$_SESSION['_bdr_booking'], $args);
  
  return get_booking_session();
}

function get_booking_session() {
  return isset($_SESSION['_bdr_booking']) ? $_SESSION['_bdr_booking'] : array();
}

add_action('init', 'bdr_init_action_handler');

function bdr_init_action_handler() {

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		switch($action) {
			case 'check_availability':
				$data = $_POST;

				push_to_booking_session(array(
						'date_in' => $data['date_in'],
						'date_out' => $data['date_out'],
						'no_of_adult' => $data['no_of_adult'],
						'no_of_child' => isset($data['no_of_child']) ? $data['no_of_child'] : 0,
					));
				exit(wp_redirect(get_permalink(get_page_by_path('rooms-suits'))));
				break;
			case 'book_room':
				$data = $_POST;
				push_to_booking_session(array(
						'date_in' => $data['date_in'],
						'date_out' => $data['date_out'],
						'no_of_adult' => $data['no_of_adult'],
						'no_of_child' => isset($data['no_of_child']) ? $data['no_of_child'] : 0,
						'room_ID' => $data['room_ID']
					));
				exit(wp_redirect(get_permalink(get_page_by_path('review'))));
				break;

			case 'make_reservation':

				$booking = push_to_booking_session(array_merge(get_booking_session(), $_POST, 
						array(
							'booking_ID' => 0,
							'amount' => get_room_price($booking['room_ID']), 
							'amount_paid' => 0,
							'booking_status' => BOOKING_DEFAULT_STATUS
						)
					));

				$args = array(
					'booking_ID' => $booking['booking_ID'],
					'room_ID' => $booking['room_ID'],
					'amount' => $booking['amount'],
					'amount_paid' => $booking['amount_paid'],
					'salutation' => $booking['salutation'],
					'country' => $booking['country'],
					'first_name' => $booking['first_name'],
					'last_name' => $booking['last_name'],
					'middle_name' => $booking['middle_name'],
					'birth_date' => format_db_date($booking['birth_date']),
					'email_address' => $booking['email_address'],
					'primary_phone' => $booking['primary_phone'],
					'address_1' => $booking['address_1'],
					'address_2' => $booking['address_2'],
					'city' => $booking['city'],
					'province' => $booking['province'],
					'zipcode' => $booking['zipcode'],
					'nationality' => $booking['nationality'],
					'date_in' => format_db_date($booking['date_in']),
					'date_out' => format_db_date($booking['date_out']),
					'booking_status' => $booking['booking_status'],
					'notes' => $booking['notes'],
					'date_booked' => date('Y-m-d H:i:s'),
				);


				if (bigdream_save_booking($args)) {
					bigdream_add_notices('updated', 'Successully Saved.');
					print_r('success');
				} else {
					bigdream_add_notices('error', 'Error while Saving.');
				}

				break;
		}

	}
}


function booking_data($key, $default = '') {
	$booking = isset($_SESSION['_bdr_booking']) ? $_SESSION['_bdr_booking'] : array();

	return isset($booking[$key]) ? $booking[$key] : $default;
}


function get_room_price($id = false) {
	if (!$id) {
		global $post;
		$id = $post->ID;
	}
	$price = get_field('price', $id);
	return $price;
}

function the_room_price($id = false) {
	if (!$id) {
		global $post;
		$id = $post->ID;
	}
	$price = get_field('price', $id);

	echo $price;
}


function the_room_price_html($id = false) {
	echo get_room_price_html($id);
}


function get_room_price_html($id = false) {
	return sprintf('<span class="amount">%s %s</span>', CURRENCY_CODE, nf(get_room_price($id)));
}

function get_booking_steps() {
	$output = '';
	$output .= '<div class="reservation_step">';
        $output .= '<ul>';
            $output .= '<li><a href="#"><span>1.</span>  Choose Date</a></li>';
            $output .= '<li class="active"><a href="#"><span>2.</span> Choose Room</a></li>';
            $output .= '<li><a href="#"><span>3.</span> Make a Reservation</a></li>';
            $output .= '<li><a href="#"><span>4.</span> Confirmation</a></li>';
        $output .= '</ul>';
    $output .= '</div>';

    return $output;
}

function format_date($date,  $format = 'D m/d/Y') {
	return date($format, strtotime($date));
}

function format_db_date($date, $format = 'Y-m-d') {
	return date($format, strtotime($date));	
}

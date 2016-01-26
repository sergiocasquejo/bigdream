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


if (!function_exists('bigdream_notices')) {
	function bigdream_notices() {

		$output = '';
		if (isset($_SESSION['bigdream_notices'])) {
			$notices = $_SESSION['bigdream_notices'];
			
			foreach ($notices as $i => $n) {
				$output .= '<div class="'. (!isset($n['type']) ? 'updated' : $n['type']) .'">';
			        $output .= '<p>'. $n['message'] .'</p>';
			    $output .= '</div>';
			}
			unset($_SESSION['bigdream_notices']);
		}
	    echo $output;
	}
}

add_filter('set-screen-option', 'bigdream_booking_list_set_option', 10, 3);
function bigdream_booking_list_set_option($status, $option, $value) {
  return $value;
}

add_action('init', 'bdr_init_action_handler');

function bdr_init_action_handler() {

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
		switch($action) {
			case 'check_availability':
				$data = $_POST;

				$_SESSION['_bdr_booking'] = array_merge((array)$_SESSION['_bdr_booking'], array(
						'date_in' => $data['date_in'],
						'date_out' => $data['date_out'],
						'no_of_adult' => $data['no_of_adult'],
						'no_of_child' => isset($data['no_of_child']) ? $data['no_of_child'] : 0,
					));
				exit(wp_redirect(get_permalink(get_page_by_path('rooms-suits'))));
				break;
			case 'book_room':
				$data = $_POST;
				$_SESSION['_bdr_booking'] = array_merge((array)$_SESSION['_bdr_booking'], array(
						'date_in' => $data['date_in'],
						'date_out' => $data['date_out'],
						'no_of_adult' => $data['no_of_adult'],
						'no_of_child' => isset($data['no_of_child']) ? $data['no_of_child'] : 0,
						'room_ID' => $data['room_ID']
					));
				exit(wp_redirect(get_permalink(get_page_by_path('review'))));
				break;

			case 'make_reservation':

				$post = $_POST;
				$_s = $_SESSION['_bdr_booking'];
				$_d = $_SESSION['_bdr_booking'] = array_merge(
						(array)$_s, 
						$post, 
						array(
							'booking_ID' => 0,
							'amount' => get_room_price($_s['room_ID']), 
							'amount_paid' => 0,
							'booking_status' => BOOKING_DEFAULT_STATUS
						)
					);

				$args = array(
					'booking_ID' => $_d['booking_ID'],
					'room_ID' => $_d['room_ID'],
					'amount' => $_d['amount'],
					'amount_paid' => $_d['amount_paid'],
					'salutation' => $_d['salutation'],
					'country' => $_d['country'],
					'first_name' => $_d['first_name'],
					'last_name' => $_d['last_name'],
					'middle_name' => $_d['middle_name'],
					'birth_date' => format_db_date($_d['birth_date']),
					'email_address' => $_d['email_address'],
					'primary_phone' => $_d['primary_phone'],
					'address_1' => $_d['address_1'],
					'address_2' => $_d['address_2'],
					'city' => $_d['city'],
					'province' => $_d['province'],
					'zipcode' => $_d['zipcode'],
					'nationality' => $_d['nationality'],
					'date_in' => format_db_date($_d['date_in']),
					'date_out' => format_db_date($_d['date_out']),
					'booking_status' => $_d['booking_status'],
					'notes' => $_d['notes'],
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
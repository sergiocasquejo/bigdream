<?php
/**
 * nf()
 * 
 * Format number
 * 
 * @param Float $number
 * @param Int $decimals
 * @param String $decimal_point
 * @param String $thousands_sep
 * @return none
 */

if(!function_exists('nf')) {
	function nf($number , $decimals = 0 , $dec_point = "." , $thousands_sep = ",") {
		return number_format($number, $decimals, $dec_point, $thousands_sep);
	}
}


/**
 * bigdream_redirect_script()
 * 
 * Print redirect javascript
 * 
 * @param String $url
 * @return Boolean
 */

function bigdream_redirect_script($url) {
	echo '<script>';
	echo 'window.location.replace("'. $url .'")';
	echo '</script>';
}
/**
 * bigdream_add_notices()
 * 
 * Add notice message
 * 
 * @param String $type
 * @param String $message
 * @return none
 */
function bigdream_add_notices($type, $message) {
	$_SESSION['bigdream_notices'][] = array('type' => $type, 'message' => $message);
}

/**
 * has_notices()
 * 
 * Check if there is notices
 * 
 * @param none
 * @return Boolean
 */
 
function has_notices() {
  return count(get_notices()) != 0;
}

/**
 * get_notices()
 * 
 * Return notices
 * 
 * @param none
 * @return Array $notices
 */
 
function get_notices() {
  return isset($_SESSION['bigdream_notices']) ? $_SESSION['bigdream_notices'] : array();
}

/**
 * bigdream_notices()
 * 
 * Print|Return notices when exists
 * 
 * @param Boolean $echo
 * @return String $notices
 */
 
 
if (!function_exists('bigdream_notices')) {
	function bigdream_notices($echo = true) {

		$output = '';
		if (has_notices()) {
			$output .= '<div class="notices-box">';
			$output .= '<div class="container">';
			$notices = get_notices();
			
			foreach ($notices as $i => $n) {
				$output .= '<div class="'. (!isset($n['type']) ? 'updated' : $n['type']) .'">';
			        $output .= '<p>'. $n['message'] .'</p>';
			    $output .= '</div>';
			}
			unset($_SESSION['bigdream_notices']);
			$output .= '</div>';
			$output .= '</div>';
		}
		if (!$echo) return $output;
		
	    echo $output;
	}
}


/**
 * modal_notices()
 * 
 * Print modal notices when exists
 * 
 * @param none
 * @return none
 */
 
function modal_notices() {
	$output = '';
	if (has_notices()) {
		$output .= '<div id="bigdreamNoticesModal" class="modal fade bs-notice-modal-sm" tabindex="-1" role="dialog" aria-labelledby="bigdreamNoticeModal">';
			$output .= '<div class="modal-dialog modal-sm">';
				$output .= '<div class="modal-content">';
					$output .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					$output .= bigdream_notices(false);
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
	}
  echo $output;
}

add_filter('set-screen-option', 'bigdream_booking_list_set_option', 10, 3);
function bigdream_booking_list_set_option($status, $option, $value) {
  return $value;
}
/**
 * push_to_booking_session()
 * 
 * Push data to session variable
 * 
 * @param none
 * @return Array $booking_data
 */
 
function push_to_booking_session($args) {
	$current = isset($_SESSION['_bdr_booking']) ? $_SESSION['_bdr_booking'] : array();
  	$_SESSION['_bdr_booking'] = array_merge($current, $args);
  
  	return get_booking_session();
}

function empty_booking() {
	unset($_SESSION['_bdr_booking']);
}


function is_empty_booking() {
	return !isset($_SESSION['_bdr_booking']) && count($_SESSION['_bdr_booking']) == 0;
}
/**
 * get_booking_session()
 * 
 * Get booking data from session
 * 
 * @param none
 * @return Array $booking_data
 */
 
function get_booking_session() {
  return isset($_SESSION['_bdr_booking']) ? $_SESSION['_bdr_booking'] : array();
}

/**
 * booking_init_action_handler()
 * 
 * Process booking post data
 * 
 * @param none
 * @return none
 */
 
add_action('init', 'booking_init_action_handler');
function booking_init_action_handler() {

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
				/*if (!is_selected_date_and_room_available($data['room_ID'], format_db_date($data['date_in']),  format_db_date($data['date_out']))) {
				  bigdream_add_notices('error', 'Selected room is not available on that date. Please check calendar to see availability.');
				  return;
				}*/
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
				if (is_empty_booking()) {
					bigdream_add_notices('error', 'Please select date.');
					exit(wp_redirect(get_bloginfo('url')));
					break;
				}
			  	$data = get_booking_session();
			  
        		/*if (!is_selected_date_and_room_available($data['room_ID'], format_db_date($data['date_in']),  format_db_date($data['date_out']))) {
				  bigdream_add_notices('error', 'Selected room is not available on that date. Please check calendar to see availability.');
				  return;
				}*/
				$booking = push_to_booking_session(array_merge($data, $_POST, 
						array(
							'booking_ID' => 0,
							'amount' => get_room_price($data['room_ID']), 
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
					'no_of_adult' => $booking['no_of_adult'],
					'no_of_child' => $booking['no_of_child'],
					'no_of_night' => count_nights($booking['date_in'], $booking['date_out']),
					'booking_status' => $booking['booking_status'],
					'notes' => $booking['notes'],
					'date_booked' => date('Y-m-d H:i:s'),
				);
				$val = validate_booking_data($args);
			
				/*** if there are errors show them ***/
			    if($val['valid'] === false)
			    {
			    	// echo '<pre>';
			    	// print_r($val['errors']);
			    	// die;

			    	bigdream_javacript_notices($val['errors']);
			
			        bigdream_add_notices('error', 'Please review the fields.');
		
			    } else {

					if (bigdream_save_booking($args)) {
						//bigdream_add_notices('updated', 'Booking Successully Saved.');
						send_success_booking_notification();
						empty_booking();
						exit(wp_redirect(get_permalink(get_page_by_path('success'))));
					} else {
						bigdream_add_notices('error', 'Error while Saving.');
					}
				}
				break;
		}

	}
}

function validate_booking_data($data) {

    $gump = new GUMP();
    
    $data = $gump->sanitize($data);

    $gump->validation_rules(array(
    	'first_name' => 'required|min_len,1|max_len,100',
    	'last_name' => 'required|min_len,1|max_len,100',
    	'middle_name' => 'required|min_len,1|max_len,100',
    	'birth_date' => 'required|date',
		'room_ID' => 'required|numeric',
		'amount' => 'required|numeric',
		'email_address' => 'required|valid_email',
		'primary_phone' => 'required',
		'address_1' => 'required',
		'city' => 'required',
		'province' => 'required',
		'zipcode' => 'required',
		'nationality' => 'required',
		'date_in' => 'required|date',
		'date_out' => 'required|date',
    ));




    return array('valid' => $gump->run($data), 'errors' => $gump->get_key_and_value_errors(true));

}

add_action('wp_footer', 'print_javascript_notices');
function print_javascript_notices() {
	if (isset($_SESSION['javascript_error_notice'])) {
		echo $_SESSION['javascript_error_notice'];
		unset($_SESSION['javascript_error_notice']);
	}
}
function bigdream_javacript_notices($errors = array()) {
	if (count($errors) > 0) {
		$output = '';
		$output .= '<script>
		jQuery(function($) {';

			foreach ($errors as $k => $v) {
				$output .= '$("<span class=\'error_field\'>'.$v. '</span>").insertAfter($(\':input[name="'. $k .'"]\'));';
			}
		$output .= '});
		</script>';

		$_SESSION['javascript_error_notice'] = $output;
	}
}

/**
 * booking_data()
 * 
 * Get booking data by key
 * 
 * @param String $key
 * @param String $default
 * @return String $array_value
 */
function booking_data($key, $default = '') {
	$booking = isset($_SESSION['_bdr_booking']) ? $_SESSION['_bdr_booking'] : array();

	return isset($booking[$key]) ? $booking[$key] : $default;
}

/**
 * get_room_price()
 * 
 * Get unformatted room price
 * 
 * @param int $id - Room/Post ID
 * @return Decimal $price
 */
function get_room_price($id = false) {
	if (!$id) {
		global $post;
		$id = $post->ID;
	}
	$price = get_field('price', $id);
	return $price;
}

/**
 * the_room_price()
 * 
 * Print unformatted price
 * 
 * @param int $id - Room/Post ID
 * @return none
 */
function the_room_price($id = false) {
	if (!$id) {
		global $post;
		$id = $post->ID;
	}
	$price = get_field('price', $id);

	echo $price;
}

/**
 * the_room_price_html()
 * 
 * Print HTML formatted price with currency code
 * 
 * @param int $id - Room/Post ID
 * @return String $formatted_price
 */
function the_room_price_html($id = false) {
	echo get_room_price_html($id);
}

/**
 * get_room_price_html()
 * 
 * Return HTML formatted price with currency code
 * 
 * @param int $id - Room/Post ID
 * @return String $formatted_price
 */
function get_room_price_html($id = false) {
	return sprintf('<span class="amount">%s %s</span>', CURRENCY_CODE, nf(get_room_price($id)));
}

/**
 * format_price()
 * 
 * Print formatted price
 * 
 * @param Decimal $price
 * @return none
 */
function format_price($price) {
  echo sprintf('<span class="amount">%s %s</span>', CURRENCY_CODE, nf($price));
}

/**
 * get_booking_steps()
 * 
 * Return booking steps/indicator
 * 
 * @param none
 * @return String $indicator
 */

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

/**
 * format_date()
 * 
 * Format date to readable date
 * 
 * @param String $date
 * @param String $format
 * @return String $formatted_date
 */
 
function format_date($date,  $format = 'D m/d/Y') {
	return date($format, strtotime($date));
}

/**
 * format_db_date()
 * 
 * Format date to mysql/database date
 * 
 * @param String $date
 * @param String $format
 * @return String $formatted_date
 */
function format_db_date($date, $format = 'Y-m-d') {
	return date($format, strtotime($date));	
}

/**
 * count_nights()
 * 
 * Counts number of nights between two dates
 * 
 * @param Date $from
 * @param Date $to
 * @return Int $total_nights
 */
function count_nights($from, $to) {
   $now = strtotime($to); // or your date as well
   $date = strtotime($from);
   $datediff = $now - $date;
   return floor($datediff/(60*60*24));
}
/**
 * get_dates_from_date_range()
 * 
 * Get dates between two dates
 * 
 * @param Date $from
 * @param Date $to
 * @return Array $dates
 */
function get_dates_from_date_range($from, $to) {
  $dates = array();
  $current = strtotime($from);
  $end = strtotime($to);
  
  while ($current <= $end) {
      $dates[] = date('Y-m-d', $current);
      $current = strtotime('+1 days', $current);
  }
  
  return $dates;
}

/**
 * send_success_booking_notification()
 * 
 * Send Email notification when successful booking
 * @param none
 * @return none
 */
function send_success_booking_notification() {
  ob_start();
  
  $d = get_booking_session();
  $logo = get_template_directory_uri() . '/dist/images/logo.png';
  $d['no_of_nights'] = count_nights($d['date_in'], $d['date_out']);
  
  include "emails/success_booking_notification.php";
  $message = ob_get_clean();

  add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
  //Send to admin
  $to = get_bloginfo('admin_email');
  $subject = 'New Reservation';
  wp_mail($to, $subject, $message);
  
  // Send to guest
  $to = $d['email_address'];
  $subject = 'Your Booking Details';
  wp_mail($to, $subject, $message);

}

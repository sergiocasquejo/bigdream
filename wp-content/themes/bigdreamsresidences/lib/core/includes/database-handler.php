<?php
/**
 * bigdream_save_booking()
 * 
 * Save booking information
 * @param Array $args
 * @param Int $result - Affected rows
 */
if (!function_exists('bigdream_save_booking')) {
	function bigdream_save_booking($args) {
		global $wpdb;
		$data = array(
			'booking_ID' => $args['booking_ID'],
			'room_ID' => $args['room_ID'],
			'room_code' => $args['room_code'],
			'room_price' => $args['room_price'],
			'amount' => $args['amount'],
			'amount_paid' => $args['amount_paid'],
			'salutation' => $args['salutation'],
			'country' => $args['country'],
			'first_name' => $args['first_name'],
			'last_name' => $args['last_name'],
			'middle_name' => $args['middle_name'],
			'birth_date' => $args['birth_date'],
			'email_address' => $args['email_address'],
			'primary_phone' => $args['primary_phone'],
			'address_1' => $args['address_1'],
			'address_2' => $args['address_2'],
			'city' => $args['city'],
			'province' => $args['province'],
			'zipcode' => $args['zipcode'],
			'nationality' => $args['nationality'],
			'date_in' => $args['date_in'],
			'date_out' => $args['date_out'],
			'no_of_adult' => $args['no_of_adult'],
			'no_of_child' => $args['no_of_child'],
			'no_of_night' => $args['no_of_night'],
			'booking_status' => $args['booking_status'],
			'notes' => $args['notes'],
			'type' => $args['type'],
			'date_booked' => $args['date_booked'],
		);

		if (isset($args['booking_ID']) && $args['booking_ID'] != 0) {
			$result = $wpdb->update( $wpdb->prefix . 'bookings', $data, array('booking_ID' => $args['booking_ID']), array('%d','%d', '%d', '%f','%f', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s'), array('%d'));
		} else {
			$result = $wpdb->insert( $wpdb->prefix . 'bookings', $data, array('%d','%d', '%d','%f','%f', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s'));
		}

		return $result;
	}
}


function get_filtered_bookings() {
	global $wpdb
		
	$sql = "SELECT p.post_title as room_title,  b.*, CONCAT(b.first_name,' ', b.middle_name, ' ', b.last_name) as guest_name FROM ". $wpdb->prefix . "bookings b  JOIN ". $wpdb->prefix ."posts p  ON p.ID = b.room_ID WHERE 1 = 1";

	if ( $s = browser_post( 's' ) != '' ) {
		$sql .= " AND ( p.post_title LIKE '%". $s ."%' OR b.first_name LIKE '%". $s ."%' OR b.last_name LIKE '%". $s ."%') ";
	}

	if ( $status = browser_request( 'status' ) != '' ) {
		$sql .= " AND (b.booking_status = '". $status ."') ";
	}

	$results = $wpdb->get_results( $sql, ARRAY_A );

	return $results;

}

function generate_and_update_booking_no($booking_ID)  {
	global $wpdb;
	$sql = "UPDATE ". $wpdb->prefix . "bookings b  SET b.booking_no = CONCAT(DATE_FORMAT(b.date_booked, '%Y%m%d'), b.booking_ID) WHERE b.booking_ID =  $booking_ID";
	
	return $wpdb->query($sql);
}

/**
 * get_booking_calendar()
 * 
 * Get Booking for calendar
 * @param none
 * @param Array $bookings
 */
function get_booking_calendar() {
	global $wpdb;
	$sql = "
		SELECT 
			b.booking_ID as id,
			CONCAT(p.post_title, ' by:  ', b.first_name,' ', b.middle_name, ' ', b.last_name) as title,
			b.date_in as start, 
			b.date_out as end, 
			CASE b.booking_status
				WHEN 'Complete' THEN '#45920B'
				WHEN 'Not Paid' THEN '#FF8100'
				WHEN 'Unconfirmed' THEN '#888888'
				WHEN 'Cancelled' THEN '#FF0000'
			END
			 as color
		FROM 
			". $wpdb->prefix . "bookings b  
		JOIN ". $wpdb->prefix ."posts p 
			ON p.ID = b.room_ID";

	return $wpdb->get_results($sql, ARRAY_A);
}




/**
 * get_booking_by_id()
 * 
 * Get booking by booking ID
 * 
 * @param Int $id - Booking id
 * @param Array $bookings
 */
 
function get_booking_by_id($id) {
	global $wpdb;
	$sql = "
		SELECT 
			p.post_title as room, 
			CONCAT(b.salutation, ' ', b.first_name,' ', b.middle_name, ' ', b.last_name) as name, 
			b.*
		FROM 
			". $wpdb->prefix . "bookings b  
		JOIN ". $wpdb->prefix ."posts p 
			ON p.ID = b.room_ID 
		WHERE booking_ID = %d";


	$sql = $wpdb->prepare($sql, $id);

	return $wpdb->get_row($sql, ARRAY_A);
}


/**
 * get_count_newly_booked()
 * 
 * Count Unread booked/Newly booked
 * 
 * @param none
 * @param Int $total
 */
 
 
function get_count_newly_booked() {
	global $wpdb;

	$total = $wpdb->get_var('SELECT count(*) as total FROM '. $wpdb->prefix . 'bookings WHERE booking_status = "NEW"');

	return $total;
}


/**
 * get_available_rooms()
 * 
 * Get available rooms
 * 
 * @param none
 * @param Array $rooms
 */

if (!function_exists('get_available_rooms')) {
	function get_available_rooms() {
		global $wpdb;

		$results = get_posts(array(
			'numberposts'	=> -1,
			'fields' => 'ids,titles',
			'post_type'		=> 'room',
			//'meta_key'		=> 'room_status',
			//'meta_value'	=> 'VACANT CLEAN'
		));

	
		return $results;
	}
}

/**
 * get_inserted_ID()
 * 
 * Return last inserted ID    
 * 
 * @param none
 * @param Int $id
 */

function get_inserted_ID() {
	global $wpdb;
	return $wpdb->insert_id;
}

/**
 * selected_date_and_room_available()
 * 
 * Check if selected room and dates are available
 * 
 * @param Int $roomID
 * @param Date $from
 * @param Date $to
 * @param Int $count
 */
 
function is_selected_date_and_room_not_available($roomID, $from) {
  global $wpdb;
  
  $sql = $wpdb->prepare("SELECT count(*) FROM ".$wpdb->prefix."bookings WHERE room_ID = %d AND '%s' BETWEEN date_in AND date_out", $roomID, $from);
  
  return $wpdb->get_var($sql);
}



function get_room_unavailable_schedule($room_ID, $output = 'ARRAY_A') {
	global $wpdb;

	$results = $wpdb->get_results("SELECT DATE_FORMAT(date_in, '%m/%d/%Y') AS date_in, DATE_FORMAT(date_out, '%m/%d/%Y') AS date_out FROM ".$wpdb->prefix."bookings WHERE room_ID = $room_ID AND date_out >= CURDATE()", $output);

	return $results;
}

function get_today_sales() {
	global $wpdb;

	$amount = $wpdb->get_var("SELECT SUM(amount_paid) FROM ".$wpdb->prefix."bookings WHERE DATE_FORMAT(date_booked, '%Y-%m-%d') = CURDATE() AND payment_status IN('UNPAID')");

	return $amount;	
}

function get_week_sales() {
	global $wpdb;

	$amount = $wpdb->get_var("SELECT SUM(amount_paid) FROM ".$wpdb->prefix."bookings WHERE WEEK(date_booked) = WEEK(CURDATE()) AND payment_status IN('UNPAID')");

	return $amount;	
}

function get_month_sales() {
	global $wpdb;

	$amount = $wpdb->get_var("SELECT SUM(amount_paid) FROM ".$wpdb->prefix."bookings WHERE MONTH(date_booked) = MONTH(CURDATE()) AND payment_status IN('UNPAID')");

	return $amount;	
}

function get_year_sales() {
	global $wpdb;

	$amount = $wpdb->get_var("SELECT SUM(amount_paid) FROM ".$wpdb->prefix."bookings WHERE YEAR(date_booked) = YEAR(CURDATE()) AND payment_status IN('UNPAID')");

	return $amount;	
}

function get_monthly_sales($output = 'ARRAY_A') {
	global $wpdb;

	$sql = "SELECT MONTH(date_booked) as month, (SUM(amount) / (SELECT SUM(amount) FROM ".$wpdb->prefix."bookings WHERE year(CURDATE()) = YEAR(date_booked))) * 100 as amount, (SUM(amount_paid) / (SELECT SUM(amount) FROM ".$wpdb->prefix."bookings WHERE YEAR(CURDATE()) = YEAR(date_booked))) * 100 as amount_paid FROM ".$wpdb->prefix."bookings WHERE YEAR(date_booked) = YEAR(CURDATE()) GROUP BY MONTH(date_booked) ORDER BY MONTH(date_booked) ASC";

	$sales = $wpdb->get_results($sql, $output);

	return $sales;
}

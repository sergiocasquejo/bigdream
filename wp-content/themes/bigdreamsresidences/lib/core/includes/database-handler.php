<?php
/**
 * save_booking()
 * 
 * Save booking information
 * @param Array $args
 * @param Int $result - Affected rows
 */
if ( ! function_exists( 'save_booking' ) ) {
	function save_booking( $args ) {
		global $wpdb;

		$data = get_array_values_by_keys( $args, 
				array(
					'room_ID',
					'room_code',
					'room_price',
					'amount',
					'amount_paid',
					'salutation',
					'country',
					'first_name',
					'last_name',
					'middle_name',
					'birth_date',
					'email_address',
					'primary_phone',
					'address_1',
					'address_2',
					'city',
					'province',
					'zipcode',
					'nationality',
					'date_in',
					'date_out',
					'no_of_adult',
					'no_of_child',
					'no_of_night',
					'booking_status',
					'payment_status',
					'notes',
					'type',
					'date_booked'
				) 
			);
		// print_me(array_data( $args, 'booking_ID', 0 ));
		// print_me($data);

		if ( array_data( $args, 'booking_ID', 0 ) > 0 ) {
			//, array( '%d','%s', '%f','%f', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s' ), array( '%d' )
			$result = $wpdb->update( $wpdb->prefix . 'bookings', $data, array( 'booking_ID' => $args['booking_ID']) );
		} else {
			//, array( '%d','%s','%f','%f', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s' )
			$result = $wpdb->insert( $wpdb->prefix . 'bookings', $data );
		}
		return $result;
	}
}


function get_filtered_bookings() {
	global $wpdb;
		
	$sql = "SELECT p.post_title as room_title,  b.*, CONCAT(b.first_name,' ', b.middle_name, ' ', b.last_name) as guest_name FROM ". $wpdb->prefix . "bookings b  JOIN ". $wpdb->prefix ."posts p  ON p.ID = b.room_ID WHERE 1 = 1";

	if ( $s = browser_post( 's' ) != '' ) {
		$sql .= " AND ( p.post_title LIKE '%". $s ."%' OR b.first_name LIKE '%". $s ."%' OR b.last_name LIKE '%". $s ."%' ) ";
	}

	

	if ( ($status = browser_request( 'status' )) != '' ) {
		$sql .= " AND (b.booking_status = '". $status ."' ) ";
	}
	
	if ( ($status = browser_request( 'filter_payment_status' )) != '' ) {
		$sql .= " AND (b.payment_status = '". $status ."' ) ";
	}

	

	if ( ($room_ID = browser_request( 'filter_room_ID' )) != '' ) {
		$sql .= " AND (b.room_ID = '". $room_ID ."' ) ";
	}


	if ( ($checkin = browser_request( 'filter_date_in' )) != '' && ($checkout = browser_request( 'filter_date_out' )) != '' ) {
		$sql .= " AND (date_in >= '". format_db_date( $checkin, 'Y-m-d' ) ."' AND  date_out <= '". format_db_date( $checkout, 'Y-m-d' ) ."'  ) ";
	}




	$results = $wpdb->get_results( $sql, ARRAY_A );

	return $results;

}


function get_bookings_for_export() {
	global $wpdb;
		
	$sql = "SELECT booking_no,  p.post_title, room_code, room_price, b.date_in, b.date_out, b.no_of_night, amount, amount_paid, b.no_of_adult, b.no_of_child,  CONCAT(b.salutation, '. ', b.first_name,' ', b.middle_name, ' ', b.last_name) as guest_name, b.birth_date, b.email_address, b.primary_phone, b.country, b.address_1, b.address_2, b.province, b.city, b.zipcode, b.nationality, b.booking_status, b.payment_status, b.date_booked  FROM ". $wpdb->prefix . "bookings b  JOIN ". $wpdb->prefix ."posts p  ON p.ID = b.room_ID WHERE 1 = 1";

	if ( $s = browser_post( 's' ) != '' ) {
		$sql .= " AND ( p.post_title LIKE '%". $s ."%' OR b.first_name LIKE '%". $s ."%' OR b.last_name LIKE '%". $s ."%' ) ";
	}

	if ( ($status = browser_get( 'status' )) != '' ) {
		$sql .= " AND (b.booking_status = '". $status ."' ) ";
	}

	$results = $wpdb->get_results( $sql, ARRAY_A );

	return $results;

}

function generate_and_update_booking_no( $booking_ID )  {
	global $wpdb;
	$sql = "UPDATE ". $wpdb->prefix . "bookings b  SET b.booking_no = CONCAT(DATE_FORMAT(b.date_booked, '%Y%m%d' ), b.booking_ID) WHERE b.booking_ID =  $booking_ID";
	
	return $wpdb->query( $sql );
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
			CONCAT(b.room_code, ' by:  ', b.first_name,' ', b.middle_name, ' ', b.last_name) as title,
			b.date_in as start, 
			b.date_out as end, 
			CASE b.booking_status
				WHEN 'NEW' THEN '#F75C05'
				WHEN 'CONFIRMED' THEN '#D6A707'
				WHEN 'ARRIVED' THEN '#0A8415'
				WHEN 'CHECKOUT' THEN '#B70707'
			END
			 as color
		FROM 
			". $wpdb->prefix . "bookings b  
		JOIN ". $wpdb->prefix ."posts p 
			ON p.ID = b.room_ID";

	return $wpdb->get_results( $sql, ARRAY_A );
}




/**
 * get_booking_by_id()
 * 
 * Get booking by booking ID
 * 
 * @param Int $id - Booking id
 * @param Array $bookings
 */
 
function get_booking_by_id( $id) {
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


	$sql = $wpdb->prepare( $sql, $id );

	return $wpdb->get_row( $sql, ARRAY_A );
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

	$total = $wpdb->get_var( 'SELECT count(*) as total FROM '. $wpdb->prefix . 'bookings WHERE booking_status = "NEW"' );

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

if ( ! function_exists( 'get_available_rooms' ) ) {
	function get_available_rooms() {
		global $wpdb;

		$results = get_posts( array(
			'numberposts'	=> -1,
			// 'fields' => 'ID',
			'post_type'		=> 'room',
			//'meta_key'		=> 'room_status',
			//'meta_value'	=> 'VACANT CLEAN'
		) );

	
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
 
function is_selected_date_and_room_not_available( $roomID, $from, $booking_ID = 0 ) {
  global $wpdb;
  
  $sql = $wpdb->prepare( "SELECT count(*) FROM ".$wpdb->prefix."bookings WHERE room_ID = %d AND '%s' >= date_in AND  '%s' < date_out AND booking_ID != %d", $roomID, $from, $from, $booking_ID );
  
  return $wpdb->get_var( $sql );
}



function get_room_unavailable_schedule( $room_ID, $output = 'ARRAY_A' ) {
	global $wpdb;

	$results = $wpdb->get_results( "SELECT DATE_FORMAT(date_in, '%m/%d/%Y' ) AS date_in, DATE_FORMAT(date_out, '%m/%d/%Y' ) AS date_out FROM ".$wpdb->prefix."bookings WHERE room_ID = $room_ID AND date_out >= CURDATE()", $output);

	return $results;
}

function get_today_sales() {
	global $wpdb;

	$amount = $wpdb->get_var( "SELECT SUM( amount_paid) FROM ".$wpdb->prefix."bookings WHERE DATE_FORMAT(date_booked, '%Y-%m-%d' ) = CURDATE() AND payment_status IN( 'UNPAID' )" );

	return $amount;	
}

function get_week_sales() {
	global $wpdb;

	$amount = $wpdb->get_var( "SELECT SUM( amount_paid) FROM ".$wpdb->prefix."bookings WHERE WEEK(date_booked) = WEEK(CURDATE() ) AND payment_status IN( 'UNPAID' )" );

	return $amount;	
}

function get_month_sales() {
	global $wpdb;

	$amount = $wpdb->get_var( "SELECT SUM( amount_paid) FROM ".$wpdb->prefix."bookings WHERE MONTH(date_booked) = MONTH(CURDATE() ) AND payment_status IN( 'UNPAID' )" );

	return $amount;	
}

function get_year_sales() {
	global $wpdb;

	$amount = $wpdb->get_var( "SELECT SUM( amount_paid) FROM ".$wpdb->prefix."bookings WHERE YEAR(date_booked) = YEAR(CURDATE() ) AND payment_status IN( 'UNPAID' )" );

	return $amount;	
}

function get_monthly_sales( $output = 'ARRAY_A' ) {
	global $wpdb;

	$sql = "SELECT MONTH(date_booked) as month, (SUM( amount) / (SELECT SUM( amount) FROM ".$wpdb->prefix."bookings WHERE year(CURDATE() ) = YEAR(date_booked) )) * 100 as amount, (SUM( amount_paid) / (SELECT SUM( amount) FROM ".$wpdb->prefix."bookings WHERE YEAR(CURDATE() ) = YEAR(date_booked) )) * 100 as amount_paid FROM ".$wpdb->prefix."bookings WHERE YEAR(date_booked) = YEAR(CURDATE() ) GROUP BY MONTH(date_booked) ORDER BY MONTH(date_booked) ASC";

	
	$sales = $wpdb->get_results( $sql, $output );

	return $sales;
}

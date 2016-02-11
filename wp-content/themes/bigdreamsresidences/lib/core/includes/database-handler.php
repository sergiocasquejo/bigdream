<?php

function get_guest_calendar_by_room_ID($room_ID, $start = date('Y-m-d'), $status = false ) {
  global $wpdb;
  
  $sql = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."guest_calendar a JOIN ".$wpdb->prefix."bookings b WHERE a.room_ID = %d", $room_ID );
  
  if ( $start != false ) {
    $sql .= $wpdb->prepare( " AND a.date_in >= '%s' ", $start )
  }
  
  if ( $status != false ) {
    $sql .= $wpdb->prepare( " AND b.booking_status = = '%s' ", $status )
  }

  return $wpdb->get_results( $sql );
}


function get_guest_calendar_by_room_and_datein($room_type_ID, $from ) {
  global $wpdb;
  
  $sql = $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."guest_calendar WHERE room_type_ID = %d AND '%s' >= date_in AND  '%s' < date_out", $room_type_ID, $from, $from );

  return $wpdb->get_results( $sql );
}



function get_guest_calendar_by_type_and_date( $room_type_ID, $date_in, $date_out ) {
	global $wpdb;
	$sql = "SELECT * FROM ". $wpdb->prefix . "guest_calendar WHERE room_type_ID = %d AND '%s' >= date_in AND  '%s' < date_out ";

	$sql = $wpdb->prepare( $sql, $room_type_ID, $date_in, $date_out );

	print_me($sql);
	return $wpdb->get_results( $sql );
}

function get_rooms_by_type( $room_type_ID, $exclude = array() ) {
	$rooms = get_posts(array(
			'showposts' => -1,
			'exclude' => $exclude,
			'post_type' => 'room',
				'meta_key' => 'room_type',
				'meta_value' => $room_type_ID,
			
		)
	);

	return $rooms;
}

function get_no_of_room_by_booking_ID( $booking_ID ) {
	global $wpdb;
	$sql = "SELECT no_of_room FROM ". $wpdb->prefix . "bookings WHERE booking_ID = %d";

	$result = $wpdb->get_var( $wpdb->prepare( $sql, $booking_ID ) );
	return $result;
}



function delete_rooms_and_guest_info( $booking_room_ID ) {
	global $wpdb;

	$sql = "DELETE FROM ". $wpdb->prefix . "guest_calendar WHERE booking_room_ID = %d";

	$result = $wpdb->query( $wpdb->prepare( $sql, $booking_room_ID ), ARRAY_A);

	return $result;
}



function get_booking_rooms( $booking_room_ID ) {
	global $wpdb;

	$sql = "SELECT * FROM ". $wpdb->prefix . "guest_calendar WHERE booking_room_ID = %d";

	$result = $wpdb->get_row( $wpdb->prepare( $sql, $booking_room_ID ), ARRAY_A);

	return $result;
}


function get_rooms_and_guest_info( $booking_ID, $brid = false ) {
	global $wpdb;

	$sql = "SELECT a.*, b.post_title as room_title FROM ". $wpdb->prefix . "guest_calendar a JOIN ". $wpdb->prefix . "posts b ON a.room_ID = b.ID WHERE a.booking_ID = %d AND a.booking_room_ID != %d";

	$result = $wpdb->get_results( $wpdb->prepare( $sql, $booking_ID, $brid ), ARRAY_A);
	return $result;
}


function is_rooms_exists_on_booking( $room_ID, $booking_ID, $booking_room_ID = false ) {
	global $wpdb;

	$sql = "SELECT count(*) FROM ". $wpdb->prefix . "guest_calendar  WHERE booking_ID = %d AND room_ID = %d AND booking_room_ID != %d";

	$result = $wpdb->get_var( $wpdb->prepare( $sql, $booking_ID, $room_ID, $booking_room_ID ) );

	return $result > 0;
}

function do_save_rooms_and_guest_info( $args ) {
	global $wpdb;

		$data = get_array_values_by_keys( $args, 
				array(
					'booking_ID',
					'room_ID',
					'room_type_ID',
					'guest',
					'phone',
					'no_of_adult',
					'no_of_child',
					'date_in',
					'date_out',
				) 
			);


		if ( array_data( $args, 'booking_room_ID', 0 ) > 0 ) {
			$result = $wpdb->update( $wpdb->prefix . 'guest_calendar', $data, array( 'booking_room_ID' => $args['booking_room_ID']) );
		} else {
			$result = $wpdb->insert( $wpdb->prefix . 'guest_calendar', $data );
		}
		return $result;
}

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
					'room_type_ID',
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
					'no_of_room',
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
		
	$sql = "SELECT p.post_title as room_title,  b.*, CONCAT(b.first_name,' ', b.middle_name, ' ', b.last_name) as guest_name FROM ". $wpdb->prefix . "bookings b  JOIN ". $wpdb->prefix ."posts p  ON p.ID = b.room_type_ID WHERE 1 = 1";

	if ( $s = browser_post( 's' ) != '' ) {
		$sql .= " AND ( p.post_title LIKE '%". $s ."%' OR b.first_name LIKE '%". $s ."%' OR b.last_name LIKE '%". $s ."%' ) ";
	}

	

	if ( ($status = browser_request( 'status' )) != '' ) {
		$sql .= " AND (b.booking_status = '". $status ."' ) ";
	}
	
	if ( ($status = browser_request( 'filter_payment_status' )) != '' ) {
		$sql .= " AND (b.payment_status = '". $status ."' ) ";
	}

	

	if ( ($room_type_ID = browser_request( 'filter_room_ID' )) != '' ) {
		$sql .= " AND (b.room_type_ID = '". $room_type_ID ."' ) ";
	}


	if ( ($checkin = browser_request( 'filter_date_in' )) != '' && ($checkout = browser_request( 'filter_date_out' )) != '' ) {
		$sql .= " AND (date_in >= '". format_db_date( $checkin, 'Y-m-d' ) ."' AND  date_out <= '". format_db_date( $checkout, 'Y-m-d' ) ."'  ) ";
	}




	$results = $wpdb->get_results( $sql, ARRAY_A );

	return $results;

}


function get_bookings_for_export() {
	global $wpdb;
		
	$sql = "SELECT booking_no,  p.post_title, room_price, b.date_in, b.date_out, b.no_of_night, b.no_of_room, amount, amount_paid, b.no_of_adult, b.no_of_child,  CONCAT(b.salutation, '. ', b.first_name,' ', b.middle_name, ' ', b.last_name) as guest_name, b.birth_date, b.email_address, b.primary_phone, b.country, b.address_1, b.address_2, b.province, b.city, b.zipcode, b.nationality, b.booking_status, b.payment_status, b.date_booked  FROM ". $wpdb->prefix . "bookings b  JOIN ". $wpdb->prefix ."posts p  ON p.ID = b.room_type_ID WHERE 1 = 1";

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
			CONCAT(p.post_title, ' by:  ', b.first_name,' ', b.middle_name, ' ', b.last_name) as title,
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
			ON p.ID = b.room_type_ID";

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
			ON p.ID = b.room_type_ID 
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
 * get_available_room_types()
 * 
 * Get available rooms
 * 
 * @param none
 * @param Array $rooms
 */

if ( ! function_exists( 'get_available_room_types' ) ) {
	function get_available_room_types() {
		global $wpdb;

		$results = get_posts( array(
			'numberposts'	=> -1,
			// 'fields' => 'ID',
			'post_type'		=> 'room_type',
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
  
  $sql = $wpdb->prepare( "SELECT count(*) FROM ".$wpdb->prefix."guest_calendar WHERE room_type_ID = %d AND '%s' >= date_in AND  '%s' < date_out AND booking_ID != %d", $roomID, $from, $from, $booking_ID );
  
  return $wpdb->get_var( $sql );
}



function get_room_unavailable_schedule( $room_type_ID, $output = 'ARRAY_A' ) {
	global $wpdb;

	$results = $wpdb->get_results( "SELECT DATE_FORMAT(date_in, '%m/%d/%Y' ) AS date_in, DATE_FORMAT(date_out, '%m/%d/%Y' ) AS date_out FROM ".$wpdb->prefix."guest_calendar WHERE room_type_ID = $room_type_ID AND date_out >= CURDATE()", $output);

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


function get_rooms( $exclude = array() ) {
	$rooms = get_posts( array( 'post_type' => 'room', 'showposts' => -1, 'exclude' => $exclude ) );

	return $rooms;
}

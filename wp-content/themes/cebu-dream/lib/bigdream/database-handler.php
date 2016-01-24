<?php

if (!function_exists('bigdream_save_booking')) {
	function bigdream_save_booking($args) {
		global $wpdb;
		$data = array(
				'room_ID' => $args['room_ID'],
				'amount' => $args['amount'],
				'amount_paid' => $args['amount_paid'],
				'title' => $args['title'],
				'first_name' => $args['first_name'],
				'last_name' => $args['last_name'],
				'middle_name' => $args['middle_name'],
				'birth_date' => $args['birth_date'],
				'email_address' => $args['email_address'],
				'primary_phone' => $args['primary_phone'],
				'secondary_phone' => $args['secondary_phone'],
				'address_1' => $args['address_1'],
				'address_2' => $args['address_2'],
				'address_3' => $args['address_3'],
				'nationality' => $args['nationality'],
				'date_in' => $args['date_in'],
				'date_out' => $args['date_out'],
				'booking_status' => $args['booking_status'],
				'date_booked' => $args['date_booked'],
			);

		if (isset($args['booking_ID']) && $args['booking_ID'] != 0) {
			$result = $wpdb->update( $wpdb->prefix . 'bookings', $data, array('booking_ID' => $args['booking_ID']), array('%d', '%f', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'), array('%d'));
		} else {
			$result = $wpdb->insert( $wpdb->prefix . 'bookings', $data, array('%d', '%f', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
		}

		return $result;
	}
}
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

function update_to_checked($id) {
	global $wpdb;

	$wpdb->update($wpdb->prefix . 'bookings', array('is_checked' => 1), array('booking_ID' => $id), array('%d'), array('%d'));
}

function get_booking_by_id($id) {
	global $wpdb;
	$sql = "
		SELECT 
			b.booking_ID,
			b.is_checked,
			p.post_title as room, 
			b.first_name,
			b.middle_name,
			b.last_name,
			CONCAT(b.first_name,' ', b.middle_name, ' ', b.last_name) as name, 
			b.room_ID,
			b.amount, 
			b.amount_paid, 
			b.title, 
			b.birth_date, 
			b.email_address, 
			b.date_in, 
			b.date_out, 
			b.booking_status, 
			b.date_booked,
			b.primary_phone,
			b.secondary_phone,
			b.address_1,
			b.address_2,
			b.address_3,
			b.nationality
		FROM 
			". $wpdb->prefix . "bookings b  
		JOIN ". $wpdb->prefix ."posts p 
			ON p.ID = b.room_ID 
		WHERE booking_ID = %d";


	$sql = $wpdb->prepare($sql, $id);

	return $wpdb->get_row($sql, ARRAY_A);
}

function get_count_newly_booked() {
	global $wpdb;

	$total = $wpdb->get_var('SELECT count(*) as total FROM '. $wpdb->prefix . 'bookings WHERE is_checked = 0');

	return $total;
}

if (!function_exists('get_available_rooms')) {
	function get_available_rooms() {
		global $wpdb;

		$results = get_posts(array(
			'numberposts'	=> -1,
			'fields' => 'ids,titles',
			'post_type'		=> 'room',
			'meta_key'		=> 'room_status',
			'meta_value'	=> 'vacant_clean'
		));

	
		return $results;
	}
}


function get_inserted_ID() {
	global $wpdb;
	return $wpdb->insert_id;
}
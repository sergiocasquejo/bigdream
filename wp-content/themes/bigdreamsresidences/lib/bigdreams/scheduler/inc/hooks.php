<?php

add_action('wp_enqueue_scripts', 'enqueue_scheduler_scripts');
function enqueue_scheduler_scripts() {
	// wp_enqueue_style('bootstrap-style', _assets('css/bootstrap.min.css'));
	wp_enqueue_style('bootstrap-style', _assets('css/scheduler.css'));
	//wp_enqueue_script('bootstrap-script', _assets('js/bootstrap.min.js'), array('jquery'), false, true);
	wp_enqueue_script('moment-script', _assets('js/moment.min.js'), array('jquery'), false, true);
	wp_enqueue_script('scheduler', _assets('js/scheduler.js'), array('jquery'), false, true);
	wp_localize_script('scheduler', 'BOOKING', array(
		'ajaxURL' => admin_url('admin-ajax.php')
	));
}



add_action('wp_ajax_get-rooms', 'wp_get_rooms');
add_action('wp_ajax_nopriv_get-rooms', 'wp_get_rooms');

function wp_get_rooms() {
	if (defined('DOING_AJAX') && DOING_AJAX) {
		wp_send_json(array(
			array(
				'id' => 1,
				'no' => 101,
				'type' => 2,
				'status' => 'cleanup'
			),
			array(
				'id' => 2,
				'no' => 103,
				'type' => 4,
				'status' => 'dirty'
			),
			array(
				'id' => 3,
				'no' => 103,
				'type' => 1,
				'status' => 'ready'
			)
		));
	}
}

add_action('wp_ajax_get-bookings', 'wp_get_bookings');
add_action('wp_ajax_get-bookings', 'wp_get_bookings');

function wp_get_bookings() {
	if (defined('DOING_AJAX') && DOING_AJAX) {
		wp_send_json(array(
			array(
				'id' => 1,
				'from' => strtotime('2016-02-01'),
				'to' => strtotime('2016-02-02'),
				'type' => 2,
				'status' => 'CONFIRMED'
			),
			array(
				'id' => 1,
				'from' => strtotime('2016-02-05'),
				'to' => strtotime('2016-02-07'),
				'type' => 2,
				'status' => 'CONFIRMED'
			),
			array(
				'id' => 1,
				'from' => strtotime('2016-02-08'),
				'to' => strtotime('2016-02-09'),
				'type' => 2,
				'status' => 'CONFIRMED'
			),
		));
	}
}

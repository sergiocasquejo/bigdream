<?php
define('SCHED_DIR', get_template_directory() . '/lib/bigdreams/scheduler');
define('SCHED_DIR_URI', get_template_directory_uri() . '/lib/bigdreams/scheduler');

include "inc/hooks.php";
include "inc/dal.php";


function _assets($file, $echo = false) {
	$url = SCHED_DIR_URI . '/assets/'. $file;
	if (!$echo) return $url;
	echo $url;
}


function booking_schedule_shortcode_handler($atts, $content = null) {
	$output = '';


	include "views/scheduler.html.php";
	$output .= ob_get_clean();
	return $output;
}

add_shortcode('booking-schedule', 'booking_schedule_shortcode_handler');

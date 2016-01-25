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


if (!function_exists('bigdream_admin_notices')) {
	function bigdream_admin_notices() {

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
				$data = $_REQUEST;

				$_SESSION['_bdr_booking'] = array_merge($_SESSION['_bdr_booking'], array(
						'date_in' => $data['date_in'],
						'date_out' => $data['date_out'],
						'no_of_adults' => $data['no_of_adults'],
						'no_of_child' => isset($data['no_of_child']) ? $data['no_of_child'] : 0,
					));
				exit(wp_redirect(get_permalink(get_page_by_path('rooms-suits'))));
				break;
		}
	}
}
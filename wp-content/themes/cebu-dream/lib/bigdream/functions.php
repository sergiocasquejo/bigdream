<?php

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
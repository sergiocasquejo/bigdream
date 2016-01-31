<?php
add_filter('show_admin_bar', '__return_false');


function bdr_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	global $user;
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) || in_array( 'booking_manager', $user->roles ) ) {
			// redirect them to the default place
			return admin_url('admin.php?page=big-dream-dashboard');
		} else {
			return home_url();
		}
	} else {
		return $redirect_to;
	}
}

add_filter('login_redirect', 'bdr_login_redirect', 10, 3);

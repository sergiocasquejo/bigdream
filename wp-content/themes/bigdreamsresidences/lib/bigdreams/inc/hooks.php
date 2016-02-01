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

add_filter('site_url',  'wplogin_filter', 10, 3);
function wplogin_filter( $url, $path, $orig_scheme )
{
 $old  = array( "/(wp-login\.php)/");
 $new  = array( "login");
 return preg_replace( $old, $new, $url, 1);
}


// Change WordPress Login Logo URL
add_filter( 'login_headerurl', 'custom_logo_url' );
function custom_logo_url($url) {
 return get_bloginfo('url');
}

add_filter('login_headertitle', 'custom_logo_title');
function custom_logo_title() {
    return get_bloginfo('name');
}

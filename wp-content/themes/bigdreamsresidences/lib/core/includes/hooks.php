<?php
add_filter('show_admin_bar', '__return_false');


function login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	global $user;
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) || in_array( 'booking_manager', $user->roles ) ) {
			// redirect them to the default place
			return admin_url('admin.php?page=booking-system');
		} else {
			return home_url();
		}
	} else {
		return $redirect_to;
	}
}

add_filter('login_redirect', 'login_redirect', 10, 3);


function login_filter( $url, $path, $orig_scheme )
{
	$old  = array( "/(wp-login\.php)/");
	$new  = array( "login");
	return preg_replace( $old, $new, $url, 1);
}

add_filter('site_url',  'login_filter', 10, 3);


// Change WordPress Login Logo URL
function custom_logo_url($url) {
	return get_bloginfo('url');
}
add_filter( 'login_headerurl', 'custom_logo_url' );


function custom_logo_title() {
    return get_bloginfo('name');
}
add_filter('login_headertitle', 'custom_logo_title');

function login_logo() { ?>
    <style type="text/css">
    	body {
    	    background-color: #000;
    	 }
        .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/dist/images/logo-medium.jpg);
            background-size: 100%;
            width: 250px;
            height: 150px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'login_logo' );



function list_set_option( $status, $option, $value ) {
  return $value;
}

add_filter( 'set-screen-option', 'list_set_option', 10, 3 );


function acf_load_color_field_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();
    
    
    // get the textarea value from options page without any formatting
    $choices = room_statuses();

    
    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        
        foreach( $choices as $choice ) {
            
            $field['choices'][ $choice ] = $choice;
            
        }
        
    }
    

    // return the field
    return $field;
    
}

add_filter('acf/load_field/name=room_status', 'acf_load_color_field_choices');
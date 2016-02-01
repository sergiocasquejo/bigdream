<?php 

class BigDream_Booking {
	const LIST_PAGE_SLUG = 'big-dream-bookings';
	const NEW_BOOKING_SLUG = 'big-dream-booking-edit';
	const VIEW_BOOKING_SLUG = 'big-dream-booking-view';

	public function __construct() {
		add_action( 'admin_menu', array($this, 'admin_menu') );
		add_action( 'admin_notices', array($this, 'newly_booked_admin_notice'));

		add_action('admin_footer', array($this, 'admin_footer'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		// Get booking details
		add_action('wp_ajax_booking-details', array($this, 'booking_details'));
		add_action('wp_ajax_nopriv_booking-details', array($this, 'booking_details'));
	}
	public function enqueue_scripts() {
		wp_enqueue_style('fullcalendar.min-style', CDR_SYSTEM_DIR_URI .'/assets/vendor/fullcalendar.min.css');
		wp_enqueue_style('fullcalendar.print.min-style', CDR_SYSTEM_DIR_URI .'/assets/vendor/fullcalendar.print.css', array(), null, 'print');

		wp_enqueue_script('moment.min-script', CDR_SYSTEM_DIR_URI .'/assets/vendor/moment.min.js');
		wp_enqueue_script('fullcalendar.min-script', CDR_SYSTEM_DIR_URI .'/assets/vendor/fullcalendar.min.js', array('moment.min-script', 'jquery'), false, false);

	}
	public function admin_menu() {
		global $menu;
		$hook = add_submenu_page( 'big-dream-dashboard', 'Bookings', 'Bookings', 'manage_bookings', self::LIST_PAGE_SLUG, array($this, 'bookings') );
		add_submenu_page( self::NEW_BOOKING_SLUG, 'Edit Booking', 'Edit Booking', 'manage_bookings', self::NEW_BOOKING_SLUG, array($this, 'add_edit_booking') );
		//add_submenu_page( self::VIEW_BOOKING_SLUG, 'View Booking', 'View Booking', 'manage_options', self::VIEW_BOOKING_SLUG, array($this, 'booking_details') );


		$newitem = get_count_newly_booked();
	    $menu[BDR_MENU_POSITION][0] .= $newitem ? "<span class='update-plugins count-1'><span class='update-count'>$newitem </span></span>" : '';
	    add_action( "load-$hook", array($this, 'add_options' ));
	}

	public function add_options() {
		global $booking_list_table;
		$option = 'per_page';
		$args = array(
		     'label' => 'Bookings',
		     'default' => 20,
		     'option' => 'bookings_per_page'
		     );
		add_screen_option( $option, $args );
		$booking_list_table = new Booking_List_TBL();
	}

	public function newly_booked_admin_notice() {
		$count = get_count_newly_booked();

		if ($count > 0) {

			echo '<div class="updated">';
        		echo '<p>' . get_count_newly_booked() . ' Guest Newly booked. <a href="'. admin_url('admin.php?page='. self::LIST_PAGE_SLUG .'&view=list&new=0') .'">Click here.</a></p>';
    		echo '</div>';
    	}
	}

	public function bookings() {
		if (isset($_GET['view']) && $_GET['view'] =='list') {
			global $booking_list_table;

			$booking_list_table->prepare_items();
			include_once CDR_ADMIN_DIR . '/views/bookings.html.php';
		} else {
			include_once CDR_ADMIN_DIR . '/views/bookings-calendar-view.html.php';
		}
	}

	public function booking_details() {
		if (defined('DOING_AJAX') && DOING_AJAX) {
			
			// Update booking to checked
			update_to_checked($_GET['bid']);
			$details = get_booking_by_id($_GET['bid']);

			$featured_image = '';
			if (has_post_thumbnail($details['room_ID'])) {
				$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($details['room_ID']), 'large')[0];
			}

			include_once CDR_ADMIN_DIR . '/views/booking-details.html.php';
			exit;
		}
	}

	public function add_edit_booking() {

		if ( isset( $_POST['save_booking_field'] ) && wp_verify_nonce( $_POST['save_booking_field'], 'save_booking_action' ) ) {
			$post = $_POST;

			$args = array(
				'booking_ID' => $post['booking_ID'],
				'room_ID' => $post['room_ID'],
				'amount' => $post['amount'],
				'amount_paid' => $post['amount_paid'],
				'salutation' => $post['salutation'],
				'country' => $post['country'],
				'first_name' => $post['first_name'],
				'last_name' => $post['last_name'],
				'middle_name' => $post['middle_name'],
				'birth_date' => $post['birth_date'],
				'email_address' => $post['email_address'],
				'primary_phone' => $post['primary_phone'],
				'address_1' => $post['address_1'],
				'address_2' => $post['address_2'],
				'city' => $post['city'],
				'province' => $post['province'],
				'zipcode' => $post['zipcode'],
				'nationality' => $post['nationality'],
				'date_in' => $post['date_in'],
				'date_out' => $post['date_out'],
				'no_of_adult' => $post['no_of_adult'],
				'no_of_child' => $post['no_of_child'],
				'no_of_night' => count_nights($post['date_in'], $post['date_out']),
				'booking_status' => $post['booking_status'],
				'notes' => $post['notes'],
				'type' => $post['booking_ID'] != 0 ? 'BOOKING' : $post['booking_ID'],
				'date_booked' => date('Y-m-d H:i:s'),
			);
			
      if ($post['booking_ID'] == 0 && is_date_and_room_not_available($post['room_ID'], format_db_date($post['date_in']),  format_db_date($post['date_out']))) {
			  bigdream_add_notices('error', 'Selected room is not available on that date. Please check calendar to see availability.');
			} else {
  			if (bigdream_save_booking($args)) {
  				bigdream_add_notices('updated', 'Successully Saved.');
  				bigdream_redirect_script('admin.php?page=big-dream-bookings&view=list');
  			} else {
  				bigdream_add_notices('error', 'Error while Saving.');
  			}
			}
		} elseif(isset($_GET['bid']) && !empty($_GET['bid'])) {
			// Update booking to checked
			update_to_checked($_GET['bid']);
			$post = get_booking_by_id($_GET['bid']);
		} else {
			$post = array(
				'booking_ID' => 0,
				'room_ID' => 0,
				'amount' => 0,
				'amount_paid' => 0,
				'salutation' => 'Mr',
				'country' => 'Philippines',
				'first_name' => '',
				'last_name' => '',
				'middle_name' => '',
				'birth_date' => '',
				'email_address' => '',
				'primary_phone' => '',
				'address_1' => '',
				'address_2' => '',
				'city' => '',
				'province' => '',
				'zipcode' => '',
				'nationality' => 'Filipino',
				'date_in' => date('Y-m-d'),
				'date_out' => date('Y-m-d'),
				'no_of_adult' => 0,
				'no_of_child' => 0,
				'booking_status' => '',
				'notes' => '',
				'date_booked' => date('Y-m-d H:i:s'),
			);
		}

		$available_rooms = get_available_rooms();
		$booking_statuses = json_decode(BOOKING_STATUSES);
		$guest_title = json_decode(GUEST_TITLE);

		include_once CDR_ADMIN_DIR . '/views/edit-booking.html.php';	
	}


	


	public function admin_footer() {
		add_thickbox();

		$output = '';
		$output .= '<div id="bdrModalDialog" style="display:none;"></div>';

		echo $output;
	}
}

new BigDream_Booking();

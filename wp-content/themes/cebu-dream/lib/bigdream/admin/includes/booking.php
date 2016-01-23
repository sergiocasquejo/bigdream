<?php 

class BigDream_Booking {
	const LIST_PAGE_SLUG = 'big-dream-bookings';
	const NEW_BOOKING_SLUG = 'big-dream-booking-edit';
	const VIEW_BOOKING_SLUG = 'big-dream-booking-view';

	public function __construct() {
		add_action( 'admin_menu', array($this, 'admin_menu') );
		add_action( 'admin_notices', array($this, 'newly_booked_admin_notice'));
	}

	public function admin_menu() {
		global $menu;
		$hook = add_submenu_page( 'big-dream-dashboard', 'Bookings', 'Bookings', 'manage_options', self::LIST_PAGE_SLUG, array($this, 'bookings') );
		add_submenu_page( self::NEW_BOOKING_SLUG, 'Edit Booking', 'Edit Booking', 'manage_options', self::NEW_BOOKING_SLUG, array($this, 'add_edit_booking') );
		add_submenu_page( self::VIEW_BOOKING_SLUG, 'View Booking', 'View Booking', 'manage_options', self::VIEW_BOOKING_SLUG, array($this, 'view_booking') );


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
        		echo '<p>' . get_count_newly_booked() . ' Newly booked. <a href="'. admin_url('admin.php?page='. self::LIST_PAGE_SLUG .'&new=0') .'">Click here.</a></p>';
    		echo '</div>';
    	}
	}

	public function bookings() {
		global $booking_list_table;

		$booking_list_table->prepare_items();
		include_once CDR_ADMIN_DIR . '/views/bookings.html.php';	
	}

	public function add_edit_booking() {

		if ( isset( $_POST['save_booking_field'] ) && wp_verify_nonce( $_POST['save_booking_field'], 'save_booking_action' ) ) {
			$post = $_POST;

			$args = array(
				'booking_ID' => $post['booking_ID'],
				'room_ID' => $post['room_ID'],
				'amount' => $post['amount'],
				'amount_paid' => $post['amount_paid'],
				'title' => $post['title'],
				'first_name' => $post['first_name'],
				'last_name' => $post['last_name'],
				'middle_name' => $post['middle_name'],
				'birth_date' => $post['birth_date'],
				'email_address' => $post['email_address'],
				'primary_phone' => $post['primary_phone'],
				'secondary_phone' => $post['secondary_phone'],
				'address_1' => $post['address_1'],
				'address_2' => $post['address_2'],
				'address_3' => $post['address_3'],
				'nationality' => $post['nationality'],
				'date_in' => $post['date_in'],
				'date_out' => $post['date_out'],
				'booking_status' => $post['booking_status'],
				'date_booked' => date('Y-m-d H:i:s'),
			);
			if (bigdream_save_booking($args)) {
				bigdream_add_notices('updated', 'Successully Saved.');
				bigdream_redirect_script('admin.php?page=big-dream-bookings');
			} else {
				bigdream_add_notices('error', 'Error while Saving.');
			}

		} elseif(isset($_GET['bid']) && !empty($_GET['bid'])) {
			// Update booking to checked
			update_to_checked($_GET['bid']);
			$post = get_booking_by_id($_GET['bid']);
		} else {
			$post = array(
				'booking_ID' => 0,
				'room_ID' => '',
				'amount' => 0,
				'amount_paid' => 0,
				'title' => 'Mr',
				'first_name' => '',
				'last_name' => '',
				'middle_name' => '',
				'birth_date' => '',
				'email_address' => '',
				'primary_phone' => '',
				'secondary_phone' => '',
				'address_1' => '',
				'address_2' => '',
				'address_3' => '',
				'nationality' => 'Filipino',
				'date_in' => date('Y-m-d'),
				'date_out' => date('Y-m-d'),
				'booking_status' => '',
			);
		}

		$available_rooms = get_available_rooms();
		$booking_statuses = json_decode(BOOKING_STATUSES);
		$guest_title = json_encode(GUEST_TITLE);


		include_once CDR_ADMIN_DIR . '/views/edit-booking.html.php';	
	}


	public function view_booking() {
		// Update booking to checked
		update_to_checked($_GET['bid']);
		$post = get_booking_by_id($_GET['bid']);
		include_once CDR_ADMIN_DIR . '/views/view-booking.html.php';	
	}
}

new BigDream_Booking();
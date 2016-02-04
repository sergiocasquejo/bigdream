<?php 

class Admin_Booking {
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

		add_action('admin_init', array($this, 'admin_init'));
	}

	public function admin_init() {

		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'export-bookings') {

			$results = get_all_bookings();

			// When executed in a browser, this script will prompt for download 
			// of 'test.xls' which can then be opened by Excel or OpenOffice.
			require BDR_SYSTEM_DIR .'/inc/php-export-data.class.php';
			// 'browser' tells the library to stream the data directly to the browser.
			// other options are 'file' or 'string'
			// 'test.xls' is the filename that the browser will use when attempting to 
			// save the download
			$exporter = new ExportDataExcel('browser', 'reports.xls');

			$exporter->initialize(); // starts streaming data to web browser

			// pass addRow() an array and it converts it to Excel XML format and sends 
			// it to the browser
			$exporter->addRow($results); 


			$exporter->finalize(); // writes the footer, flushes remaining data to browser.

			exit(); // all done

		}
	}


	public function enqueue_scripts() {
		wp_enqueue_style('fullcalendar.min-style', BDR_SYSTEM_DIR_URI .'/assets/vendor/fullcalendar.min.css');
		wp_enqueue_style('fullcalendar.print.min-style', BDR_SYSTEM_DIR_URI .'/assets/vendor/fullcalendar.print.css', array(), null, 'print');

		wp_enqueue_script('moment.min-script', BDR_SYSTEM_DIR_URI .'/assets/vendor/moment.min.js');
		wp_enqueue_script('fullcalendar.min-script', BDR_SYSTEM_DIR_URI .'/assets/vendor/fullcalendar.min.js', array('moment.min-script', 'jquery'), false, false);

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
        		echo '<p>' . get_count_newly_booked() . ' Guest Newly booked. <a href="'. admin_url('admin.php?page='. self::LIST_PAGE_SLUG .'&view=list&status=NEW') .'">Click here.</a></p>';
    		echo '</div>';
    	}
	}

	public function bookings() {
		if (isset($_GET['view']) && $_GET['view'] =='calendar') {
			include_once BDR_ADMIN_DIR . '/views/bookings-calendar-view.html.php';

		} else {
			global $booking_list_table;
			$booking_list_table->prepare_items();
			include_once BDR_ADMIN_DIR . '/views/bookings.html.php';
		}
	}

	public function booking_details() {
		if (defined('DOING_AJAX') && DOING_AJAX) {
			
			$details = get_booking_by_id($_GET['bid']);

			$featured_image = '';
			if (has_post_thumbnail($details['room_ID'])) {
				$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($details['room_ID']), 'large')[0];
			}

			include_once BDR_ADMIN_DIR . '/views/booking-details.html.php';
			exit;
		}
	}

	public function add_edit_booking() {
		$editable = true;
		if ( isset( $_POST['save_booking_field'] ) && wp_verify_nonce( $_POST['save_booking_field'], 'save_booking_action' ) ) {
			$post = $_POST;
			

			if ($post['booking_ID'] <= 0) {
				$nights = count_nights($post['date_in'], $post['date_out']);
				$nights = $nights <= 0 ? 1 : $nights;
				$room_price = get_room_price($post['room_ID'], $post['date_in'], $post['date_out']);
				$total_amount = $room_price * $nights;
			} else {
				$b = get_booking_by_id($post['booking_ID']);
				$room_price = $b['room_price'];
				$nights = $b['no_of_night'];
				$total_amount = $b['amount'];
				$post['date_in'] = $b['date_in'];
				$post['date_out'] = $b['date_out'];
				$post['room_ID'] = $b['room_ID'];
				
			}

			
			$args = array(
				'booking_ID' => $post['booking_ID'],
				'room_ID' => $post['room_ID'],
				'room_price' => $room_price,
				'amount' =>  $total_amount,
				'amount_paid' => $post['amount_paid'],
				'salutation' => $post['salutation'],
				'country' => $post['country'],
				'first_name' => $post['first_name'],
				'last_name' => $post['last_name'],
				'middle_name' => $post['middle_name'],
				'birth_date' => format_db_date($post['birth_date']),
				'email_address' => $post['email_address'],
				'primary_phone' => $post['primary_phone'],
				'address_1' => $post['address_1'],
				'address_2' => $post['address_2'],
				'city' => $post['city'],
				'province' => $post['province'],
				'zipcode' => $post['zipcode'],
				'nationality' => $post['nationality'],
				'date_in' => format_db_date($post['date_in']),
				'date_out' => format_db_date($post['date_out']),
				'no_of_adult' => $post['no_of_adult'],
				'no_of_child' => $post['no_of_child'],
				'no_of_night' => $nights,
				'payment_status' => $post['payment_status'],
				'booking_status' => $post['booking_status'],
				'notes' => $post['notes'],
				'type' => $post['booking_ID'] != 0 ? 'BOOKING' : $post['booking_ID'],
				'date_booked' => date('Y-m-d H:i:s'),
			);
			
			if (	
					$post['booking_ID'] == 0 
					&& is_date_and_room_not_available($post['room_ID'], format_db_date($post['date_in']),  format_db_date($post['date_out']))
				) {
				  bigdream_add_notices('error', 'Selected room is not available on that date. Please check calendar to see availability.');
			} else {
			
				$val = validate_booking_data($args);

			    if($val['valid'] === false) {
			    	bigdream_javacript_notices($val['errors']);
			        bigdream_add_notices('error', 'Please review the fields.');
		
			    } else if (bigdream_save_booking($args)) {
  			  
					if ($post['booking_ID'] == 0) {
						$booking_ID = get_inserted_ID();
						// Update booking no
						generate_and_update_booking_no($booking_ID);
						// Empty booking info
						empty_booking();
						// replace data in booking session with booking ID
						push_to_booking_session(array('booking_ID' => $booking_ID));
						// Send email notification
						send_success_booking_notification();
					}
						
  					bigdream_add_notices('updated', 'Successully Saved.');
	  				bigdream_redirect_script('admin.php?page=big-dream-bookings&view=list');
  					
  			} else {
  				bigdream_add_notices('error', 'Error while Saving.');
  			}
		}
		} elseif(isset($_GET['bid']) && !empty($_GET['bid'])) {
			$post = get_booking_by_id($_GET['bid']);
			if ($post['booking_ID'] > 0 && !in_array($post['booking_status'], array('Unconfirmed', 'Cancelled'))) {
				$editable = false;
			}
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
				'payment_status' => PAYMENT_DEFAULT_STATUS,
				'notes' => '',
				'date_booked' => date('Y-m-d H:i:s'),
			);
		}

		$available_rooms = get_available_rooms();
		$booking_statuses = booking_statuses();
		$guest_title = salutations();

		include_once BDR_ADMIN_DIR . '/views/edit-booking.html.php';	
	}


	


	public function admin_footer() {
		add_thickbox();

		$output = '';
		$output .= '<div id="bdrModalDialog" style="display:none;"></div>';

		echo $output;
	}
}

new Admin_Booking();

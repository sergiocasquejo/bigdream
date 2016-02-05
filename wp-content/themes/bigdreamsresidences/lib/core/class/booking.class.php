<?php
if (! class_exists('Booking') ) {

	class Booking {

		public function __construct() {
			// Register custom administrator menu
			add_action( 'admin_menu', array( &$this, 'register_admin_menu' ) );
			// Display notification to administrator for newly booked
			add_action( 'admin_notices', array( &$this, 'notify_admin_for_newly_booked' ) );

			add_action( 'admin_footer', array( &$this, 'add_thickbox_to_footer' ) );

			add_action('admin_enqueue_scripts', array( &$this, 'enqueue_styles_and_scripts' ) );

			 // Get booking details
		    add_action( 'wp_ajax_booking-details', array( &$this, 'details' ) );
		    add_action( 'wp_ajax_nopriv_booking-details', array( &$this, 'details' ) );

		    add_action( 'init', array( &$this, 'custom_init' ) );
		}


		function validate_booking_data($data) {
			
			require_class( 'gump.class.php' );

		    $gump = new GUMP();
		    
		    $data = $gump->sanitize( $data );

		    $gump->validation_rules( array(
				'first_name' => 'required|min_len,1|max_len,100',
				'last_name' => 'required|min_len,1|max_len,100',
				'middle_name' => 'required|min_len,1|max_len,100',
				'birth_date' => 'required|date',
			    'room_ID' => 'required|numeric',
			    'amount' => 'required|numeric',
			    'email_address' => 'required|valid_email',
			    'primary_phone' => 'required',
			    'address_1' => 'required',
			    'city' => 'required',
			    'province' => 'required',
			    'zipcode' => 'required',
			    'nationality' => 'required',
			    'date_in' => 'required|date',
			    'date_out' => 'required|date',
		    ) );


		    return array( 'valid' => $gump->run( $data ), 'errors' => $gump->get_key_and_value_errors( true ) );

		}	

		private function process( $data ) {

			$data['birth_date'] = format_db_date( $data['birth_date'] );
			$data['date_in'] = format_db_date( $data['date_in'] );
			$data['date_out'] = format_db_date( $data['date_out'] );

			if ( is_date_and_room_not_available( $data['room_ID'], $data['date_in'], $data['date_out'], $data['booking_ID']) ) {
				add_this_notices( 'error', 'Selected room is not available on that date. Please check calendar to see availability.' );

				return false;
			} 

			$val = $this->validate_booking_data( $data );

			if( $val['valid'] === false ) {
				javacript_notices( $val['errors'] );
				add_this_notices( 'error', 'Please review the fields.' );
			} else {

				require_class( 'gump.class.php' );
			    $gump = new GUMP();
			    $data = $gump->sanitize( $data );


				if ( save_booking( $data ) !== false ) {
					if ( $data['booking_ID'] < 1 ) {
						$inserted_ID = get_inserted_ID();
						send_success_booking_notification( $inserted_ID );

						
						// Update booking no
						generate_and_update_booking_no( $inserted_ID );
						// replace data in booking session with booking ID
						push_to_booking_session( array( 'booking_ID' => $inserted_ID ) );
						
					}

					add_this_notices( 'updated', 'Successully Saved.' );
					return true;

				} else {
					add_this_notices( 'error', 'Error while Saving.' );

				}
			}

			return false;
		}

		/**
		 * custom_init()
		 * 
		 * Process booking post data
		 * 
		 * @param none
		 * @return none
		 */
		public function custom_init() {
			$action = browser_request( 'action' );

			if ( $action != '' ) {

				switch( $action ) {

					case 'check_availability':

						$data = $_POST;

						push_to_booking_session( 
							array(
								'date_in' => $data['date_in'],
								'date_out' => $data['date_out'],
								'no_of_adult' => $data['no_of_adult'],
								'type' => 'BOOKING',
								'no_of_child' => array_data( $data, 'no_of_child', 0 )
							) 
						);

						redirect_by_page_path( 'rooms-suits' );
						break;

					case 'book_room':

						$data = $_POST;
						if ( ! is_bookable( $data['room_ID'] ) ) {

							add_this_notices( 'error', 'Selected room is Out of Order.' );
							return;
						}

						if ( is_date_and_room_not_available( $data['room_ID'], format_db_date( $data['date_in'] ),  format_db_date( $data['date_out'] ) ) ) {
							add_this_notices( 'error', 'Selected room is not available on that date. Please check calendar to see availability.' );
							return;
						}

						$nights = count_nights( $data['date_in'], $data['date_out'] );
						$room_price = get_room_price( $data['room_ID'], $data['date_in'], $data['date_out'] );

						push_to_booking_session( array(
							'date_in' 		=> $data['date_in'],
							'date_out' 		=> $data['date_out'],
							'no_of_adult' 	=> $data['no_of_adult'],
							'no_of_child' 	=> array_data( $data, 'no_of_child', 0 ),
							'room_ID' 		=> $data['room_ID'],
							'room_code' 	=> room_code( $data['room_ID'] ),
							'no_of_night' 	=> $nights,
							'room_price' 	=> $room_price,
							'amount' 		=> $room_price * $nights, 
							'booking_ID' 	=> 0,
							'amount_paid' 	=> 0,
							'payment_status' => PAYMENT_DEFAULT_STATUS,
							'booking_status' => BOOKING_DEFAULT_STATUS
						) );


						redirect_by_page_path( 'review' );

						break;

					case 'make_reservation':
						if ( is_empty_booking() ) {
							add_this_notices( 'error', 'Please select date.' );
							redirect_by_page_path( '/' );
							return;
						}

						$data = get_booking_session();

						if ( ! is_bookable( $data['room_ID'] ) ) {
							add_this_notices( 'error', 'Selected room is Out of Order.' );
							return;
						}

						$data = push_to_booking_session( array_merge( $data, $_POST, array( 'date_booked' => date( 'Y-m-d H:i:s' ) ) ) );
						if ( $this->process( $data ) ) {
							redirect_by_page_path( 'success' );
						}
						break;
					case 'export-bookings':

						$results = get_filtered_bookings();

						// When executed in a browser, this script will prompt for download 
						// of 'test.xls' which can then be opened by Excel or OpenOffice.
						require_class( 'php-export-data.class.php' );
						// 'browser' tells the library to stream the data directly to the browser.
						// other options are 'file' or 'string'
						// 'test.xls' is the filename that the browser will use when attempting to 
						// save the download
						$exporter = new ExportDataExcel( 'browser', 'reports.xls' );

						$exporter->initialize(); // starts streaming data to web browser

						foreach ( $results as $i => $r ) {
							// pass addRow() an array and it converts it to Excel XML format and sends 
							// it to the browser
							$exporter->addRow($r); 
						}

						$exporter->finalize(); // writes the footer, flushes remaining data to browser.
						exit(); // all done
						break;
				}

			}
		}


		public function add_edit_booking() {


			$info = get_booking_by_id( browser_request( 'bid', 0 ) );

			$date_in = date( 'Y-m-d' );
			$date_out = date( 'Y-m-d', time() + 86400 );
			$post = array_merge(array(
					'booking_ID' => 0,
					'room_ID' => 0,
					'room_code' => 0,
					'room_price' => 0,
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
					'date_in' => $date_in,
					'date_out' => $date_out,
					'no_of_adult' => 1,
					'no_of_child' => 0,
					'no_of_night' => 0,
					'booking_status' => BOOKING_DEFAULT_STATUS,
					'payment_status' => PAYMENT_DEFAULT_STATUS,
					'notes' => '',
					'type' => 'RESERVATION',
					'date_booked' => date('Y-m-d H:i:s')
				), (array) $info);

			
			if ( isset( $_POST['save_booking_field'] ) && wp_verify_nonce( $_POST['save_booking_field'], 'save_booking_action' ) ) {

				$post = array_merge( $post, $_POST );

				$post['no_of_night'] = count_nights( $post['date_in'], $post['date_out'] );
				$post['room_price'] = get_room_price( $post['room_ID'], $post['date_in'], $post['date_out'] );
				$post['amount'] = $post['room_price'] * $post['no_of_night'];
				$post['date_booked'] = array_data( $info, 'date_booked' , date( 'Y-m-d H:i:s' ) );
				$post['type'] = 'RESERVATION';
				$post['room_code'] = room_code( $post['room_ID'] );

				// Check if booking is exists
				// if ( count( $b = get_booking_by_id( $post['booking_ID'] ) ) > 0 ) {
				// 	$post = array_merge( $post, get_array_values_by_keys( $b, array( 'room_ID', 'room_code', 'room_price', 'no_of_night', 'amount', 'type', 'date_booked' ) ) );
				// }

				if ( $this->process( $post ) ) {
					redirect_js_script( 'admin.php?page=manage-bookings&view=list' );
				}

			}

			
			$post['editable'] = in_array( $post['booking_status'], array( 'NEW', 'CONFIRMED' ) );
			$post['available_rooms'] = get_available_rooms();
			$post['booking_statuses'] = booking_statuses();
			$post['payment_statuses'] = payment_statuses();
			$post['salutations'] = salutations();

			include_view( 'edit-booking.html.php', $post );  
		}


		public function enqueue_styles_and_scripts() {

			global $post_type;

			if ( ( isset( $_GET['page'] ) && in_array( $_GET['page'], array( 'booking-system', 'manage-bookings', 'edit-booking' ) ) ) ||  'room' == $post_type ) {

			   	wp_enqueue_style( 'admin-style', assets( 'style/admin.css' ) );	
			   	wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );

			   	wp_enqueue_style( 'fullcalendar.min-style', assets( 'vendor/fullcalendar.min.css' ) );
				wp_enqueue_style( 'fullcalendar.print.min-style', assets( 'vendor/fullcalendar.print.css' ), array(), null, 'print' );
				wp_enqueue_script( 'moment.min-script', assets( 'vendor/moment.min.js' ) );
				wp_enqueue_script( 'fullcalendar.min-script', assets( 'vendor/fullcalendar.min.js' ), array( 'moment.min-script', 'jquery' ), false, false );
			   	wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'chart-script', assets( 'vendor/Chart.min.js' ), array( 'jquery' ), true, false );
				wp_enqueue_script( 'admin-script', assets( 'js/admin.js' ), array( 'chart-script', 'jquery' ), true, true );
				wp_localize_script( 'admin-script', 'BDR', array(
					'AjaxUrl' => admin_url( 'admin-ajax.php' ),
					'bookings' => get_booking_calendar()
				) );
			}
			

		}


		public function add_thickbox_to_footer() {
			add_thickbox();
			
			$output = '<div id="bdrModalDialog" style="display:none;"></div>';

			echo $output;
		}


		public function notify_admin_for_newly_booked() {

			$count = get_count_newly_booked();

			if ($count > 0) {
				echo '<div class="updated">';
				echo '<p>' . $count . ' Guest Newly booked. <a href="'. admin_url( 'admin.php?page=big-dream-bookings&view=list&status=NEW' ) .'">Click here.</a></p>';
				echo '</div>';
			}
		}


		public function register_admin_menu() {
			global $menu;
			
			add_menu_page( 'Booking System', 'Booking System', 'manage_bookings', 'booking-system', array( &$this, 'admin_dashboard' ), 'dashicons-calendar-alt', BDR_MENU_POSITION );
			add_submenu_page( 'booking-system', 'Rooms', 'Rooms', 'manage_bookings', 'edit.php?post_type=room', false );
			$hook = add_submenu_page( 'booking-system', 'Bookings', 'Bookings', 'manage_bookings', 'manage-bookings', array( &$this, 'bookings' ) );
			add_submenu_page( 'edit-booking', 'Edit Booking', 'Edit Booking', 'manage_bookings', 'edit-booking', array( &$this, 'add_edit_booking' ) );

			// Add badge notification to menu
			$newitem = get_count_newly_booked();
			$menu[BDR_MENU_POSITION][0] .= $newitem ? "<span class='update-plugins count-1'><span class='update-count'>$newitem</span></span>" : '';

			add_action( "load-$hook", array( &$this, 'add_options' ) );
		}


		public function admin_dashboard() {
			include_view( "dashboard.html.php" );
		}

		public function add_options() {
			
			global $booking_list_table;

			require_class( 'booking-list.class.php' );

			$option = 'per_page';
			
			$args = array( 'label' => 'Bookings', 'default' => DEFAULT_PER_PAGE, 'option' => 'bookings_per_page' );

			add_screen_option( $option, $args );

			$booking_list_table = new Booking_List_Table();
		}


		


		public function bookings() {

			if ( browser_get( 'view' ) == 'calendar' ) {
				include_view ( 'bookings-calendar-view.html.php' );

			} else {

				global $booking_list_table;

				include_view ( 'bookings.html.php', $booking_list_table );
			}
		}

		public function details() {

			if ( defined('DOING_AJAX') && DOING_AJAX ) {

				$details = get_booking_by_id( browser_get( 'bid' ) );

				$details['featured_image'] = featured_image( $details['room_ID'], 'large' );

				include_view( 'booking-details.html.php', $details );
				exit;
			}
			
		}

		
	}
}



new Booking();

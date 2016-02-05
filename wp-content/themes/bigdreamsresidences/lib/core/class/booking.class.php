<?php
if (! class_exists('Booking') ) {

	class Booking {

		public function __construct() {
			// Register custom administrator menu
			add_action( 'admin_menu', array( &$this, 'register_admin_menu' ) );
			// Custom init method
			add_action( 'admin_init', array( &$this, 'init' ) );
			// Display notification to administrator for newly booked
			add_action( 'admin_notices', array( &$this, 'notify_admin_for_newly_booked' ) );

			add_action( 'admin_footer', array( &$this, 'add_thickbox_to_footer' ) );

			add_action('admin_enqueue_scripts', array( &$this, 'enqueue_styles_and_scripts' ) );

			 // Get booking details
		    add_action( 'wp_ajax_booking-details', array( &$this, 'details' ) );
		    add_action( 'wp_ajax_nopriv_booking-details', array( &$this, 'details' ) );

		    add_action( 'init', array( &this, 'custom_init' ) );
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

			if ( $data['booking_ID'] == 0 && is_date_and_room_not_available( $data['room_ID'], $data['date_in'], $data['date_out'] ) ) {
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


				if ( save_booking( $data ) ) {
					if ( $data['booking_ID'] < 1 ) {
						$inserted_ID = get_inserted_ID();
						// Update booking no
						generate_and_update_booking_no( $inserted_ID );
						// replace data in booking session with booking ID
						push_to_booking_session( array( 'booking_ID' => $bid ) );
						send_success_booking_notification( $inserted_ID );
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

			if ( $action = browser_request( 'action' ) != '' ) {

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
							redirect_by_page_path( '/' )
							break;
						}

						$data = get_booking_session();

						if ( ! is_bookable( $data['room_ID'] ) ) {
							add_this_notices( 'error', 'Selected room is Out of Order.' );
							return;
						}

						$data = push_to_booking_session( array_merge( $data, $_POST, array( 'date_booked' => date( 'Y-m-d H:i:s' ) ) ) );
						if ( $this->process( $data ) ) {
							// Empty booking info
							empty_booking();
							redirect_by_page_path( 'success' );
						}
						break;
				
				}

			}
		}


		public function add_edit_booking() {

			$editable = true;

			if ( isset( $_POST['save_booking_field'] ) && wp_verify_nonce( $_POST['save_booking_field'], 'save_booking_action' ) ) {

				$post = $_POST;

				$post['nights'] = count_nights( $post['date_in'], $post['date_out'] );
				$post['amount'] = get_sub_total( $post['room_ID'], $post['date_in'], $post['date_out'] );
				$post['date_booked'] = date( 'Y-m-d H:i:s' );
				$post['type'] = 'RESERVATION';
				$post['room_code'] = room_code( $post['room_ID'] );

				// Check if booking is exists
				if ( count( $b = get_booking_by_id( $post['booking_ID'] ) ) > 0 ) {
					$post = array_merge( $post, get_array_values_by_keys( $b, array( 'room_ID', 'room_code', 'room_price', 'no_of_night', 'amount', 'type', 'date_booked' ) );
				}

				if ( $this->process( $post ) ) {
					redirect_js_script( 'admin.php?page=big-dream-bookings&view=list' );
				}

			}

			$post = get_booking_by_id( browser_request( 'bid', 0 ) );
			$editable = in_array( $post['booking_status'], array( 'NEW', 'CONFIRMED' ) );

			$available_rooms = get_available_rooms();
			$booking_statuses = booking_statuses();
			$payment_statuses = payment_statuses();
			$guest_title = salutations();

			include_view( 'edit-booking.html.php' );  
		}


		public function enqueue_styles_and_scripts() {

			wp_enqueue_style( 'fullcalendar.min-style', assets( 'vendor/fullcalendar.min.css' ) );
			wp_enqueue_style( 'fullcalendar.print.min-style', assets( 'vendor/fullcalendar.print.css' ), array(), null, 'print' );
			wp_enqueue_script( 'moment.min-script', assets( 'vendor/moment.min.js' ) );
			wp_enqueue_script( 'fullcalendar.min-script', assets( 'vendor/fullcalendar.min.js' ), array( 'moment.min-script', 'jquery' ), false, false );

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

			$hook = add_submenu_page( 'big-dream-dashboard', 'Bookings', 'Bookings', 'manage_bookings', 'big-dream-bookings', array( &$this, 'bookings' ) );
			add_submenu_page( 'big-dream-booking-edit', 'Edit Booking', 'Edit Booking', 'manage_bookings', 'big-dream-booking-edit', array( &$this, 'add_edit_booking' ) );

			// Add badge notification to menu
			$newitem = get_count_newly_booked();
			$menu[BDR_MENU_POSITION][0] .= $newitem ? "<span class='update-plugins count-1'><span class='update-count'>$newitem</span></span>" : '';

			add_action( "load-$hook", array( &$this, 'add_options' ) );
		}


		public function add_options() {
			
			global $booking_list_table;

			require_class( 'class-booking-list.php' );

			$option = 'per_page';
			
			$args = array( 'label' => 'Bookings', 'default' => DEFAULT_PER_PAGE, 'option' => 'bookings_per_page' );

			add_screen_option( $option, $args );

			$booking_list_table = new Booking_List_Table();
		}


		public function init() {

			if ( browser_request( 'action' ) == 'export-bookings' ) {

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
			}
		}


		public function bookings() {

			if ( browser_get( 'view' ) == 'calendar' ) {
				include_view ( 'bookings-calendar-view.html.php' );

			} else {

				global $booking_list_table;
				
				$booking_list_table->prepare_items();

				include_view ( 'bookings.html.php' );
			}
		}

		public function details() {

			if ( defined('DOING_AJAX') && DOING_AJAX ) {

				$details = get_booking_by_id( browser_get( 'bid' ) );

				$featured_image = featured_image( $details['room_ID'], 'large' );

				include_view( 'booking-details.html.php' );
				exit;
			}
			
		}

		
	}
}



new Booking();

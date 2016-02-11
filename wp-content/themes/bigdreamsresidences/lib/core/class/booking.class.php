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
		    //add_action( 'wp_ajax_nopriv_booking-details', array( &$this, 'details' ) );

		    add_action( 'wp_ajax_edit-rooms-and-guest-info', array( &$this, 'render_edit_rooms_and_guest_info' ) );
		    //add_action( 'wp_ajax_edit-rooms-and-guest-info', array( &$this, 'render_rooms_and_guest_info' ) );

		    add_action( 'wp_ajax_delete-room_and_guest_info', array( &$this, 'delete_rooms_and_guest_info' ) );

		    add_action( 'wp_ajax_get-rooms_and_guest_info', array( &$this, 'render_rooms_and_guest_info' ) );
		    add_action( 'wp_ajax_calculate-total-amount', array( &$this, 'calculate_total_amount' ) );

		    add_action( 'wp_ajax_count-available-rooms', array( &$this, 'count_available_rooms' ) );
        add_action( 'wp_ajax_filter_guest_calendar_date', array(&$this, 'render_ajax_guest_calendar') );
		    add_action( 'wp_ajax_save-rooms_and_guest_info', array( &$this, 'save_rooms_and_guest_info' ) );
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
			    'room_type_ID' => 'required|numeric',
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

			if ( is_date_and_room_not_available( $data['room_type_ID'], $data['date_in'], $data['date_out'], $data['booking_ID']) ) {
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
					$inserted_ID = $data['booking_ID'];
					if ( $inserted_ID < 1 ) {
						$inserted_ID = get_inserted_ID();
						send_success_booking_notification( $inserted_ID );

						
						// Update booking no
						generate_and_update_booking_no( $inserted_ID );
						// replace data in booking session with booking ID
						push_to_booking_session( array( 'booking_ID' => $inserted_ID ) );
						
					}

					add_this_notices( 'updated', 'Successully Saved.' );
					return $inserted_ID;

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
								'no_of_room' => $data['no_of_room'],
								'type' => 'BOOKING',
								'no_of_child' => array_data( $data, 'no_of_child', 0 )
							) 
						);

						redirect_by_page_path( 'rooms-suits' );
						break;

					case 'book_room':

						$data = $_POST;

						if ( array_data( $data, 'room_type_ID', '' ) == '' || ! is_bookable( $data['room_type_ID'] ) ) {

							add_this_notices( 'error', 'Selected room is Out of Order.' );
							return;
						}

						if ( is_date_and_room_not_available( $data['room_type_ID'], format_db_date( $data['date_in'] ),  format_db_date( $data['date_out'] ) ) ) {
							add_this_notices( 'error', 'Selected room is not available on that date. Please check calendar to see availability.' );
							return;
						}

						$nights = count_nights( $data['date_in'], $data['date_out'] );
						$room_price = get_room_price( $data['room_type_ID'], $data['date_in'], $data['date_out'] );

						push_to_booking_session( array(
							'date_in' 		=> $data['date_in'],
							'date_out' 		=> $data['date_out'],
							'no_of_adult' 	=> $data['no_of_adult'],
							'no_of_child' 	=> array_data( $data, 'no_of_child', 0 ),
							'room_type_ID' 		=> $data['room_type_ID'],
							'no_of_night' 	=> $nights,
							'no_of_room' => $data['no_of_room'],
							'room_price' 	=> $room_price,
							'amount' 		=> $room_price * $data['no_of_room'] * $nights, 
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

						if ( ! is_bookable( $data['room_type_ID'] ) ) {
							add_this_notices( 'error', 'Selected room is Out of Order.' );
							return;
						}

						$data = push_to_booking_session( array_merge( $data, $_POST, array( 'date_booked' => date( 'Y-m-d H:i:s' ) ) ) );
						if ( $this->process( $data ) ) {
							redirect_by_page_path( 'success' );
						}
						break;
					case 'save_booking':

						
						if ( isset( $_POST['save_booking_field'] ) && wp_verify_nonce( $_POST['save_booking_field'], 'save_booking_action' ) ) {
							$info = get_booking_by_id( browser_request( 'bid', 0 ) );
							$post = array_merge( (array)$info, $_POST );

							$post['no_of_night'] = count_nights( $post['date_in'], $post['date_out'] );
							$post['room_price'] = get_room_price( $post['room_type_ID'], $post['date_in'], $post['date_out'] );
							$post['amount'] = $post['room_price'] * $post['no_of_room'] * $post['no_of_night'];
							$post['date_booked'] = array_data( $info, 'date_booked' , date( 'Y-m-d H:i:s' ) );
							$post['type'] = 'RESERVATION';
							$post['room_code'] = room_code( $post['room_type_ID'] );

							if ( ( $bid = $this->process( $post ) ) != false ) {
								exit( wp_redirect( 'admin.php?page=edit-booking&bid='.$bid ) );
							}

						}
						break;
					case 'export-bookings':

						$results = get_bookings_for_export();

						// When executed in a browser, this script will prompt for download 
						// of 'test.xls' which can then be opened by Excel or OpenOffice.
						require_class( 'php-export-data.class.php' );
						// 'browser' tells the library to stream the data directly to the browser.
						// other options are 'file' or 'string'
						// 'test.xls' is the filename that the browser will use when attempting to 
						// save the download
						$exporter = new ExportDataExcel( 'browser', 'reports.xls' );

						$exporter->initialize(); // starts streaming data to web browser

						$exporter->addRow(array('BOOKING NO', 'ROOM TYPE', 'ROOM PRICE', 'CHECK IN', 'CHECK OUT', 'NO OF NIGHTS', 'NO OF ROOMS', 'TOTAL AMOUNT', 'AMOUNT PAID', 'NO OF ADULT', 'NO OF CHILD', 'BOOKED BY', 'BIRTHDATE', 'EMAIL ADDRESS', 'PHONE', 'COUNTRY', 'ADDRESS 1', 'ADDRESS 2', 'PROVINCE', 'CITY', 'ZIPCODE', 'NATIONALITY', 'BOOKING STATUS', 'PAYMENT STATUS', 'DATE BOOKED'));
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
					'room_type_ID' => 0,
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
					'no_of_room' => 1,
					'booking_status' => BOOKING_DEFAULT_STATUS,
					'payment_status' => PAYMENT_DEFAULT_STATUS,
					'notes' => '',
					'type' => 'RESERVATION',
					'date_booked' => date('Y-m-d H:i:s'),
					'editable' => $info['booking_status'] != 'CHECKOUT',
					'available_rooms' => get_available_room_types(),
					'booking_statuses' => booking_statuses(),
					'payment_statuses' => payment_statuses(),
					'salutations' => salutations(),
					'rooms_and_guest' => get_rooms_and_guest_info( browser_request( 'bid', 0 ) )

				), (array) $info, (array) $_POST);


			include_view( 'edit-booking.html.php', $post );  
		}


		public function enqueue_styles_and_scripts() {

			global $post_type;

			if ( ( isset( $_GET['page'] ) && in_array( $_GET['page'], array( 'booking-system', 'manage-bookings', 'edit-booking', 'guest-calendar' ) ) ) ||  'room' == $post_type ) {

				if ( isset( $_GET['post'] ) && isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) return;

			   	wp_enqueue_style( 'admin-style', assets( 'style/admin.css' ) );	
			   	wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );

			   //	wp_enqueue_style( 'fullcalendar.min-style', assets( 'vendor/fullcalendar.min.css' ) );
				//wp_enqueue_style( 'fullcalendar.print.min-style', assets( 'vendor/fullcalendar.print.css' ), array(), null, 'print' );
				//wp_enqueue_script( 'moment.min-script', assets( 'vendor/moment.min.js' ) );
				//wp_enqueue_script( 'fullcalendar.min-script', assets( 'vendor/fullcalendar.min.js' ), array( 'moment.min-script', 'jquery' ), false, false );
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
			add_submenu_page( 'booking-system', 'Guest Calendar', 'Guest Calendar', 'manage_bookings', 'guest-calendar', array( &$this, 'render_guest_calendar' ), false );
			$hook = add_submenu_page( 'booking-system', 'Bookings', 'Bookings', 'manage_bookings', 'manage-bookings', array( &$this, 'render_bookings' ) );
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


		


		public function render_bookings() {

			// if ( browser_get( 'view' ) == 'calendar' ) {
			// 	include_view ( 'bookings-calendar-view.html.php' );

			// } else {

				global $booking_list_table;
				$data['rooms'] = get_available_room_types();
				$data['booking_list_table'] = $booking_list_table;
				$data['payment_statuses'] = payment_statuses();

				include_view ( 'bookings.html.php', $data );
			//}
		}

		public function details() {

			if ( defined('DOING_AJAX') && DOING_AJAX ) {

				$details = get_booking_by_id( browser_get( 'bid' ) );

				$details['featured_image'] = featured_image( $details['room_type_ID'], 'large' );

				include_view( 'booking-details.html.php', $details );
				exit;
			}
			
		}


		public function render_rooms_and_guest_info() {
			if ( defined('DOING_AJAX') && DOING_AJAX ) {
				$data = array();

				$data['rooms_and_guest'] = get_rooms_and_guest_info( browser_request( 'booking_ID', 0 ) );

				include_view( 'rooms_and_guest_info.html.php', $data );
				exit;
			}	
		}

		public function render_edit_rooms_and_guest_info() {
			if ( defined('DOING_AJAX') && DOING_AJAX ) {

				$data = array();
				$excludes = array();


				$brid = browser_get( 'brid' );
				$data = get_array_values_by_keys( 
						get_booking_rooms( $brid ), 
						array( 'booking_room_ID', 'booking_ID', 'room_ID', 'guest', 'phone', 'no_of_adult', 'no_of_child', 'date_in', 'date_out' ) 
					);


				$data['booking_ID'] = browser_get( 'booking_ID' );

				$existing_rooms = get_rooms_and_guest_info( $data['booking_ID'], $brid );

				foreach ( $existing_rooms as $i => $r ) {
					$excludes[] = $r['room_ID'];
				}

				$data['room_type_ID'] = browser_get( 'room_type_ID' );

				$data['rooms'] = get_rooms_by_type( $data['room_type_ID'], $excludes );

				include_view( 'edit_rooms_and_guest_info.html.php', $data );
				exit;
			}
		}

		public function save_rooms_and_guest_info() {
			if ( defined('DOING_AJAX') && DOING_AJAX && $_POST ) {

				$data = $_POST;
				if ( is_rooms_exists_on_booking( $data['room_ID'], $data['booking_ID'], $data['booking_room_ID'] ) ) {
					wp_send_json_error( array( 'message' => 'Room already exists' ) );
				} else {

					require_class( 'gump.class.php' );

				    $gump = new GUMP();
				    
				    $data['room_type_ID'] = get_room_type( $data['room_ID'] )->ID;
				    $data = $gump->sanitize( $data );

				    $gump->validation_rules( array(
						'guest' => 'required|min_len,1|max_len,100',
					    'room_ID' => 'required|numeric',
					    'room_type_ID' => 'required|numeric',
					    'no_of_adult' => 'required|numeric',
					    'no_of_child' => 'numeric',
					    'date_in' => 'required|date',
			    		'date_out' => 'required|date',
				    ) );

				    if ( $gump->run( $data ) !== false ) {
				    	if ( do_save_rooms_and_guest_info( $data ) !== false ) {
							wp_send_json_success( array( 'message' => 'Successfully saved.' ) );
						} else {
							wp_send_json_error( array( 'message' => 'Error while saving.' ) );
						}
				    } else {

				    	javacript_notices( $gump->get_key_and_value_errors( true ) );
				    	wp_send_json_error( array( 'js' => print_javascript_notices( false ) ) );
				    }

				    


					
				}
				exit;
			}
		}

		public function delete_rooms_and_guest_info() {
			if ( defined('DOING_AJAX') && DOING_AJAX && $_POST ) {

				$data = $_POST;

				if ( delete_rooms_and_guest_info( $data['booking_room_ID'] ) ) {
					wp_send_json_success( array( 'message' => 'Successfully deleted.' ) );
				} else {
					wp_send_json_error( array( 'message' => 'Error while saving.' ) );
				}
			}
		}

		public function calculate_total_amount() {
			if ( defined('DOING_AJAX') && DOING_AJAX ) {

				$data = $_GET;

				$no_of_night = count_nights( $data['date_in'], $data['date_out'] );
				$room_type_ID = $data['room_type_ID'];

				$room_price = get_room_price( $room_type_ID, $data['date_in'], $data['date_out'] );

				$total = $room_price * $data['no_of_room'] * $no_of_night;
				$output = '';
				$output .= '<ul>';
					$output .= '<li>Room Price: <span class="room_price">'. format_price( $room_price, false ) .'</span></li>';
          			$output .= '<li>Total Room: <span class="total_rooms"> x ' . $data['no_of_room'] .'</span></li>';
          			$output .= '<li>Total Nights: <span class="total_nights"> x ' . $no_of_night .'</span></li>';
          			$output .= '<li>Total Amount: <span class="total_amount">'. format_price( $total, false ) .'</span></li>';
        		$output .= '</ul>';

				wp_send_json_success( array( 'html' => $output) );
			}
		}

		public function count_available_rooms() {
			if ( defined('DOING_AJAX') && DOING_AJAX ) {

				$room_type_ID = browser_get('room_type_ID', 0);

				$rooms = get_rooms_by_type( $room_type_ID );
				// print_me($rooms);

				wp_send_json_success( array( 'total_rooms' => count( $rooms ) ) );
			}
		}
    
    public function render_ajax_guest_calendar () {
      	if ( defined('DOING_AJAX') && DOING_AJAX ) {
       		$selected_date = browser_get('start_date', 7);
			$days_to_display = browser_get('days_to_display', 7);
			$status = browser_get('booking_status', false);

	

			$output = $this->get_guest_calendar_table( $selected_date, $days_to_display, $status );
			exit( $output );
		}
    }

	  public function render_guest_calendar() {
	  		$selected_date = date( 'Y-m-d' );
			$days_to_display = 15;
			$status = false;
	    	
	    	$data = array();
	    	
			$data['selected_date'] = $selected_date;
			$data['days_to_display'] = $days_to_display;
			$data['booking_statuses'] = booking_statuses();
			$data['selected_status'] = $status;
			$data['output'] = $this->get_guest_calendar_table( $selected_date, $days_to_display, $status );


			include_view( 'guest_calendar.html.php', $data );
		}
		
		public function get_guest_calendar_table( $selected_date, $days_to_display, $status ) {

			$start_date = format_date( $selected_date, 'j' );
	      	$end_date = add_days_to_date( $selected_date, $days_to_display );

	      	$calendar = array();
	    	$rooms = get_all_rooms();

	    	foreach ( $rooms as $i => $r ) {
	    		$calendar[get_the_title( $r ).':'.get_room_type( $r )->post_title] = get_guest_calendar_by_room_ID( $r, $selected_date, $end_date, $status );
	    	}



	      	$total_day = count_days_gap( $selected_date, $end_date, $end_date );
	      	$end_date = minus_days_to_date( $end_date, 1 );	

			

      
      
			$monthHTML = $dateHTML = $dayHTML = $tdHTML = $output = '';
      
	      	$date = $selected_date;  
	      	while (strtotime($date) <= strtotime($end_date)) {
	      		$monthHTML .= '<th colspan="'. ( $date != $selected_date && $date != $end_date ? '2' : '' ) .'">'. format_date( $date, 'M' ) .'</th>';
	      		$dateHTML .= '<th colspan="'. ( $date != $selected_date && $date != $end_date ? '2' : '' ) .'">'. format_date( $date, 'j' ) .'</th>';
	      		$dayHTML .= '<th colspan="'. ( $date != $selected_date && $date != $end_date ? '2' : '' ) .'">'. format_date( $date, 'D' ) .'</th>';
	      		$date = add_days_to_date( $date, 1 ); 
	      	}
	      
	      	$date = $selected_date;  
	      
	      	$tdHTML .= '<tr>';
	      	while (strtotime($date) < strtotime($end_date)) {
	      
	      		$tdHTML .= '<td colspan="2" class="'. strtolower( format_date( $date, 'D' ) ) .'"></td>';
	      		$date = add_days_to_date( $date, 1 );
	      	}
	      	$tdHTML .= '</tr>';
	      
	      
	      	$output .= '<table class="widefat">';
	      		$output .= '<thead>';
	      			$output .= '<tr>';
	      				$output .= '<th width="10%"></th>';
	      				$output .= $monthHTML;	
	      			$output .= '</tr>';
	      			$output .= '<tr>';
	      				$output .= '<th width="10%"></th>';
	      				$output .= $dateHTML;
	      			$output .= '</tr>';
	      			$output .= '<tr>';
	      				$output .= '<th width="10%"></th>';
	      				$output .= $dayHTML;
	      			$output .= '</tr>';
	      		$output .= '</thead>';
	      		$output .= '<tbody>';
	      
	      		foreach ( $calendar as $k => $c ) {
	      			usort($c, function($a, $b) {
	      			   return strtotime( $a['from'] ) - strtotime( $b['from'] );
	      			});
	      		
	      			$output .= '<tr>';
	      				$output .= '<td class="room">'. $k .'</td>';
	      				$output .= '<td colspan="'. ( $total_day * 2 - 2 ) .'" class="calendar_row">';
	      					$output .= '<div class="row_data">';
	      						$output .= '<div class="bg_row">';
	      							$output .= '<table>';
	      								$output .= '<tbody>';
	      									$output .= $tdHTML;
	      								$output .= '</tbody>';
	      							$output .= '</table>';
	      						$output .= '</div>';
	      						$output .= '<div class="bg-content">';
	      							$output .= '<table>';
	      								$output .= '<tbody>';
	      
	      										$b = $selected_date;
	      
	      										foreach ( $c as $cal ) {
	      											if ( strtotime( $cal['from'] ) > strtotime( $end_date ) 
	      												|| ( strtotime( $cal['from'] ) < strtotime( $selected_date ) && strtotime( $cal['to'] ) < strtotime( $selected_date ) ) ) continue;
	      											
	      
	      											$cal['from'] = strtotime( $cal['from'] ) < strtotime( $selected_date ) ? $selected_date : $cal['from'];
	      
	      											if ( ( $f =  count_days_gap( $b, $cal['from'], $end_date ) ) > 0 ) {
	      												$output .= '<td colspan="'. $f .'"></td>';
	      												$b = add_days_to_date( $b, $f );
	      											}
	      											$f = count_days_gap( $cal['from'], $cal['to'], $end_date );
	      											$output .= '<td colspan="'. $f .'"><div class="text '. strtolower($cal['status']) .'">'. $cal['guest'] .'</div></td>';
	      											$b = $cal['to'] > $end_date ? $end_date : $cal['to'];
	      										}
	      
	      										if ( strtotime($end_date) > strtotime($b) && ( $f = count_days_gap( $b, $end_date, $end_date )  ) > 0 ) {
	      											$output .= '<td colspan="'. $f .'"></td>';
	      										}
	      
	      								$output .= '</tbody>';
	      							$output .= '</table>';
	      						$output .= '</div>';
	      					$output .= '</div>';
	      				$output .= '</td>';
	      			$output .= '</tr>';
	      		}
	      		$output .= '</tbody>';
	      	$output .= '</table>';
	      
	      	return $output;
	    }

	}
}



new Booking();

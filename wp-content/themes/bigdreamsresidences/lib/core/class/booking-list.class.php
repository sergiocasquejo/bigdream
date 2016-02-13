<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Booking_List_Table extends WP_List_Table {

	var $data = array();

	public function __construct() {

		parent::__construct( 
			array(
				'singular' => __( 'Booking', BDR_TEXT_DOMAIN ),
				'plural'   => __( 'Bookings', BDR_TEXT_DOMAIN ),
				'ajax'     => true
			)
		);

	}

	public function no_items() {
	  _e( 'No bookings found, dude.' );
	}

	public function get_columns() {
		$columns = array();
		//Check if test mode is enabled
		if (TEST_MODE) {
			$columns['cb'] = '<input type="checkbox" />';
		}
		$columns['booking_no'] = 'Booking #';
		$columns['room_title'] = 'Room Type';
		$columns['room_price'] = 'Room Price';
		$columns['no_of_night'] = 'Night';
		$columns['no_of_room'] = 'Room';
		$columns['amount'] = 'Total';
		$columns['amount_paid'] = 'Paid';
		$columns['date_in'] = 'Date In';
		$columns['date_out'] = 'Date Out';
		$columns['no_of_adult'] = 'Adult';
		$columns['no_of_child'] = 'Child';
		$columns['booking_status'] = 'Booking Status';
		$columns['payment_status'] = 'Payment Status';
		$columns['guest_name'] = 'Booked By';
		$columns['date_booked'] = 'Date Booked';

		return $columns;
	}

	public function get_sortable_columns() {
		$sortable_columns = array(
			'no_of_night'  	=> array( 'no_of_night',false ),
			'no_of_room'  	=> array( 'no_of_room',false ),
			'no_of_adult'  	=> array( 'no_of_adult',false ),
			'no_of_child'  	=> array( 'no_of_child',false ),
			'guest_name' 	=> array( 'guest_name',false ),
			'amount'   		=> array( 'amount',false ),
			'amount_paid'   => array( 'amount',false ),
			'date_in'   	=> array( 'date_in',false ),
			'date_out'   	=> array( 'date_out',false ),
			'booking_status'   => array( 'booking_status',false ),
			'payment_status'   => array( 'payment_status',false ),
			'date_booked'   => array( 'date_booked',false ),
		);
		return $sortable_columns;
	}

	public function column_cb( $item ) {
		return sprintf( '<input type="checkbox" name="bid[]" value="%s" />', $item['booking_ID'] ); 
	}

	public function get_bulk_actions() {
		//Check if test mode is enabled
		if ( !TEST_MODE ) return;

        return array( 'delete' => __( 'Delete', BDR_TEXT_DOMAIN ) );

    }

	public function column_room_title( $item ) {
		$room_title = sprintf( '<a href="#">%s</a>', $item['room_title'] );

  		return $room_title;
	}
	public function column_booking_no( $item ) {
		$booking_no = sprintf( '<span class="badge">%s</span>', $item['booking_no'] );

		$actions  = array(
			'edit' => sprintf( '<a href="?page=%s&bid=%s">Edit</a>','edit-booking', $item['booking_ID'] ),
			'view' => sprintf( '<a href="#" class="view-booking-details" data-id="%d">View</a>', $item['booking_ID'] )
		);


		return sprintf( '%1$s %2$s', $booking_no, $this->row_actions( $actions ) );


	}


	public function column_booking_status( $item ) {
		$output = sprintf( '<span class="badge %s">%s</span>', sanitize_title_with_dashes( $item['booking_status'] ), $item['booking_status'] );
		return $output;
	}

	public function column_payment_status( $item ) {
		$output = sprintf( '<span class="badge %s">%s</span>', sanitize_title_with_dashes( $item['payment_status'] ), $item['payment_status'] );
		return $output;
	}

	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'date_in':
			case 'date_out':
				return format_date( $item[$column_name], 'D M j, Y' );
			case 'date_booked':
				return format_date( $item[$column_name], 'D M j, Y H:i' );
			case 'room_price':
			case 'amount':
			case 'amount_paid':
				return sprintf('<span class="amount">%s</span>', nf( $item[$column_name] ));
			default:
				return $item[$column_name];
		}
	}


	public function usort_reorder( $a, $b ) {
		// If no sort, default to title
		$orderby = browser_get( 'orderby', 'date_booked' );
		// If no order, default to asc
		$order = browser_get( 'order', 'asc' );
		// Determine sort order
		$result = strcmp( $a[$orderby], $b[$orderby] );
		// Send final sort direction to usort
		return ( $order === 'asc' ) ?  -$result : $result;
	}

	public function prepare_items() {
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );

		$this->process_bulk_action();

		$this->data = get_filtered_bookings();

		usort( $this->data, array( &$this, 'usort_reorder' ) );

		$per_page = $this->get_items_per_page( 'bookings_per_page', DEFAULT_PER_PAGE );
		
		$current_page = $this->get_pagenum();

		$total_items = count( $this->data);

		// only ncessary because we have sample data
		$this->data = array_slice( $this->data, ( ( $current_page-1 ) * $per_page ), $per_page );

		$this->set_pagination_args( array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page'    => $per_page                     //WE have to determine how many items to show on a page
			) );


		$this->items = $this->data;

	}

	public function get_views(){
		$views = array();

		$current = browser_request( 'status', 'all' );
		$statuses = booking_statuses();
		//All link
		$class = ( $current == 'all' ? ' class="current"' :'' );
		$all_url = remove_query_arg( 'status' );
		$views['all'] = "<a href='{$all_url }' {$class} >All</a>";

		foreach ( $statuses as $s) {
			$slug = sanitize_title_with_dashes( $s);
			$url = add_query_arg( 'status', $s);
			$class = ( $current == $slug ? ' class="current"' :'' );
			$views[$slug] = '<a href="'. $url .'" '. $class .' >'. $s .'</a>';
		}

		return $views;
	}

	public function process_bulk_action() {

        // security check!
        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];

            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( 'Nope! Security check failed!' );

        }

        $action = $this->current_action();

        switch ( $action ) {

            case 'delete':
            	// Check if test mode is enabled
            	if ( TEST_MODE ) {
            		$booking_IDs = isset( $_POST['bid'] ) ? $_POST['bid'] : 0;

            		if ( $booking_IDs != 0 ) {
            			global $wpdb;
            			try {
            				$wpdb->query( 'START TRANSACTION' );
			            	$sql = "DELETE xFROM ". $wpdb->prefix . "bookings WHERE booking_ID IN (". implode( ',', $booking_IDs ) .")";
			            	$wpdb->query( $sql);

			            	$sql = "DELETE FROM ". $wpdb->prefix . "guest_calendar WHERE booking_ID IN (". implode( ',', $booking_IDs ) .")";
			            	$wpdb->query( $sql);

			            	$wpdb->query( 'COMMIT' );

		            	} catch (Exception $e) {
		            		$wpdb->query( 'ROLLBACK' );
		            	}
	            	}
            	}
                break;
            default:
                return;
                break;
        }

        return;
    }
}


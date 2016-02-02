<?php
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Booking_List_TBL extends WP_List_Table {
	/** Class constructor */

	var $data = array();

	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Booking', BDR_TEXT_DOMAIN ), //singular name of the listed records
			'plural'   => __( 'Bookings', BDR_TEXT_DOMAIN ), //plural name of the listed records
			'ajax'     => true //should this table support ajax?
		] );

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
		$columns['room'] = 'Room #';
		$columns['amount'] = 'Amount';
		$columns['amount_paid'] = 'Amount Paid';
		$columns['date_in'] = 'Date In';
		$columns['date_out'] = 'Date Out';
		$columns['booking_status'] = 'Status';
		$columns['name'] = 'Booked By';
		$columns['date_booked'] = 'Date Booked';

		return $columns;
	}

	public function get_sortable_columns() {
		$sortable_columns = array(
			'room'  => array('room',false),
			'name' => array('name',false),
			'amount'   => array('amount',false),
			'amount_paid'   => array('amount',false),
			'date_in'   => array('date_in',false),
			'date_out'   => array('date_out',false),
			'booking_status'   => array('booking_status',false),
			'date_booked'   => array('date_booked',false),
		);
		return $sortable_columns;
	}

	public function column_cb($item) {
		return sprintf(
            '<input type="checkbox" name="bid[]" value="%s" />', $item['booking_ID']
        ); 
	}

	public function get_bulk_actions() {
		//Check if test mode is enabled
		if (!TEST_MODE) return;
        return array(
                'delete' => __( 'Delete', BDR_TEXT_DOMAIN ),
        );

    }

	public function column_room($item) {
		$room_title = sprintf('<a href="#">%s</a>', get_field('room_code', $item['room_ID']));
		$actions['edit'] = sprintf('<a href="?page=%s&bid=%s">Edit</a>',BigDream_Booking::NEW_BOOKING_SLUG, $item['booking_ID']);
        $actions['view'] = sprintf('<a href="?page=%s&bid=%d" class="view-booking-details" data-id="%d">View</a>',BigDream_Booking::VIEW_BOOKING_SLUG, $item['booking_ID'], $item['booking_ID']);

  		return sprintf('%1$s %2$s', $room_title, $this->row_actions($actions) );
	}
	public function column_booking_no($item) {
		return sprintf('<span class="badge">%s</span>', $item['booking_no']);
	}
	public function column_name($item) {
		return $item['name'];
	}

	public function column_booking_status($item) {

		$output = sprintf('<span class="badge %s">%s</span>', sanitize_title_with_dashes($item['booking_status']), $item['booking_status']);

		return $output;

	}

	public function column_default($item, $column_name) {
		switch ($column_name) {
			case 'date_in':
			case 'date_out':
				return date('M j, Y', strtotime($item[$column_name]));
			case 'date_booked':
				return date('M j, Y H:i', strtotime($item[$column_name]));
			case 'amount':
			case 'amount_paid':
				return nf($item[$column_name]);
			case 'name':
				return $item[$column_name];
			default:
				return $item[$column_name];
		}
	}


	public function usort_reorder( $a, $b ) {
		// If no sort, default to title
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'date_booked';
		// If no order, default to asc
		$order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
		// Determine sort order
		$result = strcmp( $a[$orderby], $b[$orderby] );
		// Send final sort direction to usort
		return ( $order === 'asc' ) ?  -$result : $result;
	}

	public function prepare_items() {
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);

		$this->process_bulk_action();

		$this->data = $this->get_bookings();

		usort( $this->data, array( &$this, 'usort_reorder' ) );

		$per_page = $this->get_items_per_page('bookings_per_page', 20);
		$current_page = $this->get_pagenum();
		$total_items = count($this->data);

		// only ncessary because we have sample data
		$this->data = array_slice($this->data,(($current_page-1)*$per_page),$per_page);

		$this->set_pagination_args( array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page'    => $per_page                     //WE have to determine how many items to show on a page
			) );


		$this->items = $this->data;

	}

	public function get_views(){
		$views = array();
		$current = ( !empty($_REQUEST['status']) ? $_REQUEST['status'] : 'all');

		$statuses = booking_statuses();
		//All link
		$class = ($current == 'all' ? ' class="current"' :'');
		$all_url = remove_query_arg('status');
		$views['all'] = "<a href='{$all_url }' {$class} >All</a>";

		foreach ($statuses as $s) {
			$slug = sanitize_title_with_dashes($s);
			$url = add_query_arg('status', $s);
			$class = ($current == $slug ? ' class="current"' :'');
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
            	if (TEST_MODE) {
	            	global $wpdb;
	            	$sql = "DELETE FROM ". $wpdb->prefix . "bookings WHERE booking_ID IN (". implode(',', $_POST['bid']) .")";
	            	$wpdb->query($sql);
            	}
                break;
            default:
                // do nothing or something else
                return;
                break;
        }

        return;
    }


	public function get_bookings() {
		global $wpdb;
		
		$sql = "
		SELECT 
			
			p.post_title as room, 
			b.*,
			CONCAT(b.first_name,' ', b.middle_name, ' ', b.last_name) as name
		FROM 
			". $wpdb->prefix . "bookings b  
		JOIN ". $wpdb->prefix ."posts p 
			ON p.ID = b.room_ID 
		WHERE 1 = 1";

		if (isset($_POST['s']) && !empty($_POST['s'])) {
			$sql .= " AND ( p.post_title LIKE '%". $_POST['s'] ."%' OR b.first_name LIKE '%". $_POST['s'] ."%' OR b.last_name LIKE '%". $_POST['s'] ."%') ";
		}
		if (isset($_REQUEST['status']) && !empty($_REQUEST['status'])) {
			$sql .= " AND (b.booking_status = '". $_REQUEST['status'] ."') ";
		}

		$results = $wpdb->get_results($sql, ARRAY_A);

		return $results;
	}
}


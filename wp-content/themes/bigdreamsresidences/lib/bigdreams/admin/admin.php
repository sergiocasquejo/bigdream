<?php 
if (!class_exists('Big_Dream')) {
	class Big_Dream {
		public function __construct() {
			add_action( 'admin_menu', array($this, 'admin_menu') );
			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts') );
			//Adds the simple role
			add_action('init', array($this, 'add_capability'));
			$this->includes();
		}
		public function add_capability() {
			$administrator     = get_role('administrator');
			$administrator->add_cap( 'publish_rooms' );
			$administrator->add_cap( 'edit_rooms' );
			$administrator->add_cap( 'edit_others_rooms' );
			$administrator->add_cap( 'read_private_rooms' );
			$administrator->add_cap( 'edit_room' );
			$administrator->add_cap( 'delete_room' );
			$administrator->add_cap( 'read_room' );
			$administrator->add_cap( 'manage_bookings' );


		    add_role( 'booking_manager', 'Booking Manager', array(
		            'read' => true,
		            'edit_posts' => false,
		            'edit_rooms' => true,
		            'edit_others_rooms' => true,
		            'publish_rooms' => true,
		            'edit_rooms' => true,
		            'edit_others_rooms' => true,
		            'read_private_rooms' => true,
		            'edit_room' => true,
		            'read_room' 	=> true,
		            'upload_files' => true,
		            'manage_bookings' => true
		            ) );
		}
		

		public function includes() {
			include_once "includes/post_type.php";
			include_once "includes/booking.php";
			include_once "class/class-booking-list.php";
			include_once "class/class-validation.php";
		}

		public function admin_menu() {
			global $menu;
			add_menu_page( 'Big Dream System', 'BDR System', 'manage_bookings', 'big-dream-dashboard', array($this, 'dashboard'), 'dashicons-calendar-alt', BDR_MENU_POSITION );		
			add_submenu_page( 'big-dream-dashboard', 'Rooms', 'Rooms', 'manage_bookings', 'edit.php?post_type=room', false );
		}

		public function enqueue_scripts() {
		   wp_enqueue_style('admin-style', CDR_SYSTEM_DIR_URI . '/assets/style/admin.css');	
			 wp_enqueue_script( 'chart-script', CDR_SYSTEM_DIR_URI . '/assets/vendor/chart.min.js', array('jquery'), true, false );
			 wp_enqueue_script('admin-script', CDR_SYSTEM_DIR_URI . '/assets/js/admin.js', array('chart-script', 'jquery'), true, true);
			 wp_localize_script('admin-script', 'BDR', array(
			 	'AjaxUrl' => admin_url('admin-ajax.php'),
			 	'bookings' => get_booking_calendar()
			 ));

		}

		public function dashboard() {
			include_once "views/dashboard.html.php";
		}
		
	}
}

new Big_Dream();

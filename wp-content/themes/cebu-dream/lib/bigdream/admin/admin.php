<?php 
if (!class_exists('Big_Dream')) {
	class Big_Dream {
		public function __construct() {
			add_action( 'admin_menu', array($this, 'admin_menu') );
			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts') );
			$this->includes();
		}


		public function includes() {
			include_once "includes/post_type.php";
			include_once "includes/booking.php";
			include_once "class/class-booking-list.php";
			include_once "class/class-validation.php";
		}

		public function admin_menu() {
			global $menu;
			add_menu_page( 'Big Dream System', 'BDR System', 'manage_options', 'big-dream-dashboard', array($this, 'dashboard'), 'dashicons-calendar-alt', BDR_MENU_POSITION );		
			add_submenu_page( 'big-dream-dashboard', 'Rooms', 'Rooms', 'manage_options', 'edit.php?post_type=room', false );
		}

		public function enqueue_scripts() {
			 wp_enqueue_script( 'chart-script', CDR_SYSTEM_DIR_URI . '/assets/js/chart.min.js', array('jquery'), true, false );
		}

		public function dashboard() {
			include_once "views/dashboard.html.php";
		}
		
	}
}

new Big_Dream();

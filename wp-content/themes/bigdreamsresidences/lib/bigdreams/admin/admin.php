<?php 
if (!class_exists('Big_Dream')) {
	class Big_Dream {
		public function __construct() {
			

			add_action( 'admin_menu', array($this, 'admin_menu') );
			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts') );
			
		
			add_filter( 'manage_room_posts_columns', array($this, 'set_custom_edit_book_columns') );
			add_action( 'manage_room_posts_custom_column' , array($this, 'custom_book_column'), 10, 2 );
			//Adds the simple role
			add_action('init', array($this, 'add_capability'));
			add_action('init', array($this, 'register_post_type'));
			add_action('init', array($this, 'register_taxonomies'));

			$this->includes();
		}

		public function register_taxonomies() {
			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => _x( 'Categories', 'taxonomy general name' ),
				'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
				'search_items'      => __( 'Search Categories' ),
				'all_items'         => __( 'All Categories' ),
				'parent_item'       => __( 'Parent Category' ),
				'parent_item_colon' => __( 'Parent Category:' ),
				'edit_item'         => __( 'Edit Category' ),
				'update_item'       => __( 'Update Category' ),
				'add_new_item'      => __( 'Add New Category' ),
				'new_item_name'     => __( 'New Category Name' ),
				'menu_name'         => __( 'Category' ),
			);

			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'galleria-cat' ),
			);

			register_taxonomy( 'galleria-cat', array( 'galleria' ), $args );
		}

		public function set_custom_edit_book_columns($columns) {
		    unset( $columns['author'] );
		    unset( $columns['date'] );
		    $columns['room_price'] = __( 'Room Price', 'bigdream' );
		    $columns['room_status'] = __( 'Room Status', 'bigdream' );


		    return $columns;
		}


		public function custom_book_column( $column, $post_id ) {
		    switch ( $column ) {

		        case 'room_status' :
		        	$status = get_field('room_status', $post_id);
					echo sprintf('<span class="badge %s">%s</span>', sanitize_title_with_dashes($status), $status);
		            break;
		        case 'room_price':
		        	echo nf(get_field('price', $post_id));
		        	break;
		    }
		}


		public function register_post_type() {
			$labels = array(
				'name'               => _x( 'Rooms', 'post type general name', BDR_TEXT_DOMAIN ),
				'singular_name'      => _x( 'Room', 'post type singular name', BDR_TEXT_DOMAIN ),
				'menu_name'          => _x( 'Rooms', 'admin menu', BDR_TEXT_DOMAIN ),
				'name_admin_bar'     => _x( 'Room', 'add new on admin bar', BDR_TEXT_DOMAIN ),
				'add_new'            => _x( 'Add New', 'room', BDR_TEXT_DOMAIN ),
				'add_new_item'       => __( 'Add New Room', BDR_TEXT_DOMAIN ),
				'new_item'           => __( 'New Room', BDR_TEXT_DOMAIN ),
				'edit_item'          => __( 'Edit Room', BDR_TEXT_DOMAIN ),
				'view_item'          => __( 'View Room', BDR_TEXT_DOMAIN ),
				'all_items'          => __( 'All Rooms', BDR_TEXT_DOMAIN ),
				'search_items'       => __( 'Search Rooms', BDR_TEXT_DOMAIN ),
				'parent_item_colon'  => __( 'Parent Rooms:', BDR_TEXT_DOMAIN ),
				'not_found'          => __( 'No rooms found.', BDR_TEXT_DOMAIN ),
				'not_found_in_trash' => __( 'No rooms found in Trash.', BDR_TEXT_DOMAIN )
			);

			$args = array(
				'labels'             => $labels,
		        'description'        => __( 'Description.', BDR_TEXT_DOMAIN ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => false,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'room' ),
				'capability_type' => 'room',
				'capabilities' => array(
					'publish_posts' => 'publish_rooms',
					'edit_posts' => 'edit_rooms',
					'edit_others_posts' => 'edit_others_rooms',
					'read_private_posts' => 'read_private_rooms',
					'edit_post' => 'edit_room',
					'delete_posts' => 'delete_rooms',
					'delete_post' => 'delete_room',
					'read_post' => 'read_room',
				),
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'menu_icon'			 => 'dashicons-admin-multisite',
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
			);

			register_post_type( 'room', $args );

			$labels = array(
				'name'               => _x( 'Gallery', 'post type general name', BDR_TEXT_DOMAIN ),
				'singular_name'      => _x( 'Gallery', 'post type singular name', BDR_TEXT_DOMAIN ),
				'menu_name'          => _x( 'Gallery', 'admin menu', BDR_TEXT_DOMAIN ),
				'name_admin_bar'     => _x( 'Gallery', 'add new on admin bar', BDR_TEXT_DOMAIN ),
				'add_new'            => _x( 'Add New', 'gallery', BDR_TEXT_DOMAIN ),
				'add_new_item'       => __( 'Add New Gallery', BDR_TEXT_DOMAIN ),
				'new_item'           => __( 'New Gallery', BDR_TEXT_DOMAIN ),
				'edit_item'          => __( 'Edit Gallery', BDR_TEXT_DOMAIN ),
				'view_item'          => __( 'View Gallery', BDR_TEXT_DOMAIN ),
				'all_items'          => __( 'All Gallery', BDR_TEXT_DOMAIN ),
				'search_items'       => __( 'Search Gallery', BDR_TEXT_DOMAIN ),
				'parent_item_colon'  => __( 'Parent Gallery:', BDR_TEXT_DOMAIN ),
				'not_found'          => __( 'No gallery found.', BDR_TEXT_DOMAIN ),
				'not_found_in_trash' => __( 'No gallery found in Trash.', BDR_TEXT_DOMAIN )
			);

			$args = array(
				'labels'             => $labels,
		        'description'        => __( 'Description.', BDR_TEXT_DOMAIN ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'galleria' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'menu_icon'			 => 'dashicons-format-gallery',
				'supports'           => array( 'title', 'thumbnail' )
			);

			register_post_type( 'galleria', $args );
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
			//include_once "includes/post_type.php";
			include_once "includes/booking.php";
			include_once "includes/class-booking-list.php";
		}

		public function admin_menu() {
			global $menu;
			add_menu_page( 'Big Dream System', 'BDR System', 'manage_bookings', 'big-dream-dashboard', array($this, 'dashboard'), 'dashicons-calendar-alt', BDR_MENU_POSITION );		
			add_submenu_page( 'big-dream-dashboard', 'Rooms', 'Rooms', 'manage_bookings', 'edit.php?post_type=room', false );
		}

		public function enqueue_scripts() {
			global $post_type;
			if ( (isset($_GET['page']) && in_array($_GET['page'], array('big-dream-dashboard', 'big-dream-bookings', 'big-dream-booking-edit'))) ||  'room' == $post_type) {
			   	wp_enqueue_style('admin-style', BDR_SYSTEM_DIR_URI . '/assets/style/admin.css');	
				
			   	wp_enqueue_script('jquery-ui-datepicker');
				wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

				wp_enqueue_script( 'chart-script', BDR_SYSTEM_DIR_URI . '/assets/vendor/Chart.min.js', array('jquery'), true, false );
				wp_enqueue_script('admin-script', BDR_SYSTEM_DIR_URI . '/assets/js/admin.js', array('chart-script', 'jquery'), true, true);
				wp_localize_script('admin-script', 'BDR', array(
					'AjaxUrl' => admin_url('admin-ajax.php'),
					'bookings' => get_booking_calendar()
				));
			}

		}

		public function dashboard() {
			include_once "views/dashboard.html.php";
		}
		
	}
}

new Big_Dream();

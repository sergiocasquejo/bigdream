<?php


/**
 * admin_set_custom_edit_room_columns()
 * 
 * Add custom column to room table list
 * 
 * @param none
 * @return none
 */


function admin_set_custom_edit_room_type_columns( $columns ) {
	unset( $columns['author'] );
    unset( $columns['date'] );
    $columns['room_price'] = __( 'Room Price', BDR_TEXT_DOMAIN );
   // $columns['room_status'] = __( 'Room Status', BDR_TEXT_DOMAIN );


    return $columns;
}
add_filter( 'manage_room_type_posts_columns', 'admin_set_custom_edit_room_type_columns' );

/**
 * admin_custom_room_column()
 * 
 * Display custom column data
 * 
 * @param none
 * @return none
 */

function admin_custom_room_type_column( $column, $post_id ) {
    switch ( $column ) {

	    case 'room_status' :
	    	$status = get_field( 'room_status', $post_id);
			echo sprintf( '<span class="badge %s">%s</span>', sanitize_title_with_dashes( $status ), $status );
	        break;
	    case 'room_price':
	    	echo nf(get_field( 'price', $post_id));
	    	break;
	}
}
add_action( 'manage_room_type_posts_custom_column' , 'admin_custom_room_type_column', 10, 2 );



function admin_set_custom_edit_room_columns( $columns ) {
	unset( $columns['author'] );
    unset( $columns['date'] );
   	$columns['room_type'] = __( 'Room Type', BDR_TEXT_DOMAIN );
   //	$columns['room_status'] = __( 'Room Status', BDR_TEXT_DOMAIN );


    return $columns;
}
add_filter( 'manage_room_posts_columns', 'admin_set_custom_edit_room_columns' );

/**
 * admin_custom_room_column()
 * 
 * Display custom column data
 * 
 * @param none
 * @return none
 */

function admin_custom_room_column( $column, $post_id ) {
    switch ( $column ) {

	    case 'room_status' :
	    	$status = get_field( 'room_status', $post_id);
			echo sprintf( '<span class="badge %s">%s</span>', sanitize_title_with_dashes( $status ), $status );
	        break;
	    case 'room_type' :
			echo get_room_type( $post_id)->post_title;
	        break;
	    case 'room_price':
	    	echo nf(get_field( 'price', $post_id));
	    	break;
	}
}
add_action( 'manage_room_posts_custom_column' , 'admin_custom_room_column', 10, 2 );
/**
 * admin_custom_init()
 * 
 * Custom admin init function
 * 
 * @param none
 * @return none
 */

function admin_custom_init() {

	$labels = array(
		'name'               => _x( 'Rooms', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Room', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Rooms', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Room', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'Room', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Room', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Room', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Room', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Room', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Rooms', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Rooms', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Rooms:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Rooms found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Rooms found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'room' ),
		'capability_type' => 'room_type',
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
		'menu_icon'			=> 'dashicons-store',
		'supports'           => array( 'title' ) //, 'editor', 'author', 'thumbnail', 'excerpt', 'comments' 
	);

	register_post_type( 'room', $args );


	// Register custom room post type
	$labels = array(
		'name'               => _x( 'Room Types', 'post type general name', BDR_TEXT_DOMAIN ),
		'singular_name'      => _x( 'Room Type', 'post type singular name', BDR_TEXT_DOMAIN ),
		'menu_name'          => _x( 'Room Types', 'admin menu', BDR_TEXT_DOMAIN ),
		'name_admin_bar'     => _x( 'Room Type', 'add new on admin bar', BDR_TEXT_DOMAIN ),
		'add_new'            => _x( 'Add New', 'room', BDR_TEXT_DOMAIN ),
		'add_new_item'       => __( 'Add New Room Type', BDR_TEXT_DOMAIN ),
		'new_item'           => __( 'New Room Type', BDR_TEXT_DOMAIN ),
		'edit_item'          => __( 'Edit Room Type', BDR_TEXT_DOMAIN ),
		'view_item'          => __( 'View Room Type', BDR_TEXT_DOMAIN ),
		'all_items'          => __( 'All Room Types', BDR_TEXT_DOMAIN ),
		'search_items'       => __( 'Search Room Types', BDR_TEXT_DOMAIN ),
		'parent_item_colon'  => __( 'Parent Room Types:', BDR_TEXT_DOMAIN ),
		'not_found'          => __( 'No room types found.', BDR_TEXT_DOMAIN ),
		'not_found_in_trash' => __( 'No room types found in Trash.', BDR_TEXT_DOMAIN )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', BDR_TEXT_DOMAIN ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'room' ),
		'capability_type' => 'room_type',
		'capabilities' => array(
			'publish_posts' => 'publish_room_types',
			'edit_posts' => 'edit_room_types',
			'edit_others_posts' => 'edit_others_room_types',
			'read_private_posts' => 'read_private_room_types',
			'edit_post' => 'edit_room_type',
			'delete_posts' => 'delete_room_types',
			'delete_post' => 'delete_room_type',
			'read_post' => 'read_room_type',
		),
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-admin-multisite',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
	);

	register_post_type( 'room_type', $args );

	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Room Type Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Room Type', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Room Types' ),
		'all_items'         => __( 'All Room Types' ),
		'parent_item'       => __( 'Parent Room Type' ),
		'parent_item_colon' => __( 'Parent Room Type:' ),
		'edit_item'         => __( 'Edit Room Type' ),
		'update_item'       => __( 'Update Room Type' ),
		'add_new_item'      => __( 'Add New Room Type' ),
		'new_item_name'     => __( 'New Room Type Name' ),
		'menu_name'         => __( 'Categories' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'room-cat' ),
	);

	//register_taxonomy( 'room_type-cat', array( 'room_type' ), $args );


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



	// Add new taxonomy, make it hierarchical (like categories )
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




	// Add custom role
	$administrator = get_role( 'administrator' );
	$administrator->add_cap( 'publish_room_types' );
	$administrator->add_cap( 'edit_room_types' );
	$administrator->add_cap( 'edit_others_room_types' );
	$administrator->add_cap( 'read_private_room_types' );
	$administrator->add_cap( 'edit_room_type' );
	$administrator->add_cap( 'delete_room_type' );
	$administrator->add_cap( 'read_room_type' );

	$administrator->add_cap( 'edit_rooms' );
	$administrator->add_cap( 'edit_others_rooms' );
	$administrator->add_cap( 'publish_rooms' );
	$administrator->add_cap( 'edit_rooms' );
	$administrator->add_cap( 'edit_others_rooms' );
	$administrator->add_cap( 'read_private_rooms' );
	$administrator->add_cap( 'edit_room' );
	$administrator->add_cap( 'read_room' );

	$administrator->add_cap( 'manage_bookings' );

	// Add custom capabilitity to booking manager
    add_role( 'booking_manager', 'Booking Manager', array(
        'read' => true,
        'edit_posts' => false,
        'edit_room_types' => true,
        'edit_others_room_types' => true,
        'publish_room_types' => true,
        'edit_room_types' => true,
        'edit_others_room_types' => true,
        'read_private_room_types' => true,
        'edit_room_type' => true,
        'read_room_type' 	=> true,
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

add_action( 'init', 'admin_custom_init' );




add_filter('post_row_actions','room_action_row', 10, 2);

function room_action_row($actions, $post){
    //check for your post type
    if ($post->post_type =="room"){
        $actions['in_google'] = '<a href='.admin_url('admin.php?page=manage-bookings&filter_room_ID='. $post->ID).'">View Bookings</a>';
    }
    return $actions;
}
<?php 

add_action('init', 'dream_post_type_handler');

if (!function_exists('dream_post_type_handler')) {
	function dream_post_type_handler() {
		$labels = array(
			'name'               => _x( 'Rooms', 'post type general name', 'cebudream' ),
			'singular_name'      => _x( 'Room', 'post type singular name', 'cebudream' ),
			'menu_name'          => _x( 'Rooms', 'admin menu', 'cebudream' ),
			'name_admin_bar'     => _x( 'Room', 'add new on admin bar', 'cebudream' ),
			'add_new'            => _x( 'Add New', 'room', 'cebudream' ),
			'add_new_item'       => __( 'Add New Room', 'cebudream' ),
			'new_item'           => __( 'New Room', 'cebudream' ),
			'edit_item'          => __( 'Edit Room', 'cebudream' ),
			'view_item'          => __( 'View Room', 'cebudream' ),
			'all_items'          => __( 'All Rooms', 'cebudream' ),
			'search_items'       => __( 'Search Rooms', 'cebudream' ),
			'parent_item_colon'  => __( 'Parent Rooms:', 'cebudream' ),
			'not_found'          => __( 'No rooms found.', 'cebudream' ),
			'not_found_in_trash' => __( 'No rooms found in Trash.', 'cebudream' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Description.', 'cebudream' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'room' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'			 => 'dashicons-admin-multisite',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
		);

		register_post_type( 'room', $args );
	}
}
<?php 

add_action('init', 'dream_post_type_handler');

if (!function_exists('dream_post_type_handler')) {
	function dream_post_type_handler() {
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
			'capability_type'    => 'post',
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
}


add_filter( 'manage_room_posts_columns', 'set_custom_edit_book_columns' );
add_action( 'manage_room_posts_custom_column' , 'custom_book_column', 10, 2 );

function set_custom_edit_book_columns($columns) {
    unset( $columns['author'] );
    unset( $columns['date'] );
    $columns['room_price'] = __( 'Room Price', 'bigdream' );
    $columns['room_status'] = __( 'Room Status', 'bigdream' );


    return $columns;
}


function badge_room_status($status) {
	$badge = '<span class="badge %s">%s</span>';
	switch($status) {
		case 'vacant_dirty':
			$badge = sprintf($badge, $status, 'Vacant Dirty');
			break;
		case 'out_of_order':
			$badge = sprintf($badge, $status, 'Out of Order');
			break;
		case 'vacant_clean':
		default:
			$badge = sprintf($badge, $status, 'Vacant Clean');
	}

	echo $badge;
}
function custom_book_column( $column, $post_id ) {
    switch ( $column ) {

        case 'room_status' :
            badge_room_status(get_field('room_status', $post_id));
            break;
        case 'room_price':
        	echo nf(get_field('price', $post_id));
        	break;
    }
}


add_action('init', 'register_bdr_taxonomies');
function register_bdr_taxonomies() {
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

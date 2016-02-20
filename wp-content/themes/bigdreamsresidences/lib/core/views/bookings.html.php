<div class="wrap">
	<h1>Bookings 
		<a href="<?php echo admin_url('/admin.php?page=edit-booking'); ?>" class="page-title-action button button-secondary">Add Manually</a>
		<a href="<?php echo admin_url('/admin.php?page=manage-bookings&action=export-bookings' . get_query_string_for_export()); ?>" class="page-title-action button button-primary">Export to Excel</a>
	</h1>
	<?php  
	 	do_action( 'print_custom_notices', true );
		$booking_list_table->prepare_items();

		$booking_list_table->views(); ?>


	<form method="post">
	  <input type="hidden" name="page" value="cebu-dream-booking" />
	  <?php $booking_list_table->search_box('search', 'search_id'); ?>
	</form>
	
	<form method="post">
		<p class="search-box">
			<select name="filter_room_ID">
				<option value="">Room Type</option>
				<?php foreach ( $rooms as $room ): ?>
					<option value="<?php echo $room->ID; ?>" <?php selected( $room->ID, browser_request( 'filter_room_ID' ) ) ;?>><?php echo $room->post_title; ?></option>
				<?php endforeach; ?>
			</select>
			<select name="filter_payment_status">
				<option value="">Payment Status</option>
				<?php foreach ( $payment_statuses as $s ): ?>
					<option value="<?php echo $s; ?>" <?php selected( $s, browser_request( 'filter_payment_status' ) ) ;?>><?php echo $s; ?></option>
				<?php endforeach; ?>
			</select>
			<input type="text" name="filter_date_in" id="filter_date_in" value="<?php echo browser_request( 'filter_date_in' ) ;?>" placeholder="Check In"/>
			<input type="text" name="filter_date_out" id="filter_date_out" value="<?php echo browser_request( 'filter_date_out' ) ;?>" placeholder="Check Out"/>
			<input type="submit" id="filter" class="button" value="Filter">
			<a href="<?php echo admin_url('/admin.php?page=manage-bookings'); ?>" class="button">Reset</a>
		</p>
	  	<input type="hidden" name="page" value="cebu-dream-booking" />
	</form>

	<form method="POST">
		<?php $booking_list_table->display(); ?>
	</form>
</div>

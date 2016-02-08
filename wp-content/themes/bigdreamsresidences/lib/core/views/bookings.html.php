<div class="wrap">
	<h1>Bookings 
		<a href="<?php echo admin_url('/admin.php?page=edit-booking'); ?>" class="page-title-action">Add Manually</a>
		<a href="<?php echo admin_url('/admin.php?page=manage-bookings&action=export-bookings'); ?>" class="page-title-action">Export to Excel</a>
	</h1>
	<?php 
		site_notices(); 
		$booking_list_table->prepare_items();

		$booking_list_table->views(); ?>


	<form method="post">
	  <input type="hidden" name="page" value="cebu-dream-booking" />
	  <?php $booking_list_table->search_box('search', 'search_id'); ?>
	</form>
	
	<form method="post">
		<p class="search-box">
			<select name="filter_room_ID">
				<option value="">Room Code</option>
				<?php foreach ( $rooms as $room ): ?>
					<option value="<?php echo $room->ID; ?>" <?php selected( $room->ID, browser_request( 'filter_room_ID' ) ) ;?>><?php echo room_code( $room->ID ); ?></option>
				<?php endforeach; ?>
			</select>
			<select name="filter_payment_status">
				<option value="">Payment Status</option>
				<?php foreach ( $payment_statuses as $s ): ?>
					<option value="<?php echo $s; ?>" <?php selected( $s, browser_request( 'filter_payment_status' ) ) ;?>><?php echo $s; ?></option>
				<?php endforeach; ?>
			</select>
			<input type="text" name="filter_date_in" id="filter_date_in" class="bdr-calendar" value="<?php echo browser_request( 'filter_date_in' ) ;?>" placeholder="Check In"/>
			<input type="text" name="filter_date_out" id="filter_date_out" class="bdr-calendar" value="<?php echo browser_request( 'filter_date_out' ) ;?>" placeholder="Check Out"/>
			<input type="submit" id="filter" class="button" value="Filter">
		</p>
	  	<input type="hidden" name="page" value="cebu-dream-booking" />
	</form>

	<form method="POST">
		<?php $booking_list_table->display(); ?>
	</form>
</div>

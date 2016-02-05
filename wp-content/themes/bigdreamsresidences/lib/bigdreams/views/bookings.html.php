<div class="wrap">
	<h1>Bookings 
		<a href="<?php echo admin_url('/admin.php?page='. BigDream_Booking::NEW_BOOKING_SLUG); ?>" class="page-title-action">Add Manually</a>
		<a href="<?php echo admin_url('/admin.php?page='. BigDream_Booking::NEW_BOOKING_SLUG); ?>" class="page-title-action">Export to Excel</a>
		<a href="<?php echo admin_url('/admin.php?page='. BigDream_Booking::NEW_BOOKING_SLUG); ?>" class="page-title-action">Import Excel</a>
		<a href="<?php echo admin_url('/admin.php?page='. BigDream_Booking::LIST_PAGE_SLUG . '&view=calendar'); ?>"><span class="dashicons dashicons-calendar-alt"></span></a>
		<a href="<?php echo admin_url('/admin.php?page='. BigDream_Booking::LIST_PAGE_SLUG. '&view=list'); ?>"><span class="dashicons dashicons-list-view"></span></a>
	</h1>
	<?php bigdream_notices(); ?>
	<?php $booking_list_table->views(); ?>
	<form method="post">
	  <input type="hidden" name="page" value="cebu-dream-booking" />
	  <?php $booking_list_table->search_box('search', 'search_id'); ?>
	</form>
	<form method="POST">
		<?php $booking_list_table->display(); ?>
	</form>
</div>

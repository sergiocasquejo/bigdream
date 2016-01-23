<div class="wrap">
	<h1>Bookings <a href="<?php echo admin_url('/admin.php?page='. BigDream_Booking::NEW_BOOKING_SLUG); ?>" class="page-title-action">Add Manually</a></h1>
	<?php bigdream_admin_notices(); ?>
	<?php $booking_list_table->views(); ?>
	<form method="post">
	  <input type="hidden" name="page" value="cebu-dream-booking" />
	  <?php $booking_list_table->search_box('search', 'search_id'); ?>
	</form>
	<?php $booking_list_table->display(); ?>
</div>
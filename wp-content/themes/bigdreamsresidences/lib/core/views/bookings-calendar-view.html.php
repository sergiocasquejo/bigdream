<div class="wrap">
	<h1>Bookings 
		<a href="<?php echo admin_url('/admin.php?page='. BigDream_Booking::NEW_BOOKING_SLUG); ?>" class="page-title-action">Add Manually</a>
		<a href="<?php echo admin_url('/admin.php?page='. BigDream_Booking::LIST_PAGE_SLUG . '&view=calendar'); ?>"><span class="dashicons dashicons-calendar-alt"></span></a>
		<a href="<?php echo admin_url('/admin.php?page='. BigDream_Booking::LIST_PAGE_SLUG. '&view=list'); ?>"><span class="dashicons dashicons-list-view"></span></a>
	</h1>
	<?php site_notices(); ?>
	<div id='bookingCalendarView'></div>
</div>



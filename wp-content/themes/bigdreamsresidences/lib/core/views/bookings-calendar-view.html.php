<div class="wrap">
	<h1>Bookings 
		<a href="<?php echo admin_url('/admin.php?page=edit-booking'); ?>" class="page-title-action">Add Manually</a>
		<a href="<?php echo admin_url('/admin.php?page=manage-bookings&view=calendar'); ?>"><span class="dashicons dashicons-calendar-alt"></span></a>
		<a href="<?php echo admin_url('/admin.php?page=manage-bookings&view=list'); ?>"><span class="dashicons dashicons-list-view"></span></a>
	</h1>
	<?php site_notices(); ?>
	<div id='bookingCalendarView'></div>
</div>



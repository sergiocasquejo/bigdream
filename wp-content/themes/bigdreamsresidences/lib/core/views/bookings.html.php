<div class="wrap">
	<h1>Bookings 
		<a href="<?php echo admin_url('/admin.php?page=edit-booking'); ?>" class="page-title-action">Add Manually</a>
		<a href="<?php echo admin_url('/admin.php?page=mange-booking&action=export-bookings'); ?>" class="page-title-action">Export to Excel</a>
		<a href="<?php echo admin_url('/admin.php?page=mange-booking&view=calendar'); ?>"><span class="dashicons dashicons-calendar-alt"></span></a>
		<a href="<?php echo admin_url('/admin.php?page=mange-booking&view=list'); ?>"><span class="dashicons dashicons-list-view"></span></a>
	</h1>
	<?php 
		site_notices(); 
		$data->prepare_items();

		$data->views(); ?>
	<form method="post">
	  <input type="hidden" name="page" value="cebu-dream-booking" />
	  <?php $data->search_box('search', 'search_id'); ?>
	</form>
	<form method="POST">
		<?php $data->display(); ?>
	</form>
</div>

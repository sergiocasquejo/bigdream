<div class="wrap">
	<h1>Booking Details <a href="<?php echo admin_url('/admin.php?page=big-dream-bookings'); ?>" class="page-title-action">Back to Listing</a></h1>
	<div class="gap-30"></div>
	<?php bigdream_admin_notices(); ?>
	<div class="form-group">
		<label class="form-label" for="first_name">Room Type</label>
		<strong><?php echo $post['room']; ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="amount">Amount</label>
		<strong><?php echo $post['amount']; ?></strong>
	</div>
	<div class="gap-30"></div>
	<div class="form-group">
		<label class="form-label" for="first_name">Title</label>
		<strong><?php echo $post['title']; ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="first_name">Full Name</label>
		<strong><?php echo $post['name']; ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="birth_date">Date of Birth</label>
		<strong><?php echo date('M j, Y', strtotime($post['birth_date'])); ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="email_address">Email Address</label>
		<strong><?php echo $post['email_address']; ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="primary_phone">Primary Phone</label>
		<strong><?php echo $post['primary_phone']; ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="secondary_phone">Secondary Phone</label>
		<strong><?php echo $post['secondary_phone']; ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="address_1">Address 1</label>
		<strong><?php echo $post['address_1']; ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="address_2">Address 2</label>
		<strong><?php echo $post['address_2']; ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="address_3">Address 3</label>
		<strong><?php echo $post['address_3']; ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="nationality">Nationality</label>
		<strong><?php echo $post['nationality']; ?></strong>
	</div>
	
	
	<div class="gap-30"></div>
	<div class="form-group">
		<label class="form-label" for="date_in">Date In</label>
		<strong><?php echo date('M j, Y', strtotime($post['date_in'])); ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="date_out">Date Out</label>
		<strong><?php echo date('M j, Y', strtotime($post['date_out'])); ?></strong>
	</div>
	<div class="gap-30"></div>
	<div class="form-group">
		<label class="form-label" for="amount_paid">Amount Paid</label>
		<strong><?php echo $post['amount_paid']; ?></strong>
	</div>
	<div class="form-group">
		<label class="form-label" for="booking_status">Booking Status</label>
		<strong><?php echo $post['booking_status']; ?></strong>
	</div>
</div>
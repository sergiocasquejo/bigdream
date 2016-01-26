<div class="featured-image" style="background:#e7e7e7 url('<?php echo $featured_image; ?>');min-height:150px;">
</div>
<div class="booking-details">
	<p class="form-group">
		<label class="form-label" for="first_name">Room Type</label>
		<strong><?php echo $details['room']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="amount">Amount</label>
		<strong><?php echo $details['amount']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="first_name">Salutation</label>
		<strong><?php echo $details['salutation']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="first_name">Full Name</label>
		<strong><?php echo $details['name']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="birth_date">Date of Birth</label>
		<strong><?php echo date('M j, Y', strtotime($details['birth_date'])); ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="email_address">Email Address</label>
		<strong><?php echo $details['email_address']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="primary_phone">Primary Phone</label>
		<strong><?php echo $details['primary_phone']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="secondary_phone">Secondary Phone</label>
		<strong><?php echo $details['secondary_phone']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="address_1">Address 1</label>
		<strong><?php echo $details['address_1']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="address_2">Address 2</label>
		<strong><?php echo $details['address_2']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="address_3">Address 3</label>
		<strong><?php echo $details['address_3']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="nationality">Nationality</label>
		<strong><?php echo $details['nationality']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="date_in">Date In</label>
		<strong><?php echo date('M j, Y', strtotime($details['date_in'])); ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="date_out">Date Out</label>
		<strong><?php echo date('M j, Y', strtotime($details['date_out'])); ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="amount_paid">Amount Paid</label>
		<strong><?php echo $details['amount_paid']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="booking_status">Booking Status</label>
		<span class="badge <?php echo sanitize_title_with_dashes($details['booking_status']);  ?>"><?php echo $details['booking_status']; ?></span>
	</p>
</div>
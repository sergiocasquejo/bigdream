<div class="featured-image" style="background:#e7e7e7 url('<?php echo $featured_image; ?>');min-height:150px;">
</div>
<div class="booking-details">
	<p class="form-group">
		<label class="form-label" for="first_name">Room Type</label>
		<strong><?php echo $details['room']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="amount">Room Price</label>
		<strong><?php echo format_price($details['room_price']); ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="amount">Total</label>
		<strong><?php echo format_price($details['amount']); ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="nationality">Nationality</label>
		<strong><?php echo $details['nationality']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="first_name">Full Name</label>
		<?php echo $details['name']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="birth_date">Date of Birth</label>
		<strong><?php echo format_date($details['birth_date']); ?></strong>
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
		<label class="form-label" for="address_1">Address 1</label>
		<strong><?php echo $details['address_1']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label" for="address_2">Address 2</label>
		<strong><?php echo $details['address_2']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label">Province</label>
		<strong><?php echo $details['province']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label">City</label>
		<strong><?php echo $details['city']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label">Zip Code</label>
		<strong><?php echo $details['zipcode']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label">Address 2</label>
		<strong><?php echo $details['address_2']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label">Date In</label>
		<strong><?php echo format_date($details['date_in']); ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label">Date Out</label>
		<strong><?php echo format_date($details['date_out']); ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label">No of Night</label>
		<strong><?php echo $details['no_of_night']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label">No of Adult</label>
		<strong><?php echo $details['no_of_adult']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label">No of Child</label>
		<strong><?php echo $details['no_of_child']; ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label">Amount Paid</label>
		<strong><?php echo format_price($details['amount_paid']); ?></strong>
	</p>
	<p class="form-group">
		<label class="form-label">Booking Status</label>
		<span class="badge <?php echo sanitize_title_with_dashes($details['booking_status']);  ?>"><?php echo $details['booking_status']; ?></span>
	</p>
	<p class="form-group">
		<label class="form-label">Notes</label>
		<strong><?php echo $details['notes']; ?></strong>
	</p>
</div>
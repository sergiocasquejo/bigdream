<div class="booking-details-view">
	<div class="row">
		<div class="col-md-4 col-lg-4">
			<div class="reservation-sidebar">
				<div class="reservation-date">
					<h4 class="reservation-heading">Dates</h4>
					<ul>
						<li><span>Check-In</span><span><?php echo format_date($data['date_in']); ?></span></li>
						<li><span>Check-Out</span><span><?php echo format_date($data['date_out']); ?></span>
						</li><li><span>Total Nights</span><span><?php echo $data['no_of_night']; ?></span></li>
						<li>
							<span>Total Guests</span>
							<span><?php echo $data['no_of_adult'] . 'Adults '. $data['no_of_child'] .' Children'; ?></span>
						</li>
					</ul>
				</div>
				<div class="reservation-room-selected">
					<h4 class="reservation-heading">Selected Room</h4>
					<div class="reservation-room-seleted_item">
						<div class="reservation-room-seleted_name has-package">
							<h4><?php echo $data['room']; ?></h4>
						</div>
						<ul>
							<li>
								<span>Room Price</span>
								<span><?php echo nf($data['room_price']); ?></span>
							</li>
							<li><span>Max</span><span><?php the_field( 'max_person', $data['room_type_ID']); ?> Person(s)</span></li>
							<li><span>Size</span><span><?php the_field( 'room_size', $data['room_type_ID']); ?></span></li>
							<li><span>Bed</span><span><?php the_field( 'bed', $data['room_type_ID']); ?></span></li>
							<li><span>View</span><span><?php the_field( 'view', $data['room_type_ID']); ?></span></li>
							<li>
								<span>Total Room <?php echo $data['no_of_room']; ?></span>
								<span><?php echo nf($data['amount']); ?></span>
							</li>
						</ul>
					</div>
					<div class="reservation-room-seleted_total">
						<label>TOTAL</label>
						<span class="reservation-total">
							<?php echo format_price($data['amount']); ?>
						</span>
					</div>
					<div class="guest-paid">
						<label>GUEST PAID</label>
						<span class="price">
							<?php echo format_price($data['amount_paid']); ?>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8 col-lg-8">
			<div class="reservation_content">
				<div class="reservation-billing-detail success-details">
					<h4>BOOKING DETAILS</h4>
					<ul>
						<li><span>Booking #</span><span><?php echo $data['booking_no']; ?></span></li>
						<li><span>Booking Status</span><span><?php echo $data['booking_status']; ?></span></li>
						<li><span>Payment Status</span><span><?php echo $data['payment_status']; ?></span></li>
					</ul>
				</div>

				<div class="reservation-billing-detail success-details">
					<h4>BILLING DETAILS</h4>
					<ul>
						<li><span>Country</span><span><?php echo $data['country']; ?></span></li>
						<li><span>Full Name</span><span><?php echo $data['name']; ?></span></li>
						<li>
							<span>Date of Birth</span>
							<span><?php echo format_date($data['birth_date']); ?></span>
						</li>
						<li><span>Nationality</span><span><?php echo $data['nationality']; ?></span></li>
						<li><span>Email Address</span><span><?php echo $data['email_address']; ?></span></li>
						<li><span>Phone</span><span><?php echo $data['primary_phone']; ?></span></li>
						<li><span>Address</span><span><?php echo $data['address_1']; ?></span></li>
						<li>
							<span>Apartment, suite, unit etc.</span>
							<span><?php echo $data['address_2']; ?></span>
						</li>
						<li><span>Town / City</span><span><?php echo $data['city']; ?></span></li>
						<li><span>Province</span><span><?php echo $data['province']; ?></span></li>
						<li><span>Zip Code</span><span><?php echo $data['zipcode']; ?></span></li>
						<li><span>Notes</span><br><span><?php echo $data['notes']; ?></span></li>
					</ul>
				</div>

			</div>
		</div>
	</div>	
</div>

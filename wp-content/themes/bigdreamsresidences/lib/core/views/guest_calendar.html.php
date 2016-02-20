<div class="wrap">
	<h1>Guest Calendar</h1>
	<?php do_action( 'print_custom_notices', true ); ?>
	
	<div class="filter-box">
		<form type="post" id="filterGuestCalendarForm">
			<input type="text" name="start_date" class="calendar" value="<?php echo $selected_date; ?>" placeholder="Start Date" />
			<select name="days_to_display">
				<option value="7" <?php selected( 7, $days_to_display ); ?>>7 Days</option>
				<option value="15" <?php selected( 15, $days_to_display ); ?>>15 Days</option>
				<option value="30" <?php selected( 30, $days_to_display ); ?>>30 Days</option>
			</select>
			<select name="booking_status">
				<option value="">All</option>
				<?php foreach ( $booking_statuses as $i => $s ) { ?>
					<option value="<?php echo $s; ?>" <?php selected( $selected_status, $s ); ?>><?php echo $s; ?></option>
				<?php } ?>
			</select>
			<input type="hidden" name="action" value="filter_guest_calendar_date" />
			<button type="submit" class="button button-primary">Filter</button>
			<a href="#" class="button button-secondary">Print Calendar</a>
		</form>
	</div>
	<div class="gap-30"></div>	
	<p>
		<span class="badge new">NEW</span>
		<span class="badge confirmed">CONFIRMED</span>
		<span class="badge arrived">ARRIVED</span>
		<span class="badge checkout">CHECKOUT</span>
	</p>
	<div id="guestCalendarWrapper">
		<?php echo $output; ?>
	</div>
</div>



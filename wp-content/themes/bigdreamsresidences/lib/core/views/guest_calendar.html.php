<div class="wrap">
	<h1>Guest Calendar</h1>
	<?php site_notices(); ?>
	<div class="filter">
		<form type="post" id="filterGuestCalendarForm">
			<input type="text" name="start_date" placeholder="Start Date" />
			<select name="days_to_display">
				<option value="7">7 Days</option>
				<option value="15">15 Days</option>
				<option value="30">30 Days</option>
			</select>
			<input type="hidden" name="action" value="filter_guest_calendar_date" />
			<button type="submit" class="button button-primary">Filter</button>
		</form>
	</div>
	<div id="guestCalendarWrapper">
		<?php echo $output; ?>
	</div>
</div>



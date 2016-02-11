<div class="wrap">
	<h1>Guest Calendar</h1>
	<?php site_notices(); ?>
	<div id="guestCalendarWrapper">
		<table class="widefat">
			<thead>
				<tr>
					<th width="10%"></th>
					<th colspan="<?php echo  ( $total_day - 1  ) * 2; ?>"><?php echo format_date( $selected_date, 'F Y' ); ?></th>
				</tr>
				<tr>
					<th width="10%"></th>
					<?php $date = $selected_date; for ( $start = $start_date; $start <= $total_day; $start++ ) { ?>
					<th colspan="<?php echo $start != $start_date && $start != $total_day ? '2' : ''; ?>"><?php echo format_date( $date, 'j' ); ?></th>
					<?php $date = add_days_to_date( $date, 1 ); } ?>
				</tr>
				<tr>
					<th width="10%"></th>
					<?php $date = $selected_date; for ( $start = $start_date; $start <= $total_day; $start++ ) { ?>
					<th colspan="<?php echo $start != $start_date && $start != $total_day ? '2' : ''; ?>"><?php echo format_date( $date, 'D' ); ?></th>
					<?php $date = add_days_to_date( $date, 1 ); } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $calendar as $k => $c ): 
					usort($c, function($a, $b) {
					   return strtotime( $a['from'] ) - strtotime( $b['from'] );
					});
				?>
				<tr>
					<td><?php echo $k; ?></td>
					<td colspan="<?php echo  ( $total_day - 1 ) * 2; ?>" class="calendar_row <?php echo $total_day; ?>">
						<div class="row_data">
							<div class="bg_row">
								<table>
									<tbody>
										<?php for ( $i = $start_date; $i <= $total_day - 1; $i++ ) { ?>
										<td colspan="2"></td>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<div class="bg-content">
								<table>
									<tbody>
										<?php 
										$b = $selected_date;
										foreach ( $c as $cal ) {
											if ( strtotime( $cal['from'] ) > strtotime( $end_date ) ) continue;
											

											if ( ( $f =  count_days_gap( $b, $cal['from'], $end_date ) ) > 0 ) {
												echo '<td colspan="'. $f .'"></td>';
												$b = add_days_to_date( $b, $f );
											}

											$f = count_days_gap( $cal['from'], $cal['to'], $end_date );
											echo '<td colspan="'. $f .'"><div class="text">'. $cal['guest'] .'</div></td>';
											$b = $cal['to'] > $end_date ? $end_date : $cal['to'];

										}

										if ( strtotime($end_date) > strtotime($b) && ( $f = count_days_gap( $b, $end_date, $end_date ) - 1  ) > 0 ) {
											echo '<td colspan="'. $f .'"></td>';
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>


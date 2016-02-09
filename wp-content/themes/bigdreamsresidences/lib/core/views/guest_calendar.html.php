<div class="wrap">
	<h1>Guest Calendar</h1>
	<?php site_notices(); ?>
	<div id='guestCalendar'>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th width="10%"></th>
					<th colspan="29"><?php echo date( 'F Y' ) ;?></th>
				</tr>
				<tr>
					<th width="10%"></th>
					<?php for( $i = 1; $i <= 30; $i++ ): ?>
					<th><?php echo $i; ?></th>
					<?php endfor; ?>
				</tr>
				<tr class="day">
					<th width="10%"></th>
					<?php for( $i = 1; $i <= 30; $i++ ): ?>
					<th><?php echo date('D', strtotime( date('Y-m-'. ($i < 10 ? '0' . $i : $i) ) ) ); ?></th>
					<?php endfor; ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>CODE123</td>
					<td colspan="30" class="table_row">
						<div class="calendar_row">
							<div class="bg_row">
								<table>
									<tbody>
										<?php for( $i = 1; $i <= 30; $i++ ): ?>
										<td></td>
										<?php endfor; ?>
									</tbody>
								</table>
							</div>
							<div class="content_row">
								<table>
									<tbody>
										<td colspan="5" class="reserved">
											<span>
												John Doe
											</span>
										</td>
										<td colspan="26">&nbsp;</td>
									</tbody>
								</table>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>CODE123</td>
					<td colspan="30" class="table_row">
						<div class="calendar_row">
							<div class="bg_row">
								<table>
									<tbody>
										<?php for( $i = 1; $i <= 30; $i++ ): ?>
										<td></td>
										<?php endfor; ?>
									</tbody>
								</table>
							</div>
							<div class="content_row">
								
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>



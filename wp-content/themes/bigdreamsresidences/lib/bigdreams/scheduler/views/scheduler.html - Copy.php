<div id="calendar" class="sc sc-ltr sc-unthemed">
	<div class="sc-toolbar">
		<div class="sc-left">
			<div class="sc-button-group">
				<button type="button" class="sc-prev-button sc-button sc-state-default sc-corner-left">
					<span class="sc-icon sc-icon-left-single-arrow"></span>
				</button>
				<button type="button" class="sc-next-button sc-button sc-state-default sc-corner-right">
					<span class="sc-icon sc-icon-right-single-arrow"></span>
				</button>
			</div>
			<button type="button" class="sc-today-button sc-button sc-state-default sc-corner-left sc-corner-right">Add Room</button>
		</div>
		<div class="sc-right">
			<div class="sc-button-group">
				<button type="button" class="sc-prev-button sc-button sc-state-default sc-corner-left">
					<span class="sc-icon sc-icon-left-single-arrow"></span>
				</button>
				<button type="button" class="sc-next-button sc-button sc-state-default sc-corner-right">
					<span class="sc-icon sc-icon-right-single-arrow"></span>
				</button>
			</div>
		</div>
		<div class="sc-center">
			<h2>January 2016</h2>
		</div>
		<div class="sc-clear"></div>
	</div>
	<div class="sc-view-container" style="">
		<table class="scheduler-container">
			<tr>
				<td class="sc-view sc-month-view sc-basic-view sc-room-view" width="200">
					<table>
						<thead class="sc-head">
							<tr>
								<td class="sc-head-container sc-widget-header">
									<div class="sc-row sc-widget-header">
										<table>
											<thead>
												<tr>
													<th class="sc-day-header sc-widget-header">Room</th>
													<th class="sc-day-header sc-widget-header">Type</th>
													<th class="sc-day-header sc-widget-header">Status</th>
												</tr>
											</thead>
										</table>
									</div>
								</td>
							</tr>
						</thead>
						<tbody class="sc-body">
							<tr>
								<td class="sc-widget-content">
									<div class="sc-day-grid-container">
										<div class="sc-day-grid sc-room-grid">
											<?php foreach ($rooms as $i => $r): ?>
											<div class="sc-row sc-week sc-widget-content sc-rigid" style="height: 50px;">
												<div class="sc-bg">
													<table>
														<tbody>
															<tr>
																<td><?php echo $r['no']; ?></td>
																<td><?php echo $r['type'] . ' beds'; ?></td>
																<td class="room-<?php echo strtolower($r['status']); ?>"><?php echo $r['status']; ?></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<?php endforeach; ?>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
				<td class="sc-view sc-month-view sc-basic-view">
					<table>
						<thead class="sc-head">
							<tr>
								<td class="sc-head-container sc-widget-header">
									<div class="sc-row sc-widget-header">
										<table>
											<thead>
												<tr>
													<th class="sc-day-header sc-widget-header">1</th>
													<th class="sc-day-header sc-widget-header">2</th>
													<th class="sc-day-header sc-widget-header">3</th>
													<th class="sc-day-header sc-widget-header">4</th>
													<th class="sc-day-header sc-widget-header">5</th>
													<th class="sc-day-header sc-widget-header">6</th>
													<th class="sc-day-header sc-widget-header">7</th>
													<th class="sc-day-header sc-widget-header">8</th>
													<th class="sc-day-header sc-widget-header">9</th>
													<th class="sc-day-header sc-widget-header">10</th>
													<th class="sc-day-header sc-widget-header">11</th>
												</tr>
											</thead>
										</table>
									</div>
								</td>
							</tr>
						</thead>
						<tbody class="sc-body">
							<tr>
								<td class="sc-widget-content">
									<div class="sc-day-grid-container">
										<div class="sc-day-grid">
											<?php foreach ($rooms as $i => $r): ?>
											<div class="sc-row sc-week sc-widget-content sc-rigid" style="height: 50px;">
												<div class="sc-bg">
													<table>
														<tbody>
															<tr>
																<td class="sc-day sc-widget-content"></td>
																<td class="sc-day sc-widget-content"></td>
																<td class="sc-day sc-widget-content"></td>
																<td class="sc-day sc-widget-content"></td>
																<td class="sc-day sc-widget-content"></td>
																<td class="sc-day sc-widget-content"></td>
																<td class="sc-day sc-widget-content"></td>
																<td class="sc-day sc-widget-content"></td>
																<td class="sc-day sc-widget-content"></td>
																<td class="sc-day sc-widget-content"></td>
																<td class="sc-day sc-widget-content"></td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="sc-content-skeleton">
													<table>
														<tbody>
															<tr>
																<td class="sc-event-container" colspan="2">
																	<a class="sc-day-grid-event sc-h-event sc-event arrived sc-start sc-end sc-draggable sc-resizable">
																		<div class="sc-content"> 
																			<span class="sc-title">John Doe</span><br />
																			<ul>
																				<li><span class="sc-booking-status">Arrived</span></li>
																				<li><span class="sc-paid-status">Paid 50%</span></li>
																			</ul>
																		</div>
																	</a>
																</td>
																<td class="sc-event-container" colspan="2">
																	<a class="sc-day-grid-event sc-h-event sc-event checkout sc-start sc-end sc-draggable sc-resizable">
																		<div class="sc-content"> 
																			<span class="sc-title">John Doe</span><br />
																			<ul>
																				<li><span class="sc-booking-status">Checkout</span></li>
																				<li><span class="sc-paid-status">Paid 50%</span></li>
																			</ul>
																		</div>
																	</a>
																</td>
																<td class="sc-event-container" colspan="2">
																	<a class="sc-day-grid-event sc-h-event sc-event confirmed sc-start sc-end sc-draggable sc-resizable">
																		<div class="sc-content"> 
																			<span class="sc-title">John Doe</span><br />
																			<ul>
																				<li><span class="sc-booking-status">Confirmed</span></li>
																				<li><span class="sc-paid-status">Paid 50%</span></li>
																			</ul>
																		</div>
																	</a>
																</td>
																<td></td>
																<td class="sc-event-container" colspan="2">
																	<a class="sc-day-grid-event sc-h-event sc-event sc-start sc-end sc-draggable sc-resizable">
																		<div class="sc-content"> 
																			<span class="sc-title">John Doe</span><br />
																			<ul>
																				<li><span class="sc-booking-status">Not Confirmed</span></li>
																				<li><span class="sc-paid-status">Paid 50%</span></li>
																			</ul>
																		</div>
																	</a>
																</td>
																<td></td>
																<td></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
											<?php endforeach; ?>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
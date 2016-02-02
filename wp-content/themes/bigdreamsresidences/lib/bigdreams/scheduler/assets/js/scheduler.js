(function(window, document, $) {
	var W = $(window),
		D = $(document),
		selectedDate = new Date(),
		Booking = {

			init: function() {
				var month = 0; // January
				var d = new Date(2016, month + 1, 0);
				//alert(d.getDate()); // last day in January

				

				var _this = this;
				_this.getRooms();
				_this.getBookings();
				_this.populateTimeLine(d.getDate());


			},
			getDates: function (startDate, stopDate) {
			    var dateArray = [];
			    var currentDate = moment(startDate);
			    while (currentDate <= stopDate) {
			        dateArray.push( moment(currentDate).format('YYYY-MM-DD') )
			        currentDate = moment(currentDate).add(1, 'days');
			    }
			    return dateArray;
			},
			getRooms: function() {
				var _this = this;
				$.get(BOOKING.ajaxURL + '?action=get-rooms', function(response) {
					_this.populateRow(response);
				});
			},
			getBookings: function() {
				var _this = this;
				$.get(BOOKING.ajaxURL + '?action=get-bookings', function(response) {
					console.log(response);
					for(var i in response) {
						console.log(_this.getDates(new Date(response[i].from * 1000), new Date(response[i].to * 1000)));
					}
					// _this.populateRow(response);
				});
			},
			populateRow: function(rooms) {
				var row = '';

				for(var i in rooms) {
					var r = rooms[i];

					row += '' +
						'<div class="sc-row sc-week sc-widget-content sc-rigid" style="height: 50px;">' +
							'<div class="sc-bg">' +
								'<table>' +
									'<tbody>' +
										'<tr>' +
											'<td>'+ r.no +'</td>' + 
											'<td>'+ r.type +' bed' + (r.type > 1 ? 's' : '') + '</td>' +
											'<td class="room-'+ r.status +'">'+ r.status +'</td>' + 
										'</tr>' + 
									'</tbody>' +
								'</table>' +
							'</div>' +
						'</div>';
				}

				$('.sc-room-grid').append(row);
			},
			populateTimeLine: function(totalDays) {

				console.log(totalDays);
				var th = '';
				for (var i = 1; i <= totalDays; i++) {
					th += '<th>'+ i +'</th>';
				}

				$('.sc-day-grid-header').append(th);
			}
		};

	


	D.ready(function() {
		
		Booking.init();

	});

}(window, document, jQuery));
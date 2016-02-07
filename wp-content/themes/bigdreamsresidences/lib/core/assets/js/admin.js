(function(window,document, $) {
	'use strict';
	var W = $(window),
		D = $(document);

	function getBookingDetails(id) {
		$.get(BDR.AjaxUrl + '?action=booking-details&bid=' + id, function(response) {
			$('#bdrModalDialog').html(response);
			tb_show("Booking Details", '#TB_inline?width=600&height=550&inlineId=bdrModalDialog');
		});
	}

	function editRoomsAndGuestInfo(id) {
		$.get(BDR.AjaxUrl + '?action=edit-rooms-and-guest-info&brid=' + parseInt(id), function(response) {
			$('#bdrModalDialog').html(response);
			tb_show("Select Room", '#TB_inline?width=600&height=550&inlineId=bdrModalDialog');
		});
	}

	$(function() {
		$('body')
		.on('click', '.view-booking-details', function(e) {
			e.preventDefault();

			var $this = $(this),
				id = $this.data('id');

			getBookingDetails(id);
				
			return false;
		})
		.on('click', '#EditRoom', function(e) {
			e.preventDefault();

			editRoomsAndGuestInfo(0);

			return false;
		});

		$('body').on('submit', '#roomsAndGuestInfoForm', function(e) {
			e.preventDefault();
			var bookingID = $("#booking_ID").val();
			$.post(BDR.AjaxUrl, $(this).serialize() + '&booking_ID='+ bookingID +'&action=save-rooms_and_guest_info', function(response) {
				if ( response == 'success' ) {
					window.location.reload( true );
				}
			});

			return false;
		});

		$('#bookingCalendarView').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: new Date(),
			editable: false,
			eventLimit: true, // allow "more" link when too many events
			events: BDR.bookings,
			eventClick: function(calEvent, jsEvent, view) {
		        getBookingDetails(calEvent.id);
		    }
		});

		$( "#date_in" ).datepicker({
	      minDate: new Date(),
	      defaultDate: "+1w",
	      changeMonth: false,
	      numberOfMonths: 1,
	      onClose: function( selectedDate ) {
	        $( "#date_out" ).datepicker( "option", "minDate", selectedDate );
	      }
	    });

	    $( "#date_out" ).datepicker({
	      defaultDate: "+1w",
	      changeMonth: false,
	      numberOfMonths: 1,
	      onClose: function( selectedDate ) {
	        $( "#date_in" ).datepicker( "option", "maxDate", selectedDate );
	      }
	    });

	    $(".bdr-calendar").datepicker({
	      changeMonth: true,
	      changeYear: true,
	      yearRange: '1910:' + new Date().getFullYear(),
	    });
	});
	






}(window, document, jQuery))
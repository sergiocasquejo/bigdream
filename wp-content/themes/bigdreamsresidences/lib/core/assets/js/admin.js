(function(window,document, $) {
	'use strict';
	var W = $(window),
		D = $(document);
	function renderToolTip() {
	 $('.bdr-tooltip').tooltip({
	      show: {
	        effect: "slideDown",
	        delay: 250
	      }
	    });
	}
	function dateInAndOut( el ) {
		$( ".date_in", el ).datepicker({
	      minDate: new Date(),
	      defaultDate: "+1w",
	      dateFormat: 'yy-mm-dd',
	      changeMonth: false,
	      numberOfMonths: 1,
	      onClose: function( selectedDate ) {
	        $( ".date_out", el ).datepicker( "option", "minDate", selectedDate );
	      }
	    });

	    $( ".date_out", el ).datepicker({
	      defaultDate: "+1w",
	      dateFormat: 'yy-mm-dd',
	      changeMonth: false,
	      numberOfMonths: 1,
	      onClose: function( selectedDate ) {
	        $( ".date_in", el ).datepicker( "option", "maxDate", selectedDate );
	      }
	    });
	}

	function getBookingDetails(id) {
		$.get(BDR.AjaxUrl + '?action=booking-details&bid=' + id, function(response) {
			$('#bdrModalDialog').html(response);
			tb_show("Booking Details", '#TB_inline?width=650&height=550&inlineId=bdrModalDialog');
		});
	}

	function calculateTotalAmount() {
		var id = $(":input[name=room_type_ID] option:selected").val(),
			check_in = $(":input[name=date_in]").val(),
			check_out = $(":input[name=date_out]").val(),
			no_of_room = $(":input[name=no_of_room] option:selected").val();



		$.get(BDR.AjaxUrl, {
			action: 'calculate-total-amount', 
			room_type_ID: id, 
			date_in : check_in, 
			date_out: check_out,
			no_of_room: no_of_room
		},
		function(response) {
			if (response.success) {
				$('#priceCalculation').html( response.data.html );
			}
		});
	}

	function getRoomsAndGuestInfo() {
		var bid = $('#booking_ID').val();

		$.get(BDR.AjaxUrl + '?action=get-rooms_and_guest_info&booking_ID=' + parseInt(bid) , function(response) {
			$('#roomsAndGuestInfoWrapper').html(response);
			$(':input[name="no_of_room"]').trigger('change');
		});
	}

	function editRoomsAndGuestInfo(id) {
		var bid = $('#booking_ID').val(),
			room_type_ID = $('select[name=room_type_ID] option:selected').val();
		$.get(BDR.AjaxUrl + '?action=edit-rooms-and-guest-info&brid=' + parseInt(id) +'&booking_ID=' + parseInt(bid)+'&room_type_ID=' + parseInt(room_type_ID), function(response) {
			var $modal = $(response);
			
			$('#bdrModalDialog').html($modal);
			tb_show("Room and Guest Info", '#TB_inline?width=600&height=450&inlineId=bdrModalDialog');
			
			dateInAndOut( $modal );
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
		})
		.on('submit', '#roomsAndGuestInfoForm', function(e) {
			e.preventDefault();
			var bookingID = $("#booking_ID").val();
			$.post(BDR.AjaxUrl, $(this).serialize() + '&booking_ID='+ bookingID +'&action=save-rooms_and_guest_info', function(response) {

				if ( response.success == true ) {
					getRoomsAndGuestInfo();
					$('#TB_closeWindowButton').trigger('click');
					
					
				} else {
					if ( response.data.message != '' && response.data.message != undefined ) {
						alert( response.data.message );
					}

					$('#roomsAndGuestInfoForm .error_field').remove();
					$('body').append( response.data.js );
				}
			}, 'json');

			return false;
		})
		.on('click', '.edit-rooms-and-guest', function(e) {
			var brid = $(this).data('brid');
			editRoomsAndGuestInfo( brid );
		})
		.on('click', '.delete-rooms-and-guest', function(e) {
			var brid = $(this).data('brid');

			if ( confirm( 'Are you sure?' ) ) {
				$.post( BDR.AjaxUrl, { booking_room_ID: brid, action: 'delete-room_and_guest_info' }, function( response ) {
					if ( response.success == true ) {
						getRoomsAndGuestInfo();
					} else {
						alert( response.data.message );
					}
				} );
			}
		})
		.on('change', ':input[name="no_of_room"]', function(e) {
			var no_of_room = parseInt( $(this).val() ),
				no_of_rooms_guest = $('#roomsAndGuestInfoWrapper table tbody tr').length;

			if ( no_of_room > no_of_rooms_guest  ) {
				$('#EditRoom').removeAttr('disabled');
			} else if ( no_of_room == no_of_rooms_guest ) {
				$('#EditRoom').attr('disabled', true);
			} else {
				alert( 'Please remove some room.' );

				$('#EditRoom').attr('disabled', true);
			}
		})
		.on('keyup change', ':input[name=no_of_room], input[name=date_in], input[name=date_out], select[name=room_type_ID]', function() {
			calculateTotalAmount();
		})

		.on('change', 'select[name=booking_status]', function() {
			if ($(this).val() != 'CHECKOUT') {
				$('.editable').removeAttr('disabled');
			} else {
				$('.editable').attr('disabled', true);
			}
		})

		.on('change', ':input[name="room_type_ID"]', function() {
			var id = $(this).val();
			$.get(BDR.AjaxUrl, {action: 'count-available-rooms', room_type_ID: id }, function(response) {

				if (response.success) {
					$('select[name=no_of_room]').empty();

					if ( response.data.total_rooms <= 0 ) {
						alert('No rooms available');
						return;
					}
					for(var i = 1; i <= response.data.total_rooms; i++) {
						$('select[name=no_of_room]').append($('<option />').val(i).text(i));
					}
				}
			});
		})
		.on('submit', '#filterGuestCalendarForm', function(e) {
			e.preventDefault();
			$.get(BDR.AjaxUrl, $(this).serialize(), function(response) {
				$('#guestCalendarWrapper').html( response );
				renderToolTip();
			});

		  return false;
		})
		.on('click', '#printCalendar', function(e) {
			e.preventDefault();


			var DocumentContainer = document.getElementById('guestCalendarWrapper');
       		var WindowObject = window.open('', 'PrintWindow', 'width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes');
			WindowObject.document.writeln('<!DOCTYPE html>');
			WindowObject.document.write('<html><head>');
			WindowObject.document.write('<link rel="stylesheet" type="text/css" href="'+ BDR.assets +'style/calendar.css" media="print">');
			WindowObject.document.write('</head><body>');
			WindowObject.document.write('<div id="guestCalendarWrapper">' + DocumentContainer.innerHTML + '</div>');
			WindowObject.document.write('</body></html>');

        	setTimeout(function () {
        		WindowObject.document.close();
	            WindowObject.focus();
        		WindowObject.print();
        		WindowObject.close();
	        }, 1000);
		});


		$('select[name=room_type_ID]').trigger('change');



		dateInAndOut();

	    $(".bdr-calendar").datepicker({
	      changeMonth: true,
	      changeYear: true,
	      yearRange: '1910:' + new Date().getFullYear(),
	      dateFormat: 'yy-mm-dd',
	    });

	    $(".calendar").datepicker({
	      changeMonth: false,
	      changeYear: false,
	      dateFormat: 'yy-mm-dd',
	    });
	    renderToolTip();


		$( "#filter_date_in" ).datepicker({
			minDate: new Date(),
			defaultDate: "+1w",
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			yearRange: '1910:' + new Date().getFullYear(),
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$( "#filter_date_out" ).datepicker( "option", "minDate", selectedDate );
			}
		});

		$( "#filter_date_out" ).datepicker({
			defaultDate: "+1w",
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			yearRange: '1910:' + new Date().getFullYear(),
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				$( "#filter_date_in" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
	   
	});
	






}(window, document, jQuery))

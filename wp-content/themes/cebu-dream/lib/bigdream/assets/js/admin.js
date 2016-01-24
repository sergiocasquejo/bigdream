(function(window,document, $) {
	var W = $(window),
		D = $(document);

	$('body')
		.on('click', '.view-booking-details', function(e) {
			e.preventDefault();

			var $this = $(this),
				id = $this.data('id');

				$.get(BDR.AjaxUrl + '?action=booking-details&bid=' + id, function(response) {
					$('#bdrModalDialog').html(response);
					tb_show("Booking Details", '#TB_inline?width=600&height=550&inlineId=bdrModalDialog');
				});
			return false;
		});

}(window, document, jQuery))
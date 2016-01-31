(function(window, document, $) {
  'use strict';
  var W = $(window),
      D = $(document),
      deviceWidth = 0;
  function PlaceSideMenuPosition() {
    var $el = $('.header-sticky');
    var bottom = $el.outerHeight();

    $('.header_menu').css('top', bottom + 'px').toggleClass('active');
  }


  function PrintBooking(content) {

    var str = '<html><head><title></title>' + 
      '<link href="'+ BDR.template_dir_uri +'/dist/styles/main.css" rel="stylesheet" type="text/css" media="print" />' +
      '</head><body >' + $(content).html() + '</body></html>';

    var mywindow = window.open('', 'my div', 'height=800,width=700');
        mywindow.document.write(str);

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

      
        return true;
  }



  W.bind('resize', function () {
    if ($(window).width() < 1192) {
      $('.header-sticky').addClass('header_mobile').removeClass('header_content');
    } else {
      $('.header-sticky').addClass('header_content').removeClass('header_mobile');
    }
  });​​



  D.ready(function() {
    
    W.trigger('resize');

    $('.flexslider').flexslider({
      animation: "slide",
      prevText: '<i class="fa fa-angle-left"></i>',
      nextText: '<i class="fa fa-angle-right"></i>',
      start: function(slider){
        $('body').removeClass('loading');
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

    
    if ($(".room_calendar_availability").length) {
      var events = {};
      var dates = $(".room_calendar_availability").data('unavailable').split(',');

      for(var i = 0; i < dates.length; i++) {
        events[new Date(dates[i])] = true;
      }

      $(".room_calendar_availability").datepicker({
          minDate: new Date(),
          numberOfMonths: 2,
          showButtonPanel: true,
          prevText: '',
          nextText: '',
          beforeShowDay: function(date) {
              var event = events[date];
              if (event) {
                  return [true, 'active'];
              }
              else {
                  return [true, '', ''];
              }
          }
      });
    }
  
    $('.create-accnt-radio').on('change', function() {
      if ($(this).is(':checked')) {
        $('.create-account-box').removeClass('hidden');
      } else {
        $('.create-account-box').addClass('hidden');
      }
    });

    

    $('.menu-bars').on('click', function(e) {
      e.preventDefault();
      PlaceSideMenuPosition();
      return false;
    });

    $('.notices-box').addClass('active');
    var $grid = $('.gallery-grid');
    $grid.isotope({
      itemSelector: '.grid-item',
      masonry: {
        columnWidth: 100,
        gutter: 15
      }
    });

    $('.gallery-cat li').on('click', function(e) {
      e.preventDefault();
      var f = $(this).find('a').data('filter');
      $('.gallery-cat li').removeClass('active');
      $(this).addClass('active');
      $grid.isotope({ filter: f });
      return false;
    });

    $('.gallery-cat li:first-child').trigger('click');

    $('.print-booking').on('click', function(e) {
      e.preventDefault();
      PrintBooking('#bookingDetailContent');
      return false;
    })
  });

})(window, document, jQuery); // Fully reference jQuery after this point.

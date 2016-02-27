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

      var WindowObject = window.open('', 'PrintWindow', 'width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes');
      WindowObject.document.writeln('<!DOCTYPE html>');
      WindowObject.document.write('<html><head><title>Print it!</title>');
      WindowObject.document.write('<link href="'+ BDR.template_dir_uri +'/dist/styles/main.css" rel="stylesheet" type="text/css" media="print" />');
      WindowObject.document.write('</head><body>');
      WindowObject.document.write($(content).html()); //DocumentContainer.innerHTML);
      WindowObject.document.write('</body></html>');
      
      WindowObject.document.close();
          

      setTimeout(function () {
        WindowObject.focus();
        WindowObject.print();
        WindowObject.close();
      }, 500);

    
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

  var marker,
        map;
    function initialize() {
  
      var mapOptions = {
        zoom: 17,
        center: new google.maps.LatLng(10.329797, 123.942690)
      };

      map = new google.maps.Map(document.getElementById('location-map'),
        mapOptions);

      marker = new google.maps.Marker({
        map:map,
        position: new google.maps.LatLng(10.329797, 123.942690),
        icon : BDR.template_dir_uri + '/assets/images/marker.png',
      });
       infowindow.open(map, marker);
    }


    var contentString = '<div id="content">'+
    '<h1>'+ BDR.site_name +'</h1>' +
    '<p style="margin-top: 7px;">Address: '+ BDR.address +'</p>' +
    '<p>Phone: '+ BDR.phone +'</p>' +
    '<p>Email: <a href="mailto:'+ BDR.email +'">'+ BDR.email +'</a></p>' +
    '<p>Website: <a href="'+ BDR.url +'">'+ BDR.url +'</a></p>' +
    '</div>';


    var infowindow = new google.maps.InfoWindow({
      content: contentString
    });


    google.maps.event.addDomListener(window, 'load', initialize);


})(window, document, jQuery); // Fully reference jQuery after this point.

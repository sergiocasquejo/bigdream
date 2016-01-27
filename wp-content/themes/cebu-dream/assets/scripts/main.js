/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function(window, document, $) {
  'use strict';
  var W = $(window),
      D = $(document);
  W.load(function(){
    $('#bigdreamNoticesModal').modal('show');
  });
  D.ready(function() {
    
    $('.flexslider').flexslider({
      animation: "slide",
      start: function(slider){
        $('body').removeClass('loading');
      }
    });

    $( "#date_in" ).datepicker({
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

    $(".bdr-calendar").datepicker();
  
    $('.create-accnt-radio').on('change', function() {
      if ($(this).is(':checked')) {
        $('.create-account-box').removeClass('hidden');
      } else {
        $('.create-account-box').addClass('hidden');
      }
    });
    var deviceWidth = 0;
    $(window).bind('resize', function () {
        if ($(window).width() < 1192) {
          $('.header-sticky').addClass('header_mobile').removeClass('header_content');
        } else {
          $('.header-sticky').addClass('header_content').removeClass('header_mobile');
        }
    }).trigger('resize');​​​

    $('.menu-bars').on('click', function(e) {
      e.preventDefault();
      var $el = $('.header-sticky');
      var bottom = $el.offset().top + $el.outerHeight();

      $('.header_menu').css('top', bottom + 'px').toggleClass('active');
      return false;
    });


  });

})(window, document, jQuery); // Fully reference jQuery after this point.

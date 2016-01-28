(function(window, document, $) {
  'use strict';
  var W = $(window),
      D = $(document),
      deviceWidth = 0;
  function PlaceSideMenuPosition() {
    var $el = $('.header-sticky');
    var bottom = $el.offset().top + $el.outerHeight();

    $('.header_menu').css('top', bottom + 'px').toggleClass('active');
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

    $(".bdr-calendar").datepicker({
      changeMonth: true,
      changeYear: true
    });
  
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
  });

})(window, document, jQuery); // Fully reference jQuery after this point.

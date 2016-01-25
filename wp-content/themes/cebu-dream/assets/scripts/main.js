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
  
  D.ready(function() {
    
    $('.flexslider').flexslider({
      animation: "slide",
      start: function(slider){
        $('body').removeClass('loading');
      }
    });

    $( "#date_in,#date_out" ).datepicker();
  

  });

})(window, document, jQuery); // Fully reference jQuery after this point.

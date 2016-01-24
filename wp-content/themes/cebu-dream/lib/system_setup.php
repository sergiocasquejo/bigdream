<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ob_start();

define('CDR_SYSTEM_DIR', get_template_directory() . '/lib/bigdream');
define('CDR_SYSTEM_DIR_URI', get_template_directory_uri() . '/lib/bigdream');
define('CDR_ADMIN_DIR', CDR_SYSTEM_DIR . '/admin');
define('CDR_ADMIN_DIR_URI', CDR_SYSTEM_DIR_URI . '/admin');
define('BDR_MENU_POSITION', 6);

// Booking Statuses
define('BOOKING_STATUSES', json_encode(array('Unconfirmed', 'Complete', 'Not Paid', 'Cancelled')));
define('GUEST_TITLE', json_encode(array('Mr', 'Ms', 'Mrs')));

require_once "bigdream/functions.php";
require_once "bigdream/shortcodes.php";
require_once "bigdream/database-handler.php";
require_once "bigdream/admin/admin.php";



//http://blackrockdigital.github.io/startbootstrap-sb-admin-2/pages/index.html
//http://www.chartjs.org/
/**
* Booking Statuses
* Complete: All attendances on the booking are currently reserved.
* Unconfirmed: The initial email on the booking has not been confirmed. It is possible for the admin to manually confirm the booking but note that the attendee's email will not have been confirmed and therefore will not be included in bulk emails.
* Not paid: One or more attendees are not fully paid for (if a payment is required).
* Cancelled: The whole booking has been manually cancelled.
*/
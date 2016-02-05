<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
define( 'BDR_SYSTEM_DIR', get_template_directory() . '/lib/core' );
define( 'BDR_SYSTEM_DIR_URI', get_template_directory_uri() . '/lib/core' );
define( 'BDR_MENU_POSITION', 6 );
define( 'BDR_TEXT_DOMAIN', 'bigdreamresidences' );
define( 'ROOM_DEFAULT_STATUS', 'VACANT CLEAN' );
define( 'BOOKING_DEFAULT_STATUS', 'NEW' );
define( 'PAYMENT_DEFAULT_STATUS', 'UNPAID' );
define( 'CURRENCY_CODE', 'Php' );
define( 'TEST_MODE', true );
define( 'DEFAULT_PER_PAGE', 20 );



include "core/class/booking.class.php";


include "core/includes/functions.php";
include "core/includes/shortcodes.php";
include "core/includes/database-handler.php";
include "core/includes/hooks.php";
include "core/includes/admin.php";


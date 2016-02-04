<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
define('BDR_SYSTEM_DIR', get_template_directory() . '/lib/bigdreams');
define('BDR_SYSTEM_DIR_URI', get_template_directory_uri() . '/lib/bigdreams');
define('BDR_ADMIN_DIR', BDR_SYSTEM_DIR . '/admin');
define('BDR_ADMIN_DIR_URI', BDR_SYSTEM_DIR_URI . '/admin');
define('BDR_MENU_POSITION', 6);
define('BDR_TEXT_DOMAIN', 'bigdreamresidences');
define('ROOM_DEFAULT_STATUS', 'VACANT CLEAN');
define('BOOKING_DEFAULT_STATUS', 'NEW');
define('PAYMENT_DEFAULT_STATUS', 'UNPAID');
define('CURRENCY_CODE', 'Php');
define('TEST_MODE', true);


include "bigdreams/functions.php";
include "bigdreams/inc/shortcodes.php";
include "bigdreams/inc/database-handler.php";
include "bigdreams/inc/gump.class.php";
include "bigdreams/inc/hooks.php";
include "bigdreams/admin/admin.php";

<?php
function get_total_available_rooms( $room_type_ID, $from, $to ) {
  $exclude = array();

  $range = get_dates_from_date_range( $from, $to );
  foreach ( $range as $i => $k ) {
    if ( $guests = get_guest_calendar_by_room_and_datein( $room_type_ID, format_db_date( $k ) ) ) {
      foreach ( $guests as $g ) {
        $exclude[] = $g->room_ID;
      }
    }
  }



  return count( get_rooms_by_type( $room_type_ID, $exclude ) ); //->found_posts;
}

function print_me( $data ) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}
/**
 * nf()
 * 
 * Format number
 * 
 * @param Float $number
 * @param Int $decimals
 * @param String $decimal_point
 * @param String $thousands_sep
 * @return none
 */

if( !function_exists( 'nf' ) ) {
  function nf( $number , $decimals = 2 , $dec_point = "." , $thousands_sep = "," ) {
    return number_format( $number, $decimals, $dec_point, $thousands_sep );
  }
}

/**
 * room_code()
 * 
 * Get room number/room code by room id
 * 
 * @param Int $room_id
 * @return String $room_code
 */

function room_code( $room_id ) {
  return get_field( 'room_code', $room_id );
}


function assets( $file, $echo = false ) {
  $assets = BDR_SYSTEM_DIR_URI . '/assets/'. $file;

  if ( ! $echo ) return $assets;

  echo $assets;
}

function featured_image( $post_id, $size = 'thumbnail', $placeholder = '' ) {
  $featured_image = $placeholder;

  if ( has_post_thumbnail( $post_id ) ) {
    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size )[0];
  }

  return $featured_image;
}


function get_room_type( $post_id ) {
  return get_field( 'room_type', $post_id);
}

function category_featured_image( $term_id, $size = 'gallery-thumbnail', $placeholder = '' ) {
  $featured_image = $placeholder; 

  if ( ( $image = get_field( 'featured_image', 'room_type-cat_'. $term_id ) ) != '' ) {
    $featured_image = isset( $image['sizes'][$size] ) ? $image['sizes'][$size] : $image['url'];
  }

  return $featured_image;
}


function array_data( $arr, $key, $default = '' ) {
  return isset( $arr[$key] ) ? $arr[$key] : $default;
}

function browser_request( $key, $default = '' ) {
  return isset( $_REQUEST[$key] ) ? $_REQUEST[$key] : $default;
}


function browser_get( $key, $default = '' ) {
  return isset( $_GET[$key] ) ? $_GET[$key] : $default;
}

function browser_post( $key, $default = '' ) {
  return isset( $_POST[$key] ) ? $_POST[$key] : $default;
}


function include_view( $file, $data = array() ) {

  extract( $data );
  
  include BDR_SYSTEM_DIR . '/views/'. $file;
}

function require_class( $file, $once = true ) {
  $file = BDR_SYSTEM_DIR . '/class/'. $file;
  
  if ( $once ) {
    require_once $file;
  } else {
    require $file;
  }

}


function room_statuses() {
  return array( 'VACANT CLEAN', 'OCCUPIED', 'VACANT DIRTY', 'OUT OF ORDER', 'OUT OF SERVICE' );
}

function booking_statuses() {
  return array( 'NEW', 'CONFIRMED', 'ARRIVED', 'CHECKOUT' );
}


function payment_statuses() {
  return array( 'UNPAID', 'PARTIAL', 'PAID' );
}

function salutations() {
  return array( 'Mr', 'Ms', 'Mrs' );
}

function countries() {
  return array( "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe" );
}

/**
 * redirect_js_script()
 * 
 * Print redirect javascript
 * 
 * @param String $url
 * @return Boolean
 */

function redirect_js_script( $url ) {
  echo '<script>';
  echo 'window.location.replace("'. $url .'")';
  echo '</script>';
}
/**
 * add_this_notices()
 * 
 * Add notice message
 * 
 * @param String $type
 * @param String $message
 * @return none
 */
function add_this_notices( $type, $message ) {
  $_SESSION['_notices'][] = array( 'type' => $type, 'message' => $message );
}

/**
 * has_notices()
 * 
 * Check if there is notices
 * 
 * @param none
 * @return Boolean
 */
 
function has_notices() {
  return count( get_notices() ) > 0;
}

/**
 * get_notices()
 * 
 * Return notices
 * 
 * @param none
 * @return Array $notices
 */
 
function get_notices() {
  return array_data( $_SESSION, '_notices', array() );
}

/**
 * site_notices()
 * 
 * Print|Return notices when exists
 * 
 * @param Boolean $echo
 * @return String $notices
 */
 
 
if ( !function_exists( 'site_notices' ) ) {

  function site_notices( $echo = true ) {

    $output = '';
    if ( has_notices() ) {
      $output .= '<div class="notices-box">';
        $output .= '<div class="container">';
        $notices = get_notices();
        
        foreach ($notices as $i => $n) {
          $output .= '<div class="'. (!isset($n['type']) ? 'updated' : $n['type']) .'">';
                $output .= '<p>'. $n['message'] .'</p>';
            $output .= '</div>';
        }
        unset($_SESSION['_notices']);
        $output .= '</div>';
      $output .= '</div>';
    }

    if ( !$echo ) return $output;
    
      echo $output;
  }

}


/**
 * modal_notices()
 * 
 * Print modal notices when exists
 * 
 * @param none
 * @return none
 */
 
function modal_notices() {
  $output = '';
  if (has_notices()) {
    $output .= '<div id="bigdreamNoticesModal" class="modal fade bs-notice-modal-sm" tabindex="-1" role="dialog" aria-labelledby="bigdreamNoticeModal">';
      $output .= '<div class="modal-dialog modal-sm">';
        $output .= '<div class="modal-content">';
          $output .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
          $output .= bigdream_notices(false);
        $output .= '</div>';
      $output .= '</div>';
    $output .= '</div>';
  }
  echo $output;
}


/**
 * push_to_booking_session()
 * 
 * Push data to session variable
 * 
 * @param none
 * @return Array $booking_data
 */
 
function push_to_booking_session( $args ) {
  $current = isset($_SESSION['_bdr_booking']) ? $_SESSION['_bdr_booking'] : array();
  $_SESSION['_bdr_booking'] = array_merge( $current, $args );
  
  return get_booking_session();
}

function empty_booking() {
  $_SESSION['_bdr_booking'] = array();
  unset( $_SESSION['_bdr_booking'] );
}


function is_empty_booking() {
  return isset( $_SESSION['_bdr_booking'] ) && count( $_SESSION['_bdr_booking'] ) > 0 ? false : true;
}
/**
 * get_booking_session()
 * 
 * Get booking data from session
 * 
 * @param none
 * @return Array $booking_data
 */
 
function get_booking_session() {
  return isset( $_SESSION['_bdr_booking'] ) ? $_SESSION['_bdr_booking'] : array();
}


 


add_action('wp_footer', 'print_javascript_notices');
function print_javascript_notices( $echo = true ) {
  $errors = '';
  if (isset($_SESSION['javascript_error_notice'])) {
    $errors = $_SESSION['javascript_error_notice'];
    unset($_SESSION['javascript_error_notice']);

    if ( ! $echo ) return $errors;

    echo $errors;
  }
}


function javacript_notices($errors = array()) {
  if (count($errors) > 0) {
    $output = '';
    $output .= '<script>
    jQuery(function($) {';

      foreach ($errors as $k => $v) {
        $output .= '$("<span class=\'error_field\'>'.$v. '</span>").insertAfter($(\':input[name="'. $k .'"]\'));';
      }
    $output .= '});
    </script>';

    $_SESSION['javascript_error_notice'] = $output;
  }
}

/**
 * booking_data()
 * 
 * Get booking data by key
 * 
 * @param String $key
 * @param String $default
 * @return String $array_value
 */
function booking_data($key, $default = '') {
  $booking = isset($_SESSION['_bdr_booking']) ? $_SESSION['_bdr_booking'] : array();

  return isset($booking[$key]) ? $booking[$key] : $default;
}

function get_array_values_by_keys( $data = array(), $keys = array() ) {
  $arr = array();
  foreach ( $keys as $i => $k ) {
    $arr[$k] = array_data($data, $k, '');
  }
  return $arr;
}

/**
 * get_room_price()
 * 
 * Get unformatted room price
 * 
 * @param int $id - Room/Post ID
 * @return Decimal $price
 */
function get_room_price($id = false, $date_in = false, $date_out = false) {
  if (!$id) {
    global $post;
    $id = $post->ID;
  }
  
  $price = get_field('price', $id);

  if ( $date_in && $date_out ) {

    $date_in = strtotime( $date_in );
    $date_out = strtotime( $date_out );

    if ( have_rows( 'price_configuration', $id ) ) {

      while ( have_rows( 'price_configuration', $id ) ) { the_row();

        if ( get_sub_field( 'enable' ) ) {

          $from = strtotime( get_sub_field( 'from' ) );
          $to = strtotime( get_sub_field( 'to' ) );
          if ( ( $date_in >= $from && $date_in <= $to ) && ( $date_out >= $from && $date_out <= $to ) ) {
            $price = get_sub_field( 'price' );
            break;
          }
        }
      }
    }
  }

  return (float) $price;
}

function get_sub_total( $room_ID = false, $date_in = false, $date_out = false ) {
  $price = get_room_price( $room_ID, $date_in, $date_out );
  $nights = count_nights( $date_in, $date_out );
  $amount = $price * $nights;;

  return $amount;
}

/**
 * the_room_price()
 * 
 * Print unformatted price
 * 
 * @param int $id - Room/Post ID
 * @return none
 */
function the_room_price($id = false) {
  if (!$id) {
    global $post;
    $id = $post->ID;
  }
  $price = get_field('price', $id);

  echo $price;
}

/**
 * the_room_price_html()
 * 
 * Print HTML formatted price with currency code
 * 
 * @param int $id - Room/Post ID
 * @return String $formatted_price
 */
function the_room_price_html($id = false) {
  echo get_room_price_html($id);
}

/**
 * get_room_price_html()
 * 
 * Return HTML formatted price with currency code
 * 
 * @param int $id - Room/Post ID
 * @return String $formatted_price
 */
function get_room_price_html($id = false) {
  return sprintf('<span class="amount">%s %s</span>', CURRENCY_CODE, nf(get_room_price($id)));
}

/**
 * format_price()
 * 
 * Print formatted price
 * 
 * @param Decimal $price
 * @return none
 */
function format_price($price = 0, $echo = true) {
  if ( is_numeric( $price ) ) {
    $price = sprintf('<span class="amount">%s %s</span>', CURRENCY_CODE, nf($price));

    if (!$echo) {
      return $price;
    }
    
  }
  echo $price;
}

/**
 * get_booking_steps()
 * 
 * Return booking steps/indicator
 * 
 * @param none
 * @return String $indicator
 */

function get_booking_steps() {
  $output = '';
  $output .= '<div class="reservation_step">';
        $output .= '<ul>';
            $output .= '<li><a href="#"><span>1.</span>  Choose Date</a></li>';
            $output .= '<li class="active"><a href="#"><span>2.</span> Choose Room</a></li>';
            $output .= '<li><a href="#"><span>3.</span> Make a Reservation</a></li>';
            $output .= '<li><a href="#"><span>4.</span> Confirmation</a></li>';
        $output .= '</ul>';
    $output .= '</div>';

    return $output;
}

/**
 * format_date()
 * 
 * Format date to readable date
 * 
 * @param String $date
 * @param String $format
 * @return String $formatted_date
 */
 
function format_date( $date,  $format = 'D m/d/Y' ) {
  return date( $format, strtotime( $date ) );
}

/**
 * format_db_date()
 * 
 * Format date to mysql/database date
 * 
 * @param String $date
 * @param String $format
 * @return String $formatted_date
 */
function format_db_date( $date, $format = 'Y-m-d' ) {
  return date( $format, strtotime( $date ) ); 
}


function redirect_by_page_path($path) {
  exit( wp_redirect( page_permalink( $path ) ) );
}

function page_permalink( $path ) {
  return get_permalink( get_page_by_path( $path ) );
}

/**
 * count_nights()
 * 
 * Counts number of nights between two dates
 * 
 * @param Date $from
 * @param Date $to
 * @return Int $total_nights
 */
function count_nights( $from, $to ) {
  $now = strtotime( $to ); // or your date as well
  $date = strtotime( $from );
  $datediff = $now - $date;

  $nights = floor( $datediff / ( 60 * 60 * 24 ) );

  $nights = $nights <= 0 ? 1 : $nights;

  return $nights;
}
/**
 * get_dates_from_date_range()
 * 
 * Get dates between two dates
 * 
 * @param Date $from
 * @param Date $to
 * @return Array $dates
 */
function get_dates_from_date_range( $from, $to, $format = 'Y-m-d' ) {
  $dates = array();
  $current = strtotime( $from );
  $end = strtotime( $to );
  
  while ( $current <= $end ) {
      $dates[] = date( $format, $current );
      $current = strtotime( '+1 days', $current );
  }
  
  return $dates;
}

function unavailable_dates( $room_type_ID ) {
  $dates = get_room_unavailable_schedule( $room_type_ID );

  $arr = array();
  for( $i = 0; $i < count( $dates ); $i++ ) {
      $arr = array_merge( $arr, get_dates_from_date_range( $dates[$i]['date_in'], $dates[$i]['date_out'], 'm/d/Y' ) );
      
  }

  return $arr;
}

/**
 * send_success_booking_notification()
 * 
 * Send Email notification when successful booking
 * @param none
 * @return none
 */
function send_success_booking_notification( $booking_ID ) {
  ob_start();
  
  $d = get_booking_by_id( $booking_ID );
  $d['room_title'] = get_the_title( $d['room_ID'] );
  $d['room_code'] = get_field( 'room_code', $d['room_ID'] );
  $d['max_person'] = get_field( 'max_person', $d['room_ID'] );
  $d['room_size'] = get_field( 'room_size', $d['room_ID'] );
  $d['bed'] = get_field( 'bed', $d['room_ID'] );
  $d['view'] = get_field( 'view', $d['room_ID'] );

  $logo = get_template_directory_uri() . '/dist/images/logo.png';
  
  include BDR_SYSTEM_DIR . "/emails/success_booking_notification.php";
  $message = ob_get_clean();

  add_filter( 'wp_mail_content_type',create_function( '', 'return "text/html"; ' ) );
  //Send to admin
  $to = get_bloginfo( 'admin_email' );
  $subject = 'New Reservation';
  wp_mail( $to, $subject, $message );
  
  // Send to guest
  $to = $d['email_address'];
  $subject = 'Your Booking Details';
  wp_mail( $to, $subject, $message );

}


function get_monthly_chart_sales() {

  $arr = array();

  for ( $i = 0; $i < 12; $i++ ) {
     $arr['amount'][$i] = 0;
     $arr['amount_paid'][$i] = 0;
  }

  $sales = get_monthly_sales();

  foreach( $sales as $i => $s ) {
    $arr['amount'][$s['month'] - 1] = round( $s['amount'], 2 );
    $arr['amount_paid'][$s['month'] - 1] = round( $s['amount_paid'], 2 );
  }

  return $arr;
}

function is_bookable( $room_ID ) {
  return get_field( 'room_status', $room_ID ) != 'out_of_order';
}


function is_date_and_room_not_available( $room_ID, $from , $to, $booking_ID = 0 ) {
  
  $range = get_dates_from_date_range( $from, $to );
  foreach ( $range as $i => $k ) {
    if ( is_selected_date_and_room_not_available( $room_ID, format_db_date( $k ), $booking_ID ) > 0 ) {
      return true;
    }
  }
  
  return false;
}

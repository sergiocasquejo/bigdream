<div class="wrap">
  <h1>New Booking <a href="<?php echo admin_url('/admin.php?page=manage-bookings'); ?>" class="page-title-action">Back to Listing</a></h1>
  <div class="gap-20"></div>
  <?php site_notices(); print_javascript_notices(); ?>
  <div class="row">
    <div class="col-md-6">
      <?php if ( $booking_ID > 0 ): ?>
      <h1>Booking #: <?php echo $booking_no; ?></h1>
      <?php endif; ?>
      <div id="priceCalculation">
        <ul>
          <li>Room Price: <span class="room_price"><?php echo format_price( $room_price ); ?></span></li>
          <li>Total Room: <span class="total_rooms"><?php echo ' x ' . $no_of_room; ?></span></li>
          <li>Total Nights: <span class="total_nights"><?php echo ' x ' . $no_of_night; ?></span></li>
          <li>Total Amount: <span class="total_amount"><?php echo format_price( $amount ); ?></span></li>
        </ul>
      </div>
      <form method="post">
        <div class="row">
          <div class="col-md-6 form-group">
            <label class="form-label" for="first_name">Room</label>
            <select name="room_type_ID" class="form-control editable" required <?php disabled( $editable, false ); ?>>
              <?php foreach ($available_rooms as $i => $r): ?>
                <option value="<?php echo $r->ID; ?>" <?php selected($r->ID, $room_type_ID); ?>><?php echo get_the_title( $r->ID ); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="amount_paid">Amount Paid</label>
            <input type="number" name="amount_paid" class="form-control" value="<?php echo $amount_paid; ?>" />
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="booking_status">Payment Status</label>
            <select name="payment_status" class="form-control" required>
              <?php foreach ($payment_statuses as $s): ?>
              <option value="<?php echo $s; ?>" <?php selected($s, $payment_status); ?>><?php echo $s; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 form-group">
            <label class="form-label" for="first_name">Salutation</label>
            <select name="salutation" class="form-control" required>
              <?php foreach ($salutations as $t): ?>
              <option value="<?php echo $t; ?>" <?php selected($t, $salutation); ?>><?php echo $t; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>" required/>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="first_name">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>" required/>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="middle_name">Middle Name</label>
            <input type="text" name="middle_name" class="form-control" value="<?php echo $middle_name; ?>" required/>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 form-group">
            <label class="form-label" for="birth_date">Date of Birth</label>
            <input type="text" name="birth_date" class="form-control bdr-calendar" value="<?php echo $birth_date; ?>" required/>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="email_address">Email Address</label>
            <input type="email" name="email_address" class="form-control" value="<?php echo $email_address; ?>" required/>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="primary_phone">Primary Phone</label>
            <input type="text" name="primary_phone" class="form-control" value="<?php echo $primary_phone; ?>" required/>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="nationality">Nationality</label>
            <input type="text" name="nationality" class="form-control" value="<?php echo $nationality; ?>" required/>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 form-group">
            <label class="form-label" for="address_1">Address 1</label>
            <input type="text" name="address_1" class="form-control" value="<?php echo $address_1; ?>" required/>
          </div>
          <div class="col-md-6 form-group">
            <label class="form-label" for="address_2">Address 2</label>
            <input type="text" name="address_2" class="form-control" value="<?php echo $address_2; ?>" />
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 form-group">
            <label class="form-label" for="country">Country</label>
            <input type="text" name="country" class="form-control" value="<?php echo $country; ?>" required/>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="province">Province</label>
            <input type="text" name="province" class="form-control" value="<?php echo $province; ?>" required/>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="province">City</label>
            <input type="text" name="city" class="form-control" value="<?php echo $city; ?>" required/>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="province">Zip Code</label>
            <input type="text" name="zipcode" class="form-control" value="<?php echo $zipcode; ?>" required/>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 form-group">
            <label class="form-label" for="date_in">Date In</label>
            <input type="text" name="date_in" class="form-control date_in editable" value="<?php echo $date_in; ?>" required <?php disabled( $editable, false ); ?>/>
          </div>
          <div class="col-md-6 form-group">
            <label class="form-label" for="date_out">Date Out</label>
              <input type="text" name="date_out" class="form-control date_out editable" value="<?php echo $date_out; ?>" required <?php disabled( $editable, false ); ?>/>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 form-group">
            <label class="form-label" for="no_of_room">No of Room</label>
            <select name="no_of_room" class="form-control editable" required <?php disabled( $editable, false ); ?>>
              <option value="1">1</option>
            </select>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="date_in">No of Adult</label>
            <input type="text" name="no_of_adult" class="form-control editable" value="<?php echo $no_of_adult; ?>" required <?php disabled( $editable, false ); ?>/>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="date_out">No of Child</label>
            <input type="text" name="no_of_child" class="form-control editable" value="<?php echo $no_of_child; ?>" required <?php disabled( $editable, false ); ?>/>
          </div>
          <div class="col-md-3 form-group">
            <label class="form-label" for="booking_status">Booking Status</label>
            <select name="booking_status" class="form-control" required>
              <?php foreach ($booking_statuses as $s): ?>
              <option value="<?php echo $s; ?>" <?php selected($s, $booking_status); ?>><?php echo $s; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 form-group">
            <label class="form-label" for="amount_paid">Notes</label>
            <textarea name="notes" class="form-control"><?php echo $notes; ?></textarea>
          </div>
        </div>
        <div class="gap-30"></div>
        <input type="hidden" name="action" value="save_booking" />
        <input type="hidden" name="booking_ID" id="booking_ID" value="<?php echo $booking_ID; ?>" />
        <?php wp_nonce_field( 'save_booking_action', 'save_booking_field' ); ?>
        <input type="submit" value="Save" class="button button-primary" />
      </form>
    </div>
    <div class="col-md-6">
      <h1>
        Rooms 
        <button class="button button-default" id="EditRoom" <?php disabled( $no_of_room <= count($rooms_and_guest) || $booking_ID <= 0, true ); ?>><span class="dashicons dashicons-plus"></span> Add Room</button>
      </h1>
      <div id="roomsAndGuestInfoWrapper">
        <?php include "rooms_and_guest_info.html.php"; ?>
      </div>
    </div>
  </div>

</div>
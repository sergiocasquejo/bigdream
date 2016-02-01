<div class="wrap">
  <h1>New Booking <a href="<?php echo admin_url('/admin.php?page=big-dream-bookings'); ?>" class="page-title-action">Back to Listing</a></h1>
  <div class="gap-30"></div>
  <?php bigdream_notices(); print_javascript_notices(); ?>
  <form method="post">
    <div class="row">
      <div class="col-md-6 form-group">
        <label class="form-label" for="first_name">Room Type</label>
        <select name="room_ID" class="form-control" required>
          <?php foreach ($available_rooms as $i => $r): ?>
            <option value="<?php echo $r->ID; ?>" <?php selected($r->ID, $post['room_ID']); ?>><?php echo $r->post_title; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6 form-group">
        <label class="form-label" for="amount_paid">Amount Paid</label>
        <input type="number" name="amount_paid" class="form-control" value="<?php echo $post['amount_paid']; ?>" />
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 form-group">
        <label class="form-label" for="first_name">Salutation</label>
        <select name="salutation" class="form-control" required>
          <?php foreach ($guest_title as $t): ?>
          <option value="<?php echo $t; ?>" <?php selected($t, $post['salutation']); ?>><?php echo $t; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3 form-group">
        <label class="form-label" for="first_name">First Name</label>
        <input type="text" name="first_name" class="form-control" value="<?php echo $post['first_name']; ?>" required/>
      </div>
      <div class="col-md-3 form-group">
        <label class="form-label" for="first_name">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="<?php echo $post['last_name']; ?>" required/>
      </div>
      <div class="col-md-3 form-group">
        <label class="form-label" for="middle_name">Middle Name</label>
        <input type="text" name="middle_name" class="form-control" value="<?php echo $post['middle_name']; ?>" required/>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 form-group">
        <label class="form-label" for="birth_date">Date of Birth</label>
        <input type="text" name="birth_date" class="form-control" value="<?php echo $post['birth_date']; ?>" required/>
      </div>
      <div class="col-md-3 form-group">
        <label class="form-label" for="email_address">Email Address</label>
        <input type="email" name="email_address" class="form-control" value="<?php echo $post['email_address']; ?>" required/>
      </div>
      <div class="col-md-3 form-group">
        <label class="form-label" for="primary_phone">Primary Phone</label>
        <input type="text" name="primary_phone" class="form-control" value="<?php echo $post['primary_phone']; ?>" required/>
      </div>
      <div class="col-md-3 form-group">
        <label class="form-label" for="nationality">Nationality</label>
        <input type="text" name="nationality" class="form-control" value="<?php echo $post['nationality']; ?>" required/>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 form-group">
        <label class="form-label" for="address_1">Address 1</label>
        <input type="text" name="address_1" class="form-control" value="<?php echo $post['address_1']; ?>" required/>
      </div>
      <div class="col-md-6 form-group">
        <label class="form-label" for="address_2">Address 2</label>
        <input type="text" name="address_2" class="form-control" value="<?php echo $post['address_2']; ?>" />
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 form-group">
        <label class="form-label" for="country">Country</label>
        <input type="text" name="country" class="form-control" value="<?php echo $post['country']; ?>" />
      </div>
      <div class="col-md-3 form-group">
        <label class="form-label" for="province">Province</label>
        <input type="text" name="province" class="form-control" value="<?php echo $post['province']; ?>" />
      </div>
      <div class="col-md-3 form-group">
        <label class="form-label" for="province">City</label>
        <input type="text" name="city" class="form-control" value="<?php echo $post['city']; ?>" />
      </div>
      <div class="col-md-3 form-group">
        <label class="form-label" for="province">Zip Code</label>
        <input type="text" name="zipcode" class="form-control" value="<?php echo $post['zipcode']; ?>" />
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 form-group">
        <label class="form-label" for="date_in">Date In</label>
        <input type="text" name="date_in" class="form-control" value="<?php echo $post['date_in']; ?>" required/>
      </div>
      <div class="col-md-6 form-group">
        <label class="form-label" for="date_out">Date Out</label>
        <input type="text" name="date_out" class="form-control" value="<?php echo $post['date_out']; ?>" required/>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 form-group">
        <label class="form-label" for="date_in">No of Adult</label>
        <input type="text" name="no_of_adult" class="form-control" value="<?php echo $post['no_of_adult']; ?>" required/>
      </div>
      <div class="col-md-3 form-group">
        <label class="form-label" for="date_out">No of Child</label>
        <input type="text" name="no_of_child" class="form-control" value="<?php echo $post['no_of_child']; ?>" required/>
      </div>
      <div class="col-md-6 form-group">
        <label class="form-label" for="booking_status">Booking Status</label>
        <select name="booking_status" class="form-control" required>
          <?php foreach ($booking_statuses as $s): ?>
          <option value="<?php echo $s; ?>" <?php selected($s, $post['booking_status']); ?>><?php echo $s; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 form-group">
        <label class="form-label" for="amount_paid">Notes</label>
        <textarea name="notes" class="form-control"><?php echo $post['notes']; ?></textarea>
      </div>
    </div>
    <div class="gap-30"></div>
    <input type="hidden" name="booking_ID" value="<?php echo $post['booking_ID']; ?>" />
    <?php wp_nonce_field( 'save_booking_action', 'save_booking_field' ); ?>
    <input type="submit" value="Save" class="button button-primary" />
  </form>
</div>

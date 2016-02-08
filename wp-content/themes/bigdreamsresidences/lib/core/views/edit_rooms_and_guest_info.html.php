<div class="rooms-and-guest-info">
  <form id="roomsAndGuestInfoForm">
    <div class="form-group">
      <label for="room">Room</label>
      <select name="room_ID" class="form-control" required>
        <?php foreach( $rooms as $i => $r ): ?>
        <option value="<?php echo $r->ID; ?>" <?php selected( $r->ID, $room_ID ); ?>><?php echo $r->post_title; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label for="guest">Guest</label>
      <input type="text" name="guest" class="form-control" value="<?php echo $guest; ?>" required/> 
    </div>
    <div class="form-group">
      <label for="phone">Phone</label>
      <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>"/> 
    </div>
    <div class="form-group">
      <label for="number">Adults</label>
      <input type="text" name="no_of_adult" class="form-control" value="<?php echo $no_of_adult; ?>" required/> 
    </div>
    <div class="form-group">
      <label for="no_of_child">Children</label>
      <input type="number" name="no_of_child" class="form-control" value="<?php echo $no_of_child; ?>"  required/> 
    </div>
    <input type="hidden" name="booking_room_ID" value="<?php echo (int) $booking_room_ID; ?>" />
    <button type="submit" class="button button-primary">Save</button>
  </form>
</div>
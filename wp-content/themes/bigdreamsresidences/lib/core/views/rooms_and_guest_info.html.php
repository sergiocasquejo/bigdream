<div class="rooms-and-guest-info">
  <form id="roomsAndGuestInfoForm">
    <div class="form-group">
      <label for="room">Room</label>
      <select name="room_ID" class="form-control">
        <?php foreach( $rooms as $i => $r ): ?>
        <option value="<?php echo $r->ID; ?>"><?php echo $r->post_title; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label for="guest">Guest</label>
      <input type="text" name="guest" class="form-control" /> 
    </div>
    <div class="form-group">
      <label for="phone">Phone</label>
      <input type="text" name="phone" class="form-control" /> 
    </div>
    <div class="form-group">
      <label for="no_of_adult">Adults</label>
      <input type="text" name="no_of_adult" class="form-control" /> 
    </div>
    <div class="form-group">
      <label for="no_of_child">Children</label>
      <input type="text" name="no_of_child" class="form-control" /> 
    </div>
    <button type="submit" class="button button-primary">Save</button>
  </form>
</div>
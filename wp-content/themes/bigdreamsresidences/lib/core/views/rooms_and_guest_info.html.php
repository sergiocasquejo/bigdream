<table class="wp-list-table widefat fixed striped posts">
    <thead>
      <tr>
        <th width="80px;">Room</th>
        <th>Type</th>
        <th>Guest</th>
        <th>Phone</th>
        <th>Adults</th>
        <th>Children</th>
        <th>Check In</th>
        <th>Check Out</th>
        <th width="80px;"></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ( $rooms_and_guest as $i => $r ): ?>
      <tr>
        <td><?php echo $r['room_title']; ?></td>
        <td><?php echo get_room_type ( $r['room_ID'] )->post_title; ?></td>
        <td><?php echo $r['guest']; ?></td>
        <td><?php echo $r['phone']; ?></td>
        <td><?php echo $r['no_of_adult']; ?></td>
        <td><?php echo $r['no_of_child']; ?></td>
        <td><?php echo $r['date_in']; ?></td>
        <td><?php echo $r['date_out']; ?></td>
        <td>
          <div class="actions">
            <a href="#" title="Edit" class="edit-rooms-and-guest" data-brid="<?php echo $r['booking_room_ID']; ?>"><span class="dashicons dashicons-edit"></span></a>
            <a href="#" title="Trash" class="delete-rooms-and-guest" data-brid="<?php echo $r['booking_room_ID']; ?>"><span class="dashicons dashicons-trash"></span></a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
</table>
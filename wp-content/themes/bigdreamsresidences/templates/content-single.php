<?php while ( have_posts() ) : the_post(); 
$rooms_available = get_total_available_rooms( get_the_ID(), booking_data( 'date_in' ), booking_data( 'date_out' ) );?>
<div class="section-room bg-white">
    <div class="container">
        <div class="room-detail">
            <div class="row">
                <div class="col-lg-9">
                    <div class="room_detail_gallery">
                        <div class="slider">
                            <div class="flexslider">
                                <ul class="slides">
                                    <?php while( have_rows( 'gallery' ) ): the_row(); 
                                    $image = get_sub_field( 'image' )['sizes']['gallery-post-thumbnails'];?>
                                    <li><img src="<?php echo $image; ?>" /></li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="room-detail_book">
                        <form method="post">
                            <div class="room-detail_total">
                                <h6>STARTING ROOM FROM</h6>
                                <p class="price">
                                    <?php the_room_price_html(); ?>  /days
                                </p>
                            </div>
                            <div class="room-detail_form">
                                <div class="form-group">
                                    <label>Arrive</label>
                                    <input type="text" name="date_in" id="date_in" class="date form-control" placeholder="Arrive Date" value="<?php echo booking_data( 'date_in' ); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Depature</label>
                                    <input type="text" name="date_out" id="date_out" class="date form-control" placeholder="Departure Date" value="<?php echo booking_data( 'date_out' ); ?>"  required>
                                </div>
                                <div class="form-group">
                                    <label>No of Room</label>
                                    <select name="no_of_room" class="form-group" <?php disabled($rooms_available == 0, true); ?>>
                                        <?php for( $i = 1; $i <= $rooms_available; $i++ ): ?>
                                        <option value="<?php echo $i; ?>" <?php selected( $i, booking_data( 'no_of_room' ) ); ?>><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Adult</label>
                                        <select name="no_of_adult" class="form-group">
                                            <?php for( $i = 1; $i <= 10; $i++ ): ?>
                                            <option value="<?php echo $i; ?>" <?php selected( $i, booking_data( 'no_of_adult' ) ); ?>><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Child</label>
                                        <select name="no_of_child" class="form-group">
                                            <option value="0"></option>
                                            <?php for( $i = 1; $i <= 10; $i++ ): ?>
                                            <option value="<?php echo $i; ?>" <?php selected( $i, booking_data( 'no_of_child' ) ); ?>><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="room_type_ID" value="<?php the_ID(); ?>" />
                                <input type="hidden" name="action" value="book_room" />
                                <?php if( $rooms_available > 0 ): ?>
                                <button type="submit" class="bdr-btn bdr-btn-fill-black">Book Now</button>
                                <?php else: ?>
                                <button type="submit" class="bdr-btn bdr-btn-fill-red" disabled>No more rooms available.</button>
                                <?php endif; ?>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="room-detail_tab">
            <div class="row">
                <div class="col-md-3">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs room-detail_tab-header" role="tablist">
                        <li role="presentation" class="active"><a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Overview</a></li>
                        <li role="presentation"><a href="#aminities" aria-controls="aminities" role="tab" data-toggle="tab">Aminities</a></li>
                        <li role="presentation"><a href="#prices" aria-controls="prices" role="tab" data-toggle="tab">Rates</a></li>
                        <li role="presentation"><a href="#calendar" aria-controls="calendar" role="tab" data-toggle="tab">Calendar</a></li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <!-- Tab panes -->
                    <div class="room-detail_tab-content tab-content">
                        <div role="tabpanel" class="tab-pane active" id="overview">
                            <div class="room-detail_overview">
                                <p><?php the_content(); ?></p>

                                <div class="row">
                                    <div class="col-xs-6 col-md-4">
                                        <h6>SPECIAL ROOM</h6>
                                        <ul>
                                            <li>Max: <?php the_field( 'max_person' ); ?></li>
                                            <li>Size: <?php the_field( 'room_size' ); ?></li>
                                            <li>View: <?php the_field( 'view' ); ?></li>
                                            <li>Bed: <?php the_field( 'bed' ); ?></li>
                                        </ul>
                                    </div>
                                    <?php if ( have_rows( 'services' ) ): ?>
                                    <div class="col-xs-6 col-md-4">
                                        <h6>SERVICE ROOM</h6>
                                        <ul>
                                            <?php while( have_rows( 'services' ) ): the_row(); ?>
                                            <li><?php the_sub_field( 'title' ); ?></li>
                                            <?php endwhile; ?>
                                        </ul>
                                    </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="aminities">
                            <div class="room-detail_amenities">
                                <p><?php the_content(); ?></p>
                                <?php if ( have_rows( 'packages' ) ): ?>
                                <div class="row">
                                    <?php while ( have_rows( 'packages' ) ): the_row(); ?>
                                    <div class="col-xs-6 col-lg-4">
                                        <h6><?php the_sub_field( 'heading' ); ?></h6>
                                        <?php if ( have_rows( 'package_list' ) ): ?>
                                        <ul>
                                            <?php while ( have_rows( 'package_list' ) ): the_row(); ?>
                                            <li><?php the_sub_field( 'title' ); ?></li>
                                            <?php endwhile; ?>
                                        </ul>
                                        <?php endif; ?>    
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="prices">
                            <div class="room-detail_rates">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Rate Period</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ( have_rows( 'price_configuration', $id) ): ?>
                                            <?php while ( have_rows( 'price_configuration', $id) ): the_row(); 
                                                if ( get_sub_field( 'enable' ) ) :
                                                    $from = format_date( get_sub_field( 'from' ), 'D M d, Y' );
                                                    $to = format_date( get_sub_field( 'to' ), 'D M d, Y' );
                                                ?>
                                                <tr>
                                                    <td>
                                                        <ul>
                                                            <li><?php echo $from .' - '. $to; ?></li>
                                                            <li><?php echo count_nights( $from, $to); ?> night minimum stay</li>
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <p class="price"><?php format_price( get_sub_field( 'price' ) ); ?></p>
                                                    </td>
                                                </tr>
                                    <?php endif; 
                                    endwhile; ?>
                                <?php else: ?>    
                                    <tr>
                                        <td colspan="2">No rates available this time.</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="calendar">
                            <?php $dates = implode( ',', unavailable_dates( get_the_ID() )); ?>
                            <div class="room_calendar_availability" data-unavailable="<?php echo $dates; ?>"></div>
                            <div class="calendar_status text-center col-sm-12">
                                <span>Available</span>
                                <span class="not-available">Not Available</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>

</div>
<?php endwhile; ?>

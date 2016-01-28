<?php while (have_posts()) : the_post(); ?>
<div class="section-room bg-white">
    <div class="container">
        <div class="room-detail">
            <div class="row">
                <div class="col-lg-9">
                    <div class="room_detail_gallery">
                        <div class="slider">
                            <div class="flexslider">
                                <ul class="slides">
                                    <?php while(have_rows('gallery')): the_row(); 
                                    $image = get_sub_field('image')['sizes']['gallery-post-thumbnails'];?>
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
                                <label>Arrive</label>
                                <div class="form-group">
                                    <input type="text" name="date_in" id="date_in" class="date form-control" placeholder="Arrive Date" value="<?php echo booking_data('date_in'); ?>" required>
                                </div>
                                <label>Depature</label>
                                <div class="form-group">
                                    <input type="text" name="date_out" id="date_out" class="date form-control" placeholder="Departure Date" value="<?php echo booking_data('date_out'); ?>"  required>
                                </div>
                                <label>Adult</label>
                                <select name="no_of_adult" class="form-group">
                                    <?php for($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php selected($i, booking_data('no_of_adult')); ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label>Chirld</label>
                                <select name="no_of_child" class="form-group">
                                    <option value="0"></option>
                                    <?php for($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php selected($i, booking_data('no_of_child')); ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <input type="hidden" name="action" value="book_room" />
                                <input type="hidden" name="room_ID" value="<?php the_ID(); ?>" />
                                <button type="submit" class="bdr-btn bdr-btn-fill-red">Book Now</button>
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
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Overview</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Package</a></li>
                        <!--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Calendar</a></li>-->
                    </ul>
                </div>
                <div class="col-md-9">
                    <!-- Tab panes -->
                    <div class="room-detail_tab-content tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="room-detail_overview">
                                <h5 class="text-uppercase">de Finibus Bonorum et Malorum", written by Cicero in 45 BC</h5>
                                <p>Located in the heart of Aspen with a unique blend of contemporary luxury and historic heritage, deluxe accommodations, superb amenities, genuine hospitality and dedicated service for an elevated experience in the Rocky Mountains.</p>

                                <div class="row">
                                    <div class="col-xs-6 col-md-4">
                                        <h6>SPECIAL ROOM</h6>
                                        <ul>
                                            <li>Max: 4 Person(s)</li>
                                            <li>Size: 35 m2 / 376 ft2</li>
                                            <li>View: Ocen</li>
                                            <li>Bed: King-size or twin beds</li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-6 col-md-4">
                                        <h6>SERVICE ROOM</h6>
                                        <ul>
                                            <li>Oversized work desk</li>
                                            <li>Hairdryer</li>
                                            <li>Iron/ironing board upon request</li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <div class="room-detail_amenities">
                                <p>Located in the heart of Aspen with a unique blend of contemporary luxury and historic heritage, deluxe accommodations, superb amenities, genuine hospitality and dedicated service for an elevated experience in the Rocky Mountains.</p>
                                
                                <div class="row">
                                    <div class="col-xs-6 col-lg-4">
                                        <h6>LIVING ROOM</h6>
                                        <ul>
                                            <li>Oversized work desk</li>
                                            <li>Hairdryer</li>
                                            <li>Iron/ironing board upon request</li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-6 col-lg-4">
                                        <h6>KITCHEN ROOM</h6>
                                        <ul>
                                            <li>AM/FM clock radio</li>
                                            <li>Voicemail</li>
                                            <li>High-speed Internet access</li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-6 col-lg-4">
                                        <h6>balcony</h6>
                                        <ul>
                                            <li>AM/FM clock radio</li>
                                            <li>Voicemail</li>
                                            <li>High-speed Internet access</li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-6 col-lg-4">
                                        <h6>bedroom</h6>
                                        <ul>
                                            <li>Coffee maker</li>
                                            <li>25 inch or larger TV</li>
                                            <li>Cable/satellite TV channels</li>
                                            <li>AM/FM clock radio</li>
                                            <li>Voicemail</li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-6 col-lg-4">
                                        <h6>bathroom</h6>
                                        <ul>
                                            <li>Dataport</li>
                                            <li>Phone access fees waived</li>
                                            <li>24-hour Concierge service</li>
                                            <li>Private concierge</li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-6 col-lg-4">
                                        <h6>Oversized work desk</h6>
                                        <ul>
                                            <li>Dataport</li>
                                            <li>Phone access fees waived</li>
                                            <li>24-hour Concierge service</li>
                                            <li>Private concierge</li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!--<div role="tabpanel" class="tab-pane" id="settings">
                            <div class="bdr-calendar"></div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>  
    </div>

</div>
<?php endwhile; ?>

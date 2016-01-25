<?php while (have_posts()) : the_post(); 
	$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full')[0]; ?>
	<section class="room-banner bdr-parallax" style="background:#eee url('<?php echo $featured_image; ?>');">
		<div class="bdr-overlay"></div>
		<div class="sub-banner">
			<div class="container">
				<div class="text text-center">
					<h2><?php the_title(); ?></h2>
					<p>Lorem ipsum dolor sit amit</p>
				</div>
			</div>
		</div>
	</section>
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
                        <div class="room-detail_total">
                            <h6>STARTING ROOM FROM</h6>
                            <p class="price">
                                <span class="amout">$260</span>  /days
                            </p>
                        </div>
                        <div class="room-detail_form">
                            <label>Arrive</label>
                            <div class="form-group">
                            	<input type="text" name="date_in" id="date_in" class="date form-control" placeholder="Arrive Date">
                           	</div>
                            <label>Depature</label>
                            <div class="form-group">
                            	<input type="text" name="date_out" id="date_out" class="date form-control" placeholder="Departure Date">
                            </div>
                            <label>Adult</label>
                            <select class="form-group">
                                <option>1</option>
                                <option>2</option>
                                <option selected="">3</option>
                                <option>4</option>
                            </select>
                            <label>Chirld</label>
                            <select class="form-group">
                                <option>1</option>
                                <option>2</option>
                                <option selected="">3</option>
                                <option>4</option>
                            </select>
                            <button class="bdr-btn bdr-btn-fill-red">Book Now</button>
                        </div>

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
						<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Calendar</a></li>
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
						<div role="tabpanel" class="tab-pane" id="settings">4</div>
					</div>
				</div>
			</div>
		</div>	
	</div>


<?php endwhile; ?>

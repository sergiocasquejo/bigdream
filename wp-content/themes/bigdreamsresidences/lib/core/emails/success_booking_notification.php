<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<style type="text/css">
	@import url(https://fonts.googleapis.com/css?family=Hind:400,300,500,600,700|Montserrat:400,700);
	html,body {
		min-height: 100%;
    	height: 100%;
	}
	body,span, a, p, strong, li, ul {
		font-family: 'Hind', sans-serif;
		color:#333;
	}
	h1, h2, h3, h4, h5 {
		font-family: 'Montserrat', sans-serif;
		color:#333;
	}
	ul:after {
		content: '';
		clear:both;
		display:block;
	}
	 body {margin: 0; padding: 0; min-width: 100%!important;}
	 .content:after {
	 	content:'';
	 	clear:both;
	 	display:block;
	 }
	 .amount {
	 	color:#FFF !important;
	 }
     .content-left {width: 30%; max-width: 300px;}  
     .content-right {width: 50%; max-width: 500px;}  
     @media only screen and (max-width: 500px) {
      	.content-left,
      	.content-right {
      		width:100% !important;
      	}

      	.content-right {
      		margin-left:0 !important;
      	}
      }
</style>
<body>
	<div style="padding: 50px 0;margin: 0;background: #333333;">
		<div style="max-width:250px;height:100px;margin:0 auto;"><img width="100%" src="<?php echo $logo; ?>"></div>
		<div class="content" style="max-width: 800px;margin: 0 auto;background-color: #FFF;padding: 30px;min-height:600px;">
			<table width="30%" align="left" class="content-left" style="border-collapse: collapse;">
				<tr>
					<td style="min-width: 300px;">
						<div style="background-color: #f1f1f1;padding: 10px 25px; 25px; 25px;min-height: 220px;">
							<h2 style="font-size: 16px;color: #333;font-family: Montserrat;text-transform: uppercase;padding: 12px 20px;font-weight: 700;text-align: center;border-bottom: 1px solid #e4e4e4;">Dates</h2>
							<ul style="list-style:none;padding: 0;margin: 0;">
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:12px;font-family: 'Hind', sans-serif;">Check-In</span><span style="float:right;font-size:12px;color:#333;font-weight: 600;font-family: 'Hind', sans-serif;"><?php echo format_date($d['date_in']); ?></span></li>
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:12px;font-family: 'Hind', sans-serif;">Check-Out</span><span style="float:right;font-size:12px;color:#333;font-weight: 600;font-weight:bold;font-family: 'Hind', sans-serif;"><?php echo format_date($d['date_out']); ?></span></li>
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:12px;font-family: 'Hind', sans-serif;">Total Nights</span><span style="float:right;font-size:12px;color:#333;font-weight: 600;font-family: 'Hind', sans-serif;"><?php echo $d['no_of_night']; ?></span></li>
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:12px;font-family: 'Hind', sans-serif;">Total Guests</span><span style="float:right;font-size:12px;color:#333;font-weight: 600;font-family: 'Hind', sans-serif;text-transform:uppercase;"><?php echo $d['no_of_adult']; ?> Adults and <?php echo $d['no_of_child']; ?> Children</span></li>
							</ul>
						</div>
						<div style="background-color: #f1f1f1;padding: 10px 25px; 25px; 25px;min-height: 220px;margin-top:20px;">
							<h2 style="font-size: 16px;color: #333;font-family: Montserrat;text-transform: uppercase;padding: 12px 20px;font-weight: 700;text-align: center;border-bottom: 1px solid #e4e4e4;">Selected Room</h2>
							<ul style="list-style:none;padding: 0;margin: 0;">
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:14px;font-family: 'Hind', sans-serif;text-transform:uppercase;font-weight:bold;"><?php echo $d['room_title']; ?></span></li>
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:12px;font-family: 'Hind', sans-serif;">Room #: <?php echo $d['room_code']; ?></span></li>	
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:12px;font-family: 'Hind', sans-serif;">Room Price: <?php echo nf($d['room_price']); ?></span></li>	
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:12px;font-family: 'Hind', sans-serif;">Max: <?php echo $d['max_person']; ?> Person(s)</span></li>
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:12px;font-family: 'Hind', sans-serif;">Size: <?php echo $d['room_size']; ?></span></li>
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:12px;font-family: 'Hind', sans-serif;">Bed: <?php echo $d['bed']; ?></span></li>
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:12px;font-family: 'Hind', sans-serif;">View: <?php echo $d['view']; ?></span></li>
								<li style="font-family: 'Hind', sans-serif;display: block;clear: both;padding: 10px 0;">
									<span style="float:left;font-size:12px;font-family: 'Hind', sans-serif;">No of Room <?php echo $d['room']; ?> : <?php echo nf( $d['no_of_night'] * $d['room_price'] ); ?></span></li>
								
							</ul>
						</div>
						<div style="padding:25px;background-color: #333333;"><span style="text-transform:uppercase;color:#FFF;font-weight:bold;">Total</span><span style="float:right;color:#FFF;font-weight:bold;"><?php echo format_price($d['amount']); ?></span></div>
					</td>
				</tr>
			</table>
			<table width="50%" align="left" class="content-right" style="margin-left:50px;border-collapse: collapse;">
				<tr>
					<td style="vertical-align:top;">
						<div>
							<h2 style="text-transform:uppercase;">Billing Details</h2>
							<p style="padding:0;margin:0;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: inline-block;text-transform: uppercase;">Booking #:</span>
								<span style="font-size:16px;font-family: 'Hind', sans-serif;font-weight:bold;"><?php echo $d['booking_no']; ?></span>
							</p>
							<p style="padding:0;margin:0;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: inline-block;text-transform: uppercase;">Full Name:</span>
								<span style="font-size:12px;font-family: 'Hind', sans-serif;font-weight:bold;"><?php echo $d['salutation'] .' '. $d['first_name'] .' ' . $d['middle_name'] .' '. $d['last_name']; ?></span>
							</p>
							<p style="padding:0;margin:0;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: inline-block;text-transform: uppercase;">Email Address:</span>
								<span style="font-size:12px;font-family: 'Hind', sans-serif;font-weight:bold;"><a href="mailto:johndoe@gmail.com"><?php echo $d['email_address']; ?></a></span>
							</p>
							<p style="padding:0;margin:0;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: inline-block;text-transform: uppercase;">Date of Birth:</span>
								<span style="font-size:12px;font-family: 'Hind', sans-serif;font-weight:bold;"><?php echo format_date($d['birth_date']); ?></span>
							</p>
							<p style="padding:0;margin:0;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: inline-block;text-transform: uppercase;">Phone:</span>
								<span style="font-size:12px;font-family: 'Hind', sans-serif;font-weight:bold;"><?php echo $d['primary_phone']; ?></span>
							</p>

							<p style="padding:0;margin:0;margin-top:20px;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: inline-block;text-transform: uppercase;">Country:</span>
								<span style="font-size:12px;font-family: 'Hind', sans-serif;font-weight:bold;"><?php echo $d['country']; ?></span>
							</p>
							<p style="padding:0;margin:0;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: inline-block;text-transform: uppercase;">Address:</span>
								<span style="font-size:12px;font-family: 'Hind', sans-serif;font-weight:bold;"><?php echo $d['address_1']; ?></span>
							</p>
							<p style="padding:0;margin:0;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: inline-block;text-transform: uppercase;">Address 2:</span>
								<span style="font-size:12px;font-family: 'Hind', sans-serif;font-weight:bold;"><?php echo $d['address_2']; ?></span>
							</p>
							<p style="padding:0;margin:0;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: inline-block;text-transform: uppercase;">Province:</span>
								<span style="font-size:12px;font-family: 'Hind', sans-serif;font-weight:bold;"><?php echo $d['province']; ?></span>
							</p>
							<p style="padding:0;margin:0;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: inline-block;text-transform: uppercase;">City:</span>
								<span style="font-size:12px;font-family: 'Hind', sans-serif;font-weight:bold;"><?php echo $d['city']; ?></span>
							</p>
							<p style="padding:0;margin:0;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: inline-block;text-transform: uppercase;">Zip Code:</span>
								<span style="font-size:12px;font-family: 'Hind', sans-serif;font-weight:bold;"><?php echo $d['zipcode']; ?></span>
							</p>
							<p style="padding:0;margin:0;margin-top:20px;">
								<span style="font-size:14px;font-family: 'Hind', sans-serif;width: 150px;display: block;text-transform: uppercase;">Notes:</span>
								<span style="font-size:12px;font-family: 'Hind', sans-serif;font-weight:100;">
								<?php echo $d['notes']; ?>
								</span>
							</p>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>

<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
$url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>

 	<script type="text/javascript">
		jQuery(document).ready(function()
		{
		/*
		 *  Simple image gallery. Uses default settings
		 */
		jQuery('.fancybox').fancybox();
		/*
		*  Different effects
		*/
	    });
	</script>
	<style type="text/css">
	.fancybox-custom .fancybox-skin
	 {
		 box-shadow: 0 0 50px #222;
	 }
	</style>
	

<div class="supercontainer">
	<div class="maincontainer">
		<div class="border-right1">
			<div class="border-bot1">
				<div class="border-left1">
					<div class="border-top1">
						<div class="left-top-corner1">
							<div class="right-top-corner1">
								<div class="right-bot-corner1">
									<div class="left-bot-corner1">
										<div class="inner1">
									    	<div class="logoContainer"><img alt="" src="<?php echo $url;?>images/Logo_spark.png" style="margin-top:10px" />
									    		<a href="http://www.wp-online-booking-system.com" target="_blank"><img alt="" src="<?php echo $url;?>images/728x90_wp-obs_pro_header.jpg" style="float:right" /></a>
										    </div>
													<div class="mainmenuscontainer">
														<div id="droplinetabs1" class="droplinetabs">
															<ul>
																<li>
																	<a id="TabWiz" href="admin.php?page=TabWiz"  value="setting" ><span>Wizard</span></a>
																</li>
																<li>
																	<a id="TabBooking"   href="admin.php?page=TabBooking"><span>Bookings</span></a>
																</li>
																<li>
																	<a id="TabEmployees" href="admin.php?page=TabEmployees"><span>Employees</span></a>
																</li>
																<li>
																	<a id="TabServices" href="admin.php?page=TabServices"><span>Services</span></a>
																</li>
																<li>
																	<a id="TabCustomers" href="admin.php?page=TabCustomers"><span>Customers</span></a>
																</li>
																<li>
																	<a id="TabNotifications" href="admin.php?page=TabNotifications"><span>Notifications</span></a>
																</li>
																<li>
																	<a id="TabEmail" href="admin.php?page=TabEmail"><span>Email Templates</span></a>
																</li>
																<li>
																	<a id="TabExports" href="admin.php?page=TabExports"><span>Export Clients List</span></a>
																</li>
																<li>
																	<a id="TabBookings" href="admin.php?page=TabBookings"><span>Booking Form</span></a>
																</li>
																<li>
																	<a id="TabBookingsLink" href="admin.php?page=TabBookingsLink"><span>Booking Link</span></a>
																</li>
																<li>
																	<a id="TabSettings" href="admin.php?page=TabSettings" ><span>Settings</span></a>
															</ul>
																</li>
														</div>
												</div>
												<div id="LimitedContentPlaceHolder">
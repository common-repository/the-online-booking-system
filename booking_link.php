<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$url = plugins_url('', __FILE__) . "/"; 
$url1 = plugins_url('', __FILE__); 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<?php
?>
<div id="contentid">
		<style type="text/css">
		.box_bookingLink{ left:10% !important;}
		</style>
		<script type="text/javascript">
 			jQuery(document).ready(function()
 			{
				
				jQuery('#lightbox').click(function()
				{
						var windowWidth = document.documentElement.clientWidth;
						var clientWidth = (windowWidth / 2) - 410;
						
						if(document.getElementById('hitime'))
						{
								jQuery('hitime').remove();
						}
						jQuery('.box_bookingLink').attr('style',"border: 10px solid #525252;left:"+ clientWidth +"px;");
						jQuery('#link').load(uri+"/back-front.php",function(){jQuery('#loading').remove();jQuery('.maincontainer1').css('display', 'block');});
						jQuery('.box_bookingLink').animate({'opacity':'1.00'});
						jQuery('.backdrop, .box_bookingLink').css('display', 'block');
				});
	 			jQuery('.close').click(function()
	 			{
						close_box();
				});
	 			jQuery('.backdrop').click(function()
	 			{
						close_box();
				});
					
 
			});
 			function close_box()
			{
				jQuery('.backdrop, .box_bookingLink').animate({'opacity':'0'}, 300, 'linear', function(){
					jQuery('.backdrop, .box_bookingLink').css('display', 'none');
				});
			}
 			function Checkfiles()
			{
				var fup = document.getElementById('file');
				var fileName = fup.value;
				var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
				if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png")
				{	
					return true;
				} 
				else
				{
					alert("Upload png or Jpg images only");
					return false;
				}
			}

			jQuery(function () 
			{
					jQuery("#submit").click(function ()
					{
						var t = document.getElementById('file').value;
						if(t!="" && Checkfiles())
						{
							jQuery("#form").submit();
						}
						else
						{
							alert('Please browse image first.')
						}
					});
			});
		</script>
<div class="backdrop"></div>
<?php
		//SELECT TRANSLATION FROM THE DATABASE
		$trans = $wpdb->get_results
    	(
       		 $wpdb->prepare
       		 (
           			 "SELECT * FROM ".$wpdb->prefix."sm_translation"
              )
   		 );
		
		for($i=0;$i<=count($trans);$i++)?>
		<div  class="box_bookingLink"><div class="close1"><?php echo $trans[18]->translate; ?></div>
			<div class="close">X</div>
				<div id="link"></div>
			<div id='loading' class='loading'><img src="<?php echo $url; ?>images/loading.gif"/></div>
		</div>
		<form  method="POST" enctype="multipart/form-data" id="form" action="<?php echo $url;?>upload_link_photo.php">
				<div class="contentarea">
					<div class="one_wrap fl_left">
						<div class="msgbar msg_Success hide_onC" style="display: none">
							<span class="iconsweet">=</span>
								<p>
									All the Settings have been saved Successfully.
								</p>
						</div>
						<div class="widget-wp-obs">
								<div class="widget-wp-obs_title">
									<span class="iconsweet">(</span>
									<h5>Booking Link</h5>
								</div>
								<div class="widget-wp-obs_body">
									<ul class="form_fields_container">
											
												<li>
													<label>Image Link Code</label>
													<div class="form_input" >
														<?php
														//SELECT BOOKING LINK IMAGE FROM THE DATABASE
														$image = $wpdb -> get_var('SELECT image FROM ' . $wpdb -> prefix . sm_booking_link_img);
														//SELECT TRANSLATION FROM THE DATABASE
														$trans = $wpdb->get_results
												    	(
												       		 $wpdb->prepare
												       		 (
												           			 "SELECT * FROM ".$wpdb->prefix."sm_translation"
												              )
												   		 );
														for($i=0;$i<=count($trans);$i++)
														$titels =  $trans[18]->translate;
														$emp = "<a href=\"#\" onclick=\"frontend2();\"><img src=\"$url1/images_booklink/$image\" /></a><label style='visibility:hidden;'>[booking-link]</label>";
														?>
														<textarea  readonly="readonly"  cols="100" rows="5" ><?php echo $emp;?></textarea>
													</div>
												</li>
												<li>
													<div class="form_input">
														<!--<a href="#myModal3" data-toggle="modal" id="imgp"><img src="<?php // echo $url;   ?>images/<?php // echo $image;   ?> " style="width:100px; cursor:pointer;" ></a>-->
														<a href="#" id="lightbox" ><img src="<?php echo $url;?>images_booklink/<?php echo $image;?> " style="width:100px; cursor:pointer;"></a>
													</div>
												</li>
												
												
												
											</ul>
										</div>
									</div>
							</div>
							
							<a href="http://www.wp-online-booking-system.com" target="_blank"><img src="<?php echo $url;?>images/booking_link_pro.jpg" alt="" style="margin-top:20px;margin-left:-2px;"/></a>
							
					</div>
			</div>
		</form>
</div>
	
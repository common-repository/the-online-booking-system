<div id="bookbackcal">
<?php 
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
$uri = plugins_url('', __FILE__) . "/"; 

global $wpdb;
$var = intval($_GET['id']);
if($var == 1)
{ 
	?>
	<script>
	 jQuery('#Window').remove();
	 </script>
	<?php 
} 
?>

<link href="<?php echo $uri;?>csscal/dailog.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $uri;?>csscal/calendar.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $uri;?>csscal/main.css" rel="stylesheet" type="text/css" />
<link  rel='stylesheet' href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/base/jquery-ui.css" type="text/css"/>


<script src="<?php echo $uri;?>src/Common.js" type="text/javascript"></script>
<script src="<?php echo $uri;?>src/wdCalendar_lang_US.js" type="text/javascript"></script>
<script src="<?php echo $uri;?>src/jquery.calendar.js" type="text/javascript"></script>
<script type="text/javascript">jQuery("select, input:checkbox, input:radio").uniform();</script>

<script type="text/javascript">


function booking() 
{
		<?php
		$trans = $wpdb->get_results
		(
			$wpdb->prepare
			(
				  "SELECT * FROM ".$wpdb->prefix."sm_translation "
			)
		);	
		for($i=0;$i<=count($trans);$i++)
		?>
		var titles = "<?php echo $trans[18]->translate; ?>";
		if(document.getElementById('hitime'))
		{
			jQuery('#hitime').remove();
		}
		jQuery('.box_bookingLink').remove();
		var windowWidth = document.documentElement.clientWidth;
		var clientWidth = (windowWidth / 2) - 410;
		jQuery('body').append("<div class='box_bookingLink' style='border: 10px solid #525252;left:"+clientWidth+"px;'><div class='close1'>"+titles+"</div><div class='close'>X</div><div id='online_booking'></div><div id='loading' class='loading'><img src='"+uri+"/images/loading.gif'/></div></div>");
		jQuery('#online_booking').load(uri+"/online_booking.php",function(){jQuery('#loading').remove();jQuery('.maincontainer1').css('display', 'block');});
		jQuery('.box_bookingLink').animate({'opacity':'1.00'});
		jQuery('.backdrop, .box_bookingLink').css('display', 'block');
		jQuery('.close').click(function(){
		close_box();
		});
 		jQuery('.backdrop').click(function(){
		close_box();
		});
		
 
		function close_box()
		{
			jQuery('.box_bookingLink').remove();
			jQuery('.backdrop, .box_bookingLink').animate({'opacity':'0'}, 300, 'linear', function()
			{
				jQuery('.backdrop, .box_bookingLink').css('display', 'none');
			});
		}
};
</script>
<div id="divimp" style="margin-top:10px;"></div>
<div id="divhid" style="margin-top:10px;"></div>
<div id="content" class="contentarea">
	<div class="one_wrap fl_left">
		<div class="widget-wp-obs">
			<div class="widget-wp-obs_title">
				<span class="iconsweet">b</span>
					<h5>Bookings</h5>
						</div>
							<div class="widget-wp-obs_body">
							<form id="expo" method="post" action="<?php echo $uri;?>exportbooking.php" >
								<ul class="form_fields_container" style="width:33%;float:left">
								<li>
								<label>Select Employee :</label>
								<div class="form_input"  style="width:52%;">
								<?php
								global $wpdb;
								$name = $wpdb->get_col
								(
									$wpdb->prepare
									(
										  'SELECT emp_name FROM ' . $wpdb->prefix . 'sm_employees join ' . $wpdb -> prefix . 'sm_allocate_serv  on ' . $wpdb -> prefix . 'sm_employees.id =' . $wpdb -> prefix . 'sm_allocate_serv.emp_id  where status = %s ORDER BY ' . $wpdb -> prefix . 'sm_employees.emp_name ASC',
										  "Active"
									)
								);	
								$id = $wpdb->get_col
								(
									$wpdb->prepare
									(
										  'SELECT ' . $wpdb -> prefix . 'sm_employees.id FROM ' . $wpdb -> prefix . 'sm_employees  join ' . $wpdb -> prefix . 'sm_allocate_serv  on ' . $wpdb -> prefix . 'sm_employees.id=' . $wpdb -> prefix . 'sm_allocate_serv.emp_id  where status = %s ORDER BY ' . $wpdb -> prefix . 'sm_employees.emp_name ASC',
										  "Active"
									)
								);
								$count = $wpdb -> get_var('SELECT count(' . $wpdb -> prefix . sm_employees . '.id) FROM ' . $wpdb -> prefix . sm_employees . '  join ' . $wpdb -> prefix . sm_allocate_serv . ' on ' . $wpdb -> prefix . sm_employees . '.id=' . $wpdb -> prefix . sm_allocate_serv . '.emp_id  where status="Active"');
								?>
								<select id="employeesss" name="employeesss">
								<option value="ALL">ALL</option>
								<?php
								for($i=0;$i<$count;$i++)
								{
									$nam=$name[$i];
									if($id[$i-1]!=$id[$i])
									{
										$idd=$id[$i];
										?>
										<option value='<?php echo $idd;?>'> <?php echo $nam;?></option> <?php 
									}
								}
								?>
								</select>
								</div>
								</li>
								</ul>
									<ul class="form_fields_container" style="width:67%;float:left">
								<li style="margin-left:0px;">
								<label>Select Status :</label>
								<div class="form_input"  style="width:77%;"> 
								<select id="status1" name="status1" onchange="status();">
								<option value="ALL">ALL</option>
								<option value="Approval Pending" selected="selected">Approval Pending</option>
								<option value="Approved">Approved</option>
								<option value="Disapproved">Disapproved</option>
								<option value="Cancelled">Cancelled</option>
								<option value="timeoff">Time Off</option>
								</select>
								
								
								<a href="#" onClick="booking();" style="width:90px; margin-left:20px;font-weight: normal !important;text-shadow: none !important;" class="redishBtn button_small">Book a Service</a>
								</div>
								</li>
								</ul>
								
								
								
	<input type="hidden" id="newtxt" value="" />
		<div id="calhead" style="padding-left:1px;padding-right:1px;">
			<div class="cHead">
				<div id="loadingpannel" class="ptogtitle loadicon" style="display: none;">
					Loading data...
						</div>
						<div id="errorpannel" class="ptogtitle loaderror" style="display: none;">
							Sorry, could not load your data, please try again later
						</div>
					</div>
					<div id="caltoolbar" class="ctoolbar">
					<div id="showdaybtn" class="fbutton" style="margin-left: 20px;">
							<div>
								<span title='Day' class="showdayview">Day</span>
							</div>
						</div>
						<div  id="showweekbtn" class="fbutton fcurrent">
							<div>
								<span title='Week' class="showweekview">Week</span>
							</div>
						</div>
						<div  id="showmonthbtn" class="fbutton">
							<div>
								<span title='Month' class="showmonthview">Month</span>
							</div>
						</div>
						<div class="btnseparator"></div>
						<div id="sfprevbtn" title="Prev"  class="fbutton">
							<span class="fprev"></span>
						</div>
						<div id="sfnextbtn" title="Next" class="fbutton">
							<span class="fnext"></span>
						</div>
						<div  class="fshowdatep fbutton">
							<div>
								<input type="hidden" name="txtshow" id="hdtxtshow" />
								<span id="txtdatetimeshow">Loading</span>
							</div>
						</div>
						<div class="clear"></div>
					</div>
		</div>
		<div style="padding:1px;">
			<div id="dvCalMain"  class="calmain printborder">
				<div id="gridcontainer"  style="overflow-y: visible;height:865px;"></div>
					</div>
					</div>
				<script>
					jQuery("#showweekbtn").removeClass("fcurrent");
					jQuery("#showmonthbtn").removeClass("fcurrent");
					jQuery("#showdaybtn").addClass("fcurrent");
				</script>
				</form>
			</div>
		</div>
	</div>
	
	
	
	
<div id="hidden_clicker" style="display:none">
<a id="hiddenclicker" href="#Window" class="fancybox" >Hidden Clicker</a>
</div>
<div style="display:none;width:600px;" id="Window"></div></div>
<script type="text/javascript">
	jQuery('#BBIT_DP_CONTAINER').remove();
	<?php
	if(isset($_REQUEST['emp_id']))
	{
		?>
		var emppid = "<?php echo intval($_REQUEST['emp_id']) ?>";
		document.getElementById('employeesss').value=emppid;
		loademp();
		<?php 
	}
	else
	{
		?>
		loademp();
		<?php
	}
	?>
	jQuery(document).ready(function() 
	{
		jQuery("#employeesss").change( function() 
	{
		loademp();
		jQuery("#showweekbtn").removeClass("fcurrent");
		jQuery("#showmonthbtn").removeClass("fcurrent");
		jQuery("#showdaybtn").addClass("fcurrent");
	});
		jQuery("#status1").change(function() 
	{
		loademp();
		jQuery("#showweekbtn").removeClass("fcurrent");
		jQuery("#showmonthbtn").removeClass("fcurrent");
		jQuery("#showdaybtn").addClass("fcurrent");
	});
	});
	function loademp()
	{
	
		jQuery(document).ready(function()
		{
			emprid = document.getElementById('employeesss').value;
			var stat = document.getElementById('status1').value;
			
			filepath = uri+"/getworkinghours.php";
			jQuery.ajax
			({
				type: "POST",
				data: "empid="+emprid,
				url: filepath,
				success: function(data) 
				{
					jQuery("#divhid").html(data);
					var view="month";
					var DATA_FEED_URL = uri+"/php/datafeed.php";
					var op = 
					{
						view: view,
						theme:3,
						showday: new Date(),
						EditCmdhandler:Edit,
						DeleteCmdhandler:Delete,
						ViewCmdhandler:View,
						onWeekOrMonthToDay:wtd,
						onBeforeRequestData: cal_beforerequest,
						onAfterRequestData: cal_afterrequest,
						onRequestDataError: cal_onerror,
						autoload:true,
						url: DATA_FEED_URL + '?method=list&status='+stat,
						quickAddUrl: DATA_FEED_URL + "?method=add",
						quickUpdateUrl: DATA_FEED_URL + "?method=update",
						quickDeleteUrl: DATA_FEED_URL + "?method=remove"
					};
					var $dv = jQuery("#calhead");
					var _MH = document.documentElement.clientHeight;
					var dvH = $dv.height() + 2;
					op.height = _MH - dvH;
					op.eventItems =[];
					var p = jQuery("#gridcontainer").bcalendar(op).BcalGetOp();
					if (p && p.datestrshow) 
					{
						jQuery("#txtdatetimeshow").text(p.datestrshow);
					}
					jQuery("#caltoolbar").noSelect();
					function cal_beforerequest(type)
					{
						var t="Loading data...";
						switch(type)
						{
							case 1:
							t="Loading data...";
							break;
							case 2:
							case 3:
							case 4:
							t="The request is being processed ...";
							break;
						}
						jQuery("#errorpannel").hide();
						jQuery("#loadingpannel").html(t).show();
					}
					function cal_afterrequest(type)
					{
						switch(type)
						{
							case 1:
							jQuery("#loadingpannel").hide();
							break;
							case 2:
							case 3:
							case 4:
							jQuery("#loadingpannel").html("Success!");
							window.setTimeout(function(){ jQuery("#loadingpannel").hide();},2000);
							break;
						}
					}
					function cal_onerror(type,data)
					{
						jQuery("#errorpannel").show();
					}

					function Edit(data)
					{
						var eurl=uri+"/edit.php?id={0}&start={2}&end={3}&isallday={4}&title={1}&empid={10}&empdis={11}&sernm={1}";
						if(data)
						{
								var url = StrFormat(eurl,data);
								var value = getQuerystring("empid",url);
								if(value!=0 )
								{
									jQuery('#Window').empty();
									jQuery('#Window').load(url,function(){jQuery.fancybox.update();});
									jQuery("#hiddenclicker").trigger('click');
								}
						}
					}
					
					function getQuerystring(key,url) 
					{
						key = key.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	           			var regex = new RegExp("[\\?&]" + key + "=([^&#]*)");
	           			var qs = regex.exec(url);
	           			if (qs == null) 
           				{
               	 			return "";
            			}
            			else 
            			{
                			return qs[1];
            			}
        			}
							
					function View(data)
					{
							var str = "";
							jQuery.each(data, function(i, item)
							{
								str += "[" + i + "]: " + item + "\n";
							});
							
					}
					function Delete(data,callback)
					{
						
						jQuery.alerts.okButton="Ok";
						jQuery.alerts.cancelButton="Cancel";
						hiConfirm("Are You Sure to Delete this Event", 'Confirm',function(r){ r && callback(0);});
					}
					function wtd(p)
					{
						if (p && p.datestrshow)
						{
							jQuery("#txtdatetimeshow").text(p.datestrshow);
						}
						jQuery("#caltoolbar div.fcurrent").each(function() 
						{
							jQuery(this).removeClass("fcurrent");
						})
						jQuery("#showdaybtn").addClass("fcurrent");
					}
					//to show day view

					jQuery("#showdaybtn").click(function(e)
					 {
							jQuery("#caltoolbar div.fcurrent").each(function() 
							{
								jQuery(this).removeClass("fcurrent");
							})
								jQuery(this).addClass("fcurrent");
								var p = jQuery("#gridcontainer").swtichView("day").BcalGetOp();
								if (p && p.datestrshow) 
								{
									jQuery("#txtdatetimeshow").text(p.datestrshow);
								}
					});
					//to show week view
					jQuery("#showweekbtn").click(function(e) 
					{
						jQuery("#caltoolbar div.fcurrent").each(function() 
						{
							jQuery(this).removeClass("fcurrent");
						})
						jQuery(this).addClass("fcurrent");
						var p = jQuery("#gridcontainer").swtichView("week").BcalGetOp();
						if (p && p.datestrshow) 
						{
							jQuery("#txtdatetimeshow").text(p.datestrshow);
						}
					});
					//to show month view
					jQuery("#showmonthbtn").click(function(e) 
					{
						//document.location.href="#month";
						jQuery("#caltoolbar div.fcurrent").each(function() 
						{
							jQuery(this).removeClass("fcurrent");
						})
						jQuery(this).addClass("fcurrent");
						var p = jQuery("#gridcontainer").swtichView("month").BcalGetOp();
						if (p && p.datestrshow) 
						{
							jQuery("#txtdatetimeshow").text(p.datestrshow);
						}
					});

					jQuery("#showreflashbtn").click(function(e)
					{
						jQuery("#gridcontainer").reload();
					});
					//Add a new event
				//	jQuery("#faddbtn").click(function(e) 
					//{
					//	var url ="edit.php";
					//	OpenModelWindow(url,{ width: 500, height: 200, caption: "Create New Calendar"});
					//});
				}
			});
		});
	}
	jQuery(document).ready(function()
	{
		jQuery("#showtodaybtn").click(function(e) 
		{
			var p = jQuery("#gridcontainer").gotoDate().BcalGetOp();
			if (p && p.datestrshow) 
			{
				jQuery("#txtdatetimeshow").text(p.datestrshow);
			}
		});
		jQuery("#sfprevbtn").click(function(e) 
		{
			var p = jQuery("#gridcontainer").previousRange().BcalGetOp();
			if (p && p.datestrshow) 
			{
				jQuery("#txtdatetimeshow").text(p.datestrshow);
			}
		});
		//next date range
		jQuery("#sfnextbtn").click(function(e) 
		{
			var p = jQuery("#gridcontainer").nextRange().BcalGetOp();
			if (p && p.datestrshow) 
			{
				jQuery("#txtdatetimeshow").text(p.datestrshow);
			}
		});
	});
</script>
</div>
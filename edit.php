<?php
include_once("php/functions.php");
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' ); 
global $wpdb;
 
?>

<?php
$msg1  =  $wpdb->get_var('SELECT translate  FROM ' . $wpdb->prefix . sm_translation . ' where id = 17');
$msg2  =  $wpdb->get_var('SELECT translate  FROM ' . $wpdb->prefix . sm_translation . ' where id = 18');
?>
<script>
var message1 = "<?php echo $msg1;?>";
var message2 = "<?php echo $msg2;?>";	
</script>
<?php
function getCalendarByRange($id)
{
	$pos = strpos($id, "_");
	if ($pos === false) 
	{
		$idr=$id;
		global $wpdb;
		$booking = $wpdb->get_row
		(
				$wpdb->prepare
				(
				        "SELECT hour, minute,Date FROM ".$wpdb->prefix."sm_bookings WHERE id = %d",
				         $idr
				)
		);	
		$hourt=$booking->hour;
		$mintt=$booking->minute;
		$dtt=$booking->Date;
		
		if($hourt<10)
		{
		$hourt="0".$hourt;
		}
		if($mintt<10)
		{
		$mintt="0".$mintt;
		}
		$hrtt=$hourt.":".$mintt;
		?>
		<input type="hidden" id="iddttime" value="<?php echo $hrtt ?>"/>
		<input type="hidden" id="iddtt" value="<?php echo $dtt; ?>"/>
		<?php
	}
	else
	{
		$idrr=explode("_",$id);
		$idr=$idrr[0];
		?>
		<input type="hidden" id="iddtt" value="<?php echo $idrr[1] ?>"/>
		<input type="hidden" id="iddttime" value="<?php echo $idrr[2] ?>"/>
		<?php
	}
 ?>
 <input type="hidden" id="eidttext" value="<?php echo $idr; ?>" />
 <?php
}
if(isset($_GET["id"])){
  $event = getCalendarByRange($_GET["id"]);
}
if(isset($_REQUEST['action']))
{
		if($_REQUEST['action'] == 'update')
		{
			$wpdb->query
		     (
		            $wpdb->prepare
		            (
		                    "UPDATE ".$wpdb->prefix."sm_bookings SET status = %s WHERE id = %d",
		                    intval($_REQUEST['bokstat']),
		                    intval($_REQUEST['bid'])
		             )
		      );
		}
}

?>

		<script>
		function selecttime()
		{
		var hrselect=document.getElementById("hourselect").value;
		jQuery("#strthrrr").val(hrselect);
		}              
						 function populateemployees()
						 {
							filepath = uri+"/getlasthour.php";
						 	var id=document.getElementById("Service").value;
							
							var empedit=document.getElementById("eidttext").value;
						    jQuery(document).ready(function($) {
							jQuery.ajax({
								type: "POST",
								data: "Service="+id+"&empidd="+empedit+"&popultemp=true",
								url: filepath,
								success: function(data) {
								   jQuery("#empdiv").html(data);
								   getstartendtimebtn(false);
								}                            
						   });
						    return true;
						   });
						 }
						 
					function getstartendtimebtn(booked)
					{

							filepath = uri+"/getlasthour.php";
							var d=document.getElementById("from").value;
							var mondyr=d.split("-");
							var yr=mondyr[0];
							var mont=mondyr[1];
							var dy=mondyr[2];
							var empp=document.getElementById("emp").value;
							var strthrrr=document.getElementById("strthrrr").value;
							var serid=document.getElementById("Service").value;
							var bid=document.getElementById("hiddel").value;
						
							var days= ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
						    var today = new Date(d);
						    var day=days[today.getDay()];
							
							var hourss = document.getElementById('strthrrr').value;
							var hrrr=hourss.split(":");
							var hours=hrrr[0];
							var minutes=hrrr[1];
							jQuery.ajax
							({
									type: "POST",
									data: "day="+day+"&serid="+serid+"&hr="+hours+"&mns="+minutes+"&bid="+bid+"&empid="+empp+"&year="+yr+"&month="+mont+"&dayy="+dy+"&strtendsel="+strthrrr+"&booked="+booked,
									url: filepath,
									success: function(data) 
									{
											
											document.getElementById("btncal").disabled=false;
											document.getElementById("btncal").style.opacity = 1.0;
											jQuery("#time").html(data);
										//	jQuery("#hourselect").val(document.getElementById('strthrrr').value);
									}                            
						   });
						    return true;
						   
					}
					function book()
					{
						
							var d=document.getElementById("from").value;
							var editid=document.getElementById("eidttext").value;
							var mondyr=d.split("-");
							var yr=mondyr[0];
							var mont=mondyr[1];
							var dy=mondyr[2];
							var clientname=document.getElementById("clientname").value;
							var bookingstatus=document.getElementById("bookingstatus").value;
							var empp=document.getElementById("emp").value;
							var serid=document.getElementById("Service").value;
							var hourss = document.getElementById('strthrrr').value;
							var hrrr=hourss.split(":");
							var hrs=hrrr[0];
							var mnsss=hrrr[1];
							var totime;
							if(hrs > 12 && hrs < 23)
							{
								var temphr = hrs - 12;
								
								totime =  temphr +":"+ mnsss + "PM";
							}
							else
							{
								totime =  hourss + "AM";
							}
							var flag = 0;
							filepath22 = uri+"/servicehours.php";
							jQuery.ajax
							({
								type : "POST",
								data : "booktime="+totime+"&serv="+serid+"&emp="+empp+"&cmonth="+mont+"&cyear="+yr+"&cday="+dy,
								url : filepath22,
								success : function(data) 
								{
									var test = jQuery.trim(data);
									
									
										if(test == '0')
										{
											alert(message1);
											flag = 1;
											
										}
										else if(test == '2')
										{
											alert(message2);
											flag = 1;
										}
									if(flag!=1)
									{
										 var urlSite = "<?php echo site_url(); ?>";
										var em = confirm("Click OK if you wish to notify customers. (clicking \"Cancel\" will confirm the booking but will not send an email to the client)");
										if(em==true)
										{
											var emi = "1";
										}
										else
										{
											var emi = "0";
										}
										filepath = uri+"/book.php";
							   
										if(hourss=="" || hourss=="0:0")
										{
											alert('Please Select Start Time');
											return false;
										}
										else
										{
											jQuery.ajax
											({
													type: "POST",
													data: "day="+dy+"&serid="+serid+"&emi="+emi+"&empid="+empp+"&year="+yr+"&month="+mont+"&clientnam="+clientname+"&hourselect="+hrs+"&minss="+mnsss+"&dat="+d+"&editid="+editid+"&bookingstatus="+bookingstatus,
													url: filepath,
													success: function(data) 
													{
														parent.jQuery.fancybox.close();
														window.location.href = urlSite +"/wp-admin/admin.php?page=TabEmployees";
													}                            
											});
										}
								
									}
							}
						});
					}
					function delbook()
					{
					        filepath = uri+"/book.php";
					        var urlSite = "<?php echo site_url(); ?>";
						 	var hidid=document.getElementById("hiddel").value;
							var r=confirm("Are you sure you want to Delete this booking?");
                            if (r==true)
                            {
								jQuery.ajax
								({
										type: "POST",
										data: "hidid="+hidid,
										url: filepath,
										success: function(data) 
										{
												parent.jQuery.fancybox.close();
												window.location.href = urlSite +"/wp-admin/admin.php?page=TabBooking";
										}                            
								});
						   }
						  
					}
					function hidebutton()
					{
						document.getElementById("btncal").disabled=true;
						document.getElementById("btncal").style.opacity = 0.5;
					} 
    </script>      
    <style type="text/css">     
    .calpick     
	{        
        width:16px;   
        height:16px;     
        border:none;        
        cursor:pointer;        
        background:url("sample-css/cal.gif") no-repeat center 2px;        
        margin-left:-22px;    
    }      
	</style>
<script type="text/javascript">
jQuery(function() 
{
	jQuery( "#from" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<?php
if($_GET["empdis"]!="ALL")
{
	?>
	<div class="widget-wp-obs" style="margin:5px;">
	<div class="widget-wp-obs_title">
		<span class="iconsweet">b</span>
			<h5>Edit Booking Details</h5>
				</div>
					<div class="widget-wp-obs_body">
		<ul class="form_fields_container">
			<li>
		           <input type="hidden" id="enddate" name="enddate"/>		
				  <label>Service Name :</label>
				  <div class="form_input">
				  <select id="Service" name="Service" onchange="return populateemployees();">
				  <?php
		          $sernam = $wpdb->get_results
				  (
						$wpdb->prepare
						(
							  "SELECT id,name FROM ".$wpdb->prefix."sm_services"
						)
				  );
				  $table_name = $wpdb->prefix . "sm_bookings";
				  $jid=$wpdb->get_var("select service_id from ".$table_name." where id = " . intval($_REQUEST['id']));
				  for($i=0;$i<count($sernam);$i++)
				  {
						 if($jid==$sernam[$i]->id)
						 {	
						  	?>
							 <option value="<?php echo $sernam[$i]->id; ?>" selected="selected"><?php echo $sernam[$i]->name; ?></option>										
							<?php	
						 }
						 else
						 {
						 	?>
						 	<option value="<?php echo $sernam[$i]->id; ?>"><?php echo $sernam[$i]->name; ?></option>										
								<?php					
						 }
				  }
			?>
			</select>
			</div>  
			<script>populateemployees();</script> 
			</li>
			<li>
					<label>Employee :</label>  
					  <div class="form_input" id="empdiv">
						
						</div>
			</li>
			<li>
		 		  <label>Client Name :</label>
		 		    <div class="form_input">
  			    
					 <?php
			          
					   $table_name = $wpdb->prefix . "sm_bookings";
					   $clid=$wpdb->get_var("select client_id from ".$table_name." where id = " . intval($_REQUEST['id']));
					   $clientnam = $wpdb->get_var("SELECT name FROM ". $wpdb->prefix . sm_clients . " where id = " . '"' . $clid . '"');
					   $clientlnam = $wpdb->get_var("SELECT lastname FROM ". $wpdb->prefix . sm_clients . " where id = " . '"' . $clid . '"');
						?>
						<input type="hidden" id="clientname" name="clientname" value="<?php echo $clid; ?>" />
						<input type="text" id="clientname1" name="clientname1" disabled="disabled"  value="<?php echo $clientnam . " " . $clientlnam; ?> " style="width:370px" />
						</div>
			</li>
					<?php
			           $table_name = $wpdb->prefix . "sm_bookings";
					   $clid=$wpdb->get_var("select client_id from ".$table_name." where id = " . intval($_REQUEST['id']));
						$clientemail = $wpdb->get_var("SELECT email FROM ". $wpdb->prefix . sm_clients . " where id = " . '"' . $clid . '"');
						if($clientemail != 'undefined' && $clientemail != '')
						{
							?>
							<li>
							<label>Client Email :</label>
		 		    		<div class="form_input">
  			    
					 
								<input type="hidden" id="clientname" name="clientname" value="<?php echo $clid; ?>" />
								<input type="text" id="clientname1" name="clientname1" disabled="disabled"  value="<?php echo $clientemail; ?> " style="width:370px" />
								</div>
								</li>
								<?php
						}
						
					   $table_name = $wpdb->prefix . "sm_bookings";
					   $clid=$wpdb->get_var("select client_id from ".$table_name." where id = " . intval($_REQUEST['id']));
						$clientmobile = $wpdb->get_var("SELECT mobile FROM ". $wpdb->prefix . sm_clients . " where id = " . '"' . $clid . '"');
						if($clientmobile != 'undefined' && $clientmobile != '')
						{
							?>
							<li>
							<label>Client Mobile :</label>
							<div class="form_input">
							<input type="hidden" id="clientname" name="clientname" value="<?php echo $clid; ?>" />
							<input type="text" id="clientname1" name="clientname1" disabled="disabled"  value="<?php echo $clientmobile; ?> " style="width:370px" />
							</div>
							</li>
							<?php
						}
						?>
						<li>
						<label>Select Day :</label>
		 		   		 <div class="form_input" >
						<?php
					
				    $table_name = $wpdb->prefix . "sm_bookings";
					$StartTime=$wpdb->get_var("select StartTime from ".$table_name." where id = " . intval($_REQUEST['id']));
					$strt= explode(" ",$StartTime);
					$st = explode(":",$strt[1]);
					$time = $st[0].":".$st[1];
					?>
					<input type="text" value="<?php echo $strt[0]; ?>" onclick="hidebutton();" style="width:200px;" name="from" readonly="true" id="from"  />
					<input type="hidden" value="<?php echo $time; ?>" id="strthrrr" />
					
					<!--<input type="button" id="btncheckAvail"  class="greyishBtn button_small" style="margin-left: 340PX;margin-top: 4px;position: absolute;" onclick="return getstartendtimebtn(true);" value="Check Availability" />
					<input type="button" id="btncheckAvail"  class="greyishBtn button_small" style="margin-left:10px;" onclick="return getstartendtimebtn(true);" value="Check Availability" />-->
					<a id="btncheckAvail" class="greyishBtn button_small" onclick="return getstartendtimebtn(true);" style="margin-left:10px;text-shadow:none !important">Check Availability</a>
					</div>
					</li>
					<li>
					<label>Booking Time :</label>
		 		    <div class="form_input" id="time">
			
					</div>
					</li>
				<li>
			<label>Status :</label>
			 <div class="form_input">
			<input type="hidden" id="bookid" value="<?php echo$_REQUEST['id'];?>" />
			<select id="bookingstatus" name="bookingstatus">
					<?php
		          
				  $table_name = $wpdb->prefix . "sm_bookings";
				  $sta=$wpdb->get_var("select status from ".$table_name." where id = " . intval($_REQUEST['id']));
				  if($sta=="Approval Pending")
				  {
				  ?>
				  		<option value="<?php echo $sta; ?>" selected="selected" ><?php echo $sta; ?></option> 
						<option value="Approved" >Approved</option>
						<option value="Disapproved" >Disapproved</option>
						<option value="Cancelled" >Cancelled</option> 
				  <?php
				  }
				  elseif($sta=="Approved")
				  {
				   ?>
				  		<option value="<?php echo $sta; ?>" selected="selected" ><?php echo $sta; ?></option> 
						<option value="Approval Pending" >Approval Pending</option>
						<option value="Disapproved" >Disapproved</option>
						<option value="Cancelled" >Cancelled</option> 
				  <?php
				  
				  }
				   elseif($sta=="Disapproved")
				  {
				   ?>
				  		<option value="<?php echo $sta; ?>" selected="selected" ><?php echo $sta; ?></option> 
						<option value="Approval Pending" >Approval Pending</option>
						<option value="Approved" >Approved</option>
						<option value="Cancelled" >Cancelled</option> 
				  <?php
				  }
				  else
				  {
				   ?>
				  		<option value="<?php echo $sta; ?>" selected="selected" ><?php echo $sta; ?></option> 
						<option value="Approval Pending" >Approval Pending</option>
						<option value="Approved" >Approved</option>
						<option value="Disapproved" >Disapproved</option>
				  <?php
				  }
				?>
	 </select>  	
	 <input type="hidden" id="bookst" value="<?php echo $sta; ?>" />
	 </div>
	 </li>
		<li>
		

		 <?php $tt=intval($_REQUEST['id']); ?>
		 <input type="button" id="btncal"  class="greyishBtn button_small" style="margin-left: 125px;" onclick="return book();" value="update booking" />
		<?php
		if($tt!=0)
		{
				  $eimd = $wpdb->get_var("SELECT emp_id FROM ". $wpdb->prefix . sm_bookings . " where id=". $tt);
				?>
				<input type="hidden" id="hiddelempid" value="<?php echo $eimd; ?>"/>
				<input type="hidden" id="hiddel" value="<?php echo $tt; ?>"/>
				 <input type="button" id="btnDelete"  class="greyishBtn button_small" style="margin-left: 20px;" onclick="return delbook();" value="Delete Bookings" />
				<!--<a id="btnDelete" class="greyishBtn button_small" onclick="return delbook();"  style="margin-left:20px;">Delete Bookings</a>-->
			
				<?php
		}
				?>
				</li>
				<?php
		
			if($_REQUEST['id']!=0)
			{
				 ?>
             	 <script>
			     var edtt=document.getElementById("iddtt").value;
			     document.getElementById("from").value=edtt;
			  	 </script>
			     <?php
			}
			else
			{
					?>
			 		<script>
			 		var edttxt=document.getElementById("eidttext").value;
				 	if(edttxt==0)
				  	{
				     	var edtt=document.getElementById("iddtt").value;
				     	document.getElementById("from").value=edtt;
				  	}
			
					</script>
					<?php
			  }			
		?>
		</ul>
		</div>       
    	</div>
		<?php
	}
	else
	{
	?>
		<div class="widget-wp-obs" style="margin:5px;">
						<div class="widget-wp-obs_title">
							<span class="iconsweet">b</span>
							<h5>Booking Details</h5>
						</div>
			<div class="widget-wp-obs_body">
			<ul class="form_fields_container">
			<li>
		          <input type="hidden" id="enddate" name="enddate"/>	
				  <label>Service Name :</label>
				  <div class="form_input">
				  		<input type="text" value="<?php echo $_GET['sernm']; ?>" disabled="disabled"></input>
				  </div>
			</li>
			<li>
					<?php
					$empnm=$wpdb->get_var("SELECT emp_name FROM ". $wpdb->prefix . sm_employees. ' where id='.'"'.intval($_GET['empid']).'"');
					?>    
		          <input type="hidden" id="enddate" name="enddate"/>	
				  <label>Employee :</label>
				  <div class="form_input">
				  		<input type="text" value="<?php echo $empnm; ?>" disabled="disabled"></input>
				  </div>
			</li>
			<li>
				  <?php
   				   
				    $table_name = $wpdb->prefix . "sm_bookings";
				    $clid=$wpdb->get_var("select client_id from ".$table_name." where id = " . intval($_REQUEST['id']));
					$gettime = $wpdb->get_row
					(
							$wpdb->prepare
							(
							        "SELECT StartTime,EndTime,Date FROM ".$wpdb->prefix."sm_bookings WHERE id = %d",
							         intval($_REQUEST['id'])
							)
					);	
					$cltnam = $wpdb->get_row
					(
							$wpdb->prepare
							(
							        "SELECT name,lastname,email,mobile,addressLine1 FROM ".$wpdb->prefix."sm_clients WHERE id = %d",
							         $clid
							)
					);	
					
				   
					$sttime=$gettime->StartTime;
					$sttm=explode(" ",$sttime);
					$edtime=$gettime->EndTime;
					$edttm=explode(" ",$edtime);
					$dat=$gettime->Date;
	?>
		          <input type="hidden" id="enddate" name="enddate"/>	
				  <label>Client Name :</label>
				  <div class="form_input">
				  		<input type="text" value="<?php echo $cltnam->name ." ". $cltnam->lastname; ?>" disabled="disabled"></input>
				  </div>
			</li>
			<li>
				  <label>Client Email :</label>
				  <div class="form_input">
				  		<input type="text" value="<?php echo $cltnam->email; ?>" disabled="disabled"></input>
				  </div>
			</li>
			<?php
			if($cltnam->mobile != 'undefined' && $cltnam->mobile != '')
			{
			?>
			<li>
				  <label>Client Mobile :</label>
				  <div class="form_input">
				  <input type="text" value="<?php echo $cltnam->mobile; ?>" disabled="disabled"></input>
				  </div>
			</li>
			<?php
			}
			?>
			<li>
				  <label>Booking Date :</label>
				  <div class="form_input">
				  		<input type="text" value="<?php echo $dat;?>" disabled="disabled"></input>
				  </div>
			</li>
			<li>
				  <label>Start Time :</label>
				  <div class="form_input">
				  		<input type="text" value="<?php echo $sttm[1];?>" disabled="disabled"></input>
				  </div>
		    </li>
			<li>
				  <label>End Time :</label>
				  <div class="form_input">
				  		<input type="text" value="<?php echo $edttm[1];?>" disabled="disabled"></input>
				  </div>
			</li>
		</ul>	  	 
	</div>
	</div>		
	<?php
	}
	?>

<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$url = plugins_url('', __FILE__) . "/"; 
if(isset($_REQUEST['action']))
{
	if($_REQUEST['action'] == "GetEmployees")
	{
			$trans = $wpdb->get_results
			(
					$wpdb->prepare
					(
							"SELECT * FROM ".$wpdb->prefix."sm_translation "
					)
			);
			?>
		<script type="text/javascript">jQuery("select, input:checkbox, input:radio").uniform();</script>
		<input type="hidden" id="serviceidd" value="<?php echo intval($_REQUEST['serviceId']);?>"/>
		<table class="activity_datatable" width="100%" border="0" cellspacing="0" cellpadding="8">
		<tbody>
			<tr >
				<th width="60%" style="text-align:left;padding-left:15px;"> <?php echo $trans[10]->translate; ?> </th>
			</tr>
				<?php
				$sidd = intval($_REQUEST['serviceId']);
				$name = $wpdb->get_col
				(
						$wpdb->prepare
						(
								'SELECT emp_name FROM '.$wpdb->prefix.'sm_employees join '. $wpdb->prefix .'sm_allocate_serv  on ' . $wpdb->prefix . 'sm_employees.id = ' .$wpdb->prefix .'sm_allocate_serv.emp_id where  ' .$wpdb->prefix .'sm_allocate_serv.serv_id = %d and ' . $wpdb->prefix . 'sm_employees.status = %s  ORDER BY ' .$wpdb->prefix .'sm_employees.emp_name ASC',
								$sidd,
								"Active"
								
						)
				);
				$id = $wpdb->get_col
				(
						$wpdb->prepare
						(
								'SELECT ' . $wpdb->prefix . 'sm_employees.id FROM ' . $wpdb->prefix . 'sm_employees join '. $wpdb->prefix .'sm_allocate_serv on ' . $wpdb->prefix . 'sm_employees.id = ' .$wpdb->prefix .'sm_allocate_serv.emp_id where  ' .$wpdb->prefix .'sm_allocate_serv.serv_id = %d and ' . $wpdb->prefix .'sm_employees.status = %s  ORDER BY ' .$wpdb->prefix .'sm_employees.emp_name ASC',
								$sidd,
								"Active"
								
						)
				);
				$count= $wpdb->get_var('SELECT count('. $wpdb->prefix . sm_employees . '.id) FROM ' . $wpdb->prefix . sm_employees .'  join '. $wpdb->prefix .sm_allocate_serv .' on ' . $wpdb->prefix . sm_employees . '.id=' .$wpdb->prefix .sm_allocate_serv .'.emp_id where  ' .$wpdb->prefix .sm_allocate_serv . '.serv_id='.$sidd .' and ' . $wpdb->prefix . sm_employees . '.status = "Active"');
				for($i=0;$i<$count;$i++)
				{
				$nam = $name[$i];
				$idd = $id[$i];
				?>
				<tr>
				<td>
						<div class="form_input">
							<?php
								if($count=="1")
								{
								?>
									<input id="radio3<?php echo $i;?>" name="radio3" checked="checked" type="radio" value="<?php echo $idd;?>"/>
									<label for="radio3"><?php echo $nam;?></label>
									<input type="hidden" id="lblemp<?php echo $i;?>" value="<?php echo $nam;?>"/>
									<?php
								}
								else
								{
								?>
									<input id="radio3<?php echo $i;?>" name="radio3" type="radio" value="<?php echo $idd;?>"/>
									<label for="radio3"><?php echo $nam;?></label>
									<input type="hidden" id="lblemp<?php echo $i;?>" value="<?php echo $nam;?>"/>
									<?php
								}
								?>
						</div>
				</td>
				</tr> 
			<?php 
				}
				?>
		</tbody>
		</table>
<?php
	}
}
else
{
		$msg1  =  $wpdb->get_var('SELECT translate  FROM ' . $wpdb->prefix . sm_translation . ' where id = 17');
		$msg2  =  $wpdb->get_var('SELECT translate  FROM ' . $wpdb->prefix . sm_translation . ' where id = 18');

include ("prev_calphp.php");
?>	

<script type="text/javascript">jQuery("select, input:checkbox, input:radio").uniform();</script>
<link rel="stylesheet" href="<?php echo $url;?>css/droplinetabs1.css" />
<link rel='stylesheet'  href='<?php echo $url;?>css/front.css' type='text/css' media='all' />
<link rel='stylesheet'  href='<?php echo $url;?>css/calendar5.css' type='text/css' media='all' />
<div id="divhid"></div>
	
<script type="text/javascript">
var message1 = "<?php echo $msg1;?>";
var message2 = "<?php echo $msg2;?>";
var uri = "<?php echo plugins_url('', __FILE__);?>";
var dat = new Date();
var today=dat.getDate();
var month = dat.getMonth() +1;
var year =  dat.getFullYear();	
/*********************************************************************************/	
/* Code for Button 01 Starts here */	
function nextButton01()
{
	var radios = document.getElementsByName('radio1');
	var value1;
	for (var i = 0; i < radios.length; i++) 
	{
		if (radios[i].type == 'radio' && radios[i].checked) 
		{
			value1 = radios[i].value;
			break;
		}
	}
	if(value1 != undefined || value1 != null)
	{
			jQuery("#step101").css("display","none");
			jQuery("#step201").css("display","block");
			jQuery("#step301").css("display","none");
			jQuery("#step401").css("display","none");
			jQuery("#step501").css("display","none");
			path= uri+"/backendbooking_bookingtab.php";
			jQuery.ajax({
							type: "POST",
							data: "serviceId="+value1+"&action=GetEmployees",
							url: path,
							success: function(data)
							{
								jQuery("#diveser12").html(data);
							}
					});
		
	}
	else
	{
		alert('Please select atleast 1 Service');
	}
	
}
/* Code for Button 01 Ends here */
/*********************************************************************************/

/* Code for Button 02 Starts here */
function nextButton02()
{
		var radios03 = document.getElementsByName('radio3');
		var value03;
		for (var i = 0; i < radios03.length; i++) 
		{
			if (radios03[i].type == 'radio' && radios03[i].checked) 
			{
				value03 = radios03[i].value;
				break;
			}
		}
		if(value03 != undefined || value03 != null)
		{
			jQuery("#step101").css("display","none");
			jQuery("#step201").css("display","none");
			jQuery("#step301").css("display","block");
			jQuery("#step401").css("display","none");
			jQuery("#step501").css("display","none");
		
			var val = document.getElementById('serviceidd').value;
			var dat = new Date();
			var today=dat.getDate();
			var month = dat.getMonth() +1;
			var year =  dat.getFullYear();
			if(!document.getElementById('hiinpday'))
			{
				var ydy=document.getElementById('divhid');
				var hiinpday=document.createElement('input');
				hiinpday.type='hidden';
				hiinpday.value=today;
				hiinpday.setAttribute('id','hiinpday');
				ydy.appendChild(hiinpday);
			}
			else
			{
				document.getElementById('hiinpday').value=today;
			}
			if(!document.getElementById('hiinpmonth'))
			{
				var ydy=document.getElementById('divhid');
				var hiinpmonth=document.createElement('input');
				hiinpmonth.type='hidden';
				hiinpmonth.value=month;
				hiinpmonth.setAttribute('id','hiinpmonth');
				ydy.appendChild(hiinpmonth);
			}
			else
			{
				document.getElementById('hiinpmonth').value=month;
			}
			if(!document.getElementById('hiinpyear'))
			{
				var ydy=document.getElementById('divhid');
				var hiinpyear=document.createElement('input');
				hiinpyear.type='hidden';
				hiinpyear.value=year;
				hiinpyear.setAttribute('id','hiinpyear');
				ydy.appendChild(hiinpyear);
			}
			else
			{
				document.getElementById('hiinpyear').value=year;
			}
			<?php 
			$minformat  =  $wpdb->get_var('SELECT minuteformat  FROM ' . $wpdb->prefix . sm_settings . ' where id = 1');
			?>
			var minformat = "<?php echo $minformat; ?>";
			if(minformat==1)
			{
				path= uri+"/calendar.php";
			}
			else
			{
				path= uri+"/calendar30.php";
			}
			if(!document.getElementById('hitime'))
			{
				jQuery.ajax
				({
						type: "POST",
						data: "cservice="+val+"&empId="+value03+"&cmonth="+month+"&cyear="+year+"&cday="+today+"&years=true",
						url: path,
						success: function(data)
						{
								var temp=data;
								var index2=temp.indexOf("/table");
								var ind=index2+7;
								var cal=temp.substring(0, ind);
								jQuery("#displayed_cal").html(cal);
								var last=temp.lastIndexOf("/a>");
								var l_index=last+3;
								var time=temp.substring(ind,l_index);
								var s = time;
								var res=s.indexOf("</a>") != -1;
								if(res==true)
								{
									jQuery("#service_timings").html(time);
								}
								else
								{
									jQuery("#service_timings").html(" <div style='text-align:center;font-size:12px;font-solid;float:left;padding:80px;'>Bookings are not available for this date.</div>");
								}
						}
					});
			}
	

		}
		else
		{
			alert('Please select atleast 1 Employee');
		}
}
/* Code for Button 02 Ends here */
/*********************************************************************************/

/* Code for Button 03 Starts here */
function nextButton03()
{
	if(document.getElementById('hitime'))
	{
		if(document.getElementById('hitime').value != "")
		{
		
					var tottime = document.getElementById('hitime').value;
					var service_id = document.getElementById('serviceidd').value;
					var day=document.getElementById('hiinpday').value;
					var month=document.getElementById('hiinpmonth').value;
					var year=document.getElementById('hiinpyear').value;
					var radios = document.getElementsByName('radio3');	
					var value;
					for (var i = 0; i < radios.length; i++) 
					{
						if (radios[i].type == 'radio' && radios[i].checked) 
						{
							value = radios[i].value;
							break;
						}
					}
					var emp=value;
					
					filepath525 = uri + "/servicehours.php";
					jQuery.ajax
					({
						type : "POST",
						data : "booktime="+tottime+"&serv="+service_id+"&emp="+emp+"&cmonth=" + month + "&cyear=" + year + "&cday=" + day,
						url : filepath525,
						success : function(data) 
						{
							var test = jQuery.trim(data);
							if(test == '1')
							{
									jQuery("#step101").css("display","none");
									jQuery("#step201").css("display","none");
									jQuery("#step301").css("display","none");
									//jQuery("#step401").css("display","none");
									jQuery("#step501").css("display","none");
						
									var radios = document.getElementsByName('radio3');
									var val;
									var empnm;
									for (var i = 0; i < radios.length; i++) 
									{
										if (radios[i].type == 'radio' && radios[i].checked) 
										{
											val = radios[i].value;
											empnm=document.getElementById('lblemp'+i).value;
											break;
										}
									}
									var radios = document.getElementsByName('radio1');
									var value;
									var sernam;
									for (var i = 0; i < radios.length; i++) 
									{
										if (radios[i].type == 'radio' && radios[i].checked) 
										{
												value = radios[i].value;
												sernam=document.getElementById('radio11'+i).value;
												break;
										}
									}
									var day=document.getElementById('hiinpday').value;
									var month=document.getElementById('hiinpmonth').value;
									var year=document.getElementById('hiinpyear').value;
									var booked_time= document.getElementById('hitime').value;
									var hrs=booked_time.split(":");
									var cokval=value+"-"+val+"-"+day+"-"+month+"-"+year+"-"+hrs[0]+"-"+hrs[1]+"-"+empnm+"-"+sernam;
									cookievalue= escape(cokval) + ";";
									cookie="eg="+cookievalue;	
									nextButton04()					
						    }
							else if(test ='0')
							{
								alert(message1);
								return false;
							}
							else if(test ='2')
							{
								alert(message2);
								return false;
							}
						}
				});
		}
		else
		{
			alert('Please Select time');
		}
	}
	else
	{
		alert('Please Select time');
	}
}
/* Code for Button 03 Ends here */
/*********************************************************************************/
/* Code for Button 04 Starts here */
function nextButton04()
{
	var allcookies = cookie;
	var cokiesss=allcookies.split(";");
	var fcookes=cokiesss[0].split('=');
	var fcook=fcookes[1].split('-');
	valll =fcook[1];
	valllsr = fcook[0];
	var day= fcook[2];
	var month = fcook[3];
	var year = fcook[4];
	var booked_time= fcook[5]+":"+fcook[6];
	var service=fcook[0];
	var emp=fcook[1];
	var fnam=jQuery("#firstname").val();
	var eml=jQuery("#emaill").val();
	if(document.getElementById('mobile'))
	{
		var mob=jQuery("#mobile").val();
	}
	if(document.getElementById('ad1'))
	{
		var adrs1=jQuery("#ad1").val();
	}
	if(document.getElementById('ad2'))
	{
		var adrs2=jQuery("#ad2").val();
	}
	if(document.getElementById('city'))
	{
		var cty=jQuery("#city").val();
	}
	if(document.getElementById('pc'))
	{
		var pc=jQuery("#pc").val();
	}
	if(document.getElementById('country'))
	{
		var contry=jQuery("#country").val();
	}
	if(document.getElementById('lastname'))
	{
		var lnam=jQuery("#lastname").val();
	}
	if(document.getElementById('phone'))
	{
		var phone=jQuery("#phone").val();
	}
	var s = fcook[7];
	var lbdispemp=unescape(s);
			
	var serv = fcook[8];
	
	var lbdispser= unescape(serv);
			document.getElementById('lbl_ser').innerHTML=lbdispser;
			document.getElementById('lbl_emp').innerHTML=lbdispemp;
			var bokdt=year+"-"+month+"-"+day;
			document.getElementById('lbl_bdat').innerHTML=bokdt;
			document.getElementById('lbl_btime').innerHTML=booked_time;
			if(document.getElementById('lbl_0'))
			{
				document.getElementById('lbl_0').innerHTML=fnam;
			}
			if(document.getElementById('lbl_1'))
			{
				if(lnam!="")
				{
					document.getElementById('lbl_1').innerHTML=lnam;
				}
				else
				{
					var obj1 = document.getElementById('dlnm')
					obj1.style.display = 'none';
				}
			}
			if(document.getElementById('lbl_2'))
			{
				document.getElementById('lbl_2').innerHTML=eml;
			}
			if(document.getElementById('lbl_3'))
			{
				document.getElementById('lbl_3').innerHTML=mob;
			}
			if(document.getElementById('lbl_4'))
			{
				document.getElementById('lbl_4').innerHTML=adrs1;
			}
			if(document.getElementById('lbl_5'))
			{
				document.getElementById('lbl_5').innerHTML=adrs2;
			}
			if(document.getElementById('lbl_6'))
			{
				document.getElementById('lbl_6').innerHTML=cty;
			}
			if(document.getElementById('lbl_7'))
			{
				document.getElementById('lbl_7').innerHTML=pc;
			}
			if(document.getElementById('lbl_8'))
			{
				document.getElementById('lbl_8').innerHTML=contry;
			}
			if(document.getElementById('lbl_9'))
			{
				document.getElementById('lbl_9').innerHTML=phone;
			}
			
			jQuery("#step101").css("display","none");
			jQuery("#step201").css("display","none");
			jQuery("#step301").css("display","none");
			jQuery("#step401").css("display","none");
			jQuery("#step501").css("display","block");
			
		}
		function bookItNow1()
		{
		<?php
		$emailch = $wpdb->get_var('SELECT email FROM ' . $wpdb->prefix . sm_clients . ' where id=' . '"' . $_REQUEST['custId'] . '"'); ?>
		var emailcheck = "<?php echo $emailch; ?>"; 
		if(emailcheck!="")
		{
			var em = confirm("Click OK if you wish to send a confirmation email to the customers. (clicking \"Cancel\" will confirm the booking but will not send an email to the client)");
			if(em==true)
			{
			var emi = "1";
			}
			else
			{
			var emi = "0";
			}
		}
			var radios = document.getElementsByName('radio3');
			var value;
			for (var i = 0; i < radios.length; i++) 
			{
				if (radios[i].type == 'radio' && radios[i].checked) 
				{
					value = radios[i].value;
					break;
				}
			}
			var allcookies = cookie;
			var cokiesss=allcookies.split(";");
			var fcookes=cokiesss[0].split('=');
			var fcook=fcookes[1].split('-');
			var service=fcook[0];
			var emp=fcook[1];
			var day= fcook[2];
			var month = fcook[3];
			var year = fcook[4];
			var mnnnn=fcook[6];
			var ress=mnnnn.indexOf("AM") != -1;
			if(ress==true)
			{
				var spl=mnnnn.split("AM");
				var hrsv= fcook[5];
				var mnsv=spl[0];
			}
			else
			{
				var resss=mnnnn.indexOf("PM") != -1;
				if(resss==true)
				{
					var spl=mnnnn.split("PM");
					if(fcook[5]==12)
					{
						var hrsv= fcook[5];
						var mnsv=spl[0];
					}
					else
					{
						var hrfd=fcook[5];
						var ty=12;
						var hrsv=parseInt(ty)+parseInt(hrfd);
						var mnsv=spl[0];
					}
				}
			}
			if(ress==false && resss==false)
			{
				var hrsv=fcook[5];
				var mnsv=fcook[6];
			}
			var booked_time= hrsv+":"+mnsv;
			var fnam=jQuery("#firstname").val();
			var eml=jQuery("#emaill").val();
			var mob=jQuery("#mobile").val();
			var phone=jQuery("#phone").val();
			var adrs1=jQuery("#ad1").val();
			var adrs2=jQuery("#ad2").val();
			var cty=jQuery("#city").val();
			var pc=jQuery("#pc").val();
			var contry=jQuery("#country").val();
			var lnam=jQuery("#lastname").val();
            var urlSite = "<?php echo site_url(); ?>";
			jQuery(document).ready(function($) 
			{
			
				
				filepath3=uri+"/sendmail.php";
				jQuery.ajax({
							type: "POST",
							data: "bmonth="+month+"&byear="+year+"&bday="+day+"&empnam="+emp+"&em="+emi+"&phone="+phone+"&bname="+jQuery("#firstname").val()+"&bemail="+eml+"&bmobile="+jQuery("#mobile").val()+"&btime="+booked_time+"&bservice="+service+"&bad1="+jQuery("#ad1").val()+"&bad2="+jQuery("#ad2").val()+"&bcity="+jQuery("#city").val()+"&bpc="+jQuery("#pc").val()+"&bcountry="+jQuery("#country").val()+"&lname="+jQuery("#lastname").val(),
							url: filepath3,
							success: function(data) 
							{
									jQuery("#step101").css("display","none");
									jQuery("#step201").css("display","none");
									jQuery("#step301").css("display","none");
									jQuery("#step401").css("display","none");
									jQuery("#step501").css("display","none");
									jQuery("#step601").css("display","block");
									setTimeout( function()
									{
									window.location.href = urlSite +"/wp-admin/admin.php?page=TabBooking";
									},3000);
							}
						});
			});
			
		}
		function backButton02()
		{
			jQuery("#step101").css("display","block");
			jQuery("#step201").css("display","none");
			jQuery("#step301").css("display","none");
			jQuery("#step401").css("display","none");
			jQuery("#step501").css("display","none");
			
		}
		function backButton03()
		{
			jQuery("#step101").css("display","none");
			jQuery("#step201").css("display","block");
			jQuery("#step301").css("display","none");
			jQuery("#step401").css("display","none");
			jQuery("#step501").css("display","none");
			
		}
		function backButton04()
		{
			jQuery("#step101").css("display","none");
			jQuery("#step201").css("display","none");
			jQuery("#step301").css("display","block");
			jQuery("#step401").css("display","none");
			jQuery("#step501").css("display","none");
			
		}
		function backButton05()
		{
			jQuery("#step101").css("display","none");
			jQuery("#step201").css("display","none");
			jQuery("#step301").css("display","block");
			jQuery("#step401").css("display","none");
			jQuery("#step501").css("display","none");
	
		}
		function validatePhone(e, inputElement)
	{
				var digitsOnly = /[1234567890]/g;
				if (!e) var e = window.event
				if (e.keyCode) code = e.keyCode;
				else if (e.which) code = e.which;
				var character = String.fromCharCode(code);
				if (!e.ctrlKey && code!=9 && code!=8) 
				{
					if (character.match(digitsOnly)) 
					{
						return true;
					} 
					else 
					{
						return false;
					}
				}
	}
	</script>
		<div class="superContainer1">
			<div class="maincontainer1" style="display:none;">
				<div id="logocontainer" class="logoContainer1">
				<?php $table_name = $wpdb -> prefix . "sm_settings";
					   $booked_note = $wpdb -> get_var('SELECT book_header FROM ' . $table_name);
					?>
					<?php echo $booked_note;?>
					</div>
						<?php
								$thanks = $wpdb->get_var('SELECT thanks from ' . $wpdb->prefix . sm_settings . ' where id=1');
								$trans = $wpdb->get_results
								(
										$wpdb->prepare
										(
												"SELECT * FROM ".$wpdb->prefix."sm_translation"
										)
								);
								for($i=0;$i<=count($trans);$i++)
								{
									 
								}	
								?>
				<div class="contentarea1">
					<div class="one_wrap fl_left" id="step101" style="display:block">
						<div class="menus">
							<div id="droplinetabs1" class="droplinetabs1">
								<ul class="crBreadcrumbs">
									<li>
										<a href="#" rel="1"  class="crBreadcrumbs focus"><span>1</span><?php echo $trans[0]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="2" class="crBreadcrumbs"><span>2</span><?php echo $trans[1]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="3"  class="crBreadcrumbs"><span>3</span><?php echo $trans[2]->translate; ?></a>
									</li>
								
									<li>
										<a href="#" rel="4"  class="crBreadcrumbs"><span>4</span><?php echo $trans[4]->translate; ?></a>
									</li>
								</ul>
							</div>
							
						</div>
						<div class="widget-wp-obs" style="margin-top:5px;margin-bottom:0px;max-height: 450px;">
							<div class="widget-wp-obs_title">
								<span class="iconsweet">f</span>
								<h5> <?php echo $trans[5]->translate; ?></h5>
							</div>
							<div class="widget-wp-obs_body">
								<form action="" method="post">
									<table class="activity_datatable" width="100%" border="0" cellspacing="0" cellpadding="8">
										<tbody>
											<tr>
												<th width="60%" style="text-align:left;padding-left:15px;"> <?php echo $trans[6]->translate; ?>  </th>
												<th width="20%" style="text-align:left;padding-left:15px;"> <?php echo $trans[7]->translate; ?>  </th>
												<th width="20%" style="text-align:left;padding-left:15px;"> <?php echo $trans[8]->translate; ?>  </th>
											</tr>
											<?php
														$hour = $wpdb->get_results
														(
																$wpdb->prepare
																(
																		'SELECT * FROM ' . $wpdb->prefix . 'sm_services_time join '. $wpdb->prefix .'sm_services on ' . $wpdb->prefix . 'sm_services_time.service_id = ' .$wpdb->prefix .'sm_services.id order by rank ASC'
																)
														);
														$count =$wpdb->get_var('SELECT count(' . $wpdb->prefix . sm_services .'.id) FROM ' . $wpdb->prefix . sm_services .' join '. $wpdb->prefix .sm_services_time .' on ' . $wpdb->prefix . sm_services . '.id=' .$wpdb->prefix .sm_services_time .'.service_id order by rank ASC');
														$service_currency = $wpdb->get_var('SELECT currency FROM ' . $wpdb->prefix . sm_currency);
														$cur_icon =  $wpdb->get_var('SELECT currency_sign  FROM ' . $wpdb->prefix . sm_currency . ' where currency_used = "1"');
														for( $i = 0; $i < $count; $i++)
														{
														$idd=$hour[$i]->id;
														$nam=$hour[$i]->name;
														$hr=$hour[$i]->hours;
														$min=$hour[$i]->minutes;
														$pr=$hour[$i]->cost;
											?>

											<tr>
												<td>
												<div class="form_input">
														<?php
												if($count=="1")
												{
												?>
												<input id="radio1<?php echo $i;?>" name="radio1" checked="checked" type="radio" value="<?php echo $idd;?>">
													<label for="radio1"><?php echo $nam;?></label>
													<input type="hidden" id="radio11<?php echo $i;?>" value="<?php echo $nam;?>"/>
												<?php
												}
												else
												{
												?>
													<input id="radio1<?php echo $i;?>" name="radio1" type="radio" value="<?php echo $idd;?>">
													<label for="radio1"><?php echo $nam;?></label>
													<input type="hidden" id="radio11<?php echo $i;?>" value="<?php echo $nam;?>"/>
												<?php
												}
												?>
												</div></td>
												<td>
												<div class="form_input">
													<?php if($hr==0 && $min!=0)
{
													?><label><?php echo $min, " mins";?></label>
													<?php }
														elseif($min!=0 && $hr!=0)
														{
													?>
													<label><?php echo $hr, "hrs", ", ", $min, " mins";?></label>
													<?php }
															else
															{
													?>
													<label><?php echo $hr, "hrs";?></label>
													<?php }?>
												</div></td>
												<td>
												<div class="form_input">
													<label> <?php echo $cur_icon . " " . $pr;?></label>
												</div></td>
											</tr>
											<?php }?>
										</tbody>
									</table>
								</form>
							</div>
						</div>
						<ul class="form_fields_container">
							<li style="background:none">
								<div  style="text-align:right;margin-right:0px">
									<a href="#" onclick="nextButton01();" class="greyishBtn button_small" shape="margin-right:0px;"><?php echo $trans[9]->translate; ?></a>
								</div>
							</li>
						</ul>
					</div>
					<div class="one_wrap fl_left" id="step201" style="display:none" >
						<div class="menus">
							<!--  <img src="images/1.png" />-->
							<div id="droplinetabs1" class="droplinetabs1">
								<ul class="crBreadcrumbs">
									<li>
										<a href="#" rel="1" class="crBreadcrumbs"><span>1</span><?php echo $trans[0]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="2" class="crBreadcrumbs focus"><span>2</span><?php echo $trans[1]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="3" class="crBreadcrumbs"><span>3</span><?php echo $trans[2]->translate; ?></a>
									</li>
									
									<li>
										<a href="#" rel="4" class="crBreadcrumbs"><span>4</span><?php echo $trans[4]->translate; ?></a>
									</li>
								</ul>
							</div>
							
						</div>
									<div class="widget-wp-obs" style="margin-top:5px;margin-bottom:0px;">
							<div class="widget-wp-obs_title">
								<span class="iconsweet">f</span>
								<h5> <?php echo $trans[5]->translate; ?></h5>
							</div>
							<div  class="widget-wp-obs_body"  id="diveser12">
							
							</div>
						</div>
						<ul class="form_fields_container">
							<li style="background:none">
								<div  style="text-align:right;margin-right:0px">
									<a href="#" onclick="backButton02();" class="greyishBtn button_small"  style="float:left"><?php echo $trans[11]->translate; ?></a>
									<a href="#" onclick="nextButton02();" class="greyishBtn button_small" shape="margin-right:0px;"><?php echo $trans[9]->translate; ?></a>
								</div>
							</li>
						</ul>
					</div>
					<div class="one_wrap fl_left" id="step301" style="display:none">
						<div class="menus">
							<div id="droplinetabs1" class="droplinetabs1">
									<ul class="crBreadcrumbs">
									<li>
										<a href="#" rel="1" class="crBreadcrumbs"><span>1</span><?php echo $trans[0]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="2" class="crBreadcrumbs"><span>2</span><?php echo $trans[1]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="3" class="crBreadcrumbs focus"><span>3</span><?php echo $trans[2]->translate; ?></a>
									</li>
									
									<li>
										<a href="#" rel="4" class="crBreadcrumbs"><span>4</span><?php echo $trans[4]->translate; ?></a>
									</li>
								</ul>
							</div>
						</div>
									<div class="widget-wp-obs" style="margin-top:5px;margin-bottom:0px">
							<div class="widget-wp-obs_title">
								<span class="iconsweet">f</span>
								<h5> <?php echo $trans[5]->translate; ?></h5>
							</div>
							<div class="widget-wp-obs_body">
								<table class="activity_datatable" id="diveser12" width="100%" border="0" cellspacing="0" cellpadding="8">
									<tbody>
										<tr >
											<th width="10%" style="text-align:left;padding-left:15px;"><?php echo $trans[12]->translate; ?>  </th>
											<th width="90%" style="text-align:left;padding-left:15px;"><?php echo $trans[13]->translate; ?> </th>
										</tr>
										<tr>
											<td style="padding:10px">
											<div class="date_restaurant" style="margin:0px; padding:0px;">
												<div class="color1_restaurant" style="margin:0px; padding:0px;"></div>
												<?php $MonthAlphanum = date("m");?>
												<input type="hidden" id="monthtxt" name="monthtxt" value ="<?php echo $MonthAlphanum;?>"/>
												<div class="contentcalendar_res">
													<?php $MonthAlpha = date("M");
													$curYear = date("Y");
													?>
													<div class="year_res" id="monthdisp">
														<a id="prev_month" class="prevDate_Lafourchette" href="javascript: ">&lt;</a>
														<span id="cur_cal"><?php echo $MonthAlpha . "-" . $curYear
															?></span>
														<a id="next_month" class="prevDate_Lafourchette" href="javascript: ">&gt;</a>
													</div>
													
													<div id="displayed_cal"></div>
												</div>
											</div></td>
											<td style="float:left;">
													<div id="service_timings"></div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<ul class="form_fields_container">
							<li style="background:none">
								<div  style="text-align:right;margin-right:0px">
									<a href="#" onclick="backButton03();"  class="greyishBtn button_small" style="float:left"><?php echo $trans[11]->translate; ?></a>
									<a href="#"  onclick="return nextButton03();" class="greyishBtn button_small" shape="margin-right:0px;"><?php echo $trans[9]->translate; ?></a>
								</div>
							</li>
						</ul>
					</div>
					<div class="one_wrap fl_left" id="step401" style="display:none">
								<div class="menus">
							<div id="droplinetabs1" class="droplinetabs1">
									<ul class="crBreadcrumbs">
									<li>
										<a href="#" rel="1" class="crBreadcrumbs"><span>1</span><?php echo $trans[0]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="2" class="crBreadcrumbs"><span>2</span><?php echo $trans[1]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="3" class="crBreadcrumbs"><span>3</span><?php echo $trans[2]->translate; ?></a>
									</li>
									
									<li>
										<a href="#" rel="4" class="crBreadcrumbs focus"><span>4</span><?php echo $trans[4]->translate; ?></a>
									</li>
								</ul>
							</div>
						</div>
						<div class="widget-wp-obs" style="margin-top:5px;margin-bottom:0px">
							<div class="widget-wp-obs_title">
								<span class="iconsweet">f</span>
								<h5> <?php echo $trans[5]->translate; ?></h5>
							</div>
							<div class="widget-wp-obs_body">
								<ul class="form_fields_container">
									<?php
										$fname = $wpdb->get_var('SELECT name FROM ' . $wpdb->prefix . sm_clients . ' where id=' . '"' . intval($_REQUEST['custId']) . '"');
										$lname = $wpdb->get_var('SELECT lastname FROM ' . $wpdb->prefix . sm_clients . ' where id=' . '"' . intval($_REQUEST['custId']) . '"');
										$eml = $wpdb->get_var('SELECT email FROM ' . $wpdb->prefix . sm_clients . ' where id=' . '"' . intval($_REQUEST['custId']) . '"');
										$tel = $wpdb->get_var('SELECT telephone FROM ' . $wpdb->prefix . sm_clients . ' where id=' . '"' . intval($_REQUEST['custId']) . '"');
										$add1 = $wpdb->get_var('SELECT addressLine1 FROM ' . $wpdb->prefix . sm_clients . ' where id=' . '"' . intval($_REQUEST['custId']) . '"');
										$add2 = $wpdb->get_var('SELECT addressLine2 FROM ' . $wpdb->prefix . sm_clients . ' where id=' . '"' . intval($_REQUEST['custId']) . '"');
										$cty = $wpdb->get_var('SELECT city FROM ' . $wpdb->prefix . sm_clients . ' where id=' . '"' . intval($_REQUEST['custId']) . '"');
										$post = $wpdb->get_var('SELECT postalcode FROM ' . $wpdb->prefix . sm_clients . ' where id=' . '"' . intval($_REQUEST['custId']) . '"');
										$cntry = $wpdb->get_var('SELECT country  FROM ' . $wpdb->prefix . sm_clients . ' where id=' . '"' . intval($_REQUEST['custId']) . '"');
										$mobile = $wpdb->get_var('SELECT mobile FROM ' . $wpdb->prefix . sm_clients . ' where id=' . '"' . intval($_REQUEST['custId']) . '"');
										$fields = $wpdb->get_results
										(
												$wpdb->prepare
												(
														"SELECT * FROM ".$wpdb->prefix."sm_booking_field where status = %d",
														"1"
												)
										);
										for($i=0;$i<10;$i++)
										{
										$fiel = $fields[$i]->field_name;
										$fiel2 = $fields[$i]->field_name2;
										$stat = $fields[$i]->status;
										$req  = $fields[$i]->required ;
									?>
									<li style="background:none;padding-bottom:0px;border:none">
										<?php
											if($fiel=="First Name :")
											{
										?>
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input class="tip_west" onblur="return bookingblur(this);" Disabled="disabled" id="firstname" type="text" value="<?php echo $fname; ?>" original-title="First Name" >
										</div>
									</li>
									<?php }

										if($fiel=="Last Name :")
										{
									?>
									<li style="background:none;padding-top:0px;padding-bottom:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input class="tip_west" type="text" id="lastname" Disabled="disabled" onblur="return bookingblur(this);" value="<?php echo $lname; ?>" original-title="Last Name">
										</div>
									</li>
									<?php }
										if($fiel=="Email :")
										{
									?>
									<li style="background:none;padding-top:0px;padding-bottom:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
										
												
											<input class="tip_west" type="text" id="emaill" Disabled="disabled" onblur="return bookingblur(this);" value="<?php echo $eml; ?>" original-title="Email Address">
											
										</div>
									</li>
									<?php }

										else if($fiel=="Mobile :")
										{
									?>
									<li style="background:none;padding-top:0px;padding-bottom:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input class="tip_west" type="text" Disabled="disabled" value="<?php echo $mobile; ?>" onKeyPress="return validatePhone(event,this)" onblur="return bookingblur(this);" id="mobile" original-title="Mobile Number">
										</div>
									</li>
									<?php }

										else if($fiel=="Phone :")
										{
									?>
								<li style="background:none;padding-top:0px;padding-bottom:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input class="tip_west" type="text" Disabled="disabled" value="<?php echo $tel; ?>" onKeyPress="return validatePhone(event,this)" onblur="return bookingblur(this);" id="phone" original-title="Phone Number">
										</div>
									</li>
									<?php }

										else if($fiel=="Address Line1 :")
										{
									?>
								<li style="background:none;padding-top:0px;padding-bottom:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input class="tip_west" type="text"  Disabled="disabled" value="<?php echo $add1; ?>" onblur="return bookingblur(this);" id="ad1" original-title="Address Line 1">
										</div>
									</li>
									<?php }
										else if($fiel=="Address Line2 :")
										{
									?>
									<li style="background:none;padding-top:0px;padding-bottom:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input class="tip_west" type="text" Disabled="disabled" value="<?php echo $add2; ?>" onblur="return bookingblur(this);" id="ad2" original-title="Address Line 2">
										</div>
									</li>
									<?php }
										else if($fiel=="City :")
										{
									?>
									<li style="background:none;padding-top:0px;padding-bottom:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input class="tip_west" Disabled="disabled" type="text" id="city" onblur="return bookingblur(this);" value="<?php echo $cty; ?>" original-title="City">
										</div>
									</li>
									<?php }
										else if($fiel=="Zip/Post Code :")
										{
									?>
								<li style="background:none;padding-top:0px;padding-bottom:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input class="tip_west" Disabled="disabled" type="text" value="<?php echo $post; ?>"  onblur="return bookingblur(this);" id="pc" original-title="Post Code / Zip Code">
										</div>
									</li>
									<?php }
										if($fiel=="Country :")
										{
									?>
									<li style="background:none;padding-top:0px;padding-bottom:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
										<input class="tip_west" Disabled="disabled" type="text" value="<?php echo $cntry; ?>" onKeyPress="return validatePhone(event,this)"  id="country" original-title="country">
										</div>
									</li>
									<?php }
										}
									?>
									
								</ul>
							</div>
						</div>	<ul class="form_fields_container">
					<li style="background:none">
										<div style="text-align: right;margin-right:0px;">
											<a href="#" onclick="backButton04();" class="greyishBtn button_small" style="float:left"><?php echo $trans[11]->translate; ?></a>
											<a class="greyishBtn button_small" onclick="return nextButton04();" id="nextbtn4"><?php echo $trans[9]->translate; ?></a>
										</div>
								</li></ul>
					</div>
					<div class="one_wrap fl_left" id="step501" style="display:none" >
						<div class="menus">
							<div id="droplinetabs1" class="droplinetabs1">
									<ul class="crBreadcrumbs">
									<li>
										<a href="#" rel="1" class="crBreadcrumbs"><span>1</span><?php echo $trans[0]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="2" class="crBreadcrumbs"><span>2</span><?php echo $trans[1]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="3" class="crBreadcrumbs"><span>3</span><?php echo $trans[2]->translate; ?></a>
									</li>
									
									<li>
										<a href="#" rel="4" class="crBreadcrumbs focus"><span>4</span><?php echo $trans[4]->translate; ?></a>
									</li>
								</ul>
							</div>
						</div>
									<div class="widget-wp-obs" style="margin-top:5px;margin-bottom:0px">
							<div class="widget-wp-obs_title">
								<span class="iconsweet">f</span>
								<h5> <?php echo $trans[5]->translate; ?></h5>
							</div>
							<div class="widget-wp-obs_body">
						<ul class="form_fields_container">
										
								<?php
								
									$translation = $wpdb->get_results
									(
											$wpdb->prepare
											(
													"SELECT * FROM ".$wpdb->prefix."sm_translation"
													
											)
									);
									
										?>	
										<li style="background:none;padding:0px;">
											<label> <?php echo $translation[22]->translate; ?></label>
											<div class="form_input">
											<label id="lbl_ser" value="ad"></label>
											</div>
										</li>
										<li style="background:none;padding:0px;">
											<label> <?php echo $translation[23]->translate; ?></label>
											<div class="form_input">
											<label id="lbl_emp"></label>
											</div>
										</li>
										<li style="background:none;padding:0px;">
											<label> <?php echo $translation[24]->translate; ?></label>
											<div class="form_input">
											<label id="lbl_bdat"></label>
											</div>
										</li>
										<li style="background:none;padding:0px;">
											<label> <?php echo $translation[25]->translate; ?></label>
											<div class="form_input">
											<label id="lbl_btime"></label>
											</div>
										</li>
							<?php
									$fields = $wpdb->get_results
										(
												$wpdb->prepare
												(
														"SELECT * FROM ".$wpdb->prefix."sm_booking_field where status = %d",
														"1"
												)
										);
									for($j=0;$j<count($fields);$j++)
									{
										$fiel = $fields[$j]->field_name;
										$fiel2 = $fields[$j]->field_name2;
										$stat = $fields[$j]->status;
										$req  = $fields[$j]->required ;
										switch($fiel)
										{
											case "First Name :"
							?>
								<li style="background:none;padding:0px;">
								<label> <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="lbl_0"></label>
								</div>
							</li>
							<?php
							break;
							case "Last Name :"
							?>
									<li style="background:none;padding:0px;" id="dlnm">
									<label id="lnm"> <?php echo $fiel2;?></label>
									<div  class="form_input">
										<label id="lbl_1"></label>
									</div>
								</li>
							<?php
							break;
							case "Email :"
							?>
							<li style="background:none;padding:0px;">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="lbl_2"></label>
								</div>
							</li>
							<?php
							break;
							case "Mobile :"
							?>
							<li style="background:none;padding:0px;">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="lbl_3"></label>
								</div>
							</li>
							<?php
							break;

							case "Address Line1 :"
							?>
							<li style="background:none;padding:0px;">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="lbl_4"></label>
								</div>
							</li>
							<?php
							break;
							case "Address Line2 :"
							?>
							<li style="background:none;padding:0px;">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="lbl_5"></label>
								</div>
							</li>
							<?php
							break;
							case "City :"
							?>
							<li style="background:none;padding:0px;">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="lbl_6"></label>
								</div>
							</li>
							<?php
							break;
							case "Post Code :"
							?>
							<li style="background:none;padding:0px;">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="lbl_7"></label>
								</div>
							</li>
							<?php
							break;
							case "Country :"
							?>
							<li style="background:none;padding:0px;">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="lbl_8"></label>
								</div>
							</li>
							<?php
							break;
							case "Phone :"
							?>
							<li style="background:none;padding:0px;">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="lbl_9"></label>
								</div>
							</li>
							<?php
							break;
							}
							}
							?>
						
						</ul></div>
					
						</div>
							<ul class="form_fields_container">
							<li style="background:none">
								<div style="text-align:right;margin-right:0px">
									<a href="#" onclick="backButton05();" class="greyishBtn button_small" style=" float:left"><?php echo $trans[11]->translate; ?></a>
									<a onclick="return bookItNow1();" class="greyishBtn button_small" shape="margin-right:0px;"><?php echo $trans[14]->translate; ?></a>
								</div>
						</li>
						</ul>
					</div>
					
					<div class="one_wrap fl_left" id="step601" style="display:none;padding-bottom:10px;">
						<div class="menus">
						<div id="droplinetabs1" class="droplinetabs1">
						<ul class="crBreadcrumbs">
									<li>
										<a href="#" rel="1" class="crBreadcrumbs"><span>1</span><?php echo $trans[0]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="2" class="crBreadcrumbs"><span>2</span><?php echo $trans[1]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="3" class="crBreadcrumbs"><span>3</span><?php echo $trans[2]->translate; ?></a>
									</li>
								
									<li>
										<a href="#" rel="4" class="crBreadcrumbs focus"><span>4</span><?php echo $trans[4]->translate; ?></a>
									</li>
								</ul>
						</div>
					</div>
									<div class="widget-wp-obs" style="margin-top:5px;margin-bottom:0px" >
							<div class="widget-wp-obs_title">
								<span class="iconsweet">f</span>
								<h5><?php echo $trans[15]->translate; ?></h5>
							</div>
						<div class="widget-wp-obs_body">
						<table class="activity_datatable"  width="100%" border="0" cellspacing="0" cellpadding="8">
						<tbody>
						<tr>
						<td><br><?php echo $thanks; ?></td>
						</tr>
						</tbody>
						</table>
						</div>
					</div>
				</div>
				<label style="color:#848484;margin-top:20px;margin-left:260px;float:left">Booking calendar powered by:  <span  style="color:#EBBC43; text-decoration:none;font-size:11px">WP-OBS</span></label>
			</div>
		</div>
	</div>
<?php 
} 
?>
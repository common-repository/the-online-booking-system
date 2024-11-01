<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-load.php' );
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
<script type="text/javascript" src="<?php echo $url;?>js/form_elements.js"></script>
<script>jQuery("select, input:checkbox, input:radio").uniform(); </script>
		<input type="hidden" id="seridd" value="<?php echo $_REQUEST['serviceId'];?>"/>
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
			</tr> <?php }?>
		</tbody></table>
<?php
	}
	else if($_REQUEST['action'] == "checkemaill")
	{
		$email = esc_attr($_REQUEST['email']);
		$ckemail  =  $wpdb->get_var('SELECT count(id)  FROM ' . $wpdb->prefix . sm_clients . ' where email = '."'". $email ."'");
		if($ckemail==0)
		{
			echo "newcustomer";
		}
		else
		{
			$lname  =  $wpdb->get_var('SELECT lastname  FROM ' . $wpdb->prefix . sm_clients . ' where email = '."'". $email ."'");
			$mobile  =  $wpdb->get_var('SELECT mobile  FROM ' . $wpdb->prefix . sm_clients . ' where email = '."'". $email ."'");
			$telephone  =  $wpdb->get_var('SELECT telephone  FROM ' . $wpdb->prefix . sm_clients . ' where email = '."'". $email ."'");
			$addressLine1  =  $wpdb->get_var('SELECT addressLine1  FROM ' . $wpdb->prefix . sm_clients . ' where email = '."'". $email ."'");
			$addressLine2  =  $wpdb->get_var('SELECT addressLine2  FROM ' . $wpdb->prefix . sm_clients . ' where email = '."'". $email ."'");
			$city  =  $wpdb->get_var('SELECT city  FROM ' . $wpdb->prefix . sm_clients . ' where email = '."'". $email ."'");
			$postalcode  =  $wpdb->get_var('SELECT postalcode  FROM ' . $wpdb->prefix . sm_clients . ' where email = '."'". $email ."'");
			$country  =  $wpdb->get_var('SELECT country  FROM ' . $wpdb->prefix . sm_clients . ' where email = '."'". $email ."'");
			if($lname=="")
			{
				$lnam = "lname1=yes";
			}
			else
			{
				$lnam = "lname1=no";
			}
			if($mobile=="")
			{
				$mob = "mob1=yes";
			}
			else
			{
				$mob = "mob1=no";
			}
			if($telephone=="")
			{
				$tele = "tele1=yes";
			}
			else
			{
				$tele = "tele1=no";
			}
			if($addressLine1=="")
			{
				$add1 = "add1=yes";
			}
			else
			{
				$add1 = "add1=no";
			}
			if($addressLine2=="")
			{
				$add2 = "add2=yes";
			}
			else
			{
				$add2 = "add2=no";
			}
			if($city=="")
			{
				$cty = "city=yes";
			}
			else
			{
				$cty = "city=no";
			}
			if($postalcode=="")
			{
				$post = "post=yes";
			}
			else
			{
				$post = "post=no";
			}
			if($country=="")
			{
				$cntry = "cntry=yes";
			}
			else
			{
				$cntry = "cntry=no";
			}
			$url = $lnam ."&".$mob ."&".$tele ."&".$add1 ."&".$add2 ."&". $cty. "&".$post . "&" .$cntry;
			echo $url;
		}
	}
	
}
else
{

$msg1  =  $wpdb->get_var('SELECT translate  FROM ' . $wpdb->prefix . sm_translation . ' where id = 17');
$msg2  =  $wpdb->get_var('SELECT translate  FROM ' . $wpdb->prefix . sm_translation . ' where id = 18');
?>	
<link rel="stylesheet" href="<?php echo $url;?>css/droplinetabs1.css" />
<link rel='stylesheet'  href='<?php echo $url;?>css/front.css' type='text/css' media='all' />
<link rel='stylesheet'  href='<?php echo $url;?>css/calendar5.css' type='text/css' media='all' />
<link rel="stylesheet" href="<?php echo $url;?>css/typography.css" />
<link rel="stylesheet" href="<?php echo $url;?>css/highlight.css" />
<link rel="stylesheet" href="<?php echo $url;?>css/reset.css" />
<link rel="stylesheet" href="<?php echo $url;?>css/main.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $url;?>js/excanvas.js"></script>
<script type="text/javascript" src="<?php echo $url;?>js/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php echo $url;?>js/form_elements.js"></script>
<script>jQuery("select, input:checkbox, input:radio").uniform(); </script>

<div id="divhid"></div>
<?php include  ("prev_calphp.php"); ?>
<script>
var message1 = "<?php echo $msg1;?>";
var message2 = "<?php echo $msg2;?>";
var uri = "<?php echo plugins_url('', __FILE__);?>";

var dat = new Date();
var today=dat.getDate();
var month = dat.getMonth() +1;
var year =  dat.getFullYear();	
/*********************************************************************************/	
/* Code for Button 1 Starts here */	

function nextButton1()
{
	var radios = document.getElementsByName('radio1');
	var value;
	for (var i = 0; i < radios.length; i++) 
	{
		if (radios[i].type == 'radio' && radios[i].checked) 
		{
			value = radios[i].value;
			break;
		}
	}
	if(value != undefined || value != null)
	{
		jQuery("#step1").css("display","none");
		jQuery("#step2").css("display","block");
		jQuery("#step3").css("display","none");
		jQuery("#step4").css("display","none");
		jQuery("#step5").css("display","none");
		path= uri+"/front_bookinglink.php";
		jQuery.ajax({
					type: "POST",
					data: "serviceId="+value+"&action=GetEmployees",
					url: path,
					success: function(data)
					{					
						jQuery("#diveser1").html(data);
					}
				});
	}
	else
	{
		alert('Please select atleast 1 Service');
	}
}
/* Code for Button 1 Ends here */
/*********************************************************************************/

/* Code for Button 2 Starts here */	
	
function nextButton2()
{
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
	if(value != undefined || value != null)
	{
		jQuery("#step1").css("display","none");
		jQuery("#step2").css("display","none");
		jQuery("#step3").css("display","block");
		jQuery("#step4").css("display","none");
		jQuery("#step5").css("display","none");
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
		var val = document.getElementById('seridd').value;	
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
						data: "cservice="+val+"&empId="+value+"&cmonth="+month+"&cyear="+year+"&cday="+today+"&years=true",
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

/* Code for Button 2 Ends here */
/*********************************************************************************/

/* Code for Button 3 Starts here */	
function nextButton3()
{
	if(document.getElementById('hitime'))
	{
		if(document.getElementById('hitime').value != "")
		{
			var tottime = document.getElementById('hitime').value;
			var service_id = document.getElementById('seridd').value;
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
			filepath443 = uri + "/servicehours.php";
			jQuery.ajax
			({
				type : "POST",
				data : "booktime="+tottime+"&serv="+service_id+"&emp="+emp+"&cmonth=" + month + "&cyear=" + year + "&cday=" + day,
				url : filepath443,
				success : function(data) 
				{
					var test = jQuery.trim(data);
					if(test == '1')
					{
						jQuery("#step1").css("display","none");
						jQuery("#step2").css("display","none");
						jQuery("#step3").css("display","none");
						jQuery("#step4").css("display","block");
						jQuery("#step5").css("display","none");
						if(document.getElementById('hidden_firstname'))
						{
							var hdfname = document.getElementById('hidden_firstname').value;
							
							if(hdfname != "")
							{
								jQuery('#firstname').val(hdfname);
							}
						}
						if(document.getElementById('hidden_lastname'))
						{
							var hdlname = document.getElementById('hidden_lastname').value;
							
							if(hdlname != "")
							{
								jQuery('#lastname').val(hdlname);
							}
						}
						if(document.getElementById('hidden_email'))
						{
							var hdemail = document.getElementById('hidden_email').value;
							
							if(hdemail != "")
							{
								jQuery('#emaill').val(hdemail);
							}
						}
						if(document.getElementById('hidden_email'))
						{
						var hdexemail = document.getElementById('hidden_email').value;
							if(hdexemail != "")
							{
								jQuery('#emailcustomer').val(hdexemail);
							}
						}
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
						
						var booked_time= document.getElementById('hitime').value;
						var hrs=booked_time.split(":");
						var cokval=value+"-"+val+"-"+day+"-"+month+"-"+year+"-"+hrs[0]+"-"+hrs[1]+"-"+empnm+"-"+sernam;
						cookievalue= escape(cokval) + ";";
						cookie="eg="+cookievalue;
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
/* Code for Button 3 Ends here */
/*********************************************************************************/

/* Code for reqfnameblur */	
function reqfnameblur()
{
	if(document.getElementById('reqfirstname')) 
	{
		if(jQuery("#reqfirstname").val()==1)
		{
			
			if(jQuery('#firstname').val()=="")
			{
				jQuery("#firstname").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#firstname").hasClass('in_error'))
				{
					jQuery("#firstname").removeClass("in_error");
				}
				jQuery("#firstname").addClass("in_submitted");
				return true;
			}
		}
		
	}
	
}
/* Code for reqfnameblur Ends here */
/*********************************************************************************/

/* Code for reqlnameblur */	
function reqlnameblur()
{
	
	if(document.getElementById('reqlastname')) 
	{
	
		if(jQuery("#reqlastname").val()==1)
		{
			
			if(jQuery('#lastname').val()=="")
			{
				jQuery("#lastname").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#lastname").hasClass('in_error'))
				{
					jQuery("#lastname").removeClass("in_error");
				}
				jQuery("#lastname").addClass("in_submitted");
				return true;
			}
		}
		else
		{
		
			return true;
		}
		
	}
	else
	{
		return true;
	}
}
/* Code for reqlnameblur Ends here */
/*********************************************************************************/

/* Code for reqemailblur */	

function reqemailblur()
{

		
	if(document.getElementById('reqemaill')) 
	{
		if(jQuery("#reqemaill").val()==1)
		{
			
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			var address = jQuery("#emaill").val();
			if(reg.test(address) == false)
			{
				jQuery("#emaill").addClass("in_error");
				return false;
			}
			else
			{
			jQuery.ajax
					({
							type: "POST",
							data: "email="+address+"&action=checkemaill",
							url:  uri+"/online_booking.php",
							success: function(data) 
							{
								if(data=="newcustomer")
								{
									jQuery("#customerexist").attr('style','display:none');
									if(jQuery("#emaill").hasClass('in_error'))
									{
										jQuery("#emaill").removeClass("in_error");
									}
									jQuery("#emaill").addClass("in_submitted");
								
								}
								else
								{
									jQuery("#emaill").addClass("in_error");
									jQuery("#customerexist").attr('style','display:block;margin-top:10px;font-size:11px;color:Red');
									
								}
							}
						});
						
						if(jQuery("#emaill").hasClass('in_error'))
						{
							return false;
						}
						else
						{
							return true;
						}
								
			}
		}
	}
}
/* Code for reqemailblur Ends here */
/*********************************************************************************/

/* Code for reqmobileblur */	
function reqmobileblur()
{
	if(document.getElementById('reqmobile')) 
	{
		if(jQuery("#reqmobile").val()==1)
		{
			
			if(jQuery("#mobile").val()=="")
			{
				jQuery("#mobile").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#mobile").hasClass('in_error'))
				{
					jQuery("#mobile").removeClass("in_error");
				}
				jQuery("#mobile").addClass("in_submitted");
				return true;
			}
		}
		else
		{
		
			return true;
		}
		
	}
	else
	{
		return true;
	}
}
/* Code for reqmobileblur Ends here */
/*********************************************************************************/

/* Code for reqphoneblur */
function reqphoneblur()
{
	if(document.getElementById('reqphone')) 
	{
	
		if(jQuery("#reqphone").val()==1)
		{
			
			if(jQuery("#phone").val()=="")
			{
				jQuery("#phone").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#phone").hasClass('in_error'))
				{
					jQuery("#phone").removeClass("in_error");
				}
				jQuery("#phone").addClass("in_submitted");
				return true;
			}
		}
		else
		{
		
			return true;
		}
	}
	else
	{
	
		return true;
	}
}
/* Code for reqphoneblur Ends here */
/*********************************************************************************/

/* Code for reqad1blur */
function reqad1blur()
{
	if(document.getElementById('reqad1')) 
	{
		if(jQuery("#reqad1").val()==1)
		{
			
			if(jQuery("#ad1").val()=="")
			{
				jQuery("#ad1").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#ad1").hasClass('in_error'))
				{
					jQuery("#ad1").removeClass("in_error");
				}
				jQuery("#ad1").addClass("in_submitted");
				return true;
			}
		}
		else
		{
		
			return true;
		}
	}
	else
	{
		return true;
	}
}
/* Code for reqad1blur Ends here */
/*********************************************************************************/

/* Code for reqad2blur */
function reqad2blur()
{
	if(document.getElementById('reqad2')) 
	{
		if(jQuery("#reqad2").val()==1)
		{
			
			if(jQuery("#ad2").val()=="")
			{
				jQuery("#ad2").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#ad2").hasClass('in_error'))
				{
					jQuery("#ad2").removeClass("in_error");
				}
				jQuery("#ad2").addClass("in_submitted");
				return true;
			}
		}
		else
		{
		
			return true;
		}
	}
	else
	{
		return true;
	}
}
/* Code for reqad2blur Ends here */
/*********************************************************************************/

/* Code for reqcityblur */
function reqcityblur()
{
	if(document.getElementById('reqcity')) 
	{
		if(jQuery("#reqcity").val()==1)
		{
			
			if(jQuery("#city").val()=="")
			{
				jQuery("#city").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#city").hasClass('in_error'))
				{
					jQuery("#city").removeClass("in_error");
				}
				jQuery("#city").addClass("in_submitted");
				return true;
			}
		}
		else
		{
		
			return true;
		}
	}
	else
	{
		return true;
	}
}
/* Code for reqcityblur Ends here */
/*********************************************************************************/

/* Code for reqpcblur */
function reqpcblur()
{
	if(document.getElementById('reqpc')) 
	{
		if(jQuery("#reqpc").val()==1)
		{
			
			if(jQuery("#pc").val()=="")
			{
				jQuery("#pc").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#pc").hasClass('in_error'))
				{
					jQuery("#pc").removeClass("in_error");
				}
				jQuery("#pc").addClass("in_submitted");
				return true;
			}
		}
		else
		{
		
			return true;
		}
	}
	else
	{
		return true;
	}
}
/* Code for reqpcblur Ends here */
/*********************************************************************************/

/* Code for reqemailcustomerblur */															
function reqemailcustomerblur()
{
	if(document.getElementById('reqemaillcustomer')) 
	{
		if(jQuery("#reqemaillcustomer").val()==1)
		{
			
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			var address = jQuery("#emailcustomer").val();
			if(reg.test(address) == false)
			{
				jQuery("#emailcustomer").addClass("in_error");
				return false;
			}
			else
			{
				
				jQuery.ajax
					({
							type: "POST",
							data: "email="+address+"&action=checkemaill",
							url:  uri+"/front_bookinglink.php",
							success: function(data) 
							{
								if(data=="newcustomer")
								{
									//alert('You are not an exsisting Customer');
								jQuery("#alertc").attr('style','display:block;margin-top:10px;font-size:11px;color:Red');
											
									jQuery("#emailcustomer").addClass("in_error");
									
									jQuery("#ex_lnam").attr("style","background:none;padding-top:0px;border:none;display:none;");
									jQuery("#ex_mob").attr("style","background:none;padding-top:0px;border:none;display:none;");
									jQuery("#ex_phon").attr("style","background:none;padding-top:0px;border:none;display:none;");
									jQuery("#ex_ad1").attr("style","background:none;padding-top:0px;border:none;display:none;");
									jQuery("#ex_ad2").attr("style","background:none;padding-top:0px;border:none;display:none;");
									jQuery("#ex_ct").attr("style","background:none;padding-top:0px;border:none;display:none;");
									jQuery("#ex_zp").attr("style","background:none;padding-top:0px;border:none;display:none;");
									jQuery("#ext_cntry").attr("style","background:none;padding-top:0px;border:none;display:none;");
									//jQuery('#-radiocust1').attr('checked', 'checked');
									//jQuery("#-radiocust1").is(":checked");
									return false;
								}
								else
								{
								jQuery("#alertc").attr('style','display:none;');
								jQuery("#emailcustomer").attr("disabled","disabled");
								var dat=data.split("&");
								if(dat[0].split("=")[1] == "yes")
								{
									jQuery("#ex_lnam").attr("style","background:none;padding-top:0px;border:none;");
								}
								else
								{
									jQuery("#ex_lnam").attr("style","background:none;padding-top:0px;border:none;display:none;");
								}
								if(dat[1].split("=")[1] == "yes")
								{
									jQuery("#ex_mob").attr("style","background:none;padding-top:0px;border:none;");
								}
								else
								{
									jQuery("#ex_mob").attr("style","background:none;padding-top:0px;border:none;display:none;");
								}
								if(dat[2].split("=")[1] == "yes")
								{
									jQuery("#ex_phon").attr("style","background:none;padding-top:0px;border:none;");
								}
								else
								{
									jQuery("#ex_phon").attr("style","background:none;padding-top:0px;border:none;display:none;");
								}
								if(dat[3].split("=")[1] == "yes")
								{
									jQuery("#ex_ad1").attr("style","background:none;padding-top:0px;border:none;");
								}
								else
								{
									jQuery("#ex_ad1").attr("style","background:none;padding-top:0px;border:none;display:none;");
								}
								if(dat[4].split("=")[1] == "yes")
								{
									jQuery("#ex_ad2").attr("style","background:none;padding-top:0px;border:none;");
								}
								else
								{
									jQuery("#ex_ad2").attr("style","background:none;padding-top:0px;border:none;display:none;");
								}
								if(dat[5].split("=")[1] == "yes")
								{
									jQuery("#ex_ct").attr("style","background:none;padding-top:0px;border:none;");
								}
								else
								{
									jQuery("#ex_ct").attr("style","background:none;padding-top:0px;border:none;display:none;");
								}
								if(dat[6].split("=")[1] == "yes")
								{
									jQuery("#ex_zp").attr("style","background:none;padding-top:0px;border:none;");
								}
								else
								{
									jQuery("#ex_zp").attr("style","background:none;padding-top:0px;border:none;display:none;");
								}
								if(dat[7].split("=")[1] == "yes")
								{
									jQuery("#ext_cntry").attr("style","background:none;padding-top:0px;border:none;");
								}
								else
								{
									jQuery("#ext_cntry").attr("style","background:none;padding-top:0px;border:none;display:none;");
								}
								}
							}
					});
					if(jQuery("#emailcustomer").hasClass('in_error'))
					{
						jQuery("#emailcustomer").removeClass("in_error");
					}
					jQuery("#emailcustomer").addClass("in_submitted");
					return true;
			}
		}
	}
}
/*********************************************************************************/
/* Code for reqemailblur Ends here */
/*********************************************************************************/
/* Code for EXreqlastblur */	
function ex_reqlnameblur()
{
	if(document.getElementById('ex_reqlastname')) 
	{
		if(jQuery("#ex_reqlastname").val()==1)
		{
			
			if(jQuery("#ex_lastname").val()=="")
			{
				jQuery("#ex_lastname").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#ex_lastname").hasClass('in_error'))
				{
					jQuery("#ex_lastname").removeClass("in_error");
				}
				jQuery("#ex_lastname").addClass("in_submitted");
				return true;
			}
		}
		else
		{
			return true;
		}
		
	}
	else
	{
		return true;
	}
}
/* Code for ex_reqlnameblur Ends here */
/*********************************************************************************/
/* Code for reqmobileblur */	
function ex_reqmobileblur()
{
	if(document.getElementById('ex_reqmobile')) 
	{
		if(jQuery("#ex_reqmobile").val()==1)
		{
			
			if(jQuery("#ex_mobile").val()=="")
			{
				jQuery("#ex_mobile").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#ex_mobile").hasClass('in_error'))
				{
					jQuery("#ex_mobile").removeClass("in_error");
				}
				jQuery("#ex_mobile").addClass("in_submitted");
				return true;
			}
		}
		else
		{
			return true;
		}
		
	}
	else
	{
		return true;
	}
}
/* Code for reqmobileblur Ends here */
/*********************************************************************************/

/* Code for reqphoneblur */
function ex_reqphoneblur()
{
	if(document.getElementById('ex_reqphone')) 
	{
		if(jQuery("#ex_reqphone").val()==1)
		{
			
			if(jQuery("#ex_phone").val()=="")
			{
				jQuery("#ex_phone").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#ex_phone").hasClass('in_error'))
				{
					jQuery("#ex_phone").removeClass("in_error");
				}
				jQuery("#ex_phone").addClass("in_submitted");
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	else
	{
		return true;
	}
}
/* Code for reqphoneblur Ends here */
/*********************************************************************************/

/* Code for reqad1blur */
function ex_reqad1blur()
{

	if(document.getElementById('ex_reqad1')) 
	{
		if(jQuery("#ex_reqad1").val()==1)
		{
			
			if(jQuery("#ex_ad11").val()=="")
			{
				
				jQuery("#ex_ad11").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#ex_ad11").hasClass('in_error'))
				{
					jQuery("#ex_ad11").removeClass("in_error");
				}
				jQuery("#ex_ad11").addClass("in_submitted");
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	else
	{
		return true;
	}
}
/* Code for reqad1blur Ends here */
/*********************************************************************************/

/* Code for reqad2blur */
function ex_reqad2blur()
{
	if(document.getElementById('ex_reqad2')) 
	{
		if(jQuery("#ex_reqad2").val()==1)
		{
			
			if(jQuery("#ex_ad21").val()=="")
			{
				jQuery("#ex_ad21").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#ex_ad21").hasClass('in_error'))
				{
					jQuery("#ex_ad21").removeClass("in_error");
				}
				jQuery("#ex_ad21").addClass("in_submitted");
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	else
	{
		return true;
	}
}
/* Code for reqad2blur Ends here */
/*********************************************************************************/

/* Code for reqcityblur */
function ex_reqcityblur()
{
	if(document.getElementById('ex_reqcity')) 
	{
		if(jQuery("#ex_reqcity").val()==1)
		{
			
			if(jQuery("#ex_city").val()=="")
			{
				jQuery("#ex_city").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#ex_city").hasClass('in_error'))
				{
					jQuery("#ex_city").removeClass("in_error");
				}
				jQuery("#ex_city").addClass("in_submitted");
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	else
	{
		return true;
	}
}
/* Code for reqcityblur Ends here */
/*********************************************************************************/

/* Code for reqpcblur */
function ex_reqpcblur()
{
	if(document.getElementById('ex_reqpc')) 
	{
		if(jQuery("#ex_reqpc").val()==1)
		{
			
			if(jQuery("#ex_pc").val()=="")
			{
				jQuery("#ex_pc").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#ex_pc").hasClass('in_error'))
				{
					jQuery("#ex_pc").removeClass("in_error");
				}
				jQuery("#ex_pc").addClass("in_submitted");
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	else
	{
		return true;
	}
}
/* Code for reqpcblur Ends here */
/*********************************************************************************/
/* Code for nextButton4 */	
function nextButton4()						
{
	var radcust = document.getElementsByName('radiocustomer');
	var value;
	for (var i = 0; i < radcust.length; i++) 
	{
		if (radcust[i].type == 'radio' && radcust[i].checked) 
		{
			value = radcust[i].value;
			break;		
		}
	}
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
	if(value==1)
	{
		if(reqemailblur() && reqlnameblur() && reqfnameblur() && reqmobileblur() && reqphoneblur() && reqad1blur() && reqad2blur() && reqcityblur() && reqpcblur()) // conditions here
		{	
		jQuery.ajax
			({
					type: "POST",
					data: "email="+address+"&action=checkemaill",
					url:  uri+"/online_booking.php",
					success: function(data) 
					{
						if(data=="newcustomer")
						{
							jQuery("#customerexist").attr('style','display:none');
								
							if(document.getElementById('firstname'))
							{
								jQuery("#lbl_0").html(jQuery("#firstname").val());
							}
							if(document.getElementById('lastname'))
							{
								jQuery("#lbl_1").html(jQuery("#lastname").val());
							}
							if(document.getElementById('emaill'))
							{
								jQuery("#lbl_2").html(jQuery("#emaill").val());
							}
							if(document.getElementById('mobile'))
							{
								jQuery("#lbl_3").html(jQuery("#mobile").val());
							}
							if(document.getElementById('ad1'))
							{
								jQuery("#lbl_4").html(jQuery("#ad1").val());
							}
							if(document.getElementById('ad2'))
							{
								jQuery("#lbl_5").html(jQuery("#ad2").val());
							}
							if(document.getElementById('city'))
							{
								jQuery("#lbl_6").html(jQuery("#city").val());
							}
							if(document.getElementById('pc'))
							{
								jQuery("#lbl_7").html(jQuery("#pc").val());
							}
							if(document.getElementById('country'))
							{
								jQuery("#lbl_8").html(jQuery("#country").val());
							}
							if(document.getElementById('phone'))
							{
								jQuery("#lbl_9").html(jQuery("#phone").val());
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
							jQuery("#step1").css("display","none");
							jQuery("#step2").css("display","none");
							jQuery("#step3").css("display","none");
							jQuery("#step4").css("display","none");
							jQuery("#step5").css("display","block");
						}
						else
						{
				
							jQuery("#customerexist").attr('style','display:block;margin-top:10px;font-size:11px;color:Red');
							jQuery("#emaill").addClass("in_error");
							
						}
			
			}
			});
			}
							
		
	}
	else
	{
				
			if(document.getElementById('reqemaillcustomer')) 
			{
				if(jQuery("#reqemaillcustomer").val()==1)
				{
					var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
						var address = jQuery("#emailcustomer").val();
						if(reg.test(address) == false)
						{
							jQuery("#emailcustomer").addClass("in_error");
							jQuery("#alertc").attr('style','display:block;margin-top:10px;font-size:11px;color:Red');
							return false;
						}
						else
						{
							jQuery.ajax
							({
								type: "POST",
								data: "email="+address+"&action=checkemaill",
								url:  uri+"/back-front.php",
								success: function(data) 
								{
									if(data=="newcustomer")
									{
										jQuery("#emailcustomer").addClass("in_error");
										return false;
									}
									else
									{
										
										jQuery("#emailcustomer").attr("disabled","disabled");
										jQuery("#alertc").attr('style','display:none;');
									
										var flag;
										var flag1;
										var flag2;
										var flag3;
										var flag4;
										var flag5;
										var flag6;
										
											
										if(document.getElementById('ex_lnam'))
										{
											
											if(jQuery('#ex_lnam').css('display')=="inline-block")
											{
												 flag =  ex_reqlnameblur();
												jQuery("#exlbl_1").html(jQuery("#ex_lastname").val());
											}
											else
											{
												jQuery("#ex_dlnm").attr("style","display:none;");
												flag = true;
											}
											
										}
										else
										{
											flag = true;
										}
										
										if(document.getElementById('ex_mob'))
										{
											if(jQuery('#ex_mob').css('display')=="inline-block")
											{
												 flag1 =  ex_reqmobileblur();
												jQuery("#exlbl_3").html(jQuery("#ex_mobile").val());
											}
											else
											{
												jQuery("#ex_dmob").attr("style","display:none;");
												flag1 = true;
											}
											
										}
										else
										{
											flag1 = true;
										}
										
										if(document.getElementById('ex_phon'))
										{
											if(jQuery('#ex_phon').css('display')=="inline-block")
											{
												 flag2 = 	ex_reqphoneblur();
												jQuery("#exlbl_9").html(jQuery("#ex_phone").val());
											}
											else
											{
												jQuery("#ex_dphon").attr("style","display:none;");
												flag2 = true;
											}
										}
										else
										{
											flag2 = true;
										}
										if(document.getElementById('ex_ad1'))
										{
											if(jQuery('#ex_ad1').css('display')=="inline-block")
											{
												 flag3 =  ex_reqad1blur();
												jQuery("#exlbl_4").html(jQuery("#ex_ad11").val());
											}
											else
											{
												jQuery("#ex_dad1").attr("style","display:none;");
												flag3 = true;
											}
										}
										else
										{
											flag3 = true;
										}
										if(document.getElementById('ex_ad2'))
										{
											if(jQuery('#ex_ad2').css('display')=="inline-block")
											{
												 flag4 =  ex_reqad2blur();
												jQuery("#exlbl_5").html(jQuery("#ex_ad21").val());
												
											}
											else
											{
												jQuery("#ex_dad2").attr("style","display:none;");
												flag4 = true;
											}
										}
										else
										{
											flag4 = true;
										}
										if(document.getElementById('ex_ct'))
										{
											if(jQuery('#ex_ct').css('display')=="inline-block")
											{
												 flag5 = ex_reqcityblur();
												jQuery("#exlbl_6").html(jQuery("#ex_city").val());
											}
											else
											{
												jQuery("#ex_dct").attr("style","display:none;");
												flag5 = true;
											}
										}
										else
										{
											flag5 = true;
										}
										if(document.getElementById('ex_zp'))
										{
											if(jQuery('#ex_zp').css('display')=="inline-block")
											{
												 flag6 = ex_reqpcblur();
												jQuery("#exlbl_7").html(jQuery("#ex_pc").val());
											}
											else
											{
												jQuery("#ex_dzp").attr("style","display:none;");
												flag6 = true;
											}
										}
										else
										{
											flag6 = true;
										}
										if(document.getElementById('ex_country'))
										{
											if(jQuery('#ex_country').css('display')=="inline-block")
											{
												jQuery("#exlbl_8").html(jQuery("#ex_country").val());
											}
											else
											{
												jQuery("#ex_dcountry").attr("style","display:none;");
											}
										}
									}
									
							
							
							if(flag == true && flag1 == true && flag2 == true && flag3 == true && flag4 == true && flag5 == true && flag6 == true)
							{
									jQuery.ajax
									({
									type: "POST",
									data: "email="+address+"&action=dataemaill",
									url:  uri+"/back-front.php",
									success: function(data) 
									{
										if(jQuery("#emailcustomer").hasClass('in_error'))
										{
											jQuery("#emailcustomer").removeClass("in_error");
										}
										jQuery("#emailcustomer").addClass("in_submitted");
										
										var s = fcook[7];
										var lbdispemp=unescape(s);
									
										var serv = fcook[8];
									
										var lbdispser= unescape(serv);
										document.getElementById('exlbl_ser').innerHTML=lbdispser;
										document.getElementById('exlbl_emp').innerHTML=lbdispemp;
										var bokdt=year+"-"+month+"-"+day;
										document.getElementById('exlbl_bdat').innerHTML=bokdt;
										document.getElementById('exlbl_btime').innerHTML=booked_time;
									
										if(document.getElementById('emailcustomer'))
										{
											jQuery("#exlbl_2").html(jQuery("#emailcustomer").val());
										}
										
									
										
											jQuery("#step1").css("display","none");
											jQuery("#step2").css("display","none");
											jQuery("#step3").css("display","none");
											jQuery("#step4").css("display","none");
											jQuery("#step5A").css("display","block");
									}
									});
							}
							}
						});
					}
				}
		}	
	}
}
	
		
		function bookItNow()
		{
			var radcust1 = document.getElementsByName('radiocustomer');
			var value1;
			for (var i = 0; i < radcust1.length; i++) 
			{
				if (radcust1[i].type == 'radio' && radcust1[i].checked) 
				{
					value1 = radcust1[i].value;
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
		if(value1==1)
		{
			
			var booked_time= hrsv+":"+mnsv;
			
				filepath3=uri+"/booking.php";
				jQuery.ajax({
							type: "POST",
							data: "bmonth="+month+"&byear="+year+"&bday="+day+"&empnam="+emp+"&phone="+jQuery("#phone").val()+"&bname="+jQuery("#firstname").val()+"&bemail="+jQuery("#emaill").val()+"&bmobile="+jQuery("#mobile").val()+"&btime="+booked_time+"&bservice="+service+"&bad1="+jQuery("#ad1").val()+"&bad2="+jQuery("#ad2").val()+"&bcity="+jQuery("#city").val()+"&bpc="+jQuery("#pc").val()+"&bcountry="+jQuery("#country").val()+"&lname="+jQuery("#lastname").val(),
							url: filepath3,
							success: function(data) 
							{
								
									jQuery("#step1").css("display","none");
									jQuery("#step2").css("display","none");
									jQuery("#step3").css("display","none");
									jQuery("#step4").css("display","none");
									jQuery("#step5").css("display","none");
									jQuery("#step6").css("display","block");
									
														
							}
						});
	
		}
		else
		{
			var booked_time1= hrsv+":"+mnsv;
			var data="";
		
			if(document.getElementById('ex_cust'))
			{
			
				if(jQuery('#ex_cust').css('display')=="inline-block")
				{
					data += "day="+day+"&service="+service+"&emp="+emp+"&month="+month+"&btime="+booked_time1+"&year="+year+"&email=" + jQuery("#emailcustomer").val();
					
				}
			}
			if(document.getElementById('ex_lnam'))
			{
			
				if(jQuery('#ex_lnam').css('display')=="inline-block")
				{
					data +=  "&lname="+jQuery("#ex_lastname").val();
					
				}
			}
			
			if(document.getElementById('ex_mob'))
			{
				if(jQuery('#ex_mob').css('display')=="inline-block")
				{
					data +=  "&mobileNum="+jQuery("#ex_mobile").val();
					
				}
			}
			
			if(document.getElementById('ex_phon'))
			{
				if(jQuery('#ex_phon').css('display')=="inline-block")
				{
					data += "&phone="+jQuery("#ex_phone").val();
					
				}
			}
			
			if(document.getElementById('ex_ad1'))
			{
				if(jQuery('#ex_ad1').css('display')=="inline-block")
				{
					data += "&adress1="+jQuery("#ex_ad11").val();
					
				}
			}
			
			if(document.getElementById('ex_ad2'))
			{
				if(jQuery('#ex_ad2').css('display')=="inline-block")
				{
					data += "&address2="+jQuery("#ex_ad21").val();
					
				}
			}
			
			if(document.getElementById('ex_ct'))
			{
				if(jQuery('#ex_ct').css('display')=="inline-block")
				{
					data += "&city="+jQuery("#ex_city").val();
					
				}
			}
			
			if(document.getElementById('ex_zp'))
			{
				if(jQuery('#ex_zp').css('display')=="inline-block")
				{
					data += "&zip="+jQuery("#ex_pc").val();
					
				}
			}
			if(document.getElementById('ext_cntry'))
			{
				if(jQuery('#ext_cntry').css('display')=="inline-block")
				{
					data += "&country="+jQuery("#ex_country").val();
				}
			}
			
			
			
			
				filepathbooking=uri+"/booking_updation.php";
				jQuery.ajax({
							type: "POST",
							data: data,
							url: filepathbooking,
							success: function(data) 
							{
								
									jQuery("#step1").css("display","none");
									jQuery("#step2").css("display","none");
									jQuery("#step3").css("display","none");
									jQuery("#step4").css("display","none");
									jQuery("#step5A").css("display","none");
									jQuery("#step6").css("display","block");
									
							}
					});
		}
	}
		function backButton2()
		{
			jQuery("#step1").css("display","block");
			jQuery("#step2").css("display","none");
			jQuery("#step3").css("display","none");
			jQuery("#step4").css("display","none");
			jQuery("#step5").css("display","none");
		}
		function backButton3()
		{
			jQuery("#step1").css("display","none");
			jQuery("#step2").css("display","block");
			jQuery("#step3").css("display","none");
			jQuery("#step4").css("display","none");
			jQuery("#step5").css("display","none");
			
		}
		function backButton4()
		{
			jQuery("#step1").css("display","none");
			jQuery("#step2").css("display","none");
			jQuery("#step3").css("display","block");
			jQuery("#step4").css("display","none");
			jQuery("#step5").css("display","none");
			
		}
		function backButton5()
		{
			jQuery("#step1").css("display","none");
			jQuery("#step2").css("display","none");
			jQuery("#step3").css("display","none");
			jQuery("#step4").css("display","block");
			jQuery("#step5").css("display","none");
			jQuery("#step5A").css("display","none");
			
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
	function newcustomer()
	{
		jQuery('#newcustomer').css('display','block');
		jQuery('#Excistingcustomer').css('display','none');
	}
	function excustomer()
	{
		jQuery('#newcustomer').css('display','none');
		jQuery('#Excistingcustomer').css('display','block');
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
												"SELECT * FROM ".$wpdb->prefix."sm_translation "
										)
								);
								for($i=0;$i<=count($trans);$i++)
								{
									 
								}	
								?>
				<div class="contentarea1">
					<div class="one_wrap fl_left" id="step1" style="display:block">
						
						<div class="menus">
							<div id="droplinetabs1" class="droplinetabs1">
								
								<ul class="crBreadcrumbs">
									<li>
										<a href="#" rel="1"  class="crBreadcrumbs focus"><span>1</span><?php echo $trans[0]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="2"  class="crBreadcrumbs"><span>2</span><?php echo $trans[1]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="3"  class="crBreadcrumbs"><span>3</span><?php echo $trans[2]->translate; ?></a>
									</li>
									<li>
										<a href="#" rel="4"  class="crBreadcrumbs"><span>4</span><?php echo $trans[3]->translate; ?></a>
									</li>
									<li class="crBreadcrumbs1">
										<a href="#" rel="5" class="crBreadcrumbs"  ><span>5</span><?php echo $trans[4]->translate; ?></a>
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
												<th width="60%" style="text-align:left;padding-left:15px;"> <?php echo $trans[6]->translate; ?> </th>
												<th width="20%" style="text-align:left;padding-left:15px;"> <?php echo $trans[7]->translate; ?></th>
												<th width="20%" style="text-align:left;padding-left:15px;"> <?php echo $trans[8]->translate; ?> </th>
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
									<a href="#" onclick="nextButton1();" class="greyishBtn button_small" shape="margin-right:0px;"><?php echo $trans[9]->translate; ?></a>
								</div>
							</li>
						</ul>
					</div>
					
					
					<div class="one_wrap fl_left" id="step2" style="display:none">
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
										<a href="#" rel="4" class="crBreadcrumbs"><span>4</span><?php echo $trans[3]->translate; ?></a>
									</li>
										<li class="crBreadcrumbs1">
										<a href="#" rel="5" ><span>5</span><?php echo $trans[4]->translate; ?></a>
									</li>
								</ul>
							</div>
							
						</div>
									<div class="widget-wp-obs" style="margin-top:5px;margin-bottom:0px;">
							<div class="widget-wp-obs_title">
								<span class="iconsweet">f</span>
								<h5> <?php echo $trans[5]->translate; ?></h5>
							</div>
							<div  class="widget-wp-obs_body"  id="diveser1">
							
							</div>
						</div>
						<ul class="form_fields_container">
							<li style="background:none">
								<div style="text-align:right;margin-right:0px">
									<a href="#" onclick="backButton2();" class="greyishBtn button_small"  style="float:left"><?php echo $trans[11]->translate; ?></a>
									<a href="#" onclick="nextButton2();" class="greyishBtn button_small" shape="margin-right:0px;"><?php echo $trans[9]->translate; ?></a>
								</div>
							</li>
						</ul>
					</div>
					<div class="one_wrap fl_left" id="step3" style="display:none">
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
										<a href="#" rel="4" class="crBreadcrumbs"><span>4</span><?php echo $trans[3]->translate; ?></a>
									</li>
										<li class="crBreadcrumbs1">
										<a href="#" rel="5" ><span>5</span><?php echo $trans[4]->translate; ?></a>
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
											<th width="10%" style="text-align:left;padding-left:15px;"> <?php echo $trans[12]->translate; ?> </th>
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
									<a href="#" onclick="backButton3();"  class="greyishBtn button_small" style="float:left"><?php echo $trans[11]->translate; ?></a>
									<a href="#"  onclick="return nextButton3();" class="greyishBtn button_small" shape="margin-right:0px;"><?php echo $trans[9]->translate; ?></a>
								</div>
							</li>
						</ul>
					</div>
					<div class="one_wrap fl_left" id="step4" style="display:none">
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
										<a href="#" rel="4" class="crBreadcrumbs focus"><span>4</span><?php echo $trans[3]->translate; ?></a>
									</li>
										<li class="crBreadcrumbs1">
										<a href="#" rel="5" ><span>5</span><?php echo $trans[4]->translate; ?></a>
									</li>
								</ul>
							</div>
						</div>
						
						<div class="widget-wp-obs"  style="margin-top:5px;margin-bottom:0px">
						<?php require ('facebook.php'); ?>
							<div class="widget-wp-obs_title">
								<span class="iconsweet">f</span>
								<h5> <?php echo $trans[5]->translate; ?></h5>
							</div>
							
						<ul class="form_fields_container">
								<?php $stt = $wpdb->get_var('SELECT fbradio FROM ' . $wpdb->prefix . sm_settings);
											if($stt==1)
											{
												$api = $wpdb->get_row
												(
														$wpdb->prepare
														(
																"SELECT fb_api,fb_secret FROM ".$wpdb->prefix."sm_settings",
																$bookings[$i]->service_id 
														)
												);
												$facebook = new Facebook(array(
														'appId'  => $api->fb_api,
														'secret' => $api->fb_secret,
													));
													$user = $facebook->getUser();
												if ($user) 
												{
													try 
													{
															$user_profile = $facebook->api('/me');
															?>
															<script>
																	
																	jQuery("#firstname").val("<?php echo $user_profile['first_name'] ?>");
																	jQuery("#lastname").val("<?php echo $user_profile['last_name'] ?>");
																	jQuery("#emaill").val("<?php echo $user_profile['email'] ?>");
																	jQuery("#emailcustomer").val("<?php echo $user_profile['email'] ?>");
																	jQuery("#hidden_firstname").val("<?php echo $user_profile['first_name'] ?>");
																	jQuery("#hidden_lastname").val("<?php echo $user_profile['last_name'] ?>");
																	jQuery("#hidden_email").val("<?php echo $user_profile['email'] ?>");
																	
															</script>
															<input type="hidden" id="hidden_firstname" value="<?php echo $user_profile['first_name'] ?>" />
															<input type="hidden" id="hidden_lastname" value="<?php echo $user_profile['last_name'] ?>" />
															<input type="hidden" id="hidden_email" value="<?php echo $user_profile['email'] ?>" />
															<?php
													}
													catch (FacebookApiException $e) 
													{
															$user = null;
													}
												}
												?>
							
								<li style="background:none;border:none">
										<div class="form_input">
											<div class="fb-login-button" data-scope="email,user_checkins">
												Login with Facebook
											</div>
											<div id="fb-root"></div>
											
											<script>
												window.fbAsyncInit = function() 
												{
												
													FB.init({
															appId: '<?php echo $facebook->getAppID() ?>',
															cookie: true,
															xfbml: true,
															oauth: true
															});
													FB.Event.subscribe('auth.login', function(response) 
													{
														FB.api('/me', function(user) 
														{
															if (user) 
															{
																	var fnam=user.first_name;
																	var lnam=user.last_name;
																	var eml=user.email;
																	
																	jQuery('#firstname').val(fnam);
																	jQuery('#lastname').val(lnam);
																	jQuery('#emaill').val(eml);
																	jQuery('#emailcustomer').val(eml);
															}
														});
													});
													
												};
											  (function() {
												var e = document.createElement('script'); e.async = true;
												e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
												document.getElementById('fb-root').appendChild(e);
											  }());
													
													
											</script>
										</div>
									</li>
								<?php } ?>
							
							
							<li style="background:none;border:none">
								<?php
									$translat = $wpdb->get_results
									(
											$wpdb->prepare
											(
													"SELECT * FROM ".$wpdb->prefix."sm_translation"
													
											)
									);
									?>
								<label><?php echo $translat[19]->translate; ?></label>
								<div class="form_input">
								<input id="radiocust1" name="radiocustomer" onclick="newcustomer();" checked='checked'  value="1"  type="radio"/>
								<label for="radiocust1"><?php echo $translat[20]->translate; ?></label>
								<br />
								<input id="radiocust2" name="radiocustomer" onclick="excustomer();" value="0" type="radio" />
								<label for="radiocust2"><?php echo $translat[21]->translate; ?></label>
								</div>
								</li>
							</ul>
							
							<div class="widget-wp-obs_body" id="newcustomer" style="display:block;">
								<ul class="form_fields_container">
									<?php
							
										$fields = $wpdb->get_results
										(
												$wpdb->prepare
												(
														"SELECT * FROM ".$wpdb->prefix."sm_booking_field where status = %d",
														1
												)
										);
										$countfields = count($fields);
						
										for($i=0;$i<$countfields;$i++)
										{
										$fiel = $fields[$i]->field_name;
										$fiel2 = $fields[$i]->field_name2;
										$stat = $fields[$i]->status;
										$req  = $fields[$i]->required ;
										if($fiel=="First Name :")
										{
										?>
										<li style="background:none;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
										<input onblur="return reqfnameblur();" id="firstname" name="firstname" type="text" value="" >
										<input type="hidden" id="reqfirstname" value="<?php echo $req; ?>" /> 
										</div>
									</li>
									<?php }

											else if($fiel=="Last Name :")
										{
									?>
									<li style="background:none;padding-top:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
										
											<input type="text" id="lastname" onblur="return reqlnameblur();">
											<input type="hidden" id="reqlastname" value="<?php echo $req; ?>" /> 
											
										</div>
									</li>
									<?php }
											else if($fiel=="Email :")
											{
											?>
											<li style="background:none;padding-top:0px;border:none">
											<label> <?php echo $fiel2;?></label>
											<div class="form_input">
											
											<input type="text" id="emaill" onblur="return reqemailblur();" value="" >
											<input type="hidden" id="reqemaill" value="<?php echo $req; ?>" /> 
											<span id="customerexist" style="display:none" >Opps...It appears that you are already an existing customer.  Please choose the "Existing Customer" option above to continue your booking process.</span>
										
										</div>
									</li>
									<?php }

										else if($fiel=="Mobile :")
										{
									?>
									<li style="background:none;padding-top:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input type="text" value="" onKeyPress="return validatePhone(event,this)" onblur="return reqmobileblur();" id="mobile" >
											<input type="hidden" id="reqmobile" value="<?php echo $req; ?>" /> 
										</div>
									</li>
									<?php }
										else if($fiel=="Phone :")
										{
									?>
									<li style="background:none;padding-top:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input type="text" value="" onKeyPress="return validatePhone(event,this)" onblur="return reqphoneblur();" id="phone" >
											<input type="hidden" id="reqphone" value="<?php echo $req; ?>" /> 
										</div>
									</li>
									<?php }

										else if($fiel=="Address Line1 :")
										{
									?>
									<li style="background:none;padding-top:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input  type="text" value="" onblur="return reqad1blur();" id="ad1">
											<input type="hidden" id="reqad1" value="<?php echo $req; ?>" /> 
										</div>
									</li>
									<?php }
										else if($fiel=="Address Line2 :")
										{
									?>
									<li style="background:none;padding-top:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input type="text" value="" onblur="return reqad2blur();" id="ad2" >
											<input type="hidden" id="reqad2" value="<?php echo $req; ?>" /> 
										</div>
									</li>
									<?php }
										else if($fiel=="City :")
										{
									?>
									<li style="background:none;padding-top:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input  type="text" id="city" onblur="return reqcityblur();" value="" >
											<input type="hidden" id="reqcity" value="<?php echo $req; ?>" />
										</div>
									</li>
									<?php }
										else if($fiel=="Zip/Post Code :")
										{
									?>
									<li style="background:none;padding-top:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<input type="text" value=""  onblur="return reqpcblur();" id="pc" >
											<input type="hidden" id="reqpc" value="<?php echo $req; ?>" />
										</div>
									</li>
									<?php }
										if($fiel=="Country :")
										{
									?>
									<li style="background:none;padding-top:0px;border:none">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
											<select id="country" style=" width:200px;">
												<?php
										$sel_country = $wpdb -> get_var('SELECT name  FROM ' . $wpdb -> prefix . sm_cuntry . ' where used = 1');
										$country = $wpdb->get_col
										(
												$wpdb->prepare
												(
														"SELECT name FROM ".$wpdb->prefix."sm_cuntry where deflt = %d order by name ASC",
														1
												)
										);
										$count = count($country);
										
										for ($k = 0; $k < $count; $k++)
										{
											if ($sel_country == $country[$k])
											{
											?>
											<option value="<?php echo $country[$k];?>" selected='selected'><?php echo $country[$k];?></option>
											<?php 
											}
											else
											{
												?>
												<option value="<?php echo $country[$k];?>"><?php echo $country[$k];?></option>
												<?php
											}
										}
										?>
											</select>
										</div>
									</li>
									<?php }
										}
									?>
									
								</ul>
							</div>
							<div class="widget-wp-obs_body" id="Excistingcustomer" style="display:none;">
								<ul class="form_fields_container">
									<?php
										$table_name = $wpdb->prefix . "sm_booking_field";
										$fields1 = $wpdb->get_results
										(
												$wpdb->prepare
												(
														"SELECT * FROM ".$wpdb->prefix."sm_booking_field where status = %d",
														"1"
												)
										);
										$countfields1 = count($fields1);
						
										for($i=0;$i<$countfields1;$i++)
										{
										$fiel1 = $fields1[$i]->field_name;
										$fiel21 = $fields1[$i]->field_name2;
										$stat1 = $fields1[$i]->status;
										$req1  = $fields1[$i]->required ;
										if($fiel1=="Email :")
										{
										?>
										<li id="ex_cust" style="background:none;padding-top:0px;border:none">
											<label> <?php echo $fiel21;?></label>
											<div class="form_input">
											
											<input type="text" id="emailcustomer" onblur="return reqemailcustomerblur();" value="" >
											<input type="hidden" id="reqemaillcustomer" value="<?php echo $req1; ?>" /> 
											<span id="alertc" style="display:none;" >We are sorry, our records shows that the email address you provided does not belong to an existing customer. Please choose the "New Customer" option above to continue.</span>
											</div>
										</li>
										<?php
										}
										else if($fiel1=="Last Name :")
										{
										?>
										<li id="ex_lnam" style="background:none;padding-top:0px;border:none;display:none;">
											<label> <?php echo $fiel21;?></label>
												<div class="form_input">
													<input type="text" id="ex_lastname" onblur="return ex_reqlnameblur();">
													<input type="hidden" id="ex_reqlastname" value="<?php echo $req1; ?>" /> 
												</div>
										</li>
										<?php 
										}
									else if($fiel1=="Mobile :")
									{
									?>
									<li id="ex_mob" style="background:none;padding-top:0px;border:none;display:none;">
										<label> <?php echo $fiel21;?></label>
										<div class="form_input">
											<input type="text" value="" onKeyPress="return validatePhone(event,this)" onblur="return ex_reqmobileblur();" id="ex_mobile" >
											<input type="hidden" id="ex_reqmobile" value="<?php echo $req1; ?>" /> 
										</div>
									</li>
							 <?php }
									else if($fiel1=="Phone :")
									{
									?>
									<li id="ex_phon" style="background:none;padding-top:0px;border:none;display:none;">
										<label> <?php echo $fiel21;?></label>
										<div class="form_input">
											<input type="text" value="" onKeyPress="return validatePhone(event,this)" onblur="return ex_reqphoneblur();" id="ex_phone" >
											<input type="hidden" id="ex_reqphone" value="<?php echo $req1; ?>" /> 
										</div>
									</li>
									<?php }

										else if($fiel1=="Address Line1 :")
										{
									?>
									<li id="ex_ad1" style="background:none;padding-top:0px;border:none;display:none;">
										<label> <?php echo $fiel21;?></label>
										<div class="form_input">
											<input  type="text" value="" onblur="return ex_reqad1blur();" id="ex_ad11">
											<input type="hidden" id="ex_reqad1" value="<?php echo $req1; ?>" /> 
										</div>
									</li>
									<?php }
										else if($fiel1=="Address Line2 :")
										{
									?>
									<li id="ex_ad2" style="background:none;padding-top:0px;border:none;display:none;">
										<label><?php echo $fiel21;?></label>
										<div class="form_input">
											<input type="text" value="" onblur="return ex_reqad2blur();" id="ex_ad21" >
											<input type="hidden" id="ex_reqad2" value="<?php echo $req1; ?>" /> 
										</div>
									</li>
									<?php }
										else if($fiel1=="City :")
										{
									?>
									<li id="ex_ct" style="background:none;padding-top:0px;border:none;display:none;">
										<label> <?php echo $fiel21;?></label>
										<div class="form_input">
											<input  type="text" id="ex_city" onblur="return ex_reqcityblur();" value="" >
											<input type="hidden" id="ex_reqcity" value="<?php echo $req1; ?>" />
										</div>
									</li>
									<?php }
										else if($fiel1=="Zip/Post Code :")
										{
									?>
									<li id="ex_zp" style="background:none;padding-top:0px;border:none;display:none;">
										<label> <?php echo $fiel21;?></label>
										<div class="form_input">
											<input type="text" value=""  onblur="return ex_reqpcblur();" id="ex_pc" >
											<input type="hidden" id="ex_reqpc" value="<?php echo $req1; ?>" />
										</div>
									</li>
									<?php }
									else if($fiel1=="Country :")
										{
									?>
									<li id="ext_cntry"style="background:none;padding-top:0px;border:none;display:none;">
										<label> <?php echo $fiel2;?></label>
										<div class="form_input">
										<select id="ex_country" style=" width:200px;">
										<?php
										$sel_country1 = $wpdb -> get_var('SELECT name  FROM ' . $wpdb -> prefix . sm_cuntry . ' where used = 1');
										$country1 = $wpdb->get_col
										(
												$wpdb->prepare
												(
														"SELECT name FROM ".$wpdb->prefix."sm_cuntry where deflt = %d order by name ASC",
														1
												)
										);
										$count1 = count($country1);
										
										for ($a = 0; $a < $count1; $a++)
										{
											if ($sel_country1 == $country1[$a])
											{
												?>
												<option value="<?php echo $country1[$a];?>" selected='selected'><?php echo $country1[$a];?></option>
												<?php 
											}
											else
											{
												?>
												<option value="<?php echo $country1[$a];?>"><?php echo $country1[$a];?></option>
												<?php
											}
										}
										?>
											<input type="hidden" id="ex_reqcntry1" value="<?php echo $req1; ?>" />
											</select>
										</div>
									</li>
									<?php }
									}
									?>
									</ul>
									</div>
						</div>
						<ul class="form_fields_container">
						<li style="background:none">
										<div style="text-align: right;margin-right:0px;">
											<a href="#" onclick="backButton4();" class="greyishBtn button_small" style="float:left"><?php echo $trans[11]->translate; ?></a>
											<a   class="greyishBtn button_small" onclick="return nextButton4();" id="nextbtn4"><?php echo $trans[9]->translate; ?></a>
										</div>
								</li></ul>
				</div>
					
					<div class="one_wrap fl_left" id="step5" style="display:none">
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
										<a href="#" rel="4" class="crBreadcrumbs"><span>4</span><?php echo $trans[3]->translate; ?></a>
									</li>
										<li class="crBreadcrumbs1">
										<a href="#" rel="5" class="focus"><span>5</span><?php echo $trans[4]->translate; ?></a>
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
									$table_name = $wpdb->prefix . "sm_booking_field";
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
							<li style="background:none;">
								<div style="text-align:right;margin-right:0px">
									<a href="#" onclick="backButton5();" class="greyishBtn button_small" style="float:left"><?php echo $trans[11]->translate; ?></a>
									<a onclick="return bookItNow();" class="greyishBtn button_small" shape="margin-right:0px;"><?php echo $trans[14]->translate; ?></a>
								</div>
						</li>
						</ul>
					</div>
					
					<div class="one_wrap fl_left" id="step5A" style="display:none">
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
										<a href="#" rel="4" class="crBreadcrumbs"><span>4</span><?php echo $trans[3]->translate; ?></a>
									</li>
										<li class="crBreadcrumbs1">
										<a href="#" rel="5" class="focus"><span>5</span><?php echo $trans[4]->translate; ?></a>
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
								<label><?php echo $translation[22]->translate; ?></label>
								<div class="form_input">
									<label id="exlbl_ser" value="ad"></label>
								</div>
							</li>
								<li style="background:none;padding:0px;">
								<label><?php echo $translation[23]->translate; ?></label>
								<div class="form_input">
									<label id="exlbl_emp"></label>
								</div>
							</li>
								<li style="background:none;padding:0px;">
								<label><?php echo $translation[24]->translate; ?></label>
								<div class="form_input">
									<label id="exlbl_bdat"></label>
								</div>
							</li>
							<li style="background:none;padding:0px;">
								<label><?php echo $translation[25]->translate; ?></label>
								<div class="form_input">
									<label id="exlbl_btime"></label>
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
											
							case "Last Name :"
							?>
									<li style="background:none;padding:0px;" id="ex_dlnm">
									<label id="lnm"> <?php echo $fiel2;?></label>
									<div  class="form_input">
										<label id="exlbl_1"></label>
									</div>
								</li>
							<?php
							break;
							case "Email :"
							?>
							<li style="background:none;padding:0px;" >
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="exlbl_2"></label>
								</div>
							</li>
							<?php
							break;
							case "Mobile :"
							?>
							<li style="background:none;padding:0px;" id="ex_dmob">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="exlbl_3"></label>
								</div>
							</li>
							<?php
							break;

							case "Address Line1 :"
							?>
							<li style="background:none;padding:0px;" id="ex_dad1">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="exlbl_4"></label>
								</div>
							</li>
							<?php
							break;
							case "Address Line2 :"
							?>
							<li style="background:none;padding:0px;" id="ex_dad2">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="exlbl_5"></label>
								</div>
							</li>
							<?php
							break;
							case "City :"
							?>
							<li style="background:none;padding:0px;" id="ex_dct">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="exlbl_6"></label>
								</div>
							</li>
							<?php
							break;
							case "Post Code :"
							?>
							<li style="background:none;padding:0px;" id="ex_dzp">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="exlbl_7"></label>
								</div>
							</li>
							<?php
							break;
							case "Country :"
							?>
							<li style="background:none;padding:0px;" id="ex_dcountry">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="exlbl_8"></label>
								</div>
							</li>
							<?php
							break;
							case "Phone :"
							?>
							<li style="background:none;padding:0px;" id="ex_dphon">
								<label > <?php echo $fiel2;?></label>
								<div class="form_input">
									<label id="exlbl_9"></label>
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
							<li style="background:none;">
								<div style="text-align:right;margin-right:0px">
									<a href="#" onclick="backButton5();" class="greyishBtn button_small" style="float:left"><?php echo $trans[11]->translate; ?></a>
									<a onclick="return bookItNow();" class="greyishBtn button_small" shape="margin-right:0px;"><?php echo $trans[14]->translate; ?></a>
								</div>
						</li>
						</ul>
					</div>
					
					
					
					
					<div class="one_wrap fl_left" id="step6" style="display:none">
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
										<a href="#" rel="4" class="crBreadcrumbs"><span>4</span><?php echo $trans[3]->translate; ?></a>
									</li>
										<li class="crBreadcrumbs1">
										<a href="#" rel="5" class="focus"><span>5</span><?php echo $trans[4]->translate; ?></a>
									</li>
								</ul>
						</div>
					</div>
									<div class="widget-wp-obs" style="margin-top:5px;margin-bottom:0px">
							<div class="widget-wp-obs_title">
								<span class="iconsweet">f</span>
								<h5> <?php echo $trans[15]->translate; ?></h5>
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
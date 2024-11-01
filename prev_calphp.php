<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-load.php' );
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$msg1  =  $wpdb->get_var('SELECT translate  FROM ' . $wpdb->prefix . sm_translation . ' where id = 17');
$msg2  =  $wpdb->get_var('SELECT translate  FROM ' . $wpdb->prefix . sm_translation . ' where id = 18');
$url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<script>
	var message1 = "<?php echo $msg1;?>";
	var message2 = "<?php echo $msg2;?>";	
	
	<?php 
	$minformat  =  $wpdb->get_var('SELECT minuteformat  FROM ' . $wpdb->prefix . sm_settings . ' where id = 1');
	?>
	var minformat = "<?php echo $minformat; ?>";
	if(minformat==1)
	{
		filepath= uri+"/calendar.php";
	}
	else
	{
		filepath= uri+"/calendar30.php";
	}
	var dat = new Date();
	var today = dat.getDate();
	var month = dat.getMonth() + 1;
	var year = dat.getFullYear();
	day = today;

	jQuery("#prev_month").click(function() 
	{
	
		service_id = jQuery("#seridd").val();
		var radios = document.getElementsByName('radio3');
		var value;
		for(var i = 0; i < radios.length; i++) 
		{
			if(radios[i].type == 'radio' && radios[i].checked) 
			{
				value = radios[i].value;
				break;
			}
		}
		emp = value;
		month = month - 1;
	
		if(month < 1) 
		{
			month = 12;
			year = year - 1;
		}
		jQuery.ajax
		({
			type : "POST",
			data : "cmonth=" + month + "&cyear=" + year + "&cservice=" + service_id + "&empId=" + emp,
			url : filepath,
			success : function(data) 
			{
					switch (month) 
					{
						case 1:
									alpha_month = "Jan";
									break;
						case 2:
									alpha_month = "Feb";
									break;
						case 3:
									alpha_month = "Mar";
									break;
						case 4:
									alpha_month = "Apr";
									break;
						case 5:
									alpha_month = "May";
									break;
						case 6:
									alpha_month = "Jun";
									break;
						case 7:
									alpha_month = "Jul";
									break;
						case 8:
									alpha_month = "Aug";
									break;
						case 9:
									alpha_month = "Sep";
									break;
						case 10:
									alpha_month = "Oct";
									break;
						case 11:
									alpha_month = "Nov";
									break;
						case 12:
									alpha_month = "Dec";
									break;
					}
					jQuery("#cur_cal").html(alpha_month + " - " + year);
					jQuery("#displayed_cal").html(data);
					
				}
			});
		

	});
	jQuery("#next_month").click(function() 
	{
		
		service_id = jQuery("#seridd").val();
		var radios = document.getElementsByName('radio3');
		var value;
		for(var i = 0; i < radios.length; i++) 
		{
			if(radios[i].type == 'radio' && radios[i].checked) 
			{
				value = radios[i].value;
				break;
			}
		}
		emp = value;
		month = month + 1;
	
		if(month > 12) 
		{
				month = 1;
				year = year + 1;
		}
		
		jQuery.ajax
		({
			type : "POST",
			data : "cmonth=" + month + "&cyear=" + year + "&cservice=" + service_id + "&empId=" + emp,
			url : filepath,
			success : function(data) 
			{
					switch (month) 
					{
						case 1:
									alpha_month = "Jan";
									break;
						case 2:
									alpha_month = "Feb";
									break;
						case 3:
									alpha_month = "Mar";
									break;
						case 4:
									alpha_month = "Apr";
									break;
						case 5:
									alpha_month = "May";
									break;
						case 6:
									alpha_month = "Jun";
									break;
						case 7:
									alpha_month = "Jul";
									break;
						case 8:
									alpha_month = "Aug";
									break;
						case 9:
									alpha_month = "Sep";
									break;
						case 10:
									alpha_month = "Oct";
									break;
						case 11:
									alpha_month = "Nov";
									break;
						case 12:
									alpha_month = "Dec";
									break;
					}
					jQuery("#cur_cal").html(alpha_month + " - " + year);
					jQuery("#displayed_cal").html(data);
					
				}
			});
	});	
	time_selected = "no";
	function TimeClick(e)
	{
		var service_timings1 = document.getElementById('service_timings1');
		if(service_timings1 == null) 
		{
	
				var t = jQuery(e).val();
				
				for( i = 1; i <= 96; i++) 
				{
				
						previous_clicked = jQuery("#time_" + i).attr("class");
						
						if(previous_clicked == "hour_selected")
						{
							jQuery("#time_" + i).removeClass("hour_selected");
							jQuery("#time_" + i).addClass("hourschoice_res");
						}
						
				}
					jQuery(e).attr("class", "hour_selected");
					booked_time = jQuery(e).html();
					var totime = booked_time;
					
					service_id = jQuery("#seridd").val();
					var radios = document.getElementsByName('radio3');
					var value;
					for(var i = 0; i < radios.length; i++) 
					{
						if(radios[i].type == 'radio' && radios[i].checked) 
						{
							value = radios[i].value;
							break;
						}
					}
					emp = value;
					filepath22 = uri + "/servicehours.php";
					jQuery.ajax
					({
						type : "POST",
						data : "booktime="+totime+"&serv="+service_id+"&emp="+emp+"&cmonth="+month+"&cyear="+year+"&cday="+day,
						url : filepath22,
						success : function(data) 
						{
							
								if(data == '0')
								{
									alert(message1);
									
								}
								else if(data == '2')
								{
									
									alert(message2);
								}
						}
						});
						if(!document.getElementById('hitime')) 
						{
							var ydyy = document.getElementById('divhid');
							var hitime = document.createElement('input');
							hitime.type = 'hidden';
							hitime.value = booked_time;
							hitime.setAttribute('id', 'hitime');
							ydyy.appendChild(hitime);
					} 
					else 
					{
						document.getElementById('hitime').value = booked_time;
					}
					
					
					
					jQuery(e).attr("class", "hour_selected");
				
					return;
			}
		}
function DayClick(e)
	{
			
			day = jQuery(e).html();
			if(document.getElementById('hitime')) 
			{
				document.getElementById('hitime').value = "";	
			}
			if(!document.getElementById('hiinpday')) 
			{
				var ydy = document.getElementById('divhid');
				var hiinpday = document.createElement('input');
				hiinpday.type = 'hidden';
				hiinpday.value = day;
				hiinpday.setAttribute('id', 'hiinpday');
				ydy.appendChild(hiinpday);
			}
			else 
			{
				document.getElementById('hiinpday').value = day;
			}
			if(!document.getElementById('hiinpmonth')) 
			{
				var ydy = document.getElementById('divhid');
				var hiinpmonth = document.createElement('input');
				hiinpmonth.type = 'hidden';
				hiinpmonth.value = month;
				hiinpmonth.setAttribute('id', 'hiinpmonth');
				ydy.appendChild(hiinpmonth);
			}
			else 
			{
				document.getElementById('hiinpmonth').value = month;
			}
			if(!document.getElementById('hiinpyear')) 
			{
				var ydy = document.getElementById('divhid');
				var hiinpyear = document.createElement('input');
				hiinpyear.type = 'hidden';
				hiinpyear.value = year;
				hiinpyear.setAttribute('id', 'hiinpyear');
				ydy.appendChild(hiinpyear);
			}
			else 
			{
				document.getElementById('hiinpyear').value = year;
			}
			service_id = jQuery("#seridd").val();
			var radios = document.getElementsByName('radio3');
			var value;
			for(var i = 0; i < radios.length; i++) 
			{
				if(radios[i].type == 'radio' && radios[i].checked) 
				{
					value = radios[i].value;
					break;
				}
			}
		
			emp = value;
			jQuery.ajax
			({
				type : "POST",
				data : "cmonth=" + month + "&cyear=" + year + "&cservice=" + service_id + "&empId=" + emp + "&cday="+day,
				url : filepath,
				success : function(data) 
				{
					jQuery("#displayed_cal").html(data);
				}
			});
			
			jQuery.ajax
			({
				type : "POST",
				data : "cmonth=" + month + "&cyear=" + year + "&cday=" + day + "&cservice=" + service_id + "&empId=" + emp + "&action=EmpTimmings",
				url : filepath,
				success : function(data) 
				{

					jQuery("#service_timings").html(data);
				}
			});
				return;
	}
</script>
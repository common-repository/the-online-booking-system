<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;

if($_REQUEST['action'] == 'AddService')
{
				$serv_id = $wpdb->get_col
				(
						$wpdb->prepare
						(
								"SELECT id FROM ".$wpdb->prefix."sm_services ORDER BY id DESC"
								
						)
				);
				$sid = $serv_id[0] + 1;
				$sname = html_entity_decode($_REQUEST['name']);
				$wpdb->query
		        (
		                  $wpdb->prepare
		                  (
		                       "INSERT INTO ".$wpdb->prefix."sm_services(name,cost,rank) VALUES( %s, %d, %d)",
		                       $sname,
		                       intval($_REQUEST['cost']),
		                       $sid
		                   )
		        );
				$service_id = $wpdb->get_col
				(
						$wpdb->prepare
						(
								"SELECT id FROM ".$wpdb->prefix."sm_services ORDER BY id DESC"
								
						)
				);
				$wpdb->query
		        (
		                  $wpdb->prepare
		                  (
		                       "INSERT INTO ".$wpdb->prefix."sm_services_time(hours,minutes,service_id,gap_start_hour,gap_start_minute,gap_end_hour,gap_end_minute) VALUES( %d, %d, %d, %d, %d, %d, %d)",
		                       intval($_REQUEST['hour']),
		                       intval($_REQUEST['mint']),
		                       $service_id[0],
		                       intval($_REQUEST['start_g_hour']),
		                       intval($_REQUEST['start_g_minute']),
		                       intval($_REQUEST['end_g_hour']),
		                       intval($_REQUEST['end_g_minute'])
		                   )
		        );
				
}
else if(isset($_REQUEST['selected_hours']))
{
		$minformat  =  $wpdb->get_var('SELECT minuteformat  FROM ' . $wpdb->prefix . sm_settings . ' where id = 1');
		if($minformat==1)
		{
		if ($_REQUEST['selected_hours'] > 0)
		{
			$shours = intval($_REQUEST['selected_hours']) * 60;
		}
		if ($_REQUEST['selected_minutes'] > 0)
		{
			$sminutes = intval($_REQUEST['selected_minutes']);
		}
		$time_interval = ($shours + $sminutes) / 15;
		$gaphour = 0;
		$gapminute = 0;
		$gaphour_end = 0;
		if (isset($_REQUEST['gapstart']))
		{
			?>
			<option value ="0" >Start Time </option>
			<?php
			for ($gaptime = 1; $gaptime <= $time_interval; $gaptime++)
			{
				if ($gapminute > 45)
				{
					$gaphour++;
					$gapminute = 0;
				}
			?>
			<option value =" <?php echo ($gaphour < 10 ? "0" . $gaphour : $gaphour) . ":" . ($gapminute < 15 ? "00" : $gapminute) ?>" ><?php echo ($gaphour < 10 ? "0" . $gaphour : $gaphour) . ":" . ($gapminute < 15 ? "00" : $gapminute); ?></option>
			<?php $gapminute += 15;
			}
		}
		if (isset($_REQUEST['gapend']))
		{
			?>
			<option value ="0" >End Time </option>
			<?php
			for ($gaptime = 1; $gaptime <= $time_interval; $gaptime++)
			{
				if ($gapminute > 45)
				{	
					$gaphour++;
					$gapminute = 0;
				}
				$gapminute_end = $gapminute + 15;
				if ($gapminute_end > 45)
				{
					$gaphour_end++;
					$gapminute_end = 0;
				}
				?>
				<option value = " <?php echo ($gaphour_end < 10 ? "0" . $gaphour_end : $gaphour_end) . ":" . ($gapminute_end < 15 ? "00" : $gapminute_end) ?>" ><?php echo ($gaphour_end < 10 ? "0" . $gaphour_end : $gaphour_end) . ":" . ($gapminute_end < 15 ? "00" : $gapminute_end);?></option>
				<?php $gapminute += 15;
			}
		}
	}
	else
	{
		if ($_REQUEST['selected_hours'] > 0)
		{
			$shours = intval($_REQUEST['selected_hours']) * 60;
		}
		if ($_REQUEST['selected_minutes'] > 0)
		{
			$sminutes = intval($_REQUEST['selected_minutes']);
		}
		$time_interval = ($shours + $sminutes) / 30;
		$gaphour = 0;
		$gapminute = 0;
		$gaphour_end = 0;
		if (isset($_REQUEST['gapstart']))
		{
			?>
			<option value ="0" >Start Time </option>
			<?php
			for ($gaptime = 1; $gaptime <= $time_interval; $gaptime++)
			{
				if ($gapminute > 30)
				{
					$gaphour++;
					$gapminute = 0;
				}
			?>
			<option value =" <?php echo ($gaphour < 10 ? "0" . $gaphour : $gaphour) . ":" . ($gapminute < 30 ? "00" : $gapminute) ?>" ><?php echo ($gaphour < 10 ? "0" . $gaphour : $gaphour) . ":" . ($gapminute < 30 ? "00" : $gapminute); ?></option>
			<?php $gapminute += 30;
			}
		}
		if (isset($_REQUEST['gapend']))
		{
			?>
			<option value ="0" >End Time </option>
			<?php
			for ($gaptime = 1; $gaptime <= $time_interval; $gaptime++)
			{
				if ($gapminute > 30)
				{	
					$gaphour++;
					$gapminute = 0;
				}
				$gapminute_end = $gapminute + 30;
				if ($gapminute_end > 30)
				{
					$gaphour_end++;
					$gapminute_end = 0;
				}
				?>
				<option value = " <?php echo ($gaphour_end < 10 ? "0" . $gaphour_end : $gaphour_end) . ":" . ($gapminute_end < 30 ? "00" : $gapminute_end) ?>" ><?php echo ($gaphour_end < 10 ? "0" . $gaphour_end : $gaphour_end) . ":" . ($gapminute_end < 30 ? "00" : $gapminute_end);?></option>
				<?php $gapminute += 30;
			}
		}
	
	}
}

else if($_REQUEST['action'] == 'AllocateEmployees')
{
			$empid = intval($_REQUEST['emp']);
			$wpdb->query
			(
			  		$wpdb->prepare
			    	(
			    		"DELETE FROM ".$wpdb->prefix."sm_allocate_serv WHERE emp_id = %d order by id  ASC",
			       		 $empid
			   		)
			);
			$allserv = html_entity_decode($_REQUEST['allserv']);
			$allservices = explode(",", $allserv);
			for ($c = 0; $c < count($allservices)-1; $c++) 
			{
					$name = $allservices[$c];
					$servid = $wpdb -> get_var('SELECT id FROM ' . $wpdb -> prefix . sm_services . '  where name = '."'". $name."'");
					$eeid = $wpdb -> get_var('SELECT emp_id FROM ' . $wpdb -> prefix . sm_allocate_serv . '  where emp_id = '. '"' . $empid . '"' . 'and  serv_id = '. '"' . $servid . '"');
					if($empid != $eeid && $servid != 0)
					{
						$wpdb->query
				        (
				                  $wpdb->prepare
				                  (
				                       "INSERT INTO ".$wpdb->prefix."sm_allocate_serv(emp_id,serv_id) VALUES(%d, %d)",
				                       $empid,
				                       $servid
				                   )
				        );
						
					}
			}
			
}
else if($_REQUEST['action'] == 'deleteservice')
{
				$id = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_allocate_serv . '  where serv_id = '. '"' . intval($_REQUEST['data']) . '"');
				if($id!=0)
				{
						echo "exists";
				}
				else
				{
						$wpdb->query
						(
						  		$wpdb->prepare
						    	(
						    		"DELETE FROM ".$wpdb->prefix."sm_services WHERE id = %d",
						       		 intval($_POST['data'])
						   		)
						);
						$wpdb->query
						(
						  		$wpdb->prepare
						    	(
						    		"DELETE FROM ".$wpdb->prefix."sm_services_time WHERE service_id = %d",
						       		 intval($_POST['data'])
						   		)
						);
						$wpdb->query
						(
						  		$wpdb->prepare
						    	(
						    		"DELETE FROM ".$wpdb->prefix."sm_allocate_serv WHERE serv_id = %d",
						       		 intval($_POST['data'])
						   		)
						);
						
						

						$date = date("Y-m-d");
						$wpdb->query
						(
						  		$wpdb->prepare
						    	(
						    		"DELETE FROM ".$wpdb->prefix."sm_bookings WHERE service_id = %d and date = %d",
						       		 intval($_POST['data']),
						       		 $date
						   		)
						);
						return false;
					}
}
else if($_REQUEST['action'] == 'editrank')
{
			$id = $wpdb->get_results
			(
					$wpdb->prepare
					(
							"SELECT * FROM ".$wpdb->prefix."sm_services",
							$day,
							$month,
							$year,
							$val,
							"Disapproved"
					)
			);
	
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_services SET rank = %d WHERE id = %d",
	                    intval($_REQUEST['rnk_id']),
	                    intval($_REQUEST['serviceId'])
	             )
	      	);
			
}
else if($_REQUEST['action'] == 'updateservice')
{
			$sername = html_entity_decode($_REQUEST['name']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_services SET name = %s , cost = %d WHERE id = %d",
	                    $sername,
	                    intval($_REQUEST['cost']),
	                    intval($_REQUEST['id'])
	             )
	      	);
			return false;
}
else if($_REQUEST['action'] == 'serviceid')
{
			global $wpdb;
			$table_name = $wpdb->prefix . "sm_services";
			$sid = $wpdb->get_var('SELECT count(id) FROM ' . $wpdb->prefix . sm_services);
			echo $sid;
}
else
{
?>
<script type="text/javascript">
	function add_wizservice()
				{	
					
					 jQuery(document).ready(function($)
		             {  
					 
											jQuery.ajax
											({
		                            			type: "POST",
		                                        data: "action=serviceid",
		                                     	url:  uri+"/services.php",
		                                        success: function(data) 
		                                        {  
												
												var ser = data;
												
												
						  if(addServiceNameBlur() && addServiceCostBlur())
						  {
						  		var serhour = document.getElementById("service_hour").value;
						  		var serminute = document.getElementById("service_minute").value;
						  		
								  if((jQuery("#service_hour").val() == "0") || (jQuery("#service_minute").val() == "0" || jQuery("#service_hour").val() == "00") && (jQuery("#service_minute").val() == "00"))
								  {
								  
									  	jQuery("#wizservhr").css('display','block');
									  	return false;
								  }
								  var st_hr = document.getElementById("start_hour1").value;                                                                      
				                  var ed_hr = document.getElementById("end_hour1").value;
				                  var st_hr1= st_hr.split(":");
				                  var shour = st_hr1[0];
				                  var smin = st_hr1[1];
				                  var ed_hr1= ed_hr.split(":");
				                  var ehour = ed_hr1[0];
				                  var emin = ed_hr1[1];
								
				                  var flag = false;
				                  if(st_hr !=0 && ed_hr != 0)
				                  {
				                  	var endHour  = parseInt(ed_hr1[0] * 60) + parseInt(ed_hr1[1]);
				                  	var startHour  = parseInt(st_hr1[0] * 60) + parseInt(st_hr1[1]);
				             
				                  		if((endHour <= startHour ))
				                  	{
				                        jQuery("#errormsg").css('display','block');
				                  		return false;
				                  	}
				                  	else
				                  	{
				                  		flag = true;
				                  	}
				                  	
				                  }
				                  else if(st_hr != 0 || ed_hr != 0 )
				                  {
				                  	 flag = false;
				                  }
				                  else
				                  {
				                  	 flag = true;
				                  }
				                  
				                  if(flag)
		                 		  {                         
				                   		var hour = document.getElementById("service_hour").value;
				                        var minut = document.getElementById("service_minute").value;
				                        var name = document.getElementById("service_name").value;
				                        var cst = document.getElementById("service_cost").value;
				                        
				                        
		                        		jQuery.ajax
		                        		({
		                            			type: "POST",
		                                        data: "hour="+hour+"&mint="+minut+"&name="+name+"&cost="+cst+"&end_g_hour="+ehour+"&end_g_minute="+emin+"&start_g_hour="+shour+"&start_g_minute="+smin+"&action=AddService",
		                                     	url:  uri+"/services.php",
		                                        success: function(data) 
		                                        {    
													if(ser<=1)
													{
													jQuery("#errormsg").css('display','none');  
		                                        		jQuery("#wizservhr").css('display','none');                    					
		                                        		jQuery("#save").css('display','block');
		                                                setTimeout(function() 
		                                                {
																parent.jQuery.fancybox.close();	
																jQuery("#save").css('display','none');
																path= uri+"/servicerebind.php";
																jQuery.ajax
																({
		                                                    			type: "POST",
		                                                                data: "",
		                                                                url: path,
		                                                                success: function(data) 
																		{  	
																				jQuery("#errormsg").css('display','none');
																				var temp=data;
																				var index2=temp.indexOf("/table");
																				var ind=index2+7;
																				var cal=temp.substring(0, ind);
																				jQuery("#iddispser").html(cal);
																				var last=temp.lastIndexOf("/option>");
																				var l_index=last+8;
																				var time=temp.substring(ind,l_index);		
																				jQuery("#serv_id").html(time);
																				
																				document.getElementById("service_name").value="";
																				document.getElementById("service_cost").value="";
																				jQuery("#start_hour1").val(0);
																				jQuery("#-start_hour1").html('Start Time');
																				jQuery("#end_hour1").val(0);
																				jQuery("#-end_hour1").html('End Time');
																				jQuery("#service_hour").val(0);
																				jQuery("#-service_hour").html('Hours');
																				jQuery("#service_minute").val(0);
																				jQuery("#-service_minute").html('Minutes');
																				if(jQuery("#service_name").hasClass('in_submitted'))
			                                                                    {
			                                                                    	jQuery("#service_name").removeClass("in_submitted");
																				}
																				if(jQuery("#service_cost").hasClass('in_submitted'))
			                                                                   	{
			                                                                    	jQuery("#service_cost").removeClass("in_submitted");
			                                                                    }
																				if(jQuery("#service_name").hasClass('in_error'))
			                                                                    {
			                                                                     	jQuery("#service_name").removeClass("in_error");
			                                                                    }
																				if(jQuery("#service_cost").hasClass('in_error'))
			                                                                    {
			                                                                     	jQuery("#service_cost").removeClass("in_error");
			                                                                    }
																				if(jQuery("#service_hour").hasClass('in_submitted'))
			                                                                    {
			                                                                     	jQuery("#service_hour").removeClass("in_submitted");
			                                                                    }
																				if(jQuery("#service_minute").hasClass('in_submitted'))
			                                                                    {
			                                                                    	jQuery("#service_minute").removeClass("in_submitted");
			                                                                    }
																				if(jQuery("#service_hour").hasClass('in_error'))
			                                                                    {
			                                                                    	jQuery("#service_hour").removeClass("in_error");
			                                                                    }
																				if(jQuery("#service_minute").hasClass('in_error'))
			                                                                    {
			                                                                    	jQuery("#service_minute").removeClass("in_error");
			                                                                    }
																				if(document.getElementById('drpservceeee'))
																				{
																					jQuery("#drpservceeee").html(time);
																				}
																																								
																		}
																	});
														}, 1000);
																				
		                                                return false;
													}
													else
													{
													
														parent.jQuery.fancybox.close();
														jQuery('#LimitedContentPlaceHolder').empty();
														jQuery('#LimitedContentPlaceHolder').fadeOut("fast").load(uri+"/services.php").fadeIn(1000);
															jQuery('#modalnewservices').css('display','none');
													}
												}
		                                });
							
		                 		}
		                 		else
		                 		{
		                 			   jQuery("#errormsg").css('display','block');
				                  		return false;
		                 		}
		                 }
						 }
						});
                 	});
                 	return;   
                       
				}
		function addServiceNameBlur()
		{
			if(jQuery('#service_name').val()=="")
			{
				jQuery("#service_name").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#service_name").hasClass('in_error'))
				{
					jQuery("#service_name").removeClass("in_error");
				}
				jQuery("#service_name").addClass("in_submitted");
				return true;
			}
		}
		function addServiceCostBlur()
		{
			if(document.getElementById("service_cost").value =="")
			{
				jQuery("#service_cost").addClass("in_error");
				return false;
			}
			else
			{
				if(jQuery("#service_cost").hasClass('in_error'))
				{
					jQuery("#service_cost").removeClass("in_error");
				}
				jQuery("#service_cost").addClass("in_submitted");
				return true;
			}
		}
		jQuery(document).ready(function($)
		{
			
			jQuery("#service_hour").change(function()
			{
				jQuery.ajax
				({
							type: "POST",
							data: "selected_hours="+jQuery('#service_hour').val() + "&selected_minutes="+jQuery('#service_minute').val()+ "&gapstart=true",
							url:  uri+"/services.php",
							success: function(data)
							{
								
								jQuery("#start_hour1").html(data);
							}
				});
				jQuery.ajax
				({
						type: "POST",
						data: "selected_hours="+jQuery('#service_hour').val() + "&selected_minutes="+jQuery('#service_minute').val()+"&gapend=true",
						url:  uri+"/services.php",
						success: function(data)
						{
						
							jQuery("#end_hour1").html(data);
						}	
				});
	
			});
		});
		function numericOnly(elementRef,e)
		{
			var keyCodeEntered=e.keyCode? e.keyCode : e.charCode;
			if ( (keyCodeEntered >= 48) && (keyCodeEntered <= 57) )
			{
				return true;
			}
			else if(keyCodeEntered == 8)
			{
				return true;
			}
			// '+' sign...
			else if ( keyCodeEntered == 43 )
			{
			// Allow only 1 plus sign ('+')...
				if ( (elementRef.value) && (elementRef.value.indexOf('+') >= 0) )
				return false;
				else
				return true;
			}
			// '-' sign...
			else if ( keyCodeEntered == 45 )
			{
			// Allow only 1 minus sign ('-')...
				if ( (elementRef.value) && (elementRef.value.indexOf('-') >= 0) )
				return false;
				else
				return true;
			}
			// '.' decimal point...
			else if ( keyCodeEntered == 46 )
			{
			// Allow only 1 decimal point ('.')...
				if ( (elementRef.value) && (elementRef.value.indexOf('.') >= 0) )
				return false;
				else
				return true;
			}
			return false;
		}
		
		
		function delete_service(service) 
		{
				action = confirm("Are you sure you want to delete this service?");
					if(action == true)
					{
						
						jQuery.ajax
						({
								type: "POST",
								data: "data=" + service + "&action=deleteservice",
								url: uri+"/services.php",
								success: function(data) 
								{
								if(data=='exists')
								{
									alert('The Service could not be deleted. Some of the Employees has been associated with this Service. Kindly first de-allocate the associated employees to delete this Service.');
								}
									path= uri+"/servicerebind.php";
									jQuery.ajax
									({
											type: "POST",
											data: "bindemp=true",
											url: path,
											success: function(data)
											{
	
												var temp=data;
												var index2=temp.indexOf("/table");
												var ind=index2+7;
												var cal=temp.substring(0, ind);
												jQuery("#iddispser").html(cal);
												var last=temp.lastIndexOf("/option>");
												var l_index=last+8;
												var time=temp.substring(ind,l_index);
												jQuery("#drpserv").html(time);
												jQuery("#serv_id").html(time);
											}
									});
								}
						});
					}
				
			}
			function get_edit_div(e)
			{
					var curr=document.getElementById("sercostcurency_"+e).value;
					var crt=curr.split(" ");
					document.getElementById("sm-service-edit-id").value=document.getElementById("inpserid_"+e).value;
					document.getElementById("service_edit_cost").value=crt[4];
					document.getElementById("service_edit_name").value=document.getElementById("lblservicenam_"+e).value;
					document.getElementById("edtsercost").innerHTML="Cost ("+crt[0]+") :";
			}
			function editser()
			{
					var id = document.getElementById("sm-service-edit-id").value;
					var naee = document.getElementById("service_edit_name").value;
					var namee = encodeURIComponent(naee);
					var cost = document.getElementById("service_edit_cost").value;
					
					jQuery.ajax
					({
						type: "POST",
						data: "id="+id+"&name="+namee+"&cost="+cost+"&action=updateservice",
						url: uri+"/services.php",
						success: function(data) 
						{
						
							jQuery("#saved1").css('display','block');
							setTimeout(function() 
							{
								jQuery("#saved1").css('display','none');
								path= uri+"/servicerebind.php";
								jQuery.ajax
								({
										type: "POST",
										data: "bindemp=true",
										url: path,
										success: function(data)
										{
												var temp=data;
												var index2=temp.indexOf("/table");
												var ind=index2+7;
												var cal=temp.substring(0, ind);
												jQuery("#iddispser").html(cal);
												var last=temp.lastIndexOf("/option>");
												var l_index=last+8;
												var time=temp.substring(ind,l_index);
												jQuery("#drpserv").html(time);
												if(document.getElementById('drpservceeee'))
												{
													jQuery("#drpservceeee").html(time);
												}
										}
									});
									parent.jQuery.fancybox.close();
								}, 1000);
						}
					});
			}
			
				<?php
					$serc = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_services);
				 ?>
				 var servicecount = "<?php echo $serc; ?>";
				function submitrank()
				{
					for(i = 0; i <= servicecount; i++)
					{
						var serviceId =  jQuery("#rank_id_"+i).attr('title');
						var value =  jQuery("#rank_id_"+i).val();
						
						jQuery.ajax
						({
							type: "POST",
							data: "rnk_id="+value+"&serviceId="+serviceId+"&action=editrank",
							url: uri+"/services.php",
							success: function(data)
							{
								
								
									var pathser=uri+"/servicerebind.php";
									jQuery.ajax
									({
										type: "POST",
										data: "bindemp=true",
										url: pathser,
										success: function(data)
										{
												var temp=data;
												var index2=temp.indexOf("/table");
												var ind=index2+7;
												var cal=temp.substring(0, ind);
												jQuery("#iddispser").html(cal);
										}
									});
							}
						});
					}
					jQuery("#saveds").css('display','block');
					setTimeout(function() 
					{
							jQuery("#saveds").css('display','none');
					}, 1000);
				}
function savedetails(opt)	
{
			var empid=document.getElementById('all_emppp1').value;
			var sel = getSelected(opt);
            var strSel = "";
			var str2 = "";
            for (var item in sel)       
            {
				str2 += sel[item].value + ",";
			}
			strSel = encodeURIComponent(str2);
		    jQuery.ajax({
					type: "POST",
					data: "emp="+empid+"&allserv="+strSel+ "&action=AllocateEmployees",
					url:  uri+"/services.php",
					success: function(data) 
					{
						
						path= uri+"/servicerebind.php";
						jQuery.ajax
						({
								type: "POST",
								data: "bindemp=true",
								url: path,
								success: function(data)
								{
									
									var temp=data;
									var index2=temp.indexOf("/table");
									var ind=index2+7;
									var cal=temp.substring(0, ind);
									
									jQuery("#iddispser").html(cal);
								}
						});
						var temp=data;
						var index2=temp.indexOf("/table");
						var ind=index2+7;
						var cal=temp.substring(0, ind);
						jQuery("#iddispser").html(cal);
						jQuery("#saved2").css('display','block');
						jQuery("#errormsggg").css('display','none');
						setTimeout(function() 
						{
							jQuery("#saved2").css('display','none');
							parent.jQuery.fancybox.close();
							jQuery("#all_emppp1").val(0);
							jQuery("#-all_emppp1").html('Select Employee');
							jQuery('#show').css('display','none');
						}, 1000);
				}
		});
		 function getSelected(opt) 
		 {
				var selected = new Array();
				var index = 0;
				for (var intLoop = 0; intLoop < opt.length; intLoop++) 
				{
					if ((opt[intLoop].selected) ||
					(opt[intLoop].checked)) 
					{
					  index = selected.length;
					  selected[index] = new Object;
					  selected[index].value = opt[intLoop].value;
					  selected[index].index = intLoop;
					}
				}
				return selected;
			}
}	
		function callemp1()
		{
			
			
				var empid= document.getElementById('all_emppp1').value;
				if(empid!=0)
				{
					jQuery.fancybox.update();
					
				}
				jQuery.ajax
				({
						type: "POST",
						data: "emp_id="+empid+"&action=BindEmployees",
						url:  uri+"/employee_allocation.php",
						success: function(data) 
						{
						jQuery('#show').css('display','none');
						jQuery("#allocateserv").html(data);
							setTimeout(function() 
							{
							jQuery('#show').css('display','block');
							jQuery.fancybox.update();
							}, 150);
						}
				});
				
			
		}		
</script>
<div id="servicediv">
		<script type="text/javascript">jQuery("select, input:checkbox, input:radio").uniform();</script>
		<div class="contentarea">
		<div class="one_wrap fl_left">
				<div class="msgbar msg_Success hide_onC" id="saveds" style="display: none;margin-top:10px;margin-bottom:0px;width:98%;margin-left:0px;">
					<span class="iconsweet">=</span>
					<p>Services has been successfully Saved.</p>
				</div>
				<div class="msgbar msg_Success hide_onC" id="savedit" style="display:none;">
					<span class="iconsweet">=</span>
					<p>Service has been Successfully Edited.</p>
				</div>
				<ul class="form_fields_container">
					<?php 
				global $wpdb;
				$seridd = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_services);
				?>
					<li>
						<?php
						if($seridd<3)
						{
						?>
							<a  id="submit" href="javascript:;" class="greyishBtn button_small" >Save Services</a>
							<a style="margin: 8px;" style="display:block" id="modalnewservices"  href="#modalNewService" class="greyishBtn button_small fancybox" >Add New Services</a>
							<a class="greyishBtn button_small fancybox"  href="#allocateEmployeeee">Allocate Services</a>
						<?php
						}
						else
						{
						?>
							<a  id="submit" href="javascript:;" class="greyishBtn button_small" >Save Services</a>
							<a class="greyishBtn button_small fancybox"  href="#allocateEmployeeee">Allocate Services</a>
						<?php
						}
						?>
					</li>
				</ul>
				<div class="widget-wp-obs" style="margin-top:0px;margin-bottom:10px;">
						<div class="widget-wp-obs_title">
								<span class="iconsweet">k</span>
								<h5> Services</h5>
						</div>
						<div id="divbdyfdf" class="widget-wp-obs_body">
						<?php
						$empname = $wpdb->get_results
						(
								$wpdb->prepare
								(
										'SELECT * FROM '.$wpdb->prefix.'sm_services LEFT OUTER JOIN ' . $wpdb -> prefix . 'sm_allocate_serv ON ' . $wpdb -> prefix . 'sm_services.id = ' . $wpdb -> prefix . 'sm_allocate_serv.serv_id LEFT OUTER JOIN ' . $wpdb -> prefix . 'sm_employees ON ' . $wpdb -> prefix . 'sm_employees.id = ' . $wpdb -> prefix . 'sm_allocate_serv.emp_id ORDER BY ' . $wpdb -> prefix . 'sm_services.rank ASC '
								)
						);
						$service_name = $wpdb->get_col
						(
								$wpdb->prepare
								(
										 "SELECT name From ".$wpdb->prefix."sm_services ORDER BY rank ASC"
								)
						);	
						$service_hours = $wpdb->get_col
						(
								$wpdb->prepare
								(
										 'SELECT ' . $wpdb -> prefix . 'sm_services_time.hours FROM ' . $wpdb -> prefix . 'sm_services_time join ' . $wpdb -> prefix . 'sm_services  on ' . $wpdb -> prefix . 'sm_services_time.service_id= ' . $wpdb -> prefix . 'sm_services.id  ORDER BY ' . $wpdb -> prefix . 'sm_services.rank ASC'
								)
						);
						$service_minutes = $wpdb->get_col
						(
								$wpdb->prepare
								(
										 'SELECT ' . $wpdb -> prefix . 'sm_services_time.minutes FROM ' . $wpdb -> prefix . 'sm_services_time join ' . $wpdb -> prefix . 'sm_services  on ' . $wpdb -> prefix . 'sm_services_time.service_id= ' . $wpdb -> prefix . 'sm_services.id  ORDER BY ' . $wpdb -> prefix . 'sm_services.rank ASC'
								)
						);
						$service_cost = $wpdb->get_col
						(
								$wpdb->prepare
								(
										 "SELECT cost From ".$wpdb->prefix."sm_services ORDER BY rank ASC"
								)
						);	
						$service_id = $wpdb->get_col
						(
								$wpdb->prepare
								(
										 "SELECT id From ".$wpdb->prefix."sm_services ORDER BY rank ASC"
								)
						);	
						$rank = $wpdb->get_col
						(
								$wpdb->prepare
								(
										 "SELECT rank From ".$wpdb->prefix."sm_services ORDER BY rank ASC"
								)
						);	
						$sercurrency = $wpdb -> get_var('SELECT currency_sign FROM ' . $wpdb -> prefix . sm_currency . ' where ' . $wpdb -> prefix . sm_currency . '.currency_used = 1');
						?>
							<table class="activity_datatable" width="100%" border="0" cellspacing="0" cellpadding="8" id="iddispser">
							<tbody>
								<tr>
									<th width="15%"> Display Order </th>
									<th width="15%"> Service Name </th>
									<th width="15%"> Service ShortCode </th>
									<th width="15%"> Employee Name </th>
									<th width="15%"> Service Time </th>
									<th width="15%"> Service Cost </th>
									<th width="10%"> Action </th>
								</tr>
								<?php
									for ($i = 0; $i < count($service_id); $i++) 
									{
										$num = 0;
										$emp_nam = $wpdb->get_results
										(
												$wpdb->prepare
												(
														'SELECT ' . $wpdb->prefix . 'sm_employees.emp_name FROM ' . $wpdb->prefix . 'sm_employees  join ' . $wpdb->prefix . 'sm_allocate_serv  on ' . $wpdb->prefix . 'sm_employees.id= ' . $wpdb->prefix . 'sm_allocate_serv.emp_id where ' . $wpdb->prefix . 'sm_allocate_serv.serv_id = %d',
														$service_id[$i]
												)
										);
								?>
							<tr>
								<td>
									<ul class="form_fields_container" style="text-align: center">
										<li style="background: none">
											<div class="form_input">
												<input style="width: 50px" title="<?php echo $service_id[$i]; ?>" type="text" id="rank_id_<?php echo $i; ?>" name="rank_id_<?php echo $i; ?>" value="<?php echo $rank[$i] ?>" />
											</div>
										</li>
									</ul>
								</td>
								<td>
									<input type="hidden" id="lblservicenam_<?php echo $i; ?>" value="<?php echo $service_name[$i]; ?>">
									</input><?php echo $service_name[$i]; ?>
								</td>
								<td>[booking service=<?php echo $service_id[$i]; ?>]
									<input type="hidden" value="<?php echo $service_id[$i]; ?>" id="inpserid_<?php echo $i; ?>">
									</input>
								</td>
								<td>
									<?php
									for ($h = 0; $h < count($emp_nam); $h++) 
									{
										$cunt = count($emp_nam) - 1;
										echo $emp_nam[$h] -> emp_name;
										if ($h != $cunt) 
										{
											echo ",";
										}
									}
									?>
								</td>
								<td>
									<div class="form_input">
										<?php if($service_hours[$i] ==0 && $service_minutes[$i]!=0)
										{
										?>
										<label><?php echo $service_minutes[$i], "mins"; ?></label>
										<?php 
										}
										else if($service_hours[$i] !=0 && $service_minutes[$i]!=0)
										{
										?>
										<label><?php echo $service_hours[$i], "hr", ",  ", $service_minutes[$i], "  mins"; ?></label>
										<?php }
										else
										{
										?>
										<label><?php echo $service_hours[$i], "hrs"; ?></label>
										<?php 
										} ?>
												</div>
								</td>
								<td>
										<input type="hidden" id="sercostcurency_<?php echo $i; ?>" value="<?php echo $sercurrency . "    " . $service_cost[$i]; ?>">
										</input><?php echo $sercurrency . "    " . $service_cost[$i]; ?>
								</td>
								<td>
								<span class="data_actions iconsweet"> <a class="tip_north fancybox" original-title="Edit" id="<?php echo $i; ?>" href="#modaleditService"   data-toggle="modal" name="<?php echo $i; ?>" onClick="get_edit_div(<?php echo $i; ?>)" style="cursor:pointer;">C</a> <a class="tip_north" original-title="Delete" id='<?php echo $service_id[$i]; ?>'  href="javascript: delete_service('<?php echo $service_id[$i] ?>')" style="cursor:pointer;">X</a> 
								</span>
								</td>
							</tr>
								<?php $num++;
								}
								?>
							</tbody>
						</table>	
					</div>
	</div>
			<ul class="form_fields_container">
				<li>
					<a  onclick="return submitrank();" href="javascript:;" class="greyishBtn button_small" >Save Services</a>
				</li>
			</ul>
	
		</div>
		<div style="display:none;width:600px;" id="modalNewService">
										<div class="msgbar msg_Error hide_onC" id="errormsg" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
											<span class="iconsweet">X</span>
											<p>
												Gap Selection is Invalid.
											</p>
										</div>
										<div class="msgbar msg_Error hide_onC" id="wizservhr" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
											<span class="iconsweet">X</span>
											<p>
												Choose Service Hours & Minutes
											</p>
										</div>
										<div class="msgbar msg_Success hide_onC" id="save" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
											<span class="iconsweet">=</span>
											<p>
												Service has been saved successfully.
											</p>
										</div>
										<div class="widget-wp-obs" style="margin:5px;">
											<div class="widget-wp-obs_title">
												<span class="iconsweet">o</span>
												<h5> Add New Service</h5>
											</div>
											<div class="widget-wp-obs_body">
												<ul class="form_fields_container">
													<li style="padding-bottom: 5px">
														<label> Service Name :</label>
														<div class="form_input" style="width:70%">
															<input type="text" id="service_name" onBlur="return addServiceNameBlur();" name="service_name" />
														</div>
													</li>
													<?php
													
													$curr = $wpdb -> get_var('SELECT currency_sign FROM ' . $wpdb -> prefix . sm_currency . '  where currency_used = "1" ');
													?>
													<li style="padding-bottom: 5px">
														<label> Cost (<?php echo $curr;?>) :</label>
														<div class="form_input" style="width:70%">
															<input onKeyPress="return numericOnly(this,event);" onBlur="return addServiceCostBlur();" type="text" id="service_cost" name="service_cost" value="" />
														</div>
													</li>
													<li style="padding-bottom: 5px">
														<label> Time :</label>
														<div class="form_input" style="width:70%">
															<select id="service_hour"  name="service_hour" >
																<option value='0'>Hours</option>
																<?php
																for ($i = 0; $i <= 23; $i++) {
																	if ($i < 10) {
																		echo "<option value=0" . $i . " >0" . $i . "  Hours</option>";
																	} else {
																		echo "<option value=" . $i . ">" . $i . "  Hours</option>";
																	}
																}
																?>
															</select>
															<?php
															$minformat  =  $wpdb->get_var('SELECT minuteformat  FROM ' . $wpdb->prefix . sm_settings . ' where id = 1');
															if($minformat==1)
															{
																?>
																<select id="service_minute" name="service_minute" >
																<option value='0'>Minutes</option>
																<?php
																for ($i = 0; $i < 60; $i += 15) 
																{
																	if ($i < 15) 
																	{

																		echo "<option value=0" . $i . ">0" . $i . " Minutes</option>";
																	} 
																	else 
																	{
																		echo "<option value=" . $i . ">" . $i . "  Minutes</option>";
																	}
																}
																?>
															</select>
															<?php
															}
															else
															{
																?>
																<select id="service_minute" name="service_minute" >
																<option value='0'>Minutes</option>
																<?php
																for ($i = 0; $i < 60; $i += 30) {
																	if ($i < 30) {

																		echo "<option value=0" . $i . ">0" . $i . " Minutes</option>";
																	} else {
																		echo "<option value=" . $i . ">" . $i . "  Minutes</option>";
																	}
																}
																?>
															</select>
															<?php
															}
															?>
															
														</div>
													</li>
													<li style="padding-bottom: 5px">
														<label> Gap Hours :</label>
														<div class="form_input" style="width:70%">
															<select id="start_hour1">
																<option value="0" >Start Time</option>
															</select>
															<select id="end_hour1">
																<option value="0">End Time</option>
															</select>
														</div>
													</li>
													<li>
														<a href="#" id="sm-add-service-submit" class="greyishBtn  button_small"  style="margin-left:150px;" onclick="return add_wizservice();">Save changes</a>
													</li>
												</ul>
											</div>
										</div>
									</div>

<div  style="display:none;width:600px" id="modaleditService">
	<div class="msgbar msg_Success hide_onC" id="saved1" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
		<span class="iconsweet">=</span>
		<p>
			Services has been successfully Saved.
		</p>
	</div>
	<div class="widget-wp-obs" style="margin:5px">
		<div class="widget-wp-obs_title">
			<span class="iconsweet">o</span>
			<h5>Edit Service</h5>
		</div>
		<div class="widget-wp-obs_body">
			<ul class="form_fields_container">
				<li>
					<label> Service Name :</label>
					<div class="form_input" style="width:70%">
						<input type="text"  id="service_edit_name" name="service_edit_name" value="" />
					</div>
				</li>
				<li>
					<label id="edtsercost" >Cost :</label>
					<div class="form_input" style="width:70%">
						<input  type="text" id="service_edit_cost" name="service_edit_cost" value="" onkeypress="return numericOnly(this,event);"  />
					</div>
				</li>
				<li>
					<a href="#" id="edit_serv" class="greyishBtn  button_small" onclick="editser()" style="margin-top:10px; margin-left:155px;">Save Changes</a>
					<input type="hidden" id="sm-service-edit-id" name="sm_service_id" value="" />
				</li>
			</ul>

		</div>
	</div>
</div>

	<div  style="width:600px;display:none" id="allocateEmployeeee">
					<div class="msgbar msg_Error hide_onC" id="errormsggg" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
						<span class="iconsweet">X</span>
						<p>
							Select Employee First.
						</p>
					</div>
					<div class="msgbar msg_Success hide_onC" id="saved2" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
						<span class="iconsweet">=</span>
						<p>
							All Changes has been Successfully Saved.
						</p>
					</div>
					<div class="widget-wp-obs" style="margin:5px;">
						<div class="widget-wp-obs_title">
							<span class="iconsweet">r</span>
							<h5> Allocate Services</h5>
						</div>
						<div class="widget-wp-obs_body">
							<ul class="form_fields_container">
								<li>
									<label> Employee : <span style="color: red">*</span> : </label>
									<div id="empdisppp" class="form_input">
										<select id="all_emppp1" name="all_emppp1" onchange="callemp1();">
											<option value="0">Select Employee</option>
											<?php
												$emp = $wpdb->get_results
												(
														$wpdb->prepare
														(
																'SELECT * FROM '.$wpdb->prefix."sm_employees where status = %s order by emp_name ASC",
																"Active"
																
														)
												);
												
												$srv="";
												for( $i = 0; $i < count($emp); $i++)
												{
												if ($i==0)
												{
													$emp_d=$emp[$i]->id;
												}
												?>
												<option value ="<?php echo $emp[$i] -> id;?>"><?php echo $emp[$i] -> emp_name;
												?>
												</option>
												<?php
												}
												?>
										</select>
									</div>
								</li>
								<div id="show" style="display:none">
								<li style="max-height:250px;overflow-y:scroll">
								<div class="form_input" id="allocateserv">
								</div>
								</li>
								<li style="padding-bottom:10px;padding-top:10px">
									<div style="margin-left:125px;">
										<a href="#" class="greyishBtn button_small"  onclick="javascript:savedetails(document.getElementsByName('allocateservice'));" >Save Details</a>
									</div>
								</li>
								</div>
							</ul>
						</div>
					</div>
				</div>
		</div>
	</div>
<?php 
}
?>
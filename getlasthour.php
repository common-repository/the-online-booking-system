<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' ); 
global $wpdb;
$url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<?php
$hr = intval($_REQUEST['hr']);
$mns = intval($_REQUEST['mns']);
$bookedcheck = esc_attr($_REQUEST['booked']);

?>
<script type="text/javascript">jQuery("select, input:checkbox, input:radio").uniform();</script>	
<?php 
if(isset($_REQUEST['popultemp']))
{
     		?>
			<select id="emp" onchange="getstartendtimebtn();">
			<?php
			$serviceid = intval($_REQUEST['Service']);
			global $wpdb;
			$empnam = $wpdb->get_results
			(
					$wpdb->prepare
					(
							"SELECT emp_id FROM ".$wpdb->prefix."sm_allocate_serv WHERE serv_id = %d",
							$serviceid
							
					)
			);
			
			$emppid=$wpdb->get_var("select emp_id from " . $wpdb->prefix . "sm_bookings" . " where id = " . intval($_REQUEST['empidd']));
			for($j=0;$j<count($empnam);$j++)
			{
					$emptbl = $wpdb->get_row
					(
							$wpdb->prepare
							(
							        "SELECT id,emp_name,emp_color FROM ".$wpdb->prefix."sm_employees WHERE id = %d",
							         $empnam[$j]->emp_id
							)
					);
				   
					if($emppid==$emptbl->id)
					{
							?>
							<option value="<?php echo $emptbl->id; ?>" selected="selected"><?php echo  $emptbl->emp_name; ?></option>
							<?php	
					}
					else
					{
						 	?>
						 	<option value="<?php echo $emptbl->id; ?>"><?php echo $emptbl->emp_name; ?></option>										
							<?php					
					}
			}
			?>
			</select>
			<?php
}
else if(isset($_REQUEST['day']))
{
		global $wpdb;
		$booked = $wpdb->get_results
		(
				$wpdb->prepare
				(
						"SELECT service_id, day, month, year, hour, minute, emp_id FROM ".$wpdb->prefix."sm_bookings WHERE day = %d AND month = %d AND year = %d AND emp_id = %d AND status != %s",
						intval($_REQUEST['dayy']),
						intval($_REQUEST['month']),
						intval($_REQUEST['year']),
						intval($_REQUEST['empid']),
						"Disapproved"
				)
		);
		
		if(!empty($_REQUEST['day']))
	    {
	    	$day_time = $wpdb->get_row
			(
					$wpdb->prepare
					(
							"SELECT * FROM ".$wpdb->prefix."sm_timings WHERE day = %s AND blocked = %d AND emp_id = %d",
							esc_attr($_REQUEST['day']),
							"1",
							intval($_REQUEST['empid'])
					)
			);	
			
		}
		$dattimeee = $wpdb->get_var('SELECT count(day) FROM ' . $wpdb->prefix . sm_block_date . ' WHERE day = ' . '"' . intval($_REQUEST['dayy']) . '"' . ' AND month =' . '"' . intval($_REQUEST['month']) . '"' . ' AND year =' . '"' . intval($_REQUEST['year']) . '"'. ' AND emp_id =' . '"' . intval($_REQUEST['empid']) . '"');
		
		if($day_time->start_hour=="0" && $day_time->start_minute=="0" && $day_time->emp_id=="" ||  $dattimeee !=0)
		{
		}
		else
		{
			$minss=$day_time->start_minute;
			$minformat  =  $wpdb->get_var('SELECT minuteformat FROM ' . $wpdb->prefix . sm_settings . ' where id = 1');
			if($minformat==1)
			{
			?>
			<select id="hourselect" name="hourselect" onchange="selecttime();">
			<?php
			$serid=intval($_REQUEST['serid']);
			$booked = $wpdb->get_results
			(
					$wpdb->prepare
					(
							"SELECT service_id, day, month, year, hour, minute, emp_id FROM ".$wpdb->prefix."sm_bookings WHERE day = %d AND month = %d AND year = %d AND emp_id = %d AND status != %s",
							intval($_REQUEST['dayy']),
							intval($_REQUEST['month']),
							intval($_REQUEST['year']),
							intval($_REQUEST['empid']),
							"Disapproved"
					)
			);
			for ($hour = $day_time -> start_hour; $hour <= $day_time -> end_hour; $hour++) {
			for ($minute = 0; $minute <= 45; $minute += 15) {
				for ($matched = 0; $matched <= count($booked); $matched++) {
					if ($hour == $booked[$matched] -> hour && $minute == $booked[$matched] -> minute) {
						$serid = $cservice;
						$table_name = $wpdb -> prefix . "sm_services_time";
						$serhours = $wpdb -> get_var('SELECT hours FROM ' . $table_name . ' WHERE service_id = ' . '"' . $serid . '"');
						$sermins = $wpdb -> get_var('SELECT minutes FROM ' . $table_name . ' WHERE service_id = ' . '"' . $serid . '"');
						if ($sermins > 0 && $sermins <= 15) {
							$sermins = 15;
						}
						else if ($sermins > 15 && $sermins <= 30) {
							$sermins = 30;
							
						}
						else if ($sermins > 30 && $sermins <= 45) {
							$sermins = 45;

						}
						else
						{
							$sermins = 0;
							$serhours++;
						}
						$Sertime = $serhours * 60 + $sermins;
						$serinterval = $Sertime / 15;
						$service = $wpdb->get_row
						(
								$wpdb->prepare
								(
										"SELECT * FROM ".$wpdb->prefix."sm_services_time WHERE service_id = %d ",
										$booked[$matched] -> service_id
										
								)
						);
						$service_time_h = $service -> hours;
						$service_time_m = $service -> minutes;
						if ($service_time_h > 0) 
						{
							$service_time_h *= 60;
						}
						$service_time = $service_time_h + $service_time_m;
						$time_intervals = $service_time / 15;
						$service_gap_sh = $service -> gap_start_hour;
						$service_gap_sm = $service -> gap_start_minute;
						$service_gap_eh = $service -> gap_end_hour;
						$service_gap_em = $service -> gap_end_minute;
						$gap_hour = 0;
						$gap_minute = 0;
						for ($i = 0; $i < $time_intervals; $i++) {
							if ($minute > 45) {
								$hour++;
								$minute = 0;
							}
							if ($gap_minute > 45) {
								$gap_hour++;
								$gap_minute = 0;
							}
							$tempEnd = $day_time -> end_hour * 60 +  $day_time -> end_minute;
							$tempStart = $hour * 60 + $minute;
							if ($tempStart <= $tempEnd) {
								if (!($service_gap_sh == 0 && $service_gap_sm == 0 && $service_gap_eh == 0 && $service_gap_em == 0)) {
									$gap_starting = ($service_gap_sh * 60) + $service_gap_sm;
									$gap_ending = ($service_gap_eh * 60) + $service_gap_em;
									$gap_interval = ($gap_ending - $gap_starting) / 15;
									if (($service_gap_sh == $gap_hour) && ($service_gap_sm == $gap_minute)) {
										for ($j = 0; $j < $gap_interval; $j++) {
											if ($minute > 45) 
											{
												$hour++;
												$minute = 0;
											}
											
											if ($minute < $day_time -> start_minute && $minute_started == false) 
											{
												
											} 
											else 
											{
												
												if ($hour == $day_time -> end_hour && $minute > $day_time -> end_minute) {
													break 5;
												}

												$tottim = $serhours * 60 + $sermins;
												$gap = $gap_ending - $gap_starting;
												$booking = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['dayy']) . '"' . ' AND hour =' . '"' . $hour . '"' . ' AND minute =' . '"' . $minute . '"' . ' AND month =' . '"' . intval($_REQUEST['month']) . '"' . ' AND year =' . '"' . intval($_REQUEST['year']) . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['empid']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
												$hourcheck = $hour;
												$mincheck = $minute;
												$blktm = $hour . ":" . $minute . ":00";
												$mintemp1 = $minute;
												if ($hourcheck > 12) 
												{
													$hourcheck = $hour - 12;

												}
												
												if ($hour < 12) 
												{
													
													$minute = $minute . "AM";
													$mntt = "00AM";
												} 
												else 
												{
													$minute = $minute . "PM";
													$mntt = "00PM";
												}
												$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['dayy']) . '"' . ' AND month =' . '"' . intval($_REQUEST['month']) . '"' . ' AND year =' . '"' . intval($_REQUEST['year']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['empid']) . '"');
												$btime = explode(':', $blktime);
												$blkktime = $btime[0] . ":" . $btime[1];
												if ($booking == 0 && $blktime == "" ) 
												{
													
													if ($gap >= $tottim) 
													{
												
													?>
													
													<option value="<?php echo  ($hour < 10 ? "0".$hour : $hour) . ":" . ($mintemp1 < 15 ? "0".$mintemp1 : $mintemp1); ?>"><?php echo  ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($mintemp1 < 15 ? $mntt : $minute)  ?></option>
													<?php				
													} 

												} 
												$minute += 15;
												$time++;
												$i++;
												$minute_started = true;
												if ($minute > 45) {
													$minute = 0;
													$hour++;
												}
												if ($gap_minute > 45) {
													$gap_minute = 0;
													$gap_hour++;
												}
											}
										}
									}
								}
								if ($minute < $day_time -> start_minute && $minute_started == false) 
								{
								} 
								else 
								{
									if ($hour == $day_time -> end_hour && $minute > $day_time -> end_minute) 
									{
										break 4;
									}
									if ($i < $time_intervals) 
									{
										if ($minute > 45) 
										{
											$hour++;
											$minute = 0;
										}
										if ($gap_minute > 45) {
											$gap_hour++;
											$gap_minute = 0;
										}
										$hourcheck = $hour;
										$mincheck = $minute;
										$mintemp1 = $minute;
										if ($hourcheck > 12) 
										{
											$hourcheck = $hour - 12;
										}
										if ($hour < 12) 
										{
											$minute = $minute . "AM";
											$mntt = "00AM";
										} 
										else 
										{
											$minute = $minute . "PM";
											$mntt = "00PM";
										}
										$tempHrVar = $hour < 10 ? "0".$hour : $hour;
										$tempMinVar = $mincheck < 15 ? "0".$mincheck : $mincheck;
											if($tempHrVar == $hr && $tempMinVar == $mns && $bookedcheck == "false")
						{
						?>
									<option selected="selected" value="<?php echo  ($hour < 10 ? "0".$hour : $hour) . ":" . ($mintemp1 < 15 ?  "0".$mintemp1 : $mintemp1); ?>"><?php echo  ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($mintemp1 < 15 ? $mntt : $minute)  ?></option>
									<?php
									}
										$minute += 15;
										$time++;
										$gap_minute += 15;
										$minute_started = true;
									}
								}
							}
						}
					}
				}
					
							$tempEnd = $day_time -> end_hour * 60 +  $day_time -> end_minute;
							$tempStart = $hour * 60 + $minute;
							if ($tempStart <= $tempEnd) 
							{
					$bookinggg = 0;
					$blktm = $hour . ":" . $minute . ":00";
					if ($minute > 45) 
					{
						$hour++;
						$minute = 0;
					}
					$tm = $hour . ":" . $minute;
					$hrs = $hour;
					$mins = $minute;
				
					if ($hour == "") 
					{
						$bookinggg = -1;
					} 
					else 
					{
						for ($intervl = 1; $intervl <= $serinterval; $intervl++) 
						{
							if ($mins > 45) 
							{
								$mins = 0;
								$hrs++;
							}
							if ($hrs <= $day_time -> end_hour) 
							{
								
								$bookinggg = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['dayy']) . '"' . ' AND hour =' . '"' . $hrs . '"' . ' AND minute =' . '"' . $mins . '"' . ' AND month =' . '"' . intval($_REQUEST['month']) . '"' . ' AND year =' . '"' . intval($_REQUEST['year']) . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['empid']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
							
								$mins = $mins + 15;
								if ($bookinggg > 0) 
								{
									break;
								}
							}
							else 
							{
								$bookinggg = 1;
								break;
							}
						}
					}
					
					
					$hourcheck = $hour;
					$mincheck = $minute;
					$mintemp1 = $minute;
					if ($hourcheck > 12) 
					{
					
						$hourcheck = $hour - 12;
						
					}
					if ($hour < 12) 
					{
						$minute = $minute . "AM";
						$mntt = "00AM";
					} 
					else 
					{
						$minute = $minute . "PM";
						$mntt = "00PM";
					}
					$dattimeee = $wpdb->get_var('SELECT count(day) FROM ' . $wpdb->prefix . sm_block_date . ' WHERE day = ' . '"' . intval($_REQUEST['dayy']) . '"' . ' AND month =' . '"' . intval($_REQUEST['month']) . '"' . ' AND year =' . '"' . intval($_REQUEST['year']) . '"'. ' AND emp_id =' . '"' . intval($_REQUEST['empid']) . '"');
					$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['dayy']) . '"' . ' AND month =' . '"' . intval($_REQUEST['month']) . '"' . ' AND year =' . '"' . intval($_REQUEST['year']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['empid']) . '"');
					if($bookinggg == 0 && $blktime == "") 
					{
						
					?>
						<option value="<?php echo  ($hour < 10 ? "0".$hour : $hour) . ":" . ($mintemp1 < 15 ?  "0".$mintemp1 : $mintemp1); ?>"><?php echo  ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($mintemp1 < 15 ? $mntt : $minute)  ?></option>
						<?php
						
						
					} 
					$time++;
					$minute_started = true;
					$serinterval--;
				}

			}
		}
			
			?>
			</select>
			<?php
		}
		else
		{
		?>
		<select id="hourselect" name="hourselect" onchange="selecttime();">
			<?php
			$serid=intval($_REQUEST['serid']);
			$booked = $wpdb->get_results
			(
					$wpdb->prepare
					(
							"SELECT service_id, day, month, year, hour, minute, emp_id FROM ".$wpdb->prefix."sm_bookings WHERE day = %d AND month = %d AND year = %d AND emp_id = %d AND status != %s",
							intval($_REQUEST['dayy']),
							intval($_REQUEST['month']),
							intval($_REQUEST['year']),
							intval($_REQUEST['empid']),
							"Disapproved"
					)
			);
					
			for ($hour = $day_time -> start_hour; $hour <= $day_time -> end_hour; $hour++) {
			for ($minute = 0; $minute <= 30; $minute += 30) {
				for ($matched = 0; $matched <= count($booked); $matched++) {
					if ($hour == $booked[$matched] -> hour && $minute == $booked[$matched] -> minute) {
						$serid = $cservice;
						$table_name = $wpdb -> prefix . "sm_services_time";
						$serhours = $wpdb -> get_var('SELECT hours FROM ' . $table_name . ' WHERE service_id = ' . '"' . $serid . '"');
						$sermins = $wpdb -> get_var('SELECT minutes FROM ' . $table_name . ' WHERE service_id = ' . '"' . $serid . '"');
						
						if ($sermins > 0 && $sermins <= 30) {
							$sermins = 30;
						}
						else
						{
							$sermins = 0;
							$serhours++;
						}
						$Sertime = $serhours * 60 + $sermins;
						$serinterval = $Sertime / 30;
						$service = $wpdb->get_row
						(
								$wpdb->prepare
								(
										"SELECT * FROM ".$wpdb->prefix."sm_services_time WHERE service_id = %d ",
										$booked[$matched] -> service_id
										
								)
						);
						
						
						$service_time_h = $service -> hours;
						$service_time_m = $service -> minutes;
						if ($service_time_h > 0) 
						{
							$service_time_h *= 60;
						}
						$service_time = $service_time_h + $service_time_m;
						$time_intervals = $service_time / 30;
						$service_gap_sh = $service -> gap_start_hour;
						$service_gap_sm = $service -> gap_start_minute;
						$service_gap_eh = $service -> gap_end_hour;
						$service_gap_em = $service -> gap_end_minute;
						
						$gap_hour = 0;
						$gap_minute = 0;
						for ($i = 0; $i < $time_intervals; $i++) {
							if ($minute > 30) {
								$hour++;
								$minute = 0;
							}
							if ($gap_minute > 30) {
								$gap_hour++;
								$gap_minute = 0;
							}
							$tempEnd = $day_time -> end_hour * 60 +  $day_time -> end_minute;
							
							$tempStart = $hour * 60 + $minute;
							
							if ($tempStart <= $tempEnd) {
								if (!($service_gap_sh == 0 && $service_gap_sm == 0 && $service_gap_eh == 0 && $service_gap_em == 0)) {
									$gap_starting = ($service_gap_sh * 60) + $service_gap_sm;
									
									$gap_ending = ($service_gap_eh * 60) + $service_gap_em;
									
									$gap_interval = ($gap_ending - $gap_starting) / 30;
									
									if (($service_gap_sh == $gap_hour) && ($service_gap_sm == $gap_minute)) {
										for ($j = 0; $j < $gap_interval; $j++) {
											if ($minute > 30) 
											{
												$hour++;
												$minute = 0;
											}
											
											if ($minute < $day_time -> start_minute && $minute_started == false) 
											{
												
											} 
											else 
											{
												
												if ($hour == $day_time -> end_hour && $minute > $day_time -> end_minute) {
													break 5;
												}

												$tottim = $serhours * 60 + $sermins;
												
												$gap = $gap_ending - $gap_starting;
											
												$booking = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['dayy']) . '"' . ' AND hour =' . '"' . $hour . '"' . ' AND minute =' . '"' . $minute . '"' . ' AND month =' . '"' . intval($_REQUEST['month']) . '"' . ' AND year =' . '"' . intval($_REQUEST['year']) . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['empid']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
												
												$hourcheck = $hour;
												$mincheck = $minute;
												$blktm = $hour . ":" . $minute . ":00";
												$mintemp1 = $minute;
												if ($hourcheck > 12) 
												{
													$hourcheck = $hour - 12;

												}
												
												if ($hour < 12) 
												{
													
													$minute = $minute . "AM";
													$mntt = "00AM";
												} 
												else 
												{
													$minute = $minute . "PM";
													$mntt = "00PM";
												}
												
												$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['dayy']) . '"' . ' AND month =' . '"' . intval($_REQUEST['month']) . '"' . ' AND year =' . '"' . intval($_REQUEST['year']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['empid']) . '"');
												$btime = explode(':', $blktime);
												$blkktime = $btime[0] . ":" . $btime[1];
												
												if ($booking == 0 && $blktime == "" ) 
												{
													
													if ($gap >= $tottim) 
													{
														?>
														<option value="<?php echo  ($hour < 10 ? "0".$hour : $hour) . ":" . ($mintemp1 < 30 ? "0".$mintemp1 : $mintemp1); ?>"><?php echo  ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($mintemp1 < 30 ? $mntt : $minute)  ?></option>
														<?php				
													} 

												} 
												
												$minute += 30;
												$time++;
												$i++;
												$minute_started = true;
												if ($minute > 30) 
												{
													$minute = 0;
													$hour++;
												}
												if ($gap_minute > 30) 
												{
													$gap_minute = 0;
													$gap_hour++;
												}
											}
										}
									}
								}
								if ($minute < $day_time -> start_minute && $minute_started == false) 
								{
								} 
								else 
								{
									if ($hour == $day_time -> end_hour && $minute > $day_time -> end_minute) 
									{
										break 4;
									}
									if ($i < $time_intervals) 
									{
										if ($minute > 30) 
										{
											$hour++;
											$minute = 0;
										}
										if ($gap_minute > 30) {
											$gap_hour++;
											$gap_minute = 0;
										}
										$hourcheck = $hour;
										$mincheck = $minute;
										$mintemp1 = $minute;
										if ($hourcheck > 12) 
										{
											$hourcheck = $hour - 12;
										}
										if ($hour < 12) 
										{
											$minute = $minute . "AM";
											$mntt = "00AM";
										} 
										else 
										{
											$minute = $minute . "PM";
											$mntt = "00PM";
										}
										$tempHrVar = $hour < 10 ? "0".$hour : $hour;
										$tempMinVar = $mincheck < 30 ? "0".$mincheck : $mincheck;
										if($tempHrVar == $hr && $tempMinVar == $mns && $bookedcheck == "false")
										{
											?>
											<option selected="selected" value="<?php echo  ($hour < 10 ? "0".$hour : $hour) . ":" . ($mintemp1 < 30 ?  "0".$mintemp1 : $mintemp1); ?>"><?php echo  ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($mintemp1 < 30 ? $mntt : $minute)  ?></option>
											<?php
										}
										$minute += 30;
										$time++;
										$gap_minute += 30;
										$minute_started = true;
									}
								}
							}
						}
					}
				}
					
							$tempEnd = $day_time -> end_hour * 60 +  $day_time -> end_minute;
							$tempStart = $hour * 60 + $minute;
							if ($tempStart <= $tempEnd) 
							{
					$bookinggg = 0;
					$blktm = $hour . ":" . $minute . ":00";
					if ($minute > 30) 
					{
						$hour++;
						$minute = 0;
					}
					$tm = $hour . ":" . $minute;
					$hrs = $hour;
					$mins = $minute;
				
					if ($hour == "") 
					{
						$bookinggg = -1;
					} 
					else 
					{
						for ($intervl = 1; $intervl <= $serinterval; $intervl++) 
						{
							if ($mins > 30) 
							{
								$mins = 0;
								$hrs++;
							}
							if ($hrs <= $day_time -> end_hour) 
							{
								
								$bookinggg = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['dayy']) . '"' . ' AND hour =' . '"' . $hrs . '"' . ' AND minute =' . '"' . $mins . '"' . ' AND month =' . '"' . intval($_REQUEST['month']) . '"' . ' AND year =' . '"' . intval($_REQUEST['year']) . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['empid']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
							
								$mins = $mins + 30;
								if ($bookinggg > 0) 
								{
									break;
								}
							}
							else 
							{
								$bookinggg = 1;
								break;
							}
						}
					}
					
					
					$hourcheck = $hour;
					$mincheck = $minute;
					$mintemp1 = $minute;
					if ($hourcheck > 12) 
					{
					
						$hourcheck = $hour - 12;
						
					}
					if ($hour < 12) 
					{
						$minute = $minute . "AM";
						$mntt = "00AM";
					} 
					else 
					{
						$minute = $minute . "PM";
						$mntt = "00PM";
					}
					$dattimeee = $wpdb->get_var('SELECT count(day) FROM ' . $wpdb->prefix . sm_block_date . ' WHERE day = ' . '"' . intval($_REQUEST['dayy']) . '"' . ' AND month =' . '"' . intval($_REQUEST['month']) . '"' . ' AND year =' . '"' . intval($_REQUEST['year']) . '"'. ' AND emp_id =' . '"' . intval($_REQUEST['empid']) . '"');
					$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['dayy']) . '"' . ' AND month =' . '"' . intval($_REQUEST['month']) . '"' . ' AND year =' . '"' . intval($_REQUEST['year']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['empid']) . '"');
					if($bookinggg == 0 && $blktime == "") 
					{
						
						
						?>
						<option value="<?php echo  ($hour < 10 ? "0".$hour : $hour) . ":" . ($mintemp1 < 30 ?  "0".$mintemp1 : $mintemp1); ?>"><?php echo  ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($mintemp1 < 30 ? $mntt : $minute)  ?></option>
						<?php
						
						
					} 
					$time++;
					$minute_started = true;
					$serinterval--;
				}

			}
		}
			
			?>
			</select>
			<?php
		}
	}
		?>
		<input type="hidden" value="<?php echo $time1; ?>" id="strthrrr" />
		
		<?php
}
?>
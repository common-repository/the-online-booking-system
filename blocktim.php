<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' ); 

$url = plugins_url('', __FILE__) . "/"; 
if(isset($_REQUEST['emp_idd'])) 
{
	    $val = intval($_POST['empnam']);
		$month = intval($_POST['cmonth']);
		$day = intval($_POST['cday']);
		$year = intval($_POST['cyear']);
	    emptimings($val,$day,$month,$year);
}
function  emptimings($val,$day,$month,$year)
{     global $wpdb;
		$dattimeee = $wpdb->get_var('SELECT count(day) FROM ' . $wpdb->prefix . sm_block_date . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"'. ' AND emp_id =' . '"' . $val . '"');
		 if($dattimeee>0)
		 {
			echo "daytimeblock";
		 }
		else
		{
			if(!empty($day))
			{
				$selected_day = date('D',mktime(0,0,0,$month,$day,$year));
				$day_time = $wpdb->get_row
				(
						$wpdb->prepare
						(
								"SELECT * FROM ".$wpdb->prefix."sm_timings WHERE day = %s  AND emp_id = %d",
								$selected_day,
								$val
						)
				);
			}
		?>
	<li>	
	<label> Block Time :</label>
	<div  class="form_input" style="width: 70%">
    <select id="strtblocktime" multiple='multiple' style="width:100px;margin-top:10px;height:65px;" >
		<?php
		$minformat  =  $wpdb->get_var('SELECT minuteformat  FROM ' . $wpdb->prefix . sm_settings . ' where id = 1');
		if($minformat==1)
		{
			$timefrt = $wpdb -> get_var('SELECT TimeFormat   FROM ' . $wpdb -> prefix . sm_settings);
			if($timefrt == "0") 
			{
				$booked = $wpdb->get_results
				(
						$wpdb->prepare
						(
								"SELECT service_id, day, month, year, hour, minute, emp_id FROM ".$wpdb->prefix."sm_bookings WHERE day = %d AND month = %d AND year = %d AND emp_id = %d AND status != %s",
								intval($_REQUEST['cday']),
								intval($_REQUEST['cmonth']),
								intval($_REQUEST['cyear']),
								intval($_REQUEST['emp_idd']),
								"Disapproved"
						)
				);
		
    					
				for ($hour = $day_time -> start_hour; $hour <= $day_time -> end_hour; $hour++) 
				{
					for ($minute = 0; $minute <= 45; $minute += 15) 
					{
						for ($matched = 0; $matched <= count($booked); $matched++) 
						{
							if ($hour == $booked[$matched] -> hour && $minute == $booked[$matched] -> minute) 
							{
								$serid = $cservice;
								$table_name = $wpdb -> prefix . "sm_services_time";
								$serhours = $wpdb -> get_var('SELECT hours FROM ' . $table_name . ' WHERE service_id = ' . '"' . $booked[$matched] -> service_id . '"');
								$sermins = $wpdb -> get_var('SELECT minutes FROM ' . $table_name . ' WHERE service_id = ' . '"' . $booked[$matched] -> service_id . '"');
						
								if ($sermins > 0 && $sermins <= 15) 
								{
									$sermins = 15;
								}
								else if ($sermins > 15 && $sermins <= 30) 
								{
									$sermins = 30;
								}
								else if ($sermins > 30 && $sermins <= 45) 
								{
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
								for ($i = 0; $i < $time_intervals; $i++) 
								{
									if ($minute > 45) 
									{
										$hour++;
										$minute = 0;
									}
									if ($gap_minute > 45)
									{
										$gap_hour++;
										$gap_minute = 0;
									}
									$tempEnd = $day_time -> end_hour * 60 +  $day_time -> end_minute;
							
									$tempStart = $hour * 60 + $minute;
							
							if ($tempStart <= $tempEnd) 
							{
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
											//change variables.
												$booking = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hour . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"' . ' AND minute =' . '"' . $minute . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
												
												$hourcheck = $hour;
												$mincheck = $minute;
												$blktm = $hour . ":" . $minute . ":00";
												
												
												//change variables
												$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"');
												$btime = explode(':', $blktime);
												$blkktime = $btime[0] . ":" . $btime[1];
												if ($blktime != "") 
												{
													
												} 
												else if ($booking == 0) 
												{
													if ($gap >= $tottim) 
													{
													//option tag
													?>
														
														<option value="<?php echo  ($hourcheck < 10 ? "0".$hourcheck : $hourcheck) . ":" . ($minute < 15 ? "0" .$mntt : $minute); ?>"><?php echo  ($hourcheck < 10 ? "0".$hourcheck : $hourcheck) . ":" . ($minute < 15 ? "0" .$mntt : $minute); ?></option>
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
							//change 
								$bookinggg = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hrs . '"' . ' AND minute =' . '"' . $mins . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');

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
					
					
					//change
					$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . $val . '"');
					
					if ($blktime == "" && $bookinggg == 0) 
					{
					?>
						<option value="<?php echo  ($hourcheck < 10 ? "0".$hourcheck : $hourcheck) . ":" . ($minute < 15 ? "00" .$mntt : $minute); ?>"><?php echo  ($hourcheck < 10 ? "0".$hourcheck : $hourcheck) . ":" . ($minute < 15 ? "00" .$mntt : $minute); ?></option>
						<?php
					} 
					$time++;
					$minute_started = true;
					$serinterval--;
				}

			}
		}
		}
		else //time format else
		{
			$booked = $wpdb->get_results
			(
					$wpdb->prepare
					(
							"SELECT service_id, day, month, year, hour, minute, emp_id FROM ".$wpdb->prefix."sm_bookings WHERE day = %d AND month = %d AND year = %d AND emp_id = %d AND status != %s",
							intval($_REQUEST['cday']),
							intval($_REQUEST['cmonth']),
							intval($_REQUEST['cyear']),
							intval($_REQUEST['emp_idd']),
							"Disapproved"
					)
			);
			for ($hour = $day_time -> start_hour; $hour <= $day_time -> end_hour; $hour++) {
			for ($minute = 0; $minute <= 45; $minute += 15) {
				for ($matched = 0; $matched <= count($booked); $matched++) {
					if ($hour == $booked[$matched] -> hour && $minute == $booked[$matched] -> minute) {
						$serid = $cservice;
						$table_name = $wpdb -> prefix . "sm_services_time";
						$serhours = $wpdb -> get_var('SELECT hours FROM ' . $table_name . ' WHERE service_id = ' . '"' . $booked[$matched] -> service_id . '"');
						$sermins = $wpdb -> get_var('SELECT minutes FROM ' . $table_name . ' WHERE service_id = ' . '"' . $booked[$matched] -> service_id . '"');
						
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
											//change variables.
												$booking = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hour . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"' . ' AND minute =' . '"' . $minute . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
												
												$hourcheck = $hour;
												$mincheck = $minute;
												$blktm = $hour . ":" . $minute . ":00";
												
												if ($hourcheck > 12) 
												{
													$hourcheck = $hour - 12;

												}
												if ($hour < 12) 
												{
													$minute = $minute . " am";
													$mntt = "00 am";
												} 
												else 
												{
													$minute = $minute . " pm";
													$mntt = "00 pm";
												}
												//change variables
												$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"');
												$btime = explode(':', $blktime);
												$blkktime = $btime[0] . ":" . $btime[1];
												if ($blktime != "") 
												{
													
												} 
												else if ($booking == 0) 
												{
													if ($gap >= $tottim) 
													{
													//option tag
													?>
														
														<option value="<?php echo  ($hourcheck < 10 ? $hourcheck : $hourcheck) . ":" . ($minute < 15 ?  $mntt : $minute); ?>"><?php echo  ($hourcheck < 10 ? $hourcheck : $hourcheck) . ":" . ($minute < 15 ?  $mntt : $minute); ?></option>
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
										if ($hourcheck > 12) 
										{
											$hourcheck = $hour - 12;
										}
										if ($hour < 12) 
										{
											$minute = $minute . " am";
											$mntt = "00 am";
										} 
										else 
										{
											$minute = $minute . " pm";
											$mntt = "00 pm";
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
							//change 
								$bookinggg = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hrs . '"' . ' AND minute =' . '"' . $mins . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');

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
					
					if ($hourcheck > 12) 
					{
					
						$hourcheck = $hour - 12;
						
					}
					if ($hour < 12) 
					{
						$minute = $minute . " am";
						$mntt = "00 am";
					} 
					else 
					{
						$minute = $minute . " pm";
						$mntt = "00 pm";
					}
					//change
					$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . $val . '"');
					
					if ($blktime == "" && $bookinggg == 0) 
					{
					?>
						<option value="<?php echo  ($hourcheck < 10 ? $hourcheck : $hourcheck) . ":" . ($minute < 15 ? $mntt : $minute); ?>"><?php echo  ($hourcheck < 10 ? $hourcheck : $hourcheck) . ":" . ($minute < 15 ? $mntt : $minute); ?></option>
						<?php
					} 
					$time++;
					$minute_started = true;
					$serinterval--;
				}

			}
		}
		}
		
	}
	else // minute format
	{
	$timefrt = $wpdb -> get_var('SELECT TimeFormat   FROM ' . $wpdb -> prefix . sm_settings);
	if($timefrt == "0") 
	{
	$booked = $wpdb->get_results
	(
			$wpdb->prepare
			(
					"SELECT service_id, day, month, year, hour, minute, emp_id FROM ".$wpdb->prefix."sm_bookings WHERE day = %d AND month = %d AND year = %d AND emp_id = %d AND status != %s",
					intval($_REQUEST['cday']),
					intval($_REQUEST['cmonth']),
					intval($_REQUEST['cyear']),
					intval($_REQUEST['emp_idd']),
					"Disapproved"
			)
	);
	for ($hour = $day_time -> start_hour; $hour <= $day_time -> end_hour; $hour++) {
			for ($minute = 0; $minute <= 30; $minute += 30) {
				for ($matched = 0; $matched <= count($booked); $matched++) {
					if ($hour == $booked[$matched] -> hour && $minute == $booked[$matched] -> minute) {
						$serid = $cservice;
						$table_name = $wpdb -> prefix . "sm_services_time";
						$serhours = $wpdb -> get_var('SELECT hours FROM ' . $table_name . ' WHERE service_id = ' . '"' . $booked[$matched] -> service_id . '"');
						$sermins = $wpdb -> get_var('SELECT minutes FROM ' . $table_name . ' WHERE service_id = ' . '"' . $booked[$matched] -> service_id . '"');
						
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
											//change variables.
												$booking = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hour . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"' . ' AND minute =' . '"' . $minute . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
												
												$hourcheck = $hour;
												$mincheck = $minute;
												$blktm = $hour . ":" . $minute . ":00";
												
												
												//change variables
												$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"');
												$btime = explode(':', $blktime);
												$blkktime = $btime[0] . ":" . $btime[1];
												if ($blktime != "") 
												{
													
												} 
												else if ($booking == 0) 
												{
													if ($gap >= $tottim) 
													{
													//option tag
													?>
														
														<option value="<?php echo  ($hourcheck < 10 ? "0".$hourcheck : $hourcheck) . ":" . ($minute < 30 ? "0".$mntt : $minute); ?>"><?php echo  ($hourcheck < 10 ? "0".$hourcheck : $hourcheck) . ":" . ($minute < 30 ? "0".$mntt : $minute); ?></option>
													<?php
													} 
												
												} 
												
												$minute += 30;
												$time++;
												$i++;
												$minute_started = true;
												if ($minute > 30) {
													$minute = 0;
													$hour++;
												}
												if ($gap_minute > 30) {
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
							//change 
								$bookinggg = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hrs . '"' . ' AND minute =' . '"' . $mins . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');

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
					
					
					//change
					$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . $val . '"');
					
					if ($blktime == "" && $bookinggg == 0) 
					{
					?>
						<option value="<?php echo  ($hour < 10 ? "0".$hour : $hour) . ":" . ($minute < 30 ? "0".$minute : $minute); ?>"><?php echo  ($hour < 10 ? "0".$hour : $hour) . ":" . ($minute < 30 ? "0".$minute : $minute); ?></option>
						<?php
					} 
					$time++;
					$minute_started = true;
					$serinterval--;
				}

			}
		}
	}
	else //time format
	{
		$booked = $wpdb->get_results
		(
			$wpdb->prepare
			(
					"SELECT service_id, day, month, year, hour, minute, emp_id FROM ".$wpdb->prefix."sm_bookings WHERE day = %d AND month = %d AND year = %d AND emp_id = %d AND status != %s",
					intval($_REQUEST['cday']),
					intval($_REQUEST['cmonth']),
					intval($_REQUEST['cyear']),
					intval($_REQUEST['emp_idd']),
					"Disapproved"
			)
		);	
				
		for ($hour = $day_time -> start_hour; $hour <= $day_time -> end_hour; $hour++) {
			for ($minute = 0; $minute <= 30; $minute += 30) {
				for ($matched = 0; $matched <= count($booked); $matched++) {
					if ($hour == $booked[$matched] -> hour && $minute == $booked[$matched] -> minute) {
						$serid = $cservice;
						$table_name = $wpdb -> prefix . "sm_services_time";
						$serhours = $wpdb -> get_var('SELECT hours FROM ' . $table_name . ' WHERE service_id = ' . '"' . $booked[$matched] -> service_id . '"');
						$sermins = $wpdb -> get_var('SELECT minutes FROM ' . $table_name . ' WHERE service_id = ' . '"' . $booked[$matched] -> service_id . '"');
						
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
											//change variables.
												$booking = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hour . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"' . ' AND minute =' . '"' . $minute . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
												
												$hourcheck = $hour;
												$mincheck = $minute;
												$blktm = $hour . ":" . $minute . ":00";
												
												if ($hourcheck > 12) 
												{
													$hourcheck = $hour - 12;

												}
												if ($hour < 12) 
												{
													$minute = $minute . " am";
													$mntt = "00 am";
												} 
												else 
												{
													$minute = $minute . " pm";
													$mntt = "00 pm";
												}
												//change variables
												$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"');
												$btime = explode(':', $blktime);
												$blkktime = $btime[0] . ":" . $btime[1];
												if ($blktime != "") 
												{
													
												} 
												else if ($booking == 0) 
												{
													if ($gap >= $tottim) 
													{
													//option tag
													?>
														
														<option value="<?php echo  ($hourcheck < 10 ? $hourcheck : $hourcheck) . ":" . ($minute < 30 ? "0".$mntt : $minute); ?>"><?php echo  ($hourcheck < 10 ? $hourcheck : $hourcheck) . ":" . ($minute < 30 ? "0".$mntt : $minute); ?></option>
													<?php
													} 
												
												} 
												
												$minute += 30;
												$time++;
												$i++;
												$minute_started = true;
												if ($minute > 30) {
													$minute = 0;
													$hour++;
												}
												if ($gap_minute > 30) {
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
										if ($hourcheck > 12) 
										{
											$hourcheck = $hour - 12;
										}
										if ($hour < 12) 
										{
											$minute = $minute . " am";
											$mntt = "00 am";
										} 
										else 
										{
											$minute = $minute . " pm";
											$mntt = "00 pm";
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
							//change 
								$bookinggg = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hrs . '"' . ' AND minute =' . '"' . $mins . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND emp_id =' . '"' . intval($_REQUEST['emp_idd']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');

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
					
					if ($hourcheck > 12) 
					{
					
						$hourcheck = $hour - 12;
						
					}
					if ($hour < 12) 
					{
						$minute = $minute . " am";
						$mntt = "00 am";
					} 
					else 
					{
						$minute = $minute . " pm";
						$mntt = "00 pm";
					}
					//change
					$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . $val . '"');
					
					if ($blktime == "" && $bookinggg == 0) 
					{
					?>
						<option value="<?php echo  ($hourcheck < 10 ? $hourcheck : $hourcheck) . ":" . ($minute < 30 ? $mntt : $minute); ?>"><?php echo  ($hourcheck < 10 ?  $hourcheck : $hourcheck) . ":" . ($minute < 30 ? $mntt : $minute); ?></option>
						<?php
					} 
					$time++;
					$minute_started = true;
					$serinterval--;
				}

			}
		}
	}
}
?>
			 </select>
			 <a style="position: absolute; margin:20px 5px;padding-top:0px" onClick="moveinblocktime()" class="redishBtn button_small" href="#"><<</a>
			 <a style="position: absolute; margin:50px 5px;padding-top:0px" onClick="moveoutblocktime()"  class="greenishBtn button_small" href="#">>></a>
			<select id="addblocktime" multiple='multiple' style="width:100px;height:65px;margin-top:10px;margin-left:60px;" >
										<?php
										global $wpdb;
										$blktime = $wpdb->get_results
										(
												$wpdb->prepare
												(
														"SELECT  block_time FROM ".$wpdb->prefix."sm_block_time WHERE day = %d AND month = %d AND year = %d AND emp_id = %d order by block_time ASC",
														$day,
														$month,
														$year,
														$val
												)
										);
										$blktime = $wpdb->get_results('SELECT block_time FROM ' . $wpdb->prefix . sm_block_time . ' WHERE  day = ' . '"' . $day . '"'. ' AND month =' . '"' . $month . '"' . ' AND year =' . '"' . $year . '"'. ' AND emp_id =' . '"' . $val . '"'.' order by block_time');
										//$g = count($blktime);
										//echo "<script>alert('$blktime');</script>";
										for($i=0;$i<count($blktime);$i++)
										{
											$tim=$blktime[$i]->block_time;
											$tm=explode(":",$tim);
											$timblk=$tm[0].":".$tm[1];
											$timefrt1 = $wpdb -> get_var('SELECT TimeFormat   FROM ' . $wpdb -> prefix . sm_settings);
											if($timefrt1 == "1") 
											{
												$time_in_12_hour_format  = DATE("g:i a", STRTOTIME($timblk));
												?>
												 <option value='<?php echo $time_in_12_hour_format; ?>'><?php echo $time_in_12_hour_format; ?></option>
												<?php
											}
											else
											{
										
												?>
											
												 <option value='<?php echo $timblk; ?>'><?php echo $timblk; ?></option>
												<?php
											}
										}
										?>
										</select>
											</div>
											</li>	
											<li>
											<div>
											<a href="#" class="greyishBtn button_small" id="block_time" onclick="return save_block_time();"   name="block_time" style="margin-top: 15px;margin-left:135px;">Save Details</a>
											</div>
											</li>
								
										<?php
										}
	}
	?>
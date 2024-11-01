<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-load.php' );
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<?php
if (isset($_REQUEST['action'])) 
{
	$val = intval($_POST['empId']);
	$cservice = intval($_POST['cservice']);
	$month = intval($_POST['cmonth']);
	$day = intval($_POST['cday']);
	$year = intval($_POST['cyear']);
	emptimings($val, $day, $month, $year, $cservice);
}
else
{ 
	if (isset($_POST['years'])) 
	{
		$calendar = "";
		$val = intval($_POST['empId']);
		$month = intval($_POST['cmonth']);
		$day = intval($_POST['cday']);
		$year = intval($_POST['cyear']);
		$cservice = intval($_POST['cservice']);
		draw_calendar($month, $year, $val, $cservice);
		emptimings($val, $day, $month, $year, $cservice);
		echo $val .  $day .  $month . $year .  $cservice;
	}
	else 
	{
		
		echo draw_calendar(intval($_REQUEST['cmonth']), intval($_REQUEST['cyear']), intval($_REQUEST['empId']), intval($_POST['cservice']));
	}
}
function draw_calendar($month, $year, $val, $cservice) {

	/* draw table */
	$calendar = '<table cellpadding="0"  cellspacing="0" class="calendar-front" >';
	/* table headings */
	$headings = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
	$calendar .= '<tr class="calendar-front-row "><td class="calendar-front-day-head">' . implode('</td><td class="calendar-front-day-head">', $headings) . '</td></tr>';
	/* days and weeks vars now ... */
	$running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
	$days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
	$days_in_this_week = 1;
	$dates_array = array();
	$curr_day = date("d");
	$curr_month = date("m");
	$curr_year = date("Y");
	$print_sday = false;

	/* row for week one */
	$calendar .= '<tr class="calendar-front-row ">';
	/* print "blank" days until the first of the current week */
	for ($x = 0; $x < $running_day; $x++) :
		$calendar .= '<td class="calendar-front-day-np">&nbsp;</td>';
		$days_in_this_week++;
	endfor;
	/* keep going with days.... */
	for ($list_day = 1; $list_day <= $days_in_month; $list_day++) :
			
		if ($list_day == $curr_day && $month == $curr_month && $year == $curr_year && intval($_REQUEST['cday']) == $curr_day ) 
		{
			global $wpdb;
			$selected_day = date('D', mktime(0, 0, 0, $month, $list_day, $year));
			$dattimeee = $wpdb -> get_var('SELECT count(day) FROM ' . $wpdb -> prefix . sm_block_date . ' where month=' . $month . ' and day =' . $list_day . ' and year=' . $year . '  and emp_id= ' . $val . ' order by day ASC');
			$count = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_timings . ' WHERE day = ' . '"' . $selected_day . '"' . ' AND  emp_id =' . '"' . $val . '"' .' AND  blocked =1');
			if ($dattimeeee > 0 || $count ==0 ) 
			{
				$sel = "style=\"background-color: #f90;\"";
				$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
				$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			}
			else 
			{
			
				$sel = "style=\"background-color: #f90;\"";
				$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: white\"";
				$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			}
		}
	
		else if ($month == $curr_month && $year == $curr_year && $list_day >= $curr_day) 
		{
			global $wpdb;
			$selected_day = date('D', mktime(0, 0, 0, $month, $list_day, $year));
			$dattimeee = $wpdb -> get_var('SELECT count(day) FROM ' . $wpdb -> prefix . sm_block_date . ' where month=' . $month . ' and day =' . $list_day . ' and year=' . $year . '  and emp_id= ' . $val . ' order by day ASC');
			$count = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_timings . ' WHERE day = ' . '"' . $selected_day . '"' . ' AND  emp_id =' . '"' . $val . '"' .' AND  blocked =1');
			
			if ($count == 0) 
			{
				$sel = "style=\"cursor: default;\"";
				$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
				$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
				/* add in the day number */
			} 
			else if ($dattimeee > 0) 
			{
				$sel = "style=\"cursor: default;\"";
				$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
				$calendar .= '<div  onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			} 
			else if ($count > 0 && intval($_REQUEST['cday']) == $list_day) 
			{
			
				$sel = "style=\"background-color: #f90;\"";
				$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: white\"";
				$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			
			} 
			else 
			{
			
				
				$calendar .= '<td class="calendar-front-day">';
				$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front">' . $list_day . '</div>';
				
			}
		} 
		else if ($month == $curr_month && $year == $curr_year && $list_day < $curr_day) 
		{
			$sel = "style=\"cursor: default;\"";
			$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
			/* add in the day number */
			$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
			$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
		}
		else if ($year < $curr_year) 
		{
			$sel = "style=\"cursor: default;\"";
			$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
			/* add in the day number */
			$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
			$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';

		} 
		else if ($month < $curr_month && $year == $curr_year) 
		{
			
			$sel = "style=\"cursor: default;\"";
			$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
			/* add in the day number */
			$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
			$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
		} 
		else
		{
			global $wpdb;
			$selected_day = date('D', mktime(0, 0, 0, $month, $list_day, $year));
			$dattimeee = $wpdb -> get_var('SELECT count(day) FROM ' . $wpdb -> prefix . sm_block_date . ' where month=' . $month . ' and day =' . $list_day . ' and year=' . $year . ' and emp_id= ' . $val . ' order by day ASC');
			$count = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_timings . ' WHERE day = ' . '"' . $selected_day . '"' . ' AND  emp_id =' . '"' . $val . '"' .' AND  blocked =1');
			
			if ($count == 0) 
			{
				$sel = "style=\"cursor: default;\"";
				$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
				$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
				/* add in the day number */
			} 
			else if ($dattimeee > 0) 
			{
				$sel = "style=\"cursor: default;\"";
				$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
				$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			}
			else if ($count > 0 && intval($_REQUEST['cday']) == $list_day) 
			{
			
				$sel = "style=\"background-color: #f90;\"";
				$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: white\"";
				$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			
			}  
			else 
			{
				$calendar .= '<td class="calendar-front-day">';
				$calendar .= '<div onclick="DayClick(this);" id="day_number_' . $list_day . '" class="day-number-front">' . $list_day . '</div>';
			}
		} 
		
		/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
		//      $calendar.= str_repeat('<p>&nbsp;</p>',2);
		$calendar .= '</td>';
		if ($running_day == 6) :
			$calendar .= '</tr>';
			if (($day_counter + 1) != $days_in_month) :
				$calendar .= '<tr class="calendar-front-row ">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++;
		$running_day++;
		$day_counter++;
	endfor;
	/* finish the rest of the days in the week */
	if ($days_in_this_week < 8) :
		for ($x = 1; $x <= (8 - $days_in_this_week); $x++) :
			$calendar .= '<td class="calendar-front-day-np">&nbsp;</td>';
		endfor;
	endif;
	/* final row */
	$calendar .= '</tr>';
	/* end the table */
	$calendar .= '</table>';
	/* all done, return result */
	echo $calendar;
}

function emptimings($val, $day, $month, $year, $cservice) 
{
	global $wpdb;
	$timefrt = $wpdb -> get_var('SELECT TimeFormat   FROM ' . $wpdb -> prefix . sm_settings);
	$serid = $cservice;
	$table_name = $wpdb -> prefix . "sm_services_time";
	$serhours = $wpdb -> get_var('SELECT hours FROM ' . $table_name . ' WHERE service_id = ' . '"' . $serid . '"');
	$sermins = $wpdb -> get_var('SELECT minutes FROM ' . $table_name . ' WHERE service_id = ' . '"' . $serid . '"');
	
	if ($sermins > 0 && $sermins < 30) 
	{
		$sermins = 30;
	}
	if ($sermins > 30 && $sermins < 60) 
	{
		$sermins = 0;
		$serhours++;
	}
	if($sermins=="0")
	{
		$sermins = 0;
	}
	$Sertime = $serhours * 60 + $sermins;
	$serinterval = $Sertime / 30;

	$selected_date = $day . ", " . $month . ", " . $year;
	$time = 1;
	$booked = $wpdb->get_results
	(
			$wpdb->prepare
			(
					"SELECT service_id, day, month, year, hour, minute, emp_id FROM ".$wpdb->prefix."sm_bookings WHERE day = %d AND month = %d AND year = %d AND emp_id = %d AND status != %s",
					$day,
					$month,
					$year,
					$val,
					"Disapproved"
			)
	);
	
	if (!empty($day)) 
	{
		$selected_day = date('D', mktime(0, 0, 0, $month, $day, $year));
		$day_time = $wpdb->get_row
		(
				$wpdb->prepare
				(
						"SELECT * FROM ".$wpdb->prefix."sm_timings WHERE day = %s  AND emp_id = %d",
						$selected_day,
						$val
				)
		);
		
		$count = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_timings . ' WHERE day = ' . '"' . $selected_day . '"' . ' AND  emp_id =' . '"' . $val . '"' .' AND  blocked =1');
	}
	$dattimeee = $wpdb -> get_var('SELECT count(day) FROM ' . $wpdb -> prefix . sm_block_date . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND emp_id =' . '"' . $val . '"');
	$minute_started = false;
	if ($dattimeee > 0 || $count == 0) 
	{
		echo " <div style='text-align:center;font-size:12px;font-solid;float:left;padding:80px;'>Bookings are not available for this date.</div>";
	}
	else if ($timefrt == "0") 
	{
		for ($hour = $day_time -> start_hour; $hour <= $day_time -> end_hour; $hour++) 
		{
			for ($minute = 0; $minute <= 45; $minute += 15) 
			{
				for ($matched = 0; $matched <= count($booked); $matched++) 
				{
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
												$blktm = $hour . ":" . $minute . ":00";
												$booking = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hour . '"' . ' AND emp_id =' . '"' . $val . '"' . ' AND minute =' . '"' . $minute . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
												$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . $day . '"' . ' AND month =' . '"' . $month . '"' . ' AND year =' . '"' . $year . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . $val . '"');
												if ($blktime != "") 
												{
													echo "<a class=\"hourschoice_res1 \" rel=\"1\"  href='#' onclick='TimeClick(this);'>" . ($hour < 10 ? "0" . $hour : $hour) . ":" . ($minute < 15 ? "0" . $minute : $minute) . "</a>";
												}
												else if ($booking == 0) 
												{
													if ($gap >= $tottim) 
													{
														echo "<a class=\"hourschoice_res \" rel=\"1\" id=\"time_$time\" href='#' onclick='TimeClick(this);'>" . ($hour < 10 ? "0" . $hour : $hour) . ":" . ($minute < 15 ? "00" : $minute) . "</a>";
													}
													else 
													{
														echo "<a class=\"hourschoice_res1 \" rel=\"1\" href='#' onclick='TimeClick(this);'>" . ($hour < 10 ? "0" . $hour : $hour) . ":" . ($minute < 15 ? "0" . $minute : $minute) . "</a>";
													}
												}
												else 
												{
													echo "<a class=\"hourschoice_res1 \" rel=\"1\"  href='#' onclick='TimeClick(this);'>" . ($hour < 10 ? "0" . $hour : $hour) . ":" . ($minute < 15 ? "0" . $minute : $minute) . "</a>";
												}
												$minute += 15;
												$time++;
												$i++;
												$minute_started = true;
												if ($minute > 45) 
												{
													$minute = 0;
													$hour++;
												}
												if ($gap_minute > 45) 
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
										if ($minute > 45) {
											$hour++;
											$minute = 0;
										}
										if ($gap_minute > 45) {
											$gap_hour++;
											$gap_minute = 0;
										}
										echo "<a class=\"hourschoice_res1 \" rel=\"1\"  href='#' onclick='TimeClick(this);'>" . ($hour < 10 ? "0" . $hour : $hour) . ":" . ($minute < 15 ? "0" . $minute : $minute) . "</a>";
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
							if ($tempStart <= $tempEnd) {
					$bookinggg = 0;
					if ($minute > 45) {
						$hour++;
						$minute = 0;
					}
					$hrs = $hour;
					$mins = $minute;
					if ($hour == "") {
						$bookinggg = -1;
					} else {
						for ($intervl = 1; $intervl <= $serinterval; $intervl++) {
							if ($mins > 45) {
								$mins = 0;
								$hrs++;
							}
							if ($hrs <= $day_time -> end_hour) {
								$bookinggg = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hrs . '"' . ' AND minute =' . '"' . $mins . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND emp_id =' . '"' . $val . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
								$mins = $mins + 15;
								if ($bookinggg > 0) {
									break;
								}
							} else {
								$bookinggg = 1;
								break;
							}
						}
					}
					$blktm = $hour . ":" . $minute . ":00";
					$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . $val . '"');

					if ($blktime != "") 
					{
						echo "<a class=\"hourschoice_res1 \" rel=\"1\"  href='#' onclick='TimeClick(this);'>" . ($hour < 10 ? "0" . $hour : $hour) . ":" . ($minute < 15 ? "0" . $minute : $minute) . "</a>";
					} 
					else if ($bookinggg > 0) 
					{
						echo "<a class=\"hourschoice_res1 \" rel=\"1\"  href='#' onclick='TimeClick(this);'>" . ($hour < 10 ? "0" . $hour : $hour) . ":" . ($minute < 15 ? "00" : $minute) . "</a>";
					} 
					else if ($bookinggg == 0) 
					{
						echo "<a class=\"hourschoice_res \" rel=\"1\" id=\"time_$time\" href='#' onclick='TimeClick(this);'>" . ($hour < 10 ? "0" . $hour : $hour) . ":" . ($minute < 15 ? "00" : $minute) . "</a>";
					} 
					else 
					{
						echo "<div style='text-align:center;font-size:12px;font-solid;float:left;padding:80px'>Bookings are not available for this date.</div>";
						break;
					}
					$time++;
					$minute_started = true;
					$serinterval--;
				}
			}
		}
	} 
	else if ($timefrt == "1") 
	{
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
											
												$booking = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hour . '"' . ' AND emp_id =' . '"' . $val . '"' . ' AND minute =' . '"' . $minute . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
												
												$hourcheck = $hour;
												$mincheck = $minute;
												$blktm = $hour . ":" . $minute . ":00";
												
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
												
												$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . $val . '"');
												$btime = explode(':', $blktime);
												$blkktime = $btime[0] . ":" . $btime[1];
												if ($blktime != "") 
												{
													echo "<a class=\"hourschoice_res1 \" rel=\"1\"  href='#' onclick='TimeClick(this);'>" . ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($minute < 15 ? $mntt : $minute) . "</a>";
												} 
												else if ($booking == 0) 
												{
													if ($gap >= $tottim) 
													{
														echo "<a class=\"hourschoice_res \" rel=\"1\" id=\"time_$time\" href='#' onclick='TimeClick(this);'>" . ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($minute < 15 ? $mntt : $minute) . "</a>";
													} 
													else 
													{
														echo "<a class=\"hourschoice_res1 \" rel=\"1\"  href='#' onclick='TimeClick(this);'>" . ($hour < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($minute < 15 ? $mntt : $minute) . "</a>";
													}
												} 
												else
												{
													echo "<a class=\"hourschoice_res1 \" rel=\"1\"  href='#' onclick='TimeClick(this);'>" . ($hour < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($minute < 15 ? $mntt : $minute) . "</a>";
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
											$minute = $minute . "AM";
											$mntt = "00AM";
										} 
										else 
										{
											$minute = $minute . "PM";
											$mntt = "00PM";
										}

										echo "<a class=\"hourschoice_res1 \" rel=\"1\"  href='#' onclick='TimeClick(this);'>" . ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($minute < 15 ? $mntt : $minute) . "</a>";
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
								$bookinggg = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND hour =' . '"' . $hrs . '"' . ' AND minute =' . '"' . $mins . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND emp_id =' . '"' . $val . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');

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
						$minute = $minute . "AM";
						$mntt = "00AM";
					} 
					else 
					{
						$minute = $minute . "PM";
						$mntt = "00PM";
					}
					
					$blktime = $wpdb -> get_var('SELECT block_time FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . intval($_REQUEST['cday']) . '"' . ' AND month =' . '"' . intval($_REQUEST['cmonth']) . '"' . ' AND year =' . '"' . intval($_REQUEST['cyear']) . '"' . ' AND block_time =' . '"' . $blktm . '"' . ' AND emp_id =' . '"' . $val . '"');
					
					if ($blktime != "") {
						echo "<a class=\"hourschoice_res1 \" rel=\"1\"  href='#' onclick='TimeClick(this);'>" . ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($minute < 15 ? $mntt : $minute) . "</a>";
					} else if ($bookinggg > 0) {
						echo "<a class=\"hourschoice_res1 \" rel=\"1\"  href='#' onclick='TimeClick(this);'>" . ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($minute < 15 ? $mntt : $minute) . "</a>";
					} else if ($bookinggg == 0) {
						echo "<a class=\"hourschoice_res \" rel=\"1\" id=\"time_$time\" href='#' onclick='TimeClick(this);'>" . ($hourcheck < 10 ? "0" . $hourcheck : $hourcheck) . ":" . ($minute < 15 ? $mntt : $minute) . "</a>";
					} else {
						echo " <div style='text-align:center;font-size:12px;font-solid;float:left;padding:80px'>Bookings are not available for this date.</div>";
						break;
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
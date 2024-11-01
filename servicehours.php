<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;


$shrs = esc_html($_REQUEST['booktime']);
$serid = intval($_REQUEST['serv']);
$empid = intval($_REQUEST['emp']);
$day = intval($_REQUEST['cday']);
$month = intval($_REQUEST['cmonth']);
$year = intval($_REQUEST['cyear']);
//SELECT HOURS AND MINUTES FROM SERVICE TIMEING TABLE ON THE BASIS OF SERVICE ID
$table_name = $wpdb -> prefix . "sm_services_time";
$serhours = $wpdb -> get_var('SELECT hours FROM ' . $table_name . ' WHERE service_id = ' . '"' . $serid . '"');
$sermins = $wpdb -> get_var('SELECT minutes FROM ' . $table_name . ' WHERE service_id = ' . '"' . $serid . '"');
$serInterval = ($serhours * 60 + $sermins) / 15 ;
$time = $shrs;
$tcheck = (str_split($time,5));
$time = explode(':', $time);
$tmin = (str_split($time[1],2));
//SELECT THE TIME FORMAT OF THE PLUGIN
$table_name = $wpdb -> prefix . "sm_settings";
$timeformat = $wpdb -> get_var('SELECT TimeFormat FROM ' . $table_name);
if($timeformat==1)
{
	if($tcheck[1] == "AM")
	{
			$hour = $time[0];
			$timemin = explode('AM', $time[1]);
	}
	else if($tcheck[1] == "PM" && $time[0] !=12)
	{
			$hour = $time[0] + 12;
			$timemin = explode('PM', $time[1]);
	}
	else
	{
			$hour = $time[0];
			$timemin = explode('PM', $time[1]);
	}						
}
else
{
	$hour = $time[0];
	$timemin = $time[1];
}					
$hourr = $hour + $serhours;
$minn = $timemin[0] + $sermins;
if($minn==60)
{
	$hourr++;
	$minn=0;
}

$totaltime = $hourr * 60 + $minn;
$weekday = date("D", mktime(0,0,0,$month,$day,$year));
// SELECT THE END HOUR AND END MINUTE FROM THE SM_TIMEING TABLE ON BASIS OF THE EMPLOYEE ID
$table_name = $wpdb -> prefix . "sm_timings";
$endhr = $wpdb -> get_var('SELECT end_hour FROM ' . $table_name . ' WHERE emp_id = ' . '"' . $empid . '"' . ' and day =' . '"' . $weekday . '"' );
$endmin = $wpdb -> get_var('SELECT end_minute FROM ' . $table_name . ' WHERE emp_id = ' . '"' . $empid . '"' . ' and day =' . '"' . $weekday . '"' );
$totalendtime = $endhr * 60 + $endmin;
$flag = 0;
for($loop = 0; $loop<$serInterval;$loop++)
{
	if($loop == 0)
	{
			$tempCheck = $hour;
			$tempCheck1 = $timemin[0];
	}
	else
	{
			$tempCheck1 = $tempCheck1 + 15;
								
	}
	if($tempCheck1 > 45)
	{
			$tempCheck = $tempCheck + 1;
			$tempCheck1 = 0;
	}
	// COUNT THE BOOKING ON A PARTICULAR DATE FROM THE BOOKING TABLE 						
	$booked = $wpdb -> get_var('SELECT count(service_id) FROM ' . $wpdb -> prefix . sm_bookings . ' WHERE day = ' . '"' . $day . '"' . ' AND hour =' . '"' . $tempCheck . '"' . ' AND minute =' . '"' . $tempCheck1 . '"' . ' AND month =' . '"' . $month . '"' . ' AND year =' . '"' . $year . '"' . ' AND emp_id =' . '"' . $empid . '"' . ' AND status !=' . '"' . "Disapproved" . '"' . ' order by hour,minute ASC');
	// COUNT THE BLOCK TIME ON A PARTICULAR DATE FROM THE BLOCK_TIME TABLE 	
	$blktime = $wpdb -> get_var('SELECT count(block_time) FROM ' . $wpdb -> prefix . sm_block_time . ' WHERE  day = ' . '"' . $day . '"' . ' AND month =' . '"' . $month . '"' . ' AND year =' . '"' . $year . '"' . ' AND hour =' . '"' . $tempCheck . '"' . ' AND minute =' . '"' . $tempCheck1 . '"' . ' AND emp_id =' . '"' . $empid . '"');
							
	if($booked > 0 || $blktime > 0)
	{
		if($tempCheck == $hour && $tempCheck1 == $timemin[0] )
		{
				$flag = 0;
				break;
		}
		else
		{
				$flag = 1;
				break;
		}
	}
								
}
					
if($totaltime > $totalendtime)
{
		echo trim('0');
}
else if($flag == 1)
{
		echo trim('2');
}
else 
{
		echo trim('1');
}
?>
<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-load.php' );
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' ); 
global $wpdb;
$url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<?php
$val = intval($_POST['empnam']);
if(isset($_REQUEST['cmonth']))
{
		$month=intval($_REQUEST['cmonth']);
		$year =intval($_REQUEST['cyear']);
}
if(isset($_REQUEST['sday']))
{
		$day=esc_attr($_REQUEST['sday']);
}
if(!isset($_REQUEST['cmonth']) && !isset($_REQUEST['cyear']))
{
		 $day = date("d");
		 $month = date("m");
         $year = date("Y");
}
$calendar = '<table cellpadding="0"   cellspacing="0" class="calendar-front">';
/* table headings */
$headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
$calendar.= '<tr class="calendar-front-row"><td class="calendar-front-day-head">'.implode('</td><td class="calendar-front-day-head">',$headings).'</td></tr>';
/* days and weeks vars now ... */
$running_day = date('w',mktime(0,0,0,$month,1,$year));
$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
$days_in_this_week = 1;
$day_counter = 0;
$dates_array = array();
$curr_day = date("d");
$curr_month = date("m");
$curr_year = date("Y");
$print_sday = false;
/* row for week one */
$calendar.= '<tr class="calendar-front-row ">';
/* print "blank" days until the first of the current week */
for($x = 0; $x < $running_day; $x++):
	$calendar.= '<td class="calendar-front-day-np">&nbsp;</td>';
    $days_in_this_week++;
endfor;
/* keep going with days.... */
for($list_day = 1; $list_day <= $days_in_month; $list_day++):
			$selected_day = date('D', mktime(0, 0, 0, $month, $list_day, $year));
			$dattimeee = $wpdb-> get_var('SELECT count(day) FROM ' . $wpdb -> prefix . sm_block_date . ' where month=' . $month . ' and day =' . $list_day . ' and year=' . $year . '  and emp_id= ' . $val . ' order by day ASC');
			$count = $wpdb-> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_timings . ' WHERE day = ' . '"' . $selected_day . '"' . ' AND  emp_id =' . '"' . $val . '"' .' AND  blocked =1');
				
	if($list_day == $curr_day && $month == $curr_month && $year == $curr_year  && intval($_REQUEST['cday']) == $curr_day)
	{
		if ($dattimeeee > 0) 
		{
				$sel = "style=\"background-color: black;\"";
				$calendar.= '<td id="day_tdidblk_'.$list_day.'" class="calendar-front-day" '.$sel.'>';
                /* add in the day number */
                $sel = "style=\"color: white;\"";
                $calendar.= '<div onclick="BlockDay(this)" id="day_number_block_'. $list_day .'" class="day-number-front" '.$sel.'>'.$list_day. '</div>';
		 }
		 else
		 {
				$sel = "style=\"background-color: #f90;\"";
				$calendar.= '<td id="day_tdid_'.$list_day.'" class="calendar-front-day" '.$sel.'>';
                /* add in the day number */
                $sel = "";
                $calendar.= '<div onclick="BlockDay(this)" id="day_number_block_'. $list_day .'" class="day-number-front" '.$sel.'>'.$list_day. '</div>';
		 }
	}
	else if ($month == $curr_month && $year == $curr_year && $list_day >= $curr_day) 
	{
			If ($count == 0) 
			{
				$sel = "style=\"cursor: default;\"";
				$calendar .= '<td id="day_tdid_'.$list_day.'" class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
				$calendar .= '<div  onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
				/* add in the day number */
			} 
			else if ($dattimeee > 0) 
			{
	
				 $sel = "style=\"cursor: pointer;border-style:1px solid;border-right-color:green !important;background-color: black;\"";
                    $calendar.= '<td id="day_tdidblk_'.$list_day.'" class="calendar-front-day" '.$sel.' style="background-color:black;">';
				/* add in the day number */
				$sel = "style=\"color: #DEDEDE;\"";
				$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			} 
			else if ($count > 0 && intval($_REQUEST['cday']) == $list_day) 
			{
			
				$sel = "style=\"background-color: #f90;\"";
				$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: white\"";
				$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			} 
			else 
			{
			
				$calendar .= '<td id="day_tdid_'.$list_day.'" class="calendar-front-day">';
				$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front">' . $list_day . '</div>';
			}
	}
    else if ($month == $curr_month && $year == $curr_year && $list_day < $curr_day) 
	{
         	If ($count == 0) 
			{
				$sel = "style=\"cursor: default;\"";
				$calendar .= '<td id="day_tdid_'.$list_day.'" class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
				$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
				/* add in the day number */
			} 
			else if ($dattimeee > 0) 
			{
				$sel = "style=\"background-color: black;\"";
				$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
				$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			} 
			else 
			{
				$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
				$calendar .= '<td class="calendar-front-day">';
				$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			}
	}
	else if ($year < $curr_year) 
	{
			$sel = "style=\"cursor: default;\"";
			$calendar .= '<td id="day_tdid_'.$list_day.'" class="calendar-front-day" ' . $sel . '>';
			/* add in the day number */
			$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
			$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';

	} 
	else if ($month < $curr_month && $year == $curr_year) 
	{
			
			$sel = "style=\"cursor: default;\"";
			$calendar .= '<td  id="day_tdid_'.$list_day.'" class="calendar-front-day" ' . $sel . '>';
			/* add in the day number */
			$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
			$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
	}
	else
	{
			$selected_day = date('D', mktime(0, 0, 0, $month, $list_day, $year));
			$dattimeee = $wpdb -> get_var('SELECT count(day) FROM ' . $wpdb -> prefix . sm_block_date . ' where month=' . $month . ' and day =' . $list_day . ' and year=' . $year . ' and emp_id= ' . $val . ' order by day ASC');
			$count = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_timings . ' WHERE day = ' . '"' . $selected_day . '"' . ' AND  emp_id =' . '"' . $val . '"' .' AND  blocked =1');
			if ($count == 0) 
			{
				$sel = "style=\"cursor: default;\"";
				$calendar .= '<td id="day_tdid_'.$list_day.'" class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
				$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
				/* add in the day number */
			} 
			else if ($dattimeee > 0) 
			{
				$sel = "style=\"background-color: black;\"";
				$calendar .= '<td class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: #DEDEDE; text-decoration: line-through;\"";
				$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			}
			else if ($count > 0 && intval($_REQUEST['cday']) == $list_day) 
			{
			
				$sel = "style=\"background-color: #f90;\"";
				$calendar .= '<td id="day_tdid_'.$list_day.'" class="calendar-front-day" ' . $sel . '>';
				/* add in the day number */
				$sel = "style=\"color: white\"";
				$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front" ' . $sel . '>' . $list_day . '</div>';
			
			}  
			else 
			{
				$calendar .= '<td id="day_tdid_'.$list_day.'" class="calendar-front-day">';
				$calendar .= '<div onclick="BlockDay(this)" id="day_number_block_' . $list_day . '" class="day-number-front">' . $list_day . '</div>';
			}
	} 
	// }
    /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
    //      $calendar.= str_repeat('<p>&nbsp;</p>',2);
    $calendar.= '</td>';
    if($running_day == 6):
    	$calendar.= '</tr>';
	    if(($day_counter+1) != $days_in_month):
	    	$calendar.= '<tr class="calendar-front-row ">';
	    endif;
	    $running_day = -1;
	    $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
endfor;
/* finish the rest of the days in the week */
if($days_in_this_week < 8):
	for($x = 1; $x <= (8 - $days_in_this_week); $x++):
    	$calendar.= '<td class="calendar-front-day-np">&nbsp;</td>';
    endfor;
endif;
/* final row */
$calendar.= '</tr>';
/* end the table */
$calendar.= '</table>';
/* all done, return result */
echo $calendar;	
?>
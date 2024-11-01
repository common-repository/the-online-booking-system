<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
 global $wpdb;
 $url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<?php
 if(isset($_REQUEST['empid']))
 {
 	if($_REQUEST['empid']!=0 && $_REQUEST['empid']!="ALL")
 	{
 				$emp_id = intval($_REQUEST['empid']);
				// SELECT TIMING OF SUNDAY FROM TIMINGS TABLE 
				$sun_timings = $wpdb->get_row
 				(
      				$wpdb->prepare
        			(
           					"SELECT * FROM ".$wpdb->prefix."sm_timings WHERE day = %s and emp_id = %d",
           					"sun",
           					$emp_id
        			)
 				);
				// SELECT TIMING OF MONDAY FROM TIMINGS TABLE 
				$mon_timings = $wpdb->get_row
 				(
      				$wpdb->prepare
        			(
           					"SELECT * FROM ".$wpdb->prefix."sm_timings WHERE day = %s and emp_id = %d",
           					"Mon",
           					$emp_id
        			)
 				);	
				// SELECT TIMING OF TUESDAY FROM TIMINGS TABLE 
				$tue_timings = $wpdb->get_row
 				(
      				$wpdb->prepare
        			(
           					"SELECT * FROM ".$wpdb->prefix."sm_timings WHERE day = %s and emp_id = %d",
           					"Tue",
           					$emp_id
        			)
 				);	
				// SELECT TIMING OF WEDNESDAY FROM TIMINGS TABLE 
				$wed_timings = $wpdb->get_row
 				(
      				$wpdb->prepare
        			(
           					"SELECT * FROM ".$wpdb->prefix."sm_timings WHERE day = %s and emp_id = %d",
           					"Wed",
           					$emp_id
        			)
 				);	
				// SELECT TIMING OF THURSDAY FROM TIMINGS TABLE 
				$thu_timings = $wpdb->get_row
 				(
      				$wpdb->prepare
        			(
           					"SELECT * FROM ".$wpdb->prefix."sm_timings WHERE day = %s and emp_id = %d",
           					"Thu",
           					$emp_id
        			)
 				);	
				// SELECT TIMING OF FRIDAY FROM TIMINGS TABLE 
				$fri_timings = $wpdb->get_row
 				(
      				$wpdb->prepare
        			(
           					"SELECT * FROM ".$wpdb->prefix."sm_timings WHERE day = %s and emp_id = %d",
           					"Fri",
           					$emp_id
        			)
 				);	
				// SELECT TIMING OF SATURDAY FROM TIMINGS TABLE 
				$sat_timings = $wpdb->get_row
 				(
      				$wpdb->prepare
        			(
           					"SELECT * FROM ".$wpdb->prefix."sm_timings WHERE day = %s and emp_id = %d",
           					"Sat",
           					$emp_id
        			)
 				);	
				
				$sundayend=$sun_timings->end_hour;
			    $sunendmins=$sun_timings->end_minute;
				$sunstart=$sun_timings->start_hour;
				$sunstartmins=$sun_timings->start_minute;
				
				$mondayend=$mon_timings->end_hour;
				$mondayendmins=$mon_timings->end_minute;
				$monstart=$mon_timings->start_hour;
			    $monstartmins=$mon_timings->start_minute;
				
				$tuesdayend=$tue_timings->end_hour;
				$tuesdayendmins=$tue_timings->end_minute;
				$tuesstart=$tue_timings->start_hour;
				$tuesstartmins=$tue_timings->start_minute;
			
				$weddayend=$wed_timings->end_hour;
				$weddayendmins=$wed_timings->end_minute;
				$wedstart=$wed_timings->start_hour;
				$wedstartmins=$wed_timings->start_minute;
				
			    $thudayend=$thu_timings->end_hour;
				$thudayendmins=$thu_timings->end_minute;
				$thustart=$thu_timings->start_hour;
				$thustartmins=$thu_timings->start_minute;
				
				$fridayend=$fri_timings->end_hour;
				$fridayendmins=$fri_timings->end_minute;
				$fristart=$fri_timings->start_hour;
				$fristartmins=$fri_timings->start_minute;
				
				$satdayend=$sat_timings->end_hour;
				$satdayendmins=$sat_timings->end_minute;
				$satstart=$sat_timings->start_hour;
			    $satstartmins=$sat_timings->start_minute;
?>
		 	    <input type="hidden" id="sundayend" value="<?php echo $sundayend ?>" />
		        <input type="hidden" id="sunendmins" value="<?php echo $sunendmins ?>" />
		        <input type="hidden" id="sundaystart" value="<?php echo $sunstart ?>" />
		        <input type="hidden" id="sunstartmins" value="<?php echo $sunstartmins ?>" />
			
		        <input type="hidden" id="monend" value="<?php echo $mondayend ?>" />
			    <input type="hidden" id="mondayendmins" value="<?php echo $mondayendmins ?>" />
			    <input type="hidden" id="mondayst" value="<?php echo $monstart?>" />
			    <input type="hidden" id="monstartmins" value="<?php echo $monstartmins?>" />
				
			    <input type="hidden" id="tuesdayend" value="<?php echo $tuesdayend?>" />
			    <input type="hidden" id="tuesdayendmins" value="<?php echo $tuesdayendmins?>" />
			    <input type="hidden" id="tuesdayst" value="<?php echo $tuesstart?>" />
			    <input type="hidden" id="tuesstartmins" value="<?php echo $tuesstartmins?>" />
				
			    <input type="hidden" id="weddayend" value="<?php echo $weddayend?>" />
			    <input type="hidden" id="weddayendmins" value="<?php echo $weddayendmins?>" />
			    <input type="hidden" id="wedstart" value="<?php echo $wedstart?>" />
			    <input type="hidden" id="wedstartmins" value="<?php echo $wedstartmins?>" />
			  
			    <input type="hidden" id="thudayend" value="<?php echo $thudayend?>" />
			    <input type="hidden" id="thudayendmins" value="<?php echo $thudayendmins?>" />
			    <input type="hidden" id="thustart" value="<?php echo $thustart?>" />
			    <input type="hidden" id="thustartmins" value="<?php echo $thustartmins?>" />
				
			    <input type="hidden" id="fridayend" value="<?php echo $fridayend?>" />
			    <input type="hidden" id="fridayendmins" value="<?php echo $fridayendmins?>" />
			    <input type="hidden" id="fristart" value="<?php echo $fristart?>" />
		        <input type="hidden" id="fristartmins" value="<?php echo $fristartmins?>" />
		   
		        <input type="hidden" id="satdayend" value="<?php echo $satdayend?>" />
			    <input type="hidden" id="satdayendmins" value="<?php echo $satdayendmins?>" />
			    <input type="hidden" id="satstart" value="<?php echo $satstart?>" />
		        <input type="hidden" id="satstartmins" value="<?php echo $satstartmins?>" />
<?php
	}
}
?>	
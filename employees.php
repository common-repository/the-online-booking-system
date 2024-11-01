<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;

if(isset($_REQUEST['action']))
{
	if($_REQUEST['action'] == 'AddEmployees')
	{
		$name = html_entity_decode($_REQUEST['ename']);
		$code = intval($_REQUEST['ecode']);
		$email = html_entity_decode($_REQUEST['email']);
		$phone = esc_html($_REQUEST['ephone']);
		$color = esc_attr($_REQUEST['input_field_1']);
		$status = esc_attr($_REQUEST['rad']);
		
		$em = $wpdb -> get_var("SELECT count(email) FROM " . $wpdb -> prefix . sm_employees . ' WHERE email = ' . '"' . esc_attr($_REQUEST['email']) . '"');
		if ($name != '' && $code != '' && $phone != '' && $color != '' && $em == 0) 
		{
			$wpdb->query
		        (
		                  $wpdb->prepare
		                  (
		                       "INSERT INTO ".$wpdb->prefix."sm_employees(emp_name,emp_code,email,phone,emp_color,status) VALUES( %s, %d, %s, %s, %s, %s)",
		                       $name,
		                       $code,
		                       $email,
		                       $phone,
		                       $color,
		                       $status
		                   )
		        );
		}
	}
	else if ($_REQUEST['action'] == 'UpdateEmployees')
	{
			$idd=intval($_REQUEST['id']);
			$emp = html_entity_decode($_REQUEST['empn']);
			$em = html_entity_decode($_REQUEST['em']);
			$ph=esc_html($_REQUEST['ph']);
			
			$color=esc_attr($_REQUEST['col']);
			$chk=esc_attr($_REQUEST['value']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_employees SET emp_name = %s , email = %s , phone = %s , emp_color = %s , status = %s WHERE id = %d",
	                    $emp,
	                    $em,
	                    $ph,
	                    $color,
	                    $chk,
	                   	$idd
	             )
	      	);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_bookings SET color = %s  WHERE emp_id = %d",
	                    esc_attr($_REQUEST['col']),
	                    $idd
	             )
	      	);
	}
	else if ($_REQUEST['action'] == 'deleteemployee') 
	{
			
			$bokid= $wpdb->get_var('SELECT count(id) FROM ' . $wpdb->prefix . sm_bookings . ' where emp_id ='."'". intval($_REQUEST['data']) ."'");
			$allocid= $wpdb->get_var('SELECT count(id) FROM ' . $wpdb->prefix . sm_allocate_serv . ' where emp_id ='."'". intval($_REQUEST['data']) ."'");
			if($bokid!=0)
			{
				echo "booking";
			}
			elseif($allocid!=0)
			{
				echo "allocate_service";
			}
			else
			{
				$wpdb->query
				(
						$wpdb->prepare
						(
						    "DELETE FROM ".$wpdb->prefix."sm_employees WHERE id = %d",
						    intval($_REQUEST['data'])
						)
				);
				$wpdb->query
				(
						$wpdb->prepare
						(
						    "DELETE FROM ".$wpdb->prefix."sm_allocate_serv WHERE emp_id = %d",
						    intval($_REQUEST['data'])
						)
				);
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
		
		
	else if($_REQUEST['action'] == 'WorkingHours')
	 {
		$emp_id = intval($_REQUEST['emp_id']);
		$mon_timings = $wpdb->get_row
		(
				$wpdb->prepare
				(
					"SELECT * FROM ".$wpdb->prefix."sm_timings where day = %s and emp_id = %d ",
					"Mon",
					$emp_id
					 
				)
		);
		$tue_timings = $wpdb->get_row
		(
				$wpdb->prepare
				(
					"SELECT * FROM ".$wpdb->prefix."sm_timings where day = %s and emp_id = %d ",
					"Tue",
					$emp_id 
				)
		);
		$wed_timings = $wpdb->get_row
		(
				$wpdb->prepare
				(
					"SELECT * FROM ".$wpdb->prefix."sm_timings where day = %s and emp_id = %d ",
					"Wed",
					$emp_id 
				)
		);
		$thur_timings = $wpdb->get_row
		(
				$wpdb->prepare
				(
					"SELECT * FROM ".$wpdb->prefix."sm_timings where day = %s and emp_id = %d ",
					"Thu",
					$emp_id
				)
		);
		$fri_timings = $wpdb->get_row
		(
				$wpdb->prepare
				(
					"SELECT * FROM ".$wpdb->prefix."sm_timings where day = %s and emp_id = %d ",
					"Fri",
					$emp_id 
				)
		);
		$sat_timings = $wpdb->get_row
		(
				$wpdb->prepare
				(
					"SELECT * FROM ".$wpdb->prefix."sm_timings where day = %s and emp_id = %d ",
					"Sat",
					$emp_id 
				)
		);
		$sun_timings = $wpdb->get_row
		(
				$wpdb->prepare
				(
					"SELECT * FROM ".$wpdb->prefix."sm_timings where day = %s and emp_id = %d ",
					"Sun",
					$emp_id 
				)
		);
		?>
		<script type="text/javascript">jQuery("select, input:checkbox, input:radio").uniform();</script>
		<input type="hidden" id="day1" value="<?php echo $mon_timings -> start_hour;?>:<?php echo $mon_timings -> start_minute;?>"/>
		<input type="hidden" id="day2" value="<?php echo $tue_timings -> start_hour;?>:<?php echo $tue_timings -> start_minute;?>"/>
		<input type="hidden" id="day3" value="<?php echo $wed_timings -> start_hour;?>:<?php echo $wed_timings -> start_minute;?>"/>
		<input type="hidden" id="day4" value="<?php echo $thur_timings -> start_hour;?>:<?php echo $thur_timings -> start_minute;?>"/>
		<input type="hidden" id="day5" value="<?php echo $fri_timings -> start_hour;?>:<?php echo $fri_timings -> start_minute;?>"/>
		<input type="hidden" id="day6" value="<?php echo $sat_timings -> start_hour;?>:<?php echo $sat_timings -> start_minute;?>"/>
		<input type="hidden" id="day7" value="<?php echo $sun_timings -> start_hour;?>:<?php echo $sun_timings -> start_minute;?>"/>
		<input type="hidden" id="dayend1" value="<?php echo $mon_timings -> end_hour;?>:<?php echo $mon_timings -> end_minute;?>"/>
		<input type="hidden" id="dayend2" value="<?php echo $tue_timings -> end_hour;?>:<?php echo $tue_timings -> end_minute;?>"/>
		<input type="hidden" id="dayend3" value="<?php echo $wed_timings -> end_hour;?>:<?php echo $wed_timings -> end_minute;?>"/>
		<input type="hidden" id="dayend4" value="<?php echo $thur_timings -> end_hour;?>:<?php echo $thur_timings -> end_minute;?>"/>
		<input type="hidden" id="dayend5" value="<?php echo $fri_timings -> end_hour;?>:<?php echo $fri_timings -> end_minute;?>"/>
		<input type="hidden" id="dayend6" value="<?php echo $sat_timings -> end_hour;?>:<?php echo $sat_timings -> end_minute;?>"/>
		<input type="hidden" id="dayend7" value="<?php echo $sun_timings -> end_hour;?>:<?php echo $sun_timings -> end_minute;?>"/>
		<input type="hidden" id="radioStatus1" value="<?php echo $mon_timings -> blocked;?>"/>
		<input type="hidden" id="radioStatus2" value="<?php echo $tue_timings -> blocked;?>"/>
		<input type="hidden" id="radioStatus3" value="<?php echo $wed_timings -> blocked;?>"/>
		<input type="hidden" id="radioStatus4" value="<?php echo $thur_timings -> blocked;?>"/>
		<input type="hidden" id="radioStatus5" value="<?php echo $fri_timings -> blocked;?>"/>
		<input type="hidden" id="radioStatus6" value="<?php echo $sat_timings -> blocked;?>"/>
		<input type="hidden" id="radioStatus7" value="<?php echo $sun_timings -> blocked;?>"/>
			
	<?php include("block_cal.php");?>	
		<table class="activity_datatable" width="100%" border="0" cellspacing="0" cellpadding="8">
			<tbody>
		
				<tr>
					<th> Day </th>
					<th > Status </th>
					<th > Start Hours </th>
					<th > End Hours </th>
				</tr>
				<tr>
					<td> Monday </td>
					<td>
					<div class="form_input">
						<input id="radio_open_0" name="radio_open_0" value="true" type="radio">
						<label for="radio_open_0" style="margin-left:-10px">Open</label>
						<input name="radio_open_0" id="radio_close_0" value="false" type="radio" >
						<label for="radio_open_0" style="margin-left:25px">Closed</label>
					</div></td>
					<td>
					<select id="startTime_0">
						
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480">8:00 am</option>
						<option value="510">8:30 am</option>
						<option value="540" selected="selected">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
					<td>
					<select id="endTime_0" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480" >8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020" selected="selected">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
				</tr>
				<tr>
					<td> Tuesday </td>
					<td>
					<div class="form_input">
						<input id="radio_open_1" name="radio_open_1" value="true"  type="radio">
						<label for="radio1"  style="margin-left:-10px">Open</label>
						<input name="radio_open_1" id="radio_close_1" value="false" type="radio" >
						<label for="radio1"  style="margin-left:25px">Closed</label>
					</div></td>
					<td>
					<select id="startTime_1" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480">8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540" selected="selected">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
					<td>
					<select id="endTime_1" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480" >8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020" selected="selected">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
				</tr>
				<tr>
					<td> Wednesday </td>
					<td>
					<div class="form_input">
						<input id="radio_open_2" name="radio_open_2" value="true"  type="radio">
						<label for="radio1"  style="margin-left:-10px">Open</label>
						<input  name="radio_open_2"  id="radio_close_2" value="false" type="radio">
						<label for="radio1"  style="margin-left:25px">Closed</label>
					</div></td>
					<td>
					<select id="startTime_2" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480">8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540" selected="selected">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
					<td>
					<select id="endTime_2" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480" >8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						 <option value="750">12:30 pm</option>
						 <option value="780">1:00 pm</option>
						 <option value="810">1:30 pm</option>
						  <option value="840">2:00 pm</option>
						 <option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						 <option value="1020" selected="selected">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
				</tr>
				<tr>
					<td> Thursday </td>
					<td>
					<div class="form_input">
						<input id="radio_open_3" name="radio_open_3" value="true" type="radio" >
						<label for="radio1"  style="margin-left:-10px">Open</label>
						<input name="radio_open_3" id="radio_close_3" value="false" type="radio" >
						<label for="radio1"  style="margin-left:25px">Closed</label>
					</div></td>
					<td>
					<select id="startTime_3" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480">8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540" selected="selected">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
					<td>
					<select id="endTime_3" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480" >8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020" selected="selected">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
				</tr>
				<tr>
					<td> Friday </td>
					<td>
					<div class="form_input">
						<input id="radio_open_4" name="radio_open_4"  value="true" type="radio">
						<label for="radio1"  style="margin-left:-10px">Open</label>
						<input name="radio_open_4"  id="radio_close_4" value="false" type="radio" >
						<label for="radio1"  style="margin-left:25px">Closed</label>
					</div></td>
					<td>
					<select id="startTime_4" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480">8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540" selected="selected">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
					<td>
					<select id="endTime_4" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480" >8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020" selected="selected">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
				</tr>
				<tr>
					<td> Saturday </td>
					<td>
					<div class="form_input">
						<input id="radio_open_5" value="true" name="radio_open_5" type="radio">
						<label for="radio1"  style="margin-left:-10px">Open</label>
						<input id="radio_close_5" name="radio_open_5"  value="false" type="radio" >
						<label for="radio1"  style="margin-left:25px">Closed</label>
					</div></td>
					<td>
					<select id="startTime_5" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480">8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540" selected="selected">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
					<td>
					<select id="endTime_5" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480" >8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020" selected="selected">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
				</tr>
				<tr>
					<td> Sunday </td>
					<td>
					<div class="form_input">
						<input id="radio_open_6" name="radio_open_6" value="true" type="radio">
						<label for="radio1"  style="margin-left:-10px">Open</label>
						<input id="radio_close_6" name="radio_open_6" value="false"  type="radio" >
						<label for="radio1"  style="margin-left:25px">Closed</label>
					</div></td>
					<td>
					<select id="startTime_6" >s
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480">8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540" selected="selected">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
					<td>
					<select id="endTime_6" >
						<option value="00">00:00 am</option>
						<option value="30">12:30 am</option>
						<option value="60">1:00 am</option>
						<option value="90">1:30 am</option>
						<option value="120">2:00 am</option>
						<option value="150">2:30 am</option>
						<option value="180">3:00 am</option>
						<option value="210">3:30 am</option>
						<option value="240">4:00 am</option>
						<option value="270">4:30 am</option>
						<option value="300">5:00 am</option>
						<option value="330">5:30 am</option>
						<option value="360">6:00 am</option>
						<option value="390">6:30 am</option>
						<option value="420">7:00 am</option>
						<option value="450">7:30 am</option>
						<option value="480" >8:00 am </option>
						<option value="510">8:30 am</option>
						<option value="540">9:00 am</option>
						<option value="570">9:30 am</option>
						<option value="600">10:00 am</option>
						<option value="630">10:30 am</option>
						<option value="660">11:00 am</option>
						<option value="690">11:30 am</option>
						<option value="720">12:00 pm</option>
						<option value="750">12:30 pm</option>
						<option value="780">1:00 pm</option>
						<option value="810">1:30 pm</option>
						<option value="840">2:00 pm</option>
						<option value="870">2:30 pm</option>
						<option value="900">3:00 pm</option>
						<option value="930">3:30 pm</option>
						<option value="960">4:00 pm</option>
						<option value="990">4:30 pm</option>
						<option value="1020" selected="selected">5:00 pm</option>
						<option value="1050">5:30 pm</option>
						<option value="1080">6:00 pm</option>
						<option value="1110">6:30 pm</option>
						<option value="1140">7:00 pm</option>
						<option value="1170">7:30 pm</option>
						<option value="1200">8:00 pm</option>
						<option value="1230">8:30 pm</option>
						<option value="1260">9:00 pm</option>
						<option value="1290">9:30 pm</option>
						<option value="1320">10:00 pm</option>
						<option value="1350">10:30 pm</option>
						<option value="1380">11:00 pm</option>
						<option value="1410">11:30 pm</option>
					</select></td>
				</tr>
			</tbody>
		</table>
	<script>
				for(var day=0; day <=6; day++)
				{
					document.getElementById('-radio_close_' + day).setAttribute("style", "margin-left:50px;");
					var status = document.getElementById('radioStatus' + (day + 1)).value;
					if(status == 0)
					{
						document.getElementById('-radio_open_' + day).removeAttribute("class", "checked");
						document.getElementById('-radio_close_' + day).setAttribute("class", "checked");
					}
					else
					{
						document.getElementById('-radio_close_' + day).removeAttribute("class", "checked");
						document.getElementById('-radio_open_' + day).setAttribute("class", "checked");
						
					}
				}
				
					
	
				//////********MONDAY START DATE*****///////
				for(var day=0; day <=6; day++)
				{
					var start_0 = document.getElementById('day' + (day + 1)).value;
					
					var end_0 = document.getElementById('dayend' + (day + 1)).value;
					
					start_0 = start_0.split(":");
					end_0 = end_0.split(":");
					
					var start_value_0 = parseInt(start_0[0] * 60) + parseInt(start_0[1]);
					var end_value_0 = parseInt(end_0[0] * 60) + parseInt(end_0[1]);
					
				
				
					if(!isNaN(start_value_0))
					{	
						jQuery('#startTime_' + day).val(start_value_0);
						jQuery('#-startTime_' + day).html(jQuery("#startTime_" + day + " option[value="+start_value_0+"]").text());
					}
					if(!isNaN(end_value_0))
					{	
						jQuery('#endTime_' + day).val(end_value_0);
						jQuery('#-endTime_' + day).html(jQuery("#endTime_" + day + " option[value="+end_value_0+"]").text());
						 
					}
					if(status == 1 )
					{
					
					}
				}
	
			</script>
		<?php
	}
else if($_REQUEST['action'] == 'delBlockTime')
	{
		$day = intval($_REQUEST['day']);
		$mnth = intval($_REQUEST['month']);
		$year = intval($_REQUEST['year']);
		$empid = intval($_REQUEST['empid']);

		$table_name = $wpdb->prefix . "sm_block_time";
		$wpdb->query
		(
			$wpdb->prepare
			(
				"DELETE FROM ".$wpdb->prefix."sm_block_time WHERE day = %d and month = %d and year = %d and emp_id = %d",
				$day,
				$mnth,
				$year,
				$empid
			)
		);
		
	}
	
	else if($_REQUEST['action'] == 'AddBlockTime')
	{
		$timefrt1 = $wpdb -> get_var('SELECT TimeFormat   FROM ' . $wpdb -> prefix . sm_settings);
		if($timefrt1=="1")
		{
			$blktim  = DATE("H:i", STRTOTIME($_REQUEST['strttm']));
		}
		else
		{
			$blktim=esc_attr($_REQUEST['strttm']);
		}
		
		$day = intval($_REQUEST['day']);
		$mnth = intval($_REQUEST['month']);
		$year = intval($_REQUEST['year']);
		$empid = intval($_REQUEST['empid']);
		
		preg_match("/([0-9]{1,2}):([0-9]{1,2})/", $blktim, $match);
		$hour = $match[1];
		$min = $match[2];
		
		$mystring=$year;
		$mystring.="-";
		$mystring.=$mnth;
		$mystring.="-";
		$mystring.=$day;
		$mystring.=" ";
		$mystring.=$hour;
		$mystring.=":";
		$mystring.=$min;
		$mystring.=":";
		$mystring.="00";
		
		$tempMinCheckAdd;
		$tempHrCheckAdd;
		if($min == 45)
		{
			$tempMinCheckAdd = 0;
			$tempHrCheckAdd =$hour+1;
		}
		else
		{
			$tempMinCheckAdd = $min + 15;
			$tempHrCheckAdd =$hour;
		}
		
		$mystring1=$year;
		$mystring1.="-";
		$mystring1.=$mnth;
		$mystring1.="-";
		$mystring1.=$day;
		$mystring1.=" ";
		$mystring1.=$tempHrCheckAdd;
		$mystring1.=":";
		$mystring1.=$tempMinCheckAdd;
		$mystring1.=":";
		$mystring1.="00";
		$block = "1";
		$block_date = "0";
		$wpdb->query
		(
		      $wpdb->prepare
		      (
		          "INSERT INTO ".$wpdb->prefix."sm_block_time(day,year,month,emp_id,block_time,hour,minute,timeof,endtime,blocked,block_date_id) VALUES(%d, %d, %d, %d, '$blktim', %d, %d, '$mystring', '$mystring1', %d, %d)",
		           $day,
		           $year,
		           $mnth,
		           $empid,
		           $hour, 
		           $min,
				   $block,
				   $block_date
		      )
		);
	}
	else if($_REQUEST['action'] == "BlockTimmings")
	{
		$curr =  date("Y/m/d");
		function getDatesBetween2Dates($startTime, $endTime) 
		{
			$day = 86400;
			$format = 'Y-m-d';
			$startTime = strtotime($startTime);
			$endTime = strtotime($endTime);
			$numDays = round(($endTime - $startTime) / $day) + 1;
			$days = array();
			for ($i = 0; $i < $numDays; $i++) 
			{
				$days[] = date($format, ($startTime + ($i * $day)));
			}
			return $days;
		}
		$days = getDatesBetween2Dates($_REQUEST['from'], $_REQUEST['to']);
		foreach($days as $key => $value)
		{
				$empid=intval($_REQUEST['emppid']);
				$dat=explode("-",$value);
				$year=$dat[0];
				$month=$dat[1];
				$day=$dat[2];
				$myDate = date( 'y-m-d', $value);
				
				$count = $wpdb->get_var('SELECT count(id) FROM ' . $wpdb->prefix . sm_bookings . ' WHERE  day = ' . '"' . $day . '"' . ' AND month =' . '"' . $month . '"' . ' AND year =' . '"' . $year . '"' . '  AND emp_id =' . '"' . $empid . '"');
				if($count!=0)
				{
					echo "1";		
				}
				else
				{
						$wpdb->query
						(
						      $wpdb->prepare
						      (
						          "INSERT INTO ".$wpdb->prefix."sm_block_date(block_date,emp_id,day,month,year) VALUES( '$value', %d, %d, %d, %d)",
						           $empid,
						           $day,
						           $month,
						           $year
						      )
						);
						$date = $value;
						$weekday = date('l', strtotime($date));
						$rest = substr($weekday,0,3);  // returns "cde"
						
						$st = $wpdb->get_var('SELECT start_hour FROM ' . $wpdb->prefix . sm_timings . ' WHERE  day = ' . '"' . $rest . '"' . ' AND emp_id =' . '"' . $empid . '"');
						$et = $wpdb->get_var('SELECT end_hour FROM ' . $wpdb->prefix . sm_timings . ' WHERE  day = ' . '"' . $rest . '"' . ' AND emp_id =' . '"' . $empid . '"');
						$sm = $wpdb->get_var('SELECT start_minute  FROM ' . $wpdb->prefix . sm_timings . ' WHERE  day = ' . '"' . $rest . '"' . ' AND emp_id =' . '"' . $empid . '"');
						$em = $wpdb->get_var('SELECT end_minute FROM ' . $wpdb->prefix . sm_timings . ' WHERE  day = ' . '"' . $rest . '"' . ' AND emp_id =' . '"' . $empid . '"');
						$idbd = $wpdb->get_var('SELECT id FROM ' . $wpdb->prefix . sm_block_date . ' order by id DESC ');
						$table_name = $wpdb->prefix . "sm_block_date";
						$lastid = $wpdb->insert_id;
						
						$tm = $st;
						$tm.= ":";
						$tm.= $sm;
						$tm.= ":";
						$tm.= "00";
						
						$mystring=$value;
						$mystring.=" ";
						$mystring.=$st;
						$mystring.=":";
						$mystring.=$sm;
						$mystring.=":";
						$mystring.="00";
						
						$mystringen=$value;
						$mystringen.=" ";
						$mystringen.=$et;
						$mystringen.=":";
						$mystringen.=$em;
						$mystringen.=":";
						$mystringen.="00";
						
						$wpdb->query
						(
						      $wpdb->prepare
						      (
						          "INSERT INTO ".$wpdb->prefix."sm_block_time(block_time,hour,minute,emp_id,day,month,year,timeof,endtime,blocked,block_date_id) VALUES('$tm', %d, %d, %d, %d, %d, %d, '$mystring', '$mystringen', %d, %d)",
						           $st,
						           $sm,
						           intval($_REQUEST['emppid']),
						           $day,
						           $month,
						           $year,
						           0,
						           $lastid
						      )
						);
					}
		}
	}
	else if($_REQUEST['action'] =="SaveWorkingHours")
	{
		$day=esc_attr($_REQUEST['day']);
		$flag=intval($_REQUEST['flag']);
		$start_hour=intval($_REQUEST['start_hours']);
		$start_minutes=intval($_REQUEST['start_minutes']);
		$end_hours=intval($_REQUEST['end_hours']);
		$end_mins=intval($_REQUEST['end_mins']);
		$empid=intval($_REQUEST['empid']);
		
		$table_name = $wpdb->prefix . "sm_timings";
		$count = $wpdb->get_var('SELECT count(id) FROM ' . $table_name . ' WHERE day = ' . '"' . $day . '"'. ' AND emp_id= ' . '"' . $empid.'"');
		if($count>0)
		{
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_timings SET blocked = %d, start_hour = %d, start_minute = %d, end_hour = %d, end_minute = %d WHERE day = %s and emp_id = %d",
	                    $flag,
	                    $start_hour,
	                    $start_minutes,
	                    $end_hours,
	                    $end_mins,
	                    $day,
	                    $empid
	             )
	      	);
			
		}
		else
		{
			$wpdb->query
			(
					$wpdb->prepare
					(
						    "INSERT INTO ".$wpdb->prefix."sm_timings(blocked,day,start_hour,start_minute,end_hour,end_minute,emp_id) VALUES( %d, %s, %d, %d, %d, %d, %d)",
						     $flag,
						     $day,
						     $start_hour,
						     $start_minutes,
						     $end_hours,
						     $end_mins,
						     $empid
					)
			);
		}
		return false;
	}	
}
else
{
?>
<script type="text/javascript">jQuery("select, input:checkbox, input:radio").uniform();</script>
<script type="text/javascript">
function savehour() 
		{
			var radioopen1="";
			var radioopen2="";
			var radioopen3="";
			var empval="";
			var startmon="";
			var endmon="";
			var startmonhour="";
			var strtmonhours="";
			var strtmonminnn="";
			var strtmonminsss="";
			var strtmonmin="";
			var endmonhour="";
			var endmonhours="";
			var endmonminnnnn="";
			var strtmonminsssss="";
			var endmonmin="";
			var dayy="";
			empval=document.getElementById("drpempwiz").value;
			var count = 0;
			if(empval != 0)
			{
				for(var i=0;i<7;i++)
				{
								var flag = 0;
									radioopen1=jQuery("#-radio_open_"+i).attr("class");
								if(radioopen1 == "checked")
								{
									flag = 1;						
								}
							
						
								startmon=jQuery("option:selected", jQuery("#startTime_"+i)).text();
								
								endmon=jQuery("option:selected", jQuery("#endTime_"+i)).text();
								startmonhour=startmon.split(":");
								strtmonhours=startmonhour[0];
								strtmonminnn=startmonhour[1];
								var res=strtmonminnn.indexOf("pm") != -1;
								if(res==true && strtmonhours<12)
								{
									strtmonhours=parseInt(12)+parseInt(strtmonhours);
										
								}
								strtmonminsss=strtmonminnn.split(" ");
								strtmonmin=strtmonminsss[0];
								endmonhour=endmon.split(":");
								endmonhours=endmonhour[0];
								endmonminnnnn=endmonhour[1];
								var res=endmonminnnnn.indexOf("pm") != -1;
								if(res==true && endmonhours<12)
								{
									endmonhours=parseInt(12)+parseInt(endmonhours);
									
								}
								strtmonminsssss=endmonminnnnn.split(" ");
								endmonmin=strtmonminsssss[0];
					
						switch(i)
						{
								case 0 :
									dayy="Mon";
									break;
								case 1 :
									dayy="Tue";
									break;
								case 2 :
									dayy="Wed";
									break;
								case 3 :
									dayy="Thu";
									break;
								case 4 :
									dayy="Fri";
									break;
								case 5 :
									dayy="Sat";
									break;
								case 6 :
									dayy="Sun";
									break;
						}
						
							jQuery.ajax({
									type: "POST",
									data: "day="+dayy+"&start_hours="+strtmonhours+"&start_minutes="+strtmonmin+"&end_hours="+endmonhours+"&end_mins="+endmonmin+"&empid="+empval+"&flag="+flag+"&action=SaveWorkingHours",
									url:  uri+"/employees.php",
									success: function(data)
									{ 	
										count++;
											
										if(count == 6)
										{
											jQuery("#selemp").css('display','none');
											jQuery("#saveHours").css('display','block');
											setTimeout(function() 
			        						{
											
												jQuery("#saveHours").css('display','none');
												parent.jQuery.fancybox.close(); 
												jQuery("#drpempwiz").val(0);
												jQuery("#-drpempwiz").html('Select Employee');
											},1000);
											
										}
									}
								});
				}
				
			}
			else
			{
				jQuery("#selemp").css('display','block');
			}
			
			return;
		}
	
	function addEmployeeNameBlur() 
	{
		if(jQuery('#employeeName1').val() == "") 
		{
				jQuery("#employeeName1").addClass("in_error");
				return false;
		} 
		else 
		{
				if(jQuery("#employeeName1").hasClass('in_error')) 
				{
					jQuery("#employeeName1").removeClass("in_error");
				}
				jQuery("#employeeName1").addClass("in_submitted");
				return true;
		}
			
	}
	function addEmployeeEmailBlur()
	{
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			var address = jQuery("#employeeEmail1").val();
			if(reg.test(address) == false) 
			{
				jQuery("#employeeEmail1").addClass("in_error");
				return false;
			} 
			else 
			{
				if(jQuery("#employeeEmail1").hasClass('in_error')) 
				{
					jQuery("#employeeEmail1").removeClass("in_error");
				}
				jQuery("#employeeEmail1").addClass("in_submitted");
				return true;
			}
	}
	function addEmployeePhoneBlur()
	{
		if(jQuery('#employeePhone1').val() == "") 
		{
				jQuery("#employeePhone1").addClass("in_error");
				return false;
		} 
		else 
		{
				if(jQuery("#employeePhone1").hasClass('in_error')) 
				{
					jQuery("#employeePhone1").removeClass("in_error");
				}
				jQuery("#employeePhone1").addClass("in_submitted");
				return true;
		}
	}
	function editEmployeeNameBlur() 
	{
		if(jQuery('#employeeditName').val() == "") 
		{
				jQuery("#employeeditName").addClass("in_error");
				return false;
		} 
		else 
		{
				if(jQuery("#employeeditName").hasClass('in_error')) 
				{
					jQuery("#employeeditName").removeClass("in_error");
				}
				jQuery("#employeeditName").addClass("in_submitted");
				return true;
		}
	}
	function editEmployeeEmailBlur()
	{
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			var address = jQuery("#employeeditEmail").val();
			if(reg.test(address) == false) 
			{
				jQuery("#employeeditEmail").addClass("in_error");
				return false;
			} 
			else 
			{
				if(jQuery("#employeeditEmail").hasClass('in_error')) 
				{
					jQuery("#employeeditEmail").removeClass("in_error");
				}
				jQuery("#employeeditEmail").addClass("in_submitted");
				return true;
			}

	}
	function editEmployeePhoneBlur()
	{
		if(jQuery('#employeeeditPhone').val() == "") 
		{
				jQuery("#employeeeditPhone").addClass("in_error");
				return false;
		} 
		else 
		{
				if(jQuery("#employeeeditPhone").hasClass('in_error')) 
				{
					jQuery("#employeeeditPhone").removeClass("in_error");
				}
				jQuery("#employeeeditPhone").addClass("in_submitted");
				return true;
		}
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
	function add_employee()
	{
				jQuery(document).ready(function($) 
				{		var nam = document.getElementById("employeeName1").value;
						var name1 = encodeURIComponent(nam);
						var ema = document.getElementById('employeeEmail1').value;
						var email1 = encodeURIComponent(ema);
						var phone1 = document.getElementById('employeePhone1').value;	
						var code1=document.getElementById('employeeCode1').value;
						if(addEmployeeNameBlur() && addEmployeeEmailBlur() && addEmployeePhoneBlur())
						{
					
						var radios1 = document.getElementsByName('radStatus');
						var value;
						for (var i = 0; i < radios1.length; i++) 
						{
								if (radios1[i].type == 'radio' && radios1[i].checked) 
								{
									value1 = radios1[i].value;
									break;
								}
						}
						var input_field_1 = document.getElementById('color1').value;
						if(input_field_1=="")
						{
							jQuery("#colorcodwiz").css('display','block');
							return false;
						}
						var urlSite = "<?php echo site_url(); ?>";
						jQuery.ajax({
									type: "POST",
									data: "ename="+name1+"&ecode="+code1+"&input_field_1="+input_field_1+"&ephone="+phone1+"&email="+email1+"&rad="+value1+"&action=AddEmployees",
									url:  uri+"/employees.php",
									success: function(data) 
									{
										jQuery("#colorcodwiz").css('display','none');
										jQuery("#success").css('display','block');
										parent.jQuery.fancybox.close();
										window.location.href = urlSite +"/wp-admin/admin.php?page=TabEmployees";
									}
								});
							}
				});
	}
	function delete_employee(service) 
	{
		pathdel= uri+"/employees.php";
		action = confirm("Are you sure you want to delete this Employee?");
		if(action == true)
		{
				jQuery.ajax({
				type: "POST",
				data: "data=" + service+"&action=deleteemployee",
				url: pathdel,
				success: function(data) 
				{
				
				if(data=='booking')
				{
				alert('The Employee could not be deleted. Some of the Future Bookings has been associated with this Employee. Kindly first re-allocate the associated Bookings to delete this Employee.');
				}
				else if(data=='allocate_service')
				{
				alert('The Employee could not be deleted. Some of the services has been associated with this Employee. Kindly first de-allocate the associated services to delete this Employee.');
				}
				else
				{
				path= uri+"/employeesrebind.php";
				var urlSite = "<?php echo site_url(); ?>";
							jQuery.ajax({
										type: "POST",
										data: "bindemp=true"+"&emppage=true",
										url: path,
										success: function(data)
										{
											window.location.href = urlSite +"/wp-admin/admin.php?page=TabEmployees";
										}
								});
				
				}
				
				}
			});
		} 
	}
	function get_edit_emp(e)
	{
	
		var id=e.id;
		
		document.getElementById("employeeditCode").value = jQuery("#empcod_"+id).html();
		document.getElementById("employeeditName").value=jQuery("#empnam_"+id).html();
		document.getElementById("employeeditEmail").value=jQuery("#empemail_"+id).html();
		document.getElementById("employeeeditPhone").value=jQuery("#empphone_"+id).html();
	
		
		if(jQuery("#empsts_"+id).html() == "Active")
		{
			document.getElementById("-editeStatusOpen").setAttribute("class", "checked");
			document.getElementById("-editeStatusClose").removeAttribute("class", "checked");
			document.getElementById('editeStatusOpen').checked=true;
			document.getElementById('editeStatusClose').checked=false;
				
		}
		else
		{	document.getElementById('editeStatusClose').checked=true;
			document.getElementById('editeStatusOpen').checked=false;
			document.getElementById("-editeStatusOpen").removeAttribute("class", "checked");
			document.getElementById("-editeStatusClose").setAttribute("class", "checked");
		}
		
		var empcol=document.getElementById("empcolor_"+id).value;
		jQuery("#color2").attr("value",empcol);
		jQuery("#color2").keyup();
		var t=document.getElementById("empid_"+id).value;
		document.getElementById("empidf").value =t;
		
					
	}
	function update()
	{

		var id =document.getElementById("empidf").value;
		var enam = document.getElementById("employeeditName").value;
		var empnam = encodeURIComponent(enam);
		var emai =  document.getElementById("employeeditEmail").value;
		var em = encodeURIComponent(emai);
		var ph =  document.getElementById("employeeeditPhone").value;
		
		var col =  document.getElementById("color2").value;
		if(editEmployeeNameBlur() && editEmployeeEmailBlur() && editEmployeePhoneBlur())
		{
			var radios = document.getElementsByName('editStatus');
			var value;
			for (var i = 0; i < radios.length; i++) 
			{
				if (radios[i].type == 'radio' && radios[i].checked) 
				{
					value = radios[i].value;
					break;
				}
			}
				
			jQuery.ajax({
						type: "POST",
						data: "id="+id+"&em="+em+"&empn="+empnam+"&ph="+ph+"&col="+col+"&value="+value+"&action=UpdateEmployees",
						url:  uri+"/employees.php",
						success: function(data) 
						{
							path= uri+"/employeesrebind.php";
							jQuery.ajax({
										type: "POST",
										data: "bindemp=true"+"&emppage=true",
										url: path,
										success: function(data)
										{
											
											var temp=data;
											var index2=temp.indexOf("/table");
											var ind=index2+7;
											var cal=temp.substring(0, ind);
											var last=temp.lastIndexOf("/option>");
											var l_index=last+8;
											var time=temp.substring(ind,l_index);
											jQuery("#disptbldata").html(cal);
											jQuery("#empdispid").html(cal);
											jQuery("#all_emppp").html(time);
											jQuery("#drpempwiz").html(time);
											jQuery("#empid").html(time);	
											jQuery("#successedd").css('display','block');
											setTimeout(function() 
											{	if(jQuery("#employeeditName").hasClass('in_submitted'))
																	{
																		jQuery("#employeeditName").removeClass("in_submitted");
																	}
																	if(jQuery("#employeeditEmail").hasClass('in_submitted'))
																	{
																		jQuery("#employeeditEmail").removeClass("in_submitted");
																	}
																	if(jQuery("#employeeeditPhone").hasClass('in_submitted'))
																	{
																		jQuery("#employeeeditPhone").removeClass("in_submitted");
																	}
												jQuery("#successedd").css('display','none');
												parent.jQuery.fancybox.close();
											}, 1000);
										}
							});
						}
					});
					
			

					
		}
	}
	
	function callemp()
	{
	
			jQuery(document).ready(function($)
			{
				var empid= document.getElementById('all_emppp').value;
				if(empid!=0)
				{
					jQuery.fancybox.update();	
					
				}
				jQuery.ajax
				({
						type: "POST",
						data: "emp_id="+empid,
						url:  uri+"/employee_allocation.php",
						success: function(data) 
						{
							jQuery('#show').css('display','none');
							jQuery("#allocateserv").html(data);
							setTimeout(function() 
							{
							jQuery('#show').css('display','block');
							jQuery.fancybox.update();
							}, 1000);
						}
				});
			});
	}
	
	function get_emp_timingswiz()
	{
			
			var  empid = jQuery("#drpempwiz").val();
			jQuery.ajax({
			type: "POST",
			data: "emp_id="+empid+"&action=WorkingHours",
			url:  uri+"/employees.php",
			success: function(data) 
			{
				jQuery("#disptb").empty();
				jQuery("#disptb").html(data);
			}
			});
		return;
	}
	
function timeoff()
{
	var sda = document.getElementById('empid').value;
	if(sda != 0)
	{
	document.getElementById("deletecalemp").style.display='block';
	if(document.getElementById('radioblockhours').checked==false)
	{
			
			
			var filepath1=uri+"/blockcal.php";
			jQuery(document).ready(function($) 
			{
					var dat = new Date();		
					var day=dat.getDate();
				    var month = dat.getMonth() +1;
				    var year =  dat.getFullYear();
					jQuery.ajax
					({
							type: "POST",
							    data: "cmonth="+month+"&cyear="+year+"&cday="+day+"&empnam="+sda,
							url: filepath1,
							success: function(data) 
							{
								jQuery("#maindisptime").css('display','block');
								jQuery("#blktimecontrols").css('display','none');
								jQuery("#displayed_cal").html(data);
								var valemp=sda;
								var filepath335 =uri+"/blocktim.php";
								if(valemp!=0)
								{
									jQuery.ajax
									({
									        type: "POST",
									        data: "cmonth="+month+"&cyear="+year+"&cday="+day+"&empnam="+sda,
									        url: filepath335,
	        								success: function(data) 
											{		
												var obj8 = document.getElementById('blktimecontrols');
												obj8.style.display = 'block';	
												jQuery("#blktimecontrols").html(data);
											}
									});
								}
							}
						});
				});
		}
	}
	else
	{
		jQuery("#maindisptime").css("display","none");
	}
}
function blockdays(e)
{
    jQuery(document).ready(function($) 
    {
	    var blkvar=e.value;
		if(blkvar=="blkdays")
		{
			document.getElementById("divcont").style.display='none';
			jQuery("#maindisptime").css('display','block');
			document.getElementById("divblkcal").style.display='block';
			jQuery("#blktimecontrols").css('display','none');
		}
		else if(blkvar=="blkhours")
		{
			document.getElementById("divblkcal").style.display='none';
			document.getElementById("divcont").style.display='block';
			var sda = document.getElementById('empid').value;
			
			var filepath1=uri+"/blockcal.php";
			jQuery.ajax
			({
				type: "POST",
				data: "empnam="+sda,
				url: filepath1,
				success: function(data) 
				{
					jQuery("#maindisptime").css('display','block');
					jQuery("#displayed_cal").html(data);
					var dat = new Date();		
					var day=dat.getDate();
				    var month = dat.getMonth() +1;
				    var year =  dat.getFullYear();
					var valemp=sda.trim();
					var filepath3456 =uri+"/blocktim.php";					
					if(valemp!=0)
					{
	 					jQuery.ajax
	 					({
				              type: "POST",
				              data: "cmonth="+month+"&cyear="+year+"&cday="+day+"&empnam="+sda+"&emp_idd="+sda,
				              url: filepath3456,
				              success: function(data) 
			  				  {
								  	var obj8 = document.getElementById('blktimecontrols');
									obj8.style.display = 'block';
								   jQuery("#blktimecontrols").html(data);
			  				  }
						});
		    		}
					else
					{
						var obj8 = document.getElementById('blktimecontrols');
						obj8.style.display = 'none';
					}
				}
			});
		}
	});
}
function save_block_time()
{
		var day="";
	    if(!document.getElementById('blokday'))
		{
			var dat = new Date();		
			var today=dat.getDate();
  			var divcnt=document.getElementById('displayed_cal');
			var blokday=document.createElement('input');
			blokday.type='hidden';
        	blokday.value=today;
            blokday.setAttribute('id','blokday');
            divcnt.appendChild(blokday);
			day=today;
        }
		else
		{
			day=document.getElementById('blokday').value;
		}
		var empid=document.getElementById('empid').value;
		var mntyer=jQuery("#cur_calll").html();
		var stmnth=mntyer.split("-");
		var yer=stmnth[1].trim();
		var monthg=stmnth[0].trim();
		
		var fileaddblocktime=uri+"/employees.php";
		var curmonth="";
		switch(monthg)
		{
			case "Jan" :
						curmonth=1;
						break;
			case "Feb" :
						curmonth=2;
						break;
			case "Mar" :
						curmonth=3;
						break;
			case "Apr" :
						curmonth=4;
						break;
			case "May":
						curmonth=5;
						break;
			case "Jun" :
						curmonth=6;
						break;
			case "Jul" :
						curmonth=7;
						break;
			case "Aug" :
						curmonth=8;
						break;
			case "Sep" :
						curmonth=9;
						break;
			case "Oct" :
		    			curmonth=10;
						break;
			case "Nov" :
						curmonth=11;
						break;
			case "Dec" :
						curmonth=12;
						break;
		}
		var sda = document.getElementById('addblocktime');
		var len = sda.length;
		
		jQuery.ajax
		({
			type: "POST",
			data: "day="+day+"&month="+curmonth+"&empid="+empid+"&year="+yer+"&action=delBlockTime",
			url: fileaddblocktime,
			success: function(data)
			{
				
				for(var j=0; j<len; j++)
				{
					var tmp1 = sda.options[j].value;
				
			    		jQuery.ajax
			    		({
							type: "POST",
							data: "day="+day+"&month="+curmonth+"&empid="+empid+"&year="+yer+"&strttm="+tmp1+"&action=AddBlockTime",
							url: fileaddblocktime,
							success: function(data)
							{
								jQuery("#saveblock").css('display','block');	
							}
						});
					
				}
						 setTimeout(function() 
							{
										   jQuery("#saveblock").css('display','none');
										   jQuery("#maindisptime").css('display','none');
										   jQuery("#divblkcal").css('display','block');
										   jQuery("#divcont").css('display','none');
				   							var obj8 = document.getElementById('blktimecontrols');
				   							obj8.style.display = 'none';
				   							document.getElementById('empid').value=0;
				   							parent.jQuery.fancybox.close();
				   							document.getElementById('-radioblockhours').removeAttribute("class","checked");
				   							document.getElementById('-radioblockdays').setAttribute("class","checked");
				   							document.getElementById('radioblockdays').checked=true;
				   							jQuery("#-empid").html("Choose Employee");
				   						}, 1000);	
									
			}
		});
}
function block_dat() 
{
	jQuery(document).ready(function($) 
	{
		
		var fileaddblocktime=uri+"/employees.php";
		var emmpid=document.getElementById('empid').value;																
		if(emmpid==0)
		{
			jQuery("#errorblock").css('display','block');
			return false;
		}
		var blokdat = jQuery("#from").val();
		if(blokdat==0)
		{
			jQuery("#errorblock").css('display','none');
			jQuery("#stdt").css('display','block');
			return false;
		}
		var blokdate = jQuery("#to").val();
		if(blokdate==0)
		{
			jQuery("#stdt").css('display','none');
			jQuery("#eddt").css('display','block');
			jQuery("#errorblock").css('display','none');
			return false;
		}
		jQuery.ajax
		({
			type: "POST",
			data: "to="+blokdate+"&from="+blokdat+"&emppid="+emmpid+"&action=BlockTimmings",
			url: fileaddblocktime,
			success: function(data) 
			{
					
			var datta = jQuery.trim(data);
		
				if(datta==1)
				{
					alert('IMPORTANT NOTE: One or more of the dates/hours you are trying to block has an assigned appointment to them (serviced by you). You must first clear any appointments you have on that specific date before proceeding to block any dates/hours (this is done via the Booking or the Customers Tab');
				}
				jQuery("#errorblock").css('display','none');
				jQuery("#saveblock").css('display','block');
				jQuery("#eddt").css('display','none');
				jQuery("#stdt").css('display','none');
				setTimeout(function() 
				{
					
					jQuery("#saveblock").css('display','none');
					parent.jQuery.fancybox.close();
					document.getElementById('from').value="";
					document.getElementById('to').value="";
		 			jQuery("#-empid").html("Choose Employee");
					document.getElementById('empid').value=0;
				}, 1000);
			}
		});
	});
}
	function moveoutblocktime()
	{
	var sda = document.getElementById('strtblocktime');
	
	var len = sda.length;
	var sda1 = document.getElementById('addblocktime');
	for(var j=0; j<len; j++)
	{
		if(sda[j].selected)
		{
			var tmp = sda.options[j].text;
			var tmp1 = sda.options[j].value;
			sda.remove(j);
			j--;
			var y=document.createElement('option');
			y.text=tmp;
			try
			{
				sda1.add(y,null);
			}
			catch(ex)
			{
			sda1.add(y);
			}
		}
	}
	}
function moveinblocktime()
{	try
	{
		var sda = document.getElementById('strtblocktime');
		var sda1 = document.getElementById('addblocktime');
		var len = sda1.length;
		for(var j=0; j<len; j++)
		{
			if(sda1[j].selected)
			{
				var tmp = sda1.options[j].text;
				var tmp1 = sda1.options[j].value;
				sda1.remove(j);
				j--;
				var y=document.createElement('option');
				y.text=tmp;
				var dat = y.text;
				sda.add(y,null);
			}
		}
	}
	catch(ex)
	{
	}
}
	

function savedetails(opt)	
{
	jQuery(document).ready(function($) 
	{
	
		var empid=document.getElementById('all_emppp').value;
			var sel = getSelected(opt);
            var strSel = "";
			var str2 = "";
            for (var item in sel)       
              for (var item in sel)       
            {
				str2 += sel[item].value + ",";
			}
			strSel = encodeURIComponent(str2);
			
		   
		    jQuery.ajax({
					type: "POST",
					data: "emp="+empid+"&allserv="+strSel+ "&action=AllocateEmployees",
					url:  uri+"/employees.php",
					success: function(data) 
					{
						jQuery("#saved2").css('display','block');
						jQuery("#errormsggg").css('display','none');
						setTimeout(function() 
						{
							jQuery("#saved2").css('display','none');
							parent.jQuery.fancybox.close();
							jQuery("#all_emppp").val(0);
							jQuery("#-all_emppp").html('Select Employee');
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

 			
	 
	});
}		

</script>



<script type="text/javascript">
		get_emp_timingswiz();
jQuery(function() {
		jQuery( "#from" ).datepicker({ dateFormat: 'yy-mm-dd' });
		jQuery( "#to" ).datepicker({ dateFormat: 'yy-mm-dd' });
	});
	
			jQuery(document).ready( function() {
				jQuery(".color-picker").miniColors();
			
				
			});
			
		</script>		
 <div id="employeediv">
	    <div class="contentarea">
		<div class="one_wrap fl_left">
		
			<div class="msgbar msg_Success hide_onC" id="savedallocate" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
				<span class="iconsweet">=</span>
				<p>
					Service has been Successfully allocated to the Employee.
				</p>
			</div>
			<div class="msgbar msg_Success hide_onC" id="saveblockdel" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
				<span class="iconsweet">=</span>
				<p>
					Employee Block Date has been Successfully Deleted.
				</p>
			</div>
			<div class="msgbar msg_Success hide_onC" id="savedit" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
				<span class="iconsweet">=</span><p>
					Employee has been Successfully Edited.
				</p>
				</div>
				<ul class="form_fields_container" style="margin-top:10px;">
					<li>
					<?php
						global $wpdb;
						$count = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_employees );
						if($count<1)
						{
						?>
						<a class="greyishBtn button_small fancybox"  href="#Addemployee" >Add New Employee</a>
						<?php
						}
						?>
						<a class="greyishBtn button_small fancybox"  href="#allocateEmployeeee">Allocate Services</a>
						<a class="greyishBtn button_small fancybox"  href="#officeHours">Working Hours</a>
						<a class="greyishBtn button_small fancybox"  href="#timeOff">Time Off</a>
					</li>
				</ul>
				<div class="widget-wp-obs" style="margin-top: 0px">
					<div class="widget-wp-obs_title">
						<span class="iconsweet">k</span>
						<h5> Existing Employees</h5>
					</div>
					<div id="disptbldata" class="widget-wp-obs_body">
						<table class="activity_datatable" width="100%" border="0" cellspacing="0" cellpadding="8">
							<tbody>
								<tr>
									<th width="10%"> Emp. Code </th>
									<th width="14%"> Color Code </th>
									<th width="20%"> Employee Name </th>
									<th width="20%"> Email </th>
									<th width="15%"> Phone </th>
									<th width="10%"> Status </th>
									<th width="11%"> Action </th>
								</tr>
								<?php
								$emp = $wpdb->get_results
								(
										$wpdb->prepare
										(
											"SELECT * FROM ".$wpdb->prefix."sm_employees"
										)
								);
								for ($i = 0; $i < count($emp); $i++) {
								$idd = $emp[$i]->id;
								$code = $emp[$i]->emp_code;
								$color = $emp[$i]->emp_color;
								$name = $emp[$i]->emp_name;
								$email = $emp[$i]->email;
								$phon = $emp[$i]->phone;
								$status = $emp[$i]->status;
								?>
								<tr class="tyu">
									<td>
									<label id="empcod_<?php echo $i; ?>" style="cursor:default; " value=""><?php echo $code;?> </label>
									</td>
									<td style="background-color:<?php echo $color;?>">
									<input type="hidden" id="empcolor_<?php echo $i; ?>" style="cursor:default; " value="<?php echo $color; ?>">
									</input></td>
									<td><label id="empnam_<?php echo $i; ?>" style="cursor:default; " value=""><?php echo $name;
										?></label></td>
									<td><label id="empemail_<?php echo $i; ?>" style="cursor:default; " value=""><?php echo $email;
										?></label></td>
									<td><label id="empphone_<?php echo $i; ?>" style="cursor:default; " value=""><?php echo $phon;
										?></label></td>
									<td>
									<input type="hidden" id="empid_<?php echo $i; ?>" style="cursor:default; " value="<?php echo $idd; ?>"/>
									<?php
									if ($status == "In Active") {
									?>
									<label id="empsts_<?php echo $i; ?>" style="color:red;cursor:default; "><?php echo $status;
										?></label><?php }
									else if($status == "Active")
									{
									?>
									<label id="empsts_<?php echo $i; ?>" style="color:green;cursor:default;"><?php echo $status;
										?></label><?php }
									?></td>
									<td><span class="data_actions iconsweet"> <a class="tip_north fancybox" original-title="Edit" id="<?php echo $i;?>" href="#Editemployee" onclick="get_edit_emp(this)"   style="cursor:pointer;">C</a> <a class="tip_north" original-title="Delete" id='<?php echo $idd;?>'  href="javascript: delete_employee('<?php echo $idd;?>')"  style="cursor:pointer;">X</a> </span></td>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
				</div>
				</div>
				<div id="Addemployee"  style="width:600px;display:none;">
					<div class="msgbar msg_Success hide_onC" id="success"  style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
						<span class="iconsweet">=</span>
						<p>
							Employee has been Successfully added.
						</p>
					</div>
					<div class="msgbar msg_Error hide_onC" id="colorcodwiz"  style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
						<span class="iconsweet">X</span>
						<p>
							Select Employee Color Code.
						</p>
					</div>
					<div class="widget-wp-obs" style="margin:5px;">
						<div class="widget-wp-obs_title">
							<span class="iconsweet">o</span>
							<h5> Add New Employee</h5>
						</div>
						<div class="widget-wp-obs_body"></div>
						<ul class="form_fields_container">
							<li>
								<label> Emp Code : </label>
								<?php $num = rand(1, 9999);
								?>
								<div class="form_input" style="width:75%" >
									<input type="text" name="employeeCode1" id="employeeCode1" value="<?php echo $num;?>" disabled="disabled" />
								</div>
							</li>
							<li>
								<label> Color Code :</label>
									<div class="form_input" style="width:70%">
									<input type="text" name="color1" id="color1" class="color-picker" size="6" autocomplete="on" maxlength="10" />
								</div>
							</li>
							<li>
								<label> Name <span style="color: red">*</span> : </label>
								<div class="form_input" >
									<input type="text" onBlur="return addEmployeeNameBlur();" name="employeeName1" id="employeeName1" />
								</div>
							</li>
							<li>
								<label> E-mail <span style="color: red">*</span> :</label>
								<div class="form_input" >
									<input type="text" onBlur="return addEmployeeEmailBlur();" name="employeeEmail1" id="employeeEmail1" />
								</div>
							</li>
							<li>
								<label> Phone :</label>
								<div class="form_input" >
									<input type="text" onBlur="return addEmployeePhoneBlur();" name="employeePhone1" id="employeePhone1" onKeyPress="return validatePhone(event,this)"/>
								</div>
							</li>
							<li>
								<label> Status : </label>
								<div class="form_input" >
									<input id="radStatus11"  name="radStatus"  type="radio" value="Active" checked="checked" style="width:auto !important">
									<label for="radStatus"> Active</label>
									<br />
									<input id="radStatus21"   name="radStatus" type="radio" value="In Active"  style="width:auto !important">
									<label for="radStatus"> InActive</label>
								</div>
							</li>
							<li id="btnsaveemp" style="padding-bottom:10px;padding-top:10px">
								<a href="#" class="greyishBtn button_small"   onClick="add_employee();" style="margin-left:120px;">Save Details</a>
								</li >
						</ul>
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
									<label> Employee : <span style="color: red">*</span></label>
									<div id="empdisppp" class="form_input" >
										<select id="all_emppp" name="all_emppp" onchange="callemp();">
											<option value="0">Select Employee</option>
											<?php
												$emp = $wpdb->get_results
												(
														$wpdb->prepare
														(
															"SELECT * FROM ".$wpdb->prefix."sm_employees where status = %s order by emp_name ASC",
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
												?></option>
											<?php } ?>
										</select>
									</div>
								</li>
								
								<div id="show" style="display:none;">
								<li style="max-height:250px;overflow-y:scroll">
								<div class="form_input" id="allocateserv" >
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
				<div  id="officeHours" style="display:none;width:850px;">
					<div class="msgbar msg_Error hide_onC" id="selemp" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
						<span class="iconsweet">X</span>
						<p>
							Select Employee First.
						</p>
					</div>
					<div class="msgbar msg_Success hide_onC" id="saveHours" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
						<span class="iconsweet">=</span>
						<p>
							Employee Office Timmings has been Successfully added.
						</p>
					</div>
					<div class="widget-wp-obs" style="margin:5px;">
						<div class="widget-wp-obs_title">
							<span class="iconsweet">o</span>
							<h5> Working Hours</h5>
						</div>
						<div class="widget-wp-obs_body">
							<ul class="form_fields_container">
								<li style="background:none">
									<label> Employee : </label>
									<div id="workingtim" class="form_input" >
										<select name='drpempwiz' id='drpempwiz' onchange="get_emp_timingswiz();">
											<option value='0'>Select Employee</option>
											<?php
											$name = $wpdb->get_col
											(
												$wpdb->prepare
												(
													"SELECT emp_name FROM ".$wpdb->prefix."sm_employees where status = %s ORDER BY emp_name ASC",
													"Active"
																	
												)
											);
											$id = $wpdb->get_col
											(
												$wpdb->prepare
												(
													"SELECT id FROM ".$wpdb->prefix."sm_employees where status = %s ORDER BY emp_name ASC",
													"Active"
																	
												)
											);
											
											$count = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_employees . ' where status = "Active" ');
											for($i=0;$i<$count;$i++)
											{
											$nam=$name[$i];
											$idd=$id[$i];
											?>
											<option value='<?php echo $idd;?>'><?php echo $nam;?></option> <?php }
											?>
										</select>
									</div>
								</li>
							</ul>
							<div id="disptb"></div>
							<ul>
							<li>
								<a href="#" class="greyishBtn button_small" onclick="return savehour();" id="btn_wizsave"  name="btn_wizsave" style="margin:10px 5px;">Save Details</a>
							</li>
						</ul>
						</div>	
						</div>
						
				
				</div>
				<div  id="timeOff" style="display:none;width:550px;">
					<div class="msgbar msg_Error hide_onC" id="errorblock" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
						<span class="iconsweet">X</span>
						<p>
							Select Employee First.
						</p>
					</div>
					<div class="msgbar msg_Error hide_onC" id="stdt" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
						<span class="iconsweet">X</span>
						<p>
							Select Start Date.
						</p>
					</div>
					<div class="msgbar msg_Error hide_onC" id="eddt" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
						<span class="iconsweet">X</span>
						<p>
							Select End Date.
						</p>
					</div>
					<div class="msgbar msg_Success hide_onC" id="saveblock"style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
						<span class="iconsweet">=</span>
						<p>
							Employee Block Date has been Successfully saved.
						</p>
					</div>
					<div class="widget-wp-obs" style="margin:5px">
						<div class="widget-wp-obs_title">
							<span class="iconsweet">z</span>
							<h5> Time Off</h5>
						</div>
						<div class="widget-wp-obs_body">
							<ul class="form_fields_container">
								<li style="padding-bottom: 5px; padding-top: 5px">
									<label> Employee : </label>
									<div id="emptimeoff" class="form_input">
										<?php
											$name = $wpdb->get_col
											(
												$wpdb->prepare
												(
													"SELECT emp_name FROM ".$wpdb->prefix."sm_employees where status = %s ORDER BY emp_name ASC",
													"Active"
																	
												)
											);
											$id = $wpdb->get_col
											(
												$wpdb->prepare
												(
													"SELECT id FROM ".$wpdb->prefix."sm_employees where status = %s ORDER BY emp_name ASC",
													"Active"
																	
												)
											);
											
											$count = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_employees . ' where status = "Active"');
										?>
										<select name='empid' id='empid' onchange="return timeoff();" >
											<option value="0">Choose Employee</option>
											<?php
											for($i=0;$i<$count;$i++)
											{
											$nam=$name[$i];
											$idd=$id[$i];
											?>
											<option value='<?php echo $idd;?>'> <?php echo $nam;?></option> <?php
											}
											?>
										</select>
									</div>
								</li>
							</ul>
							<div id="deletecalemp" style="display:none;">
								<ul class="form_fields_container">
									<li>
										<div style="display:none;margin-left:110px;" id="maindisptime" class="contentcalendar_res" style="margin-top:-50px; padding:0px; ">
											<?php
												$MonthAlpha = date("M");
												$curYear = date("Y");
											?>
											<div class="color1_restaurant" style="margin:0px; padding:0px;"></div>
											<div class="year_res" id="monthdisp">
												<a id="prev_monthhh" class="prevDate_Lafourchette" href="javascript: ">&lt;</a>
												<span id="cur_calll" ><?php echo $MonthAlpha . "-" . $curYear
													?></span>
												<a id="next_monthhh" class="prevDate_Lafourchette" href="javascript: ">&gt;</a>
											</div>
											<div class="navcalendar_res"></div>
											<div id="displayed_cal"></div>
										</div>
									</li>
								</ul>
								
							</div>
							<ul class="form_fields_container">
								<li>
									<label> Block Time:</label>
									<div class="form_input">
										<input  id="radioblockdays" name="radioblock" checked='checked' onchange="return blockdays(this);" value="blkdays" type="radio"  />
										<label for="radioblockdays">Block Days</label>
										<br />
										<input  id="radioblockhours" name="radioblock"  onchange="return blockdays(this);" value="blkhours"   type="radio"  />
										<label for="radioblockhours">Block Hours</label>
									</div>
								</li>
							</ul>
							<div id="divblkcal" >
								<ul class="form_fields_container">
									<li >
										<label> Start Date :</label>
										<div class="form_input demo">
											<input type="text" id="from"  name="from"/>
										</div>
									</li>
									<li>
										<label> End Date :</label>
										<div class="form_input demo">
											<input type="text"  id="to" name="to"/>
										</div>
									</li>
									<li>
										<div >
											<a href="#" class="greyishBtn button_small" id="block_dt"  onclick="return block_dat();"  name="block_dt" style="margin-left: 105px;">Save Details</a>
										</div>
									</li>
								</ul>
							</div>
							<div id="divcont" style="display:none;">
								<ul class="form_fields_container">
									<li>
										<div style="display:none;margin-left:140px;" id="maindisptime" class="contentcalendar_res" style="margin-top:-50px; padding:0px; ">
											<?php
												$MonthAlpha = date("M");
												$curYear = date("Y");
											?>
											<div class="color1_restaurant" style="margin:0px; padding:0px;"></div>
											<div class="year_res" id="monthdisp">
												<a id="prev_monthhh" class="prevDate_Lafourchette" href="javascript: ">&lt;</a>
												<span id="cur_calll" ><?php echo $MonthAlpha . "-" . $curYear
													?></span>
												<a id="next_monthhh" class="prevDate_Lafourchette" href="javascript: ">&gt;</a>
											</div>
											<div class="navcalendar_res"></div>
											<div id="displayed_cal"></div>
										</div>
									</li>
								</ul>
								<ul id="blktimecontrols" class="form_fields_container"></ul>
							</div>
						</div>
					</div>
				</div>
				<div style="width:600px;display:none;" id="Editemployee">
					<div class="msgbar msg_Success hide_onC" id="successedd" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
						<span class="iconsweet">=</span>
						<p>
							Employee has been Successfully Edited.
						</p>
					</div>
					<div class="widget-wp-obs" style="margin:5px;">
						<div class="widget-wp-obs_title">
							<span class="iconsweet">o</span>
							<h5> Edit Employee</h5>
						</div>
						<div class="widget-wp-obs_body">
							<ul class="form_fields_container">
								<li>
									<label> Emp Code : </label>
									<div class="form_input" style="width:75%" >
										<input type="text" name="employeeditCode" id="employeeditCode" value="" disabled="disabled" />
									</div>
								</li>
								<li>
								<label> Color Code :</label>
								<div class="form_input" style="width:70%">
									<input type="text" name="color2" id="color2" class="color-picker" size="6" autocomplete="on" maxlength="10" />
								</div>
							</li>
								</li>
								<li>
									<label> Name <span style="color: red">*</span> : </label>
									<div class="form_input" >
										<input type="text" onBlur="return editEmployeeNameBlur();" name="employeeditName" id="employeeditName" />
									</div>
								</li>
								<li>
									<label> E-mail <span style="color: red">*</span> :</label>
									<div class="form_input" >
										<input type="text" onBlur="return editEmployeeEmailBlur();" name="employeeditEmail" id="employeeditEmail" />
									</div>
								</li>
								<li>
									<label> Phone :</label>
									<div class="form_input" >
										<input type="text" onBlur="return editEmployeePhoneBlur();" name="employeeeditPhone" id="employeeeditPhone" onKeyPress="return validatePhone(event,this)"/>
									</div>
								</li>
								<li>
									<label> Status : </label>
									<div class="form_input" >
										<input id="editeStatusOpen" name="editStatus" type="radio" value="Active"  style="width:auto !important">
										<label for="editStatus"> Active</label>
										<br />
										<input id="editeStatusClose" name="editStatus" type="radio" value="In Active"  style="width:auto !important">
										<label for="editStatus">InActive</label>
									</div>
								</li>
								
								<li style="padding-bottom:10px;padding-top:10px;">
									<div style="margin-left:125px;">
										<input type="hidden" id="empidf" value=""/>
										<a href="#" class="greyishBtn button_small" onClick="update();">Update Details</a>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				</div>
<?php }?>
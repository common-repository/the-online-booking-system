<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-load.php' );
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' ); 
 global $wpdb;
	$title=get_bloginfo('name');
    $client_name = esc_attr($_REQUEST['bname']);
	$last_name = esc_attr($_REQUEST['lname']);
    $client_email = esc_attr($_REQUEST['bemail']);
    $client_mobile = intval($_REQUEST['bmobile']);
    $time = explode(":", esc_attr($_REQUEST['btime']));
	$bad1 = esc_attr($_REQUEST['bad1']);
	$bserviceid = intval($_REQUEST['bservice']);
	$sertimeeee = $wpdb->get_row
	(
      	$wpdb->prepare
      	(	
           		"SELECT hours,minutes FROM ".$wpdb->prefix."sm_services_time WHERE service_id = %d ",
           		$bserviceid
      	)
	);
	
    $curdate =  $wpdb->get_var("SELECT STR_TO_DATE('". intval($_REQUEST['byear']) . "," . intval($_REQUEST['bmonth']) . "," . intval($_REQUEST['bday']) . "','%Y,%m,%d')");
	$hour = $time[0];
    $minute = $time[1];
	$sttime=$curdate." ".$hour.":".$minute.":00";
	$ethour=$sertimeeee->hours+$hour;	
	$etmins=$sertimeeee->minutes+$minute;
	if($etmins>45)
	{
		$ethour++;
		$etmins="00";
	}
	if($etmins<10)
	{
		$etmins="0".$etmins;
	}
	if($ethour<10)
	{
		$ethour="0".$ethour;
	}
	$etime=$curdate." ".$ethour.":".$etmins.":00";

	$admin_email = get_settings('admin_email');
		
		$table_name = $wpdb->prefix . "sm_clients";
        $existing_client = $wpdb->get_var('SELECT count(email) FROM ' . $table_name . ' WHERE email = ' . '"' . $client_email . '"');		
	    $curdate =  $wpdb->get_var("SELECT STR_TO_DATE('". intval($_REQUEST['byear']) . "," . intval($_REQUEST['bmonth']) . "," . intval($_REQUEST['bday']) . "','%Y,%m,%d')");
		$existing_client_id = $wpdb->get_var('SELECT id FROM ' . $table_name . ' WHERE email = ' . '"' . $client_email . '"');		
		
		$table_name = $wpdb->prefix . "sm_bookings";
		$empid=intval($_REQUEST['empnam']);
		$empcolor=$wpdb->get_var("SELECT emp_color FROM ". $wpdb->prefix . sm_employees. ' where id='.'"'.intval($_REQUEST['empnam']).'"');
		$wpdb->query
        (
               $wpdb->prepare
               (
                       "INSERT INTO ".$wpdb->prefix."sm_bookings (service_id,client_id,day,month,year,hour,minute,Date,emp_id,status,StartTime,EndTime,color) VALUES( %d, %d, %d, %d, %d, %d, %d, '$curdate', %d, %s, '$sttime', '$etime', %s )",
                       intval($_REQUEST['bservice']),
                       $existing_client_id,
                       intval($_REQUEST['bday']),
                       intval($_REQUEST['bmonth']),
                       intval($_REQUEST['byear']),
                       $hour,
                       $minute,
                       $empid,
                       "Approved",
					   $empcolor
                )
        );
		
		$emial = esc_attr($_REQUEST['em']);
		if($emial == 1)
		{
		
			$day = intval($_REQUEST['bday']);
			$month = intval($_REQUEST['bmonth']);
			$year = intval($_REQUEST['byear']);
			$hour = $time[0];
			$minute = $time[1];
			$emp_nam=$wpdb->get_var("SELECT emp_name From  " . $wpdb->prefix . sm_employees . " WHERE id =". '"' . intval($_REQUEST['empnam']) . '"'); 
			$emp_email=$wpdb->get_var("SELECT email From  " . $wpdb->prefix . sm_employees . " WHERE id =". '"' . intval($_REQUEST['empnam']) . '"'); 
			$lastnam = $wpdb->get_var("SELECT lastname From  " . $wpdb->prefix . sm_clients . " WHERE id =". '"' . $existing_client_id . '"'); 		 
			$name = $wpdb->get_var("SELECT name From  " . $wpdb->prefix . sm_clients . "  WHERE id =". '"' . $existing_client_id . '"');        
			$email = $wpdb->get_var("SELECT email From   " . $wpdb->prefix . sm_clients . "  WHERE id =". '"' .  $existing_client_id . '"');	      
			$telephone = $wpdb->get_var("SELECT mobile From   " . $wpdb->prefix . sm_clients . " WHERE id =". '"' .  $existing_client_id . '"');
			$ser_name = $wpdb->get_var("SELECT name From  " . $wpdb->prefix . sm_services . "  WHERE id =". '"' .  intval($_REQUEST['bservice']) . '"');		 
			$table_name = $wpdb->prefix . "sm_email_signature";
			$em_sign= $wpdb->get_var('SELECT initial  FROM ' . $table_name);
			$e_content = $wpdb->get_var('SELECT content FROM  ' . $wpdb->prefix . sm_emails . ' WHERE type = ' . '"' . "single_client_confirm" . '"');	
		    $subject = $wpdb->get_var('SELECT subject FROM   ' . $wpdb->prefix . sm_emails . ' WHERE type = ' . '"' . "single_client_confirm" . '"');			 
		    
			$textual_month = date('M',mktime(0,0,0,$month,$day,$year));
	        $date = $day." ".$textual_month." ".$year;
			
	        $time1 = $hour.":".$minute;
			$customer_app_confirm = $wpdb->get_var('SELECT app_confirm FROM ' . $wpdb->prefix . sm_customer_notifications);
			if($customer_app_confirm==1)
			{
				$to = $email;
		        $message_1 = str_replace("[client_name]", $name, $e_content);
		        $message_2 = str_replace("[service_name]", $ser_name, $message_1);
		        $message_3 = str_replace("[booked_time]", $time1, $message_2);
				$message_4 = str_replace("[employee_name]", $emp_nam, $message_3);
				$message_5 = str_replace("[signature]", $em_sign, $message_4);
				$message_6 = str_replace("[companyName]", $title, $message_5);
		        $message = str_replace("[booked_date]", $date, $message_6);
				$staff_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $wpdb->prefix . sm_staff_notifications);
				if($staff_app_booked==1)
				{
					$headers = "From: " .$title. "<". $admin_email . ">". "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=utf-8\r\n";
					$headers .="Content-transfer-encoding: BASE64 | Quoted-Printable";
					$headers .= "Bcc: ".$emp_email . "\r\n";
				}
				else
				{
					$headers = "From: " .$title. "<". $admin_email . ">". "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=utf-8\r\n";
					$headers .="Content-transfer-encoding: BASE64 | Quoted-Printable";
				}
				echo "<p style=\"color: green; font-style: italic; clear: both;\">Booking has been approved successfully.
		        <br /><br />
		        Booking Details:
		        <br />
		        <br />
		        Client Name: ".$name."
		        <br />
		        Client Email: ".$email."
		        <br />
		        Client Mobile Number: ".$telephone."
		        <br />
		        Booking Date: ".$date."
		        <br />
		        Booking Time: ".$time1."
				</p>";
				mail($to,$subject,$message,$headers); 
			}
			else
			{
				$to = $emp_email;
				$message_1 = str_replace("[client_name]", $name, $e_content);
		        $message_2 = str_replace("[service_name]", $ser_name, $message_1);
		        $message_3 = str_replace("[booked_time]", $time1, $message_2);
				$message_4 = str_replace("[employee_name]", $emp_nam, $message_3);
				$message_5 = str_replace("[signature]", $em_sign, $message_4);
				$message_6 = str_replace("[companyName]", $title, $message_5);
		        $message  =   str_replace("[booked_date]", $date, $message_6);
				$headers = "From: " .$title. "<". $admin_email . ">". "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				$headers .="Content-transfer-encoding: BASE64 | Quoted-Printable";
				
				echo "<p style=\"color: green; font-style: italic; clear: both;\">Booking has been approved successfully.
		        <br /><br />
		        Booking Details:
		        <br />
		        <br />
		        Client Name: ".$name."
		        <br />
		        Client Email: ".$email."
		        <br />
		        Client Mobile Number: ".$telephone."
		        <br />
		        Booking Date: ".$date."
		        <br />
		        Booking Time: ".$time1."
				</p>";
				$staff_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $wpdb->prefix . sm_staff_notifications);
				if($staff_app_booked==1)
				{
					 mail($to,$subject,$message,$headers); 
				}		
			}			
		}			
?>
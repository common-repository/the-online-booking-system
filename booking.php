<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-load.php' );
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
 global $wpdb;
 $url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<?php
 $admin_email = get_settings('admin_email');	
 $table_name = $wpdb->prefix . "sm_services";
 $booked_service_name = $wpdb->get_var('SELECT name FROM ' . $table_name . ' WHERE id = ' . '"' . intval($_REQUEST['bservice']) . '"');
 $date = intval($_REQUEST['bday'])."/".intval($_REQUEST['bmonth'])."/".intval($_REQUEST['byear']);
 $table_name = $wpdb->prefix . "sm_emails";
 $message_stored = $wpdb->get_var('SELECT content  FROM ' . $table_name . ' WHERE type = ' . '"' . "single_client" . '"');
 $subject_stored = $wpdb->get_var('SELECT subject  FROM ' . $table_name . ' WHERE type = ' . '"' . "single_client" . '"');
 $table_name = $wpdb->prefix . "sm_email_signature";
 $em_signature= $wpdb->get_var('SELECT initial  FROM ' . $table_name);
 $title=get_bloginfo('name');
 $table_name = $wpdb->prefix . "sm_employees";
 $emp_nam = $wpdb->get_var('SELECT emp_name  FROM ' . $table_name . ' WHERE id = ' . '"' . esc_attr($_REQUEST['empnam']) . '"');
 $emp_email = $wpdb->get_var('SELECT email  FROM ' . $table_name . ' WHERE id = ' . '"' . esc_attr($_REQUEST['empnam']) . '"');
 $message_1 = str_replace("[client_name]", esc_attr($_REQUEST['bname']), $message_stored);
 $message_2 = str_replace("[service_name]", $booked_service_name, $message_1);
 $message_5 = str_replace("[booked_time]", esc_html($_REQUEST['btime']), $message_2);
 $message_6 = str_replace("[signature]", $em_signature, $message_5);
 $message_7 = str_replace("[companyName]", $title, $message_6);
 $message_8 = str_replace("[employee_name]", $emp_nam, $message_7);
 $message_final = str_replace("[booked_date]", $date, $message_8);
 $client_name = esc_attr($_REQUEST['bname']);
 $last_name = esc_attr($_REQUEST['lname']);
 $client_email = esc_attr($_REQUEST['bemail']);
 $client_mobile = esc_attr($_REQUEST['bmobile']);
 $time = explode(":", esc_html($_REQUEST['btime']));
 
 $bad1 = esc_attr($_REQUEST['bad1']);
 $table_name = $wpdb->prefix . "sm_services_time";
 $servid = intval($_REQUEST['bservice']);
 $sertimeeee = $wpdb->get_row
 (
	  $wpdb->prepare
	  (
			"SELECT hours,minutes FROM ".$wpdb->prefix."sm_services_time WHERE service_id = %d",
			$servid
	   )
 );	
 $curdate =  $wpdb->get_var("SELECT STR_TO_DATE('". intval($_REQUEST['byear']) . "," . intval($_REQUEST['bmonth']) . "," . intval($_REQUEST['bday']) . "','%Y,%m,%d')");
 $hour = $time[0];
 $minute = $time[1];

 $sttime= $curdate." ".$hour.":".$minute.":00";
 $timestamp = strtotime($sttime);
 $myDate = date( 'y-m-d  h:i:s', $sttime );
 //echo $timestamp;
 $ethour=$sertimeeee->hours+$hour;	
 $etmins=$sertimeeee->minutes+$minute;
 $table_name = $wpdb->prefix . "sm_settings";
 $minformat = $wpdb->get_var('SELECT minuteformat  FROM ' . $table_name );
 if($minformat==0)
 {
		if($etmins>30)
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
 }
 else
 {
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
 }
	$etime=$curdate." ".$ethour.":".$etmins.":00";
	
	$bad2 = esc_attr($_REQUEST['bad2']);
	$bcity = esc_attr($_REQUEST['bcity']);
	$bpc = esc_attr($_REQUEST['bpc']);
	$bcountry = esc_attr($_REQUEST['bcountry']);	
    $hour = $time[0];
    $minute = $time[1];
	$time = $hour ." : " . $minute;
    $message_admin= "Booking Details:
    <br />
    <br />
    Client Name: $client_name
    <br />
    Client Email: $client_email
    <br />
    Client Mobile Number: $client_mobile
    <br />
    Booking Date: $date
    <br />
	Booking Time: $hour:$minute
    <br />
	Booking Service Name: $booked_service_name
    <br />
    Booking Service Provider: $emp_nam";	
	$headers = "From: " .$title. "<". $admin_email . ">". "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=utf-8\r\n";
	$headers .="Content-transfer-encoding: BASE64 | Quoted-Printable";
	$to = esc_attr($_REQUEST['bemail']);	
	$table_name = $wpdb->prefix . "sm_customer_notifications";
	$customer_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $table_name);
	if($customer_app_booked == 1)
	{
			
			mail($to,$subject_stored,$message_final,$headers);
	}
    if($last_name=="undefined")
	{
			$last_name="";
	}
	if($client_mobile=="undefined")
	{
			$client_mobile="";
	}
	if($bad1=="undefined")
	{
			$bad1="";
	}
	if($bad2=="undefined")
	{
			$bad2="";
	}
	if($bcity=="undefined")
	{
			$bcity="";
	}
	if($bpc=="undefined")
		{
			$bpc="";
		}
	if($bcountry=="undefined")
	{
			$bcountry="";
	}
	if($phn=="undefined")
	{
			$phn="";
	}
    $table_name = $wpdb->prefix . "sm_clients";
    $existing_client = $wpdb->get_var('SELECT count(email) FROM ' . $table_name . ' WHERE email = ' . '"' . $client_email . '"');		
	$curdate =  $wpdb->get_var("SELECT STR_TO_DATE('". intval($_REQUEST['byear']) . "," . intval($_REQUEST['bmonth']) . "," . intval($_REQUEST['bday']) . "','%Y,%m,%d')");
	if($existing_client>0)
	{
			$existing_client_id = $wpdb->get_var('SELECT id FROM ' . $table_name . ' WHERE email = ' . '"' . $client_email . '"');		
			$add1 = $wpdb->get_var('SELECT addressLine1 FROM ' . $table_name . ' WHERE email = ' . '"' . $client_email . '"');		
				
		
		if($add1=="")
		{
			$wpdb->query
		     (
		            $wpdb->prepare
		            (
		                    "UPDATE ".$wpdb->prefix."sm_clients SET telephone = %s, addressLine1 = %s, addressLine2 = %s, city= %s, country = %s, postalcode = %s  WHERE id = %d",
		                    $client_mobile,
		                    $bad1,
		                    $bad2,
		                    $bcity,
		                    $bcountry,
		                    $bpc,
		                    $existing_client_id
		             )
		      );	
		}
		$table_name = $wpdb->prefix . "sm_bookings";
		$empid=intval($_REQUEST['empnam']);
		$empcolor=$wpdb->get_var("SELECT emp_color FROM ". $wpdb->prefix . sm_employees. ' where id='.'"'.intval($_REQUEST['empnam']).'"');
		$countt=$wpdb->get_var("SELECT count(id) FROM ". $wpdb->prefix . sm_bookings. ' where StartTime ='.'"'.$sttime.'"'.' and EndTime  ='.'"'.$etime.'"'.' and emp_id ='.'"'.$empid.'"'.' and service_id  ='.'"'. intval($_REQUEST['bservice']).'"'.' and status = Approval Pending');
	    if($countt==0)
		{
			$wpdb->query
	            (
	                  $wpdb->prepare
	                  (
	                       "INSERT INTO ".$wpdb->prefix."sm_bookings (service_id,client_id,day,month,year,emp_id,hour,minute,Date,status,StartTime,EndTime,color) VALUES( %d, %d, %d, %d, %d, %d, %d, %d, '$curdate', %s, '$sttime', '$etime', %s )",
	                       intval($_REQUEST['bservice']),
	                       $existing_client_id,
	                       intval($_REQUEST['bday']),
	                       intval($_REQUEST['bmonth']),
	                       intval($_REQUEST['byear']),
	                       $empid,
	                       $hour,
	                       $minute,
	                       "Approval Pending",
	                       $empcolor
	                   )
	            );
		}
		$table_name = $wpdb->prefix . "sm_emails";
	    $msg_stored = $wpdb->get_var('SELECT content  FROM ' . $table_name . ' WHERE type = ' . '"' . "admin" . '"');
		$msg_sub = $wpdb->get_var('SELECT subject FROM ' . $table_name . ' WHERE type = ' . '"' . "admin" . '"');
	    $msg_1 = str_replace("[client_name]", esc_attr($_REQUEST['bname']), $msg_stored);
	    $msg_2 = str_replace("[service_name]", $booked_service_name, $msg_1);
	    $msg_3 = str_replace("[booked_time]", esc_html($_REQUEST['btime']), $msg_2);
	    $msg_4= str_replace("[booked_date]", $date, $msg_3);
	    $b_id = $wpdb->get_col
		(
			$wpdb->prepare
			(
				  "SELECT id FROM ".$wpdb->prefix."sm_bookings ORDER BY id DESC"
			)
		);	
	    $approve = "<a href=\"$url\confirm.php?actionappbok=approve&id=".$b_id[0]."\">Approve Booking</a>";
	    $msg_5 = str_replace("[approve]", $approve, $msg_4);
	    $disapprove = "<a href=\"$url\confirm_disapprove.php?action=disapprove&booking=".$b_id[0]."\">Disapprove Booking</a>";
	    $msg_6 = str_replace("[deny]", $disapprove, $msg_5);
		$msg_7 = str_replace("[email_address]", $client_email, $msg_6);
		$msg_8 = str_replace("[mobile_number]", $client_mobile, $msg_7);		
	    $textual_month = date('M',mktime(0,0,0,esc_attr($_REQUEST['bmonth']),esc_attr($_REQUEST['bday']),esc_attr($_REQUEST['byear'])));
	    $date = intval($_REQUEST['bday'])." ".$textual_month." ".intval($_REQUEST['byear']);
		$table_name = $wpdb->prefix . "sm_staff_notifications";
		$staff_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $table_name);
		
		mail($admin_email, $msg_sub, $msg_8, $headers);
	} 
	else
	{
	    $phn=esc_attr($_REQUEST['phone']);
		if($last_name=="undefined")
		{
			$last_name="";
		}
		if($client_mobile=="undefined")
		{
			$client_mobile="";
		}
		if($bad1=="undefined")
		{
			$bad1="";
		}
		if($bad2=="undefined")
		{
			$bad2="";
		}
		if($bcity=="undefined")
		{
			$bcity="";
		}
		if($bpc=="undefined")
		{
			$bpc="";
		}
		if($bcountry=="undefined")
		{
			$bcountry="";
		}
		if($phn=="undefined")
		{
			$phn="";
		}
		
		$wpdb->query
        (
                  $wpdb->prepare
                  (
                       "INSERT INTO ".$wpdb->prefix."sm_clients (name,lastname,email,mobile,addressLine1,addressLine2,city,postalcode,country,telephone) VALUES( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
                       $client_name,
                       $last_name,
                       $client_email,
                       $client_mobile,
                       $bad1,
                       $bad2,
                       $bcity,
                       $bpc,
                       $bcountry,
                       $phn
                   )
        );
		$c_id = $wpdb->insert_id;
        $new_client_id = $wpdb->get_var('SELECT id FROM ' . $table_name . ' WHERE email = ' . '"' . $client_email . '"');
        $table_name = $wpdb->prefix . "sm_bookings";
		$empid=intval($_REQUEST['empnam']);	
		$empcolor=$wpdb->get_var("SELECT emp_color FROM ". $wpdb->prefix . sm_employees. ' where id='.'"'.intval($_REQUEST['empnam']).'"');
        $serr = intval($_REQUEST['bservice']);
		$dayy = intval($_REQUEST['bday']);
		$mont = intval($_REQUEST['bmonth']);
		$yea = intval($_REQUEST['byear']);
		
        $wpdb->query
        (
               $wpdb->prepare
               (
                       "INSERT INTO ".$wpdb->prefix."sm_bookings (service_id,client_id,day,month,year,hour,minute,Date,emp_id,status,StartTime,EndTime,color) VALUES( %d, %d, %d, %d, %d, %d, %d, '$curdate', %d, %s, '$sttime', '$etime', %s )",
                       $serr,
                       $new_client_id,
                       $dayy,
                       $mont,
                       $yea,
                       $hour,
                       $minute,
                       $empid,
                       "Approval Pending",
					   $empcolor
                )
        );
        $table_name = $wpdb->prefix . "sm_emails";
        $msg_stored = $wpdb->get_var('SELECT content  FROM ' . $table_name . ' WHERE type = ' . '"' . "admin" . '"');
		$msg_subject = $wpdb->get_var('SELECT subject FROM ' . $table_name . ' WHERE type = ' . '"' . "admin" . '"');
        $msg_1 = str_replace("[client_name]", esc_attr($_REQUEST['bname']), $msg_stored);
        $msg_2 = str_replace("[service_name]", $booked_service_name, $msg_1);
        $msg_3 = str_replace("[booked_time]", esc_html($_REQUEST['btime']), $msg_2);
        $msg_4 = str_replace("[booked_date]", $date, $msg_3);
        $b_id = $wpdb->get_col
		(
			$wpdb->prepare
			(
				  "SELECT id FROM ".$wpdb->prefix."sm_bookings ORDER BY id DESC"
			)
		);	
        $approve = "<a href=\"$url\confirm.php?actionappbok=approve&id=".$b_id[0]."\">Approve Booking</a>";
        $msg_5 = str_replace("[approve]", $approve, $msg_4);
        $disapprove = "<a href=\"$url\confirm_disapprove.php?action=disapprove&booking=".$b_id[0]."\">Disapprove Booking</a>";
        $msg_6 = str_replace("[deny]", $disapprove, $msg_5);
		$msg_7 = str_replace("[email_address]", $client_email, $msg_6);
		$msg_8 = str_replace("[mobile_number]", $client_mobile, $msg_7);
        $textual_month = date('M',mktime(0,0,0,intval($_REQUEST['bmonth']),intval($_REQUEST['bday']),intval($_REQUEST['byear'])));
        $date = intval($_REQUEST['bday'])." ".$textual_month." ".intval($_REQUEST['byear']); 
		$table_name = $wpdb->prefix . "sm_staff_notifications";
		$staff_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $table_name);
		
		mail($admin_email,$msg_subject,$msg_8,$headers);	
	}
?>
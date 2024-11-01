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
 $booked_service_name = $wpdb->get_var('SELECT name FROM ' . $table_name . ' WHERE id = ' . '"' . intval($_REQUEST['service']) . '"');
 $date = intval($_REQUEST['day'])."/". intval($_REQUEST['month'])."/".intval($_REQUEST['year']);
 $table_name = $wpdb->prefix . "sm_emails";
 $message_stored = $wpdb->get_var('SELECT content  FROM ' . $table_name . ' WHERE type = ' . '"' . "single_client" . '"');
 $subject_stored = $wpdb->get_var('SELECT subject  FROM ' . $table_name . ' WHERE type = ' . '"' . "single_client" . '"');
 $table_name = $wpdb->prefix . "sm_email_signature";
 $em_signature= $wpdb->get_var('SELECT initial  FROM ' . $table_name);
 $title=get_bloginfo('name');
 $table_name = $wpdb->prefix . "sm_employees";
 $emp_nam = $wpdb->get_var('SELECT emp_name  FROM ' . $table_name . ' WHERE id = ' . '"' . intval($_REQUEST['emp']) . '"');
 $emp_email = $wpdb->get_var('SELECT email  FROM ' . $table_name . ' WHERE id = ' . '"' . intval($_REQUEST['emp']) . '"');

	//$client_name = ;// query fetch from database
	if(isset($_REQUEST['email']))
	{
		if($_REQUEST['email']!="" &&  $_REQUEST['email']!="undefined")
		{
			$client_email = esc_attr($_REQUEST['email']);
			$table_name = $wpdb->prefix . "sm_clients";
			$client_name = $wpdb->get_var('SELECT name  FROM ' . $table_name . ' WHERE email = ' . '"' . esc_attr($_REQUEST['email']) . '"');
		}
	}
	if(isset($_REQUEST['lname']))
	{
		if($_REQUEST['lname']!="" &&  $_REQUEST['lname']!="undefined")
		{
			$client_lastname = esc_attr($_REQUEST['lname']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_clients SET lastname = %s WHERE email = %s",
	                    $client_lastname,
	                    $client_email
	             )
	      	);	
		}
	}
	if(isset($_REQUEST['mobileNum']))
	{
		if($_REQUEST['mobileNum']!="" &&  $_REQUEST['mobileNum']!="undefined")
		{
			$client_mobile = esc_attr($_REQUEST['mobileNum']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_clients SET mobile = %s WHERE email = %s",
	                    $client_mobile,
	                    $client_email
	             )
	      	);	
		}
		else
		{
			$table_name = $wpdb->prefix . "sm_clients";
			$client_mobile = $wpdb->get_var('SELECT mobile  FROM ' . $table_name . ' WHERE email = ' . '"' . esc_attr($_REQUEST['email']) . '"');
		}
	}
	else
	{
		$table_name = $wpdb->prefix . "sm_clients";
		$client_mobile = $wpdb->get_var('SELECT mobile  FROM ' . $table_name . ' WHERE email = ' . '"' . esc_attr($_REQUEST['email']) . '"');
	}
	
	
	if(isset($_REQUEST['phone']))
	{
		if($_REQUEST['phone']!="" &&  $_REQUEST['phone']!="undefined")
		{
			$phone = esc_attr($_REQUEST['phone']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_clients SET telephone = %s WHERE email = %s",
	                    $phone,
	                    $client_email
	             )
	      	);	
		}
	}
	
	if(isset($_REQUEST['adress1']))
	{
		if($_REQUEST['adress1']!="" &&  $_REQUEST['adress1']!="undefined")
		{
			$add1 = esc_attr($_REQUEST['adress1']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_clients SET addressLine1 = %s WHERE email = %s",
	                    $add1,
	                    $client_email
	             )
	      	);	
		}
	}
	if(isset($_REQUEST['address2']))
	{
		if($_REQUEST['address2']!="" &&  $_REQUEST['address2']!="undefined")
		{
			$add2 = esc_attr($_REQUEST['address2']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_clients SET addressLine2 = %s WHERE email = %s",
	                    $add2,
	                    $client_email
	             )
	      	);	
		}
	}
	
	if(isset($_REQUEST['city']))
	{
		if($_REQUEST['city']!="" &&  $_REQUEST['city']!="undefined")
		{
			$city = esc_attr($_REQUEST['city']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_clients SET city = %s WHERE email = %s",
	                    $city,
	                    $client_email
	             )
	      	);
		}
	}
	if(isset($_REQUEST['zip']))
	{
		if($_REQUEST['zip']!="" && $_REQUEST['zip']!="undefined")
		{
			$zip = esc_attr($_REQUEST['zip']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_clients SET postalcode = %s WHERE email = %s",
	                    $zip,
	                    $client_email
	             )
	      	);
		}
	}
	if(isset($_REQUEST['country']))
	{
		if($_REQUEST['country']!="" &&  $_REQUEST['country']!="undefined")
		{
			$country = esc_attr($_REQUEST['country']);
			$wpdb->query
	     	(
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_clients SET country = %s WHERE email = %s",
	                    $country,
	                    $client_email
	             )
	      	);
		}
	}
    $message_1 = str_replace("[client_name]", $client_name, $message_stored);
    $message_2 = str_replace("[service_name]", $booked_service_name, $message_1);
    $message_5 = str_replace("[booked_time]", esc_html($_REQUEST['btime']), $message_2);
	$message_6 = str_replace("[signature]", $em_signature, $message_5);
	$message_7 = str_replace("[companyName]", $title, $message_6);
	$message_8 = str_replace("[employee_name]", $emp_nam, $message_7);
    $message_final = str_replace("[booked_date]", $date, $message_8);
	$time = explode(":", esc_html($_REQUEST['btime']));
	$servid = intval($_REQUEST['service']);
	$sertimeeee = $wpdb->get_row
	(
			$wpdb->prepare
			(
				   "SELECT hours,minutes FROM ".$wpdb->prefix."sm_services_time WHERE service_id = %d",
				    $servid
			)
	);	
	$curdate =  $wpdb->get_var("SELECT STR_TO_DATE('". intval($_REQUEST['year']) . "," . intval($_REQUEST['month']) . "," . intval($_REQUEST['day']) . "','%Y,%m,%d')");
    $hour = $time[0];
    $minute = $time[1];
	$sttime=$curdate." ".$hour.":".$minute.":00";
	$ethour=$sertimeeee->hours+$hour;	
	$etmins=$sertimeeee->minutes+$minute;
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
	$etime=$curdate." ".$ethour.":".$etmins.":00";
	$bcountry = esc_attr($_REQUEST['country']);	
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
		$to = $client_email;	
		$table_name = $wpdb->prefix . "sm_customer_notifications";
		$customer_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $table_name);
		if($customer_app_booked==1)
		{
			mail($to,$subject_stored,$message_final,$headers);
		}
        $table_name = $wpdb->prefix . "sm_clients";
       	$curdate =  $wpdb->get_var("SELECT STR_TO_DATE('". intval($_REQUEST['year']) . "," . intval($_REQUEST['month']) . "," . intval($_REQUEST['day']) . "','%Y,%m,%d')");
		$existing_client_id = $wpdb->get_var('SELECT id FROM ' . $table_name . ' WHERE email = ' . '"' . $client_email . '"');
		$table_name = $wpdb->prefix . "sm_bookings";
		$empid=intval($_REQUEST['empnam']);
		$empcolor=$wpdb->get_var("SELECT emp_color FROM ". $wpdb->prefix . sm_employees. ' where id='.'"'.intval($_REQUEST['emp']).'"');
		$countt=$wpdb->get_var("SELECT count(id) FROM ". $wpdb->prefix . sm_bookings. ' where StartTime ='.'"'.$sttime.'"'.' and EndTime  ='.'"'.$etime.'"'.' and emp_id ='.'"'.intval($_REQUEST['emp']).'"'.' and service_id  ='.'"'. intval($_REQUEST['service']).'"'.' and status = Approval Pending');
        if($countt==0)
		{
			$serviceid = intval($_REQUEST['service']);
			$wpdb->query
            (
                  $wpdb->prepare
                  (
                       "INSERT INTO ".$wpdb->prefix."sm_bookings (service_id,client_id,day,month,year,emp_id,hour,minute,Date,status,StartTime,EndTime,color) VALUES( %d, %d, %d, %d, %d, %d, %d, %d, '$curdate', %s, '$sttime', '$etime', %s )",
                       $serviceid,
                       $existing_client_id,
                       intval($_REQUEST['day']),
                       intval($_REQUEST['month']),
                       intval($_REQUEST['year']),
                       intval($_REQUEST['emp']),
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
        $msg_1 = str_replace("[client_name]", $client_name, $msg_stored);
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
        $textual_month = date('M',mktime(0,0,0,intval($_REQUEST['month']),intval($_REQUEST['day']),intval($_REQUEST['year'])));
        $date = intval($_REQUEST['day'])." ".$textual_month." ".intval($_REQUEST['year']);
		$table_name = $wpdb->prefix . "sm_staff_notifications";
		$staff_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $table_name);
		
		mail($admin_email, $msg_sub, $msg_8, $headers);
?>
<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<?php
$title=get_bloginfo('name');
  if(isset($_REQUEST['hidid']))
  {
  		$dat =  intval($_REQUEST['hidid']);
		$wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpdb->prefix."sm_bookings WHERE id = %d;", $dat ));
		
  }
  else
  {
		$serid=intval($_REQUEST['serid']);
		$client_id=intval($_REQUEST['clientnam']);
		$day=intval($_REQUEST['day']);
		$month=intval($_REQUEST['month']);
		$year=intval($_REQUEST['year']);
		$hour=intval($_REQUEST['hourselect']);
		$minute=intval($_REQUEST['minss']);
		$empid=intval($_REQUEST['empid']);
		$strtdat=esc_attr($_REQUEST['dat']);
		$status=esc_attr($_REQUEST['bookingstatus']);
		$table_name = $wpdb->prefix . "sm_employees";
		$empcol = $wpdb->get_var('SELECT emp_color FROM ' . $table_name . ' WHERE id = ' . '"' . $empid . '"');
		$mystring=$strtdat;
		$mystring.=" ";
		$mystring.=$hour;
		$mystring.=":";
		$mystring.=$minute;
		$mystring.=":";
		$mystring.="00";
		$table_name = $wpdb->prefix . "sm_services_time";
		$booked_service_hrs = $wpdb->get_var('SELECT hours FROM ' . $table_name . ' WHERE service_id = ' . '"' . $serid . '"');
		$booked_service_min = $wpdb->get_var('SELECT minutes FROM ' . $table_name . ' WHERE service_id = ' . '"' . $serid . '"');
		$serend=$hour+$booked_service_hrs;
		$minnn=$minute+$booked_service_min;
		if($minnn>30)
		{
				$minnn=0;
				$serend++;
		}
		$mystringend=$strtdat;
		$mystringend.=" ";
		$mystringend.=$serend;
		$mystringend.=":";
		$mystringend.=$minnn;
		$mystringend.=":";
		$mystringend.="00";
		$edtid=intval($_REQUEST['editid']);
		if($edtid==0)
		{
			$wpdb->query
	        (
	                  $wpdb->prepare
	                  (
	                       "INSERT INTO ".$wpdb->prefix."sm_bookings(service_id,client_id,day,month,year,hour,minute,emp_id,status,StartTime,EndTime,Date,color) VALUES( %d, %d, %d, %d, %d, %d, %d, %d, %s, '$mystring', '$mystringend', '$strtdat', %s )",
	                       $serid,
	                       $client_id,
	                       $day,
	                       $month,
	                       $year,
	                       $hour,
	                       $minute,
	                       $empid,
	                       $status,
	                       $empcol
	                   )
	        );
		}
		else 
		{
		$wpdb->query
   		(
        	 $wpdb->prepare
        	 (
          	     "UPDATE ".$wpdb->prefix."sm_bookings SET StartTime = '$mystring', EndTime = '$mystringend', service_id = %d, color = %s, emp_id = %d, client_id = %d, day = %d, hour = %d, minute = %d, year = %d, Date = '$strtdat', status = %s, month = %d   WHERE id = %d",
          	     $serid,
          	     $empcol,
          	     $empid,
          	     $client_id,
          	     $day,
          	     $hour,
          	     $minute,
          	     $year,
          	     $status,
          	     $month,
          	     $edtid
          	     
          	     
        	 )
  		 );	
		}
	$emi = intval($_REQUEST['emi']);
	$status=esc_attr($_REQUEST['bookingstatus']);
	if($status=="Approved" && $emi==1)
	{
		 $edtid=intval($_REQUEST['editid']);
		 $status=esc_attr($_REQUEST['bookingstatus']);
		 $empid=intval($_REQUEST['empid']);
		 $admin_email = get_settings('admin_email');	
		 $wpdb->query
	     (
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_bookings SET status = %s WHERE id = %d",
	                    "Approved",
	                    $edtid
	             )
	      );	
      	 $client_id1 = $wpdb->get_var("SELECT client_id From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');
		 $service_id = $wpdb->get_var("SELECT service_id From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"'); 
         $empid=$wpdb->get_var("SELECT emp_id From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"'); 
         $emp_nam=$wpdb->get_var("SELECT emp_name From  " . $wpdb->prefix . sm_employees . " WHERE id =". '"' . $empid . '"');
		 $emp_email=$wpdb->get_var("SELECT email From  " . $wpdb->prefix . sm_employees . " WHERE id =". '"' . $empid . '"');		 
		 $day = $wpdb->get_var("SELECT day From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');				
		 $month = $wpdb->get_var("SELECT month From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');	 	  
		 $year = $wpdb->get_var("SELECT year From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');	
		 $hour = $wpdb->get_var("SELECT hour From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');	 
	     $minute = $wpdb->get_var("SELECT minute From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');
	     $lastnam = $wpdb->get_var("SELECT lastname From  " . $wpdb->prefix . sm_clients . " WHERE id =". '"' . $client_id . '"'); 		 
		
		 $name = $wpdb->get_var("SELECT name From  " . $wpdb->prefix . sm_clients . "  WHERE id =". '"' . $client_id . '"');        
		 $email = $wpdb->get_var("SELECT email From   " . $wpdb->prefix . sm_clients . "  WHERE id =". '"' .  $client_id . '"');	      
		 $ser_name = $wpdb->get_var("SELECT name From  " . $wpdb->prefix . sm_services . "  WHERE id =". '"' .  $serid . '"');		 
		 $table_name = $wpdb->prefix . "sm_email_signature";
		 $em_sign= $wpdb->get_var('SELECT initial  FROM ' . $table_name);
		 $e_content = $wpdb->get_var('SELECT content FROM  ' . $wpdb->prefix . sm_emails . ' WHERE type = ' . '"' . "single_client_confirm" . '"');	
	     $subject = $wpdb->get_var('SELECT subject FROM   ' . $wpdb->prefix . sm_emails . ' WHERE type = ' . '"' . "single_client_confirm" . '"');			 
	     $title=get_bloginfo('name');
		 $textual_month = date('M',mktime(0,0,0,$month,$day,$year));
         $date = $day." ".$textual_month." ".$year;
		 $to = $email;
         if($hour < 10)
		 {
            $hour = "0".$hour;
         }
         if($minute < 10)
		 {
            $minute = "0".$minute;			
         }
         $time = $hour.":".$minute;
		 $customer_app_confirm = $wpdb->get_var('SELECT app_confirm FROM ' . $wpdb->prefix . sm_customer_notifications);
		 if($customer_app_confirm==1)
		 {
				$message_1 = str_replace("[client_name]", $name, $e_content);
				$message_2 = str_replace("[service_name]", $ser_name, $message_1);
				$message_3 = str_replace("[booked_time]", $time, $message_2);
				$message_4 = str_replace("[employee_name]", $emp_nam, $message_3);
				$message_5 = str_replace("[signature]", $em_sign, $message_4);
				$message_6 = str_replace("[companyName]", $title, $message_5);
				$message  =   str_replace("[booked_date]", $date, $message_6);
				$staff_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $wpdb->prefix . sm_staff_notifications);
				if($staff_app_booked==1)
				{
					$headers = "From: " .$title. "<". $admin_email . ">". "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=utf-8\r\n";
					$headers .= "Bcc: ".$emp_email . "\r\n";
					$headers .="Content-transfer-encoding: BASE64 | Quoted-Printable";
					
				}
				else
				{
					$headers = "From: " .$title. "<". $admin_email . ">". "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=utf-8\r\n";
					$headers .="Content-transfer-encoding: BASE64 | Quoted-Printable";
				}
				mail($to,$subject,$message,$headers); 
			}	
			else
			{
				
				$message_1 = str_replace("[client_name]", $name, $e_content);
				$message_2 = str_replace("[service_name]", $ser_name, $message_1);
				$message_3 = str_replace("[booked_time]", $time, $message_2);
				$message_4 = str_replace("[employee_name]", $emp_nam, $message_3);
				$message_5 = str_replace("[signature]", $em_sign, $message_4);
				$message_6 = str_replace("[companyName]", $title, $message_5);
				$message  =  str_replace("[booked_date]", $date, $message_6);
				
				$headers = "From: " .$title. "<". $admin_email . ">". "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				$headers .="Content-transfer-encoding: BASE64 | Quoted-Printable";
				$staff_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $wpdb->prefix . sm_staff_notifications);
				if($staff_app_booked==1)
				{
					mail($emp_email,$subject,$message,$headers); 
				}
		}			
	}
	$emi = intval($_REQUEST['emi']);
	$status=esc_attr($_REQUEST['bookingstatus']);
	if($status=="Disapproved" && $emi==1)
	{
	    $edtid=intval($_REQUEST['editid']);
		$wpdb->query
	     (
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_bookings SET status = %s WHERE id = %d",
	                    "Disapproved",
	                    $edtid
	             )
	      );
	    
		echo "Disapproved";	   
        $admin_email = get_settings('admin_email');	
		$client_id = $wpdb->get_var("SELECT client_id From   " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');		
		$service_id = $wpdb->get_var("SELECT service_id From   " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"'); 
		$empid=$wpdb->get_var("SELECT emp_id From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"'); 
        $emp_nam=$wpdb->get_var("SELECT emp_name From  " . $wpdb->prefix . sm_employees . " WHERE id =". '"' . $empid . '"'); 
		$day = $wpdb->get_var("SELECT day From   " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');				
		$month = $wpdb->get_var("SELECT month From   " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');	 	 
		$year = $wpdb->get_var("SELECT year From   " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');	
		$hour = $wpdb->get_var("SELECT hour From   " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');	
		$minute = $wpdb->get_var("SELECT minute From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $edtid . '"');
		$name = $wpdb->get_var("SELECT name From  " . $wpdb->prefix . sm_clients . " WHERE id =". '"' . $client_id . '"');        
		$email = $wpdb->get_var("SELECT email From  " . $wpdb->prefix . sm_clients . " WHERE id =". '"' .  $client_id . '"');	     
	    $telephone = $wpdb->get_var("SELECT mobile From  " . $wpdb->prefix . sm_clients . " WHERE id =". '"' .  $client_id . '"');
		$service_name = $wpdb->get_var("SELECT name From  " . $wpdb->prefix . sm_services . " WHERE id =". '"' .  $service_id . '"');	    		
		$table_name = $wpdb->prefix . "sm_email_signature";
		$email_sign= $wpdb->get_var('SELECT initial  FROM ' . $table_name);
		$title=get_bloginfo('name');
		$textual_month = date('M',mktime(0,0,0,$month,$day,$year));
        $date = $day." ".$textual_month." ".$year;
        $to = $email;    
        if($hour< 10)
		{
              $hour = "0".$hour;
        }
        if($minute < 10)
		{
              $minute = "0".$minute;
        }
        $time = $hour.":".$minute;
		
		$app_cancel = $wpdb->get_var('SELECT app_cenceled FROM ' . $wpdb->prefix . sm_customer_notifications);
		if($app_cancel==1)
		{
				$msg_stored = $wpdb->get_var('SELECT content  FROM ' . $wpdb->prefix . sm_emails . ' WHERE type = ' . '"' . "decline_client" . '"');
				$msg_sub = $wpdb->get_var('SELECT subject FROM ' . $wpdb->prefix . sm_emails . ' WHERE type = ' . '"' . "decline_client" . '"');
				$msg_1 = str_replace("[first name]", $name, $msg_stored );
				$msg_2 = str_replace("[service]", $service_name, $msg_1);
				$msg_3 = str_replace("[date]", $date, $msg_2);
				$msg_4= str_replace("[time]", $time, $msg_3);
				$msg_5 = str_replace("[employee_name]", $emp_nam, $msg_4);
				$msg_6 = str_replace("[signature]", $email_sign, $msg_5);
				$msg_7 = str_replace("[companyName]", $title, $msg_6);
				$headers = "From: " .$title. "<". $admin_email . ">". "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				$headers .="Content-transfer-encoding: BASE64 | Quoted-Printable";
				mail($to,$msg_sub, $msg_7, $headers);   
		}
	}
	$emi = intval($_REQUEST['emi']);
	$status=esc_attr($_REQUEST['bookingstatus']);
	if($status=="Approval Pending" && $emi==1)
	{
		$serid=intval($_REQUEST['serid']);
		$client_id=intval($_REQUEST['clientnam']);
		$day=intval($_REQUEST['day']);
		$month=intval($_REQUEST['month']);
		$year=intval($_REQUEST['year']);
		$hour=intval($_REQUEST['hourselect']);
		$minute=intval($_REQUEST['minss']);
		$empid=intval($_REQUEST['empid']);
		
			$admin_email = get_settings('admin_email');	
			$table_name = $wpdb->prefix . "sm_services";
			$booked_service_name = $wpdb->get_var('SELECT name FROM ' . $table_name . ' WHERE id = ' . '"' . $serid . '"');
			$date = intval($_REQUEST['day'])."/".intval($_REQUEST['month'])."/".intval($_REQUEST['year']);
			$table_name = $wpdb->prefix . "sm_emails";
			$message_stored = $wpdb->get_var('SELECT content  FROM ' . $table_name . ' WHERE type = ' . '"' . "single_client" . '"');
			$subject_stored = $wpdb->get_var('SELECT subject  FROM ' . $table_name . ' WHERE type = ' . '"' . "single_client" . '"');
			$table_name = $wpdb->prefix . "sm_email_signature";
			$em_signature= $wpdb->get_var('SELECT initial  FROM ' . $table_name);
			$title=get_bloginfo('name');
			$table_name = $wpdb->prefix . "sm_employees";
			$emp_nam = $wpdb->get_var('SELECT emp_name  FROM ' . $table_name . ' WHERE id = ' . '"' . $empid . '"');
			$name = $wpdb->get_var("SELECT name From  " . $wpdb->prefix . sm_clients . " WHERE id =". '"' . $client_id . '"');        
			$email = $wpdb->get_var("SELECT email From  " . $wpdb->prefix . sm_clients . " WHERE id =". '"' .  $client_id . '"');	     
			$telephone = $wpdb->get_var("SELECT mobile From  " . $wpdb->prefix . sm_clients . " WHERE id =". '"' .  $client_id . '"');
			$lastnam = $wpdb->get_var("SELECT lastname From  " . $wpdb->prefix . sm_clients . " WHERE id =". '"' . $client_id . '"'); 		 
			$time = $hour.":".$minute;
			$message_1 = str_replace("[client_name]", $name." ".$lastnam, $message_stored);
			$message_2 = str_replace("[service_name]", $booked_service_name, $message_1);
			$message_5 = str_replace("[booked_time]", $time, $message_2);
			$message_6 = str_replace("[signature]", $em_signature, $message_5);
			$message_7 = str_replace("[companyName]", $title, $message_6);
			$message_8 = str_replace("[employee_name]", $emp_nam, $message_7);
			$message_final = str_replace("[booked_date]", $date, $message_8);
			$time = $hour ." : " . $minute;
			$cname = $name . " " . $lastnam;
			$message_admin= "Booking Details:
			<br />
			<br />
			Client Name: $cname
			<br />
			Client Email: $email
			<br />
			Client Mobile Number: $telephone
			<br />
			Booking Date: $date
			<br />
			Booking Time: $time
			<br />
			Booking Service Name: $booked_service_name
			<br />
			Booking Service Provider: $emp_nam";	
			
				$headers = "From: " .$title. "<". $admin_email . ">". "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				$headers .="Content-transfer-encoding: BASE64 | Quoted-Printable";
				$to = $email;	
				$table_name = $wpdb->prefix . "sm_customer_notifications";
				$customer_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $table_name);
				if($customer_app_booked==1)
				{
					mail($to,$subject_stored,$message_final,$headers);
				}
				$table_name = $wpdb->prefix . "sm_emails";
				$msg_stored = $wpdb->get_var('SELECT content  FROM ' . $table_name . ' WHERE type = ' . '"' . "admin" . '"');
				$msg_sub = $wpdb->get_var('SELECT subject FROM ' . $table_name . ' WHERE type = ' . '"' . "admin" . '"');
				$msg_1 = str_replace("[client_name]", $name, $msg_stored);
				$msg_2 = str_replace("[service_name]", $booked_service_name, $msg_1);
				$msg_3 = str_replace("[booked_time]", $time, $msg_2);
				$msg_4= str_replace("[booked_date]", $date, $msg_3);
				$table_name = $wpdb->prefix . "sm_bookings";
				$b_id = $wpdb->get_var('SELECT id FROM ' . $table_name . ' where id = '. '"' . intval($_REQUEST['editid']) . '"');
				
			
				
				$approve = "<a href=\"$url\confirm.php?actionappbok=approve&id=".$b_id."\">Approve Booking</a>";
				$msg_5 = str_replace("[approve]", $approve, $msg_4);
				$disapprove = "<a href=\"$url\confirm_disapprove.php?action=disapprove&booking=".$b_id."\">Disapprove Booking</a>";
				$msg_6 = str_replace("[deny]", $disapprove, $msg_5);
				$msg_7 = str_replace("[email_address]", $email, $msg_6);
				$msg_8 = str_replace("[mobile_number]", $telephone, $msg_7);		
				$table_name = $wpdb->prefix . "sm_staff_notifications";
				$staff_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $table_name);
				mail($admin_email, $msg_sub, $msg_8, $headers);
			}
}
?>
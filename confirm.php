<?php  
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-load.php' );
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<?php
    if($_REQUEST['actionappbok']=="approve")
	{
	     $book_id = intval($_REQUEST['id']);
		 $admin_email = get_settings('admin_email');
		 $wpdb->query
	     (
	            $wpdb->prepare
	            (
	                    "UPDATE ".$wpdb->prefix."sm_bookings SET status = %s WHERE id = %d",
	                    "Approved",
	                    $book_id
	             )
	      );	
      	 $client_id = $wpdb->get_var("SELECT client_id From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $book_id . '"');
		 $service_id = $wpdb->get_var("SELECT service_id From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $book_id . '"'); 
         $empid=$wpdb->get_var("SELECT emp_id From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $book_id . '"'); 
         $emp_nam=$wpdb->get_var("SELECT emp_name From  " . $wpdb->prefix . sm_employees . " WHERE id =". '"' . $empid . '"'); 
		 $emp_email=$wpdb->get_var("SELECT email From  " . $wpdb->prefix . sm_employees . " WHERE id =". '"' . $empid . '"');
		 $day = $wpdb->get_var("SELECT day From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $book_id . '"');				
		 $month = $wpdb->get_var("SELECT month From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $book_id . '"');	 	  
		 $year = $wpdb->get_var("SELECT year From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $book_id . '"');	
		 $hour = $wpdb->get_var("SELECT hour From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $book_id . '"');	 
	     $minute = $wpdb->get_var("SELECT minute From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . $book_id . '"');
		 
	     $lastnam = $wpdb->get_var("SELECT lastname From  " . $wpdb->prefix . sm_clients . " WHERE id =". '"' . $client_id . '"'); 		 
		 
		
		 $name = $wpdb->get_var("SELECT name From  " . $wpdb->prefix . sm_clients . "  WHERE id =". '"' . $client_id . '"');        
		 $email = $wpdb->get_var("SELECT email From   " . $wpdb->prefix . sm_clients . "  WHERE id =". '"' .  $client_id . '"');	      
		 $telephone = $wpdb->get_var("SELECT mobile From   " . $wpdb->prefix . sm_clients . " WHERE id =". '"' .  $client_id . '"');
		 $ser_name = $wpdb->get_var("SELECT name From  " . $wpdb->prefix . sm_services . "  WHERE id =". '"' .  $service_id . '"');		 
		 $table_name = $wpdb->prefix . "sm_email_signature";
		 $em_sign= $wpdb->get_var('SELECT initial  FROM ' . $table_name);
		 $e_content = $wpdb->get_var('SELECT content FROM  ' . $wpdb->prefix . sm_emails . ' WHERE type = ' . '"' . "single_client_confirm" . '"');	
	     $subject = $wpdb->get_var('SELECT subject FROM   ' . $wpdb->prefix . sm_emails . ' WHERE type = ' . '"' . "single_client_confirm" . '"');			 
	     $title=get_bloginfo('name');
		 $textual_month = date('M',mktime(0,0,0,$month,$day,$year));
         $date = $day." ".$textual_month." ".$year;
		 $to = $email;
        if($hour < 10){
           $hour = "0".$hour;
        }
         if($minute < 10){
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
			Booking Time: ".$time."
	        <br />
			Booking Service Name: ".$ser_name."
	        <br />
	        Booking Service Provider: ".$emp_nam."
			</p>";
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
		        $message  =   str_replace("[booked_date]", $date, $message_6);
				$staff_app_booked = $wpdb->get_var('SELECT app_booked FROM ' . $wpdb->prefix . sm_staff_notifications);
				if($staff_app_booked==1)
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
				Booking Time: ".$time."
		        <br />
				Booking Service Name: ".$ser_name."
		        <br />
		        Booking Service Provider: ".$emp_nam."
				</p>";
				mail($emp_email,$subject,$message,$headers); 
	}		
}
if($_REQUEST['actionappbok']=="disapprove")
{
				
		$client_idd = $wpdb->get_var("SELECT client_id From  " . $wpdb->prefix . sm_bookings . " WHERE id =". '"' . intval($_REQUEST['id']) . '"');   	  
		$emaill = $wpdb->get_var("SELECT email From  " . $wpdb->prefix . sm_clients . "  WHERE id =". '"' .  $client_idd . '"');	  	
		?>
		<script type="text/javascript">
		function send_demail() 
		{
			
            var d_email = jQuery('#d_client_email').val();
            var d_booking = jQuery('#d_booking_id').val();
            file=uri+"/confirm_disapprove.php";
            jQuery.ajax({
                      type: "POST",
                      data: "client_email=" + d_email + "&booking=" + d_booking,
                      url: file,
                      success: function(data) 
                      { 
							jQuery("#demail_send_success").html(data);
                      }                            
                   });
         }	
		</script>
		<input type="hidden" id="d_client_email" value="<?php echo  $emaill; ?>" />
		<input type="hidden" id="d_booking_id" value="<?php echo intval($_REQUEST['id']); ?>" />
		<span id="demail_send_success" style="color: green; font-style: italic; position: relative; top: 12px;"></span>
		<script type="text/javascript">send_demail();</script>
<?php
}
?>
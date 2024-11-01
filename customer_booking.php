<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
 
?>

<?php
if(isset($_REQUEST['action']))
{
		if($_REQUEST['action'] == 'addcustomer')
		{
					$fname = html_entity_decode($_REQUEST['firstnam']);
					$lname = html_entity_decode($_REQUEST['lastname']);
					$email = html_entity_decode($_REQUEST['email']);
					$mobile = html_entity_decode($_REQUEST['mobile']);
					$tel = html_entity_decode($_REQUEST['tel']);
					$customerAddress1 = html_entity_decode($_REQUEST['customerAddress1']);
					$customerAddress2 = html_entity_decode($_REQUEST['customerAddress2']);
					$customerCity = html_entity_decode($_REQUEST['customerCity']);
					$Country = html_entity_decode($_REQUEST['Country']);
					$customerZip = html_entity_decode($_REQUEST['customerZip']);
					$comments = html_entity_decode($_REQUEST['comments']);
					$wpdb->query
			        (
			                  $wpdb->prepare
			                  (
			                       "INSERT INTO ".$wpdb->prefix."sm_clients(name,lastname,email,mobile,telephone,addressLine1,addressLine2,city,postalcode,country,comments) VALUES( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )",
			                       $fname,
			                       $lname,
			                       $email,
			                       $mobile,
			                       $tel,
			                       $customerAddress1,
			                       $customerAddress2,
			                       $customerCity,
			                       $customerZip,
			                       $Country,
			                       $comments
			                  )
			        );
					
}
else if($_REQUEST['action'] == 'updatecust')
{
			$fname1 = html_entity_decode($_REQUEST['firstnam1']);
			$lname1 = html_entity_decode($_REQUEST['lastnam1']);
			$email1 = html_entity_decode($_REQUEST['email1']);
			$mobile1 = html_entity_decode($_REQUEST['mobile1']);
			$tel1 = html_entity_decode($_REQUEST['tel1']);
			$customerAddress11 = html_entity_decode($_REQUEST['customerAddress11']);
			$customerAddress21 = html_entity_decode($_REQUEST['customerAddress21']);
			$customerCity1 = html_entity_decode($_REQUEST['customerCity1']);
			$Country1 = html_entity_decode($_REQUEST['Country1']);
			$customerZip1 = html_entity_decode($_REQUEST['customerZip1']);
			$comments1 = html_entity_decode($_REQUEST['comments1']);
			$wpdb->query
		    (
		            $wpdb->prepare
		            (
		                    "UPDATE ".$wpdb->prefix."sm_clients SET name = %s, lastname = %s ,email = %s, mobile = %s, telephone = %s, addressLine1 = %s, addressLine2 = %s, city = %s, postalcode = %s, country = %s, comments = %s  WHERE id = %d",
		                    $fname1,
		                    $lname1,
		                    $email1,
		                    $mobile1,
		                    $tel1,
		                    $customerAddress11,
		                    $customerAddress21,
		                    $customerCity1,
		                    $customerZip1,
		                    $Country1,
		                    $comments1,
		                    intval($_REQUEST['id1'])
		                   
		             )
		    );	
}
else if($_REQUEST['action'] == 'deletecustomer')
{
			$bid = $wpdb->get_var('SELECT count(id) FROM ' . $wpdb->prefix . sm_bookings . ' WHERE client_id = ' . '"' . intval($_REQUEST['delid']) . '"');
			if($bid >0)
			{
				echo  "booked"; 
			}
			else
			{
				$wpdb->query
			  	(
			  		$wpdb->prepare
			    	(
			    		"DELETE FROM ".$wpdb->prefix."sm_bookings WHERE client_id = %d",
			       		 intval($_REQUEST['delid'])
			   		 )
			 	 );
				$wpdb->query
			  	(
			  		$wpdb->prepare
			    	(
			    		"DELETE FROM ".$wpdb->prefix."sm_clients WHERE id = %d",
			       		 intval($_REQUEST['delid'])
			   		 )
			 	 );
			}
}
else if($_REQUEST['action'] == 'searchcustomer')
{
			
			$vl = esc_attr($_REQUEST['searchstring']);
			if($vl == "")
			{
				$alpha  = "a";
				$query ="name LIKE '". $alpha ."%'";
			}
			else
			{
				$query ="name LIKE '%". $vl ."%' or lastname LIKE '%". $vl ."%' or email LIKE '%". $vl ."%' or mobile LIKE '%". $vl ."%' or telephone LIKE '%". $vl ."%' or city LIKE '%". $vl ."%' or postalcode LIKE '%". $vl ."%' or country LIKE '%". $vl ."%' ";
			}
			$disp = $wpdb -> get_results("SELECT id, name, lastname, email, mobile, telephone, addressLine1, addressLine2, city,postalcode,country,comments FROM " . $wpdb -> prefix . sm_clients . " WHERE " . $query . " order by name ASC");
			$count = count($disp);
			if($count!=0){
			?>
			<tr>
					<th width="11% ! important"> First Name </th>
					<th width="10% ! important"> Last Name </th>
					<th width="15% ! important"> Email </th>
					<th width="10% ! important"> Mobile </th>
					<th width="10% ! important"> City </th>
					<th width="10% ! important"> Postal Code </th>
					<th width="10% ! important"> Country </th>
					<th width="24% ! important"> Action </th>
			</tr>
			<?php
			for ($i = 0; $i < count($disp); $i++){
			$st = ($i%2 == 0)? '': 'background-color: #ffffff';
			?>
			<input type="hidden" id="id_<?php echo $i;?>" value="<?php echo $disp[$i] -> id;?>"/>
			<input type="hidden" id="name_<?php echo $i;?>" value="<?php echo $disp[$i] -> name;?>"/>
			<input type="hidden" id="lname_<?php echo $i;?>" value="<?php echo $disp[$i] -> lastname;?>"/>
			<input type="hidden" id="email_<?php echo $i;?>" value="<?php echo $disp[$i] -> email;?>"/>
			<input type="hidden" id="mobile_<?php echo $i;?>" value="<?php echo $disp[$i] -> mobile;?>"/>
			<input type="hidden" id="telephone_<?php echo $i;?>" value="<?php echo $disp[$i] -> telephone;?>"/>
			<input type="hidden" id="addressLine1_<?php echo $i;?>" value="<?php echo $disp[$i] -> addressLine1;?>"/>
			<input type="hidden" id="addressLine2_<?php echo $i;?>" value="<?php echo $disp[$i] -> addressLine2;?>"/>
			<input type="hidden" id="city_<?php echo $i;?>" value="<?php echo $disp[$i] -> city;?>"/>
			<input type="hidden" id="postalcode_<?php echo $i;?>" value="<?php echo $disp[$i] -> postalcode;?>"/>
			<input type="hidden" id="country_<?php echo $i;?>" value="<?php echo $disp[$i] -> country;?>"/>
			<input type="hidden" id="comments_<?php echo $i;?>" value="<?php echo $disp[$i] -> comments;?>"/>
			<tr style="<?php echo $st; ?> ">
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> name;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> lastname;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> email;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> mobile;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> city;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> postalcode;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> country;?></td>
			<td>
				<span class="data_actions iconsweet">
					<a class="tip_north fancybox" original-title="Edit Customer" id="li_<?php echo $i;?>" href="#Editcustomer" style="cursor:pointer;"  onclick="getappointments(this);">C</a>
					<a class="tip_north fancybox" original-title="Bookings" id="e_<?php echo $i;?>" onClick="custdetail(this)" href="#customerdetail" style="cursor:pointer;">P</a>
					<a class="tip_north fancybox" original-title="Send Email" id="h_<?php echo $i;?>" onClick="emailcust(this)" href="#customemail" style="cursor:pointer;">A</a>
					<a class="tip_north" original-title="Delete Customer" id="customerDeleteButton_<?php echo $i;?>" onClick="deletecustomer(this)"  style="cursor:pointer;">X</a>
					<a class="tip_north" original-title="Booking Customer" href="#" id="hid_<?php echo $i;?>" onClick="bookbackend(this)"  style="cursor:pointer;">+</a>
				</span>
			</td>
			</tr>
			<?php
			}			
			}
			else
			{
						?>
						<tr>
											<th> First Name </th>
											<th> Last Name </th>
											<th> Email </th>
											<th> Mobile </th>
											<th> City </th>
											<th> Postal Code </th>
											<th> Country </th>
											<th> Action </th>
						</tr>
			<?php
			}
}
else if($_REQUEST['action'] == 'sortingchar')
 {
			
			$ch = esc_attr($_REQUEST['charcter']);
			$query ="name LIKE '". $ch ."%' or lastname LIKE '". $ch ."%'";
			
			$disp = $wpdb -> get_results("SELECT id, name, lastname, email, mobile, telephone, addressLine1, addressLine2, city,postalcode,country,comments FROM " . $wpdb -> prefix . sm_clients . " WHERE " . $query . " order by name ASC");
			$count = count($disp);
			if($count!=0){
			?>
			<tr>
					<th width="11% ! important"> First Name </th>
											<th width="10% ! important"> Last Name </th>
											<th width="15% ! important"> Email </th>
											<th width="10% ! important"> Mobile </th>
											<th width="10% ! important"> City </th>
											<th width="10% ! important"> Postal Code </th>
											<th width="10% ! important"> Country </th>
											<th width="24% ! important"> Action </th>
			</tr>
			<?php
			for ($i = 0; $i < count($disp); $i++){
			$st = ($i%2 == 0)? '': 'background-color: #ffffff';
			?>
			<input type="hidden" id="id_<?php echo $i;?>" value="<?php echo $disp[$i] -> id;?>"/>
			<input type="hidden" id="name_<?php echo $i;?>" value="<?php echo $disp[$i] -> name;?>"/>
			<input type="hidden" id="lname_<?php echo $i;?>" value="<?php echo $disp[$i] -> lastname;?>"/>
			<input type="hidden" id="email_<?php echo $i;?>" value="<?php echo $disp[$i] -> email;?>"/>
			<input type="hidden" id="mobile_<?php echo $i;?>" value="<?php echo $disp[$i] -> mobile;?>"/>
			<input type="hidden" id="telephone_<?php echo $i;?>" value="<?php echo $disp[$i] -> telephone;?>"/>
			<input type="hidden" id="addressLine1_<?php echo $i;?>" value="<?php echo $disp[$i] -> addressLine1;?>"/>
			<input type="hidden" id="addressLine2_<?php echo $i;?>" value="<?php echo $disp[$i] -> addressLine2;?>"/>
			<input type="hidden" id="city_<?php echo $i;?>" value="<?php echo $disp[$i] -> city;?>"/>
			<input type="hidden" id="postalcode_<?php echo $i;?>" value="<?php echo $disp[$i] -> postalcode;?>"/>
			<input type="hidden" id="country_<?php echo $i;?>" value="<?php echo $disp[$i] -> country;?>"/>
			<input type="hidden" id="comments_<?php echo $i;?>" value="<?php echo $disp[$i] -> comments;?>"/>
			<tr style="<?php echo $st; ?>">
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> name;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> lastname;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> email;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> mobile;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> city;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> postalcode;?></td>
			<td style="word-wrap: break-word"><?php echo $disp[$i] -> country;?></td>
			<td>
				<span class="data_actions iconsweet">
					<a class="tip_north fancybox" original-title="Edit Customer" id="li_<?php echo $i;?>" href="#Editcustomer" style="cursor:pointer;"  onclick="getappointments(this);">C</a>
					<a class="tip_north fancybox" original-title="Bookings" id="e_<?php echo $i;?>" onClick="custdetail(this)" href="#customerdetail" style="cursor:pointer;">P</a>
					<a class="tip_north fancybox" original-title="Send Email" id="h_<?php echo $i;?>" onClick="emailcust(this)" href="#customemail" style="cursor:pointer;">A</a>
					<a class="tip_north" original-title="Delete Customer" id="customerDeleteButton_<?php echo $i;?>" onClick="deletecustomer(this)"  style="cursor:pointer;">X</a>
					<a class="tip_north" original-title="Booking Customer" href="#" id="hid_<?php echo $i;?>" onClick="bookbackend(this)"  style="cursor:pointer;">+</a>
				</span>
			</td>
			</tr>
			<?php
			}			
			}
				else{
				?>
				<tr>
											<th> First Name </th>
											<th> Last Name </th>
											<th> Email </th>
											<th> Mobile </th>
											<th> City </th>
											<th> Postal Code </th>
											<th> Country </th>
											<th> Action </th>
				</tr>
<?php
}
}
else if($_REQUEST['action'] == 'customerHistory')
{
	$vl = intval($_REQUEST['custId']);
	$bookings = $wpdb->get_results
	(
			$wpdb->prepare
			(
					"SELECT id,service_id,emp_id, client_id, day, month, year, hour, minute, status FROM ".$wpdb->prefix."sm_bookings WHERE client_id = %d  order by date desc",
					intval($_REQUEST['custId'])
			)
	);
	
?>
<table class="activity_datatable"  width="100%" border="0" cellspacing="0" cellpadding="8">
									<tbody>
										<tr>
											<th> Service Name </th>
											<th> Employee Name </th>
											<th> Service Time </th>
											<th> Service Cost </th>
											<th> Booking Date </th>
											<th> Booking Time </th>
											<th> Booking Status </th>
											<th> Comments </th>
											<th style= "width:10%"> Note </th>
										</tr>
										<ul>
										<?php 
										
											for($i=0;$i<count($bookings);$i++)
											{
											$services = $wpdb->get_row
											(
													$wpdb->prepare
													(
															"SELECT * FROM ".$wpdb->prefix."sm_services WHERE id = %d",
															$bookings[$i]->service_id 
													)
											);
											$services_time = $wpdb->get_row
											(
													$wpdb->prepare
													(
															"SELECT * FROM ".$wpdb->prefix."sm_services_time WHERE service_id = %d",
															$bookings[$i]->service_id 
													)
											);
											$stat = $wpdb->get_var('SELECT status FROM ' . $wpdb->prefix . sm_bookings . ' WHERE id = ' . '"' . $bookings[$i]->id . '"');
											$comments = $wpdb->get_var('SELECT note FROM ' . $wpdb->prefix . sm_bookings . ' WHERE id = ' . '"' . $bookings[$i]->id . '"');
											$empname = $wpdb->get_var('SELECT emp_name FROM ' . $wpdb->prefix . sm_employees . ' WHERE id = ' . '"' . $bookings[$i]->emp_id . '"');
											$sercurrency = $wpdb -> get_var('SELECT currency_sign FROM ' . $wpdb -> prefix . sm_currency . ' where ' . $wpdb -> prefix . sm_currency . '.currency_used = 1');
											?>
										<tr>
											<td><?php echo $services->name; ?></td>
											<td><?php echo $empname;?></td>
											<td><?php if($services_time->hours > 0){echo $services_time->hours." h ".$services_time->minutes." m";}else{echo $services_time->minutes. " m";} ?></td>
											<td><?php echo $sercurrency. " " .$services->cost; ?></td>
											<td><?php echo ($bookings[$i]->day<10 ? "0".$bookings[$i]->day : $bookings[$i]->day) ?>-<?php echo ($bookings[$i]->month<10) ? "0".$bookings[$i]->month : $bookings[$i]->month?>-<?php echo $bookings[$i]->year ?></td>
											<td><?php echo ($bookings[$i]->hour<10 ? "0".$bookings[$i]->hour : $bookings[$i]->hour) ?>:<?php echo ($bookings[$i]->minute<10) ? "0".$bookings[$i]->minute : $bookings[$i]->minute?></td>
											<td><?php echo $stat;?></td>
											<td><?php echo $comments;?></td>
											<td><span class="data_actions iconsweet"><a class="tip_north fancybox" original-title="Note" id="<?php echo $bookings[$i]->id; ?>"  href="#notecustomer" onclick="comen(this)"  style="cursor:pointer;">C</a>
											<a class="tip_north" original-title="Delete Customer" id="<?php echo $bookings[$i]->id;?>" onClick="deletebooking(this)"  style="cursor:pointer;">X</a></span></td>
										</tr>
										<?php
										}
										?>
										</ul>
							</tbody>	
					</table>
<?php	
}
else if($_REQUEST['action'] == 'commentcustomer')
	{
			$wpdb->query
		    (
		            $wpdb->prepare
		            (
		                    "UPDATE ".$wpdb->prefix."sm_bookings SET note = %s  WHERE id = %d",
		                    esc_attr($_REQUEST['comment']),
		                    intval($_REQUEST['id'])
		             )
		    );
	}
else if($_REQUEST['action'] == 'notecustomer')
	{
			$comments = $wpdb->get_var('SELECT note FROM ' . $wpdb->prefix . sm_bookings . ' WHERE id = ' . '"' . intval($_REQUEST['custoId']) . '"');
			?>
			<div id="notec" class="form_input">
			<textarea  id="comm"><?php echo $comments; ?></textarea>
			</div>
			<?php
	}
else if($_REQUEST['action'] == 'emailcustomers')
	{
				$email = $wpdb->get_var('SELECT email FROM ' . $wpdb->prefix . sm_clients . ' WHERE id = ' . '"' . intval($_REQUEST['id']) . '"');
				$to = $email;
				$title=get_bloginfo('name');
				$content = esc_attr($_REQUEST['ecut']);
				$admin_email = get_settings('admin_email');
				$headers = "From: " .$title. "<". $admin_email . ">". "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				$headers .="Content-transfer-encoding: BASE64 | Quoted-Printable";
				$title=get_bloginfo('name');
				$subject = "Message from the Administrator " . $title;
				mail($to, $subject, $content, $headers );
	}
	else if($_REQUEST['action'] == "checkemaill")
	{
		$email = esc_attr($_REQUEST['email']);
		$ckemail  =  $wpdb->get_var('SELECT count(id)  FROM ' . $wpdb->prefix . sm_clients . ' where email = '."'". $email ."'");
		if($ckemail==0)
		{
			echo "newcustomer";
		}
		else
		{
			echo "excustomer";
		}
	}
else if($_REQUEST['action'] == "delbooking")
	{
		
		$idd = intval($_REQUEST['id']);
				$wpdb->query
			  	(
			  		$wpdb->prepare
			    	(
			    		"DELETE FROM ".$wpdb->prefix."sm_bookings WHERE id = %d",
			       		 $idd
			   		 )
			 	 );
	
	}
}
else 
{
?>
<script type="text/javascript">

function deletebooking(b)
{
	
 var id=b.id;
 	action = confirm("Are you sure you want to delete this Booking?");
	if(action == true)
	{
	jQuery.ajax
			({
				type: "POST",
				data:"id="+id+"&action=delbooking",
				url: uri+"/customer.php",
				success: function(data)
				{
					parent.jQuery.fancybox.close();
				}
			});
	}
}
function emailcustomer()
{
		var ecut=document.getElementById("emcustomer").value;
		var eid = document.getElementById('ecust').value;
		jQuery(document).ready(function($) 
		{											
				
			jQuery.ajax
			({
				type: "POST",
				data:"id="+ eid +"&ecut="+ecut+"&action=emailcustomers",
				url: uri+"/customer_booking.php",
				success: function(data)
				{
				
					jQuery("#successEmail").css('display','block');
					
					setTimeout(function()
					{		
						jQuery("#successEmail").css('display','none');
						document.getElementById("emcustomer").value="";																		
						parent.jQuery.fancybox.close();
					}, 1000);
				}
			});
		});
}
										
function emailcust(e)
{
	var deliddd;
	jQuery(document).ready(function($) 
	{
		id=e.id;
		var delid=id.split("_");
		deliddd=delid[1];
		var eid=document.getElementById('id_'+deliddd).value;
		
		document.getElementById('ecust').value=eid;
		var nam=document.getElementById('name_'+deliddd).value;
		var lnam=document.getElementById('lname_'+deliddd).value;
		
		var clientName = jQuery("#clientName").html(nam+" "+lnam);
		
	});
}														
										



function comment()
{
		var comm=document.getElementById("comm").value;
		
		var id = document.getElementById('commentId').value;
	
		jQuery(document).ready(function($)
		{											
				
			jQuery.ajax
			({
				type: "POST",
				data:"id="+ id +"&comment="+comm+"&action=commentcustomer",
				url: uri+"/customer_booking.php",
				success: function(data)
				{
				
					jQuery("#customercomm").css('display','block');
					setTimeout(function()
					{
						jQuery("#customercomm").css('display','none');																			
						parent.jQuery.fancybox.close();
					}, 1000);
				}
			});
		});
}
														function comen(e)
														{
																var id=e.id;
															
																document.getElementById('commentId').value = id;
																jQuery(document).ready(function($) 
																{
																		
																	jQuery.ajax
																	({
																		type: "POST",
																		data:"custoId="+id+"&action=notecustomer",
																		url: uri+"/customer_booking.php",
																		success: function(data)
																		{
																			jQuery("#notec").html(data);
																		}
																	});
																});
														}
													function customerFirstNameblur()
													{
													if(jQuery('#customerFirstName').val()=="")
													{
														jQuery("#customerFirstName").addClass("in_error");
														return false;
                                                    }
                                                   else
                                                    {
													if(jQuery("#customerFirstName").hasClass('in_error'))
													{
														jQuery("#customerFirstName").removeClass("in_error");
													}
														jQuery("#customerFirstName").addClass("in_submitted");
														return true;
													}
													}
													function customerLastNameblur()
													{
														if(jQuery('#customerLastName').val()!="")
														{
															jQuery("#customerLastName").addClass("in_submitted");
														
														}
													
													}
													
												   function customeremailblur() {
												   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                                                   var address = jQuery("#customeremail").val();
                                                   if(reg.test(address) == false) 
												   {
														
														jQuery("#customeremail").addClass("in_error");
														
                                                   }
                                                   else
                                                   {
                                                   if(jQuery("#customeremail").hasClass('in_error'))
                                                   {
														jQuery("#customeremail").removeClass("in_error");
                                                   }
                                                       jQuery("#customeremail").addClass("in_submitted");
                                                       
												   }	
												   }
												   function customerMobileblur (){
													if(jQuery('#customerMobile').val()!="")
													{
														jQuery("#customerMobile").addClass("in_submitted");
														return false;
                                                    }
                                                 
													}
													function customertelblur () {

													if(jQuery('#customertel').val()!="")
													{
														jQuery("#customertel").addClass("in_submitted");
														
                                                    }
                                                  
													}
													function customerAddress1blur(){
													if(jQuery('#customerAddress1').val()!="")
													{
														jQuery("#customerAddress1").addClass("in_submitted");
														
                                                    }
                                                  
													}
													
													function customerAddress2blur (){
													if(jQuery('#customerAddress2').val()!="")
													{
														jQuery("#customerAddress2").addClass("in_submitted");
														
                                                    }
                                                  
													}
													
													function customerCityblur(){
													if(jQuery('#customerCity').val()!="")
													{
														jQuery("#customerCity").addClass("in_submitted");
														
                                                    }
                                               
													}
													function postalblur(){
													if(jQuery('#postal').val()!="")
													{
														jQuery("#postal").addClass("in_submitted");
														
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
													
												function change()
												{
													var emialreq=document.getElementById("reqemail").checked;
													if(emialreq==false)
													{
														if (jQuery("#customeremail").hasClass('in_error'))
														{
															jQuery("#customeremail").removeClass("in_error");
														}
													}												
													else
													{
														if(jQuery("#customeremail").hasClass('in_error'))
														{
															jQuery("#customeremail").removeClass("in_error");
														}
													}
											}		
																function clearSearchText(e)
																{
																	idd=e.id;
																	document.getElementById(idd).value="";
																}
																function savecustomer()
																{
																	if(customerFirstNameblur())
																	{
																				var fnam=document.getElementById("customerFirstName").value;
																				var firstnam = encodeURIComponent(fnam);
																				var lnam=document.getElementById("customerLastName").value;
																				var lastnam = encodeURIComponent(lnam);
																				var mob=document.getElementById("customerMobile").value;
																				var mobile = encodeURIComponent(mob);
																				var tele=document.getElementById("customertel").value;
																				var tel = encodeURIComponent(tele);
																				var cAddress1=document.getElementById("customerAddress1").value;
																				var customerAddress1 = encodeURIComponent(cAddress1);
																				var cAddress2=document.getElementById("customerAddress2").value;
																				var customerAddress2 = encodeURIComponent(cAddress2);
																				var cCity=document.getElementById("customerCity").value;
																				var customerCity = encodeURIComponent(cCity);
																				var cments=document.getElementById("comments").value;
																				var comments = encodeURIComponent(cments);
																				var cZip=document.getElementById("postal").value;
																				var customerZip = encodeURIComponent(cZip);
																				var Cntry = document.getElementById("Country").value;	
																				var Country = encodeURIComponent(Cntry);
																				var emialreq=document.getElementById("reqemail").checked;
																				if(emialreq==false)
																				{
																					
																					var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
																					var address = jQuery("#customeremail").val();
																					if(reg.test(address) == false) 
																					{
																					
																						jQuery("#customeremail").addClass("in_error");
																						return false;
																					}
																					else
																					{
																					var address = jQuery("#customeremail").val();
																						
																					
																					 jQuery.ajax
																						({
																								type: "POST",
																								data: "email="+address+"&action=checkemaill",
																								url:  uri+"/customer.php",
																								success: function(data) 
																								{
																								var datta = jQuery.trim(data);
																								
																									if(datta=="excustomer")
																									{
																										alert('Sorry, this email address is already in your DB. You should enter a new email address OR find the correct Customer in your customers list and update their details.');
																										jQuery("#customeremail").addClass("in_error");
																										return false;
																									}
																									else
																									{
																										if (jQuery("#customeremail").hasClass('in_error'))
																										{
																											jQuery("#customeremail").removeClass("in_error");
																										}
																										jQuery("#customeremail").addClass("in_submitted");
																										
																									}
																								}
																							});
																							var email=document.getElementById("customeremail").value;
																					}
																				}
																				else
																				{
																					var email="";
																				}
																				
																					
																				<?php
																				$sell = $wpdb -> get_var('SELECT name FROM ' . $wpdb -> prefix . sm_cuntry . ' where used ="1"');
																				?>
																				if(!jQuery("#customeremail").hasClass('in_submitted'))
																				{
																					return false;
																				}
																				else
																				{
																				var cntry = "<?php echo $sell; ?>";	
																																				
																				jQuery.ajax
																				({
																						type: "POST",
																						data:"firstnam="+firstnam+"&lastname="+lastnam+"&email="+email+"&mobile="+mobile+"&tel="+tel+"&customerAddress1="+customerAddress1+"&customerAddress2="+customerAddress2+"&customerCity="+customerCity+"&Country="+Country+"&customerZip="+customerZip+"&comments="+comments+"&action=addcustomer",
																						url: uri+"/customer.php",
																						success: function(data) 
																						{
																								jQuery("#customeradd").css('display','block');
																								path= uri+"/customersrebind.php";
																								jQuery.ajax
																								({
																									type: "POST",
																									data: "bindempwizard=true",
																									url: path,
																									success: function(data)
																									{
																											var temp=data;
																											var index2=temp.indexOf("/table");
																											var ind=index2+7;
																											var cal=temp.substring(0, ind);
																											jQuery("#customertable").html(cal);
																											var last=temp.lastIndexOf("/option>");
																											var l_index=last+8;
																											var time=temp.substring(ind,l_index);
																											jQuery("#Country").html(time);
																											setTimeout(function()
																											{
																													jQuery("#customeradd").css('display','none');
																													document.getElementById('customerFirstName').value="";
																													document.getElementById('customerLastName').value="";
																													document.getElementById('customeremail').value="";
																													document.getElementById('customerMobile').value="";
																													document.getElementById('customertel').value="";
																													document.getElementById('customerAddress1').value="";
																													document.getElementById('customerAddress2').value="";
																													document.getElementById('customerCity').value="";
																													document.getElementById('postal').value="";
																													jQuery("#Country").val(0);
																													jQuery("#-Country").html(cntry);
																													document.getElementById('comments').value="";
																													if(jQuery("#customerFirstName").hasClass('in_submitted'))
																													{
																														jQuery("#customerFirstName").removeClass("in_submitted");
																													}
																													if(jQuery("#customeremail").hasClass('in_submitted'))
																													{
																														jQuery("#customeremail").removeClass("in_submitted");
																													}
																													if(jQuery("#customerMobile").hasClass('in_submitted'))
																													{
																														jQuery("#customerMobile").removeClass("in_submitted");
																													}
																													if(jQuery("#customerLastName").hasClass('in_submitted'))
																													{
																														jQuery("#customerLastName").removeClass("in_submitted");
																													}
																													if(jQuery("#customerMobile").hasClass('in_submitted'))
																													{
																														jQuery("#customerMobile").removeClass("in_submitted");
																													}
																													if(jQuery("#customertel").hasClass('in_submitted'))
																													{
																														jQuery("#customertel").removeClass("in_submitted");
																													}
																													if(jQuery("#customerAddress1").hasClass('in_submitted'))
																													{
																														jQuery("#customerAddress1").removeClass("in_submitted");
																													}
																													if(jQuery("#customerAddress2").hasClass('in_submitted'))
																													{
																														jQuery("#customerAddress2").removeClass("in_submitted");
																													}
																													if(jQuery("#customerCity").hasClass('in_submitted'))
																													{
																														jQuery("#customerCity").removeClass("in_submitted");
																													}
																													if(jQuery("#postal").hasClass('in_submitted'))
																													{
																														jQuery("#postal").removeClass("in_submitted");
																													}
																													if(jQuery("#Country").hasClass('in_submitted'))
																													{
																														jQuery("#Country").removeClass("in_submitted");
																													}
																													parent.jQuery.fancybox.close();
																											}, 1000);
																											var iddd=document.getElementById("id").value;
																									}
																							});
																						}
																				});
																		}
																}
													}																			
													function searchcustomers(e)
													{
														jQuery(document).ready(function($) 
														{
															searchstring=document.getElementById("txtsearch").value;
																
															jQuery.ajax
															({
																type: "POST",
																data:"searchstring="+searchstring+"&action=searchcustomer",
																url: uri+"/customer_booking.php",
																success: function(data)
																{
																	
																	var dat = data.substring(0, data.length - 1);
																	jQuery("#searchcustomer").html(dat);
																}
															});
														});
													}
													function customerFirstNameblur1()
													{
														if(jQuery('#customerFirstName1').val()=="")
														{
															jQuery("#customerFirstName1").addClass("in_error");
															return false;
	                                                    }
	                                                    else
	                                                    {
															if(jQuery("#customerFirstName1").hasClass('in_error'))
															{
																jQuery("#customerFirstName1").removeClass("in_error");
															}
															jQuery("#customerFirstName1").addClass("in_submitted");
															return true;
														}
													}
												   function customeremailblur1() {
												   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                                                   var address = jQuery("#customeremail1").val();
                                                   if(reg.test(address) == false) 
												   {
														jQuery("#customeremail1").addClass("in_error");
														return false;
                                                   }
                                                   else
                                                   {
                                                   if(jQuery("#customeremail1").hasClass('in_error'))
                                                   {
														jQuery("#customeremail1").removeClass("in_error");
                                                   }
                                                       jQuery("#customeremail1").addClass("in_submitted");
                                                       return true;
												   }	
												   }
												    function customerMobileblur1 (){
													if(jQuery('#customerMobile1').val()!="")
													{
														jQuery("#customerMobile1").addClass("in_submitted");
														return false;
                                                    }
                                                  
													}
														function getappointments(e)
														{
															var deliddd;
															jQuery(document).ready(function($) 
															{
																id=e.id; 
																var delid=id.split("_");
																deliddd=delid[1];
																var cid=document.getElementById('id_'+deliddd).value;
																document.getElementById('id').value=cid;	
																document.getElementById('customerFirstName1').value = document.getElementById('name_'+deliddd).value;
																document.getElementById('customerLastName1').value = document.getElementById('lname_'+deliddd).value;
																document.getElementById('customeremail1').value = document.getElementById('email_'+deliddd).value;
																document.getElementById('customerMobile1').value = document.getElementById('mobile_'+deliddd).value;
																document.getElementById('customertel1').value = document.getElementById('telephone_'+deliddd).value;
																document.getElementById('customerAddress11').value = document.getElementById('addressLine1_'+deliddd).value;
																document.getElementById('customerAddress21').value = document.getElementById('addressLine2_'+deliddd).value;
																document.getElementById('customerCity1').value = document.getElementById('city_'+deliddd).value;
																document.getElementById('postal1').value = document.getElementById('postalcode_'+deliddd).value;
																jQuery("#Country1").val(document.getElementById('country_'+deliddd).value);
																jQuery("#-Country1").html(document.getElementById('country_'+deliddd).value);
																document.getElementById('comments1').value = document.getElementById('comments_'+deliddd).value;
																jQuery('#update').show();
																jQuery('#Address2').hide();
																jQuery('#Address1').hide();
																jQuery('#cty').hide();
																jQuery('#zip').hide();
																jQuery('#telep').hide();
																jQuery('#mob').hide();
																jQuery('#eml').hide();
																jQuery('#cmt').hide();
																jQuery('#divdisp').hide();
																	
														});
													}
													function updatecustomer()
													{
														if(customerFirstNameblur1())
														{
															jQuery(document).ready(function($) 
															{
																var ftnam1=document.getElementById("customerFirstName1").value;
																var firstnam1 = encodeURIComponent(ftnam1);
																var lname1=document.getElementById("customerLastName1").value;
																var lastname1 = encodeURIComponent(lname1);
																var ema1=document.getElementById("customeremail1").value;
																var email1 = encodeURIComponent(ema1);
																var mob1=document.getElementById("customerMobile1").value;
																var mobile1 = encodeURIComponent(mob1);
																var tele1=document.getElementById("customertel1").value;
																var tel1 = encodeURIComponent(tele1);
																var cusAddress11=document.getElementById("customerAddress11").value;
																var customerAddress11 = encodeURIComponent(cusAddress11);
																var cusAddress21=document.getElementById("customerAddress21").value;
																var customerAddress21 = encodeURIComponent(cusAddress21);
																var cusCity1=document.getElementById("customerCity1").value;
																var customerCity1 = encodeURIComponent(cusCity1);
																var Ctry1=document.getElementById("Country1").value;
																var Country1 = encodeURIComponent(Ctry1);
																var comment1=document.getElementById("comments1").value;
																var comments1 = encodeURIComponent(comment1);
																var cusZip1=document.getElementById("postal1").value;
																var customerZip1 = encodeURIComponent(cusZip1);
																var iddd1=document.getElementById("id").value;
																			
																jQuery.ajax
																({	
																		type: "POST",
																		data:"firstnam1="+firstnam1+"&lastnam1="+lastname1+"&email1="+email1+"&id1="+iddd1+"&mobile1="+mobile1+"&tel1="+tel1+"&customerAddress11="+customerAddress11+"&customerAddress21="+customerAddress21+"&customerCity1="+customerCity1+"&Country1="+Country1+"&customerZip1="+customerZip1+"&comments1="+comments1+"&action=updatecust",
																		url: uri+"/customer_booking.php",
																		success: function(data)
																		{
																			jQuery("#customeredit").css('display','block');
																			path= uri+"/customersrebind.php";
																			jQuery.ajax
																			({
																				type: "POST",
																				data: "bindempwizard=true",
																				url: path,
																				success: function(data)
																				{
																					var temp=data;
																					var index2=temp.indexOf("/table");
																					var ind=index2+7;
																					var cal=temp.substring(0, ind);
																					jQuery("#customertable").html(cal);
																					setTimeout(function()
																					{
																							document.getElementById('customerFirstName1').value="";
																							document.getElementById('customerLastName1').value="";
																							document.getElementById('customeremail1').value="";
																							document.getElementById('customerMobile1').value="";
																							document.getElementById('customertel1').value="";
																							document.getElementById('customerAddress11').value="";
																							document.getElementById('customerAddress21').value="";
																							document.getElementById('customerCity1').value="";
																							document.getElementById('postal1').value="";
																							document.getElementById('comments1').value="";
																						jQuery("#customeredit").css('display','none');
																						parent.jQuery.fancybox.close();
																						if(jQuery("#customerFirstName1").hasClass('in_submitted'))
																						{
																							jQuery("#customerFirstName1").removeClass("in_submitted");
																						}
																						if(jQuery("#customeremail1").hasClass('in_submitted'))
																						{
																							jQuery("#customeremail1").removeClass("in_submitted");
																						}
																						if(jQuery("#customerMobile1").hasClass('in_submitted'))
																						{
																							jQuery("#customerMobile1").removeClass("in_submitted");
																						}
																					}, 1000);
																					var iddd=document.getElementById("id").value;
																				}
																			});
																		}
																});
															});
														}
													}							
														function deletecustomer(e)
														{ 
															id=e.id;
															var delid=id.split("_");
															jQuery(document).ready(function($) {
															delid=document.getElementById("id_"+delid[1]).value;
																
															action = confirm("Are you sure you want to delete this Customer?");
															if(action == true)
															{
														jQuery.ajax({
																type: "POST",
																data:"delid="+delid+"&action=deletecustomer",
																url: uri+"/customer_booking.php",
																success: function(data)
																{
																var dat = jQuery.trim(data);
																if(dat == "booked")
																{
																	alert('The Client could not be deleted. Some of the Bookings has been associated with this Client. Kindly first Delete the associated Bookings to delete this Client.');
																	return false;
																}
																else
																{
																path= uri+"/customersrebind.php";
																jQuery.ajax({
																		type: "POST",
																		data: "bindempwizard=true",
																		url: path,
																		success: function(data)
																		{
																			var temp=data;
																			var index2=temp.indexOf("/table");
																			var ind=index2+7;
																			var cal=temp.substring(0, ind);	
																			jQuery("#customertable").html(cal);																			
																		}
																	});
																	}
																}
															});
														}
													});
												}
														function custdetail(e)
														{
															var id=e.id;
															var delid=id.split("_");
															var deliddd=delid[1];
															var cid=document.getElementById('id_'+deliddd).value;
															document.getElementById('commentId').value=cid;
															var nam=document.getElementById('name_'+deliddd).value;
															var lnam=document.getElementById('lname_'+deliddd).value;
															var clientName = jQuery("#clientNam").html(nam+" "+lnam);
															jQuery(document).ready(function($)
															{
																	
																jQuery.ajax
																({
																		type: "POST",
																		data:"custId="+cid+"&action=customerHistory",
																		url: uri+"/customer_booking.php",
																		success: function(data)
																		{
																				jQuery('#customerhis').html(data);
																				jQuery.fancybox.update();
																		}
																});
															});
														}
														function bookbackend(h)
														{
															var id=h.id;
															var deli=id.split("_");
															var delid=deli[1];
															var hid=document.getElementById('id_'+delid).value;
															<?php
															$trans = $wpdb->get_results
															(
																	$wpdb->prepare
																	(
																			"SELECT * FROM ".$wpdb->prefix."sm_translation"
																	)
															);
															for($i=0;$i<=count($trans);$i++)
															?>
															var titles = "<?php echo $trans[18]->translate; ?>";
															if(document.getElementById('hitime'))
															{
																jQuery('#hitime').remove();
															}
															jQuery('.box_bookingLink').remove();
															var windowWidth = document.documentElement.clientWidth;
															var clientWidth = (windowWidth / 2) - 410;
															jQuery('body').append("<div class='box_bookingLink' style='border: 10px solid #525252;left:"+clientWidth+"px;'><div class='close1'>"+titles+"</div><div class='close'>X</div><div id='booking_backend_tab'></div><div id='loading' class='loading'><img src='"+uri+"/images/loading.gif'/></div></div>");
															jQuery('#booking_backend_tab').load(uri+"/backendbooking_bookingtab.php?custId="+hid,function(){jQuery('#loading').remove();jQuery('.maincontainer1').css('display', 'block');});
															jQuery('.box_bookingLink').animate({'opacity':'1.00'});
															jQuery('.backdrop, .box_bookingLink').css('display', 'block');
															
											 
													jQuery('.close').click(function(){
													close_box();
													});
											 
													jQuery('.backdrop').click(function(){
														close_box();
													});
													
											 
														function close_box()
														{
															jQuery('.box_bookingLink').remove();
															jQuery('.backdrop, .box_bookingLink').animate({'opacity':'0'}, 300, 'linear', function(){
																jQuery('.backdrop, .box_bookingLink').css('display', 'none');
															});
														}
														
														}
														function sorting(e)
														{
															idd=e.id;
															var delid=idd.split("_");
															jQuery(document).ready(function($) 
															{
																delid=document.getElementById("char_"+delid[1]).value
																
																jQuery.ajax
																({
																			type: "POST",
																			data:"charcter="+delid+"&action=sortingchar",
																			url: uri+"/customer_booking.php",
																			success: function(data)
																			{
																				
																				jQuery("#searchcustomer").html(data);
																			}
																});
															
															 });
														}
														function importcustomer()
														{
																jQuery('#import').load(uri+"/import.php",function(){jQuery.fancybox.update();});
														}
					</script>
<script type="text/javascript">jQuery("select, input:checkbox, input:radio").uniform();</script>											
	<div id="divcustomer_book_tab">
	<div  class="contentarea">
		<div class="one_wrap fl_left">
		<ul class="form_fields_container" style="margin-bottom:0px;margin-top:10px">
				<li>
					<a class="greyishBtn button_small fancybox"  href="#Addcustomer">Add New Customer</a>
					<a class="greyishBtn button_small fancybox"  href="#import">Import Customers</a>
				</li>
				</ul>
				<div class="widget-wp-obs" style="margin-top:0px">
				<div class="widget-wp-obs_title">
					<span class="iconsweet">}</span>
						<h5>Search Customers</h5>
				</div>
					<div class="widget-wp-obs_body">
						<ul class="form_fields_container">
						<li>
						<label> Search Customer :</label>
							<div class="form_input">
									<span>
										<input id="txtsearch" type="text" name="" value="Search Customer" onkeyup="searchcustomers(this)"  onFocus="clearSearchText(this)" />
									</span>
							</div>
						</li>
						</ul>
					</div>
			</div>
		<div style="margin-top: 7px;">
<table>
<tr>
<?php 
for ($i=65; $i<=90; $i++) 
{
$x = chr($i); 
?>
<input type="hidden" id="char_<?php echo $i ?>" value="<?php echo $x; ?>" />
<td style="margin-left:5px; font-size: 14px; letter-spacing: 0.5em"><a herf="#" onclick="sorting(this);" id="sort_<?php echo $i; ?>" style='cursor:pointer;'><?php echo $x;?></a></td>
<?php
} 
?></tr>
	</table>		
	</div>
	<div class="widget-wp-obs">
					<div class="widget-wp-obs_title">
						<span class="iconsweet">}</span>
						<h5> Existing Customers </h5>
						</div>
						<div id="customertable" class="widget-wp-obs_body" >
						<table class="activity_datatable" id="searchcustomer" width="100%" border="0" cellspacing="0" cellpadding="8">
									<tbody>
										<tr>
											<th width="11% ! important"> First Name </th>
											<th width="10% ! important"> Last Name </th>
											<th width="15% ! important"> Email </th>
											<th width="10% ! important"> Mobile </th>
											<th width="10% ! important"> City </th>
											<th width="10% ! important"> Postal Code </th>
											<th width="10% ! important"> Country </th>
											<th width="24% ! important"> Action </th>
										</tr>
										<ul id="customerSortingContainer" class="customer_list_header">
											<div class="clear_all"></div>
										</ul>
										<ul class="customer_list_content" id="customerListContainer" onscroll="getMoreCustomersByScroll();" >
											<?php
											global $wpdb;
											$alpha  = "a";
											$query ="name LIKE '". $alpha ."%'";
											$disp = $wpdb -> get_results("SELECT id, name, lastname, email, mobile, telephone, addressLine1, addressLine2, city,postalcode,country,comments FROM " . $wpdb -> prefix . sm_clients  . " WHERE " . $query . " order by name ASC");
											$cou = count($disp);
											?>
											<input type="hidden" id="txtcount" value="<?php echo $cou;?>"/>
											<?php
											for ($i = 0; $i < count($disp); $i++) {
											$coust = $disp[$i]->name;
											$st = ($i%2 == 0)? '': 'background-color: #ffffff';
											?>
												<tr class="break-word" style="<?php echo $st; ?>">
												<input type="hidden" id="id_<?php echo $i;?>" name="<?php echo $i;?>" value="<?php echo $disp[$i] -> id;?>"/>
												<input type="hidden" id="name_<?php echo $i;?>" name="<?php echo $i;?>" value="<?php echo $disp[$i] -> name;?>"/>
												<input type="hidden" id="lname_<?php echo $i;?>" name="<?php echo $i;?>" value="<?php echo $disp[$i]-> lastname;?>"/>
												<input type="hidden" id="email_<?php echo $i;?>" value="<?php echo $disp[$i] -> email;?>"/>
												<input type="hidden" id="mobile_<?php echo $i;?>" value="<?php echo $disp[$i] -> mobile;?>"/>
												<input type="hidden" id="telephone_<?php echo $i;?>" value="<?php echo $disp[$i] -> telephone;?>"/>
												<input type="hidden" id="addressLine1_<?php echo $i;?>" value="<?php echo $disp[$i] -> addressLine1;?>"/>
												<input type="hidden" id="addressLine2_<?php echo $i;?>" value="<?php echo $disp[$i] -> addressLine2;?>"/>
												<input type="hidden" id="city_<?php echo $i;?>" value="<?php echo $disp[$i] -> city;?>"/>
												<input type="hidden" id="postalcode_<?php echo $i;?>" value="<?php echo $disp[$i] -> postalcode;?>"/>
												<input type="hidden" id="country_<?php echo $i;?>" value="<?php echo $disp[$i] -> country;?>"/>
												<input type="hidden" id="comments_<?php echo $i;?>" value="<?php echo $disp[$i] -> comments;?>"/>
												<td><div style="word-wrap: break-word"><?php echo $coust;?></div></td>
												<td style="word-wrap: break-word"><?php echo $disp[$i] -> lastname;?></td>
												<td style="word-wrap: break-word"><?php echo $disp[$i] -> email;?></td>
												<td style="word-wrap: break-word"><?php echo $disp[$i] -> mobile;?></td>
												<td style="word-wrap: break-word"><?php echo $disp[$i] -> city;?></td>
												<td style="word-wrap: break-word"><?php echo $disp[$i] -> postalcode;?></td>
												<td style="word-wrap: break-word"><?php echo $disp[$i] -> country;?></td>
												<td>
												<span class="data_actions iconsweet">
													<a class="tip_north fancybox" original-title="Edit Customer" id="li_<?php echo $i;?>" href="#Editcustomer" style="cursor:pointer;"  onclick="getappointments(this);">C</a>
													<a class="tip_north fancybox" original-title="Bookings" id="e_<?php echo $i;?>" onClick="custdetail(this)" href="#customerdetail" style="cursor:pointer;">P</a>
													<a class="tip_north fancybox" original-title="Send Email" id="h_<?php echo $i;?>" onClick="emailcust(this)" href="#customemail" style="cursor:pointer;">A</a>
													<a class="tip_north" original-title="Delete Customer" id="customerDeleteButton_<?php echo $i;?>" onClick="deletecustomer(this)"  style="cursor:pointer;">X</a>
													<a class="tip_north" original-title="Booking Customer" href="#" id="hid_<?php echo $i;?>" onClick="bookbackend(this)"  style="cursor:pointer;">+</a>
												</span>
											</td></tr>
											<?php }?>
										</ul>
									</tbody>
							</table>
						</div>
					</div>
				
			<div id="Addcustomer"  style="width:700px; display:none;">
				<div class="msgbar msg_Success hide_onC" id="customeradd" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
					<span class="iconsweet">=</span>
					<p>
						Customer has been Successfully added.
					</p>
				</div>
				<div class="one_two_wrap fl_left">
						<div class="widget-wp-obs" style="margin:5px;">
							<div class="widget-wp-obs_title">
									<span class="iconsweet">o</span>
									<h5> Add New Customer</h5>
							</div>
							<div class="widget-wp-obs_body">
									<ul class="form_fields_container">
											<li>
												<label> First Name :</label>
												<div class="form_input"  style="width:60%">
													<input type="text" value=""  onBlur="return customerFirstNameblur();"  id="customerFirstName">
												</div>
											</li>
											<li>
												<label> Last Name :</label>
												<div class="form_input"  style="width:60%">
													<input type="text" onBlur="return customerLastNameblur()" name="customerLastName" value="" id="customerLastName"/>
										
												</div>
											</li>
											<li>
												<label> Email :</label>
												<div class="form_input"  style="width:60%">
														
														<input    type="text" name="customeremail" id="customeremail" value="" />
												</div>
											</li>
											<li>
												<label> Mobile :</label>
												<div class="form_input"  style="width:60%">
														<input  onBlur="return customerMobileblur();" type="text" name="work" value="" id="customerMobile" onKeyPress="return validatePhone(event,this)" />
												</div>
											</li>
											<li>
												<label> Telephone :</label>
												<div class="form_input"  style="width:60%">
														<input type="text" onBlur="return customertelblur();" name="personal" value="" id="customertel" onKeyPress="return validatePhone(event,this)" />
												</div>
											</li>
											<li style="padding-bottom:12px">
												<label> Address1 :</label>
												<div class="form_input"  style="width:60%">
														<input onBlur="return customerAddress1blur();" name="address1" value="" id="customerAddress1"   type="text"/>
												</div>
											</li>
												<li>
											<label> Address2 :</label>
											<div class="form_input"  style="width:60%">
												<input onBlur="return customerAddress2blur();" name="address2" type="text" value="" id="customerAddress2" />
											</div>
										</li>
									</ul>
							</div>
						</div>
				</div>
				<div class="one_two_wrap fl_right">
						<div class="widget-wp-obs" style="margin:5px;margin-left:-20px">
							<div class="widget-wp-obs_title">
							</div>
							<div class="widget-wp-obs_body">
									<ul class="form_fields_container">
									
										<li>
											<label> City :</label>
											<div class="form_input"  style="width:60%">
													<input onBlur="return customerCityblur();" name="city" type="text" value="" id="customerCity"  />
											</div>
										</li>
										<li>
											<label> Zip/Post Code :</label>
												<div class="form_input"  style="width:60%">
													<input onBlur="return postalblur();" name="postal" type="text" value="" id="postal"  />
											</div>
										</li>
										<li style="padding-bottom:9px">
											<label> Country :</label>
											<div class="form_input"  style="width:60%">
												<select name="Country" id="Country">
													<?php
													
													
													$sel_country = $wpdb -> get_var('SELECT name  FROM ' . $wpdb -> prefix . sm_cuntry . ' where used = 1');
													$country = $wpdb->get_col
													(
															$wpdb->prepare
															(
																	"SELECT name FROM ".$wpdb->prefix."sm_cuntry where deflt = %d ORDER BY name ASC",
																	1
																	
															)
													);
													
													for($p=0;$p<= count($country);$p++)
													{
													if ($sel_country == $country[$p])
													{
													?>
													<option value="<?php echo $country[$p];?>" selected="selected"><?php echo $country[$p];
														?></option>
													<?php 
													}
													else
													{
													?>
													<option value="<?php echo $country[$p];?>"><?php echo $country[$p];
													?></option>
													<?php 
													}
													}
													?>
												</select>
											</div>
										</li>
										<li>
											<label> Notes :</label>
											<div class="form_input"  style="width:60%">
												<textarea class="auto" name="zip"   type="text" value="" id="comments" name="growingTextarea" rows="3"></textarea>
											</div>
										
											
										</li>
										<li>
										
										<div class="form_input">
											<span >
												<input  id="reqemail" type="checkbox" onclick='change(this);' style="opacity: 1;">
											</span>
											<label for="check1">Email Not Required</label>
										</div>
										</li>
									<li>
										<a  id="save" name="save" onClick="return savecustomer();" class="greyishBtn button_small" href="#" style="margin-left:120px;margin-top:10px">Add New Customer</a>
								</li>									
										
									</ul>
							</div>
						</div>
				</div>
			</div>
				
				<div id="Editcustomer"  style="width:700px;display:none;">
						<div class="msgbar msg_Success hide_onC" id="customeredit" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
							<span class="iconsweet">=</span>
							<p>
								Customer has been Successfully edited.
							</p>
						</div>
						<div class="one_two_wrap fl_left">
							<div class="widget-wp-obs" style="margin:5px;">
								<div class="widget-wp-obs_title">
										<span class="iconsweet">o</span>
										<h5> Edit Customer</h5>
								</div>
								<div class="widget-wp-obs_body">
									<ul class="form_fields_container">
										<li>
											<label> First Name :</label>
											<div class="form_input"  style="width:60%">
												<input type="text" value=""  onBlur="return customerFirstNameblur1();"  id="customerFirstName1"/>
											</div>
										</li>
										<li>
											<label> Last Name :</label>
											<div class="form_input"  style="width:60%">
												<input   type="text" name="customerLastName1" value="" id="customerLastName1"/>
											</div>
										</li>
										<li>
											<label> Email :</label>
											<div class="form_input"  style="width:60%">
												<input type="hidden" name="id" id="id" value="" />
												<input  onBlur="return customeremailblur1();"  type="text" name="customeremail1" id="customeremail1" value="" />
											</div>
										</li>
										<li>
											<label> Mobile :</label>
											<div class="form_input"  style="width:60%">
												<input type="text" name="work" value="" id="customerMobile1" onKeyPress="return validatePhone(event,this)" />
											</div>
										</li>
										<li>
											<label> Telephone :</label>
											<div class="form_input"  style="width:60%">
												<input type="text" name="customertel1" value="" id="customertel1" onKeyPress="return validatePhone(event,this)" />
											</div>
										</li>
										<li style="padding-bottom:12px">
											<label> Address1 :</label>
											<div class="form_input"  style="width:60%">
													<input name="customerAddress11" type="text" value="" id="customerAddress11" />
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="one_two_wrap fl_right">
							<div class="widget-wp-obs" style="margin:5px;margin-left:-20px">
								<div class="widget-wp-obs_title">
								</div>
								<div class="widget-wp-obs_body">
									<ul class="form_fields_container">
										<li>
											<label> Address2 :</label>
											<div class="form_input"  style="width:60%">
													<input name="customerAddress21" type="text" value="" id="customerAddress21" />
											</div>
										</li>
										<li>
											<label> City :</label>
											<div class="form_input"  style="width:60%">
													<input name="customerCity1" type="text" value="" id="customerCity1"  />
											</div>
										</li>
										<li>
											<label> Zip/Post Code :</label>
											<div class="form_input"  style="width:60%">
													<input name="postal1" type="text" value="" id="postal1"  />
											</div>
										</li>
										<li style="padding-bottom:9px">
											<label> Country :</label>
											<div class="form_input"  style="width:60%">
												<select name="Country1" id="Country1" style="">
													<?php
														$coun = $wpdb->get_col
														(
																$wpdb->prepare
																(
																		"SELECT name FROM ".$wpdb->prefix."sm_cuntry where deflt = %d",
																		1
																		
																)
														);
	                                                    
														$country = $wpdb->get_var('SELECT country FROM ' . $wpdb->prefix . sm_clients . ' where id =' . "'".  $_REQUEST['id'] . "'");      
														if ($country !=0) 
														{
													?>
													<option value="<?php echo $country; ?>"><?php echo $country; ?> </option>
													<?php 
														}
														else
														{                                                             
	                                                    	for($i=0;$i<count($coun);$i++)
															{
													?>
													<option value="<?php echo $coun[$i]; ?>"><?php echo $coun[$i]; ?> </option>
													<?php
															}
														}
													?>
	                                            </select>
											</div>
										</li>
										<li>
											<label> Notes :</label>
												<div class="form_input"  style="width:60%">
													<textarea class="auto" name="zip" type="text" value="" id="comments1" name="growingTextarea" rows="3"></textarea>
												</div>
										<a style="margin-left:120px;margin-top:10px"  name="update" id="update" class="greyishBtn button_small"  onclick="return updatecustomer();">Update Customer Details</a>
										
										 </li>
									</ul>
							</div>
						</div>
				</div>
		</div>
							<div id="customerdetail"  style="width:850px; display:none;">
								<div class="widget-wp-obs" style="margin:5px;">
									<div class="widget-wp-obs_title">
										<span class="iconsweet">o</span>
										<h5>Detail of <label id="clientNam"></label></h5>
									</div>
									<div class="widget-wp-obs_body">
									<table class="activity_datatable" id="customerhis" width="100%" border="0" cellspacing="0" cellpadding="8">
									</table>
									</div>
									</div>
		</div>
			<div id="notecustomer"  style="width:600px; display:none;">
			<div class="widget-wp-obs" style="margin:5px;">
			<div class="msgbar msg_Success hide_onC" id="customercomm" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
							<span class="iconsweet">=</span>
							<p>
								Comment has been Successfully Saved.
							</p>
							</div>
									<div class="widget-wp-obs_title">
										<span class="iconsweet">o</span>
										<h5>Customer Comments</h5>
									</div>
									<div  class="widget-wp-obs_body">
								<ul class="form_fields_container">
								<li>
								<input type="hidden" id="commentId" name="commentId" />
								<label>Comments :</label>
								
								<div id="notec"> </div>
							</li>
							<li>
								<a id="submitt" class="greyishBtn button_small" onClick="return comment()" href="#" style="margin-left:120px">Save Settings</a>
							</li>
						</ul>
				</div>
			</div>
		</div>
		<div id="customemail"  style="width:600px; display:none;">
				<div class="msgbar msg_Success hide_onC" id="successEmail" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
					<span class="iconsweet">=</span>
					<p>Email has been Successfully sent.</p>
				</div>
				<div class="widget-wp-obs" style="margin:5px;">
					<div class="widget-wp-obs_title">
						<span class="iconsweet">o</span>
						<h5>Send Email to <label id="clientName"></label></h5>
					</div>
					<div  class="widget-wp-obs_body">
						<ul class="form_fields_container">
							<input type="hidden" id="ecust" name="ecust" value="" />
							<?php 
							
							
							?>
							<li>
								<label>Email :</label>
								<div class="form_input">
									<textarea name="emcustomer"  id="emcustomer" class="tinymce" rows="15" cols="100"></textarea>
								</div>
							</li>
							<li>
								<a id="submitt" class="greyishBtn button_small" onClick="return emailcustomer()" href="#" style="margin-left:125px">Send Email</a>
							</li>
						</ul>
					</div>
				</div>
		</div>	

	

		<div id="import"  style="width:600px; display:none;">
				<div class="msgbar msg_Success hide_onC" id="successEmail" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
					<span class="iconsweet">=</span>
					<p>Import Customers</p>
				</div>
				<div class="widget-wp-obs" style="margin:5px;">
					<div class="widget-wp-obs_title">
						<span class="iconsweet">o</span>
						<h5>Import Customers</h5>
					</div>
					<div  class="widget-wp-obs_body">
						
				<form enctype="multipart/form-data" action="<?php echo $url;?>import.php" method="POST" >
					<ul class="form_fields_container">
					<li>
						<div class="form_input" >
						<input type="hidden" name="file_upload" id="file_upload" value="true" />
						</div>
					</li>
					<li>
						<div class="form_input" >
						<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
						<div class="choose_file">
						Choose Your CSV File: <input name="uploadedfile" type="file" style="margin-left:10px; width:200px; " /><br /><br />
							</div>
							</div>
					</li>
					<li>
					<div class="form_input" >
							<input type="submit" class="uploads" name="btnimport" id="btnimport" value="Upload File"  />
					</li>
					</ul>
				
					</div>	
					</form>
				</div>	
			</div>	
		</div>	


		
	</div>
</div>
</div>
<?php
}
?>

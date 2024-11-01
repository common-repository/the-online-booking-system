<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$url = plugins_url('', __FILE__) . "/"; 

include_once ('function.php');

$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 20;
if($paqe == 1)
{
$startpoint = ($page * $limit);
}
else
{
$startpoint = ($page * $limit) - $limit;
}
//to make pagination


?>


	<link rel="stylesheet" href="<?php echo $url;?>css/A_yellow.css" />
	<link rel="stylesheet" href="<?php echo $url;?>css/pagination.css" />
	<script type="text/javascript">jQuery("select, input:checkbox, input:radio").uniform();</script>
	
	<link rel="stylesheet"  type="text/css" href="<?php echo $url; ?>source/jquery.fancybox.css" />
	<script type="text/javascript">
	
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
													if(jQuery('#customerMobile1').val()=="")
													{
														jQuery("#customerMobile1").addClass("in_error");
														return false;
                                                    }
                                                   else
                                                    {
													if(jQuery("#customerMobile1").hasClass('in_error'))
													{
														jQuery("#customerMobile1").removeClass("in_error");
													}
														jQuery("#customerMobile1").addClass("in_submitted");
														return true;
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
														jQuery.fancybox.update();
													}
													function updatecustomer()
													{
														if(customerFirstNameblur1()  && customerMobileblur1())
														{
															jQuery(document).ready(function($) 
															{
																var firstnam1=document.getElementById("customerFirstName1").value;
																var lastname1=document.getElementById("customerLastName1").value;
																var email1=document.getElementById("customeremail1").value;
																var mobile1=document.getElementById("customerMobile1").value;
																var tel1=document.getElementById("customertel1").value;
																var customerAddress11=document.getElementById("customerAddress11").value;
																var customerAddress21=document.getElementById("customerAddress21").value;
																var customerCity1=document.getElementById("customerCity1").value;
																var Country1=document.getElementById("Country1").value;
																var comments1=document.getElementById("comments1").value;
																var customerZip1=document.getElementById("postal1").value;
																var iddd1=document.getElementById("id").value;
																		
																jQuery.ajax
																({	
																		type: "POST",
																		data:"firstnam1="+firstnam1+"&lastnam1="+lastname1+"&email1="+email1+"&id1="+iddd1+"&mobile1="+mobile1+"&tel1="+tel1+"&customerAddress11="+customerAddress11+"&customerAddress21="+customerAddress21+"&customerCity1="+customerCity1+"&Country1="+Country1+"&customerZip1="+customerZip1+"&comments1="+comments1+"&action=updatecust",
																		url: uri+"/customer.php",
																		success: function(data)
																		{
																			jQuery("#customeredit").css('display','block');
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
																							
																							parent.jQuery.fancybox.close();
																							
																							jQuery('#LimitedContentPlaceHolder').empty();
																							jQuery('#LimitedContentPlaceHolder').fadeOut("fast").load(uri+"/exports.php?page=refresh").fadeIn(1000);	
																							
							
																					}, 1000);
																					var iddd=document.getElementById("id").value;
																		}
																});
															});
														}
													}	
	</script>


<div  class="contentarea">
<form id="idexports" method="post" action="<?php echo $url;?>exportbutton.php" >

		
			<div class="one_wrap fl_left">
				<div class="msgbar msg_Success hide_onC" style="display: none">
					<span class="iconsweet">=</span>
					<p>
						Data has been successfully exported.
					</p>
				</div>
				<ul class="form_fields_container">
					<li>
						<input type="submit"  id="submitExport" class="preview button" style="float:left;margin-left:5px;" name="submitExport" value="Export Data"/>
						<!-- <a style="margin: 5px;" class="greyishBtn button_small" href="#">Export Data</a>-->
					</li>
				</ul>
				<div class="widget-wp-obs" style="margin-top:0px">
					<div class="widget-wp-obs_title">
						<span class="iconsweet">f</span>
						<h5>Export Data</h5>
					</div>
					<div class="widget-wp-obs_body">
					<div id="div_services_table">
		<?php
            //show records
			
			
			$statement = $wpdb->get_results
			(
				$wpdb->prepare
				(
					  "SELECT * FROM ".$wpdb->prefix."sm_clients ORDER BY name ASC  LIMIT %d,%d",
					  $startpoint,
					  $limit
				)
			);
			$statement1 = $wpdb->get_results
			(
				$wpdb->prepare
				(
					  "SELECT * FROM ".$wpdb->prefix."sm_clients ORDER BY name ASC"
				)
			);
			
			$total = count($statement1);
			
            ?>
			<table class="activity_datatable" id="exporttable" width="100%" border="0" cellspacing="0" cellpadding="8">
					<tbody>
								<tr>
									<th width="11%"> First Name </th>
									<th width="11%"> Last Name </th>
									<th width="15%"> Email </th>
									<th width="10%"> Mobile </th>
									<th width="12%"> Tel. </th>
									<th width="12%"> Addr 1 </th>
									<th width="5%"> City </th>
									<th width="13%"> Country </th>
									<th width="11%"> Post Code </th>
								</tr>
								<?php
									for ($i = 0; $i < count($statement); $i++) 
									{
										$st = ($i%2 == 0)? '': 'background-color: #f6f6f6';
									$idd = $statement[$i]->id;
									$nam = $statement[$i]->name;
									$emai = $statement[$i]->email;
									$telephon = $statement[$i]->telephone;
									$addressLin1 = $statement[$i]->addressLine1;
									$addressLin2 = $statement[$i]->addressLine2;
									$cty = $statement[$i]->city;
									$postcode = $statement[$i]->postalcode;
									$contry = $statement[$i]->country;
									$coment = $statement[$i]->comments;
									$lastnam = $statement[$i]->lastname;
									$mob = $statement[$i]->mobile;
									?>
										<input type="hidden" id="id_<?php echo $i;?>" name="<?php echo $i;?>" value="<?php echo $idd;?>"/>
												<input type="hidden" id="name_<?php echo $i;?>" name="<?php echo $i;?>" value="<?php echo $nam;?>"/>
												<input type="hidden" id="lname_<?php echo $i;?>" name="<?php echo $i;?>" value="<?php echo $lastnam;?>"/>
												<input type="hidden" id="email_<?php echo $i;?>" value="<?php echo $emai;?>"/>
												<input type="hidden" id="mobile_<?php echo $i;?>" value="<?php echo $mob;?>"/>
												<input type="hidden" id="telephone_<?php echo $i;?>" value="<?php echo $telephon;?>"/>
												<input type="hidden" id="addressLine1_<?php echo $i;?>" value="<?php echo $addressLin1;?>"/>
												<input type="hidden" id="addressLine2_<?php echo $i;?>" value="<?php echo $addressLin2;?>"/>
												<input type="hidden" id="city_<?php echo $i;?>" value="<?php echo $cty;?>"/>
												<input type="hidden" id="postalcode_<?php echo $i;?>" value="<?php echo $postcode;?>"/>
												<input type="hidden" id="country_<?php echo $i;?>" value="<?php echo $contry;?>"/>
												<input type="hidden" id="comments_<?php echo $i;?>" value="<?php echo $coment;?>"/>
										<tr style="<?php echo $st; ?> ">
										<td><a class="tip_north fancybox" original-title="Edit Customer" id="li_<?php echo $i;?>" href="#Editcustomer1" style="cursor:pointer;"  onclick="getappointments(this);"><?php echo $nam;?></a></td>
										<td><?php echo $lastnam;?></td>
										<td><?php echo $emai;?></td>
										<td><?php echo $mob;?></td>
										<td><?php echo $telephon;?></td>
										<td><?php echo $addressLin1;?></td>
										<td><?php echo $cty;?></td>
										<td><?php echo $contry;?></td>
										<td><?php echo $postcode;?></td>
									</tr>
								<?php
								}
								?>
								<tr>
							
<td colspan="9">	<?php
echo pagination($total,$limit,$page);
?></td>
								</tr>
							</tbody>
						</table>
						</div>	</div></div></div></form>	
	<div id="Editcustomer1"  style="width:700px;display:none;">
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
												<input  type="text" name="customerLastName1" value="" id="customerLastName1"/>
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
											<label> Zip :</label>
											<div class="form_input"  style="width:60%">
													<input name="postal1" type="text" value="" id="postal1" onKeyPress="return validatePhone(event,this)" />
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
	                                                   $country = $wpdb->get_var('SELECT country FROM ' . $wpdb->prefix . sm_clients . ' where id =' . "'".  intval($_REQUEST['id']) . "'");      
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


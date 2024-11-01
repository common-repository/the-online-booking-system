<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
 
?>

<?php
if($_REQUEST['action'] == 'transdata')
{
	$table_name = $wpdb->prefix . "sm_translation";
	$tr = html_entity_decode($_REQUEST['translate']);
	$wpdb->query
     (
           $wpdb->prepare
           (
                "UPDATE ".$wpdb->prefix."sm_translation SET translate = %s where item = %s",
                $tr,
                esc_attr($_REQUEST['value'])
           )
      );
	}
?>
<script type="text/javascript">jQuery("select, input:checkbox, input:radio").uniform();</script>
<script type="text/javascript">
function save_fields()
{
			<?php $bookfields = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_booking_field);?>
			var countfields = "<?php echo $bookfields;?>";
			for(var i=0;i<countfields;i++)
			{
					var radiovisible;
					var radioo2req;
					if(i!=0)
					{
						if(i!=1)
						{
								var radios = document.getElementsByName('radioo'+i);
								for (var j = 0; j < radios.length; j++) 
								{
									if(radios[j].type == 'radio' && radios[j].checked)
									{
										radiovisible = radios[j].value;
										break;
									}
								}
						}
						else
						{
								radiovisible=1;
						}
					}
					else
					{
							radiovisible=1;
					}
					if(i!=0)
					{
							if(i!=1)
							{
									var radioss = document.getElementsByName('radiobut'+i);
									for (var k = 0; k < radioss.length; k++) 
									{
										if (radioss[k].type == 'radio' && radioss[k].checked)
										{
												radioo2req = radioss[k].value;
												break;
										}
									}	
							}
							else
							{
									radioo2req=1;
							}
					}
					else
					{
							radioo2req=1;
					}
					var field_name11= document.getElementById("field_name"+i).value;
					var field_name = encodeURIComponent(field_name11);
					var fime1= document.getElementById("filnm1"+i).value;
					var field_name1 = encodeURIComponent(fime1);
					
					var filepath1=uri+"/radio.php";
					jQuery.ajax
					({
							type: "POST",
							data: "fieldcompare="+field_name1+"&fieldtoupdate="+field_name+"&radiovisible="+radiovisible+"&radioo2req="+radioo2req,
							url: filepath1,
							success: function(data)
							{
							}
					});
			}
			jQuery("#msgshow").css('display','block');
			setTimeout(function()
			{
					jQuery("#msgshow").css('display','none');
			},1000);
			<?php $bookfields = $wpdb -> get_var('SELECT count(id) FROM ' . $wpdb -> prefix . sm_translation);?>
			var countfields = "<?php echo $bookfields;?>";
			
			for(var k=0;k<countfields;k++)
			{
					var tr= document.getElementById("trans_field"+k).value;
					var translate = encodeURIComponent(tr);
					var valu= document.getElementById("valu"+k).value;
					var filepath2=uri+"/booking_form.php";
					jQuery.ajax
					({
							type: "POST",
							data: "translate="+translate+"&value="+valu+"&action=transdata",
							url: filepath2,
							success: function(data)
							{
							}
					});
									
			}
	
}
</script>
<div id="bookfrmpg" class="contentarea">
	<form id="bookfom">
		<div id="msgshow" class="msgbar msg_Success hide_onC" style="display: none;margin-top:10px;">
			<span class="iconsweet">=</span>
			<p>
				Booking Form has been successfully saved.
			</p>
		</div>
		<ul class="form_fields_container" style="margin-top:0px;margin-bottom:-10px;">
				<li>
					<a id="button" href="javascript:;" onclick="return save_fields();" class="greyishBtn button_small">Save Fields</a>
				</li>
			</ul>
		<div class="one_wrap fl_left">
			<div class="widget-wp-obs" style="margin-top: 0px;margin-bottom:0px;">
				<div class="widget-wp-obs_title">
					<span class="iconsweet">f</span>
					<h5>Booking Form</h5>
				</div>
				
				<div class="widget-wp-obs_body">
					<table class="activity_datatable" width="100%" border="0" cellspacing="0" cellpadding="8">
						<tbody>
							<tr>
								<th width="40%">Field Name</th>
								<th width="60%">Rename Field</th>
								
							</tr>
							<?php
							$field = $wpdb->get_results
						    (
						        $wpdb->prepare
						        (
						            "SELECT * FROM ".$wpdb->prefix."sm_booking_field"
						        )
						    );
							for ($i = 0; $i < count($field); $i++) 
							{
									$fiel = $field[$i]->field_name;
									$fiel2 = $field[$i]->field_name2;
									$stat = $field[$i]->status;
									$req = $field[$i]->required;
									$checked = "";
									$check = "";
									if ($stat == 1) 
									{
										$checked = "checked='checked'";
									} 
									else 
									{
										$check = "checked='checked'";
									}
									$check1 = "";
									$check0 = "";
									if ($req == 1) 
									{
										$check1 = "checked='checked'";
									} 
									else 
									{
										$check0 = "checked='checked'";
									}
									?>
									<tr>
										<td><?php echo $fiel
										?>
										
										<input type="hidden" id="filnm1<?php echo $i;?>" value="<?php echo $fiel;?>"/>
										</td>
										<td>
										<ul class="form_fields_container">
											<li style="background: none">
												<div class="form_input" style="width:95%">
													<input type="text"  id="field_name<?php echo $i;?>" name="field_name<?php echo $i;?>" value="<?php echo $fiel2 ?>"  class="tip_east" original-title="Enter your own translation" />
												</div>
										
											</li>
										</ul> 
										</td>
									
										
									</tr>
									<?php $checked = "";
										$check = "";
										$check1 = "";
										$check0 = "";
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>
<a href="http://www.wp-online-booking-system.com"  target="_blank"><img style="margin: 20PX 20PX 0PX 20PX;" src="<?php echo $url;?>images/booking_form.jpg" alt=""/></a>
<div class="one_wrap fl_left" >
			<div class="widget-wp-obs" style="margin-left: 20px;margin-right:20px;">
				<div class="widget-wp-obs_title">
					<span class="iconsweet">f</span>
					<h5>Translation Form</h5>
				</div>
				<div class="widget-wp-obs_body">
					<table class="activity_datatable" width="100%" border="0" cellspacing="0" cellpadding="8">
						<tbody>
							<tr>
								<th width="40%">Value</th>
								<th width="60%">Translate Value</th>
							</tr>
							<?php
							$translator = $wpdb->get_results
						    (
						        $wpdb->prepare
						        (
						            "SELECT * FROM ".$wpdb->prefix."sm_translation"
						        )
						    );
							for ($i = 0; $i < count($translator); $i++) 
							{
								$item = $translator[$i]->item;
								$value = $translator[$i]->value;
								$trans = $translator[$i]->translate;
								?>
								<tr>
									<td><?php echo $value; ?>
									<input type="hidden" id="valu<?php echo $i;?>" value="<?php echo $item;?>"/>
									</td>
									<td>
									<ul class="form_fields_container">
										<li style="background: none">
											<div class="form_input" style="width:95%">
												<textarea id="trans_field<?php echo $i;?>" name="trans_field<?php echo $i;?>" class="tip_east" original-title="Enter your own translation"><?php echo $trans ?></textarea>
											</div>
										</li>
									</ul> 
									</td>
								</tr>
								<?php 
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<ul class="form_fields_container" style="margin-left:20px;margin-top:0px;">
				<li>
					<a id="button" href="javascript:;" onclick="return save_fields();" class="greyishBtn button_small">Save Fields</a>
				</li>
			</ul>
		</div>
<script type="text/javascript">
	function setaction(e) 
	{
		var t = e.id;
		var radid = t.split("_");
		value = e.value;
		if(value == 0) 
		{
			document.getElementById('-radio_' + radid[1]).removeAttribute("class", "checked");
			document.getElementById('-radio5_' + radid[1]).setAttribute("class", "checked");
			document.getElementById('radio5_' + radid[1]).setAttribute("disabled", "disabled");
			document.getElementById('radio_' + radid[1]).setAttribute("disabled", "disabled");
		} 
		else if(value == 1)
		{
			document.getElementById('-radio_' + radid[1]).setAttribute("class", "checked");
			document.getElementById('-radio5_' + radid[1]).removeAttribute("class", "checked");
			document.getElementById('radio5_' + radid[1]).removeAttribute("disabled", "disabled");
			document.getElementById('radio_' + radid[1]).removeAttribute("disabled", "disabled");
		}
	}
</script>

<div id="setpage">	
<?php 
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
?>
<style type="text/css">
        /* body { background: #ccc;} */
        div.jHtmlArea .ToolBar ul li a.custom_disk_button 
        {
            background: url(images/disk.png) no-repeat;
            background-position: 0 0;
        }
        
        div.jHtmlArea { border: solid 1px #ccc; }
    </style>
<?php
	
	
if(isset($_REQUEST['action']))
{
	if($_REQUEST['action'] == 'AddCurrency')
	{
			$name = html_entity_decode($_REQUEST['nam']);
			$symbol = html_entity_decode($_REQUEST['sym']);
			$table_name = $wpdb->prefix . "sm_currency";
			$wpdb->query
	        (
	                  $wpdb->prepare
	                  (
	                       "INSERT INTO ".$wpdb->prefix."sm_currency(currency,currency_sign,currency_used) VALUES( %s, %s, %d)",
	                       $name,
	                       $symbol,
	                       0
	                       
	                   )
	        );
	}
	else if($_REQUEST['action'] == 'UpdateCurriences')
	{
			$id = intval($_POST['id']);
			$currencyname = esc_attr($_POST['currency_name']);
			$currencysign = esc_attr($_POST['currency_sign']);
			
			$table_name = $wpdb->prefix . "sm_currency";
			$wpdb->query
		     (
		            $wpdb->prepare
		            (
		                    "UPDATE ".$wpdb->prefix."sm_currency SET currency = %s, currency_sign = %s  WHERE id = %d",
		                    $currencyname,
		                    $currencysign,
		                    $id
		                   
		             )
		      );	
			return false;
		
	}
	else if($_REQUEST['action'] == 'deleteCurrency')
	{
			$iddd = intval($_REQUEST['idd']);
			$wpdb->query
			  (
			  		$wpdb->prepare
			    	(
			    		"DELETE FROM ".$wpdb->prefix."sm_currency WHERE id = %d",
			       		 $iddd
			   		 )
			  );
				return false;
	}
	else if($_REQUEST['action'] == 'saveSettings')
	{
				$curr = esc_attr($_REQUEST['currency']);
				$thankhdr = html_entity_decode($_REQUEST['thankshd']);
				$bhedr = html_entity_decode($_REQUEST['bhedr']);
				$wpdb->query
				(
				      $wpdb->prepare
				      (
				          	"UPDATE ".$wpdb->prefix."sm_currency SET currency_used = %d where currency = %s",
				          	 1,
				          	 $curr
				       )
				 );	
				$wpdb->query
				(
				      $wpdb->prepare
				      (
				          	"UPDATE ".$wpdb->prefix."sm_currency SET currency_used = %d where currency != %s",
				          	 0,
				          	 $curr
				       )
				 );	
				
				$table_name = $wpdb->prefix . "sm_settings";
				$qry10 ="UPDATE $table_name set  book_header = ". '"' . $bhedr . '"'.",thanks = ". '"' . $thankhdr . '"'." where id = '1'";
				$wpdb->query($qry10);
		}
}
else
{
?>
	
	<script type="text/javascript">
	    jQuery(function() {

            jQuery("textarea").htmlarea(); // Initialize jHtmlArea's with all default values
        });

		function moveoutid()
		{
			var sda = document.getElementById('Select1');
			var len = sda.length;
			var sda1 = document.getElementById('Select2');
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
		function moveinid()
		{
			var sda = document.getElementById('Select1');
			var sda1 = document.getElementById('Select2');
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
					try
					{
						sda.add(y,null);
					}
					catch(ex)
					{
						sda.add(y);
					}
				}
			}
		}
		function funcurrency()
		{
					jQuery(document).ready(function($) 
					{
							var currency = jQuery("#currency").val();
							
							var bhe = jQuery("#elm1").val();
							var bheadr = encodeURIComponent(bhe);
							var tha = jQuery("#cust1").val();
							var thankshd = encodeURIComponent(tha);
							var result = jQuery.ajax({
										type: "POST",
										data: "currency="+currency+"&bhedr="+bheadr+"&thankshd="+thankshd+"&action=saveSettings",
										url: uri+"/setting.php",
										success: function(data) 
										{
											
											jQuery("#successSettings").css('display','block');
											setTimeout(function() 
											{
												jQuery("#successSettings").css('display','none');
											}, 1000);
										}
									});
									//result.abort();
					});
		}
		function add_currency()
		{
			
			if(currblur() && currsymbol())
			{
			var sy = document.getElementById('symbol').value;
			var na = document.getElementById('name').value;
			var syb = encodeURIComponent(sy);
			var nam = encodeURIComponent(na);
			jQuery(document).ready(function($) 
			{	
			
						jQuery.ajax
						({
							type: "POST",
							data: "nam="+nam+"&sym="+syb+"&action=AddCurrency",
							url: uri+"/setting.php",
							success: function(data) 
							{
								jQuery("#savecurr").css('display','block');
								path= uri+"/settingrebind.php";
								jQuery.ajax
								({
										type: "POST",
										data: "bindsetting=true",
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
												jQuery("#managecurr").html(cal);
												jQuery("#currency").html(time);
											setTimeout(function() 
											{
												
												jQuery("#savecurr").css('display','none');
												parent.jQuery.fancybox.close();
												document.getElementById('symbol').value="";
												document.getElementById('name').value="";
												if(jQuery("#name").hasClass('in_submitted'))
												{
													jQuery("#name").removeClass("in_submitted");
												}
												if(jQuery("#symbol").hasClass('in_submitted'))
												{
													jQuery("#symbol").removeClass("in_submitted");
												}
												
											}, 1000);		
									}	
							});
						}
					});
				});
		}
	}	
			function currsymbol(){
				var syb = document.getElementById('symbol').value;
				if(syb=="")
				{
					jQuery("#symbol").addClass("in_error");
					return false;
				
				}
				else
				{
					if(jQuery("#symbol").hasClass('in_error'))
					{
						jQuery("#symbol").removeClass("in_error");
					}
					jQuery("#symbol").addClass("in_submitted");
					return true;
				}																																	
			}
			function currblur()
		{
				var nam = document.getElementById('name').value;
				if(nam=="")
				{
					jQuery("#name").addClass("in_error");
					return false;
				}
				else
				{
					if(jQuery("#name").hasClass('in_error'))
					{
						jQuery("#name").removeClass("in_error");
					}
					jQuery("#name").addClass("in_submitted");
					return true;
				}
				}
		function edit_mode(elm)
		{
			jQuery(document).ready(function($) 
			{
				var e_name=document.getElementById('txt_c_name_'+elm.name);
				var e_sign=document.getElementById('txt_c_sign_'+elm.name);
				e_name.removeAttribute("readonly",0);
				e_sign.removeAttribute("readonly",0);
				e_sign.focus();
				e_name.setAttribute('style','border:1px solid #ccc;background-color:#fff;width:250px;');
				e_sign.setAttribute('style','border:1px solid #ccc;background-color:#fff;width:50px;');
				document.getElementById(elm.id).style.display='none';
				document.getElementById('save_'+elm.name).style.display='block';
				document.getElementById('cancelc_'+elm.name).style.display='block';
				document.getElementById(elm.name).style.display='none';
				elm.style.display='none';
			});
		}
		function save_currency(el)
		{
			jQuery(document).ready(function($) 
			{	
				
				var id=el.name;
				
				var currency_name=document.getElementById('txt_c_name_'+id);
				var currency_name_value=currency_name.value;
				var currency_sign=document.getElementById('txt_c_sign_'+id);
				var currency_sign_value=currency_sign.value;
				if(currency_name_value!="" && currency_sign_value!="")
				{
					jQuery.ajax
					({
					type: "POST",
					data: "currency_name="+currency_name_value+"&currency_sign="+currency_sign_value+"&id="+id+"&action=UpdateCurriences",
					url: uri+"/setting.php",
					success: function(data) 
					{
						
						path= uri+"/settingrebind.php";
								jQuery.ajax
								({
										type: "POST",
										data: "bindsetting=true",
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
												jQuery("#managecurr").html(cal);
												jQuery("#currency").html(time);
												document.getElementById('edit_'+id).style.display='block';
												document.getElementById('cancelc_'+id).style.display='none';
												document.getElementById(id).style.display='block';
												document.getElementById(el.id).style.display='none';
												
												currency_name.setAttribute('readonly','readonly');
												currency_sign.setAttribute('readonly','readonly');
												currency_name.setAttribute('name',currency_name_value);
												currency_sign.setAttribute('name',currency_sign_value);
												currency_name.setAttribute('style','border:1px solid #ccc;background-color:#eee;width:250px;');
												currency_sign.setAttribute('style','border:1px solid #ccc;background-color:#eee;width:50px;');
										}
								});
					}
					});
					}
				else
				{
					if(currency_name_value=="")
					{
						currency_name.setAttribute('style','border:1px solid red;background-color:#FCD2D2;width:250px;');
					}
					if(currency_sign_value=="")
					{
						currency_sign.setAttribute('style','border:1px solid red;background-color:#FCD2D2;wdith:50px;');
					}
				}
			});
		}
		function delete_currency(currency) 
		{
			jQuery(document).ready(function($) 
			{   
				action = confirm("Are you sure you want to delete this currency?");
				if(action == true)               
				{   
					   
					jQuery.ajax({
						type: "POST",
						data: "idd=" + currency + "&action=deleteCurrency",
						url: uri+"/setting.php",
						success: function(data) 
						{
						
						path= uri+"/settingrebind.php";
								jQuery.ajax
								({
										type: "POST",
										data: "bindsetting=true",
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
												jQuery("#managecurr").html(cal);
												jQuery("#currency").html(time);
												// setTimeout(function() 
												// {
													// parent.jQuery.fancybox.close();
												// }, 1000);													                                                                          	
										}
								});
						}
				});
 		}  
	});
}		
		function cancel_save_currency(ec)
		{
				var e_name=document.getElementById('txt_c_name_'+ec.name);
				var e_sign=document.getElementById('txt_c_sign_'+ec.name);
				e_name.value=e_name.name;
				e_sign.value=e_sign.name;
				e_name.setAttribute('readonly','readonly');
				e_sign.setAttribute('readonly','readonly');
				e_name.setAttribute('style','border:1px solid #ccc;width:250px;background-color:#eee');
				e_sign.setAttribute('style','border:1px solid #ccc;width:50px;background-color:#eee');
				ec.style.display='none';
				document.getElementById('edit_'+ec.name).style.display='block';
				document.getElementById('save_'+ec.name).style.display='none';
				document.getElementById(ec.name).style.display='block';
		}
		function check_blur(ev)
		{
			if(ev.value!="")
			{
				ev.setAttribute('style','border:1px solid #ccc;width:50px');
			}
			else
			{
				ev.setAttribute('style','border:1px solid red;background-color:#FCD2D2;width:50px;');
			}
		}
		function check_blur1(ev)
		{
			if(ev.value!="")
			{
				ev.setAttribute('style','border:1px solid #ccc;width:250px');
			}
			else
			{
				ev.setAttribute('style','border:1px solid red;background-color:#FCD2D2;width:250px;');
			}
		}
	</script>

	<div id="content" class="contentarea">
		<form action="" method="get" id="settings">
			<div class="one_wrap fl_left">
				<div class="msgbar msg_Success hide_onC" id="successSettings" style="display: none;margin-top:15px;margin-bottom:-10px">
					<span class="iconsweet">=</span>
					<p>
						All the Settings have been saved successfully.
					</p>
				</div>
				<div class="widget-wp-obs">
					<div class="widget-wp-obs_title">
						<span class="iconsweet">i</span>
						<h5>Settings</h5>
					</div>
					<div class="widget-wp-obs_body">
						<ul class="form_fields_container">
							<li>
								<label>Default Currency</label>
								<div class="form_input">
									<?php
									
									 $currency = $wpdb->get_col
									 (
										$wpdb->prepare
										(
											  "SELECT currency From ".$wpdb->prefix."sm_currency order by currency ASC"
										)
									 );	
									
									$currency_code = $wpdb->get_col
									 (
										$wpdb->prepare
										(
											  "SELECT currency_sign From ".$wpdb->prefix."sm_currency order by currency ASC"
										)
									 );	
									
									$currency_sel = $wpdb -> get_var('SELECT currency FROM ' . $wpdb -> prefix . sm_currency . ' where currency_used = 1');
									$sel_country = $wpdb -> get_var('SELECT name  FROM ' . $wpdb -> prefix . sm_cuntry . ' where used = 1');
									$country = $wpdb->get_col
									 (
										$wpdb->prepare
										(
											  "SELECT name From ".$wpdb->prefix."sm_cuntry where deflt = %d order by name ASC",
											  "1"
										)
									 );	
									$bhdr = $wpdb -> get_var('SELECT book_header   FROM ' . $wpdb -> prefix . sm_settings . ' where id = 1');
									$thank = $wpdb -> get_var('SELECT thanks   FROM ' . $wpdb -> prefix . sm_settings . ' where id = 1');
									?>
									<select name="currency" id="currency" style="width:200px;">
										<?php
										for ($i = 0; $i < count($currency); $i++)
										{
										if ($currency[$i] == $currency_sel)
										{
										$cc = $currency_code[$i];
										?>
										<option value="<?php echo $currency[$i];?>" selected='selected'><?php echo "(" . $cc . ")  ";
											echo $currency[$i];
											?></option>
										<?php }
												else
												{
										?>
										<option value="<?php echo $currency[$i];?>"><?php echo "(" . $currency_code[$i] . ")  ";
											echo $currency[$i];
											?></option>
										<?php }
												}
										?>
									</select>
									<a style="margin: 2px 0px 2px 20px;text-shadow:none" class="greyishBtn button_small fancybox" href="#manageCurrency" ><span class="iconsweet">*</span>Manage Currencies</a>
									<a class="greyishBtn button_small fancybox"  href="#addcurr" style="text-shadow:none">Add Currency</a>
								</div>
							</li>
							<li>
								<a href="http://www.wp-online-booking-system.com" target="_blank"><img src="<?php echo $url;?>images/settings_pro.jpg" alt=""/></a>
							</li>
							<li>
								<label>Booking Form Header</label>
								<div class="form_input">
									<textarea id="elm1" name="elm1" rows="15" cols="100"  class="tinymce">
									<?php echo $bhdr;?></textarea>
								</div>
							</li>
							<li>
								<label>Thank You Customer</label>
								<div class="form_input">
									<textarea id="cust1" name="cust1" rows="15" cols="100"  class="tinymce">
									<?php echo $thank;?></textarea>
								</div>
							</li>
							<li>
								<a id="submitt" class="greyishBtn button_small" onClick="return funcurrency();" href="#" style="margin-left:240px">Save Settings</a>
							</li>
						</ul>
					
				</div>
			</div>
	</div>
	
<div style="display:none;width:500px;" id="manageCurrency">
	<div class="widget-wp-obs" style="margin:5px;">
		<div class="widget-wp-obs_title">
			<span class="iconsweet">7</span>
			<h5> Manage Currencies</h5>
		</div>
		<div class="widget-wp-obs_body">
			<?php 
			$currency1 = $wpdb->get_col
			(
					$wpdb->prepare
					(
							"SELECT currency From ".$wpdb->prefix."sm_currency order by currency ASC"
					)
			);	
			$currency_sign = $wpdb->get_col
			(
					$wpdb->prepare
					(
							"SELECT currency_sign From ".$wpdb->prefix."sm_currency order by currency ASC"
					)
			);	
			$currency_id = $wpdb->get_col
			(
					$wpdb->prepare
					(
							"SELECT id From ".$wpdb->prefix."sm_currency order by currency ASC"
					)
			);	
			
			?>
			<table class="activity_datatable" id="managecurr" width="100%" border="0" cellspacing="0" cellpadding="8">
				<tr >
					<th width="10%">Sign</th>
					<th width="40%">Currency(s)</th>
					<th width="20%">Actions</th>
				</tr>
				<?php
				for ($i = 0; $i < count($currency1); $i++) {
				?>
				<tr id="tr_<?php echo $currency_id[$i];?>">
					<td width="20%">
					<input id="txt_c_sign_<?php echo $currency_id[$i];?>" name="<?php echo $currency_sign[$i];?>" type="text" value="<?php echo $currency_sign[$i];?>"  readonly='' onBlur="check_blur(this);" style="width:50px"/>
					</td>
					<td width="60%">
					<input id="txt_c_name_<?php echo $currency_id[$i];?>" name="<?php echo $currency1[$i];?>" type="text" value="<?php echo $currency1[$i];?>"  readonly='' onblur='check_blur1(this);' style="width:250px"/>
					</td>
					<td width="20%"><span class="data_actions iconsweet"> <a class="tip_east" original-title="Edit" id="edit_<?php echo $currency_id[$i];?>" name="<?php echo $currency_id[$i];?>" style="cursor:pointer;"  onclick="edit_mode(this);">C</a> <a class="tip_west" original-title="Delete" id='<?php echo $currency_id[$i];?>' style="cursor:pointer;" name='<?php echo $currency_id[$i];?>'  href="javascript: delete_currency('<?php echo $currency_id[$i];?>')">X</a> <a class="tip_east" original-title="Save" id="save_<?php echo $currency_id[$i];?>" name="<?php echo $currency_id[$i];?>" type="button" onClick="save_currency(this)" style="display:none;font-weight:bold;cursor:pointer;">=</a> <a class="tip_west" original-title="Cancel" id="cancelc_<?php echo $currency_id[$i];?>" name="<?php echo $currency_id[$i];?>" type="button" value="Cancel" onClick="cancel_save_currency(this)" style="display:none;font-weight:bold;cursor:pointer;">x</a></span></td>
				</tr>
				<?php
				}
				?>
			</table>
		</div>
	</div>
</div>
<div  id="addcurr" style="display:none;width:600px;">
				<div class="msgbar msg_Success hide_onC" id="savecurr" style="display: none;margin-top:5px;margin-bottom:5px;width:95%;margin-left:5px;">
					<span class="iconsweet">=</span>
					<p>
						Currency has been Successfully saved.
					</p>
				</div>
				<div class="widget-wp-obs" style="margin:5px;">
					<div class="widget-wp-obs_title">
						<span class="iconsweet">z</span>
						<h5> Add Currency</h5>
					</div>
					<div class="widget-wp-obs_body">
						<ul class="form_fields_container">
							<li>
								<label> Currency Symbol :</label>
								<div class="form_input" style="width: 60%">
									<input type="text" onBlur="return currsymbol(this);" id="symbol" name="symbol"/>
								</div>
							</li>
							<li>
								<label> Currency Name :</label>
								<div class="form_input" style="width: 60%">
									<input type="text" onBlur="return currblur(this);" id="name" name="name"/>
								</div>
							</li>
							<li>
								<a href="#" class="greyishBtn button_small" id="add_curr"  onclick="return add_currency();"  name="add_curr" style="margin-left:212px;">Save Details</a>
							</li>
						</ul>
					</div>
				</div>
</div>
</form>
</div>
</div>


<?php
}
?>
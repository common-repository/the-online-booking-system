<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;

if (isset($_REQUEST['data'])) 
{
	//DELETE THE CUSTOMER ID FROM THE DATABASE	
	$dat = intval($_REQUEST['data']);
	$wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpdb->prefix."sm_clients WHERE id = %d;", $dat ));
	
}
?>
<table class="activity_datatable"  width="100%" border="0" cellspacing="0" cellpadding="8" id="searchcustomer">
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
			$alpha  = "a";
			$query ="name LIKE '". $alpha ."%'";
			// SELECT DATA FROM THE CLIENT TABLE AND SHOW IT INTO THE TABLE
			$disp = $wpdb -> get_results("SELECT id, name, lastname, email, mobile, telephone, addressLine1, addressLine2, city,postalcode,country,comments FROM " . $wpdb -> prefix . sm_clients . " WHERE " . $query . " order by name ASC");
			$cou = count($disp);?>
			<input type="hidden" id="txtcount" value="<?php echo $cou;?>"/>
			<?php
			for ($i = 0; $i < count($disp); $i++)
			{
					$coust = $disp[$i]->name;
					$st = ($i%2 == 0)? '': 'background-color: #ffffff';?>
					<tr style="<?php echo $st ?>">
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
					<td class="break-word"><?php echo $coust;?></td>
					<td class="break-word"><?php echo $disp[$i] -> lastname;?></td>
					<td class="break-word"><?php echo $disp[$i] -> email;?></td>
					<td class="break-word"><?php echo $disp[$i] -> mobile;?></td>
					<td class="break-word"><?php echo $disp[$i] -> city;?></td>
					<td class="break-word"><?php echo $disp[$i] -> postalcode;?></td>
					<td class="break-word"><?php echo $disp[$i] -> country;?></td>
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
			?>
			</ul>
		</tbody>
</table>
<?php
// SELECT COUNTRY FROM THE DATABASE
$sel_country = $wpdb -> get_var('SELECT name  FROM ' . $wpdb -> prefix . sm_cuntry . ' where used = 1');
//SELECT THE DEFAULT COUNTRY FROM THE DATABASE
$country = $wpdb->get_col
(
      $wpdb->prepare
      (
           	"SELECT name FROM ".$wpdb->prefix."sm_cuntry where deflt = %d ORDER BY name ASC",
           	 1
      )
);
		
for ($i = 0; $i < count($country); $i++)
{
		if ($sel_country == $country[$i])
		{
		?>
				<option value="<?php echo $country[$i];?>" selected='selected'><?php echo $country[$i];?></option>
<?php 	}
		else
		{
		?>
				<option value="<?php echo $country[$i];?>"><?php echo $country[$i];?></option>
<?php 	}
}
?>		
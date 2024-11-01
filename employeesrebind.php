<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' ); 
global $wpdb;
?>
 <table class="activity_datatable" width="100%" border="0" cellspacing="0" cellpadding="8">
	<tbody>
		<tr>
			<th width="10%"> Emp. Code </th>
			<th width="14%"> Color Code </th>
			<th width="20%"> Employee Name </th>
			<th width="20%"> Email </th>
			<th width="15%"> Phone </th>
			<th width="10%"> Status </th>
			<th width="11%"> Action </th>
		</tr>
		<?php
		$emp = $wpdb->get_results
		(
			$wpdb->prepare
			(
				  "SELECT * FROM ".$wpdb->prefix."sm_employees "
			)
		);	

		for ($i = 0; $i < count($emp); $i++) 
		{
			$idd = $emp[$i]->id;
			$code = $emp[$i]->emp_code;
			$color = $emp[$i]->emp_color;
			$name = $emp[$i]->emp_name;
			$email = $emp[$i]->email;
			$phon = $emp[$i]->phone;
			$status = $emp[$i]->status;
				?>
				<tr class="tyu">
					<td><label id="empcod_<?php echo $i;?>" style="cursor:default; " value=""><?php echo $code;?></label></td>
					<td style="background-color:<?php echo $color;?>">
					<input type="hidden" id="empcolor_<?php echo $i;?>" style="cursor:default; " value="<?php echo $color;?>">
					</input></td>
					<td><label id="empnam_<?php echo $i;?>" style="cursor:default; " value=""><?php echo $name;?></label></td>
					<td><label id="empemail_<?php echo $i;?>" style="cursor:default; " value=""><?php echo $email;?></label></td>
					<td><label id="empphone_<?php echo $i;?>" style="cursor:default; " value=""><?php echo $phon;?></label></td>
					<td>
					<input type="hidden" id="empid_<?php echo $i;?>" style="cursor:default; " value="<?php echo $idd;?>"/>
					<?php
					if ($status == "Active") {
					?>
					<label id="empsts_<?php echo $i;?>" style="color:Green;cursor:cursor; "><?php echo $status;?></label><?php }
						else if($status == "In Active")
						{
					?>
					<label id="empsts_<?php echo $i;?>" style="color:red;cursor:cursor;"><?php echo $status;?></label><?php }?></td>
					
					<td><span class="data_actions iconsweet"> <a class="tip_north fancybox" original-title="Edit" id="<?php echo $i;?>" href="#Editemployee" onclick="get_edit_emp(this)"   style="cursor:pointer;">C</a> <a class="tip_north" original-title="Delete" id='<?php echo $idd;?>'  href="javascript: delete_employee('<?php echo $idd;?>')"  style="cursor:pointer;">X</a> </span></td>
				
				</tr>
				<?php
		}
		?>
	</tbody>
</table>
<option value="0">Select Employee</option>
<?php
		$emp = $wpdb->get_results
		(
			$wpdb->prepare
			(
				  "SELECT * FROM ".$wpdb->prefix."sm_employees where status = %s order by emp_name ASC",
				  "Active"
			)
		);

	$srv="";
	for( $i = 0; $i < count($emp); $i++)
	{
		if ($i==0)
		{
			$emp_d=$emp[$i]->id;
		}
		?>
		<option value ="<?php echo $emp[$i] -> id;?>"><?php echo $emp[$i] -> emp_name;?></option>
		<?php
	}
?>							
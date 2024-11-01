<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
// JOIN SERVICE TABLE AND ALLOACTE TABLE AND FETCH DATA FROM THEM
$empname = $wpdb->get_results
(
      $wpdb->prepare
      (
            'SELECT * FROM '.$wpdb->prefix.'sm_services LEFT OUTER JOIN  ' . $wpdb -> prefix . 'sm_allocate_serv ON  ' . $wpdb -> prefix . 'sm_services.id =  ' . $wpdb -> prefix . 'sm_allocate_serv.serv_id LEFT OUTER JOIN ' . $wpdb -> prefix . 'sm_employees ON  ' . $wpdb -> prefix . 'sm_employees.id = ' . $wpdb -> prefix . 'sm_allocate_serv.emp_id ORDER BY ' . $wpdb -> prefix . 'sm_services.rank ASC'
      )
);
//SELECT SERVICE NAME FROM SERCVICE TABLE 
$service_name = $wpdb->get_col
(
      $wpdb->prepare
      (
           	"SELECT name FROM ".$wpdb->prefix."sm_services ORDER BY rank ASC"
      )
);
// SELECT THE SERVICE HOUR OF THE SERVICE
$service_hours = $wpdb->get_col
(
      $wpdb->prepare
      (
           	'SELECT ' . $wpdb -> prefix . 'sm_services_time.hours FROM '.$wpdb->prefix.'sm_services_time join ' . $wpdb -> prefix . 'sm_services on ' . $wpdb -> prefix . 'sm_services_time.service_id = ' . $wpdb -> prefix . 'sm_services.id  ORDER BY ' . $wpdb -> prefix . 'sm_services.rank ASC'
      )
);
// SELECT THE SERVICE MINUTE OF THE SERVICE
$service_minutes = $wpdb->get_col
(
      $wpdb->prepare
      (
           	'SELECT ' . $wpdb -> prefix . 'sm_services_time.minutes FROM '.$wpdb->prefix.'sm_services_time join ' . $wpdb -> prefix . 'sm_services on ' . $wpdb -> prefix . 'sm_services_time.service_id = ' . $wpdb -> prefix . 'sm_services.id  ORDER BY ' . $wpdb -> prefix . 'sm_services.rank ASC'
      )
);
// SELECT COST OF THE SERVICE FROM THE DATABASE
$service_cost = $wpdb->get_col
(
      $wpdb->prepare
      (
           	"SELECT cost FROM ".$wpdb->prefix."sm_services ORDER BY rank ASC"
      )
);
// SELECT THE SERVICE ID FROM THE SERVICE TABLE 
$service_id = $wpdb->get_col
(
      $wpdb->prepare
      (
           	"SELECT id FROM ".$wpdb->prefix."sm_services ORDER BY rank ASC"
      )
);
// SELECT THE RANK OF THE SERVICES FROM THE DATABSE
$rank = $wpdb->get_col
(
      $wpdb->prepare
      (
           	"SELECT rank FROM ".$wpdb->prefix."sm_services ORDER BY rank ASC"
      )
);
//SELECT THE CURRENCY SYMBOL FROM THE DATABASE
$sercurrency = $wpdb -> get_var('SELECT currency_sign FROM ' . $wpdb -> prefix . sm_currency . ' where ' . $wpdb -> prefix . sm_currency . '.currency_used = 1');
?>

<table class="activity_datatable" width="100%" border="0" cellspacing="0" cellpadding="8">
	<tbody>
		<tr>
			<th width="15%"> Display Order </th>
			<th width="15%"> Service Name </th>
			<th width="15%"> Service ShortCode </th>
			<th width="15%"> Employee Name </th>
			<th width="15%"> Service Time </th>
			<th width="15%"> Service Cost </th>
			<?php if(!isset($_REQUEST['bindempwiz']) && !isset($_REQUEST['param12']))
			{
			?>
			<th width="10%"> Action </th>
			<?php }?>
		</tr>
		<?php
for ($i = 0; $i < count($service_id); $i++) {
$num = 0;
// SELECT THE EMPLOYEE NAME FROM THE EMPLOYEE TABLE AFTER JOINING THE ALLOCATE TABLE
$emp_nam = $wpdb->get_results
(
      $wpdb->prepare
      (
            'SELECT ' . $wpdb->prefix . 'sm_employees.emp_name FROM ' . $wpdb->prefix . 'sm_employees JOIN  ' . $wpdb -> prefix . 'sm_allocate_serv ON  ' . $wpdb -> prefix . 'sm_employees.id =  ' . $wpdb -> prefix . 'sm_allocate_serv.emp_id where ' . $wpdb->prefix . 'sm_allocate_serv.serv_id = %d',
            $service_id[$i]
      )
);	
?>
		<tr>
			<td>
				<ul class="form_fields_container" style="text-align: center">
				<li style="background: none">
					<div class="form_input">
						<input style="width: 50px" title="<?php echo $service_id[$i];?>" type="text" id="rank_id_<?php echo $i;?>" name="rank_id_<?php echo $i;?>" value="<?php echo $rank[$i] ?>" />
					</div>
				</li>
				</ul></td>
			<td>
			<input type="hidden" id="lblservicenam_<?php echo $i;?>" value="<?php echo $service_name[$i];?>">
			</input><?php echo $service_name[$i];?></td>
			<td>[booking service=<?php echo $service_id[$i];?>]
			<input type="hidden" value="<?php echo $service_id[$i];?>" id="inpserid_<?php echo $i;?>">
			</input></td>
			<td><?php
			for ($h = 0; $h < count($emp_nam); $h++) {
				$cunt = count($emp_nam) - 1;
				echo $emp_nam[$h] -> emp_name;
				if ($h != $cunt) {
					echo ",";
				}
			}
			?></td>
			<td>
			<div class="form_input">
				<?php if($service_hours[$i] ==0 && $service_minutes[$i]!=0)
{
				?>
				<label><?php echo $service_minutes[$i], "mins";?></label>
				<?php }
						else if($service_hours[$i] !=0 && $service_minutes[$i]!=0)
						{
				?>
				<label><?php echo $service_hours[$i], "hr", ",  ", $service_minutes[$i], "  mins";?></label>
				<?php }
						else
						{
				?>
				<label><?php echo $service_hours[$i], "hrs";?></label>
				<?php }?>
			</td>
			<td>
			<input type="hidden" id="sercostcurency_<?php echo $i;?>" value="<?php echo $sercurrency . "    " . $service_cost[$i];?>">
			</input><?php echo $sercurrency . "    " . $service_cost[$i];?></td>
			<?php if(!isset($_REQUEST['bindempwiz']))
			{
			?>
			<td><span class="data_actions iconsweet"> <a class="tip_north fancybox" original-title="Edit" id="<?php echo $i;?>" href="#modaleditService"   data-toggle="modal" name="<?php echo $i;?>" onClick="get_edit_div(<?php echo $i;?>)" style="cursor:pointer;">C</a> <a class="tip_north" original-title="Delete" id='<?php echo $service_id[$i];?>'  href="javascript: delete_service('<?php echo $service_id[$i] ?>')" style="cursor:pointer;">X</a> </span></td>
			<?php }?>
		</tr>
		<?php $num++;
			}
		?>
	</tbody>
</table>

<option value="0">Select Service</option>
<?php
		//SELECT ALL THE SERVICES FROM THE SERVICE TABLE
		$serv = $wpdb->get_results
		(
    		  $wpdb->prepare
     		 (
          		  'SELECT * FROM '.$wpdb->prefix.'sm_services '
            
		     )
		);
		
		$srv="";
		for( $i = 0; $i < count($serv); $i++)
		{
				if ($i==0)
				{
						$serv_n=$serv[$i]->id;
				}
				?>
<option value ="<?php echo $serv[$i] -> id; ?>"><?php echo $serv[$i] -> name; ?></option>
<?php
		}
?>
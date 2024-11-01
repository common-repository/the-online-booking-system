<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
if (isset($_REQUEST['data'])) 
{
	//DELETE THE CURRENCY ID FROM THE DATABASE
	$dat = intval($_REQUEST['data']);
	$wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpdb->prefix."sm_currency WHERE id = %d;", $dat ));
}
// SELECT CURRENCY FROM THE CURRENCY TABLE 
$currency1 = $wpdb->get_col
 (
      $wpdb->prepare
        (
           	"SELECT currency FROM ".$wpdb->prefix."sm_currency order by currency ASC"
        )
 );
 // SELECT CURRENCY SIGN FROM THE CURRENCY TABLE 
 $currency_sign = $wpdb->get_col
 (
      $wpdb->prepare
        (
           	"SELECT currency_sign FROM ".$wpdb->prefix."sm_currency order by currency ASC"
        )
 );		
 // SELECT CURRENCY ID FROM THE CURRENCY TABLE 
 $currency_id = $wpdb->get_col
 (
      $wpdb->prepare
        (
           	"SELECT id FROM ".$wpdb->prefix."sm_currency order by currency ASC"
        )
 );				
?>
<table class="activity_datatable" width="100%" border="0" cellspacing="0" cellpadding="8">
		<tr>
			<th width="10%">Sign</th>
			<th width="40%">Currency(s)</th>
			<th width="20%">Actions</th>
		</tr>
<?php
for ($i = 0; $i < count($currency1); $i++) 
{
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
<?php	
 // SELECT CURRENCY FROM THE CURRENCY TABLE 	
$currency = $wpdb->get_col
 (
     	$wpdb->prepare
       	(
        	  "SELECT currency FROM ".$wpdb->prefix."sm_currency order by currency ASC"
       	)
 );			
 // SELECT CURRENCY SIGN FROM THE CURRENCY TABLE 		
$currency_code = $wpdb->get_col
 (
     $wpdb->prepare
     (
        	"SELECT currency_sign FROM ".$wpdb->prefix."sm_currency order by currency ASC"
     )
 );	
 // SELECT COUNTRY SIGN FROM THE CURRENCY TABLE 		
$country = $wpdb->get_col
 (
     	$wpdb->prepare
       	(
        	   "SELECT name FROM ".$wpdb->prefix."sm_cuntry where deflt = %d order by name ASC",
        	   	1
       	 )
 );
 // SELECT CURRENCY SELECTED FROM THE CURRENCY TABLE 		
$currency_sel = $wpdb -> get_var('SELECT currency FROM ' . $wpdb -> prefix . sm_currency . ' where currency_used = 1');
 // SELECT COUNTRY FROM THE COUNTRY TABLE 	
$sel_country = $wpdb -> get_var('SELECT name  FROM ' . $wpdb -> prefix . sm_cuntry . ' where used = 1');

for ($i = 0; $i < count($currency); $i++)
{
	if ($currency[$i] == $currency_sel)
	{
		$cc = $currency_code[$i];?>
		<option value="<?php echo $currency[$i];?>" selected='selected'><?php echo "(" . $cc . ")  ";
		echo $currency[$i];?></option><?php 
	}
	else
	{
?>
		<option value="<?php echo $currency[$i];?>"><?php echo "(" . $currency_code[$i] . ")  ";
		echo $currency[$i];?></option><?php 
	}
}
?>
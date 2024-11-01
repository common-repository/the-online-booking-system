<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<?php
if(isset($_REQUEST['blockdelete']))
{
  // Requesting Variables and Sanitizing it.	
  $day = intval($_REQUEST['sday']);
  $month = intval($_REQUEST['cmonth']);
  $year= intval($_REQUEST['cyear']);
  $empid= intval($_REQUEST['empnam']);
  // This is to select id from the sm_block_date table for further use.
  $idbdd = $wpdb->get_var('SELECT id FROM ' . $wpdb->prefix . sm_block_date .' where month=' .'"'. $month .'"'. ' and day='.'"'.$day .'"'. ' and emp_id= ' .'"'. $empid.'"' .' and year= ' .'"'. $year.'"');
  
  // This is to delete the record from the sm_block_time table.
  $wpdb->query
  (
  		$wpdb->prepare
   		(
    		"DELETE FROM ".$wpdb->prefix."sm_block_time WHERE block_date_id = %d",
       		$idbdd
    	)
   );
  // This is to delete the record from the sm_block_date table.	
   $wpdb->query
   (
   		$wpdb->prepare
        (
        	"DELETE FROM ".$wpdb->prefix."sm_block_date WHERE id = %d",
          	$idbdd
        )
   );
 }
?>
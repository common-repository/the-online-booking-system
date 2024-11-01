<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<?php
if(isset($_REQUEST['whrclause']))
{
?>
 	<script type="text/javascript" src="<?php echo $url;?>js/jHtmlArea-0.7.5.js"></script>
    <link rel="Stylesheet" type="text/css" href="<?php echo $url;?>css/jHtmlArea.css" />
    <style type="text/css">
        /* body { background: #ccc;} */
        div.jHtmlArea .ToolBar ul li a.custom_disk_button 
        {
            background: url(images/disk.png) no-repeat;
            background-position: 0 0;
        }
        div.jHtmlArea { border: solid 1px #ccc; }
    </style>
    
    	<script type="text/javascript">
	    jQuery(function(){
            jQuery("textarea").htmlarea(); // Initialize jHtmlArea's with all default values
        });
   		 </script>
<?php 
		// select email content and subject from database and and pass it to textarea
		$table_name = $wpdb -> prefix . "sm_emails";
		$booktm_content = $wpdb -> get_var('SELECT content FROM ' . $table_name . ' WHERE type = ' . '"' . esc_attr($_REQUEST['whrclause']) . '"');
		$stored_subject = $wpdb -> get_var('SELECT subject FROM ' . $table_name . ' WHERE type = ' . '"' . esc_attr($_REQUEST['whrclause']) . '"');
?>
		<textarea id="elm1" name="elm1" rows="15" cols="23"  class="tinymce"><?php echo $booktm_content;?></textarea>
<?php
}
else if(isset($_REQUEST['updatetemplates']))
{
$table_name = $wpdb->prefix."sm_emails";
$typee = html_entity_decode($_REQUEST['updatetemplates']);
$content = html_entity_decode($_REQUEST['content']);
$subjct = html_entity_decode($_REQUEST['subjct']);
$qry = "UPDATE $table_name SET content = ". '"' . $content . '"' . ", subject = " . '"' . $subjct . '"' . " WHERE type = " .'"'. $typee.'"';
$wpdb->query($qry);
}
else if($_REQUEST['action'] == "subject")
{
		// select subject of the email template from the database
		$table_name = $wpdb -> prefix . "sm_emails";
		$stored_subject = $wpdb -> get_var('SELECT subject FROM ' . $table_name . ' WHERE type = ' . '"' . esc_attr($_REQUEST['type']) . '"');
		?>
		<input type="text" id="emailsubject" value="<?php echo $stored_subject; ?>" />
		<?php
}
?>
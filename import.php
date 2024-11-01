<?php
// Test CVS
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-load.php' );
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
global $final;
$url = site_url(); 

function ExcelToCSv($filename)
{
	require_once 'Excel/reader.php';
	// ExcelFile($filename, $encoding);
	$excel = new Spreadsheet_Excel_Reader();
	// Set output Encoding.
	$excel->setOutputEncoding('CP1251');
	$excel->read($filename);
	$x=1;
    $sep = ",";
    ob_start();
    while($x<=$excel->sheets[0]['numRows']) 
    {
    	$y=1;
   		$row="";
   		while($y<=$excel->sheets[0]['numCols']) 
   		{
        	 $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
         	$row.=($row=="")?"\"".$cell."\"":"".$sep."\"".$cell."\"";
         	$y++;
     	} 
     	echo $row."\n"; 
    	 $x++;
    }
	$random_digit2=rand(000,999999);
    $fp = fopen("uploads/". $random_digit2 . ".csv" ,'w');
    fwrite($fp,ob_get_contents());
    fclose($fp);
    ob_end_clean();
	$result = readAndDump("uploads/". $random_digit2 . ".csv",2);
 	return $result;
}
function readAndDump($file_path,$start_row=2)
{
	$errorMsg = "";
	if(empty($file_path))
	{
            $errorMsg .= "<br />Input file is not specified";
            return $errorMsg;
    }
	$file_handle = fopen($file_path, "r");
	if ($file_handle === FALSE)
	{
		// File could not be opened...
		$errorMsg .= 'Source file could not be opened!<br />';
		$errorMsg .= "Error on fopen('$file_path')";	// Catch any fopen() problems.
		return $errorMsg;
	}
	global $wpdb;
	$id = $wpdb->get_col
	(
     	 $wpdb->prepare
      	 (
         	  	"SELECT id FROM ".$wpdb->prefix."sm_clients"
      	  )
	);
	
	$emaill = $wpdb->get_col
	(
     	 $wpdb->prepare
      	 (
         	  	"SELECT email FROM ".$wpdb->prefix."sm_clients"
      	  )
	);
	
	$mobileee = $wpdb->get_col
	(
     	 $wpdb->prepare
      	 (
         	  	"SELECT mobile FROM ".$wpdb->prefix."sm_clients"
      	  )
	);
	
    $count = $wpdb->get_var('SELECT count(id) FROM ' . $wpdb->prefix . sm_clients);
	$row = 1; 
	$content = '<table border="1" cellpadding="5" cellspacing="0" style=" font-size:13px;" > 
	  <tr bgcolor="#ffcc99">
		<th style="width:150px; font-size:13px;">First Name</th>
		<th style="width:150px; font-size:13px;">Last Name</th>
		<th style="width:150px;">Email</th>
		<th style="width:150px;" >Mobile</th>
		<th style="width:150px;" >Telephone</th>
		<th style="width:150px;">AddressLine1</th>
		<th style="width:150px;">AddressLine2</th>	   
	    <th style="width:150px;">City</th>	
		<th style="width:150px;">Country</th>
		<th style="width:150px;">Postcode</th>		
	    <th style="width:150px;">Comments</th>
	</tr>';
	while (!feof($file_handle)) 
	{
		$line_of_text = fgetcsv($file_handle, 1024);
		if ($row < $start_row)
		{
		
			$row++;
			continue;
		}
		$columns = 12;
	        	for($c=1;$c<=$columns;$c++)
	        	{
				
					if($c==1)
					{
			         $name = $wpdb->escape($line_of_text[0]).",";
				    }
					if($c==2)
					{
			         $lastname = $wpdb->escape($line_of_text[1]).",";
				    }
					if($c==3)
					{
			         $email = $wpdb->escape($line_of_text[2]).",";
				    }
					if($c==4)
					{
			         $mobile = $wpdb->escape($line_of_text[3]).",";
				    }
					if($c==5)
					{
			         $telephone = $wpdb->escape($line_of_text[4]).",";
				    }
					if($c==6)
					{
			         $add1 = $wpdb->escape($line_of_text[5]).",";
				    }
					if($c==7)
					{
			         $add2 = $wpdb->escape($line_of_text[6]).",";
				    }
					if($c==8)
					{
			         $city = $wpdb->escape($line_of_text[7]).",";
				    }
					if($c==9)
					{
			         $country = $wpdb->escape($line_of_text[8]).",";
				    }
					
					if($c==10)
					{
			         $postalcode = $wpdb->escape($line_of_text[9]).",";
				    }
						
						if($c==11)
					{
			         $comment = $wpdb->escape($line_of_text[10]).",";
				    }
	        	 }
								
			 	 $nam=  split(",",$name);	
		      	 $eml=  split(",",$email);	
              	 $tel=  split(",",$telephone);	
		      	 $ad1=  split(",",$add1);	
             	 $ad2=  split(",",$add2);
              	 $cty=  split(",",$city);	
              	 $postcode=  split(",",$postalcode);	
              	 $cnty=  split(",",$country);				  
	          	 $cmt=  split(",",$comment);	
              	 $lstnam=  split(",",$lastname);				  
	          	 $mob=  split(",",$mobile);				  
			  	 $emailll=$eml[0];            			 
				 $type=false;	
			 
	        	for($i=1;$i<=$count;$i++)
		    	{	
             		if($emailll=="" )
			  		{	
						if($mob[0]!="")
						{			  
			  				if($mob[0]==$mobileee[$i])
							{			  
								$type=TRUE;
								break;                                  
							}
						}
			  		}
	       	  		else if($emailll== $emaill[$i])
			  		{					  
			   			 $type=TRUE;
		    			 break;                                  
		      		}
			   
	        	}
			
				if($type==false )
			 	{	
					if($nam[0]!="" || $lstnam[0]!="")
					{	 
							$today = date("Y-n-j"); 
							$content.='<tr><td style="width:100px;font-size:13px;">';
							$content.= $nam[0] . '&nbsp; </td><td style="width:150px;font-size:13px;">';
							$content.= $lstnam[0] . '&nbsp; </td><td style="width:150px;font-size:13px;">';
							$content.= $eml[0] . '&nbsp; </td><td style="width:150px;font-size:13px;">';
							$content.= $mob[0] . '&nbsp; </td><td style="width:150px;font-size:13px;">';
							$content.= $tel[0] . '&nbsp; </td><td style="width:150px;font-size:13px;">';
							$content.= $ad1[0] . '&nbsp; </td><td style="width:150px;font-size:13px;">';
							$content.= $ad2[0] . '&nbsp; </td><td style="width:150px;font-size:13px;">';
							$content.= $cty[0] . '&nbsp; </td><td style="width:150px;font-size:13px;">';
							$content.= $cnty[0] . '&nbsp; </td><td style="width:150px;font-size:13px;">';
							$content.= $postcode[0] . '&nbsp; </td><td style="width:150px;font-size:13px;">';
							
							$wpdb->query
		                    (
		                        $wpdb->prepare
		                        (
		                            "INSERT INTO ".$wpdb->prefix."sm_clients (name,lastname,email,mobile,telephone,addressLine1,addressLine2,city,country,postalcode) VALUES( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
		                            $nam[0],
		                            $lstnam[0],
		                            $eml[0],
		                            $mob[0],
		                            $tel[0],
		                            $ad1[0],
		                            $ad2[0],
		                            $cty[0],
		                            $cnty[0],
		                            $postcode[0]
		                        )
		                    );
							
							
							if(empty($results))
							{
								$errorMsg .= "<br />Insert into the Database failed for the following Query:<br />";
								$errorMsg .= $query;
								
							} 
					}
	        }
		$row++;
	}
$content.='</tr></table>';
fclose($file_handle);
return $content;
}

if (isset($_POST['btnimport'])) 
{
	$btn=$_POST['btnimport'];
	if($btn == "Upload File")
	{
   		$target_path = "uploads/" . $_FILES['uploadedfile']['name'];		

		//echo $target_path;
		//echo "<br />Target Path: ".$target_path;
		echo '<div id="message" class="updated fade"><p><strong>';
		if ($_FILES["uploadedfile"]["error"] > 0)
		{
		 	echo "There was an error uploading the file, please try again!";
		}
		else
		{
			if(copy($_FILES['uploadedfile']['tmp_name'], $target_path . ""))
			{
		  		 // echo "The file ".  basename( $_FILES['uploadedfile']['name'])." has been uploaded";
		    	 $final = ExcelToCSv($target_path);
		   		 
				 $form = '<body>
				<div class="popupbg">
				<h2 class="popup_title "><label for="title">Upload Excel/CSV for Importing Contacts</label></h2>
				<hr />
	
				<p>
				
				<a href="'.$url.'uploads/ps.xls">Click here</a> to download a sample CSV file, use this format when importing your own members below.
				</p>
				<p>
				Please MAKE SURE your file is in the same format as provided above. <br />
				There is no error checking in this beta import.
				</p>
        
       			<br />

				<form enctype="multipart/form-data" action="' .  $_SERVER["REQUEST_URI"] .'" method="POST">
				<input type="hidden" name="file_upload" id="file_upload" value="true" />

				<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
				<div class="choose_file">
				Choose Your CSV File: <input name="uploadedfile" type="file" style="margin-left:10px; width:200px; " /><br /><br />
				</div>
				<input type="submit" class="uploads" name="btnimport" id="btnimport" value="Upload File"  />

				</form>
				<div style="margin-top:30px">'. $final .'</div>
				</div></body></html>';
				echo "<script type='text/javascript'> window.location = '$url/wp-admin/admin.php?page=TabCustomers';</script>";
			} 
		
		}
                echo '</strong></p></div>';
    exit;
	}
}
?>
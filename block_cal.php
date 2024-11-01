<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-load.php' );
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' );
global $wpdb;
$url = plugins_url('', __FILE__) . "/"; 
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<script>

filepath =uri+"/blockcal.php";
filepath2 =uri+"/blockdatedelete.php";
var dat = new Date();
var today=dat.getDate();
var month = dat.getMonth() +1;
var year =  dat.getFullYear();
day = today;

jQuery("#prev_monthhh").click(function() 
{
	jQuery("#blktimecontrols").css('display','none');
	month = month-1;
	if(month<1)
	{
		month=12;
		year=year-1;
	}
	switch (month)
	{
		case 1:
		alpha_month = "Jan";
		break;
		case 2:
		alpha_month = "Feb";
		break;
		case 3:
		alpha_month = "Mar";
		break;
		case 4:
		alpha_month = "Apr";
		break;
		case 5:
		alpha_month = "May";
		break;
		case 6:
		alpha_month = "Jun";
		break;
		case 7:
		alpha_month = "Jul";
		break;
		case 8:
		alpha_month = "Aug";
		break;
		case 9:
		alpha_month = "Sep";
		break;
		case 10:
		alpha_month = "Oct";
		break;
		case 11:
		alpha_month = "Nov";
		break;
		case 12:
		alpha_month = "Dec";
		break;
	}		
	jQuery("#cur_calll").html(alpha_month+" - "+year);
	var sda = document.getElementById('empid').value;
	jQuery.ajax({
			type: "POST",
			data: "cmonth="+month+"&cyear="+year+"&empnam="+sda,
			url: filepath,
			success: function(data) 
			{
				jQuery("#displayed_cal").html(data);
			}
		  });
		return;
});

jQuery("#next_monthhh").click(function() 
{
	jQuery("#blktimecontrols").css('display','none');
	month = month+1;
	if(month>12)
	{
		month=1;
		year=year+1;
	}
	switch (month)
	{
		case 1:
		alpha_month = "Jan";
		break;
		case 2:
		alpha_month = "Feb";
		break;
		case 3:
		alpha_month = "Mar";
		break;
		case 4:
		alpha_month = "Apr";
		break;
		case 5:
		alpha_month = "May";
		break;
		case 6:
		alpha_month = "Jun";
		break;
		case 7:
		alpha_month = "Jul";
		break;
		case 8:
		alpha_month = "Aug";
		break;
		case 9:
		alpha_month = "Sep";
		break;
		case 10:
		alpha_month = "Oct";
		break;
		case 11:
		alpha_month = "Nov";
		break;
		case 12:
		alpha_month = "Dec";
		break;
	}
	jQuery("#cur_calll").html(alpha_month+" - "+year);
	day = jQuery(this).html();
	var sda = document.getElementById('empid').value;
	jQuery.ajax({
				type: "POST",
				data: "cmonth="+month+"&cyear="+year+"&empnam="+sda,
				url: filepath,
				success: function(data) 
				{
					jQuery("#displayed_cal").html(data);
				}
		   });
			return;
});
function BlockDay(e)
{
	
	day = jQuery(e).html();
	var curday=e.id;
	var sda = document.getElementById('empid').value;
	var dat = new Date();
	var today=dat.getDate();
	var valepid=sda.trim();
	if(valepid!=0)
	{
		if(!document.getElementById('blokday'))
		{
			var divcnt=document.getElementById('displayed_cal');
			var blokday=document.createElement('input');
			blokday.type='hidden';
			blokday.value=day;
			blokday.setAttribute('id','blokday');
			divcnt.appendChild(blokday);
		}
		else
		{
			document.getElementById('blokday').value=day;
		}
		jQuery.ajax({
				type: "POST",
				data: "cmonth="+month+"&cyear="+year+"&cday="+day+"&empnam="+sda+"&emp_idd="+sda,
				url: uri+"/blocktim.php",
				success: function(data)
				{
					var blktime=data.trim();		
					if(blktime=="daytimeblock")
					{
						jQuery("#blktimecontrols").css('display','none');
						var monthhh = dat.getMonth() +1;
						if((monthhh==month && day>=today) || month>monthhh)
						{
							var r=confirm("Are you sure you want to delete this Block date?");
							if(r==true)
							{
							jQuery.ajax
								({
									type: "POST",
									data: "cmonth="+month+"&cyear="+year+"&sday="+day+"&empnam="+sda+"&blockdelete=true",
									url: uri+"/blockdatedelete.php",
									success: function(data)
									{
										
										var stcoll=document.getElementById('day_tdidblk_'+day);
										if(document.getElementById('day_tdidblk_'+day))
										{
											stcoll.setAttribute('style','background-color:white;cursor:default;border-bottom:1px solid #999;border-right:1px solid #999;');
										}
										if(document.getElementById('day_number_block_'+day))
										{
											var stcollll=document.getElementById('day_number_block_'+day);
											stcollll.setAttribute('style','color: black !important;');
										}
								}
							});
						}
					}
				}
				else
				{
					var mnt= jQuery("#cur_calll").html();
					var montver= mnt.split("-");
					var mntsp=montver[0].trim();
					switch (mntsp)
					{
						case "Jan":
						alpha_mnt = 1;
						break;
						case "Feb":
						alpha_mnt =2;
						break;
						case "Mar":
						alpha_mnt =3;
						break;
						case "Apr":
						alpha_mnt =4;
						break;
						case "May":
						alpha_mnt =5;
						break;
						case "Jun":
						alpha_mnt = 6;
						break;
						case "Jul":
						alpha_mnt = 7;
						break;
						case "Aug":
						alpha_mnt = 8;
						break;
						case "Sep":
						alpha_mnt = 9;
						break;
						case "Oct":
						alpha_mnt = 10;
						break;
						case "Nov":
						alpha_mnt = 11;
						break;
						case "Dec":
						alpha_mnt = 12;
						break;
					}
					var monthhh = dat.getMonth() +1;
					if((alpha_mnt==monthhh && day>=today) || alpha_mnt>monthhh)
					{
						jQuery("#blktimecontrols").html(data);
						var obj8 = document.getElementById('blktimecontrols');
						obj8.style.display = 'block';
						var dcou="";
						if(alpha_mnt>monthhh)
						{
							dcou=1;
						}
						else
						{
							dcou=today;
						}
						for(j = dcou; j <= 31; j++)
						{
							if(j==day)
							{
								var stcol=document.getElementById('day_tdid_'+day);
								if(stcol!=null)
								{
									stcol.setAttribute('style','background-color:#f90;cursor:default;border-bottom:1px solid #999;border-right:1px solid #999;');
								}
							}
							else
							{
								var stcoll=document.getElementById('day_tdid_'+j);
								if(stcoll!=null)
								{
									stcoll.setAttribute('style','background-color:white;cursor:default;border-bottom:1px solid #999;border-right:1px solid #999;');
								}
							}
						}
					}
				}
			}
		});
		return;
	}
}
</script>
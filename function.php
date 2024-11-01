<?php
require_once(dirname(dirname(dirname( dirname( __FILE__ ) ))) . '/wp-config.php' ); ?>
?>
<script>var uri = "<?php echo plugins_url('', __FILE__);?>" </script>
<script>
function Onclick(e)
{	
		var value = e;
		jQuery('#Editcustomer').remove();
		jQuery('#exportPage').empty();
		jQuery('#exportPage').fadeOut("fast").load(uri+"/index.php?page="+ value).fadeIn(1000);	
}
</script>
<?php
function pagination($total, $per_page = 10,$page = 1,$url="?")
{        
		$adjacents = "2"; 
    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination form_fields_container'>";
            $pagination .= "<li class='details'>Page $page of $lastpage</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
					{
    					$pagination.= "<li><a class='current'>$counter</a></li>";
					}
    				else
					{
    					$pagination.= "<li><a href='#' onclick='Onclick($counter);'>$counter</a></li>";	
					}				
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='#' onclick='Onclick($counter);'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='#' onclick='Onclick($lpm1);'>$lpm1</a></li>";
    				$pagination.= "<li><a href='#' onclick='Onclick($lastpage);'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='#' onclick='Onclick(1);'>1</a></li>";
    				$pagination.= "<li><a href='#' onclick='Onclick(2);'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='#' onclick='Onclick($counter);'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='#' onclick='Onclick($lpm1);'>$lpm1</a></li>";
    				$pagination.= "<li><a href='#' onclick='Onclick($lastpage);'>$lastpage</a></li>";	
    			}
    			else
    			{
    				$pagination.= "<li><a href='#' onclick='Onclick(1);'>1</a></li>";
    				$pagination.= "<li><a href='#' onclick='Onclick(2);'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='#' onclick='Onclick($counter);'>$counter</a></li>";						
    				}
    			}
    		}
    		
    		if ($page < $counter - 1)
    		{ 
    			$pagination.= "<li><a href='#' onclick='Onclick($next);'>Next</a></li>";
                $pagination.= "<li><a href='#' onclick='Onclick($lastpage);'>Last</a></li>";
    		}
    		else
    		{
    			$pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    	return $pagination;
} 
?>    
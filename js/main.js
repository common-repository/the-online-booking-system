// JavaScript Document		
jQuery(document).ready(function() {


//===== SORTABLE LIBRARY QUICKSAND =====//
	
		  // get the action filter option item on page load
	  var $filterType = jQuery('.filter_project li.selected a').attr('class');
		
	  // get and assign the ourHolder element to the
		// $holder varible for use later
	  var $holder = jQuery('ul.project_list');
	
	  // clone all items within the pre-assigned $holder element
	  var $data = $holder.clone();
	
	  // attempt to call Quicksand when a filter option
		// item is clicked
		jQuery('.filter_project li a').click(function(e) {
			// reset the active class on all the buttons
			jQuery('.filter_project li').removeClass('selected');		
			// assign the class of the clicked filter option
			// element to our $filterType variable
			var $filterType = jQuery(this).attr('class');
			jQuery(this).parent().addClass('selected');
			
			if ($filterType == 'all') {
				// assign all li items to the $filteredData var when
				// the 'All' filter option is clicked
				var $filteredData = $data.find('li');
			} 
			else {
				// find all li elements that have our required $filterType
				// values for the data-type element
				var $filteredData = $data.find('li[data-type=' + $filterType + ']');
			}
			
			// call quicksand and assign transition parameters
			$holder.quicksand($filteredData, {duration: 800, easing: 'easeInOutQuad'}, function(){
				initTip();
		
			});
			
			return false;
		});
		
			initTip();
			
		
	
//===== MESSAGES =====//
			//Alert
		jQuery("div.msgbar").click(function(){
			jQuery(this).slideUp();
		});
		
	
//===== FORM ELEMENTS =====//
		jQuery("select, input:checkbox, input:radio").uniform(); 
	
			

//===== CODE HIGHLIGHTER =====//
			jQuery('pre.code').highlight({source:1, zebra:1, indent:'space', list:'ol'});
			


//===== TOOLTIP =====//
	function initTip()
	{
		jQuery('.tip_north').tipsy({gravity: 's'});
		jQuery('.tip_south').tipsy({gravity: 'n'});
		jQuery('.tip_east').tipsy({gravity: 'e'});
		jQuery('.tip_west').tipsy({gravity: 'w'});
	}

});
	
	
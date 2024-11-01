    (function() 
	{  
        tinymce.create('tinymce.plugins.quote', 
		{  
            init : function(ed, url) 
			{  
                ed.addButton('quote', 
				{  
                    title : 'Booking Link',  
                    image : url+'/1346740883_config-date.png',  
                    onclick : function() 
					{  
                         ed.selection.setContent('[booking link color=orange size=30px padding=5px]BOOK NOW[/booking link]');  
      
                    }  
                });  
            },  
            createControl : function(n, cm) 
			{  
                return null;  
            },  
        });  
        tinymce.PluginManager.add('quote', tinymce.plugins.quote);  
    })();  
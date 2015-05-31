cj(document).ready(function(){
	
		cj(".action-link.section.register_link-section.register_link-bottom").click(function(event){
				ga('send', 'event', 'Register', 'click');
		});
		
		cj(".action-link.section.register_link-section.register_link-top").click(function(event){
				ga('send', 'event', 'Register', 'click');
		});

		cj("div[class^='price-set-row']").click(function(event)
		{
			var id = event.target.id;
			if(cj("#"+ id).is(':checked'))
			{
				var eventString = "Selected " + cj("#"+id).attr('data-amount') + " " + cj("#"+id).attr('data-currency');
				ga('send', 'event', eventString, 'click');	
			}	
		});

});    


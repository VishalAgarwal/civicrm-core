function ecommerce()
{
	var trnxId = CRM.vars.WebTracking.trnx_id;
	var totalAmount = CRM.vars.WebTracking.totalAmount;
	alert(trnxId);
	alert(totalAmount);

	ga('require', 'ecommerce');
	ga('ecommerce:addItem', {
		'id': trnxId,                     // Transaction ID. Required.
		'name': 'Test',    			  	  // Product name. Required
		'price': totalAmount
				});
	ga('ecommerce:send');
}

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


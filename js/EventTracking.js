function ecommerce()
{
	var trnxId = CRM.vars.WebTracking.trnx_id;
	var totalAmount = CRM.vars.WebTracking.totalAmount;
	var source = CRM.vars.WebTracking.utm_source;

	ga('require', 'ecommerce');
	ga('ecommerce:addTransaction', {
  		'id': trnxId,                     // Transaction ID. Required.
  		'affiliation': source,   		  // Affiliation or store name.
  		'revenue': totalAmount,           // Grand Total.
  		'shipping': '0',                  // Shipping.
  		'tax': '0'                     	  // Tax.
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

function confirm()
{
	cj(document).ready(function(){
		cj(".crm-submit-buttons").click(function(event){
			ga('send', 'event', 'Confirm Register', 'click');
		});
	});	
}


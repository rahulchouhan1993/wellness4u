var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#cancel_order')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var invoice = $('hdninvoice').val();
			jQuery.ajax({
				url: 'ajax/cancel_order.php',
				type: "POST",
				data:formData,
				processData: false,
				contentType: false,
				//beforeSend: function(){ $("#logBtn").val('Connecting...');},
				success: function(result)
				{
					//alert(result);
					var JSONObject = JSON.parse(result);
					var rslt=JSONObject[0]['status'];
					
					if(rslt==1)
					{    
						window.location.href="view_order.php?invoice="+invoice; 
					}
					else
					{
						//alert(error);
						BootstrapDialog.show({
							title: 'Error' +" "+" "+'Response',
							message:JSONObject[0]['msg']
						}); 
					}      
				}
			});
		}
	});
	
	$("#cancel_order").validate({
		rules: {
			order_status      : "required",
			payment_status    : "required"
			
		},
		messages: {
			order_status        : "Please select order status",
			payment_status      : "Please select payment status"
		}
	});
}();
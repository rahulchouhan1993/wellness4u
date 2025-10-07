var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#edit_order')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			jQuery.ajax({
				url: 'ajax/edit_order.php',
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
						window.location.href="manage_orders.php"; 
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
	
	$("#edit_order").validate({
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
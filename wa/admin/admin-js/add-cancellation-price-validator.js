var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_cancellation_price')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			jQuery.ajax({
				url: 'ajax/add_cancellation_price.php',
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
						window.location.href="manage_cancellation_prices.php"; 
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
	
	$("#add_cancellation_price").validate({
		rules: {
			cp_title 			: "required",
			cp_type 			: "required",
			cp_min_hrs 			: "required",
			cp_max_hrs 			: "required",
			cp_applied_on		: "required",
			cp_effective_date	: "required"
			
		},
		messages: {
			cp_title   			: "Please enter title",
			cp_type   			: "Please select cancellation type",
			cp_min_hrs   		: "Please select min cancellation hrs",
			cp_max_hrs   		: "Please select max cancellation hrs",
			cp_applied_on		: "Please select option",
			cp_effective_date	: "Please enter effective date"
		}
	});
}();
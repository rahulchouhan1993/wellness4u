var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_discount_coupon')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var country_id_str = $('#country_id').val();
			if(country_id_str == null)
			{
				//country_id_str = '-1';
			}
			formData.append("country_id_str", country_id_str);
			
			var state_id_str = $('#state_id').val();
			if(state_id_str == null)
			{
				//state_id_str = '-1';
			}
			formData.append("state_id_str", state_id_str);
			
			var city_id_str = $('#city_id').val();
			if(city_id_str == null)
			{
				//city_id_str = '-1';
			}
			formData.append("city_id_str", city_id_str);
			
			var area_id_str = $('#area_id').val();
			if(area_id_str == null)
			{
				//area_id_str = '-1';
			}
			formData.append("area_id_str", area_id_str);
			
			var dc_effective_days_of_month_str = $('#dc_effective_days_of_month').val();
			if(dc_effective_days_of_month_str == null)
			{
				//dc_effective_days_of_month_str = '-1';
			}
			formData.append("dc_effective_days_of_month_str", dc_effective_days_of_month_str);
			
			var dc_effective_days_of_week_str = $('#dc_effective_days_of_week').val();
			if(dc_effective_days_of_week_str == null)
			{
				//dc_effective_days_of_week_str = '-1';
			}
			formData.append("dc_effective_days_of_week_str", dc_effective_days_of_week_str);
			
			jQuery.ajax({
				url: 'ajax/add_discount_coupon.php',
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
						window.location.href="manage_discount_coupons.php"; 
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
	
	$("#add_discount_coupon").validate({
		rules: {
			discount_coupon : "required",
			dc_type : "required",
			dc_applied_on : "required",
			dc_effective_date_type   : "required"
			
		},
		messages: {
			discount_coupon   : "Please enter discount coupon",
			dc_type   : "Please select discount type",
			dc_applied_on   : "Please select option",
			dc_effective_date_type   : "Please select effective date type"
		}
	});
}();
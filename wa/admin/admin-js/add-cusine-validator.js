var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_cusine')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var file_data = $("#cusine_image").prop("files")[0]; 
			formData.append("cusine_image", file_data);
			
			/*
			var vloc_id_str = $('#vloc_id').val();
			if(vloc_id_str == null)
			{
				//vloc_id_str = '-1';
			}
			formData.append("vloc_id_str", vloc_id_str);
			*/
			
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
			
			var publish_days_of_month_str = $('#publish_days_of_month').val();
			if(publish_days_of_month_str == null)
			{
				//publish_days_of_month_str = '-1';
			}
			formData.append("publish_days_of_month_str", publish_days_of_month_str);
			
			var publish_days_of_week_str = $('#publish_days_of_week').val();
			if(publish_days_of_week_str == null)
			{
				//publish_days_of_week_str = '-1';
			}
			formData.append("publish_days_of_week_str", publish_days_of_week_str);
			
			var delivery_days_of_month_str = $('#delivery_days_of_month').val();
			if(delivery_days_of_month_str == null)
			{
				//delivery_days_of_month_str = '-1';
			}
			formData.append("delivery_days_of_month_str", delivery_days_of_month_str);
			
			var delivery_days_of_week_str = $('#delivery_days_of_week').val();
			if(delivery_days_of_week_str == null)
			{
				//delivery_days_of_week_str = '-1';
			}
			formData.append("delivery_days_of_week_str", delivery_days_of_week_str);
			
			jQuery.ajax({
				url: 'ajax/add_cusine.php',
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
						window.location.href="manage_cusines.php"; 
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
	
	$("#add_cusine").validate({
		rules: {
			item_id         	: "required",
			cusine_type_id      : "required",
			vendor_id       	: "required",
			vendor_show       	: "required",
			publish_date_type   : "required",
			delivery_date_type 	: "required",
			order_cutoff_time 	: "required"
		},
		messages: {
			item_id         	: "Please select item",
			cusine_type_id      : "Please select menu presentation",
			vendor_id       	: "Please select vendor",
			vendor_show       	: "Please select show vendor details",
			publish_date_type   : "Please select publish date type",
			delivery_date_type  : "Please select delivery date type",
			order_cutoff_time   : "Please select oredr cutoff time(hrs)"
		}
	});
}();
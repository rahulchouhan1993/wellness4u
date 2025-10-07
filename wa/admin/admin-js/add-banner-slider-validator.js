var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_banner_slider')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var file_data = $("#banner_image").prop("files")[0]; 
			formData.append("banner_image", file_data);
			
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
			
			jQuery.ajax({
				url: 'ajax/add_banner_slider.php',
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
						window.location.href="manage_banner_sliders.php"; 
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
	
	$("#add_banner_slider").validate({
		rules: {
			banner_title      : "required",
			banner_order      : "required",
			publish_date_type : "required"
			
		},
		messages: {
			banner_title        : "Please enter banner title",
			banner_order	    : "Please enter banner order",
			publish_date_type   : "Please select publish date type"
		}
	});
}();
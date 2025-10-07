var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_tax')[0]);
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
			
			jQuery.ajax({
				url: 'ajax/add_tax.php',
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
						window.location.href="manage_taxes.php"; 
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
	
	$("#add_tax").validate({
		rules: {
			tax_name   : "required",
			tax_cat_id   : "required",
			tax_type : "required",
			tax_applied_on : "required",
			tax_effective_date : "required"
			
		},
		messages: {
			tax_name     : "Please enter tax name",
			tax_cat_id   : "Please select tax category",
			tax_type   : "Please select tax type",
			tax_applied_on   : "Please select option",
			tax_effective_date   : "Please enter effective date"
		}
	});
}();
var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_city')[0]);
			formData.append("btnSubmit",'btnSubmit');
			 
			jQuery.ajax({
				url: 'ajax/add_city.php',
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
						window.location.href="manage_cities.php"; 
					}
					else
					{
						BootstrapDialog.show({
							title: 'Error' +" "+" "+'Response',
							message:JSONObject[0]['msg']
						}); 
					}      
				}
			});
		}
	});
	
	$("#add_city").validate({
		rules: {
			country_id : "required",
			state_id : "required",
			city_name : "required",
		},
		messages: {
			country_id:"Please select Country",
			state_id:"Please select State",
			city_name:"Please enter City Name",
		}
	});
}();
var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_area')[0]);
			formData.append("btnSubmit",'btnSubmit');
			 
			jQuery.ajax({
				url: 'ajax/add_area.php',
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
						window.location.href="manage_area.php"; 
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
	
	$("#add_area").validate({
		rules: {
			country_id : "required",
			state_id : "required",
			city_id : "required",
			area_name : "required",
			area_pincode : "required",
		},
		messages: {
			country_id:"Please select Country",
			state_id:"Please select State",
			city_id:"Please select City",
			area_name:"Please enter Area Name",
			area_pincode:"Please enter Area Pincode",
		}
	});
}();
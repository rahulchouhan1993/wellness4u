var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#edit_user')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var btnSubmit = 1;
			
			jQuery.ajax({
				url: 'ajax/edit_user.php',
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
						window.location.href="manage_users.php"; 
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
	
	$("#edit_user").validate({
		rules: {
			first_name : "required",
			email : "required",
			mobile_no : "required",
			country_id : "required",
			state_id : "required",
			city_id : "required"
		},
		messages: {
			first_name:"Please enter first name",
			email:"Please enter email",
			mobile_no:"Please enter mobile no",
			country_id:"Please select country",
			state_id:"Please select state",
			city_id:"Please select city"
		}
	});
}();
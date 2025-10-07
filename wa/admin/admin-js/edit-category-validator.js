var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#edit_cat')[0]);
			formData.append("btnSubmit",'btnSubmit');
			 
			jQuery.ajax({
				url: 'ajax/edit_category.php',
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
						window.location.href="manage_profile_customization_category.php"; 
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
	
	$("#edit_cat").validate({
		rules: {
			cat_name : "required",
		},
		messages: {
			cat_name:"Please enter main profile",
		}
	});
}();
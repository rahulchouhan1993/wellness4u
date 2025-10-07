var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#edit_vendor_loc')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var btnSubmit = 1;
			
			jQuery.ajax({
				url: 'ajax/edit_location_contact_info.php',
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
					var refurl=JSONObject[0]['refurl'];
					
					if(rslt==1)
					{    
						window.location.href = refurl; 
					}
					else
					{
						//alert(error);
						BootstrapDialog.show({
							title: 'Error' +" "+" "+'Response',
							message:JSONObject[0]['msg']
						}); 
					}  
					// window.location.href="index.php";     
				}

			});
		}
	});
	
	$("#edit_vendor_loc").validate({
		rules: {
		},
		messages: {
		}
	});
}();
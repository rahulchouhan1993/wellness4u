var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_vendors_access_form')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			jQuery.ajax({
				url: 'ajax/add_vendors_access_form.php',
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
						window.location.href=JSONObject[0]['refurl']; 
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
	
	$("#add_vendors_access_form").validate({
		rules: {
			vafm_id : "required"
		},
		messages: {
			vafm_id : "Please select form"
		}
	});
}();
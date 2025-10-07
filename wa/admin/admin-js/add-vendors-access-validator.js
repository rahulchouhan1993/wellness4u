var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_vendors_access')[0]);
			formData.append("btn_submit",'btn_submit');
			 
			jQuery.ajax({
				url: 'ajax/add_vendors_access.php',
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
						window.location.href="manage_vendors_access.php"; 
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
	
	$("#add_vendors_access").validate({
		rules: {
			va_cat_id : "required",
			va_name : "required"
		},
		messages: {
			va_cat_id:"Please select category",
			va_name:"Please enter title"
		}
	});
}();
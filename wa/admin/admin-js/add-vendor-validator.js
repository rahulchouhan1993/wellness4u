var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_vendor')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var btnSubmit = 1;
				
			jQuery.ajax({
				url: 'ajax/add_vendor.php',
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
						window.location.href="manage_vendors.php"; 
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
	
	$("#add_vendor").validate({
		rules: {
			vendor_parent_cat_id : "required",
			vendor_cat_id : "required",
			vendor_name : "required",
			vendor_username : "required",
			vendor_password : "required"
		},
		messages: {
			vendor_parent_cat_id:"Please select main profile",
			vendor_cat_id:"Please select category",
			vendor_name:"Please enter company name",
			vendor_username:"Please enter vendor username",
			vendor_password:"Please enter vendor password",
		}
	});
}();
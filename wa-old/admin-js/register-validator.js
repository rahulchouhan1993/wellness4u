var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#register')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var btnSubmit = 1;
				
			jQuery.ajax({
				url: 'ajax/register.php',
				type: "POST",
				data:formData,
				processData: false,
				contentType: false,
				//beforeSend: function(){ $("#logBtn").val('Connecting...');},
				success: function(result)
				{
					alert(result);
					var JSONObject = JSON.parse(result);
					var rslt=JSONObject[0]['status'];
					var refurl=JSONObject[0]['refurl'];
					
					if(rslt==1)
					{    
						window.location.href = refurl; 
					}
					else
					{
//						alert(error);
alert('failure');
                    
						BootstrapDialog.show({
							title: 'Error' +" "+" "+'Response',
							message:JSONObject[0]['msg']
						}); 
					}      
				}
			});
		}
	});
	
	$("#register").validate({
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
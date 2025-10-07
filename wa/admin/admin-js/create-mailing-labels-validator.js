var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#create_mailing_labels')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			jQuery.ajax({
				url: 'ajax/create_mailing_labels.php',
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
						window.location.href=JSONObject[0]['refurl'];; 
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
	
	$("#create_mailing_labels").validate({
		rules: {
			ml_layout         	: "required"
		},
		messages: {
			ml_layout         	: "Please select layout"
		}
	});
}();
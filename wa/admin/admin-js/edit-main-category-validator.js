var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#edit_main_cat')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var file_data = $("#cat_image").prop("files")[0]; 
			formData.append("cat_image", file_data);
			 
			jQuery.ajax({
				url: 'ajax/edit_main_category.php',
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
						window.location.href="manage_main_category.php"; 
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
	
	$("#edit_main_cat").validate({
		rules: {
			cat_name : "required",
			parent_cat_id:"required"
		},
		messages: {
			cat_name:"Please enter category name",
			parent_cat_id:"Please select main profile"
		}
	});
}();
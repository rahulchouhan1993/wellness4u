var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#edit_page')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var page_contents = escape($('#page_contents').summernote('code'));
			formData.append("page_contents", page_contents);
			
			jQuery.ajax({
				url: 'ajax/edit_page.php',
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
						window.location.href="manage_pages.php"; 
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
	
	$("#edit_page").validate({
		rules: {
			page_name      : "required",
			page_title      : "required"
			
		},
		messages: {
			page_name        : "Please enter page name",
			page_title	    : "Please enter page heading"
		}
	});
}();
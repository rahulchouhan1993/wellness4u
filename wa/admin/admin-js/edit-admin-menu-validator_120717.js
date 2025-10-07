var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#edit_admin_menu')[0]);
			formData.append("btn_submit",'btn_submit');
			 
			jQuery.ajax({
				url: 'ajax/edit_admin_menu.php',
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
						window.location.href="manage_admin_menus.php"; 
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
	
	$("#edit_admin_menu").validate({
		rules: {
			am_title : "required",
			am_link : "required",
			am_order: {
				required: true,
				minlength: 1,
				number:true
			}
		},
		messages: {
			am_title:"Please enter menu title",
			am_link:"Please enter menu link",
			am_order:  "Please enter menu order"
		}
	});
}();
var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_admin_action')[0]);
			formData.append("btn_submit",'btn_submit');
			 
			jQuery.ajax({
				url: 'ajax/add_admin_action.php',
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
						var am_id = $("#am_id").val();
						window.location.href="manage_admin_actions.php?am_id="+am_id; 
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
	
	$("#add_admin_action").validate({
		rules: {
			aa_title : "required",
			aa_link : "required",
			aa_vendor_menu : "required"
			
		},
		messages: {
			aa_title:"Please enter action title",
			aa_link:"Please enter action page link",
			aa_vendor_menu:"Please select business associate panel option"
		}
	});
}();
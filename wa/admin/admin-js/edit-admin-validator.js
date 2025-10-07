var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#edit_admin')[0]);
			formData.append("btn_submit",'btn_submit');
			 
			jQuery.ajax({
				url: 'ajax/edit_admin.php',
				type: "POST",
				data:formData,
				processData: false,
				contentType: false,
				//beforeSend: function(){ $("#logBtn").val('Connecting...');},
				success: function(result)
				{
					var JSONObject = JSON.parse(result);
					var rslt=JSONObject[0]['status'];
					
					if(rslt==1)
					{    
						window.location.href="manage_admins.php"; 
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
	
	$("#edit_admin").validate({
		rules: {
			username : "required",
			email: {
				required: true,
				email: true
			},
			fname : "required",
			lname : "required",
			contact_no: {
				required: true,
				minlength: 10,
				number:true
			}
		},
		messages: {
			username:"Please enter username",
			email:  "Please enter valid email",
			fname:  "Please enter valid first name",
			fname:  "Please enter valid last name",
			contact_no:"Please enter valid contact number"
		}
	});
}();
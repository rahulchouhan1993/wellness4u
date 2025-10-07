var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#edit_order_delivery')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var file_data = $("#proof_of_delivery").prop("files")[0]; 
			formData.append("proof_of_delivery", file_data);
			
			var favorite = [];
			var chkbox_records_str = "";
			$.each($("input[name='chkbox_records[]']:checked"), function(){            
				favorite.push($(this).val());
			});
			chkbox_records_str = favorite.join(",");
			formData.append("chkbox_records_str", chkbox_records_str);
			
			jQuery.ajax({
				url: 'ajax/edit_order_delivery.php',
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
						window.location.href="manage_order_delivery.php"; 
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
	
	$("#edit_order_delivery").validate({
		rules: {
			invoice   : "required",
			delivery_date : "required",
			logistic_partner_type_cat_id : "required",
			delivery_status : "required",
			delivery_person_name : "required"
			
		},
		messages: {
			invoice     : "Please select invoice",
			delivery_date   : "Please select delivery date",
			logistic_partner_type_cat_id   : "Please select logistic partner type",
			delivery_status   : "Please select delivery status",
			delivery_person_name   : "Please enter delivery person name"
		}
	});
}();
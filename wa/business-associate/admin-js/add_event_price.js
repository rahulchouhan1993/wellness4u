var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_event')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var publish_days_of_month_str = $('#publish_days_of_month').val();
			if(publish_days_of_month_str == null)
			{
				//publish_days_of_month_str = '-1';
			}
			formData.append("publish_days_of_month_str", publish_days_of_month_str);
			
			var publish_days_of_week_str = $('#publish_days_of_week').val();
			if(publish_days_of_week_str == null)
			{
				//publish_days_of_week_str = '-1';
			}
			formData.append("publish_days_of_week_str", publish_days_of_week_str);
			
			$('.image_load').show();
			jQuery.ajax({
				url: 'ajax/add_event_price.php',
				type: "POST",
				data:formData,
				processData: false,
				contentType: false,
				//beforeSend: function(){ $("#logBtn").val('Connecting...');},
				success: function(result)
				{
					//alert(result);
                    $('.image_load').hide();                   
                    $("#show_data").html(result);            
					var JSONObject = JSON.parse(result);
					var rslt=JSONObject[0]['status'];
					
					if(rslt==1)
					{    
						window.location.href="manage-event-price.php"; 
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
	
	$("#add_event").validate({
		rules: {
			
		},
		messages: {
			
		}
	});
}();
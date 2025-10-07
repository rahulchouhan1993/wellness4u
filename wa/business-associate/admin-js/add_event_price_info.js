var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_event')[0]);
			formData.append("btnSubmit",'btnSubmit');
			

			$('.image_load').show();
			jQuery.ajax({
				url: 'ajax/add_event_price_detail.php',
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
					var refurl=JSONObject[0]['refurl'];
					if(rslt==1)
					{    
						window.location.href=refurl; 
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
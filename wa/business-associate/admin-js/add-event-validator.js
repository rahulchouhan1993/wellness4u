var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_event')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
            var event_contents = escape($('#event_contents').summernote('code'));
			formData.append("event_contents", event_contents);
                 // alert('hi');       
			var btnSubmit = 1;
		$('.image_load').show();
			jQuery.ajax({
				url: 'ajax/add_event.php',
				type: "POST",
				data:formData,
				processData: false,
				contentType: false,
				//beforeSend: function(){ $("#logBtn").val('Connecting...');},
				success: function(result)
				{
					//alert(result);
                                        //return false;
                    $('.image_load').hide();                   
                    $("#error_msg").html(result);
					var JSONObject = JSON.parse(result);
					var rslt=JSONObject[0]['status'];
					
                                        
                                        
					if(rslt==1)
					{    
						window.location.href="manage_event.php"; 
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
			organiser_id : "required"
		},
		messages: {
		organiser_id:"Please select organiser profile"	
		}
	});
}();
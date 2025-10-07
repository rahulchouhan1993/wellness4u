var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_event')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
                        var event_contents = escape($('#event_contents').summernote('code'));
			formData.append("event_contents", event_contents);
                        
			var btnSubmit = 1;
				
			jQuery.ajax({
				url: 'ajax/edit_events.php',
				type: "POST",
				data:formData,
				processData: false,
				contentType: false,
				//beforeSend: function(){ $("#logBtn").val('Connecting...');},
				success: function(result)
				{
					//alert(result);
                                        //return false;
                                        //$("#datashow").html(result);
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
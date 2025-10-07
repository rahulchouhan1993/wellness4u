var Script = function () {
	$.validator.setDefaults({
		submitHandler: function() 
		{ 
			var formData = new FormData($('#add_items')[0]);
			formData.append("btnSubmit",'btnSubmit');
			
			var item_name = $('#item_name').val();
			var item_code = $('#item_code').val();
			
			
			var cat_id1 = $('#cat_id1').val();
			var cat_id2 = $('#cat_id2').val();
			var cat_id3 = $('#cat_id3').val();
			var cat_id4 = $('#cat_id4').val();
			var cat_id5 = $('#cat_id5').val();
		
			var parent_cat = cat_id1;
			
			if(cat_id2 != '')
			{
				parent_cat = parent_cat+','+cat_id2;
			}		
			
			if(cat_id3 != '')
			{
				parent_cat = parent_cat+','+cat_id3;
			}	
			
			if(cat_id4 != '')
			{
				parent_cat = parent_cat+','+cat_id4;
			}	
			
			if(cat_id5 != '')
			{
				parent_cat = parent_cat+','+cat_id5;
			}	
			
			var sub_cat1 = $('#sub_cat1').val();
			var sub_cat2 = $('#sub_cat2').val();
			var sub_cat3 = $('#sub_cat3').val();
			var sub_cat4 = $('#sub_cat4').val();
			var sub_cat5 = $('#sub_cat5').val();
			
			var cat_id = sub_cat1;
			
			if(sub_cat2 != '')
			{
				cat_id = cat_id+','+sub_cat2;
			}	
			
			if(sub_cat3 != '')
			{
				cat_id = cat_id+','+sub_cat3;
			}	
			
			if(sub_cat4 != '')
			{
				cat_id = cat_id+','+sub_cat4;
			}	
			
			if(cat_id5 != '')
			{
				cat_id = cat_id+','+sub_cat5;
			}	
			
			var cat_show1 = $('#cat_show1').val();
			var cat_show2 = $('#cat_show2').val();
			var cat_show3 = $('#cat_show3').val();
			var cat_show4 = $('#cat_show4').val();
			var cat_show5 = $('#cat_show5').val();
			
			var show = cat_show1+','+cat_show2+','+cat_show3+','+cat_show4+','+cat_show5;
			
			var item_disc1 = $('#item_disc_1').val();
			
			var item_disc2 = $('#item_disc_2').val();
			
			var item_disc_show1 = $('#item_disc_show1').val();
			
			var item_disc_show2 = $('#item_disc_show2').val();
			
			var ingredient_type = $('#ingredient_type').val();

			var ingredient_id = $('#ingredient_id').val();
			
			var ingredient_show = $('#ingredient_show').val();
			
			var btnSubmit = 1;
				
			jQuery.ajax({
				url: 'ajax/add_items.php',
				type: "POST",
				data:'item_name='+item_name+'&item_code='+item_code+'&parent_cat='+parent_cat+'&cat_id='+cat_id+'&show='+show+'&item_disc1='+item_disc1+'&item_disc2='+item_disc2+'&item_disc_show1='+item_disc_show1+'&item_disc_show2='+item_disc_show2+'&ingredient_type='+ingredient_type+'&ingredient_id='+ingredient_id+'&ingredient_show='+ingredient_show+'&btnSubmit='+btnSubmit,
				
				cache: false,     
				//beforeSend: function(){ $("#logBtn").val('Connecting...');},
				success: function(result)
				{
					//alert(result);
					var JSONObject = JSON.parse(result);
					var rslt=JSONObject[0]['status'];
					
					if(rslt==1)
					{    
						window.location.href="manage_items.php"; 
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
	
	$("#add_items").validate({
		rules: {
			item_name : "required",
			cat_id1 : "required",
			sub_cat1 : "required",
		},
		messages: {
			item_name:"Please enter item name",
			cat_id1:"Please select item type main category",
			sub_cat1:"Please select item type sub category1",
		}
	});
}();
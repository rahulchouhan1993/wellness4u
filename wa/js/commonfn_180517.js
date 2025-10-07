function setTopLocation()
{
	var select_your_city = $('#select_your_city').val();
	var select_your_area = $('#select_your_area').val();
	if(select_your_city == '' || select_your_city == null || select_your_city == 'undefiled')
	{
		alert('Please enter your location');
	}
	else
	{
		if(select_your_area == '' || select_your_area == null || select_your_area == 'undefiled')
		{
			select_your_area = '';
		}
		$('#hdntopcityid').val(select_your_city);
		$('#hdntopareaid').val(select_your_area);
		
		//alert(select_your_area);
		
		var dataString ='topcityid='+select_your_city+'&topareaid='+select_your_area+'&action=settoplocation';
		$.ajax({
			type: "POST",
			url: "remote.php",
			data: dataString,
			cache: false,
			success: function(result)
			{
				var arr_result = result.split('::::');
				if(arr_result[1] == '1')
				{
					alert(arr_result[2])
				}
				else
				{
					//alert(result);
					//window.location.reload(true);
					window.location.href = arr_result[3];
				}
			}
		});
	}
}

function getTopAreaOption()
{
	//alert('1111');
	var select_your_city = $('#select_your_city').val();
	var select_your_area = $('#select_your_area').val();
	
	
	if(select_your_city == null)
	{
		select_your_city = '';
	}
	
	if(select_your_area == null)
	{
		area_id = '';
	}
	
	var dataString ='topcityid='+select_your_city+'&topareaid='+select_your_area+'&action=gettopareaoption';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,      
		success: function(result)
		{
			//alert(result);
			
			if(select_your_city == '')
			{
				$('#select_your_area').tokenize2().trigger('tokenize:clear');
			}
			
			$("#select_your_area").html(result);
		}
	});
}

function setCurrentShowingDate(dateval)
{
	var dataString = 'action=setcurrentshowingdate&date='+dateval;
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			window.location.reload(true);
		}
	});
}

function openCartPopup()
{
	$(".overlay-box").show();
	$("#side-cart-box").show(0).animate({'right': 0},500);	
	
	$('#overlay-box').on('click', function() {
		closeCartPopup();
	});
}

function closeCartPopup()
{
	$("#side-cart-box").show(0).animate({'right': -320},500);	
	$(".overlay-box").hide();
}	

function getSideCartBox()
{
	var dataString = 'action=getsidecartbox';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			var arr_result = result.split('::::');
			$("#side-cart-box").html(arr_result[1]);
			startComplementrySlider();
			openCartPopup();
		}
	});
}

function getSideCartBoxCheckout()
{
	var dataString = 'action=getsidecartboxcheckout';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			var arr_result = result.split('::::');
			$("#checkout-cart-box").html(arr_result[1]);
			//openCartPopup();
		}
	});
}

function addToCart(cusine_id,qty)
{
	var dataString = 'action=addtocart&cusine_id='+cusine_id+'&qty='+qty;
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			var arr_result = result.split('::::');
			if(arr_result[1] == '1')
			{
				alert(arr_result[2])
			}
			else
			{
				getSideCartBox();
			}
		}
	});
}

function removeFromCart(cart_id)
{
	var dataString = 'action=removefromcart&cart_id='+cart_id;
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			var arr_result = result.split('::::');
			if(arr_result[1] == '1')
			{
				alert(arr_result[2])
			}
			else
			{
				getSideCartBox();
			}
		}
	});
}

function removeFromCartCheckout(cart_id)
{
	var dataString = 'action=removefromcart&cart_id='+cart_id;
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			var arr_result = result.split('::::');
			if(arr_result[1] == '1')
			{
				alert(arr_result[2])
			}
			else
			{
				getSideCartBoxCheckout();
			}
		}
	});
}

function updateCartSingleItem(idval)
{
	var cusine_id = $('#hdncartcusine_id_'+idval).val();
	var qty = $('#cart_qty_'+idval).val();
	
	var dataString = 'action=updatecartsingleitem&cusine_id='+cusine_id+'&qty='+qty;
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			var arr_result = result.split('::::');
			if(arr_result[1] == '1')
			{
				alert(arr_result[2])
			}
			else
			{
				getSideCartBox();
			}
		}
	});
}

function updateCartSingleItemCheckout(idval)
{
	var cusine_id = $('#hdncartcusine_id_'+idval).val();
	var qty = $('#cart_qty_'+idval).val();
	
	var dataString = 'action=updatecartsingleitem&cusine_id='+cusine_id+'&qty='+qty;
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			var arr_result = result.split('::::');
			if(arr_result[1] == '1')
			{
				alert(arr_result[2])
			}
			else
			{
				getSideCartBoxCheckout();
			}
		}
	});
}



function doCheckoutSignUp()
{
	var signup_first_name = $('#signup_first_name').val();
	var signup_last_name = $('#signup_last_name').val();
	var signup_email = $('#signup_email').val();
	var signup_mobile_no = $('#signup_mobile_no').val();
	var signup_password = $('#signup_password').val();
	
	var error = false;
	
	if(signup_first_name == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter first name.</p>');
		error = true;
	}
	else if(signup_last_name == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter last name.</p>');
		error = true;
	}
	else if(signup_email == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter email.</p>');
		error = true;
	}
	else if(signup_mobile_no == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter mobile number.</p>');
		error = true;
	}
	else if(signup_password == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter password.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=docheckoutsignup&signup_first_name='+escape(signup_first_name)+'&signup_last_name='+escape(signup_last_name)+'&signup_email='+escape(signup_email)+'&signup_mobile_no='+escape(signup_mobile_no)+'&signup_password='+escape(signup_password);
		$.ajax({
			type: "POST",
			url: "remote.php",
			data: dataString,
			cache: false,
			success: function(result)
			{
				//alert(result);
				var arr_result = result.split('::::');
				if(arr_result[1] == '1')
				{
					$('#err_msg_signup').html('<p class="err_msg">'+arr_result[2]+'</p>');
				}
				else
				{
					$('#err_msg_signup').html('');
					//operateAccordion(1);
					window.location.reload(true);
				}
			}
		});	
	}
}

function doEditProfile()
{
	var signup_first_name = $('#signup_first_name').val();
	var signup_last_name = $('#signup_last_name').val();
	var signup_email = $('#signup_email').val();
	var signup_mobile_no = $('#signup_mobile_no').val();
	
	var error = false;
	
	if(signup_first_name == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter first name.</p>');
		error = true;
	}
	else if(signup_last_name == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter last name.</p>');
		error = true;
	}
	else if(signup_email == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter email.</p>');
		error = true;
	}
	else if(signup_mobile_no == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter mobile number.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=doeditprofile&signup_first_name='+escape(signup_first_name)+'&signup_last_name='+escape(signup_last_name)+'&signup_mobile_no='+escape(signup_mobile_no);
		$.ajax({
			type: "POST",
			url: "remote.php",
			data: dataString,
			cache: false,
			success: function(result)
			{
				//alert(result);
				var arr_result = result.split('::::');
				if(arr_result[1] == '1')
				{
					$('#err_msg_signup').html('<p class="err_msg">'+arr_result[2]+'</p>');
				}
				else
				{
					$('#err_msg_signup').html('');
					//operateAccordion(1);
					window.location.href = arr_result[3];
				}
			}
		});	
	}
}

function doCheckoutSignUpGuest()
{
	var guest_name = $('#guest_name').val();
	var guest_email = $('#guest_email').val();
	var guest_mobile = $('#guest_mobile').val();
	
	var error = false;
	
	if(guest_name == '')
	{
		$('#err_msg_guest').html('<p class="err_msg">Please enter name.</p>');
		error = true;
	}
	else if(guest_email == '')
	{
		$('#err_msg_guest').html('<p class="err_msg">Please enter email.</p>');
		error = true;
	}
	else if(guest_mobile == '')
	{
		$('#err_msg_guest').html('<p class="err_msg">Please enter mobile number.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=docheckoutsignupguest&guest_name='+escape(guest_name)+'&guest_email='+escape(guest_email)+'&guest_mobile='+escape(guest_mobile);
		$.ajax({
			type: "POST",
			url: "remote.php",
			data: dataString,
			cache: false,
			success: function(result)
			{
				//alert(result);
				var arr_result = result.split('::::');
				if(arr_result[1] == '1')
				{
					$('#err_msg_guest').html('<p class="err_msg">'+arr_result[2]+'</p>');
				}
				else
				{
					$('#err_msg_guest').html('');
					//operateAccordion(1);
					window.location.reload(true);
				}
			}
		});	
	}
}

function doCheckoutLogIn()
{
	var email = $('#email').val();
	var password = $('#password').val();
	
	var error = false;
	
	if(email == '')
	{
		$('#err_msg_login').html('<p class="err_msg">Please enter email.</p>');
		error = true;
	}
	else if(password == '')
	{
		$('#err_msg_login').html('<p class="err_msg">Please enter password.</p>');
		error = true;
	}
	
	if(!error)
	{
		var ref_url = '';
		var dataString = 'action=docheckoutlogin&email='+escape(email)+'&password='+escape(password)+'&ref_url='+escape(ref_url);
		$.ajax({
			type: "POST",
			url: "remote.php",
			data: dataString,
			cache: false,
			success: function(result)
			{
				//alert(result);
				var arr_result = result.split('::::');
				if(arr_result[1] == '1')
				{
					$('#err_msg_login').html('<p class="err_msg">'+arr_result[2]+'</p>');
				}
				else
				{
					$('#err_msg_login').html('');
					//operateAccordion(1);
					window.location.reload(true);
				}
			}
		});	
	}
}

function doLogIn()
{
	var email = $('#email').val();
	var password = $('#password').val();
	var ref_url = $('#ref_url').val();
	
	var error = false;
	
	if(email == '')
	{
		$('#err_msg_login').html('<p class="err_msg">Please enter email.</p>');
		error = true;
	}
	else if(password == '')
	{
		$('#err_msg_login').html('<p class="err_msg">Please enter password.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=docheckoutlogin&email='+escape(email)+'&password='+escape(password)+'&ref_url='+escape(ref_url);
		$.ajax({
			type: "POST",
			url: "remote.php",
			data: dataString,
			cache: false,
			success: function(result)
			{
				//alert(result);
				var arr_result = result.split('::::');
				if(arr_result[1] == '1')
				{
					$('#err_msg_login').html('<p class="err_msg">'+arr_result[2]+'</p>');
				}
				else
				{
					$('#err_msg_login').html('');
					//operateAccordion(1);
					window.location.href=arr_result[3];
				}
			}
		});	
	}
}

function doCheckoutSaveDeliveryAddress()
{
	var delivery_building_name = $('#delivery_building_name').val();
	var delivery_floor_no = $('#delivery_floor_no').val();
	var delivery_address_line1 = $('#delivery_address_line1').val();
	var delivery_landmark = $('#delivery_landmark').val();
	var delivery_city_id = $('#hdndelivery_city_id').val();
	var delivery_area_id = $('#hdndelivery_area_id').val();
	var delivery_mobile_no = $('#delivery_mobile_no').val();
	var delivery_pincode = $('#delivery_pincode').val();
	
	var error = false;
	
	if(delivery_building_name == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter flat number/house number, building name.</p>');
		error = true;
	}
	else if(delivery_address_line1 == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter address line 1.</p>');
		error = true;
	}
	else if(delivery_city_id == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter location.</p>');
		error = true;
	}
	else if(delivery_mobile_no == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter mobile number.</p>');
		error = true;
	}
	else if(delivery_pincode == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter pincode.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=docheckoutsavedeliveryaddress&delivery_building_name='+escape(delivery_building_name)+'&delivery_floor_no='+escape(delivery_floor_no)+'&delivery_address_line1='+escape(delivery_address_line1)+'&delivery_landmark='+escape(delivery_landmark)+'&delivery_city_id='+escape(delivery_city_id)+'&delivery_area_id='+escape(delivery_area_id)+'&delivery_mobile_no='+escape(delivery_mobile_no)+'&delivery_pincode='+escape(delivery_pincode);
		$.ajax({
			type: "POST",
			url: "remote.php",
			data: dataString,
			cache: false,
			success: function(result)
			{
				//alert(result);
				var arr_result = result.split('::::');
				if(arr_result[1] == '1')
				{
					$('#err_msg_delivery').html('<p class="err_msg">'+arr_result[2]+'</p>');
				}
				else
				{
					$('#err_msg_delivery').html('');
					operateAccordion(2);
					//window.location.reload(true);
				}
			}
		});	
	}
}

function doCheckoutProceedToPayment()
{
	var dataString = 'action=docheckoutproceedtopayment';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			var arr_result = result.split('::::');
			if(arr_result[1] == '1')
			{
				$('#err_msg_payment').html('<p class="err_msg">'+arr_result[2]+'</p>');
			}
			else
			{
				$('#err_msg_payment').html('');
				//alert(arr_result[2]);
				//operateAccordion(2);
				window.location.href=arr_result[3];
			}
		}
	});
}

function startComplementrySlider()
{
	$('.my_silick_complementry').slick({
		  dots: false,
		  infinite: true,
		  centerPadding: '80px',
		  speed: 270,
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  autoplay: true,
		  autoplaySpeed: 2000,
		  prevArrow: '<div class="slick-prev-2"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
		  nextArrow: '<div class="slick-next-2"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
	});		
}	

startComplementrySlider();	

function goToCusineListPage(select_your_area,dateval,regionstr)
{
	var select_your_city = $('#select_your_city').val();
	//var select_your_area = $('#select_your_area').val();
	if(select_your_city == '' || select_your_city == null || select_your_city == 'undefiled')
	{
		alert('Please enter your location');
	}
	else
	{
		if(select_your_area == '' || select_your_area == null || select_your_area == 'undefiled')
		{
			select_your_area = '';
		}
		$('#hdntopcityid').val(select_your_city);
		$('#hdntopareaid').val(select_your_area);
		
		//alert(select_your_area);
		
		var dataString ='topcityid='+select_your_city+'&topareaid='+select_your_area+'&action=settoplocation';
		$.ajax({
			type: "POST",
			url: "remote.php",
			data: dataString,
			cache: false,
			success: function(result)
			{
				//alert(result);
				var arr_result = result.split('::::');
				if(arr_result[1] == '1')
				{
					alert(arr_result[2])
				}
				else
				{
					//alert(result);
					var dataString2 = 'action=setcurrentshowingdate&date='+dateval+'&regionstr='+regionstr;
					$.ajax({
						type: "POST",
						url: "remote.php",
						data: dataString2,
						cache: false,
						success: function(result2)
						{
							//alert(result2);	
							var arr_result2 = result2.split('::::');
							if(arr_result2[1] == '1')
							{
								alert(arr_result2[2])
							}
							else
							{
								window.location.href = arr_result2[3];
							}	
						}
					});
				}
			}
		});
	}
}

function doSearchForHomeListing()
{
	var select_your_city = $('#select_your_city').val();
	var select_your_area = $('#home_list_area_id').val();
	var home_list_region_id = $('#home_list_region_id').val();
	var home_list_item_id = $('#home_list_item_id').val();
	var home_list_date = $('#home_list_date').val();
	
	if(select_your_city == '' || select_your_city == null || select_your_city == 'undefiled')
	{
		alert('Please enter your location');
	}
	else
	{
		if(select_your_area == '' || select_your_area == null || select_your_area == 'undefiled')
		{
			select_your_area = '';
		}
		
		$('#hdntopcityid').val(select_your_city);
		//$('#hdntopareaid').val(select_your_area);
		
		
		if(home_list_region_id == '' || home_list_region_id == null || home_list_region_id == 'undefiled')
		{
			home_list_region_id = '';
		}
		
		if(home_list_item_id == '' || home_list_item_id == null || home_list_item_id == 'undefiled')
		{
			home_list_item_id = '';
		}
		
		if(home_list_date == '' || home_list_date == null || home_list_date == 'undefiled')
		{
			home_list_date = '';
		}
		
		var dataString ='topcityid='+select_your_city+'&topareaid='+select_your_area+'&home_list_region_id='+home_list_region_id+'&home_list_item_id='+home_list_item_id+'&home_list_date='+home_list_date+'&action=dosearchforhomelisting';
		$.ajax({
			type: "POST",
			url: "remote.php",
			data: dataString,
			cache: false,
			success: function(result)
			{
				//alert(result);
				var arr_result = result.split('::::');
				if(arr_result[1] == '1')
				{
					alert(arr_result[2])
				}
				else
				{
					window.location.href = arr_result[3];
				}
			}
		});
	}
}

function setHomeListAreaOptions()
{
	var home_list_date = $('#home_list_date').val();
	var home_list_area_id = $('#home_list_area_id').val();
	
	if(home_list_date == null)
	{
		home_list_date = '';
	}
	
	if(home_list_area_id == null)
	{
		home_list_area_id = '';
	}
	
	var dataString ='home_list_date='+home_list_date+'&home_list_area_id='+home_list_area_id+'&action=sethomelistareaoptions';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,      
		success: function(result)
		{
			$("#home_list_area_id").html(result);
			setHomeListRegionOptions();
		}
	});
}

function setHomeListRegionOptions()
{
	var home_list_date = $('#home_list_date').val();
	var home_list_area_id = $('#home_list_area_id').val();
	var home_list_region_id = $('#home_list_region_id').val();
	
	if(home_list_date == null)
	{
		home_list_date = '';
	}
	
	if(home_list_area_id == null)
	{
		home_list_area_id = '';
	}
	
	if(home_list_region_id == null)
	{
		home_list_region_id = '';
	}
		
	var dataString ='home_list_date='+home_list_date+'&home_list_area_id='+home_list_area_id+'&home_list_region_id='+home_list_region_id+'&action=sethomelistregionoptions';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,      
		success: function(result)
		{
			$("#home_list_region_id").html(result);
			setHomeListItemOptions();
		}
	});
}

function setHomeListItemOptions()
{
	var home_list_date = $('#home_list_date').val();
	var home_list_area_id = $('#home_list_area_id').val();
	var home_list_region_id = $('#home_list_region_id').val();
	var home_list_item_id = $('#home_list_item_id').val();
	
	
	if(home_list_date == null)
	{
		home_list_date = '';
	}
	
	if(home_list_area_id == null)
	{
		home_list_area_id = '';
	}
	
	if(home_list_region_id == null)
	{
		home_list_region_id = '';
	}
	
	if(home_list_item_id == null)
	{
		home_list_item_id = '';
	}
	
	var dataString ='home_list_date='+home_list_date+'&home_list_area_id='+home_list_area_id+'&home_list_region_id='+home_list_region_id+'&home_list_item_id='+home_list_item_id+'&action=sethomelistitemoptions';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,      
		success: function(result)
		{
			$("#home_list_item_id").html(result);
		}
	});
}

function openIngredientPopup(item_id)
{
	//alert(item_id);
	var dataString ='item_id='+item_id+'&action=openingredientpopup';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,      
		success: function(result)
		{
			$('#animatedModalIngredient').show();
			$('#modal_ingredient_content').html(result);
		}
	});
	
	
}
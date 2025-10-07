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

function setDeliveryLocation()
{
	var select_your_city = $('#select_your_city2').val();
	var select_your_area = $('#select_your_area2').val();
	if(select_your_city == '' || select_your_city == null || select_your_city == 'undefiled')
	{
		//alert('Please enter delivery city/town');
		$('#err_msg_deliverypopup').html('<p class="err_msg">Please enter delivery city/town</p>');
	}
	else if(select_your_area == '' || select_your_area == null || select_your_area == 'undefiled')
	{
		//alert('Please enter delivery area');
		$('#err_msg_deliverypopup').html('<p class="err_msg">Please enter delivery area</p>');
	}
	else
	{
		var dataString ='deliverycityid='+select_your_city+'&deliveryareaid='+select_your_area+'&action=setdeliverylocation';
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
					//alert(arr_result[2]);
					$('#err_msg_deliverypopup').html('<p class="err_msg">'+arr_result[2]+'</p>');
				}
				else
				{
					$('#hdndelivery_city_id').val(select_your_city);
					$('#hdndelivery_area_id').val(select_your_area);
					$('#delivery_location').val(arr_result[3]);
					$('#delivery_pincode').val(arr_result[4]);
					$('#err_msg_deliverypopup').html('');
					$( ".close-animatedModalLocation2" ).trigger( "click" );
				}
			}
		});
	}
}

function setBillingLocation()
{
	var select_your_city = $('#select_your_city4').val();
	var select_your_area = $('#select_your_area4').val();
	if(select_your_city == '' || select_your_city == null || select_your_city == 'undefiled')
	{
		//alert('Please enter billing city/town');
		$('#err_msg_billingpopup').html('<p class="err_msg">Please enter billing city/town</p>');
	}
	else if(select_your_area == '' || select_your_area == null || select_your_area == 'undefiled')
	{
		//alert('Please enter billing area');
		$('#err_msg_billingpopup').html('<p class="err_msg">Please enter billing area</p>');
	}
	else
	{
		var dataString ='deliverycityid='+select_your_city+'&deliveryareaid='+select_your_area+'&action=setbillinglocation';
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
					//alert(arr_result[2]);
					$('#err_msg_billingpopup').html('<p class="err_msg">'+arr_result[2]+'</p>');
				}
				else
				{
					$('#hdnbilling_city_id').val(select_your_city);
					$('#hdnbilling_area_id').val(select_your_area);
					$('#billing_location').val(arr_result[3]);
					$('#billing_pincode').val(arr_result[4]);
					$('#err_msg_billingpopup').html('');
					$( ".close-animatedModalLocation4" ).trigger( "click" );
				}
			}
		});	
	}
}

function setContactUsLocation()
{
	var contactus_city_id = $('#contactus_city_id').val();
	var contactus_area_id = $('#contactus_area_id').val();
        
	if(contactus_city_id == '' || contactus_city_id == null || contactus_city_id == 'undefiled')
	{
		$('#err_msg_contactuspopup').html('<p class="err_msg">Please enter your location</p>');
	}
	else
	{
		if(contactus_area_id == '' || contactus_area_id == null || contactus_area_id == 'undefiled')
		{
			contactus_area_id = '';
		}
		
		
		//alert(select_your_area);
		
		var dataString ='contactus_city_id='+contactus_city_id+'&contactus_area_id='+contactus_area_id+'&action=setcontactuslocation';
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
					$('#err_msg_contactuspopup').html('<p class="err_msg">'+arr_result[2]+'</p>');
				}
				else
				{
					$('#err_msg_contactuspopup').html('');
					$('#hdncontactus_city_id').val(contactus_city_id);
					$('#hdncontactus_area_id').val(contactus_area_id);
					$('#contactus_location').val(arr_result[3]);
					$( ".close-animatedModalLocation3" ).trigger( "click" );
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
		select_your_area = '';
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

function getDeliveryAreaOption()
{
	//alert('1111');
	var select_your_city = $('#select_your_city2').val();
	var select_your_area = $('#select_your_area2').val();
	
	
	if(select_your_city == null)
	{
		select_your_city = '';
	}
	
	if(select_your_area == null)
	{
		select_your_area = '';
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
				$('#select_your_area2').tokenize2().trigger('tokenize:clear');
			}
			
			$("#select_your_area2").html(result);
		}
	});
}

function getBillingAreaOption()
{
	//alert('1111');
	var select_your_city = $('#select_your_city4').val();
	var select_your_area = $('#select_your_area4').val();
	
	
	if(select_your_city == null)
	{
		select_your_city = '';
	}
	
	if(select_your_area == null)
	{
		select_your_area = '';
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
				$('#select_your_area4').tokenize2().trigger('tokenize:clear');
			}
			
			$("#select_your_area4").html(result);
		}
	});
}

function getContactUsAreaOption()
{
	//alert('1111');
	var contactus_city_id = $('#contactus_city_id').val();
	var contactus_area_id = $('#contactus_area_id').val();
	
	
	if(contactus_city_id == null)
	{
		contactus_city_id = '';
	}
	
	if(contactus_area_id == null)
	{
		contactus_area_id = '';
	}
	
	var dataString ='topcityid='+contactus_city_id+'&topareaid='+contactus_area_id+'&action=gettopareaoption';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,      
		success: function(result)
		{
			//alert(result);
			
			if(contactus_city_id == '')
			{
				$('#contactus_area_id').tokenize2().trigger('tokenize:clear');
			}
			
			$("#contactus_area_id").html(result);
                        $("#request_area_id").html(result);
		}
	});
}

function getRequestAreaOption()
{
	
	var request_city_id = $('#request_city_id').val();
	var request_area_id = $('#request_area_id').val();
	
	
	if(request_city_id == null)
	{
		request_city_id = '';
	}
	
	if(request_city_id == null)
	{
		request_city_id = '';
	}
	
	var dataString ='topcityid='+request_city_id+'&topareaid='+request_area_id+'&action=gettopareaoption';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,      
		success: function(result)
		{
			//alert(result);
			
			if(request_city_id == '')
			{
				$('#request_area_id').tokenize2().trigger('tokenize:clear');
			}
			
			$("#request_area_id").html(result);
                        
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

function setValueToCloneSlider(obj,cnt)
{
	//var val = $("option:selected", this).val();
	var val =  $(obj).find('option:selected').val();
	//alert(val);
	$('.cusine_area_'+cnt).val(val);
}

function addToCart(cusine_id,qty,cnt,cusine_delivery_date)
{
	//var cusine_area_id = $('#cusine_area_'+cnt).val();
	var cusine_area_id = $('.cusine_area_'+cnt).val();
	//var cusine_area_id = $('.cusine_area_'+cnt).filter(":selected").val();
	//alert(cusine_delivery_date);
	if(cusine_area_id == '' || cusine_area_id == 'null' || cusine_area_id == 'undefined')
		{
		console.log('.cusine_area_'+cnt+':'+cusine_area_id);
		alert('Please select area of item');
	}
	else
	{
		var dataString = 'action=addtocart&cusine_id='+cusine_id+'&qty='+qty+'&cusine_area_id='+cusine_area_id+'&cusine_delivery_date='+cusine_delivery_date;
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
	var delivery_date = $('#hdncartdelivery_date_'+idval).val();
	var qty = $('#cart_qty_'+idval).val();
	
	var dataString = 'action=updatecartsingleitem&cusine_id='+cusine_id+'&qty='+qty+'&delivery_date='+delivery_date;
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
	var delivery_date = $('#hdncartdelivery_date_'+idval).val();
	var qty = $('#cart_qty_'+idval).val();
	
	var dataString = 'action=updatecartsingleitem&cusine_id='+cusine_id+'&qty='+qty+'&delivery_date='+delivery_date;
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

function doApplyDiscountCoupon()
{
	var discount_coupon = $('#discount_coupon').val();
	if(discount_coupon == '')
	{
		alert('Please enter coupon');
	}
	else
	{
		var dataString = 'action=doapplydiscountcoupon&discount_coupon='+discount_coupon;
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
					//window.location.reload(true);
					$('#signup-box').hide();
					$('#verify-otp-box').show();
				}
			}
		});	
	}
}

function doVerifyOTP()
{
	var user_otp = $('#user_otp').val();
	var email = $('#signup_email').val();
	var mobile_no = $('#signup_mobile_no').val();
	
	var error = false;
	
	if(user_otp == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter otp.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=doverifyotp&user_otp='+escape(user_otp)+'&email='+escape(email)+'&mobile_no='+escape(mobile_no);
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

function doVerifyOTPGuest()
{
	var user_otp = $('#guest_otp').val();
	var email = $('#guest_email').val();
	var mobile_no = $('#guest_mobile').val();
	
	var error = false;
	
	if(user_otp == '')
	{
		$('#err_msg_guest').html('<p class="err_msg">Please enter otp.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=doverifyotp&user_otp='+escape(user_otp)+'&email='+escape(email)+'&mobile_no='+escape(mobile_no);
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
					$('#err_msg_signup').html('');
					//operateAccordion(1);
					window.location.reload(true);
				}
			}
		});	
	}
}

function doVerifyOTPForgotPassword()
{
	var user_otp = $('#user_otp').val();
	var mobile_no = $('#mobile_no').val();
	
	var error = false;
	
	if(user_otp == '')
	{
		$('#err_msg_login').html('<p class="err_msg">Please enter otp.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=doverifyotpforgotpassword&user_otp='+escape(user_otp)+'&mobile_no='+escape(mobile_no);
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
					$('#forgot-box').hide();
					$('#verify-otp-box').hide();
					$('#forgot-password-box').show();
				}
			}
		});	
	}
}

function resetNewPassword()
{
	var user_otp = $('#user_otp').val();
	var mobile_no = $('#mobile_no').val();
	var password = $('#password').val();
	var cpassword = $('#cpassword').val();
	
	var error = false;
	
	if(user_otp == '')
	{
		$('#err_msg_login').html('<p class="err_msg">Please enter otp.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=resetnewpassword&user_otp='+escape(user_otp)+'&mobile_no='+escape(mobile_no)+'&password='+escape(password)+'&cpassword='+escape(cpassword);
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
					window.location.href = arr_result[3];
				}
			}
		});	
	}
}

function reSendOTP()
{
	var mobile_no = $('#signup_mobile_no').val();
	
	var error = false;
	
	if(!error)
	{
		var dataString = 'action=resendotp&mobile_no='+escape(mobile_no);
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
					$('#err_msg_signup').html('<p class="err_msg">'+arr_result[2]+'</p>');
				}
			}
		});	
	}
}

function reSendOTPGuest()
{
	var mobile_no = $('#guest_mobile').val();
	
	var error = false;
	
	if(!error)
	{
		var dataString = 'action=resendotp&mobile_no='+escape(mobile_no);
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
					$('#err_msg_guest').html('<p class="err_msg">'+arr_result[2]+'</p>');
				}
			}
		});	
	}
}

function sendOTPForgotPassword()
{
	var mobile_no = $('#mobile_no').val();
	
	var error = false;
	
	if(mobile_no == '')
	{
		$('#err_msg_login').html('<p class="err_msg">Please mobile no.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=resendotp&mobile_no='+escape(mobile_no);
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
					//window.location.reload(true);
					$('#forgot-box').hide();
					$('#verify-otp-box').show();
				}
			}
		});	
	}
}

function reSendOTPForgorPassword()
{
	var mobile_no = $('#mobile_no').val();
	
	var error = false;
	
	if(!error)
	{
		var dataString = 'action=resendotp&mobile_no='+escape(mobile_no);
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
					$('#err_msg_login').html('<p class="err_msg">'+arr_result[2]+'</p>');
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

function doChangePassword()
{
	var opassword = $('#opassword').val();
	var npassword = $('#npassword').val();
	var cpassword = $('#cpassword').val();
	
	var error = false;
	
	if(opassword == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter current password.</p>');
		error = true;
	}
	else if(npassword == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter new password.</p>');
		error = true;
	}
	else if(cpassword == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please enter confirm password.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=dochangepassword&opassword='+escape(opassword)+'&npassword='+escape(npassword)+'&cpassword='+escape(cpassword);
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
					//window.location.reload(true);
					$('#guest-box').hide();
					$('#guest-verify-otp-box').show();
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
	var delivery_name = $('#delivery_name').val();
	var delivery_building_name = $('#delivery_building_name').val();
	var delivery_floor_no = $('#delivery_floor_no').val();
	var delivery_address_line1 = $('#delivery_address_line1').val();
	var delivery_landmark = $('#delivery_landmark').val();
	var delivery_city_id = $('#hdndelivery_city_id').val();
	var delivery_area_id = $('#hdndelivery_area_id').val();
	var delivery_mobile_no = $('#delivery_mobile_no').val();
	var delivery_pincode = $('#delivery_pincode').val();
	
	var billing_name = $('#billing_name').val();
	var billing_building_name = $('#billing_building_name').val();
	var billing_floor_no = $('#billing_floor_no').val();
	var billing_address_line1 = $('#billing_address_line1').val();
	var billing_landmark = $('#billing_landmark').val();
	var billing_city_id = $('#hdnbilling_city_id').val();
	var billing_area_id = $('#hdnbilling_area_id').val();
	var billing_mobile_no = $('#billing_mobile_no').val();
	var billing_pincode = $('#billing_pincode').val();
	
	var error = false;
	
	if(delivery_name == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter delivery name.</p>');
		error = true;
	}
	else if(delivery_building_name == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter flat number/house number, building name for delivery address.</p>');
		error = true;
	}
	else if(delivery_address_line1 == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter address line 1 for delivery address.</p>');
		error = true;
	}
	else if(delivery_city_id == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter delivery city/town	.</p>');
		error = true;
	}
	else if(delivery_area_id == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter delivery area.</p>');
		error = true;
	}
	else if(delivery_mobile_no == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter mobile number for delivery address.</p>');
		error = true;
	}
	else if(delivery_pincode == '')
	{
		//$('#err_msg_delivery').html('<p class="err_msg">Please enter pincode.</p>');
		//error = true;
	}
	else if(billing_name == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter billing name.</p>');
		error = true;
	}
	else if(billing_building_name == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter flat number/house number, building name for billing address.</p>');
		error = true;
	}
	else if(billing_address_line1 == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter address line 1 for billing address.</p>');
		error = true;
	}
	else if(billing_city_id == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter billing city/town.</p>');
		error = true;
	}
	else if(billing_area_id == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter billing area.</p>');
		error = true;
	}
	else if(billing_mobile_no == '')
	{
		$('#err_msg_delivery').html('<p class="err_msg">Please enter mobile number for billing address.</p>');
		error = true;
	}
	else if(billing_pincode == '')
	{
		//$('#err_msg_delivery').html('<p class="err_msg">Please enter pincode.</p>');
		//error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=docheckoutsavedeliveryaddress&delivery_name='+escape(delivery_name)+'&delivery_building_name='+escape(delivery_building_name)+'&delivery_floor_no='+escape(delivery_floor_no)+'&delivery_address_line1='+escape(delivery_address_line1)+'&delivery_landmark='+escape(delivery_landmark)+'&delivery_city_id='+escape(delivery_city_id)+'&delivery_area_id='+escape(delivery_area_id)+'&delivery_mobile_no='+escape(delivery_mobile_no)+'&delivery_pincode='+escape(delivery_pincode)+'&billing_name='+escape(billing_name)+'&billing_building_name='+escape(billing_building_name)+'&billing_floor_no='+escape(billing_floor_no)+'&billing_address_line1='+escape(billing_address_line1)+'&billing_landmark='+escape(billing_landmark)+'&billing_city_id='+escape(billing_city_id)+'&billing_area_id='+escape(billing_area_id)+'&billing_mobile_no='+escape(billing_mobile_no)+'&billing_pincode='+escape(billing_pincode);
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

function doSearchCusineExplore()
    {
    var select_your_city = $('#select_your_city').val();
    var home_region_speciality = $('#home_region_speciality').val();
    var home_dish_items = $('#home_dish_items').val();
	//alert(home_region_speciality+" "+home_dish_items);
	if(select_your_city == '' || select_your_city == null || select_your_city == 'undefiled')
	{
		alert('Please enter your location');
	}
	else
	{
		if(home_region_speciality == '' || home_region_speciality == null || home_region_speciality == 'undefiled')
		{
			home_region_speciality = '';
		}
		
		if(home_dish_items == '' || home_dish_items == null || home_dish_items == 'undefiled')
		{
			home_dish_items = '';
		}
				
		var dataString ='topcityid='+select_your_city+'&home_region_speciality='+home_region_speciality+'&home_dish_items='+home_dish_items+'&action=dosearchcusineexplore';
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
                                    //alert(arr_result[4]);
					//alert(document.location.href);
					//var arr_url_temp = String( document.location.href ).split('#');
					//document.location.href = String( document.location.href ).replace( arr_url_temp[1], "" );
					//document.location.href = String( document.location.href ).replace( "#", "" );
					//window.location.reload(true);
					//window.location.href = arr_result[3];
					//window.location.reload(true);
					//document.location.href = arr_result[3];
					//window.location.href += "#mypara";
					window.location.href = arr_result[4];
					
					//location.reload();
					
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

function setHomeAllPublishedItemOptions()
{
	var home_region_speciality = $('#home_region_speciality').val();
	var home_dish_items = $('#home_dish_items').val();
	
	
	if(home_region_speciality == null)
	{
		home_region_speciality = '';
	}
	
	if(home_dish_items == null)
	{
		home_dish_items = '';
	}
	
	
	var dataString ='home_region_speciality='+home_region_speciality+'&home_dish_items='+home_dish_items+'&action=sethomeallpublisheditemoptions';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,      
		success: function(result)
		{
			//alert(result);
			$("#home_dish_items").html(result);
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

function getContactUsCategoryOption()
{
	var contactus_parent_cat_id = $('#contactus_parent_cat_id').val();
	var contactus_cat_id = $('#contactus_cat_id').val();
	
	
	if(contactus_parent_cat_id == null)
	{
		contactus_parent_cat_id = '';
	}
	
	if(contactus_cat_id == null)
	{
		contactus_cat_id = '';
	}
	
	var dataString ='contactus_parent_cat_id='+contactus_parent_cat_id+'&contactus_cat_id='+contactus_cat_id+'&action=getcontactuscategoryoption';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,      
		success: function(result)
		{
			//alert(result);
			$("#contactus_cat_id").html(result);
			toggleContactUsCategoryOther();
			if(contactus_parent_cat_id == '157')
			{
				$("#show_contactus_subtype").hide();
			}
			else
			{
				$("#show_contactus_subtype").show();
			}
			
			if(contactus_parent_cat_id == '157' || contactus_parent_cat_id == '163')
			{
				$("#show_contactus_cat_other").show();
			}
			
		}
	});
}

function toggleContactUsParentCategoryOther()
{
	var contactus_parent_cat_id = $('#contactus_parent_cat_id').val();
	
	if(contactus_parent_cat_id == '157')
	{
		$("#show_contactus_parent_cat_other").show();
	}
	else
	{
		$("#show_contactus_parent_cat_other").hide();
	}
	
	if(contactus_parent_cat_id == '150' || contactus_parent_cat_id == '151' || contactus_parent_cat_id == '')
	{
		$("#show_contactus_speciality").hide();
		$("#show_contactus_item").hide();
		$("#show_contactus_no_of_people").hide();
	}
	else
	{
		$("#show_contactus_speciality").show();
		$("#show_contactus_item").show();
		$("#show_contactus_no_of_people").show();
	}
}

function toggleContactUsCategoryOther()
{
	var contactus_cat_id = $('#contactus_cat_id').val();
	
	if(contactus_cat_id == '158' || contactus_cat_id == '159' || contactus_cat_id == '161')
	{
		$("#show_contactus_cat_other").show();
	}
	else
	{
		$("#show_contactus_cat_other").hide();
	}
}

function toggleContactUsSpecialityOther()
{
	var contactus_speciality_id = $('#contactus_speciality_id').val();
	//alert('Array: '+JSON.stringify(contactus_speciality_id));
	
	if(inArray('999999999', contactus_speciality_id))
	{
		$("#show_contactus_speciality_other").show();
	}
	else
	{
		$("#show_contactus_speciality_other").hide();
	}
}

function getItemOptionSpecialityWise()
{
	var contactus_speciality_id = $('#contactus_speciality_id').val();
	var contactus_item_id = $('#contactus_item_id').val();
	//alert('Array: '+JSON.stringify(contactus_speciality_id));
	//alert(contactus_speciality_id);
	//alert(contactus_item_id);
	
	var dataString ='speciality='+contactus_speciality_id+'&item_id='+contactus_item_id+'&action=getitemoptionspecialitywise';
	$.ajax({
		type: "POST",
		url: "remote.php",
		data: dataString,
		cache: false,      
		success: function(result)
		{
			//alert(result);
			
			//if(contactus_speciality_id == '')
			//{
				//$('#contactus_item_id').tokenize2().trigger('tokenize:clear');
			//}
			
			$("#contactus_item_id").html(result);
		}
	});
}

function toggleContactUsItemOther()
{
	var contactus_item_id = $('#contactus_item_id').val();
	//alert('Array: '+JSON.stringify(contactus_item_id));
	
	if(inArray('999999999', contactus_item_id))
	{
		$("#show_contactus_item_other").show();
	}
	else
	{
		$("#show_contactus_item_other").hide();
	}
}

function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        //alert("haystack:"+haystack[i]+", needle:"+needle);
        if(haystack[i] == needle) return true;
        
    }
    return false;
}

function arrayCompare(a1, a2) {
    if (a1.length != a2.length) return false;
    var length = a2.length;
    for (var i = 0; i < length; i++) {
        if (a1[i] !== a2[i]) return false;
    }
    return true;
}

function doContactUs()
{
	var contactus_city_id = $('#hdncontactus_city_id').val();
	var contactus_area_id = $('#hdncontactus_area_id').val();
	var contactus_name = $('#contactus_name').val();
	var contactus_email = $('#contactus_email').val();
	var contactus_contact_no = $('#contactus_contact_no').val();
	var contactus_parent_cat_id = $('#contactus_parent_cat_id').val();
	var contactus_parent_cat_other = $('#contactus_parent_cat_other').val();
	var contactus_cat_id = $('#contactus_cat_id').val();
	var contactus_cat_other = $('#contactus_cat_other').val();
	var contactus_speciality_id = $('#contactus_speciality_id').val();
	var contactus_speciality_other = $('#contactus_speciality_other').val();
	var contactus_item_id = $('#contactus_item_id').val();
	var contactus_item_other = $('#contactus_item_other').val();
	var contactus_no_of_people = $('#contactus_no_of_people').val();
	var contactus_comments = $('#contactus_comments').val();
	
	var error = false;
	
	if(contactus_parent_cat_id == '')
	{
		$('#err_msg_contactus').html('<p class="err_msg">Please select enquiry type.</p>');
		$(window).scrollTop(0); 
		error = true;
	}
	else if(contactus_name == '')
	{
		$('#err_msg_contactus').html('<p class="err_msg">Please enter your name.</p>');
		$(window).scrollTop(0); 
		error = true;
	}
	else if(contactus_email == '')
	{
		$('#err_msg_contactus').html('<p class="err_msg">Please enter your email.</p>');
		$(window).scrollTop(0); 
		error = true;
	}
	else if(contactus_contact_no == '')
	{
		$('#err_msg_contactus').html('<p class="err_msg">Please enter your contact no.</p>');
		$(window).scrollTop(0); 
		error = true;
	}
	else if(contactus_city_id == '')
	{
		$('#err_msg_contactus').html('<p class="err_msg">Please enter your location.</p>');
		$(window).scrollTop(0); 
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=docontactus&contactus_city_id='+escape(contactus_city_id)+'&contactus_area_id='+escape(contactus_area_id)+'&contactus_name='+escape(contactus_name)+'&contactus_email='+escape(contactus_email)+'&contactus_contact_no='+escape(contactus_contact_no)+'&contactus_parent_cat_id='+escape(contactus_parent_cat_id)+'&contactus_parent_cat_other='+escape(contactus_parent_cat_other)+'&contactus_cat_id='+escape(contactus_cat_id)+'&contactus_cat_other='+escape(contactus_cat_other)+'&contactus_speciality_id='+escape(contactus_speciality_id)+'&contactus_speciality_other='+escape(contactus_speciality_other)+'&contactus_item_id='+escape(contactus_item_id)+'&contactus_item_other='+escape(contactus_item_other)+'&contactus_no_of_people='+escape(contactus_no_of_people)+'&contactus_comments='+escape(contactus_comments);
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
					$('#err_msg_contactus').html('<p class="err_msg">'+arr_result[2]+'</p>');
					$(window).scrollTop(0); 
				}
				else
				{
					$('#err_msg_contactus').html('');
					window.location.href = arr_result[3];
				}
			}
		});	
	}
}

function scrollToDiv(divid)
{
	//alert(divid);
	$('html, body').animate({
        scrollTop: $("#"+divid).offset().top
    }, 1000);
}

function doCancelItem()
{
	var invoice = $('#hdninvoice').val();
	var ocid = $('#hdnocid').val();
	var cancel_cat_id = $('#cancel_cat_id').val();
	var cancel_cat_other = $('#cancel_cat_other').val();
	var cancel_comments = $('#cancel_comments').val();
	
	var error = false;
	
	if(!error)
	{
		var dataString = 'action=docancelitem&invoice='+escape(invoice)+'&ocid='+escape(ocid)+'&cancel_cat_id='+escape(cancel_cat_id)+'&cancel_cat_other='+escape(cancel_cat_other)+'&cancel_comments='+escape(cancel_comments);
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
					$('#err_msg_cancel').html('<p class="err_msg">'+arr_result[2]+'</p>');
					$(window).scrollTop(0); 
				}
				else
				{
					$('#err_msg_cancel').html('');
					window.location.href = arr_result[3];
				}
			}
		});	
	}
}

function toggleCancelCategoryOther()
{
	var cancel_cat_id = $('#cancel_cat_id').val();
	
	if(cancel_cat_id == '221')
	{
		$("#show_cancel_cat_other").show();
	}
	else
	{
		$("#show_cancel_cat_other").hide();
	}
	
}

function doVendorRegistrationProceed()
{
	var va_cat_id = $('#va_cat_id').val();
	
	var error = false;
	
	if(va_cat_id == '')
	{
		$('#err_msg_signup').html('<p class="err_msg">Please select category.</p>');
		error = true;
	}
	
	if(!error)
	{
		var dataString = 'action=dovendorregistrationproceed&va_cat_id='+escape(va_cat_id);
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
					window.location.href = arr_result[3];
					
				}
			}
		});	
	}
}
function sendRequstWithUserLogin(name,item_id,parent_id,cat_id)
	{
	var formData = new FormData();
        formData.append("request_item_id",item_id);
        formData.append("request_parent_id",parent_id);
        formData.append("request_cat_id",cat_id);  		
        formData.append("btnsubmit",'btnsubmit');
        jQuery.ajax({
        url:'remote.php',
        type: "POST",
        data:formData,
        processData: false,
        contentType: false,
		//beforeSend: function(){ $("#loader").show();$("#hidebtn").hide();},
        success: function(result)
		 {
		   bootbox.alert("Your request has been sent !");		  
           }
		});		 	
	}
function openRequestCusineForm(name,item_id,parent_id,cat_id)
    {
        
    $('#request_item_name').val(name);    
    $('#request_item_id').val(item_id);   
    $('#request_parent_id').val(parent_id); 
    $('#request_cat_id').val(cat_id); 
    var modal = document.getElementById('exampleModal');
    modal.style.display = "block";
    }
function closeRequestCusineForm()
    {
        
    $('#cusineRequestForm')[0].reset();
    var modal = document.getElementById('exampleModal');
    modal.style.display = "none";
    }

function sendRequst()
    {
	var error=true;	
	//alert($('#request_city_id').val();
	if($('#request_item_name').val()=='' )
		{
	    $('#er_req_item').html('<p style="color:red">Please enter item</p>');
		error=false;
		}
 	if($('#request_name').val()=='' )
		{
	    $('#er_req_name').html('<p style="color:red">Please enter name</p>');
		error=false;
		}
    if($('#request_email').val()=='' )
		{
		$('#er_req_email').html('<p style="color:red">Please enter email</p>');
		error=false;
		}
    if($('#request_contact').val()=='' )
		{
		
		$('#er_req_contact').html('<p style="color:red">Please enter contact number</p>');
		error=false;
		}
    if($('#request_comments').val()=='' )
		{
		$('#er_req_comment').html('<p style="color:red">Please enter additional information</p>');
		error=false;
		}
    /*if($('#request_city_id').val()=='' )
		{
		$('#er_req_city').html('<p style="color:red">Please select city</p>');	
		error=false;
		}
    if($('#request_area_id').val()=='' )
		{
		$('#er_req_area').html('<p style="color:red">Please select area</p>');
		error=false;
		}*/
    if(error)
		{
		var formData = new FormData($('#cusineRequestForm')[0]); 
        formData.append("btnsubmit",'btnsubmit');
        jQuery.ajax({
        url:'remote.php',
        type: "POST",
        data:formData,
        processData: false,
        contentType: false,
		beforeSend: function(){ $("#loader").show();$("#hidebtn").hide();},
        success: function(result)
          {
           var arr_result = result.split('::::');
		  
			if(arr_result[1] == '1')
				{
				$('#err_rq').html('<p class="req_err">'+arr_result[2]+'</p>');
				}
			else
				{
				$('#cusineRequestForm')[0].reset();
					$("#exampleModal").hide();	
			    bootbox.alert("Your request has been sent !");		
				
				}   
			}
		});		 
		}		
   
    }
	function openNextDelaveryDate(item,cnt)
		{
	    var cusine_area_id = $('.cusine_area_'+cnt).val();
		//var cusine_area_id = $('.cusine_area_'+cnt).filter(":selected").val();
		if(cusine_area_id == '' || cusine_area_id == 'null' || cusine_area_id == 'undefined')
			{
			console.log('.cusine_area_'+cnt+':'+cusine_area_id);
			alert('Please select area of item');
			}	
        else
			{
		    var dataString ='action=getAllDelaveyListOfItem&item_id='+item+'&cnt='+cnt;
			$.ajax({
			type: "POST",
			url: "remote.php",
			data: dataString,
			cache: false,
			success: function(result)
			{
				bootbox.dialog({
				title: 'Delavery Date',
				message: result
			});
			
			}
		});				 
			}			
			
	}
	
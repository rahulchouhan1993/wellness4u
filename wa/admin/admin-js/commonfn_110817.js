function ShowOrHideCheckBox(id_val)
{
	if($('#menu_'+id_val).is(':checked'))
	{
		$("input[id^='permissions_"+id_val+"_']").removeAttr("disabled");
		//$("input[id^='permissions_"+id_val+"_']").attr("checked", true);
		$("input[id^='permissions_"+id_val+"_']").prop('checked', !($(this).is(':checked')));
		
	}
	else
	{
		$("input[id^='permissions_"+id_val+"_']").attr("disabled", true);
		$("input[id^='permissions_"+id_val+"_']").removeAttr("checked");
	}
	
}
	
function HideCheckBox(id_val)
{
	var values = $('input:checkbox:checked.group_'+id_val).map(function () {
		return this.value;
	}).get();
	 //alert(values);
	 
	 if(values == '')
	{
		$("#menu_"+id_val).removeAttr("checked");
		ShowOrHideCheckBox(id_val);
	}
}

function getVendorLocationOption(type,multiple,option_str,vloc_id)
{
	var vendor_id = $("#vendor_id").val();
	var dataString = 'action=getvendorlocationoption&vendor_id='+vendor_id+'&type='+type+'&multiple='+multiple;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			if(option_str == '1')
			{
				$(".vloc_box").html(result);
			}
			else
			{
				$("#"+vloc_id).html(result);	
			}
			
		}
	});
}

function getVendorLocationOptionMulti(idval,type,multiple,option_str)
{
	var vendor_id = $("#vendor_id_"+idval).val();
	var dataString = 'action=getvendorlocationoption&vendor_id='+vendor_id+'&type='+type+'&multiple='+multiple;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			if(option_str == '1')
			{
				$(".vloc_box").html(result);
			}
			else
			{
				$("#vloc_id_"+idval).html(result);	
			}
			
		}
	});
}

function getMainCategoryOptionAddMore(idval)
{
	var parent_cat_id = $("#cucat_parent_cat_id_"+idval).val();
	var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#cucat_cat_id_"+idval).html(result);
		}
	});
}

function getMainCategoryOptionAddMoreCommon(substr,idval)
{
	var parent_cat_id = $("#"+substr+"_parent_cat_id_"+idval).val();
	var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#"+substr+"_cat_id_"+idval).html(result);
		}
	});
}

function getMainCategoryOptionCommon(idval,type)
{
	var parent_cat_id = $("#"+idval+"_parent_cat_id").val();
	var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id+'&type='+type;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#"+idval+"_cat_id").html(result);
		}
	});
}

function getMainCategoryOptionCommonMultiple(idval,type,multiple)
{
	var parent_cat_id = $("#"+idval+"_parent_cat_id").val();
	var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id+'&type='+type+'&multiple='+multiple;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#"+idval+"_cat_id").html(result);
		}
	});
}

function getStateOptionCommon(type,multiple)
{
	var country_id = $("#country_id").val();
	var state_id = '';
	var dataString = 'action=getstateoption&country_id='+country_id+'&state_id='+state_id+'&type='+type+'&multiple='+multiple;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#state_id").html(result);
			getCityOptionCommon(type,multiple);
		}
	});
}

function getCityOptionCommon(type,multiple)
{
	var country_id = $("#country_id").val();
	var state_id = $("#state_id").val();
	var city_id = '';
	var dataString = 'action=getcityoption&country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&type='+type+'&multiple='+multiple;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#city_id").html(result);
			getAreaOptionCommon(type,multiple);
		}
	});
}

function getAreaOptionCommon(type,multiple)
{
	var country_id = $("#country_id").val();
	var state_id = $("#state_id").val();
	var city_id = $("#city_id").val();
	var area_id = '';
	var dataString = 'action=getareaoption&country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&type='+type+'&multiple='+multiple;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#area_id").html(result);
		}
	});
}

function showHideDateDropdowns(idval)
{
	var date_type = $('#'+idval+'_date_type').val();
		
	 
	if(date_type == 'days_of_month')
	{
		$('#'+idval+'_show_days_of_month').show();
		$('#'+idval+'_show_days_of_week').hide();
		$('#'+idval+'_show_single_date').hide();
		$('#'+idval+'_show_start_date').hide();
		$('#'+idval+'_show_end_date').hide();
	}
	else if(date_type == 'days_of_week')
	{
		$('#'+idval+'_show_days_of_month').hide();
		$('#'+idval+'_show_days_of_week').show();
		$('#'+idval+'_show_single_date').hide();
		$('#'+idval+'_show_start_date').hide();
		$('#'+idval+'_show_end_date').hide();
	}
	else if(date_type == 'single_date')
	{
		$('#'+idval+'_show_days_of_month').hide();
		$('#'+idval+'_show_days_of_week').hide();
		$('#'+idval+'_show_single_date').show();
		$('#'+idval+'_show_start_date').hide();
		$('#'+idval+'_show_end_date').hide();
	}
	else if(date_type == 'date_range')
	{
		$('#'+idval+'_show_days_of_month').hide();
		$('#'+idval+'_show_days_of_week').hide();
		$('#'+idval+'_show_single_date').hide();
		$('#'+idval+'_show_start_date').show();
		$('#'+idval+'_show_end_date').show();
	}
	else
	{
		$('#'+idval+'_show_days_of_month').hide();
		$('#'+idval+'_show_days_of_week').hide();
		$('#'+idval+'_show_single_date').hide();
		$('#'+idval+'_show_start_date').hide();
		$('#'+idval+'_show_end_date').hide();
	}
}

function showHideDateDropdownsMulti(idval,cnt)
{
	var date_type = $('#'+idval+'_date_type_'+cnt).val();
		
	 
	if(date_type == 'days_of_month')
	{
		$('#'+idval+'_show_days_of_month_'+cnt).show();
		$('#'+idval+'_show_days_of_week_'+cnt).hide();
		$('#'+idval+'_show_single_date_'+cnt).hide();
		$('#'+idval+'_show_start_date_'+cnt).hide();
		$('#'+idval+'_show_end_date_'+cnt).hide();
	}
	else if(date_type == 'days_of_week')
	{
		$('#'+idval+'_show_days_of_month_'+cnt).hide();
		$('#'+idval+'_show_days_of_week_'+cnt).show();
		$('#'+idval+'_show_single_date_'+cnt).hide();
		$('#'+idval+'_show_start_date_'+cnt).hide();
		$('#'+idval+'_show_end_date_'+cnt).hide();
	}
	else if(date_type == 'single_date')
	{
		$('#'+idval+'_show_days_of_month_'+cnt).hide();
		$('#'+idval+'_show_days_of_week_'+cnt).hide();
		$('#'+idval+'_show_single_date_'+cnt).show();
		$('#'+idval+'_show_start_date_'+cnt).hide();
		$('#'+idval+'_show_end_date_'+cnt).hide();
	}
	else if(date_type == 'date_range')
	{
		$('#'+idval+'_show_days_of_month_'+cnt).hide();
		$('#'+idval+'_show_days_of_week_'+cnt).hide();
		$('#'+idval+'_show_single_date_'+cnt).hide();
		$('#'+idval+'_show_start_date_'+cnt).show();
		$('#'+idval+'_show_end_date_'+cnt).show();
	}
	else
	{
		$('#'+idval+'_show_days_of_month_'+cnt).hide();
		$('#'+idval+'_show_days_of_week_'+cnt).hide();
		$('#'+idval+'_show_single_date_'+cnt).hide();
		$('#'+idval+'_show_start_date_'+cnt).hide();
		$('#'+idval+'_show_end_date_'+cnt).hide();
	}
}

function toggleOfferDetails(cnt)
{
	var is_offer = $('#is_offer_'+cnt).val();
		
	 
	if(is_offer == '1')
	{
		$('#offer_show_price_label_'+cnt).show();
		$('#offer_show_price_value_'+cnt).show();
		$('#offer_show_date_'+cnt).show();
	}
	else
	{
		$('#offer_show_price_label_'+cnt).hide();
		$('#offer_show_price_value_'+cnt).hide();
		$('#offer_show_date_'+cnt).hide();
	}
}

function setDaysOfMonthStrMulti(cnt)
{
	var days_of_month = $('#offer_days_of_month_'+cnt).val();
	//alert(days_of_month);
	$('#offer_days_of_month_str_'+cnt).val(days_of_month);
}

function setDaysOfWeekStrMulti(cnt)
{
	var days_of_week = $('#offer_days_of_week_'+cnt).val();
	//alert(days_of_week);
	$('#offer_days_of_week_str_'+cnt).val(days_of_week);
}

function toggleCusionTypeValues()
{
	var cusine_type_id = $('#cusine_type_id').val();
		
	 
	if(cusine_type_id == '122')
	{
		$('.show_for_complementry').show();
	}
	else 
	{
		$('.show_for_complementry').hide();
	}
}

function showHideTaxQtyDropdowns()
{
	var tax_type = $('#tax_type').val();
		
	 
	if(tax_type == '2')
	{
		$('#show_tax_qty_id').show();
		$('#show_tax_amount').show();
		$('#show_tax_percentage').hide();
	}
	else if(tax_type == '0')
	{
		$('#show_tax_qty_id').hide();
		$('#show_tax_amount').show();
		$('#show_tax_percentage').hide();
	}
	else if(tax_type == '1')
	{
		$('#show_tax_qty_id').hide();
		$('#show_tax_amount').hide();
		$('#show_tax_percentage').show();
	}
	else if(tax_type == '3')
	{
		$('#show_tax_qty_id').hide();
		$('#show_tax_amount').hide();
		$('#show_tax_percentage').hide();
	}
	else
	{
		//$('#show_tax_qty_id').hide();
	}
}

function showHideShippingQtyDropdowns()
{
	var sp_type = $('#sp_type').val();
		
	 
	if(sp_type == '2')
	{
		$('#show_sp_min_qty_id').show();
		$('#show_sp_max_qty_id').show();
		$('#show_sp_amount').show();
		$('#show_sp_percentage').hide();
		$('#show_sp_order_amount').hide();
	}
	else if(sp_type == '0')
	{
		$('#show_sp_min_qty_id').hide();
		$('#show_sp_max_qty_id').hide();
		$('#show_sp_amount').show();
		$('#show_sp_percentage').hide();
		$('#show_sp_order_amount').show();
	}
	else if(sp_type == '1')
	{
		$('#show_sp_min_qty_id').hide();
		$('#show_sp_max_qty_id').hide();
		$('#show_sp_amount').hide();
		$('#show_sp_percentage').show();
		$('#show_sp_order_amount').show();
	}
	else if(sp_type == '3')
	{
		$('#show_sp_min_qty_id').hide();
		$('#show_sp_max_qty_id').hide();
		$('#show_sp_amount').hide();
		$('#show_sp_percentage').hide();
		$('#show_sp_order_amount').hide();
	}
	else
	{
		
	}
}

function showHideCancellationQtyDropdowns()
{
	var cp_type = $('#cp_type').val();
		
	 
	if(cp_type == '2')
	{
		$('#show_cp_min_qty_id').show();
		$('#show_cp_max_qty_id').show();
		$('#show_cp_amount').show();
		$('#show_cp_percentage').hide();
		$('#show_cp_cancellation_amount').hide();
	}
	else if(cp_type == '0')
	{
		$('#show_cp_min_qty_id').hide();
		$('#show_cp_max_qty_id').hide();
		$('#show_cp_amount').show();
		$('#show_cp_percentage').hide();
		$('#show_cp_cancellation_amount').show();
	}
	else if(cp_type == '1')
	{
		$('#show_cp_min_qty_id').hide();
		$('#show_cp_max_qty_id').hide();
		$('#show_cp_amount').hide();
		$('#show_cp_percentage').show();
		$('#show_cp_cancellation_amount').show();
	}
	else if(cp_type == '3')
	{
		$('#show_cp_min_qty_id').hide();
		$('#show_cp_max_qty_id').hide();
		$('#show_cp_amount').hide();
		$('#show_cp_percentage').hide();
		$('#show_cp_cancellation_amount').hide();
	}
	else
	{
		
	}
}

function showHideDiscountCouponQtyDropdowns()
{
	var dc_type = $('#dc_type').val();
		
	 
	if(dc_type == '2')
	{
		$('#show_dc_min_qty_id').show();
		$('#show_dc_max_qty_id').show();
		$('#show_dc_amount').show();
		$('#show_dc_percentage').hide();
		$('#show_dc_order_amount').hide();
	}
	else if(dc_type == '0')
	{
		$('#show_dc_min_qty_id').hide();
		$('#show_dc_max_qty_id').hide();
		$('#show_dc_amount').show();
		$('#show_dc_percentage').hide();
		$('#show_dc_order_amount').show();
	}
	else if(dc_type == '1')
	{
		$('#show_dc_min_qty_id').hide();
		$('#show_dc_max_qty_id').hide();
		$('#show_dc_amount').hide();
		$('#show_dc_percentage').show();
		$('#show_dc_order_amount').show();
	}
	else
	{
		
	}
}

function getOrderDeliveryDate()
{
	var invoice = $("#invoice").val();
	var dataString = 'action=getorderdeliverydate&invoice='+invoice;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			$("#delivery_date").val(result);
		}
	});
}

function getOrderCartItemsListOfInvoice(mode)
{
	var invoice = $("#invoice").val();
	var str_order_cart_id = $("#hdnstr_order_cart_id").val();
	var dataString = 'action=getordercartitemslistofinvoice&invoice='+invoice+'&str_order_cart_id='+str_order_cart_id+'&mode='+mode;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#od_items_list").html(result);
		}
	});
}

function getLogisticPartnerOption(type)
{
	var vendor_cat_id = $("#logistic_partner_type_cat_id").val();
	var dataString = 'action=getlogisticpartneroption&vendor_cat_id='+vendor_cat_id+'&type='+type;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#logistic_partner_id").html(result);
		}
	});
}

function getIngredientsByIngrdientType()
{
	var ingredient_type = $("#ingredient_type").val();
	var ingredient_id = $("#ingredient_id").val();
	if(ingredient_type == null)
	{
		ingredient_type = '';
	}
	
	if(ingredient_id == null)
	{
		ingredient_id = '';
	}
	
	var dataString ='ingredient_type='+ingredient_type+'&ingredient_id='+ingredient_id+'&action=getingredientsbyingrdienttype';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,      
		success: function(result)
		{
			//alert(result);
			
			if(ingredient_type == '')
			{
				//$('#ingredient_id').tokenize2().trigger('tokenize:clear');
			}
			
			$("#ingredient_id").html(result);
		}
	});
}

function getShippingAppliedOnOption(type)
{
	var sp_type = $("#sp_type").val();
	var sp_applied_on = $("#sp_applied_on").val();
	var dataString = 'action=getshippingappliedonoption&sp_type='+sp_type+'&sp_applied_on='+sp_applied_on+'&type='+type;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#sp_applied_on").html(result);
		}
	});
}

function getCancellationAppliedOnOption(type)
{
	var cp_type = $("#cp_type").val();
	var cp_applied_on = $("#cp_applied_on").val();
	var dataString = 'action=getcancellationappliedonoption&cp_type='+cp_type+'&cp_applied_on='+cp_applied_on+'&type='+type;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#cp_applied_on").html(result);
		}
	});
}

function getDiscountCouponAppliedOnOption(type)
{
	var dc_type = $("#dc_type").val();
	var dc_applied_on = $("#dc_applied_on").val();
	var dataString = 'action=getdiscountcouponappliedonoption&dc_type='+dc_type+'&dc_applied_on='+dc_applied_on+'&type='+type;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#dc_applied_on").html(result);
		}
	});
}

function removeImageCommon(idval)
{
	//alert(idval);
	$("#divid_"+idval).remove();
	$("#hdn"+idval).val('');
}

function calculateItemCancellationCharge(idval)
{
	var prod_subtotal = $("#prod_subtotal_"+idval).val();
	var order_cart_id = $("#order_cart_id_"+idval).val();
	var cp_id = $("#cp_id_"+idval).val();
	var invoice = $("#hdninvoice").val();
	
	var dataString = 'action=calculateitemcancellationcharge&prod_subtotal='+prod_subtotal+'&order_cart_id='+order_cart_id+'&cp_id='+cp_id+'&invoice='+invoice;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#prod_cancel_subtotal_"+idval).html(result);
			calculateFinalCancellationCharge();
		}
	});
}

function calculateFinalCancellationCharge()
{
	var totalitems = $("#hdntotalitems").val();
	var invoice = $("#hdninvoice").val();
	var cp_sp_amount = $("#cp_sp_amount").val();
	var cp_tax_amount = $("#cp_tax_amount").val();
	
	var prod_subtotal = '';
	var order_cart_id = '';
	var cp_id = '';
	var i=0;
	for(i=0;i<totalitems;i++)
	{
		prod_subtotal += $("#prod_subtotal_"+i).val()+',';
		order_cart_id += $("#order_cart_id_"+i).val()+',';
		cp_id += $("#cp_id_"+i).val()+',';	
	}
	
	var dataString = 'action=calculatefinalcancellationcharge&prod_subtotal='+prod_subtotal+'&order_cart_id='+order_cart_id+'&cp_id='+cp_id+'&invoice='+invoice+'&cp_sp_amount='+cp_sp_amount+'&cp_tax_amount='+cp_tax_amount+'&totalitems='+totalitems;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#total_cancellation_amount").html(result);
		}
	});
}

function calculateFinalCancellationCharge()
{
	var totalitems = $("#hdntotalitems").val();
	var invoice = $("#hdninvoice").val();
	var cp_sp_amount = $("#cp_sp_amount").val();
	var cp_tax_amount = $("#cp_tax_amount").val();
	
	var prod_subtotal = '';
	var order_cart_id = '';
	var cp_id = '';
	var i=0;
	for(i=0;i<totalitems;i++)
	{
		prod_subtotal += $("#prod_subtotal_"+i).val()+',';
		order_cart_id += $("#order_cart_id_"+i).val()+',';
		cp_id += $("#cp_id_"+i).val()+',';	
	}
	
	var dataString = 'action=calculatefinalcancellationcharge&prod_subtotal='+escape(prod_subtotal)+'&order_cart_id='+escape(order_cart_id)+'&cp_id='+escape(cp_id)+'&invoice='+escape(invoice)+'&cp_sp_amount='+escape(cp_sp_amount)+'&cp_tax_amount='+escape(cp_tax_amount)+'&totalitems='+escape(totalitems);
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#total_cancellation_amount").html(result);
		}
	});
}

function doCancellationOrder()
{
	var totalitems = $("#hdntotalitems").val();
	var invoice = $("#hdninvoice").val();
	var cp_sp_amount = $("#cp_sp_amount").val();
	var cp_tax_amount = $("#cp_tax_amount").val();
	var cancellation_note = $("#cancellation_note").val();
	
	var prod_subtotal = '';
	var order_cart_id = '';
	var cp_id = '';
	var i=0;
	for(i=0;i<totalitems;i++)
	{
		prod_subtotal += $("#prod_subtotal_"+i).val()+',';
		order_cart_id += $("#order_cart_id_"+i).val()+',';
		cp_id += $("#cp_id_"+i).val()+',';	
	}
	
	var dataString = 'action=docancellationorder&prod_subtotal='+escape(prod_subtotal)+'&order_cart_id='+escape(order_cart_id)+'&cp_id='+escape(cp_id)+'&invoice='+escape(invoice)+'&cp_sp_amount='+escape(cp_sp_amount)+'&cp_tax_amount='+escape(cp_tax_amount)+'&totalitems='+escape(totalitems)+'&cancellation_note='+escape(cancellation_note);
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			var arr_result = result.split('::::');
			if(arr_result[1] == '1')
			{
				alert(arr_result[2]);
			}
			else
			{
				window.location.href = arr_result[3];
			}
		}
	});
}

function generateDiscountCoupon()
{
	var dataString = 'action=generatediscountcoupon';
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#discount_coupon").val(result);
		}
	});
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

function toggleTOSAndVendorName(idval)
{
	var seller_type = $('#seller_type_'+idval).val();
	
	if(seller_type == '1')
	{
		$("#tos_name_"+idval).hide();
		$("#tos_address_"+idval).hide();
		$("#vendor_id_"+idval).show();
		$("#vloc_id_"+idval).show();
	}
	else
	{
		$("#tos_name_"+idval).show();
		$("#tos_address_"+idval).show();
		$("#vendor_id_"+idval).hide();
		$("#vloc_id_"+idval).hide();
	}
}

function getVendorAccessFormCode()
{
	var va_id = $("#hdnva_id").val();
	var vafm_id = $("#vafm_id").val();
	var dataString = 'action=getvendoraccessformcode&va_id='+va_id+'&vafm_id='+vafm_id;
	$.ajax({
		type: "POST",
		url: "ajax/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
			$("#vendor_access_form").html(result);
		}
	});
}
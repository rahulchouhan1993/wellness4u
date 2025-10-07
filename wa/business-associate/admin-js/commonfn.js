function fin(responseTxt,responseStat) {

  //alert(responseStat+' - '+responseTxt);

}





function ajaxObject(url, callbackFunction) {

	var that=this;     

  	this.updating = false;

  	this.abort = function() {

    	if (that.updating) {

      		that.updating=false;

      		that.AJAX.abort();

      		that.AJAX=null;

    	}

	}

	this.update = function(passData,postMethod) {

    	if (that.updating) { 

			return false;

		}

    	that.AJAX = null;                         

    	if (window.XMLHttpRequest) {             

      		that.AJAX=new XMLHttpRequest();             

    	} else {                                 

      		that.AJAX=new ActiveXObject("Microsoft.XMLHTTP");

    	}                                             

    	if (that.AJAX==null) {                             

      		return false;                               

    	} else {

      		that.AJAX.onreadystatechange = function() { 

        		if (that.AJAX.readyState==4) {             

          			that.updating=false;               

          			that.callback(that.AJAX.responseText,that.AJAX.status,that.AJAX.responseXML);       

          			that.AJAX=null;                                         

        		}                                                     

      		}                                                       

      		that.updating = new Date();                             

      		if (/post/i.test(postMethod)) {

        		var uri=urlCall+'?'+that.updating.getTime();

        		that.AJAX.open("POST", uri, true);

        		that.AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        		that.AJAX.send(passData);

      		} else {

        		var uri=urlCall+'?'+passData+'&timestamp='+(that.updating.getTime());

        		that.AJAX.open("GET", uri, true);                             

        		that.AJAX.send(null);                                         

      		}             

      		return true;                                             

    	}                                                                           

  	}

  	var urlCall = url;       

  	this.callback = callbackFunction || function () { };

  

}

























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

	var default_cat_id = $("#default_cucat_cat_id").val();

	var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id+'&default_cat_id='+default_cat_id;

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



function getMainCategoryOptionAddMoreCommon(substr,idval,default_cat_id)

{

	var parent_cat_id = $("#"+substr+"_parent_cat_id_"+idval).val();

	var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id+'&default_cat_id='+default_cat_id;

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



function getMainCategoryOptionCommon(idval,type,default_cat_id)

{

	var parent_cat_id = $("#"+idval+"_parent_cat_id").val();

	var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id+'&type='+type+'&default_cat_id='+default_cat_id;

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



function doOpenPopupItemNotAvailable()

{

	var dataString = 'action=doopenpopupitemnotavailable';

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			BootstrapDialog.show({

				title: 'Enter Your item to notify Admin',

				message:result

			});

		}

	});

}



function sendNewItemNotificationToAdmin()

{

	var new_item_name = $("#new_item_name").val();

	var dataString = 'action=sendnewitemnotificationtoadmin&new_item_name='+new_item_name;

	$.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

			//alert(result);

			$("#err_popup").html(result);

		}

	});

}



function toggleDiscountDetails(cnt)

{

	var is_offer = $('#is_discount_'+cnt).val();

		

	 

	if(is_offer == '1')

	{

		$('#discount_show_price_label_'+cnt).show();

		$('#discount_show_price_value_'+cnt).show();

		$('#discount_show_date_'+cnt).show();

	}

	else

	{

		$('#discount_show_price_label_'+cnt).hide();

		$('#discount_show_price_value_'+cnt).hide();

		$('#discount_show_date_'+cnt).hide();

	}

}



function getMainCategoryOptionAddMoreCommon(substr,idval)

{

	var parent_cat_id = $("#"+substr+"_parent_cat_id_"+idval).val();

        //alert(parent_cat_id);

	var dataString = 'action=getmaincategoryoptionnew&parent_cat_id='+parent_cat_id;

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



function getMainCategoryOptionAddMoreCommonLOC(substr,idval,default_cat_id)

{

	var parent_cat_id = $("#"+substr+"_parent_cat_id_"+idval).val();

        //alert(default_cat_id);

	var dataString = 'action=getmaincategoryoptionloc&parent_cat_id='+parent_cat_id+'&default_cat_id='+default_cat_id;

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



function getMainCategoryOptionAddMoreCommonLOCPlus(substr,idval)

{

	var parent_cat_id = $("#"+substr+"_parent_cat_id_"+idval).val();

        

        

        

        var default_cat_id = $("#hdn_default_cat_id_"+idval).val();



        //alert(default_cat_id);

    

    var dataString = 'action=getmaincategoryoptionloc&parent_cat_id='+parent_cat_id+'&default_cat_id='+default_cat_id;

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







// 10-5-2019

function doAcceptUserInvitation(ar_id,puid)

{

	// alert('hi');

	var Choice = confirm("Do you wish to modify?");

	if (Choice == true)

	{

		// alert(result);

		link='ajax/remote.php?action=doacceptuserinvitation&ar_id='+ar_id+'&puid='+puid;

		var linkComp = link.split( "?");

		// var result



       

		var obj = new ajaxObject(linkComp[0], fin);

		obj.update(linkComp[1],"GET");

		obj.callback = function (responseTxt, responseStat) {

			// we'll do something to process the data here.

			result = responseTxt;



			

			

			$(".QTPopup").css('display', 'none');

			window.location.reload(true);

			

		}

	

	}

}

		//add by ample
		function showUserQueryPopup(idval,page_id)
         
         {  

            if(idval)
            {
                var text='My Reply';
            }
            else
            {
                var text='Add Suggestions/Goal';
            }
         
                 var dataString ='parent_aq_id='+idval+'&page_id='+page_id+'&action=showuserquerypopup';
         
               $.ajax({
         
                  type: "POST",
         
                  url: "ajax/remote.php",
         
                  data: dataString,
         
                  cache: false,      
         
                  success: function(result)
         
                  {
         
                     BootstrapDialog.show({
         
                                             title: text,
         
                                             message:result
         
                                         });
         
                  }
         
               });
         
                 
         

         }

        //add by ample
         function replyUserQuery()
         
         {
         
            var parent_aq_id = $('#hdnparent_aq_id').val();
         
            var temp_user_id = $('#hdntemp_user_id').val();
         
            var temp_pro_user_id = $('#hdntemp_pro_user_id').val();
         
            var temp_page_id = $('#hdntemp_page_id').val();
         
            var name = $('#hdnname').val();
         
            var email = $('#hdnemail').val();
         
            var query = escape($('#feedback').val());
         
            
         
            
            //add by ample 26-03-20
            if(temp_page_id == '')

            {

                alert('Please Select Reference!');  

            }

             else if(query == '')
         
            {
         
               alert('Please Enter Query!'); 
         
            }
         
            else
         
            {
         
                         var dataString ='action=replyuserquery&parent_aq_id='+parent_aq_id+'&temp_pro_user_id='+temp_pro_user_id+'&temp_user_id='+temp_user_id+'&temp_page_id='+temp_page_id+'&name='+name+'&email='+email+'&query='+query;
         
               $.ajax({
         
                  type: "POST",
         
                  url: "ajax/remote.php",
         
                  data: dataString,
         
                  cache: false,      
         
                  success: function(result)
         
                  {
         
                                         // alert(result);

                                         // console.log(result);

                     result = result.split("::");

 					window.location = "my_users_queries.php";

                     if(result[0] == 1 || result[0] == 2)

                     {

                             // alert(result[1]);

                             // if(result[0] == 2)

                             // {

                             //       window.location.reload(true);
                             //       location.reload();

                             // }

                     }

                  
         
                  }
         
               });
         
         
            }
         
         }


     // add by ample 06-04-20

		function updateSelfQueryPopup(idval)
         {  
         
                var dataString ='parent_aq_id='+idval+'&action=showSelfQueryPopup';
         
               $.ajax({
         
                  type: "POST",
         
                  url: "ajax/remote.php",
         
                  data: dataString,
         
                  cache: false,      
         
                  success: function(result)
         
                  {
         
                     BootstrapDialog.show({
         
                                             title: 'Update My Query',
                                             message:result
         
                                         });
         
                  }
         
               });
         

         }

     //add by ample 06-04-20

         function updateUserQuery()
         
         {
         
            var parent_aq_id = $('#parent_aq_id').val();
         
            var query_old = escape($('#feedback_old').val());

            var query_new = escape($('#feedback_new').val());

            if(query_new == '')
         
            {
         
               alert('Please update Query!'); 
         
            }
            else
            {
            	 var dataString ='action=updateUserQuery&parent_aq_id='+parent_aq_id+'&query_old='+query_old+'&query_new='+query_new;
         
               $.ajax({
         
                  type: "POST",
         
                  url: "ajax/remote.php",
         
                  data: dataString,
         
                  cache: false,      
         
                  success: function(result)
         
                  {
         
                     // alert(result);

                     // console.log(result);

                     //result = result.split("::");

 					window.location = "my_users_queries.php";

         
                  }
         
               });
            }
         
        }

         

	// add new js function for show user profile by ample 25-03-20
	function viewUserProfilePopup(user_id="")

	{

		var dataString = 'action=viewUserProfilePopup&user_id='+user_id;

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,

			success: function(result)

			{

				BootstrapDialog.show({

					title: 'View User Details',

					message:result

				});

			}

		});

	}

	//add by ample 26-03-30
function post2blank(url,myarray)
{   var myform = '<form id="temporary_form" action="' +url+ '" method="POST" target="_blank">';
    $.each(myarray, function( key, value ){myform += '<input name="' +key+ '" value="' +value+ '"/>';});
    myform += '</form>';
    $(myform).appendTo('body').submit();
    $('#temporary_form').remove();
}
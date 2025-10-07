function fin(responseTxt,responseStat) {
  //alert(responseStat+' - '+responseTxt);
}

// create a new ajaxObject, give it a url it will be calling and
// tell it to call the function "fin" when its got data back from the server.
//var test1 = new ajaxObject('http://someurl.com/server.cgi',fin);
//    test1.update();
               
// create a new ajaxObject, give it a url and tell it to call fin when it
// gets data back from the server.  When we initiate the ajax call we'll
// be passing 'id=user4379' to the server.           
//var test2 = new ajaxObject('http://someurl.com/program.php',fin);
//    test2.update('id=user4379');
               
// create a new ajaxObject but we'll overwrite the callback function inside
// the object to more tightly bind the object with the response hanlder.


// create a new ajaxObject and pass the data to the server (in update) as
// a POST method instead of a GET method.
//var test4 = new ajaxObject('http://someurl.com/postit.cgi', fin);
//   test4.update('coolData=47&userId=user49&log=true','POST'); 


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

function showDeactivateUserInvitationPopup(ar_id,puid)
{
	//startPageLoading();
	link='remote.php?action=showdeactivateuserinvitationpopup&ar_id='+ar_id+'&puid='+puid;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		
		document.getElementById('caption_text').innerHTML = 'User Deactivation'; 
		document.getElementById('prwcontent').innerHTML = result;  
		$(".QTPopup").animate({width: 'show'}, 'slow');
		$(".closeBtn").click(function(){			
			$(".QTPopup").css('display', 'none');
		});
		$("#btnCancelPopup").click(function(){			
			$(".QTPopup").css('display', 'none');
		});
		//stopPageLoading();
	}
}

function showActivateUserInvitationPopup(ar_id,puid)
{
	//startPageLoading();
	link='remote.php?action=showactivateuserinvitationpopup&ar_id='+ar_id+'&puid='+puid;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		
		document.getElementById('caption_text').innerHTML = 'User Activation'; 
		document.getElementById('prwcontent').innerHTML = result;  
		$(".QTPopup").animate({width: 'show'}, 'slow');
		$(".closeBtn").click(function(){			
			$(".QTPopup").css('display', 'none');
		});
		$("#btnCancelPopup").click(function(){			
			$(".QTPopup").css('display', 'none');
		});
		//stopPageLoading();
	}
}

function deactivateUserInvitation(ar_id,puid)
{
	var Choice = confirm("Do you wish to Deactivate User?");
	if (Choice == true)
	{
		var status_reason = escape($("#status_reason").val());
		if(status_reason == '')
		{
			alert('Please enter reason for deactivation');
		}
		else
		{
			link='remote.php?action=deactivateuserinvitation&ar_id='+ar_id+'&puid='+puid+'&status_reason='+status_reason;
			var linkComp = link.split( "?");
			var result;
			var obj = new ajaxObject(linkComp[0], fin);
			obj.update(linkComp[1],"GET");
			obj.callback = function (responseTxt, responseStat) {
				// we'll do something to process the data here.
				result = responseTxt;
				//alert(result);
				$(".QTPopup").css('display', 'none');
				window.location.reload(true);
			}
		}	
	}	
}

function activateUserInvitation(ar_id,puid)
{
	var Choice = confirm("Do you wish to Activate User?");
	if (Choice == true)
	{
		var status_reason = escape($("#status_reason").val());
		if(status_reason == '')
		{
			alert('Please enter reason for activation');
		}
		else
		{
			link='remote.php?action=activateuserinvitation&ar_id='+ar_id+'&puid='+puid+'&status_reason='+status_reason;
			var linkComp = link.split( "?");
			var result;
			var obj = new ajaxObject(linkComp[0], fin);
			obj.update(linkComp[1],"GET");
			obj.callback = function (responseTxt, responseStat) {
				// we'll do something to process the data here.
				result = responseTxt;
				//alert(result);
				$(".QTPopup").css('display', 'none');
				window.location.reload(true);
			}
		}	
	}	
}

function declineUserInvitation(ar_id,puid)
{
	var Choice = confirm("Do you wish to decline invitation request?");
	if (Choice == true)
	{
            var status_reason = escape($("#status_reason").val());
		link='remote.php?action=declineuserinvitation&ar_id='+ar_id+'&puid='+puid+'&status_reason='+status_reason;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			//alert(result);
			window.location.reload(true);
		}
	}	
}

function showDeclineUserInvitationPopup(ar_id,puid)
{
	//startPageLoading();
	link='remote.php?action=showdeclineuserinvitationpopup&ar_id='+ar_id+'&puid='+puid;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		
		document.getElementById('caption_text').innerHTML = 'User Decline'; 
		document.getElementById('prwcontent').innerHTML = result;  
		$(".QTPopup").animate({width: 'show'}, 'slow');
		$(".closeBtn").click(function(){			
			$(".QTPopup").css('display', 'none');
		});
		$("#btnCancelPopup").click(function(){			
			$(".QTPopup").css('display', 'none');
		});
		//stopPageLoading();
	}
}

function doAcceptUserInvitation(ar_id,puid)
{
	
	var Choice = confirm("Do you wish to modify?");
	if (Choice == true)
	{
		link='remote.php?action=doacceptuserinvitation&ar_id='+ar_id+'&puid='+puid;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			//alert(result);
			
			$(".QTPopup").css('display', 'none');
			window.location.reload(true);
			
		}
	
	}
	
	
}

function getUserQueryPageOptions(puid,valreadonly,idval,pgidval)
{
	var uid = $('#'+idval).val();
	link='remote.php?action=getuserquerypageoptions&puid='+puid+'&uid='+uid+'&valreadonly='+valreadonly+'&pgidval='+pgidval;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		document.getElementById('idreference').innerHTML = result;  
	}
}

function sendAdviserPlanRequest()
{
	var ap_id = "";
	var selected = $("input[type='radio'][name='select_ap_id']:checked");
	if (selected.length > 0) {
		ap_id = selected.val();
	}
	//alert(ap_id);
	
	if(ap_id == "")
	{
		alert('Please select any plan');
	}
	else
	{
		link='remote.php?action=sendadviserplanrequest&ap_id='+ap_id;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			//result = responseTxt.split("::::");
			result = responseTxt;
			alert(result);
			window.location = 'subscription_plans.php';
		}
		
	}	
}

function viewAdviserPlans()
{
	//startPageLoading();
	var apct_id = $('#apct_id').val();
	link='remote.php?action=viewadviserplans&apct_id='+apct_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		$('#idviewadviserplans').html(result);
	}
}

function getUserAcceptedReportsOptions(puid)
{
	var uid = document.getElementById('user_id').value;
	link='remote.php?action=getuseracceptedreportsoptions&puid='+puid+'&uid='+uid;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('idreporttype').innerHTML = result;  
	}
}

function getUserAcceptedReportsOptionsNew(puid)
{
    startPageLoading();
    var uid = document.getElementById('user_id').value;
    link='remote.php?action=getuseracceptedreportsoptionsnew&puid='+puid+'&uid='+uid;
    var linkComp = link.split( "?");
    var result;
    var obj = new ajaxObject(linkComp[0], fin);
    obj.update(linkComp[1],"GET");
    obj.callback = function (responseTxt, responseStat) {
        // we'll do something to process the data here.
        result = responseTxt;
        document.getElementById('idreporttype').innerHTML = result;  
        getUserAcceptedReportsSetOptions(puid);
        stopPageLoading();
    }
}

function getUserAcceptedReportsSetOptions(puid)
{
    startPageLoading();
    var uid = document.getElementById('user_id').value;
    var report_module = document.getElementById('report_module').value;
    link='remote.php?action=getuseracceptedreportssetoptions&puid='+puid+'&uid='+uid+'&report_module='+report_module;
    var linkComp = link.split("?");
    var result;
    var obj = new ajaxObject(linkComp[0], fin);
    obj.update(linkComp[1],"GET");
    obj.callback = function (responseTxt, responseStat) {
        // we'll do something to process the data here.
        result = responseTxt;
        document.getElementById('iduserreportset').innerHTML = result;  
        stopPageLoading();
    }
}





function resetReportForm()
{
    $('#divreportresults').hide();
    $('#module_criteria').val('');
    $('#idcriteriascaleshow').hide();
    $('#start_criteria_scale_value').val('');
    $('#end_criteria_scale_value').val('');
    $('#div_start_criteria_scale_value').hide();
    $('#div_end_criteria_scale_value').hide();
    if($('#report_module').val() == 'mdt_report' || $('#report_module').val() == '24')
    {
        $('#trigger_criteria').val('');
        //$('.spntriggercriteria').show('');
        $('.spntriggercriteria').hide('');
    }
    else
    {
        $('#trigger_criteria').val('');
        $('.spntriggercriteria').hide('');
    }
}

function getModuleWiseKeywordsOptions()
{
    $('#divreportresults').hide();
    var report_module = $('#report_module').val();
    var uid = $('#user_id').val();
    var user_set_id = $('#user_set_id').val();
    
    startPageLoading();
    link='remote.php?action=getmodulewisekeywordsoptions&report_module='+report_module+'&uid='+uid+'&user_set_id='+user_set_id;
    var linkComp = link.split( "?");
    var result;
    var obj = new ajaxObject(linkComp[0], fin);
    obj.update(linkComp[1],"GET");
    obj.callback = function (responseTxt, responseStat) {
            // we'll do something to process the data here.
            result = responseTxt;
            $('#tdkeywordresult').html(result);
            stopPageLoading();
    }
}

function getModuleWiseCriteriaOptions()
{
    $('#divreportresults').hide();
    var report_module = $('#report_module').val();
    var user_set_id = $('#user_set_id').val();
    startPageLoading();
    link='remote.php?action=getmodulewisecriteriaoptions&report_module='+report_module+'&user_set_id='+user_set_id;
        var linkComp = link.split( "?");
        var result;
        var obj = new ajaxObject(linkComp[0], fin);
        obj.update(linkComp[1],"GET");
        obj.callback = function (responseTxt, responseStat) {
                // we'll do something to process the data here.
                result = responseTxt;
                $('#tdcriteriaresult').html(result);
                stopPageLoading();
        }
}

function getModuleWiseCriteriaScaleOptions()
{
    $('#divreportresults').hide();
    var report_module = $('#report_module').val();
    var user_set_id = $('#user_set_id').val();
    var uid = $('#user_id').val();
    var module_criteria = $('#module_criteria').val();
    startPageLoading();
    link='remote.php?action=getmodulewisecriteriascaleoptions&report_module='+report_module+'&user_set_id='+user_set_id+'&module_criteria='+module_criteria+'&uid='+uid;
        var linkComp = link.split( "?");
        var result;
        var obj = new ajaxObject(linkComp[0], fin);
        obj.update(linkComp[1],"GET");
        obj.callback = function (responseTxt, responseStat) {
                // we'll do something to process the data here.
                result = responseTxt;
                //alert(result);
                $('#tdcriteriascalerange').html(result);
                if(module_criteria == '9' && report_module == 'mdt_report')
                {
                    $('.spntriggercriteria').show();
                }
                else
                {
                    $('.spntriggercriteria').hide();
                    $('#trigger_criteria').val('');
                }
                stopPageLoading();
        }
}

function getModuleWiseCriteriaScaleValues()
{
    $('#divreportresults').hide();
    var report_module = $('#report_module').val();
    var user_set_id = $('#user_set_id').val();
    var uid = $('#user_id').val();
    var module_criteria = $('#module_criteria').val();
    var criteria_scale_range = $('#criteria_scale_range').val();
    
    startPageLoading();
    link='remote.php?action=getmodulewisecriteriascalevalues&module_criteria='+module_criteria+'&report_module='+report_module+'&user_set_id='+user_set_id+'&criteria_scale_range='+criteria_scale_range+'&uid='+uid;
        var linkComp = link.split( "?");
        var result;
        var obj = new ajaxObject(linkComp[0], fin);
        obj.update(linkComp[1],"GET");
        obj.callback = function (responseTxt, responseStat) {
                // we'll do something to process the data here.
                result = responseTxt;
                $('#idcriteriascalevalues').html(result);
                stopPageLoading();
        }
}

function toggleScaleShow()
{
    $('#divreportresults').hide();
    var report_module = $('#report_module').val();
    if (report_module == "" || report_module == "1" || report_module == "14" || report_module == "22" || report_module == "4" || report_module == "5") 
    {
        $('#idscaleshow').hide();
    }
    else 
    { 	
        $('#idscaleshow').show();
    }
}

function toggleCriteriaScaleShow()
{
    $('#divreportresults').hide();
    var module_criteria = $('#module_criteria').val();
    if (module_criteria == "") 
    {
        $('#idcriteriascaleshow').hide();
    }
    else 
    { 	
        $('#idcriteriascaleshow').show();
    }
}



function toggleScaleRangeType(id_val,div_start_val,div_end_val)
{
    $('#divreportresults').hide();
    var scale_type = $('#'+id_val).val();
    if (scale_type == "") 
    { 	
        $('#'+div_start_val).hide();
        $('#'+div_end_val).hide();
    }
    else if (scale_type == "6") 
    { 	
        $('#'+div_start_val).show();
        $('#'+div_end_val).show();
    }
    else 
    { 
        $('#'+div_start_val).show();
        $('#'+div_end_val).hide();
    }

}

function getUserTriggerCriteriaOptions()
{
    $('#divreportresults').hide();
    //var report_module = $('#report_module').val();
    //var user_set_id = $('#user_set_id').val();
    var uid = $('#user_id').val();
    //var module_criteria = $('#module_criteria').val();
    //var criteria_scale_range = $('#criteria_scale_range').val();
    
    startPageLoading();
    link='remote.php?action=getusertriggercriteriaoptions&uid='+uid;
    var linkComp = link.split( "?");
    var result;
    var obj = new ajaxObject(linkComp[0], fin);
    obj.update(linkComp[1],"GET");
    obj.callback = function (responseTxt, responseStat) {
            // we'll do something to process the data here.
            result = responseTxt;
            $('#idtriggercriteria').html(result);
            stopPageLoading();
    }
}


function toggleDateSelectionTypeUser(id_val)
{

	var date_type = document.getElementById(id_val).value;
	if (date_type == "date_range") 
	{ 	
            document.getElementById('tbldaterange').style.display = '';
            document.getElementById('tblsingledate').style.display = 'none';
            document.getElementById('tblmonthdate').style.display = 'none';
	}
	else if (date_type == "single_date") 
	{ 	
            document.getElementById('tbldaterange').style.display = 'none';
            document.getElementById('tblsingledate').style.display = '';
            document.getElementById('tblmonthdate').style.display = 'none';
	}
	else if (date_type == "month_wise") 
	{ 	
            document.getElementById('tbldaterange').style.display = 'none';
            document.getElementById('tblsingledate').style.display = 'none';
            document.getElementById('tblmonthdate').style.display = '';
	}
}


function selectPopupLocation(idval)
{
	var country_id = $('#popup_country_id').val();
	var state_id = $('#popup_state_id').val();
	var city_id = $('#popup_city_id').val();
	var place_id = $('#popup_place_id').val();
	
	$('#hdncountry_id_'+idval).val(country_id);
	$('#hdnstate_id_'+idval).val(state_id);
	$('#hdncity_id_'+idval).val(city_id);
	$('#hdnplace_id_'+idval).val(place_id);
	
	link='remote.php?action=selectpopuplocation&country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&place_id='+place_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		$('#service_location_'+idval).val(result);
		$(".QTPopup").css('display', 'none');
	}
}	

function getStateOptionsPopup(state_id)
{
	var country_id = document.getElementById('popup_country_id').value;
	link='remote.php?action=getstateoptionspopup&country_id='+country_id+'&state_id='+state_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('tdpopupstate').innerHTML = result;  
		getCityOptionsPopup('')
	}
}

function getCityOptionsPopup(city_id)
{
	var state_id = document.getElementById('popup_state_id').value;
	link='remote.php?action=getcityoptionspopup&state_id='+state_id+'&city_id='+city_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('tdpopupcity').innerHTML = result;  
		getPlaceOptionsPopup('');
	}
}

function getPlaceOptionsPopup(place_id)
{
	var state_id = document.getElementById('popup_state_id').value;
	var city_id = document.getElementById('popup_city_id').value;
	link='remote.php?action=getplaceoptionspopup&state_id='+state_id+'&city_id='+city_id+'&place_id='+place_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('tdpopupplace').innerHTML = result;  
	}
}

function showLocationPopup(idval)
{
	var country_id = $('#hdncountry_id_'+idval).val();
	var state_id = $('#hdnstate_id_'+idval).val();
	var city_id = $('#hdncity_id_'+idval).val();
	var place_id = $('#hdnplace_id_'+idval).val();
	//startPageLoading();
	link='remote.php?action=showlocationpopup&country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&place_id='+place_id+'&idval='+idval;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		
		document.getElementById('caption_text').innerHTML = 'Select Location'; 
		document.getElementById('prwcontent').innerHTML = result;  
		$(".QTPopup").animate({width: 'show'}, 'slow');
		$(".closeBtn").click(function(){			
			$(".QTPopup").css('display', 'none');
		});
		//stopPageLoading();
	}
}

function showRoundIcon(idval)
{
	$('#roundicon_'+idval).show();
}

function hideRoundIcon(idval)
{
	$('#roundicon_'+idval).hide();
}

function toggleReadUnreadQuery(idval)
{
	var tgaction = $('#hdntoggle_action_'+idval).val();
	link='remote.php?action=togglereadunreadquery&tgaction='+tgaction+'&idval='+idval;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		
		if(tgaction == 'read')
		{
			$('#td1id_'+idval).removeClass("qryunread");
			$('#td2id_'+idval).removeClass("qryunread");
			$('#td3id_'+idval).removeClass("qryunread");
			$('#td4id_'+idval).removeClass("qryunread");
			$('#td5id_'+idval).removeClass("qryunread");
			$('#td6id_'+idval).removeClass("qryunread");
			
			$('#td1id_'+idval).addClass("qryread");
			$('#td2id_'+idval).addClass("qryread");
			$('#td3id_'+idval).addClass("qryread");
			$('#td4id_'+idval).addClass("qryread");
			$('#td5id_'+idval).addClass("qryread");
			$('#td6id_'+idval).addClass("qryread");
			
			$('#hdntoggle_action_'+idval).val('unread');
		}
		else if(tgaction == 'unread')
		{
			$('#td1id_'+idval).removeClass("qryread");
			$('#td2id_'+idval).removeClass("qryread");
			$('#td3id_'+idval).removeClass("qryread");
			$('#td4id_'+idval).removeClass("qryread");
			$('#td5id_'+idval).removeClass("qryread");
			$('#td6id_'+idval).removeClass("qryread");
			
			$('#td1id_'+idval).addClass("qryunread");
			$('#td2id_'+idval).addClass("qryunread");
			$('#td3id_'+idval).addClass("qryunread");
			$('#td4id_'+idval).addClass("qryunread");
			$('#td5id_'+idval).addClass("qryunread");
			$('#td6id_'+idval).addClass("qryunread");
			
			$('#hdntoggle_action_'+idval).val('read');
		}
		else
		{
		
		}
	}
}

function replyUserQuery()
{
	var parent_aq_id = document.getElementById('hdnparent_aq_id').value;
	var temp_user_id = document.getElementById('hdntemp_user_id').value;
	var temp_pro_user_id = document.getElementById('hdntemp_pro_user_id').value;
	var temp_page_id = document.getElementById('hdntemp_page_id').value;
	var name = document.getElementById('hdnname').value;
	var email = document.getElementById('hdnemail').value;
	var query = escape(document.getElementById('feedback').value);
	
	if(query == '')
	{
		alert('Please Enter Query!');	
	}
	else
	{
		link='remote.php?action=replyuserquery&parent_aq_id='+parent_aq_id+'&temp_pro_user_id='+temp_pro_user_id+'&temp_user_id='+temp_user_id+'&temp_page_id='+temp_page_id+'&name='+name+'&email='+email+'&query='+query;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt.split("::");
			//alert(responseTxt);
			if(result[0] == '1' || result[0] == '2')
			{
				alert(result[1]);
				if(result[0] == '2')
				{
					$(".QTPopup").css('display', 'none');
					//var main_page_id = document.getElementById('main_page_id').value;
					//if(main_page_id == '47' || main_page_id == '46')
					//{
						window.location.reload(true);
					//}
				}
			}
		}
	}
}

function showUserQueryPopup(parent_aq_id)
{
	//startPageLoading();
	link='remote.php?action=showuserquerypopup&parent_aq_id='+parent_aq_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		
		document.getElementById('caption_text').innerHTML = 'My Reply'; 
		document.getElementById('prwcontent').innerHTML = result;  
		$(".QTPopup").animate({width: 'show'}, 'slow');
		$(".closeBtn").click(function(){			
			$(".QTPopup").css('display', 'none');
		});
		//stopPageLoading();
	}
}

function getStateOptionsMulti()
{
	var country_id = document.getElementById('country_id').value;
		
	link='remote.php?action=getstateoptionsmulti&country_id='+country_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('tdstate').innerHTML = result;  
		getCityOptionsMulti();
	}
	
}

function getCityOptionsMulti()
{
	var country_id = document.getElementById('country_id').value;
	var obj_state_id = document.getElementById('state_id');
	var str_state_id = "";
	
	for (var x=0;x<obj_state_id.length;x++)
	{
		if (obj_state_id[x].selected)
		{
			str_state_id = str_state_id + obj_state_id[x].value + "," ;
		}
	}
	//alert(str_state_id);
	
	link='remote.php?action=getcityoptionsmulti&country_id='+country_id+'&state_id='+str_state_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('tdcity').innerHTML = result;  
		getPlaceOptionsMulti();
	}
	
}

function getPlaceOptionsMulti()
{
	var country_id = document.getElementById('country_id').value;
	var obj_state_id = document.getElementById('state_id');
	var str_state_id = "";
	var obj_city_id = document.getElementById('city_id');
	var str_city_id = "";
	
	for (var x=0;x<obj_state_id.length;x++)
	{
		if (obj_state_id[x].selected)
		{
			str_state_id = str_state_id + obj_state_id[x].value + "," ;
		}
	}
	
	for (var x=0;x<obj_city_id.length;x++)
	{
		if (obj_city_id[x].selected)
		{
			str_city_id = str_city_id + obj_city_id[x].value + "," ;
		}
	}
	
	link='remote.php?action=getplaceoptionsmulti&country_id='+country_id+'&state_id='+str_state_id+'&city_id='+str_city_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('tdplace').innerHTML = result;  
	}
	
}

function toggleDateSelectionType(id_val)
{
	var sc_listing_date_type = document.getElementById(id_val).value;
	if (sc_listing_date_type == "days_of_month") 
	{ 	
	    document.getElementById('tr_days_of_month').style.display = '';
		document.getElementById('tr_single_date').style.display = 'none';
		document.getElementById('tr_date_range').style.display = 'none';
	}
	else if (sc_listing_date_type == "single_date") 
	{ 	
	   	document.getElementById('tr_days_of_month').style.display = 'none';
		document.getElementById('tr_single_date').style.display = '';
		document.getElementById('tr_date_range').style.display = 'none';
	}
	else if (sc_listing_date_type == "date_range") 
	{ 	
	  	document.getElementById('tr_days_of_month').style.display = 'none';
		document.getElementById('tr_single_date').style.display = 'none';
		document.getElementById('tr_date_range').style.display = '';
	}
}

function viewUsersSelectionPopup()
{
	var obj_user_id = document.getElementById('user_id');
	var str_user_id = "";
	
	for (var x=0;x<obj_user_id.length;x++)
	{
		if (obj_user_id[x].selected)
		{
			str_user_id = str_user_id + obj_user_id[x].value + "," ;
		}
	}
	//startPageLoading();
	link='remote.php?action=viewusersselectionpopup&str_user_id='+str_user_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		
		document.getElementById('caption_text').innerHTML = 'Select Users'; 
		document.getElementById('prwcontent').innerHTML = result;
		
		$('.QTPopupCntnr').css('width','1100px');
		$('.QTPopupCntnr').css('left','8%');
		$('.QTPopupCntnr').css('top','30%');
		$('.QTPopupCntnr').css('margin-left','0px');
		$('.gpBdrRight').css('height','600px');
		
		
		$(".QTPopup").animate({width: 'show'}, 'slow');
		$(".closeBtn").click(function(){			
			$(".QTPopup").css('display', 'none');
		});
		//stopPageLoading();
	}
}

function SetSelectedUsers()
{
	var checkValues = $('input:checkbox[name="selected_user_id"]:checked').map(function() {																   
			return $(this).val();
		}).get();
	
	var str_uid = String(checkValues);
	//alert(str_uid);
	var arr_uid = str_uid.split(",");
	$(".QTPopup").css('display', 'none');
	$("#user_id").val(arr_uid);
}

function toggleCheckBoxes(id_val)
{
	if($("#all_"+id_val).attr("checked")== 'checked')
	{
		$("input[id^='"+id_val+"_']").attr("checked", true);
	}
	else
	{
		$("input[id^='"+id_val+"_']").removeAttr("checked");
	}
}

function removeRows(tid)
{
	
	if( (tid != '') )
	{
		//alert(tid);
		var totalRow = parseInt($('#hdnrow_totalRow').val());
		totalRow = totalRow - 1;       
							
		$('#hdnrow_totalRow').val(totalRow);
		
		$('#row_id_1_'+tid).remove();
		$('#row_id_2_'+tid).remove();
		$('#row_id_3_'+tid).remove();
		$('#row_id_4_'+tid).remove();
		$('#row_id_5_'+tid).remove();
		$('#row_id_6_'+tid).remove();
		$('#row_id_7_'+tid).remove();
		$('#row_id_8_'+tid).remove();
		$('#tr_row_'+tid).remove();
	}
}

function removeMultipleRows(clsval,idval_totalrows)
{
	var totalRow = parseInt($('#'+idval_totalrows).val());
	totalRow = totalRow - 1;       
	$('#'+idval_totalrows).val(totalRow);
	$('.'+clsval).remove();
}

function getStateOptions(state_id)
{
	var country_id = document.getElementById('country_id').value;
	link='remote.php?action=getstateoptions&country_id='+country_id+'&state_id='+state_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('tdstate').innerHTML = result;  
	}
}

function getDestinationOptions(destination_id)
{
	var country_id = document.getElementById('country_id').value;
	link='remote.php?action=getdestinationoptions&country_id='+country_id+'&destination_id='+destination_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('tddestination').innerHTML = result;  
	}
}


function showMonthWiseRewardChart()
{
	if($('#btnShowMonthWiseChart').val() == 'Show Monthwise Chart')
	{
		$('#idmonthwisechart').show();	
		//$('#btnShowMonthWiseChart').val() = 'Hide Monthwise Chart';
		$("#btnShowMonthWiseChart").attr('value', 'Hide Monthwise Chart');
	}
	else
	{
		$('#idmonthwisechart').hide();	
		//$('#btnShowMonthWiseChart').val() = 'Show Monthwise Chart';
		$("#btnShowMonthWiseChart").attr('value', 'Show Monthwise Chart');
	}
}

function imagePreview(){	
			/* CONFIG */
			
			xOffset = 200;
			yOffset = -700;
			
			// these 2 variable determine popup's distance from the cursor
			// you might want to adjust to get the right result
			
		/* END CONFIG */
		$("a.preview").hover(function(e){
			this.t = this.title;
			this.title = "";	
			var c = (this.t != "") ? "<br/>" + this.t : "";
			$("body").append("<p id='preview'><img width='600' src='"+ this.href +"' alt='Image preview' />"+ c +"</p>");								 
			$("#preview")
				.css("top",(e.pageY - xOffset) + "px")
				.css("left",(e.pageX + yOffset) + "px")
				.css("z-index","1300")
				.fadeIn("fast");						
		},
		function(){
			this.title = this.t;	
			$("#preview").remove();
		});	
		$("a.preview").mousemove(function(e){
			$("#preview")
				.css("top",(e.pageY - xOffset) + "px")
				.css("left",(e.pageX + yOffset) + "px");
		});			
}

function showRewardCatlog()
{
	startPageLoading();
	link='remote.php?action=showrewardcatlog';
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		
		document.getElementById('caption_text').innerHTML = 'Rewards Catlog'; 
		document.getElementById('prwcontent').innerHTML = result;  
		$(".QTPopup").animate({width: 'show'}, 'slow');
		$(".closeBtn").click(function(){			
			$(".QTPopup").css('display', 'none');
		});
		imagePreview();
		stopPageLoading();
	}
}

function viewEntriesDetailsList(start_date,end_date,reward_module_id,reward_module_title)
{
	startPageLoading();
	link='remote.php?action=viewentriesdetailslist&start_date='+start_date+'&end_date='+end_date+'&reward_module_id='+reward_module_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		
		document.getElementById('caption_text').innerHTML = 'Rewards Entries List - '+reward_module_title; 
		document.getElementById('prwcontent').innerHTML = result;  
		$(".QTPopup").animate({width: 'show'}, 'slow');
		$(".closeBtn").click(function(){			
			$(".QTPopup").css('display', 'none');
		});
		stopPageLoading();
	}
}

function addScrollingContentToFav(str_sc_id)
{
	
	//var submitme = false;
		
	//$('.scrolling_content_radio').each(function() { // loop through each radio button
	//	nam = $(this).attr('name'); // get the name of its set
	//	if ($(':radio[name="'+nam+'"]:checked').length) { 
	//		submitme = true;
	//	}
	//});
	
	//if(!submitme)
	//{
	//	alert('Please select any option to add as fav');
	//}
	//else
	//{
		var page_id = $('#hdnpage_id').val();
		//var str_sc_id = $.map($(".scrolling_content_radio:checked"), function(elem, idx) {
		//	  return $(elem).val();
		//}).join(',');
	
		
		link='remote.php?action=addscrollingcontenttofav&page_id='+page_id+'&str_sc_id='+str_sc_id;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt.split("::::");
			alert(result[1]);
		}
	//}
	
	//return false;
}
/*  amol function start */  



function ChangeTheam()
{
	var theam_id = document.getElementById('theam_id').value;
	//alert(theam_id);
	link='remote.php?action=changtheam&theam_id='+theam_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt.split("::");
		$('#bgimage').css("background-image", "url("+result[0]+")");
		$('#color_code').css("background-color", result[1]); 
	}
}

function ChangeTheam2()
{
	var theam_id = document.getElementById('theam_id2').value;
	//alert(theam_id);
	link='remote.php?action=changtheam&theam_id='+theam_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt.split("::");
		$('#bgimage').css("background-image", "url("+result[0]+")");
		$('#color_code').css("background-color", result[1]); 
	}
}

function ChangeTheam3()
{
	var theam_id = document.getElementById('theam_id3').value;
	//alert(theam_id);
	link='remote.php?action=changtheam&theam_id='+theam_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt.split("::");
		$('#bgimage').css("background-image", "url("+result[0]+")");
		$('#color_code').css("background-color", result[1]); 
	}
}

function GetOnKeyUpBanner()
{
	var select_title = document.getElementById('select_title').value;
	link='remote.php?action=getonkeyupbanner&select_title='+select_title;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		document.getElementById('disply_banner1').innerHTML = '';  
		document.getElementById('disply_banner1').style.display = 'none';  
		document.getElementById('tdslider').innerHTML = result;  
			$('#slider').bxSlider({
				auto : true,
				autoConrols : true
			});
	}
}

function OnChangeGetShortNarration()
{
	
	var select_title = document.getElementById('select_title').value;
	var short_narration = document.getElementById('short_narration').value;
	//alert(short_narration);
	//alert(select_title);
	link='remote.php?action=onchangegetshortnarration&short_narration='+short_narration+'&select_title='+select_title;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		document.getElementById('disply_banner1').innerHTML = '';  
		document.getElementById('disply_banner1').style.display = 'none';  
		document.getElementById('tdslider').innerHTML = result;  
			$('#slider').bxSlider({
				auto : true,
				autoConrols : true
			});
	}
}



function GetShortNarration(short_narration)
{
	var select_title = document.getElementById('select_title').value;
	//alert(short_narration);
	link='remote.php?action=getshortnarration&select_title='+select_title+'&short_narration='+short_narration;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		document.getElementById('narration').innerHTML = result;  
	}
}

function getTitleComments()
{
	var select_title = document.getElementById('select_title').value;
	var short_narration = document.getElementById('short_narration').value;
	link='remote.php?action=gettitlecomments&select_title='+select_title+'&short_narration='+short_narration;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		document.getElementById('Allcomment').innerHTML = result;  
	}
}

/*function getNarrationComments()
{
	var select_title = document.getElementById('select_title').value;
	var short_narration = document.getElementById('short_narration').value;
	link='remote.php?action=getnarrationcomments&select_title='+select_title+'&short_narration='+short_narration;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		document.getElementById('Allcomment').innerHTML = result;  
	}
}*/

function PassParentID(feedback_id,page_id)
{
	 document.getElementById('hdn_p_id').value = feedback_id;
	  document.getElementById('temp_page_id').value = page_id;
	  //alert(page_id);
	  $(".btnReply").click(function(){
				if(feedback_id > 0)
					{	
						$("#temp_page_id").attr("disabled", true);	
					}
					$(".QTPopup").animate({width: 'show'}, 'slow');
			});	
	  
	  $(".closeBtn").click(function(){			
				$(".QTPopup").css('display', 'none');
				
				
			});
}

function MakeNoteForFavList(ufs_id,page_id)
{
	  	link='remote.php?action=makenoteforfavlist&ufs_id='+ufs_id+'&page_id='+page_id;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			//alert(result);
			document.getElementById('caption_text').innerHTML = 'Make Note'; 
			document.getElementById('prwcontent').innerHTML = result;  
			
		}
		
	  $(".QTPopup").animate({width: 'show'}, 'slow');
	  
	  $(".closeBtn").click(function(){			
				$(".QTPopup").css('display', 'none');
			});
	  
}

function Save_Note_FavList(ufs_id)
{
	var note = escape(document.getElementById('note').value);
	var ufs_cat_id = document.getElementById('ufs_cat_id2').value;
	var ufs_priority = document.getElementById('ufs_priority').value;
	//alert(note);
	if(note == '')
	{
		alert('Please enter note');
	}
	else
	{
		link='remote.php?action=save_note_favlist&ufs_id='+ufs_id+'&note='+note+'&ufs_cat_id='+ufs_cat_id+'&ufs_priority='+ufs_priority;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			//alert(result);
			if(result == '1')
			{
				alert('Your note successfully saved');	
				$(".QTPopup").css('display', 'none');
				//window.location.reload(true);
				Search_MyFavList();
			}
		}
	}
}

function MakeNote(library_id,page_id)
{
	  	link='remote.php?action=makenote&library_id='+library_id+'&page_id='+page_id;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			//alert(result);
			document.getElementById('caption_text').innerHTML = 'Make Note'; 
			document.getElementById('prwcontent').innerHTML = result;  
			
		}
		
	  $(".QTPopup").animate({width: 'show'}, 'slow');
	  
	  $(".closeBtn").click(function(){			
				$(".QTPopup").css('display', 'none');
			});
	  
}



function Library_Feedback(page_id)
{
	
	link='remote.php?action=library_feedback&page_id='+page_id;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			//alert(result);
			document.getElementById('caption_text').innerHTML = 'Feedback and Suggestions'; 
			document.getElementById('prwcontent').innerHTML = result;  
				
			}
}



function Save_Note(library_id)
{
	//alert(library_id);
	var note = document.getElementById('note').value;
	//alert(note);
	if(note == '')
	{
		alert('Please enter note');
	}
	else
	{
		link='remote.php?action=save_note&library_id='+library_id+'&note='+note;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			//alert(result);
			if(result)
			{
				alert('Your note successfully saved');	
				$(".QTPopup").css('display', 'none');
				window.location.reload(true);
			}
		}
	}
}


function GetFeedback()
{
	var page_id = document.getElementById('temp_page_id').value;
	var name = document.getElementById('name').value;
	var email = document.getElementById('email').value;
	var feedback = escape(document.getElementById('feedback').value);
	//var feedback = document.getElementById('feedback').value;
	var hdn_p_id = document.getElementById('hdn_p_id').value;
	//alert (hdn_p_id);
	if(hdn_p_id == '')
	{
	  hdn_p_id = '0';	
	} 
	
	if(page_id == '')
	{
	 alert('Please Select Page!');	
	} 
		else if(name == '')
		{
		 alert('Please Enter Name!');	
		}
		else if(email == '')
		{
		 alert('Please Enter Email!');	
		}
		else if(feedback == '')
		{
		 alert('Please Enter Feedback!');	
		}
	else
		{
			link='remote.php?action=getfeedback&page_id='+page_id+'&name='+name+'&email='+email+'&feedback='+feedback+'&parent_id='+hdn_p_id;
			var linkComp = link.split( "?");
			var result;
			var obj = new ajaxObject(linkComp[0], fin);
			obj.update(linkComp[1],"GET");
			obj.callback = function (responseTxt, responseStat) {
				// we'll do something to process the data here.
				result = responseTxt.split("::");
				//alert(responseTxt);
				if(result[0] == '1' || result[0] == '2')
				{
					alert(result[1]);
					if(result[0] == '2')
					{
						$(".QTPopup").css('display', 'none');
						var main_page_id = document.getElementById('main_page_id').value;
						if(main_page_id == '47' || main_page_id == '46')
						{
						window.location.reload(true);
						}
					}
				}
		}
	}
}


function PostComment()
{
	var comment_box = document.getElementById('comment_box').value;
	var select_title = document.getElementById('select_title').value;
	var short_narration = document.getElementById('short_narration').value;
	var ref = document.getElementById('hdnref').value;
	if(comment_box == '')
	{
	 alert('Please Enter Your Opinion !');	
	} 
	else if(select_title == '')
	{
	 alert('Please Select Title !');	
	}
	else if(short_narration == '')
	{
	 alert('Please Select Narration !');	
	}
	else
	{
		link='remote.php?action=postcomment&comment_box='+comment_box+'&select_title='+select_title+'&short_narration='+short_narration;
	
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		//result = responseTxt;
		//alert(responseTxt);
			result = responseTxt.split("::");
			if(result[0])
			{
				window.location = "login.php?ref="+result[1];
			}
			else
			{
				document.getElementById('Allcomment').innerHTML = result[1]; 
				document.getElementById('comment_box').value = ''; 
			}
		}
	}
}

function getAllPDF()
{
	var select_title = document.getElementById('select_title').value;
	var short_narration = document.getElementById('short_narration').value;
	link='remote.php?action=getallpdf&select_title='+select_title+'&short_narration='+short_narration;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		//alert(result);
		document.getElementById('pdf_result').innerHTML = result;  
	}
}

function Search_MyFavList()
{
	var pg_id = document.getElementById('pg_id').value;
	var start_date = document.getElementById('start_date').value;
	var end_date = document.getElementById('end_date').value;
	var ufs_cat_id = document.getElementById('ufs_cat_id').value;
	
	if(start_date == '')
	{
		alert('Please select start date');
	}
	else if(end_date == '')
	{
		alert('Please select end date');
	}
	else 
	{
		link='remote.php?action=search_myfavlist&pg_id='+pg_id+'&start_date='+start_date+'&end_date='+end_date+'&ufs_cat_id='+ufs_cat_id;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			//alert(result);
			result = responseTxt.split("::");
			
			if(result[1] == 1)
			{
				alert(result[2]);
			}
			else
			{
				//alert(result[3]);
				
				document.getElementById('Search_MyFavList').innerHTML = result[3];  
			}
		}
	}	
}

function Delete_MyFavItem(ufs_id)
{
	//alert(library_id);
	if(confirm('Are you sure to delete this record'))
	{
		link='remote.php?action=delete_myfavitem&ufs_id='+ufs_id;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			//alert(result);
			//window.location.reload(true);
			Search_MyFavList();
			
		}
	}
}

function Search_Library()
{
	var page_id = document.getElementById('page_id').value;
	var day = document.getElementById('day').value;
	var month = document.getElementById('month').value;
	var year = document.getElementById('year').value;
	//alert(page_id);
		link='remote.php?action=search_library&page_id='+page_id+'&day='+day+'&month='+month+'&year='+year;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			//alert(result);
			result = responseTxt.split("::");
			
			if(result[0] == 1)
			{
				alert(result[1]);
			}
			else
			{
				//alert(result[2]);
				
				document.getElementById('Search_Library').innerHTML = result[2];  
			}
		}
	
}

function PDF_Library(page_id)
{
	 var values = $('input:checkbox:checked.chk_pdf').map(function () {
		  return this.value;
			}).get();
	if(values == '')
		{
			alert('Please select PDF');	
		}
	else
	{	
		link='remote.php?action=pdflibrary&page_id='+page_id+'&values='+values;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			result = responseTxt.split("::");
			//alert(result);
			if(result[1] == 1)
			{
				alert('Please login to save PDF File');	
			}
			else
			{
				if(result[0] == 1)
				{
					alert('Selected PDF successfully saved to your library');	
				}
				else
				{
					alert('Your details already saved');	
				}
			}
		}
	}
}

function Delete_libraryPDF(library_id)
{
	//alert(library_id);
	if(confirm('Are you sure to delete this record'))
	{
		link='remote.php?action=delete_librarypdf&library_id='+library_id;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			//alert(result);
			window.location.reload(true);
			
		}
	}
}


function PlayAngerventsound(sound_clip_id)
{
	//var sound_clip_id = document.getElementById('sound_clip_id').value;
	//alert('aaaaaaaaaaaaaaaaaaaa');
	link='remote.php?action=getangerventsoundclip&sound_clip_id='+sound_clip_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('playmusic').innerHTML = result;  
	}
}


function PlayMindjumblesound(sound_clip_id)
{
	//var sound_clip_id = document.getElementById('sound_clip_id').value;
	//alert('aaaaaaaaaaaaaaaaaaaa');
	link='remote.php?action=getmindjumblesoundclip&sound_clip_id='+sound_clip_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('playmusic').innerHTML = result;  
	}
}

function Playsound(sound_clip_id)
{
	//var sound_clip_id = document.getElementById('sound_clip_id').value;
	//alert('aaaaaaaaaaaaaaaaaaaa');
	link='remote.php?action=getsoundclip&sound_clip_id='+sound_clip_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('playmusic').innerHTML = result;  
	}
}
function checkIt(el)
{
	if (el.value == "other medium") 
	{
		document.getElementById('text1').style.display = 'none';
		document.getElementById('text').style.display = '';
	}
	if(el.value == "user" || el.value == "other wellness Guide")
	{
		document.getElementById('text1').style.display = '';
		document.getElementById('text').style.display = 'none';
	}
}

function HideRateIt()
	{
		alert('amol');
		//$('input.wow').attr("disabled", true);
		
		}
		
function BannerBox()
{
	var banner_type = document.getElementById('banner_type').value;
	
	
	if (banner_type == " ") 
	{ 	
	    document.getElementById('trfile').style.display = '';
		document.getElementById('trtext').style.display = '';
	}
	if (banner_type == "Video") 
	{ 	
	   document.getElementById('trtext').style.display = '';
	   document.getElementById('trfile').style.display = 'none';
	}
	if(banner_type == "Image" || banner_type == "Flash" || banner_type == "Audio")
	{
		document.getElementById('trtext').style.display = 'none';
		document.getElementById('trfile').style.display = '';
	}
}

function BannerBox1(idval)
{
	var user_banner_type = document.getElementById('user_banner_type'+idval).value;
   
	if (user_banner_type == " ") 
	{ 	
	    document.getElementById('user_trfile'+idval).style.display = '';
		document.getElementById('user_trtext'+idval).style.display = '';
	}
	else if(user_banner_type == "Video") 
	{ 	
	   document.getElementById('user_trtext'+idval).style.display = '';
	   document.getElementById('user_trfile'+idval).style.display = 'none';
	}
	else if(user_banner_type == "Image" || user_banner_type == "Flash" || user_banner_type == "Audio" || user_banner_type == "PDF")
	{
		document.getElementById('user_trtext'+idval).style.display = 'none';
		document.getElementById('user_trfile'+idval).style.display = '';
		
		if(user_banner_type == "Image")
		{
			document.getElementById('user_file_type_msg'+idval).innerHTML = 'Please upload jpg/gif image';	
		}
		else if(user_banner_type == "Flash")
		{
			document.getElementById('user_file_type_msg'+idval).innerHTML = 'Please upload swf file';	
		}
		else if(user_banner_type == "Audio")
		{
			document.getElementById('user_file_type_msg'+idval).innerHTML = 'Please upload mp3/wav/mid file';	
		}
		else if(user_banner_type == "PDF")
		{
			document.getElementById('user_file_type_msg'+idval).innerHTML = 'Please upload only pdf file';	
		}
	}
}



function Display_Banner(idval)
{
	var banner_id = $('input:radio[name=select_banner'+idval+']:checked').val();
	
	link='remote.php?action=display_banner&banner_id='+banner_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		
		document.getElementById('disply_banner'+idval).style.display = '';
		document.getElementById('disply_banner'+idval).innerHTML = result;  
		
	}
}

function Display_Angervent_Banner(idval)
{
	var banner_id = $('input:radio[name=select_banner'+idval+']:checked').val();
	//alert(banner_id);
	link='remote.php?action=display_angervent_banner&banner_id='+banner_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		
		document.getElementById('disply_banner'+idval).style.display = '';
		document.getElementById('disply_banner'+idval).innerHTML = result;  
		
	}
}

function Display_MindJumble_Banner(idval)
{
	var banner_id = $('input:radio[name=select_banner'+idval+']:checked').val();
	//alert(banner_id);
	link='remote.php?action=display_mindjumble_banner&banner_id='+banner_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		
		document.getElementById('disply_banner'+idval).style.display = '';
		document.getElementById('disply_banner'+idval).innerHTML = result;  
		
	}
}

/* amol function ends*/

function removeRow(tid)
{
	if(tid != '')
	{
		var totalRow = parseInt($('#totalRow').val());
		totalRow = totalRow - 1;       
		$('#totalRow').val(totalRow);
		
		$('#tr1_'+tid).remove();
		$('#tr2_'+tid).remove();
		$('#tr3_'+tid).remove();
		$('#tr4_'+tid).remove();
		$('#tr5_'+tid).remove();
		$('#tr6_'+tid).remove();
		$('#tr7_'+tid).remove();
		$('#tr8_'+tid).remove();
		$('#tr9_'+tid).remove();
		$('#tr10_'+tid).remove();
	}
}

function toggleOtherActivity(tid,obj)
{
	if(tid != '')
	{
		var activity_id = obj.value; 
		if(activity_id == '0')
		{
			$('#tr3_'+tid).show();	
			$('#tr4_'+tid).hide();
		}
		else
		{
			$('#tr3_'+tid).hide();	
			$('#tr4_'+tid).show();
		}
	}
}

function removeMealRow(meal_type,tid)
{
	if( (tid != '') && (meal_type != '') )
	{
		var totalRow = parseInt($('#'+meal_type+'_totalRow').val());
		totalRow = totalRow - 1;       
		$('#'+meal_type+'_totalRow').val(totalRow);
		
		$('#tr_'+meal_type+'_1_'+tid).remove();
		$('#tr_'+meal_type+'_2_'+tid).remove();
		$('#tr_'+meal_type+'_3_'+tid).remove();
		$('#tr_'+meal_type+'_4_'+tid).remove();
		$('#tr_'+meal_type+'_5_'+tid).remove();
		$('#tr_'+meal_type+'_6_'+tid).remove();
		$('#tr_'+meal_type+'_7_'+tid).remove();
		$('#tr_'+meal_type+'_8_'+tid).remove();
		$('#tr_'+meal_type+'_9_'+tid).remove();
	}
}




function addslashes(str) 
{
	str=str.replace(/\\/g,'\\\\');
	str=str.replace(/\'/g,'\\\'');
	str=str.replace(/\"/g,'\\"');
	str=str.replace(/\0/g,'\\0');
	return str;
}

function stripslashes(str) 
{
	str=str.replace(/\\'/g,'\'');
	str=str.replace(/\\"/g,'"');
	str=str.replace(/\\0/g,'\0');
	str=str.replace(/\\\\/g,'\\');
	return str;
}

var win = null;
function NewWindow(mypage,myname,w,h,scroll)
{
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
}



function toggleBeefAndPorkOption()
{
	var food_veg_nonveg = $('input:radio[name=food_veg_nonveg]:checked').val();
	if(food_veg_nonveg == 'NV')
	{
		document.getElementById('tr_beef_pork').style.display = '';
	}
	else
	{
		document.getElementById('tr_beef_pork').style.display = 'none';
	}	
}

function getCityOptions(city_id)
{
	var state_id = document.getElementById('state_id').value;
	link='remote.php?action=getcityoptions&state_id='+state_id+'&city_id='+city_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('tdcity').innerHTML = result;  
		getPlaceOptions('');
	}
}

function getPlaceOptions(place_id)
{
	var state_id = document.getElementById('state_id').value;
	var city_id = document.getElementById('city_id').value;
	link='remote.php?action=getplaceoptions&state_id='+state_id+'&city_id='+city_id+'&place_id='+place_id;
	var linkComp = link.split( "?");
	var result;
	var obj = new ajaxObject(linkComp[0], fin);
	obj.update(linkComp[1],"GET");
	obj.callback = function (responseTxt, responseStat) {
		// we'll do something to process the data here.
		result = responseTxt;
		document.getElementById('tdplace').innerHTML = result;  
	}
}

function toggleMyResponseScale(objid,tid)
{
	var check = $('#'+objid+tid).attr('checked'); 
	if(check)
	{
		$('#tr_response_img_'+tid).hide();	
		$('#tr_response_slider_'+tid).show();
		
	}
	else
	{
		$('#tr_response_img_'+tid).show();
		document.getElementById('scale_'+tid).value = '0';
		document.getElementById('remarks_'+tid).value = '';
		$('#tr_response_slider_'+tid).hide();
	}
}


function validateActivityForm()
{
	var today_wakeup_time = document.getElementById('today_wakeup_time').value;
	
	if(today_wakeup_time == '')
	{
		alert('Please select today wakeup time');
		return false;
	} 
	else
	{
		document.getElementById('frmactivity').submit();
		return true;
	}
}

function getUsersWAEQuestionDetails()
{
	var day = document.getElementById('day').value;
	var month = document.getElementById('month').value;
	var year = document.getElementById('year').value;
	
	if( (day == '') || (month == '') || (year == ''))
	{
		alert('Please select valid date');
		return false;
	} 
	else
	{
		link='remote.php?action=getuserswaequestiondetails&day='+day+'&month='+month+'&year='+year;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			temparr = result.split('::::');
			$('#cnt').val(temparr[1]);
			document.getElementById('divwae').innerHTML = temparr[0]; 
			
			var cnt = parseInt($('#cnt').val());
			var abc = new Array(cnt);
			for(var i=0; i < cnt; i++)
			{
				abc[i] = $('#scale_'+i).selectToUISlider().next();
			}
		}
	}
}

function getUsersGSQuestionDetails()
{
	var day = document.getElementById('day').value;
	var month = document.getElementById('month').value;
	var year = document.getElementById('year').value;
	
	if( (day == '') || (month == '') || (year == ''))
	{
		alert('Please select valid date');
		return false;
	} 
	else
	{
		link='remote.php?action=getusersgsquestiondetails&day='+day+'&month='+month+'&year='+year;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			temparr = result.split('::::');
			$('#cnt').val(temparr[1]);
			document.getElementById('divgs').innerHTML = temparr[0]; 
			
			var cnt = parseInt($('#cnt').val());
			var abc = new Array(cnt);
			for(var i=0; i < cnt; i++)
			{
				abc[i] = $('#scale_'+i).selectToUISlider().next();
			}
		}
	}
}

function getUsersSleepQuestionDetails()
{
	var day = document.getElementById('day').value;
	var month = document.getElementById('month').value;
	var year = document.getElementById('year').value;
	
	if( (day == '') || (month == '') || (year == ''))
	{
		alert('Please select valid date');
		return false;
	} 
	else
	{
		link='remote.php?action=getuserssleepquestiondetails&day='+day+'&month='+month+'&year='+year;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			temparr = result.split('::::');
			$('#cnt').val(temparr[1]);
			document.getElementById('divsleep').innerHTML = temparr[0]; 
			
			var cnt = parseInt($('#cnt').val());
			var abc = new Array(cnt);
			for(var i=0; i < cnt; i++)
			{
				abc[i] = $('#scale_'+i).selectToUISlider().next();
			}
		}
	}
}

function getUsersMCQuestionDetails()
{
	var day = document.getElementById('day').value;
	var month = document.getElementById('month').value;
	var year = document.getElementById('year').value;
	
	if( (day == '') || (month == '') || (year == ''))
	{
		alert('Please select valid date');
		return false;
	} 
	else
	{
		link='remote.php?action=getusersmcquestiondetails&day='+day+'&month='+month+'&year='+year;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			temparr = result.split('::::');
			$('#cnt').val(temparr[1]);
			document.getElementById('divmc').innerHTML = temparr[0]; 
			
			var cnt = parseInt($('#cnt').val());
			var abc = new Array(cnt);
			for(var i=0; i < cnt; i++)
			{
				abc[i] = $('#scale_'+i).selectToUISlider().next();
			}
		}
	}
}

function getUsersMRQuestionDetails()
{
	var day = document.getElementById('day').value;
	var month = document.getElementById('month').value;
	var year = document.getElementById('year').value;
	
	if( (day == '') || (month == '') || (year == ''))
	{
		alert('Please select valid date');
		return false;
	} 
	else
	{
		link='remote.php?action=getusersmrquestiondetails&day='+day+'&month='+month+'&year='+year;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt;
			temparr = result.split('::::');
			$('#cnt').val(temparr[1]);
			document.getElementById('divmr').innerHTML = temparr[0]; 
			
			var cnt = parseInt($('#cnt').val());
			var abc = new Array(cnt);
			for(var i=0; i < cnt; i++)
			{
				abc[i] = $('#scale_'+i).selectToUISlider().next();
			}
		}
	}
}

function startPageLoading()
{
	document.getElementById('page_loading_bg').style.display = ''; 	
}

function stopPageLoading()
{
	document.getElementById('page_loading_bg').style.display = 'none'; 	
}

function toggleMealLikeIcon(meal_type,idval)
{
	var meal_like = $('#'+meal_type+'_meal_like_'+idval).val();
	var icon = '';
	
	if(meal_like == 'Like')
	{
		icon = '<img border="0" src="images/like_icon.jpg" width="29" height="25">';
	}
	else if(meal_like == 'Dislike')
	{
		icon = '<img border="0" src="images/dislike_icon.jpg" width="29" height="25">';
	}
	else if(meal_like == 'Favourite')
	{
		icon = '<img border="0" src="images/favorite_icon.jpg" width="29" height="25">';
	}
	else if(meal_like == 'Allergic')
	{
		icon = '<img border="0" src="images/allergies_icon.jpg" width="29" height="25">';
	}
	else
	{
		icon = '';
	}
	$('#spn_'+meal_type+'_meal_like_icon_'+idval).html(icon);
}

function saveToExcel()
{
	var start_day = document.getElementById('hdnstart_day').value;
	var start_month = document.getElementById('hdnstart_month').value;
	var start_year = document.getElementById('hdnstart_year').value;
	var end_day = document.getElementById('hdnend_day').value;
	var end_month = document.getElementById('hdnend_month').value;
	var end_year = document.getElementById('hdnend_year').value;
	
	if( (start_day == '') || (start_month == '') || (start_year == ''))
	{
		alert('Please select valid start date');
		return false;
	} 
	else if( (end_day == '') || (end_month == '') || (end_year == ''))
	{
		alert('Please select valid end date');
		return false;
	} 
	else
	{
		link='remote.php?action=savetoexcel&start_day='+start_day+'&start_month='+start_month+'&start_year='+start_year+'&end_day='+end_day+'&end_month='+end_month+'&end_year='+end_year;
		var linkComp = link.split( "?");
		var result;
		var obj = new ajaxObject(linkComp[0], fin);
		obj.update(linkComp[1],"GET");
		obj.callback = function (responseTxt, responseStat) {
			// we'll do something to process the data here.
			result = responseTxt.split("::::");
			if(result[0] == '1')
			{
				alert(result[1]);
			}
		}
	}
}
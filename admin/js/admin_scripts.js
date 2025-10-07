function fin(responseTxt,responseStat) {

  //alert(responseStat+' - '+responseTxt);

}
const isLocalhost = window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1";
const ADMIN_URL = isLocalhost
  ? "http://localhost/welness/admin"
  : "https://wellnessway4u.com/admin";

const SITE_URL = isLocalhost
  ? "http://localhost/welness/"
  : "https://wellnessway4u.com/";
console.log(ADMIN_URL)


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



// Simple event handler, called from onChange and onSelect

                // event handlers, as per the Jcrop invocation above

                function showCoords(c)

                {

                  $('#hdnbp_image_x1').val(c.x);

                  $('#hdnbp_image_y1').val(c.y);

                  $('#hdnbp_image_x2').val(c.x2);

                  $('#hdnbp_image_y2').val(c.y2);

                  $('#hdnbp_image_w').val(c.w);

                  $('#hdnbp_image_h').val(c.h);

                };



                function clearCoords()

                {

                  //$('#coords input').val('');

                  $('#hdnbp_image_x1').val('');

                  $('#hdnbp_image_y1').val('');

                  $('#hdnbp_image_x2').val('');

                  $('#hdnbp_image_y2').val('');

                  $('#hdnbp_image_w').val('');

                  $('#hdnbp_image_h').val('');

                };

                

                function updatePreview(c)

                {

                  if (parseInt(c.w) > 0)

                  {

                    var rx = xsize / c.w;

                    var ry = ysize / c.h;



                    $pimg.css({

                      width: Math.round(rx * boundx) + 'px',

                      height: Math.round(ry * boundy) + 'px',

                      marginLeft: '-' + Math.round(rx * c.x) + 'px',

                      marginTop: '-' + Math.round(ry * c.y) + 'px'

                    });

                  }

                };

                

                



function toggleBodyImage()

{

	var bp_side = document.getElementById('bp_side').value;

        var bp_sex = document.getElementById('bp_sex').value;

	link='remote.php?action=togglebodyimage&bp_side='+bp_side+'&bp_sex='+bp_sex;

	var linkComp = link.split( "?");

	var result;

	var obj = new ajaxObject(linkComp[0], fin);

	obj.update(linkComp[1],"GET");

	obj.callback = function (responseTxt, responseStat) {

		// we'll do something to process the data here.

		result = responseTxt;

		document.getElementById('idbodyimage').innerHTML = result;  

                

                var jcrop_api;



                $('#target').Jcrop({

                  onChange:   showCoords,

                  onSelect:   showCoords,

                  onRelease:  clearCoords

                },function(){

                  jcrop_api = this;

                });



                $('#coords').on('change','input',function(e){

                  var x1 = $('#hdnbp_image_x1').val(),

                      x2 = $('#hdnbp_image_x2').val(),

                      y1 = $('#hdnbp_image_y1').val(),

                      y2 = $('#hdnbp_image_y2').val();

                  jcrop_api.setSelect([x1,y1,x2,y2]);

                });

	}

}



function getEarlierDocumentRefOptions()

{

    var banner_client_id = $('#banner_client_id').val();

    

    startPageLoading();

    link='remote.php?action=getearlierdocumentrefoptions&banner_client_id='+banner_client_id;

    var linkComp = link.split( "?");

    var result;

    var obj = new ajaxObject(linkComp[0], fin);

    obj.update(linkComp[1],"GET");

    obj.callback = function (responseTxt, responseStat) {

        // we'll do something to process the data here.

        result = responseTxt;

        $('#tdolddocrefno').html(result);

        stopPageLoading();

    }

}



function getAllProfileCustomizationSelectionStr(prct_cat_id)

{

    var prct_ref_no = $('#prct_ref_no').val();

    

    startPageLoading();

    link='remote.php?action=getallprofilecustomizationselectionstr&prct_ref_no='+prct_ref_no+'&prct_cat_id='+prct_cat_id;

    var linkComp = link.split( "?");

    var result;

    var obj = new ajaxObject(linkComp[0], fin);

    obj.update(linkComp[1],"GET");

    obj.callback = function (responseTxt, responseStat) {

        // we'll do something to process the data here.

        result = responseTxt;

        $('#tdprctitemsresult').html(result);

        stopPageLoading();

    }

}



function getAllSolutionItemsSelectionStrCatwise(idval)

{

    var sol_cat_id = $('#sol_cat_id_'+idval).val();

    

    startPageLoading();

    link='remote.php?action=getallsolutionitemsselectionstrcatwise&sol_cat_id='+sol_cat_id+'&idval='+idval;

    var linkComp = link.split( "?");

    var result;

    var obj = new ajaxObject(linkComp[0], fin);

    obj.update(linkComp[1],"GET");

    obj.callback = function (responseTxt, responseStat) {

        // we'll do something to process the data here.

        result = responseTxt;

        $('#tdsolitemscatwise_'+idval).html(result);

        stopPageLoading();

    }

}



function getAllSolutionItemsSelectionStrCatwiseSingle(sol_item_id)

{

    var sol_cat_id = $('#sol_cat_id').val();

    

    //startPageLoading();

    link='remote.php?action=getallsolutionitemsselectionstrcatwisesingle&sol_cat_id='+sol_cat_id+'&sol_item_id='+sol_item_id;

    var linkComp = link.split( "?");

    var result;

    var obj = new ajaxObject(linkComp[0], fin);

    obj.update(linkComp[1],"GET");

    obj.callback = function (responseTxt, responseStat) {

        // we'll do something to process the data here.

        result = responseTxt;

        $('#tdsolitemscatwise').html(result);

       // stopPageLoading();

    }

}



function getModuleWiseKeywordsOptions()

{

    var module_id = $('#module_id').val();

    

    //startPageLoading();

    link='remote.php?action=getmodulewisekeywordsoptions&module_id='+module_id;

    var linkComp = link.split( "?");

    var result;

    var obj = new ajaxObject(linkComp[0], fin);

    obj.update(linkComp[1],"GET");

    obj.callback = function (responseTxt, responseStat) {

            // we'll do something to process the data here.

            result = responseTxt;

            $('#tdkeywordresult').html(result);

            //stopPageLoading();

    }

}



function getModuleWiseKeywordsOptionsDropdown()

{

    var module_id = $('#module_id').val();

    

    //startPageLoading();

    link='remote.php?action=getmodulewisekeywordsoptionsdropdown&module_id='+module_id;

    var linkComp = link.split( "?");

    var result;

    var obj = new ajaxObject(linkComp[0], fin);

    obj.update(linkComp[1],"GET");

    obj.callback = function (responseTxt, responseStat) {

            // we'll do something to process the data here.

            result = responseTxt;

            $('#tdkeywordresult').html(result);

            //stopPageLoading();

    }

}



function toggleScaleShow()

{

    //$('#divreportresults').hide();

    var report_module = $('#module_id').val();

    if (report_module == "113" || report_module == "45" ) 

    {

        $('#idscaleshow').show();

    }

    else 

    { 	

        $('#idscaleshow').hide();

    }

}



function getModuleWiseCriteriaOptions()

{

    //$('#divreportresults').hide();

    var report_module = $('#module_id').val();

    //startPageLoading();

    link='remote.php?action=getmodulewisecriteriaoptions&report_module='+report_module;

    var linkComp = link.split( "?");

    var result;

    var obj = new ajaxObject(linkComp[0], fin);

    obj.update(linkComp[1],"GET");

    obj.callback = function (responseTxt, responseStat) {

            // we'll do something to process the data here.

            result = responseTxt;

            $('#tdcriteriaresult').html(result);

            //stopPageLoading();

    }

}



function getModuleWiseCriteriaScaleValues()

{

    //$('#divreportresults').hide();

    var report_module = $('#module_id').val();

    var pro_user_id = '';

    var module_criteria = $('#module_criteria').val();

    var criteria_scale_range = $('#criteria_scale_range').val();

    

    //alert('module_criteria = '+module_criteria);

    

    //startPageLoading();

    link='remote.php?action=getmodulewisecriteriascalevalues&module_criteria='+module_criteria+'&report_module='+report_module+'&pro_user_id='+pro_user_id+'&criteria_scale_range='+criteria_scale_range;

        var linkComp = link.split( "?");

        var result;

        var obj = new ajaxObject(linkComp[0], fin);

        obj.update(linkComp[1],"GET");

        obj.callback = function (responseTxt, responseStat) {

                // we'll do something to process the data here.

                result = responseTxt;

                //alert(result);

                $('#idcriteriascalevalues').html(result);

                //stopPageLoading();

        }

}



function toggleCriteriaScaleShow()

{

    //$('#divreportresults').hide();

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



function resetReportForm()

{

    //$('#divreportresults').hide();

    $('#module_criteria').val('');

    $('#idcriteriascaleshow').hide();

    $('#start_criteria_scale_value').val('');

    $('#end_criteria_scale_value').val('');

    $('#div_start_criteria_scale_value').hide();

    $('#div_end_criteria_scale_value').hide();

    if($('#module_id').val() == '45')

    {

        $('#trigger_criteria').val('');

        $('.spntriggercriteria').show('');

    }

    else

    {

        $('#trigger_criteria').val('');

        $('.spntriggercriteria').hide('');

    }

    

}



function getModuleWiseCriteriaScaleOptions()

{

    //$('#divreportresults').hide();

    var report_module = $('#module_id').val();

    //var pro_user_id = $('#pro_user_id').val();

    var module_criteria = $('#module_criteria').val();

    //startPageLoading();

    link='remote.php?action=getmodulewisecriteriascaleoptions&report_module='+report_module+'&module_criteria='+module_criteria;

        var linkComp = link.split( "?");

        var result;

        var obj = new ajaxObject(linkComp[0], fin);

        obj.update(linkComp[1],"GET");

        obj.callback = function (responseTxt, responseStat) {

                // we'll do something to process the data here.

                result = responseTxt;

                //alert(result);

                $('#tdcriteriascalerange').html(result);

                if(module_criteria == '9' && report_module == '45')

                {

                    $('.spntriggercriteria').show();

                }

                else

                {

                    $('.spntriggercriteria').hide();

                    $('#trigger_criteria').val('');

                }

                //stopPageLoading();

        }

}



function toggleScaleRangeType(id_val,div_start_val,div_end_val)

{

    //$('#divreportresults').hide();

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



function sayHello()

{

    alert('test say hello');

}



function imagePreviewAdmin(){	

			/* CONFIG */

			//alert('hello');

			xOffset = 50;

			yOffset = 50;

			

			// these 2 variable determine popup's distance from the cursor

			// you might want to adjust to get the right result

			

		/* END CONFIG */

		$("a.preview").hover(function(e){

			this.t = this.title;

			this.title = "";	

			var c = (this.t != "") ? "<br/>" + this.t : "";

			$("body").append("<p id='preview'><img  src='"+ this.href +"' alt='Image preview' />"+ c +"</p>");								 

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



function setBulkEmailCampaignValues()

{

	var email_ar_id = $('#email_ar_id').val();

	

	if(email_ar_id == '')

	{

		$('#email_from_name').val('Info');

		$('#email_from_email').val('info@wellnessway4u.com');

		$('#email_subject').val('');

		tinyMCE.activeEditor.setContent('');

	}

	else

	{

		link='remote.php?action=setbulkemailcampaignvalues&email_ar_id='+email_ar_id;

		var linkComp = link.split( "?");

		var result;

		var obj = new ajaxObject(linkComp[0], fin);

		obj.update(linkComp[1],"GET");

		obj.callback = function (responseTxt, responseStat) {

			// we'll do something to process the data here.

			//result = responseTxt;

			result = responseTxt.split("::::");

			$('#email_from_name').val(result[1]);

			$('#email_from_email').val(result[2]);

			$('#email_subject').val(result[3]);

			//$('#email_body').val(result[4]);

			

			tinyMCE.activeEditor.setContent(result[4]);

		}

	}	

}	





function getSelectedUserListIds()

{
        //alert('Hiii');
	var ult_id = $('#ult_id').val();	

	var checkValues = $('input:checkbox[name="selected_user_id"]:checked').map(function() {																   

			return $(this).val();

		}).get();

	

	var str_uid = String(checkValues);

	//alert(str_uid);

	

	if (ult_id == "2" || ult_id == "4" || ult_id == "6") 

	{

		$('#hdnstr_selected_adviser_id').val(str_uid);

		$('#hdnstr_selected_user_id').val(str_uid);

	}

	else

	{ 

		$('#hdnstr_selected_adviser_id').val(str_uid);

	  	$('#hdnstr_selected_user_id').val(str_uid);

	}

}





function getUserTypeSelectedEmailList()

{

	var ult_id = $('#ult_id').val();

	var country_id = $('#country_id').val();

	var str_selected_user_id = $('#hdnstr_selected_user_id').val();

	var str_selected_adviser_id = $('#hdnstr_selected_adviser_id').val();

	

	var obj_state_id = document.getElementById('state_id');

	var str_state_id = "";

	

	for (var x=0;x<obj_state_id.length;x++)

	{

		if (obj_state_id[x].selected)

		{

			str_state_id = str_state_id + obj_state_id[x].value + "," ;

		}

	}

	

	var obj_city_id = document.getElementById('city_id');

	var str_city_id = "";

	

	for (var x=0;x<obj_city_id.length;x++)

	{

		if (obj_city_id[x].selected)

		{

			str_city_id = str_city_id + obj_city_id[x].value + "," ;

		}

	}

	

	var obj_place_id = document.getElementById('place_id');

	var str_place_id = "";

	

	for (var x=0;x<obj_place_id.length;x++)

	{

		if (obj_place_id[x].selected)

		{

			str_place_id = str_place_id + obj_place_id[x].value + "," ;

		}

	}

	

	var obj_ap_id = document.getElementById('ap_id');

	var str_ap_id = "";

	

	for (var x=0;x<obj_ap_id.length;x++)

	{

		if (obj_ap_id[x].selected)

		{

			str_ap_id = str_ap_id + obj_ap_id[x].value + "," ;

		}

	}

	

	var obj_up_id = document.getElementById('up_id');

	var str_up_id = "";

	

	for (var x=0;x<obj_up_id.length;x++)

	{

		if (obj_up_id[x].selected)

		{

			str_up_id = str_up_id + obj_up_id[x].value + "," ;

		}

	}

	

	startPageLoading();

	link='remote.php?action=getusertypeselectedemaillist&ult_id='+ult_id+'&country_id='+country_id+'&str_state_id='+str_state_id+'&str_city_id='+str_city_id+'&str_place_id='+str_place_id+'&str_selected_user_id='+str_selected_user_id+'&str_selected_adviser_id='+str_selected_adviser_id+'&str_ap_id='+str_ap_id+'&str_up_id='+str_up_id;

	var linkComp = link.split( "?");

	var result;

	var obj = new ajaxObject(linkComp[0], fin);

	obj.update(linkComp[1],"GET");

	obj.callback = function (responseTxt, responseStat) {

		// we'll do something to process the data here.

		result = responseTxt;

		$('#user_selection_list').html(result);

		

		$('#state_id').change(function() { getUserTypeSelectedEmailList(); });

		$('#city_id').change(function() { getUserTypeSelectedEmailList(); });

		$('#place_id').change(function() { getUserTypeSelectedEmailList(); });

		getSelectedUserListIds();

		stopPageLoading();

	}

}	



function toggleUserListTypeSelection()

{

	var ult_id = document.getElementById('ult_id').value;

	if (ult_id == "3" ) 

	{

		$('.truserplan').show();

		$('.tradviserplan').hide();	

		$('.trlocation').hide();

	}

	else if (ult_id == "4" ) 

	{

		$('.truserplan').hide();

		$('.tradviserplan').show();	

		$('.trlocation').hide();

	}

	else if (ult_id == "5" || ult_id == "6") 

	{

		$('.truserplan').hide();

		$('.tradviserplan').hide();	

		$('.trlocation').show();	

	}

	else

	{ 	

		$('.truserplan').hide();	

		$('.tradviserplan').hide();	

	  	$('.trlocation').hide();	

	}

	getUserTypeSelectedEmailList();

}



function confirmEditAdviserPlan()

{

	var ap_status = $('#ap_status').val();

	if(ap_status == '0')

	{

		var Choice = confirm("If you Inactivate this plan then it will be deactivated from users plan.Do you wish to continue?");

		if (Choice == true)

		{

			return true;

		}

		else

		{

			return false;

		}

	}

	return true;

}



function confirmEditUserPlan()

{

	var up_status = $('#up_status').val();

	if(up_status == '0')

	{

		var Choice = confirm("If you Inactivate this plan then it will be deactivated from users plan.Do you wish to continue?");

		if (Choice == true)

		{

			return true;

		}

		else

		{

			return false;

		}

	}

	return true;

}



function confirmAdviserDefaultPlan(current_ap_id)

{

	if($('#ap_default').is(':checked'))

	{

		link='remote.php?action=confirmadviserdefaultplan&current_ap_id='+current_ap_id;

		var linkComp = link.split( "?");

		var result;

		var obj = new ajaxObject(linkComp[0], fin);

		obj.update(linkComp[1],"GET");

		obj.callback = function (responseTxt, responseStat) {

			// we'll do something to process the data here.

			//result = responseTxt;

			//alert(responseTxt);

			result = responseTxt.split("::::");

			if(result[1] == '11')

			{

				var Choice = confirm("There is currently existing default plan. Do you wish to replace it?");

				if (Choice == true)

				{

					$(".chkbxapaid").removeAttr("onclick");

					$(".selapaid").removeAttr("disabled");

				}

				else

				{

					$("input[id='ap_default']").removeAttr("checked");

				}

			}	

		}

		

	}

	else

	{

		//alert('unchekd');

		link='remote.php?action=confirmadviserdefaultplanunchked&current_ap_id='+current_ap_id;

		var linkComp = link.split( "?");

		var result;

		var obj = new ajaxObject(linkComp[0], fin);

		obj.update(linkComp[1],"GET");

		obj.callback = function (responseTxt, responseStat) {

			// we'll do something to process the data here.

			//alert(responseTxt);

			result = responseTxt.split("::::");

			if(result[1] == '11')

			{

				var Choice = confirm("Do you wish to deactivate default plan?");

				if (Choice == true)

				{

					

				}

				else

				{

					$("input[id='ap_default']").attr("checked", true);

				}

			}	

			else if(result[1] == '00')

			{

				$(".chkbxapaid").attr("onclick","return false");

				$(".selapaid").attr("disabled",true);

			}

		}

	}

}	



function confirmUserDefaultPlan(current_up_id)

{

	if($('#up_default').is(':checked'))

	{

		link='remote.php?action=confirmuserdefaultplan&current_up_id='+current_up_id;

		var linkComp = link.split( "?");

		var result;

		var obj = new ajaxObject(linkComp[0], fin);

		obj.update(linkComp[1],"GET");

		obj.callback = function (responseTxt, responseStat) {

			// we'll do something to process the data here.

			//result = responseTxt;

			//alert(responseTxt);

			result = responseTxt.split("::::");

			if(result[1] == '11')

			{

				var Choice = confirm("There is currently existing default plan. Do you wish to replace it?");

				if (Choice == true)

				{

					$(".chkbxapaid").removeAttr("onclick");

					$(".selapaid").removeAttr("disabled");

				}

				else

				{

					$("input[id='up_default']").removeAttr("checked");

				}

			}	

		}

		

	}

	else

	{

		//alert('unchekd');

		link='remote.php?action=confirmuserdefaultplanunchked&current_up_id='+current_up_id;

		var linkComp = link.split( "?");

		var result;

		var obj = new ajaxObject(linkComp[0], fin);

		obj.update(linkComp[1],"GET");

		obj.callback = function (responseTxt, responseStat) {

			// we'll do something to process the data here.

			//alert(responseTxt);

			result = responseTxt.split("::::");

			if(result[1] == '11')

			{

				var Choice = confirm("Do you wish to deactivate default plan?");

				if (Choice == true)

				{

					

				}

				else

				{

					$("input[id='up_default']").attr("checked", true);

				}

			}	

			else if(result[1] == '00')

			{

				$(".chkbxapaid").attr("onclick","return false");

				$(".selapaid").attr("disabled",true);

			}	

		}

	}

}	





function toggleTrLocations()

{

	var apct_id = document.getElementById('apct_id').value;

	if (apct_id == "1") 

	{

		$('.trlocation').show();	

	}

	else

	{ 	

	  	$('.trlocation').hide();	

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



function getAdvisersUserOptionsMulti()

{

	var practitioner_id = document.getElementById('practitioner_id').value;

		

	link='remote.php?action=getadvisersuseroptionsmulti&practitioner_id='+practitioner_id;

	var linkComp = link.split( "?");

	var result;

	var obj = new ajaxObject(linkComp[0], fin);

	obj.update(linkComp[1],"GET");

	obj.callback = function (responseTxt, responseStat) {

		// we'll do something to process the data here.

		result = responseTxt;

		document.getElementById('tduser').innerHTML = result;  

	}

	

}



function ViewUserFavList()

{

	var pg_id = document.getElementById('pg_id').value;

	var start_date = document.getElementById('start_date').value;

	var end_date = document.getElementById('end_date').value;

	var ufs_cat_id = document.getElementById('ufs_cat_id').value;

	var user_id = document.getElementById('user_id').value;

	

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

		link='remote.php?action=viewuserfavlist&pg_id='+pg_id+'&start_date='+start_date+'&end_date='+end_date+'&ufs_cat_id='+ufs_cat_id+'&uid='+user_id;

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

				document.getElementById('showfavlist').innerHTML = result[3];  

			}

		}

	}	

}



function ViewUserReferral()

{

	var user_id = document.getElementById('user_id').value;

	var start_date = document.getElementById('start_date').value;

	var end_date = document.getElementById('end_date').value;

	//alert(user_id);

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

		link='remote.php?action=viewuserreferral&uid='+user_id+'&start_date='+start_date+'&end_date='+end_date;

		var linkComp = link.split( "?");

		var result;

		var obj = new ajaxObject(linkComp[0], fin);

		obj.update(linkComp[1],"GET");

		obj.callback = function (responseTxt, responseStat) {

			// we'll do something to process the data here.

			result = responseTxt;

			result = responseTxt.split("::");

			

			if(result[1] == 1)

			{

				alert(result[2]);

			}

			else

			{

				document.getElementById('showreferal').innerHTML = result[3];  

			}

			

		}

	}

}



function ViewUserEncashedRewards()

{

	var user_id = document.getElementById('user_id').value;

	var start_date = document.getElementById('start_date').value;

	var end_date = document.getElementById('end_date').value;

	var reward_list_module_id = document.getElementById('reward_list_module_id').value;

	//alert(user_id);

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

		link='remote.php?action=viewuserencashedrewards&uid='+user_id+'&start_date='+start_date+'&end_date='+end_date+'&reward_list_module_id='+reward_list_module_id;

		var linkComp = link.split( "?");

		var result;

		var obj = new ajaxObject(linkComp[0], fin);

		obj.update(linkComp[1],"GET");

		obj.callback = function (responseTxt, responseStat) {

			// we'll do something to process the data here.

			result = responseTxt;

			result = responseTxt.split("::");

			

			if(result[1] == 1)

			{

				alert(result[2]);

			}

			else

			{

				document.getElementById('showreferal').innerHTML = result[3];  

			}

			

		}

	}

}



function showMonthWiseRewardChart(idval)

{

	if($('#btnShowMonthWiseChart').val() == 'Show Monthwise Chart')

	{

		$('#'+idval).show();	

		//$('#btnShowMonthWiseChart').val() = 'Hide Monthwise Chart';

		$("#btnShowMonthWiseChart").attr('value', 'Hide Monthwise Chart');

	}

	else

	{

		$('#'+idval).hide();	

		//$('#btnShowMonthWiseChart').val() = 'Show Monthwise Chart';

		$("#btnShowMonthWiseChart").attr('value', 'Show Monthwise Chart');

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



function viewUsersSelectionPopup()

{

	var practitioner_id = document.getElementById('practitioner_id').value;

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

	link='remote.php?action=viewusersselectionpopup&practitioner_id='+practitioner_id+'&str_user_id='+str_user_id;

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

    //alert($("#all_"+id_val).attr("checked"));

    if($("#all_"+id_val).attr("checked")== 'checked' ||  $("#all_"+id_val).attr("checked") === true)

    {

        //alert('all chkd');

        $("input[id^='"+id_val+"_']").attr("checked", true);

    }

    else

    {

        //alert('not chkd'+ '#all_'+id_val);

        $("input[id^='"+id_val+"_']").removeAttr("checked");

    }

}



function viewEntriesDetailsList(start_date,end_date,reward_module_id,reward_module_title,uid)

{

	startPageLoading();

	link='remote.php?action=viewentriesdetailslist&start_date='+start_date+'&end_date='+end_date+'&reward_module_id='+reward_module_id+'&uid='+uid;

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

/*  Amol function start */







function removeBannerRow(tid)

{

	

	if( (tid != '') )

	{

		//alert(tid);

		var totalRow = parseInt($('#hdnbanner_totalRow').val());

		totalRow = totalRow - 1;       

							

		$('#hdnbanner_totalRow').val(totalRow);

		

		$('#banner_id_1_'+tid).remove();

		$('#banner_id_2_'+tid).remove();

		$('#banner_id_3_'+tid).remove();

		$('#banner_id_4_'+tid).remove();

		$('#banner_id_5_'+tid).remove();

		$('#banner_id_6_'+tid).remove();

		$('#banner_id_7_'+tid).remove();

		$('#banner_id_8_'+tid).remove();

		$('#banner_id_9_'+tid).remove();
                $('#banner_id_10_'+tid).remove();
                $('#banner_id_11_'+tid).remove();

		$('#trfile_'+tid).remove();

		$('#trtext_'+tid).remove();

		$('#tr_banner_'+tid).remove();

	}

}



function removeBannerRowMulti(tid)

{

	

	if( (tid != '') )

	{

		//alert(tid);

		var totalRow = parseInt($('#hdnbanner_totalRow').val());

		totalRow = totalRow - 1;       

							

		$('#hdnbanner_totalRow').val(totalRow);

		

		$('.tr_banner_row_'+tid).remove();

		

	}

}



function removeMultipleRows(clsval,idval_totalrows)

{

	var totalRow = parseInt($('#'+idval_totalrows).val());

	totalRow = totalRow - 1;       

	$('#'+idval_totalrows).val(totalRow);

	$('.'+clsval).remove();

}



function toggleContentType()

{

	var sc_content_type = document.getElementById('sc_content_type').value;

	if (sc_content_type == "text") 

	{

		$('.tr_text_content').show();	

	    $('.tr_image_content').hide();	

		$('.tr_video_content').hide();	

		$('.tr_flash_content').hide();	

		$('.tr_rss_content').hide();	

	}

	else if (sc_content_type == "text_and_image") 

	{ 	

	   	$('.tr_text_content').show();	

	    $('.tr_image_content').show();	

		$('.tr_video_content').hide();	

		$('.tr_flash_content').hide();

		$('.tr_rss_content').hide();

	}

	else if (sc_content_type == "image") 

	{ 	

	  	$('.tr_text_content').hide();	

	    $('.tr_image_content').show();	

		$('.tr_video_content').hide();	

		$('.tr_flash_content').hide();

		$('.tr_rss_content').hide();

	}

	else if (sc_content_type == "video") 

	{ 	

	  	$('.tr_text_content').hide();	

	    $('.tr_image_content').hide();	

		$('.tr_video_content').show();	

		$('.tr_flash_content').hide();

		$('.tr_rss_content').hide();

	}

	else if (sc_content_type == "flash") 

	{ 	

	  	$('.tr_text_content').hide();	

	    $('.tr_image_content').hide();	

		$('.tr_video_content').hide();	

		$('.tr_flash_content').show();

		$('.tr_rss_content').hide();

	}

	else if (sc_content_type == "rss") 

	{ 	

	  	$('.tr_text_content').hide();	

	    $('.tr_image_content').hide();	

		$('.tr_video_content').hide();	

		$('.tr_flash_content').hide();

		$('.tr_rss_content').show();

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

        document.getElementById('tr_days_of_week').style.display = 'none';

        document.getElementById('tr_month_date').style.display = 'none';

    }

    else if (sc_listing_date_type == "single_date") 

    { 	

        document.getElementById('tr_days_of_month').style.display = 'none';

        document.getElementById('tr_single_date').style.display = '';

        document.getElementById('tr_date_range').style.display = 'none';

        document.getElementById('tr_days_of_week').style.display = 'none';

        document.getElementById('tr_month_date').style.display = 'none';

    }

    else if (sc_listing_date_type == "date_range") 

    { 	

        document.getElementById('tr_days_of_month').style.display = 'none';

        document.getElementById('tr_single_date').style.display = 'none';

        document.getElementById('tr_date_range').style.display = '';

        document.getElementById('tr_days_of_week').style.display = 'none';

        document.getElementById('tr_month_date').style.display = 'none';

    }

    else if (sc_listing_date_type == "days_of_week") 

    { 	

        document.getElementById('tr_days_of_month').style.display = 'none';

        document.getElementById('tr_single_date').style.display = 'none';

        document.getElementById('tr_date_range').style.display = 'none';

        document.getElementById('tr_days_of_week').style.display = '';

        document.getElementById('tr_month_date').style.display = 'none';

    }

    else if (sc_listing_date_type == "month_wise") 

    { 	

        document.getElementById('tr_days_of_month').style.display = 'none';

        document.getElementById('tr_single_date').style.display = 'none';

        document.getElementById('tr_date_range').style.display = 'none';

        document.getElementById('tr_days_of_week').style.display = 'none';

        document.getElementById('tr_month_date').style.display = '';

    }

    else

    { 	

        document.getElementById('tr_days_of_month').style.display = 'none';

        document.getElementById('tr_single_date').style.display = 'none';

        document.getElementById('tr_date_range').style.display = 'none';

        document.getElementById('tr_days_of_week').style.display = 'none';

        document.getElementById('tr_month_date').style.display = 'none';

    }

}







function toggleRewardFileType()

{

	var reward_list_file_type = document.getElementById('reward_list_file_type').value;

	if (reward_list_file_type == "Video") 

	{ 	

	    document.getElementById('trfile').style.display = 'none';

		document.getElementById('trtext').style.display = '';

	}

	else

	{ 	

	   document.getElementById('trfile').style.display = '';

		document.getElementById('trtext').style.display = 'none';

	}

}



function BannerBox(id)

{

	//alert(id);

	var banner_type = document.getElementById('banner_type_'+id).value;

	//alert(banner_type);

	if (banner_type == " ") 

	{ 	

	    document.getElementById('trfile_'+id).style.display = '';

		document.getElementById('trtext_'+id).style.display = '';

		document.getElementById('google_ads_'+id).innerHTML = '';  

	}

	else if (banner_type == "Video") 

	{ 	

	   document.getElementById('trtext_'+id).style.display = '';

	   document.getElementById('trfile_'+id).style.display = 'none';

	   document.getElementById('google_ads_'+id).innerHTML = '';  

	}

	else if(banner_type == "Image" || banner_type == "Flash")

	{

		document.getElementById('trtext_'+id).style.display = 'none';

		document.getElementById('trfile_'+id).style.display = '';

		document.getElementById('google_ads_'+id).innerHTML = '';  

	}

	else if (banner_type == "Google Ads")

	{

		

		var position_id = document.getElementById('position_id').value;

		

		if(position_id == '')

		{

			alert('Please select position');	

		}

		else

			{

				document.getElementById('trtext_'+id).style.display = 'none';

				document.getElementById('trfile_'+id).style.display = 'none';

				link=SITE_URL+'remote.php?action=getgoogleads&position_id='+position_id+'&banner_type='+banner_type;

				var linkComp = link.split( "?");

				var result;

				var obj = new ajaxObject(linkComp[0], fin);

				obj.update(linkComp[1],"GET");

				obj.callback = function (responseTxt, responseStat) 

				{

					// we'll do something to process the data here.

					result = responseTxt;

					//alert(result);

					document.getElementById('google_ads_'+id).innerHTML = result;  

				}

		}

	}

}



function BannerBox2()

{

	//alert(id);

	var banner_type = document.getElementById('banner_type').value;

	//alert(banner_type);

	if (banner_type == " ") 

	{ 	

	    document.getElementById('trfile').style.display = '';

		document.getElementById('trtext').style.display = '';

		document.getElementById('google_ads').innerHTML = '';  

	}

	else if (banner_type == "Video") 

	{ 	

	   document.getElementById('trtext').style.display = '';

	   document.getElementById('trfile').style.display = 'none';

	   document.getElementById('google_ads').innerHTML = '';  

	}

	else if(banner_type == "Image" || banner_type == "Flash")

	{

		document.getElementById('trtext').style.display = 'none';

		document.getElementById('trfile').style.display = '';

		document.getElementById('google_ads').innerHTML = '';  

	}

	else if (banner_type == "Google Ads")

	{

		

		var position_id = document.getElementById('position_id').value;

		

		if(position_id == '')

		{

			alert('Please select position');	

		}

		else

			{

				document.getElementById('trtext_'+id).style.display = 'none';

				document.getElementById('trfile_'+id).style.display = 'none';

				link='remote.php?action=getgoogleads&position_id='+position_id+'&banner_type='+banner_type;

				var linkComp = link.split( "?");

				var result;

				var obj = new ajaxObject(linkComp[0], fin);

				obj.update(linkComp[1],"GET");

				obj.callback = function (responseTxt, responseStat) 

				{

					// we'll do something to process the data here.

					result = responseTxt;

					//alert(result);

					document.getElementById('google_ads').innerHTML = result;  

				}

		}

	}

}



function ViewLibrary()

{

	var user_id = document.getElementById('user_id').value;

	//alert(user_id);

	if(user_id == '')

	{

		alert('Please select user');

	}

	else

	{

		link='remote.php?action=viewlibrary&user_id='+user_id;

		var linkComp = link.split( "?");

		var result;

		var obj = new ajaxObject(linkComp[0], fin);

		obj.update(linkComp[1],"GET");

		obj.callback = function (responseTxt, responseStat) {

			// we'll do something to process the data here.

			result = responseTxt;

			//alert(result);

			document.getElementById('library').innerHTML = result;  

		}

	}

}



function Enable_Report(flag)

{

	var report_type = document.getElementById('report_type').value;

	var user_id = document.getElementById('user_id').value;

	//alert(flag);

	//alert(report_type);

	if(user_id == '')

	{

		alert('Please select user');

	}

	else if(report_type == '')

	{

		alert('Please select report type');

	}

	else

	{

		link='remote.php?action=enable_report&user_id='+user_id+'&report_type='+report_type+'&flag='+flag;

		var linkComp = link.split( "?");

		var result;

		var obj = new ajaxObject(linkComp[0], fin);

		obj.update(linkComp[1],"GET");

		obj.callback = function (responseTxt, responseStat) {

			// we'll do something to process the data here.

			result = responseTxt;

			//alert(result);

			resultarr = result.split('::');

			//alert(resultarr[1]);

			document.getElementById('enable_report').innerHTML = resultarr[1];  

		}

	}

}







function GetShortNarration(short_narration)

{

	var title_id = document.getElementById('title_id').value;

	//alert(title_id);

	link='remote.php?action=getshortnarration&title_id='+title_id+'&short_narration='+short_narration;

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







function ShowOrHideCheckBox(id_val)

	{

		if($('#menu_'+id_val).is(':checked'))

		{

			$("input[id^='permissions_"+id_val+"_']").removeAttr("disabled");

			$("input[id^='permissions_"+id_val+"_']").attr("checked", true);

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



function BannerBox1()

{

	var banner_type = document.getElementById('banner_type').value;

	//alert(banner_type);

	if (banner_type == "Video") 

	{ 

           document.getElementById('tr_rss_content').style.display = 'none';  

	   document.getElementById('trtext').style.display = '';

	   document.getElementById('trfile').style.display = 'none';

	}

        else if(banner_type == "rss") 

	{ 

           document.getElementById('tr_rss_content').style.display = ''; 

	   document.getElementById('trtext').style.display = 'none';

	   document.getElementById('trfile').style.display = 'none';

	}

        else if(banner_type == "text") 

	{ 

           document.getElementById('tr_rss_content').style.display = 'none'; 

	   document.getElementById('trtext').style.display = 'none';

	   document.getElementById('trfile').style.display = 'none';

	}

	else

	{

            document.getElementById('tr_rss_content').style.display = 'none'; 

            document.getElementById('trtext').style.display = 'none';

            document.getElementById('trfile').style.display = '';

	}

}



function ShowStressOptions()

{

	var step = document.getElementById('step').value;

	//alert(step);

	if (step == "2") 

	{ 	

	    document.getElementById('displaystressbuster').style.display = '';

	}

	else

	{ 	

	   document.getElementById('displaystressbuster').style.display = 'none';

	}

}



function Playsound(sound_clip_id)

{

	var sound_clip_id = document.getElementById('sound_clip_id').value;

	//alert(sound_clip_id);

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





function getHeightAndWidth()

{

	var position_id = document.getElementById('position_id').value;

	//alert(position);

	link=SITE_URL+'remote.php?action=getheightandwidth&position_id='+position_id;

	var linkComp = link.split( "?");

	var result;

	var obj = new ajaxObject(linkComp[0], fin);

	obj.update(linkComp[1],"GET");

	obj.callback = function (responseTxt, responseStat) {

		// we'll do something to process the data here.

		result = responseTxt.split("::");

		document.getElementById('width').innerHTML = result[0]; 

		document.getElementById('height').innerHTML = result[1];

		

		document.getElementById('hdnwidth').value = result[0]; 

		document.getElementById('hdnheight').value = result[1];

	}

}



function getHeightAndWidthNew(idval)

{

	var position_id = document.getElementById('position_id_'+idval).value;

	//alert(position);

	link='remote.php?action=getheightandwidth&position_id='+position_id;

	var linkComp = link.split( "?");

	var result;

	var obj = new ajaxObject(linkComp[0], fin);

	obj.update(linkComp[1],"GET");

	obj.callback = function (responseTxt, responseStat) {

		// we'll do something to process the data here.

		result = responseTxt.split("::");

		document.getElementById('width_'+idval).innerHTML = result[0]; 

		document.getElementById('height_'+idval).value = result[1];

		

		document.getElementById('hdnwidth_'+idval).value = result[0]; 

		document.getElementById('hdnheight_'+idval).value = result[1];

                

                if(position_id == '1' || position_id == '12')

                {

                    $('#height_'+idval).attr('readonly', true);

                }

                else

                {

                    $('#height_'+idval).removeAttr('readonly');

                }

	}

}


//commented by rahul for bs height and width
// function getHeightAndWidthBS()

// {

// 	var position_id = document.getElementById('position_id').value;

// 	//alert(position);

// 	link=SITE_URL+'remote.php?action=getheightandwidth&position_id='+position_id;
	
// 	var linkComp = link.split( "?");

// 	var result;

// 	var obj = new ajaxObject(linkComp[0], fin);

// 	obj.update(linkComp[1],"GET");

// 	obj.callback = function (responseTxt, responseStat) {

// 		// we'll do something to process the data here.

// 		result = responseTxt.split("::");

// 		document.getElementById('bs_width').value = result[0]; 

// 		document.getElementById('bs_height').value = result[1];

// 	}

// }


function getHeightAndWidthBS(element){
    var position_id = element.value;
    var link = SITE_URL + 'remote.php?action=getheightandwidth&position_id=' + position_id;
    var linkComp = link.split("?");
    var result;

    var obj = new ajaxObject(linkComp[0], fin);
    obj.update(linkComp[1], "GET");
    obj.callback = function(responseTxt, responseStat){
        result = responseTxt.split("::");

        // Find the banner block container for this element
        $(element).parent().parent().next().next('tr').find('input').val(result[0]);
		$(element).parent().parent().next().next().next().next('tr').find('input').val(result[1]);
    }
}






/*  Amol Function End*/



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

	}

}



function getCityOptionsUser(city_id)

{

	var state_id = document.getElementById('state_id').value;

	link='remote.php?action=getcityoptionsuser&state_id='+state_id+'&city_id='+city_id;

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



function getStateOptionsMultiCMN(idval)

{

	var country_id = document.getElementById(idval+'_country_id').value;

		

	link='remote.php?action=getstateoptionsmulticmn&country_id='+country_id+'&idval='+idval;

	var linkComp = link.split( "?");

	var result;

	var obj = new ajaxObject(linkComp[0], fin);

	obj.update(linkComp[1],"GET");

	obj.callback = function (responseTxt, responseStat) {

		// we'll do something to process the data here.

		result = responseTxt;

		document.getElementById('tdstate_'+idval).innerHTML = result;  

		getCityOptionsMultiCMN(idval);

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



function getCityOptionsMultiCMN(idval)

{

	var country_id = document.getElementById(idval+'_country_id').value;

	var obj_state_id = document.getElementById(idval+'_state_id');

	var str_state_id = "";

	

	for (var x=0;x<obj_state_id.length;x++)

	{

		if (obj_state_id[x].selected)

		{

			str_state_id = str_state_id + obj_state_id[x].value + "," ;

		}

	}

	//alert(str_state_id);

	

	link='remote.php?action=getcityoptionsmulticmn&country_id='+country_id+'&state_id='+str_state_id+'&idval='+idval;

	var linkComp = link.split( "?");

	var result;

	var obj = new ajaxObject(linkComp[0], fin);

	obj.update(linkComp[1],"GET");

	obj.callback = function (responseTxt, responseStat) {

		// we'll do something to process the data here.

		result = responseTxt;

		document.getElementById('tdcity_'+idval).innerHTML = result;  

		getPlaceOptionsMultiCMN(idval);

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



function getPlaceOptionsMultiCMN(idval)

{

	var country_id = document.getElementById(idval+'_country_id').value;

	var obj_state_id = document.getElementById(idval+'_state_id');

	var str_state_id = "";

	var obj_city_id = document.getElementById(idval+'_city_id');

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

	

	link='remote.php?action=getplaceoptionsmulticmn&country_id='+country_id+'&state_id='+str_state_id+'&city_id='+str_city_id+'&idval='+idval;

	var linkComp = link.split( "?");

	var result;

	var obj = new ajaxObject(linkComp[0], fin);

	obj.update(linkComp[1],"GET");

	obj.callback = function (responseTxt, responseStat) {

		// we'll do something to process the data here.

		result = responseTxt;

		document.getElementById('tdplace_'+idval).innerHTML = result;  

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



function IsNumeric(strString)

{

	var strValidChars = "0123456789.";

	var strChar;

	var blnResult = true;

	

	if (strString.length == 0) return false;

	

	//  test strString consists of valid characters listed above

	for (i = 0; i < strString.length && blnResult == true; i++)

	{

		strChar = strString.charAt(i);

		if (strValidChars.indexOf(strChar) == -1)

		{

			blnResult = false;

		}

	}

	return blnResult;

}



function fn_switch_box(id)

{

	elm = document.getElementById(id);

	if (!elm) {

		return false;

	}



	// visible

	if (elm.style.display == '') 

	{

		elm.style.display = 'none';

	} 

	else 

	{

		elm.style.display = '';

	}



	document.getElementById('img_open_'+id).style.display = (elm.style.display == 'none') ? '' : 'none';

	document.getElementById('img_close_'+id).style.display = elm.style.display;

}



function fn_redirect(url)

{

	if (document.getElementsByTagName('base')[0]) {

		url = document.getElementsByTagName('base')[0].href + url;

	}

	window.location.href = url;

}



function fn_confirmdelete(type,url)

{

	Choice = confirm("Are you sure to delete this "+type+ " ?");

	if (Choice == true)

	{

		window.location = url;

	}

	else

	{

		window.location = '';

	}

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
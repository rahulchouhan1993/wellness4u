<?php

require_once('../classes/config.php');

require_once('../classes/vendor.php');

$admin_main_menu_id = '11';

$add_action_id = '21';



$obj = new Vendor();

$obj2 = new commonFunctions();

if(!$obj->isVendorLoggedIn())

{

	header("Location: login.php");

	exit(0);

}

else

{

	$adm_vendor_id = $_SESSION['adm_vendor_id'];

}



$vendor_details = $obj->getVendorUserDetails($adm_vendor_id);



if(!$obj->chkIfAccessOfMenu($adm_vendor_id,$admin_main_menu_id))

{

        

	header("Location: invalid.php");

	exit(0);

}



if(!$obj->chkIfAccessOfMenuAction($adm_vendor_id,$add_action_id))

{

        

	header("Location: invalid.php");

	exit(0);

}





$va_id = $obj->getVendorVAID($adm_vendor_id);

$vaf_id = $obj->getVendorAccessFormIdFromVAIDAndVAFAMID($va_id,$admin_main_menu_id);

if($vaf_id > 0)

{

	$arr_vaff_record = $obj->getVendorAccessFormFieldsDetails($vaf_id);

	if(count($arr_vaff_record) == 0)

	{

		//echo '111111111111111111';

                //echo 'hii';die();

		header("Location: invalid.php");

		exit(0);

	}

}

else

{

	//echo '222222222222';

    //echo 'bbb';die();

	header("Location: invalid.php");

	exit(0);

}


//$data_dropdown = $obj->GETDATADROPDOWNMYDAYTODAYOPTION($vendor_details['vendor_cat_id'],'151');
// custom function write by ample 27-12-19
//$final_dropdown=$obj->FilterDataDropdown($data_dropdown);

//add by ample 09-10-20
    $tags=$obj->GETDATADROPDOWNMYDAYTODAYOPTION_ForEventTags($vendor_details['vendor_cat_id'],211);

$error = false;

$err_msg = "";

$msg = '';



$cat_cnt = 0;

$cat_total_cnt = 1;



$data = $obj->getPageCatDropdownValue('151',$vendor_details['vendor_cat_id']);



if(!empty($data))

{

        $profile_cat1 = '';

        $profile_cat2 ='';

        $profile_cat3 ='';

        $profile_cat4 ='';

        $profile_cat5 ='';

        

        $fav_cat_id1_val = explode(',', $data['prof_cat1']);

        $fav_cat_id2_val = explode(',', $data['prof_cat2']);

        $fav_cat_id3_val = explode(',', $data['prof_cat3']);

        $fav_cat_id4_val = explode(',', $data['prof_cat4']);

        $fav_cat_id5_val = explode(',', $data['prof_cat5']);

        

        $fav_cat_id1 = implode('\',\'', $fav_cat_id1_val);

        $fav_cat_id2 = implode('\',\'', $fav_cat_id2_val);

        $fav_cat_id3 = implode('\',\'', $fav_cat_id3_val);

        $fav_cat_id4 = implode('\',\'', $fav_cat_id4_val);

        $fav_cat_id5 = implode('\',\'', $fav_cat_id5_val);

 

        

        if($data['prof_cat1']!=''){

                $profile_cat1 = $obj->getMoreFavCategoryTypeOptions($fav_cat_id1,'');

        }

        if($data['prof_cat2']!=''){

               $profile_cat2 =$obj->getMoreFavCategoryTypeOptions($fav_cat_id2,'');

        }

        if($data['prof_cat3']!=''){

              $profile_cat3 =$obj->getMoreFavCategoryTypeOptions($fav_cat_id3,'');

        }

        if($data['prof_cat4']!=''){

             $profile_cat4 =$obj->getMoreFavCategoryTypeOptions($fav_cat_id4,'');

        }

        if($data['prof_cat5']!=''){

            $profile_cat5 =$obj->getMoreFavCategoryTypeOptions($fav_cat_id5,'');

        }

}



?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Business Associates</title>

	<?php require_once 'head.php'; ?>

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-sm-10">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>

						</div>

					</div>

					<hr>

					<center><div id="error_msg"></div></center>

					<form role="form" class="form-horizontal" id="add_event" name="add_event" method="post" > 

						<input type="hidden" name="va_id" id="va_id" value="<?php echo $va_id;?>">

						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">

						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">

						<input type="hidden" name="loc_cnt" id="loc_cnt" value="<?php echo $loc_cnt;?>">

						<input type="hidden" name="loc_total_cnt" id="loc_total_cnt" value="<?php echo $loc_total_cnt;?>">

						<input type="hidden" name="cw_cnt" id="cw_cnt" value="<?php echo $cw_cnt;?>">

						<input type="hidden" name="cw_total_cnt" id="cw_total_cnt" value="<?php echo $cw_total_cnt;?>">

						<input type="hidden" name="healcareandwellbeing" id="healcareandwellbeing" value="<?php echo $vendor_details['vendor_cat_id']; ?>">

                                                <div class="form-group">

                                                

						<?php

                                                

                                                $default_vloc_parent_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'location_category');

						$vloc_parent_cat_id = $default_vloc_parent_cat_id;

						$default_vloc_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'location_sub_category');

                                                

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'reference_number'))

						{ ?>

							<label class="col-lg-2 control-label">Reference Number :</label>

							<div class="col-lg-2">

                                                            <input type="text" name="reference_number" readonly="" id="reference_number" value="<?php echo $obj->getnextrefernceNumber(); ?>" >

                                                            

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="item_id" id="item_id" value="<?php echo $item_id;?>">	

						<?php

						} ?>							

						

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'wellbeing_id'))

						{ ?>

							<label class="col-lg-3 control-label">System Category:</span></label>

                                                        <div class="col-lg-3">

                                                            <?php echo $obj->getFavCatNameById($vendor_details['vendor_cat_id']); ?>

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="healcareandwellbeing" id="healcareandwellbeing" value="">	

						<?php

						} ?>	

						</div>

                                                

                                                <div class="form-group">

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'institution_id'))

						{ ?>

							<label class="col-lg-2 control-label">Institution<span style="color:red">*</span></label>

							<div class="col-lg-4">

<!--								<select name="institution_id" id="institution_id" class="form-control" required>

									<?php //echo $obj->getVendorOption($institution_id,$type='1',$multiple='0');?>

								</select>-->

                                                            <input type="text" name="institution_id" id="institution_id" value="<?php echo $institution_id; ?>" class="form-control" >

							</div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="institution_id" id="institution_id" value="<?php echo $institution_id;?>">	

						<?php

						} ?>							

						

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'sponsor_id'))

						{ ?>

							<label class="col-lg-2 control-label">Sponsor Name</label>

							<div class="col-lg-4">

<!--                                                            <select name="sponsor_id" id="sponsor_id" class="form-control">

									<?php //echo $obj->getVendorOption($sponsor_id,$type='1',$multiple='0');?>

                                                            </select>-->

                                                            <input type="text" name="sponsor_id" id="sponsor_id" value="<?php echo $arr_record['sponsor_id']; ?>" class="form-control" required>

							</div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="sponsor_id" id="sponsor_id" value="<?php echo $sponsor_id;?>">	

						<?php

						} ?>	

						</div>

                                                

                                                <div class="form-group">

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'event_name'))

						{ ?>

							<label class="col-lg-2 control-label">Event Name<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<input type="text" name="event_name" id="event_name" value="<?php echo $event_name;?>" placeholder="Event Name" class="form-control" required>

							</div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="event_name" id="event_name" value="<?php echo $event_name;?>">	

						<?php

						} ?>							

						

						<label class="col-lg-2 control-label"><?=($tags['tag_heading'])? $tags['tag_heading'] : 'Event Tags';?></label>

                                                        <div class="col-lg-4">

                                                                <select name="event_tags[]" id="event_tags" multiple="multiple" class="form-control vloc_speciality_offered" >

                                                                         <!-- <?php echo $final_dropdown; ?> -->

                                                                   <?php 

                                                                        if(!empty($tags['tag_data']))
                                                                         {
                                                                            foreach ($tags['tag_data'] as $key => $value) {
                                                                                $sel="";
                                                                                ?>
                                                                                <option value="<?=$value;?>" <?=$sel?> ><?=$value;?></option>
                                                                                <?php
                                                                            }
                                                                         }

                                                                        ?>

                                                                   ?>

                                                                </select>

                                                        </div>	

						</div>

                                                

                                                <div class="form-group">

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'event_contents'))

						{ ?>

							 <div class="form-group"><label class="col-lg-2 control-label">Events Contents<span style="color:red">*</span></label>

							<div class="col-lg-10">

								<div class="summernote-theme-1">

									<div class="event_contents" name="event_contents" id="event_contents"><?php echo $event_contents;?></div>

								</div>

							</div>

                                                    </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="event_contents" id="event_contents" value="<?php echo $event_contents;?>">	

						<?php

						} ?>							

						

						

						</div>

                                               

                                                

                                                 <div class="form-group">

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'prof_cat_id_1'))

						{ ?>

							<label class="col-lg-2 control-label" id="prof_header1"><?php echo $data['header1'];?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_1" class="form-control" id="profile_cat_1"  onchange="getMainCategoryOptionAddMoreSingle('1')">

                                                           

                                                            <?php echo $profile_cat1 ;?>

                                                            </select>

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="profile_cat_1" id="profile_cat_1" value="<?php echo $profile_cat_1;?>">	

						<?php

						} ?>							

						

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'fav_cat_id_1'))

						{ ?>

							<label class="col-lg-2 control-label">Fav Category</label>

                                                        <div class="col-lg-4" id="">

                                                            <select name="fav_cat_1[]" class="form-control" id="fav_cat_1" >

                                                                <option value="">Select Sub Cat</option>

                                                            </select>

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="fav_cat_1" id="fav_cat_1" value="<?php echo $fav_cat_1;?>">	

						<?php

						} ?>	

						</div>

                                                

                                                <div class="form-group">

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'prof_cat_id_2'))

						{ ?>

							<label class="col-lg-2 control-label" id="prof_header1"><?php echo $data['header2']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_2" class="form-control" id="profile_cat_2"  onchange="getMainCategoryOptionAddMore('2')">

                                                           	

                                                           <?php echo $profile_cat2 ;?>

                                                            </select>

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="profile_cat_2" id="profile_cat_2" value="<?php echo $profile_cat_2;?>">	

						<?php

						} ?>							

						

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'fav_cat_id_2'))

						{ ?>

							<label class="col-lg-2 control-label">Fav Category</label>

                                                        <div class="col-lg-4" id="fav_cat_2">

                                                            <select name="fav_cat_2" class="form-control" id="fav_cat_2" >

                                                                <option value="">Select Sub Cat</option>

                                                            </select>

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="fav_cat_2" id="fav_cat_2" value="<?php echo $fav_cat_2;?>">	

						<?php

						} ?>	

						</div>

                                                <div class="form-group">

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'prof_cat_id_3'))

						{ ?>

							<label class="col-lg-2 control-label" id="prof_header1"><?php echo $data['header3']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_3" class="form-control" id="profile_cat_3"  onchange="getMainCategoryOptionAddMore('3')">

                                                           

                                                            <?php echo $profile_cat3 ;?>

                                                            </select>

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="profile_cat_3" id="profile_cat_3" value="<?php echo $profile_cat_3;?>">	

						<?php

						} ?>							

						

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'fav_cat_id_3'))

						{ ?>

							<label class="col-lg-2 control-label">Fav Category</label>

                                                        <div class="col-lg-4" id="fav_cat_3">

                                                            <select name="fav_cat_3" class="form-control" id="fav_cat_3" >

                                                                <option value="">Select Sub Cat</option>

                                                            </select>

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="fav_cat_3" id="fav_cat_3" value="<?php echo $fav_cat_3;?>">	

						<?php

						} ?>	

						</div>

                                                

                                                <div class="form-group">

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'prof_cat_id_4'))

						{ ?>

							<label class="col-lg-2 control-label" id="prof_header1"><?php echo $data['header4']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_4" class="form-control" id="profile_cat_4"  onchange="getMainCategoryOptionAddMore('4')">

                                                            	

                                                            <?php echo $profile_cat4 ;?>

                                                            </select>

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="profile_cat_4" id="profile_cat_4" value="<?php echo $profile_cat_4;?>">	

						<?php

						} ?>							

						

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'fav_cat_id_4'))

						{ ?>

							<label class="col-lg-2 control-label">Fav Category</label>

                                                        <div class="col-lg-4" id="fav_cat_4">

                                                            <select name="fav_cat_4" class="form-control" id="fav_cat_4" >

                                                                <option value="">Select Sub Cat</option>

                                                            </select>

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="fav_cat_4" id="fav_cat_4" value="<?php echo $fav_cat_4;?>">	

						<?php

						} ?>	

						</div>

                                                

                                                <div class="form-group">

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'prof_cat_id_5'))

						{ ?>

							<label class="col-lg-2 control-label" id="prof_header1"><?php echo $data['header5']; ?></label>

                                                        <div class="col-lg-4">

                                                            <select name="profile_cat_5" class="form-control" id="profile_cat_5"  onchange="getMainCategoryOptionAddMore('5')">

                                                           

                                                            <?php echo $profile_cat5 ;?>

                                                            </select>

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="profile_cat_5" id="profile_cat_5" value="<?php echo $profile_cat_5;?>">	

						<?php

						} ?>							

						

						<?php

						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'fav_cat_id_5'))

						{ ?>

							<label class="col-lg-2 control-label">Fav Category</label>

                                                        <div class="col-lg-4" id="fav_cat_5">

                                                            <select name="fav_cat_5" class="form-control" id="fav_cat_5" >

                                                                <option value="">Select Sub Cat</option>

                                                            </select>

                                                        </div>

						<?php

						}

						else

						{ ?>

							<input type="hidden" name="fav_cat_5" id="fav_cat_5" value="<?php echo $fav_cat_5;?>">	

						<?php

						} ?>	

						</div>


						<hr>

						<button type="button" data-toggle="popover" data-placement="right" data-content="Available after submit event" class="btn btn-success rounded">ADD Event-Location details</button> 

						<hr>


						<div class="form-group">

							<div class="col-lg-offset-3 col-lg-10">

								<div class="pull-left">

									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>

                       <!-- <button class="btn btn-success rounded" type="button" style="display: block" id="loader"><img src="assets/img/fancybox_loading.gif" > processing..</button> -->

									<a href="manage_cusines.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>



                    <img border="0" class="image_load" src="<?php echo SITE_URL.'/images/loading.gif'?>" style=" width: 6%; display: none; float: right; margin-right:75%;">

								</div>

							</div>

						</div>

					</form>

				</div>

			</div>

		</div>
		<div class="col-sm-2"><?php include_once('wa_right_sidebar.php'); ?></div>
	</div>

</div>

<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>

<script type="text/javascript" src="js/jquery.validate.min.js"></script>

<script src="js/tokenize2.js"></script>

<script src="admin-js/add-event-validator.js" type="text/javascript"></script>

<script>

$(document).ready(function()

{ 

        $('#event_contents').summernote();

        $('.vloc_speciality_offered').tokenize2();

	$('.clsdatepicker').datepicker();

        $('.clsdatepicker2').datepicker();

        $("input[name^='vc_cert_reg_date']").attr('autocomplete', 'off');

        $("input[id^='capitals']").attr('autocomplete', 'off');

        $("input[id^='vc_cert_validity_date']").attr('autocomplete', 'off');

        $("input[id^='start_date']").attr('autocomplete', 'off');

        $("input[id^='end_date']").attr('autocomplete', 'off');

        $("input[id^='judge_cert_reg_date']").attr('autocomplete', 'off');

        $("input[id^='judge_cert_validity_date']").attr('autocomplete', 'off');

        $("input[id^='org_cert_reg_date']").attr('autocomplete', 'off');

        $("input[id^='org_cert_validity_date']").attr('autocomplete', 'off');

       

});





function getStateOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		

                //alert(country_id);

                

		if(country_id == null)

		{

			country_id = '-1';

		}

		

		if(state_id == null)

		{

			state_id = '-1';

		}

		

		

		var dataString ='country_id='+country_id+'&state_id='+state_id+'&action=getstateoption';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

                               // alert(result);

				$("#state_id_"+id_val).html(result);

                                $('#city_id_'+id_val).val('');

				getCityOptionAddMore(id_val);

			}

		});

	}

	

	function getCityOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		var city_id = $('#city_id_'+id_val).val();

		

		if(country_id == null)

		{

			country_id = '-1';

		}

				

		if(state_id == null)

		{

			state_id = '-1';

		}

		

		if(city_id == null)

		{

			city_id = '-1';

		}

		

		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&action=getcityoption';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

                                //alert(result);

				$("#capitals_"+id_val).html(result);

				getAreaOptionAddMore(id_val);

			}

		});

	}

	

	function getAreaOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		var city_id = $('#city_id_'+id_val).val();

		var area_id = $('#area_id_'+id_val).val();

		

		if(country_id == null)

		{

			country_id = '-1';

		}

				

		if(state_id == null)

		{

			state_id = '-1';

		}

		

		if(city_id == null)

		{

			state_id = '-1';

		}

		

		if(area_id == null)

		{

			area_id = '-1';

		}

		

		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&action=getareaoption';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

				$("#area_id_"+id_val).html(result);

			}

		});

	}


function getMainCategoryOptionAddMore(id)

    {

           // alert(id);

            var parent_cat_id = $("#profile_cat_"+id).val();

            //var sub_cat = $("#fav_cat_id_"+idval).val();

            //alert(parent_cat_id);

             var dataString = 'action=FavcategoryByprofCatEvent&parent_cat_id='+parent_cat_id+'&id_no='+id;

            

           $.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

                         //alert(result);  

			$("#fav_cat_"+id).html(result);

			

		}

	});

    }

    function getlocation(id_val)

       {

           var city = $("#city_id_"+id_val).val();

           //alert(city);

            var dataString ='city='+city+'&action=getlocation';

            $.ajax({

                   type: "POST",

                    url: 'ajax/remote.php', 

                   data: dataString,

                   cache: false,

                   success: function(result)

                        {

                            //alert(result);

                         var JSONObject = JSON.parse(result);

                         //var rslt=JSONObject[0]['status'];   

                        $('#area_id_'+id_val).html(JSONObject[0]['place_option']);

                       }

              }); 

       }

       

function CheckTeamType(idval)

    {

      

      var event_format = $("#event_format_"+idval).val();

      

      if(event_format == '504')

      {

        $('#no_of_teams_level_'+idval).hide();  

        $('#no_of_teams_div_'+idval).hide();  

      }

      else

      {

         $('#no_of_teams_level_'+idval).show();  

         $('#no_of_teams_div_'+idval).show();   

      }

      

    }

    

    function getMainCategoryOptionAddMoreSingle(id)

    {

           // alert(id);

            var parent_cat_id = $("#profile_cat_"+id).val();

            //var sub_cat = $("#fav_cat_id_"+idval).val();

            //alert(parent_cat_id);

             var dataString = 'action=FavcategoryByprofCatEventSingle&parent_cat_id='+parent_cat_id+'&id_no='+id;

            

           $.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

                         //alert(result);  

			$("#fav_cat_"+id).html(result);

			

		}

	});

    }

   $('[data-toggle="popover"]').popover();   

</script>

</body>

</html>
<?php

require_once('../classes/config.php');

require_once('../classes/admin.php');

$admin_main_menu_id = '16';

$edit_action_id = '45';



$obj = new Admin();

$obj2 = new commonFunctions();

if(!$obj->isAdminLoggedIn())

{

	header("Location: login.php");

	exit(0);

}

else

{

	$admin_id = $_SESSION['admin_id'];

}



if(!$obj->chkIfAccessOfMenu($admin_id,$admin_main_menu_id))

{

	header("Location: invalid.php");

	exit(0);

}



if(!$obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))

{

	header("Location: invalid.php");

	exit(0);

}



$error = false;

$err_msg = "";

$msg = '';



// if(isset($_POST['add_sponsor']))

// {

// 	$sponsor_value=$_POST['sponsor_value'];



// 	echo "<pre>";print_r($sponsor_value);echo "</pre>";

// }









if(isset($_GET['token']) && $_GET['token'] != '')

{

	$vendor_id = base64_decode($_GET['token']);

	$arr_record = $obj->getVendorDetails($vendor_id);

	if(count($arr_record) == 0)

	{

		header("Location: manage_vendors.php");

		exit(0);

	}

	

	$vendor_parent_cat_id = $arr_record['vendor_parent_cat_id'];

	$vendor_cat_id = $arr_record['vendor_cat_id'];

	$vendor_name = $arr_record['vendor_name'];

        

	$vendor_username = $arr_record['vendor_username'];

	$vendor_status = $arr_record['vendor_status'];

        

        $vendor_email = $arr_record['vendor_email'];

        $vendor_mobile = $arr_record['vendor_mobile'];



        $sponsor=$arr_record['participant_profile'];



    $food_products_offered =  explode(',', $arr_record['food_products_offered']); //add by ample 18-09-20
        

	$va_cat_name = $obj->getProfileCategoryName($arr_record['vendor_parent_cat_id']);

        $va_sub_cat_name = $obj->getSubCategoryName($arr_record['vendor_cat_id']);

	$vendor_loc_data = $obj->getVendorAllLocationsAndCertifications($vendor_id);

	//add by ample 18-09-20
	$tag_level_1=$obj->GETDATADROPDOWNMYDAYTODAYOPTION_ForTags($arr_record['vendor_cat_id'],39,1);
	$tag_level_2=$obj->GETDATADROPDOWNMYDAYTODAYOPTION_ForTags($arr_record['vendor_cat_id'],39,2);
	

	// echo '<br><pre>';

	// print_r($vendor_loc_data);

	// echo '<br></pre>';

	// die();

	

}	

else

{

	header("Location: manage_vendors.php");

	exit(0);

}	

?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Admin</title>

	<?php require_once 'head.php'; ?>

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-md-12">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($edit_action_id);?></h3>

						</div>

						 <div class="col-md-6 text-right">
                                        <?php 
                                           if($vendor_status==1)
                                           {
                                             ?>
                                             <button class="btn btn-danger" type="button" onclick="vendorStatus(<?=$vendor_id;?>,0)">Inactivate</button>
                                             <?php
                                           }
                                           else
                                           {
                                            ?>
                                             <button class="btn btn-success" type="button" onclick="vendorStatus(<?=$vendor_id;?>,1)">Activate</button>
                                             <?php
                                           }
                                           ?>
                        </div>

					</div>

					<hr>

					<center><div id="error_msg"></div></center>

					<form role="form" class="form-horizontal" id="edit_vendor" name="edit_vendor" method="post"> 

						<input type="hidden" name="hdnvendor_id" id="hdnvendor_id" value="<?php echo $vendor_id;?>" >

						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">

						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">

                                                <input type="hidden" name="vendor_parent_cat_id" id="vendor_parent_cat_id" value="<?php echo $vendor_parent_cat_id; ?>">

						<input type="hidden" name="vendor_cat_id" id="vendor_cat_id" value="<?php echo $vendor_cat_id; ?>">

<!--						<div class="form-group">

							<label class="col-lg-2 control-label">Category<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<select name="vendor_parent_cat_id" id="vendor_parent_cat_id" class="form-control" onchange="getMainCategoryOptionCommon('vendor','1');" required  >

								  <?php //echo $obj->getMainProfileOption($vendor_parent_cat_id);?>

                                                                    <?php //echo $obj->getEventCategoryRamakant('39',$vendor_parent_cat_id);?>

                                                                    <?php //echo $obj->getvendoraccesdropdownmain($vendor_parent_cat_id);?>

								</select>

							</div>

							<div class="col-lg-2"></div>

							<div class="col-lg-4">

								<select name="vendor_cat_id" id="vendor_cat_id" class="form-control" required>

									<?php //echo $obj->getMainCategoryOption($vendor_parent_cat_id,$vendor_cat_id); ?>

								</select>

							</div>

						</div>-->

						

                          <div class="form-group">

							<label class="col-lg-2 control-label">Category<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<?php echo $va_cat_name; ?>

							</div>

							<div class="col-lg-2"></div>

							<div class="col-lg-4">

                                                            <?php echo $va_sub_cat_name; ?>

							</div>

						</div>

                                                

						<div class="form-group"><label class="col-lg-2 control-label">Company Name<span style="color:red">*</span></label>

							<div class="col-lg-10">

								<input type="text" name="vendor_name" id="vendor_name" value="<?php echo $vendor_name;?>" placeholder="Company Name" class="form-control" required>

							</div>

						</div>

						

						<div class="form-group">

							<label class="col-lg-2 control-label">Username<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<input type="text" name="vendor_username" id="vendor_username" value="<?php echo $vendor_username;?>" placeholder="Vendor Username" class="form-control" required>

							</div>

							

							<label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<select name="vendor_status" id="vendor_status" class="form-control">

									<option value="1" <?php if($vendor_status == '1'){?> selected <?php } ?>>Active</option> 

									<option value="0" <?php if($vendor_status == '0'){?> selected <?php } ?>>Inactive</option> 

								</select>

							</div>

						</div>







                         <div class="form-group">

						<label class="col-lg-2 control-label">Admin Email<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<input type="text" name="vendor_email" id="vendor_email" value="<?php echo $vendor_email;?>" placeholder="Vendor Email" class="form-control" required>

							</div>





						

						<label class="col-lg-2 control-label">Admin Mobile<span style="color:red">*</span></label>

							<div class="col-lg-4">

								<input type="text" name="vendor_mobile" id="vendor_mobile" value="<?php echo $vendor_mobile;?>" placeholder="Vendor Mobile" class="form-control" required>

                                                                

                            </div>                        

						</div>

						<div class="form-group">
                              <label class="col-lg-2 control-label"><?=($tag_level_1['tag_heading'])? $tag_level_1['tag_heading'] : 'Speciality';?></label>
                              <div class="col-lg-10">
                                 <select name="food_products_offered[]" id="speciality_offered" multiple="multiple" class="form-control vloc_speciality_offered" >
                                            <?php //echo $obj->getFavCategoryVendorEdit('13,53,42,64',$food_products_offered); 

                                             if(!empty($tag_level_1['tag_data']))
                                             {
                                             	foreach ($tag_level_1['tag_data'] as $key => $value) {
                                             		$sel="";
                                             		if (in_array($value, $food_products_offered))
													  {
													  	$sel="selected";
													  }
													?>
                                             		<option value="<?=$value;?>" <?=$sel?> ><?=$value;?></option>
                                             		<?php
                                             	}
                                             }

                                            ?>

                                 </select>
                              </div>
                           </div>



						<div class="container">

							<div class="row">

						<div class="form-group">

						 <label class="col-lg-2 control-label">Participant Profile<span style="color:red">*</span></label>

                             <div class="col-lg-4">

                                    <?php echo $obj->getusersponsor('69','0','300','150',$sponsor);?>

                            </div>



                             <div class="col-lg-12">



                             	<button type="button" class="btn btn-default" onclick="return addSponser('<?php echo $_GET['token'];?>');" style="float: right; margin-right: 13%;margin-top: 3%;">Add</button>

                        	  <!-- <input type="Submit" name="add_sponsor" value="Add" style="float: right; margin-right: 13%;margin-top: 3%;"> -->

                        </div>

                        </div>

						</div>



						</div>

					<?php if($arr_record['add_type']  == 'Admin') { ?>

					<hr>
                    <a href="add_location_contact.php?vendor=<?=$_GET['token']?>" target="_blank" class="pull-right"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">ADD Company-Location details</button></a>

                      <?php } ?>

                    <br>
                    <table class="table table-bordered" style="margin-top: 15px;">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Services</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(!empty($vendor_loc_data))
                            {
                                foreach ($vendor_loc_data as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><?=$key+1;?></td>
                                        <td><?=$obj->getProfileCategoryName($value['vloc_parent_cat_id']);?> <br>
                                        	<?=$obj->getFavCategoryNameVivek($value['vloc_cat_id']);?>
                                        </td>
                                        <td>
                                            <b>Area: </b> <?=$obj->getAreaName($value['area_id']);?> &nbsp;
                                            <b>City: </b> <?=$obj->GetCityName($value['city_id']);?> &nbsp;
                                            <br>
                                            <b>State: </b> <?=$obj->GetStateName($value['state_id']);?> &nbsp;
                                            <b>Country: </b> <?=$obj->GetCountryName($value['country_id']);?> &nbsp;
                                        </td>
                                        <td>
                                            <?=$value['vloc_speciality_offered'];?>
                                        </td>
                                        <td>
                                            <?=($value['vloc_status']==1)? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';?>
                                        </td>
                                        <td>

                                        	<?php if($arr_record['add_type']  == 'Admin') { ?>
                                            
                                            <a href="edit_location_contact.php?vendor=<?=$_GET['token']?>&token=<?=base64_encode($value['vloc_id']);?>" target="_blank"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">Edit</button></a>

                                            <?php } 
                                            else
                                            {
                                            	?>
                                            	<a href="edit_location_contact.php?vendor=<?=$_GET['token']?>&token=<?=base64_encode($value['vloc_id']);?>" target="_blank"><button class="btn btn-success rounded" type="button" name="btnSubmit" id="btnSubmit">View</button></a>
                                            	<?php
                                            }

                                            ?>

                                            <?php 
                                           if($value['vloc_status']==1)
                                           {
                                             ?>
                                             <button class="btn btn-danger rounded" type="button" onclick="vendorLocationStatus(<?=$value['vloc_id'];?>,0)">Inactivate</button>
                                             <?php
                                           }
                                           else
                                           {
                                            ?>
                                             <button class="btn btn-success rounded" type="button" onclick="vendorLocationStatus(<?=$value['vloc_id'];?>,1)">Activate</button>
                                             <?php
                                           }
                                           ?>
                                            
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <tr><td colspan="6" class="text-center">No vendor location found</td></tr>
                                <?php
                            }
                            ?>
                        </tbody>
                      </table>

						
						

						

						<hr>

						<div class="form-group">

							<div class="col-lg-offset-3 col-lg-10">

								<div class="pull-left">

                                                                        <?php if($arr_record['add_type']  == 'Admin') { ?>

									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>

                                                                        <?php } ?>

                                                                        <a href="manage_vendors.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>

								</div>

							</div>

						</div>

					</form>	

				</div>	

			</div>

		</div>

	</div>

</div>

<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>

<script type="text/javascript" src="js/jquery.validate.min.js"></script>

<script src="js/tokenize2.js"></script>

<script src="admin-js/edit-vendor-validator.js" type="text/javascript"></script>

<script>

	$(document).ready(function()

	{

		$('.vloc_speciality_offered').tokenize2();

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

                $("input[name^='city_id']").attr('autocomplete', 'off');

                $("input[name^='vc_cert_reg_date']").attr('autocomplete', 'off');

                $("input[id^='capitals']").attr('autocomplete', 'off');

                $("input[id^='vc_cert_validity_date']").attr('autocomplete', 'off');

               

	});	

	

	function getStateOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		

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

				$("#state_id_"+id_val).html(result);

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

				//$("#city_id_"+id_val).html(result);

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



	function addMoreRowCertificate(i_val)

	{

		

		var cert_cnt = parseInt($("#cert_cnt_"+i_val).val());

		

		cert_cnt = cert_cnt + 1;

		var new_row = '	<div id="row_cert_'+i_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

							'<input type="hidden" name="vc_cert_id_'+i_val+'[]" id="vc_cert_id_'+i_val+'_'+cert_cnt+'" value="0">'+

							'<input type="hidden" name="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" id="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" value="">'+

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>'+

								'<div class="col-lg-5">'+

									'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control" required>'+

										'<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

									'</select>'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Name</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Number</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Issued By</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Issued Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Vaidity Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

								'</div>'+

							'</div>'+

							'<div class="form-group small-title">'+

									'<label class="col-lg-1 control-label">Scan Image</label>'+

									'<div class="col-lg-5">'+

										'<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+

									'</div>'+

								'</div>'+

							'<div class="form-group">'+

								'<div class="col-lg-2">'+

									'<a href="javascript:void(0);" onclick="removeRowCertificate('+i_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

								'</div>'+

							'</div>'+

						'</div>';

		

		$("#row_cert_"+i_val+"_first").after(new_row);

		$("#cert_cnt_"+i_val).val(cert_cnt);

		

		var cert_total_cnt = parseInt($("#cert_total_cnt_"+i_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+i_val).val(cert_total_cnt);

		

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

	}

	

	function removeRowCertificate(i_val,cert_cnt)

	{

		$("#row_cert_"+i_val+"_"+cert_cnt).remove();



		var cert_total_cnt = parseInt($("#cert_total_cnt_"+i_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+i_val).val(cert_total_cnt);

		

	}

		

	function addMoreRowLocation()

	{

		

		var cat_cnt = parseInt($("#cat_cnt").val());

		cat_cnt = cat_cnt + 1;

		

		var i_val = cat_cnt;

		var cert_cnt = 0;

		var new_row = 	'<div id="row_loc_'+cat_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

							'<input type="hidden" name="cert_cnt_'+cat_cnt+'" id="cert_cnt_'+cat_cnt+'" value="'+cert_cnt+'">'+

							'<input type="hidden" name="cert_total_cnt_'+cat_cnt+'" id="cert_total_cnt_'+cat_cnt+'" value="1">'+

							'<input type="hidden" name="cert_loop_cnt[]" id="cert_loop_cnt_'+cat_cnt+'" value="'+cat_cnt+'">'+

							'<input type="hidden" name="hdnvloc_doc_file[]" id="hdnvloc_doc_file_'+cat_cnt+'" value="">'+

							'<input type="hidden" name="hdnvloc_menu_file[]" id="hdnvloc_menu_file_'+cat_cnt+'" value="">'+

							'<input type="hidden" name="vloc_id[]" id="vloc_id_'+cat_cnt+'" value="0">'+

                                                        '<input type="hidden" name="hdn_default_cat_id" id="hdn_default_cat_id_'+cat_cnt+'" value="<?php echo $default_vloc_cat_id; ?>">'+

							'<div class="form-group left-label">'+

								'<label class="col-lg-3 control-label"><strong>Location and Contact Details:</strong></label>'+

							'</div>'+

							'<div class="form-group">'+

								'<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" class="form-control"  onchange="getMainCategoryOptionAddMoreCommonLOCPlus(\'vloc\','+cat_cnt+');" required  >'+

										'<?php echo $obj2->getMainProfileOptionLOC($arr_vloc_parent_cat_id[0],'1','0',$default_vloc_parent_cat_id);?>'+

									'</select>'+

								'</div>'+

								'<div class="col-lg-2"></div>'+

								'<div class="col-lg-4">'+

									'<select name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" class="form-control" required>'+

										'<?php echo $obj->getMainCategoryOptionLOC($arr_vloc_parent_cat_id[0],$arr_vloc_cat_id[0],'1','',$default_vloc_cat_id); ?>'+

									'</select>'+

								'</div>'+

							'</div>'+

							'<div class="form-group" >'+	

								'<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select name="country_id[]" id="country_id_'+cat_cnt+'" onchange="getStateOptionAddMore('+cat_cnt+')" class="form-control" required>'+

										'<?php echo $obj->getCountryOption(''); ?>'+

									'</select>'+

								'</div>'+

								'<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select name="state_id[]" id="state_id_'+cat_cnt+'" onchange="getCityOptionAddMore('+cat_cnt+')" class="form-control" required>'+

										'<?php echo $obj->getStateOption('',''); ?>'+

									'</select>'+

								'</div>'+

							'</div>'+

							'<div class="form-group">'+	

								'<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

                                                                        '<input type="text" required="" name="city_id[]" id="city_id_'+cat_cnt+'" placeholder="Select your city" list="capitals_'+cat_cnt+'" class="form-control" onchange="getlocation('+cat_cnt+')" />'+

									'<datalist id="capitals_'+cat_cnt+'">'+

                                                                    '</datalist>'+

								'</div>'+

								'<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select name="area_id[]" id="area_id_'+cat_cnt+'" class="form-control" required>'+

										'<?php echo $obj->getAreaOption('','','',''); ?>'+

									'</select>'+

								'</div>'+

							'</div>'+

							'<div class="form-group">'+

								'<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select name="contact_person_title[]" id="contact_person_title_'+cat_cnt+'" class="form-control" required>'+

										'<?php echo $obj->getPersonTitleOption('');?>'+

									'</select>'+

								'</div>'+

								

								'<label class="col-lg-2 control-label">Contact Person<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="contact_person[]" id="contact_person_'+cat_cnt+'" value="" placeholder="Contact Person" class="form-control" required>'+

								'</div>'+

							'</div>'+

							

							'<div class="form-group">'+

								'<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="contact_email[]" id="contact_email_'+cat_cnt+'" value="" placeholder="Contact Email" class="form-control" >'+

								'</div>'+

								

								'<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="contact_number[]" id="contact_number_'+cat_cnt+'" value="" placeholder="Contact Number" class="form-control" >'+

								'</div>'+

							'</div>'+

						

							'<div class="form-group">'+

								'<label class="col-lg-2 control-label">Contact Designation</label>'+

								'<div class="col-lg-4">'+

									'<select name="contact_designation[]" id="contact_designation_'+cat_cnt+'" class="form-control">'+

										'<?php echo $obj->getFavCategoryRamakant('44','');?>'+

									'</select>'+

								'</div>'+

								

								'<label class="col-lg-2 control-label">Remark</label>'+

								'<div class="col-lg-4">'+

									'<textarea name="contact_remark[]" id="contact_remark_'+cat_cnt+'"  class="form-control"></textarea>'+

								'</div>'+

							'</div>'+

							'<div class="form-group">'+

								'<label class="col-lg-2 control-label">Speciality Offered</label>'+

								'<div class="col-lg-10">'+

									'<select name="vloc_speciality_offered_'+cat_cnt+'[]" id="vloc_speciality_offered_'+cat_cnt+'" multiple="multiple" class="form-control vloc_speciality_offered" >'+

										'<?php echo $obj->getFavCategoryRamakant('13,53,42,64',''); ?>'+

									'</select>'+

								'</div>'+

							'</div>'+	

							'<div class="form-group">'+	

								'<label class="col-lg-2 control-label">Menu Image/Pdf</label>'+

								'<div class="col-lg-4">'+

									'<input type="file" name="vloc_menu_file[]" id="vloc_menu_file_'+cat_cnt+'" class="form-control">'+

								'</div>'+

								

								'<label class="col-lg-2 control-label">Vendor Estt Pdf</label>'+

								'<div class="col-lg-4">'+

									'<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_'+cat_cnt+'" class="form-control">'+

								'</div>'+

							'</div>'+

							

							'<div class="form-group left-label">'+

								'<label class="col-lg-6 control-label"><strong>Licences, Registration, Certification & Memberships:</strong></label>'+

							'</div>'+

							'<div id="row_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

								'<input type="hidden" name="vc_cert_id_'+i_val+'[]" id="vc_cert_id_'+i_val+'_'+cert_cnt+'" value="0">'+

								'<input type="hidden" name="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" id="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" value="">'+

								'<div class="form-group small-title">'+

									'<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>'+

									'<div class="col-lg-5">'+

										'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control" required>'+

											'<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

										'</select>'+

									'</div>'+

									

									'<label class="col-lg-1 control-label">Name</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

									'</div>'+

								'</div>'+	

								'<div class="form-group small-title">'+

									'<label class="col-lg-1 control-label">Number</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

									'</div>'+

									

									'<label class="col-lg-1 control-label">Issued By</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

									'</div>'+

								'</div>'+	

								'<div class="form-group small-title">'+

									'<label class="col-lg-1 control-label">Issued Date</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

									'</div>'+

									

									'<label class="col-lg-1 control-label">Vaidity Date</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

									'</div>'+

								'</div>'+

								'<div class="form-group small-title">'+

										'<label class="col-lg-1 control-label">Scan Image</label>'+

										'<div class="col-lg-5">'+

											'<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+

										'</div>'+

									'</div>'+

								'<div class="form-group">'+

									'<div class="col-lg-2">'+

										'<a href="javascript:void(0);" onclick="addMoreRowCertificate('+i_val+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>'+

									'</div>'+

								'</div>'+

							'</div>'+

							'<div class="form-group">'+

								'<div class="col-lg-2">'+

									'<a href="javascript:void(0);" onclick="removeRowLocation('+cat_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

								'</div>'+

							'</div>'+

						'</div>';	

		

		$("#row_loc_first").after(new_row);

		$("#cat_cnt").val(cat_cnt);

		

		var cat_total_cnt = parseInt($("#cat_total_cnt").val());

		cat_total_cnt = cat_total_cnt + 1;

		$("#cat_total_cnt").val(cat_total_cnt);

		

		$('.vloc_speciality_offered').tokenize2();

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

	}



	function removeRowLocation(idval)

	{

		$("#row_loc_"+idval).remove();



		var cat_total_cnt = parseInt($("#cat_total_cnt").val());

		cat_total_cnt = cat_total_cnt - 1;

		$("#cat_total_cnt").val(cat_total_cnt);

		

	}

	

	function removeFileOfRow(idval)

	{

		$("#divid_"+idval).remove();

		$("#hdn"+idval).val('');

		

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



function getSelectedUserListIds()

{





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







function addSponser(get_id)

{

var all_location_id = document.querySelectorAll('input[name="sponsor_value[]"]:checked');

var aIds = [];

for(var x = 0, l = all_location_id.length; x < l;  x++)

{

    aIds.push(all_location_id[x].value);

}

var str = aIds.join(', ');



            var dataString ='get_id='+get_id+'&values='+str+'&action=getSponsorDetails';

            $.ajax({

                   type: "POST",

                    url: 'ajax/remote.php', 

                   data: dataString,

                   cache: false,

                   success: function(result)

                        {

                        	if(result==1)

                        	{

                        		alert('Update Sponsor successfully.');

                        	}

                        	else

                        	{

                        		alert('Sponsor updating failed.');

                        	}



                        }

                    });

}


	function vendorLocationStatus(id,status)
    {

        var action='vendorLocationStatus';
        $.ajax({
           url: 'ajax/remote.php',
           type: 'POST',
           data: {id: id, status: status, action:action},
           error: function() {
              alert('Something is wrong');
           },
           success: function(res) {
                alert(res);
                location.reload();
           }
        });
    }

    function vendorStatus(id,status)
    {

        var action='vendorStatus';
        $.ajax({
           url: 'ajax/remote.php',
           type: 'POST',
           data: {id: id, status: status, action:action},
           error: function() {
              alert('Something is wrong');
           },
           success: function(res) {
                alert(res);
                location.reload();
           }
        });
    }






</script>



</body>

</html>
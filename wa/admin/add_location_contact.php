<?php

require_once('../classes/config.php');

require_once('../classes/admin.php');

$admin_main_menu_id = '4';

$add_action_id = '10';

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



$error = false;

$err_msg = "";

$msg = '';



if(isset($_GET['vendor']) && $_GET['vendor'] != '')

{

	$vendor_id = base64_decode($_GET['vendor']);

	$arr_record = $obj->getVendorDetails($vendor_id);

	$vendor_location_id=base64_decode($_GET['token']);

	$vendor_parent_cat_id = $arr_record['vendor_parent_cat_id'];

	$vendor_cat_id = $arr_record['vendor_cat_id'];

	$vendor_name = $arr_record['vendor_name'];

        

	$vendor_username = $arr_record['vendor_username'];

	$vendor_status = $arr_record['vendor_status'];

        

        $vendor_email = $arr_record['vendor_email'];

        $vendor_mobile = $arr_record['vendor_mobile'];

	if(count($arr_record) == 0)

	{

		header("Location: index.php");

		exit(0);

	}

	//add by ample 05-09-20
	$tag_level_1=$obj->GETDATADROPDOWNMYDAYTODAYOPTION_ForTags($arr_record['vendor_cat_id'],39,1);
	$tag_level_2=$obj->GETDATADROPDOWNMYDAYTODAYOPTION_ForTags($arr_record['vendor_cat_id'],39,2);




		$cat_cnt = 0;

		$cat_total_cnt = 1;

		$arr_vloc_parent_cat_id = array('2');

		$arr_vloc_cat_id = array('');

		$arr_contact_person_title = array('');

		$arr_contact_person = array('');

		$arr_contact_email = array('');

		$arr_contact_number = array('');

		$arr_contact_designation = array('');

		$arr_contact_remark = array('');

		$arr_vloc_speciality_offered = array('');



		$arr_cert_cnt = array(0);

		$arr_cert_total_cnt = array(1);



		$arr_vc_cert_type_id = array();

		$arr_vc_cert_name = array();

		$arr_vc_cert_no = array();

		$arr_vc_cert_issued_by = array();

		$arr_vc_cert_reg_date = array();

		$arr_vc_cert_validity_date = array();



		for($i=0;$i<count($arr_cert_total_cnt);$i++)

		{

			$arr_vc_cert_type_id[$i] = array('');

			$arr_vc_cert_name[$i] = array('');

			$arr_vc_cert_no[$i] = array('');

			$arr_vc_cert_issued_by[$i] = array('');

			$arr_vc_cert_reg_date[$i] = array('');

			$arr_vc_cert_validity_date[$i] = array('');

		}



		$arr_country_id = array('-1');

		$arr_state_id = array('-1');

		$arr_city_id = array('-1');

		$arr_area_id = array('-1');


		    $va_id = $obj2->getVAIDFromVACATID($arr_record['vendor_parent_cat_id'],$arr_record['vendor_cat_id']);

        //$arr_record = $obj->getVendorsAccessDetails($va_id);

		$vaf_id = $obj2->getVendorAccessFormIdFromVAIDAndVAFAMID($va_id,'4');

	

		if($vaf_id > 0)

		{

			$arr_vaff_record = $obj2->getVendorAccessFormFieldsDetails($vaf_id);

	                

	                $default_vloc_parent_cat_id = $obj2->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'vloc_parent_cat_id');

	                //$arr_vloc_parent_cat_id[0] = $default_vloc_parent_cat_id;

	                $default_vloc_cat_id = $obj2->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'vloc_cat_id');



		}


	

}	

else

{

	header("Location: index.php");

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

	<style type="text/css">
		.box
		{
			border: 1px solid #eee;
    		padding: 5px;
    		border-radius: 2.5px;
    		margin: 2.5px;
		}
	</style>

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

					</div>

					<hr>

					<center><div id="error_msg"></div>
						    <?php 

								if(!empty($_SESSION['MSG'])) {
								   $message = $_SESSION['MSG'];
								   echo '<div class="alert alert-success">'.$message.'</div>';
								   unset($_SESSION['MSG']);
								}

								    ?>
					</center>

					<form role="form" class="form-horizontal" id="add_vendor_loc" name="add_vendor_loc" method="post"> 

						<input type="hidden" name="hdnvendor_id" id="hdnvendor_id" value="<?php echo $vendor_id;?>" >

						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">

						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">

                                                <input type="hidden" name="vendor_parent_cat_id" id="vendor_parent_cat_id" value="<?php echo $vendor_parent_cat_id; ?>">

						<input type="hidden" name="vendor_cat_id" id="vendor_cat_id" value="<?php echo $vendor_cat_id; ?>">

						<div class="form-group"><label class="col-lg-2 control-label">Company <span style="color:red">*</span></label>

							<div class="col-lg-10">

								<?php echo $vendor_name;?>    (<?php echo $vendor_email;?>)

							</div>

						</div>


						

					<?php 

					for($i=0;$i<$cat_total_cnt;$i++)

					{ ?>

						<div id="row_loc_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

							<input type="hidden" name="cert_cnt_<?php echo $i;?>" id="cert_cnt_<?php echo $i;?>" value="<?php echo $arr_cert_cnt[$i];?>">

							<input type="hidden" name="cert_total_cnt_<?php echo $i;?>" id="cert_total_cnt_<?php echo $i;?>" value="<?php echo $arr_cert_total_cnt[$i];?>">

							<input type="hidden" name="cert_loop_cnt[]" id="cert_loop_cnt_<?php echo $i;?>" value="<?php echo $i;?>">

							<input type="hidden" name="hdnvloc_doc_file[]" id="hdnvloc_doc_file_<?php echo $i;?>" value="<?php echo $arr_vloc_doc_file[$i];?>">

							<input type="hidden" name="hdnvloc_menu_file[]" id="hdnvloc_menu_file_<?php echo $i;?>" value="<?php echo $arr_vloc_menu_file[$i];?>">

							<input type="hidden" name="vloc_id[]" id="vloc_id_<?php echo $i;?>" value="<?php echo $arr_vloc_id[$i];?>">

							<div class="form-group left-label">

								<label class="col-lg-3 control-label"><strong>Location and Contact Details:</strong></label>

							</div>

							<div class="form-group">

								<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_<?php echo $i;?>" class="form-control"  onchange="getMainCategoryOptionAddMoreCommonLOC('vloc',<?php echo $i;?>,'<?php echo $default_vloc_cat_id; ?>');" required  >

										<?php //echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[$i]);?>

                                                                                <?php echo $obj2->getMainProfileOptionLOC($arr_vloc_parent_cat_id[$i],'1','0',$default_vloc_parent_cat_id);?>

									</select>

								</div>

								<div class="col-lg-2"></div>

								<div class="col-lg-4">

									<select name="vloc_cat_id[]" id="vloc_cat_id_<?php echo $i;?>" class="form-control" required>

										<?php echo $obj->getMainCategoryOptionLOC($arr_vloc_parent_cat_id[$i],$arr_vloc_cat_id[$i],'1','',$default_vloc_cat_id); ?>

									</select>

								</div>

							</div>

							<div class="form-group" >	

								<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select name="country_id[]" id="country_id_<?php echo $i;?>" onchange="getStateOptionAddMore(<?php echo $i;?>)" class="form-control" required>

										<?php echo $obj->getCountryOption($arr_country_id[$i]); ?>

									</select>

								</div>

								<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select name="state_id[]" id="state_id_<?php echo $i;?>" onchange="getCityOptionAddMore(<?php echo $i;?>)" class="form-control" required>

										<?php echo $obj->getStateOption($arr_country_id[$i],$arr_state_id[$i]); ?>

									</select>

								</div>

							</div>

							<div class="form-group">	

								<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>

								<div class="col-lg-4">

                                                                    <input type="text" value="<?php echo $obj->GetCityName($arr_city_id[$i]); ?>" required="" name="city_id[]" id="city_id_<?php echo $i;?>" placeholder="Select your city" list="capitals_<?php echo $i;?>" class="form-control" onchange="getlocation(<?php echo $i;?>)" />

                                                               

                                                                     <datalist id="capitals_<?php echo $i;?>">

                                                                        <?php //echo $obj->getCityOptions(); ?>

                                                                    </datalist>

								</div>

								<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select name="area_id[]" id="area_id_<?php echo $i;?>" class="form-control" required>

										<?php echo $obj->getPlaceOptions($arr_city_id[$i],$arr_area_id[$i]); ?>

									</select>

								</div>

							</div>
							<!-- comment by 24-06-20 ample -->
							<!-- <div class="form-group">

								<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<select name="contact_person_title[]" id="contact_person_title_<?php echo $i;?>" class="form-control" required>

										<?php echo $obj->getPersonTitleOption($arr_contact_person_title[$i]);?>

									</select>

								</div>

								

								<label class="col-lg-2 control-label">Contact Person<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<input type="text" name="contact_person[]" id="contact_person_<?php echo $i;?>" value="<?php echo $arr_contact_person[$i]?>" placeholder="Contact Person" class="form-control" required>

								</div>

							</div>

							

							<div class="form-group">

								<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<input type="text" name="contact_email[]" id="contact_email_<?php echo $i;?>" value="<?php echo $arr_contact_email[$i]?>" placeholder="Contact Email" class="form-control" required>

								</div>

								

								<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>

								<div class="col-lg-4">

									<input type="text" name="contact_number[]" id="contact_number_<?php echo $i;?>" value="<?php echo $arr_contact_number[$i]?>" placeholder="Contact Number" class="form-control" required>

								</div>

							</div>

						

							<div class="form-group">

								<label class="col-lg-2 control-label">Contact Designation</label>

								<div class="col-lg-4">

									<select name="contact_designation[]" id="contact_designation_<?php echo $i;?>" class="form-control">

										

                                                                             <?php echo $obj->getFavCategoryRamakant('44',$arr_contact_designation[$i]); ?>

									</select>

								</div>

								

								<label class="col-lg-2 control-label">Remark</label>

								<div class="col-lg-4">

                                                                    <textarea name="contact_remark[]" id="contact_remark_<?php echo $i;?>"  class="form-control"><?php echo $arr_contact_remark[$i]?></textarea>


								</div>

							</div> -->

							

							<div class="form-group">

								<label class="col-lg-2 control-label"><?=($tag_level_2['tag_heading'])? $tag_level_2['tag_heading'] : 'Speciality';?> </label>
								<div class="col-lg-10">

									<select name="vloc_speciality_offered_<?php echo $i;?>[]" id="vloc_speciality_offered_<?php echo $i;?>" multiple="multiple" class="form-control vloc_speciality_offered" >

                                      <?php //echo $obj->getFavCategoryVendorEdit('13,53,42,64',$arr_vloc_speciality_offered[$i]); 

                                      	 if(!empty($tag_level_2['tag_data']))
                                             {
                                             	foreach ($tag_level_2['tag_data'] as $key => $value) {
                                             		$sel="";
                                             		if (in_array($value, $arr_vloc_speciality_offered[$i]))
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

							<div class="form-group">	

								<label class="col-lg-2 control-label">Menu Image/Pdf</label>

								<div class="col-lg-4">

								<?php

								if($arr_vloc_menu_file[$i] != '')

								{ ?>

									<div id="divid_vloc_menu_file_<?php echo $i;?>">

									<?php

									$file4 = substr($arr_vloc_menu_file[$i], -4, 4);

									if(strtolower($file4) == '.pdf')

									{ ?>

										<a title="<?php echo $arr_vloc_menu_file[$i];?>" href="<?php echo SITE_URL.'/uploads/'.$arr_vloc_menu_file[$i];?>" target="_blank">View Pdf</a>

									<?php	

									}	

									else

									{ ?>

										<img title="<?php echo $arr_vloc_menu_file[$i];?>" alt="<?php echo $arr_vloc_menu_file[$i];?>" border="0" height="100" src="<?php echo SITE_URL.'/uploads/'.$arr_vloc_menu_file[$i];?>" />

									<?php		

									} ?>

										<a href="javascript:void(0);" onclick="removeFileOfRow('vloc_menu_file_<?php echo $i;?>');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" style="margin-bottom:10px;" data-original-title=""><i class="fa fa-remove"></i></a>

									</div>

								<?php	

								} ?>	

									<input type="file" name="vloc_menu_file[]" id="vloc_menu_file_<?php echo $i;?>" class="form-control">

								</div>

								

								<label class="col-lg-2 control-label">Vendor Estt Pdf</label>

								<div class="col-lg-4">

								<?php

								if($arr_vloc_doc_file[$i] != '')

								{ ?>

									<div id="divid_vloc_doc_file_<?php echo $i;?>">

									<?php

									$file4 = substr($arr_vloc_doc_file[$i], -4, 4);

									if(strtolower($file4) == '.pdf')

									{ ?>

										<a title="<?php echo $arr_vloc_doc_file[$i];?>" href="<?php echo SITE_URL.'/uploads/'.$arr_vloc_doc_file[$i];?>" target="_blank">View Pdf</a>

									<?php	

									}	

									else

									{ ?>

										<img title="<?php echo $arr_vloc_doc_file[$i];?>" alt="<?php echo $arr_vloc_doc_file[$i];?>" border="0" height="100" src="<?php echo SITE_URL.'/uploads/'.$arr_vloc_doc_file[$i];?>" />

									<?php		

									} ?>

										<a href="javascript:void(0);" onclick="removeFileOfRow('vloc_doc_file_<?php echo $i;?>');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" style="margin-bottom:10px;" data-original-title=""><i class="fa fa-remove"></i></a>

									</div>

								<?php		

								} ?>	

									<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_<?php echo $i;?>" class="form-control">

								</div>

							</div>

							<button type="button" data-toggle="popover" data-placement="left" data-content="Available after submit">Add Work Force</button> <button type="button" data-toggle="popover" data-placement="right" data-content="Available after submit">Update Professional details</button>

							<div class="form-group left-label">

								<label class="col-lg-6 control-label"><strong>Licences, Registration, Certification & Memberships:</strong></label>

							</div>

							<?php 

							for($k=0;$k<$arr_cert_total_cnt[$i];$k++)

							{ ?>

							<div id="row_cert_<?php if($k == 0){ echo $i.'_first';}else{ echo $i.'_'.$k;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">

								<input type="hidden" name="vc_cert_id_<?php echo $i;?>[]" id="vc_cert_id_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_id[$i][$k];?>">

								<input type="hidden" name="hdnvc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" id="hdnvc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_scan_file[$i][$k];?>">

								<div class="form-group small-title">

									<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>

									<div class="col-lg-5">

										<select name="vc_cert_type_id_<?php echo $i;?>[]" id="vc_cert_type_id_<?php echo $i;?>_<?php echo $k;?>" class="form-control" required>

											

                                                                                    <?php echo $obj->getFavCategoryRamakant('47',$arr_vc_cert_type_id[$i][$k]); ?>

										</select>

									</div>

									

									<label class="col-lg-1 control-label">Name</label>

									<div class="col-lg-5">

										<input type="text" name="vc_cert_name_<?php echo $i;?>[]" id="vc_cert_name_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_name[$i][$k];?>" placeholder="Name" class="form-control">

									</div>

								</div>	

								<div class="form-group small-title">

									<label class="col-lg-1 control-label">Number</label>

									<div class="col-lg-5">

										<input type="text" name="vc_cert_no_<?php echo $i;?>[]" id="vc_cert_no_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_no[$i][$k];?>" placeholder="Number" class="form-control">

									</div>

									

									<label class="col-lg-1 control-label">Issued By</label>

									<div class="col-lg-5">

										<input type="text" name="vc_cert_issued_by_<?php echo $i;?>[]" id="vc_cert_issued_by_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_issued_by[$i][$k];?>" placeholder="Issued By" class="form-control">

									</div>

								</div>	

								<div class="form-group small-title">

									<label class="col-lg-1 control-label">Issued Date</label>

									<div class="col-lg-5">

										<input type="text" name="vc_cert_reg_date_<?php echo $i;?>[]" id="vc_cert_reg_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_reg_date[$i][$k];?>" placeholder="Issued Date" class="form-control clsdatepicker2">

									</div>

									

									<label class="col-lg-1 control-label">Vaidity Date</label>

									<div class="col-lg-5">

										<input type="text" name="vc_cert_validity_date_<?php echo $i;?>[]" id="vc_cert_validity_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_validity_date[$i][$k];?>" placeholder="Validity Date" class="form-control clsdatepicker">

									</div>

								</div>

								<div class="form-group small-title">

									<label class="col-lg-1 control-label">Scan Image</label>

									<div class="col-lg-5">

									<?php

									if($arr_vc_cert_scan_file[$i][$k] != '')

									{ ?>

										<div id="divid_vc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>">

										<?php	

										$file4 = substr($arr_vc_cert_scan_file[$i][$k], -4, 4);

										if(strtolower($file4) == '.pdf')

										{ ?>

											<a title="<?php echo $arr_vc_cert_scan_file[$i][$k];?>" href="<?php echo SITE_URL.'/uploads/'.$arr_vc_cert_scan_file[$i][$k];?>" target="_blank">View Pdf</a>

										<?php	

										}	

										else

										{ ?>

											<img title="<?php echo $arr_vc_cert_scan_file[$i][$k];?>" alt="<?php echo $arr_vc_cert_scan_file[$i][$k];?>" border="0" height="100" src="<?php echo SITE_URL.'/uploads/'.$arr_vc_cert_scan_file[$i][$k];?>" />

										<?php		

										}?>

											<a href="javascript:void(0);" onclick="removeFileOfRow('vc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" style="margin-bottom:10px;" data-original-title=""><i class="fa fa-remove"></i></a><br>

										</div>

									<?php	

									}

									?>	

										<input type="file" name="vc_cert_scan_file_<?php echo $i;?>[]" id="vc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >

									</div>

								</div>

								<div class="form-group">

									<div class="col-lg-2">

									<?php

									if($k == 0)

									{ ?>

										<a href="javascript:void(0);" onclick="addMoreRowCertificate(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>

									<?php  	

									}

									else

									{ ?>

										<a href="javascript:void(0);" onclick="removeRowCertificate(<?php echo $i;?>,<?php echo $k;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>

									<?php	

									}

									?>	

									</div>

								</div>

							</div>	

							<?php

							} ?>

<!-- 							<div class="form-group">

								<div class="col-lg-2">

								<?php

								if($i == 0)

								{ ?>

									<a href="javascript:void(0);" onclick="addMoreRowLocation();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>

								<?php  	

								}

								else

								{ ?>

									<a href="javascript:void(0);" onclick="removeRowLocation(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>

								<?php	

								}

								?>	

								</div>

							</div> -->

						</div>

					<?php 

					} ?>

						

						

						<hr>

						<div class="form-group">

							<div class="col-lg-offset-3 col-lg-10">

								<div class="pull-left">

                                                                       

									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>

                                                                       

                                    <a href="manage_vendors.php"><button type="button" class="btn btn-danger rounded">Cancel</button></a>



                                    <img border="0" class="image_load" src="<?php echo SITE_URL.'/images/loading.gif'?>" style=" width: 6%; display: none; float: right; margin-right:75%;">





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

<script src="admin-js/add-vendor-location-validator.js" type="text/javascript"></script>

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

                                //alert(result);

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

									'<a href="javascript:void(0);" onclick="removeRowCertificate('+i_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

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

                            //  alert(result);

                         var JSONObject = JSON.parse(result);

                         //var rslt=JSONObject[0]['status'];   

                        $('#area_id_'+id_val).html(JSONObject[0]['place_option']);

                       }

              }); 

       }

       //add by ample 24-06-20

    function add_staff(vloc_id)
    {
    	//alert(vloc_id);
    	$('.vloc_speciality_offered').tokenize2();
    	$('#addModal').modal('show');
    	$('#staff_vloc').val(vloc_id);
    	$('.vloc_speciality_offered').tokenize2();
    }

    function add_staff_box()
    {
    	var cat_cnt = parseInt($("#box_count").val());
		cat_cnt = cat_cnt + 1;

		var new_row = 	'<div class="box" id="box'+cat_cnt+'">'+
							
							
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

									'<input type="text" name="contact_email[]" id="contact_email_'+cat_cnt+'" value="" placeholder="Contact Email" class="form-control" required>'+

								'</div>'+

								

								'<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="contact_number[]" id="contact_number_'+cat_cnt+'" value="" placeholder="Contact Number" class="form-control" required>'+

								'</div>'+

							'</div>'+

						

							'<div class="form-group">'+

								'<label class="col-lg-2 control-label">Designation</label>'+

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

									'<select name="speciality_offered['+cat_cnt+'][]" id="vloc_speciality_offered_'+cat_cnt+'" multiple="multiple" class="form-control vloc_speciality_offered" >'+

										'<?php echo $obj->getFavCategoryRamakant('13,53,42,64',''); ?>'+

									'</select>'+

								'</div>'+

							'</div>'+	

							'<button type="button" class="btn btn-danger btn-sm" onclick="remove_staff_box('+cat_cnt+')">Remove</button>'+

							'</div>';	

		$("#staff_box_form").append(new_row);

		$("#box_count").val(cat_cnt);

		$('.vloc_speciality_offered').tokenize2();

		$('#vloc_speciality_offered_'+cat_cnt).tokenize2();
    }


    function remove_staff_box(idval)
	{
		$("#box"+idval).remove();
		var cat_total_cnt = parseInt($("#box_count").val());
		cat_total_cnt = cat_total_cnt - 1;
		$("#box_count").val(cat_total_cnt);
	}

	function view_staff(vloc_id)
	{
		var dataString ='vloc_id='+vloc_id+'&action=getVendorContacts';
		$.ajax({
			type: "POST",
			url: "ajax/remote.php",
			data: dataString,
			cache: false,      
			success: function(result)
			{
				//alert(result);
				$('#view_staff_list').html(result);
				$('#viewModal').modal('show');

			}

		});
	}

	//add by ample 27-07-20
	function update_contact_status(contact_id,status)
	{	
		var retVal = confirm("Do you want to update status ?");

		if( retVal == true ) 
		{
			var dataString ='contact_id='+contact_id+'&status='+status+'&action=vendorContactUpdateStatus';
			$.ajax({
				type: "POST",
				url: "ajax/remote.php",
				data: dataString,
				cache: false,      
				success: function(result)
				{
					alert(result);
					location.reload();
				}

			});
		}
		else
		{
			return false;
		}
		
	}

$(document).ready(function(){
  $('[data-toggle="popover"]').popover();  
});

</script>



</body>

</html>
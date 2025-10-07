<?php
require_once('../classes/config.php');
require_once('../classes/vendor.php');

$admin_main_menu_id = '4';
$add_action_id = '44';

$obj = new Vendor();
$obj2 = new commonFunctions();

if($obj->isVendorLoggedIn())
{
    header("Location: index.php");
    exit(0);
}

$error = false;
$err_msg = "";
$msg = '';


if(isset($_GET['vtoken']) && $_GET['vtoken'] != '')
{
	$va_id = base64_decode($_GET['vtoken']);
	
        $arr_record = $obj->getVendorsAccessDetails($va_id);
        $va_cat_name = $obj->getProfileCategoryName($arr_record['va_cat_id']);
        $va_sub_cat_name = $obj->getSubCategoryName($arr_record['va_sub_cat_id']);
        
	$vaf_id = $obj->getVendorAccessFormIdFromVAIDAndVAFAMID($va_id,$admin_main_menu_id);
	
	if($vaf_id > 0)
	{
		$arr_vaff_record = $obj->getVendorAccessFormFieldsDetails($vaf_id);
                //die();
                //echo 'Hh1';
                //die();
		if(count($arr_vaff_record) == 0)
		{
			header("Location: invalid.php");
			exit(0);
		}
	}
	else
	{
               // echo 'Hh2';
                //die();
		header("Location: invalid.php");
		exit(0);
	}		
}	
else
{
	header("Location: invalid.php");
	exit(0);
}


$cat_cnt = 0;
$cat_total_cnt = 1;

$vendor_parent_cat_id = '11';
$vendor_cat_id = '';
$vendor_name = '';
$vendor_username = '';
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
		<div class="col-sm-12">

			<!-- <div class="col-md-4"> -->
				
				<!-- <div style="float:left;width:100%;margin:20px;">
					<p class="payment_msg">Please Wait!</p>
					<p class="payment_msg">Your Payment is processing.</p>
					<p class="payment_msg">Do not refresh/reload the page</p>
				</div> -->
			<!-- </div> -->


			<div class="panel">
				<div class="panel-body">
					<div class="row mail-header">
						<div class="col-md-6">
							<h3><?php echo $obj->getVendorAccessFormTitle($vaf_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="register" name="register" enctype="multipart/form-data" method="post"> 
						<?php
						$default_vendor_parent_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'vendor_parent_cat_id');
						$vendor_parent_cat_id = $default_vendor_parent_cat_id;
						$default_vendor_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'vendor_cat_id');
						
						$default_vloc_parent_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'vloc_parent_cat_id');
						$arr_vloc_parent_cat_id[0] = $default_vloc_parent_cat_id;
						$default_vloc_cat_id = $obj->getDeualtValueOfVendorAccessFormFieldFromVAFID($vaf_id,'vloc_cat_id');
						
						
						?>	
						<input type="hidden" name="va_id" id="va_id" value="<?php echo $va_id;?>">
						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">
						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">
						
						<div class="form-group">
						<label class="col-lg-2 control-label">Category<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="vendor_parent_cat_id" id="vendor_parent_cat_id" class="form-control" required  >
                                                                    <option value="<?php echo $arr_record['va_cat_id']; ?>"><?php echo $va_cat_name; ?></option>
								</select>
							</div>	
							<div class="col-lg-2"></div>
							<div class="col-lg-4">
								<select name="vendor_cat_id" id="vendor_cat_id" class="form-control" required>
									<option value="<?php echo $arr_record['va_sub_cat_id']; ?>"><?php echo $va_sub_cat_name; ?></option>
								</select>
							</div>
						</div>
						
						<?php
						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vendor_name'))
						{ ?>
						<div class="form-group"><label class="col-lg-2 control-label">Company Name<span style="color:red">*</span></label>
							<div class="col-lg-10">
								<input type="text" name="vendor_name" id="vendor_name" value="<?php echo $vendor_name;?>" placeholder="Company Name" class="form-control" required>
							</div>
						</div>
						<?php
						} 
						else
						{ ?>
							<input type="hidden" name="vendor_name" id="vendor_name" value="<?php echo $vendor_name;?>" >
						<?php
						} ?>
						
						
						<div class="form-group">
						<?php
						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vendor_username'))
						{ ?>	
							<label class="col-lg-2 control-label">Username<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="vendor_username" id="vendor_username" value="<?php echo $vendor_username;?>" placeholder="Vendor Username" class="form-control" required>
							</div>
						<?php
						} 
						else
						{ ?>
							<input type="hidden" name="vendor_username" id="vendor_username" value="<?php echo $vendor_username;?>" >
						<?php
						} ?>
						
						<?php
						if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vendor_password'))
						{ ?>	
							<label class="col-lg-2 control-label">Password<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="password" name="vendor_password" id="vendor_password" value="" placeholder="Vendor Password" class="form-control" required>
                                                                <p style="font-size: 12px; color: brown;">Password Atleast 1 Upper case alphabate[A-Z], 1 Lower case alphabate[a-z] , 1 Numeric[0-9] , 1 special characters[!@#$%^&*()-_=+,<>./?]</p>
                                                        </div>
                                                        
						<?php
						} 
						else
						{ ?>
							<input type="hidden" name="vendor_password" id="vendor_password" value="<?php echo $vendor_password;?>" >
						<?php
						} ?>	
						</div>
                                                
                                                 <div class="form-group">
						<label class="col-lg-2 control-label">Admin Email<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="vendor_email" id="vendor_email" value="<?php echo $vendor_email;?>" placeholder="Vendor Email" class="form-control" required>
							</div>
						
						<label class="col-lg-2 control-label">Admin Mobile<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="vendor_mobile" id="vendor_mobile" value="" placeholder="Vendor Mobile" class="form-control" required>
                                                                
                                                        </div>
                                                      
						</div>
						
					<?php 
					for($i=0;$i<$cat_total_cnt;$i++)
					{ ?>
						<div id="row_loc_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
							<input type="hidden" name="cert_cnt_<?php echo $i;?>" id="cert_cnt_<?php echo $i;?>" value="<?php echo $arr_cert_cnt[$i];?>">
							<input type="hidden" name="cert_total_cnt_<?php echo $i;?>" id="cert_total_cnt_<?php echo $i;?>" value="<?php echo $arr_cert_total_cnt[$i];?>">
							<input type="hidden" name="cert_loop_cnt[]" id="cert_loop_cnt_<?php echo $i;?>" value="<?php echo $i;?>">
							<input type="hidden" name="hdnvloc_doc_file[]" id="hdnvloc_doc_file_<?php echo $i;?>" value="">
							<input type="hidden" name="hdnvloc_menu_file[]" id="hdnvloc_menu_file_<?php echo $i;?>" value="">
							<input type="hidden" name="vloc_id[]" id="vloc_id_<?php echo $i;?>" value="0">
							<div class="form-group left-label">
								<label class="col-lg-3 control-label"><strong>Location and Contact Details:</strong></label>
							</div>
							<div class="form-group">
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_parent_cat_id'))
							{ 
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_cat_id'))
								{  ?>
								<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_<?php echo $i;?>" class="form-control"  onchange="getMainCategoryOptionAddMoreCommonLOC('vloc',<?php echo $i;?>,'<?php echo $default_vloc_cat_id; ?>');" required  >
										<?php echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[$i],'1','0',$default_vloc_parent_cat_id);?>
									</select>
								</div>	
								<div class="col-lg-2"></div>
								<div class="col-lg-4">
									<select name="vloc_cat_id[]" id="vloc_cat_id_<?php echo $i;?>" class="form-control" required>
										<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[$i],$arr_vloc_cat_id[$i],'1','0',$default_vloc_cat_id); ?>
									</select>
								</div>
								<?php
								}
								else
								{ ?>
								<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_<?php echo $i;?>" class="form-control"  required  >
										<?php echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[$i],'1','0',$default_vloc_parent_cat_id);?>
									</select>
								</div>
								<input type="hidden" name="vloc_cat_id[]" id="vloc_cat_id_<?php echo $i;?>" value="<?php echo $arr_vloc_cat_id[$i];?>" >	
								<?php	
								}
							}
							else
							{
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_cat_id'))
								{ ?> 
								<input type="hidden" name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_<?php echo $i;?>" value="<?php echo $arr_vloc_parent_cat_id[$i];?>" >	
								<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="vloc_cat_id[]" id="vloc_cat_id_<?php echo $i;?>" class="form-control" required>
										<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[$i],$arr_vloc_cat_id[$i],'1','0',$default_vloc_cat_id); ?>
									</select>
								</div>
								<?php
								}
								else
								{ ?>
								<input type="hidden" name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_<?php echo $i;?>" value="<?php echo $arr_vloc_parent_cat_id[$i];?>" >	
								<input type="hidden" name="vloc_cat_id[]" id="vloc_cat_id_<?php echo $i;?>" value="<?php echo $arr_vloc_cat_id[$i];?>" >	
								<?php	
								}									
							} ?>
							</div>
							<div class="form-group" >	
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'country_id'))
							{ ?>		
								<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="country_id[]" id="country_id_<?php echo $i;?>" onchange="getStateOptionAddMore(<?php echo $i;?>)" class="form-control" required>
										<?php echo $obj->getCountryOption($arr_country_id[$i]); ?>
									</select>
								</div>
							<?php
							}
							else
							{ ?>
								<input type="hidden" name="country_id[]" id="country_id_<?php echo $i;?>" value="<?php echo $arr_country_id[$i];?>" >	
							<?php	
							}
							
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'state_id'))
							{ ?>			
								<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="state_id[]" id="state_id_<?php echo $i;?>" onchange="getCityOptionAddMore(<?php echo $i;?>)" class="form-control" required>
										<?php echo $obj->getStateOption($arr_country_id[$i],$arr_state_id[$i]); ?>
									</select>
								</div>
							<?php
							}
							else
							{ ?>
								<input type="hidden" name="state_id[]" id="state_id_<?php echo $i;?>" value="<?php echo $arr_state_id[$i];?>" >	
							<?php	
							} ?>	
							</div>
							<div class="form-group">	
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'city_id'))
							{ ?>			
								<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>
								<div class="col-lg-4">
                                                                <input type="text" required="" name="city_id[]" id="city_id_<?php echo $i;?>" placeholder="Select your city" list="capitals_<?php echo $i;?>" class="form-control" onchange="getlocation(<?php echo $i;?>)" />
                                                               
                                                                     <datalist id="capitals_<?php echo $i;?>">
                                                                        <?php echo $obj->getCityOptions(); ?>
                                                                    </datalist>
<!--									<select name="city_id[]" id="city_id_<?php echo $i;?>" onchange="getAreaOptionAddMore(<?php echo $i;?>)" class="form-control" required>
										<?php //echo $obj->getCityOption($arr_country_id[$i],$arr_state_id[$i],$arr_city_id[$i]); ?>
									</select>-->
                                                                </div>
							<?php
							}
							else
							{ ?>
								<input type="hidden" name="city_id[]" id="city_id_<?php echo $i;?>" value="<?php echo $arr_city_id[$i];?>" >	
							<?php	
							}
							
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'area_id'))
							{ ?>				
								<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="area_id[]" id="area_id_<?php echo $i;?>" class="form-control" required>
										<?php echo $obj->getAreaOption($arr_country_id[$i],$arr_state_id[$i],$arr_city_id[$i],$arr_area_id[$i]); ?>
									</select>
								</div>
							<?php
							}
							else
							{ ?>
								<input type="hidden" name="area_id[]" id="area_id_<?php echo $i;?>" value="<?php echo $arr_area_id[$i];?>" >	
							<?php	
							} ?>	
							</div>
							<div class="form-group">
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_person_title'))
							{ ?>
								<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="contact_person_title[]" id="contact_person_title_<?php echo $i;?>" class="form-control" required>
										<?php echo $obj->getPersonTitleOption($arr_contact_person_title[$i]);?>
									</select>
								</div>
							<?php
							}
							else
							{ ?>
								<input type="hidden" name="contact_person_title[]" id="contact_person_title_<?php echo $i;?>" value="<?php echo $arr_contact_person_title[$i];?>" >	
							<?php	
							} 
							
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_person'))
							{ ?>
								<label class="col-lg-2 control-label">Contact Person Name<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<input type="text" name="contact_person[]" id="contact_person_<?php echo $i;?>" value="<?php echo $arr_contact_person[$i]?>" placeholder="Contact Person" class="form-control" required>
								</div>
							<?php
							}
							else
							{ ?>
								<input type="hidden" name="contact_person[]" id="contact_person_<?php echo $i;?>" value="<?php echo $arr_contact_person[$i];?>" >	
							<?php	
							} ?>			
								
							</div>
							
							<div class="form-group">
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_email'))
							{ ?>
								<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<input type="text" name="contact_email[]" id="contact_email_<?php echo $i;?>" value="<?php echo $arr_contact_email[$i]?>" placeholder="Contact Email" class="form-control" required>
								</div>
							<?php
							}
							else
							{ ?>
								<input type="hidden" name="contact_email[]" id="contact_email_<?php echo $i;?>" value="<?php echo $arr_contact_email[$i];?>" >	
							<?php	
							} 
							
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_number'))
							{ ?>
								<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<input type="text" name="contact_number[]" id="contact_number_<?php echo $i;?>" value="<?php echo $arr_contact_number[$i]?>" placeholder="Contact Number" class="form-control" required>
								</div>
							<?php
							}
							else
							{ ?>
								<input type="hidden" name="contact_number[]" id="contact_number_<?php echo $i;?>" value="<?php echo $arr_contact_number[$i];?>" >	
							<?php	
							} ?>	
							</div>
						
							<div class="form-group">
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_designation'))
							{ ?>
								<label class="col-lg-2 control-label">Contact Designation</label>
								<div class="col-lg-4">
									<select name="contact_designation[]" id="contact_designation_<?php echo $i;?>" class="form-control">
                                                                            <option value="">Select</option>	
                                                                            <?php 
                                                                                //echo $obj->getContactDesignationOption($arr_contact_designation[$i]);
                                                                                echo $obj->getFavCategoryRamakant('44',$arr_contact_designation[$i]);
                                                                                
                                                                                ?>
									</select>
								</div>
							<?php
							}
							else
							{ ?>
								<input type="hidden" name="contact_designation[]" id="contact_designation_<?php echo $i;?>" value="<?php echo $arr_contact_designation[$i];?>" >	
							<?php	
							} ?>

							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_remark'))
							{ ?>	
								<label class="col-lg-2 control-label">Remark</label>
								<div class="col-lg-4">
                                                                        <textarea name="contact_remark[]" id="contact_remark_<?php echo $i;?>"  class="form-control"><?php echo $arr_contact_remark[$i]?></textarea>
									<!--<input type="text" name="contact_remark[]" id="contact_remark_<?php //echo $i;?>" value="<?php //echo $arr_contact_remark[$i]?>" placeholder="Remark" class="form-control">-->
								</div>
							<?php
							}
							else
							{ ?>
                                                                
								<input type="hidden" name="contact_remark[]" id="contact_remark_<?php echo $i;?>" value="<?php echo $arr_contact_remark[$i];?>" >	
							<?php	
							} ?>	
							</div>
							
							<div class="form-group">
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_speciality_offered'))
							{ ?>	
								<label class="col-lg-2 control-label">Speciality Offered</label>
								<div class="col-lg-10">
									<select name="vloc_speciality_offered_<?php echo $i;?>[]" id="vloc_speciality_offered_<?php echo $i;?>" multiple="multiple" class="form-control vloc_speciality_offered" >
										 <?php echo $obj->getFavCategoryVendor('13,53,42,64',''); ?>
									</select>
								</div>
							<?php
							}
							else
							{ ?>
								<input type="hidden" name="vloc_speciality_offered[]" id="vloc_speciality_offered_<?php echo $i;?>" value="<?php echo $arr_vloc_speciality_offered[$i];?>" >	
							<?php	
							} ?>		
							</div>	
							<div class="form-group">	
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_menu_file'))
							{ ?>	
								<label class="col-lg-2 control-label">Menu Image/Pdf</label>
								<div class="col-lg-4">
									<input type="file" name="vloc_menu_file[]" id="vloc_menu_file_<?php echo $i;?>" class="form-control">
								</div>
							<?php
							} ?>
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_doc_file'))
							{ ?>	
								<label class="col-lg-2 control-label">Vendor Estt Pdf</label>
								<div class="col-lg-4">
									<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_<?php echo $i;?>" class="form-control">
								</div>
							<?php
							} ?>	
							</div>
							
							<div class="form-group left-label">
								<label class="col-lg-6 control-label"><strong>Licences, Registration, Certification & Memberships:</strong></label>
							</div>
							<?php 
							for($k=0;$k<$arr_cert_total_cnt[$i];$k++)
							{ ?>
							<div id="row_cert_<?php if($k == 0){ echo $i.'_first';}else{ echo $i.'_'.$k;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
								<input type="hidden" name="vc_cert_id_<?php echo $i;?>[]" id="vc_cert_id_<?php echo $i;?>_<?php echo $k;?>" value="0">
								<input type="hidden" name="hdnvc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" id="hdnvc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" value="">
								<div class="form-group small-title">
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_type_id'))
								{ ?>
									<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>
									<div class="col-lg-5">
										<select name="vc_cert_type_id_<?php echo $i;?>[]" id="vc_cert_type_id_<?php echo $i;?>_<?php echo $k;?>" class="form-control" required>
                                                                                    <option value="">Select</option>
                                                                                        <?php echo $obj->getFavCategoryRamakant('47',$arr_vc_cert_type_id[$i][$k]); ?>
										</select>
									</div>
								<?php
								}
								else
								{ ?>
									<input type="hidden" name="vc_cert_type_id_<?php echo $i;?>[]" id="vc_cert_type_id_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_type_id[$i][$k];?>" >
								<?php		
								} ?>									
									
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_name'))
								{ ?>	
									<label class="col-lg-1 control-label">Name</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_name_<?php echo $i;?>[]" id="vc_cert_name_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_name[$i][$k];?>" placeholder="Name" class="form-control" required>
									</div>
								<?php
								}
								else
								{ ?>
									<input type="hidden" name="vc_cert_name_<?php echo $i;?>[]" id="vc_cert_name_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_name[$i][$k];?>" >
								<?php		
								} ?>	
								</div>	
								<div class="form-group small-title">
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_no'))
								{ ?>
									<label class="col-lg-1 control-label">Number</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_no_<?php echo $i;?>[]" id="vc_cert_no_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_no[$i][$k];?>" placeholder="Number" class="form-control" required>
									</div>
								<?php
								}
								else
								{ ?>
									<input type="hidden" name="vc_cert_no_<?php echo $i;?>[]" id="vc_cert_no_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_no[$i][$k];?>" >
								<?php		
								} ?>

								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_issued_by'))
								{ ?>	
									<label class="col-lg-1 control-label">Issued By</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_issued_by_<?php echo $i;?>[]" id="vc_cert_issued_by_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_issued_by[$i][$k];?>" placeholder="Issued By" class="form-control" required>
									</div>
								<?php
								}
								else
								{ ?>
									<input type="hidden" name="vc_cert_issued_by_<?php echo $i;?>[]" id="vc_cert_issued_by_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_issued_by[$i][$k];?>" >
								<?php		
								} ?>	
								</div>	
								<div class="form-group small-title">
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_reg_date'))
								{ ?>
									<label class="col-lg-1 control-label">Issued Date</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_reg_date_<?php echo $i;?>[]" id="vc_cert_reg_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_reg_date[$i][$k];?>" placeholder="Issued Date" class="form-control clsdatepicker2" required>
									</div>
								<?php
								}
								else
								{ ?>
									<input type="hidden" name="vc_cert_reg_date_<?php echo $i;?>[]" id="vc_cert_reg_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_reg_date[$i][$k];?>" >
								<?php		
								} ?>

								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_validity_date'))
								{ ?>	
									<label class="col-lg-1 control-label">Vaidity Date</label>
									<div class="col-lg-5">
										<input type="text" name="vc_cert_validity_date_<?php echo $i;?>[]" id="vc_cert_validity_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_validity_date[$i][$k];?>" placeholder="Validity Date" class="form-control clsdatepicker" required>
									</div>
								<?php
								}
								else
								{ ?>
									<input type="hidden" name="vc_cert_validity_date_<?php echo $i;?>[]" id="vc_cert_validity_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_validity_date[$i][$k];?>" >
								<?php		
								} ?>	
								</div>
								<div class="form-group small-title">
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_validity_date'))
								{ ?>	
									<label class="col-lg-1 control-label">Scan Image</label>
									<div class="col-lg-5">
										<input type="file" name="vc_cert_scan_file_<?php echo $i;?>[]" id="vc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >
									</div>
								<?php		
								} ?>		
								</div>
								<div class="form-group">
									<div class="col-lg-2">
									<?php
									if($k == 0)
									{ ?>
										<a href="javascript:void(0);" onclick="addMoreRowCertificate(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>
									<?php  	
									}
									else
									{ ?>
										<a href="javascript:void(0);" onclick="removeRowCertificate(<?php echo $i;?>,<?php echo $k;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>
									<?php	
									}
									?>	
									</div>
								</div>
							</div>	
							<?php
							} ?>
							<div class="form-group">
								<div class="col-lg-2">
								<?php
								if($i == 0)
								{ ?>
									<a href="javascript:void(0);" onclick="addMoreRowLocation();" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>
								<?php  	
								}
								else
								{ ?>
									<a href="javascript:void(0);" onclick="removeRowLocation(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>
								<?php	
								}
								?>	
								</div>
							</div>
						</div>
					<?php 
					} ?>
						
						
						<hr>
						<div class="form-group">
							<div class="col-lg-offset-5 col-lg-10">
								<div class="">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>

									<!-- <div class="backlo"> -->
					                <img border="0" class="image_load" src="<?php echo SITE_URL.'/images/loading.gif'?>" style=" width: 6%; display: none;">
			                    	<!-- </div> -->
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
<script src="admin-js/register-validator.js" type="text/javascript"></script>
<script src="js/tokenize2.js"></script>
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
                                //alert();
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
							'<div class="form-group small-title">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_type_id'))
							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>'+
								'<div class="col-lg-5">'+
									'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control" required>'+
										'<option value="">Select</option>'+
                                                                                 '<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+
									'</select>'+
								'</div>';
							<?php
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" value="">';
							<?php	
							} ?>								
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_name'))
							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Name</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+
								'</div>';
							<?php
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="">';
							<?php	
							} ?>	
							
			new_row +=		'</div>'+	
							'<div class="form-group small-title">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_no'))
							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Number</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+
								'</div>';
							<?php
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="">';
							<?php	
							} ?>	
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_issued_by'))
							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Issued By</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+
								'</div>';
							<?php
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="">';	
							<?php	
							} ?>	
							
			new_row +=		'</div>'+	
							'<div class="form-group small-title">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_reg_date'))
							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Issued Date</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+
								'</div>';
							<?php
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="">';	
							<?php	
							} ?>	
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_validity_date'))
							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Vaidity Date</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+
								'</div>';
							<?php
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="">';	
							<?php	
							} ?>
							
			new_row +=		'</div>'+
							'<div class="form-group small-title">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_scan_file'))
							{ ?>
			new_row +=			'<label class="col-lg-1 control-label">Scan Image</label>'+
								'<div class="col-lg-5">'+
									'<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+
								'</div>';
							<?php	
							} ?>	
			new_row +=		'</div>'+
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
		//alert("Hiii");
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
							'<div class="form-group">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_parent_cat_id'))
							{ ?>
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_cat_id'))
								{ ?>
			new_row +=                          '<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" class="form-control"  onchange="getMainCategoryOptionAddMoreCommonLOC(\'vloc\','+cat_cnt+',\'<?php echo $default_vloc_cat_id; ?>\');" required  >'+
										'<?php echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[0],'1','0',$default_vloc_parent_cat_id);?>'+
									'</select>'+
								'</div>'+
								'<div class="col-lg-2"></div>'+
								'<div class="col-lg-4">'+
									'<select name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" class="form-control" required>'+
										'<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[0],'','1','0',$default_vloc_cat_id); ?>'+
									'</select>'+
								'</div>';				
								<?php
								}
								else
								{ ?>
			new_row += 			'<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" class="form-control"  required  >'+
										'<?php echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[0],'1','0',$default_vloc_parent_cat_id);?>'+
									'</select>'+
								'</div>'+
								'<input type="hidden" name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" value="<?php echo $arr_vloc_cat_id[0];?>" >';				
								<?php	
								} ?>
							<?php
							}
							else
							{ ?>
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_cat_id'))
								{ ?>
			new_row +=			'<input type="hidden" name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" value="<?php echo $arr_vloc_parent_cat_id[0];?>" >';
			new_row += 			'<label class="col-lg-2 control-label">Location Category<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" class="form-control" required>'+
										'<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[0],'','1','0',$default_vloc_cat_id); ?>'+
									'</select>'+
								'</div>';				
								<?php
								}
								else
								{ ?>
			new_row +=			'<input type="hidden" name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" value="<?php echo $arr_vloc_parent_cat_id[0];?>" >';
			new_row +=			'<input type="hidden" name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" value="<?php echo $arr_vloc_cat_id[0];?>" >';
								<?php	
								} ?>
							<?php	
							} ?>	
						
			
			new_row += 		'</div>'+
							'<div class="form-group" >';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'country_id'))
							{ ?>			
			new_row +=			'<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="country_id[]" id="country_id_'+cat_cnt+'" onchange="getStateOptionAddMore('+cat_cnt+')" class="form-control" required>'+
										'<?php echo $obj->getCountryOption(''); ?>'+
									'</select>'+
								'</div>';
							<?php	
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="country_id[]" id="country_id_'+cat_cnt+'" value="" >';					
							<?php
							} ?>			
					
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'state_id'))
							{ ?>			
			new_row +=			'<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="state_id[]" id="state_id_'+cat_cnt+'" onchange="getCityOptionAddMore('+cat_cnt+')" class="form-control" required>'+
										'<?php echo $obj->getStateOption('',''); ?>'+
									'</select>'+
								'</div>';
							<?php	
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="state_id[]" id="state_id_'+cat_cnt+'" value="" >';					
							<?php
							} ?>				
							
			new_row +=		'</div>'+
							'<div class="form-group">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'city_id'))
							{ ?>			
			new_row +=			'<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
                                                                        '<input type="text" required="" name="city_id[]" id="city_id_'+cat_cnt+'" placeholder="Select your city" list="capitals_'+cat_cnt+'" class="form-control" onchange="getlocation('+cat_cnt+')" />'+
									'<datalist id="capitals_'+cat_cnt+'">'+
										'<?php echo $obj->getCityOptions(); ?>'+
									'</datalist>'+
								'</div>';
							<?php	
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="city_id[]" id="city_id_'+cat_cnt+'" value="" >';					
							<?php
							} ?>
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'area_id'))
							{ ?>				
			new_row +=			'<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="area_id[]" id="area_id_'+cat_cnt+'" class="form-control" required>'+
										'<?php echo $obj->getAreaOption('','','',''); ?>'+
									'</select>'+
								'</div>';
							<?php	
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="area_id[]" id="area_id_'+cat_cnt+'" value="" >';					
							<?php
							} ?>
							
			new_row +=		'</div>'+
							'<div class="form-group">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_person_title'))
							{ ?>				
			new_row +=			'<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="contact_person_title[]" id="contact_person_title_'+cat_cnt+'" class="form-control" required>'+
										'<?php echo $obj->getPersonTitleOption('');?>'+
									'</select>'+
								'</div>';
							<?php	
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="contact_person_title[]" id="contact_person_title_'+cat_cnt+'" value="" >';					
							<?php
							} ?>	
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_person'))
							{ ?>	
			new_row +=			'<label class="col-lg-2 control-label">Contact Person Name<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_person[]" id="contact_person_'+cat_cnt+'" value="" placeholder="Contact Person" class="form-control" required>'+
								'</div>';
							<?php	
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="contact_person[]" id="contact_person_'+cat_cnt+'" value="" >';					
							<?php
							} ?>		
								
			new_row +=		'</div>'+
							'<div class="form-group">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_email'))
							{ ?>	
			new_row +=			'<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_email[]" id="contact_email_'+cat_cnt+'" value="" placeholder="Contact Email" class="form-control" >'+
								'</div>';
							<?php	
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="contact_email[]" id="contact_email_'+cat_cnt+'" value="" >';					
							<?php
							} ?>			
								
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_number'))
							{ ?>		
			new_row +=			'<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_number[]" id="contact_number_'+cat_cnt+'" value="" placeholder="Contact Number" class="form-control" >'+
								'</div>';
							<?php	
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="contact_number[]" id="contact_number_'+cat_cnt+'" value="" >';					
							<?php
							} ?>				
								
			new_row +=		'</div>'+
							'<div class="form-group">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_designation'))
							{ ?>
			new_row +=			'<label class="col-lg-2 control-label">Contact Designation</label>'+
								'<div class="col-lg-4">'+
                                                                       
									'<select name="contact_designation[]" id="contact_designation_'+cat_cnt+'" class="form-control">'+
										'<option value="">Select</option>'+
                                                                                '<?php echo $obj->getFavCategoryRamakant('44','');?>'+
									'</select>'+
								'</div>';
							<?php	
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="contact_designation[]" id="contact_designation_'+cat_cnt+'" value="" >';					
							<?php
							} ?>					
								
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'contact_remark'))
							{ ?>	
			new_row +=			'<label class="col-lg-2 control-label">Remark</label>'+
								'<div class="col-lg-4">'+
									'<textarea name="contact_remark[]" id="contact_remark_'+cat_cnt+'"  class="form-control"></textarea>'+
								'</div>';
							<?php	
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="contact_remark[]" id="contact_remark_'+cat_cnt+'" value="" >';					
							<?php
							} ?>
								
			new_row +=		'</div>'+
							'<div class="form-group">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_speciality_offered'))
							{ ?>
			new_row +=			'<label class="col-lg-2 control-label">Speciality Offered</label>'+
								'<div class="col-lg-10">'+
									'<select name="vloc_speciality_offered_'+cat_cnt+'[]" id="vloc_speciality_offered_'+cat_cnt+'" multiple="multiple" class="form-control vloc_speciality_offered" >'+
										'<?php echo $obj->getFavCategoryVendor('13,53,42,64',''); ?>'+
									'</select>'+
								'</div>';
							<?php	
							}
							else
							{ ?>
			new_row +=			'<input type="hidden" name="vloc_speciality_offered_'+cat_cnt+'[]" id="vloc_speciality_offered_'+cat_cnt+'" value="" >';					
							<?php
							} ?>
							
			new_row +=		'</div>'+	
							'<div class="form-group">';
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_menu_file'))
							{ ?>
			new_row +=			'<label class="col-lg-2 control-label">Menu Image/Pdf</label>'+
								'<div class="col-lg-4">'+
									'<input type="file" name="vloc_menu_file[]" id="vloc_menu_file_'+cat_cnt+'" class="form-control">'+
								'</div>';
							<?php
							} ?>	
							
							<?php
							if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vloc_doc_file'))
							{ ?>	
			new_row +=			'<label class="col-lg-2 control-label">Vendor Estt Pdf</label>'+
								'<div class="col-lg-4">'+
									'<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_'+cat_cnt+'" class="form-control">'+
								'</div>';
							<?php
							} ?>	
							
			new_row +=		'</div>'+
							
							'<div class="form-group left-label">'+
								'<label class="col-lg-6 control-label"><strong>Licences, Registration, Certification & Memberships:</strong></label>'+
							'</div>'+
							'<div id="row_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
								'<input type="hidden" name="vc_cert_id_'+i_val+'[]" id="vc_cert_id_'+i_val+'_'+cert_cnt+'" value="0">'+
								'<input type="hidden" name="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" id="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" value="">'+
								'<div class="form-group small-title">';
									
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_type_id'))
								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Type<span style="color:red">*</span></label>'+
									'<div class="col-lg-5">'+
										'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control" required>'+
                                                                                        '<option value="">Select</option>'+
											'<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+
										'</select>'+
									'</div>';
								<?php
								}
								else
								{ ?>
				new_row +=			'<input type="hidden" name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" value="">';
								<?php	
								} ?>								
								
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_name'))
								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Name</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+
									'</div>';
								<?php
								}
								else
								{ ?>
				new_row +=			'<input type="hidden" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="">';
								<?php	
								} ?>	
				
				new_row +=		'</div>'+	
								'<div class="form-group small-title">';
								
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_no'))
								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Number</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+
									'</div>';
								<?php
								}
								else
								{ ?>
				new_row +=			'<input type="hidden" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="">';
								<?php	
								} ?>	
								
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_issued_by'))
								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Issued By</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+
									'</div>';
								<?php
								}
								else
								{ ?>
				new_row +=			'<input type="hidden" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="">';	
								<?php	
								} ?>
								
				new_row +=		'</div>'+	
								'<div class="form-group small-title">';
								
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_reg_date'))
								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Issued Date</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+
									'</div>';
								<?php
								}
								else
								{ ?>
				new_row +=			'<input type="hidden" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="">';	
								<?php	
								} ?>				
									
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_validity_date'))
								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Vaidity Date</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+
									'</div>';
								<?php
								}
								else
								{ ?>
				new_row +=			'<input type="hidden" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="">';	
								<?php	
								} ?>
								
				new_row +=		'</div>'+
								'<div class="form-group small-title">';
								
								<?php
								if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_cert_scan_file'))
								{ ?>
				new_row +=			'<label class="col-lg-1 control-label">Scan Image</label>'+
									'<div class="col-lg-5">'+
										'<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+
									'</div>';
								<?php	
								} ?>
								
				new_row +=		'</div>'+
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
</script>
</body>
</html>
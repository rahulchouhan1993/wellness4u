<?php
require_once('../classes/config.php');
require_once('../classes/admin.php');
$admin_main_menu_id = '11';
$add_action_id = '21';

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

if(!$obj->chkIfAccessOfMenuAction($admin_id,$add_action_id))
{
	header("Location: invalid.php");
	exit(0);
}

$error = false;
$err_msg = "";
$msg = '';

$cat_cnt = 0;
$cat_total_cnt = 1;

$vendor_parent_cat_id = '11';
$vendor_cat_id = '';
$vendor_name = '';
$vendor_username = '';
$arr_vloc_parent_cat_id = array();
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
	<title><?php echo SITE_NAME;?> - Admin</title>
	<?php require_once 'head.php'; ?>
	<link href="assets/css/tokenize2.css" rel="stylesheet" />
</head>
<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">
<?php include_once('header.php');?>
<div class="container">
    <div id="datashow"></div>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel">
				<div class="panel-body">
					<div class="row mail-header">
						<div class="col-md-6">
							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>
						</div>
					</div>
					<hr>
					<center><div id="error_msg"></div></center>
					<form role="form" class="form-horizontal" id="add_event" name="add_event" enctype="multipart/form-data" method="post"> 
						<input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">
						<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">
						<div class="form-group">
                                                        <label class="col-lg-2 control-label">Reference Number</label>
                                                        <div class="col-lg-10">
                                                            <input type="text" name="reference_number" readonly="" id="reference_number" value="<?php echo $obj->getnextrefernceNumber(); ?>" >
                                                            
                                                        </div>
                                                </div>
                                                <div class="form-group">
							<label class="col-lg-2 control-label">Organizer<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="organiser_id" id="organiser_id" class="form-control" required>
									<?php echo $obj->getVendorOption($vendor_id,$type='1',$multiple='0');?>
								</select>
							</div>
                                                        <label class="col-lg-2 control-label">Institution<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<select name="institution_id" id="institution_id" class="form-control" required>
									<?php echo $obj->getVendorOption($institution_id,$type='1',$multiple='0');?>
								</select>
							</div>
						</div>
                                                
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">Sponsor Name</label>
							<div class="col-lg-4">
                                                            <select name="sponsor_id" id="sponsor_id" class="form-control">
									<?php echo $obj->getVendorOption($sponsor_id,$type='1',$multiple='0');?>
                                                            </select>
							</div>
                                                    <label class="col-lg-2 control-label">Event Name<span style="color:red">*</span></label>
							<div class="col-lg-4">
								<input type="text" name="event_name" id="event_name" value="<?php echo $event_name;?>" placeholder="Event Name" class="form-control" required>
							</div>
						</div>
                                                <div class="form-group"><label class="col-lg-2 control-label">Events Contents<span style="color:red">*</span></label>
							<div class="col-lg-8">
								<div class="summernote-theme-1">
									<div class="event_contents" name="event_contents" id="event_contents"><?php echo $event_contents;?></div>
								</div>
							</div>
						</div>
                                                
                                                <div class="form-group">
                                                        <label class="col-lg-2 control-label">Profile Category</label>
                                                        <div class="col-lg-4">
                                                            <select name="profile_cat_1" class="form-control" id="profile_cat_1"  onchange="getMainCategoryOptionAddMore('1')">
                                                            <option value="">All Type</option>	
                                                            <?php echo $obj->getFavCategoryTypeOptions('');?>
                                                            </select>
                                                        </div>
							<label class="col-lg-2 control-label">Fav Category</label>
                                                        <div class="col-lg-4" id="fav_cat_1">
                                                            <select name="fav_cat_1" class="form-control" id="fav_cat_1" >
                                                                <option value="">Select Sub Cat</option>
                                                            </select>
                                                        </div>
						</div>
                                                
                                                <div class="form-group">
                                                        <label class="col-lg-2 control-label">Profile Category</label>
                                                        <div class="col-lg-4">
                                                            <select name="profile_cat_2" class="form-control" id="profile_cat_2"  onchange="getMainCategoryOptionAddMore('2')">
                                                            <option value="">All Type</option>	
                                                            <?php echo $obj->getFavCategoryTypeOptions('');?>
                                                            </select>
                                                        </div>
							<label class="col-lg-2 control-label">Fav Category</label>
                                                        <div class="col-lg-4" id="fav_cat_2">
                                                            <select name="fav_cat_2" class="form-control" id="fav_cat_2" >
                                                                <option value="">Select Sub Cat</option>
                                                            </select>
                                                        </div>
						</div>
                                                
                                                <div class="form-group">
                                                        <label class="col-lg-2 control-label">Profile Category</label>
                                                        <div class="col-lg-4">
                                                            <select name="profile_cat_3" class="form-control" id="profile_cat_3"  onchange="getMainCategoryOptionAddMore('3')">
                                                            <option value="">All Type</option>	
                                                            <?php echo $obj->getFavCategoryTypeOptions('');?>
                                                            </select>
                                                        </div>
							<label class="col-lg-2 control-label">Fav Category</label>
                                                        <div class="col-lg-4" id="fav_cat_3">
                                                            <select name="fav_cat_3" class="form-control" id="fav_cat_3" >
                                                                <option value="">Select Sub Cat</option>
                                                            </select>
                                                        </div>
						</div>
                                                
                                                <div class="form-group">
                                                        <label class="col-lg-2 control-label">Profile Category</label>
                                                        <div class="col-lg-4">
                                                            <select name="profile_cat_4" class="form-control" id="profile_cat_4"  onchange="getMainCategoryOptionAddMore('4')">
                                                            <option value="">All Type</option>	
                                                            <?php echo $obj->getFavCategoryTypeOptions('');?>
                                                            </select>
                                                        </div>
							<label class="col-lg-2 control-label">Fav Category</label>
                                                        <div class="col-lg-4" id="fav_cat_4">
                                                            <select name="fav_cat_4" class="form-control" id="fav_cat_4" >
                                                                <option value="">Select Sub Cat</option>
                                                            </select>
                                                        </div>
						</div>
                                                
                                                <div class="form-group">
                                                        <label class="col-lg-2 control-label">Profile Category</label>
                                                        <div class="col-lg-4">
                                                            <select name="profile_cat_5" class="form-control" id="profile_cat_5"  onchange="getMainCategoryOptionAddMore('5')">
                                                            <option value="">All Type</option>	
                                                            <?php echo $obj->getFavCategoryTypeOptions('');?>
                                                            </select>
                                                        </div>
							<label class="col-lg-2 control-label">Fav Category</label>
                                                        <div class="col-lg-4" id="fav_cat_5">
                                                            <select name="fav_cat_5" class="form-control" id="fav_cat_5" >
                                                                <option value="">Select Sub Cat</option>
                                                            </select>
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
								<label class="col-lg-3 control-label"><strong>Event Details:</strong></label>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Location Category</label>
								<div class="col-lg-4">
									<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_<?php echo $i;?>" class="form-control"  onchange="getMainCategoryOptionAddMoreCommon('vloc',<?php echo $i;?>);" >
										<?php echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[$i]);?>
									</select>
								</div>
								<div class="col-lg-2"></div>
								<div class="col-lg-4">
									<select name="vloc_cat_id[]" id="vloc_cat_id_<?php echo $i;?>" class="form-control" >
										<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[$i],$arr_vloc_cat_id[$i]); ?>
									</select>
								</div>
							</div>

							<div class="form-group">	
								<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>
								<div class="col-lg-4">
                                                                    <input type="text" required="" name="city_id[]" id="city_id_<?php echo $i;?>" placeholder="Select your city" list="capitals_<?php echo $i;?>" class="form-control" onchange="getlocation(<?php echo $i;?>)" />
                                                               
                                                                     <datalist id="capitals_<?php echo $i;?>">
                                                                        <?php echo $obj->getCityOptions(); ?>
                                                                    </datalist>

								</div>
								<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="area_id[]" id="area_id_<?php echo $i;?>" class="form-control" required>
										<?php echo $obj->getAreaOption($arr_country_id[$i],$arr_state_id[$i],$arr_city_id[$i],$arr_area_id[$i]); ?>
									</select>
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-lg-2 control-label">Venue<span style="color:red">*</span></label>
								<div class="col-lg-10">
                                                                    <textarea name="venue[]" id="venue_<?php echo $i;?>" class="form-control" required=""></textarea>
								</div>
							</div>

                                                            <div class="form-group small-title">
									<label class="col-lg-2 control-label">Start Date <span style="color:red">*</span></label>
									<div class="col-lg-4">
                                                                            <input required="" type="text" name="start_date[]" id="start_date_<?php echo $i;?>" style="width:200px; float:left;" value="<?php echo $arr_start_date_time_[$i];?>" placeholder="Start Date" class="form-control clsdatepicker">
                                                                                
                                                                            <select name="start_time[]" id="start_time_<?php echo $i;?>" required="" class="form-control" style="width:120px;">
                                                                                   <option value="">Select Time</option>
                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
                                                                                </select>
                                                                        </div>
									
									<label class="col-lg-2 control-label">End Date <span style="color:red">*</span></label>
									<div class="col-lg-4">
                                                                            <input type="text" name="end_date[]" required="" id="end_date_<?php echo $i;?>" style="width:200px; float:left;" value="<?php echo $arr_end_date_time_[$i];?>" placeholder="End Date" class="form-control clsdatepicker">
                                                                                
                                                                            <select name="end_time[]" id="end_time_<?php echo $i;?>"  required="" class="form-control" style="width:120px;">
                                                                                   <option value="">Select Time</option>
                                                                                    <?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>
                                                                                </select>
                                                                        </div>
								</div>

                                                            <div class="form-group">
                                                                    <label class="col-lg-2 control-label">Time Zone</label>
                                                                    <div class="col-lg-10">
                                                                        <select name="time_zone[]" required="" id="time_zone_<?php echo $i;?>" class="form-control">
                                                                            <option value="">Select Time Zone</option>
                                                                            <?php echo $obj->getFavCategoryRamakant('59',''); ?>
                                                                        </select>
                                                                    </div>
                                                            </div>
                                                        
                                                        <div class="form-group">	
								<label class="col-lg-2 control-label">Venue Image/Pdf<span style="color:red">*</span></label>
								<div class="col-lg-4">
                                                                    <input readonly="" type="file" name="venue_image_file[]" id="venue_image_file_<?php echo $i;?>" class="form-control">
								</div>
								
								<label class="col-lg-2 control-label">Event Image/Pdf</label>
								<div class="col-lg-4">
									<input type="file" name="event_image_file[]" id="event_image_file_<?php echo $i;?>" class="form-control">
								</div>
							</div>

                                                        

                                                        <div class="form-group">
								<label class="col-lg-2 control-label">No of Groups<span style="color:red">*</span></label>
								<div class="col-lg-4">
                                                                    <input required="" type="text" name="no_of_groups[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_groups_<?php echo $i;?>" class="form-control">
								</div>
                                                                
                                                                <label class="col-lg-2 control-label">No of Teams<span style="color:red">*</span></label>
								<div class="col-lg-4">
                                                                    <input required="" type="text" name="no_of_teams[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_teams_<?php echo $i;?>" class="form-control">
								</div>
                                                                
							</div>
                                                        <div class="form-group">
								<label class="col-lg-2 control-label">No of Participants per team<span style="color:red">*</span></label>
								<div class="col-lg-4">
                                                                    <input type="text" required="" name="no_of_participants[]" onKeyPress="return isNumberKey(event);" maxlength="5" id="no_of_participants_<?php echo $i;?>" class="form-control">
								</div>
                                                                
                                                                <label class="col-lg-2 control-label">No of Judges<span style="color:red">*</span></label>
								<div class="col-lg-4">
                                                                    <input type="text" required="" name="no_of_judges[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_judges_<?php echo $i;?>" class="form-control">
								</div>
                                                                
							</div>

							<div class="form-group">	
								<label class="col-lg-2 control-label">Rules and regulation Image/Pdf <span style="color:red">*</span></label>
								<div class="col-lg-4">
                                                                    <input type="file" required="" name="vloc_menu_file[]" id="vloc_menu_file_<?php echo $i;?>" class="form-control">
								</div>
								
								<label class="col-lg-2 control-label">Institution Profile Pdf</label>
								<div class="col-lg-4">
									<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_<?php echo $i;?>" class="form-control">
								</div>
							</div>
                                                        <div class="form-group left-label">
								<label class="col-lg-3 control-label"><strong>Participants Criteria:</strong></label>
							</div>
                                                        <div class="form-group">
								<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select  name="participants_title[]" id="participants_title_<?php echo $i;?>" class="form-control" required>                                                                              
                                                                                <?php echo $obj->getPersonTitleOption($arr_participants_title[$i]);?>
                                                                                <option value="All">All</option>
									</select>
								</div>
								<label class="col-lg-2 control-label">Special Remarks<span style="color:red">*</span></label>
								<div class="col-lg-4">
									
                                                                    <textarea required="" class="form-control" name="parti_remarks[]" id="parti_remarks_<?php echo $i;?>"><?php echo $arr_parti_remarks[$i];?></textarea>
                                                                </div>
								
							</div>
                                                         <div class="form-group">
								<label class="col-lg-2 control-label">From Age Group</label>
								<div class="col-lg-4">
									 <input  type="text" name="from_age[]" id="from_age_<?php echo $i;?>" value="<?php echo $arr_from_age[$i]?>" placeholder="From age" class="form-control" >
								</div>
								
								<label class="col-lg-2 control-label">To Age Group</label>
								<div class="col-lg-4">
                                                                        <input  type="text" name="to_age[]" id="to_age_<?php echo $i;?>" value="<?php echo $arr_to_age[$i]?>" placeholder="To age" class="form-control" >
                                                                </div>
							</div>
                                                         <div class="form-group">
								<label class="col-lg-2 control-label">Height</label>
								<div class="col-lg-4">
									<select name="height[]" id="height_<?php echo $i;?>" class="form-control" >
                                                                            <option value="">Select Height</option>
										<?php   echo $obj->getHeightOptions($arr_height_id[$i]);?>	
                                                                        </select>
								</div>
								
								<label class="col-lg-2 control-label">Weight</label>
								<div class="col-lg-4">
                                                                    <select name="weight[]" id="weight_<?php echo $i;?>" class="form-control" >
                                                                            <option value="">Select Weight</option>
										<?php
										for($we=45;$we<=200;$we++)
										{ ?>
											<option value="<?php echo $we;?>" <?php if($weight == $we) { ?> selected="selected" <?php } ?>><?php echo $we;?> Kgs</option>
										<?php
										} ?>	
                                                                        </select>
								</div>
							</div>
                                                        
                                                        <div class="form-group left-label">
								<label class="col-lg-6 control-label"><strong>Participants Registration, Certification & Memberships:(As applicable)</strong></label>
							</div>
							<?php 
							for($k=0;$k<$arr_cert_total_cnt[$i];$k++)
							{ ?>
							<div id="row_cert_<?php if($k == 0){ echo $i.'_first';}else{ echo $i.'_'.$k;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
								<input type="hidden" name="vc_cert_id_<?php echo $i;?>[]" id="vc_cert_id_<?php echo $i;?>_<?php echo $k;?>" value="0">
								<input type="hidden" name="hdnvc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" id="hdnvc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" value="">
								<div class="form-group small-title">
									<label class="col-lg-1 control-label">Type</label>
									<div class="col-lg-5">
										<select name="vc_cert_type_id_<?php echo $i;?>[]" id="vc_cert_type_id_<?php echo $i;?>_<?php echo $k;?>" class="form-control">
                                                                                    <option value="">Select</option>
                                                                                    <?php echo $obj->getFavCategoryRamakant('47',''); ?>
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
										<input type="file" name="vc_cert_scan_file_<?php echo $i;?>[]" id="vc_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >
									</div>
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
                                                        
                                                        <div class="form-group left-label">
								<label class="col-lg-3 control-label"><strong>Judge Criteria:</strong></label>
							</div>
                                                        <div class="form-group">
								<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>
								<div class="col-lg-4">
									<select name="judge_title[]" id="judge_title_<?php echo $i;?>" class="form-control" required>                                                                              
                                                                                <?php echo $obj->getPersonTitleOption($arr_judge_title[$i]);?>
                                                                                <option value="All">All</option>
									</select>
								</div>
								<label class="col-lg-2 control-label">Special Remarks<span style="color:red">*</span></label>
								<div class="col-lg-4">
									
                                                                    <textarea required="" class="form-control" name="judge_remarks[]" id="judge_remarks_<?php echo $i;?>"><?php echo $arr_judge_remarks[$i];?></textarea>
                                                                </div>
								
							</div>
                                                        <div class="form-group left-label">
								<label class="col-lg-6 control-label"><strong>Judge Registration, Certification & Memberships:(As applicable)</strong></label>
							</div>
							<?php 
							for($k=0;$k<$arr_cert_total_cnt[$i];$k++)
							{ ?>
							<div id="row_judge_cert_<?php if($k == 0){ echo $i.'_first';}else{ echo $i.'_'.$k;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
								<input type="hidden" name="judge_cert_id_<?php echo $i;?>[]" id="judge_cert_id_<?php echo $i;?>_<?php echo $k;?>" value="0">
								<input type="hidden" name="hdnjudge_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" id="hdnjudge_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" value="">
								<div class="form-group small-title">
									<label class="col-lg-1 control-label">Type</label>
									<div class="col-lg-5">
										<select name="judge_cert_type_id_<?php echo $i;?>[]" id="judge_cert_type_id_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >
											<option value="">Select</option>
                                                                                    <?php echo $obj->getFavCategoryRamakant('47',''); ?>
										</select>
									</div>
									
									<label class="col-lg-1 control-label">Name</label>
									<div class="col-lg-5">
										<input type="text" name="judge_cert_name_<?php echo $i;?>[]" id="judge_cert_name_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_name[$i][$k];?>" placeholder="Name" class="form-control">
									</div>
								</div>	
								<div class="form-group small-title">
									<label class="col-lg-1 control-label">Number</label>
									<div class="col-lg-5">
										<input type="text" name="judge_cert_no_<?php echo $i;?>[]" id="judge_cert_no_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_no[$i][$k];?>" placeholder="Number" class="form-control">
									</div>
									
									<label class="col-lg-1 control-label">Issued By</label>
									<div class="col-lg-5">
										<input type="text" name="judge_cert_issued_by_<?php echo $i;?>[]" id="judge_cert_issued_by_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_issued_by[$i][$k];?>" placeholder="Issued By" class="form-control">
									</div>
								</div>	
								<div class="form-group small-title">
									<label class="col-lg-1 control-label">Issued Date</label>
									<div class="col-lg-5">
										<input type="text" name="judge_cert_reg_date_<?php echo $i;?>[]" id="judge_cert_reg_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_reg_date[$i][$k];?>" placeholder="Issued Date" class="form-control clsdatepicker2">
									</div>
									
									<label class="col-lg-1 control-label">Vaidity Date</label>
									<div class="col-lg-5">
										<input type="text" name="judge_cert_validity_date_<?php echo $i;?>[]" id="judge_cert_validity_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_validity_date[$i][$k];?>" placeholder="Validity Date" class="form-control clsdatepicker">
									</div>
								</div>
								<div class="form-group small-title">
									<label class="col-lg-1 control-label">Scan Image</label>
									<div class="col-lg-5">
										<input type="file" name="judge_cert_scan_file_<?php echo $i;?>[]" id="judge_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-2">
									<?php
									if($k == 0)
									{ ?>
										<a href="javascript:void(0);" onclick="addMoreRowCertificateJudge(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>
									<?php  	
									}
									else
									{ ?>
										<a href="javascript:void(0);" onclick="removeRowCertificateJudge(<?php echo $i;?>,<?php echo $k;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>
									<?php	
									}
									?>	
									</div>
								</div>
							</div>	
							<?php
							} ?>
                                                        <div class="form-group left-label">
								<label class="col-lg-3 control-label"><strong>Organiser Social Media Details:</strong></label>
							</div>

                                                        <div class="form-group">
								<label class="col-lg-2 control-label">Facebook</label>
								<div class="col-lg-4">
									<input type="text" name="facebook_page_link[]" id="facebook_page_link_<?php echo $i;?>" value="<?php echo $arr_facebook_page_link[$i]?>" placeholder="Facebook Page Link" class="form-control">
								</div>
								
								<label class="col-lg-2 control-label">Twitter</label>
								<div class="col-lg-4">
									<input type="text" name="twitter_page_link[]" id="twitter_page_link_<?php echo $i;?>" value="<?php echo $arr_twitter_page_link[$i]?>" placeholder="Twitter Page Link" class="form-control">
								</div>
							</div>

                                                        <div class="form-group">
								<label class="col-lg-2 control-label">Instagram</label>
								<div class="col-lg-4">
									<input type="text" name="instagram_page_link[]" id="instagram_page_link_<?php echo $i;?>" value="<?php echo $arr_instagram_page_link[$i]?>" placeholder="Instgram Page Link" class="form-control">
								</div>
								
								<label class="col-lg-2 control-label">Youtube</label>
								<div class="col-lg-4">
									<input type="text" name="youtube_page_link[]" id="youtube_page_link_<?php echo $i;?>" value="<?php echo $arr_youtube_page_link[$i]?>" placeholder="Youtube Channel Link" class="form-control">
								</div>
							</div>
                                                        
                                                        <div class="form-group left-label">
								<label class="col-lg-3 control-label"><strong>Organiser Contact Details:</strong></label>
							</div>
                                                        <div class="form-group">
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
								<label class="col-lg-2 control-label">Contact Designation<span style="color:red">*</span></label>
								<div class="col-lg-4">
                                                                    <select name="contact_designation[]" id="contact_designation_<?php echo $i;?>" class="form-control" required="">
                                                                            <option value="">Select</option>
                                                                                <?php echo $obj->getFavCategoryRamakant('44',''); ?>
									</select>
								</div>
								
								<label class="col-lg-2 control-label">Remark</label>
								<div class="col-lg-4">
									<input type="text" name="contact_remark[]" id="contact_remark_<?php echo $i;?>" value="<?php echo $arr_contact_remark[$i]?>" placeholder="Remark" class="form-control">
								</div>
							</div>
							
							<div class="form-group left-label">
								<label class="col-lg-6 control-label"><strong>Organisers Licences, Registration, Certification & Memberships:</strong></label>
							</div>
							<?php 
							for($k=0;$k<$arr_cert_total_cnt[$i];$k++)
							{ ?>
							<div id="row_org_cert_<?php if($k == 0){ echo $i.'_first';}else{ echo $i.'_'.$k;}?>" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">
								<input type="hidden" name="org_cert_id_<?php echo $i;?>[]" id="org_cert_id_<?php echo $i;?>_<?php echo $k;?>" value="0">
								<input type="hidden" name="hdnorg_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" id="hdnorg_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" value="">
								<div class="form-group small-title">
									<label class="col-lg-1 control-label">Type</label>
									<div class="col-lg-5">
										<select name="org_cert_type_id_<?php echo $i;?>[]" id="org_cert_type_id_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >
                                                                                    <option value="">Select</option>
                                                                                    <?php echo $obj->getFavCategoryRamakant('47',''); ?>
										</select>
									</div>
									
									<label class="col-lg-1 control-label">Name</label>
									<div class="col-lg-5">
										<input type="text" name="org_cert_name_<?php echo $i;?>[]" id="org_cert_name_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_name[$i][$k];?>" placeholder="Name" class="form-control">
									</div>
								</div>	
								<div class="form-group small-title">
									<label class="col-lg-1 control-label">Number</label>
									<div class="col-lg-5">
										<input type="text" name="org_cert_no_<?php echo $i;?>[]" id="org_cert_no_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_no[$i][$k];?>" placeholder="Number" class="form-control">
									</div>
									
									<label class="col-lg-1 control-label">Issued By</label>
									<div class="col-lg-5">
										<input type="text" name="org_cert_issued_by_<?php echo $i;?>[]" id="org_cert_issued_by_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_issued_by[$i][$k];?>" placeholder="Issued By" class="form-control">
									</div>
								</div>	
								<div class="form-group small-title">
									<label class="col-lg-1 control-label">Issued Date</label>
									<div class="col-lg-5">
										<input type="text" name="org_cert_reg_date_<?php echo $i;?>[]" id="org_cert_reg_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_reg_date[$i][$k];?>" placeholder="Issued Date" class="form-control clsdatepicker2">
									</div>
									
									<label class="col-lg-1 control-label">Vaidity Date</label>
									<div class="col-lg-5">
										<input type="text" name="org_cert_validity_date_<?php echo $i;?>[]" id="org_cert_validity_date_<?php echo $i;?>_<?php echo $k;?>" value="<?php echo $arr_vc_cert_validity_date[$i][$k];?>" placeholder="Validity Date" class="form-control clsdatepicker">
									</div>
								</div>
								<div class="form-group small-title">
									<label class="col-lg-1 control-label">Scan Image</label>
									<div class="col-lg-5">
										<input type="file" name="org_cert_scan_file_<?php echo $i;?>[]" id="org_cert_scan_file_<?php echo $i;?>_<?php echo $k;?>" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-2">
									<?php
									if($k == 0)
									{ ?>
										<a href="javascript:void(0);" onclick="addMoreRowCertificateOrg(<?php echo $i;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>
									<?php  	
									}
									else
									{ ?>
										<a href="javascript:void(0);" onclick="removeRowCertificateOrg(<?php echo $i;?>,<?php echo $k;?>);" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>
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
							<div class="col-lg-offset-3 col-lg-10">
								<div class="pull-left">
									<button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
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
<script src="admin-js/add-event-validator.js" type="text/javascript"></script>
<script src="js/tokenize2.js"></script>
<script>
	$(document).ready(function()
	{
		$('.vloc_speciality_offered').tokenize2();
		$('.clsdatepicker').datepicker();
		$('.clsdatepicker2').datepicker({endDate: new Date});
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
				$("#city_id_"+id_val).html(result);
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
								'<label class="col-lg-1 control-label">Type</label>'+
								'<div class="col-lg-5">'+
									'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control">'+
										'<option value="">Select</option>'+
                                                                                ' <?php echo $obj->getFavCategoryRamakant('47',''); ?>'+
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
        
        function addMoreRowCertificateJudge(j_val)
	{
		//alert(j_val);
                //j_val = j_val+1;
		var cert_cnt = parseInt($("#cert_cnt_"+j_val).val());
		cert_cnt = cert_cnt + 1;
		var new_row = '	<div id="row_judge_cert_'+j_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
							'<input type="hidden" name="judge_cert_id_'+j_val+'[]" id="judge_cert_id_'+j_val+'_'+cert_cnt+'" value="0">'+
							'<input type="hidden" name="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" id="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" value="">'+
							'<div class="form-group small-title">'+
								'<label class="col-lg-1 control-label">Type</label>'+
								'<div class="col-lg-5">'+
									'<select name="judge_cert_type_id_'+j_val+'[]" id="judge_cert_type_id_'+j_val+'_'+cert_cnt+'" class="form-control">'+
										'<option value="">Select</option>'+
                                                                                ' <?php echo $obj->getFavCategoryRamakant('47',''); ?>'+
									'</select>'+
								'</div>'+
								
								'<label class="col-lg-1 control-label">Name</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="judge_cert_name_'+j_val+'[]" id="judge_cert_name_'+j_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+
								'</div>'+
							'</div>'+	
							'<div class="form-group small-title">'+
								'<label class="col-lg-1 control-label">Number</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="judge_cert_no_'+j_val+'[]" id="judge_cert_no_'+j_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+
								'</div>'+
								
								'<label class="col-lg-1 control-label">Issued By</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="judge_cert_issued_by_'+j_val+'[]" id="judge_cert_issued_by_'+j_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+
								'</div>'+
							'</div>'+	
							'<div class="form-group small-title">'+
								'<label class="col-lg-1 control-label">Issued Date</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="judge_cert_reg_date_'+j_val+'[]" id="judge_cert_reg_date_'+j_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+
								'</div>'+
								
								'<label class="col-lg-1 control-label">Vaidity Date</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="judge_cert_validity_date_'+j_val+'[]" id="judge_cert_validity_date_'+j_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+
								'</div>'+
							'</div>'+
							'<div class="form-group small-title">'+
									'<label class="col-lg-1 control-label">Scan Image</label>'+
									'<div class="col-lg-5">'+
										'<input type="file" name="judge_cert_scan_file_'+j_val+'[]" id="judge_cert_scan_file_'+j_val+'_'+cert_cnt+'" class="form-control" >'+
									'</div>'+
								'</div>'+
							'<div class="form-group">'+
								'<div class="col-lg-2">'+
									'<a href="javascript:void(0);" onclick="removeRowCertificateJudge('+j_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+
								'</div>'+
							'</div>'+
						'</div>';
		
                //alert(new_row);
		$("#row_judge_cert_"+j_val+"_first").after(new_row);
		$("#cert_cnt_"+j_val).val(cert_cnt);
		
		var cert_total_cnt = parseInt($("#cert_total_cnt_"+j_val).val());
		cert_total_cnt = cert_total_cnt + 1;
		$("#cert_total_cnt_"+j_val).val(cert_total_cnt);
		
		$('.clsdatepicker').datepicker();
		$('.clsdatepicker2').datepicker({endDate: new Date});
	}
        
        function addMoreRowCertificateOrg(k_val)
	{
		
		var cert_cnt = parseInt($("#cert_cnt_"+k_val).val());
		cert_cnt = cert_cnt + 1;
		var new_row = '	<div id="row_org_cert_'+k_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
							'<input type="hidden" name="org_cert_id_'+k_val+'[]" id="org_cert_id_'+k_val+'_'+cert_cnt+'" value="0">'+
							'<input type="hidden" name="hdnorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" id="hdnorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" value="">'+
							'<div class="form-group small-title">'+
								'<label class="col-lg-1 control-label">Type</label>'+
								'<div class="col-lg-5">'+
									'<select name="org_cert_type_id_'+k_val+'[]" id="org_cert_type_id_'+k_val+'_'+cert_cnt+'" class="form-control">'+
										'<option value="">Select</option>'+
                                                                                ' <?php echo $obj->getFavCategoryRamakant('47',''); ?>'+
									'</select>'+
								'</div>'+
								
								'<label class="col-lg-1 control-label">Name</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="org_cert_name_'+k_val+'[]" id="org_cert_name_'+k_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+
								'</div>'+
							'</div>'+	
							'<div class="form-group small-title">'+
								'<label class="col-lg-1 control-label">Number</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="org_cert_no_'+k_val+'[]" id="org_cert_no_'+k_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+
								'</div>'+
								
								'<label class="col-lg-1 control-label">Issued By</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="org_cert_issued_by_'+k_val+'[]" id="org_cert_issued_by_'+k_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+
								'</div>'+
							'</div>'+	
							'<div class="form-group small-title">'+
								'<label class="col-lg-1 control-label">Issued Date</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="org_cert_reg_date_'+k_val+'[]" id="org_cert_reg_date_'+k_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+
								'</div>'+
								
								'<label class="col-lg-1 control-label">Vaidity Date</label>'+
								'<div class="col-lg-5">'+
									'<input type="text" name="org_cert_validity_date_'+k_val+'[]" id="org_cert_validity_date_'+k_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+
								'</div>'+
							'</div>'+
							'<div class="form-group small-title">'+
									'<label class="col-lg-1 control-label">Scan Image</label>'+
									'<div class="col-lg-5">'+
										'<input type="file" name="org_cert_scan_file_'+k_val+'[]" id="org_cert_scan_file_'+k_val+'_'+cert_cnt+'" class="form-control" >'+
									'</div>'+
								'</div>'+
							'<div class="form-group">'+
								'<div class="col-lg-2">'+
									'<a href="javascript:void(0);" onclick="removeRowCertificateOrg('+k_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+
								'</div>'+
							'</div>'+
						'</div>';
		
		$("#row_org_cert_"+k_val+"_first").after(new_row);
		$("#cert_cnt_"+k_val).val(cert_cnt);
		
		var cert_total_cnt = parseInt($("#cert_total_cnt_"+k_val).val());
		cert_total_cnt = cert_total_cnt + 1;
		$("#cert_total_cnt_"+k_val).val(cert_total_cnt);
		
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
	
        function removeRowCertificateJudge(j_val,cert_cnt)
	{
		$("#row_judge_cert_"+j_val+"_"+cert_cnt).remove();

		var cert_total_cnt = parseInt($("#cert_total_cnt_"+j_val).val());
		cert_total_cnt = cert_total_cnt + 1;
		$("#cert_total_cnt_"+j_val).val(cert_total_cnt);
		
	}
        
        function removeRowCertificateOrg(k_val,cert_cnt)
	{
		$("#row_org_cert_"+k_val+"_"+cert_cnt).remove();

		var cert_total_cnt = parseInt($("#cert_total_cnt_"+k_val).val());
		cert_total_cnt = cert_total_cnt + 1;
		$("#cert_total_cnt_"+k_val).val(cert_total_cnt);
		
	}
        
        
	function addMoreRowLocation()
	{
		
		var cat_cnt = parseInt($("#cat_cnt").val());
		cat_cnt = cat_cnt + 1;
		
		var i_val = cat_cnt;
                var j_val = cat_cnt;
                var k_val = cat_cnt;
		var cert_cnt = 0;
		var new_row = 	'<div id="row_loc_'+cat_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
							'<input type="hidden" name="cert_cnt_'+cat_cnt+'" id="cert_cnt_'+cat_cnt+'" value="'+cert_cnt+'">'+
							'<input type="hidden" name="cert_total_cnt_'+cat_cnt+'" id="cert_total_cnt_'+cat_cnt+'" value="1">'+
							'<input type="hidden" name="cert_loop_cnt[]" id="cert_loop_cnt_'+cat_cnt+'" value="'+cat_cnt+'">'+
							'<input type="hidden" name="hdnvloc_doc_file[]" id="hdnvloc_doc_file_'+cat_cnt+'" value="">'+
							'<input type="hidden" name="hdnvloc_menu_file[]" id="hdnvloc_menu_file_'+cat_cnt+'" value="">'+
							'<input type="hidden" name="vloc_id[]" id="vloc_id_'+cat_cnt+'" value="0">'+
							'<div class="form-group left-label">'+
								'<label class="col-lg-3 control-label"><strong>Event Details:</strong></label>'+
							'</div>'+
							'<div class="form-group">'+
								'<label class="col-lg-2 control-label">Location Category</label>'+
								'<div class="col-lg-4">'+
									'<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" class="form-control"  onchange="getMainCategoryOptionAddMoreCommon(\'vloc\','+cat_cnt+');"  >'+
										'<?php echo $obj->getMainProfileOption($arr_vloc_parent_cat_id[0]);?>'+
									'</select>'+
								'</div>'+
								'<div class="col-lg-2"></div>'+
								'<div class="col-lg-4">'+
									'<select name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" class="form-control">'+
										'<?php echo $obj->getMainCategoryOption($arr_vloc_parent_cat_id[0],''); ?>'+
									'</select>'+
								'</div>'+
							'</div>'+
							'<div class="form-group">'+	
								'<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
                                                                        '<input type="text" required="" name="city_id[]" id="city_id_'+cat_cnt+'" placeholder="Select your city" list="capitals_'+cat_cnt+'" class="form-control" onchange="getlocation('+cat_cnt+')" />'+
									'<datalist id="capitals_'+cat_cnt+'">'+
                                                                        '<?php echo $obj->getCityOptions(); ?>'+
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
								'<label class="col-lg-2 control-label">Venue <span style="color:red">*</span></label>'+
								'<div class="col-lg-10">'+
                                                                    '<textarea name="venue[]" id="venue_'+cat_cnt+'" class="form-control" required></textarea>'+
								'</div>'+
							'</div>'+
                                                        
                                                        '<div class="form-group small-title">'+
									'<label class="col-lg-2 control-label">Start Date <span style="color:red">*</span></label>'+
									'<div class="col-lg-4">'+
										'<input type="text" required name="start_date[]" id="start_date_'+cat_cnt+'" style="width:200px; float:left;"  placeholder="Start Date" class="form-control clsdatepicker">'+
                                                                                '<select name="start_time[]" id="start_time_'+cat_cnt+'" class="form-control" style="width:120px;" required>'+
                                                                                   '<option value="">Select Time</option>'+
                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+
                                                                                '</select>'+
                                                                        '</div>'+
									'<label class="col-lg-2 control-label">End Date<span style="color:red">*</span></label>'+
									'<div class="col-lg-4">'+
										'<input required type="text" name="end_date[]" id="end_date_'+cat_cnt+'" style="width:200px; float:left;  placeholder="End Date" class="form-control clsdatepicker">'+
                                                                                '<select required name="end_time[]" id="end_time_'+cat_cnt+'" class="form-control" style="width:100px;">'+
                                                                                   '<option value="">Select Time</option>'+
                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+
                                                                                '</select>'+
                                                                        '</div>'+
								'</div>'+
                                                        
                                                                '<div class="form-group">'+
                                                                    '<label class="col-lg-2 control-label">Time Zone<span style="color:red">*</span></label>'+
                                                                    '<div class="col-lg-10">'+
                                                                        '<select required name="time_zone[]" id="time_zone_'+cat_cnt+'" class="form-control">'+
                                                                            '<option value="">Select Time Zone</option>'+
                                                                            '<?php echo $obj->getFavCategoryRamakant('59',''); ?>'+
                                                                        '</select>'+
                                                                    '</div>'+
                                                            '</div>'+
                                                            
                                                            '<div class="form-group">'+	
								'<label class="col-lg-2 control-label">Venue Image/Pdf <span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input required type="file" name="venue_image_file[]" id="venue_image_file_'+cat_cnt+'" class="form-control">'+
								'</div>'+
								
								'<label class="col-lg-2 control-label">Event Image/Pdf</label>'+
								'<div class="col-lg-4">'+
									'<input type="file" name="event_image_file[]" id="event_image_file_'+cat_cnt+'" class="form-control">'+
								'</div>'+
							'</div>'+
                                                        
                                                         '<div class="form-group">'+
								'<label class="col-lg-2 control-label">No of Groups <span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
                                                                    '<input type="text" name="no_of_groups[]" required onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_groups_'+cat_cnt+'" class="form-control">'+
								'</div>'+
                                                                '<label class="col-lg-2 control-label">No of Teams <span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
                                                                    '<input type="text" name="no_of_teams[]" required onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_teams_'+cat_cnt+'" class="form-control">'+
								'</div>'+
							'</div>'+
                                                       
                                                       '<div class="form-group">'+
								'<label class="col-lg-2 control-label">No of participants per team <span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
                                                                    '<input type="text" required name="no_of_participants[]" onKeyPress="return isNumberKey(event);" maxlength="5" id="no_of_participants_'+cat_cnt+'" class="form-control">'+
								'</div>'+
                                                                
                                                                '<label class="col-lg-2 control-label">No of judges <span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
                                                                    '<input type="text" required name="no_of_judges[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_judges_'+cat_cnt+'" class="form-control">'+
								'</div>'+
                                                                
							'</div>'+
                                                        
                                                        '<div class="form-group">'+	
								'<label class="col-lg-2 control-label">Rules and regulation Image/Pdf <span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="file" required name="vloc_menu_file[]" id="vloc_menu_file_'+cat_cnt+'" class="form-control">'+
								'</div>'+
								
								'<label class="col-lg-2 control-label">Institution Profile Pdf</label>'+
								'<div class="col-lg-4">'+
									'<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_'+cat_cnt+'" class="form-control">'+
								'</div>'+
							'</div>'+
                                                       
                                                        '<div class="form-group left-label">'+
								'<label class="col-lg-3 control-label"><strong>Participants Criteria:</strong></label>'+
							'</div>'+
                                                        
                                                        '<div class="form-group">'+
								'<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="participants_title[]" id="participants_title_'+cat_cnt+'" class="form-control" required>'+                                                                            
                                                                                '<?php echo $obj->getPersonTitleOption('');?>'+
                                                                                '<option value="All">All</option>'+
									'</select>'+
								'</div>'+
								'<label class="col-lg-2 control-label">Special Remarks<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
                                                                        '<textarea required class="form-control" name="parti_remarks[]" id="parti_remarks_'+cat_cnt+'"></textarea>'+
                                                                '</div>'+
							'</div>'+
                                                       
                                                        '<div class="form-group">'+
								'<label class="col-lg-2 control-label">From Age Group</label>'+
								'<div class="col-lg-4">'+
									 '<input  type="text" name="from_age[]" id="from_age_'+cat_cnt+'"  placeholder="From age" class="form-control" >'+
								'</div>'+
								
								'<label class="col-lg-2 control-label">To Age Group</label>'+
								'<div class="col-lg-4">'+
                                                                       '<input  type="text" name="to_age[]" id="to_age_'+cat_cnt+'"  placeholder="To age" class="form-control" >'+
                                                                '</div>'+
							'</div>'+
                                                       
                                                       '<div class="form-group">'+
                                                       '<label class="col-lg-2 control-label">Height</label>'+
								'<div class="col-lg-4">'+
									'<select name="height[]" id="height_'+cat_cnt+'" class="form-control" >'+
                                                                            '<option value="">Select Height</option>'+
										'<?php echo $obj->getHeightOptions(0);?>'+	
                                                                        '</select>'+
								'</div>'+
                                                                '<label class="col-lg-2 control-label">Weight</label>'+
								'<div class="col-lg-4">'+
                                                                    '<select name="weight[]" id="weight_'+cat_cnt+'" class="form-control" >'+
                                                                            '<option value="">Select Weight</option>'+
										'<?php
										for($we=45;$we<=200;$we++)
										{ ?>'+
											'<option value="<?php echo $we;?>" <?php if($weight == $we) { ?> selected="selected" <?php } ?>><?php echo $we;?> Kgs</option>'+
										'<?php
										} ?>'+	
                                                                        '</select>'+
								'</div>'+
                                                       '</div>'+
                                                       
                                                       '<div class="form-group left-label">'+
								'<label class="col-lg-6 control-label"><strong>Participants Registration, Certification & Memberships:(As applicable)</strong></label>'+
							'</div>'+
                                                       
							'<div id="row_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
								'<input type="hidden" name="vc_cert_id_'+i_val+'[]" id="vc_cert_id_'+i_val+'_'+cert_cnt+'" value="0">'+
								'<input type="hidden" name="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" id="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" value="">'+
								'<div class="form-group small-title">'+
									'<label class="col-lg-1 control-label">Type</label>'+
									'<div class="col-lg-5">'+
										'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control" >'+
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
                                                        
                                                         '<div class="form-group left-label">'+
								'<label class="col-lg-3 control-label"><strong>Judge Criteria:</strong></label>'+
							'</div>'+
                                                        
                                                        '<div class="form-group">'+
								'<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select name="judge_title[]" id="judge_title_'+cat_cnt+'" class="form-control" required>'+                                                                           
                                                                                '<?php echo $obj->getPersonTitleOption('');?>'+
                                                                                '<option value="All">All</option>'+
									'</select>'+
								'</div>'+
								'<label class="col-lg-2 control-label">Special Remarks<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									
                                                                        '<textarea class="form-control" name="judge_remarks[]" id="judge_remarks_'+cat_cnt+'" required></textarea>'+
                                                                '</div>'+
								
							'</div>'+
                                                        '<div class="form-group left-label">'+
								'<label class="col-lg-6 control-label"><strong>Judge Registration, Certification & Memberships:(As applicable)</strong></label>'+
							'</div>'+
                                                        
                                                        '<div id="row_judge_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
								'<input type="hidden" name="judge_cert_id_'+j_val+'[]" id="judge_cert_id_'+j_val+'_'+cert_cnt+'" value="0">'+
								'<input type="hidden" name="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" id="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" value="">'+
								'<div class="form-group small-title">'+
									'<label class="col-lg-1 control-label">Type</label>'+
									'<div class="col-lg-5">'+
										'<select name="judge_cert_type_id_'+j_val+'[]" id="judge_cert_type_id_'+j_val+'_'+cert_cnt+'" class="form-control">'+
											'<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+
										'</select>'+
									'</div>'+
									
									'<label class="col-lg-1 control-label">Name</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="judge_cert_name_'+j_val+'[]" id="judge_cert_name_'+j_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+
									'</div>'+
								'</div>'+	
								'<div class="form-group small-title">'+
									'<label class="col-lg-1 control-label">Number</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="judge_cert_no_'+j_val+'[]" id="judge_cert_no_'+j_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+
									'</div>'+
									
									'<label class="col-lg-1 control-label">Issued By</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="judge_cert_issued_by_'+j_val+'[]" id="judge_cert_issued_by_'+j_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+
									'</div>'+
								'</div>'+	
								'<div class="form-group small-title">'+
									'<label class="col-lg-1 control-label">Issued Date</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="judge_cert_reg_date_'+j_val+'[]" id="judge_cert_reg_date_'+j_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+
									'</div>'+
									
									'<label class="col-lg-1 control-label">Vaidity Date</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="judge_cert_validity_date_'+j_val+'[]" id="judge_cert_validity_date_'+j_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+
									'</div>'+
								'</div>'+
								'<div class="form-group small-title">'+
										'<label class="col-lg-1 control-label">Scan Image</label>'+
										'<div class="col-lg-5">'+
											'<input type="file" name="judge_cert_scan_file_'+j_val+'[]" id="judge_cert_scan_file_'+j_val+'_'+cert_cnt+'" class="form-control" >'+
										'</div>'+
									'</div>'+
								'<div class="form-group">'+
									'<div class="col-lg-2">'+
										'<a href="javascript:void(0);" onclick="addMoreRowCertificateJudge('+j_val+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>'+
									'</div>'+
								'</div>'+
							'</div>'+
                                                        
                                                        '<div class="form-group left-label">'+
								'<label class="col-lg-3 control-label"><strong>Organiser Social Media Details:</strong></label>'+
							'</div>'+

                                                       '<div class="form-group">'+
								'<label class="col-lg-2 control-label">Facebook</label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="facebook_page_link[]" id="facebook_page_link_'+cat_cnt+'"  placeholder="Facebook Page Link" class="form-control" >'+
								'</div>'+
								
								'<label class="col-lg-2 control-label">Twitter</label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="twitter_page_link[]" id="twitter_page_link_'+cat_cnt+'" placeholder="Twitter Page Link" class="form-control" >'+
								'</div>'+
							'</div>'+
                                                        
                                                        '<div class="form-group">'+
								'<label class="col-lg-2 control-label">Instagram</label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="instagram_page_link[]" id="instagram_page_link_'+cat_cnt+'" placeholder="Instgram Page Link" class="form-control" >'+
								'</div>'+
								
								'<label class="col-lg-2 control-label">Youtube</label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="youtube_page_link[]" id="youtube_page_link_'+cat_cnt+'"  placeholder="Youtube Channel Link" class="form-control" >'+
								'</div>'+
							'</div>'+
                                                        
                                                        
                                                        '<div class="form-group left-label">'+
								'<label class="col-lg-3 control-label"><strong>Organiser Contact Details:</strong></label>'+
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
									'<input type="text" name="contact_person[]" id="contact_person_'+cat_cnt+'"  placeholder="Contact Person" class="form-control" required>'+
								'</div>'+
							'</div>'+
							
							'<div class="form-group">'+
								'<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_email[]" id="contact_email_'+cat_cnt+'"  placeholder="Contact Email" class="form-control" required>'+
								'</div>'+
								
								'<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_number[]" id="contact_number_'+cat_cnt+'"  placeholder="Contact Number" class="form-control" required>'+
								'</div>'+
							'</div>'+
						
							'<div class="form-group">'+
								'<label class="col-lg-2 control-label">Contact Designation<span style="color:red">*</span></label>'+
								'<div class="col-lg-4">'+
									'<select required name="contact_designation[]" id="contact_designation_'+cat_cnt+'" class="form-control">'+
										'<option value="">Select</option>'+
                                                                                '<?php echo $obj->getFavCategoryRamakant('44',''); ?>'+
									'</select>'+
								'</div>'+
								
								'<label class="col-lg-2 control-label">Remark</label>'+
								'<div class="col-lg-4">'+
									'<input type="text" name="contact_remark[]" id="contact_remark_'+cat_cnt+'"  placeholder="Remark" class="form-control">'+
								'</div>'+
							'</div>'+
                                                        '<div class="form-group left-label">'+
								'<label class="col-lg-6 control-label"><strong>Organisers Licences, Registration, Certification & Memberships:</strong></label>'+
							'</div>'+
                                                        '<div id="row_org_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+
								'<input type="hidden" name="org_cert_id_'+k_val+'[]" id="org_cert_id_'+k_val+'_'+cert_cnt+'" value="0">'+
								'<input type="hidden" name="hdnorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" id="hdnjorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" value="">'+
								'<div class="form-group small-title">'+
									'<label class="col-lg-1 control-label">Type</label>'+
									'<div class="col-lg-5">'+
										'<select name="org_cert_type_id_'+k_val+'[]" id="org_cert_type_id_'+k_val+'_'+cert_cnt+'" class="form-control" >'+
											'<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+
										'</select>'+
									'</div>'+
									
									'<label class="col-lg-1 control-label">Name</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="org_cert_name_'+k_val+'[]" id="org_cert_name_'+k_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+
									'</div>'+
								'</div>'+	
								'<div class="form-group small-title">'+
									'<label class="col-lg-1 control-label">Number</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="org_cert_no_'+k_val+'[]" id="org_cert_no_'+k_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+
									'</div>'+
									
									'<label class="col-lg-1 control-label">Issued By</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="org_cert_issued_by_'+k_val+'[]" id="org_cert_issued_by_'+k_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+
									'</div>'+
								'</div>'+	
								'<div class="form-group small-title">'+
									'<label class="col-lg-1 control-label">Issued Date</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="org_cert_reg_date_'+k_val+'[]" id="org_cert_reg_date_'+k_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+
									'</div>'+
									
									'<label class="col-lg-1 control-label">Vaidity Date</label>'+
									'<div class="col-lg-5">'+
										'<input type="text" name="org_cert_validity_date_'+k_val+'[]" id="org_cert_validity_date_'+k_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+
									'</div>'+
								'</div>'+
								'<div class="form-group small-title">'+
										'<label class="col-lg-1 control-label">Scan Image</label>'+
										'<div class="col-lg-5">'+
											'<input type="file" name="org_cert_scan_file_'+k_val+'[]" id="org_cert_scan_file_'+k_val+'_'+cert_cnt+'" class="form-control" >'+
										'</div>'+
									'</div>'+
								'<div class="form-group">'+
									'<div class="col-lg-2">'+
										'<a href="javascript:void(0);" onclick="addMoreRowCertificateOrg('+k_val+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>'+
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
</script>
<script>
    $(document).ready(function()
    { 
            $('#event_contents').summernote();
    });
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
       
       function isNumberKey(evt){  <!--Function to accept only numeric values-->
    //var e = evt || window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
        return false;
        return true;
	}
    
    function changedate(idval)
    {
     
    }
    
</script>
</body>
</html>
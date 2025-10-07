<?php
require_once('config/class.mysql.php');
require_once('classes/class.rewardpoints.php');
require_once('classes/class.scrollingwindows.php');
$obj = new RewardPoint();

$obj1 = new Scrolling_Windows();

$add_action_id = '147';

if(!$obj->isAdminLoggedIn())
{
header("Location: index.php?mode=login");
exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$add_action_id))
{	
header("Location: index.php?mode=invalid");
exit(0);
}

$display_trfile = '';
$display_trtext = 'none';



$tr_days_of_month = '';
$tr_single_date = 'none';
$tr_date_range = 'none';
$tr_month_date = 'none';
$tr_days_of_week = 'none';


$error = false;
$err_msg = "";

if(isset($_POST['btnSubmit']))
{
$reward_list_module_id = trim($_POST['reward_list_module_id']);
$reward_list_conversion_type_id = trim($_POST['reward_list_conversion_type_id']);
$reward_list_conversion_value = trim($_POST['reward_list_conversion_value']);
$reward_list_cutoff_type_id = trim($_POST['reward_list_cutoff_type_id']);
$reward_list_min_cutoff = trim($_POST['reward_list_min_cutoff']);
$reward_list_max_cutoff = trim($_POST['reward_list_max_cutoff']);
$reward_list_name = trim($_POST['reward_list_name']);
$reward_list_file_type = trim($_POST['reward_list_file_type']);
$reward_list_file2 = trim($_POST['reward_list_file2']);
$reward_list_date = trim($_POST['reward_list_date']);

$event_id=trim($_POST['event_id']);
$identity_type=trim($_POST['identity_type']);
$identity_id=trim($_POST['identity_id']);
$reference_number=trim($_POST['ref_number']);
$event_close_date=trim($_POST['reward_point_close_date']);

$fav_cat_type_id_1 =$_POST['fav_cat_type_id_1'];
$fav_cat_type_id_2 =$_POST['fav_cat_type_id_2'];
$fav_cat_id_1 =$_POST['fav_cat_id_1'];
$fav_cat_id_2 =$_POST['fav_cat_id_2'];
$reward_title_remark =trim($_POST['reward_title_remark']);
$sponsor_type_id = $_POST['sponsor_type_id'];
$sponsor_name = implode(',',$_POST['sponsor_name']);
$sponsor_remarks = $_POST['sponsor_remarks'];
$special_remarks = $_POST['special_remarks'];

$reward_type=$_POST['reward_type'];



$admin_comment=$_POST['admin_comment'];
$tables_names=$_POST['tables_names'];
$columns_dropdown=$_POST['columns_dropdown'];

$tables_names2=$_POST['tables_names2'];
$columns_dropdown_reword=$_POST['columns_dropdown_reword'];
$columns_dropdown_value_reword=$_POST['columns_dropdown_value_reword'];

$shows_cat=$_POST['shows_cat'];
$listing_date_type=$_POST['listing_date_type'];

$days_of_month=$_POST['days_of_month'];
$days_of_month1=implode(',',$days_of_month);

 



$single_date=($_POST['single_date']!="") ? date('y-m-d',strtotime($_POST['single_date'])) : '';

$start_date=($_POST['start_date']!="") ? date('y-m-d',strtotime($_POST['start_date'])):'';
$end_date=($_POST['end_date']!="") ? date('y-m-d',strtotime($_POST['end_date'])) :'';

 $days_of_week=$_POST['days_of_week'];
 $days_of_week1=implode(',',$days_of_week);

 $months=$_POST['months'];
 $months1=implode(',',$months);

 // exit;

 $shows_where=$_POST['shows_where'];
 $shows_gallery=$_POST['shows_gallery'];



    $sponsor_list=$_POST['sponsor_list'];
     if($sponsor_list[0]!="")
     {
      $selected_user_id=$_POST['selected_user_id'];
      $selected_vendor_id=$_POST['selected_vendor_id']; 
      $str_arr1=implode(',',$selected_user_id);
      $str_arr2=implode(',',$selected_vendor_id);

    $value_rr=array_values(array_filter(array($str_arr1,$str_arr2)));
}
else
{
    $sponsor_list=array('self');
    $value_rr=array('wellness');
}

 // echo "<pre>";print_r($value_rr);echo "</pre>";
// exit;
// exit;

if($reward_list_module_id == "")
{
$error = true;
$err_msg = "Please select module.";
}

if($reward_list_conversion_type_id == "")
{
$error = true;
$err_msg .= "<br>Please select conversion type.";
}

if($reward_list_conversion_value == "")
{
$error = true;
$err_msg .= "<br>Please enter conversion value.";
}

if($reward_list_cutoff_type_id == "")
{
$error = true;
$err_msg .= "<br>Please select cutoff type.";
}

if($reward_list_cutoff_type_id != "0")
{
if($reward_list_min_cutoff == "")
{
$error = true;
$err_msg .= "<br>Please enter minimum cutoff.";
}
elseif(!is_numeric($reward_list_min_cutoff))
{
$error = true;
$err_msg .= "<br>Invalid no of minimum cutoff.";
}
}

if($reward_list_name == "")
{
$error = true;
$err_msg .= "<br>Please enter reward name.";
}

if($reward_list_date == "")
{
$error = true;
$err_msg .= "<br>Please enter effective date.";
}

if(!$error)
{
if($reward_list_file_type == 'Video')
{
$display_trfile = 'none';
$display_trtext = '';

$reward_list_file = $reward_list_file2;
if($reward_list_file == '')
{
$error = true;
$err_msg = "Please enter video url.";
}	
}
else
{
$display_trfile = '';
$display_trtext = 'none';

if(isset($_FILES['reward_list_file']['tmp_name']) && $_FILES['reward_list_file']['tmp_name'] != '')
{
$reward_list_file = $_FILES['reward_list_file']['name'];
$file4 = substr($reward_list_file, -4, 4);

if($reward_list_file_type == 'Pdf')
{ 
if((strtolower($file4) != '.pdf'))
{
$error = true;
$err_msg = 'Please Upload Only(pdf) files for reward file';
}	 
}
else
{ 
if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))
{
$error = true;
$err_msg = 'Please Upload Only(jpg/gif/jpeg/png) files for reward file';
}	 
elseif( $_FILES['reward_list_file']['type'] != 'image/jpeg' and $_FILES['reward_list_file']['type'] != 'image/pjpeg'  and $_FILES['reward_list_file']['type'] != 'image/gif' and $_FILES['reward_list_file']['type'] != 'image/png' )
{
$error = true;
$err_msg = 'Please Upload Only(jpg/gif/jpeg/png) files for reward file.';
}
}

if(!$error)
{	

$reward_list_file = time()."_".$reward_list_file;
$temp_dir = SITE_PATH.'/uploads/';
$temp_file = $temp_dir.$reward_list_file;

if(!move_uploaded_file($_FILES['reward_list_file']['tmp_name'], $temp_file)) 
{
if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
$error = true;
$err_msg = 'Couldn\'t Upload reward file';
$reward_list_file = '';
}
}
}  
else
{
$reward_list_file = '';
}	
}
//$reward_terms = $_FILE['reward_terms']['name'];
if(isset($_FILES['reward_terms']['tmp_name']) && $_FILES['reward_terms']['tmp_name'] != '')
{
$reward_terms = $_FILES['reward_terms']['name'];
$file4 = substr($reward_list_file, -4, 4);

if(!$error)
{	

$reward_terms = time()."_".$reward_terms;
$temp_dir = SITE_PATH.'/uploads/';
$temp_file = $temp_dir.$reward_terms;

if(!move_uploaded_file($_FILES['reward_terms']['tmp_name'], $temp_file)) 
{
if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
$error = true;
$err_msg = 'Couldn\'t Upload reward file';
$reward_list_file = '';
}
}
}  
else
{
$reward_terms = '';
}


if(!$error)
{	
if($obj->AddRewardList($fav_cat_type_id_1,$fav_cat_type_id_2,$fav_cat_id_1,$fav_cat_id_2,$reward_title_remark,$sponsor_type_id,$sponsor_name,$sponsor_remarks,$special_remarks,$reward_terms,$reward_list_module_id,$reward_list_conversion_type_id,$reward_list_conversion_value,$reward_list_cutoff_type_id,$reward_list_min_cutoff,$reward_list_max_cutoff,$reward_list_name,$reward_list_file_type,$reward_list_file,$reward_list_date,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_type,$admin_comment,$tables_names,$columns_dropdown,$tables_names2,$columns_dropdown_reword,$columns_dropdown_value_reword,$sponsor_list,$value_rr,$listing_date_type,$days_of_month1,$single_date,$start_date,$end_date,$days_of_week1,$months1,$shows_cat,$shows_where,$shows_gallery))
{
// $sponsor_list0,$sponsor_list1,$str_arr1,$str_arr2,$default_sponsor,$self_sponsor,
    // $listing_date_type,$days_of_month1,$single_date,$start_date,$end_date,$days_of_week1,$months1,$shows_cat,$shows_where,$shows_gallery

$err_msg = "Reward point settings added successfully!";
header('location: index.php?mode=reward_list&msg='.urlencode($err_msg));
}
else
{
$error = true;
$err_msg = "Currently there is some problem.Please try again later.";
}
}	
}
}
else
{
$reward_list_module_id = '';
$reward_list_conversion_type_id = '';
$reward_list_conversion_value = '';
$reward_list_cutoff_type_id = '';
$reward_list_min_cutoff = '';
$reward_list_max_cutoff = '';
$reward_list_name = '';
$reward_list_file_type = '';
$reward_list_file = '';
$reward_list_file2 = '';
$reward_list_date = date('d-m-Y');
}	
?>
<div id="central_part_contents">
<link href="../css/tokenize2.css" rel="stylesheet" />
<div id="notification_contents">
<?php
if($error)
{
?>
<table class="notification-border-e" id="notification" align="center" border="0" width="97%" cellpadding="1" cellspacing="1">
<tbody>
<tr>
<td class="notification-body-e">
<table border="0" width="100%" cellpadding="0" cellspacing="6">
<tbody>
<tr>
<td><img src="images/notification_icon_e.gif" alt="" border="0" width="12" height="10"></td>
<td width="100%">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td class="notification-title-E">Error</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td class="notification-body-e"><?php echo $err_msg; ?></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<?php
}
?>
<!--notification_contents-->
</div>	 
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Reward Item</td>
<td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td>
<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<td class="mainbox-body">
<form action="#" method="post" name="frmadd_contents" id="frmadd_contents" enctype="multipart/form-data" >
<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="table_add">
<tbody>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right"><strong>Identity Type</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><input name="identity_type" type="text" id="identity_type" readonly="" value="Admin" style="width:200px;" ></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>

  
 <tr>
     <td width="20%" align="right"><strong>Admin Notes</strong></td>
     <td width="5%" align="center"><strong>:</strong></td>
     <td width="75%" align="left"><textarea name="admin_comment" type="text" id="admin_comment" value="<?php //echo $admin_comment;?>"  style="width:400px; height: 200px;" ></textarea>
    </td>
</tr>

<tr>
    <td colspan="3" align="center">&nbsp;</td>
</tr>

<tr>
<td align="right"><strong>Identity ID</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><input name="identity_id" type="text" id="identity_id" readonly="" value="<?php echo $admin_id; ?>" style="width:200px;" ></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right"><strong>Reference Number</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><input name="ref_number" type="text" id="ref_number" value="<?php echo $ref_number; ?>" style="width:400px;" ></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>

<tr>
<td width="20%" align="right"><strong>Reward type</strong></td>
<td width="5%" align="center"><strong>:</strong></td>
<td width="75%" align="left">
    <select name="reward_type" id="reward_type" style="width:200px;">
        <?php echo $obj->getFavCategoryRamakant('73',''); ?>
    </select>  
</td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>


<tr>
<td width="20%" align="right"><strong>Module Name</strong></td>
<td width="5%" align="center"><strong>:</strong></td>
<td width="75%" align="left">
<select id="reward_list_module_id" name="reward_list_module_id" style="width:400px;">
<option value="">Select Module </option>
<?php echo $obj->getRewardModuleOptions($reward_list_module_id); ?>
</select>
</td>
</tr>


                           <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>

                         <tr>
                            <td width="20%" align="right"><strong>Tables</strong></td>
                            <td width="5%" align="center"><strong>:</strong></td>
                            <td align="left" align="top">
                             <?php echo $obj->getTableNameOptions_dropdown_kr1(0,'','');?>

                                <select id="columns_dropdown0" style="width:100px;" name="columns_dropdown" onchange="sub_selectTable(0);">
                                <option value="">-Select-</option>
                                </select>

                               
                                  <select  class="" id="tables_names2_0" name="tables_names2" style="width:150px; display: none;" onchange="Selectable2_(0);">
                                      <option value="">-Select-</option>
                                  </select>


                                  <select id="columns_dropdown_reword0" style="width:100px; display: none;" name="columns_dropdown_reword">
                                  </select>

                                  <select id="columns_dropdown_value_reword0" style="width:100px; display: none;" name="columns_dropdown_value_reword">
                                 </select>
                             </td>
                        </tr>

                        <tr>
                        <td colspan="3" align="center">&nbsp;</td>
                        </tr>


                    <tr>
                        <td width="20%" align="right"><strong>Event Name</strong></td>
                        <td width="5%" align="center"><strong>:</strong></td>
                        <td width="75%" align="left">
                            <select id="event_id" name="event_id" style="width:400px;" onchange="ShowData();">
                                <option value="">Select Event</option>
                                <?php echo $obj->getEventOptions($event_id); ?>
                            </select>

                        </td>
                    </tr>
                      <tr>
                        <td colspan="3" align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6" align="center" id="show_data"></td>
                    </tr>


                     
                    <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Reward Main Category 1</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                                <select name="fav_cat_type_id_1" id="fav_cat_type_id_1" style="width:200px;" onchange="getMainCategoryOptionAddMore()">
                                        <!-- <option value="">All Type</option> -->
                                          <?php echo $obj->getRewardMaincat(423,34,'','prof1'); ?> 
                                        <?php //echo $obj->getFavCategoryTypeOptions($fav_cat_type_id_1); //34 ?>
                                    </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Reward Sub Category 1</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                                <select name="fav_cat_id_1" id="fav_cat_id_1" style="width:200px;">
                                        <option value="">All Type</option>
                                        <?php echo $obj->getFavCategoryRamakant($fav_cat_type_id_1,$fav_cat_id_1)?>
                                    </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Reward Main Category 2</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                                <select name="fav_cat_type_id_2" id="fav_cat_type_id_2" style="width:200px;" onchange="getMainCategoryOptionAddMore1()">
                                        <!-- <option value="">All Type</option> -->
                                          <?php echo $obj->getRewardMaincat(423,34,'','prof2'); ?> 
                                        <?php //echo $obj->getFavCategoryTypeOptions($fav_cat_type_id_2)?>
                                    </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Reward Sub Category 2</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                                <select name="fav_cat_id_2" id="fav_cat_id_2" style="width:200px;">
                                        <option value="">All Type</option>
                                        <?php echo $obj->getFavCategoryRamakant($fav_cat_type_id_2,$fav_cat_id_2)?>
                                    </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>

                        <tr>
                            <td align="right"><strong>Reward Title/Remarks</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left"><input name="reward_title_remark" type="text" id="reward_title_remark" value="<?php echo $reward_title_remark; ?>" style="width:400px;" ></td>
                        </tr>

                    <tr>
                        <td colspan="3" align="center">&nbsp;</td>
                    </tr>
                    <tr>
<td align="right"><strong>Conversion Type</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left">
                        <select id="reward_list_conversion_type_id" name="reward_list_conversion_type_id" style="width:400px;">
                            <?php echo $obj->getFavCategoryRamakant('61',$fav_cat_id)?>
                        </select>
                        </td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right"><strong>Conversion Value</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><input name="reward_list_conversion_value" type="text" id="reward_list_conversion_value" value="<?php echo $reward_list_conversion_value; ?>" style="width:400px;" ></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
                    <tr>
<td align="right"><strong>Cutoff Type</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left">
                            <select id="reward_list_cutoff_type_id" name="reward_list_cutoff_type_id" style="width:400px;">
                                <?php echo $obj->getFavCategoryRamakant('61',$fav_cat_id)?>
                            </select>
                            </td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
                    <tr>
<td align="right"><strong>Minimum Cutoff</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><input name="reward_list_min_cutoff" type="text" id="reward_list_min_cutoff" value="<?php echo $reward_list_min_cutoff; ?>" style="width:400px;" ></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right"><strong>Maximum Cutoff</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><input name="reward_list_max_cutoff" type="text" id="reward_list_max_cutoff" value="<?php echo $reward_list_max_cutoff; ?>" style="width:400px;" ></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right"><strong>Reward Name</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><input name="reward_list_name" type="text" id="reward_list_name" value="<?php echo $reward_list_name; ?>" style="width:400px;" ></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right"><strong>Reward File Type</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left">
<select name="reward_list_file_type" id="reward_list_file_type" onChange="toggleRewardFileType()">
<option value="Image" <?php if($reward_list_file_type == 'Image'){ ?> selected <?php } ?>>Image</option>
<option value="Video" <?php if($reward_list_file_type == 'Video'){ ?> selected <?php } ?>>Video</option>
                            <option value="Pdf" <?php if($reward_list_file_type == 'Pdf'){ ?> selected <?php } ?>>Pdf</option>
</select>
</td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right" valign="top"><strong>Reward File</strong></td>
<td align="center" valign="top"><strong>:</strong></td>
<td align="left">
<?php 
if($reward_list_file != '')
{  
if($reward_list_file_type == 'Image')
{ ?>
<img border="0" src="<?php echo SITE_URL.'/uploads/'. $reward_list_file;?>" width="200" height="200"  /> 
<?php
}		
elseif($reward_list_file_type == 'Video')
{   ?>
<iframe width="200" height="200" src="<?php echo $obj->getYoutubeString($reward_list_file2); ?>" frameborder="0" allowfullscreen></iframe>
<?php
}
elseif($reward_list_file_type == 'Pdf')
{   ?>
<a target="_blank" href="<?php echo SITE_URL.'/uploads/'.$reward_list_file;?>"><img border="0" src="images/pdf-download-icon.png" width="50" height="50"  /> </a>
<?php
}	
}
?>
</td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
                   
<tr id="trfile" style="display:<?php echo $display_trfile;?>">
<td width="20%" align="right" valign="top">&nbsp;</td>
<td width="5%" align="center" valign="top">&nbsp;</td>
<td width="75%" align="left"><input type="file" name="reward_list_file" id="reward_list_file" />
</td>
</tr>
<tr id="trtext" style="display:<?php echo $display_trtext;?>">
<td align="right" valign="top">&nbsp;</td>
<td align="center" valign="top">&nbsp;</td>
<td align="left"><input type="text" name="reward_list_file2" id="reward_list_file2" value="<?php echo $reward_list_file2;?>" />
</td>
</tr>

                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Sponsor Type</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                                <select name="sponsor_type_id" id="sponsor_type_id" style="width:200px;">
                                   <?php echo $obj->getFavCategoryRamakant('68','')?>
                                 </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>

                          <tr>
                            <td align="right"><strong>Sponsor List</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                                <select name="sponsor_list[]" id="sponsor_list0" class="vloc_speciality_offered ul_att" onchange="return selectSponsor(0);">
                                    <option value="">Select sponsor list</option>
                                  <option value="user">User</option>
                                  <option value="Wa">Wellness associate</option>
                                </select>
                            </td>
                        </tr>
                       
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>

                        <tr id="add_mores1">
                            <td align="right"><strong>Sponsor name</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                             <div id="display_sponsor0"></div>
                            </td>
                        </tr>
                        <!-- <tr id="add_mores1"></tr> -->

                         <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>

                           
                    <tr>

                        <td align="right" valign="top"><strong>Sponsor Remarks</strong></td>
                        <td align="center" valign="top"><strong>:</strong></td>

                        <td align="left"><textarea id="sponsor_remarks" rows="10" cols="50" name="sponsor_remarks" ><?php echo $narration; ?></textarea></td>

                    </tr>

                    <tr>

                        <td colspan="3" align="center">&nbsp;</td>

                    </tr>
                    <tr>
                        <td align="right" valign="top"><strong>Reward Term & condition</strong></td>
                        <td align="center" valign="top"><strong>:</strong></td>
                        <td align="left">
                            <input type="file" name="reward_terms" id="reward_terms" />
                        </td>
                    </tr>
                    <tr>

                        <td colspan="3" align="center">&nbsp;</td>

                    </tr>
                    <tr>

                        <td align="right" valign="top"><strong>Special Remarks</strong></td>

                        <td align="center" valign="top"><strong>:</strong></td>


                        <td align="left"><textarea id="special_remarks" rows="10" cols="50" name="special_remarks" ><?php echo $narration; ?></textarea></td>

                    </tr>

                    <tr>

                        <td colspan="3" align="center">&nbsp;</td>

                    </tr>
                    <tr>
                        <td align="right"><strong>Effective Date</strong></td>
                        <td align="center"><strong>:</strong></td>
                        <td align="left">
                            <input name="reward_list_date" id="reward_list_date" type="text" value="<?php echo $reward_list_date;?>" style="width:200px;"  />
                            <script>$('#reward_list_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right"><strong>Close Date</strong></td>
                        <td align="center"><strong>:</strong></td>
                        <td align="left">
                            <input name="reward_point_close_date" id="reward_point_close_date" type="text" value="<?php echo $reward_point_close_date;?>" style="width:200px;"  />
                            <script>$('#reward_point_close_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>
                    </tr>



                <tr>
                    <td align="right"><strong>Show</strong></td>
                    <td align="center"><strong>:</strong></td>
                    <td align="left">
                        <select id="shows" name="shows_cat" style="width:400px;">
                           <?php echo $obj->getFavCategoryRamakant('58',$fav_cat_id)?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>
                </tr>


                <tr>
                    <td align="right"><strong>Show Where</strong></td>
                    <td align="center"><strong>:</strong></td>
                    <td align="left">
                        <select id="shows_where" name="shows_where" style="width:400px;">
                           <?php echo $obj->getDatadropdownPage('8','');?> 
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>
                </tr>

                <tr>

                <td align="right"><strong>Date Selection Type</strong></td>

                <td align="center"><strong>:</strong></td>

                <td align="left">
                    <select name="listing_date_type" id="listing_date_type" onchange="toggleDateSelectionType('listing_date_type')" style="width:200px;">

                        <option value="days_of_month" <?php if($listing_date_type == 'days_of_month') { ?> selected="selected" <?php } ?>>Days of Month</option>

                        <option value="single_date" <?php if($listing_date_type == 'single_date') { ?> selected="selected" <?php } ?>>Single Date</option>

                        <option value="date_range" <?php if($listing_date_type == 'date_range') { ?> selected="selected" <?php } ?>>Date Range</option>

                        <option value="month_wise" <?php if($listing_date_type == 'month_wise') { ?> selected="selected" <?php } ?>>Month Wise</option>

                        <option value="days_of_week" <?php if($listing_date_type == 'days_of_week') { ?> selected="selected" <?php } ?>>Days of Week</option>

                    </select>

            </td>

            </tr>
          
          <tr>
            <td colspan="3" align="center">&nbsp;</td>
        </tr>
        <tr id="tr_days_of_month" style="display:<?php echo $tr_days_of_month;?>">
            <td align="right" valign="top"><strong>Select days of month</strong></td>
            <td align="center" valign="top"><strong>:</strong></td>
            <td align="left">
                <select id="days_of_month" name="days_of_month[]" multiple="multiple" style="width:200px;">
                <?php
                for($i=1;$i<=31;$i++)
                    { ?>
                        <option value="<?php echo $i;?>" <?php if (in_array($i, $arr_days_of_month)) {?> selected="selected" <?php } ?>><?php echo $i;?></option>
                    <?php
                    } ?>    
                    </select>&nbsp;*<br>
                    You can choose more than one option by using the ctrl key.
                </td>
            </tr>


            
            <tr id="tr_single_date" style="display:<?php echo $tr_single_date;?>">
                <td align="right" valign="top"><strong>Select Date</strong></td>
                <td align="center" valign="top"><strong>:</strong></td>
                <td align="left">
                    <input name="single_date" id="single_date" type="text" value="<?php echo $single_date;?>" style="width:200px;"  />
                    <script>$('#single_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                </td>
            </tr>


            <tr id="tr_date_range" style="display:<?php echo $tr_date_range;?>">
                <td align="right" valign="top"><strong>Select Date Range</strong></td>
                <td align="center" valign="top"><strong>:</strong></td>
                <td align="left">

                    <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:200px;"  /> - <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:200px;"  />

                    <script>$('#start_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'});$('#end_date').datepick({ minDate: 0 , dateFormat : 'dd-mm-yy'}); </script>
                </td>
            </tr>


            <tr id="tr_days_of_week" style="display:<?php echo $tr_days_of_week;?>">
                <td align="right" valign="top"><strong>Select days of week</strong></td>
                <td align="center" valign="top"><strong>:</strong></td>
                <td align="left">
                    <select id="days_of_week" name="days_of_week[]" multiple="multiple" style="width:200px;">
                    <?php echo $obj1->getDayOfWeekOptionsMultiple($arr_days_of_week); ?>    
                    </select>&nbsp;*<br>
                    You can choose more than one option by using the ctrl key.
                </td>
            </tr>


            <tr id="tr_month_date" style="display:<?php echo $tr_month_date;?>">
                <td align="right" valign="top"><strong>Select Month</strong></td>
                <td align="center" valign="top"><strong>:</strong></td>
                <td align="left">
                    <select id="months" name="months[]" multiple="multiple" style="width:200px;">
                    <?php echo $obj1->getMonthsOptionsMultiple($arr_month); ?>  
                    </select>&nbsp;*<br>
                    You can choose more than one option by using the ctrl key.
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center">&nbsp;</td>
            </tr>

                  <tr>
                    <td align="right"><strong>Show Gallery</strong></td>
                    <td align="center"><strong>:</strong></td>
                    <td align="left">
                        <select id="shows_gallery" name="shows_gallery" style="width:400px;">
                          <option value="1">Yes</option>
                           <option value="0">No</option>
                        </select>
                    </td>
                </tr>



            <tr>
                <td colspan="3" align="center">&nbsp;</td>
            </tr>

    <tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align="left"><input type="Submit" name="btnSubmit" value="Submit" /></td>
</tr>
</tbody>
</table>
</form>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<br>
</div>
<!-- <script src="../js/jquery.min.js"></script> -->
<!-- <script src="../js/tokenize2.js"></script> -->
  <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript">
        tinyMCE.init({
            mode : "exact",
            theme : "advanced",
            elements : "comment,admin_comment",
            plugins : "style,advimage,advlink,emotions",
            theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",
            theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",
        });
    </script>

    <!-- <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script> -->
	<script type="text/javascript">
		tinyMCE.init({
			mode : "exact",
			theme : "advanced",
			elements : "sponsor_remarks,special_remarks",
			plugins : "style,advimage,advlink,emotions",
			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",
			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",
		});
	</script>

<script>
$(document).ready(function()
{
$('.vloc_speciality_offered').tokenize2();	
});
function ShowData()
{
var event_id = $("#event_id").val();
var dataString = 'action=show_event_data_list&event_id='+event_id;
$.ajax({
type: "POST",
url: "include/remote.php",
data: dataString,
cache: false,
success: function(result)
{
//alert(result);
var JSONObject = JSON.parse(result);
//var rslt=JSONObject[0]['status'];
//alert(result);
//alert(sub_cat);
$("#show_data").html(JSONObject[0]['show_data']);
$("#fav_cat_type_id_1").html(JSONObject[0]['fav_cat_type_id_1']);
$("#fav_cat_type_id_2").html(JSONObject[0]['fav_cat_type_id_2']);
}
});
}
</script>
<script>
function getMainCategoryOptionAddMore()
{

var parent_cat_id = $("#fav_cat_type_id_1").val();
//var sub_cat = $("#fav_cat_id_"+idval).val();
//alert(parent_cat_id);
var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id;
$.ajax({
type: "POST",
url: "include/remote.php",
data: dataString,
cache: false,
success: function(result)
{
//alert(result);
//alert(sub_cat);
$("#fav_cat_id_1").html(result);
}
});
}

function getMainCategoryOptionAddMore1()
{

var parent_cat_id = $("#fav_cat_type_id_2").val();
//var sub_cat = $("#fav_cat_id_"+idval).val();
//alert(parent_cat_id);
var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id;
$.ajax({
type: "POST",
url: "include/remote.php",
data: dataString,
cache: false,
success: function(result)
{
//alert(result);
//alert(sub_cat);
$("#fav_cat_id_2").html(result);
}
});
}



function Selectable(get)
{   
    var table_name=$('#tables_names'+get).val();   
    var dataString = 'action=getTableColumnsNameKR&tablm_name='+table_name+'&get='+get;
      $.ajax({
        type: "POST",
        url: "include/remote.php",
        dataType:'JSON',
        data: dataString,
        cache: false,
        success: function(result)
        {
         $('#columns_dropdown'+get).html(result);
         $('#columns_dropdown_value'+get).html(result);
        }
      });

}

function sub_selectTable(get)
{
    var columns_dropdown0=$('#columns_dropdown0'+get).val(); 

    var dataString = 'action=getTableColumnsNameKR_new_field&columns_dropdown0='+columns_dropdown0+'&get='+get;
      $.ajax({
        type: "POST",
        url: "include/remote.php",
        dataType:'JSON',
        data: dataString,
        cache: false,
        success: function(result)
        {

         $('#tables_names2_'+get).html(result);
        $('#tables_names2_'+get).show();

         // $('#columns_dropdown_value'+get).html(result);
        }
      });
}


function Selectable2_(get)
{   
    var table_name=$('#tables_names2_'+get).val();   
    var dataString = 'action=getTableColumnsNameKR&tablm_name='+table_name+'&get='+get;
      $.ajax({
        type: "POST",
        url: "include/remote.php",
        dataType:'JSON',
        data: dataString,
        cache: false,
        success: function(result)
        {
         $('#columns_dropdown_reword'+get).html(result);
         $('#columns_dropdown_value_reword'+get).html(result);
         $('#columns_dropdown_reword'+get).show();
         $('#columns_dropdown_value_reword'+get).show();
        }
      });

}

function selectSponsor(num)
{
  
    var sponsor_list=$('#sponsor_list'+num).val();
    // var display_sponsor=$('#display_sponsor').html();
     if(sponsor_list!="")
    {
         var dataString='action=get_sponsor_name&sponsor_list='+sponsor_list+'&mor_id='+num;
          $.ajax({
            type: "POST",
            url: "include/remote.php",
            dataType:'JSON',
            data: dataString,
            cache: false,
            success: function(result)
            {
            
             $('#display_sponsor'+num).html(result);
            }
        });
  }
  else
  {
     $('#display_sponsor'+num).html('');
  }

}

function add_more_input(idss)
{
    // alert(idss);
    // $var sponsor_list0=$('#sponsor_list0').val();

    // var ul_att=$('.ul_att').length;
    // alert(ul_att);
   // if(ul_att!=2)
   // {
      var html='';
                html +='<tr>'+
                      '<td colspan="3" align="center">&nbsp;</td>'+
                 '</tr>'+
                '<tr>'+
                    '<td align="right"><strong>Sponsor List</strong></td>'+
                    '<td align="center"><strong>:</strong></td>'+
                    '<td align="left">'+
                       '<select name="sponsor_list[]" id="sponsor_list1" class="vloc_speciality_offered ul_att" onchange="return selectSponsor(1);">'+
                            '<option value="">Select sponsor list</option>'+
                            '<option value="user">User</option>'+
                            '<option value="Wa">Wellness associate</option>'+
                      '</select>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td colspan="3" align="center">&nbsp;</td>'+
                '</tr>'+
                '<tr>'+
                    '<td align="right"><strong>Sponsor name</strong></td>'+
                    '<td align="center"><strong>:</strong></td>'+
                    '<td align="left">'+
                    '<div id="display_sponsor1"></div>'+
                     '<td>'+
                 '</tr>';
  
    $('#table_add tr:#add_mores1').after(html);
 // }



// alert($idss);
}


 // if(sponsor_list0=='user')
 //                            {
 //                              html +='<option value="Wa">Wellness associate</option>';
 //                            }
 //                            else
 //                            {
 //                             html +='<option value="user">User</option>';  
 //                            }


</script>

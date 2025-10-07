<?php
require_once('config/class.mysql.php');
require_once('classes/class.rewardpoints.php');
require_once('classes/class.scrollingwindows.php');
require_once('classes/class.contents.php'); 
$obj2 = new Contents();

$obj = new RewardPoint();
$obj1 = new Scrolling_Windows();
$edit_action_id = '165';

if(!$obj->isAdminLoggedIn())
{

header("Location: index.php?mode=login");
exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$edit_action_id))
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
$reward_list_id = $_POST['hdnreward_list_id'];  
$reward_list_module_id = trim($_POST['hdnreward_list_module_id']);
$reward_list_conversion_type_id = trim($_POST['hdnreward_list_conversion_type_id']);
$reward_list_conversion_value = trim($_POST['hdnreward_list_conversion_value']);
$reward_list_cutoff_type_id = trim($_POST['hdnreward_list_cutoff_type_id']);
$reward_list_min_cutoff = trim($_POST['hdnreward_list_min_cutoff']);
$reward_list_max_cutoff = trim($_POST['hdnreward_list_max_cutoff']);
$reward_list_name = trim($_POST['hdnreward_list_name']);
$reward_list_file_type = trim($_POST['reward_list_file_type']);
$reward_list_file2 = trim($_POST['reward_list_file2']);
$reward_terms = trim($_POST['reward_terms']);
$reward_list_date = trim($_POST['hdnreward_list_date']);
$reward_list_status = trim($_POST['reward_list_status']);

$sponsor_remarks = $_POST['sponsor_remarks'];
$special_remarks = $_POST['special_remarks'];
$reward_type=trim($_POST['reward_type']);

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

     $sponsor_list=array_values(array_filter($_POST['sponsor_list']));

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




 $shows_where=$_POST['shows_where'];
 $shows_gallery=$_POST['shows_gallery'];



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
$reward_list_file = strip_tags(trim($_POST['hdnreward_list_file']));
}	
}

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
$reward_terms = '';
}
}
}  
else
{
$reward_terms = strip_tags(trim($_POST['hdnreward_terms']));
}

if(!$error)
{
if($obj->updateRewardList($special_remarks,$sponsor_remarks,$reward_terms,$reward_list_id,$reward_list_module_id,$reward_list_conversion_type_id,$reward_list_conversion_value,$reward_list_cutoff_type_id,$reward_list_min_cutoff,$reward_list_max_cutoff,$reward_list_name,$reward_list_file_type,$reward_list_file,$reward_list_status,$reward_list_date,$reward_type,$shows_cat,$listing_date_type,$days_of_month1,$single_date,$start_date,$end_date,$days_of_week1,$months1,$sponsor_list,$value_rr,$shows_where,$shows_gallery,$admin_comment))
{
$msg = "Record Updated Successfully!";
header('location: index.php?mode=reward_list&msg='.urlencode($msg));
}
else
{
$error = true;
$err_msg = "Currently there is some problem.Please try again later.";
}
}
}
elseif(isset($_GET['id']))
{


$reward_list_id = $_GET['id'];
list($fav_cat_type_id_1,$fav_cat_type_id_2,$fav_cat_id_1,$fav_cat_id_2,$reward_title_remark,$sponsor_type_id,$sponsor_name,$sponsor_remarks,$special_remarks,$reward_terms,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_list_module_id,$reward_list_conversion_type_id,$reward_list_conversion_value,$reward_list_cutoff_type_id,$reward_list_min_cutoff,$reward_list_max_cutoff,$reward_list_name,$reward_list_file_type,$reward_list_file,$reward_list_status,$reward_list_date,$reward_type,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$days_of_week,$months,$arr_v,$show_cat,$shows_where,$shows_gallery,$admin_comment) = $obj->getRewardListDetails($reward_list_id);





// $listing_date_type = $design_data['listing_date_type'];                              
if($listing_date_type == 'days_of_month')

    {
        $tr_days_of_week = 'none';
        $tr_days_of_month = '';
        $tr_single_date = 'none';
        $tr_date_range = 'none';
        $tr_month_date = 'none';

        $single_date = '';
        $start_date = '';
        $end_date = '';
        $days_of_week = '';

        $pos = strpos($days_of_month, ',');
        if ($pos !== false) 
        {
            $arr_days_of_month = explode(',',$days_of_month);
        }
        else
        {
            array_push($arr_days_of_month , $days_of_month);
        }
        
//        echo '<pre>';
//        print_r($arr_days_of_month);
//        echo '</pre>';
        
    }
    elseif($listing_date_type == 'days_of_week')
    {

        $tr_days_of_week = '';
        $tr_days_of_month = 'none';
        $tr_single_date = 'none';
        $tr_date_range = 'none';
        $tr_month_date = 'none';
        $single_date = '';
        $start_date = '';
        $end_date = '';
        $days_of_month = '';

        $pos = strpos($days_of_week, ',');

        if ($pos !== false) 
        {
            $arr_days_of_week = explode(',',$days_of_week);
        }
        else
        {
            array_push($arr_days_of_week , $days_of_week);
        }
    }

    elseif($listing_date_type == 'single_date')

    {

        $tr_days_of_week = 'none';
        $tr_days_of_month = 'none';
        $tr_single_date = '';
        $tr_date_range = 'none';
        $tr_month_date = 'none';
        $days_of_month = '';
        $start_date = '';
        $end_date = '';
        $days_of_week = '';
        $single_date = date('d-m-Y',strtotime($single_date));

    }

    elseif($listing_date_type == 'date_range')

    {

        $tr_days_of_week = 'none';
        $tr_days_of_month = 'none';
        $tr_single_date = 'none';
        $tr_date_range = '';
        $tr_month_date = 'none';
        $days_of_month = '';
        $single_date = '';
        $days_of_week = '';
        $start_date = date('d-m-Y',strtotime($start_date));
        $end_date = date('d-m-Y',strtotime($end_date));

    }

    elseif($listing_date_type == 'month_wise')

    {

        $tr_days_of_week = 'none';
        $tr_days_of_month = 'none';
        $tr_single_date = 'none';
        $tr_date_range = 'none';
        $tr_month_date = '';
        $single_date = '';
        $start_date = '';
        $end_date = '';
        $days_of_month = '';
        $days_of_week = '';
        $pos = strpos($months, ',');
        if ($pos !== false) 
        {
            $arr_month = explode(',',$months);
        }
        else
        {
            array_push($arr_month , $months);
        }

    }
                                   
    else
    {
        $box_title = '';
        $banner_type = '';
        $box_desc = '';
        $credit_line = '';
        $arr_day = array();
        $credit_line_url = 'http://';
        $tr_days_of_month = 'none';
        $tr_single_date = 'none';
        $tr_date_range = 'none';
        $tr_month_date = 'none';
        $tr_days_of_week = 'none';
        $arr_days_of_month = array();
        $arr_days_of_week = array();
        $arr_month = array();
    }









if($reward_list_file_type == 'Video')
{
$display_trfile = 'none';
$display_trtext = '';

$reward_list_file2 = $reward_list_file;
}
else
{
$display_trfile = '';
$display_trtext = 'none';
}

$reward_list_date = date('d-m-Y',strtotime($reward_list_date));
$event_close_date = date('d-m-Y',strtotime($event_close_date));
}	
else
{
header('location: index.php?mode=invalid');
exit(0);
}













// echo "<pre>";print_r($sponsor_list1);echo "</pre>";
// echo "<pre>";print_r($sponsor_list2);echo "</pre>";
// echo "<pre>";print_r($str_sponsor_name1);echo "</pre>";
// echo "<pre>";print_r($str_sponsor_name2);echo "</pre>";

?>
<script type="text/javascript" src="js/jscolor.js"></script>
<div id="central_part_contents">
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
<table border="0" width="97%" align="center" cellpadding="0" cellspacing="0" >
<tbody>
<tr>
<td>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Reward Item</td>
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
<form action="#" method="post" name="frmedit_daily_meal" id="frmedit_daily_meal" enctype="multipart/form-data" >
<input type="hidden" name="hdnreward_list_id" id="hdnreward_list_id" value="<?php echo $reward_list_id;?>" />
<input type="hidden" name="hdnreward_list_file" id="hdnreward_list_file" value="<?php echo $reward_list_file;?>" />
                <input type="hidden" name="hdnreward_list_module_id" id="hdnreward_list_module_id" value="<?php echo $reward_list_module_id;?>" />
                <input type="hidden" name="hdnreward_list_conversion_type_id" id="hdnreward_list_conversion_type_id" value="<?php echo $reward_list_conversion_type_id;?>" />
                <input type="hidden" name="hdnreward_list_conversion_value" id="hdnreward_list_conversion_value" value="<?php echo $reward_list_conversion_value;?>" />
                <input type="hidden" name="hdnreward_list_cutoff_type_id" id="hdnreward_list_cutoff_type_id" value="<?php echo $reward_list_cutoff_type_id;?>" />
                <input type="hidden" name="hdnreward_list_min_cutoff" id="hdnreward_list_min_cutoff" value="<?php echo $reward_list_min_cutoff;?>" />
                <input type="hidden" name="hdnreward_list_max_cutoff" id="hdnreward_list_max_cutoff" value="<?php echo $reward_list_max_cutoff;?>" />
                <input type="hidden" name="hdnreward_list_name" id="hdnreward_list_name" value="<?php echo $reward_list_name;?>" />
                <input type="hidden" name="hdnreward_list_date" id="hdnreward_list_date" value="<?php echo $reward_list_date;?>" />
                <input type="hidden" name="hdnreward_terms" id="hdnreward_terms" value="<?php echo $reward_terms;?>" />
                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="table_add">
<tbody>
                    <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Identity Type</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left"><?php echo $identity_type; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>

                       <tr>
						<td colspan="3" align="center">&nbsp;</td>
						</tr>
						 <tr>
						     <td width="20%" align="right"><strong>Admin Notes</strong></td>
						     <td width="5%" align="center"><strong>:</strong></td>
						     <td width="75%" align="left"><textarea name="admin_comment" type="text" id="admin_comment"  style="width:400px; height: 200px;" ><?php echo $admin_comment;?></textarea>
						    </td>
						</tr>




                        <tr>
                            <td align="right"><strong>Identity ID</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left"><?php echo $identity_id; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Reference Number</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left"><?php echo $reference_number; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>



<tr>
<td width="20%" align="right"><strong>Reward type</strong></td>
<td width="5%" align="center"><strong>:</strong></td>
   <td width="75%" align="left">
       <select name="reward_type" id="reward_type" style="width:200px;">
            <option value="<?php echo $reward_type[0];?>"><?php echo $reward_type[1];?></option>
            <!-- echo $reward_type; -->
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
<td width="75%" align="left"><strong><?php echo $obj->getRewardModuleTitle($reward_list_module_id); ?></strong></td>
</tr>


<tr>
    <td colspan="3" align="center">&nbsp;</td>
</tr>

 <tr>
    <td width="20%" align="right"><strong>Tables</strong></td>
    <td width="5%" align="center"><strong>:</strong></td>
    <td align="left" align="top">
     <?php echo $obj->getTableNameOptions_dropdown_kr1(0,'','disabled');?>

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
                        <td width="20%" align="right"><strong>Event Details</strong></td>
                        <td width="5%" align="center"><strong>:</strong></td>
                        <td width="75%" align="left">
                           <?php echo $obj->getEventdatashow($event_id); ?>
                        </td>
                    </tr>


                    
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Reward Main Category 1</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                                <?php echo $obj->getprofcatname($fav_cat_type_id_1); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Reward Sub Category 1</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                               <?php echo $obj->getFavCategoryNameVivek($fav_cat_id_1); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Reward Main Category 2</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                              <?php echo $obj->getprofcatname($fav_cat_type_id_2); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Reward Sub Category 2</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                               <?php echo $obj->getFavCategoryNameVivek($fav_cat_id_2); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>

                        <tr>
                            <td align="right"><strong>Reward Title/Remarks</strong></td>
                            <td align="center"><strong>:</strong></td>
                            <td align="left">
                                <?php echo $reward_title_remark; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">&nbsp;</td>
                        </tr>
                        <tr>
<td align="right"><strong>Conversion Type</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><strong><?php echo $obj->getpfavcatname($reward_list_conversion_type_id); ?></strong></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right"><strong>Conversion Value</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><strong><?php echo $reward_list_conversion_value; ?></strong></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right"><strong>Cutoff Type</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><strong><?php echo $obj->getpfavcatname($reward_list_cutoff_type_id); ?></strong></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right"><strong>Minimum Cutoff</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><strong><?php echo $reward_list_min_cutoff; ?></strong></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right"><strong>Maximum Cutoff</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><strong><?php echo $reward_list_max_cutoff; ?></strong></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right"><strong>Reward Name</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left"><strong><?php echo $reward_list_name; ?></strong></td>
</tr>
<tr>
<td colspan="3" align="center">&nbsp;</td>
</tr>
                            <tr>
                                <td align="right"><strong>Effective Date</strong></td>
                                <td align="center"><strong>:</strong></td>
                                <td align="left"><strong><?php echo $reward_list_date;?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="right"><strong>Closing Date</strong></td>
                                <td align="center"><strong>:</strong></td>
                                <td align="left"><strong><?php echo $event_close_date;?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>
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
                               <?php echo $obj->getFavCategoryNameVivek($sponsor_type_id); ?>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">&nbsp;</td>
                            </tr>

<!-- ----krishna---- -->

                       <?php
                    // $get_val=array(array($sponsor_list1,$str_sponsor_name1),array($sponsor_list2,$str_sponsor_name2));
                       // echo
                       $cont= count($arr_v);
                       foreach($arr_v as $key=>$spon_val)
                       {

                          if($spon_val['sponsor_type']!="self")
                          {
                            // echo $cont;
                        ?>

                         
                         <tr>
                                <td align="right"><strong>Sponsor List</strong></td>
                                <td align="center"><strong>:</strong></td>
                                <td align="left">
                                    <select name="sponsor_list[]" id="sponsor_list<?php echo $key;?>" class="vloc_speciality_offered ul_att" onchange="return selectSponsor(<?php echo $key;?>);">
                                 <?php
                                     if($spon_val['sponsor_type']=="user")
                                     {
                                        ?>
                                        <option value="<?php echo $spon_val['sponsor_type'];?>">User</option>
                                        <option value="Wa">Wellness associate</option>
                                        <?php
                                     }
                                     else
                                     {
                                        ?>
                                          <option value="Wa">Wellness associate</option>
                                          <option value="user">User</option>
                                        <?php
                                      }
                                      ?>  
                                      <option value="">Select sponsor list</option>
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
                                <?php echo $obj2->multisponsor_name($spon_val['sponsor_type'],$key,$spon_val['sponsor_name'],$cont);?>
                                </td>
                            </tr>
                             <tr>
                                <td colspan="3" align="center">&nbsp;</td>
                            </tr>

                             <?php
                         }
                         else
                         {
                            ?>
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

                             <tr id="add_mores1">
                                <td align="right"><strong>Sponsor name</strong></td>
                                <td align="center"><strong>:</strong></td>
                                <td align="left">
                                <div id="display_sponsor0"></div>
                                <?php
                                echo $spon_val['sponsor_name'];
                                ?>
                                </td>
                            </tr>

                            <?php
                         }
                    }
                        ?>

                            <tr>
                                <td colspan="3" align="center">&nbsp;</td>
                            </tr>



                         <!--   <?php
                            // if($str_sponsor_name1!="")
                            // {
                           ?>
                              <tr>
                                <td align="right"><strong>Sponsor List</strong></td>
                                <td align="center"><strong>:</strong></td>
                                <td align="left">
                                    <select name="sponsor_list0" id="sponsor_list0" class="vloc_speciality_offered ul_att" onchange="return selectSponsor(0);">

                                      <?php
                                     // if($sponsor_list1=="user")
                                     // {
                                        ?>
                                        <option value="<?php echo $sponsor_list1;?>">User</option>
                                        <option value="Wa">Wellness associate</option>
                                        <?php
                                     // }
                                     // else
                                     // {
                                        ?>
                                          <option value="Wa">Wellness associate</option>
                                          <option value="user">User</option>
                                        <?php
                                     // }
                                      ?>
                                       <option value="">Select sponsor list</option>
                                    </select>
                                </td>
                            </tr>



                            <tr id="add_mores1">
                                <td align="right"><strong>Sponsor name</strong></td>
                                <td align="center"><strong>:</strong></td>
                                <td align="left">
                                <?php //echo $obj2->multisponsor_name($sponsor_list1,'',$str_sponsor_name1);?>

                                   <div id="display_sponsor0"></div>
                                </td>
                            </tr>
                              <tr>
                                <td colspan="3" align="center">&nbsp;</td>
                             </tr>
                         <?php
                       // }
                    ?> -->


                       <!--  <?php
                            // if($str_sponsor_name2!="")
                            // {
                             ?>

                              <tr>
                                <td align="right"><strong>Sponsor List</strong></td>
                                <td align="center"><strong>:</strong></td>
                                <td align="left">
                                    <select name="sponsor_list0" id="sponsor_list0" class="vloc_speciality_offered ul_att" onchange="return selectSponsor(0);"> -->

                                 <!--      <?php
                                     // if($sponsor_list2=="user")
                                     // {
                                        ?>
                                        <option value="<?php echo $sponsor_list1;?>">User</option>
                                        <option value="Wa">Wellness associate</option>
                                        <?php
                                     // }
                                     // else
                                     // {
                                        ?>
                                          <option value="Wa">Wellness associate</option>
                                          <option value="user">User</option>
                                        <?php
                                     // }
                                      ?>
                                       <option value="">Select sponsor list</option>
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
                                 <?php //echo $obj2->multisponsor_name($sponsor_list2,'',$str_sponsor_name2);?>
                                   <div id="display_sponsor0"></div>
                                </td>
                            </tr> -->
                            <?php
                          // }
                            ?>


                            <tr>
                                <td colspan="3" align="center">&nbsp;</td>
                            </tr>
                        <tr>

                            <td align="right" valign="top"><strong>Sponsor Remarks</strong></td>

                            <td align="center" valign="top"><strong>:</strong></td>


                            <td align="left"><textarea id="sponsor_remarks" rows="10" cols="50" name="sponsor_remarks" ><?php echo $sponsor_remarks; ?></textarea></td>

                        </tr>

                        <tr>

                            <td colspan="3" align="center">&nbsp;</td>

                        </tr>
                       
                        <tr>
<td align="right" valign="top"><strong>Reward Term & condition</strong></td>
<td align="center" valign="top"><strong>:</strong></td>
<td align="left">
                                    <input type="file" name="reward_terms" id="reward_terms" />
<?php 
                                $ext = pathinfo($reward_terms, PATHINFO_EXTENSION);
                                //echo $ext;
                                if(($ext == 'jpg')|| ($ext == 'JPG') || ($ext =='jpeg') || ($ext == 'JPEG') || ($ext =='gif') || ($ext == 'GIF') || ($ext =='png') || ($ext == 'PNG'))								
                                    { ?>
<img border="0" src="<?php echo SITE_URL.'/uploads/'.$reward_terms;?>" width="200" height="200"  /> 
                                    <?php
                                    }
                                    elseif($ext == 'Pdf')
                                    {   ?>
                                    <a target="_blank" href="<?php echo SITE_URL.'/uploads/'.$reward_terms;?>"><img border="0" src="images/pdf-download-icon.png" width="50" height="50"  /> </a>
                                    <?php
                                    
                                    }
                                ?>
</td>
</tr>
                        <tr>

                            <td colspan="3" align="center">&nbsp;</td>

                        </tr>
                        <tr>

                            <td align="right" valign="top"><strong>Special Remarks</strong></td>

                            <td align="center" valign="top"><strong>:</strong></td>


                            <td align="left"><textarea id="special_remarks" rows="10" cols="50" name="special_remarks" ><?php echo $special_remarks; ?></textarea></td>

                        </tr>

                        <tr>

                            <td colspan="3" align="center">&nbsp;</td>

                        </tr>






<!-- $show_cat -->

               <tr>
                    <td align="right"><strong>Show</strong></td>
                    <td align="center"><strong>:</strong></td>
                    <td align="left">
                        <select id="shows" name="shows_cat" style="width:400px;">
                           <?php echo $obj->getFavCategoryRamakant('58',$show_cat)?>
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
                           <?php echo $obj->getDatadropdownPage('8',$shows_where);?> 
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
                <select id="shows_where" name="shows_where" style="width:400px;">
                    <?php
                     if($shows_gallery==0)
                     {
                        ?>
                        <option value="<?php echo $shows_gallery;?>">No</option>
                        <option value="1">Yes</option>
                        <?php
                     }
                     else
                     {
                        ?>
                        <option value="<?php echo $shows_gallery;?>">Yes</option>
                         <option value="0">No</option>
                        <?php
                     }
                    ?>
                  
                </select>
            </td>
        </tr>

        <tr>
          <td colspan="3" align="center">&nbsp;</td>
      </tr>



                        
 <tr>
<td align="right"><strong>Status</strong></td>
<td align="center"><strong>:</strong></td>
<td align="left">
<select id="reward_list_status" name="reward_list_status" style="width:200px;">
	<option value="0" <?php if($reward_list_status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
	<option value="1" <?php if($reward_list_status == '1') { ?> selected="selected" <?php } ?>>Active</option>
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
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
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

 <!-- <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script> -->
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

    <script>
    	
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
    // alert(num);
    var sponsor_list=$('#sponsor_list'+num).val();
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

}




    </script>
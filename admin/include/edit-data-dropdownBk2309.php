<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');  
require_once('classes/class.places.php');

require_once('classes/class.dailymeals.php');
$obj1 = new Daily_Meals();
$obj = new Contents();
$obj2 = new Places();


require_once('classes/class.scrollingwindows.php');
$obj1 = new Scrolling_Windows();

$edit_action_id = '295';

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

$error = false;
$err_msg = "";

$prof_cat1 = array();
$prof_cat2 = array();
$prof_cat3 = array();
$prof_cat4 = array();
$prof_cat5 = array();
$prof_cat6 = array();
$prof_cat7 = array();
$prof_cat8 = array();
$prof_cat9 = array();
$prof_cat10 = array();

if(isset($_POST['btnSubmit']))
{
    
//    echo '<pre>';
//    print_r($_POST);
//    echo '</pre>';
//    die();
    $id = strip_tags(trim($_POST['hdnpd_id']));
    $healcareandwellbeing = $_POST['healcareandwellbeing'];
    
    $time_show = $_POST['time_show'];
    $duration_show = $_POST['duration_show'];
    $location_show = $_POST['location_show'];
    $like_dislike_show = $_POST['like_dislike_show'];
    $set_goals_show = $_POST['set_goals_show'];
    $scale_show = $_POST['scale_show'];
    $reminder_show = $_POST['reminder_show'];
    $comments_show = $_POST['comments_show'];
    $heading = strip_tags(trim($_POST['heading']));
    $order_show = strip_tags(trim($_POST['order_show']));
    
    $location_category = implode(',', $_POST['location_category']);
    $user_response_category = implode(',', $_POST['user_response_category']);
    $user_what_next_category = implode(',', $_POST['user_what_next_category']);
    $alerts_updates_category = implode(',', $_POST['alerts_updates_category']);
    $data_source = $_POST['data_source'];
    
    
    $arr_heading = array();
    $arr_heading['time_heading']=$_POST['time_heading'];
    $arr_heading['duration_heading']=$_POST['duration_heading'];
    $arr_heading['location_heading']=$_POST['location_heading'];
    $arr_heading['like_dislike_heading']=$_POST['like_dislike_heading'];
    $arr_heading['set_goals_heading']=$_POST['set_goals_heading'];
    $arr_heading['scale_heading']=$_POST['scale_heading'];
    $arr_heading['reminder_heading']=$_POST['reminder_heading'];
    $arr_heading['comments_heading']=$_POST['comments_heading'];
    
    $page_name = strip_tags(trim($_POST['page_name']));
    
    $pag_cat_status = strip_tags(trim($_POST['pag_cat_status']));
    
    $ref_code = strip_tags(trim($_POST['ref_code']));
    
    $prof_cat1 = $_POST['fav_cat_type_id'];
    
    $prof_cat2 = $_POST['fav_cat_type_id2'];
    
    $prof_cat3 = $_POST['fav_cat_type_id3'];
    
    $prof_cat4 = $_POST['fav_cat_type_id4'];
    
    $prof_cat5 = $_POST['fav_cat_type_id5'];
    
    $prof_cat6 = $_POST['fav_cat_type_id6'];
    
    $prof_cat7 = $_POST['fav_cat_type_id7'];
    
    $prof_cat8 = $_POST['fav_cat_type_id8'];
    
    $prof_cat9 = $_POST['fav_cat_type_id9'];
    
     $prof_cat10 = $_POST['fav_cat_type_id10'];
    
    
    $arr_selected_cat_id1 = $_POST['selected_cat_id1'];
    $arr_selected_cat_id2 = $_POST['selected_cat_id2'];
    $arr_selected_cat_id3 = $_POST['selected_cat_id3'];
    $arr_selected_cat_id4 = $_POST['selected_cat_id4'];
    $arr_selected_cat_id5 = $_POST['selected_cat_id5'];
    $arr_selected_cat_id6 = $_POST['selected_cat_id6'];
    $arr_selected_cat_id7 = $_POST['selected_cat_id7'];
    $arr_selected_cat_id8 = $_POST['selected_cat_id8'];
    $arr_selected_cat_id9 = $_POST['selected_cat_id9'];
    $arr_selected_cat_id10 = $_POST['selected_cat_id10'];
    $admin_comment = $_POST['admin_comment'];
    
    $cat_fetch_show_data = array();
    
    if(isset($_POST['canv_sub_cat1_show_fetch']))
    {
        $cat_fetch_show_data['canv_sub_cat1_show_fetch']= $_POST['canv_sub_cat1_show_fetch']; // Displaying Selected Value
    }    
    
   if(isset($_POST['canv_sub_cat2_show_fetch']))
    {
        $cat_fetch_show_data['canv_sub_cat2_show_fetch']= $_POST['canv_sub_cat2_show_fetch']; 
    }

    if(isset($_POST['canv_sub_cat3_show_fetch']))
    {
        $cat_fetch_show_data['canv_sub_cat3_show_fetch']= $_POST['canv_sub_cat3_show_fetch']; 
    }
    
    if(isset($_POST['canv_sub_cat4_show_fetch']))
    {
        $cat_fetch_show_data['canv_sub_cat4_show_fetch']= $_POST['canv_sub_cat4_show_fetch']; 
    }
    
    if(isset($_POST['canv_sub_cat5_show_fetch']))
    {
        $cat_fetch_show_data['canv_sub_cat5_show_fetch']= $_POST['canv_sub_cat5_show_fetch']; 
    }
    
    if(isset($_POST['canv_sub_cat6_show_fetch']))
    {
        $cat_fetch_show_data['canv_sub_cat6_show_fetch']= $_POST['canv_sub_cat6_show_fetch']; 
    }
    
    if(isset($_POST['canv_sub_cat7_show_fetch']))
    {
        $cat_fetch_show_data['canv_sub_cat7_show_fetch']= $_POST['canv_sub_cat7_show_fetch']; 
    }
    
   if(isset($_POST['canv_sub_cat8_show_fetch']))
    {
        $cat_fetch_show_data['canv_sub_cat8_show_fetch']= $_POST['canv_sub_cat8_show_fetch']; 
    }
    
   if(isset($_POST['canv_sub_cat9_show_fetch']))
    {
        $cat_fetch_show_data['canv_sub_cat9_show_fetch']= $_POST['canv_sub_cat9_show_fetch']; 
    }
    
    if(isset($_POST['canv_sub_cat10_show_fetch']))
    {
        $cat_fetch_show_data['canv_sub_cat10_show_fetch']= $_POST['canv_sub_cat10_show_fetch']; 
    }
    
    $canv_sub_cat_link = array();
    
    $canv_sub_cat_link['canv_sub_cat1_link']= $_POST['canv_sub_cat1_link'];
    $canv_sub_cat_link['canv_sub_cat2_link']= $_POST['canv_sub_cat2_link'];
    $canv_sub_cat_link['canv_sub_cat3_link']= $_POST['canv_sub_cat3_link'];
    $canv_sub_cat_link['canv_sub_cat4_link']= $_POST['canv_sub_cat4_link'];
    $canv_sub_cat_link['canv_sub_cat5_link']= $_POST['canv_sub_cat5_link'];
    $canv_sub_cat_link['canv_sub_cat6_link']= $_POST['canv_sub_cat6_link'];
    $canv_sub_cat_link['canv_sub_cat7_link']= $_POST['canv_sub_cat7_link'];
    $canv_sub_cat_link['canv_sub_cat8_link']= $_POST['canv_sub_cat8_link'];
    $canv_sub_cat_link['canv_sub_cat9_link']= $_POST['canv_sub_cat9_link'];
    $canv_sub_cat_link['canv_sub_cat10_link']= $_POST['canv_sub_cat10_link'];
    
    
    
    
    
   
    if($page_name == '')
    {
        $error = true;
        $err_msg = 'Please select Page';
    }

    if(!$error)
    {
        
        $sub_cat1 = implode(',',$arr_selected_cat_id1);
        $sub_cat2 = implode(',',$arr_selected_cat_id2);
        $sub_cat3 = implode(',',$arr_selected_cat_id3);
        $sub_cat4 = implode(',',$arr_selected_cat_id4);
        $sub_cat5 = implode(',',$arr_selected_cat_id5);
        $sub_cat6 = implode(',',$arr_selected_cat_id6);
        $sub_cat7 = implode(',',$arr_selected_cat_id7);
        $sub_cat8 = implode(',',$arr_selected_cat_id8);
        $sub_cat9 = implode(',',$arr_selected_cat_id9);
        $sub_cat10 = implode(',',$arr_selected_cat_id10);
       
        
        if($obj->updateDataCatDropdown($admin_comment,$arr_heading,$pag_cat_status,$admin_id,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$id,$time_show,$duration_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$heading,$order_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$cat_fetch_show_data,$canv_sub_cat_link,$data_source))
        {
            $msg = "Record Updated Successfully!";
            header('location: index.php?mode=manage-data-dropdown&msg='.urlencode($msg));
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
//    $pd_id = $_GET['id'];
     $page_cat_id = $_GET['id'];
     list($admin_comment,$arr_heading,$healcareandwellbeing,$page_name,$ref_code,$profcat1,$profcat2,$profcat3,$profcat4,$profcat5,$profcat6,$profcat7,$profcat8,$profcat9,$profcat10,$pag_cat_status,$heading,$time_show,$location_show,$like_dislike_show,$set_goals_show,$scale_show,$reminder_show,$order_show,$duration_show,$comments_show,$location_category,$user_response_category,$user_what_next_category,$alerts_updates_category,$canv_sub_cat1_link,$canv_sub_cat2_link,$canv_sub_cat3_link,$canv_sub_cat4_link,$canv_sub_cat5_link,$canv_sub_cat6_link,$canv_sub_cat7_link,$canv_sub_cat8_link,$canv_sub_cat9_link,$canv_sub_cat10_link, $canv_sub_cat1_show_fetch,$canv_sub_cat2_show_fetch,$canv_sub_cat3_show_fetch,$canv_sub_cat4_show_fetch,$canv_sub_cat5_show_fetch,$canv_sub_cat6_show_fetch,$canv_sub_cat7_show_fetch,$canv_sub_cat8_show_fetch,$canv_sub_cat9_show_fetch,$canv_sub_cat10_show_fetch,$page_type) = $obj->getDataCatDropdownDetails($page_cat_id);
   // print_r($page_name);die();
        $oldvalue=0;
        if($prof_cat1!='')
        {
           $oldvalue= $oldvalue+1;
        }
        if($prof_cat2!='')
        {
           $oldvalue= $oldvalue+1;
        }
        if($prof_cat3!='')
        {
           $oldvalue= $oldvalue+1;
        }
        if($prof_cat4!='')
        {
           $oldvalue= $oldvalue+1;
        }
        if($prof_cat5!='')
        {
           $oldvalue= $oldvalue+1;
        }
        if($prof_cat6!='')
        {
           $oldvalue= $oldvalue+1;
        }
        if($prof_cat7!='')
        {
           $oldvalue= $oldvalue+1;
        }
         if($prof_cat8!='')
        {
           $oldvalue= $oldvalue+1;
        }
        if($prof_cat9!='')
        {
           $oldvalue= $oldvalue+1;
        }
        if($prof_cat10!='')
        {
           $oldvalue= $oldvalue+1;
        }
//       echo $oldvalue;
    
    $prof_cat1 = explode(',',$prof_cat1);
    $prof_cat2 = explode(',',$prof_cat2);
    $prof_cat3 = explode(',',$prof_cat3);
    $prof_cat4 = explode(',',$prof_cat4);
    $prof_cat5 = explode(',',$prof_cat5);
    $prof_cat6 = explode(',',$prof_cat6);
    $prof_cat7 = explode(',',$prof_cat7);
    $prof_cat8 = explode(',',$prof_cat8);
    $prof_cat9 = explode(',',$prof_cat9);
    $prof_cat10 = explode(',',$prof_cat10);
   
//    $arr_selected_page_id = explode(',',$page_id_str);
}	
else
{
    header('location: index.php?mode=manage-data-dropdown');
    exit(0);
}
?>
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
	<table border="0" width="97%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Data Dropdowns</td>
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
							<form action="#" method="post" name="frmedit_my_relation" id="frmedit_my_relation" enctype="multipart/form-data" >
							<input type="hidden" name="hdnpd_id" id="hdnpd_id" value="<?php echo $page_cat_id;?>" />
                                                        <input type="hidden" name="oldvalue" id="oldvalue" value="<?php echo $oldvalue;?>" />
                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow">
							<tbody>
                                     <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                    <tr>
                                            <td width="30%" align="right"><strong>Status</strong></td>
                                            <td width="5%" align="center"><strong>:</strong></td>
                                            <td width="65%" align="left">
                                                <select id="pag_cat_status" name="pag_cat_status" style="width:200px;height: 24px;">
                                                    <option value="1" <?php if($pag_cat_status == '1'){ ?> selected <?php } ?>>Active</option>
                                                    <option value="0" <?php if($pag_cat_status == '0'){ ?> selected <?php } ?>>Inactive</option>
                                                </select>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="30%" align="right" valign="top"><strong>Reference Code</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="ref_code" id="ref_code" style="width:200px;height: 24px;" value="<?php echo $ref_code;?>">
                                           
                                        </td>
                                    </tr>
                                     <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                        </tr>
                                    <tr>
                                            <td width="30%" align="right" valign="top"><strong>Admin Notes</strong></td>
                                            <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                            <td width="65%" align="left" valign="top">
                                                <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"><?php echo $admin_comment; ?></textarea>

                                            </td>
                                        </tr>
                                       
                                     <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>System Category</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type='text' name="healcareandwellbeing" id="healcareandwellbeing" style="width:200px; " value="<?php echo $healcareandwellbeing;?>" readonly/>
                                               
                                               
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Page Name</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="hidden" name="page_name" id="page_name" value="<?php echo $page_name; ?>">
                                           <?php echo $obj->getPagenamebyPage_menu_id('4',$page_name,$page_type); ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Header <input type="text" name="heading" id="heading" value="<?php echo $heading; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Data Source</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="data_source" id="data_source" style="width:200px; height: 24px;" >
                                                <option value="">Select Data Source</option>
                                               <?php echo $obj->getDatadropdownPage('6',$data_source,'');?>
                                            </select>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category1</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id" id="fav_cat_type_id" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat1);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat1_show_fetch" <?php if($canv_sub_cat1_show_fetch == 1){ echo 'checked'; } ?> value="1">Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat1_show_fetch" <?php if($canv_sub_cat1_show_fetch == 2){ echo 'checked'; } ?> value="2">Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat1_link" id="canv_sub_cat1_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat1_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat1_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat1_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat1_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                                <option value="tbl_event_master" <?php if($canv_sub_cat1_link == 'tbl_event_master'){ echo 'selected'; } ?>>tbl_event_master</option>
                                            </select>
                                            <!--<input type="text" name="canv_sub_cat1_link" id="canv_sub_cat1_link" value="<?php //echo $canv_sub_cat1_link; ?>" >-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category1</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id" align="left" valign="top">
                                            
                                            <?php  echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category2</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id2" id="fav_cat_type_id2" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore2()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat2);?>
                                            </select>
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat2_show_fetch" value="1" <?php if($canv_sub_cat2_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat2_show_fetch" value="2" <?php if($canv_sub_cat2_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;
                                            <select name="canv_sub_cat2_link" id="canv_sub_cat2_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat2_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat2_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat2_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat2_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                                <option value="tbl_event_master" <?php if($canv_sub_cat2_link == 'tbl_event_master'){ echo 'selected'; } ?>>tbl_event_master</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Sub Category2</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id2" align="left" valign="top">
                                            
                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category3</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id3" id="fav_cat_type_id3" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore3()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat3);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat3_show_fetch" value="1" <?php if($canv_sub_cat3_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat3_show_fetch" value="2" <?php if($canv_sub_cat3_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat3_link" id="canv_sub_cat3_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat3_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat3_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat3_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat3_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                                <option value="tbl_event_master" <?php if($canv_sub_cat3_link == 'tbl_event_master'){ echo 'selected'; } ?>>tbl_event_master</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Sub Category3</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id3" align="left" valign="top">
                                            
                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category4</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id4" id="fav_cat_type_id4" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore4()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat4);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat4_show_fetch" value="1" <?php if($canv_sub_cat4_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat4_show_fetch" value="2" <?php if($canv_sub_cat4_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat4_link" id="canv_sub_cat4_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat4_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat4_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat4_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat4_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category4</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id4" align="left" valign="top">
                                            
                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category5</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id5" id="fav_cat_type_id5" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore5()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat5);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat5_show_fetch" value="1" <?php if($canv_sub_cat5_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat5_show_fetch" value="2" <?php if($canv_sub_cat5_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat5_link" id="canv_sub_cat5_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat5_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat5_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat5_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat5_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category5</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id5" align="left" valign="top">
                                            
                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category6</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id6" id="fav_cat_type_id6" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore6()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat6);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat6_show_fetch" value="1" <?php if($canv_sub_cat6_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat6_show_fetch" value="2" <?php if($canv_sub_cat6_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat6_link" id="canv_sub_cat6_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat6_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat6_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat6_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat6_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category6</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id6" align="left" valign="top">
                                            
                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category7</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id7" id="fav_cat_type_id7" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore7()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat7);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat7_show_fetch" value="1" <?php if($canv_sub_cat7_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat7_show_fetch" value="2" <?php if($canv_sub_cat7_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat7_link" id="canv_sub_cat7_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat7_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat7_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat7_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat7_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category7</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id7" align="left" valign="top">
                                            
                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category8</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id8" id="fav_cat_type_id8" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore8()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat8);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat8_show_fetch" value="1" <?php if($canv_sub_cat8_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat8_show_fetch" value="2" <?php if($canv_sub_cat8_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat8_link" id="canv_sub_cat8_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat8_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat8_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat8_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat8_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category8</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id8" align="left" valign="top">
                                            
                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category9</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id9" id="fav_cat_type_id9" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore9()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat9);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat9_show_fetch" value="1" <?php if($canv_sub_cat9_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat9_show_fetch" value="2" <?php if($canv_sub_cat9_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat9_link" id="canv_sub_cat9_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat9_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat9_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat9_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat9_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category9</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id9" align="left" valign="top">
                                            
                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Profile Category10</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id10" id="fav_cat_type_id10" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore10()">
                                                <option value="">Select Prof Cat</option>
                                               <?php  echo $obj->getFavCategoryTypeOptions($profcat10);?>
                                            </select>
                                            &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat10_show_fetch" value="1" <?php if($canv_sub_cat10_show_fetch == 1){ echo 'checked'; } ?>>Show
                                             &nbsp;&nbsp;
                                            <input type="radio" name="canv_sub_cat10_show_fetch" value="2" <?php if($canv_sub_cat10_show_fetch == 2){ echo 'checked'; } ?>>Fetch
                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat10_link" id="canv_sub_cat10_link">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($canv_sub_cat10_link == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($canv_sub_cat10_link == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($canv_sub_cat10_link == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($canv_sub_cat10_link == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
                                        <td align="right" valign="top"><strong>Sub Category10</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id10" align="left" valign="top">
                                            
                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                     <tr>                                                                    
                                        <td align="right" valign="top"><strong>Time (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="time_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php if($time_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php if($time_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="time_heading" id="time_heading" value="<?php echo $arr_heading['time_heading'] ?>" >
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Duration (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="duration_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php if($duration_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php if($duration_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="duration_heading" id="duration_heading"  value="<?php echo $arr_heading['duration_heading'] ?>">
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Location (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="location_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php if($location_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php if($location_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                             &nbsp;&nbsp;&nbsp;Heading <input type="text" name="location_heading" id="location_heading" value="<?php echo $arr_heading['location_heading'] ?>">
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Location Category </strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                                <?php echo $obj->getAllFavCatChkeckbox('location_category',$location_category,'200','150');?>                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>User Response (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="like_dislike_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php if($like_dislike_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php if($like_dislike_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="like_dislike_heading" id="like_dislike_heading" value="<?php echo $arr_heading['like_dislike_heading'] ?>">
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>User Response Category </strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                                <?php echo $obj->getAllFavCatChkeckbox('user_response_category',$user_response_category,'200','150');?>                                           
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>User What Next (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="set_goals_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php if($set_goals_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php if($set_goals_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="set_goals_heading" id="set_goals_heading" value="<?php echo $arr_heading['set_goals_heading'] ?>">
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>User What Next Category </strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                                <?php echo $obj->getAllFavCatChkeckbox('user_what_next_category',$user_what_next_category,'200','150');?>                                           
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Scale (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="scale_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php if($scale_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php if($scale_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="scale_heading" id="scale_heading" value="<?php echo $arr_heading['scale_heading'] ?>">
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Alerts/Updates (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="reminder_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php if($reminder_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php if($reminder_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="reminder_heading" id="reminder_heading" value="<?php echo $arr_heading['reminder_heading'] ?>">
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Alerts/Updates Category </strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                                <?php echo $obj->getAllFavCatChkeckbox('alerts_updates_category',$alerts_updates_category,'200','150');?>                                           
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Comments (Show)</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="comments_show" style="width:200px; height: 24px;">
                                                <option value="">Select</option>
                                                <option value="1" <?php if($comments_show == 1){ echo 'selected'; } ?>>Yes</option>
                                                <option value="0" <?php if($comments_show == 0){ echo 'selected'; } ?>>NO</option>
                                            </select>
                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="comments_heading" id="comments_heading" value="<?php echo $arr_heading['comments_heading'] ?>">
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <tr>                                                                    
                                        <td align="right" valign="top"><strong>Order</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td  align="left" valign="top">
                                            <select name="order_show" style="width:200px; height: 24px;">
                                                <?php for($i=1;$i<=50;$i++) { ?>
                                                <option value="<?php echo $i ?>"  <?php if($order_show == $i){ echo 'selected'; } ?>><?php echo $i ?></option>
                                                <?php } ?>
                                            </select>
<!--                                            <select name="order_show" style="width:200px; height: 24px;">
                                                <option value="1" <?php // if($order_show == 1){ echo 'selected'; } ?>>1</option>
                                                <option value="2" <?php //if($order_show == 2){ echo 'selected'; } ?>>2</option>
                                                <option value="3" <?php //if($order_show == 3){ echo 'selected'; } ?>>3</option>
                                                <option value="4" <?php //if($order_show == 4){ echo 'selected'; } ?>>4</option>
                                                <option value="5" <?php //if($order_show == 5){ echo 'selected'; } ?>>5</option>
                                                <option value="6" <?php //if($order_show == 6){ echo 'selected'; } ?>>6</option>
                                            </select>-->
                                        </td>
                                    </tr>
                                     <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
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
        <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			mode : "exact",
			theme : "advanced",
			elements : "admin_comment",
			plugins : "style,advimage,advlink,emotions",
			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",
			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",
		});
    </script>
        <script>
            
    $( document ).ready(function()
    {
        var parent_cat_id1 = $("#fav_cat_type_id").val();
        var parent_cat_id2 = $("#fav_cat_type_id2").val();
        var parent_cat_id3 = $("#fav_cat_type_id3").val();
        var parent_cat_id4 = $("#fav_cat_type_id4").val();
        var parent_cat_id5 = $("#fav_cat_type_id5").val();
        var parent_cat_id6 = $("#fav_cat_type_id6").val();
        var parent_cat_id7 = $("#fav_cat_type_id7").val();
        var parent_cat_id8 = $("#fav_cat_type_id8").val();
        var parent_cat_id9 = $("#fav_cat_type_id9").val();
        var parent_cat_id10 =$("#fav_cat_type_id10").val();
        
        var id = $("#hdnpd_id").val();
        
        
        if(parent_cat_id1!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id1+'&id='+id+'&columns=sub_cat1';
	    $.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id").html(result);
		}
	});
        }
        
        if(parent_cat_id2!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id2+'&id='+id+'&columns=sub_cat2';
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id2").html(result);
		}
	});
        }
        
        if(parent_cat_id3!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id3+'&id='+id+'&columns=sub_cat3';
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id3").html(result);
		}
	});
        }
        
        if(parent_cat_id4!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id4+'&id='+id+'&columns=sub_cat4';
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id4").html(result);
		}
	});
        }
        
        if(parent_cat_id5!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id5+'&id='+id+'&columns=sub_cat5';
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id5").html(result);
		}
	});
        }
        
        if(parent_cat_id6!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id6+'&id='+id+'&columns=sub_cat6';
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id6").html(result);
		}
	});
        }
        
        if(parent_cat_id7!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id7+'&id='+id+'&columns=sub_cat7';
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id7").html(result);
		}
	});
        }
        
        if(parent_cat_id8!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id8+'&id='+id+'&columns=sub_cat8';
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id8").html(result);
		}
	});
        }
        
        if(parent_cat_id9!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id9+'&id='+id+'&columns=sub_cat9';
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id9").html(result);
		}
	});
        }
        
        if(parent_cat_id10!='')
        {
            var dataString = 'action=getdatasubcatoption&parent_cat_id='+parent_cat_id10+'&id='+id+'&columns=sub_cat10';
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id10").html(result);
		}
	});
        }
        
    });        
    function getMainCategoryOptionAddMore()
{
        
	var parent_cat_id = $("#fav_cat_type_id").val();
        var id='';

	var dataString = 'action=getsubcatoption&parent_cat_id='+parent_cat_id+'&id='+id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id").html(result);
		}
	});
}


 function getMainCategoryOptionAddMore2()
{
        
	var parent_cat_id = $("#fav_cat_type_id2").val();
        var id='';
	var dataString = 'action=getsubcat2option&parent_cat_id='+parent_cat_id+'&id='+id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id2").html(result);
		}
	});
}

 function getMainCategoryOptionAddMore3()
{
        
	var parent_cat_id = $("#fav_cat_type_id3").val();
        var id='';
	var dataString = 'action=getsubcat3option&parent_cat_id='+parent_cat_id+'&id='+id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id3").html(result);
		}
	});
}
 function getMainCategoryOptionAddMore4()
{
        
	var parent_cat_id = $("#fav_cat_type_id4").val();
        var id='';
	var dataString = 'action=getsubcat4option&parent_cat_id='+parent_cat_id+'&id='+id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id4").html(result);
		}
	});
}

 function getMainCategoryOptionAddMore5()
{
        
	var parent_cat_id = $("#fav_cat_type_id5").val();
        var id='';
	var dataString = 'action=getsubcat5option&parent_cat_id='+parent_cat_id+'&id='+id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id5").html(result);
		}
	});
}
 function getMainCategoryOptionAddMore6()
{
        
	var parent_cat_id = $("#fav_cat_type_id6").val();
        var id='';
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
	var dataString = 'action=getsubcat6option&parent_cat_id='+parent_cat_id+'&id='+id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id6").html(result);
		}
	});
}

 function getMainCategoryOptionAddMore7()
{
        
	var parent_cat_id = $("#fav_cat_type_id7").val();
        var id='';
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
	var dataString = 'action=getsubcat7option&parent_cat_id='+parent_cat_id+'&id='+id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id7").html(result);
		}
	});
}
 function getMainCategoryOptionAddMore8()
{
        
	var parent_cat_id = $("#fav_cat_type_id8").val();
        var id='';
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
	var dataString = 'action=getsubcat8option&parent_cat_id='+parent_cat_id+'&id='+id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id8").html(result);
		}
	});
}

 function getMainCategoryOptionAddMore9()
{
        
	var parent_cat_id = $("#fav_cat_type_id9").val();
        var id='';
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
	var dataString = 'action=getsubcat9option&parent_cat_id='+parent_cat_id+'&id='+id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id9").html(result);
		}
	});
}
 function getMainCategoryOptionAddMore10()
{
        
	var parent_cat_id = $("#fav_cat_type_id10").val();
        var id='';
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
	var dataString = 'action=getsubcat10option&parent_cat_id='+parent_cat_id+'&id='+id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id10").html(result);
		}
	});
}
            
            </script>
</div>
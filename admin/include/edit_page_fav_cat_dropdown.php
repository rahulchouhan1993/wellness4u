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
    $id = strip_tags(trim($_POST['hdnpd_id']));
    $healcareandwellbeing = $_POST['healcareandwellbeing'];
    
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
        $admin_comment = $_POST['admin_comment'];
        
        if($obj->updatePageFavCatDropdown($admin_comment,$pag_cat_status,$admin_id,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$id))
        {
            $msg = "Record Updated Successfully!";
            header('location: index.php?mode=manage_page_fav_cat_dropdowns&msg='.urlencode($msg));
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
    list($admin_comment,$healcareandwellbeing,$page_name,$ref_code,$profcat1,$profcat2,$profcat3,$profcat4,$profcat5,$profcat6,$profcat7,$profcat8,$profcat9,$profcat10,$pag_cat_status,$page_type) = $obj->getPageFavCatDropdownDetailsVivek($page_cat_id);
//    print_r($healcareandwellbeing);die();
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
    header('location: index.php?mode=manage_page_cat_dropdowns');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Page Fav Category Dropdown</td>
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
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                            <td width="30%" align="right" valign="top"><strong>Admin Notes</strong></td>
                                            <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                            <td width="65%" align="left" valign="top">
                                                <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"><?php echo $admin_comment; ?></textarea>

                                            </td>
                                        </tr>
                                        
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
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
<!--                                            <select name="page_name" id="page_name" style="width:200px; height: 24px;">
                                                <option value="">Select Page Name</option>
                                                <?php //echo $obj->getPageCatDropdownModulesOptions($page_name);?>
                                                <?php //echo $obj->getDatadropdownPage('11',$page_name);?>
                                            </select>-->
                                            <input type="hidden" name="page_name" id="page_name" value="<?php echo $page_name; ?>">
                                           <?php echo $obj->getPagenamebyPage_menu_id('11',$page_name,$page_type); ?>
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Sub Category1</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td id="fav_cat_id" align="left" valign="top">
                                            
                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
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
        var parent_cat_id10 = $("#fav_cat_type_id10").val();
        
        var id = $("#hdnpd_id").val();
        
        
        if(parent_cat_id1!='')
        {
            var dataString = 'action=getsubcatoption&parent_cat_id='+parent_cat_id1+'&id='+id;
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
            var dataString = 'action=getsubcat2option&parent_cat_id='+parent_cat_id2+'&id='+id;
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
            var dataString = 'action=getsubcat3option&parent_cat_id='+parent_cat_id3+'&id='+id;
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
            var dataString = 'action=getsubcat4option&parent_cat_id='+parent_cat_id4+'&id='+id;
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
            var dataString = 'action=getsubcat5option&parent_cat_id='+parent_cat_id5+'&id='+id;
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
            var dataString = 'action=getsubcat6option&parent_cat_id='+parent_cat_id6+'&id='+id;
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
            var dataString = 'action=getsubcat7option&parent_cat_id='+parent_cat_id7+'&id='+id;
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
            var dataString = 'action=getsubcat8option&parent_cat_id='+parent_cat_id8+'&id='+id;
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
            var dataString = 'action=getsubcat9option&parent_cat_id='+parent_cat_id9+'&id='+id;
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
            var dataString = 'action=getsubcat10option&parent_cat_id='+parent_cat_id10+'&id='+id;
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
</div>
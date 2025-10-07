<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');  
require_once('classes/class.places.php');

$obj = new Contents();
$obj2 = new Places();

require_once('classes/class.scrollingwindows.php');
$obj1 = new Scrolling_Windows();

$add_action_id = '314';

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

//if($action == 'getsubcategoryoption')
//{
//    
//        
//	$profid = trim($_REQUEST['profid']);
//        $arr_selected_cat_id1 =array();
//	$data = $obj->getAllSubCategoryChkeckbox($arr_selected_cat_id1,$profid,'0','300','200');
//     print_r($data) ;
//
//}

$error = false;
$err_msg = "";
$arr_selected_cat_id1 = array();
$arr_selected_cat_id2 = array();
$arr_selected_cat_id3 = array();
$arr_selected_cat_id4 = array();
$arr_selected_cat_id5 = array();
$arr_selected_cat_id6 = array();
$arr_selected_cat_id7 = array();
$arr_selected_cat_id8 = array();
$arr_selected_cat_id9 = array();
$arr_selected_cat_id10 = array();

 
    
if(isset($_POST['btnSubmit']))
{
   
   $fav_cat_type_id_0 = $_POST['fav_cat_type_id_0'];
   if($_POST['healcareandwellbeing']=='')
   {
       $healcareandwellbeing = $obj->getAllHealcareAndWellbeingPageDropdownData($fav_cat_type_id_0);
       
   }
   else
   {
       $healcareandwellbeing = $_POST['healcareandwellbeing'];
   }
   
    $page_name = strip_tags(trim($_POST['page_name']));
    
    $page_type = strip_tags(trim($_POST['page_type']));
    
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
   
    
    foreach ($_POST['selected_cat_id1'] as $key => $value) 
    {
        array_push($arr_selected_cat_id1,$value);
    }
    
     
    foreach ($_POST['selected_cat_id2'] as $key => $value) 
    {
        array_push($arr_selected_cat_id2,$value);
    }
   
     foreach ($_POST['selected_cat_id3'] as $key => $value) 
    {
        array_push($arr_selected_cat_id3,$value);
    }
    foreach ($_POST['selected_cat_id4'] as $key => $value) 
    {
        array_push($arr_selected_cat_id4,$value);
    }
     foreach ($_POST['selected_cat_id5'] as $key => $value) 
    {
        array_push($arr_selected_cat_id5,$value);
    }
    foreach ($_POST['selected_cat_id6'] as $key => $value) 
    {
        array_push($arr_selected_cat_id6,$value);
    }
     foreach ($_POST['selected_cat_id7'] as $key => $value) 
    {
        array_push($arr_selected_cat_id7,$value);
    }
    foreach ($_POST['selected_cat_id8'] as $key => $value) 
    {
        array_push($arr_selected_cat_id8,$value);
    }
    foreach ($_POST['selected_cat_id9'] as $key => $value) 
    {
        array_push($arr_selected_cat_id9,$value);
    }
    foreach ($_POST['selected_cat_id10'] as $key => $value) 
    {
        array_push($arr_selected_cat_id10,$value);
    }
    
   
    if($page_name == '')
    {
        $error = true;
        $err_msg = 'Please select Page';
    }
//    elseif($obj->chkPageDropdownModuleExists($page_name))
//    {
//        $error = true;
//        $err_msg .= '<br>This function already added';
//    }
    
   
    if(count($arr_selected_cat_id1) == 0)
    {
       
        $error = true;
        $err_msg .= '<br>Please select Profile Category1';
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
        if($obj->addFavCatDropdown($admin_comment,$fav_cat_type_id_0,$healcareandwellbeing,$ref_code,$page_name,$sub_cat1,$sub_cat2,$sub_cat3,$sub_cat4,$sub_cat5,$sub_cat6,$sub_cat7,$sub_cat8,$sub_cat9,$sub_cat10,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$admin_id,$page_type))
        {
            $msg = "Record Added Successfully!";
            header('location: index.php?mode=manage_page_fav_cat_dropdowns&msg='.urlencode($msg));
        }
        else
        {
            $error = true;
            $err_msg = "Currently there is some problem.Please try again later.";
        }
    }
}
else
{
    $pdm_id = '';
    
}	
?>
<div id="central_part_contents">
    <div id="notification_contents">
    <?php
    if($error)
    { ?>
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
    } ?>
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Page Fav Cat Dropdown</td>
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
                            <form action="#" method="post" name="frmadd_my_relation" id="frmadd_my_relation" enctype="multipart/form-data" >
                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                <tbody>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                     <tr>
                                        <td width="30%" align="right" valign="top"><strong>Reference Code</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="ref_code" id="ref_code" style="width:200px;height: 24px;">
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                        </tr>
                                    <tr>
                                            <td width="30%" align="right" valign="top"><strong>Admin Notes</strong></td>
                                            <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                            <td width="65%" align="left" valign="top">
                                                <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"></textarea>

                                            </td>
                                        </tr>
                                        
                                     <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>System Category</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id_0" id="fav_cat_type_id_0" required="" style="width:200px; height: 24px;" onchange="getMainCategoryOption('0','healcareandwellbeing')">                                                
                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>System Sub Category</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top" id="fav_cat_id_0">
<!--                                            <select name="healcareandwellbeing[]" id="healcareandwellbeing" style="width:200px; height: 90px;" multiple>
                                               
                                                 <?php //echo $obj1->getFavCategoryRamakant('42',$fav_cat_id)?>
                                            </select>-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Page Type</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="page_type" id="page_type" style="width:200px; height: 24px;" required="" onchange="getDatadropdownPage('11')">
                                                <option value="">Select Page Type</option>
                                                <option value="Menu">Menu</option>
                                                <option value="Page">Page</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Page Name</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="page_name" id="page_name" style="width:200px; height: 24px;" required="">
                                                <option value="">Select Page Name</option>
                                                <?php //echo $obj->getPageCatDropdownModulesOptions($page_name);?>
                                                <?php echo $obj->getDatadropdownPage('11','','');?>
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
                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr >                                                                    
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
                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
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
                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
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
                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
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
                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
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
                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
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
                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
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
                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
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
                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
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
                                               <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);?>
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
   
function getMainCategoryOption(serial,checkboxname)
{
        
	var parent_cat_id = $("#fav_cat_type_id_0").val();
        var id='0';
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
	var dataString = 'action=getsubcatoptionCommon&parent_cat_id='+parent_cat_id+'&id='+id+'&serial='+serial+'&checkboxname='+checkboxname;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#fav_cat_id_0").html(result);
		}
	});
}
        
        
    function getMainCategoryOptionAddMore()
{
        
	var parent_cat_id = $("#fav_cat_type_id").val();
        var id='';
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
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
function getDatadropdownPage(idval)
{
        var pdm_id = idval;
        var page_type = $("#page_type").val();
//        alert(parent_cat_id);
        //var sub_cat = $("#fav_cat_id_"+idval).val();
        //alert(parent_cat_id);
	var dataString = 'action=getDatadropdownPage&pdm_id='+pdm_id+'&page_type='+page_type;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
			//alert(result);
                        //alert(sub_cat);
			$("#page_name").html(result);
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
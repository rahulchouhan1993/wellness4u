<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');  
require_once('classes/class.places.php');


$obj = new Contents();
$obj2 = new Places();

require_once('classes/class.scrollingwindows.php');
$obj1 = new Scrolling_Windows();

$add_action_id = '294';

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

 foreach ($_POST['selected_cat_id1'] as $key => $value) 
    {
        array_push($arr_selected_cat_id1,$value);
    }
    
if(isset($_POST['btnSubmit']))
{
 
 $fav_cat_type_id = $_POST['fav_cat_type_id'];   
    
if($_POST['healcareandwellbeing']=='')
   {
       //$healcareandwellbeing = $obj->getAllHealcareAndWellbeingPageDropdownData('42');
        $healcareandwellbeing = $obj->getAllHealcareAndWellbeingPageDropdownData($fav_cat_type_id);
      
//         echo '<pre>';
//        print_r($healcareandwellbeing);
//        echo '</pre>'; 
   }
   else
   {
       $healcareandwellbeing = $_POST['healcareandwellbeing'];
   }
   
//    echo '<pre>';
//    print_r($healcareandwellbeing);
//    echo '</pre>'; 
//    die();
   
    $page_name = strip_tags(trim($_POST['page_name']));
    $page_type = strip_tags(trim($_POST['page_type']));
    $ref_code = strip_tags(trim($_POST['ref_code']));
    
    $header1 = strip_tags(trim($_POST['header1']));
     
    $header2 = strip_tags(trim($_POST['header2']));
    
    $header3 = strip_tags(trim($_POST['header3']));
    
    $header4 = strip_tags(trim($_POST['header4']));
     
    $header5 = strip_tags(trim($_POST['header5']));
    
    $header6 = strip_tags(trim($_POST['header6']));
    
    $header7 = strip_tags(trim($_POST['header7']));
     
    $header8 = strip_tags(trim($_POST['header8']));
    
    $header9 = strip_tags(trim($_POST['header9']));
    
     $header10 = strip_tags(trim($_POST['header10']));
   
    
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
        $prof_cat1 = implode(',',$arr_selected_cat_id1);
        $prof_cat2 = implode(',',$arr_selected_cat_id2);
        $prof_cat3 = implode(',',$arr_selected_cat_id3);
        $prof_cat4 = implode(',',$arr_selected_cat_id4);
        $prof_cat5 = implode(',',$arr_selected_cat_id5);
        $prof_cat6 = implode(',',$arr_selected_cat_id6);
        $prof_cat7 = implode(',',$arr_selected_cat_id7);
        $prof_cat8 = implode(',',$arr_selected_cat_id8);
        $prof_cat9 = implode(',',$arr_selected_cat_id9);
        $prof_cat10 = implode(',',$arr_selected_cat_id10);
        
        $admin_comment = $_POST['admin_comment'];
        
        if($obj->addPageCatDropdown($admin_comment,$header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$healcareandwellbeing,$ref_code,$page_name,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$admin_id,$fav_cat_type_id,$page_type))
        {
            $msg = "Record Added Successfully!";
            header('location: index.php?mode=manage_page_cat_dropdowns&msg='.urlencode($msg));
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Page Cat Dropdown</td>
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
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>System Category</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="fav_cat_type_id" id="fav_cat_type_id" required="" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore('0','healcareandwellbeing')">                                                
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
                                       
                                            <td id="fav_cat_id" align="left" valign="top">
                                            
                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
<!--                                            <select name="healcareandwellbeing[]" id="healcareandwellbeing" style="width:200px; height: 90px;" multiple>
                                               
                                                 <?php //echo $obj1->getFavCategoryRamakant('42',$fav_cat_id)?>
                                            </select>-->
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Page Type</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <select name="page_type" id="page_type" style="width:200px; height: 24px;" required="" onchange="getDatadropdownPage('9')">
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
                                                <?php echo $obj->getDatadropdownPage('9','','');?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                   
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Profile Category1</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllCategoryChkeckbox($arr_selected_cat_id1,'0','300','200');?>
                                        </td>
                                         <td width="30%" align="right" valign="top"><strong>Header1</strong></td>
                                        <td width="25%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="header1" id="header1" value="<?php echo $header1;?>" style="width:200px; height: 24px;"/>
                                               
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Profile Category2</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');?>
                                        </td>
                                        <td width="30%" align="right" valign="top"><strong>Header2</strong></td>
                                        <td width="25%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="header2" id="header2" value="<?php echo $header2;?>" style="width:200px; height: 24px;"/>
                                               
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                     <tr>                                                                    
                                        <td align="right" valign="top"><strong>Profile Category3</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllCategory3Chkeckbox($arr_selected_cat_id3,'0','300','200');?>
                                        </td>
                                        <td width="30%" align="right" valign="top"><strong>Header3</strong></td>
                                        <td width="25%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="header3" id="header3" value="<?php echo $header3;?>" style="width:200px; height: 24px;"/>
                                               
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                     <tr>                                                                    
                                        <td align="right" valign="top"><strong>Profile Category4</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllCategory4Chkeckbox($arr_selected_cat_id4,'0','300','200');?>
                                        </td>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Header4</strong></td>
                                        <td width="25%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="header4" id="header4" value="<?php echo $header4;?>" style="width:200px; height: 24px;"/>
                                               
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                     <tr>                                                                    
                                        <td align="right" valign="top"><strong>Profile Category5</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllCategory5Chkeckbox($arr_selected_cat_id5,'0','300','200');?>
                                        </td>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Header5</strong></td>
                                        <td width="25%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="header5" id="header5" value="<?php echo $header5;?>" style="width:200px; height: 24px;"/>
                                               
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                     <tr>                                                                    
                                        <td align="right" valign="top"><strong>Profile Category6</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllCategory6Chkeckbox($arr_selected_cat_id6,'0','300','200');?>
                                        </td>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Header6</strong></td>
                                        <td width="25%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="header6" id="header6" value="<?php echo $header6;?>" style="width:200px; height: 24px;"/>
                                               
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                     <tr>                                                                    
                                        <td align="right" valign="top"><strong>Profile Category7</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllCategory7Chkeckbox($arr_selected_cat_id7,'0','300','200');?>
                                        </td>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Header7</strong></td>
                                        <td width="25%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="header7" id="header7" value="<?php echo $header7;?>" style="width:200px; height: 24px;"/>
                                               
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                     <tr>                                                                    
                                        <td align="right" valign="top"><strong>Profile Category8</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllCategory8Chkeckbox($arr_selected_cat_id8,'0','300','200');?>
                                        </td>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Header8</strong></td>
                                        <td width="25%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="header8" id="header8" value="<?php echo $header8;?>" style="width:200px; height: 24px;"/>
                                               
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                     <tr>                                                                    
                                        <td align="right" valign="top"><strong>Profile Category9</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllCategory9Chkeckbox($arr_selected_cat_id9,'0','300','200');?>
                                        </td>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Header9</strong></td>
                                        <td width="25%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="header9" id="header9" value="<?php echo $header9;?>" style="width:200px; height: 24px;"/>
                                               
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                     <tr>                                                                    
                                        <td align="right" valign="top"><strong>Profile Category10</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllCategory10Chkeckbox($arr_selected_cat_id10,'0','300','200');?>
                                        </td>
                                        
                                        <td width="30%" align="right" valign="top"><strong>Header10</strong></td>
                                        <td width="25%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="header10" id="header10" value="<?php echo $header10;?>" style="width:200px; height: 24px;"/>
                                               
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
<script>
    function getMainCategoryOptionAddMore(serial,checkboxname)
{
        
	var parent_cat_id = $("#fav_cat_type_id").val();
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
			$("#fav_cat_id").html(result);
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
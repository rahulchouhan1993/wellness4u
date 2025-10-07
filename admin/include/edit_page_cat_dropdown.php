<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');  
require_once('classes/class.places.php');

require_once('classes/class.dailymeals.php');
$obj1 = new Daily_Meals();
$obj = new Contents();
$obj2 = new Places();

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
     
     
    $id = strip_tags(trim($_POST['hdnpd_id']));
    $oldvalue = $_POST['oldvalue'];
    
    $page_name = strip_tags(trim($_POST['page_name']));
    
    $ref_code = strip_tags(trim($_POST['ref_code']));
   
    $pag_cat_status = strip_tags(trim($_POST['pag_cat_status']));
   
    
    foreach ($_POST['selected_cat_id1'] as $key => $value) 
    {
        array_push($prof_cat1,$value);
    }

    foreach ($_POST['selected_cat_id2'] as $key => $value) 
    {
        array_push($prof_cat2,$value);
    }
     foreach ($_POST['selected_cat_id3'] as $key => $value) 
    {
        array_push($prof_cat3,$value);
    }
    foreach ($_POST['selected_cat_id4'] as $key => $value) 
    {
        array_push($prof_cat4,$value);
    }
     foreach ($_POST['selected_cat_id5'] as $key => $value) 
    {
        array_push($prof_cat5,$value);
    }
    foreach ($_POST['selected_cat_id6'] as $key => $value) 
    {
        array_push($prof_cat6,$value);
    }
     foreach ($_POST['selected_cat_id7'] as $key => $value) 
    {
        array_push($prof_cat7,$value);
    }
    foreach ($_POST['selected_cat_id8'] as $key => $value) 
    {
        array_push($prof_cat8,$value);
    }
    foreach ($_POST['selected_cat_id9'] as $key => $value) 
    {
        array_push($prof_cat9,$value);
    }
    foreach ($_POST['selected_cat_id10'] as $key => $value) 
    {
        array_push($prof_cat10,$value);
    }
   
    if($page_name == '')
    {
        $error = true;
        $err_msg = 'Please select Page';
    }

    if(!$error)
    {
        $prof_cat1 = implode(',',$prof_cat1);
        $prof_cat2 = implode(',',$prof_cat2);
        $prof_cat3 = implode(',',$prof_cat3);
        $prof_cat4 = implode(',',$prof_cat4);
        $prof_cat5 = implode(',',$prof_cat5);
        $prof_cat6 = implode(',',$prof_cat6);
        $prof_cat7 = implode(',',$prof_cat7);
        $prof_cat8 = implode(',',$prof_cat8);
        $prof_cat9 = implode(',',$prof_cat9);
        $prof_cat10 = implode(',',$prof_cat10);
        
        
        $value=0;
        if($prof_cat1!='')
        {
           $value= $value+1;
        }
        if($prof_cat2!='')
        {
           $value= $value+1;
        }
        if($prof_cat3!='')
        {
           $value= $value+1;
        }
        if($prof_cat4!='')
        {
           $value= $value+1;
        }
        if($prof_cat5!='')
        {
           $value= $value+1;
        }
        if($prof_cat6!='')
        {
           $value= $value+1;
        }
        if($prof_cat7!='')
        {
           $value= $value+1;
        }
         if($prof_cat8!='')
        {
           $value= $value+1;
        }
        if($prof_cat9!='')
        {
           $value= $value+1;
        }
        if($prof_cat10!='')
        {
           $value= $value+1;
        }
        $new_value = $value;
        
        if($new_value>$oldvalue)
        {
        $toal_value_count=$new_value-$oldvalue;
        $scale_prof_cat_id_data=$obj1->addScaleProfCatData();
        
        }
        $admin_comment = $_POST['admin_comment'];
        
        if($obj->updatePageCatDropdown($admin_comment,$header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$pag_cat_status,$admin_id,$ref_code,$page_name,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$id))
        {
            $msg = "Record Updated Successfully!";
            header('location: index.php?mode=manage_page_cat_dropdowns&msg='.urlencode($msg));
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
    list($admin_comment,$header1,$header2,$header3,$header4,$header5,$header6,$header7,$header8,$header9,$header10,$healcareandwellbeing,$page_name,$ref_code,$prof_cat1,$prof_cat2,$prof_cat3,$prof_cat4,$prof_cat5,$prof_cat6,$prof_cat7,$prof_cat8,$prof_cat9,$prof_cat10,$pag_cat_status,$page_type) = $obj->getPageCatDropdownDetails($page_cat_id);
    
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
        $oldvalue;
    
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Page Category Dropdown</td>
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
                                            <input type="text" name="healcareandwellbeing" id="healcareandwellbeing" value="<?php echo $healcareandwellbeing;?>" style="width:200px; height: 24px;" readonly/>
                                               
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
                                                <?php //echo $obj->getDatadropdownPage('9',$page_name,'');?>
                                            </select>-->
                                            <input type="hidden" name="page_name" id="page_name" value="<?php echo $page_name; ?>">
                                           <?php echo $obj->getPagenamebyPage_menu_id('9',$page_name,$page_type); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Profile Category1</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getAllCategoryChkeckbox($prof_cat1,'0','300','200');?>
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
                                            <?php echo $obj->getAllCategory2Chkeckbox($prof_cat2,'0','300','200');?>
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
                                            <?php echo $obj->getAllCategory3Chkeckbox($prof_cat3,'0','300','200');?>
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
                                            <?php echo $obj->getAllCategory4Chkeckbox($prof_cat4,'0','300','200');?>
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
                                            <?php echo $obj->getAllCategory5Chkeckbox($prof_cat5,'0','300','200');?>
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
                                            <?php echo $obj->getAllCategory6Chkeckbox($prof_cat6,'0','300','200');?>
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
                                            <?php echo $obj->getAllCategory7Chkeckbox($prof_cat7,'0','300','200');?>
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
                                            <?php echo $obj->getAllCategory8Chkeckbox($prof_cat8,'0','300','200');?>
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
                                            <?php echo $obj->getAllCategory9Chkeckbox($prof_cat9,'0','300','200');?>
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
                                            <?php echo $obj->getAllCategory10Chkeckbox($prof_cat10,'0','300','200');?>
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
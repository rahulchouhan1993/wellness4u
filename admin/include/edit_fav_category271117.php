<?php
require_once('config/class.mysql.php');
require_once('classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();

$edit_action_id = '159';

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
$arr_fav_cat_type_id = array();
$arr_fav_cat_id = array();
if(isset($_POST['btnSubmit']))
{
    $page =$_POST['page'];
    
    $fav_cat_id = $_POST['hdnfav_cat_id'];
    
    $id =$_POST['hdnfav_id'];
    
    $fav_cat_type_id = strip_tags(trim($_POST['fav_cat_type_id']));
    
    $fav_cat_id_parent = $_POST['fav_cat_id'];
    $fav_cat_id_parent_name = $obj->getFavCategoryNameRamakant($fav_cat_id_parent);
    
    $fav_cat = strip_tags(trim($_POST['fav_cat']));
    
    $fav_cat_keyword_data =$_POST['fav_cat_keyword_data'];
    
    $all_keyword_data = $fav_cat_id_parent_name.','.$fav_cat.''.$fav_cat_keyword_data;
    $all_keyword_data_explode=explode(',',$all_keyword_data);
    
    $sol_item_id = $_POST['sol_item_id'];  
    
    $fav_cat_status = strip_tags(trim($_POST['fav_cat_status']));
    $cat_status = strip_tags(trim($_POST['status']));
    $fav_code = strip_tags(trim($_POST['fav_code']));
    $uom = $_POST['uom'];  
    $comment = $_POST['comment'];   
    $show_hide = strip_tags(trim($_POST['show_hide']));   
    if($fav_cat == '')
    {
        $error = true;
        $err_msg = 'Please enter category';
    }
    elseif($obj->chkIfFavCategoryAlreadyExists_Edit($fav_cat,$fav_cat_id,$str_fav_cat_type_id))
    {
        $error = true;
        $err_msg = 'Category is already exist';
    }

    if(!$error)
    {
        if($obj->updatefavCategory($all_keyword_data_explode,$sol_item_id,$fav_code,$uom,$comment,$id,$fav_cat_id,$fav_cat_id_parent,$fav_cat,$fav_cat_type_id,$cat_status,$fav_cat_status,$show_hide))
        {
            $msg = "Record Updated Successfully!";
            header('location: index.php?page='.$page.'&mode=fav_categories&msg='.urlencode($msg));
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
    $fav_cat_id = $_GET['id'];
    //list($fav_cat,$fav_cat_type_id,$fav_cat_status) = $obj->getFavCategoryDetails($fav_cat_id);
    
    list($sol_item_id,$fav_code,$fav_cat,$fav_cat_type_id,$cat_status,$fav_parent_cat,$show_hide,$favcat_id,$fav_cat_status,$comment,$uom) = $obj->getFavCategoryDetailsRamakant($fav_cat_id);
//   print_r($sol_item_id);die();
//    echo $uom;
//    die();
    
    

    $favcat_id = $obj->getBmsIdFromSymtumsCustomCategoryTableViveks($fav_cat_id);
    $FavCategory = $obj->getSymtumsCustomCategoryAllDataViveks($favcat_id,$_GET['id']);
     foreach($FavCategory as $rec)
     {
       $fav_cat_id_data[]=$rec['fav_cat_type_id'];
       $sub_cat_id_data[]=$rec['fav_parent_cat'];
     }
   
     $fav_cat_id_data_implode=implode('\',\'',$fav_cat_id_data);
     $sub_cat_id_data_implode=implode('\',\'',$sub_cat_id_data);
     $fav_cat_name=$obj->getSubCatNameByProfileCatIdFromFavCatTableVivek($fav_cat_id_data_implode,$sub_cat_id_data_implode);
     $fav_cat_name_implode=implode(',',$fav_cat_name);
     			
    if($fav_cat == '')
    {
        header('location: index.php?mode=fav_categories');	
    }	
}	
else
{
    header('location: index.php?mode=fav_categories');
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Category</td>
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
							<input type="hidden" name="hdnfav_cat_id" id="hdnfav_cat_id" value="<?php echo $favcat_id;?>" />
                                                        <input type="hidden" name="hdnfav_id" id="hdnfav_cat_id" value="<?php echo $fav_cat_id;?>" />
                                                        <input type="hidden" name="sol_item_id" id="sol_item_id" value="<?php echo $sol_item_id;?>">
				                        <input type="hidden" name="fav_cat_keyword_data" id="fav_cat_keyword_data" value="<?php echo $fav_cat_name_implode;?>">
	                                                <input type="hidden" name="page" id="page" value="<?php echo $_GET['page'];?>" />

                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
                                                                <tr>
                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>
                                                                </tr>
                                                                 <tr>
                                                                    <td colspan="10" height="30" align="left" valign="middle">
                                                                      <table>
                                                                          
                                                                          
                                                                            <tr>
                                                                                <td width="70%" align="left" valign="top"><strong>Fav Code:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>
                                                                                <td width="20%" align="center" valign="top">
                                                                                <input name="fav_code" type="text" id="fav_code" value="<?php echo $fav_code; ?>" style="width:150px; height: 23px;" >
                                                                                </td>
                                                                              
                                                                                
                                                                               
                                                                            </tr>
                                                                       </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>
                                                                </tr>
                                                               
                                                                <tr>
                                                                                <td width="15%" height="30" align="left" valign="middle"><strong>Category:</strong></td>
                                                                                <td width="15%" height="30" align="left" valign="middle"><input name="fav_cat" type="text" id="fav_cat" value="<?php echo $fav_cat; ?>" style="width:150px; height: 23px;" required=""></td>
                                                                               <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;UOM(Units Of Measurment):</strong></td>
                                                                                <td width="15%" height="30" align="left" valign="middle">
                                                                                    <select name="uom" id="uom" style="width:150px; height: 23px;">
                                                                                        <?php $arr_cucat_parent_cat_id=23; echo $obj->getFavCategoryRamakant($arr_cucat_parent_cat_id,$uom)?>
                                                                                    </select>
                                                                                </td>
                                                                                <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Comment:</strong></td>
                                                                                <td width="15%" height="30" align="left" valign="middle">
                                                                                    <textarea name="comment" type="text" id="comment"  style="width:150px; height: 23px;" required=""><?php echo $comment; ?></textarea>

                                                                                </td>
                                                                                <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Status:&nbsp;&nbsp;</strong></td>
                                                                                
                                                                                <td width="10%" height="30" align="left" valign="middle">
                                                                                    <select name="fav_cat_status" id="fav_cat_status" style="width:150px; height: 23px;" required="">
                                                                                        <option value="1" <?php if($fav_cat_status == 1) { echo 'selected'; } ?> >Active</option>
                                                                                        <option value="0" <?php if($fav_cat_status == 0) { echo 'selected'; } ?>>InActive</option>
                                                                                    </select>
                                                                                </td>
                                                                      
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>
                                                                </tr>
								 
                                                               <tr>
                                                                    <td width="15%" height="30" align="left" valign="middle"><strong>Profile Category:</strong></td>
                                                                    <td width="15%" height="30" align="left" valign="middle">
                                                                        <select  name="fav_cat_type_id" id="fav_cat_type_id" onchange="getMainCategoryOptionAddMore()" style="width:150px; height: 23px;" required="">
                                                                            <option value="">Select Type</option>
                                                                            <?php echo $obj->getFavCategoryTypeOptions($fav_cat_type_id);?>
                                                                        </select>
                                                                    </td>
                                                                    <td width="15%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;fav Category:</strong></td>
                                                                    <td width="15%" height="30" align="left" valign="middle">
                                                                        <select name="fav_cat_id" id="fav_cat_id" style="width:150px; height: 23px;">
                                                                            <?php echo $obj->getFavCategoryRamakant($fav_cat_type_id,$fav_parent_cat)?>
                                                                        </select>
                                                                    </td>
                                                                    <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td>
                                                                    <td width="10%" height="30" align="left" valign="middle">
                                                                        <select name="show_hide" id="show_hide" style="width:150px; height: 23px;" required="">
                                                                            <?php echo $obj->getShowHideOption($show_hide); ?>
                                                                        </select>
                                                                    </td>
                                                                    
                                                                    <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Status:&nbsp;&nbsp;</strong></td>
                                                                    <td width="10%" height="30" align="left" valign="middle">
                                                                        <select name="status" id="status" style="width:150px; height: 23px;" required="">
                                                                            <option value="1" <?php if($cat_status == 1) { echo 'selected'; } ?> >Active</option>
                                                                            <option value="0" <?php if($cat_status == 0) { echo 'selected'; } ?>>InActive</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            
								<tr>
									<td colspan="10" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
                                                                        <td>&nbsp;</td>
									<td>&nbsp;</td>
									<td align="left" valign="top"><input type="Submit" name="btnSubmit" value="Submit" /></td>
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
function getMainCategoryOptionAddMore()
{
        
	var parent_cat_id = $("#fav_cat_type_id").val();
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
			$("#fav_cat_id").html(result);
		}
	});
}
        </script>
</div>
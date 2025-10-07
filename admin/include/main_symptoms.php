<?php
require_once('config/class.mysql.php');
require_once('classes/class.bodyparts.php');
$obj = new BodyParts();

$view_action_id = '227';
$add_action_id = '228';

if(!$obj->isAdminLoggedIn())
{
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$view_action_id))
{	
	header("Location: index.php?mode=invalid");
	exit(0);
}

if(isset($_POST['btnSubmit']))
{
    $search = strip_tags(trim($_POST['search']));
    $bms_status = strip_tags(trim($_POST['bms_status']));
    $bmst_id = trim($_POST['bmst_id']);
    $fav_cat_type_id = trim($_POST['fav_cat_type_id']);
    $fav_cat_id = trim($_POST['fav_cat_id']);
    $updated_by = trim($_POST['updated_by']);
    
}
else
{
    $search = '';
    $bms_status = '';
    $bmst_id = '';
    $fav_cat_type_id = '';
    $fav_cat_id='';
    $updated_by='';
}

?>
<div id="central_part_contents">
	<div id="notification_contents"><!--notification_contents--></div>	  
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Symptoms</td>
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
							<p class="err_msg"><?php if(isset($_GET['msg']) && $_GET['msg'] != '' ) { echo urldecode($_GET['msg']); }?></p>
							<div id="pagination_contents" align="center"> 
                                                            <form action="#" method="post" name="frm_place" id="frm_place" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                        </tr>
                                        <tr>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>Profile Category:</strong></td>
                                            <td width="10%" height="30" align="left" valign="middle">
                                                <select name="fav_cat_type_id" id="fav_cat_type_id" style="width:200px;" onchange="getMainCategoryOptionAddMore()">
                                                    <option value="">All Type</option>
                                                    <?php echo $obj->getFavCategoryTypeOptions($fav_cat_type_id)?>
                                                </select>
                                            </td>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Fav Category:</strong></td>
                                            <td width="10%" height="30" align="left" valign="middle">
                                                <select name="fav_cat_id" id="fav_cat_id" style="width:200px;">
                                                    <option value="">All Type</option>
                                                    <?php echo $obj->getFavCategoryRamakant($fav_cat_type_id,$fav_cat_id)?>
                                                </select>
                                            </td>
                                            <td width="10%" height="30" align="left" valign="middle">&nbsp;</td>
                                            <td width="10%" height="30" align="left" valign="middle"><strong>Symptoms Name:</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <input type="text" name="search" id="search" value="<?php echo $search;?>" style="width:200px;"  />
                                            </td>
                                            <td width="20%" height="30" align="left" valign="middle">&nbsp;</td>
                                            <td width="5%" height="30" align="left" valign="middle"><strong>Status:</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <select name="bms_status" id="bms_status" style="width:200px;">
                                                    <option value="">All Status</option>
                                                    <option value="0" <?php if($bms_status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                    <option value="1" <?php if($bms_status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                       
                                        <tr>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">
                                                
                                            </td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td height="30" align="left" valign="middle">&nbsp;</td>
                                            <td colspan="2" height="30" align="left" valign="middle">
                                                <input type="submit" name="btnSubmit" id="btnSubmit" value="Search" />
                                            </td>
                                        </tr>
                                         <tr>
                                           
<!--                                            <td width="10%" height="30" align="left" valign="middle"><strong>Profile Category:</strong></td>
                                            <td width="15%" height="30" align="left" valign="middle">
                                                <input type="text" name="search" id="search" value="<?php echo $search;?>" style="width:200px;"  />
                                            </td>-->
                                            <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Posted By:</strong></td>
                                            <td width="10%" height="30" align="left" valign="middle">
                                                <select name="updated_by" id="updated_by" style="width:200px;">
                                                    <option value="">All </option>
                                                   <?php  echo $obj->getAdminDropdown($updated_by); ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                        </tr>
                                        
                                    </tbody>
                                    </table>
                                </form>
								<p></p>
								<table border="1" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<td colspan="13" align="left">
                                          <?php if($obj->chkValidActionPermission($admin_id,$add_action_id))
											{	 ?>
											<a href="index.php?mode=add_main_symptom"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
											<?php } ?>
                                        </td>
									</tr>
									<tr class="manage-header">
										<td width="7%" class="manage-header" align="center"><strong>S.No</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Symptom Code</strong></td>
                                                                                <td width="20%" class="manage-header" align="center"><strong>Symptom Name</strong></td>
                                                                                <td width="10%" class="manage-header" align="center"><strong>Profile Category</strong></td>
                                                                                <td width="10%" class="manage-header" align="center"><strong>Symptom Type</strong></td>
                                                                                <td width="10%" class="manage-header" align="center"><strong>Keywords</strong></td>
                                                                                <td width="10%" class="manage-header" align="center"><strong>Status</strong></td>
                                                                                <td width="10%" class="manage-header" align="center"><strong>posted by</strong></td>
                                                                                <td width="10%" class="manage-header" align="center"><strong>Date</strong></td>
                                                                                <td width="5%" class="manage-header" align="center"><strong>Add WSI</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Edit WSI</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Edit</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Delete</strong></td>
									</tr>
									<?php
									echo $obj->getAllMainSymptomsRamakant($search,$bms_status,$fav_cat_type_id,$fav_cat_id,$updated_by);
									?>
								</tbody>
								</table>
								<p></p>
							<!--pagination_contents-->
							</div>
							<p></p>
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

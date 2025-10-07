<?php

require_once('config/class.mysql.php');

require_once('classes/class.scrollingwindows.php');

$obj = new Scrolling_Windows();



$view_action_id = '160';

$add_action_id = '158';



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

    $fav_cat_type_id = trim($_POST['fav_cat_type_id']);

    $fav_cat_id = trim($_POST['fav_cat_id']);

    $status = trim($_POST['status']);

}

else 

{

    $search = '';

    $fav_cat_type_id = '';

    $status = '';

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

						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Fav Categories</td>

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

                                                            <form action="#" method="post" name="frm_stressbuster" id="frm_stressbuster" enctype="multipart/form-data" AUTOCOMPLETE="off">

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

                                            <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Status:</strong></td>

                                            <td width="15%" height="30" align="left" valign="middle">

                                                <select name="status" id="status" style="width:100px;">

                                                    <option value="">All Status</option>

                                                    <option value="0" <?php if($status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

                                                    <option value="1" <?php if($status == '1') { ?> selected="selected" <?php } ?>>Active</option>

                                                </select>

                                            </td>

                                            <td width="5%" height="30" align="left" valign="middle"><strong>Search:</strong></td>

                                            <td width="15%" height="30" align="left" valign="middle">

                                                <input type="text" id="search" name="search"  value="<?php echo $search; ?>" />

                                            </td>

                                        </tr>

                                        <tr>

                                            <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                        </tr>

                                        <tr>

                                            <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

                                            <td height="30" align="left" valign="middle">&nbsp;</td>

                                            <td height="30" align="left" valign="middle">&nbsp;</td>

                                            <td height="30" align="left" valign="middle">&nbsp;</td>

                                            <td height="30" align="left" valign="middle">&nbsp;</td>

                                            <td height="30" align="left" valign="middle">&nbsp;</td>

                                            <td colspan="2" height="30" align="left" valign="middle">

                                                <input type="submit" name="btnSubmit" id="btnSubmit" value="Search" />

                                            </td>

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

                                                                                    {	 

                                                                                    ?>

                                                                                    <a href="index.php?mode=add_fav_category"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>

                                                                                    <?php } ?>

                                                                            </td>

									</tr>

									<tr class="manage-header">

										<td width="5%" class="manage-header" align="center"><strong>S.No</strong></td>

										<td width="10%" class="manage-header" align="center"><strong>Fav Code</strong></td>

                                                                                <td width="10%" class="manage-header" align="center"><strong>Fav Category</strong></td>

                                                                                <td width="10%" class="manage-header" align="center"><strong>Fav Parent Category</strong></td>

                                                                                <td width="10%" class="manage-header" align="center"><strong>Profile Category</strong></td>

                                                                                <td width="5%" class="manage-header" align="center"><strong>Status</strong></td>

                                                                                <td width="10%" class="manage-header" align="center"><strong>posted by</strong></td>

                                                                                <td width="10%" class="manage-header" align="center"><strong>Date</strong></td>

                                                                                <td width="5%" class="manage-header" align="center"><strong>Icon</strong></td>

                                                                                <td width="5%" class="manage-header" align="center"><strong>Add WSI</strong></td>

										<td width="5%" class="manage-header" align="center"><strong>Edit WSI</strong></td>

										<td width="5%" class="manage-header" align="center"><strong>Edit</strong></td>

										<td width="5%" class="manage-header" align="center"><strong>Delete</strong></td>

									</tr>

									<?php

									echo $obj->getAllFavCategoriesRamakant($search,$fav_code,$status,$fav_cat_type_id,$fav_cat_id);

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


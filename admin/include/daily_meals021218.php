<?php
require_once('config/class.mysql.php');
require_once('classes/class.dailymeals.php');
$obj = new Daily_Meals();

if(isset($_POST['btnSubmit']))
{
	$search = strip_tags(trim($_POST['search']));
    //echo $search;

}

$add_action_id = '10';
$view_action_id = '12';
$import_action_id = '105';

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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Daily Meals </td>
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
								<p>
                                <form action="#" method="post" name="frm_dailymeal" id="frm_dailymeal" enctype="multipart/form-data" AUTOCOMPLETE="off">
                                <table border="0" width="32%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="right">Search For - :</td>
                                        <td align="left"><input type="text" id="search" name="search"  value="<?php echo $search; ?>" /></td>
                                        <td align="left"> <input type="Submit" name="btnSubmit" value="Search" /></td>             
                                    </tr>
                                 </table>
                                
                                 </form>
                                 </p>
								<table border="1" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<td colspan="2"align="left">
                                                                    <?php if($obj->chkValidActionPermission($admin_id,$import_action_id))
                                                                   {	 ?>
                                                                   <a href="index.php?mode=import_daily_meals">Import Excel File</a>
                                                                   <?php } ?>
                                                                   </td>
                                                                   <td colspan="15" align="right">
                                                                    <?php if($obj->chkValidActionPermission($admin_id,$add_action_id))
                                                                       {	 ?>
                                                                       <a href="index.php?mode=add_daily_meal"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>
                                                                       <?php } ?>
                                                                   </td>
									</tr>
									<tr class="manage-header">
										<td width="3%" class="manage-header" align="center"><strong>S.No</strong></td>
                                                                                <td width="3%" class="manage-header" align="center"><strong>Posted by</strong></td>
										<td width="4%" class="manage-header" align="center"><strong>Date</strong></td>
                                                                                <td width="3%" class="manage-header" align="center"><strong>Edit</strong></td>
										<td width="4%" class="manage-header" align="center"><strong>Delete</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Food Code</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Food Description</strong></td>
										<td width="10%" class="manage-header" align="center"><strong>Benefits</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Serving Size</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Volume</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Weight</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Ingredient Type</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Food Type</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Food Composition</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>Content</strong></td>
										<td width="5%" class="manage-header" align="center"><strong>UOM</strong></td>
										
										
									</tr>
									<?php
//                                                                          echo $obj->getAllDailyMealsOld($search);
                                                                            echo $obj->getAllDailyMeals($search);
                                                                       
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
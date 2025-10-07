<?php
require_once('config/class.mysql.php');
require_once('classes/class.theams.php');  
require_once('../init.php');
$obj = new Theams();

$edit_action_id = '331';
require_once('classes/class.scrollingwindows.php');
$obj1 = new Scrolling_Windows();

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

if(isset($_POST['btnSubmit']))
{
	$exl_id = $_POST['exl_id'];
        $exl_name = strip_tags(trim($_POST['exl_name']));
        $page_name = strip_tags(trim($_POST['page_name']));
        $user_id = $_SESSION['admin_id'];
        $status = $_POST['status'];
	
                        if($obj->Update_Exclusion($exl_id,$status,$exl_name,$page_name,$user_id))
				{
					$msg = "Record Edited Successfully!";
					header('location: index.php?mode=exclusion&msg='.urlencode($msg));
				}
			else
				{
					$error = true;
					$err_msg = "Currently there is some problem.Please try again later.";
				}
		

    }
    elseif(isset($_GET['id']))
	{
		$id = $_GET['id'];

		list($exl_name,$page_name,$page_id,$page_type,$status) = $obj->getExclusionDetails($id);
//	        print_r($listing_date_type);die();
//		$arr_day = explode(",", $days_of_month);
        
	}




?>
<script src="js/AC_ActiveX.js" type="text/javascript"></script>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
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
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Exclusion</td>
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
							<form action="#" method="post" name="frmedit_theam" id="frmedit_theam" enctype="multipart/form-data" >
                                                            <input type="hidden" id="exl_id" name="exl_id" value="<?php echo $id;?>" />
                            <!--<input type="hidden" name="hdn_image" value="<?php echo $image;?>" />-->             
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
							<tbody>
                                                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
								<tr>
                                                <td width="20%" align="right"><strong>Exclusion Name</strong></td>
                                                <td width="5%" align="center"><strong>:</strong></td>
                                                <td width="75%" align="left"><input type="text"  id="exl_name" name="exl_name" value="<?php echo $exl_name; ?>"/>
                                                </td>
                                    </tr>
				    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>
                                                <td width="20%" align="right"><strong>Page Name</strong></td>
                                                <td width="5%" align="center"><strong>:</strong></td>
                                                <td width="75%" align="left">
                                                   <?php if($page_type == 'Page')
                                                   {
                                                       echo $obj->getPagenamebyid($page_id);
                                                   } 
                                                   else
                                                   {
                                                       echo $obj->getAdminMenuName($page_id);
                                                   }
                                                   ?>
                                                    
                                                </td>
                                                 
                                    </tr>
                                     <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>
                                    <tr>
                                        <td width="20%" align="right"><strong>Status</strong></td>
                                        <td width="5%" align="center"><strong>:</strong></td>
                                        <td width="75%" align="left"><select name="status" id="status">
                                                <option value="1" <?php  if($status == 1) {?> selected="selected" <?php } ?> >Active</option>
                                                <option value="0" <?php  if($status == 0) {?> selected="selected" <?php } ?> >Inactive</option>
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
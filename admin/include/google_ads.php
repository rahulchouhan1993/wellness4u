<?php
require_once('config/class.mysql.php');
require_once('classes/class.banner.php');  
$banner = new Banner();


$view_action_id = '81';

if(!$banner->isAdminLoggedIn())
{
	
	header("Location: index.php?mode=login");
	exit(0);
}

if(!$banner->chkValidActionPermission($admin_id,$view_action_id))
	{	
	  	header("Location: index.php?mode=invalid");
		exit(0);
	}

$error = false;
$err_msg = "";
if(isset($_POST['btnSubmit']))
{
	$arr_position_id = $_POST['hdn_position_id'];
	$arr_position = $_POST['hdn_position'];
	$arr_google_ads = $_POST['google_ads'];
		
		if(!$error)
		{
							
			if($banner->Update_google_ads($arr_position_id,$arr_position,$arr_google_ads))
				{
						$msg = "Record Edited Successfully!";
						header('location: index.php?mode=banner&msg='.urlencode($msg));
				}
			else
				{
					$error = true;
					$err_msg = "Currently there is some problem.Please try again later.";
				}
		}	
}else
{
    list($arr_position_id,$arr_position,$arr_side,$arr_height,$arr_width,$arr_google_ads) = $banner->GetAllPositions();
	
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Google Adds</td>
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
                                 <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                	<tr align="left">
                                    	<td align="left">
                                        	<input type="button" name="btnSubmit" value="Back" onclick="window.location.href='index.php?mode=banner';"/>
                                       		</td>
                                        </tr>
                                 </table>
                                </p>
								<form id="google_add" name="google_add" action="#" method="post" enctype="multipart/form-data" >
                               
                                <table border="0" width="100%" cellpadding="1" cellspacing="1">
								<tbody>
                                <tr class="manage-header">
										<td class="manage-header" align="center" width="10%" nowrap="nowrap" >S.No.</td>
									    <td class="manage-header" align="center" width="20%">Position</td>
                                         <td class="manage-header" align="center" width="70%">Google Ads</td>
                                      </tr>
                                <?php 
                                	for($i=0;$i<count($arr_position_id);$i++)
									{	?>
										<tr class="manage-row">
										<td height="30" align="center" ><?php echo $i+1; ?></td>
									    <td height="30" align="center" ><strong><?php echo $arr_position[$i]; ?></strong><br/><span>(<?php echo $arr_width[$i];?> X <?php echo $arr_height[$i]; ?>)</span></td>
                                        <td height="30" align="center" >
                                        <input type="hidden" id="hdn_position_id_<?php echo $arr_position_id[$i]; ?>" name="hdn_position_id[]" value="<?php echo $arr_position_id[$i]; ?>" />
                                        <input type="hidden" id="hdn_position_<?php echo $arr_position[$i]; ?>" name="hdn_position[]" value="<?php echo $arr_position[$i]; ?>" />
                                        
                                        <textarea id="google_ads_<?php echo $arr_position_id[$i]; ?>" name="google_ads[]" cols="60" rows="3"><?php  echo $arr_google_ads[$i]; ?></textarea></td>
                                     	 </tr>
                                    	<?php } ?>				
                                    <tr>
										<td colspan="3" align="center">
										<input type="Submit" name="btnSubmit" value="Submit" />
										</td>
									</tr>
								</tbody>
                                </table>
								</form>
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
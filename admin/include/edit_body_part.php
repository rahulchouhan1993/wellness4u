<?php
require_once('config/class.mysql.php');
require_once('classes/class.bodyparts.php');

$obj = new BodyParts();

$edit_action_id = '221';

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
	$bp_id = $_POST['hdnbp_id'];
	
	$bp_name = strip_tags(trim($_POST['bp_name']));
        $bp_side = trim($_POST['bp_side']);
        $bp_sex = trim($_POST['bp_sex']);
        //$bp_parent_id = trim($_POST['bp_parent_id']);
        $bp_parent_id = '0';
        $bp_image_x1 = trim($_POST['hdnbp_image_x1']);
        $bp_image_x2 = trim($_POST['hdnbp_image_x2']);
        $bp_image_y1 = trim($_POST['hdnbp_image_y1']);
        $bp_image_y2 = trim($_POST['hdnbp_image_y2']);
        $bp_image_w = trim($_POST['hdnbp_image_w']);
        $bp_image_h = trim($_POST['hdnbp_image_h']);
	
	$bp_status = strip_tags(trim($_POST['bp_status']));
	
	if($bp_name == '')
    {
            $error = true;
            $err_msg = 'Please enter body part name';
    }

    if($bp_side == '')
    {
        $error = true;
        $err_msg .= '<br>Please select side';
    }

    if($bp_side == '')
    {
        $error = true;
        $err_msg .= '<br>Please select gender';
    }

    if($bp_image_x1 == '' || $bp_image_x2 == '' || $bp_image_y1 == '' || $bp_image_y2 == '' || $bp_image_w == '' || $bp_image_h == '')
    {
        $error = true;
        $err_msg .= '<br>Please select body part image';
    }
    
    if($bp_sex == '1')
    {
        if($bp_side == '1')
        {
            $body_image = 'male_body_front.png';
        }
        else
        {
            $body_image = 'male_body_back.png';
        }
    }
    else
    {
        if($bp_side == '1')
        {
            $body_image = 'female_body_front.png';
        }
        else
        {
            $body_image = 'female_body_back.png';
        }
    }

	if(!$error)
	{
		$bp_image = $bp_image_x1.','.$bp_image_x2.','.$bp_image_y1.','.$bp_image_y2.','.$bp_image_w.','.$bp_image_h;
		
		if($obj->updateBodyPart($bp_name,$bp_side,$bp_sex,$bp_parent_id,$bp_image,$bp_status,$bp_id))
		{
			$msg = "Record Updated Successfully!";
			header('location: index.php?mode=body_parts&msg='.urlencode($msg));
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
	$bp_id = $_GET['id'];
	list($bp_name,$bp_side,$bp_sex,$bp_parent_id,$bp_image,$bp_status) = $obj->getBodyPartDetails($bp_id);
	if($bp_name == '')
	{
		header('location: index.php?mode=body_parts');	
	}
	
	$arr_temp_image = explode(',',$bp_image);
        $bp_image_x1 = $arr_temp_image[0];
        $bp_image_x2 = $arr_temp_image[1];
        $bp_image_y1 = $arr_temp_image[2];
        $bp_image_y2 = $arr_temp_image[3];
        $bp_image_w = $arr_temp_image[4];
        $bp_image_h = $arr_temp_image[5];
        
        if($bp_sex == '1')
        {
            if($bp_side == '1')
            {
                $body_image = 'male_body_front.png';
            }
            else
            {
                $body_image = 'male_body_back.png';
            }
        }
        else
        {
            if($bp_side == '1')
            {
                $body_image = 'female_body_front.png';
            }
            else
            {
                $body_image = 'female_body_back.png';
            }
        }
}	
else
{
	header('location: index.php?mode=body_parts');
}
?>
<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
<script type="text/javascript" src="js/jquery.Jcrop.js"></script>
<script type="text/javascript"> 
	$(document).ready(function() {
		var jcrop_api;

                $('#target').Jcrop({
                  onChange:   showCoords,
                  onSelect:   showCoords,
                  onRelease:  clearCoords,
                  setSelect: [ <?php echo $bp_image_x1;?>, <?php echo $bp_image_y1;?>, <?php echo $bp_image_x2;?>, <?php echo $bp_image_y2;?> ]
                },function(){
                  jcrop_api = this;
                });

                $('#coords').on('change','input',function(e){
                  var x1 = $('#hdnbp_image_x1').val(),
                      x2 = $('#hdnbp_image_x2').val(),
                      y1 = $('#hdnbp_image_y1').val(),
                      y2 = $('#hdnbp_image_y2').val();
                  jcrop_api.setSelect([x1,y1,x2,y2]);
                });
                jcrop_api.setSelect([x1,y1,x2,y2]);
                
                
	});
</script>
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Body Part</td>
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
							<input type="hidden" name="hdnbp_id" id="hdnbp_id" value="<?php echo $bp_id;?>" />
                                                        <input type="hidden" name="hdnbp_image_x1" id="hdnbp_image_x1" value="<?php echo $bp_image_x1;?>" />
                                                        <input type="hidden" name="hdnbp_image_x2" id="hdnbp_image_x2" value="<?php echo $bp_image_x2;?>" />
                                                        <input type="hidden" name="hdnbp_image_y1" id="hdnbp_image_y1" value="<?php echo $bp_image_y1;?>" />
                                                        <input type="hidden" name="hdnbp_image_y2" id="hdnbp_image_y2" value="<?php echo $bp_image_y2;?>" />
                                                        <input type="hidden" name="hdnbp_image_w" id="hdnbp_image_w" value="<?php echo $bp_image_w;?>" />
                                                        <input type="hidden" name="hdnbp_image_h" id="hdnbp_image_h" value="<?php echo $bp_image_h;?>" />
							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow">
							<tbody>
                                                                <tr>
                                        <td width="30%" align="right" valign="top"><strong>Body Part Name</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <input type="text" name="bp_name" id="bp_name" value="<?php echo $bp_name;?>" style="width:200px;" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Side</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="bp_side" id="bp_side" style="width:200px;" onchange="toggleBodyImage();">
                                                <option value="1" <?php if($bp_side == '1'){?> selected <?php } ?>>Front Side</option>
                                                <option value="0" <?php if($bp_side == '0'){?> selected <?php } ?>>Back Side</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Gender</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="bp_sex" id="bp_sex" style="width:200px;" onchange="toggleBodyImage();">
                                                <option value="1" <?php if($bp_sex == '1'){?> selected <?php } ?>>Male</option>
                                                <option value="0" <?php if($bp_sex == '0'){?> selected <?php } ?>>Female</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <?php
                                    /*
                                    <tr>
                                        <td align="right"><strong>Main Body part</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <select name="bp_parent_id" id="bp_parent_id" style="width:200px;">
                                                <option value="0" >None</option>
                                                <?php echo $obj->getMainBodyPartsOptions($bp_parent_id,'0'); ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                     * 
                                     */
                                    ?>
                                    <tr>
                                        <td align="right"><strong>Image</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left" id="idbodyimage">
                                            <img src="<?php echo SITE_URL.'/uploads/'.$body_image;?>" id="target" alt="[Jcrop Example]" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                            <td align="right"><strong>Status</strong></td>
                                            <td align="center"><strong>:</strong></td>
                                            <td align="left">
                                                <select id="bp_status" name="bp_status">
                                                    <option value="1" <?php if($bp_status == '1'){ ?> selected <?php } ?>>Active</option>
                                                    <option value="0" <?php if($bp_status == '0'){ ?> selected <?php } ?>>Inactive</option>
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
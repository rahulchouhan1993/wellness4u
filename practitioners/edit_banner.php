<?php
require_once('../config.php');
$page_id = '104';
list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('practitioners/themes.php');

if(!isLoggedInPro())
{
	header("Location: ".SITE_URL."/prof_login.php?ref=".$ref);
	exit(0);
}
else
{
	doUpdateOnlinePro($_SESSION['pro_user_id']);
	$pro_user_id = $_SESSION['pro_user_id'];
}

if(!chkAdviserPlanFeaturePermission($pro_user_id,'15'))
{
	header('location: banners.php');
	exit(0);
}

if(get_magic_quotes_gpc())
{
	foreach($_POST as $k => $v)
	{
		$_POST[$k] = stripslashes($_POST[$k]);
	}
}

$error = false;
$err_msg = "";
$new_banner = false;


if(isset($_POST['btnSubmit']))
{
	$ab_id = $_POST['hdnab_id'];
	$image 		= strip_tags(trim($_POST['image']));
	//$status = strip_tags(trim($_POST['status'])); 
	
	list($old_image,$old_status) = getAdviserBannerDetails($ab_id,$pro_user_id);
	
	if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != '')
	{
	
		$image = basename($_FILES['image']['name']);
		
		$type_of_uploaded_file =substr($image,strrpos($image, '.') + 1);
		$target_size = $_FILES['image']['size']/1024;
			
		$max_allowed_file_size = 1000; // size in KB
		$target_type = array("jpg","JPG","jpeg","JPEG","gif","GIF","png","PNG");
	
		if($target_size > $max_allowed_file_size )
		{
			$error = true;
			$err_msg .=  "\n Size of file should be less than $max_allowed_file_size kb";
		}
	
		$allowed_ext = false;
		for($i=0; $i<count($target_type); $i++)
		{
			if(strcasecmp($target_type[$i],$type_of_uploaded_file) == 0)
			{
				$allowed_ext = true;
			}
		  
		}
		
		if(!$allowed_ext)
		{
			$error = true;
			
			$err_msg .= "\n The uploaded file is not supported file type. ".
					   "<br>Only the following file types are supported: ".implode(',',$target_type);
		}
	
	    if(!$error)
		{
		    
			if($old_image != $image)
			{
				$new_banner = true;
			}
				
			$target_path = SITE_PATH."/uploads/";
			$image = time().'_'.$image;
			$target_path = $target_path .$image;
		
		  	
			if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path))
			{		    
			
			} 
			else
			{
				$error = true;
				$err_msg .= '<br>Banner file not uploaded. Please Try again Later';
				$image = $_POST['hdn_image'];
			}
		}
		else
		{
			$image = $_POST['hdn_image'];
		}
	}	
	else
	{
		$image = $_POST['hdn_image'];
	}
	
	if(!$error)
	{
		if(updateAdviserBanner($pro_user_id,$image,$ab_id,$new_banner))
		{
			$msg = "Record Updated Successfully!";
			
			if($new_banner)
			{
				header('location: message.php?msg=5');  // 13 is old message id
			}
			else
			{		
				header('location: banners.php?msg='.urlencode($msg));
			}
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
	$ab_id = $_GET['id'];
	list($image,$status) = getAdviserBannerDetails($ab_id,$pro_user_id);
	if($image == '')
	{
		header('location: banners.php');
		exit(0);
	}
	
}	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $meta_description;?>" />
	<meta name="keywords" content="<?php echo $meta_keywords;?>" />
	<meta name="title" content="<?php echo $meta_title;?>" />
	<title><?php echo $meta_title;?></title>
	<link href="../cwri.css" rel="stylesheet" type="text/css" />
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/JavaScript" src="js/commonfn.js"></script>
	<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
	<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
   
    
    <style type="text/css">@import "css/jquery.datepick.css";</style> 
	<script type="text/javascript" src="js/jquery.datepick.js"></script>
    
     <script type="text/javascript" src="js/jscolor.js"></script>
     
      <link href="css/ticker-style.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.ticker.js" type="text/javascript"></script>
    
	<script type="text/javascript">
		ddsmoothmenu.init({
		mainmenuid: "smoothmenu1", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		//customtheme: ["#1c5a80", "#18374a"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
		})

		$(document).ready(function() {
		
			$('#js-news').ticker({
				controls: true,        // Whether or not to show the jQuery News Ticker controls
				 htmlFeed: true, 
				titleText: '',   // To remove the title set this to an empty String
				displayType: 'reveal', // Animation type - current options are 'reveal' or 'fade'
				direction: 'ltr'       // Ticker direction - current options are 'ltr' or 'rtl'
				
			});
		
			$(".QTPopup").css('display','none')

			$(".feedback").click(function(){
				$(".QTPopup").animate({width: 'show'}, 'slow');
			});	

			$(".closeBtn").click(function(){			
				$(".QTPopup").css('display', 'none');
			});
			
			
		});			
	</script>
</head>
<body>
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" valign="top">
			<?php include_once('header.php');?>
			<table width="980" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="980" align="left" valign="top">
						<table width="960" align="center" border="0" cellspacing="0" cellpadding="0">
							<tr>
	                            <td height="40" align="left" valign="top" class="breadcrumb">
                                	<?php echo getBreadcrumbCode($page_id);?>
                                     
                                </td>
                            </tr>
                        </table> 
						<table width="960" align="center" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">
							<tr>
								<td align="center" valign="middle" bgcolor="#FFFFFF" style="background-repeat:repeat-x; padding:10px;">
									<form action="#" name="frmedit_profile" id="frmedit_profile" method="post" enctype="multipart/form-data"> 
                                    	
										<input type="hidden" name="hdnab_id" value="<?php echo $ab_id;?>" />
                           				 <input type="hidden" name="hdn_image" value="<?php echo $image;?>" />
                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                        <tbody>
                                        	<tr>
												<td colspan="3" align="left" class="err_msg"><?php echo $err_msg;?></td>
											</tr>
                                        	
                                <?php /*?><tr>
									<td width="20%" align="right"><strong>Status</strong></td>
									<td width="5%" align="center"><strong>:</strong></td>
									<td width="75%" align="left">
                                    <select name="status" id="status">
                                                                    <option value="1" <?php  if($status == 1) {?> selected="selected" <?php } ?> >Active</option>
                                                                    <option value="0" <?php  if($status == 0) {?> selected="selected" <?php } ?> >Inacive</option>
                                                                    </select>
                                    
                                                                    </td>
								</tr>
								<tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr><?php */?>
                                 
								 <tr>
									<td align="right"></td>
									<td align="center"></td>
									<td align="left"><img border="0" src="<?php echo SITE_URL."/uploads/".$image ?>" width="200"  />    </td>
								</tr>
                                <tr>
									<td colspan="3" align="center">&nbsp;</td>
								</tr>
                                <tr>
                                   <td width="20%" align="right" valign="top"><strong>Upload Image</strong>
                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                    <td width="75%">
                                    	<input name="image" type="file" id="image" />
                                        <br /><span class="footer">Please upload banner of resolution (960X150)</span>
                                        <br /><span class="footer">Allowed Image type (jpg/gif/png)</span>
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
						</table>
						<table width="580" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<?php include_once('footer.php');?>
		</td>
	</tr>
</table>
</body>
</html>
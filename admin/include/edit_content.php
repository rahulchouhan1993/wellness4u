<?php

require_once('config/class.mysql.php');

require_once('classes/class.contents.php');

require_once('../init.php');



$obj = new Contents();



$edit_action_id = '76';



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

	$page_id = $_POST['hdnpage_id'];

	$page_name = trim($_POST['page_name']);

	$page_title = trim($_POST['page_title']);

	$page_contents = trim($_POST['page_contents']);

        $page_contents2 = trim($_POST['page_contents2']);

	$meta_title = trim($_POST['meta_title']);

	$meta_keywords = trim($_POST['meta_keywords']);

	$meta_description = trim($_POST['meta_description']);

	$menu_title = trim($_POST['menu_title']);

        $menu_link = trim($_POST['menu_link']);

	$menu_link_enable = trim($_POST['menu_link_enable']);

        $admin_id = $_SESSION['admin_id'];

        $hdnpage_icon =trim($_POST['hdnpage_icon']);

       

	

	if($page_name == "")

	{

		$error = true;

		$err_msg = "Please Enter Page Name.";

	}

	

	if($menu_title == "")

	{

		$error = true;

		$err_msg = "Please Enter Menu Name.";

	}

	//comment by ample 09-12-19

	// if(isset($_FILES['page_icon']['tmp_name']) && $_FILES['page_icon']['tmp_name'] != '')

	// 		{

			

	// 			$image = basename($_FILES['page_icon']['name']);

				

	// 			$type_of_uploaded_file =substr($image,strrpos($image, '.') + 1);

	// 			$target_size = $_FILES['image']['size']/1024;

					

	// 			$max_allowed_file_size = 1000; // size in KB

	// 			$target_type = array("jpg","JPG","jpeg","JPEG","gif","GIF","png","PNG");

			

	// 				if($target_size > $max_allowed_file_size )

	// 				{

	// 					$error = true;

	// 					$err_msg .=  "\n Size of file should be less than $max_allowed_file_size kb";

	// 				}

			

	// 			$allowed_ext = false;

	// 				for($i=0; $i<count($target_type); $i++)

	// 				{

	// 					if(strcasecmp($target_type[$i],$type_of_uploaded_file) == 0)

	// 					{

	// 						$allowed_ext = true;

	// 					}

					  

	// 				}

			

	// 			if(!$allowed_ext)

	// 			{

	// 				$error = true;

					

	// 				$err_msg .= "\n The uploaded file is not supported file type. ".

	// 						   "<br>Only the following file types are supported: ".implode(',',$target_type);

	// 			}

		

	// 			if(!$error)

	// 			{

					

	// 				$target_path = SITE_PATH."/uploads/";

	// 				$image = time().'_'.$image;

	// 				$target_path = $target_path .$image;

				

					

	// 				if(move_uploaded_file($_FILES['page_icon']['tmp_name'], $target_path))

	// 					{		    

					

	// 					} 

	// 				else

	// 					{

	// 						$error = true;

	// 						$err_msg .= '<br>File Not Uploaded. Please Try Again Later';

	// 					}

				

	// 			}

		

	// }	

	// else

	// 	{

	// 	  $image = $hdnpage_icon;

	// 	}	

	$page_icon=trim($_POST['page_icon']);
	$page_icon_type=trim($_POST['page_icon_type']);

	if(!$error)

	{

		if($obj->UpdateContent($page_icon,$menu_link,$page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$page_id,$page_contents2,$admin_id,$page_icon_type))

		{

			$err_msg = "Page Updateds Successfully!";

			header('location: index.php?mode=contents&msg='.urlencode($err_msg));

		}

		else

		{

			$error = true;

			$err_msg = "Currently there is some problem.Please try again later.";

		}

	}

}

elseif(isset($_GET['page_id']))

{

	$page_id = $_GET['page_id'];

	list($page_icon,$menu_link,$page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link_enable,$page_contents2,$page_icon_type) = $obj->getContentDetails($page_id);

}

else

{

	header('location: index.php?mode=contents');

}	

?>

<!-- TinyMCE -->

	<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>

	<script type="text/javascript">

		tinyMCE.init({

			mode : "exact",

			theme : "advanced",

			elements : "page_contents,page_contents2",

			plugins : "style,advimage,advlink,emotions",

			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

		});

	</script>

	<!-- /TinyMCE -->

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

						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Page </td>

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

							<form action="#" method="post" name="frmedit_content" id="frmedit_content" enctype="multipart/form-data" >

							<input type="hidden" name="hdnpage_id" value="<?php echo $page_id;?>" />

                                                        <!-- <input type="hidden" name="hdnpage_icon" value="<?php echo $page_icon;?>" /> -->

							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">

							<tbody>

                                                            <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right"><strong>Page Name</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left"><input name="page_name" type="text" id="page_name" value="<?php echo $page_name; ?>" style="width:400px;" ></td>

								</tr>

                                                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right"><strong>Page Icon</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">	
																<!-- comment by ample 09-12-19 -->
                                                                            <!-- <input name="page_icon" type="file" id="page_icon"> -->

                                                                           <!--  <br> -->

                                                                           <!--  <?php if($page_icon!='') {

                                                                                ?>

                                                                                    <img src="../uploads/<?php echo $page_icon; ?>" style="width:50px; height: 50px;">

                                                                                <?php

                                                                            } ?> -->


                                        <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('IMG',0,'page_icon');">Gallery 1</button>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('OT',0,'page_icon');">Gallery 2</button>
                                        <input type="hidden" name="page_icon" id="page_icon" value="<?=$page_icon?>" readonly />
                                        <input type="text" name="page_icon_type" id="page_icon_type" value="<?=$page_icon_type?>" readonly/>

                                        <?php 
                                        $banner_name=$banner_file="";
                                        if(!empty($page_icon_type))
                                        {
                                            if($page_icon_type=='Image')
                                            {
                                                $banner_data=$obj->get_data_from_tblicons('',$page_icon);
                                                $banner_name=$banner_data[0]['icons_name'];
                                                $banner_file=$banner_data[0]['image'];
                                            }
                                            else
                                            {
												//commented by rahul
                                                //$banner_data=$obj->get_data_from_tblmindjumble('',$page_icon);
												$banner_data=$obj->get_data_from_tblicons('',$page_icon);
                                                $banner_name=$banner_data[0]['box_title'];
                                                $banner_file=$banner_data[0]['box_banner'];
                                            }
                                        }

                                        ?>

                                        <input type="text"  id="page_icon_name" value="<?=$banner_name;?>" disabled/>
                                        <input type="text"  id="page_icon_file" value="<?=$banner_file;?>" disabled />
                                        <button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData('page_icon');">Reset</button>
                                        
                                         <br>
                                        <?php 

                                        if(!empty($banner_file))
                                        {

                                                ?>
                                                <a href="<?php echo SITE_URL.'/uploads/'. $banner_file;?>" target="_blank"><?php echo $banner_file;?></a> 
                                                <?php
                                        }


                                        ?>


                                                                        </td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right"><strong>Page Title</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left"><input name="page_title" type="text" id="page_title" value="<?php echo $page_title; ?>" style="width:400px;" ></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                <tr>

									<td align="right"><strong>Menu Title</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left"><input name="menu_title" type="text" id="menu_title" value="<?php echo $menu_title; ?>" style="width:400px;" ></td>

								</tr>

                                                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                <tr>

									<td align="right"><strong>Menu Link</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left"><input name="menu_link" type="text" id="menu_link" value="<?php echo $menu_link; ?>" style="width:400px;" ></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                <tr>

									<td align="right"><strong>Enable Menu Link</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left"><input type="checkbox" name="menu_link_enable" id="menu_link_enable" value="1" <?php if($menu_link_enable == '1'){?> checked="checked" <?php }?>   ></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right" valign="top"><strong>Contents</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<textarea id="page_contents" name="page_contents" style="width: 400px; height:400px;"><?php echo stripslashes($page_contents);?></textarea>

									</td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                <tr>

									<td align="right" valign="top"><strong>Extra Contents </strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<textarea id="page_contents2" name="page_contents2" style="width: 400px; height:400px;"><?php echo stripslashes($page_contents2);?></textarea>

									</td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right"><strong>Meta Title</strong></td>

									<td align="center"><strong>:</strong></td>

									<td align="left">

										<input type="text" id="meta_title" name="meta_title" style="width: 400px;" value="<?php echo $meta_title;?>" />

									</td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right" valign="top"><strong>Meta Keywords</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<textarea id="meta_keywords" name="meta_keywords" style="width: 400px; height:100px;"><?php echo $meta_keywords;?></textarea>

									</td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td align="right" valign="top"><strong>Meta Description</strong></td>

									<td align="center" valign="top"><strong>:</strong></td>

									<td align="left">

										<textarea id="meta_description" name="meta_description" style="width: 400px; height:100px;"><?php echo $meta_description;?></textarea>

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
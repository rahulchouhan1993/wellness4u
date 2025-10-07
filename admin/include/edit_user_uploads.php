<?php

require_once('config/class.mysql.php');

require_once('classes/class.mindjumble.php');

require_once('../init.php');

$obj = new Mindjumble();



$edit_action_id = '347';



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

    $id = $_POST['hdnbanner_id'];

    $admin_comment =$_POST['admin_comment'];

    $show_where =$_POST['show_where'];

    $show_to_user =$_POST['show_to_user'];

    $status =$_POST['status'];

    $approved_date = date("Y-m-d H:i:s");



    $admin_tags=$_POST['admin_tags'];





            

		if(!$error)

		{  

			if($obj->Update_UserUploads($id,$admin_id,$admin_comment,$show_where,$show_to_user,$status,$approved_date,$admin_tags))

				{

                                        $user_uploads = $_GET['user_uploads'];

					if($user_uploads == '1')

						{

							$mode = 'mindjumble_user_upload';

						}

						else

						{

							$mode = 'mindjumble';

						}

					$msg = "Record Edited Successfully!";	

					header('location: index.php?mode='.$mode.'&msg='.urlencode($msg));

				}

			else

				{

					$error = true;

					$err_msg = "Currently there is some problem.Please try again later.";

				}

		}	

}

elseif(isset($_GET['uid']))

{

  $banner_id = $_GET['uid'];    

  $data = $obj->getuseruploadsDetails($banner_id);    

  $arr_admin_tags = explode(",", $data['admin_tags']);

       //  echo '<pre>';

       // print_r($arr_admin_tags);

       // echo '</pre>';

	// die();

	

	$arr_day = explode(",", $day);

	

	if($step == '2')

	{

		$display_stressbuster = '';

	}

	else

	{	

		$display_stressbuster = 'none';

	}

	

	if($banner_type == 'Video')

	{

		$display_trfile = 'none';

		$display_trtext = '';

	}

	else

	{

		$display_trfile = '';

		$display_trtext = 'none';

	}

}

else

{

	$user_uploads = $_GET['user_uploads'];

	if($user_uploads == '1')

	{

		$mode = 'mindjumble_user_upload';

	}

	else

	{

		$mode = 'mindjumble';

	}

	header('location: index.php?mode='.$mode);

}	



?>

<meta charset="utf-8">

<script src="js/AC_ActiveX.js" type="text/javascript"></script>

<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>





<link rel="stylesheet" href="css/build.min.css">

<script src="js/build.min.js"></script>

<link rel="stylesheet" href="css/fastselect.min.css">

<script src="js/fastselect.standalone.js"></script>



  <style>



   /* .fstElement { font-size: 1.2em; }

    .fstToggleBtn { min-width: 16.5em; }



    .submitBtn { display: none; }



    .fstMultipleMode { display: block; }

    .fstMultipleMode .fstControls { width: 100%; }*/



        </style>





<!-- <script src="js/tokenize2.js"></script> -->



<script>

// $(document).ready(function(){

	// $('#ingredient_type').tokenize2({sortable: true});

	// $('#ingredient_type').on('tokenize:tokens:add', getIngredientsByIngrdientType);

	// $('#ingredient_type').on('tokenize:tokens:remove', getIngredientsByIngrdientType);

	// $('#ingredient_id').tokenize2({sortable: true});

// });

</script>



<?php

 // echo "<pre>";print_r($data);echo "</pre>";

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

	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">

	<tbody>

		<tr>

			<td>

				<table border="0" width="100%" cellpadding="0" cellspacing="0">

				<tbody>

					<tr>

						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>

						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>

						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit User Uploads</td>

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

							<form action="#" method="post" name="frmedit_Mindjumble" id="frmedit_Mindjumble" enctype="multipart/form-data" >

							<input type="hidden" name="hdnbanner_id" value="<?php echo $banner_id;?>" />

                                                     <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">

							<tbody>

								

                                                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                <tr>

									<td width="20%" align="right"><strong>Ref Code</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                            <?php echo $data['ref_code']; ?>

                                                                        </td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                <tr>

                                                                    <td width="30%" align="right" valign="top"><strong>Admin Notes</strong></td>

                                                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                                                    <td width="65%" align="left" valign="top">

                                                                        <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"><?php echo $data['admin_notes']; ?></textarea>

                                                                        

                                                                    </td>

                                                                </tr>

                                                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                

                                                                <tr>

                                                                    <td width="30%" align="right" valign="top"><strong>Show Where</strong></td>

                                                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                                                    <td width="65%" align="left" valign="top">

                                                                        <input type="text" name="show_where" id="show_where" value="<?php echo $data['show_where']; ?>"/>

                                                                    </td>

                                                                </tr>

                                                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                

                                                                <tr>

									<td width="20%" align="right"><strong>User Show</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                            <select name="show_to_user" id="show_to_user" style="width:200px;" required="">

                                                                                <option value="">Select</option>

                                                                                 <option value="1" <?php if($data['user_show'] == 1) { echo 'Selected'; } ?>>Yes</option>

                                                                                  <option value="0" <?php if($data['user_show'] == 0) { echo 'Selected'; } ?>>No</option>

                                                                            </select>

                                                                        </td>

								</tr>

                                                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                <tr>

									<td width="20%" align="right"><strong>Status</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                            <select id="status" name="status" style="width:200px;">

                                                                                <option value="1" <?php if($data['status'] == '1'){ ?> selected <?php } ?>>Active</option>

                                                                                <option value="0" <?php if($data['status'] == '0'){ ?> selected <?php } ?>>Inactive</option>

                                                                            </select>

                                                                        </td>

								</tr>

                                                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                <tr>

									<td width="20%" align="right"><strong>Box Title</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                        <?php echo $data['box_title']; ?>

                                                                        </td>

								</tr>

                                                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right" ><strong>Fav Cat</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                            

                                                                           <?php echo $obj->getFavCatNameById($data['sub_cat_id']); ?> 

                                                                            

                                                                        </td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

                                                                        <?php $user_data = $obj->getUserDetails($data['user_id']); ?>

									<td width="20%" align="right"><strong>User Name</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                            <?php echo $user_data['name'].' '.$user_data['middle_name'].' '.$user_data['last_name']; ?>

                                                                        </td>

								</tr>

                                                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right"><strong>User ID</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                           <?php echo $user_data['unique_id']; ?>

                                                                        </td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                                                    

                                   <tr>

										<td width="20%" align="right"><strong>From Page</strong></td>

										<td width="5%" align="center"><strong>:</strong></td>

										<td width="75%" align="left">

	                                      <?php echo $data['from_page']; ?>

                                  </td>

								</tr>





                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>





                                 <!-- $data['id']  -->





                                 <tr>

                                    <td width="30%" align="right" valign="top"><strong>User Tags</strong></td>

                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                    <td width="65%" align="left" valign="top">

                                    	 <?php //echo $obj->getUserTagsValue($data['id'],$data['user_id']);?> 

							            <select class="multipleSelect" name="user_tags" id="user_tags" multiple >

							                <?php echo $obj->getUserTagsValue($data['id'],$data['user_id']);?> <!-- fav id,comman,pagename -->

							            </select>



							            <script>

							                $('.multipleSelect').fastselect();

							            </script>

                                    </td>

                                </tr>

                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                  <tr>

                                    <td width="30%" align="right" valign="top"><strong>Admin Tags</strong></td>

                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                    <td width="65%" align="left" valign="top">

 

	                                      <select class="multipleSelect1" name="admin_tags[]" id="admin_tags" multiple>   

	                                      	<?php echo $obj->getIngredientsByIngrdientType($data['sub_cat_id'],'423','70',$arr_admin_tags);?>

							               <!-- fav id,comman,page_cat_id -->

							            </select>

							            <script>

							                $('.multipleSelect1').fastselect();

							            </script>

                                    </td>

                                </tr>



								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>



                                    <?php if($data['banner_type'] =='video' )

                                    {

                                        ?>

                                    <tr>

									<td width="20%" align="right"><strong>Video</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                 <iframe width="300" height="200" src="https://www.youtube.com/embed/<?php echo $data['video_url']; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="false"></iframe>

                                                            </td>

                                                            </tr>

                                                            <tr>

                                                                  <td colspan="3" align="center">&nbsp;</td>

                                                            </tr>

                                                                    <?php

                                                                }

                                                                 ?>

                                                                <?php if($data['banner_type'] =='audio' )

                                                                {

                                                                    ?>

                                                                        <tr>

									<td width="20%" align="right"><strong>audio</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

                                                                            <audio controls>

                                                                                <source src="../uploads/<?php echo $data['image_video_audio_pdf']; ?>" type="audio/mpeg">

                                                                              </audio>

                                                                        </td>

                                                                        </tr>

                                                                        <tr>

                                                                                <td colspan="3" align="center">&nbsp;</td>

                                                                        </tr>

                                                                    <?php

                                                                }

                                                                 ?>

                                                                

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

        <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>

	<script type="text/javascript">

		tinyMCE.init({

			mode : "exact",

			theme : "advanced",

			elements : "narration,admin_comment",

			plugins : "style,advimage,advlink,emotions",

			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

		});

       </script>

</div>



<style>



	.fstQueryInput {

         font-size: 12px !important;

         }  

         .fstChoiceItem

         {

         	background-color: #505558 !important;

         	font-size: 10px !important;

         }  

         .fstMultipleMode .fstControls {

			    box-sizing: border-box;

			    padding: 0.5em 0.5em 0em 0.5em;

			    overflow: hidden;

			    width: 50em !important;

			    cursor: text;

			}



</style>
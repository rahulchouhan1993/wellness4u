<?php



require_once('config/class.mysql.php');



require_once('classes/class.feedback.php');  



$obj = new Feedback();







$view_action_id = '110';







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







if(isset($_POST['btnActive']))

{

  $active_status  = $_POST['chk_status'];

   $count = count($active_status);

   if($count > 0)

	{

		for($i=0 ; $i<$count ; $i++) 

		{ 

			$obj->ActiveFeedback($active_status[$i]);

		}

		$msg .= 'User updated successfully!';	

	}

   else

   {

   		$msg = 'Please select checkbox to active';

	}

}







if(isset($_POST['btnInactive']))



{



   $active_status1  = $_POST['chk_status'];



   $count1 = count($active_status1);



   if($count1 > 0)



	{



		for($i=0 ; $i<$count1 ; $i++) 



		{ 



			$obj->InActiveFeedback($active_status1[$i]);



		}



		 $msg .= 'User updated successfully!';



	}



   else



   {



		$msg .= 'Please select checkbox to inactive';	



	}



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



						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Feedback</td>



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



                                <?php echo $msg; ?>



                                </p>



								 <form action="#" method="post" name="frm_feedback" id="frm_feedback" enctype="multipart/form-data" >



                                    <table border="1" width="100%" cellpadding="1" cellspacing="1">



                                    <tbody>



                                        <tr>



                                            <td height="30" colspan="6">(Click on to name to view conversations)</td>



                                            <td><input type="submit" id="btnActive" name="btnActive" value="Active"/></td>



                                            <td><input type="submit" id="btnInactive" name="btnInactive" value="Inactive"/></td>



                                        </tr>



                                        <tr class="manage-header">



                                            <td class="manage-header" align="center" width="5%" nowrap="nowrap" >S.No.</td>



                                            <td class="manage-header" align="center" width="15%">Name</td>



                                            <td class="manage-header" align="center" width="10%">Unique ID</td>



                                            <td class="manage-header" align="center" width="15%">Subject</td>



                                            <td class="manage-header" align="center" width="30%">Feedback</td>



                                            <td class="manage-header" align="center" width="15%">Date</td>



                                            <td class="manage-header" align="center" width="5%">Status</td>



                                            <td width="5%" align="center" nowrap="nowrap" class="manage-header">&nbsp;</td>



                                        </tr>



                                        <?php



                                        echo $obj->GetAllPages();



                                        ?>



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
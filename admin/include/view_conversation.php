<?php



require_once('config/class.mysql.php');



require_once('classes/class.feedback.php');  



require_once('../init.php');



$obj = new Feedback();







$view_action_id = '111';







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







$err_msg = 'none';















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



		$err_msg = '';



		$msg .= 'User updated successfully!';	



	}



   else



   {



   		$err_msg = '';



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



		 $err_msg = '';



		 $msg .= 'User updated successfully!';



	}



   else



   {



		$err_msg = '';



		$msg .= 'Please select checkbox to inactive';	



	}



}







$id = $_GET['uid'];






//update by ample 17-04-20
list($page_name,$feedback,$status,$email,$name,$page_id,$user_id,$feedback_date) = $obj->getfeedback($id);







$str_feedback_id = $obj->GetAllConvarsationId($id);







list($arr_feedback_id,$arr_feedback,$arr_name,$arr_feedback_add_date,$arr_admin,$arr_status) = $obj->GetAllFeedBackByID($str_feedback_id);







?>



<script src="js/AC_ActiveX.js" type="text/javascript"></script>



<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>



<script type="text/javascript" src="js/jscolor.js"></script>



<div id="central_part_contents">



	<div id="notification_contents">



	<?php



	if($error)



	{?>



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



	}?>



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



                            <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">View Conversation</td>



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



                               



                                </p>



							<form action="#" method="post" name="frmedit_theam" id="frmedit_theam" enctype="multipart/form-data" >



							<input type="hidden" name="hdnfeedback_id" value="<?php echo $id;?>" />



                            <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">



							<tbody>



                                <tr>



                                <td align="left" colspan="4"><input type="button" name="btnSubmit" value="Back" onclick="window.location.href='index.php?mode=feedback';"/></td>



                                



                                </tr>



                                <tr>



                                    <td height="30" width="20%" align="center"><strong>Subject:</strong> <?php echo $page_name; ?></td>


                                    <td height="30" width="20%" align="center"><strong>User: </strong><?php echo $name; ?></td>


                                    <td height="30" width="40%" align="center"><strong>Feedback: </strong><?php echo $feedback; ?></td> 

                                    <td height="30" width="20%" align="center"><strong>Posted On: </strong><?php echo $feedback_date; ?></td>

                                </tr>



                                <tr>



                                	<td height="30" colspan="4" align="center"><h3><strong>Conversation</strong></h3></td>



                                </tr>



                                <tr id="err_msg" style="display:<?php echo $err_msg; ?>"><td colspan="8" align="right" height="30"> <?php echo $msg; ?></td></tr>



                               <tr>



									<td colspan="4" align="center">



                                        <table width="100%" cellpadding="0" cellspacing="0" border="1">



                                        	<tr>



                                            <td align="right" height="30" colspan="7"><input type="submit" id="btnActive" name="btnActive" value="Active"/></td>



                                            <td><input type="submit" id="btnInactive" name="btnInactive" value="Inactive"/></td>



                                            </tr>



                                        	<tr class="manage-header">



                                                <td class="manage-header" align="center" width="5%" nowrap="nowrap" >S.No.</td>



                                                <td class="manage-header" align="center" width="15%">Date</td>



                                                <td class="manage-header" align="center" width="15%">From</td>



                                                <td class="manage-header" align="center" width="5%">To</td>



                                                <td class="manage-header" align="center" width="40%">Feedback</td>



                                                <td class="manage-header" align="center" width="10%">Reply</td>



                                                <td class="manage-header" align="center" width="5%">Status</td>



                                                <td class="manage-header" align="center" width="5%">&nbsp;</td>



                                            </tr>



											<?php 



                                            for($i=0,$j=1;$i<count($arr_feedback);$i++,$j++)



                                            {



                                               // $date = date('d-M-Y h:i A',strtotime($arr_feedback_add_date[$i]));

												$time= strtotime($arr_feedback_add_date[$i]);

												$time=$time+19800;

												$date = date('d-M-Y h:i A',$time);

                                                



                                                if($arr_admin[$i] == '0')



                                                {



                                                    $to = 'Admin';



                                                    $from = $arr_name[$i];



                                                }



                                                else



                                                {



                                                    $to = 'User';



                                                    $from = 'Admin('.$arr_name[$i].')';



                                                } 



												if($arr_status[$i] == 1)



												{



													$status = 'Active';



												}	



												else



												{



													$status = 'Inactive';



												}



												



												?>



                                                <tr>



                                                    <td height="35" align="center"><?php echo $j; ?></td>



                                                    <td height="35" align="center"><?php  echo $date;?></td>



                                                    <td height="35" align="center"><?php  echo $from;?></td>



                                                    <td height="35" align="center"><?php echo $to;?></td>



                                                    <td height="35" align="center"><?php echo $arr_feedback[$i]; ?> </td>



                                                    <td height="35" align="center">



                                                    <?php 



                                                    if($arr_admin[$i] == '1' && $i==0 && $arr_status[$i]==1) 



                                                    { ?>



                                                       <!--  <a href="javascript:fn_confirmdelete('Feedback','sql/delfeedback.php?uid=<?php echo $arr_feedback_id[$i]; ?>')"><img src = "images/del.gif" border="0" ></a> -->

                                                        <input type="button" name="btnSubmit" value="Update" onclick="window.location.href='index.php?mode=update_feedback&uid=<?php echo $arr_feedback_id[$i]; ?>&pid=<?php echo $id;?>';"/>

                                                    <?php 



                                                    } 



                                                    elseif($arr_admin[$i] == '0' && $i==0 && $arr_status[$i]==1) 



                                                    { ?>



                                                        <input type="button" name="btnSubmit" value="Reply" onclick="window.location.href='index.php?mode=reply_feedback&uid=<?php echo $arr_feedback_id[$i]; ?>&pid=<?php echo $id;?>';"/>



                                                    <?php 



                                                    } ?>



                                                    </td>



                                                     <td height="35" align="center"><?php echo $status; ?></td>



                                                     <td align="center"><input type="checkbox" id="chk_status" name="chk_status[]" value="<?php echo $arr_feedback_id[$i]; ?>" /></td>



                                                </tr>



                                            <?php 



                                            } ?>



                                        </table>



                                    </td>



								</tr>



                                <tr>



                                	<td align="center" >&nbsp;</td>



									<td align="center" >&nbsp;</td>



									<td align="center" >&nbsp;</td>



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
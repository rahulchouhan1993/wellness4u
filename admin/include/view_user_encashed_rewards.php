<?php
require_once('config/class.mysql.php');
require_once('classes/class.rewardpoints.php');  
$obj = new RewardPoint();

$view_action_id = '218';

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

$start=''; $end=''; $module_id=''; $user_id;

if(isset($_POST['submit']) && !empty($_POST['submit']))
{

    $module_id=$_POST['reward_list_module_id'];

    $user_id=$_POST['user_id'];

    $start_date=$_POST['start_date'];

    $end_date=$_POST['end_date'];

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
                                            <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">User encashed Rewards</td>
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
                                 <form action="#" method="post" name="frm_library" id="frm_library" enctype="multipart/form-data" >
                                <table border="0" width="100%" cellpadding="1" cellspacing="1">
                                	<tr>
                                    	<td width="10%" align="left"><strong>Select User : </strong></td>
					 					                 <td width="20%" align="left">
                                            <select name="user_id" id="user_id">
                                                <option value="">All User</option>
                                                <?php $list=$obj->redeem_common_user_data();
                                                   if(!empty($list))
                                                   {  
                                                    
                                                    foreach ($list as $key => $value) {
                                                      $sel="";
                                                      if($value['user_id']==$user_id)
                                                      {
                                                        $sel='selected';
                                                      }
                                                      ?>
                                                       <option value="<?=$value['user_id'];?>" <?=$sel;?> > <?=$value['name']; ?></option>
                                                      <?php
                                                    }
                                                   }
                                                 ?>
                                            </select>
                                         </td>
                                        <td width="10%" align="left"><strong>Start Date : </strong></td>
                                        <td width="20%" align="left">
                                            <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:100px;" autocomplete='off'/>
                                        </td>
                                        <td width="10%" align="left"><strong>End Date : </strong></td>
                                        <td width="20%" align="left">
                                            <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:100px;" autocomplete='off'/>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                    	<td align="left"><strong>Select Modules : </strong></td>
					 					                   <td align="left">
                                            <select name="reward_list_module_id" id="reward_list_module_id">
                                                <option value="">All</option>
                                                 <?php $list=$obj->redeem_common_module_data();
                                                   if(!empty($list))
                                                   {  
                                                   
                                                    foreach ($list as $key => $value) {
                                                       $sel="";
                                                      if($value['reward_module_id']==$module_id)
                                                      {
                                                        $sel='selected';
                                                      }
                                                      ?>
                                                       <option value="<?=$value['reward_module_id'];?>" <?=$sel;?> > <?=$value['page_name']; ?></option>
                                                      <?php
                                                    }
                                                   }
                                                 ?>
                                            </select>
                                         </td>
                                        <td align="left"></td>
                                        <td align="left"></td>
                                        <td align="left"></td>
                                        <td align="left">
                                           <input type="submit" id="btnViewReferral" name="submit" value="View List" />
                                        </td>
                                       
                                    </tr>
                                 </table>
                                 <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                	<tr>
                                    	<td width="100%" align="center" height="30">&nbsp;</td>
                                      </tr>
                                 </table>       
                                 
                                    <table border="1" width="100%" cellpadding="1" cellspacing="1">



                                    <tbody>


                                        <tr class="manage-header">

                                            <td class="manage-header" align="center" nowrap="nowrap" >S.No.</td>

                                            <td class="manage-header" align="center">Name</td>

                                            <td class="manage-header" align="center">Date</td>

                                            <td class="manage-header" align="center">Credit</td>

                                            <td class="manage-header" align="center">Debit</td>

                                            <td class="manage-header" align="center">Balance</td>

                                            <td class="manage-header" align="center">Module</td>

                                            <td class="manage-header" align="center">Transaction No</td>

                                            <td class="manage-header" align="center">Type</td>

                                            <td class="manage-header" align="center">Prize/Gift</td>

                                            <td align="center" nowrap="nowrap" class="manage-header">&nbsp;</td>


                                        </tr>


                                        <?php

                                          echo $obj->GetAllUserPointHistory($module_id,$user_id,$start_date,$end_date);

                                        ?>


                                    </tbody>



                                    </table>          
								
								<p></p>
					 </form>		<!--pagination_contents-->
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

<script type="text/javascript">
    $('#start_date').datepicker({ todayHighlight: true, dateFormat : 'dd-mm-yy',autoclose: true});
    $('#end_date').datepicker({ todayHighlight: true , dateFormat : 'dd-mm-yy',autoclose: true});
</script>
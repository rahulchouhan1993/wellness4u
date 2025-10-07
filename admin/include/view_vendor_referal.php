<?php
require_once('config/class.mysql.php');
require_once('classes/class.referral.php');  
$obj = new user_referral();

$view_action_id = '388';

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


$start_date=''; $end_date='';$user_id='';$vendor_id="";$request="";$referral="";

if(isset($_POST['submit']) && !empty($_POST['submit']))
{

    $user_id=trim($_POST['user_id']);

    $vendor_id=trim($_POST['vendor_id']);

    $start_date=$_POST['start_date'];

    $end_date=$_POST['end_date'];

    $request=trim($_POST['request']);

    $referral=trim($_POST['referral']);

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
                                            <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Vendor Referral</td>
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
                                                <?php 
                                                	$list=$obj->advice_refferal_common_user_data();
                                                   if(!empty($list))
                                                   {  
                                                    foreach ($list as $key => $value) 
                                                    {
                                                      $sel="";
                                                      if($value['user_id']==$user_id)
                                                      {
                                                        $sel='selected';
                                                      }
                                                      ?>
                                                       <option value="<?=$value['user_id'];?>" <?=$sel;?> > <?=$value['name'];?> (<?=$value['unique_id'];?>)</option>
                                                      <?php
                                                    }
                                                   }
                                                ?>
                                            </select>
                                         </td>
                                         <td width="10%" align="left"><strong>Select Vendor : </strong></td>
                                         <td width="20%" align="left">
                                            <select name="vendor_id" id="vendor_id">
                                                <option value="">All Vendor</option>
                                                <?php 
                                                  $list=$obj->advice_refferal_common_vendor_data();
                                                   if(!empty($list))
                                                   {  
                                                    foreach ($list as $key => $value) 
                                                    {
                                                      $sel="";
                                                      if($value['vendor_id']==$vendor_id)
                                                      {
                                                        $sel='selected';
                                                      }
                                                      ?>
                                                       <option value="<?=$value['vendor_id'];?>" <?=$sel;?> > <?=$value['vendor_name'];?> (<?=$value['vendor_unique_id'];?>)</option>
                                                      <?php
                                                    }
                                                   }
                                                ?>
                                            </select>
                                         </td>
                                        <td width="10%" align="left"><strong>Start Date : </strong></td>
                                        <td width="20%" align="left">
                                            <input name="start_date" id="start_date" type="text" value="<?php echo $start_date;?>" style="width:100px;" autocomplete='off' />
                                        </td>
                                        <td width="10%" align="left"><strong>End Date : </strong></td>
                                        <td width="20%" align="left">
                                            <input name="end_date" id="end_date" type="text" value="<?php echo $end_date;?>" style="width:100px;" autocomplete='off'/>
                                        </td>

                                    </tr>
                                    <tr>
                                      <td width="10%" align="left"><strong>Request : </strong></td>
                                         <td width="20%" align="left">
                                            <select name="request" id="request">
                                                <option value="">All</option>
                                                <option value="0" <?=($request=='0')? 'selected' : '';?> >Pending</option>
                                                <option value="1" <?=($request=='1')? 'selected' : '';?> >Accept</option>
                                            </select>
                                         </td>
                                         <td width="10%" align="left"><strong>Referral : </strong></td>
                                         <td width="20%" align="left">
                                            <select name="referral" id="referral">
                                                <option value="">All</option>
                                                <option value="0" <?=($referral=='0')? 'selected' : '';?> >Pending</option>
                                                <option value="1" <?=($referral=='1')? 'selected' : '';?> >Accept</option>
                                            </select>
                                         </td>
                                        <td width="10%" align="left">
                                        <input type="submit" id="btnViewReferral" name="submit" value="View Referral" />
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


                                            <td class="manage-header" align="center">Refer By</td>

                                            <td class="manage-header" align="center">Refer To</td>

                                            <td class="manage-header" align="center" style="max-width: 200px;">Message</td>

                                            <td class="manage-header" align="center">Date</td>

                                            <td class="manage-header" align="center">Request</td>

                                            <td class="manage-header" align="center">Referral</td>

                                        </tr>


                                        <?php

                                          echo $obj->GetAllVendorReferal($user_id,$vendor_id,$start_date,$end_date,$request,$referral);

                                        ?>


                                    </tbody>



                                    </table>          
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

<!--add by ample 17-12-20 -->
<script type="text/javascript">
    $('#start_date').datepicker({ todayHighlight: true, dateFormat : 'dd-mm-yy',autoclose: true});
    $('#end_date').datepicker({ todayHighlight: true , dateFormat : 'dd-mm-yy',autoclose: true});
</script>
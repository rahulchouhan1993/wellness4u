<?php

require_once('config/class.mysql.php');

require_once('classes/class.rewardpoints.php');

$obj = new RewardPoint();



$view_action_id = '145';

$add_action_id = '144';



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


$search="";$module_id="";$reward_type="";$con_type="";$eqv_type="";$cut_type="";

if(isset($_POST['btnSubmit']))

{

    $search = strip_tags(trim($_POST['search']));
    $module_id = strip_tags(trim($_POST['module_id']));
    $reward_type = strip_tags(trim($_POST['reward_type']));
    $con_type = strip_tags(trim($_POST['con_type']));
    $eqv_type = strip_tags(trim($_POST['eqv_type']));
    $cut_type = strip_tags(trim($_POST['cut_type']));


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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Reward Points </td>

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

                                <form action="#" method="post" name="frm_realation" id="frm_relation" enctype="multipart/form-data" AUTOCOMPLETE="off">

                                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>
                                            </tr>
                                            <tr>
                                                <td  height="30" align="left" valign="middle"><strong>Search:</strong></td>
                                                <td  height="30" align="left" valign="middle">
                                                    <input type="text" id="search" name="search"  value="<?php echo $search; ?>" style="width:200px;" />
                                                </td>
                                                <td height="30" align="left" valign="middle">&nbsp;</td>
                                                <td height="30" align="left" valign="middle"><strong>MODULE:</strong></td>
                                                <td  height="30" align="left" valign="middle">
                                                    <select name="module_id" id="module_id" style="width:200px;">
                                                        <option value="">All</option>
                                                        <?=$obj->getRewardModuleOptions($module_id);?>
                                                    </select>
                                                </td>
                                                <td  height="30" align="left" valign="middle">&nbsp;</td>
                                                <td  height="30" align="left" valign="middle"><strong>Reward Type:</strong></td>
                                                <td  height="30" align="left" valign="middle">
                                                    <select name="reward_type" id="reward_type" style="width:200px;">
                                                        <?php echo $obj->getFavCategoryRamakant('73',$reward_type); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  height="30" align="left" valign="middle"><strong>CONVERSION:</strong></td>
                                                <td  height="30" align="left" valign="middle">
                                                    <select name="con_type" id="con_type" style="width:200px;">
                                                        <?php echo $obj->getFavCategoryRamakant('61',$con_type)?>
                                                    </select>
                                                </td>
                                                <td height="30" align="left" valign="middle">&nbsp;</td>
                                                <td  height="30" align="left" valign="middle"><strong>EQUIVALENT:</strong></td>
                                                <td  height="30" align="left" valign="middle">
                                                    <select name="eqv_type" id="eqv_type" style="width:200px;">
                                                        <?php echo $obj->getFavCategoryRamakant('61',$eqv_type)?>
                                                    </select>
                                                </td>
                                                <td  height="30" align="left" valign="middle">&nbsp;</td>
                                                <td  height="30" align="left" valign="middle"><strong>CUTTOFF:</strong></td>
                                                <td  height="30" align="left" valign="middle">
                                                    <select name="cut_type" id="cut_type" style="width:200px;">
                                                         <?php echo $obj->getFavCategoryRamakant('61',$cut_type)?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="center" height="30">
                                                    <input type="submit" name="btnSubmit" id="btnSubmit" value="Search" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </form>

                                </p>

                                <table border="1" width="100%" cellpadding="1" cellspacing="1">

                                <tbody>

                                    <tr>

                                        <!-- align="right" -->

                                        <td colspan="23" nowrap="nowrap">

                                        <?php

                                        if($obj->chkValidActionPermission($admin_id,$add_action_id))

                                        { ?>

                                            <a href="index.php?mode=add_reward_point"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>

                                        <?php

                                        }?>    

                                        </td>

                                    </tr>

                                    <tr class="manage-header">

                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">S.No.</td>

                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">Status</td>

                                        <td width="15%" align="center" nowrap="nowrap" class="manage-header">Date</td>

                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">Edit</td>

                                        <td width="5%" align="center" nowrap="nowrap" class="manage-header">Delete</td>

                                        <td class="manage-header" align="center" width="15%">Ref. Number</td>

                                        <td class="manage-header" align="center" width="15%">Module Name</td>

                                        <td class="manage-header" align="center" width="15%">Event Name</td>

                                        <td class="manage-header" align="center" width="15%">Reward Cat1</td>

                                        <td class="manage-header" align="center" width="15%">Reward Cat2</td>

                                        <td class="manage-header" align="center" width="15%">Reward </td>

                                        <td class="manage-header" align="center" width="15%">Dates</td>

                                        <td class="manage-header" align="center" width="15%">Conversion</td>

                                        <td class="manage-header" align="center" width="15%">Equivalent</td>

                                        <td class="manage-header" align="center" width="15%">Cuttoff </td>

                                        <td class="manage-header" align="center" width="15%">Identity</td>


                                    </tr>

                                    <?php

                                    echo $obj->GetAllRewardsPointList($search,$module_id,$reward_type,$con_type,$eqv_type,$cut_type);

                                    ?>

                                </tbody>

                                </table>

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
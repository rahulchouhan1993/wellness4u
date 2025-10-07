<?php
require_once('config/class.mysql.php');
require_once('classes/class.rewardpoints.php');
$obj = new RewardPoint();

$edit_action_id = '251';

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

$display_trfile = '';
$display_trtext = 'none';

$error = false;
$err_msg = "";

if(isset($_POST['btnSubmit']))
{
    $reward_bonus_id = $_POST['hdnreward_bonus_id'];  
    $reward_bonus_module_id = trim($_POST['hdnreward_bonus_module_id']);
    $reward_bonus_conversion_type_id = trim($_POST['hdnreward_bonus_conversion_type_id']);
    $reward_bonus_conversion_value = trim($_POST['hdnreward_bonus_conversion_value']);
    $reward_bonus_cutoff_type_id = trim($_POST['hdnreward_bonus_cutoff_type_id']);
    $reward_bonus_min_cutoff = trim($_POST['hdnreward_bonus_min_cutoff']);
    $reward_bonus_max_cutoff = trim($_POST['hdnreward_bonus_max_cutoff']);
    $reward_bonus_date = trim($_POST['hdnreward_bonus_date']);
    $reward_bonus_status = trim($_POST['reward_bonus_status']);
    $reward_type=trim($_POST['reward_type']);

    $admin_comment=$_POST['admin_comment'];
    $tables_names=$_POST['tables_names'];
    $columns_dropdown=$_POST['columns_dropdown'];

    $tables_names2=$_POST['tables_names2'];
    $columns_dropdown_reword=$_POST['columns_dropdown_reword'];
    $columns_dropdown_value_reword=$_POST['columns_dropdown_value_reword'];

    if($reward_bonus_id == "")
    {
        $error = true;
        $err_msg = "Please select module.";
    }
	
    if(!$error)
    {
        if($obj->updateRewardBonus($reward_bonus_id,$reward_bonus_status))
        {
            $msg = "Record Updated Successfully!";
            header('location: index.php?mode=reward_bonus&msg='.urlencode($msg));
            exit(0);
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
    $reward_bonus_id = $_GET['id'];
    list($reward_title,$reward_sub_category_2,$reward_sub_category_1,$reward_main_category_2,$reward_main_category_1,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_bonus_module_id,$reward_bonus_conversion_type_id,$reward_bonus_conversion_value,$reward_bonus_cutoff_type_id,$reward_bonus_min_cutoff,$reward_bonus_max_cutoff,$reward_bonus_status,$reward_bonus_date,$reward_type) = $obj->getRewardBonusDetails($reward_bonus_id);
    $reward_bonus_date = date('d-m-Y',strtotime($reward_bonus_date));
    $event_close_date = date('d-m-Y',strtotime($event_close_date));

  // echo "<pre>";print_R($reward_type);echo "</pre>";
   // echo $reward_type;

}	
else
{
    header('location: index.php?mode=invalid');
    exit(0);
}
?>
<script type="text/javascript" src="js/jscolor.js"></script>
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Reward Bonus Point</td>
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
                            <form action="#" method="post" name="frmedit_daily_meal" id="frmedit_daily_meal" enctype="multipart/form-data" >
                                <input type="hidden" name="hdnreward_bonus_id" id="hdnreward_bonus_id" value="<?php echo $reward_bonus_id;?>" />
                                <input type="hidden" name="hdnreward_bonus_module_id" id="hdnreward_bonus_module_id" value="<?php echo $reward_bonus_module_id;?>" />
                                <input type="hidden" name="hdnreward_bonus_conversion_type_id" id="hdnreward_bonus_conversion_type_id" value="<?php echo $reward_bonus_conversion_type_id;?>" />
                                <input type="hidden" name="hdnreward_bonus_conversion_value" id="hdnreward_bonus_conversion_value" value="<?php echo $reward_bonus_conversion_value;?>" />
                                <input type="hidden" name="hdnreward_bonus_cutoff_type_id" id="hdnreward_bonus_cutoff_type_id" value="<?php echo $reward_bonus_cutoff_type_id;?>" />
                                <input type="hidden" name="hdnreward_bonus_min_cutoff" id="hdnreward_bonus_min_cutoff" value="<?php echo $reward_bonus_min_cutoff;?>" />
                                <input type="hidden" name="hdnreward_bonus_max_cutoff" id="hdnreward_bonus_max_cutoff" value="<?php echo $reward_bonus_max_cutoff;?>" />
                                <input type="hidden" name="hdnreward_bonus_date" id="hdnreward_bonus_date" value="<?php echo $reward_bonus_date;?>" />
                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Identity Type</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><?php echo $identity_type; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>

                                    
                                <tr>
                                     <td width="20%" align="right"><strong>Admin Notes</strong></td>
                                     <td width="5%" align="center"><strong>:</strong></td>
                                     <td width="75%" align="left"><textarea name="admin_comment" type="text" id="admin_comment" value="<?php //echo $admin_comment;?>"  style="width:400px; height: 200px;" ></textarea>
                                    </td>
                                </tr>
                               <tr>
                                  <td colspan="3" align="center">&nbsp;</td>
                                </tr>

                                    <tr>
                                        <td align="right"><strong>Identity ID</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><?php echo $identity_id; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Reference Number</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><?php echo $reference_number; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>

                                      <tr>
                                        <td width="20%" align="right"><strong>Reward type</strong></td>
                                        <td width="5%" align="center"><strong>:</strong></td>
                                           <td width="75%" align="left">
                                               <select name="reward_type" id="reward_type" style="width:200px;">
                                                    <option value="<?php echo $reward_type[0];?>"><?php echo $reward_type[1];?></option>
                                                    <!-- echo $reward_type; -->
                                                    <?php echo $obj->getFavCategoryRamakant('73',''); ?>
                                                </select> 
                                            </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>




                                    <tr>
                                        <td width="20%" align="right"><strong>Module Name</strong></td>
                                        <td width="5%" align="center"><strong>:</strong></td>
                                        <td width="75%" align="left"><strong><?php echo $obj->getRewardModuleTitle($reward_bonus_module_id); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td width="20%" align="right"><strong>Tables</strong></td>
                                        <td width="5%" align="center"><strong>:</strong></td>
                                        <td align="left" align="top">
                                         <?php echo $obj->getTableNameOptions_dropdown_kr1(0,'','disabled');?>

                                            <select id="columns_dropdown0" style="width:100px;" name="columns_dropdown" onchange="sub_selectTable(0);">
                                            <option value="">-Select-</option>
                                            </select>

                                           
                                              <select  class="" id="tables_names2_0" name="tables_names2" style="width:150px; display: none;" onchange="Selectable2_(0);">
                                                  <option value="">-Select-</option>
                                              </select>


                                              <select id="columns_dropdown_reword0" style="width:100px; display: none;" name="columns_dropdown_reword">
                                              </select>

                                              <select id="columns_dropdown_value_reword0" style="width:100px; display: none;" name="columns_dropdown_value_reword">
                                             </select>
                                         </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>



                                    <tr>
                                        <td width="20%" align="right"><strong>Event Details</strong></td>
                                        <td width="5%" align="center"><strong>:</strong></td>
                                        <td width="75%" align="left">
                                           <?php echo $obj->getEventdatashow($event_id); ?>
                                   	</td>
                                    </tr>
                                     <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>

                                    
                                    <tr>
                                        <td align="right"><strong>Reward Main Category 1</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <?php echo $obj->getprofcatname($reward_main_category_1); ?>
                                   	</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Reward Sub Category 1</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                           <?php echo $obj->getFavCategoryNameVivek($reward_sub_category_1); ?>
                                   	</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Reward Main Category 2</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                          <?php echo $obj->getprofcatname($reward_main_category_2); ?>
                                   	</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Reward Sub Category 2</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                           <?php echo $obj->getFavCategoryNameVivek($reward_sub_category_2); ?>
                                   	</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right"><strong>Reward Title/Remarks</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                            <?php echo $reward_title; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Conversion Type</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><strong><?php echo $obj->getpfavcatname($reward_bonus_conversion_type_id); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Conversion Value</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><strong><?php echo $reward_bonus_conversion_value; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Cutoff Type</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><strong><?php echo $obj->getpfavcatname($reward_bonus_cutoff_type_id); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Minimum Cutoff</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><strong><?php echo $reward_bonus_min_cutoff; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Maximum Cutoff</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><strong><?php echo $reward_bonus_max_cutoff; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Effective Date</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><strong><?php echo $reward_bonus_date;?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="right"><strong>Closing Date</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left"><strong><?php echo $event_close_date;?></strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="right"><strong>Status</strong></td>
                                        <td align="center"><strong>:</strong></td>
                                        <td align="left">
                                                <select id="reward_bonus_status" name="reward_bonus_status" style="width:200px;">
                                                        <option value="0" <?php if($reward_bonus_status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                        <option value="1" <?php if($reward_bonus_status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                                </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left">
                                            <input type="Submit" name="btnSubmit" value="Submit" />&nbsp;
                                            <input type="button" name="btnCancel" id="btnCancel" value="Cancel" onclick="window.location.href='index.php?mode=reward_bonus'" >
                                        </td>
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

<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript">
        tinyMCE.init({
            mode : "exact",
            theme : "advanced",
            elements : "comment,admin_comment",
            plugins : "style,advimage,advlink,emotions",
            theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",
            theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",
        });
    </script>
    <script>
function Selectable(get)
{   
    var table_name=$('#tables_names'+get).val();   
    var dataString = 'action=getTableColumnsNameKR&tablm_name='+table_name+'&get='+get;
      $.ajax({
        type: "POST",
        url: "include/remote.php",
        dataType:'JSON',
        data: dataString,
        cache: false,
        success: function(result)
        {
         $('#columns_dropdown'+get).html(result);
         $('#columns_dropdown_value'+get).html(result);
        }
      });

}

function sub_selectTable(get)
{
    var columns_dropdown0=$('#columns_dropdown0'+get).val(); 

    var dataString = 'action=getTableColumnsNameKR_new_field&columns_dropdown0='+columns_dropdown0+'&get='+get;
      $.ajax({
        type: "POST",
        url: "include/remote.php",
        dataType:'JSON',
        data: dataString,
        cache: false,
        success: function(result)
        {

         $('#tables_names2_'+get).html(result);
        $('#tables_names2_'+get).show();

         // $('#columns_dropdown_value'+get).html(result);
        }
      });
}


function Selectable2_(get)
{   
    var table_name=$('#tables_names2_'+get).val();   
    var dataString = 'action=getTableColumnsNameKR&tablm_name='+table_name+'&get='+get;
      $.ajax({
        type: "POST",
        url: "include/remote.php",
        dataType:'JSON',
        data: dataString,
        cache: false,
        success: function(result)
        {
         $('#columns_dropdown_reword'+get).html(result);
         $('#columns_dropdown_value_reword'+get).html(result);
         $('#columns_dropdown_reword'+get).show();
         $('#columns_dropdown_value_reword'+get).show();
        }
      });

}
    </script>
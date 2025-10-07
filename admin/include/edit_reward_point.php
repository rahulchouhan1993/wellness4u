<?php

require_once('config/class.mysql.php');

require_once('classes/class.rewardpoints.php');

$obj = new RewardPoint();



$edit_action_id = '252';



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

    $reward_point_id = $_POST['hdnreward_point_id'];  

    $reward_point_module_id = trim($_POST['hdnreward_point_module_id']);

    $reward_point_conversion_type_id = trim($_POST['hdnreward_point_conversion_type_id']);

    $reward_point_conversion_value = trim($_POST['hdnreward_point_conversion_value']);

    $reward_point_cutoff_type_id = trim($_POST['hdnreward_point_cutoff_type_id']);

    $reward_point_min_cutoff = trim($_POST['hdnreward_point_min_cutoff']);

    $reward_point_max_cutoff = trim($_POST['hdnreward_point_max_cutoff']);

    $reward_point_date = trim($_POST['hdnreward_point_date']);

    $reward_point_status = trim($_POST['reward_point_status']);

    $reward_type=trim($_POST['reward_type']);

    $event_close_date= trim($_POST['event_close_date']);

    $admin_comment=$_POST['admin_comment'];

    $tables_names=$_POST['tables_names'];

    $columns_dropdown=$_POST['columns_dropdown'];



    $tables_names2=$_POST['tables_names2'];

    $columns_dropdown_reword=$_POST['columns_dropdown_reword'];

    $columns_dropdown_value_reword=$_POST['columns_dropdown_value_reword'];

    $reward_close_date=trim($_POST['reward_close_date']);


    if($reward_close_date<$event_close_date)
    {
        $error = true;

        $err_msg = "New close date are less then by old date!";
    }
    else
    {
        $event_close_date=$reward_close_date;
    }

    

    if($reward_point_id == "")

    {

        $error = true;

        $err_msg = "Please select module.";

    }

	

    if(!$error)

    {
        //update by ample 01-09-20
        if($obj->updateRewardPoint($reward_point_id,$reward_point_status,$reward_type,$admin_comment,$event_close_date))

        {   
             if(!empty($_POST['event_close_date']))
            {
                $close_date=date('Y-m-d',strtotime($_POST['event_close_date']));
            }
            else
            {
                $close_date='0000-00-00';        
            }
            //added by ample 12-12-20
            $update_data=array(
                        'reward_id'=>$reward_point_id,
                        'reward_type'=>'reward_point',
                        'close_date'=>$close_date,
                    );
            $obj->update_reward_close_history($update_data);

            $msg = "Record Updated Successfully!";

            header('location: index.php?mode=reward_points&msg='.urlencode($msg));

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

    $reward_point_id = $_GET['id'];

    list($reward_title,$reward_sub_category_2,$reward_sub_category_1,$reward_main_category_2,$reward_main_category_1,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_point_module_id,$reward_point_conversion_type_id,$reward_point_conversion_value,$reward_point_cutoff_type_id,$reward_point_min_cutoff,$reward_point_max_cutoff,$reward_point_status,$reward_point_date,$reward_type,$tables_select,$columns_id,$tables_select2,$columns_id2,$columns_value2,$admin_comment,$equivalent_type,$equivalent_value) = $obj->getRewardPointDetails($reward_point_id);


    $history_data=$obj->get_reward_close_history('reward_point',$reward_point_id); //added by ample 12-12-20

    $reward_point_date = date('d-m-Y',strtotime($reward_point_date));

    if($event_close_date!='0000-00-00')
    {
        $event_close_date = date('d-m-Y',strtotime($event_close_date));
    }
    else
    {
        $event_close_date="";
    }
    



// echo "<pre>";print_r($reward_type[]);echo "</pre>";



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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Reward Point</td>

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

                                <input type="hidden" name="hdnreward_point_id" id="hdnreward_point_id" value="<?php echo $reward_point_id;?>" />

                                <input type="hidden" name="hdnreward_point_module_id" id="hdnreward_point_module_id" value="<?php echo $reward_point_module_id;?>" />

                                <input type="hidden" name="hdnreward_point_conversion_type_id" id="hdnreward_point_conversion_type_id" value="<?php echo $reward_point_conversion_type_id;?>" />

                                <input type="hidden" name="hdnreward_point_conversion_value" id="hdnreward_point_conversion_value" value="<?php echo $reward_point_conversion_value;?>" />

                                <input type="hidden" name="hdnreward_point_cutoff_type_id" id="hdnreward_point_cutoff_type_id" value="<?php echo $reward_point_cutoff_type_id;?>" />

                                <input type="hidden" name="hdnreward_point_min_cutoff" id="hdnreward_point_min_cutoff" value="<?php echo $reward_point_min_cutoff;?>" />

                                <input type="hidden" name="hdnreward_point_max_cutoff" id="hdnreward_point_max_cutoff" value="<?php echo $reward_point_max_cutoff;?>" />

                                <input type="hidden" name="hdnreward_point_date" id="hdnreward_point_date" value="<?php echo $reward_point_date;?>" />

                                <input type="hidden" name="event_close_date" id="event_close_date" value="<?php echo $event_close_date;?>" />

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

                                     <td width="75%" align="left"><textarea name="admin_comment" type="text" id="admin_comment" value="<?php //echo $admin_comment;?>"  style="width:400px; height: 200px;" ><?php echo $admin_comment;?></textarea>

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

                                               <select style="width:200px;" disabled="">

                                                <option value="<?php echo $reward_type[0];?>"><?php echo $reward_type[1];?></option>

                                                    <!-- echo $reward_type; -->

                                                    <?php echo $obj->getFavCategoryRamakant('73',''); ?>

                                                </select> 
                                            <input type="hidden" name="reward_type" id="reward_type" value="<?php echo $reward_type[0];?>">

                                    </td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>





                                    <tr>

                                        <td width="20%" align="right"><strong>Module Name</strong></td>

                                        <td width="5%" align="center"><strong>:</strong></td>

                                        <td width="75%" align="left"><strong><?php echo $obj->getRewardModuleTitle($reward_point_module_id); ?></strong></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>





                                   <tr>

                                        <td width="20%" align="right"><strong>Tables</strong></td>

                                        <td width="5%" align="center"><strong>:</strong></td>

                                        <td align="left" align="top">

                                         <?php echo $obj->getTableNameOptions_dropdown_kr1(0,$tables_select,'disabled');?>

                                            <select id="columns_dropdown0" style="width:125px;" name="columns_dropdown" onchange="sub_selectTable(0);" disabled>

                                            <option value="<?php echo $columns_id;?>"><?php echo $columns_id;?></option>  

                                            

                                            </select>

                                              <select  class="" id="tables_names2_0" name="tables_names2" style="width:125px;" onchange="Selectable2_(0);" disabled>

                                                 <option value="<?php echo $tables_select2;?>"><?php echo $tables_select2;?></option>  


                                              </select>

                                              <select id="columns_dropdown_reword0" style="width:125px;" name="columns_dropdown_reword" disabled>

                                                 <option value="<?php echo $columns_id2;?>"><?php echo $columns_id2;?></option> 

                                              </select>

                                              <!-- comment by ample 07-11-19  --> <!-- uncomment by ample 20-08-20  -->
                                              <select id="columns_dropdown_value_reword0" style="width:100px;" name="columns_dropdown_value_reword" disabled>

                                                <option value="<?php echo $columns_value2;?>"><?php echo $columns_value2;?></option> 

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

                                        <td align="left"><strong><?php echo $obj->getpfavcatname($reward_point_conversion_type_id); ?></strong></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Conversion Value</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><strong><?php echo $reward_point_conversion_value; ?></strong></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>  Equivalent Type</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><strong><?php echo $obj->getpfavcatname($equivalent_type); ?></strong></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>  Equivalent Value</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><strong><?php echo $equivalent_value; ?></strong></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Cutoff Type</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <strong>

                                            <?php 

                                            if($reward_point_cutoff_type_id == '0')

                                            {

                                                $reward_point_cutoff_title = 'None';

                                            }

                                            else

                                            {

                                                $reward_point_cutoff_title = $obj->getpfavcatname($reward_point_cutoff_type_id);

                                            }

                                            echo $reward_point_cutoff_title; 

                                            ?>

                                            </strong>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Minimum Cutoff</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><strong><?php echo $reward_point_min_cutoff; ?></strong></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Maximum Cutoff</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><strong><?php echo $reward_point_max_cutoff; ?></strong></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Effective Date</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><strong><?php echo $reward_point_date;?></strong></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Closing Date</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                         <td align="left"><strong>
                                            <input name="reward_close_date" id="reward_close_date" type="text" value="<?php echo $event_close_date;?>" style="width:200px;" autocomplete="off" />

                                            <script>$('#reward_close_date').datepicker({startDate: '-0d' , dateFormat : 'dd-mm-yy'}); </script>
                                        </strong>

                                        <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#historyModal">Date Hostory</button>

                                    </td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Status</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                                <select id="reward_point_status" name="reward_point_status" style="width:200px;">

                                                        <option value="0" <?php if($reward_point_status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

                                                        <option value="1" <?php if($reward_point_status == '1') { ?> selected="selected" <?php } ?>>Active</option>

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

                                            <input type="button" name="btnCancel" id="btnCancel" value="Cancel" onclick="window.location.href='index.php?mode=reward_points'" >

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

    <!-- Modal add by ample 20-11-19 -->
<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Date History</h4>
      </div>
      <div class="modal-body">
        
             <table class="table table-condensed table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Last close Date</th>
                    <th>Changes On</th>
                    <th>Admin Name</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if(!empty($history_data))
                    {
                        foreach ($history_data as $key => $value) {
                            if($value['close_date']!='0000-00-00')
                                {
                                    $close_date = date('d-m-Y',strtotime($value['close_date']));
                                }
                                else
                                {
                                    $close_date="N/A";
                                }
                            ?>
                            <tr>
                                <td><?=$key+1;?></td>
                                <td><?=$close_date;?></td>
                                <td><?=date('d-m-Y H:i:s',strtotime($value['entry_date']));?></td>
                                <td><?=$obj->getAdminName($value['admin_id']);?></td>
                              </tr>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                        <tr><td colspan="4" class="text-center">No history found!</td></tr>
                        <?php
                    }
                  ?>
                </tbody>
  </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

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
         // comment by ample 07-11-19
         // $('#columns_dropdown_value_reword'+get).html(result);

         $('#columns_dropdown_reword'+get).show();
         // comment by ample 07-11-19
         // $('#columns_dropdown_value_reword'+get).show();

        }

      });



}



    </script>
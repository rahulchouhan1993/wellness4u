<?php

require_once('config/class.mysql.php');

require_once('classes/class.rewardpoints.php');

$obj = new RewardPoint();

$add_action_id = '144';

//Add by ample 07-11-19
require_once('classes/class.contents.php'); 
$obj2 = new Contents();

if(!$obj->isAdminLoggedIn())

{

    header("Location: index.php?mode=login");

    exit(0);

}



if(!$obj->chkValidActionPermission($admin_id,$add_action_id))

{	

    header("Location: index.php?mode=invalid");

    exit(0);

}



$error = false;

$err_msg = "";

if(isset($_POST['btnSubmit']))

{

    $reward_bonus_module_id = $_POST['reward_bonus_module_id'];

    $reward_bonus_conversion_type_id = trim($_POST['reward_bonus_conversion_type_id']);

    $reward_bonus_conversion_value = trim($_POST['reward_bonus_conversion_value']);

    $reward_bonus_cutoff_type_id = trim($_POST['reward_bonus_cutoff_type_id']);

    $reward_bonus_min_cutoff = trim($_POST['reward_bonus_min_cutoff']);

    $reward_bonus_max_cutoff = trim($_POST['reward_bonus_max_cutoff']);

    $reward_bonus_date = trim($_POST['reward_bonus_date']);

    $event_id=trim($_POST['event_id']);

    $identity_type=trim($_POST['identity_type']);

    $identity_id=trim($_POST['identity_id']);

    $reference_number=trim($_POST['ref_number']);

    $event_close_date=trim($_POST['reward_point_close_date']);

    

    $fav_cat_type_id_1 =$_POST['fav_cat_type_id_1'];

    $fav_cat_type_id_2 =$_POST['fav_cat_type_id_2'];

    $fav_cat_id_1 =$_POST['fav_cat_id_1'];

    $fav_cat_id_2 =$_POST['fav_cat_id_2'];

    $reward_title_remark =trim($_POST['reward_title_remark']);

    $reward_type=$_POST['reward_type'];



    $admin_comment=$_POST['admin_comment'];

    $tables_names=$_POST['tables_names'];

    $columns_dropdown=$_POST['columns_dropdown'];



    $tables_names2=$_POST['tables_names2'];

    $columns_dropdown_reword=$_POST['columns_dropdown_reword'];

    $columns_dropdown_value_reword=$_POST['columns_dropdown_value_reword'];

    //add by ample 05-11-20
    $equivalent_type = trim($_POST['equivalent_type']);
    $equivalent_value = trim($_POST['equivalent_value']);


    //chnage by ample 

    if(empty($reward_bonus_module_id))

    {

        $error = true;

        $err_msg = "Please select module.";

    }


     if(empty($reward_type))

    {

        $error = true;

        $err_msg = "Please select reward type.";

    }




    if($reward_bonus_conversion_type_id == "")

    {

        $error = true;

        $err_msg .= "<br>Please select conversion type.";

    }



    if($reward_bonus_conversion_value == "")

    {

        $error = true;

        $err_msg .= "<br>Please enter conversion value.";

    }



    if($reward_bonus_cutoff_type_id == "")

    {

        $error = true;

        $err_msg .= "<br>Please select cutoff type.";

    }

	

    if($reward_bonus_cutoff_type_id != "0")

    {

        if($reward_bonus_min_cutoff == "")

        {

            $error = true;

            $err_msg .= "<br>Please enter minimum cutoff.";

        }

        elseif(!is_numeric($reward_bonus_min_cutoff))

        {

            $error = true;

            $err_msg .= "<br>Invalid no of minimum cutoff.";

        }

    }



    if($reward_bonus_date == "")

    {

        $error = true;

        $err_msg .= "<br>Please enter effective date.";

    }


    //add by ample 
    if(!empty($event_close_date))
    { 
      if($event_close_date<$reward_bonus_date)
      {

            $error = true;
            $err_msg = "Please check reward close date.";

      }
    }

   //add by ample 01-09-20
if(!empty($reward_bonus_max_cutoff))
{

  if($reward_bonus_max_cutoff<$reward_bonus_min_cutoff)
  {

        $error = true;
        $err_msg = "Maximum Cutoff not less then Minimum Cutoff, please check it.";

  }
}



    if(!$error)

    {   
        //added by ample 12-10-20
        if($reward_bonus_cutoff_type_id==451)
        {
            $reward_bonus_min_cutoff=0;
            $reward_bonus_max_cutoff=0;
        }


        if($obj->AddRewardBonus($reward_title_remark,$fav_cat_id_2,$fav_cat_id_1,$fav_cat_type_id_2,$fav_cat_type_id_1,$reward_bonus_module_id,$reward_bonus_conversion_type_id,$reward_bonus_conversion_value,$reward_bonus_cutoff_type_id,$reward_bonus_min_cutoff,$reward_bonus_max_cutoff,$reward_bonus_date,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_type,$admin_comment,$tables_names,$columns_dropdown,$tables_names2,$columns_dropdown_reword,$columns_dropdown_value_reword,$equivalent_type,$equivalent_value))

        {

            $err_msg = "Reward bonus settings added successfully!";

            header('location: index.php?mode=reward_bonus&msg='.urlencode($err_msg));

            exit(0);

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

    $reward_bonus_module_id = '';

    $reward_bonus_conversion_type_id = '';

    $reward_bonus_conversion_value = '';

    $reward_bonus_cutoff_type_id = '';

    $reward_bonus_min_cutoff = '';

    $reward_bonus_max_cutoff = '';

    $reward_bonus_date = date('d-m-Y');

}	

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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Reward Bonus Point</td>

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

                            <form action="#" method="post" name="frmadd_contents" id="frmadd_contents" enctype="multipart/form-data" >

                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">

                                <tbody>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Identity Type</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><input name="identity_type" type="text" id="identity_type" readonly="" value="Admin" style="width:200px;" ></td>

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

                                        <td align="left"><input name="identity_id" type="text" id="identity_id" readonly="" value="<?php echo $admin_id; ?>" style="width:200px;" ></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Reference Number</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><input name="ref_number" type="text" id="ref_number" value="<?php echo $ref_number; ?>" style="width:400px;" ></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>





                                     <tr>

                                        <td width="20%" align="right"><strong>Reward type</strong></td>

                                        <td width="5%" align="center"><strong>:</strong></td>

                                        <td width="75%" align="left">

                                            <!-- <select name="reward_type[]" id="reward_type" style="width:200px;" multiple>

                                                <?php echo $obj->getFavCategoryRamakant('73',''); ?>

                                            </select>   -->

                                            <!--  add by ample 20-8-20-->
                                            <?php echo $obj->getFevCategoryCheckbox('73',$reward_type,'reward_type'); ?>

                                    </td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>



                                    <tr>

                                        <td width="20%" align="right"><strong>Module Name</strong></td>

                                        <td width="5%" align="center"><strong>:</strong></td>

                                        <td width="75%" align="left">

                                            <!-- <select id="reward_bonus_module_id" name="reward_bonus_module_id[]" style="width:400px;" multiple>

                                                <option value="">Select Module </option>

                                                <?php echo $obj->getRewardModuleOptions($reward_bonus_module_id); ?>

                                            </select> -->

                                            <!-- add by ample 20-08-20-->
                                            <?php echo $obj->getRewardModuleCheckbox($reward_bonus_module_id,'reward_bonus_module_id'); ?>

                                        </td>

                                    </tr>





                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                  

                                  <tr>

                                        <td width="20%" align="right"><strong>Tables</strong></td>

                                        <td width="5%" align="center"><strong>:</strong></td>

                                         <td align="left" align="top">

                                         <?php 

                                         //$table_all= $obj->getTableNameOptions_dropdown_kr1(0,'','');
                                          //Add this function by ample 07-11-19
                                         $tables=$obj2->getTableNameFrom_tbltabldropdown('4');
                                            
                                         ?>
                                         <!--added by ample 07-11-19 -->
                                         <select class="" id="tables_names0" name="tables_names" style="width:125px;" onchange="Selectable(0);">
                                             
                                             <?php echo $tables; ?>

                                         </select>

                                            <select id="columns_dropdown0" style="width:125px;" name="columns_dropdown" onchange="sub_selectTable(0);">
                                                     <option value="">Select</option>
                                            </select>

                                              <select  class="" id="tables_names2_0" name="tables_names2" style="width:125px; display: none;" onchange="Selectable2_(0);">

                                                  <option value="">Select</option>

                                              </select>

                                              <select id="columns_dropdown_reword0" style="width:125px; display: none;" name="columns_dropdown_reword">
                                                 <option value="">Select</option>
                                              </select>

                                              <!-- comment by ample 07-11-19--> <!-- uncomment by ample 20-8-20-->
                                              <select id="columns_dropdown_value_reword0" style="width:100px; display: none;" name="columns_dropdown_value_reword">

                                             </select>

                                         </td>

                                    </tr>



                                    



                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td width="20%" align="right"><strong>Event Name</strong></td>

                                        <td width="5%" align="center"><strong>:</strong></td>

                                        <td width="75%" align="left">

                                            <select id="event_id" name="event_id" style="width:400px;" onchange="ShowData();">

                                                <option value="">Select Event</option>

                                                <?php echo $obj->getEventOptions($event_id); ?>

                                            </select>

                                            

                                   	</td>

                                    </tr>

                                     <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td colspan="6" align="center" id="show_data"></td>

                                    </tr>

                                   





                                   

                                    

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Reward Main Category 1</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <select name="fav_cat_type_id_1" id="fav_cat_type_id_1" style="width:200px;" onchange="getMainCategoryOptionAddMore()">

                                                    <!-- <option value="">All Type</option> -->

                                                <?php echo $obj->getRewardMaincat(423,34,'','prof1'); ?> 

                                                    <?php //echo $obj->getFavCategoryTypeOptions($fav_cat_type_id_1); //34 ?>

                                                </select>

                                   	</td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Reward Sub Category 1</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <select name="fav_cat_id_1" id="fav_cat_id_1" style="width:200px;">

                                                    <option value="">All Type</option>

                                                    <?php echo $obj->getFavCategoryRamakant($fav_cat_type_id_1,$fav_cat_id_1)?>

                                                </select>

                                   	</td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Reward Main Category 2</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <select name="fav_cat_type_id_2" id="fav_cat_type_id_2" style="width:200px;" onchange="getMainCategoryOptionAddMore1()">

                                                    <!-- <option value="">All Type</option> -->

                                                    <?php //echo $obj->getFavCategoryTypeOptions($fav_cat_type_id_2)?>



                                                     <?php echo $obj->getRewardMaincat(423,34,'','prof2'); ?> 

                                                </select>

                                   	</td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Reward Sub Category 2</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <select name="fav_cat_id_2" id="fav_cat_id_2" style="width:200px;">

                                                    <option value="">All Type</option>

                                                    <?php echo $obj->getFavCategoryRamakant($fav_cat_type_id_2,$fav_cat_id_2)?>

                                                </select>

                                   	</td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    

                                    <tr>

                                        <td align="right"><strong>Reward Title/Remarks</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><input name="reward_title_remark" type="text" id="reward_title_remark" value="<?php echo $reward_title_remark; ?>" style="width:400px;" ></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Conversion Type</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <select id="reward_bonus_conversion_type_id" name="reward_bonus_conversion_type_id" style="width:400px;">

                                                 <?php echo $obj->getFavCategoryRamakant('61',$fav_cat_id)?>

                                            </select>

                                   	</td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Conversion Value</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><input name="reward_bonus_conversion_value" type="number" id="reward_bonus_conversion_value" value="<?php echo $reward_bonus_conversion_value; ?>" style="width:400px;" ></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Equivalent Type</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                                                <select id="equivalent_type" name="equivalent_type" style="width:400px;">

                                                                    <?php echo $obj->getFavCategoryRamakant('61',$equivalent_type)?>

                                                                </select>

                                                                </td>

                                        </tr>

                                        <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                        </tr>

                                        <tr>

                                        <td align="right"><strong>Equivalent Value</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><input name="equivalent_value" type="number" id="equivalent_value" value="<?php echo $equivalent_value; ?>" style="width:400px;" ></td>

                                        </tr>

                                        <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                        </tr>

                                    <tr>

                                        <td align="right"><strong>Cutoff Type</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <select id="reward_bonus_cutoff_type_id" name="reward_bonus_cutoff_type_id" style="width:400px;">

                                                 <?php echo $obj->getFavCategoryRamakant('61',$fav_cat_id)?>

                                            </select>

                                   	</td>

                                    </tr>

                                    <tr>

                                            <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Minimum Cutoff</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><input name="reward_bonus_min_cutoff" type="number" id="reward_bonus_min_cutoff" value="<?php echo $reward_bonus_min_cutoff; ?>" style="width:400px;" ></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Maximum Cutoff</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><input name="reward_bonus_max_cutoff" type="number" id="reward_bonus_max_cutoff" value="<?php echo $reward_bonus_max_cutoff; ?>" style="width:400px;" ></td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Effective Date</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <input name="reward_bonus_date" id="reward_bonus_date" type="text" value="<?php echo $reward_bonus_date;?>" style="width:200px;" autocomplete="off" />

                                            <script>$('#reward_bonus_date').datepicker({ startDate: '-0d' , dateFormat : 'dd-mm-yy'}); </script>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right"><strong>Close Date</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <input name="reward_point_close_date" id="reward_point_close_date" type="text" value="<?php echo $reward_point_close_date;?>" style="width:200px;" autocomplete="off" />

                                            <script>$('#reward_point_close_date').datepicker({ startDate: '-0d' , dateFormat : 'dd-mm-yy'}); </script>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>

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

    function ShowData()

    {

        var event_id = $("#event_id").val();

	var dataString = 'action=show_event_data_bonus&event_id='+event_id;

	$.ajax({

		type: "POST",

		url: "include/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

                        //alert(result);

                        var JSONObject = JSON.parse(result);

                        //var rslt=JSONObject[0]['status'];

			//alert(result);

                        //alert(sub_cat);

			$("#show_data").html(JSONObject[0]['show_data']);

                        $("#fav_cat_type_id_1").html(JSONObject[0]['fav_cat_type_id_1']);

                        $("#fav_cat_type_id_2").html(JSONObject[0]['fav_cat_type_id_2']);

		}

	});

    }

</script>

<script>

    function getMainCategoryOptionAddMore()

    {



            var parent_cat_id = $("#fav_cat_type_id_1").val();

            //var sub_cat = $("#fav_cat_id_"+idval).val();

            //alert(parent_cat_id);

            var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id;

            $.ajax({

                    type: "POST",

                    url: "include/remote.php",

                    data: dataString,

                    cache: false,

                    success: function(result)

                    {

                            //alert(result);

                            //alert(sub_cat);

                            $("#fav_cat_id_1").html(result);

                    }

            });

    }

    

    function getMainCategoryOptionAddMore1()

    {



            var parent_cat_id = $("#fav_cat_type_id_2").val();

            //var sub_cat = $("#fav_cat_id_"+idval).val();

            //alert(parent_cat_id);

            var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id;

            $.ajax({

                    type: "POST",

                    url: "include/remote.php",

                    data: dataString,

                    cache: false,

                    success: function(result)

                    {

                            //alert(result);

                            //alert(sub_cat);

                            $("#fav_cat_id_2").html(result);

                    }

            });

    }







function Selectable(get)

{   

    var table_name=$('#tables_names'+get).val();   

    var dataString = 'action=getTableColumnsNameKR&tablm_name='+table_name+'&get='+get;

      $.ajax({

        type: "POST",

        url: "include/remote.php",

        // dataType:'JSON',

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

        // dataType:'JSON',

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

        // dataType:'JSON',

        data: dataString,

        cache: false,

        success: function(result)

        {

         $('#columns_dropdown_reword'+get).html(result);

         //comment by ample 07-11-19  //uncomment by ample 20-08-20
         $('#columns_dropdown_value_reword'+get).html(result);

         $('#columns_dropdown_reword'+get).show();
         //comment by ample 07-11-19 //uncomment by ample 20-08-20
         $('#columns_dropdown_value_reword'+get).show();

        }

      });



}



</script>
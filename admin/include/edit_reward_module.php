<?php

require_once('config/class.mysql.php');

require_once('classes/class.rewardpoints.php');

$obj = new RewardPoint();


$edit_action_id = '141';


//Add by ample 06-11-20
require_once('classes/class.contents.php'); 
$obj2 = new Contents();



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

$reward_module_title="";
$table_link="";


//update by ample 17-08-20
if(isset($_POST['btnSubmit']))

{

$reward_module_id = $_POST['hdnreward_module_id'];

$reward_module_title = trim($_POST['reward_module_title']);

$reward_module_status = trim($_POST['reward_module_status']);

// $page_id = trim($_POST['page_id']);

$page_id = trim($_GET['page_id']);

$table_link = trim($_POST['table_link']);
$table_column = trim($_POST['table_column']);

$column1 = trim($_POST['column1']);
$column2 = trim($_POST['column2']);
$value1 = trim($_POST['value1']);
$value2 = trim($_POST['value2']);

// if($reward_module_title == "")

// {

// $error = true;

// $err_msg = "Please enter module name.";

// }

// elseif($obj->chkIfRewardModuleAlreadyExists_edit($reward_module_title,$reward_module_id))

// {

// //$error = true;

// //$err_msg = "This module already exists.";

// }



if(!$error)

{   

    $reward_module_title = $obj->getMenuTitleOfPage($page_id);

    //update by ample 17-08-20
    if($reward_module_id)
    {
        $result=$obj->UpdateRewardModule($reward_module_title,$reward_module_status,$reward_module_id,$page_id,$table_link,$table_column,$column1,$column2,$value1,$value2,$admin_id);
    }
    else
    {
         $result=$obj->AddRewardModule($reward_module_title,$table_link,$table_column,$column1,$column2,$value1,$value2,$page_id,$admin_id);
    }

if($result)

{

$err_msg = "Module Update Successfully!";

header('location: index.php?mode=reward_modules&msg='.urlencode($err_msg));

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

$reward_module_id = $_GET['id'];

list($reward_module_title,$reward_module_status,$reward_page_id,$table_link,$table_column,$column1,$column2,$value1,$value2) = $obj->getRewardModuleDetails($reward_module_id);

$reward_module_title = $obj->getMenuTitleOfPage($reward_page_id);

    if(empty($reward_page_id))
    {
        $reward_page_id=$_GET['page_id'];
    }

}

else

{

header('location: index.php?mode=reward_modules');

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

<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Reward Module </td>

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

<input type="hidden" name="hdnreward_module_id" value="<?php echo $reward_module_id;?>" />

<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">

<tbody>

<tr>

<td colspan="3" align="center">&nbsp;</td>

</tr>

            <tr>

                <td width="30%" align="right" valign="top"><strong>Module Name/Page Name</strong></td>

                <td width="5%" align="center" valign="top"><strong>:</strong></td>

                <td width="65%" align="left" valign="top">

                    <select name="page_id" id="page_id" style="width:200px; height: 24px;" required="" onchange="getText(this)" disabled>

                        <option value="">Select Page Name</option>

                        <?php echo $obj->getDatadropdownPage('8',$reward_page_id);?>

                    </select>

                    <input type="hidden" name="reward_module_title" id="reward_module_title" value="<?php echo $reward_module_title; ?>">

                </td>

            </tr>


             <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                     <tr>

                                        <td width="20%" align="right"><strong>Tables structure</strong></td>

                                        <td width="5%" align="center"><strong>:</strong></td>

                                        <td align="left" align="top">

                                         <?php 

                                         //$table_all= $obj->getTableNameOptions_dropdown_kr1(0,'','');
                                          //Add this function by ample 07-11-19
                                         $tables=$obj2->getTableNameFrom_tbltabldropdown('4',$table_link);
                                            
                                         ?>
                                         <!--added by ample 07-11-19 -->
                                         <select class="" id="tables_names" name="table_link" style="width:125px;" onchange="getColumnsTables();">
                                             
                                             <?php echo $tables; ?>

                                         </select>

                                         &nbsp; &nbsp;

                                            <select id="columns_dropdown1" style="width:125px;" name="table_column" >
                                                    <?php 
                                                        if(!empty($table_column))
                                                        {
                                                            ?>
                                                            <option value="<?=$table_column?>"><?=$table_column?></option>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <option value="">Select</option>
                                                            <?php
                                                        }
                                                    ?>
                                                     
                                            </select>

                                            <br>

                                             
                                               <select id="columns_dropdown2" style="width:125px;" name="column1" >
                                                    <?php 
                                                        if(!empty($column1))
                                                        {
                                                            ?>
                                                            <option value="<?=$column1?>"><?=$column1?></option>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <option value="">Select</option>
                                                            <?php
                                                        }
                                                    ?>
                                            </select>
                                            &nbsp; &nbsp;
                                            <input type="text" value="<?=$value1;?>" style="width:125px;" name="value1">

                                            <br>

                                              <select id="columns_dropdown3" style="width:125px;" name="column2" >
                                                     <?php 
                                                        if(!empty($column2))
                                                        {
                                                            ?>
                                                            <option value="<?=$column2?>"><?=$column2?></option>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <option value="">Select</option>
                                                            <?php
                                                        }
                                                    ?>
                                            </select>
                                            &nbsp; &nbsp;
                                            <input type="text" value="<?=$value2;?>" style="width:125px;" name="value2">

                                           

                                         </td>

                                    </tr>

<tr>

<td colspan="3" align="center">&nbsp;</td>

</tr>

<tr>

<td align="right"><strong>Status</strong></td>

<td align="center"><strong>:</strong></td>

<td align="left">

<select id="reward_module_status" name="reward_module_status" style="width:200px;">

<option value="0" <?php if($reward_module_status == 0) { ?> selected="selected" <?php } ?>>Inactive</option>

<option value="1" <?php if($reward_module_status == 1) { ?> selected="selected" <?php } ?>>Active</option>

</select>

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

<script>

function getText(element) {

var textHolder = element.options[element.selectedIndex].text

document.getElementById("reward_module_title").value = textHolder;

}

</script>

<script>


function getColumnsTables()

{   

    var table_name=$('#tables_names').val();   

    var dataString = 'action=getTableColumnsNameKR&tablm_name='+table_name;

      $.ajax({

        type: "POST",

        url: "include/remote.php",

        //dataType:'JSON',

        data: dataString,

        cache: false,

        success: function(result)

        {

         $('#columns_dropdown1').html(result);
         $('#columns_dropdown2').html(result);
         $('#columns_dropdown3').html(result);

        }

      });



}




</script>
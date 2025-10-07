<?php

require_once('config/class.mysql.php');

require_once('classes/class.subscriptions.php');

$obj = new Subscriptions();

$edit_action_id = '192';


//Add by ample 06-11-20
require_once('classes/class.contents.php'); 
$obj2 = new Contents();



if(!$obj2->isAdminLoggedIn())

{

header("Location: index.php?mode=login");

exit(0);

}



if(!$obj2->chkValidActionPermission($admin_id,$edit_action_id))

{	

header("Location: index.php?mode=invalid");

exit(0);

}


$page_id=$_GET['page_id'];

if(empty($page_id))
{
    header('location: index.php?mode=edit_user_plan&id=<?=$_GET["plan_id"]?>');
}




$error = false;

$err_msg = "";


$table_link="";


//update by ample 17-08-20
if(isset($_POST['btnSubmit']))

{

    // echo "<pre>";

    // print_r($_POST);

    // die('---test');


// $setting_id = $_POST['setting_id'];

// $page_id = trim($_GET['page_id']);

// $table_link = trim($_POST['table_link']);
// $table_column = trim($_POST['table_column']);

// $column1 = trim($_POST['column1']);
// $column2 = trim($_POST['column2']);
// $value1 = trim($_POST['value1']);
// $value2 = trim($_POST['value2']);


    if(!$error)

    {   


        //update by ample 17-08-20
        if(isset($_POST['setting_id']) && !empty($_POST['setting_id']))
        {
            $result=$obj->updated_page_setting($_POST);
        }
        else
        {
            $result=$obj->added_page_setting($_POST);
        }

        if($result)

        {

        $err_msg = "Page Setting Update Successfully!";

        header('location: index.php?mode=edit_user_plan&id=<?=$_GET["plan_id"]?>&msg='.urlencode($err_msg));

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

    $data=$obj->get_page_setting($page_id);


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

<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Update page setting </td>

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

<input type="hidden" name="setting_id" value="<?php echo $data['setting_id'];?>" />

<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">

<tbody>

<tr>

<td colspan="3" align="center">&nbsp;</td>

</tr>

            <tr>

                <td width="30%" align="right" valign="top"><strong>Page Name</strong></td>

                <td width="5%" align="center" valign="top"><strong>:</strong></td>

                <td width="65%" align="left" valign="top">

                    <input type="text" name="page_id" id="page_id" value="<?=$obj->get_PageName($page_id);?>" disabled>
                    <input type="hidden" name="page_id" id="page_id" value="<?=$page_id;?>" readonly>
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

                                          //Add this function by ample 07-11-19
                                         $tables=$obj2->getTableNameFrom_tbltabldropdown('11',$data['table_link']);
                                            
                                         ?>
                                         <!--added by ample 07-11-19 -->
                                         <select class="" id="tables_names" name="table_link" style="width:125px;" onchange="getColumnsTables();">
                                             
                                             <?php echo $tables; ?>

                                         </select>

                                         &nbsp; &nbsp;

                                            <select id="columns_dropdown1" style="width:125px;" name="table_column" >
                                                    <?php 
                                                        if(!empty($data['table_column']))
                                                        {
                                                            ?>
                                                            <option value="<?=$data['table_column']?>"><?=$data['table_column']?></option>
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
                                                        if(!empty($data['column1']))
                                                        {
                                                            ?>
                                                            <option value="<?=$data['column1']?>"><?=$data['column1']?></option>
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
                                            <input type="text" value="<?=$data['value1'];?>" style="width:125px;" name="value1">

                                            <br>

                                              <select id="columns_dropdown3" style="width:125px;" name="column2" >
                                                     <?php 
                                                        if(!empty($data['column2']))
                                                        {
                                                            ?>
                                                            <option value="<?=$data['column2']?>"><?=$data['column2']?></option>
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
                                            <input type="text" value="<?=$data['value2'];?>" style="width:125px;" name="value2">

                                           <br>

                                              <select id="columns_dropdown4" style="width:125px;" name="column3" >
                                                     <?php 
                                                        if(!empty($data['column3']))
                                                        {
                                                            ?>
                                                            <option value="<?=$data['column3']?>"><?=$data['column3']?></option>
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
                                            <input type="text" value="<?=$data['value3'];?>" style="width:125px;" name="value3">


                                         </td>

                                    </tr>

<tr>

<td colspan="3" align="center">&nbsp;</td>

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
         $('#columns_dropdown4').html(result);
        }

      });



}




</script>
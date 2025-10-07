<?php

require_once('config/class.mysql.php');

require_once('classes/class.rewardpoints.php');

require_once('classes/class.scrollingwindows.php');

require_once('classes/class.contents.php'); 

$obj2 = new Contents();



$obj = new RewardPoint();

$obj1 = new Scrolling_Windows();

$edit_action_id = '165';


require_once('classes/class.mindjumble.php');
$obj3 = new Mindjumble();



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


$reward_list_id = $_POST['hdnreward_list_id'];  

$reward_list_module_id = trim($_POST['hdnreward_list_module_id']);

$reward_list_conversion_type_id = trim($_POST['hdnreward_list_conversion_type_id']);

$reward_list_conversion_value = trim($_POST['hdnreward_list_conversion_value']);

$reward_list_cutoff_type_id = trim($_POST['hdnreward_list_cutoff_type_id']);

$reward_list_min_cutoff = trim($_POST['hdnreward_list_min_cutoff']);

$reward_list_max_cutoff = trim($_POST['hdnreward_list_max_cutoff']);

$reward_list_name = trim($_POST['hdnreward_list_name']);

$reward_list_file_type = trim($_POST['reward_list_file_type']);

$reward_list_file2 = trim($_POST['reward_list_file2']);

$reward_terms = trim($_POST['reward_terms']);

$reward_list_date = trim($_POST['hdnreward_list_date']);

$reward_list_status = trim($_POST['reward_list_status']);

$event_close_date= trim($_POST['event_close_date']);

$special_remarks = $_POST['special_remarks'];

$reward_type=trim($_POST['reward_type']);



$admin_comment=$_POST['admin_comment'];

$tables_names=$_POST['tables_names'];

$columns_dropdown=$_POST['columns_dropdown'];



$tables_names2=$_POST['tables_names2'];

$columns_dropdown_reword=$_POST['columns_dropdown_reword'];

$columns_dropdown_value_reword=$_POST['columns_dropdown_value_reword'];



$gallery_remark = $_POST['gallery_remark'];


$shows_cat=$_POST['shows_cat'];



 $shows_where=$_POST['shows_where'];

 $shows_gallery=$_POST['shows_gallery'];



$reward_point_close_date=trim($_POST['reward_point_close_date']);


if($reward_point_close_date<$event_close_date)
{
    $error = true;

    $err_msg = "New close date are less then by old date!";
}
else
{
    $event_close_date=$reward_point_close_date;
}



if($reward_list_module_id == "")

{

$error = true;

$err_msg = "Please select module.";

}



if($reward_list_conversion_type_id == "")

{

$error = true;

$err_msg .= "<br>Please select conversion type.";

}



if($reward_list_conversion_value == "")

{

$error = true;

$err_msg .= "<br>Please enter conversion value.";

}



if($reward_list_cutoff_type_id == "")

{

$error = true;

$err_msg .= "<br>Please select cutoff type.";

}



if($reward_list_cutoff_type_id != "0")

{

if($reward_list_min_cutoff == "")

{

$error = true;

$err_msg .= "<br>Please enter minimum cutoff.";

}

elseif(!is_numeric($reward_list_min_cutoff))

{

$error = true;

$err_msg .= "<br>Invalid no of minimum cutoff.";

}

}



if($reward_list_name == "")

{

$error = true;

$err_msg .= "<br>Please enter reward name.";

}



if($reward_list_date == "")

{

$error = true;

$err_msg .= "<br>Please enter effective date.";

}


if(!empty($listing_date_type) && $listing_date_type=='single_date' )
{
     if(!empty($single_date))
     {
         if($_POST['single_date'] >= $reward_list_date && $_POST['single_date'] <= $event_close_date)
         {

         }
         else
         {
            $error = true;

            $err_msg .= "<br>Please Single date choose between event open date and event close date.";
         }
     }
}


if($reward_list_file_type == 'Video')

{

$display_trfile = 'none';

$display_trtext = '';



$reward_list_file = $reward_list_file2;

if($reward_list_file == '')

{

$error = true;

$err_msg = "Please enter video url.";

}	

}

else

{

$display_trfile = '';

$display_trtext = 'none';

}

if(isset($_FILES['reward_terms']['tmp_name']) && $_FILES['reward_terms']['tmp_name'] != '')

{

$reward_terms = $_FILES['reward_terms']['name'];

$file4 = substr($reward_list_file, -4, 4);



if(!$error)

{	



$reward_terms = time()."_".$reward_terms;

$temp_dir = SITE_PATH.'/uploads/';

$temp_file = $temp_dir.$reward_terms;



if(!move_uploaded_file($_FILES['reward_terms']['tmp_name'], $temp_file)) 

{

if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file

$error = true;

$err_msg = 'Couldn\'t Upload reward file';

$reward_terms = '';

}

}

}  

else

{

$reward_terms = strip_tags(trim($_POST['hdnreward_terms']));

}


//update by ample 05-11-20
$reward_list_file_type = trim($_POST['level_icon_type']);
$reward_list_file = trim($_POST['level_icon']);



if(!$error)

{

if($obj->updateRewardList($special_remarks,$reward_terms,$reward_list_id,$reward_list_module_id,$reward_list_conversion_type_id,$reward_list_conversion_value,$reward_list_cutoff_type_id,$reward_list_min_cutoff,$reward_list_max_cutoff,$reward_list_name,$reward_list_file_type,$reward_list_file,$reward_list_status,$reward_list_date,$reward_type,$shows_cat,$shows_where,$shows_gallery,$admin_comment,$gallery_remark,$event_close_date))

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
                        'reward_id'=>$reward_list_id,
                        'reward_type'=>'reward_list',
                        'close_date'=>$close_date,
                    );
        $obj->update_reward_close_history($update_data);

        $msg = "Record Updated Successfully!";

        header('location: index.php?mode=reward_list&msg='.urlencode($msg));

}

else

{

$error = true;

$err_msg = "Currently there is some problem.Please try again later.";

}

}

}

elseif (isset($_POST['btnSave'])) {


    if(isset($_FILES['reward_terms']['tmp_name']) && $_FILES['reward_terms']['tmp_name'] != '')
        {

            $reward_terms = $_FILES['reward_terms']['name'];
            $file4 = substr($reward_list_file, -4, 4);
            $reward_terms = time()."_".$reward_terms;
            $temp_dir = SITE_PATH.'/uploads/';
            $temp_file = $temp_dir.$reward_terms;
            if(!move_uploaded_file($_FILES['reward_terms']['tmp_name'], $temp_file)) 
            {
                if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file
                $error = true;
                $err_msg = 'Couldn\'t Upload reward file';
                $reward_terms = '';
            }
        }  
        else
        {
        $reward_terms = '';
        }

    $res=$obj->new_reward_list_addons($_POST,$reward_terms);

    if($res)
    {   
        $error = false;
        $err_msg = "New reward list added successfully!";
        $_SESSION['MSG']=$err_msg;
        header('location: index.php?mode=reward_list&msg='.urlencode($err_msg));
        //header('location: index.php?mode=edit_reward_list&id='.$res.'&msg='.urlencode($err_msg));
    }
    else
    {   
        $error = true;
        $err_msg = "Try Later!";
        header('location: index.php?mode=edit_reward_list&id='.$_POST['reward_list_id'].'&msg='.urlencode($err_msg));
    }

}

elseif(isset($_GET['id']))

{





$reward_list_id = $_GET['id'];
//update by ample 19-08-20/20-08-20
list($fav_cat_type_id_1,$fav_cat_type_id_2,$fav_cat_id_1,$fav_cat_id_2,$reward_title_remark,$special_remarks,$reward_terms,$event_id,$identity_type,$identity_id,$reference_number,$event_close_date,$reward_list_module_id,$reward_list_conversion_type_id,$reward_list_conversion_value,$reward_list_cutoff_type_id,$reward_list_min_cutoff,$reward_list_max_cutoff,$reward_list_name,$reward_list_file_type,$reward_list_file,$reward_list_status,$reward_list_date,$reward_type,$listing_date_type,$days_of_month,$single_date,$start_date,$end_date,$days_of_week,$months,$show_cat,$shows_where,$shows_gallery,$admin_comment,$tables_select,$tables_select2,$columns_id,$columns_id2,$columns_value2,$gallery_remark,$equivalent_type,$equivalent_value) = $obj->getRewardListDetails($reward_list_id);




    $history_data=$obj->get_reward_close_history('reward_list',$reward_list_id);  //added by ample 12-12-20



// $listing_date_type = $design_data['listing_date_type'];                              

if($listing_date_type == 'days_of_month')



    {

        $tr_days_of_week = 'none';

        $tr_days_of_month = '';

        $tr_single_date = 'none';

        $tr_date_range = 'none';

        $tr_month_date = 'none';



        $single_date = '';

        $start_date = '';

        $end_date = '';

        $days_of_week = '';



        $pos = strpos($days_of_month, ',');

        if ($pos !== false) 

        {

            $arr_days_of_month = explode(',',$days_of_month);

        }

        else

        {

            array_push($arr_days_of_month , $days_of_month);

        }

        

//        echo '<pre>';

//        print_r($arr_days_of_month);

//        echo '</pre>';

        

    }

    elseif($listing_date_type == 'days_of_week')

    {



        $tr_days_of_week = '';

        $tr_days_of_month = 'none';

        $tr_single_date = 'none';

        $tr_date_range = 'none';

        $tr_month_date = 'none';

        $single_date = '';

        $start_date = '';

        $end_date = '';

        $days_of_month = '';



        $pos = strpos($days_of_week, ',');



        if ($pos !== false) 

        {

            $arr_days_of_week = explode(',',$days_of_week);

        }

        else

        {

            array_push($arr_days_of_week , $days_of_week);

        }

    }



    elseif($listing_date_type == 'single_date')



    {



        $tr_days_of_week = 'none';

        $tr_days_of_month = 'none';

        $tr_single_date = '';

        $tr_date_range = 'none';

        $tr_month_date = 'none';

        $days_of_month = '';

        $start_date = '';

        $end_date = '';

        $days_of_week = '';

        $single_date = date('d-m-Y',strtotime($single_date));



    }



    elseif($listing_date_type == 'date_range')



    {



        $tr_days_of_week = 'none';

        $tr_days_of_month = 'none';

        $tr_single_date = 'none';

        $tr_date_range = '';

        $tr_month_date = 'none';

        $days_of_month = '';

        $single_date = '';

        $days_of_week = '';

        $start_date = date('d-m-Y',strtotime($start_date));

        $end_date = date('d-m-Y',strtotime($end_date));



    }



    elseif($listing_date_type == 'month_wise')



    {



        $tr_days_of_week = 'none';

        $tr_days_of_month = 'none';

        $tr_single_date = 'none';

        $tr_date_range = 'none';

        $tr_month_date = '';

        $single_date = '';

        $start_date = '';

        $end_date = '';

        $days_of_month = '';

        $days_of_week = '';

        $pos = strpos($months, ',');

        if ($pos !== false) 

        {

            $arr_month = explode(',',$months);

        }

        else

        {

            array_push($arr_month , $months);

        }



    }

                                   

    else

    {

        $box_title = '';

        $banner_type = '';

        $box_desc = '';

        $credit_line = '';

        $arr_day = array();

        $credit_line_url = 'http://';

        $tr_days_of_month = 'none';

        $tr_single_date = 'none';

        $tr_date_range = 'none';

        $tr_month_date = 'none';

        $tr_days_of_week = 'none';

        $arr_days_of_month = array();

        $arr_days_of_week = array();

        $arr_month = array();

    }



















if($reward_list_file_type == 'Video')

{

$display_trfile = 'none';

$display_trtext = '';



$reward_list_file2 = $reward_list_file;

}

else

{

$display_trfile = '';

$display_trtext = 'none';

}



$reward_list_date = date('d-m-Y',strtotime($reward_list_date));

if($event_close_date!='0000-00-00')
    {
        $event_close_date = date('d-m-Y',strtotime($event_close_date));
    }
    else
    {
        $event_close_date="";
    }

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

if(!empty($_SESSION['MSG'])) {
   $message = $_SESSION['MSG'];
   echo '<div class="alert alert-success">'.$message.'</div>';
   unset($_SESSION['MSG']);
}

    ?>

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

<table border="0" width="97%" align="center" cellpadding="0" cellspacing="0" >

<tbody>

<tr>

<td>

<table border="0" width="100%" cellpadding="0" cellspacing="0">

<tbody>

<tr>

<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>

<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>

<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Reward Item</td>

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

<input type="hidden" name="hdnreward_list_id" id="hdnreward_list_id" value="<?php echo $reward_list_id;?>" />

<input type="hidden" name="hdnreward_list_file" id="hdnreward_list_file" value="<?php echo $reward_list_file;?>" />

                <input type="hidden" name="hdnreward_list_module_id" id="hdnreward_list_module_id" value="<?php echo $reward_list_module_id;?>" />

                <input type="hidden" name="hdnreward_list_conversion_type_id" id="hdnreward_list_conversion_type_id" value="<?php echo $reward_list_conversion_type_id;?>" />

                <input type="hidden" name="hdnreward_list_conversion_value" id="hdnreward_list_conversion_value" value="<?php echo $reward_list_conversion_value;?>" />

                <input type="hidden" name="hdnreward_list_cutoff_type_id" id="hdnreward_list_cutoff_type_id" value="<?php echo $reward_list_cutoff_type_id;?>" />

                <input type="hidden" name="hdnreward_list_min_cutoff" id="hdnreward_list_min_cutoff" value="<?php echo $reward_list_min_cutoff;?>" />

                <input type="hidden" name="hdnreward_list_max_cutoff" id="hdnreward_list_max_cutoff" value="<?php echo $reward_list_max_cutoff;?>" />

                <input type="hidden" name="hdnreward_list_name" id="hdnreward_list_name" value="<?php echo $reward_list_name;?>" />

                <input type="hidden" name="hdnreward_list_date" id="hdnreward_list_date" value="<?php echo $reward_list_date;?>" />

                 <input type="hidden" name="event_close_date" id="event_close_date" value="<?php echo $event_close_date;?>" />

                <input type="hidden" name="hdnreward_terms" id="hdnreward_terms" value="<?php echo $reward_terms;?>" />

                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="table_add">

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

						<td colspan="3" align="center">&nbsp;</td>

						</tr>

						 <tr>

						     <td width="20%" align="right"><strong>Admin Notes</strong></td>

						     <td width="5%" align="center"><strong>:</strong></td>

						     <td width="75%" align="left"><textarea name="admin_comment" type="text" id="admin_comment"  style="width:400px; height: 200px;" ><?php echo $admin_comment;?></textarea>

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

<td width="20%" align="right"><strong>Module Name</strong></td>

<td width="5%" align="center"><strong>:</strong></td>

<td width="75%" align="left"><strong><?php echo $obj->getRewardModuleTitle($reward_list_module_id); ?></strong></td>

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

                                <?php echo $obj->getprofcatname($fav_cat_type_id_1); ?>

                            </td>

                        </tr>

                        <tr>

                            <td colspan="3" align="center">&nbsp;</td>

                        </tr>

                        <tr>

                            <td align="right"><strong>Reward Sub Category 1</strong></td>

                            <td align="center"><strong>:</strong></td>

                            <td align="left">

                               <?php echo $obj->getFavCategoryNameVivek($fav_cat_id_1); ?>

                            </td>

                        </tr>

                        <tr>

                            <td colspan="3" align="center">&nbsp;</td>

                        </tr>

                        <tr>

                            <td align="right"><strong>Reward Main Category 2</strong></td>

                            <td align="center"><strong>:</strong></td>

                            <td align="left">

                              <?php echo $obj->getprofcatname($fav_cat_type_id_2); ?>

                            </td>

                        </tr>

                        <tr>

                            <td colspan="3" align="center">&nbsp;</td>

                        </tr>

                        <tr>

                            <td align="right"><strong>Reward Sub Category 2</strong></td>

                            <td align="center"><strong>:</strong></td>

                            <td align="left">

                               <?php echo $obj->getFavCategoryNameVivek($fav_cat_id_2); ?>

                            </td>

                        </tr>


                        <tr>

                            <td colspan="3" align="center">&nbsp;</td>

                        </tr>

                        <tr>

<td align="right"><strong>Conversion Type</strong></td>

<td align="center"><strong>:</strong></td>

<td align="left"><strong><?php echo $obj->getpfavcatname($reward_list_conversion_type_id); ?></strong></td>

</tr>

<tr>

<td colspan="3" align="center">&nbsp;</td>

</tr>

<tr>

<td align="right"><strong>Conversion Value</strong></td>

<td align="center"><strong>:</strong></td>

<td align="left"><strong><?php echo $reward_list_conversion_value; ?></strong></td>

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

<td align="left"><strong><?php echo $obj->getpfavcatname($reward_list_cutoff_type_id); ?></strong></td>

</tr>

<tr>

<td colspan="3" align="center">&nbsp;</td>

</tr>

<tr>

<td align="right"><strong>Minimum Cutoff</strong></td>

<td align="center"><strong>:</strong></td>

<td align="left"><strong><?php echo $reward_list_min_cutoff; ?></strong></td>

</tr>

<tr>

<td colspan="3" align="center">&nbsp;</td>

</tr>

<tr>

<td align="right"><strong>Maximum Cutoff</strong></td>

<td align="center"><strong>:</strong></td>

<td align="left"><strong><?php echo $reward_list_max_cutoff; ?></strong></td>

</tr>

<tr>

<td colspan="3" align="center">&nbsp;</td>

</tr>


                            <tr>

                                <td align="right"><strong>Effective Date</strong></td>

                                <td align="center"><strong>:</strong></td>

                                <td align="left"><strong><?php echo $reward_list_date;?></strong></td>

                            </tr>

                            <tr>

                                <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>

                            </tr>

                            <tr>

                                <td align="right"><strong>Closing Date</strong></td>

                                <td align="center"><strong>:</strong></td>

                                <td align="left"><strong>
                                    
                                    <input name="reward_point_close_date" id="reward_point_close_date" type="text" value="<?php echo $event_close_date;?>" style="width:200px;" autocomplete="off" />

                                    <script>$('#reward_point_close_date').datepicker({startDate: '-0d' , dateFormat : 'dd-mm-yy'}); </script>
                                </strong>

                                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#historyModal">Date Hostory</button>

                            </td>


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

                            <td align="right"><strong>Reward Title/Remarks</strong></td>

                            <td align="center"><strong>:</strong></td>

                            <td align="left">

                                <?php echo $reward_title_remark; ?>

                            </td>

                        </tr>

                            <tr>

                                <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>

                            </tr>


<tr>

<td align="right"><strong>Reward Name</strong></td>

<td align="center"><strong>:</strong></td>

<td align="left"><strong><?php echo $reward_list_name; ?></strong></td>

</tr>

<tr>

<td colspan="3" align="center">&nbsp;</td>

</tr>

                            <tr>

<td align="right"><strong>Reward File</strong></td>

<td align="center"><strong>:</strong></td>

<td align="left">

                                      <!-- add by ample 23-01-20 -->
                                        <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('IMG',0,'level_icon');">Gallery 1</button>
                                        <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('OT',0,'level_icon');">Gallery 2</button>
                                        <input type="hidden" name="level_icon" id="level_icon" value="<?=$reward_list_file?>" readonly />
                                        <input type="text" name="level_icon_type" id="level_icon_type" value="<?=$reward_list_file_type?>" readonly/>

                                        <?php 
                                        $banner_name=$banner_file="";
                                        if(!empty($reward_list_file_type) && is_numeric($reward_list_file))
                                        {
                                            if($reward_list_file_type=='Image')
                                            {
                                                $banner_data=$obj3->get_data_from_tblicons('',$reward_list_file);
                                                $banner_name=$banner_data[0]['icons_name'];
                                                $banner_file=$banner_data[0]['image'];
                                            }
                                            else
                                            {
                                                $banner_data=$obj3->get_data_from_tblmindjumble('',$reward_list_file);
                                                $banner_name=$banner_data[0]['box_title'];
                                                $banner_file=$banner_data[0]['box_banner'];
                                            }
                                        }

                                        ?>

                                        <input type="text"  id="level_icon_name" value="<?=$banner_name;?>" disabled/>
                                        <input type="text"  id="level_icon_file" value="<?=$banner_file;?>" disabled />
                                        <button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData('level_icon');">Reset</button>
                                        
                                         <br>
                                        <?php 

                                        if(!empty($banner_file))
                                        {

                                                ?>
                                                <a href="<?php echo SITE_URL.'/uploads/'. $banner_file;?>" target="_blank"><?php echo $banner_file;?></a> 
                                                <?php
                                        }


                                        ?>

</td>

</tr>

<tr>

<td colspan="3" align="center">&nbsp;</td>

</tr>


<tr>

<td colspan="3" align="center">&nbsp;</td>

</tr>


                       

                        <tr>

<td align="right" valign="top"><strong>Reward Term & condition</strong></td>

<td align="center" valign="top"><strong>:</strong></td>

<td align="left">

                                    <input type="file" name="reward_terms" id="reward_terms" />

<?php 

                                $ext = pathinfo($reward_terms, PATHINFO_EXTENSION);

                                //echo $ext;

                                if(($ext == 'jpg')|| ($ext == 'JPG') || ($ext =='jpeg') || ($ext == 'JPEG') || ($ext =='gif') || ($ext == 'GIF') || ($ext =='png') || ($ext == 'PNG'))								

                                    { ?>

<img border="0" src="<?php echo SITE_URL.'/uploads/'.$reward_terms;?>" width="200" height="200"  /> 

                                    <?php

                                    }

                                    elseif($ext == 'Pdf')

                                    {   ?>

                                    <a target="_blank" href="<?php echo SITE_URL.'/uploads/'.$reward_terms;?>"><img border="0" src="images/pdf-download-icon.png" width="50" height="50"  /> </a>

                                    <?php

                                    

                                    }

                                ?>

</td>

</tr>

                        <tr>



                            <td colspan="3" align="center">&nbsp;</td>



                        </tr>

                        <tr>



                            <td align="right" valign="top"><strong>Special Remarks</strong></td>



                            <td align="center" valign="top"><strong>:</strong></td>





                            <td align="left"><textarea id="special_remarks" rows="10" cols="50" name="special_remarks" ><?php echo $special_remarks; ?></textarea></td>



                        </tr>



                        <tr>



                            <td colspan="3" align="center">&nbsp;</td>



                        </tr>













<!-- $show_cat -->



               <tr>

                    <td align="right"><strong>Show</strong></td>

                    <td align="center"><strong>:</strong></td>

                    <td align="left">

                        <select id="shows" name="shows_cat" style="width:400px;">

                           <?php echo $obj->getFavCategoryRamakant('58',$show_cat)?>

                        </select>

                    </td>

                </tr>

                <tr>

                    <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>

                </tr>







                 <tr>

                    <td align="right"><strong>Show Where</strong></td>

                    <td align="center"><strong>:</strong></td>

                    <td align="left">

                        <select id="shows_where" name="shows_where" style="width:400px;">

                           <?php echo $obj->getDatadropdownPage('8',$shows_where);?> 

                        </select>

                    </td>

                </tr>



               <tr>

                    <td colspan="3" height="30" align="center" valign="top">&nbsp;</td>

                </tr>


          <tr>

            <td align="right"><strong>Show Gallery</strong></td>

            <td align="center"><strong>:</strong></td>

            <td align="left">

                <select id="shows_gallery" name="shows_gallery" style="width:400px;">

                    <?php

                     if($shows_gallery==0)

                     {

                        ?>

                        <option value="<?php echo $shows_gallery;?>">No</option>

                        <option value="1">Yes</option>

                        <?php

                     }

                     else

                     {

                        ?>

                        <option value="<?php echo $shows_gallery;?>">Yes</option>

                         <option value="0">No</option>

                        <?php

                     }

                    ?>

                  

                </select>

            </td>

        </tr>





        <tr>

          <td colspan="3" align="center">&nbsp;</td>

      </tr>


                          <tr>



                        <td align="right" valign="top"><strong>Gallery Remarks</strong></td>



                        <td align="center" valign="top"><strong>:</strong></td>





                        <td align="left"><textarea id="gallery_remark" rows="10" cols="50" name="gallery_remark" ><?php echo $gallery_remark; ?></textarea></td>



                    </tr>



            <tr>

                <td colspan="3" align="center">&nbsp;</td>





                        

 <tr>

<td align="right"><strong>Status</strong></td>

<td align="center"><strong>:</strong></td>

<td align="left">

<select id="reward_list_status" name="reward_list_status" style="width:200px;">

	<option value="0" <?php if($reward_list_status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

	<option value="1" <?php if($reward_list_status == '1') { ?> selected="selected" <?php } ?>>Active</option>

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
                                        <a href="index.php?mode=update_sponsor_data&data_id=<?=$_GET['id']?>"><button type="button" class="btn btn-info btn-xs">Sponsor Data</button>

                                        <a href="index.php?mode=update_scheduled&redirect_id=<?=$_GET['id']?>&redirect=rewardList" target="_blank"><button type="button" class="btn btn-warning btn-xs">Schedule Set</button></a>

                                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#rewardModal">Reward Addons</button>

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

<!-- Date history Modal add by ample 20-11-19 -->
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
                    <th>Extend Date</th>
                    <th>Extended On</th>
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

 <!-- Reward add-ons Modal add by ample 23-12-20 -->
  <div class="modal fade" id="rewardModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Reward Add-Ons</h4>
        </div>
        <div class="modal-body">
            <form action="#" method="post"  enctype="multipart/form-data" >
              <table>
                  <tbody>
                      <tr>

                                <td width="20%" align="right"><strong>Reward type</strong></td>

                                <td width="5%" align="center"><strong>:</strong></td>

                                <td width="75%" align="left">

                                    <select name="reward_type" id="reward_type" style="width:200px;">

                                        <?php echo $obj->getFavCategoryRamakant('73',''); ?>

                                    </select> 

                                </td>

                                </tr>

                                <tr>

                                <td colspan="3" align="center">&nbsp;</td>

                                </tr>

                                 <tr>

                                        <td align="right"><strong>Reward Title/Remarks</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left"><input name="reward_title_remark" type="text" id="reward_title_remark" value="" style="width:400px;" ></td>

                                    </tr>



                                <tr>

                                    <td colspan="3" align="center">&nbsp;</td>

                                </tr>

                                <tr>

                                <td align="right"><strong>Reward Name</strong></td>

                                <td align="center"><strong>:</strong></td>

                                <td align="left"><input name="reward_list_name" type="text" id="reward_list_name" value="" style="width:400px;" ></td>

                                </tr>

                                <tr>

                                <td colspan="3" align="center">&nbsp;</td>

                                </tr>


                                <tr>                                                                    

                                            <td align="right" valign="top"><strong>Reward File</strong></td>

                                            <td align="center" valign="top"><strong>:</strong></td>

                                            <td  align="left" valign="top">

                                                <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('IMG',0,'level_icons');">Gallery 1</button>
                                                <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('OT',0,'level_icons');">Gallery 2</button>
                                                <input type="hidden" name="level_icons" id="level_icons" readonly />
                                                <input type="text" name="level_icons_type" id="level_icons_type" readonly/>
                                                <input type="text"  id="level_icons_name" disabled/>
                                                <input type="text"  id="level_icons_file" disabled />
                                                <button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData('level_icons');">Reset</button>
                                                

                                            </td>

                                        </tr>

                                <tr>

                                <td colspan="3" align="center">&nbsp;</td>

                                </tr>               



                            <tr>

                                <td colspan="3" align="center">&nbsp;</td>

                            </tr>

                        <tr>

                            <td align="right" valign="top"><strong>Reward Term & condition</strong></td>

                            <td align="center" valign="top"><strong>:</strong></td>

                            <td align="left">

                                <input type="file" name="reward_terms" id="reward_terms" />

                            </td>

                        </tr>

                        <tr>

                        <td>&nbsp;</td>

                        <td>&nbsp;</td>

                        <td align="left">
                            <input type="hidden" name="reward_list_id" id="reward_list_id" value="<?php echo $reward_list_id;?>" />
                            <input type="Submit" name="btnSave" value="Save" />
                        </td>

                        </tr>
                  </tbody>
              </table>
            </form>
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

elements : "sponsor_remarks,special_remarks,gallery_remark",

plugins : "style,advimage,advlink,emotions",

theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

});

</script>



 <!-- <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script> -->

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
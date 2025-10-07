<?php
include ('classes/config.php');
$obj = new frontclass();
$page_id = '85';
$main_page_id = $page_id;
$page_data = $obj->getPageDetails($page_id);
//list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);
$ref = base64_encode('my_adviser_queries.php');
if (!$obj->isLoggedIn()) {
    //  header("Location: login.php?ref=".$ref);
    echo "<script>window.location.href='login.php?ref=$ref'</script>";
    exit(0);
} else {
    $user_id = $_SESSION['user_id'];
    $obj->doUpdateOnline($_SESSION['user_id']);
}
$user_upa_id = $obj->getupaid($page_id);
$plan_flag = $obj->Checkifplanexist($user_upa_id);
if ($plan_flag) {
    if ($obj->chkUserPlanFeaturePermission($user_id, $user_upa_id)) {
        $page_access = true;
    } else {
        $page_access = false;
    }
} else {
    $page_access = true;
}
$error = false;
$err_msg = '';
if (isset($_POST['pro_user_id'])) {
    $pro_user_id = strip_tags(trim($_POST['pro_user_id']));
} elseif (isset($_SESSION['adviser_query_pro_user_id'])) {
    $pro_user_id = $_SESSION['adviser_query_pro_user_id'];
} else {
    $pro_user_id = '';
}
if (isset($_POST['pg_id'])) {
    $pg_id = strip_tags(trim($_POST['pg_id']));
} elseif (isset($_SESSION['adviser_query_pg_id'])) {
    $pg_id = $_SESSION['adviser_query_pg_id'];
} else {
    $pg_id = '';
}
// echo $pg_id;
if (isset($_POST['start_date'])) {
    $start_date = strip_tags(trim($_POST['start_date']));
} elseif (isset($_SESSION['adviser_query_start_date'])) {
    $start_date = $_SESSION['adviser_query_start_date'];
} else {
    $start_date = '';
}
if (isset($_POST['end_date'])) {
    $end_date = strip_tags(trim($_POST['end_date']));
} elseif (isset($_SESSION['adviser_query_end_date'])) {
    $end_date = $_SESSION['adviser_query_end_date'];
} else {
    $end_date = '';
}
if (isset($_POST['search_keywords'])) {
    $search_keywords = strip_tags(trim($_POST['search_keywords']));
} elseif (isset($_SESSION['adviser_query_search_keywords'])) {
    $search_keywords = $_SESSION['adviser_query_search_keywords'];
} else {
    $search_keywords = '';
}
$_SESSION['adviser_query_pro_user_id'] = $pro_user_id;
$_SESSION['adviser_query_pg_id'] = $pg_id;
$_SESSION['adviser_query_start_date'] = $start_date;
$_SESSION['adviser_query_end_date'] = $end_date;
$_SESSION['adviser_query_search_keywords'] = $search_keywords;
if ($start_date == '' || $end_date == '') {
    $error = true;
    $err_msg = '<span class="Header_blue">Please select From and To date.</span>';
} else {
    // update by ample 04-03-20 & 25-03-20
    list($arr_feedback_id, $arr_aq_user_unique_id, $arr_pg_id, $arr_pg_tbl, $arr_permission_type, $arr_user_id, $arr_name, $arr_email, $arr_feedback, $arr_feedback_add_date, $arr_vendor_id, $arr_user_read, $arr_pro_user_read,$arr_from_user) = $obj->getUsersAllAdviserQueries($user_id, $pro_user_id, $pg_id, $start_date, $end_date, $search_keywords);

     // $query_data=$obj->getUsersAllAdviserQueries($user_id, $pro_user_id, $pg_id, $start_date, $end_date, $search_keywords);

// echo "<pre>";

// print_r($query_data);

// die('jhdgbh');


    if (count($arr_feedback_id) > 0) {
        $error = false;
        $err_msg = '';
    } else {
        $error = true;
        $err_msg = '<span class="err_msg">No Records Found!</span>';
    }
}


// $query_data=$obj->getUsersAllAdviserQueries($user_id, $pro_user_id, $pg_id, $start_date, $end_date, $search_keywords);

// echo "<pre>";

// print_r($query_data);

// die('jhdgbh');

$access_btn=$obj->check_user_subcription_plan_status($page_id); //added by ample 04-12-20

$title=base64_decode($_GET['title'] ?? '');
?><!DOCTYPE html>

<html lang="en">

<head>
<?php include_once ('head.php'); ?>

</head>
<body>
<?php include_once ('analyticstracking.php'); ?>
<?php include_once ('analyticstracking_ci.php'); ?>

<?php include_once ('analyticstracking_y.php'); ?>
<?php include_once ('header.php'); ?>
<!--header End -->      
<!--breadcrumb--> 
<div class="container"> 
        <div class="breadcrumb">
                    <div class="row">
                    <div class="col-md-8">  
                      <?php echo $obj->getBreadcrumbCode($page_id); ?> 
                       </div>
                         <div class="col-md-4">
                         <?php
if ($obj->isLoggedIn()) {
    echo $obj->getWelcomeUserBoxCode($_SESSION['name'], $_SESSION['user_id']);
}
?>

                         </div>
                       </div>
                </div>
                     <!-- </div>          -->
                      <!--breadcrumb end --> 

                      <div class="alert alert-danger alert-dismissible fade in" id="plan_msg" style="display: none;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                         Your current plan page limit exceeded now!
                    </div>


                      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                              <td align="left" valign="top"><span class="Header_brown"><?php echo $obj->getPageTitle($page_id); ?></span><br /><br /><?php echo $obj->getPageContents($page_id); ?></td>
                            </tr>
                        </table>
                        <?php
if ($page_access) { ?>

                        <form name="frmadviserquery" method="post" action="#" >
                        <table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" >
                          <tr>

                              <td width="20%" height="50" align="left" valign="middle" bgcolor="#FFFFFF">

                                  
                                    <strong class="Header_brown">From date</strong></td><td width="25%">
                                     <input name="start_date" id="start_date" type="text" value="<?php echo $start_date; ?>" class="form-control input-half-width datepicker" style="width: 150px!important;"/>

                                    
                                    <td width="5%"></td>
                                    <td width="10%"><strong class="Header_brown">To date</strong></td><td width="25%">
                                   <input name="end_date" id="end_date" type="text" value="<?php echo $end_date; ?>" class="form-control input-half-width datepicker" style="width: 150px!important;"/>

                                    

                                   </td></tr>
                                   <tr>

                                   <td width="20%" height="50">
                                    <strong class="Header_brown">Search Keyword</strong>
                                      <td width="70%" colspan="4">                           
                                           <input name="search_keywords" id="search_keywords" type="text" value="<?php echo $search_keywords; ?>" class="form-control" />
                                </td>

                               
                            </tr>
                            <tr>
                              <td width="20%" align="left" valign="middle" bgcolor="#FFFFFF" height="50">

                                  
                                    <label><strong class="Header_brown">Search For</strong></label></td><td width="25%">

                                       <select name="pro_user_id" id="pro_user_id" class="form-control">
                                    <!--  
                                          update by ample 01-11-19
                                      <select name="pro_user_id" id="pro_user_id" class="form-control" onchange="getAdviserQueryPageOptions('<?php echo $user_id; ?>','','pro_user_id','pg_id');"> -->
                                        <!-- <option value="">All Advisers</option> -->
                                        <?php //echo $obj->getUsersAdviserOptions($user_id,$pro_user_id);?>
                                         <?php echo $obj->getUsersAcceptedAdviserOptions($user_id, $pro_user_id); ?>

                                    </select>    

                                  </td>

                                  <td width="5%"></td>

                                  <td width="10%">

                                    <label><strong class="Header_brown">My Patterns </strong></label></td><td width="40%">

                                     <span id="idreference">
                                     <?php //echo $obj->getReportnameOfUser('User'); ?>
                                    <select name="pg_id" id="pg_id" class="form-control">

                                        <option value="">All Patterns</option>

                                        <!-- <?php //echo $obj->getAdviserQueryPageOptionsnew($pg_id,$user_id,$pro_user_id,'1');?> -->

                                        <!-- <?php //echo $obj->getReportnameOfUser('User'); ?> -->
                                        <!-- add by ample 04-03-20 -->
                                        <?php echo $obj->getAdviserQueryReference('', '','1'); ?>

                                    </select>    

                                    </span>

                                    &nbsp;

                                </td>

                              
                            </tr>

                            <tr>                            
                               <td height="50">
                            </td>

                            <td colspan="4">
                            <input type="submit" name="btnSubmit" class="btn btn-primary" value="Search" />
                            </td>

                            </tr>
                        </table>
                        </form>
                         <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                              <td class="footer" height="30">&nbsp;</td>
                            </tr>
                        </table>  

                        <?php
    if (!$error) {


      //update by ample 01-11-19  
        $arr_temp_adviser = array_unique($arr_vendor_id);
        for ($k = 0;$k < count($arr_temp_adviser);$k++) {
            //update ample 06-03-20
            list($ar_id, $request_status,$last_status) = $obj->chkIfIsAdvisersReferralsData($arr_temp_adviser[$k], $user_id);


            if($last_status==1)
            {
               $status_by = ' By Adviser';
            }
            else
            {
              $status_by = ' By Me';
            }

            $action4='';

            if ($request_status == 1) {
                $adviser_status = '<span class="Header_blue">Activated '.$status_by.'</span>';
                $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Deactivate" onclick="showDeactivateAdviserInvitationPopup(\'' . $ar_id . '\',\'' . $user_id . '\',\'' . $arr_temp_adviser[$k] . '\')">';
                $action = '<input type="button" name="btnAccept" id="btnAccept" value="Authorise/Modify Access" onclick="showPatternsPopup(\'' . $ar_id . '\',\'' . $arr_temp_adviser[$k] . '\')" >';

                if($access_btn==1)
                {
                  $action3=' <input class="btnReply" type="button" name="btnReply" id="btnReply" value="Add Query" onclick="showAdviserQueryPopup(\'' . "". '\',\'' . $arr_temp_adviser[$k] . '\')"/>';
                }
                else
                {
                  $action3=' <input class="btnReply" type="button"  value="Add Query" onclick="plan_msg()"/>';
                }

                
                $action4='<a href="appointment-request.php?ref_code=Dsgn-T&group_id=717&vendor_id='.$arr_temp_adviser[$k].'" target="_blank"><input class="btnReply" type="button" name="btnReply" id="btnReply" value="Add Appointment" /></a>';
            } else {
                $adviser_status = '<span class="Header_red">Deactivated '.$status_by.'</span>';
                 $action2='';
                if($last_status == '0')
                  {
                      $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Activate" onclick="showActivateAdviserInvitationPopup(\'' . $ar_id . '\',\'' . $user_id . '\',\'' . $arr_temp_adviser[$k] . '\')">';
                      
                  }
                $action3='';
                $action = '';
            }
            // if(!$obj->chkUserPlanFeaturePermission($user_id,'29'))
            // {
            //  $action2 = '';
            //  $action = '';
            // }


            
?>

                          
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                              <td width="30%" align="left" valign="middle"><strong>Adviser Name: <?php echo $obj->GetVendorName($arr_temp_adviser[$k]); ?></strong></td>
                                <td width="30%" align="left" valign="middle"><strong>Status: <?php echo $adviser_status; ?></strong></td>
                                <td width="20%" align="left" valign="middle">
                                    <?php echo $action3; ?> &nbsp; <?php echo $action4; ?>
                                </td>
                                <td width="10%" align="left" valign="middle"><?php echo $action2; ?></td>
                                <td width="10%" align="left" valign="middle"><?php echo $action; ?></td>
                            </tr>

                            

                        </table>

                        

                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                              <td height="30">&nbsp;</td>
                            </tr>
                        </table>  

                        
                        <table class="table table-bordered">
                          <tr class="success">

                              <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr No.</strong></td>

                                <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Query / Guidance ID</strong></td>

                                <td width="15%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Reference</strong></td>

                                <td width="40%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Queries & related Guidance</strong></td>

                                <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Date</strong></td>

                                <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Add</strong></td>

                                <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>View</strong></td>

                                <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>&nbsp;</strong></td>

                            </tr>



              <?php

                // echo "<pre>";

                // print_r($arr_feedback_id);

                // die('sjfhjk');

            $j = 1;
            for ($i = 0;$i < count($arr_feedback_id);$i++) {
                // echo "<pre>";print_r($arr_pro_user_id[$i]);echo "</pre>";
                // $arr_pro_user_id[$i]
                if ($arr_vendor_id[$i] == $arr_temp_adviser[$k])
                // $arr_user_id
                {


                    $time = strtotime($arr_feedback_add_date[$i]);
                    $time = $time + 19800;
                    $date = date('d-M-Y h:i A', $time);
                    // chnage function by ample 04-03-20
                    $pg_name = $obj->getReferenceName($arr_pg_id[$i],$arr_pg_tbl[$i]);
                    //$pg_name = $obj->getReportTypeName($arr_pg_id[$i]);
                    // $pg_name = $obj->getReportTypeNameString($arr_pg_id[$i]);
                    // echo "<pre>";

                    // print_r($pg_name);
                    // die();
                    // if ($arr_pg_id[$i] > 0) {
                    //     if ($arr_permission_type[$i] == '1') {
                    //         $pg_name.= ' (Adviser Set)';
                    //     } else {
                    //         $pg_name.= ' (Standard Set)';
                    //     }
                    // }
                    // if ($arr_user_read[$i] == '1') {
                    //     $td_class = 'qryread';
                    //     $td_title = 'Make Unread';
                    //     $toggle_action = 'unread';
                    // } else {
                    //     $td_class = 'qryunread';
                    //     $td_title = 'Make Read';
                    //     $toggle_action = 'read';
                    // }

                    $all_queries_datas = $obj->getAllAdviserQueriesByID($arr_feedback_id[$i]);
                    $total_chats=(isset($all_queries_datas) && !empty($all_queries_datas))? count($all_queries_datas) : 0;

                    $icon=""; $url="";
                    //add by ample 23-04-20
                    if($arr_pg_tbl[$i]=='tblfavcategory')
                    {
                        $icon=$obj->get_icon_of_favcategory($arr_pg_id[$i]);
                    }

                    if ($arr_from_user[$i] == '1')
                    { 
                       $redirect_data=$obj->get_redirection_data('OnlineHub',$arr_feedback_id[$i]);
                    }
                    else
                    {
                        
                        $redirect_data=$obj->get_redirection_data_vendor('OnlineHub',$arr_feedback_id[$i],$arr_vendor_id[$i]);
                        if($redirect_data!=true)
                        {
                          $icon="";
                        }
                    }

?>

                            <tr onmouseover="showRoundIcon('<?php echo $arr_feedback_id[$i]; ?>')" onmouseout="hideRoundIcon('<?php echo $arr_feedback_id[$i]; ?>')" <?=($arr_from_user[$i] ==1)? 'class="warning"' : 'class="active"' ?>> 

                              <td id="td1id_<?php echo $arr_feedback_id[$i]; ?>"  align="center" valign="top" class="<?php echo $td_class; ?>">

                                  <div style="float:left;width:70px;">

                                      <div style="float:left;width:5px;">

                                          <input type="hidden" name="hdntoggle_action" id="hdntoggle_action_<?php echo $arr_feedback_id[$i]; ?>" value="<?php echo $toggle_action; ?>"  />

                                          <div style="display:none;" id="roundicon_<?php echo $arr_feedback_id[$i]; ?>" class="roundicon" title="<?php echo $td_title; ?>" onclick="toggleReadUnreadQuery('<?php echo $arr_feedback_id[$i]; ?>')" ></div>

                                        </div>    

                    <div style="float:right;width:60px;"><?php echo $j; ?></div>

                                    </div>

                                </td>

                                <td id="td2id_<?php echo $arr_feedback_id[$i]; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $arr_aq_user_unique_id[$i]; ?></td>

                                <td id="td3id_<?php echo $arr_feedback_id[$i]; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $pg_name; ?></td>

                                <td id="td4id_<?php echo $arr_feedback_id[$i]; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $arr_feedback[$i]; ?></td>

                                <td id="td5id_<?php echo $arr_feedback_id[$i]; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $date; ?></td>

                                <td align="center" valign="top" class="<?php echo $td_class; ?>">
                                    <?php 
                                      if($icon && $redirect_data!=true)
                                      { 
                                        if($arr_pg_tbl[$i]=='tblfavcategory')
                                        {
                                              $url=$obj->get_url_of_favcategory($arr_pg_id[$i],$page_id,$arr_feedback_id[$i],'OnlineHub',$arr_feedback[$i],'');
                                        }
                                        if(!empty($url))
                                        {
                                        ?>
                                           <a href="<?=$url;?>" target="_blank"> <img src="<?=SITE_URL?>/uploads/<?=$icon;?>" style="width:50px; height: 50px;"/> </a>
                                        <?php
                                        }
                                      }
                                    ?>
                                </td>

                                <td align="center" valign="top" class="<?php echo $td_class; ?>">
                                   <?php 
                                      if($icon && $redirect_data==true)
                                      {
                                        if($arr_pg_tbl[$i]=='tblfavcategory')
                                        {
                                              $url=$obj->get_url_of_favcategory($arr_pg_id[$i],$page_id,$arr_feedback_id[$i],'OnlineHub','','VIEW');
                                        }
                                        if(!empty($url))
                                        {
                                        ?>
                                           <a href="<?=$url;?>" target="_blank"> <img src="<?=SITE_URL?>/uploads/<?=$icon;?>" style="width:50px; height: 50px;"/> </a>
                                        <?php
                                        }
                                      }
                                    ?>
                                </td>

                                <td id="td6id_<?php echo $arr_feedback_id[$i]; ?>" align="center" valign="top" class="<?php echo $td_class; ?>">&nbsp;

                                    <?php
                                if ($arr_from_user[$i] == '0' && $request_status) { 
                                   if(!($total_chats>1)){ 
                                  ?>
                                        <input style="width:45px; height:20px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:9px; font-weight:bold; vertical-align: text-top; color:#000000; padding-bottom:2px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Reply" onclick="showAdviserQueryPopup('<?php echo $arr_feedback_id[$i]; ?>','<?php echo $arr_vendor_id[$i]; ?>' )"/><?php
                                
                                  }
                                } 
                                else
                                {
                                   if(!($total_chats>1)){ 

                                      ?>
                                      <input style="width:55px; height:20px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:9px; font-weight:bold; vertical-align: text-top; color:#000000; padding-bottom:2px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Update" onclick="updateSelfQueryPopup('<?php echo $arr_feedback_id[$i]; ?>')"/>
                                      <?php

                                   }
                                }

                                ?>

                                </td>

                            </tr>

                            <?php 
                              if(!($total_chats>1))
                                { 
                                  ?>
                                  <tr>
                                    <td colspan="8"></td>
                                  </tr>
                                  <?php
                                }
                            ?>
                            



              <?php
                      //echo $arr_feedback_id[$i];

                    $all_queries_data = $obj->getAllAdviserQueriesByID($arr_feedback_id[$i]);
                    // echo "<pre>";
                    // print_r($all_queries_data);
                    // echo "</pre>";
                    // die('jsgbfjhasgfjsa');
                    $total_chat=count($all_queries_data);
                    if (count($all_queries_data) > 0) {
                        $l = 1;
                        foreach ($all_queries_data as $record) {
                            if ($record['aq_id'] != $arr_feedback_id[$i]) //-------------
                            {
                                // echo "<pre>";print_r($record);echo "</pre>";
                                $time = strtotime($record['aq_add_date']);
                                $time = $time + 19800;
                                $date = date('d-M-Y h:i A', $time);
                                //change by ample 04-03-20
                                //$pg_name = $obj->getReportTypeName($record['page_id']);
                                $pg_name = $obj->getReferenceName($arr_pg_id[$i],$arr_pg_tbl[$i]);
                                // if ($record['page_id'] > 0) {
                                //     if ($record['permission_type'] == '1') {
                                //         $pg_name.= ' (Adviser Set)';
                                //     } else {
                                //         $pg_name.= ' (Standard Set)';
                                //     }
                                // }
                                // if ($record['user_read'] == '1') {
                                //     $td_class = 'qryread';
                                //     $td_title = 'Make Unread';
                                //     $toggle_action = 'unread';
                                // } else {
                                //     $td_class = 'qryunread';
                                //     $td_title = 'Make Read';
                                //     $toggle_action = 'read';
                                // }
                            ?>

                           <tr onmouseover="showRoundIcon('<?php echo $record['aq_id']; ?>')" onmouseout="hideRoundIcon('<?php echo $record['aq_id']; ?>')"> 
                              <td id="td1id_<?php echo $record['aq_id']; ?>"  align="center" valign="top" class="<?php echo $td_class; ?>">
                                  <div style="float:left;width:70px;">
                                      <div style="float:left;width:5px;">
                                          <input type="hidden" name="hdntoggle_action" id="hdntoggle_action_<?php echo $record['aq_id']; ?>" value="<?php echo $toggle_action; ?>"  />
                                          <div style="display:none;" id="roundicon_<?php echo $record['aq_id']; ?>" class="roundicon" title="<?php echo $td_title; ?>" onclick="toggleReadUnreadQuery('<?php echo $record['aq_id']; ?>')" ></div>
                                        </div>    
          <div style="float:right;width:60px;">&nbsp;</div>
                                    </div>
                                </td>

                                <td id="td2id_<?php echo $record['aq_id']; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $record['aq_user_unique_id']; ?></td>
                                <td id="td3id_<?php echo $record['aq_id']; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $pg_name; ?></td>
                                <td id="td4id_<?php echo $record['aq_id']; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $record['query']; ?></td>
                                <td id="td5id_<?php echo $record['aq_id']; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $date; ?></td>
                                <td align="center" valign="top" class="<?php echo $td_class; ?>">&nbsp;&nbsp;</td>
                                <td align="center" valign="top" class="<?php echo $td_class; ?>">&nbsp;&nbsp;</td>
                                <td id="td6id_<?php echo $record['aq_id']; ?>" align="center" valign="top" class="<?php echo $td_class; ?>">
                                   
                                  <?php
                                if ($record['from_user'] == '0' && $request_status) { 
                                  if($total_chat==$l){
                                  ?>
                                        <input style="width:45px; height:20px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:9px; font-weight:bold; vertical-align: text-top; color:#000000; padding-bottom:2px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Reply" onclick="showAdviserQueryPopup('<?php echo $record['aq_id']; ?>','<?php echo $arr_temp_adviser[$k]; ?>' )"/><?php
                                }

                                } 
                                else
                                {
                                  if($total_chat==$l)
                                  {
                                  ?>
                                   <input style="width:55px; height:20px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size:9px; font-weight:bold; vertical-align: text-top; color:#000000; padding-bottom:2px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Update" onclick="updateSelfQueryPopup('<?php echo $record['aq_id']; ?>')"/>
                                   <?php
                                  }
                                }


                                ?>
                                    </td>
                            </tr>

                            <?php 
                              if($total_chat==$l)
                                { 
                                  ?>
                                  <tr>
                                    <td colspan="8"></td>
                                  </tr>
                                  <?php
                                }
                            ?>

<!-- -------------------------------------------------------------------------------------- -->

 
                <?php
                            }
                            $l++;
                        }
                        //$l++;
                    }
                    $j++;
                }
            }
?>

                      </table>

                        <table width="100%" border="0" cellpadding="0" cellspacing="0">

                            <tr>

                                <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>

                            </tr>

                        </table>

                        

                        <?php
        }
    } else {
?>

                         <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                          <tr>

                              <td><?php echo $err_msg; ?></td>

                            </tr>

                        </table>

                        <?php
    } ?>

                        

                        

                        <?php
} else { ?>

              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                <tr align="center">

                  <td height="5" class="Header_brown"><?php echo $obj->getCommonSettingValue('3'); ?></td>

                </tr>

              </table>

            <?php
} ?>

                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                            <tr>

                                <td align="left" valign="top">

                                    <?php echo $obj->getScrollingWindowsCodeMainContent($page_id); ?>

                                    <?php echo $obj->getPageContents2($page_id); ?>

                                </td>

                            </tr>

                        </table>


                        <?php 
                  if(isset($_GET['title']) && !empty($_GET['title']))
                  {
                    ?>
                     <button class="btn btn-secondary" style="display: none;" type="button" id="popupBox" onclick="query_box()">Query Box</button>
                    <?php
                  }
                  ?>

   </div>  

   <!-- ad left_sidebar end -->                     

      <div class="col-md-2">  

               <?php include_once ('left_sidebar.php'); ?>

              </div>

    

 <!-- ad right_sidebar end -->

                   

   

</div>

</div>

<!--container-->               

<?php include_once ('footer.php'); ?>

  <!--  Footer-->



 



<!-- Bootstrap Core JavaScript -->



 <!--default footer end here-->

       <!--scripts and plugins -->

        <!--must need plugin jquery-->

       <!-- <script src="csswell/js/jquery.min.js"></script>-->        

        <!--bootstrap js plugin-->



        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>       
        <script>

          //new code by ample 14-11-19
       $('.datepicker').on('focus', function(e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");  
    });

       //added by ample
   function plan_msg()
  {
    $('#plan_msg').fadeIn();
    $("html").animate({ scrollTop: 0 }, "slow");
  }

$(document).ready(function()
            {
                $('#start_date').attr('autocomplete', 'off');
                $('#end_date').attr('autocomplete', 'off');
                $('#start_date').datepicker(
                            {
                                dateFormat: 'dd-mm-yy'

                            }        
                        ); 

                $('#end_date').datepicker(
                        {
                            dateFormat: 'dd-mm-yy'

                        }        
                    ); 

                }
        ); 

  function query_box()
  { 
      var title='<?=$title;?>';
      link='remote.php?action=redirectQueryPopup&title='+title;

      var linkComp = link.split( "?");

      var result;

      var obj = new ajaxObject(linkComp[0], fin);

      obj.update(linkComp[1],"GET");

      obj.callback = function (responseTxt, responseStat) {

              result = responseTxt;

              BootstrapDialog.show({

                      title: 'Add New Query',

                      message:result

              }); 

          //stopPageLoading();
      }
  }

  function addAdviserQueryNew()

  {     

   

      var parent_aq_id = document.getElementById('parent_aq_id').value;

      var temp_pro_user_id = document.getElementById('temp_pro_user_id').value;

      var temp_page_id = document.getElementById('temp_page_id').value;

      var query = escape(document.getElementById('feedback_text').value);

      if(temp_pro_user_id == '')

      {

          alert('Please Select Adviser!');    

      } 

      else if(temp_page_id == '')

      {

          alert('Please Select Reference!');  

      } 

      else if(query == '')

      {

          alert('Please Enter Query!');   

      }

      else

      { 


          link='remote.php?action=addadviserqueryNew&parent_aq_id='+parent_aq_id+'&temp_pro_user_id='+temp_pro_user_id+'&temp_page_id='+temp_page_id+'&query='+query;

          var linkComp = link.split( "?");

          var result;

          var obj = new ajaxObject(linkComp[0], fin);

          obj.update(linkComp[1],"GET");

          obj.callback = function (responseTxt, responseStat) {

              
              // we'll do something to process the data here.

              result = responseTxt.split("::");

              //   alert(result);

              // return false;


                  if(result[0] == 0)

                  {

                      alert(result[1]);

                      location.reload();

                      window.location = "my_adviser_queries.php";

                  }
                  else
                  {
                     alert(result[1]);
                    location.reload();
                  }

              

          }

      }

  }

</script>

<?php 
if(isset($_GET['title']) && !empty($_GET['title']) )
{ 
  $title=base64_decode($_GET['title']);
  ?>
  <script type="text/javascript">
    // $(document).ready(function(){
    //     $("#popupBox").trigger('click'); 
    //      $('#popupBox').click(); 
    // });
  document.getElementById("popupBox").click();
</script>
  <?php
}
?>

</body>

</html>
<?php
require_once ('../classes/config.php');

require_once ('../classes/vendor.php');

$admin_main_menu_id = '35';

$add_action_id = '36';

$page_id = '86';

$obj = new Vendor();

$obj2 = new commonFunctions();

if (!$obj->isVendorLoggedIn())

{

    header("Location: login.php");

    exit(0);

}

else

{

    $adm_vendor_id = $_SESSION['adm_vendor_id'];

    $pro_user_id = $_SESSION['adm_vendor_id'];

}

$vendor_details = $obj->getVendorUserDetails($adm_vendor_id);

if (isset($_POST['btnSubmit']))

{

    $user_id = strip_tags(trim($_POST['user_id']));

    $pg_id = strip_tags(trim($_POST['pg_id']));

    $start_date = strip_tags(trim($_POST['start_date']));

    $end_date = strip_tags(trim($_POST['end_date']));

    $search_keywords = strip_tags(trim($_POST['search_keywords']));

}

else

{

    $user_id = '';

    $pg_id = '';

    $start_date = '';

    $end_date = '';

    $search_keywords = '';

}

if (isset($_POST['user_id']))

{

    $user_id = strip_tags(trim($_POST['user_id']));

}

elseif (isset($_SESSION['user_query_user_id']))

{

    $user_id = $_SESSION['user_query_user_id'];

}

else

{

    $user_id = '';

}

if (isset($_POST['pg_id']))

{

    $pg_id = strip_tags(trim($_POST['pg_id']));

}

elseif (isset($_SESSION['user_query_pg_id']))

{

    $pg_id = $_SESSION['user_query_pg_id'];

}

else

{

    $pg_id = '';

}

if (isset($_POST['start_date']))

{

    $start_date = strip_tags(trim($_POST['start_date']));

}

elseif (isset($_SESSION['user_query_start_date']))

{

    $start_date = $_SESSION['user_query_start_date'];

}

else

{

    $start_date = '';

}

if (isset($_POST['end_date']))

{

    $end_date = strip_tags(trim($_POST['end_date']));

}

elseif (isset($_SESSION['user_query_end_date']))

{

    $end_date = $_SESSION['user_query_end_date'];

}

else

{

    $end_date = '';

}

if (isset($_POST['search_keywords']))

{

    $search_keywords = strip_tags(trim($_POST['search_keywords']));

}

elseif (isset($_SESSION['user_query_search_keywords']))

{

    $search_keywords = $_SESSION['user_query_search_keywords'];

}

else

{

    $search_keywords = '';

}

$_SESSION['user_query_user_id'] = $user_id;

$_SESSION['user_query_pg_id'] = $pg_id;

$_SESSION['user_query_start_date'] = $start_date;

$_SESSION['user_query_end_date'] = $end_date;

$_SESSION['user_query_search_keywords'] = $search_keywords;

if ($start_date == '' || $end_date == '')

{

    $error = true;

    $err_msg = '<span class="Header_blue">Please select From and To date.</span>';

}

else

{

    //die('trtweetw');
    

    $referral_data = $obj->getAllAdviserUserQueries($pro_user_id, $user_id, $pg_id, $start_date, $end_date, $search_keywords);

    // echo "<pre>";
    // print_r($referral_data);
    // die('lksjfka');
    if (count($referral_data) > 0)

    {

        $error = false;

        $err_msg = '';

    }

    else

    {

        $error = true;

        $err_msg = '<span class="err_msg">No Records Found!</span>';

    }

}

?><!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title><?php echo SITE_NAME; ?> - Business Associates</title>
      <?php require_once 'head.php'; ?>
      <link href="assets/css/tokenize2.css" rel="stylesheet" />
   </head>
   <body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">
      <?php include_once ('header.php'); ?>
      <div class="container">
         <div class="row">
            <div class="col-sm-10">
               <div class="panel">
                  <div class="panel-body">
                     <div class="row mail-header">
                        <div class="col-md-6">
                           <h3><?php echo $obj->getAdminActionName($add_action_id); ?></h3>
                        </div>
                     </div>
                     <hr>
                     <center>
                      <!--   <div id="error_msg" style="color: red;"><?php if ($error)
                        {
                            echo $err_msg;
                        } ?></div> -->
                     </center>
                     <!--for get page icon 22-04-20 -->
                      <?php echo $obj->getPageIcon($page_id);?>
                     <?php echo $obj->getPageContents($page_id); ?>
                     <br>
                     <div>
                        <form name="frmadviserquery" method="post" action="#" >
                           <table width="100%" border="0" align="left" cellpadding="5" cellspacing="1" >
                              <tr>
                                 <td width="20%" height="50" align="left" valign="middle" bgcolor="#FFFFFF">
                                    <strong class="Header_brown">From date</strong>
                                 </td>
                                 <td width="25%">
                                    <input name="start_date" id="start_date" type="text" value="<?php echo $start_date; ?>" class="form-control datepicker" style="width: 150px!important" />
                                 </td>
                                 <td width="5%"></td>
                                 <td width="20%"><strong class="Header_brown">To date</strong></td>
                                 <td width="30%">
                                    <input name="end_date" id="end_date" type="text" value="<?php echo $end_date; ?>" class="form-control datepicker" style="width: 150px!important" />
                                 </td>
                              </tr>
                              <tr>
                                 <td width="20%" height="50">
                                    <strong class="Header_brown">Search Keyword</strong>
                                 <td width="70%" colspan="4">                               
                                    <input name="search_keywords" id="search_keywords" type="text" value="<?php echo $search_keywords; ?>" class="form-control" />
                                 </td>
                              </tr>
                              <tr>
                                 <td width="20%" align="left" valign="middle" bgcolor="#FFFFFF" height="50">
                                    <label><strong class="Header_brown">Search For</strong></label>
                                 </td>
                                 <td width="25%">
                                    <select name="user_id" id="user_id" class="form-control" onchange="getUserQueryPageOptions('<?php echo $pro_user_id; ?>','','user_id','pg_id');">
                                       <option value="">All Users</option>
                                       <?php //echo $obj->getAdvisersUserOptions($user_id,$pro_user_id);
                                      echo $obj->getAdviserAcceptedUsersOptions($user_id, $adm_vendor_id);

                                      ?>
                                    </select>
                                 </td>
                                 <td width="5%"></td>
                                 <td width="20%">
                                    <label><strong class="Header_brown">   My Patterns </strong></label>
                                 </td>
                                 <td width="30%">
                                    <span id="idreference">
                                       <select name="pg_id" id="pg_id" class="form-control">
                                          <option value="">All Patterns</option>
                                          <?php
                                                //echo $obj->getReportnameOfUser('User'); //update by ample
                                                echo $obj->getAdviserQueryReference('','','1',$pg_id);

                                                //echo $obj->getUserQueryPageOptions($pg_id,$user_id,$pro_user_id);
                                                 ?>
                                       </select>
                                    </span>
                                    &nbsp;
                                 </td>
                              </tr>
                              <tr>
                                 <td height="50">
                                 </td>
                                 <td colspan="4">
                                    <input type="submit" name="btnSubmit" value="Search" class="btn btn-primary" />
                                 </td>
                              </tr>
                           </table>
                        </form>
                     </div>
                     <div id="">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                           <tr>
                              <td class="footer" height="30">&nbsp;</td>
                           </tr>
                        </table>
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                           <tr>
                              <td width="100%" align="left" valign="top">
                                 <?php
if (!$error)

{

    $arr_temp_user_id = array();

    foreach ($referral_data as $record)

    {

        //print_r($record);
        

        array_push($arr_temp_user_id, $record['user_id']);

    }

    $arr_temp_user = array_unique($arr_temp_user_id);

    $arr_temp_user = array_values($arr_temp_user);

    for ($k = 0;$k < count($arr_temp_user);$k++)

    {
        //add by ample 06-03-20
        list($ar_id, $request_status,$last_status) = $obj->chkIfIsAdvisersReferralsData($pro_user_id, $arr_temp_user[$k]);

        // if ($request_status)
        // {
        //     $adviser_status = '<span class="Header_blue">Activated By User</span>';
        // }
        // else
        // {
        //     $adviser_status = '<span class="Header_red">Deactivated By User</span>';
        // }

            if($last_status==1)
                {
                   $status_by = ' By Me';
                }
                else
                {
                  $status_by = ' By User';
                }

                if ($request_status == 1) {
                    $adviser_status = '<span class="Header_blue">Activated '.$status_by.'</span>';
                    $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Deactivate" onclick="showDeactivateUserInvitationPopup(\'' . $ar_id . '\',\'' . $arr_temp_user[$k] . '\',\'' . $pro_user_id . '\')">';
                    $action3='<input class="btnReply" type="button" name="btnReply" id="btnReply" style="width: 75px;" value="Add Inputs" onclick="showUserQueryPopup(\'' . "". '\',\'' . $arr_temp_user[$k] . '\')"/> ';
                } else {
                    $adviser_status = '<span class="Header_red">Deactivated '.$status_by.'</span>';
                     $action2=''; $action3='';
                    if($last_status == '1')
                      {
                           $action2 = '<input type="button" name="btnDecline" id="btnDecline" value="Activate" onclick="showActivateUserInvitationPopup(\'' . $ar_id . '\',\'' . $arr_temp_user[$k] . '\',\'' . $pro_user_id . '\')">';
                      }
                    
                    $action = '';
                }

?>
                                 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                       <td width="20%" align="left" valign="middle"><strong>User Name: <?php echo $obj->getUserFullNameById($arr_temp_user[$k]); ?></strong></td>
                                       <td width="20%" align="left" valign="middle"><strong>Status: <?php echo $adviser_status; ?></strong></td>
                                        <td width="10%" align="left" valign="middle">
                                        <?php echo $action3; ?> </td>
                                       <td width="10%" align="left" valign="middle"><?php echo $action2; ?></td>
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
        $i = 1;

        foreach ($referral_data as $record)

        {

            //print_r($record);
            if ($record['user_id'] == $arr_temp_user[$k])

            {

                $time = strtotime($record['aq_add_date']);

                $time = $time + 19800;

                $date = date('d-M-Y h:i A', $time);

                //$pg_name = $obj->getReportTypeName($record['page_id']);
                //change by ample 04-03-20
                $pg_name = $obj->getReferenceName($record['page_id'], $record['page_table']);
                // if($record['page_id'] > 0)
                // {
                //   if($record['permission_type'] == '1')
                //   {
                //      $pg_name .= ' (Adviser Set)';
                //   }
                //   else
                //   {
                //      $pg_name .= ' (Standard Set)';
                //   }
                // }
                

                // if ($record['pro_user_read'] == '1')

                // {

                //     $td_class = 'qryread';

                //     $td_title = 'Make Unread';

                //     $toggle_action = 'unread';

                // }

                // else

                // {

                //     $td_class = 'qryunread';

                //     $td_title = 'Make Read';

                //     $toggle_action = 'read';

                // }

                $all_queries_data = $obj->getAllAdviserQueriesByID($record['aq_id']);
                $total_chat=(isset($all_queries_data) && !empty($all_queries_data))? count($all_queries_data) : 0;


                 $icon=""; $url="";
                 //add by ample 23-04-20
                    if($record['page_table']=='tblfavcategory')
                    {
                        $icon=$obj->get_icon_of_favcategory($record['page_id']);
                        
                    }

                    if ($record['from_user'] == '1')
                    {
                        $redirect_data=$obj->get_redirection_data_user('OnlineHub',$record['aq_id'],$record['user_id']);
                        if($redirect_data!=true)
                        {
                          $icon=""; 
                        }
                    }
                    else
                    {
                        
                        $redirect_data=$obj->get_redirection_data('OnlineHub',$record['aq_id']);

                         //print_r($redirect_data);  die('--sssssss-');
                    }

                    //print_r($redirect_data);  die('---');
                    

?>
                                    <tr onmouseover="showRoundIcon('<?php echo $record['aq_id']; ?>')" onmouseout="hideRoundIcon('<?php echo $record['aq_id']; ?>')" <?=($record['from_user'] ==1)? 'class="warning"' : 'class="active"' ?>>
                                       <td id="td1id_<?php echo $record['aq_id']; ?>" height="30" align="center" valign="middle" class="<?php echo $td_class; ?>">
                                          <div style="float:left;width:70px;">
                                             <div style="float:left;width:5px;">
                                                <input type="hidden" name="hdntoggle_action" id="hdntoggle_action_<?php echo $record['aq_id']; ?>" value="<?php echo $toggle_action; ?>"  />
                                                <div style="display:none;" id="roundicon_<?php echo $record['aq_id']; ?>" class="roundicon" title="<?php echo $td_title; ?>" onclick="toggleReadUnreadQuery('<?php echo $record['aq_id']; ?>')" ></div>
                                             </div>
                                             <div style="float:right;width:60px;"><?php echo $i; ?></div>
                                          </div>
                                       </td>
                                       <td id="td2id_<?php echo $record['aq_id']; ?>" height="30" align="center" valign="middle" class="<?php echo $td_class; ?>"><?php echo $record['aq_user_unique_id']; ?></td>
                                       <td id="td3id_<?php echo $record['aq_id']; ?>" height="30" align="center" valign="middle" class="<?php echo $td_class; ?>"><?php echo $pg_name; ?></td>
                                       <td id="td4id_<?php echo $record['aq_id']; ?>" height="30" align="center" valign="middle" class="<?php echo $td_class; ?>"><?php echo $record['query']; ?></td>
                                       <td id="td5id_<?php echo $record['aq_id']; ?>" height="30" align="center" valign="middle" class="<?php echo $td_class; ?>"><?php echo $date; ?></td>
                                       <td align="center" valign="middle" class="<?php echo $td_class; ?>">
                                        <?php 
                                          if($icon && $redirect_data!=true)
                                          {
                                             if($record['page_table']=='tblfavcategory')
                                              {
                                                    $url=$obj->get_url_of_favcategory($record['page_id'],$page_id,$record['aq_id'],'OnlineHub',$record['query']);
                                              }
                                              if(!empty($url))
                                              {
                                            ?>
                                               <a href="<?=MAIN_URL.$url;?>" target="_blank"> <img src="<?=MAIN_URL?>/uploads/<?=$icon;?>" style="width:50px; height: 50px;"/> </a>
                                            <?php
                                            }
                                          }
                                        ?>
                                    </td>

                                    <td align="center" valign="middle" class="<?php echo $td_class; ?>">
                                       <?php 
                                          if($icon && $redirect_data==true)
                                          {
                                            if($record['page_table']=='tblfavcategory')
                                              {
                                                    $url=$obj->get_url_of_favcategory($record['page_id'],$page_id,$record['aq_id'],'OnlineHub','','VIEW');
                                              }
                                              if(!empty($url))
                                              {
                                            ?>
                                               <a href="<?=MAIN_URL.$url;?>" target="_blank"> <img src="<?=MAIN_URL?>/uploads/<?=$icon;?>" style="width:50px; height: 50px;"/> </a>
                                            <?php
                                            }
                                          }
                                        ?>
                                    </td>
                                       <td id="td6id_<?php echo $record['aq_id']; ?>" height="30" align="center" valign="middle" class="<?php echo $td_class; ?>"><?php if ($record['from_user'] == '1' && $request_status)
                { 
                  if(!($total_chat>1)){ 
                  ?>
                                          <input class="btnReply" type="button" name="btnReply" id="btnReply" value="Reply" onclick="showUserQueryPopup('<?php echo $record['aq_id']; ?>','<?php echo $record['user_id']; ?>' )"/><?php
                  } 

                }
                else
                {
                  if(!($total_chat>1)){ 

                    ?>
                    <input style="width:55px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Update" onclick="updateSelfQueryPopup('<?php echo $record['aq_id']; ?>')"/>
                   <?php

                  }
                  
                }

                ?>
                                       </td>
                                    </tr>

                                      <?php 
                              if(!($total_chat>1))
                                { 
                                  ?>
                                  <tr>
                                    <td colspan="8"></td>
                                  </tr>
                                  <?php
                                }
                            ?>



                                    <?php
                if (count($all_queries_data) > 0)

                {

                    $l = 1;

                    foreach ($all_queries_data as $record2)

                    {

                        if ($record2['aq_id'] != $record['aq_id'])

                        {

                            $time = strtotime($record2['aq_add_date']);

                            $time = $time + 19800;

                            $date = date('d-M-Y h:i A', $time);

                            //$pg_name = $obj->getReportTypeName($record2['page_id']);
                            //change by ample 04-03-20
                            $pg_name = $obj->getReferenceName($record2['page_id'],$record2['page_table']);
                            // if($record2['page_id'] > 0)
                            // {
                            //   if($record2['permission_type'] == '1')
                            //   {
                            //      $pg_name .= ' (Adviser Set)';
                            //   }
                            //   else
                            //   {
                            //      $pg_name .= ' (Standard Set)';
                            //   }
                            // }
                            

                            // if ($record2['user_read'] == '1')

                            // {

                            //     $td_class = 'qryread';

                            //     $td_title = 'Make Unread';

                            //     $toggle_action = 'unread';

                            // }

                            // else

                            // {

                            //     $td_class = 'qryunread';

                            //     $td_title = 'Make Read';

                            //     $toggle_action = 'read';

                            // }

?>
                                    <tr onmouseover="showRoundIcon('<?php echo $record2['aq_id']; ?>')" onmouseout="hideRoundIcon('<?php echo $record2['aq_id']; ?>')">
                                       <td id="td1id_<?php echo $record2['aq_id']; ?>"  align="center" valign="top" class="<?php echo $td_class; ?>">
                                          <div style="float:left;width:70px;">
                                             <div style="float:left;width:5px;">
                                                <input type="hidden" name="hdntoggle_action" id="hdntoggle_action_<?php echo $record2['aq_id']; ?>" value="<?php echo $toggle_action; ?>"  />
                                                <div style="display:none;" id="roundicon_<?php echo $record2['aq_id']; ?>" class="roundicon" title="<?php echo $td_title; ?>" onclick="toggleReadUnreadQuery('<?php echo $record2['aq_id']; ?>')" ></div>
                                             </div>
                                             <div style="float:right;width:60px;">&nbsp;</div>
                                          </div>
                                       </td>
                                       <td id="td2id_<?php echo $record2['aq_id']; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $record2['aq_user_unique_id']; ?></td>
                                       <td id="td3id_<?php echo $record2['aq_id']; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $pg_name; ?></td>
                                       <td id="td4id_<?php echo $record2['aq_id']; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $record2['query']; ?></td>
                                       <td id="td5id_<?php echo $record2['aq_id']; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php echo $date; ?></td>
                                        <td align="center" valign="top" class="<?php echo $td_class; ?>">&nbsp;&nbsp;</td>
                                        <td align="center" valign="top" class="<?php echo $td_class; ?>">&nbsp;&nbsp;</td>
                                       <td id="td6id_<?php echo $record2['aq_id']; ?>" align="center" valign="top" class="<?php echo $td_class; ?>"><?php if ($record2['from_user'] == '1' && $request_status)
                            { 
                              // echo $total_chat; echo "----"; echo $l;
                              if($total_chat==$l){
                              ?>
                                          <input class="btnReply" type="button" name="btnReply" id="btnReply" value="Reply" onclick="showUserQueryPopup('<?php echo $record2['aq_id']; ?>','<?php echo $page_id; ?>' )"/><?php
                              } 
                            }
                            else
                            {
                              if($total_chat==$l){
                                ?>
                                  <input style="width:55px;" class="btnReply" type="button" name="btnReply" id="btnReply" value="Update" onclick="updateSelfQueryPopup('<?php echo $record2['aq_id']; ?>')"/>
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


                                    <?php
                        }
                        $l++;
                    }

                   // $l++;

                }

                $i++;

            }

        } ?>
                                 </table>
                                 <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                       <td height="30" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                                    </tr>
                                 </table>
                                 <?php
    }

}

else

{ ?>
                                 <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                       <td height="30" align="left" valign="middle" bgcolor="#FFFFFF" class="err_msg"><?php echo $err_msg; ?></td>
                                    </tr>
                                 </table>
                                 <?php
} ?>
                              </td>
                           </tr>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-sm-2"><?php include_once('wa_right_sidebar.php'); ?></div>
         </div>
      </div>
      <?php include_once ('footer.php'); ?>
      <!--Common plugins-->
      <?php require_once ('script.php'); ?>
      <script type="text/javascript" src="js/jquery.validate.min.js"></script>
      <script src="js/tokenize2.js"></script>
      <script>


        $('.datepicker').on('focus', function(e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");  
    });

         $(document).ready(function()
         
         { 
         
             var dataString ='action=myuserquery';
         
            $.ajax({
         
               type: "POST",
         
               url: "ajax/remote.php",
         
               data: dataString,
         
               cache: false,
         
               success: function(result)
         
               {
         
                  $("#myuserquery").html(result);
         
               }
         
            });
         
                 
         
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
         
                 
         
                 
         
         }); 
         
         
         
         
         
         
         function showRoundIcon(idval)
         
         {
         
            $('#roundicon_'+idval).show();
         
         }
         
         
         
         function hideRoundIcon(idval)
         
         {
         
            $('#roundicon_'+idval).hide();
         
         }
         
         
        
         
         //add by ample 05-03-20

         function toggleReadUnreadQuery(idval)

        {

            var tgaction = $('#hdntoggle_action_'+idval).val();

            link='ajax/remote.php?action=togglereadunreadquery&tgaction='+tgaction+'&idval='+idval;

            var linkComp = link.split( "?");

            var result;

            var obj = new ajaxObject(linkComp[0], fin);

            obj.update(linkComp[1],"GET");

            obj.callback = function (responseTxt, responseStat) {

                // we'll do something to process the data here.

                result = responseTxt;

                if(tgaction == 'read')

                {

                    $('#td1id_'+idval).removeClass("qryunread");

                    $('#td2id_'+idval).removeClass("qryunread");

                    $('#td3id_'+idval).removeClass("qryunread");

                    $('#td4id_'+idval).removeClass("qryunread");

                    $('#td5id_'+idval).removeClass("qryunread");

                    $('#td6id_'+idval).removeClass("qryunread");

                    

                    $('#td1id_'+idval).addClass("qryread");

                    $('#td2id_'+idval).addClass("qryread");

                    $('#td3id_'+idval).addClass("qryread");

                    $('#td4id_'+idval).addClass("qryread");

                    $('#td5id_'+idval).addClass("qryread");

                    $('#td6id_'+idval).addClass("qryread");

                    

                    $('#hdntoggle_action_'+idval).val('unread');

                }

                else if(tgaction == 'unread')

                {

                    $('#td1id_'+idval).removeClass("qryread");

                    $('#td2id_'+idval).removeClass("qryread");

                    $('#td3id_'+idval).removeClass("qryread");

                    $('#td4id_'+idval).removeClass("qryread");

                    $('#td5id_'+idval).removeClass("qryread");

                    $('#td6id_'+idval).removeClass("qryread");

                    

                    $('#td1id_'+idval).addClass("qryunread");

                    $('#td2id_'+idval).addClass("qryunread");

                    $('#td3id_'+idval).addClass("qryunread");

                    $('#td4id_'+idval).addClass("qryunread");

                    $('#td5id_'+idval).addClass("qryunread");

                    $('#td6id_'+idval).addClass("qryunread");

                    

                    $('#hdntoggle_action_'+idval).val('read');

                }

                else

                {

                

                }

            }

        }

         // copy by ample 06-03-20
            function showActivateUserInvitationPopup(ar_id,puid,vendor)

          {

            // alert(vendor);

            

                  var dataString ='action=showactivateuserinvitationpopup&ar_id='+ar_id+'&puid='+puid+'&vendor='+vendor;

            $.ajax({

              type: "POST",

              url: "ajax/remote.php",

              data: dataString,

              cache: false,

              success: function(result)

              {

                             BootstrapDialog.show({

                                  title: 'User Activation',

                                  message:result

                              });

              }

            });

                  

          }





          function showDeactivateUserInvitationPopup(ar_id,puid,vendor)

          {

           // alert(vendor);

                  var dataString ='action=showdeactivateuserinvitationpopup&ar_id='+ar_id+'&puid='+puid+'&vendor='+vendor;

            $.ajax({

              type: "POST",

              url: "ajax/remote.php",

              data: dataString,

              cache: false,

              success: function(result)

              {

                             BootstrapDialog.show({

                                  title: 'User Deactivation',

                                  message:result

                              });

              }

            });

                  

          }
         
         function deactivateUserInvitation(ar_id,puid,vendor_id)

        {

          var Choice = confirm("Do you wish to Deactivate User?");

          if (Choice == true)

          {

            var status_reason = escape($("#status_reason").val());

            if(status_reason == '')

            {

              alert('Please enter reason for deactivation');

            }

            else

            {

                                var dataString ='action=deactivateuserinvitation&ar_id='+ar_id+'&puid='+puid+'&status_reason='+status_reason+'&vendor='+vendor_id;

                                    $.ajax({

                                            type: "POST",

                                            url: "ajax/remote.php",

                                            data: dataString,

                                            cache: false,

                                            success: function(result)

                                            {

                                               window.location.reload(true);

                                            }

                                    });



                                

            } 

          } 

        }



        function activateUserInvitation(ar_id,puid,vendor)

        {

          var Choice = confirm("Do you wish to Activate User?");

          if (Choice == true)

          {

            var status_reason = escape($("#status_reason").val());

            if(status_reason == '')

            {

              alert('Please enter reason for activation');

            }

            else

            {

                                var dataString ='action=activateuserinvitation&ar_id='+ar_id+'&puid='+puid+'&status_reason='+status_reason+'&vendor='+vendor;

                                    $.ajax({

                                            type: "POST",

                                            url: "ajax/remote.php",

                                            data: dataString,

                                            cache: false,

                                            success: function(result)

                                            {

                                               window.location.reload(true);

                                            }

                                    });

                                

                                

            } 

          } 

        }

         
      </script>
   </body>
</html>
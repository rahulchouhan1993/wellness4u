<?php

include('classes/config.php');

$page_id = '115';

$obj = new frontclass();

$obj2 = new frontclass2();

$page_data = $obj->getPageDetails($page_id);

//list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode('refer_a_adviser.php');

//print_r($_SESSION);

//exit();

if(!$obj->isLoggedIn())

{

   echo "<script>window.location.href='login.php?ref=$ref'</script>";

    exit(0);

    // header("Location: login.php?ref=".$ref);

    // exit(0);

}

else

{

    $user_id = $_SESSION['user_id'];

    $obj->doUpdateOnline($_SESSION['user_id']);

}

$user_upa_id = $obj->getupaid($page_id);

$plan_flag = $obj->Checkifplanexist($user_upa_id);

if($plan_flag)

{

    if($obj->chkUserPlanFeaturePermission($user_id,$user_upa_id))

    {

            $page_access = true;

    }

    else

    {

            $page_access = false;

    }

}

else

{

  $page_access = true;  

}

$error = false;

$msg = '';

if(isset($_POST['submit']))

{

    
    $user_name = strip_tags(trim($_POST['user_name']));

    $user_email = strip_tags(trim($_POST['user_email']));

    $msg = strip_tags(trim($_POST['msg']));

    if($user_email == '')

    {

            $error = true;

            $err_msg = 'Please enter email of adviser';

    }

    //elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $user_email))

    elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) 

    {

            $error = true;

            $err_msg = 'Please enter valid email';

    }

    elseif($obj->chkIfRequestAlreadySentByuser($user_id,$user_email))

    {

            $error = true;

            $err_msg = 'You have already sent request to this adviser.';

    }


    if($user_name == '')

    {

       $error = true;

       $err_msg .='<br>Please enter name of adviser';

    }



    if(!$error)

    {

        if($obj->chkVendorEmailExists($user_email))

        {

            $new_user = 0;

            if($obj->chkIfUserIsAdvisersReferralsChkByProEmail($user_email,$user_id))

            {

                $error = true;

                $err_msg = 'Adviser have already added to you.';

            }

        }

        else

        {

            $new_user = 1;

        }

        if(!$error)

        {     
            $invite_by_user = 1;

            $arid = $obj->addUsersReferral($user_id,$user_email,$user_name,$msg,$new_user,$invite_by_user,$referral_status);

            if($arid > 0)

            {

                    if($new_user == 1)

                    {   

                            $url = SITE_URL.'/wa_register.php?arid='.base64_encode($arid).'&puid='.base64_encode($user_id).'';

                            $from_user = $obj->getUserFullNameById($user_id);

                            //list($email_ar_subject,$email_ar_from_name,$email_ar_from_email,$email_ar_to_email,$email_ar_body) = $obj->getEmailAutoresponderDetails('9');

                            $mail_data =$obj->getEmailAutoresponderDetails('9'); 

                            $to_email = $user_email;

                            //$from_email = $email_ar_from_email;

                            if($mail_data['email_ar_from_name'] == '[[FROM_USER]]')

                            {

                                    $from_name = $from_user;

                            }

                            else

                            {

                                    $from_name = $mail_data['email_ar_from_name'];

                            }

                        //     echo "hi";

                        // exit;

                            $from_email = $mail_data['email_ar_from_email'];

                            //$from_name = $mail_data['email_ar_from_name'];

                            $subject = $mail_data['email_ar_subject'];

                            $message = $mail_data['email_ar_body'];

                            //$subject = $email_ar_subject;

                            $subject = str_ireplace("[[FROM_USER]]", $from_user, $subject);

                            //$message = $email_ar_body;

                            $message = str_ireplace("[[USER_NAME]]", $user_name, $message);

                            $message = str_ireplace("[[FROM_USER]]", $from_user, $message);

                            $message = str_ireplace("[[MSG]]", ucfirst(trim($msg)), $message);

                            $message = str_ireplace("[[ANCHER_URL_START]]", '<a href="'.$url.'">', $message);

                            $message = str_ireplace("[[ANCHER_URL_END]]", '</a>', $message);

                            $message = str_ireplace("[[URL]]", $url, $message);

                            $mail = new PHPMailer();

                            $mail->IsHTML(true);

                            $mail->Host = "batmobile.websitewelcome.com"; // SMTP server

                            $mail->From = $from_email;

                            $mail->FromName = $from_name;

                            $mail->AddAddress($to_email);

                            $mail->Subject = $subject;

                            $mail->Body = $message;

                            $mail->Send();

                            $mail->ClearAddresses();

                    }

                    else

                    {

                    }       

                    header("Location: message.php?msg=5");  //13 is old message id

                    exit(0);        

            }

            else 

            {

                    $error = true;

                    $err_msg = 'Somthing Went Wrong Try later.';

            }

        }

    }

    if($err_msg != '')

        {

            $err_msg = '<div class="err_msg_box"><span class="blink_me">'.$err_msg.'</span></div>';

         }

}

?>
    <!DOCTYPE html>

    <html lang="en">

    <head>

        <?php include_once('head.php');?>

            <!-- <link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css"> -->

            <!-- <script type="text/javascript" src="w_js/jquery-1.12.4.min.js" charset="UTF-8"></script> -->

            <!-- <script type="text/javascript" src="w_js/datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script> -->

            <style>
                .ui-datepicker-header {
                    display: none!important;
                }
            </style>

    </head>

    <body>

        <?php include_once('analyticstracking.php'); ?>

            <?php include_once('analyticstracking_ci.php'); ?>

                <?php include_once('analyticstracking_y.php'); ?>

                    <?php include_once('header.php');?>

                        <div class="container">

                            <div class="breadcrumb">

                                <div class="row">

                                    <div class=" col-md-8">

                                        <?php echo $obj->getBreadcrumbCode($page_id);?>

                                    </div>

                                    <div class=" col-md-4">

                                        <?php

                                    if($obj->isLoggedIn())

                                    { 

                                        echo $obj->getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);

                                    }

                                    ?>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!--container-->

                        <div class="container">

                            <div class="row">

                                <div class=" col-md-8">

                                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                                        <tr>

                                            <td align="left" valign="top">

                                                <span class="Header_brown"><?php echo $obj->getPageTitle($page_id);?></span>
                                                <br />
                                                <br />

                                                <?php echo $obj->getPageContents($page_id);?>

                                            </td>

                                        </tr>

                                    </table>

                                    <?php

                        if($page_access)

                        { ?>

                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">

                                            <tr>

                                                <td width="100%" align="left" valign="top">

                                                    <form action='#' method="post">

                                                        <table border="0" width="100%" cellpadding="0" cellspacing="0">

                                                            <tr>

                                                                <td colspan="2" align="left" class="err_msg">
                                                                    <?php echo $err_msg;?>
                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td width="20%" height="30" align="left" valign="top"><span style="color:red;">*</span>Email ID:</td>

                                                                <td width="80%" height="30" align="left" valign="top">
                                                                    <input class="form-control" type="text" name="user_email" id="user_email" value="<?php echo $user_email; ?>" />
                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td colspan="2" height="30" align="left" valign="top">&nbsp;</td>

                                                            </tr>

                                                            <tr>

                                                                <td height="30" align="left" valign="top"><span style="color:red;">*</span>User Name:</td>

                                                                <td height="30" align="left" valign="top">
                                                                    <input class="form-control" type="text" name="user_name" id="user_name" value="" />
                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td colspan="2" height="30" align="left" valign="top">&nbsp;</td>

                                                            </tr>

                                                            <tr>

                                                                <td height="30" align="left" valign="top"><span style="color:red;">*</span>Message:</td>

                                                                <td height="30" align="left" valign="top">
                                                                    <textarea class="form-control" cols="30" name="msg" id="msg"><?php echo $msg;?></textarea>
                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td colspan="2" height="30" align="left" valign="top">&nbsp;</td>

                                                            </tr>

                                                            <tr>

                                                                <td height="30" align="left" valign="top">&nbsp;</td>

                                                                <td height="30" align="left" valign="top">
                                                                    <input type="submit" name="submit" class="btn btn-primary" id="submit" value="Send Request" />
                                                                </td>

                                                            </tr>

                                                            <tr>

                                                                <td colspan="2" height="30" align="left" valign="top">&nbsp;</td>

                                                            </tr>

                                                        </table>

                                                    </form>

                                                </td>

                                            </tr>

                                        </table>

                                        <?php 

                        } 

                        else 

                        { ?>

                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                                                <tr align="center">

                                                    <td height="5" class="Header_brown">
                                                        <?php echo $obj->getCommonSettingValue('3');?>
                                                    </td>

                                                </tr>

                                            </table>

                                            <?php 

                        } ?>

                                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                                                    <tr>

                                                        <td align="left" valign="top">

                                                            <?php echo $obj->getScrollingWindowsCodeMainContent($page_id);?>

                                                                <?php echo $obj->getPageContents2($page_id);?>

                                                        </td>

                                                    </tr>

                                                </table>

                                </div>

                                <!-- ad left_sidebar-->

                                <div class="col-md-2">

                                    <?php include_once('left_sidebar.php'); ?>

                                </div>

                                <!-- ad left_sidebar end -->

                                <!-- ad right_sidebar-->

                                <div class="col-md-2">

                                    <?php include_once('right_sidebar.php'); ?>
                                </div>

                                <!-- ad right_sidebar end -->

                            </div>

                        </div>

                        <!--container-->

                        <!--footer -->

                        <?php include_once('footer.php');?>

                            <!--footer end -->

                            <!-- Bootstrap Core JavaScript -->

                            <!--default footer end here-->

                            <!--scripts and plugins -->

                            <!--must need plugin jquery-->

                            <!-- <script src="csswell/js/jquery.min.js"></script>         -->

                            <!--bootstrap js plugin-->

                            <!-- <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>        -->

    </body>

    </html>
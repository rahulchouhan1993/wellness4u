<?php

include('classes/config.php');

$obj = new frontclass();

$page_id = '164';



$main_page_id = $page_id;



//list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);



$page_data = $obj->getPageDetails($page_id);

$ref = base64_encode('user_dashboard.php');



if(!$obj->isLoggedIn())



{



    echo "<script>window.location.href='login.php?ref=$ref'</script>";

//    header("Location: login.php?ref=".$ref);

//

//    exit(0);



}



else



{



    $user_id = $_SESSION['user_id'];



    $obj->doUpdateOnline($_SESSION['user_id']);

    

    $user_left_menu = $obj->GETUSERLEFTMENU('left');

    $user_right_menu = $obj->GETUSERLEFTMENU('right');

    $user_top_menu_1 = $obj->GETUSERLEFTMENU('top_1');

    $user_top_menu_2 = $obj->GETUSERLEFTMENU('top_2');

    

    $user_middle_menu_2 = $obj->GETUSERLEFTMENU('middle_2');

    $user_middle_menu_3 = $obj->GETUSERLEFTMENU('middle_3');

    $user_middle_menu_4 = $obj->GETUSERLEFTMENU('middle_4');

    

    $user_bottom_menu_1 = $obj->GETUSERLEFTMENU('bottom_1');

    $user_bottom_menu_2 = $obj->GETUSERLEFTMENU('bottom_2');

    $user_bottom_menu_3 = $obj->GETUSERLEFTMENU('bottom_3');

    $user_bottom_menu_4 = $obj->GETUSERLEFTMENU('bottom_4');

    $user_bottom_menu_5 = $obj->GETUSERLEFTMENU('bottom_5');

    $user_bottom_menu_6 = $obj->GETUSERLEFTMENU('bottom_6');

    $user_bottom_menu_7 = $obj->GETUSERLEFTMENU('bottom_7');

    $user_bottom_menu_8 = $obj->GETUSERLEFTMENU('bottom_8');

    $user_bottom_menu_9 = $obj->GETUSERLEFTMENU('bottom_9');

    $user_bottom_menu_10 = $obj->GETUSERLEFTMENU('bottom_10');

    

    

    

    $user_top_menu_1_header = $obj->GETUSERDASHBOARDHEADER('top_1');

    $user_top_menu_2_header = $obj->GETUSERDASHBOARDHEADER('top_2');

    

    $user_middle_menu_2_header = $obj->GETUSERDASHBOARDHEADER('middle_2');

    $user_middle_menu_3_header = $obj->GETUSERDASHBOARDHEADER('middle_3');

    $user_middle_menu_4_header = $obj->GETUSERDASHBOARDHEADER('middle_4');

    

    $user_bottom_menu_1_header = $obj->GETUSERDASHBOARDHEADER('bottom_1');

    $user_bottom_menu_2_header = $obj->GETUSERDASHBOARDHEADER('bottom_2');

    $user_bottom_menu_3_header = $obj->GETUSERDASHBOARDHEADER('bottom_3');

    $user_bottom_menu_4_header = $obj->GETUSERDASHBOARDHEADER('bottom_4');

    $user_bottom_menu_5_header = $obj->GETUSERDASHBOARDHEADER('bottom_5');

    $user_bottom_menu_6_header = $obj->GETUSERDASHBOARDHEADER('bottom_6');

    $user_bottom_menu_7_header = $obj->GETUSERDASHBOARDHEADER('bottom_7');

    $user_bottom_menu_8_header = $obj->GETUSERDASHBOARDHEADER('bottom_8');

    $user_bottom_menu_9_header = $obj->GETUSERDASHBOARDHEADER('bottom_9');

    $user_bottom_menu_10_header = $obj->GETUSERDASHBOARDHEADER('bottom_10');


    

}





if($obj->chkUserPlanFeaturePermission($user_id,'34'))



{

	$page_access = true;

}

else

{

	$page_access = false;

}



?>



<!DOCTYPE html>



<html>



<head>



  <meta charset="utf-8">



  <meta http-equiv="X-UA-Compatible" content="IE=edge">



  <title>Wellnessway4u | Dashboard</title>



  <!-- Tell the browser to be responsive to screen width -->



  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">



  <!-- Bootstrap 3.3.6 -->



  <link rel="stylesheet" href="csswell/bootstrap/css/bootstrap.min.css">



  <!-- Font Awesome -->



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">



  <!-- Ionicons -->



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">



  <!-- jvectormap -->



  <link rel="stylesheet" href="userdashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.css">



  <!-- Theme style -->



  <link rel="stylesheet" href="userdashboard/dist/css/AdminLTE.min.css">



  <!-- AdminLTE Skins. Choose a skin from the css/skins



       folder instead of downloading all of them to reduce the load. -->



  <link rel="stylesheet" href="userdashboard/dist/css/skins/_all-skins.min.css">



    <link rel="stylesheet" href="userdashboard/dist/css/circle.css">







  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->



  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->



  <!--[if lt IE 9]>



  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>



  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>



  <![endif]-->



  <style >



  



  .subKey1{color:#00c0ef; font-weight:bold



  ; font-size:16px; text-align:center;}



  .subKey2{color:#009900; font-weight:bold



  ; font-size:16px; text-align:center;}



  .subKey3{color:#666600; font-weight:bold



  ; font-size:16px; text-align:center;}



  .subKey4{color:#ff3300; font-weight:bold



  ; font-size:16px; text-align:center;}



  .subKey5{color:#006666; font-weight:bold



  ; font-size:16px; /*text-align:center;*/}



  .subKey6{color:#990099; font-weight:bold



  ; font-size:16px; text-align:center;}



  



  .timearea{display:inline;}



  time.icon



{



  font-size: 1em;



  display: block;



  position: relative;



  width: 5em;



  height: 7em;



  background-color: #fff;



  margin: 0em auto;



  border-radius: 0.6em;



  box-shadow: 0 1px 0 #bdbdbd;



  overflow: hidden;



  -webkit-backface-visibility: hidden;



  -webkit-transform: rotate(0deg) skewY(0deg);



  -webkit-transform-origin: 50% 10%;



  transform-origin: 50% 10%;



}







time.icon *



{



  display: block;



  width: 100%;



  font-size: 1em;



  font-weight: bold;



  font-style: normal;



  text-align: center;



}







time.icon strong



{



  position: absolute;



  top: 0;



  padding: 0.4em 0;



  color: #fff;



  background-color: #feb34a;



  border-bottom: 1px dashed #f37302;



  box-shadow: 0 2px 0 #fd9f1b;



}











time.icon em



{



  position: absolute;



  bottom: 0.3em;



  color: #fd9f1b;



}







time.icon span



{



  width: 100%;



  font-size: 2.8em;



  letter-spacing: -0.05em;



  padding-top: 0.8em;



  color: #2f2f2f;



}







.fontCap{font-size:22px; color:#009900; text-transform: uppercase;}







.fontGreenDash{font-size:20px; color:#009900; }







.btn-twitter {



    /*background-color: #55acee;



    border-color: rgba(0, 0, 0, 0.2);



    color: #fff;*/



border:0px solid #15aeec; -webkit-border-radius: 15px; -moz-border-radius: 15px;border-radius: 15px;font-size:12px;font-family:arial, helvetica, sans-serif; padding: 10px 10px 10px 10px; text-decoration:none; display:inline-block;font-weight:bold; color: #FFFFFF;



 background-color: #49C0F0; background-image: -webkit-gradient(linear, left top, left bottom, from(#49C0F0), to(#175C78));



 background-image: -webkit-linear-gradient(top, #49C0F0, #175C78);



 background-image: -moz-linear-gradient(top, #49C0F0, #175C78);



 background-image: -ms-linear-gradient(top, #49C0F0, #175C78);



 background-image: -o-linear-gradient(top, #49C0F0, #175C78);



 background-image: linear-gradient(to bottom, #49C0F0, #175C78);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#49C0F0, endColorstr=#175C78);



}











.btn-twitter:hover{



 border:0px solid #1090c3;



 background-color: #175C78; background-image: -webkit-gradient(linear, left top, left bottom, from(#175C78), to(#49C0F0));



 background-image: -webkit-linear-gradient(top, #175C78, #49C0F0);



 background-image: -moz-linear-gradient(top, #175C78, #49C0F0);



 background-image: -ms-linear-gradient(top, #175C78, #49C0F0);



 background-image: -o-linear-gradient(top, #175C78, #49C0F0);



 background-image: linear-gradient(to bottom, #175C78, #49C0F0);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#175C78, endColorstr=#49C0F0);



}



















.btn-vk {



   border:0px solid #64f21f; -webkit-border-radius: 15px; -moz-border-radius: 15px;border-radius: 15px;font-size:12px;font-family:arial, helvetica, sans-serif; padding: 10px 10px 10px 10px; text-decoration:none; display:inline-block;text-shadow: 0px 0px 0 rgba(0,0,0,0.3);font-weight:bold; color: #FFFFFF;



 background-color: #89F554; background-image: -webkit-gradient(linear, left top, left bottom, from(#89F554), to(#66CC33));



 background-image: -webkit-linear-gradient(top, #89F554, #66CC33);



 background-image: -moz-linear-gradient(top, #89F554, #66CC33);



 background-image: -ms-linear-gradient(top, #89F554, #66CC33);



 background-image: -o-linear-gradient(top, #89F554, #66CC33);



 background-image: linear-gradient(to bottom, #89F554, #66CC33);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#89F554, endColorstr=#66CC33);



}



.btn-vk:hover {



 border:0px solid #4fd60d;



 background-color: #66CC33; background-image: -webkit-gradient(linear, left top, left bottom, from(#66CC33), to(#89F554));



 background-image: -webkit-linear-gradient(top, #66CC33, #89F554);



 background-image: -moz-linear-gradient(top, #66CC33, #89F554);



 background-image: -ms-linear-gradient(top, #66CC33, #89F554);



 background-image: -o-linear-gradient(top, #66CC33, #89F554);



 background-image: linear-gradient(to bottom, #66CC33, #89F554);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#66CC33, endColorstr=#89F554);



}











.btn-social {



    overflow: hidden;



    padding-left: 44px;



    position: relative;



    text-align: left;



    text-overflow: ellipsis;



    white-space: nowrap;



}







.fontCap {



    color: #009900;



    font-size: 18px;



    text-transform: uppercase;



	display: inline-block;    



    line-height: 1;



    margin: 0;



}







.skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side {



    background-color: #bae1b0;



}



.skin-blue .sidebar-menu > li.header {



    background: #a5c3a8 none repeat scroll 0 0;



    color: #009900;



}



.skin-blue .sidebar-form input[type="text"], .skin-blue .sidebar-form .btn {



    background-color: #dfeae0;



    border: 1px solid transparent;



    box-shadow: none;



    height: 35px;



}



.skin-blue .main-header .logo {



    background-color: #5abd46;



    border-bottom: 0 solid transparent;



    color: #fff;



}



.skin-blue .main-header .navbar {



    background-color: #5abd46;



}







skin-blue .main-header .logo {



    background-color: #51aa3f;



    border-bottom: 0 solid transparent;



    color: #fff;



}











.skin-blue .main-header .logo {



    background-color: #5abd46;



    border-bottom: 0 solid transparent;



    color: #fff;



}







.skin-blue .sidebar a {



    color: #5abd46;



}



/*.main-header .logo {



    display: block;



    float: left;



    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;



    font-size: 20px;



    font-weight: 300;



    height: 80px;



    line-height: 50px;



    overflow: hidden;



    padding: 0 15px;



    text-align: center;



    transition: width 0.3s ease-in-out 0s;



    width: 230px;



}*/







/*.main-sidebar, .left-side {



    left: 0;



    min-height: 100%;



    padding-top: 80px;



    position: absolute;



    top: 0;



    transition: transform 0.3s ease-in-out 0s, width 0.3s ease-in-out 0s;



    width: 230px;



    z-index: 810;



}*/







.content-header > .breadcrumb {



    background: transparent none repeat scroll 0 0;



    border-radius: 2px;



    float: left;



    font-size: 12px;



    margin-bottom: 0;



    margin-top: 0;



    padding: 7px 5px;



    position: absolute;



    left: 10px;



    top: 15px;



}







.userName{



    background: transparent none repeat scroll 0 0;



    border-radius: 2px;



    float: right;



    font-size: 12px;



    margin-bottom: 0;



    margin-top: 0;



    padding: 7px 5px;



    position: absolute;



    right: 10px;



    top: 15px;



}







.info-box {



    background: #fff none repeat scroll 0 0;



    border-radius: 2px;



    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);



    display: block;



    margin-bottom: 15px;



    min-height: 180px;



    width: 100%;



}



time.icon span {



    color: #2f2f2f;



    font-size: 2.8em;



    letter-spacing: -0.05em;



    padding-left: 0.4em;



    padding-top: 0.9em;



    width: 75%;



}







  </style>



</head>



<body class="hold-transition skin-blue sidebar-mini">



<div class="wrapper">







  <header class="main-header">







    <!-- Logo -->



    <a href="index.php" class="logo">



      <!-- mini logo for sidebar mini 50x50 pixels -->



      <span class="logo-mini"><img src="uploads/cwri_logo.png" width="50px" height="50px" border="0" /></span>



      <!-- logo for regular state and mobile devices -->



      <span class="logo-lg">Wellnessway4u</span>



    </a>







    <!-- Header Navbar: style can be found in header.less -->



    <nav class="navbar navbar-static-top">



      <!-- Sidebar toggle button-->



      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">



        <span class="sr-only">Toggle navigation</span>



      </a>



      <!-- Navbar Right Menu -->



      <div class="navbar-custom-menu">



        <ul class="nav navbar-nav">



          <!-- Messages: style can be found in dropdown.less-->



          <li class="dropdown messages-menu">



            <a href="#" class="dropdown-toggle" data-toggle="dropdown">



              <i class="fa fa-envelope-o"></i>



              <span class="label label-success"></span>



            </a>



            <ul class="dropdown-menu" style="display:none;">



              <li class="header">You have 4 messages</li>



              <li>



                <!-- inner menu: contains the actual data -->



                <ul class="menu">



                  <li><!-- start message -->



                    <a href="#">



                      <div class="pull-left">



                        <img src="userdashboard/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">



                      </div>



                      <h4>



                        Support Team



                        <small><i class="fa fa-clock-o"></i> 5 mins</small>



                      </h4>



                      <p>Why not buy a new awesome theme?</p>



                    </a>



                  </li>



                  <!-- end message -->



                  <li>



                    <a href="#">



                      <div class="pull-left">



                        <img src="userdashboard/upload/edit-profile.jpg" class="img-circle" alt="User Image">



                      </div>



                      <h4>



                        Design Team



                        <small><i class="fa fa-clock-o"></i> 2 hours</small>



                      </h4>



                      <p>Why not buy a new awesome theme?</p>



                    </a>



                  </li>



                  <li>



                    <a href="#">



                      <div class="pull-left">



                        <img src="userdashboard/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">



                      </div>



                      <h4>



                        Developers



                        <small><i class="fa fa-clock-o"></i> Today</small>



                      </h4>



                      <p>Why not buy a new awesome theme?</p>



                    </a>



                  </li>



                  <li>



                    <a href="#">



                      <div class="pull-left">



                        <img src="userdashboard/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">



                      </div>



                      <h4>



                        Sales Department



                        <small><i class="fa fa-clock-o"></i> Yesterday</small>



                      </h4>



                      <p>Why not buy a new awesome theme?</p>



                    </a>



                  </li>



                  <li>



                    <a href="#">



                      <div class="pull-left">



                        <img src="userdashboard/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">



                      </div>



                      <h4>



                        Reviewers



                        <small><i class="fa fa-clock-o"></i> 2 days</small>



                      </h4>



                      <p>Why not buy a new awesome theme?</p>



                    </a>



                  </li>



                </ul>



              </li>



              <li class="footer"><a href="#">See All Messages</a></li>



            </ul>



          </li>



          <!-- Notifications: style can be found in dropdown.less -->



          <li class="dropdown notifications-menu">



            <a href="#" class="dropdown-toggle" data-toggle="dropdown">



              <i class="fa fa-bell-o"></i>



              <span class="label label-warning"></span>



            </a>



            <ul class="dropdown-menu" style="display:none;">



              <li class="header">You have 10 notifications</li>



              <li>



                <!-- inner menu: contains the actual data -->



                <ul class="menu">



                  <li>



                    <a href="#">



                      <i class="fa fa-users text-aqua"></i> 5 new members joined today



                    </a>



                  </li>



                  <li>



                    <a href="#">



                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the



                      page and may cause design problems



                    </a>



                  </li>



                  <li>



                    <a href="#">



                      <i class="fa fa-users text-red"></i> 5 new members joined



                    </a>



                  </li>



                  <li>



                    <a href="#">



                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made



                    </a>



                  </li>



                  <li>



                    <a href="#">



                      <i class="fa fa-user text-red"></i> You changed your username



                    </a>



                  </li>



                </ul>



              </li>



              <li class="footer"><a href="#">View all</a></li>



            </ul>



          </li>



          <!-- Tasks: style can be found in dropdown.less -->



          <li class="dropdown tasks-menu">



            <a href="#" class="dropdown-toggle" data-toggle="dropdown">



              <i class="fa fa-flag-o"></i>



              <span class="label label-danger"></span>



            </a>



            <ul class="dropdown-menu" style="display:none;">



              <li class="header">You have 9 tasks</li>



              <li>



                <!-- inner menu: contains the actual data -->



                <ul class="menu">



                  <li><!-- Task item -->



                    <a href="#">



                      <h3>



                        Design some buttons



                        <small class="pull-right">20%</small>



                      </h3>



                      <div class="progress xs">



                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">



                          <span class="sr-only">20% Complete</span>



                        </div>



                      </div>



                    </a>



                  </li>



                  <!-- end task item -->



                  <li><!-- Task item -->



                    <a href="#">



                      <h3>



                        Create a nice theme



                        <small class="pull-right">40%</small>



                      </h3>



                      <div class="progress xs">



                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">



                          <span class="sr-only">40% Complete</span>



                        </div>



                      </div>



                    </a>



                  </li>



                  <!-- end task item -->



                  <li><!-- Task item -->



                    <a href="#">



                      <h3>



                        Some task I need to do



                        <small class="pull-right">60%</small>



                      </h3>



                      <div class="progress xs">



                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">



                          <span class="sr-only">60% Complete</span>



                        </div>



                      </div>



                    </a>



                  </li>



                  <!-- end task item -->



                  <li><!-- Task item -->



                    <a href="#">



                      <h3>



                        Make beautiful transitions



                        <small class="pull-right">80%</small>



                      </h3>



                      <div class="progress xs">



                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">



                          <span class="sr-only">80% Complete</span>



                        </div>



                      </div>



                    </a>



                  </li>



                  <!-- end task item -->



                </ul>



              </li>



              <li class="footer">



                <a href="#">View all tasks</a>



              </li>



            </ul>



          </li>



          <!-- User Account: style can be found in dropdown.less -->



         <!-- <li class="dropdown user user-menu">



            <a href="#" class="dropdown-toggle" data-toggle="dropdown">



              <img src="uploads/user-profile.png" width="30" height="30" > <span class="hidden-xs">  <?php



                                    if($obj->isLoggedIn())



                                    { 



                                        echo $obj->getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);



                                    }



                                    ?></span>



            </a>



            



          </li>-->



          <!-- Control Sidebar Toggle Button -->



       <!--   <li>



            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>



          </li>-->



        </ul>



      </div>







    </nav>



  </header>



  <!-- Left side column. contains the logo and sidebar -->



  <aside class="main-sidebar">



    <!-- sidebar: style can be found in sidebar.less -->



    <section class="sidebar">



      <!-- Sidebar user panel -->



      <!--<div class="user-panel">



        <div class="pull-left image">



        <img src="uploads/user-profile.png" width="60" height="60"  class="img-circle" alt="User Image"> 



          



        </div>



        <div class="pull-left info">



          <p>



          <?php



               if($obj->isLoggedIn())



                                    { 



                                        echo $obj->getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);



                                    }



                                    ?>



                                    </p>



          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>



        </div>



      </div>-->



      



      <!-- search form -->



     <!-- <form action="#" method="get" class="sidebar-form">



        <div class="input-group">



          <input type="text" name="q" class="form-control" placeholder="Search...">



              <span class="input-group-btn">



                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>



                </button>



              </span>



        </div>



      </form>-->



      <!-- /.search form -->



      <!-- sidebar menu: : style can be found in sidebar.less -->



      <ul class="sidebar-menu" style="margin-top:20px;;">



    <!--    <li class="header">MAIN NAVIGATION</li>-->

                

                <?php if(count($user_left_menu)>0) {

                    

                    for($i=0;$i<count($user_left_menu);$i++)

                    {

                        ?>

                            <li> <a href="<?php echo $user_left_menu[$i]['menu_link']; ?>" target="_blank"><?php echo $user_left_menu[$i]['page_name']; ?></a> </li>

                        <?php

                    }

                    

                } ?>

            

                

<!--                <li><a  href="my_fav_list.php" target="_blank" >My Fav List</a></li>

                <li><a  href="library.php" target="_blank">My Library</a></li>

                <li><a href="feedback.php" target="_blank">My Feedback</a></li>

                <li><a  href="my_subscription_plans.php" target="_blank">Subscription</a></li>

                <li><a href="edit_profile.php" target="_blank">Edit Profile</a></li>-->



                

                

                         <?php

                                   $arr_active_menu_items = $obj->getAllActiveMenuItems(0);







                                                if(count($arr_active_menu_items) > 0)







                                                {







                                                    foreach($arr_active_menu_items as $key => $val  )







                                                    {







                                                        if($val['menu_details']['link_enable'] == '1')







                                                        { 







                                                            $menu_link1 = $val['menu_details']['menu_link'];







                                                            if($menu_link1 == '')







                                                            {







                                                                $menu_link1 = '#';







                                                            }







                                                        }







                                                        else







                                                        {







                                                            $menu_link1 = '#';







                                                        } ?>







                                                        







                                                    <?php







                                                    } ?>







                                                <?php        











                                                } ?>







                                                    <?php







                                                    if($obj->isLoggedIn() || $obj->isLoggedInPro())







                                                    { ?>







                                                        <li><a href="logout.php" style="color:#F00">Logout</a></li>







                                                    <?php







                                                    }







                                                    else







                                                    { ?>







                                                        <li><a href="login.php">Login&nbsp;&nbsp;&nbsp;&nbsp;</a></li>







                                                    <?php







                                                    } ?>







                    </ul>



            



         



    </section>



    <!-- /.sidebar -->



  </aside>







  <!-- Content Wrapper. Contains page content -->



  <div class="content-wrapper" style="background-color:#fff;">



    <!-- Content Header (Page header) -->



    <section class="content-header" style="margin-bottom:20px;" >



    <ol class="breadcrumb">



        <li><a href="index.php" target="_blank"><i class="fa fa-dashboard"></i> Home</a></li>



        <li class="active">Dashboard</li>



      </ol>



      



      <span class="userName">  <?php



               if($obj->isLoggedIn())



                                    { 



                                        echo $obj->getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);



                                    }



                                    ?></span>



      </section>



    <section class="content-header" style="background-color:#fff;">



    



      <h2 class="fontGreenDash">



       <!-- REWARDS MELA - The ONLY Site that Rewards you for your efforts & motivation-->



<!--       LIFE KO # NAYA ANDAAZ REWARDS - To Motivate & Appreciate Your Efforts-->

           <?php echo $user_top_menu_1_header; ?>



        <small></small>



      </h2>

    </section>

    <!-- Main content -->

    <section class="content" style="background-color:#fff;">

       <!-- Main row -->

      <!-- Info boxes -->

            <div class="row">

                

                <div class="col-md-8">

                  <div class="row">

          <?php for($i=0;$i<count($user_top_menu_1);$i++) { ?>

        <div class="col-md-3 col-sm-6 col-xs-12">

            <a href="<?php echo $user_top_menu_1[$i]['menu_link']; ?>" target="_blank">   

                <div class="info-box">

                 <center> <span><b><?php echo $user_top_menu_1[$i]['page_name']; ?></b></span><br/>

                 <!-- <img src="uploads/<?php echo $user_top_menu_1[$i]['page_icon']; ?>" width="120" height="120" ></center>  -->

                  <!-- code write by ample 11-12-19 -->
                         <?php if($user_top_menu_1[$i]['page_icon']!='') { 

                                if($user_top_menu_1[$i]['page_icon_type']=='Image')
                                {   
                                  $imgData="";
                                    $imgData=$obj->getImgData($user_top_menu_1[$i]['page_icon']);
                                    if(!empty($imgData['image']))
                                    {
                                        ?>
                                        <img src="uploads/<?php echo $imgData['image']; ?>" style="width:120px; height: 120px;">
                                        <?php
                                    }
                                }
                            ?>
                         <?php } ?> 

               </div>

            </a>

        </div>

          <?php } ?>

              </div> 

              <h1 class="fontGreenDash">



       <!-- REWARDS MELA - The ONLY Site that Rewards you for your efforts & motivation-->



<!--       LIFE KO # NAYA ANDAAZ REWARDS - To Motivate & Appreciate Your Efforts-->

           <?php echo $user_top_menu_2_header; ?>



        <small></small>



      </h1>

              <div class="row">

          <?php for($i=0;$i<count($user_top_menu_2);$i++) { ?>

        <div class="col-md-3 col-sm-6 col-xs-12">

            <a href="<?php echo $user_top_menu_2[$i]['menu_link']; ?>" target="_blank">   

                <div class="info-box">

                 <center> <span><b><?php echo $user_top_menu_2[$i]['page_name']; ?></b></span><br/>

                 <!-- <img src="uploads/<?php echo $user_top_menu_2[$i]['page_icon']; ?>" width="120" height="120" ></center>   -->

                 <!-- code write by ample 11-12-19 -->
                         <?php if($user_top_menu_2[$i]['page_icon']!='') { 

                                if($user_top_menu_2[$i]['page_icon_type']=='Image')
                                {   
                                  $imgData="";
                                    $imgData=$obj->getImgData($user_top_menu_2[$i]['page_icon']);
                                    if(!empty($imgData['image']))
                                    {
                                        ?>
                                        <img src="uploads/<?php echo $imgData['image']; ?>" style="width:120px; height: 120px;">
                                        <?php
                                    }
                                }
                            ?>
                         <?php } ?> 

               </div>

            </a>

        </div>

          <?php } ?>

              </div>   

                

                    

        <div class="row">

           <div class="col-md-12">



            <!-- My 10 Keys  -->



          <div class="box box-info">



            <div class="box-header with-border">



              <!--<h3 class="fontCap">KNOW THE HIDDEN INFLUENCES IN YOUR LIFE - START HERE WITH MY 6 KEYS</h3>-->





              <div class="box-tools pull-right">



                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                </button>



                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>



              </div>



            </div>



            <!-- /.box-header -->



            <div class="box-body">



               <!-- Info Boxes Style 2 -->



                <div class="row">



            



           <!-- Your Natural Energy Rejuvenators-->



            <div class="col-md-12">



             <!-- <h5 class="box-title">Just like Social Media, simply talk / review about quality of your daily LIFE routine, experiences & possible reasons</h5>-->            



            <!-- /.box-header -->



           <!-- Start My Food



           <?php



	$yesterdayDate = date('Y-m-d',strtotime("-1 days"));



	$todayDate = date("Y-m-d");



?>



         <a href="../daily_meal.php" target="_blank">



            <div class="col-md-4">  



           <h5 class="box-title subKey6">My Food</h5>



            <div class="box-body">



            <div class="col-md-5">



           <time class="icon">



  <em>entries</em>



  <strong>Yesterday</strong>



  <?php	



	$yfoodCount = $obj->getMyFoodCountByDate($yesterdayDate, $_SESSION['user_id']);



?>



	<span><?php echo $yfoodCount;?></span>



            </time>



            </div>



               <div class="col-md-5">



            <time class="icon">



  <em>entries</em>



  <strong>Today</strong>



  <?php	



	$tfoodCount = $obj->getMyFoodCountByDate($todayDate, $_SESSION['user_id']);



?>



							<span><?php echo $tfoodCount;?></span>



            </time>



            </div>



            </div>



           <!-- Bar-->



           <!--<div class="progress-group">



                  



                    <span class="progress-number"><b>160</b>/200</span>







                    <div class="progress sm">



                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>



                    </div>



                  </div>-->



           <!-- Bar-->



            </div>



           </a>



          <!-- End My Food--> 



         <!-- My Activity



          <a href="../activity.php" target="_blank">  



            <div class="col-md-4">  



           <h5 class="box-title subKey6">My Activity</h5>



            <div class="box-body">



            <div class="col-md-5">



           <time class="icon">



  <em>entries</em>



  <strong>Yesterday</strong>



 <?php



	$yactivityCount = $obj->getMyActivityCountByDate($yesterdayDate, $_SESSION['user_id']);



?>



							<span><?php echo $yactivityCount;?></span>







            </time>



            </div>



               <div class="col-md-5">



            <time class="icon">



  <em>entries</em>



  <strong>Today</strong>



  <?php	



	$tactivityCount = $obj->getMyActivityCountByDate($todayDate, $_SESSION['user_id']);



?>



							<span><?php echo $tactivityCount;?></span>



            </time>



            </div>



            </div>



           <!-- Bar-->



         <!--  '.$total_entry.-->'



           <!--<div class="progress-group">



                                       <span class="progress-number"><b>100</b>/200</span>







                    <div class="progress sm">



                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>



                    </div>



                  </div>-->



           <!-- Bar-->



            </div>



            </a>



            <!-- End My Activity-->



           <!-- My Sleep



           <a href="../sleep.php" target="_blank">



            <div class="col-md-4">  



           <h5 class="box-title subKey6">My Sleep</h5>



            <div class="box-body">



            <div class="col-md-5">



           <time class="icon">



  <em>entries</em>



  <strong>Yesterday</strong>



  <?php



	$yactivityCount = $obj->getMySleepCountByDate($yesterdayDate, $_SESSION['user_id']);



?>



							<span><?php echo $yactivityCount;?></span>



 



           </time>



            </div>



               <div class="col-md-5">



            <time class="icon">



  <em>entries</em>



  <strong>Today</strong>



<?php	



            $tactivityCount = $obj->getMySleepCountByDate($todayDate, $_SESSION['user_id']);



?>



            <span><?php echo $tactivityCount;?></span>



            </time>



            </div>



            </div>



        <!-- Bar-->



           <!--<div class="progress-group">



                  <span class="progress-number"><b>90</b>/200</span>







                    <div class="progress sm">



                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>



                    </div>



                  </div>-->







           <!-- Bar-->



            </div>



            </a>



             <!-- End My Sleep-->



            <!-- /.box-body -->          



          </div>



           <!--Your Daily Energy Drainers or Rejuvenators-->



           <div class="col-md-12">



              <!-- <h4 class="box-title">TRACK your Emotions Management</h4>-->            



            <!-- /.box-header -->



            



            <!--My Situation Today



            <a href="../my_day_today.php" target="_blank">



            <div class="col-md-4">  



           <h5 class="box-title subKey6">My Situation Today</h5>



            <div class="box-body">



            <div class="col-md-5">



           <time class="icon">



  <em>entries</em>



  <strong>Yesterday</strong>



  <?php



	$yactivityCount = $obj->getMySituationByDate($yesterdayDate, $_SESSION['user_id']);



?>



							<span><?php echo $yactivityCount;?></span>



            </time>



            </div>



               <div class="col-md-5">



            <time class="icon">



  <em>entries</em>



  <strong>Today</strong>



  <?php	



	$tactivityCount = $obj->getMySituationByDate($todayDate, $_SESSION['user_id']);



?>



							<span><?php echo $tactivityCount;?></span>



            </time>



            </div>



            </div>



           <!-- Bar-->



           <!--<div class="progress-group">



                    <span class="progress-number"><b>10</b>/200</span>







                    <div class="progress sm">



                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>



                    </div>



                  </div>-->



           <!-- Bar-->



            </div>



            </a>



           <!--End My Situation Today-->



          <!-- My Communications 



          <a href="../my_communications.php" target="_blank">



            <div class="col-md-4">  



           <h5 class="box-title subKey6">My Communications</h5>



            <div class="box-body">



            <div class="col-md-5">



           <time class="icon">



  <em>entries</em>



  <strong>Yesterday</strong>



<?php



	$yactivityCount = $obj->getMyCommunicationsByDate($yesterdayDate, $_SESSION['user_id']);



?>



							<span><?php echo $yactivityCount;?></span>



            </time>



            </div>



               <div class="col-md-5">



            <time class="icon">



  <em>entries</em>

  <strong>Today</strong>

  <?php	

	$tactivityCount = $obj->getMyCommunicationsByDate($todayDate, $_SESSION['user_id']);

?>

            <span><?php echo $tactivityCount;?></span>



            </time>



            </div>



            </div>



          <!-- Bar-->



           <!--<div class="progress-group">



                    <span class="progress-number"><b>0</b>/200</span>







                    <div class="progress sm">



                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>



                    </div>



                  </div>-->







           <!-- Bar-->



            </div>



            </a>



            <!-- End My Communications  -->



         <!-- Workplace  



         <a href="../work_and_environment.php" target="_blank">



            <div class="col-md-4">  



           <h5 class="box-title subKey6">Workplace</h5>



            <div class="box-body">



            <div class="col-md-5">



           <time class="icon">



  <em>entries</em>



  <strong>Yesterday</strong>



<?php



	$yactivityCount = $obj->getMyWorkplaceByDate($yesterdayDate, $_SESSION['user_id']);



?>



							<span><?php echo $yactivityCount;?></span>



            </time>



            </div>



               <div class="col-md-5">



            <time class="icon">



  <em>entries</em>



  <strong>Today</strong>



 <?php	



	$tactivityCount = $obj->getMyWorkplaceByDate($todayDate, $_SESSION['user_id']);



?>



							<span><?php echo $tactivityCount;?></span>



            </time>



            </div>



            </div>



          <!-- Bar-->



           <!--<div class="progress-group">



                    <span class="progress-number"><b>10</b>/200</span>







                    <div class="progress sm">



                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>



                    </div>



                  </div>-->



           <!-- Bar-->



            </div>



            </a>



            <!-- End Workplace --> 



            <!-- /.box-body -->          



          </div>

<!-- My Energy Indicators Today-->  



        <div class="col-md-12">



            <div style="margin-top:25px;" >



            <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_middle_menu_2_header; ?></h3>



            </div>



          



            <!-- /.box-header -->



            <div class="box-body">



               <!-- Info Boxes Style 2 -->



                <div class="row">



                <!--Digital Personal Wellness Diary-->



        <?php if(!empty($user_middle_menu_2)) { 

            

            for($i=0;$i<count($user_middle_menu_2);$i++)

            {

            ?>



            <div class="col-md-4"> 

                <div class="box-body"> 

                   <center>

                       <!--<h5 class="box-title">My Energy Indicators TodayMy Lifestyle/Routine @</h5>-->

                       <a href="<?php echo $user_middle_menu_2[$i]['menu_link']; ?>" target="_blank">    

                        <h5 class="box-title subKey5"><?php echo $user_middle_menu_2[$i]['page_name']; ?></h5>

                             <!-- <img src="uploads/<?php echo $user_middle_menu_2[$i]['page_icon']; ?>" width="100" height="100" alt="wim"> -->

                             <!-- code write by ample 11-12-19 -->
                         <?php if($user_middle_menu_2[$i]['page_icon']!='') { 

                                if($user_middle_menu_2[$i]['page_icon_type']=='Image')
                                {   
                                  $imgData="";
                                    $imgData=$obj->getImgData($user_middle_menu_2[$i]['page_icon']);
                                    if(!empty($imgData['image']))
                                    {
                                        ?>
                                        <img src="uploads/<?php echo $imgData['image']; ?>" style="width:100px; height: 100px;">
                                        <?php
                                    }
                                }
                            ?>
                         <?php } ?> 

                       </a>

                   </center>

                  </div> 

            </div>

                

        <?php } } ?>

                

           

          </div>



        <!-- My Energy Indicators Today-->  



        <div class="col-md-12">



            <div style="margin-top:25px;" >



            <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_middle_menu_3_header; ?></h3>



            </div>



          



            <!-- /.box-header -->



            <div class="box-body">



               <!-- Info Boxes Style 2 -->



                <div class="row">



                <!--Digital Personal Wellness Diary-->



        <?php if(!empty($user_middle_menu_3)) { 

            

            for($i=0;$i<count($user_middle_menu_3);$i++)

            {

            ?>



            <div class="col-md-4"> 

                <div class="box-body"> 

                   <center>

                       <!--<h5 class="box-title">My Energy Indicators TodayMy Lifestyle/Routine @</h5>-->

                       <a href="<?php echo $user_middle_menu_3[$i]['menu_link']; ?>" target="_blank">    

                        <h5 class="box-title subKey5"><?php echo $user_middle_menu_3[$i]['page_name']; ?></h5>

                             <!-- <img src="uploads/<?php echo $user_middle_menu_3[$i]['page_icon']; ?>" width="100" height="100" alt="wim"> -->

                             <!-- code write by ample 11-12-19 -->
                         <?php if($user_middle_menu_3[$i]['page_icon']!='') { 

                                if($user_middle_menu_3[$i]['page_icon_type']=='Image')
                                {   
                                  $imgData="";
                                    $imgData=$obj->getImgData($user_middle_menu_3[$i]['page_icon']);
                                    if(!empty($imgData['image']))
                                    {
                                        ?>
                                        <img src="uploads/<?php echo $imgData['image']; ?>" style="width:100px; height: 100px;">
                                        <?php
                                    }
                                }
                            ?>
                         <?php } ?> 

                       </a>

                   </center>

                  </div> 

            </div>

                

        <?php } } ?>

                

           

          </div>

              <h3 class="fontCap"><?php // echo $user_middle_menu_4_header; ?></h3>  

          <div class="row">



                <!--Digital Personal Wellness Diary-->

               <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_middle_menu_4_header; ?></h3>



            </div>



        <?php if(!empty($user_middle_menu_4)) { 

            

//            echo '<pre>';

//            print_r($user_middle_menu_4);

//            echo '</pre>';

            

            

            for($i=0;$i<count($user_middle_menu_4);$i++)

            {

            ?>



                <div class="col-md-4" > 

                <div class="box-body"> 

                   <center>

                       <!--<h5 class="box-title">My Energy Indicators TodayMy Lifestyle/Routine @</h5>-->

                       <a href="<?php echo $user_middle_menu_4[$i]['menu_link']; ?>" target="_blank">    

                        <h5 class="box-title subKey5"><?php echo $user_middle_menu_4[$i]['page_name']; ?></h5>

                            <!--  <img src="uploads/<?php echo $user_middle_menu_4[$i]['page_icon']; ?>" width="100" height="100" alt="<?php echo $user_middle_menu_4[$i]['page_name']; ?>"> -->

                            <!-- code write by ample 11-12-19 -->
                         <?php if($user_middle_menu_4[$i]['page_icon']!='') { 

                                if($user_middle_menu_4[$i]['page_icon_type']=='Image')
                                {   
                                  $imgData="";
                                    $imgData=$obj->getImgData($user_middle_menu_4[$i]['page_icon']);
                                    if(!empty($imgData['image']))
                                    {
                                        ?>
                                        <img src="uploads/<?php echo $imgData['image']; ?>" style="width:120px; height: 120px;">
                                        <?php
                                    }
                                }
                            ?>
                         <?php } ?> 

                       </a>

                   </center>

                  </div> 

            </div>

                

        <?php } } ?>

                

           

          </div>     



              <!-- /.table-responsive -->



            </div>



            <!-- /.box-body -->            



            <!-- /.box-footer -->



          </div>



          </div> 



           



          </div>



              <!-- /.table-responsive -->



            </div>



            <!-- /.box-body -->            



            <!-- /.box-footer -->



          </div>



          <!-- /.box -->



         </div>

                    </div> 

                    

         <div class="row">

             <div class="col-md-6">

                 

                 

             <!--Bottom 1 -->

              <?php if(!empty($user_bottom_menu_1)) { ?>

              

              <div class="row">

                   <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_bottom_menu_1_header; ?></h3>



            </div>

                  <?php for($i=0;$i<count($user_bottom_menu_1);$i++) { ?>

                  <div class="col-md-6">         



              <!-- DIRECT CHAT -->



              <div class="box box-primary">



                <div class="box-header with-border">



                  <h3 class="box-title"><?php echo $user_bottom_menu_1[$i]['page_name']; ?></h3>







                  <div class="box-tools pull-right">



                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>



                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                    </button>



                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">



                      <i class="fa fa-comments"></i></button>



                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>



                    </button>



                  </div>



                </div>



                <!-- /.box-header -->



                <div class="box-body">



                <?php echo $user_bottom_menu_1[$i]['dashboard_contents']; ?>



                </div>



                <!-- /.box-body -->                



                <!-- /.box-footer-->



              </div>



              <!--/.direct-chat -->



           



         <!-- Testimonials -->



          <div class="box box-primary" style="display:none;">



            <div class="box-header with-border">



              <h3 class="box-title">Testimonials</h3>







              <div class="box-tools pull-right">



                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                </button>



                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>



              </div>



            </div>



            



            



            <!-- /.box-header -->



            <div class="box-body">



              Testimonials



            </div>



            <!-- /.box-body -->



            <div class="box-footer text-center">



              <a href="javascript:void(0)" class="uppercase">View All Testimonials</a>



            </div>



            <!-- /.box-footer -->



          </div>



          <!-- /.box -->



          



          <!-- /.row -->



        </div>



                  <?php } ?>

        <!-- /.col -->



         <!-- Left col -->



        

              </div>

              

              <?php } ?>

             <!-- end bottom 1 -->

             

             <!--Bottom 2 -->

              <?php if(!empty($user_bottom_menu_2)) { ?>

              

              <div class="row">

                  <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_bottom_menu_2_header; ?></h3>



            </div>

                  <?php for($i=0;$i<count($user_bottom_menu_2);$i++) { ?>

                  <div class="col-md-6">         



              <!-- DIRECT CHAT -->



              <div class="box box-primary">



                <div class="box-header with-border">



                  <h3 class="box-title"><?php echo $user_bottom_menu_2[$i]['page_name']; ?></h3>







                  <div class="box-tools pull-right">



                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>



                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                    </button>



                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">



                      <i class="fa fa-comments"></i></button>



                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>



                    </button>



                  </div>



                </div>



                <!-- /.box-header -->



                <div class="box-body">



                <?php echo $user_bottom_menu_2[$i]['dashboard_contents']; ?>



                </div>



                <!-- /.box-body -->                



                <!-- /.box-footer-->



              </div>



              <!--/.direct-chat -->



           



         <!-- Testimonials -->



          <div class="box box-primary" style="display:none;">



            <div class="box-header with-border">



              <h3 class="box-title">Testimonials</h3>







              <div class="box-tools pull-right">



                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                </button>



                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>



              </div>



            </div>



            



            



            <!-- /.box-header -->



            <div class="box-body">



              Testimonials



            </div>



            <!-- /.box-body -->



            <div class="box-footer text-center">



              <a href="javascript:void(0)" class="uppercase">View All Testimonials</a>



            </div>



            <!-- /.box-footer -->



          </div>



          <!-- /.box -->



          



          <!-- /.row -->



        </div>



                  <?php } ?>

        <!-- /.col -->



         <!-- Left col -->



        

              </div>

              

              <?php } ?>

             <!-- end bottom 2 -->

             

             <!--Bottom 3 -->

              <?php if(!empty($user_bottom_menu_3)) { ?>

              

              <div class="row">

                  <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_bottom_menu_3_header; ?></h3>



            </div>

                  <?php for($i=0;$i<count($user_bottom_menu_3);$i++) { ?>

                  <div class="col-md-6">         



              <!-- DIRECT CHAT -->



              <div class="box box-primary">



                <div class="box-header with-border">



                  <h3 class="box-title"><?php echo $user_bottom_menu_3[$i]['page_name']; ?></h3>







                  <div class="box-tools pull-right">



                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>



                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                    </button>



                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">



                      <i class="fa fa-comments"></i></button>



                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>



                    </button>



                  </div>



                </div>



                <!-- /.box-header -->



                <div class="box-body">



                <?php echo $user_bottom_menu_3[$i]['dashboard_contents']; ?>



                </div>



                <!-- /.box-body -->                



                <!-- /.box-footer-->



              </div>



              <!--/.direct-chat -->



           



         <!-- Testimonials -->



          <div class="box box-primary" style="display:none;">



            <div class="box-header with-border">



              <h3 class="box-title">Testimonials</h3>







              <div class="box-tools pull-right">



                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                </button>



                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>



              </div>



            </div>



            <!-- /.box-header -->



            <div class="box-body">



              Testimonials



            </div>



            <!-- /.box-body -->



            <div class="box-footer text-center">



              <a href="javascript:void(0)" class="uppercase">View All Testimonials</a>



            </div>



            <!-- /.box-footer -->



          </div>



          <!-- /.box -->



          



          <!-- /.row -->



        </div>



                  <?php } ?>

        <!-- /.col -->



         <!-- Left col -->



        

              </div>

              

              <?php } ?>

             <!-- end bottom 3 -->

             

             <!--Bottom 4 -->

              <?php if(!empty($user_bottom_menu_4)) { ?>

              

              <div class="row">

                  <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_bottom_menu_4_header; ?></h3>



            </div>

                  <?php for($i=0;$i<count($user_bottom_menu_4);$i++) { ?>

                  <div class="col-md-6">         



              <!-- DIRECT CHAT -->



              <div class="box box-primary">



                <div class="box-header with-border">



                  <h3 class="box-title"><?php echo $user_bottom_menu_4[$i]['page_name']; ?></h3>







                  <div class="box-tools pull-right">



                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>



                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                    </button>



                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">



                      <i class="fa fa-comments"></i></button>



                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>



                    </button>



                  </div>



                </div>



                <!-- /.box-header -->



                <div class="box-body">



                <?php echo $user_bottom_menu_4[$i]['dashboard_contents']; ?>



                </div>



                <!-- /.box-body -->                



                <!-- /.box-footer-->



              </div>



              <!--/.direct-chat -->



           



         <!-- Testimonials -->



          <div class="box box-primary" style="display:none;">



            <div class="box-header with-border">



              <h3 class="box-title">Testimonials</h3>







              <div class="box-tools pull-right">



                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                </button>



                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>



              </div>



            </div>



            <!-- /.box-header -->



            <div class="box-body">



              Testimonials



            </div>



            <!-- /.box-body -->



            <div class="box-footer text-center">



              <a href="javascript:void(0)" class="uppercase">View All Testimonials</a>



            </div>



            <!-- /.box-footer -->



          </div>



          <!-- /.box -->



          



          <!-- /.row -->



        </div>



                  <?php } ?>

        <!-- /.col -->



         <!-- Left col -->



        

              </div>

              

              <?php } ?>

             <!-- end bottom 4 -->

             

             <!--Bottom 5 -->

              <?php if(!empty($user_bottom_menu_5)) { ?>

              

              <div class="row">

                  <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_bottom_menu_5_header; ?></h3>



            </div>

                  <?php for($i=0;$i<count($user_bottom_menu_5);$i++) { ?>

                  <div class="col-md-6">         



              <!-- DIRECT CHAT -->



              <div class="box box-primary">



                <div class="box-header with-border">



                  <h3 class="box-title"><?php echo $user_bottom_menu_5[$i]['page_name']; ?></h3>







                  <div class="box-tools pull-right">



                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>



                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                    </button>



                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">



                      <i class="fa fa-comments"></i></button>



                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>



                    </button>



                  </div>



                </div>



                <!-- /.box-header -->



                <div class="box-body">



                <?php echo $user_bottom_menu_5[$i]['dashboard_contents']; ?>



                </div>



                <!-- /.box-body -->                



                <!-- /.box-footer-->



              </div>



              <!--/.direct-chat -->



           



         <!-- Testimonials -->



          <div class="box box-primary" style="display:none;">



            <div class="box-header with-border">



              <h3 class="box-title">Testimonials</h3>







              <div class="box-tools pull-right">



                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                </button>



                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>



              </div>



            </div>



            <!-- /.box-header -->



            <div class="box-body">



              Testimonials



            </div>



            <!-- /.box-body -->



            <div class="box-footer text-center">



              <a href="javascript:void(0)" class="uppercase">View All Testimonials</a>



            </div>



            <!-- /.box-footer -->



          </div>



          <!-- /.box -->



          



          <!-- /.row -->



        </div>



                  <?php } ?>

        <!-- /.col -->



         <!-- Left col -->



        

              </div>

              

              <?php } ?>

             <!-- end bottom 5 -->

             

             <!--Bottom 6 -->

              <?php if(!empty($user_bottom_menu_6)) { ?>

              

              <div class="row">

                  <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_bottom_menu_6_header; ?></h3>



            </div>

                  <?php for($i=0;$i<count($user_bottom_menu_6);$i++) { ?>

                  <div class="col-md-6">         



              <!-- DIRECT CHAT -->



              <div class="box box-primary">



                <div class="box-header with-border">



                  <h3 class="box-title"><?php echo $user_bottom_menu_6[$i]['page_name']; ?></h3>







                  <div class="box-tools pull-right">



                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>



                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                    </button>



                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">



                      <i class="fa fa-comments"></i></button>



                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>



                    </button>



                  </div>



                </div>



                <!-- /.box-header -->



                <div class="box-body">



                <?php echo $user_bottom_menu_6[$i]['dashboard_contents']; ?>



                </div>



                <!-- /.box-body -->                



                <!-- /.box-footer-->



              </div>



              <!--/.direct-chat -->



           



         <!-- Testimonials -->



          <div class="box box-primary" style="display:none;">



            <div class="box-header with-border">



              <h3 class="box-title">Testimonials</h3>







              <div class="box-tools pull-right">



                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                </button>



                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>



              </div>



            </div>



            <!-- /.box-header -->



            <div class="box-body">



              Testimonials



            </div>



            <!-- /.box-body -->



            <div class="box-footer text-center">



              <a href="javascript:void(0)" class="uppercase">View All Testimonials</a>



            </div>



            <!-- /.box-footer -->



          </div>



          <!-- /.box -->



          



          <!-- /.row -->



        </div>



                  <?php } ?>

        <!-- /.col -->



         <!-- Left col -->



        

              </div>

              

              <?php } ?>

             <!-- end bottom 6 -->

             

             <!--Bottom 7 -->

              <?php if(!empty($user_bottom_menu_7)) { ?>

              

              <div class="row">

                  <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_bottom_menu_7_header; ?></h3>



            </div>

                  <?php for($i=0;$i<count($user_bottom_menu_7);$i++) { ?>

                  <div class="col-md-6">         



              <!-- DIRECT CHAT -->



              <div class="box box-primary">



                <div class="box-header with-border">



                  <h3 class="box-title"><?php echo $user_bottom_menu_7[$i]['page_name']; ?></h3>







                  <div class="box-tools pull-right">



                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>



                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                    </button>



                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">



                      <i class="fa fa-comments"></i></button>



                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>



                    </button>



                  </div>



                </div>



                <!-- /.box-header -->



                <div class="box-body">



                <?php echo $user_bottom_menu_7[$i]['dashboard_contents']; ?>



                </div>



                <!-- /.box-body -->                



                <!-- /.box-footer-->



              </div>



              <!--/.direct-chat -->



           



         <!-- Testimonials -->



          <div class="box box-primary" style="display:none;">



            <div class="box-header with-border">



              <h3 class="box-title">Testimonials</h3>







              <div class="box-tools pull-right">



                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                </button>



                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>



              </div>



            </div>



            <!-- /.box-header -->



            <div class="box-body">



              Testimonials



            </div>



            <!-- /.box-body -->



            <div class="box-footer text-center">



              <a href="javascript:void(0)" class="uppercase">View All Testimonials</a>



            </div>



            <!-- /.box-footer -->



          </div>



          <!-- /.box -->



          



          <!-- /.row -->



        </div>



                  <?php } ?>

        <!-- /.col -->



         <!-- Left col -->



        

              </div>

              

              <?php } ?>

             <!-- end bottom 7 -->

             

             <!--Bottom 8 -->

              <?php if(!empty($user_bottom_menu_8)) { ?>

              

              <div class="row">

                  <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_bottom_menu_8_header; ?></h3>



            </div>

                  <?php for($i=0;$i<count($user_bottom_menu_8);$i++) { ?>

                  <div class="col-md-6">         



              <!-- DIRECT CHAT -->



              <div class="box box-primary">



                <div class="box-header with-border">



                  <h3 class="box-title"><?php echo $user_bottom_menu_8[$i]['page_name']; ?></h3>







                  <div class="box-tools pull-right">



                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>



                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                    </button>



                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">



                      <i class="fa fa-comments"></i></button>



                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>



                    </button>



                  </div>



                </div>



                <!-- /.box-header -->



                <div class="box-body">



                <?php echo $user_bottom_menu_8[$i]['dashboard_contents']; ?>



                </div>



                <!-- /.box-body -->                



                <!-- /.box-footer-->



              </div>



              <!--/.direct-chat -->



           



         <!-- Testimonials -->



          <div class="box box-primary" style="display:none;">



            <div class="box-header with-border">



              <h3 class="box-title">Testimonials</h3>







              <div class="box-tools pull-right">



                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                </button>



                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>



              </div>



            </div>



            <!-- /.box-header -->



            <div class="box-body">



              Testimonials



            </div>



            <!-- /.box-body -->



            <div class="box-footer text-center">



              <a href="javascript:void(0)" class="uppercase">View All Testimonials</a>



            </div>



            <!-- /.box-footer -->



          </div>



          <!-- /.box -->



          



          <!-- /.row -->



        </div>



                  <?php } ?>

        <!-- /.col -->



         <!-- Left col -->



        

              </div>

              

              <?php } ?>

             <!-- end bottom 8 -->

             

             <!--Bottom 9 -->

              <?php if(!empty($user_bottom_menu_9)) { ?>

              

              <div class="row">

                  <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_bottom_menu_9_header; ?></h3>



            </div>

                  <?php for($i=0;$i<count($user_bottom_menu_9);$i++) { ?>

                  <div class="col-md-6">         



              <!-- DIRECT CHAT -->



              <div class="box box-primary">



                <div class="box-header with-border">



                  <h3 class="box-title"><?php echo $user_bottom_menu_9[$i]['page_name']; ?></h3>







                  <div class="box-tools pull-right">



                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>



                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                    </button>



                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">



                      <i class="fa fa-comments"></i></button>



                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>



                    </button>



                  </div>



                </div>



                <!-- /.box-header -->



                <div class="box-body">



                <?php echo $user_bottom_menu_9[$i]['dashboard_contents']; ?>



                </div>



                <!-- /.box-body -->                



                <!-- /.box-footer-->



              </div>



              <!--/.direct-chat -->



           



         <!-- Testimonials -->



          <div class="box box-primary" style="display:none;">



            <div class="box-header with-border">



              <h3 class="box-title">Testimonials</h3>







              <div class="box-tools pull-right">



                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                </button>



                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>



              </div>



            </div>



            <!-- /.box-header -->



            <div class="box-body">



              Testimonials



            </div>



            <!-- /.box-body -->



            <div class="box-footer text-center">



              <a href="javascript:void(0)" class="uppercase">View All Testimonials</a>



            </div>



            <!-- /.box-footer -->



          </div>



          <!-- /.box -->



          



          <!-- /.row -->



        </div>



                  <?php } ?>

        <!-- /.col -->



         <!-- Left col -->



        

              </div>

              

              <?php } ?>

             <!-- end bottom 9 -->

             

             <!--Bottom 10 -->

              <?php if(!empty($user_bottom_menu_10)) { ?>

              

              <div class="row">

                  <div class="box-header with-border">



              <!--<h3 class="fontCap">Track Below Your Wim Patterns</h3>-->

              <h3 class="fontCap"><?php echo $user_bottom_menu_10_header; ?></h3>



            </div>

                  <?php for($i=0;$i<count($user_bottom_menu_10);$i++) { ?>

                  <div class="col-md-6">         



              <!-- DIRECT CHAT -->



              <div class="box box-primary">



                <div class="box-header with-border">



                  <h3 class="box-title"><?php echo $user_bottom_menu_10[$i]['page_name']; ?></h3>







                  <div class="box-tools pull-right">



                    <span data-toggle="tooltip" title="3 New Messages" class="badge bg-yellow">3</span>



                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                    </button>



                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">



                      <i class="fa fa-comments"></i></button>



                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>



                    </button>



                  </div>



                </div>



                <!-- /.box-header -->



                <div class="box-body">



                <?php echo $user_bottom_menu_10[$i]['dashboard_contents']; ?>



                </div>



                <!-- /.box-body -->                



                <!-- /.box-footer-->



              </div>



              <!--/.direct-chat -->



           



         <!-- Testimonials -->



          <div class="box box-primary" style="display:none;">



            <div class="box-header with-border">



              <h3 class="box-title">Testimonials</h3>







              <div class="box-tools pull-right">



                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>



                </button>



                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>



              </div>



            </div>



            <!-- /.box-header -->



            <div class="box-body">



              Testimonials



            </div>



            <!-- /.box-body -->



            <div class="box-footer text-center">



              <a href="javascript:void(0)" class="uppercase">View All Testimonials</a>



            </div>



            <!-- /.box-footer -->



          </div>



          <!-- /.box -->



          



          <!-- /.row -->



        </div>



                  <?php } ?>

        <!-- /.col -->



         <!-- Left col -->



        

              </div>

              

              <?php } ?>

             <!-- end bottom 10 -->

             



        <!-- /.col -->

</div>





                 

             </div>    

         </div>

         

                    <div class="col-md-2"> <?php include_once('left_sidebar.php'); ?></div>

                    <div class="col-md-2"><?php include_once('right_sidebar.php'); ?></div>

               



            </div>



    </section>







</div>



  <!-- /.content-wrapper -->







  <footer class="main-footer">



    <div class="pull-right hidden-xs">



     



    </div>



   �2016 Chaitanya Wellness Research Institute, all rights reserved.



  </footer>







  <!-- Control Sidebar -->



  <aside class="control-sidebar control-sidebar-dark">



    <!-- Create the tabs -->



    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">



      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>



      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>



    </ul>



    <!-- Tab panes -->



    <div class="tab-content">



      <!-- Home tab content -->



      <div class="tab-pane" id="control-sidebar-home-tab">



        <h3 class="control-sidebar-heading">Recent Activity</h3>



        <ul class="control-sidebar-menu">



          <li>



            <a href="javascript:void(0)">



              <i class="menu-icon fa fa-birthday-cake bg-red"></i>







              <div class="menu-info">



                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>







                <p>Will be 23 on April 24th</p>



              </div>



            </a>



          </li>



          <li>







            <a href="javascript:void(0)">



              <i class="menu-icon fa fa-user bg-yellow"></i>







              <div class="menu-info">



                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>







                <p>New phone +1(800)555-1234</p>



              </div>



            </a>



          </li>



          <li>



            <a href="javascript:void(0)">



              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>







              <div class="menu-info">



                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>







                <p>nora@example.com</p>



              </div>



            </a>



          </li>



          <li>



            <a href="javascript:void(0)">



              <i class="menu-icon fa fa-file-code-o bg-green"></i>







              <div class="menu-info">



                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>







                <p>Execution time 5 seconds</p>



              </div>



            </a>



          </li>



        </ul>



        <!-- /.control-sidebar-menu -->







        <h3 class="control-sidebar-heading">Tasks Progress</h3>



        <ul class="control-sidebar-menu">



          <li>



            <a href="javascript:void(0)">



              <h4 class="control-sidebar-subheading">



                Custom Template Design



                <span class="label label-danger pull-right">70%</span>



              </h4>







              <div class="progress progress-xxs">



                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>



              </div>



            </a>



          </li>



          <li>



            <a href="javascript:void(0)">



              <h4 class="control-sidebar-subheading">



                Update Resume



                <span class="label label-success pull-right">95%</span>



              </h4>







              <div class="progress progress-xxs">



                <div class="progress-bar progress-bar-success" style="width: 95%"></div>



              </div>



            </a>



          </li>



          <li>



            <a href="javascript:void(0)">



              <h4 class="control-sidebar-subheading">



                Laravel Integration



                <span class="label label-warning pull-right">50%</span>



              </h4>







              <div class="progress progress-xxs">



                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>



              </div>



            </a>



          </li>



          <li>



            <a href="javascript:void(0)">



              <h4 class="control-sidebar-subheading">



                Back End Framework



                <span class="label label-primary pull-right">68%</span>



              </h4>







              <div class="progress progress-xxs">



                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>



              </div>



            </a>



          </li>



        </ul>



        <!-- /.control-sidebar-menu -->







      </div>



      <!-- /.tab-pane -->







      <!-- Settings tab content -->



      <div class="tab-pane" id="control-sidebar-settings-tab">



        <form method="post">



          <h3 class="control-sidebar-heading">General Settings</h3>







          <div class="form-group">



            <label class="control-sidebar-subheading">



              Report panel usage



              <input type="checkbox" class="pull-right" checked>



            </label>







            <p>



              Some information about this general settings option



            </p>



          </div>



          <!-- /.form-group -->







          <div class="form-group">



            <label class="control-sidebar-subheading">



              Allow mail redirect



              <input type="checkbox" class="pull-right" checked>



            </label>







            <p>



              Other sets of options are available



            </p>



          </div>



          <!-- /.form-group -->







          <div class="form-group">



            <label class="control-sidebar-subheading">



              Expose author name in posts



              <input type="checkbox" class="pull-right" checked>



            </label>







            <p>



              Allow the user to show his name in blog posts



            </p>



          </div>



          <!-- /.form-group -->







          <h3 class="control-sidebar-heading">Chat Settings</h3>







          <div class="form-group">



            <label class="control-sidebar-subheading">



              Show me as online



              <input type="checkbox" class="pull-right" checked>



            </label>



          </div>



          <!-- /.form-group -->







          <div class="form-group">



            <label class="control-sidebar-subheading">



              Turn off notifications



              <input type="checkbox" class="pull-right">



            </label>



          </div>



          <!-- /.form-group -->







          <div class="form-group">



            <label class="control-sidebar-subheading">



              Delete chat history



              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>



            </label>



          </div>



          <!-- /.form-group -->



        </form>



      </div>



      <!-- /.tab-pane -->



    </div>



  </aside>



  <!-- /.control-sidebar -->



  <!-- Add the sidebar's background. This div must be placed



       immediately after the control sidebar -->



  <div class="control-sidebar-bg"></div>







</div>







<!-- ./wrapper -->







<!-- ./wrapper -->















<!-- jQuery 2.2.3 -->



<script src="userdashboard/plugins/jQuery/jquery-2.2.3.min.js"></script>



<!-- Bootstrap 3.3.6 -->



<script src="csswell/bootstrap/js/bootstrap.min.js"></script>



<!-- FastClick -->



<script src="userdashboard/plugins/fastclick/fastclick.js"></script>



<!-- AdminLTE App expand collaps-->



<script src="userdashboard/dist/js/app.min.js"></script>



<!-- Sparkline -->



<script src="userdashboard/plugins/sparkline/jquery.sparkline.min.js"></script>



<!-- jvectormap -->



<script src="userdashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>



<script src="userdashboard/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>



<!-- SlimScroll 1.3.0 -->



<script src="userdashboard/plugins/slimScroll/jquery.slimscroll.min.js"></script>



<!-- ChartJS 1.0.1 -->



<script src="userdashboard/plugins/chartjs/Chart.min.js"></script>



<!-- AdminLTE dashboard demo (This is only for demo purposes) -->



<script src="userdashboard/dist/js/pages/dashboard2.js"></script>



<!-- AdminLTE for demo purposes -->



<script src="userdashboard/dist/js/demo.js"></script>



<!--<script src="userdashboard/plugins/knob/jquery.knob.js"></script>-->



<script src="userdashboard/plugins/chartjs/Chart.min.js"></script>



<!-- page script -->







</body>



</html>








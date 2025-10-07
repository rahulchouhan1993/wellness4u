<?php

include('config.php');

$page_id = '159';

$main_page_id = $page_id;

list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($page_id);

$ref = base64_encode('user_dashboard.php');

if(!isLoggedIn())

{

    header("Location: login.php?ref=".$ref);

    exit(0);

}

else

{

    $user_id = $_SESSION['user_id'];

    doUpdateOnline($_SESSION['user_id']);

}





if(chkUserPlanFeaturePermission($user_id,'34'))

{

	$page_access = true;

}

else

{

	$page_access = false;

}



$return = false;

$error = false;

$tr_err_date = 'none';

$err_date = '';



$idmonthwisechart = 'none';



$summary_cnt = 0;



if(isset($_POST['btnSubmit']))	

{

	$start_day = '1';

	$start_month = trim($_POST['start_month']);

	$start_year = trim($_POST['start_year']);

	

	$end_day = '1';

	$end_month = trim($_POST['end_month']);

	$end_year = trim($_POST['end_year']);



	

	if($start_month == '')

	{

		$error = true;

		$tr_err_date = '';

		$err_date = 'Please select start month';

	}

	elseif($start_year == '')

	{

		$error = true;

		$tr_err_date = '';

		$err_date = 'Please select start year';

	}

	elseif(!checkdate($start_month,$start_day,$start_year))

	{

		$error = true;

		$tr_err_date = '';

		$err_date = 'Please select valid start date';

	}

	elseif(mktime(0,0,0,$start_month,$start_day,$start_year) > time())

	{

		$error = true;

		$tr_err_date = '';

		$err_date = 'Please select today or previous day for start date ';

	}

	else

	{

		$start_date = $start_year.'-'.$start_month.'-'.$start_day;

	}





	if($end_month == '')

	{

		$error = true;

		if($tr_err_date == 'none')

		{

			$tr_err_date = '';

			$err_date = 'Please select end month';

		}

		else

		{

			$err_date .= '<br>Please select end month';

		}	

	}

	elseif($end_year == '')

	{

		$error = true;

		if($tr_err_date == 'none')

		{

			$tr_err_date = '';

			$err_date = 'Please select end year';

		}

		else

		{

			$err_date .= '<br>Please select end year';

		}	

	}

	else

	{

		$end_date = $end_year.'-'.$end_month.'-'.$end_day;

		$end_day = date('t',strtotime($end_date)); 

		$end_date = $end_year.'-'.$end_month.'-'.$end_day;

		

		if(strtotime($start_date) > strtotime($end_date))

		{

			$error = true;

			if($tr_err_date == 'none')

			{

				$tr_err_date = '';

				$err_date = 'Please select end month/year less than start month/year';

			}

			else

			{

				$err_date .= '<br>Please select end month/year less than start month/year';

			}	

		}	

	}	



	if(!$error)

	{

		list($return,$arr_reward_modules,$arr_reward_summary) = getMyRewardsChart($user_id,$start_date,$end_date);

	}

}

else

{

	$now = time();

	$user_add_date = getUserRegistrationTimestamp($user_id);

	$start_year = date("Y",$user_add_date);

	$start_month = date("m",$user_add_date);

	$start_day = date("d",$user_add_date);

	$end_year = date("Y",$now);

	$end_month = date("m",$now);

	$end_day = date('t',$now); 

	$error = false;

	$return = false;

	

	$start_date = $start_year.'-'.$start_month.'-'.$start_day;

	$end_date = $end_year.'-'.$end_month.'-'.$end_day;

	list($return,$arr_reward_modules,$arr_reward_summary) = getMyRewardsChart($user_id,$start_date,$end_date);

}

$summary_cnt = count($arr_reward_summary);

//echo '<br><pre>';

//print_r($arr_reward_summary);

//echo '<br></pre>';

//echo '<br>Testkk summary_cnt = '.$summary_cnt;

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

                                    if(isLoggedIn())

                                    { 

                                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);

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

               if(isLoggedIn())

                                    { 

                                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);

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

       <li> <a href="../refer_a_friend.php" target="_blank">

Invite Friends

</a> </li>



 <li><a  href="../my_fav_list.php" target="_blank" >

My Fav List

</a></li>

 

 <li><a  href="../library.php" target="_blank">

My Library

</a></li>







 <li><a href="../feedback.php" target="_blank">

My Feedback

</a></li>



 <li><a  href="../my_subscription_plans.php" target="_blank">

Subscription

</a></li>



 <li><a href="../edit_profile.php" target="_blank">

Edit Profile

</a></li>



        



                         <?php



                                                $arr_active_menu_items = getAllActiveMenuItems(0);



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



                                                    if(isLoggedIn() || isLoggedInPro())



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

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header" style="margin-bottom:20px;" >

    <ol class="breadcrumb">

        <li><a href="index.php" target="_blank"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Dashboard</li>

      </ol>

      

      <span class="userName">  <?php

               if(isLoggedIn())

                                    { 

                                        echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);

                                    }

                                    ?></span>

      </section>

    <section class="content-header">

    

      <h1 class="fontGreenDash">

       <!-- REWARDS MELA - The ONLY Site that Rewards you for your efforts & motivation-->

       LIFE KO # NAYA ANDAAZ REWARDS - To Motivate & Appreciate Your Efforts

        <small></small>

      </h1>

      

    </section>



    <!-- Main content -->

    <section class="content">

       <!-- Main row -->

      

      <!-- Info boxes -->

      <div class="row">

        <div class="col-md-2 col-sm-6 col-xs-12">

       <a href="http://wellnessway4u.com/pages.php?id=148" target="_blank">   <div class="info-box">

         <center> <span><b>October Challenge </b></span><br/>

         <!-- 1500 Reward points from minimum Three MY KEYS or more.-->

          <img src="uploads/month_challenge.png" width="120" height="120" > </center>    

            <!-- /.info-box-content -->

          </div></a>

          <!-- /.info-box -->

        </div>

        <!-- /.col -->

        <div class="col-md-2 col-sm-6 col-xs-12">

        <a href="http://wellnessway4u.com/pages.php?id=161" target="_blank">

          <div class="info-box">

        <center> <span><b>Mega Rewards Challenge</b></span><br/>

         <img src="uploads/reward-1.jpg" width="120" height="120" ></center>

             

            <!-- /.info-box-content -->

          </div>

          </a>

          <!-- /.info-box -->

        </div>

        <!-- /.col -->



        <!-- fix for small devices only -->

        <div class="clearfix visible-sm-block"></div>



        <div class="col-md-2 col-sm-6 col-xs-12">

        <a href="../my_rewards.php" target="_blank">   <div class="info-box">

       <center>  <span><b>Rewards Catlog</b></span><br/>

         <img src="uploads/reward_catlog-banner.jpg" width="135" height="135" ></center>

            <!-- /.info-box-content -->

          </div></a>

          <!-- /.info-box -->

        </div>

        <!-- /.col -->

        <div class="col-md-2 col-sm-6 col-xs-12">

          <a href="http://wellnessway4u.com/pages.php?id=160" target="_blank">

          <div class="info-box">

        <center>  <span><b>Achievers Hall of Fame</b></span><br/>

           <img src="uploads/Achievers-Hall-Fame.jpg" width="135" height="135" >

           </center>

            <!-- /.info-box-content -->

          </div>

          </a>

          <!-- /.info-box -->

        </div>

        <!-- /.col -->    

        <div class="col-md-4 col-sm-6 col-xs-12">

          <div class="info-box">

            <center> <!--<span><b> Communication & Work</b></span><br/>-->

            <iframe width="300" height="180" src="https://www.youtube.com/embed/hfAipKVfwt0" frameborder="0" allowfullscreen></iframe>

            

              <!--<img src="uploads/My-Communication-wellness-way-4-u-07.jpg" width="80" height="80" >--></center>

   

            <!-- /.info-box-content -->

          </div>

          <!-- /.info-box -->

        </div>

        <!-- /.col -->

      </div>

      

      

      

      <!-- /.row -->



      <!-- Main row -->

      <div class="row">

        <!-- Left col -->

        <div class="col-md-8">

            <!-- My 10 Keys  -->

          <div class="box box-info">

            <div class="box-header with-border">

              <h3 class="fontCap">TO ACHIEVE YOUR  GOALS - START HERE WITH MY 6 KEYS</h3>



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

              <h5 class="box-title">Just like Social Media, simply talk / review about quality of your daily LIFE routine, experiences & possible reasons</h5>            

            <!-- /.box-header -->

           <!-- Start My Food-->

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

	$yfoodCount = getMyFoodCountByDate($yesterdayDate, $_SESSION['user_id']);

?>

							<span><?php echo $yfoodCount;?></span>

            </time>

            </div>

               <div class="col-md-5">

            <time class="icon">

  <em>entries</em>

  <strong>Today</strong>

  <?php	

	$tfoodCount = getMyFoodCountByDate($todayDate, $_SESSION['user_id']);

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

         <!-- My Activity-->

          <a href="../activity.php" target="_blank">  

            <div class="col-md-4">  

           <h5 class="box-title subKey6">My Activity</h5>

            <div class="box-body">

            <div class="col-md-5">

           <time class="icon">

  <em>entries</em>

  <strong>Yesterday</strong>

 <?php

	$yactivityCount = getMyActivityCountByDate($yesterdayDate, $_SESSION['user_id']);

?>

							<span><?php echo $yactivityCount;?></span>



            </time>

            </div>

               <div class="col-md-5">

            <time class="icon">

  <em>entries</em>

  <strong>Today</strong>

  <?php	

	$tactivityCount = getMyActivityCountByDate($todayDate, $_SESSION['user_id']);

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

           <!-- My Sleep-->

           <a href="../sleep.php" target="_blank">

            <div class="col-md-4">  

           <h5 class="box-title subKey6">My Sleep</h5>

            <div class="box-body">

            <div class="col-md-5">

           <time class="icon">

  <em>entries</em>

  <strong>Yesterday</strong>

  <?php

	$yactivityCount = getMySleepCountByDate($yesterdayDate, $_SESSION['user_id']);

?>

							<span><?php echo $yactivityCount;?></span>

 

           </time>

            </div>

               <div class="col-md-5">

            <time class="icon">

  <em>entries</em>

  <strong>Today</strong>

<?php	

	$tactivityCount = getMySleepCountByDate($todayDate, $_SESSION['user_id']);

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

           <!--Your Daily Energy Drainers or Rejuvenators -->

           <div class="col-md-12">

              <h4 class="box-title">TRACK your Emotions Management</h4>            

            <!-- /.box-header -->

            

            <!--My Situation Today-->

            <a href="../my_day_today.php" target="_blank">

            <div class="col-md-4">  

           <h5 class="box-title subKey6">My Situation Today</h5>

            <div class="box-body">

            <div class="col-md-5">

           <time class="icon">

  <em>entries</em>

  <strong>Yesterday</strong>

  <?php

	$yactivityCount = getMySituationByDate($yesterdayDate, $_SESSION['user_id']);

?>

							<span><?php echo $yactivityCount;?></span>

            </time>

            </div>

               <div class="col-md-5">

            <time class="icon">

  <em>entries</em>

  <strong>Today</strong>

  <?php	

	$tactivityCount = getMySituationByDate($todayDate, $_SESSION['user_id']);

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

          <!-- My Communications  -->

          <a href="../my_communications.php" target="_blank">

            <div class="col-md-4">  

           <h5 class="box-title subKey6">My Communications</h5>

            <div class="box-body">

            <div class="col-md-5">

           <time class="icon">

  <em>entries</em>

  <strong>Yesterday</strong>

<?php

	$yactivityCount = getMyCommunicationsByDate($yesterdayDate, $_SESSION['user_id']);

?>

							<span><?php echo $yactivityCount;?></span>

            </time>

            </div>

               <div class="col-md-5">

            <time class="icon">

  <em>entries</em>

  <strong>Today</strong>

  <?php	

	$tactivityCount = getMyCommunicationsByDate($todayDate, $_SESSION['user_id']);

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

         <!-- Workplace --> 

         <a href="../work_and_environment.php" target="_blank">

            <div class="col-md-4">  

           <h5 class="box-title subKey6">Workplace</h5>

            <div class="box-body">

            <div class="col-md-5">

           <time class="icon">

  <em>entries</em>

  <strong>Yesterday</strong>

<?php

	$yactivityCount = getMyWorkplaceByDate($yesterdayDate, $_SESSION['user_id']);

?>

							<span><?php echo $yactivityCount;?></span>

            </time>

            </div>

               <div class="col-md-5">

            <time class="icon">

  <em>entries</em>

  <strong>Today</strong>

 <?php	

	$tactivityCount = getMyWorkplaceByDate($todayDate, $_SESSION['user_id']);

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

              <h3 class="fontCap">Track Below Your Wim Patterns</h3>

</div>

          

            <!-- /.box-header -->

            <div class="box-body">

               <!-- Info Boxes Style 2 -->

                <div class="row">

                <!--Digital Personal Wellness Diary-->

        

         <div class="col-md-4">          

         <div class="box-body"> 

         <center>

            <h5 class="box-title"><!--My Energy Indicators Today-->My Lifestyle/Routine @</h5>

          <a href="../digital_personal_wellness_diary.php" target="_blank">    

           <h5 class="box-title subKey5">My Digital Wellness Diary</h5>

            

            

<!--  <em>entries</em>-->

  <!--<strong>Yesterday</strong>-->

 <img src="uploads/wim-sim.jpg" width="100" height="100" alt="wim">

           

           

            

             <!-- Bar-->

           <!--<div class="progress-group">

                  

                    <span class="progress-number"><b>150</b>/200</span>



                    <div class="progress sm">

                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>

                    </div>

                  </div>-->

           <!-- Bar-->

            </a>

            </center>

           </div>           

            </div>

          

            <!-- End Digital Personal Wellness Diary-->

            <!-- /.box-header -->

          <!--  My Physical signs-->

         

           <div class="box-body">  

            <div class="col-md-4">  

            <center>

             <a href="../current_physical_state.php" target="_blank">   

            <h5 class="box-title">My BODY Speak @</h5>   

                  

           <h5 class="box-title subKey5">My Physical signs</h5>

            

           

<!--  <em>entries</em>-->

  <!--<strong>Yesterday</strong>-->

 <img src="uploads/My-Physical-Signs-1.jpg" width="100" height="100" alt="wim">

           

           

            

             <!-- Bar-->

         <!--  <div class="progress-group">

                   

                    <span class="progress-number"><b>150</b>/200</span>



                    <div class="progress sm">

                      <div class="progress-bar progress-bar-green" style="width: 80%"></div>

                    </div>

                  </div>-->

           <!-- Bar-->

           </a>

           </center>

           </div>

            </div>

           

             <!--  End My Physical signs-->

            <!-- /.box-body -->          

        

           

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

         <div class="col-md-4">  

        <div class="box box-info">

            <div class="box-header with-border">

              <h3 class="box-title">Products/Services</h3>



              <div class="box-tools pull-right">

                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>

                </button>

                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>

              </div>

            </div>

            <!-- /.box-header -->           

               <!-- Info Boxes Style 2 -->

               <div class="box-body">

               <div class="row">

               <center>

                <div class="col-md-12">

                <iframe width="300" height="225" src="https://www.youtube.com/embed/B8HUn8Ma3QM" frameborder="0" allowfullscreen></iframe>                

           </div>

           <br/>

           <div class="col-md-12">

                <iframe width="300" height="225" src="https://www.youtube.com/embed/ejDpAOyFnoE" frameborder="0" allowfullscreen></iframe>               

           </div>   

             <br/>

             <div class="col-md-12">        

        <iframe width="300" height="225" src="https://www.youtube.com/embed/TAs9cNurB0o" frameborder="0" allowfullscreen></iframe>  

          </div>

          </center>

          </div>

          </div>

              <!-- /.table-responsive -->          

            <!-- /.box-body -->            

            <!-- /.box-footer -->

          </div>       

            </div>

         

         

         </div> 

   <!-- /.box -->


   <!-- Main row -->

      <div class="row">

        <div class="col-md-4">         

          <!-- /.box -->    

             <!-- My Advisors PanelT -->

          <div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">My Advisors Panel</h3>



              <div class="box-tools pull-right">

                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>

                </button>

                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>

              </div>

            </div>

            


            

            <!-- /.box-header -->

            <div class="box-body">

            <a href="../my_referal_adviser.php" class="uppercase" target="_blank">Invite Advisers</a>

            </div>

            <!-- /.box-body -->            

            <!-- /.box-footer -->

          </div>

          <!-- /.box -->  

  <div class="box box-danger" style="display:none;">

                <div class="box-header with-border">

                  <h3 class="box-title">Reward Winner Members</h3>



                  <div class="box-tools pull-right">

                    <span class="label label-danger">8 New Members</span>

                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>

                    </button>

                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>

                    </button>

                  </div>

                </div>

                <!-- /.box-header -->

                <div class="box-body no-padding">

                  <ul class="users-list clearfix">

                    <li>

                      <img src="userdashboard/dist/img/user1-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Santosh R</a>

                      <span class="users-list-date">Today</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user8-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Norman</a>

                      <span class="users-list-date">Yesterday</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user7-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Jane</a>

                      <span class="users-list-date">12 Jan</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user6-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">John</a>

                      <span class="users-list-date">12 Jan</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user2-160x160.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Alexander</a>

                      <span class="users-list-date">13 Jan</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user5-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Sarah</a>

                      <span class="users-list-date">14 Jan</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user4-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Nora</a>

                      <span class="users-list-date">15 Jan</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user3-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Nadia</a>

                      <span class="users-list-date">15 Jan</span>

                    </li>

                  </ul>

                  <!-- /.users-list -->

                </div>

                <!-- /.box-body -->

                <div class="box-footer text-center">

                  <a href="javascript:void(0)" class="uppercase">View All Users</a>

                </div>

                <!-- /.box-footer -->

              </div>

 

         

        </div>

        <!-- /.col -->

         <!-- Left col -->

        <div class="col-md-4">         

              <!-- DIRECT CHAT -->

              <div class="box box-primary">

                <div class="box-header with-border">

                  <h3 class="box-title">24 x 7 Online  Consulting</h3>




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

                <a href="../my_adviser_queries.php" class="uppercase" target="_blank">24 x 7 Online  Consulting</a>

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

        <!-- /.col -->

<div class="col-md-8">         

          <!-- /.box -->    

             <!-- My Advisors PanelT -->

          <div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Advisors Module </h3>

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

                <!--Digital Personal Wellness Diary-->

          <div class="col-md-4"> 
         
              <div class="box-body"> 

         <center>

         <!--   <h5 class="box-title">My Lifestyle/Routine @</h5>-->

          <a href="../general_stressors.php" target="_blank">    

           <h5 class="box-title subKey5">General Stress</h5>
<!--  <em>entries</em>-->
  <!--<strong>Yesterday</strong>-->
 <img src="uploads/General-Stress-wellness-way-4-u-06.jpg" width="100" height="100" alt="General-Stress">
            </a>

            </center>

           </div>         

            </div>
            <!-- End Digital Personal Wellness Diary-->
            <!-- /.box-header -->
          <!--  My Physical signs-->
         <div class="col-md-4">  
           <div class="box-body">  
            <center>
             <a href="../addictions.php" target="_blank">   

         <!--   <h5 class="box-title">My BODY Speak @</h5>   -->
           <h5 class="box-title subKey5">My Addiction</h5>
<!--  <em>entries</em>-->
  <!--<strong>Yesterday</strong>-->
 <img src="uploads/My-Addiction-wellness-way-4-u-10.jpg" width="100" height="100" alt="My-Addiction-wellness">
           </a>

           </center>

           </div>

            </div>
          
         <div class="col-md-4">          
        <div class="box-body"> 
         <center>
         <!--   <h5 class="box-title">My Lifestyle/Routine @</h5>-->
          <a href="../my_relations.php" target="_blank">    

           <h5 class="box-title subKey5">My Relations</h5>
<!--  <em>entries</em>-->
  <!--<strong>Yesterday</strong>-->
 <img src="uploads/My-Relations-wellness.jpg" width="100" height="100" alt="My-Relations">
            </a>
            </center>
           </div>   
            </div>
             <!--  End My Physical signs-->
            <!-- /.box-body --> 
          </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->  
          </div>

          <!-- /.box -->  

  <div class="box box-danger" style="display:none;">

                <div class="box-header with-border">

                  <h3 class="box-title">Reward Winner Members</h3>



                  <div class="box-tools pull-right">

                    <span class="label label-danger">8 New Members</span>

                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>

                    </button>

                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>

                    </button>

                  </div>

                </div>

                <!-- /.box-header -->

                <div class="box-body no-padding">

                  <ul class="users-list clearfix">

                    <li>

                      <img src="userdashboard/dist/img/user1-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Santosh R</a>

                      <span class="users-list-date">Today</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user8-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Norman</a>

                      <span class="users-list-date">Yesterday</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user7-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Jane</a>

                      <span class="users-list-date">12 Jan</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user6-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">John</a>

                      <span class="users-list-date">12 Jan</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user2-160x160.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Alexander</a>

                      <span class="users-list-date">13 Jan</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user5-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Sarah</a>

                      <span class="users-list-date">14 Jan</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user4-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Nora</a>

                      <span class="users-list-date">15 Jan</span>

                    </li>

                    <li>

                      <img src="userdashboard/dist/img/user3-128x128.jpg" alt="User Image">

                      <a class="users-list-name" href="#">Nadia</a>

                      <span class="users-list-date">15 Jan</span>

                    </li>

                  </ul>

                  <!-- /.users-list -->

                </div>

                <!-- /.box-body -->

                <div class="box-footer text-center">

                  <a href="javascript:void(0)" class="uppercase">View All Users</a>

                </div>

                <!-- /.box-footer -->

              </div>

 

         

        </div>

        <!-- Banner ads -->

        <div class="col-md-2">  

        <div class="box box-info">

            <div class="box-header with-border">

              <h3 class="box-title">Section 1</h3>



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

                <div class="col-md-12">

               <iframe width="140" height="160" src="https://www.youtube.com/embed/nh2p2fcfYbc" frameborder="0" allowfullscreen></iframe>

                </div> <br/> 

                <div class="col-md-12">

             <iframe width="140" height="160" src="https://www.youtube.com/embed/epAgSC7MjpU" frameborder="0" allowfullscreen></iframe>

                </div>      

          </div>

              <!-- /.table-responsive -->

            </div>

            <!-- /.box-body -->            

            <!-- /.box-footer -->

          </div>       

            </div>

           <!-- /.col -->

            <!-- Banner ads -->

        <div class="col-md-2">  

        <div class="box box-info">

            <div class="box-header with-border">

              <h3 class="box-title">Products/Services</h3>



              <div class="box-tools pull-right">

                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>

                </button>

                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>

              </div>

            </div>

            <!-- /.box-header -->           

               <!-- Info Boxes Style 2 -->

               <div class="row">

                <div class="col-md-12">

       <center> <img src="uploads/hero-cycle.jpg" alt="User Image" ></center>

       <!--  <?php include_once('right_sidebar.php'); ?>-->

           </div>

          </div>

              <!-- /.table-responsive -->          

            <!-- /.box-body -->            

            <!-- /.box-footer -->

          </div>       

            </div>

           <!-- /.col -->
           

      </div>

      <!-- /.row -->

   

    <!-- /.content -->

</section>



</div>

  <!-- /.content-wrapper -->



  <footer class="main-footer">

    <div class="pull-right hidden-xs">

     

    </div>

   &#65533;2016 Chaitanya Wellness Research Institute, all rights reserved.

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




<?php
session_start();
ob_start();
ini_set("memory_limit","200M");
error_reporting(E_ERROR | E_PARSE);
//error_reporting(E_ALL);
ini_set("display_errors","1");
if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };
@set_time_limit(1000000);
date_default_timezone_set('Asia/Kolkata');
require_once('../init.php');
require_once('../class.phpmailer.php');
require_once('config/class.mysql.php');
require_once('classes/class.admin.php');
require_once('classes/class.menus.php');

//echo'<br><pre>';
//print_r($_SESSION);
//echo'<br></pre>';

$obj = new Menus();

list($arr_menu_id,$arr_menu_name,$arr_menu_mode) = $obj->getAllMenu();

if(isset($_SESSION['admin_id']))

{
    $admin_id = $_SESSION['admin_id'];
}

else

{
    $admin_id = '';
}	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Admin back-end - Chaitanya Wellness Research Institute</title>

<link href="css/styles.css" rel="stylesheet" type="text/css">



<script language="javascript1.2" type="text/javascript" src="js/admin_scripts.js"></script>

<script language="javascript1.2" type="text/javascript" src="js/jquery-1.4.2.min.js"></script>

<script language="javascript1.2" type="text/javascript" src="js/main.js"></script>

<!--bar graph and pichart js and css-->

<?php /*<script type="text/javascript" src="js/jquery.min.js"></script> */ ?> 

<script type="text/javascript" src="js/jquery.jqplot.min.js"></script>

<script type="text/javascript" src="js/jquery.jqplot.min.js"></script>

<script type="text/javascript" src="js/jqplot.barRenderer.min.js"></script>

<script type="text/javascript" src="js/jqplot.pieRenderer.min.js"></script>

<script type="text/javascript" src="js/jqplot.categoryAxisRenderer.min.js"></script>

<script type="text/javascript" src="js/jqplot.pointLabels.min.js"></script>

 <link href="../csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>      
 <link href="../csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />
 
<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.min.css" />

<link rel="stylesheet" type="text/css" href="css/examples.min.css" />

<link type="text/css" rel="stylesheet" href="css/shCoreDefault.min.css" />

<link type="text/css" rel="stylesheet" href="css/shThemejqPlot.min.css" />

<script  language="javascript"  src="js/jqplot.donutRenderer.min.js"></script>


<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script type="text/javascript" src="../w_js/jquery-1.12.4.min.js" charset="UTF-8"></script>


 <link rel="stylesheet" href="css/bootstrap-datepicker.css"/> 


 <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>


<script  language="javascript"  src="../csswell/bootstrap/js/bootstrap.min.js"></script>


 <!-- latest jQuery library -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->




</head>

<body >

<table style="height: 100%; " border="0" width="100%" cellpadding="0" cellspacing="0" >

<tbody>

    <tr>

        <td valign="top">

            <table border="0" width="100%" cellpadding="0" cellspacing="0">

            <tbody>

                <tr>

                    <td><?php include('include/header.php'); ?></td>

                </tr>

                <tr>

                    <td>

                        <table border="0" width="100%" cellpadding="0" cellspacing="0">

                        <tbody>

                            <tr>

                                <td width="1%">&nbsp;</td>

                                <td width="15%" valign="top" id="left_sideboxes">

                                <?php 

                                if(isset($_GET['mode']) && isset($_SESSION['admin_id']) && $_SESSION['admin_id'] != '')

                                {

                                    $mode = $_GET['mode'];

                                }	

                                else

                                {

                                    $mode = "login";

                                }	



                                switch($mode)

                                {

                                    case "login":  break;

                                    case "recover_password": break;

                                    default : include('include/mainmenu.php');

                                }

                                ?>

                                    <p></p>

                                    <div><img src="images/spacer.gif" alt="" border="0" width="145" height="1"></div>

                                </td>

                                <td width="1%">&nbsp;&nbsp;&nbsp;</td>

                                <td valign="top" width="80%">

                                <?php 

                                //echo $mode;

                                switch($mode)

                                {
                                    case "icons":                               include('include/icons.php'); break;   

                                    case "add_icons":                           include('include/add_icons.php'); break;

                                    case "edit_icons":                          include('include/edit_icons.php'); break;
                                    
                                    case "interpretation_reading":              include('include/interpretation_reading.php'); break;   

                                    case "add_interpretation_reading": 		include('include/add_interpretation_reading.php'); break;

                                    case "edit_interpretation_reading": 	include('include/edit_interpretation_reading.php'); break;
                                    
                                    case "set_goals_and_query":                 include('include/set_goals_and_query.php'); break;
                                    
                                    case "add_goals_and_query": 		include('include/add_goals_and_query.php'); break;
                                    
                                    case "edit_goals_and_query": 		include('include/edit_goals_and_query.php'); break;
                                    
                                    case "manage_page_fav_cat_dropdowns":       include('include/manage_page_fav_cat_dropdowns.php'); break;         

                                    case "add_page_fav_cat_dropdown":           include('include/add_page_fav_cat_dropdown.php'); break;         

                                    case "edit_page_fav_cat_dropdown":          include('include/edit_page_fav_cat_dropdown.php'); break; 
                                    
                                    case "manage-data-dropdown":                include('include/manage-data-dropdown.php'); break;
                                    case "add-data-dropdown":                   include('include/add-data-dropdown.php'); break;  
                                    case "edit-data-dropdown":                  include('include/edit-data-dropdown.php'); break; 
                                    
                                    case "manage-design-your-life":             include('include/manage-design-your-life.php'); break;
                                    case "add-design-your-life":                include('include/add-design-your-life.php'); break;  
                                    case "edit-design-your-life":               include('include/edit-design-your-life.php'); break; 

                                    case "function_name":                       include('include/function_name.php'); break;         

                                    case "add_function_name":                   include('include/add_function_name.php'); break;         

                                    case "edit_function_name":                  include('include/edit_function_name.php'); break;

                                    case "personalities":                       include('include/personalities.php'); break;   
                                    
                                    case "add_personalities":                   include('include/add_personalities.php'); break;

                                    case "edit_personalities":                  include('include/edit_personalities.php'); break;
                                    
                                    case "manage_subadmin":                     include('include/manage_subadmin.php'); break;   

                                    case "add_sub_admin":                       include('include/add_sub_admin.php'); break;

                                    case "edit_sub_admin":                      include('include/edit_sub_admin.php'); break;
                                    
                                    case "manage_scale":                        include('include/manage_scale.php'); break;
                                    
                                    case "add_scale":                           include('include/add_scale.php'); break;

                                    case "edit_scale":                          include('include/edit_scale.php'); break;

                                    case "reset_sub_admin_password":            include('include/reset_sub_admin_password.php'); break;

                                    case "login":                               include('include/login.php'); break;

                                    case "home":                                include('include/home.php'); break;

                                    case "change_password":                     include('include/changepassword.php'); break;

                                    case "logout":                              include('sql/logout.php'); break;

                                    case "myaccount":                           include('include/myaccount.php'); break;

                                    case "users":                               include('include/users.php'); break;

                                    case "reset_user_password":                 include('include/reset_user_password.php'); break;

                                    case "edit_user":                           include('include/edit_user.php'); break;

                                    case "add_user":                            include('include/add_user.php'); break;

                                    case "daily_activity":                      include('include/daily_activity.php'); break;

                                    case "import_daily_activity":               include('include/import_daily_activity.php'); break;

                                    case "edit_daily_activity":                 include('include/edit_daily_activity.php'); break;

                                    case "add_daily_activity":                  include('include/add_daily_activity.php'); break;

                                    case "daily_meals":                         include('include/daily_meals.php'); break;

                                    case "import_daily_meals":                  include('include/import_daily_meals.php'); break;

                                    case "edit_daily_meal":                     include('include/edit_daily_meal.php'); break;

                                    case "add_daily_meal":                      include('include/add_daily_meal.php'); break;

                                    case "ngo_sliders":                         include('include/ngo_sliders.php'); break;

                                    case "add_ngo_slider":                      include('include/add_ngo_slider.php'); break;

                                    case "edit_ngo_slider":                     include('include/edit_ngo_slider.php'); break;

                                    case "nature_sliders":                      include('include/nature_sliders.php'); break;

                                    case "add_nature_slider":                   include('include/add_nature_slider.php'); break;

                                    case "edit_nature_slider":                  include('include/edit_nature_slider.php'); break;

                                    case "work_and_environment":                include('include/work_and_environment.php'); break;

                                    case "edit_work_and_environment":           include('include/edit_work_and_environment.php'); break;

                                    case "add_work_and_environment":            include('include/add_work_and_environment.php'); break;

                                    case "heights":                             include('include/heights.php'); break;

                                    case "import_heights":                  include('include/import_heights.php'); break;

                                    case "edit_height":                     include('include/edit_height.php'); break;

                                    case "add_height":                      include('include/add_height.php'); break;

                                    case "states":                          include('include/states.php'); break;

                                    case "edit_state":                      include('include/edit_state.php'); break;

                                    case "add_state":                       include('include/add_state.php'); break;

                                    case "cities":                          include('include/cities.php'); break;

                                    case "edit_city":                       include('include/edit_city.php'); break;

                                    case "add_city":                        include('include/add_city.php'); break;

                                    case "import_places":                   include('include/import_places.php'); break;

                                    case "places":                          include('include/places.php'); break;

                                    case "edit_place":                      include('include/edit_place.php'); break;

                                    case "add_place":                       include('include/add_place.php'); break;

                                    case "contents":                        include('include/contents.php'); break;

                                    case "edit_content":                    include('include/edit_content.php'); break;

                                    case "add_content":                     include('include/add_content.php'); break;
                                    
                                    case "user-dashboard":                        include('include/user-dashboard.php'); break;

                                    case "edit_user_dashboard":                    include('include/edit_user_dashboard.php'); break;

                                    case "add_user_dashboard":                     include('include/add_user_dashboard.php'); break;
                                
                                    case "general_stressors":               include('include/general_stressors.php'); break;

                                    case "edit_general_stressors":          include('include/edit_general_stressors.php'); break;

                                    case "add_general_stressors":           include('include/add_general_stressors.php'); break;

                                    case "sleeps":                          include('include/sleeps.php'); break;

                                    case "edit_sleep":                      include('include/edit_sleep.php'); break;

                                    case "add_sleep":                       include('include/add_sleep.php'); break;

                                    case "my_communications":               include('include/my_communications.php'); break;

                                    case "edit_my_communication":           include('include/edit_my_communication.php'); break;

                                    case "add_my_communication":            include('include/add_my_communication.php'); break;

                                    case "my_relations":                    include('include/my_relations.php'); break;

                                    case "edit_my_relation":                include('include/edit_my_relation.php'); break;

                                    case "add_my_relation":                 include('include/add_my_relation.php'); break;

                                    case "majorlifeevents":                 include('include/majorlifeevents.php'); break;

                                    case "edit_majorlifeevent":             include('include/edit_majorlifeevent.php'); break;

                                    case "add_majorlifeevent":              include('include/add_majorlifeevent.php'); break;

                                    case "addictions":                      include('include/addictions.php'); break;

                                    case "edit_addiction":                  include('include/edit_addiction.php'); break;

                                    case "add_addiction":                   include('include/add_addiction.php'); break;

                                    case "reports":                         include('include/reports.php'); break;

                                    case "import_nutrients":                include('include/import_nutrients.php'); break;

                                    case "nutrients":                       include('include/nutrients.php'); break;

                                    case "edit_nutrients":                  include('include/edit_nutrients.php'); break;

                                    case "import_nutrientstdreq":           include('include/import_nutrientstdreq.php'); break;

                                    case "nutrientstdreq":                  include('include/nutrientstdreq.php'); break;

                                    case "edit_nutrientstdreq":             include('include/edit_nutrientstdreq.php'); break;

                                    case "import_nutrientavgreq":           include('include/import_nutrientavgreq.php'); break;

                                    case "nutrientavgreq":                  include('include/nutrientavgreq.php'); break;

                                    case "edit_nutrientavgreq":             include('include/edit_nutrientavgreq.php'); break;

                                    case "import_nutrientuplim":            include('include/import_nutrientuplim.php'); break;

                                    case "nutrientuplim":                   include('include/nutrientuplim.php'); break;

                                    case "edit_nutrientuplim":              include('include/edit_nutrientuplim.php'); break;

                                    case "banner":                          include('include/banner.php'); break;

                                    case "add_banner":                      include('include/add_banner.php'); break;

                                    case "edit_banner":                     include('include/edit_banner.php'); break;

                                    case "top_banner":     		    include('include/top_banner.php'); break; 

                                    case "add_top_banner":                  include('include/add_top_banner.php'); break;

                                    //case "edit_top_banner":               include('include/edit_top_banner.php'); break; 

                                    case "sliders":                         include('include/sliders.php'); break;

                                    case "view_sliders":                    include('include/view_sliders.php'); break;

                                    case "add_sliders":                     include('include/add_sliders.php'); break; 

                                    case "edit_slider":                     include('include/edit_slider.php'); break;   

                                    case "add_view_slider":                 include('include/add_view_slider.php'); break; 

                                    case "edit_view_slider":                include('include/edit_view_slider.php'); break;

                                    case "stressbuster":                    include('include/stressbuster.php'); break;

                                    case "add_stressbuster":                include('include/add_stressbuster.php'); break; 

                                    case "edit_stressbuster":               include('include/edit_stressbuster.php'); break;

                                    case "manage_pdf":                      include('include/manage_pdf.php'); break;   

                                    case "edit_pdf":                        include('include/edit_pdf.php'); break;

                                    case "manage_user_uploads":             include('include/manage_user_uploads.php'); break;

                                    case "manage_background_music":         include('include/manage_background_music.php'); break;  

                                    case "edit_music":                      include('include/edit_music.php'); break;   

                                    case "manage_tooltip":                  include('include/manage_tooltip.php'); break; 

                                    case "add_stressbuster_pdf":            include('include/add_stressbuster_pdf.php'); break; 

                                    case "add_music":                       include('include/add_music.php'); break;

                                    case "click_sound":                     include('include/click_sound.php'); break;

                                    case "add_new_clip":                    include('include/add_new_clip.php'); break;

                                    case "edit_sound_clip":                 include('include/edit_sound_clip.php'); break;

                                    case "angervent":                       include('include/angervent.php'); break;   

                                    case "add_angervent":                   include('include/add_angervent.php'); break;  

                                    case "edit_angervent":                  include('include/edit_angervent.php'); break;  

                                    case "angervent_pdf":                   include('include/angervent_pdf.php'); break; 

                                    case "add_angervent_pdf":               include('include/add_angervent_pdf.php'); break;  

                                    case "edit_angevent_pdf":               include('include/edit_angevent_pdf.php'); break;

                                    case "manage_anger_vent_bk_music":      include('include/manage_anger_vent_bk_music.php'); break; 

                                    case "add_angervent_music":             include('include/add_angervent_music.php'); break;   

                                    case "edit_anger_vent_music":           include('include/edit_anger_vent_music.php'); break;  

                                    case "angervent_tooltip":               include('include/angervent_tooltip.php'); break;  

                                    case "angervent_user_upload":           include('include/angervent_user_upload.php'); break;

                                    case "mindjumble":                      include('include/mindjumble.php'); break;

                                    case "add_mindjumble":                  include('include/add_mindjumble.php'); break;

                                    case "edit_mindjumble":                 include('include/edit_mindjumble.php'); break;  

                                    case "mindjumble_pdf":                  include('include/mindjumble_pdf.php'); break;

                                    case "add_mindjumble_pdf":              include('include/add_mindjumble_pdf.php'); break;  

                                    case "edit_mindjumble_pdf":             include('include/edit_mindjumble_pdf.php'); break;  

                                    case "mindjumble_user_upload":          include('include/mindjumble_user_upload.php'); break;  
                                    
                                    case "edit_user_uploads":          include('include/edit_user_uploads.php'); break;  

                                    case "mindjumble_tooltip":              include('include/mindjumble_tooltip.php'); break;

                                    case "mindjumble_bk_music":             include('include/mindjumble_bk_music.php'); break;  

                                    case "edit_mindjumble_music":           include('include/edit_mindjumble_music.php'); break;

                                    case "add_mindjumble_music":            include('include/add_mindjumble_music.php'); break;  

                                    case "exclusion":                          include('include/exclusion.php'); break; 

                                    case "add_exclusion":                      include('include/add_exclusion.php'); break;       

                                    case "edit_exclusion":                      include('include/edit_exclusion.php'); break;

                                    case "theams":                          include('include/theams.php'); break; 

                                    case "add_theams":                      include('include/add_theams.php'); break;       

                                    case "edit_theam":                      include('include/edit_theam.php'); break;

                                    case "invalid":                         include('include/invalid_access.php'); break;     

                                    case "title":                           include('include/title.php'); break;

                                    case "add_title":                       include('include/add_title.php'); break;

                                    case "edit_title":                      include('include/edit_title.php'); break;

                                    case "narration":                       include('include/narration.php'); break;  

                                    case "add_narration":                   include('include/add_narration.php'); break;     

                                    case "edit_narration":                  include('include/edit_narration.php'); break;

                                    case "comments":                        include('include/comment.php'); break;

                                    case "edit_comments":                   include('include/edit_comments.php'); break;

                                    case "feedback":                        include('include/feedback.php'); break;   

                                    case "reply_feedback":                  include('include/reply_feedback.php'); break;

                                    case "update_feedback":                 include('include/update_feedback.php'); break; //add by ample 160420

                                    case "view_conversation":               include('include/view_conversation.php'); break;

                                    case "google_ads":                      include('include/google_ads.php'); break;

                                    case "library":                         include('include/library.php'); break;  

                                    case "manage_reports":                  include('include/manage_reports.php'); break;        

                                    case "dbbackup":                        include('include/dbbackup.php'); break;

                                    case "manage_anger_vent_user_area":     include('include/anger_vent_user_area.php'); break;

                                    case "edit_angervent_user_area":        include('include/edit_angervent_user_area.php'); break;           

                                    case "manage_mindjumble_user_area":     include('include/mindjumble_user_area.php'); break;

                                    case "edit_mindjumble_user_area":       include('include/edit_mindjumble_user_area.php'); break;

                                    case "manage_stressbuster_user_area":   include('include/stressbuster_user_area.php'); break;

                                    case "edit_stressbuster_user_area":     include('include/edit_stressbuster_user_area.php'); break;       

                                    case "manage_menus":                    include('include/manage_menus.php'); break;       

                                    case "reward_points":                   include('include/reward_points.php'); break;       

                                    case "add_reward_point":                include('include/add_reward_point.php'); break;       

                                    case "edit_reward_point":               include('include/edit_reward_point.php'); break;       

                                    case "reward_modules":                  include('include/reward_modules.php'); break;       

                                    case "add_reward_module":               include('include/add_reward_module.php'); break;       

                                    case "edit_reward_module":              include('include/edit_reward_module.php'); break;     

                                    case "reward_bonus":                    include('include/reward_bonus.php'); break;       

                                    case "add_reward_bonus":                include('include/add_reward_bonus.php'); break;         

                                    case "edit_reward_bonus":               include('include/edit_reward_bonus.php'); break;         

                                    case "reward_list":                     include('include/reward_list.php'); break;       

                                    case "add_reward_list":                 include('include/add_reward_list.php'); break;    

                                    case "edit_reward_list":                include('include/edit_reward_list.php'); break;   

                                    //add by ample 19-08-20
                                    case "update_sponsor_data":               
                                    include('include/update_sponsor_data.php'); 
                                    break;      

                                    case "scrolling_windows":               include('include/scrolling_windows.php'); break;         

                                    case "add_scrolling_window":            include('include/add_scrolling_window.php'); break;         

                                    case "edit_scrolling_window":           include('include/edit_scrolling_window.php'); break;         

                                    case "scrolling_contents":              include('include/scrolling_contents.php'); break;         

                                    case "add_scrolling_content":           include('include/add_scrolling_content.php'); break;         

                                    case "edit_scrolling_content":          include('include/edit_scrolling_content.php'); break;   

                                    case "fav_categories":                  include('include/fav_categories.php'); break;         

                                    case "add_fav_category":                include('include/add_fav_category.php'); break;         
                                    //case "add_fav_category":                include('include/add_fav_category_new.php'); break;     
                                    case "edit_fav_category":               include('include/edit_fav_category.php'); break;          

                                    case "view_user_referal":               include('include/view_user_referal.php'); break;  
                                    case "view_vendor_referal":               include('include/view_vendor_referal.php'); break;         		

                                    case "view_user_favlist":               include('include/view_user_favlist.php'); break;      

                                    case "rss_feeds":                       include('include/rss_feeds.php'); break;        		

                                    case "add_rss_feed":                    include('include/add_rss_feed.php'); break;        		

                                    case "edit_rss_feed":                   include('include/edit_rss_feed.php'); break;        		

                                    case "view_rss_feed_items":             include('include/view_rss_feed_items.php'); break; 

                                    case "edit_rss_feed_item":              include('include/edit_rss_feed_item.php'); break; 

                                     //add by ample 26-08-20
                                    case "update_RSS_buttons":               
                                    include('include/update_RSS_buttons.php'); 
                                    break;

                                    case "reward_chart_report":             include('include/reward_chart_report.php'); break; 

                                    case "practitioners":                   include('include/practitioners.php'); break;

                                    case "reset_practitioner_password":     include('include/reset_practitioner_password.php'); break;

                                    case "edit_practitioner":               include('include/edit_practitioner.php'); break;

                                    case "add_practitioner":                include('include/add_practitioner.php'); break;

                                    case "adviser_contents":                include('include/adviser_contents.php'); break;

                                    case "edit_adviser_content":            include('include/edit_adviser_content.php'); break;

                                    case "add_adviser_content":             include('include/add_adviser_content.php'); break;

                                    case "manage_adviser_menus":            include('include/manage_adviser_menus.php'); break;    

                                    case "adviser_plans":                   include('include/adviser_plans.php'); break;

                                    case "edit_adviser_plan":               include('include/edit_adviser_plan.php'); break;

                                    case "add_adviser_plan":                include('include/add_adviser_plan.php'); break;

                                    case "adviser_plan_requests":           include('include/adviser_plan_requests.php'); break;

                                    case "edit_adviser_plan_request":       include('include/edit_adviser_plan_request.php'); break;

                                    case "adviser_banners":                 include('include/adviser_banners.php'); break;

                                    case "add_adviser_banner":              include('include/add_adviser_banner.php'); break;

                                    case "edit_adviser_banner":             include('include/edit_adviser_banner.php'); break;

                                    case "user_plans":                      include('include/user_plans.php'); break;

                                    case "edit_user_plan":                  include('include/edit_user_plan.php'); break;

                                    case "add_user_plan":                   include('include/add_user_plan.php'); break;

                                    case "user_plan_requests":              include('include/user_plan_requests.php'); break;

                                    case "edit_user_plan_request":          include('include/edit_user_plan_request.php'); break;

                                    case "scrolling_bars":                  include('include/scrolling_bars.php'); break;         

                                    case "add_scrolling_bar":               include('include/add_scrolling_bar.php'); break;         

                                    case "edit_scrolling_bar":              include('include/edit_scrolling_bar.php'); break;      

                                    case "adviser_plan_categories":         include('include/adviser_plan_categories.php'); break;         

                                    case "add_adviser_plan_category":       include('include/add_adviser_plan_category.php'); break;         

                                    case "edit_adviser_plan_category":      include('include/edit_adviser_plan_category.php'); break;      

                                    case "user_plan_categories":            include('include/user_plan_categories.php'); break;         

                                    case "add_user_plan_category":          include('include/add_user_plan_category.php'); break;         

                                    case "edit_user_plan_category":         include('include/edit_user_plan_category.php'); break;      

                                    case "adviser_banner_settings":         include('include/adviser_banner_settings.php'); break;

                                    case "add_adviser_banner_setting":      include('include/add_adviser_banner_setting.php'); break;

                                    case "edit_adviser_banner_setting":     include('include/edit_adviser_banner_setting.php'); break;

                                    case "email_autoresponders":            include('include/email_autoresponders.php'); break;

                                    case "add_email_autoresponder":         include('include/add_email_autoresponder.php'); break;

                                    case "edit_email_autoresponder":        include('include/edit_email_autoresponder.php'); break;

                                    case "common_messages_user":            include('include/common_messages_user.php'); break;
									
				    case "add_message":            include('include/add_messages_user.php'); break;

                                    case "edit_common_message_user":        include('include/edit_common_message_user.php'); break;

                                    case "common_messages_adviser":         include('include/common_messages_adviser.php'); break;

                                    case "edit_common_message_adviser":     include('include/edit_common_message_adviser.php'); break;

                                    case "send_bulk_email":                 include('include/send_bulk_email.php'); break;

                                    case "view_sent_bulk_emails":           include('include/view_sent_bulk_emails.php'); break;

                                    case "view_user_encashed_rewards":      include('include/view_user_encashed_rewards.php'); break;

                                    case "body_parts":                      include('include/body_parts.php'); break;         

                                    case "add_body_part":                   include('include/add_body_part.php'); break;         

                                    case "edit_body_part":                  include('include/edit_body_part.php'); break;      

                                    case "body_symptoms":                   include('include/body_symptoms.php'); break;         

                                    case "add_body_symptom":                include('include/add_body_symptom.php'); break;         

                                    case "edit_body_sypmtom":               include('include/edit_body_symptom.php'); break;      

                                    case "main_symptoms":                   include('include/main_symptoms.php'); break;         

                                    case "add_main_symptom":                include('include/add_main_symptom.php'); break;         

                                    case "edit_main_symptom":               include('include/edit_main_symptom.php'); break;    

                                    case "clients_master":                  include('include/clients_master.php'); break;         

                                    case "add_client":                      include('include/add_client.php'); break;         

                                    case "edit_client":                     include('include/edit_client.php'); break;   

                                    case "keywords_master":                 include('include/keywords_master.php'); break;         

                                    case "add_keyword":                     include('include/add_keyword.php'); break;         

                                    case "edit_keyword":                    include('include/edit_keyword.php'); break;   

                                    case "document_master":                 include('include/document_master.php'); break;         

                                    case "add_document_master":             include('include/add_document_master.php'); break;         

                                    case "edit_document_master":            include('include/edit_document_master.php'); break;   

                                    case "document_items":                  include('include/document_items.php'); break;         

                                    case "add_document_item":               include('include/add_document_item.php'); break;         

                                    case "edit_document_item":              include('include/edit_document_item.php'); break;   

                                    case "page_dropdowns":                  include('include/page_dropdowns.php'); break;         

                                    case "manage_page_cat_dropdowns":       include('include/manage_page_cat_dropdowns.php'); break;         

                                    case "add_page_cat_dropdown":       include('include/add_page_cat_dropdown.php'); break;         

                                    case "edit_page_cat_dropdown":       include('include/edit_page_cat_dropdown.php'); break;         

                                    case "add_page_dropdown":               include('include/add_page_dropdown.php'); break; 

                                    case "edit_page_dropdown":              include('include/edit_page_dropdown.php'); break;   

                                    case "wellness_solutions":              include('include/wellness_solutions.php'); break;         

                                    case "add_wellness_solution":           include('include/add_wellness_solution.php'); break;         

                                    case "edit_wellness_solution":          include('include/edit_wellness_solution.php'); break;   

                                    case "wellness_solution_items":         include('include/wellness_solution_items.php'); break;         

                                    case "add_wellness_solution_item":      include('include/add_wellness_solution_item.php'); break;         

                                    case "edit_wellness_solution_item":     include('include/edit_wellness_solution_item.php'); break;   

                                    case "update_banner_solution_items":     include('include/update_banner_solution_items.php'); break;  //add by ample 13-05-20

                                     //add by ample 31-07-20
                                    case "update_WSI_buttons":               
                                    include('include/update_WSI_buttons.php'); 
                                    break;

                                    case "wellness_solution_user_area":     include('include/wellness_solution_user_area.php'); break;   

                                    case "edit_wellness_solution_user_area":     include('include/edit_wellness_solution_user_area.php'); break;   

                                    case "wellness_solution_bg_music":      include('include/wellness_solution_bg_music.php'); break;   

                                    case "add_wellness_solution_bg_music":  include('include/add_wellness_solution_bg_music.php'); break;   

                                    case "edit_wellness_solution_bg_music": include('include/edit_wellness_solution_bg_music.php'); break;   

                                    case "profile_customization":           include('include/profile_customization.php'); break;   

                                    case "add_profile_customization":       include('include/add_profile_customization.php'); break;   

                                    case "edit_profile_customization":      include('include/edit_profile_customization.php'); break;   

                                    case "profile_customization_categories":           include('include/profile_customization_categories.php'); break;   

                                    case "add_profile_customization_category":       include('include/add_profile_customization_category.php'); break;   

                                    case "edit_profile_customization_category":      include('include/edit_profile_customization_category.php'); break;   

                                    case "contracts_trans_type":           include('include/contracts_trans_type.php'); break;   

                                    case "add_contracts_trans_type":       include('include/add_contracts_trans_type.php'); break;   

                                    case "edit_contracts_trans_type":      include('include/edit_contracts_trans_type.php'); break;   

                                    case "vender_contents":                include('include/vender_contents.php'); break;

                                    case "edit_vender_content":            include('include/edit_vender_content.php'); break;

                                    case "add_vender_content":             include('include/add_vender_content.php'); break;

                                    case "manage_vender_menus":            include('include/manage_vender_menus.php'); break;    

                                    case "banner_size_master":           include('include/banner_size_master.php'); break;   

                                    case "add_banner_size":       include('include/add_banner_size.php'); break;   

                                    case "edit_banner_size":      include('include/edit_banner_size.php'); break; 
                                    
                                    case "assign_interpretation":    include('include/assign_interpretation.php'); break;   

                                    case "add_interpretation":       include('include/add_interpretation.php'); break;   

                                    case "edit_interpretation":      include('include/edit_interpretation.php'); break; 

                                     case "manage_table_dropdown":               include('include/manage_table_dropdown.php'); break;          
                                     // case "manage_orders":      include('include/manage_orders.php');
                                     //  break;  
                                    case "add_table_dropdown":               include('include/add_table_dropdown.php'); break; 

                                    case "edit_table_dropdown":               include('include/edit_table_dropdown.php'); break; 

                                    case "report_customisation":               include('include/report_customisation.php'); break; 

                                    case "add_report_customisation":               include('include/add_report_customisation.php'); break; 

                                    case "edit_report_customisation":               include('include/edit_report_customisation.php'); break; 

                                    //add by ample 30-01-20
                                    case "update_banner_DYL":               
                                    include('include/update_banner_DYL.php'); 
                                    break;

                                    //add by ample 08-04-20
                                    case "update_banner_favcategory":               
                                    include('include/update_banner_favcategory.php'); 
                                    break;

                                    //add by ample 30-01-20
                                    case "update_specifiq_data_DYL":               
                                    include('include/update_specifiq_data_DYL.php'); 
                                    break;

                                    case "add_page_pop":               include('include/add_page_pop.php'); break; 
                                    case "edit_page_pop":               include('include/edit_page_pop.php'); break; 

                                    //add by ample 16-06-20
                                    case "manage-page-decor":               include('include/manage-page-decor.php'); break; 
                                    case "add-page-decor":               include('include/add-page-decor.php'); break; 
                                    case "edit-page-decor":               include('include/edit-page-decor.php'); break; 
                                    //add by ample 16-06-20
                                    case "update_page_decor_buttons":               
                                    include('include/update_page_decor_buttons.php'); 
                                    break;

                                    //add by ample 04-08-20
                                    case "common-button-setting":               include('include/common-button-setting.php'); break; 
                                    case "add-common-button-setting":               include('include/add-common-button-setting.php'); break; 
                                    case "edit-common-button-setting":               include('include/edit-common-button-setting.php'); break; 
                                    case "update_common_buttons":               
                                    include('include/update_common_buttons.php'); 
                                    break;

                                    //add by ample 10-07-20
                                    case "manage_sms_credentials":               include('include/manage_sms_credentials.php'); break; 
                                    case "add_sms_credential":               include('include/add_sms_credential.php'); break; 
                                    case "edit_sms_credential":               include('include/edit_sms_credential.php'); break; 

                                      case "page_pop":               include('include/page_pop.php'); break; 
                                      // case "table_page_pop":               include('include/table_page_pop.php'); break; 
                                      case "page_setting":               include('include/page_setting.php'); break;

                                      //add by ample 10-12-20
                                    case "banner_slider":                          include('include/banner_slider.php'); break;
                                    case "add_banner_slider":                      include('include/add_banner_slider.php'); break;
                                    case "edit_banner_slider":                     include('include/edit_banner_slider.php'); break;
                                    //add by ample 16-10-20
                                    case "add_band_setting":                      include('include/add_band_setting.php'); break;
                                    case "edit_band_setting":                     include('include/edit_band_setting.php'); break;
                                    //add by ample 20-10-20
                                    case "add_scheduled":                      include('include/add_scheduled.php'); break;
                                    case "edit_scheduled":                     include('include/edit_scheduled.php'); break;
                                    //add by ample 21-10-20
                                    case "update_scheduled":                     include('include/update_scheduled.php'); break;
                                    //add by ample 28-12-20
                                    case "reset_mood_set":                     include('include/reset_mood_set.php'); break;
                                    case "logs-history":                     include('include/logs-history.php'); break;
                                } ?>

                                </td>

                            <?php

                            if(isset($_GET['mode']) && isset($_SESSION['admin_id']) && $_SESSION['admin_id'] != '' )

                            { ?>

                                <td width="1%">&nbsp;&nbsp;&nbsp;</td>

                            <?php

                            } ?>

                                <td width="1%">&nbsp;&nbsp;&nbsp;</td>

                            </tr>

                        </tbody>

                        </table>

                    </td>

		</tr>

            </tbody>

            </table>

	</td>

    </tr>

    <tr>

        <td valign="bottom" style=""><?php include('include/footer.php'); ?><p></p></td>

    </tr>

</tbody>

</table>

</body>

</html>
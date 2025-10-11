<?php

require_once('config/class.mysql.php');

require_once('classes/class.contents.php');

require_once('classes/class.places.php');



$obj = new Contents();

$obj2 = new Places();



require_once('classes/class.scrollingwindows.php');

$obj1 = new Scrolling_Windows();


// wrong action id comment by ample 26-11-19
//$add_action_id = '314';

// update by ample 26-11-19
$add_action_id = '334';


if (!$obj->isAdminLoggedIn()) {
    
    header("Location: index.php?mode=login");
    
    exit(0);
    
}



if (!$obj->chkValidActionPermission($admin_id, $add_action_id)) {
    
    header("Location: index.php?mode=invalid");
    
    exit(0);
    
}

// add by ample 05-11-19
$tables=$obj->getTableNameFrom_tbltabldropdown('3');


//if($action == 'getsubcategoryoption')

//{

//    

//        

//    $profid = trim($_REQUEST['profid']);

//        $arr_selected_cat_id1 =array();

//    $data = $obj->getAllSubCategoryChkeckbox($arr_selected_cat_id1,$profid,'0','300','200');

//     print_r($data) ;

//

//}



$error = false;

$err_msg = "";

$arr_selected_cat_id1 = array();

$arr_selected_cat_id2 = array();

$arr_selected_cat_id3 = array();

$arr_selected_cat_id4 = array();

$arr_selected_cat_id5 = array();

$arr_selected_cat_id6 = array();

$arr_selected_cat_id7 = array();

$arr_selected_cat_id8 = array();

$arr_selected_cat_id9 = array();

$arr_selected_cat_id10 = array();







if (isset($_POST['btnSubmit'])) {
    
    
    
    
    
    //echo '<br><pre>';
    
    //print_r($_POST);
    
    //echo '</pre>';
    
    //die();
    
    $fav_cat_type_id_0 = $_POST['fav_cat_type_id_0'];
    
    
    
    if ($_POST['healcareandwellbeing'] == '') {
        
        $healcareandwellbeing = $obj->getAllHealcareAndWellbeingPageDropdownData($fav_cat_type_id_0);
        
        //        echo '<pre>';
        
        //        print_r($healcareandwellbeing);
        
        //        echo '</pre>'; 
        
    }
    
    else {
        
        $healcareandwellbeing = $_POST['healcareandwellbeing'];
        
    }
    
    
    
    //   echo '<pre>';
    
    //   print_r($healcareandwellbeing);
    
    //   echo '</pre>';
    
    //   die();
    
    $page_name = strip_tags(trim($_POST['page_name']));
    
    $page_type = strip_tags(trim($_POST['page_type']));
    
    $ref_code = strip_tags(trim($_POST['ref_code']));
    
    $prof_cat1 = $_POST['fav_cat_type_id'];
    
    $prof_cat2 = $_POST['fav_cat_type_id2'];
    
    $prof_cat3 = $_POST['fav_cat_type_id3'];
    
    $prof_cat4 = $_POST['fav_cat_type_id4'];
    
    $prof_cat5 = $_POST['fav_cat_type_id5'];
    
    $prof_cat6 = $_POST['fav_cat_type_id6'];
    
    $prof_cat7 = $_POST['fav_cat_type_id7'];
    
    $prof_cat8 = $_POST['fav_cat_type_id8'];
    
    $prof_cat9 = $_POST['fav_cat_type_id9'];
    
    $prof_cat10 = $_POST['fav_cat_type_id10'];
    
    if(isset($_POST['data_source']) && $_POST['data_source']!=''){
        $data_source = $_POST['data_source'];
    }else{
        $data_source = 0;
    }
    
    
    
    $arr_heading = array();
    
    $arr_heading['time_heading'] = $_POST['time_heading'];
    
    $arr_heading['duration_heading'] = $_POST['duration_heading'];
    
    $arr_heading['location_heading'] = $_POST['location_heading'];
    
    $arr_heading['like_dislike_heading'] = $_POST['like_dislike_heading'];
    
    $arr_heading['set_goals_heading'] = $_POST['set_goals_heading'];
    
    $arr_heading['scale_heading'] = $_POST['scale_heading'];
    
    $arr_heading['reminder_heading'] = $_POST['reminder_heading'];
    
    $arr_heading['comments_heading'] = $_POST['comments_heading'];
    
    
    
    $cat_fetch_show_data = array();
    
    
    
    if(isset($_POST['canv_sub_cat1_show_fetch']) && $_POST['canv_sub_cat1_show_fetch']!='')

    {

        $cat_fetch_show_data['canv_sub_cat1_show_fetch']= $_POST['canv_sub_cat1_show_fetch']; // Displaying Selected Value

    }else{
        $cat_fetch_show_data['canv_sub_cat1_show_fetch']= 0; 
    }

    

   if(isset($_POST['canv_sub_cat2_show_fetch']) && $_POST['canv_sub_cat2_show_fetch']!='')

    {

        $cat_fetch_show_data['canv_sub_cat2_show_fetch']= $_POST['canv_sub_cat2_show_fetch']; 

    }else{
        $cat_fetch_show_data['canv_sub_cat2_show_fetch']= 0; 
    }



    if(isset($_POST['canv_sub_cat3_show_fetch']) && $_POST['canv_sub_cat3_show_fetch']!='')

    {

        $cat_fetch_show_data['canv_sub_cat3_show_fetch']= $_POST['canv_sub_cat3_show_fetch']; 

    }else{
        $cat_fetch_show_data['canv_sub_cat3_show_fetch']= 0; 
    }

    

    if(isset($_POST['canv_sub_cat4_show_fetch']) && $_POST['canv_sub_cat4_show_fetch']!='')

    {

        $cat_fetch_show_data['canv_sub_cat4_show_fetch']= $_POST['canv_sub_cat4_show_fetch']; 

    }else{
        $cat_fetch_show_data['canv_sub_cat4_show_fetch']= 0; 
    }

    

    if(isset($_POST['canv_sub_cat5_show_fetch']) && $_POST['canv_sub_cat5_show_fetch']!='')

    {

        $cat_fetch_show_data['canv_sub_cat5_show_fetch']= $_POST['canv_sub_cat5_show_fetch']; 

    }else{
        $cat_fetch_show_data['canv_sub_cat5_show_fetch']= 0; 
    }

    

    if(isset($_POST['canv_sub_cat6_show_fetch']) && $_POST['canv_sub_cat6_show_fetch']!='')

    {

        $cat_fetch_show_data['canv_sub_cat6_show_fetch']= $_POST['canv_sub_cat6_show_fetch']; 

    }else{
        $cat_fetch_show_data['canv_sub_cat6_show_fetch']= 0; 
    }

    

    if(isset($_POST['canv_sub_cat7_show_fetch']) && $_POST['canv_sub_cat7_show_fetch']!='')

    {

        $cat_fetch_show_data['canv_sub_cat7_show_fetch']= $_POST['canv_sub_cat7_show_fetch']; 

    }else{
        $cat_fetch_show_data['canv_sub_cat7_show_fetch']= 0; 
    }

    

   if(isset($_POST['canv_sub_cat8_show_fetch'])&&$_POST['canv_sub_cat8_show_fetch']!='')

    {

        $cat_fetch_show_data['canv_sub_cat8_show_fetch']= $_POST['canv_sub_cat8_show_fetch']; 

    }else{
        $cat_fetch_show_data['canv_sub_cat8_show_fetch']= 0; 
    }

    

   if(isset($_POST['canv_sub_cat9_show_fetch']) && $_POST['canv_sub_cat9_show_fetch']!='')

    {

        $cat_fetch_show_data['canv_sub_cat9_show_fetch']= $_POST['canv_sub_cat9_show_fetch']; 

    }else{
        $cat_fetch_show_data['canv_sub_cat9_show_fetch']= 0; 
    }

    

    if(isset($_POST['canv_sub_cat10_show_fetch']) && $_POST['canv_sub_cat10_show_fetch']!='')

    {

        $cat_fetch_show_data['canv_sub_cat10_show_fetch']= $_POST['canv_sub_cat10_show_fetch']; 

    }else{
        $cat_fetch_show_data['canv_sub_cat10_show_fetch']= 0; 
    }

    if (isset($_POST['canv_loc_cat_show_fetch']) && $_POST['canv_loc_cat_show_fetch']!='') {
        
        $cat_fetch_show_data['canv_loc_cat_show_fetch'] = $_POST['canv_loc_cat_show_fetch'];
        
    }else{
        $cat_fetch_show_data['canv_loc_cat_show_fetch'] = 0;
    }
    
    if (isset($_POST['canv_user_cat_show_fetch']) && $_POST['canv_user_cat_show_fetch']!='') {
        
        $cat_fetch_show_data['canv_user_cat_show_fetch'] = $_POST['canv_user_cat_show_fetch'];
        
    }else{
        $cat_fetch_show_data['canv_user_cat_show_fetch'] = 0;
    }
    
    if (isset($_POST['canv_wn_cat_show_fetch']) && $_POST['canv_wn_cat_show_fetch']!='') {
        
        $cat_fetch_show_data['canv_wn_cat_show_fetch'] = $_POST['canv_wn_cat_show_fetch'];
        
    }else{
        $cat_fetch_show_data['canv_wn_cat_show_fetch'] = 0;
    }
    
    if (isset($_POST['canv_au_cat_show_fetch']) && $_POST['canv_au_cat_show_fetch']!='') {
        
        $cat_fetch_show_data['canv_au_cat_show_fetch'] = $_POST['canv_au_cat_show_fetch'];
        
    }else{
        $cat_fetch_show_data['canv_au_cat_show_fetch'] = 0;
    }
    
    $canv_sub_cat_link = array();
    
    
    
    $canv_sub_cat_link['canv_sub_cat1_link'] = $_POST['canv_sub_cat1_link'];
    
    $canv_sub_cat_link['canv_sub_cat2_link'] = $_POST['canv_sub_cat2_link'];
    
    $canv_sub_cat_link['canv_sub_cat3_link'] = $_POST['canv_sub_cat3_link'];
    
    $canv_sub_cat_link['canv_sub_cat4_link'] = $_POST['canv_sub_cat4_link'];
    
    $canv_sub_cat_link['canv_sub_cat5_link'] = $_POST['canv_sub_cat5_link'];
    
    $canv_sub_cat_link['canv_sub_cat6_link'] = $_POST['canv_sub_cat6_link'];
    
    $canv_sub_cat_link['canv_sub_cat7_link'] = $_POST['canv_sub_cat7_link'];
    
    $canv_sub_cat_link['canv_sub_cat8_link'] = $_POST['canv_sub_cat8_link'];
    
    $canv_sub_cat_link['canv_sub_cat9_link'] = $_POST['canv_sub_cat9_link'];
    
    $canv_sub_cat_link['canv_sub_cat10_link'] = $_POST['canv_sub_cat10_link'];
    
    $canv_sub_cat_link['canv_loc_cat_link'] = $_POST['canv_loc_cat_link'];
    
    $canv_sub_cat_link['canv_user_cat_link'] = $_POST['canv_user_cat_link'];
    
    $canv_sub_cat_link['canv_wn_cat_link'] = $_POST['canv_wn_cat_link'];
    
    $canv_sub_cat_link['canv_au_cat_link'] = $_POST['canv_au_cat_link'];


    /* code added by ample 04-11-19 */
    $prof_cat_heading=array();
    $prof_cat_heading['prof_cat1_heading'] = $_POST['prof_cat1_heading'];
    $prof_cat_heading['prof_cat2_heading'] = $_POST['prof_cat2_heading'];
    $prof_cat_heading['prof_cat3_heading'] = $_POST['prof_cat3_heading'];
    $prof_cat_heading['prof_cat4_heading'] = $_POST['prof_cat4_heading'];
    $prof_cat_heading['prof_cat5_heading'] = $_POST['prof_cat5_heading'];
    $prof_cat_heading['prof_cat6_heading'] = $_POST['prof_cat6_heading'];
    $prof_cat_heading['prof_cat7_heading'] = $_POST['prof_cat7_heading'];
    $prof_cat_heading['prof_cat8_heading'] = $_POST['prof_cat8_heading'];
    $prof_cat_heading['prof_cat9_heading'] = $_POST['prof_cat9_heading'];
    $prof_cat_heading['prof_cat10_heading'] = $_POST['prof_cat10_heading'];
    $prof_cat_ref_code=array();
    $prof_cat_ref_code['prof_cat1_ref_code'] = $_POST['prof_cat1_ref_code'];
    $prof_cat_ref_code['prof_cat2_ref_code'] = $_POST['prof_cat2_ref_code'];
    $prof_cat_ref_code['prof_cat3_ref_code'] = $_POST['prof_cat3_ref_code'];
    $prof_cat_ref_code['prof_cat4_ref_code'] = $_POST['prof_cat4_ref_code'];
    $prof_cat_ref_code['prof_cat5_ref_code'] = $_POST['prof_cat5_ref_code'];
    $prof_cat_ref_code['prof_cat6_ref_code'] = $_POST['prof_cat6_ref_code'];
    $prof_cat_ref_code['prof_cat7_ref_code'] = $_POST['prof_cat7_ref_code'];
    $prof_cat_ref_code['prof_cat8_ref_code'] = $_POST['prof_cat8_ref_code'];
    $prof_cat_ref_code['prof_cat9_ref_code'] = $_POST['prof_cat9_ref_code'];
    $prof_cat_ref_code['prof_cat10_ref_code'] = $_POST['prof_cat10_ref_code'];
     /* code added by ample 04-11-19 */


    
    $location_ref_code = $_POST['location_ref_code'];
    $ur_ref_code = $_POST['ur_ref_code'];
    $uw_ref_code = $_POST['uw_ref_code'];
    $au_ref_code = $_POST['au_ref_code'];
    
    $time_show = $_POST['time_show'];
    
    $duration_show = $_POST['duration_show'];
    
    $location_show = $_POST['location_show'];
    
    $like_dislike_show = $_POST['like_dislike_show'];
    
    $set_goals_show = $_POST['set_goals_show'];
    
    $scale_show = $_POST['scale_show'];
    
    $reminder_show = $_POST['reminder_show'];
    
    $comments_show = $_POST['comments_show'];
    
    $heading = strip_tags(trim($_POST['heading']));
    
    $order_show = strip_tags(trim($_POST['order_show']));
    
    $admin_comment = $_POST['admin_comment'];
    
    $page_show=$_POST['page_show']; // add by ample 07-04-20

    //code added by ample 12-12-19 & update 16-12-19
        $level=array();
        $level['level']=$_POST['level'];
        $level['level_heading']=$_POST['level_heading'];
        $level['level_title']=$_POST['level_title'];
        $level['level_title_heading']=$_POST['level_title_heading'];
        $level['level_icon']=$_POST['level_icon'];
        $level['level_icon_type']=$_POST['level_icon_type'];
        $level['level_icon_heading']=$_POST['level_icon_heading'];
    
    $location_category = isset($_POST['location_category']) && is_array($_POST['location_category']) 
        ? implode(',', $_POST['location_category']) 
        : '';

    $user_response_category = isset($_POST['user_response_category']) && is_array($_POST['user_response_category']) 
        ? implode(',', $_POST['user_response_category']) 
        : '';

    $user_what_next_category = isset($_POST['user_what_next_category']) && is_array($_POST['user_what_next_category']) 
        ? implode(',', $_POST['user_what_next_category']) 
        : '';

    $alerts_updates_category = isset($_POST['alerts_updates_category']) && is_array($_POST['alerts_updates_category']) 
        ? implode(',', $_POST['alerts_updates_category']) 
        : '';
    
    //add by ample 19-05-20
    $special_key=array(
                    'special_key1'=>$_POST['special_key1'],
                    'special_key2'=>$_POST['special_key2'],
                    'special_key3'=>$_POST['special_key3'],
                    'special_ref_code1'=>$_POST['special_ref_code1'],
                    'special_ref_code2'=>$_POST['special_ref_code2'],
                    'special_ref_code3'=>$_POST['special_ref_code3'],
                );
   
    
    
    
    foreach ($_POST['selected_cat_id1'] as $key => $value) {
        
        array_push($arr_selected_cat_id1, $value);
        
    }
    
    
    
    foreach ($_POST['selected_cat_id2'] as $key => $value) {
        
        array_push($arr_selected_cat_id2, $value);
        
    }
    
    
    
    foreach ($_POST['selected_cat_id3'] as $key => $value) {
        
        array_push($arr_selected_cat_id3, $value);
        
    }
    
    
    
    foreach ($_POST['selected_cat_id4'] as $key => $value) {
        
        array_push($arr_selected_cat_id4, $value);
        
    }
    
    
    
    foreach ($_POST['selected_cat_id5'] as $key => $value) {
        
        array_push($arr_selected_cat_id5, $value);
        
    }
    
    foreach ($_POST['selected_cat_id6'] as $key => $value) {
        
        array_push($arr_selected_cat_id6, $value);
        
    }
    
    foreach ($_POST['selected_cat_id7'] as $key => $value) {
        
        array_push($arr_selected_cat_id7, $value);
        
    }
    
    foreach ($_POST['selected_cat_id8'] as $key => $value) {
        
        array_push($arr_selected_cat_id8, $value);
        
    }
    
    foreach ($_POST['selected_cat_id9'] as $key => $value) {
        
        array_push($arr_selected_cat_id9, $value);
        
    }
    
    foreach ($_POST['selected_cat_id10'] as $key => $value) {
        
        array_push($arr_selected_cat_id10, $value);
        
    }
    
    
    
    
    if ($page_name == '') {
        
        $error = true;
        
        $err_msg = 'Please select Page';
        
    }
    
    //    elseif($obj->chkPageDropdownModuleExists($page_name))
    
    //    {
    
    //        $error = true;
    
    //        $err_msg .= '<br>This function already added';
    
    //    }
    
    
    
    
    
    if (count($arr_selected_cat_id1) == 0) {
        
        
        
        $error = true;
        
        $err_msg .= '<br>Please select Profile Category1';
        
    }
    
    
    
    
    
    if (!$error) {
        
        $sub_cat1 = implode(',', $arr_selected_cat_id1);
        
        $sub_cat2 = implode(',', $arr_selected_cat_id2);
        
        $sub_cat3 = implode(',', $arr_selected_cat_id3);
        
        $sub_cat4 = implode(',', $arr_selected_cat_id4);
        
        $sub_cat5 = implode(',', $arr_selected_cat_id5);
        
        $sub_cat6 = implode(',', $arr_selected_cat_id6);
        
        $sub_cat7 = implode(',', $arr_selected_cat_id7);
        
        $sub_cat8 = implode(',', $arr_selected_cat_id8);
        
        $sub_cat9 = implode(',', $arr_selected_cat_id9);
        
        $sub_cat10 = implode(',', $arr_selected_cat_id10);
        
         /* update by ample 04-11-19  & 12-12-19 & 19-05-20*/
        
        if ($obj->addDataDropdown($admin_comment, $arr_heading, $fav_cat_type_id_0, $healcareandwellbeing, $ref_code, $page_name, $sub_cat1, $sub_cat2, $sub_cat3, $sub_cat4, $sub_cat5, $sub_cat6, $sub_cat7, $sub_cat8, $sub_cat9, $sub_cat10, $prof_cat1, $prof_cat2, $prof_cat3, $prof_cat4, $prof_cat5, $prof_cat6, $prof_cat7, $prof_cat8, $prof_cat9, $prof_cat10, $admin_id, $time_show, $duration_show, $location_show, $like_dislike_show, $set_goals_show, $scale_show, $reminder_show, $heading, $order_show, $comments_show, $location_category, $user_response_category, $user_what_next_category, $alerts_updates_category, $cat_fetch_show_data, $canv_sub_cat_link, $data_source, $page_type, $location_ref_code, $ur_ref_code, $uw_ref_code, $au_ref_code,$prof_cat_heading,$prof_cat_ref_code,$level,$page_show,$special_key)) {
            
            $msg = "Record Added Successfully!";
            
            header('location: index.php?mode=manage-data-dropdown&msg=' . urlencode($msg));
            
        }
        
        else {
            
            $error = true;
            
            $err_msg = "Currently there is some problem.Please try again later.";
            
        }
        
    }
    
}

else {
    
    $pdm_id = '';
    
    
    
}

?>

<div id="central_part_contents">

    <div id="notification_contents">

    <?php

if ($error) {
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

                            <td class="notification-body-e"><?php
    echo $err_msg;
?></td>

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

    <table border="0" width="97%" align="center" cellpadding="0" cellspacing="0">

    <tbody>

        <tr>

            <td>

                <table border="0" width="100%" cellpadding="0" cellspacing="0">

                <tbody>

                    <tr>

                        <td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>

                        <td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Data Dropdowns</td>

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

                            <form action="#" method="post" name="frmadd_my_relation" id="frmadd_my_relation" enctype="multipart/form-data" >

                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">

                                <tbody>

                                    <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                     <tr>

                                        <td width="30%" align="right" valign="top"><strong>Reference Code</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <input type="text" name="ref_code" id="ref_code" style="width:200px;height: 24px;" required>

                                           

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                    <tr>

                    <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                        <tr>

                                            <td width="30%" align="right" valign="top"><strong>Admin Notes</strong></td>

                                            <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                            <td width="65%" align="left" valign="top">

                                                <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"></textarea>



                                            </td>

                                        </tr>



                                        <tr>

                                                <td colspan="3" align="center">&nbsp;</td>

                                        </tr>

                                        <tr>                                                                    

                                        <td align="right" valign="top"><strong>Level</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="level" style="min-width: 100px;">

                                                <?php for($i=1;$i<=200;$i++) { ?>

                                                <option value="<?php echo $i ?>" <?php if($design_data['level'] == $i ){ ?> selected <?php } ?>><?php echo $i ?></option>

                                                <?php } ?>

                                            </select>

                                             &nbsp;&nbsp;&nbsp;Heading <input type="text" name="level_heading" id="level_heading" value="<?php echo $design_data['level_heading'];?>" >

                                        </td>

                                    </tr>

                                <tr>

                                    <td colspan="3" align="center">&nbsp;</td>

                                </tr>

                                 <tr>                                                                    

                                        <td align="right" valign="top"><strong>Level Title</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <input type="text" name="level_title" id="level_title" value="" style="width:200px;height: 24px;">

                                             &nbsp;&nbsp;&nbsp;Heading <input type="text" name="level_title_heading" id="level_title_heading" value="<?php echo $design_data['level_title_heading'];?>" >

                                        </td>

                                    </tr>

                                 <tr>

                                    <td colspan="3" align="center">&nbsp;</td>

                                </tr>

                                <tr>                                                                    

                                        <td align="right" valign="top"><strong>Level Icons</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <!-- add by ample 16-12-19 -->
                                            <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('IMG',0,'level_icon');">Gallery 1</button>
                                            <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('OT',0,'level_icon');">Gallery 2</button>
                                            <input type="hidden" name="level_icon" id="level_icon" readonly />
                                            <input type="text" name="level_icon_type" id="level_icon_type" readonly/>
                                            <input type="text"  id="level_icon_name" disabled/>
                                            <input type="text"  id="level_icon_file" disabled />
                                            <button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData('level_icon');">Reset</button>

                                            <br> <br>

                                             &nbsp;&nbsp;&nbsp;Heading <input type="text" name="level_icon_heading" id="level_icon_heading" value="<?php echo $design_data['level_icon_heading'];?>" >

                                        </td>

                                    </tr>

                                <tr>

                                    <td colspan="3" align="center">&nbsp;</td>

                                </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>System Category</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id_0" id="fav_cat_type_id_0" required="" style="width:200px; height: 24px;" onchange="getMainCategoryOption('0','healcareandwellbeing')">                                                

                                               <?php
echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);
?>

                                            </select>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>System Sub Category</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top" id="fav_cat_id_0">

<!--                                            <select name="healcareandwellbeing[]" id="healcareandwellbeing" style="width:200px; height: 90px;" multiple>

                                               

                                                 <?php //echo $obj1->getFavCategoryRamakant('42',$fav_cat_id)
?>

                                            </select>-->

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Page Type</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="page_type" id="page_type" style="width:200px; height: 24px;" required="" onchange="getDatadropdownPage('4')">

                                                <option value="">Select Page Type</option>

                                                <option value="Menu">Menu</option>

                                                <option value="Page">Page</option>

                                            </select>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Page Name</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="page_name" id="page_name" style="width:200px; height: 24px;">

                                                <option value="">Select Page Name</option>

                                                <?php
echo $obj->getDatadropdownPage('4', '', '');
?>

                                            </select>

                                            &nbsp;&nbsp;&nbsp;Header <input type="text" name="heading" id="heading" >

                                        </td>

                                    </tr>

                                    

                                    

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Data Source</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="data_source" id="data_source" style="width:200px; height: 24px;" >

                                                <option value="0">Select Data Source</option>

                                               <?php
echo $obj->getDatadropdownPage('6', '', '');
?>

                                            </select>

                                        </td>

                                    </tr>

                                    

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Profile Category1</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id" id="fav_cat_type_id" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore()">

                                                <option value="">Select Prof Cat</option>

                                               <?php
echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);
?>

                                            </select>

                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat1_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat1_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 
                                            <!-- make daynamic by ample-->
                                            <select name="canv_sub_cat1_link" id="canv_sub_cat1_link"  onchange="get_column_names(this,'prof_cat1_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                            <!-- <select name="canv_sub_cat1_link" id="canv_sub_cat1_link">

                                                <option value="">Select</option>

                                                <option value="tbl_bodymainsymptoms" <?php
if ($canv_sub_cat10_link == 'tbl_bodymainsymptoms') {
    echo 'selected';
}
?>>tbl_bodymainsymptoms</option>

                                                <option value="tblsolutionitems" <?php
if ($canv_sub_cat10_link == 'tblsolutionitems') {
    echo 'selected';
}
?>>tblsolutionitems</option>

                                                <option value="tbldailymealsfavcategory" <?php
if ($canv_sub_cat10_link == 'tbldailymealsfavcategory') {
    echo 'selected';
}
?>>tbldailymealsfavcategory</option>

                                                <option value="tbldailyactivity" <?php
if ($canv_sub_cat10_link == 'tbldailyactivity') {
    echo 'selected';
}
?>>tbldailyactivity</option>
                                                <option value="tbl_event_master">tbl_event_master</option>
                                            </select> -->

                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="30%" align="right" valign="top"></td>
                                        <td width="5%" align="center" valign="top"></td>
                                        <td width="65%" align="left" valign="top">
                                        <div class="row" style="margin-top: 2.5px;">
                                            <div class="col-lg-4">
                                                 Heading <input type="text" name="prof_cat1_heading" id="prof_cat1_heading" style="width: 157px;">
                                                 <br> 
                                                 <label class="checkbox-inline"><input type="checkbox" name="special_key1" value="1">Special Key</label>
                                            </div>
                                            <div class="col-lg-8">
                                                  Reference Code 
                                                <select name="prof_cat1_ref_code" id="prof_cat1_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                </select>
                                                <br>
                                                Special Reference Code 
                                                <select name="special_ref_code1" class="prof_cat1_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr >                                                                    

                                        <td align="right" valign="top"><strong>Sub Category1</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td id="fav_cat_id" align="left" valign="top">

                                            

                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');
?>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Profile Category2</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id2" id="fav_cat_type_id2" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore2()">

                                                <option value="">Select Prof Cat</option>

                                               <?php
echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);
?>

                                            </select>

                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat2_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat2_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 

                                            <select name="canv_sub_cat2_link" id="canv_sub_cat2_link"  onchange="get_column_names(this,'prof_cat2_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="30%" align="right" valign="top"></td>
                                        <td width="5%" align="center" valign="top"></td>
                                        <td width="65%" align="left" valign="top">
                                        <div class="row" style="margin-top: 2.5px;">
                                            <div class="col-lg-4">
                                                 Heading <input type="text" name="prof_cat2_heading" id="prof_cat2_heading" style="width: 157px;">
                                                 <br> 
                                                 <label class="checkbox-inline"><input type="checkbox" name="special_key2" value="1">Special Key</label>
                                            </div>
                                            <div class="col-lg-8">
                                                  Reference Code 
                                                <select name="prof_cat2_ref_code" id="prof_cat2_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                </select>
                                                <br>
                                                Special Reference Code 
                                                <select name="special_ref_code2" class="prof_cat2_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr >                                                                    

                                        <td align="right" valign="top"><strong>Sub Category2</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td id="fav_cat_id2" align="left" valign="top">

                                            

                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');
?>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Profile Category3</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id3" id="fav_cat_type_id3" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore3()">

                                                <option value="">Select Prof Cat</option>

                                               <?php
echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);
?>

                                            </select>

                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat3_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat3_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 
                                            <select name="canv_sub_cat3_link" id="canv_sub_cat3_link"  onchange="get_column_names(this,'prof_cat3_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="30%" align="right" valign="top"></td>
                                        <td width="5%" align="center" valign="top"></td>
                                        <td width="65%" align="left" valign="top">
                                        <div class="row" style="margin-top: 2.5px;">
                                            <div class="col-lg-4">
                                                 Heading <input type="text" name="prof_cat3_heading" id="prof_cat3_heading" style="width: 157px;">
                                                 <br> 
                                                 <label class="checkbox-inline"><input type="checkbox" name="special_key3" value="1">Special Key</label>
                                            </div>
                                            <div class="col-lg-8">
                                                  Reference Code 
                                                <select name="prof_cat3_ref_code" id="prof_cat3_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                </select>
                                                <br>
                                                Special Reference Code 
                                                <select name="special_ref_code3" class="prof_cat3_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr >                                                                    

                                        <td align="right" valign="top"><strong>Sub Category3</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td id="fav_cat_id3" align="left" valign="top">

                                            

                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');
?>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Profile Category4</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id4" id="fav_cat_type_id4" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore4()">

                                                <option value="">Select Prof Cat</option>

                                               <?php
echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);
?>

                                            </select>

                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat4_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat4_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link

                                           <select name="canv_sub_cat4_link" id="canv_sub_cat4_link"  onchange="get_column_names(this,'prof_cat4_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="30%" align="right" valign="top"></td>
                                        <td width="5%" align="center" valign="top"></td>
                                        <td width="65%" align="left" valign="top">
                                        <div class="row" style="margin-top: 2.5px;">
                                            <div class="col-lg-4">
                                                 Heading <input type="text" name="prof_cat4_heading" id="prof_cat4_heading" style="width: 157px;">
                                                 
                                            </div>
                                            <div class="col-lg-8">
                                                  Reference Code 
                                                <select name="prof_cat4_ref_code" id="prof_cat4_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr >                                                                    

                                        <td align="right" valign="top"><strong>Sub Category4</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td id="fav_cat_id4" align="left" valign="top">

                                            

                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');
?>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Profile Category5</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id5" id="fav_cat_type_id5" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore5()">

                                                <option value="">Select Prof Cat</option>

                                               <?php
echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);
?>

                                            </select>

                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat5_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat5_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 

                                            <select name="canv_sub_cat5_link" id="canv_sub_cat5_link"  onchange="get_column_names(this,'prof_cat5_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="30%" align="right" valign="top"></td>
                                        <td width="5%" align="center" valign="top"></td>
                                        <td width="65%" align="left" valign="top">
                                        <div class="row" style="margin-top: 2.5px;">
                                            <div class="col-lg-4">
                                                 Heading <input type="text" name="prof_cat5_heading" id="prof_cat5_heading" style="width: 157px;">
                                            </div>
                                            <div class="col-lg-8">
                                                  Reference Code 
                                                <select name="prof_cat5_ref_code" id="prof_cat5_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                <option value="ABC">ABC</option>
                                                <option value="XYZ">XYZ</option>
                                                </select>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr >                                                                    

                                        <td align="right" valign="top"><strong>Sub Category5</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td id="fav_cat_id5" align="left" valign="top">

                                            

                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');
?>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Profile Category6</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id6" id="fav_cat_type_id6" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore6()">

                                                <option value="">Select Prof Cat</option>

                                               <?php
echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);
?>

                                            </select>

                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat6_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat6_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 
                                            <!--  make dynamlic by ample 05-11-19-->
                                            <select name="canv_sub_cat6_link" id="canv_sub_cat6_link"  onchange="get_column_names(this,'prof_cat6_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="30%" align="right" valign="top"></td>
                                        <td width="5%" align="center" valign="top"></td>
                                        <td width="65%" align="left" valign="top">
                                        <div class="row" style="margin-top: 2.5px;">
                                            <div class="col-lg-4">
                                                 Heading <input type="text" name="prof_cat6_heading" id="prof_cat6_heading" style="width: 157px;">
                                            </div>
                                            <div class="col-lg-8">
                                                  Reference Code 
                                                <select name="prof_cat6_ref_code" id="prof_cat6_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                <option value="ABC">ABC</option>
                                                <option value="XYZ">XYZ</option>
                                                </select>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr >                                                                    

                                        <td align="right" valign="top"><strong>Sub Category6</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td id="fav_cat_id6" align="left" valign="top">

                                            

                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');
?>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Profile Category7</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id7" id="fav_cat_type_id7" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore7()">

                                                <option value="">Select Prof Cat</option>

                                               <?php
echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);
?>

                                            </select>

                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat7_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat7_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 

                                            <!--  make dynamlic by ample 05-11-19-->
                                            <select name="canv_sub_cat7_link" id="canv_sub_cat7_link"  onchange="get_column_names(this,'prof_cat7_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="30%" align="right" valign="top"></td>
                                        <td width="5%" align="center" valign="top"></td>
                                        <td width="65%" align="left" valign="top">
                                        <div class="row" style="margin-top: 2.5px;">
                                            <div class="col-lg-4">
                                                 Heading <input type="text" name="prof_cat7_heading" id="prof_cat7_heading" style="width: 157px;">
                                            </div>
                                            <div class="col-lg-8">
                                                  Reference Code 
                                                <select name="prof_cat7_ref_code" id="prof_cat7_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                <option value="ABC">ABC</option>
                                                <option value="XYZ">XYZ</option>
                                                </select>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr >                                                                    

                                        <td align="right" valign="top"><strong>Sub Category7</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td id="fav_cat_id7" align="left" valign="top">

                                            

                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');
?>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Profile Category8</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id8" id="fav_cat_type_id8" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore8()">

                                                <option value="">Select Prof Cat</option>

                                               <?php
echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);
?>

                                            </select>

                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat8_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat8_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 

                                            <!--  make dynamlic by ample 05-11-19-->
                                            <select name="canv_sub_cat8_link" id="canv_sub_cat8_link"  onchange="get_column_names(this,'prof_cat8_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="30%" align="right" valign="top"></td>
                                        <td width="5%" align="center" valign="top"></td>
                                        <td width="65%" align="left" valign="top">
                                        <div class="row" style="margin-top: 2.5px;">
                                            <div class="col-lg-4">
                                                 Heading <input type="text" name="prof_cat8_heading" id="prof_cat8_heading" style="width: 157px;">
                                            </div>
                                            <div class="col-lg-8">
                                                  Reference Code 
                                                <select name="prof_cat8_ref_code" id="prof_cat8_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                <option value="ABC">ABC</option>
                                                <option value="XYZ">XYZ</option>
                                                </select>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr >                                                                    

                                        <td align="right" valign="top"><strong>Sub Category8</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td id="fav_cat_id8" align="left" valign="top">

                                            

                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');
?>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Profile Category9</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id9" id="fav_cat_type_id9" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore9()">

                                                <option value="">Select Prof Cat</option>

                                               <?php
echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);
?>

                                            </select>

                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat9_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat9_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 

                                            <!--  make dynamlic by ample 05-11-19-->
                                            <select name="canv_sub_cat9_link" id="canv_sub_cat9_link"  onchange="get_column_names(this,'prof_cat9_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="30%" align="right" valign="top"></td>
                                        <td width="5%" align="center" valign="top"></td>
                                        <td width="65%" align="left" valign="top">
                                        <div class="row" style="margin-top: 2.5px;">
                                            <div class="col-lg-4">
                                                 Heading <input type="text" name="prof_cat9_heading" id="prof_cat9_heading" style="width: 157px;">
                                            </div>
                                            <div class="col-lg-8">
                                                  Reference Code 
                                                <select name="prof_cat9_ref_code" id="prof_cat9_ref_code" style="width: 169px;">
                                                <option value="">Select</option>

                                                </select>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr >                                                                    

                                        <td align="right" valign="top"><strong>Sub Category9</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td id="fav_cat_id9" align="left" valign="top">

                                            

                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');
?>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Profile Category10</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id10" id="fav_cat_type_id10" style="width:200px; height: 24px;" onchange="getMainCategoryOptionAddMore10()">

                                                <option value="">Select Prof Cat</option>

                                               <?php
echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id);
?>

                                            </select>

                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat10_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_sub_cat10_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 

                                            <!--  make dynamlic by ample 05-11-19-->
                                            <select name="canv_sub_cat6_link" id="canv_sub_cat6_link"  onchange="get_column_names(this,'prof_cat10_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                            <!-- <select name="canv_sub_cat10_link" id="canv_sub_cat10_link">

                                                <option value="">Select</option>

                                                <option value="tbl_bodymainsymptoms" <?php
if ($canv_sub_cat10_link == 'tbl_bodymainsymptoms') {
    echo 'selected';
}
?>>tbl_bodymainsymptoms</option>

                                                <option value="tblsolutionitems" <?php
if ($canv_sub_cat10_link == 'tblsolutionitems') {
    echo 'selected';
}
?>>tblsolutionitems</option>

                                                <option value="tbldailymealsfavcategory" <?php
if ($canv_sub_cat10_link == 'tbldailymealsfavcategory') {
    echo 'selected';
}
?>>tbldailymealsfavcategory</option>

                                                <option value="tbldailyactivity" <?php
if ($canv_sub_cat10_link == 'tbldailyactivity') {
    echo 'selected';
}
?>>tbldailyactivity</option>
                                                <option value="tbl_event_master">tbl_event_master</option>
                                            </select> -->

                                        </td>

                                    </tr>

                                    <tr>
                                        <td width="30%" align="right" valign="top"></td>
                                        <td width="5%" align="center" valign="top"></td>
                                        <td width="65%" align="left" valign="top">
                                        <div class="row" style="margin-top: 2.5px;">
                                            <div class="col-lg-4">
                                                 Heading <input type="text" name="prof_cat10_heading" id="prof_cat10_heading" style="width: 157px;">
                                            </div>
                                            <div class="col-lg-8">
                                                  Reference Code 
                                                <select name="prof_cat10_refer_code" id="prof_cat10_ref_code" style="width: 169px;">
                                                <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>Sub Category10</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td id="fav_cat_id10" align="left" valign="top">

                                            

                                            <?php // echo $obj->getAllCategory2Chkeckbox($arr_selected_cat_id2,'0','300','200');
?>

                                        </td>

                                    </tr>

                                    

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                     <tr>                                                                    

                                        <td align="right" valign="top"><strong>Time (Show)</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="time_show" style="width:200px; height: 24px;">

                                                <option value="">Select</option>

                                                <option value="1">Individual</option>

                                                <option value="0">No</option>

                                                <option value="2">Common</option>

                                                <option value="3">Both</option>

                                            </select>

                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="time_heading" id="time_heading" >

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>Duration (Show)</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="duration_show" style="width:200px; height: 24px;">

                                                <option value="">Select</option>

                                               <option value="1">Individual</option>

                                                <option value="0">No</option>

                                                <option value="2">Common</option>

                                                <option value="3">Both</option>

                                            </select>

                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="duration_heading" id="duration_heading" >

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>Location (Show)</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="location_show" style="width:200px; height: 24px;">

                                                <option value="">Select</option>

                                               <option value="1">Individual</option>

                                                <option value="0">No</option>

                                                <option value="2">Common</option>

                                                <option value="3">Both</option>

                                            </select>

                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="location_heading" id="location_heading" >

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>Location Category </strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                                <?php
echo $obj->getAllFavCatChkeckbox('location_category', $arr_selected_cat_id, '200', '150');
?>                                           
                                            
                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_loc_cat_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_loc_cat_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 

                                            <!-- make daynamic by ample-->
                                            <select name="canv_loc_cat_link" id="canv_loc_cat_link"  onchange="get_column_names(this,'location_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                            <!-- <select name="canv_loc_cat_link" id="canv_loc_cat_link">

                                                <option value="">Select</option>

                                                <option value="tbl_bodymainsymptoms" <?php
if ($canv_loc_cat_link == 'tbl_bodymainsymptoms') {
    echo 'selected';
}
?>>tbl_bodymainsymptoms</option>

                                                <option value="tblsolutionitems" <?php
if ($canv_loc_cat_link == 'tblsolutionitems') {
    echo 'selected';
}
?>>tblsolutionitems</option>

                                                <option value="tbldailymealsfavcategory" <?php
if ($canv_loc_cat_link == 'tbldailymealsfavcategory') {
    echo 'selected';
}
?>>tbldailymealsfavcategory</option>

                                                <option value="tbldailyactivity" <?php
if ($canv_loc_cat_link == 'tbldailyactivity') {
    echo 'selected';
}
?>>tbldailyactivity</option>
                                                <option value="tbl_event_master">tbl_event_master</option>
                                            </select> -->
                                            &nbsp;&nbsp;

                                            <!-- Update Reference Code by ample 05-11-19 -->
                
                                              <!--  <input type="text" name="location_ref_code" id="location_ref_code" placeholder="Reference Code" style="width:200px;height: 24px;" value=""> -->
                                            <div style="margin-top: 2.5px;">
                                                Reference Code 
                                                <select name="location_ref_code" id="location_ref_code" style="width: 205px;">
                                                <option value="">Select</option>
                                                </select>
                                            </div>
   
                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>User Response (Show)</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="like_dislike_show" style="width:200px; height: 24px;">

                                                <option value="">Select</option>

                                               <option value="1">Individual</option>

                                                <option value="0">No</option>

                                                <option value="2">Common</option>

                                                <option value="3">Both</option>

                                            </select>

                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="like_dislike_heading" id="like_dislike_heading" >

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>User Response Category </strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                                <?php
echo $obj->getAllFavCatChkeckbox('user_response_category', $arr_selected_cat_id, '200', '150');
?>                                           
                                            
                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_user_cat_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_user_cat_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 
                                             <!-- make daynamic by ample-->
                                            <select name="canv_user_cat_link" id="canv_user_cat_link"  onchange="get_column_names(this,'ur_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                            <!-- <select name="canv_user_cat_link" id="canv_user_cat_link">

                                                <option value="">Select</option>

                                                <option value="tbl_bodymainsymptoms" <?php
if ($canv_user_cat_link == 'tbl_bodymainsymptoms') {
    echo 'selected';
}
?>>tbl_bodymainsymptoms</option>

                                                <option value="tblsolutionitems" <?php
if ($canv_user_cat_link == 'tblsolutionitems') {
    echo 'selected';
}
?>>tblsolutionitems</option>

                                                <option value="tbldailymealsfavcategory" <?php
if ($canv_user_cat_link == 'tbldailymealsfavcategory') {
    echo 'selected';
}
?>>tbldailymealsfavcategory</option>

                                                <option value="tbldailyactivity" <?php
if ($canv_user_cat_link == 'tbldailyactivity') {
    echo 'selected';
}
?>>tbldailyactivity</option>
                                                <option value="tbl_event_master">tbl_event_master</option>
                                            </select> -->
                                            
                                            &nbsp;&nbsp;
                                           <!--  <input type="text" name="ur_ref_code" id="ur_ref_code" placeholder="Reference Code" style="width:200px;height: 24px;" value="">    --> 
                                           <!-- Reference Code update by maple 05-11-19 -->
                                            <div style="margin-top: 2.5px;">
                                                Reference Code 
                                                <select name="ur_ref_code" id="ur_ref_code" style="width: 205px;">
                                                <option value="">Select</option>
                                                </select>
                                            </div>
                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>User What Next (Show)</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="set_goals_show" style="width:200px; height: 24px;">

                                                <option value="">Select</option>

                                               <option value="1">Individual</option>

                                                <option value="0">No</option>

                                                <option value="2">Common</option>

                                                <option value="3">Both</option>

                                            </select>

                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="set_goals_heading" id="set_goals_heading" >

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>User What Next Category </strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                                <?php
echo $obj->getAllFavCatChkeckbox('user_what_next_category', $arr_selected_cat_id, '200', '150');
?>                                           


                                            
                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_wn_cat_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_wn_cat_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 

                                             <!-- make daynamic by ample-->
                                            <select name="canv_wn_cat_link" id="canv_wn_cat_link"  onchange="get_column_names(this,'uw_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                            <!-- <select name="canv_wn_cat_link" id="canv_wn_cat_link">

                                                <option value="">Select</option>

                                                <option value="tbl_bodymainsymptoms" <?php
if ($canv_wn_cat_link == 'tbl_bodymainsymptoms') {
    echo 'selected';
}
?>>tbl_bodymainsymptoms</option>

                                                <option value="tblsolutionitems" <?php
if ($canv_wn_cat_link == 'tblsolutionitems') {
    echo 'selected';
}
?>>tblsolutionitems</option>

                                                <option value="tbldailymealsfavcategory" <?php
if ($canv_wn_cat_link == 'tbldailymealsfavcategory') {
    echo 'selected';
}
?>>tbldailymealsfavcategory</option>

                                                <option value="tbldailyactivity" <?php
if ($canv_wn_cat_link == 'tbldailyactivity') {
    echo 'selected';
}
?>>tbldailyactivity</option>
                                                <option value="tbl_event_master">tbl_event_master</option>
                                            </select> -->
                                            
                                            &nbsp;&nbsp;
                                            <!-- <input type="text" name="uw_ref_code" id="uw_ref_code" placeholder="Reference Code" style="width:200px;height: 24px;" value=""> -->
                                            <!-- Reference Code update by maple 05-11-19 -->
                                            <div style="margin-top: 2.5px;">
                                                Reference Code 
                                                <select name="uw_ref_code" id="uw_ref_code" style="width: 205px;">
                                                <option value="">Select</option>
                                                </select>
                                            </div>
                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>Scale (Show)</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="scale_show" style="width:200px; height: 24px;">

                                                <option value="">Select</option>

                                                <<option value="1">Individual</option>

                                                <option value="0">No</option>

                                                <option value="2">Common</option>

                                                <option value="3">Both</option>

                                            </select>

                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="scale_heading" id="scale_heading" >

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>Alerts/Updates (Show)</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="reminder_show" style="width:200px; height: 24px;">

                                                <option value="">Select</option>

                                                <option value="1">Individual</option>

                                                <option value="0">No</option>

                                                <option value="2">Common</option>

                                                <option value="3">Both</option>

                                            </select>

                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="reminder_heading" id="reminder_heading" >

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                     <tr>                                                                    

                                        <td align="right" valign="top"><strong>Alerts/Updates Category </strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                                <?php
echo $obj->getAllFavCatChkeckbox('alerts_updates_category', $arr_selected_cat_id, '200', '150');
?>                                           
                                                
                                            
                                            &nbsp;&nbsp;

                                            <input type="radio" name="canv_au_cat_show_fetch" value="1">Show

                                             &nbsp;&nbsp;

                                            <input type="radio" name="canv_au_cat_show_fetch" value="2">Fetch

                                            &nbsp;&nbsp;&nbsp;Link 

                                            <!-- make daynamic by ample-->
                                            <select name="canv_au_cat_link" id="canv_au_cat_link"  onchange="get_column_names(this,'au_ref_code')">

                                                <?php echo $tables; ?>

                                            </select>

                                            <!-- <select name="canv_au_cat_link" id="canv_au_cat_link">

                                                <option value="">Select</option>

                                                <option value="tbl_bodymainsymptoms" <?php
if ($canv_au_cat_link == 'tbl_bodymainsymptoms') {
    echo 'selected';
}
?>>tbl_bodymainsymptoms</option>

                                                <option value="tblsolutionitems" <?php
if ($canv_au_cat_link == 'tblsolutionitems') {
    echo 'selected';
}
?>>tblsolutionitems</option>

                                                <option value="tbldailymealsfavcategory" <?php
if ($canv_au_cat_link == 'tbldailymealsfavcategory') {
    echo 'selected';
}
?>>tbldailymealsfavcategory</option>

                                                <option value="tbldailyactivity" <?php
if ($canv_au_cat_link == 'tbldailyactivity') {
    echo 'selected';
}
?>>tbldailyactivity</option>
                                                <option value="tbl_event_master">tbl_event_master</option>
                                            </select> -->
                                            
                                            &nbsp;&nbsp;
                                           <!--  <input type="text" name="au_ref_code" id="au_ref_code" placeholder="Reference Code" style="width:200px;height: 24px;" placeholder="Reference Code" value=""> -->

                                           <!-- Reference Code update by maple 05-11-19 -->
                                            <div style="margin-top: 2.5px;">
                                                Reference Code 
                                                <select name="au_ref_code" id="au_ref_code" style="width: 205px;">
                                                <option value="">Select</option>
                                                </select>
                                            </div>
                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>Comments (Show)</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="comments_show" style="width:200px; height: 24px;">

                                                <option value="">Select</option>

                                                <option value="1">Individual</option>

                                                <option value="0">No</option>

                                                <option value="2">Common</option>

                                                <option value="3">Both</option>

                                            </select>

                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="comments_heading" id="comments_heading" >

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <tr>                                                                    

                                        <td align="right" valign="top"><strong>Order</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="order_show" style="width:200px; height: 24px;">

                                                <?php
for ($i = 1; $i <= 50; $i++) {
?>

                                                <option value="<?php
    echo $i;
?>"><?php
    echo $i;
?></option>

                                                <?php
}
?>

                                            </select>

                                        </td>

                                    </tr>

                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <!--copy by ample 07-04-20 -->
                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>Page Popup</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="page_show" id="page_show" style="width:200px; height: 24px;">

                                                <option value="">Select</option>

                                                <option value="Show">Show</option>

                                                <option value="Hide">Hide</option>

                                            </select>

                                        </td>

                                    </tr>
                                     <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

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

     <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>

    <script type="text/javascript">

        tinyMCE.init({

            mode : "exact",

            theme : "advanced",

            elements : "admin_comment",

            plugins : "style,advimage,advlink,emotions",

            theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

            theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

            theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

        });

    </script>

    <script>

        

function getMainCategoryOption(serial,checkboxname)

{

        

    var parent_cat_id = $("#fav_cat_type_id_0").val();

        var id='0';

//        alert(parent_cat_id);

        //var sub_cat = $("#fav_cat_id_"+idval).val();

        //alert(parent_cat_id);

    var dataString = 'action=getsubcatoptionCommon&parent_cat_id='+parent_cat_id+'&id='+id+'&serial='+serial+'&checkboxname='+checkboxname;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#fav_cat_id_0").html(result);

        }

    });

}

    function getMainCategoryOptionAddMore()

{

        

    var parent_cat_id = $("#fav_cat_type_id").val();

        var id='';

//        alert(parent_cat_id);

        //var sub_cat = $("#fav_cat_id_"+idval).val();

        //alert(parent_cat_id);

    var dataString = 'action=getsubcatoption&parent_cat_id='+parent_cat_id+'&id='+id;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#fav_cat_id").html(result);

        }

    });

}





 function getMainCategoryOptionAddMore2()

{

        

    var parent_cat_id = $("#fav_cat_type_id2").val();

        var id='';



    var dataString = 'action=getsubcat2option&parent_cat_id='+parent_cat_id+'&id='+id;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#fav_cat_id2").html(result);

        }

    });

}



 function getMainCategoryOptionAddMore3()

{

        

    var parent_cat_id = $("#fav_cat_type_id3").val();

        var id='';

    var dataString = 'action=getsubcat3option&parent_cat_id='+parent_cat_id+'&id='+id;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#fav_cat_id3").html(result);

        }

    });

}

 function getMainCategoryOptionAddMore4()

{

        

    var parent_cat_id = $("#fav_cat_type_id4").val();

        var id='';

    var dataString = 'action=getsubcat4option&parent_cat_id='+parent_cat_id+'&id='+id;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#fav_cat_id4").html(result);

        }

    });

}



 function getMainCategoryOptionAddMore5()

{

        

    var parent_cat_id = $("#fav_cat_type_id5").val();

        var id='';

    var dataString = 'action=getsubcat5option&parent_cat_id='+parent_cat_id+'&id='+id;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#fav_cat_id5").html(result);

        }

    });

}

 function getMainCategoryOptionAddMore6()

{

        

    var parent_cat_id = $("#fav_cat_type_id6").val();

        var id='';

    var dataString = 'action=getsubcat6option&parent_cat_id='+parent_cat_id+'&id='+id;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#fav_cat_id6").html(result);

        }

    });

}



 function getMainCategoryOptionAddMore7()

{

        

    var parent_cat_id = $("#fav_cat_type_id7").val();

        var id='';

    var dataString = 'action=getsubcat7option&parent_cat_id='+parent_cat_id+'&id='+id;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#fav_cat_id7").html(result);

        }

    });

}

 function getMainCategoryOptionAddMore8()

{

        

    var parent_cat_id = $("#fav_cat_type_id8").val();

        var id='';

    var dataString = 'action=getsubcat8option&parent_cat_id='+parent_cat_id+'&id='+id;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#fav_cat_id8").html(result);

        }

    });

}



 function getMainCategoryOptionAddMore9()

{

        

    var parent_cat_id = $("#fav_cat_type_id9").val();

        var id='';

    var dataString = 'action=getsubcat9option&parent_cat_id='+parent_cat_id+'&id='+id;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#fav_cat_id9").html(result);

        }

    });

}

 function getMainCategoryOptionAddMore10()

{

        

    var parent_cat_id = $("#fav_cat_type_id10").val();

        var id='';

    var dataString = 'action=getsubcat10option&parent_cat_id='+parent_cat_id+'&id='+id;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#fav_cat_id10").html(result);

        }

    });

}



function getDatadropdownPage(idval)

{

        var pdm_id = idval;

        var page_type = $("#page_type").val();

//        alert(parent_cat_id);

        //var sub_cat = $("#fav_cat_id_"+idval).val();

        //alert(parent_cat_id);

    var dataString = 'action=getDatadropdownPage&pdm_id='+pdm_id+'&page_type='+page_type;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            //alert(result);

                        //alert(sub_cat);

            $("#page_name").html(result);

        }

    });  
}

//add this by ample 05-11-19
 function get_column_names(tbl="",show_on="")
    {   
        //alert(tbl.value);
        var tbl_name=tbl.value;
        var dataString = 'action=getTableColumnsName&tbl_name='+tbl_name;

      $.ajax({
        type: "POST",
        url: "include/remote.php",
        // dataType:'JSON',
        data: dataString,
        cache: false,
        success: function(result)
        {
            //alert(result);
            $('#'+show_on).html(result);
            $('.'+show_on).html(result);      //add by ample 20-05-20 new condition
        }
      });
    }

    </script>

</div>
<?php

require_once('config/class.mysql.php');

require_once('classes/class.contents.php');

$obj = new Contents();


// wrong action id comment by ample 26-11-19
// $view_action_id = '313';
// $add_action_id = '314';

// update by ample 26-11-19
$view_action_id = '333';
$add_action_id = '334';



if(!$obj->isAdminLoggedIn())

{

    header("Location: index.php?mode=login");

    exit(0);

}



if(!$obj->chkValidActionPermission($admin_id,$view_action_id))

{	

    header("Location: index.php?mode=invalid");

    exit(0);

}



if(isset($_POST['btnSubmit']))

{

    $search = strip_tags(trim($_POST['search']));

    $status = strip_tags(trim($_POST['status']));

    $prof_cat = strip_tags(trim($_POST['prof_cat']));

   

}

else

{

    $search = '';

    $status = '';

    $prof_cat = '';

}



?>

<div id="central_part_contents" >

    <div id="notification_contents" ><!--notification_contents--></div>	  

    <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" >

    <tbody>

        <tr>

            <td>

                <table border="0" width="100%" cellpadding="0" cellspacing="0">

                <tbody>

                    <tr>

                        <td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>

                        <td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Data Dropdowns</td>

                        <td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>

                    </tr>

                </tbody>

                </table>

            </td>

        </tr>

        <tr >

            <td>

                <table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">

                <tbody >

                    <tr>

                        <td class="mainbox-body">

                            <p class="err_msg"><?php if(isset($_GET['msg']) && $_GET['msg'] != '' ) { echo urldecode($_GET['msg']); }?></p>

                            <div id="pagination_contents" align="center"> 

                                <p></p>

                                <form action="#" method="post" name="frm_place" id="frm_place" enctype="multipart/form-data" AUTOCOMPLETE="off">

                                    

                                <table border="0" width="100%" cellpadding="0" cellspacing="0">

                                <tbody>

                                    <tr>

                                        <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record</strong></td>

                                    </tr>

                                    <tr>

                                        

<!--                                        <td width="10%" height="30" align="left" valign="middle"><strong>Profile Category:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                           <select name="prof_cat" id="prof_cat" style="width:200px;">

                                                <option value="">Select Profile Category</option>

                                                 <?php  echo $obj->getFavCategoryTypeOptions($prof_cat);?>

                                            </select>

                                        </td>-->

                                        <td width="10%" height="30" align="left" valign="middle">&nbsp;</td>

                                        <td width="6%" height="30" align="left" valign="middle"><strong>Search:</strong></td>

                                        <td width="14%" height="30" align="left" valign="middle">

                                            <input type="text" name="search" id="search" value="<?php echo $search;?>" style="width:200px;"  />

                                        </td>

                                        <td width="10%" height="30" align="left" valign="middle">&nbsp;</td>

                                        <td width="10%" height="30" align="left" valign="middle"><strong>Status:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                           <select name="status" id="status" style="width:200px;">

                                                <option value="">All Status</option>

                                                <option value="0" <?php if($status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>

                                                <option value="1" <?php if($status == '1') { ?> selected="selected" <?php } ?>>Active</option>

                                            </select>

                                        </td>

                                        

                                        

                                        <td width="20%" height="30" align="left" valign="middle">&nbsp;</td>

                                        <td width="5%" height="30" align="left" valign="middle">&nbsp;</td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                            <input type="submit" name="btnSubmit" id="btnSubmit" value="Search" />

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                    

                                </tbody>

                                </table>

                                </form>

                            

                                <table border="1" width="100%" cellpadding="1" cellspacing="1">

                                <tbody>

                                    <tr>

                                        <td colspan="33" align="left">

                                        <?php 

                                        if($obj->chkValidActionPermission($admin_id,$add_action_id))

                                        { ?>

                                            <a href="index.php?mode=add-data-dropdown"><img src="images/add.gif" width="10" height="8" border="0" />Add New Entry</a>

                                        <?php 

                                        } ?>

                                        </td>

                                    </tr>

                                    <tr class="manage-header">

                                        <td width="5%" class="manage-header" align="center" >S.No.</td>

                                        <td width="10%" class="manage-header" align="center">Status</td>

                                        <td width="10%" class="manage-header" align="center">Added By Admin</td>

                                        <td width="10%" class="manage-header" align="center">Date</td>

                                        <td width="5%" class="manage-header" align="center">Edit</td>

                                        <td width="5%" class="manage-header" align="center">Del</td>

                                        <td width="10%" class="manage-header" align="center">Ref Code</td>

                                        <td width="10%" class="manage-header" align="center">Admin Notes</td>

                                        <td width="10%" class="manage-header" align="center">Heading</td>

                                        <td width="10%" class="manage-header" align="center">System Category</td>

                                        <td width="10%" class="manage-header" align="center">Page Name</td>

                                        <td width="10%" class="manage-header" align="center">Data Source</td>

                                        <td width="10%" class="manage-header" align="center">Prof Cat1</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat1</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat1 Fetch/Show</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat1 Link</td>

                                        

                                        <td width="10%" class="manage-header" align="center">Prof Cat2</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat2</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat2 Fetch/Show</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat2 Link</td>

                                        

                                        <td width="10%" class="manage-header" align="center">Prof Cat3</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat3</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat3 Fetch/Show</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat3 Link</td>

                                        

                                        <td width="10%" class="manage-header" align="center">Prof Cat4</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat4</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat4 Fetch/Show</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat4 Link</td>

                                        

                                        <td width="10%" class="manage-header" align="center">Prof Cat5</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat5</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat5 Fetch/Show</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat5 Link</td>

                                        

                                        <td width="10%" class="manage-header" align="center">Prof Cat6</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat6</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat6 Fetch/Show</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat6 Link</td>

                                        

                                        <td width="10%" class="manage-header" align="center">Prof Cat7</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat7</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat7 Fetch/Show</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat7 Link</td>

                                        

                                        <td width="10%" class="manage-header" align="center">Prof Cat8</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat8</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat8 Fetch/Show</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat8 Link</td>

                                        

                                        <td width="10%" class="manage-header" align="center">Prof Cat9</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat9</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat9 Fetch/Show</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat9 Link</td>

                                        

                                        <td width="10%" class="manage-header" align="center">Prof Cat10</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat10</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat10 Fetch/Show</td>

                                        <td width="10%" class="manage-header" align="center">Sub Cat10 Link</td>

                                        

                                         <td width="5%" class="manage-header" align="center">Time</td>

                                         <td width="5%" class="manage-header" align="center">Duration</td>

                                         <td width="5%" class="manage-header" align="center">Location</td>

                                         <td width="5%" class="manage-header" align="center">Location Cat</td>

                                         <td width="5%" class="manage-header" align="center">User Response</td>

                                         <td width="5%" class="manage-header" align="center">Response Cat</td>

                                         <td width="5%" class="manage-header" align="center">User What Next</td>

                                         <td width="5%" class="manage-header" align="center">What Next Cat </td>

                                         <td width="5%" class="manage-header" align="center">Scale</td>

                                         <td width="5%" class="manage-header" align="center">Alerts/Updates</td>

                                         <td width="5%" class="manage-header" align="center">Alerts/Updates Cat</td>

                                         <td width="5%" class="manage-header" align="center">Comments</td>

                                         <td width="5%" class="manage-header" align="center">Order</td>

                                        <!--add by ample 07-04-20 -->
                                        <td width="5%" class="manage-header" align="center">Page Popup</td>

                                       

                                    </tr>

                                    <?php

                                    echo $obj->getAllDataDropdowns($search,$status);

                                    ?>

                                </tbody>

                                </table>

                                <p></p>

                                <!--pagination_contents-->

                            </div>

                            <p></p>

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
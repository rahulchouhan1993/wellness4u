<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');  
require_once('classes/class.places.php');

$obj = new Contents();
$obj2 = new Places();

$edit_action_id = '352';

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


$error = false;
$err_msg = "";

$arr_selected_table_id = array();

if(isset($_POST['btnSubmit']))
{
    $tabl_id = $_POST['hdnpd_id'];
   
    $admin_comment=$_POST['admin_comment'];
    // $table_name=$_POST['table_name'];
     $page_id = $_POST['page_id'];

    $tablm_id=$_POST['tablm_id'];
    $ftablm_name=$_POST['ftablm_name'];
    $selected_table_name=$_POST['selected_table_name'];



 
    // $tablm_id = strip_tags(trim($_POST['tablm_id']));
    // $menu_id = implode(',', $_POST['admin_menu_id']);
    // $admin_comment = $_POST['admin_comment'];
    // $table_name = $_POST['table_name'];


    // foreach ($selected_table_name as $key => $value) 
    // {
    //     array_push($arr_selected_page_id,$value);
    // }

  

 // $pd_status = $_POST['pd_status'];
    $tabl_status=$_POST['tabl_status'];
    

  
    if($tablm_id == '')
    {
        $error = true;
        $err_msg = 'Please select function';
    }
    // elseif($obj->chkPageDropdownModuleExists_Edit($tablm_id,$pd_id))
    // {
    //     $error = true;
    //     $err_msg .= '<br>This function already added';
    // }
    
    
    if(count($selected_table_name) == 0)
    {
        $error = true;
        $err_msg .= '<br>Please select pages';
    }



    if(!$error)
    {
        $page_id_str = implode(',',$selected_table_name);
        
       
   // echo "<pre>";print_r($page_id_str);echo  "</pre>";
        // exit;


        if($obj->updateTablDropdownKR($admin_comment,$tabl_id,$tablm_id,$page_id_str,$ftablm_name,$tabl_status,$page_id))
        {
            
            // if(!empty($table_name))
            // {
            //     for($i=0;$i<count($arr_selected_page_id);$i++)
            //     {
            //         if($obj->alreadyinlist($arr_selected_page_id[$i]))
            //         {
            //             $obj->UpdateUserPlanAttributes($arr_selected_page_id[$i]);
            //         }
            //         else
            //         {
            //           $obj->AddUserPlanAttributes($arr_selected_page_id[$i]);  
            //         }
            //     }
            // }
            
            $msg = "Record Updated Successfully!";
            header('location: index.php?mode=manage_table_dropdown&msg='.urlencode($msg));
        }
        else
        {
            $error = true;
            $err_msg = "Currently there is some problem.Please try again later.";
        }
    }
}
elseif(isset($_GET['id']))
{
    $tabl_id = $_GET['id'];
    // list($admin_comment,$tabl_name,$tablm_id,$tabl_status,$plan_table) = $obj->getTablDropdownDetailsKR($tabl_id);
      $get_dta=$obj->getTablDropdownDetailsKR($tabl_id);
      
       // echo "<pre>";print_r($get_dta);echo "</pre>";
    
    $function_name=$obj->getTablFunctionNameById($get_dta['tablm_id']);
     // echo "<pre>";print_r($get_dta);echo "<pre>";

    // if($tablm_id == '')
    // {
    //     header('location: index.php?mode=manage_table_dropdown');	
    //     exit(0);
    // }
    // $arr_selected_page_id = explode(',',$page_id_str); 
    // $arr_selected_menu_id = explode(',',$menu_id); 
}	
else
{
    header('location: index.php?mode=manage_table_dropdown');
    exit(0);
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
	<table border="0" width="97%" align="center" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Page Dropdown</td>
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
                            <form method="post" name="frmadd_my_relation" id="frmadd_my_relation" enctype="multipart/form-data" >

                                <input type="hidden" name="hdnpd_id" id="hdnpd_id" value="<?php echo $tabl_id;?>" />
                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">
                                <tbody>


                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                                      
                                    <tr>
                                    <td width="30%" align="right"><strong>Status</strong></td>
                                    <td width="5%" align="center"><strong>:</strong></td>
                                    <td width="65%" align="left">
                                        <select id="tabl_status" name="tabl_status">
                                            <option value="1" <?php if($get_dta['tabl_status'] == '1'){ ?> selected <?php } ?>>Active</option>
                                            <option value="0" <?php if($get_dta['tabl_status'] == '0'){ ?> selected <?php } ?>>Inactive</option>
                                        </select>
                                     </td>
                                </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>
                                            <td width="30%" align="right" valign="top"><strong>Admin Notes</strong></td>
                                            <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                            <td width="65%" align="left" valign="top">
                                                <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"><?php echo  $get_dta['admin_comment'];?></textarea>

                                            </td>
                                        </tr>
                                        
                                        <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                        </tr>
                                        
                                        <!-- <tr>
                                        <td width="30%" align="right" valign="top"><strong>Table Name</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                           <select name="table_name" id="table_name" style="width:200px;">
                                                <option value="">Select Page</option>
                                                <option value="tbladviserplanatributes" <?php if($get_dta['plan_table'] == 'tbladviserplanatributes') { echo 'selected'; } ?>>tbladviserplanatributes</option>
                                            </select>
                                        </td>
                                    </tr> -->

                                    <tr>
                                        <td width="30%" align="right" valign="top"><strong>Page name</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                       <td width="65%" align="left" valign="top">
                                        <select name="page_id" id="page_id" style="width:200px; height: 24px;" onchange="getText(this)">
                                            <option value="">Select Page Name</option>
                                            <?php echo $obj->getDatadropdownPage_kr('27',$get_dta['page_id']);?>
                                        </select>
                                    </td>
                                 </tr>
                                        
                                        <tr>
                                                <td colspan="3" align="center">&nbsp;</td>
                                        </tr>
                                        
                                    <tr>
                                        <td width="30%" align="right" valign="top"><strong>Function Name</strong></td>
                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>
                                        <td width="65%" align="left" valign="top">
                                            <!--<input type='text' name='tablm_id' id='tablm_id'>-->
                                     <input type="hidden" name="tablm_id" id="tablm_id" style="width:200px;" value="<?php echo $get_dta['tablm_id'];?>">

                                         <!-- <input type="text" name="tablm_name" id="tablm_name" style="width:200px;" value="<?php echo $function_name;?>" readonly> -->

                                        <select name="ftablm_name" id="ftablm_name" style="width:200px;">
                                         <option value="<?php echo $function_name;?>"><?php echo $function_name;?></option>    <option value="">Select Function</option>
                                            <?php echo $obj->getTableDropdownModulesOptions($tablm_id);?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center">&nbsp;</td>
                                    </tr>
                                    <tr>                                                                    
                                        <td align="right" valign="top"><strong>Tables Names</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>
                                        <td align="left" valign="top">
                                            <?php echo $obj->getTableNameOptionsCheckedEdit($get_dta['tabl_name']);?>
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
	<br>
</div>
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
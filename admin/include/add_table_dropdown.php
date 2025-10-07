<?php

require_once('config/class.mysql.php');

require_once('classes/class.contents.php');  

require_once('classes/class.places.php');



$obj = new Contents();

$obj2 = new Places();



$add_action_id = '351';



if(!$obj->isAdminLoggedIn())

{

    header("Location: index.php?mode=login");

    exit(0);

}



if(!$obj->chkValidActionPermission($admin_id,$add_action_id))

{	

    header("Location: index.php?mode=invalid");

    exit(0);

}



$error = false;

$err_msg = "";

$arr_selected_tabl_name = array();



if(isset($_REQUEST['action']) && $_REQUEST['action'] =='addFunctionName')

    {        

        $function_name = $_REQUEST['function_name'];

       

        if($function_name=='')

        {

            echo 'Please Enter Function Name';die();

        }

        else if($obj->chkPageDropdownModuleExists_EditVivek($function_name))

        {

            echo 'This function already added';die();

        }

        else

        {

            echo $obj->addPageDropdownModuleVivek($function_name);die();

        }

        

    }



$admin_id=$_SESSION['admin_id'];

if(isset($_POST['btnSubmit']))

{

    //echo '<br><pre>';

    //print_r($_POST);

    //echo '<br></pre>';

    $tablm_id = strip_tags(trim($_POST['tablm_id']));

    // $menu_id = implode(',', $_POST['admin_menu_id']);

    $admin_comment = $_POST['admin_comment'];


   //new key page_type added by ample 04-11-19
    $page_id = $_POST['page_name'];
    $page_type = $_POST['page_type'];

    

    foreach ($_POST['selected_table_name'] as $key => $value) 

    {

        array_push($arr_selected_tabl_name,$value);

    }

        

    if($tablm_id == '')

    {

        $error = true;

        $err_msg = 'Please select function';

    }

   /* elseif($obj->chkPageDropdownModuleExists($tablm_id))

    {

        $error = true;

        $err_msg .= '<br>This function already added';

    }*/

    
    //comment by ample because its alraedy empty tabel and not run addTablDropdownKR function date 04-11-19
    // if(count($arr_selected_tabl_name) == 0)

    // {

    //     $error = true;

    //     $err_msg .= '<br>Please select pages';

    // }

    

    

    if(!$error)

    {

        $table_name_str = implode(',',$arr_selected_tabl_name);
        //key page_type send in function by ample 04-11-19
        if($obj->addTablDropdownKR($admin_comment,$tablm_id,$table_name_str,$page_id,$admin_id,$page_type))

        {

            // if(!empty($table_name))

            // {

            //     for($i=0;$i<count($arr_selected_tabl_name);$i++)

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

            $msg = "Record Added Successfully!";

            header('location: index.php?mode=manage_table_dropdown&msg='.urlencode($msg));

        }

        else

        {

            $error = true;

            $err_msg = "Currently there is some problem.Please try again later.";

        }

    }

}

else

{

    $pdm_id = '';

}	

?>

<div id="central_part_contents">

    <div id="notification_contents">

    <?php

    if($error)

    { ?>

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

    } ?>

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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Table Dropdown</td>

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

                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">

                                <tbody>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td width="30%" align="right" valign="top"><strong>Add Function Name</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <input type='text' name='function_name1' id='function_name1'>

                                        </td>

                                        

                                    </tr>

                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td width="30%" align="right" valign="top"><strong></strong></td>

                                        <td width="5%" align="center" valign="top"><strong></strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <button  name='addfunction'  id='addfunction' onclick='return addTablFunctionName();'>Submit</button>

                                        </td>

                                        

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

                                        

                                        <!-- <tr>

                                        <td width="30%" align="right" valign="top"><strong>Table Name</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="table_name" id="table_name" style="width:200px;">

                                                <option value="">Select Page</option>

                                                <option value="tbladviserplanatributes">tbladviserplanatributes</option>

                                            </select>

                                        </td>

                                    </tr> -->


                                      <!-- function change by ample 04-11-19 -->

                                   <!--  <tr>

                                        <td width="30%" align="right" valign="top"><strong>Page name</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                       <td width="65%" align="left" valign="top">

                                        <select name="page_id" id="page_id" style="width:200px; height: 24px;" onchange="getText(this)">

                                            <option value="">Select Page Name</option>


                                            <?php echo $obj->getDatadropdownPage_kr('27','');?>
                                           

                                        </select>

                                    </td>

                                 </tr> -->

                                 <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Page Type</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="page_type" id="page_type" style="width:200px; height: 24px;" required="" onchange="getDatadropdownPage('27')">

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

                                            <select name="page_name" id="page_name" style="width:200px; height: 24px;" required="">

                                                <option value="">Select Page Name</option>

                                                <?php //echo $obj->getPageCatDropdownModulesOptions($page_name);?>

                                                <?php echo $obj->getDatadropdownPage('27','','');?>

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

                                            <!--<input type='text' name='pdm_id' id='pdm_id'>-->

                                            <select name="tablm_id" id="tablm_id" style="width:200px;">

                                                <option value="">Select Function</option>

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

                                            <?php echo $obj->getTableNameOptions();?>

                                        </td>

                                    </tr>

                                    

                                   <!--  <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>                                                                    

                                        <td align="right" valign="top"><strong>Admin Menu</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td align="left" valign="top">

                                            <?php //echo $obj->getAllAdminMenuChkeckbox($arr_selected_page_id,'0','300','200');?>

                                        </td>

                                    </tr> -->

                                    

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

          function addTablFunctionName()

          {

   

              var function_name = $("#function_name1").val();

              

              var dataString ='function_name1='+function_name +'&action=addTablFunctionName';

              



            $.ajax({

            type: "POST",

            url: 'include/remote.php', 

            data: dataString,

            cache: false,

            success: function(result)

                 {



                     if(result==1)

                     {

                   

                         location.reload();

                     }

                     else

                     {



                        alert(result);

                     }

                

                }

           });

          }

          //copy function from add_page_fav_cat_dropdown by ample 04-11-19

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

        </script>

    </tbody>

    </table>

    <br>

</div>
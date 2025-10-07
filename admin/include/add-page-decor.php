<?php

require_once('config/class.mysql.php');

require_once('classes/class.contents.php');

require_once('classes/class.places.php');


$obj = new Contents();

$obj2 = new Places();

require_once('classes/class.scrollingwindows.php');

$obj1 = new Scrolling_Windows();


$add_action_id = '373';


if (!$obj->isAdminLoggedIn()) {
    
    header("Location: index.php?mode=login");
    
    exit(0);
    
}
else

{

   $admin_id = $_SESSION['admin_id']; 

}


if (!$obj->chkValidActionPermission($admin_id, $add_action_id)) {
    
    header("Location: index.php?mode=invalid");
    
    exit(0);
    
}

$DYL_id= $_GET['DYL_id'];

// add by ample 05-11-19
$tables=$obj->getTableNameFrom_tbltabldropdown('3');
$error = false;
$err_msg = "";


if (isset($_POST['btnSubmit'])) {
    
    
    // echo '<br><pre>';
    
    // print_r($_POST);
    
    // echo '</pre>';
    
    // die();

    $data=array(
    			'page_name' =>$_POST['page_name'],
    			'page_type' => $_POST['page_type'],
    			'data_source' => $_POST['data_source'],
    			'ref_code' => strip_tags(trim($_POST['ref_code'])),
    			'page_name_heading'=>strip_tags(trim($_POST['page_name_heading'])),
    			'system_cat'=>$_POST['fav_cat_type_id_0'],
    			'system_sub_cat'=>implode(',', $_POST['healcareandwellbeing']),
    			'admin_notes' => strip_tags(trim($_POST['admin_comment'])),
    			'narration' => strip_tags(trim($_POST['narration'])),
    			'order_no'=>$_POST['order_no'],
    			);


    if ($_POST['page_name'] == '') {
        
        $error = true;
        $err_msg = 'Please select Page';
    }
    
 
    if (!$error) {
        

        
        if ($obj->addPageDecorData($admin_id,$data,$DYL_id)) {
            
            $msg = "Record Added Successfully!";
            
             header('location: index.php?mode=manage-page-decor&msg=' . urlencode($msg));
            
        }
        
        else {
            
            $error = true;
            
            $err_msg = "Currently there is some problem.Please try again later.";
            
        }
        
    }
    
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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Page Decor</td>

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

                            <form action="#" method="post"  enctype="multipart/form-data" >

                                <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0"  id="tblrow">

                                <tbody>

                                    <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                     <tr>

                                        <td width="30%" align="right" valign="top"><strong>Reference Code</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <input type="text" name="ref_code" id="ref_code" style="width:200px;height: 24px;">

                                           

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

                                    <td width="30%" align="right" valign="top"><strong>Narration</strong></td>

                                    <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                    <td width="65%" align="left" valign="top">

                                        <textarea rows="5" cols="40" name="narration" id="narration">

                                        </textarea>

                                        

                                    </td>

                                </tr>

                                <tr>

                                    <td colspan="3" align="center">&nbsp;</td>

                                </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>System Category</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="fav_cat_type_id_0" id="fav_cat_type_id_0"  style="width:200px; height: 24px;" onchange="getMainCategoryOption('0','healcareandwellbeing')">                                                

												                                               <?php
												echo $obj->getFavCategoryTypeOptions('');
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

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Page Type</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <select name="page_type" id="page_type" style="width:200px; height: 24px;" onchange="getDatadropdownPage('30')">

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
                                                echo $obj->getDatadropdownPage('30', '', '');
                                                ?>

                                            </select>

                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="page_name_heading" id="heading" >

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
                                                echo $obj->getDatadropdownPage('4', '', '');
                                                ?>

                                            </select>

                                        </td>

                                    </tr>

                                    

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <tr>                                                                    

                                        <td align="right" valign="top"><strong>Order</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td  align="left" valign="top">

                                            <select name="order_no" style="width:200px; height: 24px;">

                                            	<option value="">Select Order Number</option>

                                                <?php for($i=1;$i<=50;$i++) { ?>

                                                <option value="<?php echo $i ?>"><?php echo $i ?></option>

                                                <?php } ?>

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

            elements : "narration,admin_comment",

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

    var dataString = 'action=getsubcatoptionPageDecor&parent_cat_id='+parent_cat_id+'&id='+id+'&serial='+serial+'&checkboxname='+checkboxname;

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

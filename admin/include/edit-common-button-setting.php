<?php

require_once('config/class.mysql.php');

require_once('classes/class.contents.php');

require_once('classes/class.places.php');


$obj = new Contents();

$obj2 = new Places();

require_once('classes/class.scrollingwindows.php');

$obj1 = new Scrolling_Windows();


$edit_action_id = '381';
$tblID='3';

if (!$obj->isAdminLoggedIn()) {
    
    header("Location: index.php?mode=login");
    
    exit(0);
    
}
else

{

   $admin_id = $_SESSION['admin_id']; 

}


if (!$obj->chkValidActionPermission($admin_id, $edit_action_id)) {
    
    header("Location: index.php?mode=invalid");
    
    exit(0);
    
}


$error = false;

$err_msg = "";


if (isset($_POST['btnSubmit'])) {
    
    
    // echo '<br><pre>';
    
    // print_r($_POST);
    
    // echo '</pre>';
    
    // die();

    $id=$_GET['id'];

    $data=array(
    			'page_name' =>$_POST['page_name'],
    			'page_type' => $_POST['page_type'],
    			'ref_code' => strip_tags(trim($_POST['ref_code'])),
    			'admin_comment' => strip_tags(trim($_POST['admin_comment'])),
                'status'=>$_POST['status'],
    			);


    if ($_POST['page_name'] == '') {
        
        $error = true;
        $err_msg = 'Please select Page';
    }
    
 
    if (!$error) {
        

        
        if ($obj->updateCommonButtonSetting($admin_id,$data,$id)) {
            
            $msg = "Record Update Successfully!";
            
            header('location: index.php?mode=common-button-setting&msg=' . urlencode($msg));
            
        }
        
        else {
            
            $error = true;
            
            $err_msg = "Currently there is some problem.Please try again later.";
            
        }
        
    }
    
}
elseif(isset($_GET['id']))
{
    $data = $obj->getCommonButtonSettingData($_GET['id']); 

    // echo "<pre>";

    // print_r($data);

    // die('-------');

}



?>

<div id="central_part_contents">

    <div id="notification_contents">

    <?php

    if(!empty($_SESSION['banner_msg'])) {
   $message = $_SESSION['banner_msg'];
   echo '<div class="alert alert-success">'.$message.'</div>';
   unset($_SESSION['banner_msg']);
}


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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Special Button Setting</td>

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

                                            <input type="text" name="ref_code" id="ref_code" value="<?php echo $data['ref_code']; ?>" style="width:200px;height: 24px;">

                                           

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

                                                <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"><?php echo $data['admin_comment']; ?></textarea>



                                            </td>

                                        </tr>


                                <tr>

                                    <td colspan="3" align="center">&nbsp;</td>

                                </tr>


                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Page Type</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                            <input type="text" name="page_type" id="page_type" value="<?php echo $data['page_type']; ?>" readonly>

                                        </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        

                                        <td width="30%" align="right" valign="top"><strong>Page Name</strong></td>

                                        <td width="5%" align="center" valign="top"><strong>:</strong></td>

                                        <td width="65%" align="left" valign="top">

                                           <input type="hidden" name="page_name" id="page_name" value="<?php echo $data['page_name']; ?>">

                                           <?php echo $obj->getPagenamebyPage_menu_id('30',$data['page_name'],$data['page_type']); ?>

              

                                        </td>

                                    </tr>

                                    

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>
                                    
                                    <!-- status add by ample 27-04-20 -->
                                    <tr>

                                            <td width="30%" align="right"><strong>Status</strong></td>

                                            <td width="5%" align="center"><strong>:</strong></td>

                                            <td width="65%" align="left">

                                                <select id="status" name="status" style="width:200px;height: 24px;">

                                                    <option value="1" <?php if($data['status'] == '1'){ ?> selected <?php } ?>>Active</option>

                                                    <option value="0" <?php if($data['status'] == '0'){ ?> selected <?php } ?>>Inactive</option>

                                                </select>

                                            </td>

                                    </tr>

                                    <tr>

                                        <td colspan="8" align="center">&nbsp;</td>

                                    </tr>


                                     <tr>

                                    <td>&nbsp;</td>

                                    <td>&nbsp;</td>

                                    <td align="left">
                                        <a href="index.php?mode=update_common_buttons&data_id=<?=$_GET['id']?>"><button type="button" class="btn btn-info btn-xs">Button Setting</button></a>

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

        var id='<?=$_GET["id"]?>';


    var dataString = 'action=getsubcatoptionPageDecor&parent_cat_id='+parent_cat_id+'&id='+id+'&serial='+serial+'&checkboxname='+checkboxname;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {


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
  $(document).ready(function()
    {
       $('.tbl_link').trigger('change');
    });
    </script>

</div>

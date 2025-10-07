<?php

require_once('config/class.mysql.php');

require_once('classes/class.contents.php');

require_once('classes/class.places.php');


$obj = new Contents();

$obj2 = new Places();

require_once('classes/class.scrollingwindows.php');

$obj1 = new Scrolling_Windows();


$edit_action_id = '374';
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
    			'data_source' => $_POST['data_source'],
    			'ref_code' => strip_tags(trim($_POST['ref_code'])),
    			'page_name_heading'=>strip_tags(trim($_POST['page_name_heading'])),
    			'system_cat'=>$_POST['fav_cat_type_id_0'],
    			'system_sub_cat'=>implode(',', $_POST['healcareandwellbeing']),
    			'admin_notes' => strip_tags(trim($_POST['admin_comment'])),
    			'narration' => strip_tags(trim($_POST['narration'])),
    			'order_no'=>$_POST['order_no'],
                'status'=>$_POST['status'],
    			);


    if ($_POST['page_name'] == '') {
        
        $error = true;
        $err_msg = 'Please select Page';
    }
    
 
    if (!$error) {
        

        
        if ($obj->updatePageDecorData($admin_id,$data,$id)) {
            
            $msg = "Record Update Successfully!";
            
            header('location: index.php?mode=manage-page-decor&msg=' . urlencode($msg));
            
        }
        
        else {
            
            $error = true;
            
            $err_msg = "Currently there is some problem.Please try again later.";
            
        }
        
    }
    
}
elseif(isset($_GET['id']))
{
    $data = $obj->getPageDecorData($_GET['id']); 

    // echo "<pre>";

    // print_r($data);

    // die('-------');
    $arr_selected_cat_id=explode(',',$data['system_sub_cat']);
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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Page Decor</td>

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

                                                <textarea rows="5" cols="40" name="admin_comment" id="admin_comment"><?php echo $data['admin_notes']; ?></textarea>



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
                                            <?php echo $data['narration']; ?>
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

                                            <select name="fav_cat_type_id_0" id="fav_cat_type_id_0" class="tbl_link" style="width:200px; height: 24px;" onchange="getMainCategoryOption('0','healcareandwellbeing')">
												<?php
												echo $obj->getFavCategoryTypeOptions($data['system_cat']);
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

                                            &nbsp;&nbsp;&nbsp;Heading <input type="text" name="page_name_heading" id="heading" value="<?php echo $data['page_name_heading']; ?>" >

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
                                                echo $obj->getDatadropdownPage('6',$data['data_source'], '');
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

                                                <option value="<?php echo $i ?>" <?=($data['order_no']==$i)? "selected": '' ?> ><?php echo $i ?></option>

                                                <?php } ?>

                                            </select>

                                        </td>

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
                                        <a href="index.php?mode=update_page_decor_buttons&PD_id=<?=$_GET['id']?>"><button type="button" class="btn btn-info btn-xs">Button Setting</button></a>

                                        <?php
                                            if(!empty($data['SW_id']))
                                            {
                                                ?>
                                                <a href="index.php?mode=edit_scrolling_window&id=<?=$data['SW_id'];?>" target="_blank"><button type="button" class="btn btn-warning btn-xs">Scrolling Windows</button></a>
                                                <?php
                                            }   
                                            else
                                            {
                                                ?>
                                                <a href="index.php?mode=add_scrolling_window&page_id=<?=$data['page_name'];?>&PD_id=<?=$_GET['id']?>" target="_blank"><button type="button" class="btn btn-warning btn-xs">Scrolling Windows</button></a>
                                                <?php
                                            }
                                         ?>

                                           <?php
                                            if(!empty($data['band_id']))
                                            {
                                                ?>
                                                <a href="index.php?mode=edit_band_setting&id=<?=$data['band_id'];?>&PD_id=<?=$_GET['id']?>" target="_blank"><button type="button" class="btn btn-primary btn-xs">Band Setting</button></a>
                                                <?php
                                            }   
                                            else
                                            {
                                                ?>
                                                <a href="index.php?mode=add_band_setting&PD_id=<?=$_GET['id']?>" target="_blank"><button type="button" class="btn btn-primary btn-xs">Band Setting</button></a>
                                                <?php
                                            }
                                         ?>
                                        
                                        <a href="index.php?mode=reset_mood_set&PD_id=<?=$_GET['id']?>"><button type="button" class="btn btn-success btn-xs">Reset Mood Band</button></a>

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

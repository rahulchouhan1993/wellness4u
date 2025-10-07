<?php

require_once('config/class.mysql.php');
require_once('classes/class.contents.php');
$obj = new Contents();

require_once('classes/class.banner.php');  
$obj1 = new Banner();

require_once('classes/class.scrollingwindows.php');
$obj2 = new Scrolling_Windows();


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


$error = false;

$err_msg = "";



if (isset($_POST['btnSubmit'])) 
{
    $banner_image = '';
 
        $picture_size_limit = 5120;
        $error = false;
        $err_msg = '';

        // Define a destination
        $targetFolder = SITE_PATH . '/uploads'; // Relative to the root

        if (!empty($_FILES) && (isset($_FILES['banner_image']['name'])) && ($_FILES['banner_image']['name'] != '') )
        {   

            $tempFile = $_FILES['banner_image']['tmp_name'];

            $filename = date('dmYHis') . '_' . $_FILES['banner_image']['name'];
            $filename = str_replace(' ', '-', $filename);

            $targetPath = $targetFolder;
            $targetFile = rtrim($targetPath, '/') . '/' . $filename;
            $mimetype = $_FILES['banner_image']['type'];

            // Validate the file type
            $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG'); // File extensions
            $fileParts = pathinfo($_FILES['banner_image']['name']);

            if (in_array($fileParts['extension'], $fileTypes))
            {
                $banner_image = $_FILES['banner_image']['name'];
                $size_in_kb = $_FILES['banner_image']['size'] / 1024;
                $file4 = substr($banner_image, -4, 4);
                if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG'))
                {
                    $error = true;
                    $err_msg = 'Please upload only(jpg/gif/jpeg/png) image ';
                }
                elseif ($size_in_kb > $picture_size_limit)
                {
                    $error = true;
                    $err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb.';
                }

                if (!$error)
                {
                    $banner_image = $filename;

                    if (!move_uploaded_file($tempFile, $targetFile))
                    {
                        if (file_exists($targetFile))
                        {
                            unlink($targetFile);
                        } // Remove temp file
                        $error = true;
                        $err_msg = 'Couldn\'t upload image';
                    }
                }
            }
            else
            {
                $error = true;
                $err_msg = 'Invalid file type';
            }
        }   
        else
        {
            $error = true;
            $err_msg = 'Couldn\'t choose banner image';
        }
        
    

    $data=array(
    			'band_title' => trim($_POST['band_title']),
    			'band_text'=>trim($_POST['band_text']),
                'button1'=>strip_tags(trim($_POST['button1'])),
                'button1_url'=>strip_tags(trim($_POST['button1_url'])),
                'button1_font_family'=>$_POST['button1_font_family'],
                'button1_font_size'=>$_POST['button1_font_size'],
                'button1_font_color'=>$_POST['button1_font_color'],
                'button1_bg_color'=>$_POST['button1_bg_color'],
                'button1_icon_code'=>$_POST['button1_icon_code'],
                'button1_show'=>$_POST['button1_show'],
                'button2'=>strip_tags(trim($_POST['button2'])),
                'button2_url'=>strip_tags(trim($_POST['button2_url'])),
                'button2_font_family'=>$_POST['button2_font_family'],
                'button2_font_size'=>$_POST['button2_font_size'],
                'button2_font_color'=>$_POST['button2_font_color'],
                'button2_bg_color'=>$_POST['button2_bg_color'],
                'button2_icon_code'=>$_POST['button2_icon_code'],
                'button2_show'=>$_POST['button2_show'],
    			'band_row_no'=>$_POST['band_row_no'],
                'band_status'=>$_POST['band_status'],
                'data_content'=>$_POST['data_content'],
                'bg_image'=>$banner_image,
                'bg_color'=>$_POST['bg_color'],
                'band_type'=>$_POST['band_type'],
    			);

   
 
    if (!$error) {
        

        
        if ($obj1->addBandSetting($admin_id,$data,$_GET['PD_id'])) {
            
            $msg = "Band Add Successfully!";
            header('location: index.php?mode=edit-page-decor&id='.$_GET['PD_id'].'&msg=' . urlencode($msg));
            
        }
        
        else {
            
            $error = true;
            
            $err_msg = "Currently there is some problem.Please try again later.";
            
        }
        
    }
    
}
else
{
    $_POST=array();
    $_POST['band_title']=' &nbsp; ';
}



?>

<!-- <script type="text/javascript" src="js/jscolor.js"></script>  -->
<script type="text/javascript" src="js/jscolor-2.1.1.js"></script> 

<div id="central_part_contents">

    <div id="notification_contents">

    <?php

    if(!empty($_SESSION['band_msg'])) {
   $message = $_SESSION['band_msg'];
   echo '<div class="alert alert-success">'.$message.'</div>';
   unset($_SESSION['band_msg']);
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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Band Setting</td>

                        <td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>

                    </tr>

                </tbody>

                </table>

            </td>

        </tr>

        <tr>

            <td>
                <br><br><br>
                    <center><div id="error_msg"></div></center>
                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-10">
                            <form role="form" class="form-horizontal" id="add_band_slider" name="add_band_slider" method="post" enctype='multipart/form-data'> 

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Band Title<span style="color:red">*</span></label>
                            <div class="col-lg-4">
                                 <textarea class="form-control" rows="5" id="band_title" name="band_title" required><?php echo $_POST['band_title']?></textarea>
                            </div>
                            <label class="col-lg-2 control-label">Band Text Line</label>
                            <div class="col-lg-4">
                                 <textarea class="form-control" rows="5" id="band_text" name="band_text" ><?php echo $_POST['band_text']?></textarea>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Button1</label>
                            <div class="col-lg-4">
                                <input type="text" name="button1" id="button1" value="<?=$_POST['button1'];?>" class="form-control" >
                            </div>
                            <label class="col-lg-2 control-label">Button1 URL</label>
                            <div class="col-lg-4">
                               <input type="text" name="button1_url" id="button1_url" value="<?=$_POST['button1_url'];?>" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group">
                             <label class="col-lg-2 control-label">Font Family</label>
                            <div class="col-lg-2">
                                <select name="button1_font_family" id="button1_font_family" class="form-control">
                                    <?php echo $obj2->getFontFamilyOptions($_POST['button1_font_family']); ?>    
                                </select>
                            </div>
                        
                            <label class="col-lg-2 control-label">Font Size</label>
                            <div class="col-lg-2">
                                <select name="button1_font_size" id="button1_font_size" class="form-control">
                                    <?php echo $obj2->getFontSizeOptions($_POST['button1_font_size']); ?>    
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Font Color</label>
                            <div class="col-lg-2">
                                <input type="text" name="button1_font_color" id="button1_font_color" value="<?=$_POST['button1_font_color']?>" class="form-control" data-jscolor="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Background Color</label>
                            <div class="col-lg-2">
                               <input type="text" name="button1_bg_color" id="button1_bg_color" value="<?=$_POST['button1_bg_color']?>" class="form-control" data-jscolor="">
                            </div>
                            <label class="col-lg-2 control-label">Icon Code</label>
                            <div class="col-lg-2">
                               <input type="text" name="button1_icon_code" id="button1_icon_code" value="<?=$_POST['button1_icon_code']?>" class="form-control">
                            </div>
                            <label class="col-lg-2 control-label">Button1 Show</label>
                            <div class="col-lg-2">
                                <select name="button1_show" id="button1_show" class="form-control">
                                    <option value="1" <?php if($_POST['button1_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                    <option value="0" <?php if($_POST['button1_show'] == '0'){?> selected <?php } ?>>No</option> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Button2</label>
                            <div class="col-lg-4">
                                <input type="text" name="button2" id="button2" value="<?=$_POST['button2'];?>" class="form-control" >
                            </div>
                             <label class="col-lg-2 control-label">Button2 URL</label>
                            <div class="col-lg-4">
                               <input type="text" name="button2_url" id="button2_url" value="<?=$_POST['button2_url'];?>" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group">
                             <label class="col-lg-2 control-label">Font Family</label>
                            <div class="col-lg-2">
                                <select name="button2_font_family" id="button2_font_family" class="form-control">
                                    <?php echo $obj2->getFontFamilyOptions($_POST['button2_font_family']); ?>    
                                </select>
                            </div>
                        
                            <label class="col-lg-2 control-label">Font Size</label>
                            <div class="col-lg-2">
                                <select name="button2_font_size" id="button2_font_size" class="form-control">
                                    <?php echo $obj2->getFontSizeOptions($_POST['button2_font_size']); ?>    
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Font Color</label>
                            <div class="col-lg-2">
                                <input type="text" name="button2_font_color" id="button2_font_color" value="<?=$_POST['button2_font_color']?>" class="form-control" data-jscolor="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Background Color</label>
                            <div class="col-lg-2">
                               <input type="text" name="button2_bg_color" id="button2_bg_color" value="<?=$_POST['button2_bg_color']?>" class="form-control" data-jscolor="">
                            </div>
                            <label class="col-lg-2 control-label">Icon Code</label>
                            <div class="col-lg-2">
                               <input type="text" name="button2_icon_code" id="button2_icon_code" value="<?=$_POST['button2_icon_code']?>" class="form-control">
                            </div>
                            <label class="col-lg-2 control-label">Button2 Show</label>
                            <div class="col-lg-2">
                                <select name="button2_show" id="button2_show" class="form-control">
                                    <option value="1" <?php if($_POST['button2_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                    <option value="0" <?php if($_POST['button2_show'] == '0'){?> selected <?php } ?>>No</option> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Row Number<span style="color:red">*</span></label>
                            <div class="col-lg-4">
                                <select name="band_row_no" id="band_row_no" class="form-control" required>
                                    <option value="">--select--</option>
                                    <?php
                                    for ($i=1; $i < 11; $i++) { 
                                        ?>
                                        <option value="<?=$i?>" <?php if($_POST['band_row_no'] == $i){?> selected <?php } ?>><?=$i?></option> 
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                             <label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
                            <div class="col-lg-4">
                                <select name="band_status" id="band_status" class="form-control" required>
                                    <option value="1" <?php if($_POST['band_status'] == '1'){?> selected <?php } ?>>Active</option> 
                                    <option value="0" <?php if($_POST['band_status'] == '0'){?> selected <?php } ?>>Inactive</option> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Data Content</label>
                            <div class="col-lg-4">
                                <input type="text" name="data_content" id="data_content" value="<?php echo $_POST['data_content']?>" class="form-control">
                            </div>
                             <label class="col-lg-2 control-label">Data Link</label>
                            <div class="col-lg-4">
                                <input type="text" name="data_link" id="data_link" value="<?php echo $_POST['data_link']?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Band Background Image</label>
                            <div class="col-lg-4">
                                <input type="file" name="banner_image" id="banner_image" class="form-control"><br><span>(Recommanded size 1600px X 900px)</span>
                            </div>
                            <label class="col-lg-2 control-label">Band Background Color</label>
                            <div class="col-lg-4">
                               <input type="text" name="bg_color" id="bg_color" value="<?=$_POST['bg_color']?>" class="form-control" data-jscolor="">
                            </div>
                            
                        </div>

                        <div class="form-group">
                             <label class="col-lg-2 control-label">Band Type<span style="color:red">*</span></label>
                            <div class="col-lg-4">
                                <select name="band_type" id="band_type" class="form-control" required>
                                    <option value="banner-view" <?php if($_POST['band_type'] == 'banner-view'){?> selected <?php } ?>>banner-view</option> 
                                    <option value="search-view" <?php if($_POST['band_type'] == 'search-box'){?> selected <?php } ?>>search-view</option>
                                    <option value="icon-view" <?php if($_POST['band_type'] == 'icon-vie'){?> selected <?php } ?>>icon-view</option>
                                    <option value="item-view" <?php if($_POST['band_type'] == 'item-view'){?> selected <?php } ?>>item-view</option> 
                                </select>
                            </div>
                        </div>
                   
                        <hr>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-10">
                                <div class="pull-left">
                                    <button class="btn btn-primary rounded" type="submit" name="btnSubmit" id="btnSubmit">Submit</button>
                                    <a href="index.php?mode=edit-page-decor&id=<?=$_GET['PD_id'];?>"><button type="button" class="btn btn-danger rounded">Cancel</button></a>
                                </div>
                            </div>
                        </div>
                    </form>

                        </div>
                        <div class="col-md-1">
                        </div>
                    </div>
                    
            </td>

        </tr>

            </tbody>

    </table>


</div>

     <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>

    <script type="text/javascript">

        tinyMCE.init({

            mode : "exact",

            theme : "advanced",

            elements : "band_title,band_text",

            plugins : "style,advimage,advlink,emotions",

            theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

            theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

            theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

        });


    </script>

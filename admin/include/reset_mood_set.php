<?php

require_once('config/class.mysql.php');
require_once('classes/class.contents.php');
$obj = new Contents();

require_once('classes/class.banner.php');  
$obj1 = new Banner();

require_once('classes/class.scrollingwindows.php');
$obj2 = new Scrolling_Windows();


$edit_action_id = '374';


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



$id=$_GET['PD_id'];

$theme_data=array();
$music_data=array();
$icon_data=array();


if (isset($_POST['btnSubmit'])) 
{
        
    
    $band_id=$_POST['band_id'];
    $is_default=$_POST['is_default'];
    if(empty($is_default))
    {
        $is_default=0;
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
            'bg_color'=>$_POST['bg_color'],
            'band_type'=>$_POST['band_type'],
            'is_default'=>$is_default,
            );

    if(!empty($band_id))
    {
        if ($obj1->editBandSetting_reset($admin_id,$data,$band_id)) {
            
            $msg = "Band Update Successfully!";
            header('location: index.php?mode=reset_mood_set&PD_id='.$_GET['PD_id'].'&msg=' . urlencode($msg));
            
        }
        
        else {
            
            $error = true;
            
            $err_msg = "Currently there is some problem.Please try again later.";
            
        }
    }
    else
    {
        if ($obj1->addBandSetting_reset($admin_id,$data,$_GET['PD_id'])) {
            
            $msg = "Band Add Successfully!";
            header('location: index.php?mode=reset_mood_set&PD_id='.$_GET['PD_id'].'&msg=' . urlencode($msg));
            
        }
        
        else {
            
            $error = true;
            
            $err_msg = "Currently there is some problem.Please try again later.";
            
        }
    }

}
else
{
    $theme_data = $obj1->get_reset_mood_setting($_GET['PD_id'],'theme-band'); 
    $music_data = $obj1->get_reset_mood_setting($_GET['PD_id'],'music-band');
    $icon_data = $obj1->get_reset_mood_setting($_GET['PD_id'],'icon-band');
    $board_data = $obj1->get_reset_mood_setting($_GET['PD_id'],'nudge-board');
    $bits_data = $obj1->get_reset_mood_setting($_GET['PD_id'],'fun-tit-bits');
}



?>

<!-- <script type="text/javascript" src="js/jscolor.js"></script>  -->
<script type="text/javascript" src="js/jscolor-2.1.1.js"></script> 

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

                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Reset Mood Band Setting</td>

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
                                <a href="index.php?mode=edit-page-decor&id=<?=$_GET['PD_id'];?>" style="text-align: right;float: right;"><button type="button" class="btn btn-default rounded">Back</button></a>
                              <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#theme-band">Theme Band</a></li>
                                <li><a data-toggle="tab" href="#music-band">Music Band</a></li>
                                <li><a data-toggle="tab" href="#icon-band">Mascot Band</a></li>
                                <li><a data-toggle="tab" href="#Nudge-Board">Nudge Board</a></li>
                                <li><a data-toggle="tab" href="#Fun-tit-bits">Fun tit bits</a></li>
                              </ul>

                              <div class="tab-content">
                                <div id="theme-band" class="tab-pane fade in active">
                                  <h3>Theme Band</h3>
                                  <form role="form" class="form-horizontal" id="edit_banner_slider" name="edit_banner_slider" method="post" enctype='multipart/form-data'> 
                                    <input type="hidden" name="band_id"  value="<?php echo $theme_data['band_id'];?>" >
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Band Title<span style="color:red">*</span></label>
                                        <div class="col-lg-4">
                                            <textarea class="form-control" rows="5" id="band_title1" name="band_title"><?php echo $theme_data['band_title']?></textarea>
                                        </div>
                                         <label class="col-lg-2 control-label">Band Text Line</label>
                                        <div class="col-lg-4">
                                             <textarea class="form-control" rows="5" id="band_text1" name="band_text" ><?php echo $theme_data['band_text']?></textarea>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Button1</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="button1" id="button1" value="<?=$theme_data['button1']?>" class="form-control" >
                                        </div>
                                        <label class="col-lg-2 control-label">Button1 URL</label>
                                        <div class="col-lg-4">
                                           <input type="text" name="button1_url" id="button1_url" value="<?=$theme_data['button1_url']?>" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                         <label class="col-lg-2 control-label">Font Family</label>
                                        <div class="col-lg-2">
                                            <select name="button1_font_family" id="button1_font_family" class="form-control">
                                                <?php echo $obj2->getFontFamilyOptions($theme_data['button1_font_family']); ?>    
                                            </select>
                                        </div>
                                    
                                        <label class="col-lg-2 control-label">Font Size</label>
                                        <div class="col-lg-2">
                                            <select name="button1_font_size" id="button1_font_size" class="form-control">
                                                <?php echo $obj2->getFontSizeOptions($theme_data['button1_font_size']); ?>    
                                            </select>
                                        </div>
                                        <label class="col-lg-2 control-label">Font Color</label>
                                        <div class="col-lg-2">
                                            <input type="text" name="button1_font_color" id="button1_font_color" value="<?=$theme_data['button1_font_color']?>" class="form-control" data-jscolor="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Background Color</label>
                                        <div class="col-lg-2">
                                           <input type="text" name="button1_bg_color" id="button1_bg_color" value="<?=$theme_data['button1_bg_color']?>" class="form-control" data-jscolor="">
                                        </div>
                                        <label class="col-lg-2 control-label">Icon Code</label>
                                        <div class="col-lg-2">
                                           <input type="text" name="button1_icon_code" id="button1_icon_code" value="<?=$theme_data['button1_icon_code']?>" class="form-control">
                                        </div>
                                        <label class="col-lg-2 control-label">Button1 Show</label>
                                        <div class="col-lg-2">
                                            <select name="button1_show" id="button1_show" class="form-control">
                                                <option value="1" <?php if($theme_data['button1_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                                <option value="0" <?php if($theme_data['button1_show'] == '0'){?> selected <?php } ?>>No</option> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Button2</label>
                                        <div class="col-lg-4">
                                            <input type="text" name="button2" id="button2" value="<?=$theme_data['button2']?>" class="form-control" >
                                        </div>
                                         <label class="col-lg-2 control-label">Button2 URL</label>
                                        <div class="col-lg-4">
                                           <input type="text" name="button2_url" id="button2_url" value="<?=$theme_data['button2_url']?>" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                         <label class="col-lg-2 control-label">Font Family</label>
                                        <div class="col-lg-2">
                                            <select name="button2_font_family" id="button2_font_family" class="form-control">
                                                <?php echo $obj2->getFontFamilyOptions($theme_data['button2_font_family']); ?>    
                                            </select>
                                        </div>
                                    
                                        <label class="col-lg-2 control-label">Font Size</label>
                                        <div class="col-lg-2">
                                            <select name="button2_font_size" id="button2_font_size" class="form-control">
                                                <?php echo $obj2->getFontSizeOptions($theme_data['button2_font_size']); ?>    
                                            </select>
                                        </div>
                                        <label class="col-lg-2 control-label">Font Color</label>
                                        <div class="col-lg-2">
                                            <input type="text" name="button2_font_color" id="button2_font_color" value="<?=$theme_data['button2_font_color']?>" class="form-control" data-jscolor="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Background Color</label>
                                        <div class="col-lg-2">
                                           <input type="text" name="button2_bg_color" id="button2_bg_color" value="<?=$theme_data['button2_bg_color']?>" class="form-control" data-jscolor="">
                                        </div>
                                        <label class="col-lg-2 control-label">Icon Code</label>
                                        <div class="col-lg-2">
                                           <input type="text" name="button2_icon_code" id="button2_icon_code" value="<?=$theme_data['button2_icon_code']?>" class="form-control">
                                        </div>
                                        <label class="col-lg-2 control-label">Button2 Show</label>
                                        <div class="col-lg-2">
                                            <select name="button2_show" id="button2_show" class="form-control">
                                                <option value="1" <?php if($theme_data['button2_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                                <option value="0" <?php if($theme_data['button2_show'] == '0'){?> selected <?php } ?>>No</option> 
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
                                                    <option value="<?=$i?>" <?php if($theme_data['band_row_no'] == $i){?> selected <?php } ?>><?=$i?></option> 
                                                    <?php
                                                }
                                                ?> 
                                            </select>
                                        </div>
                                         <label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
                                        <div class="col-lg-4">
                                            <select name="band_status" id="band_status" class="form-control">
                                                <option value="1" <?php if($theme_data['band_status'] == '1'){?> selected <?php } ?>>Active</option> 
                                                <option value="0" <?php if($theme_data['band_status'] == '0'){?> selected <?php } ?>>Inactive</option> 
                                            </select>
                                        </div>
                                    </div>   
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Band Type<span style="color:red">*</span></label>
                                        <div class="col-lg-4">
                                            <input type="text" name="band_type" id="band_type" value="theme-band" class="form-control" readonly>
                                        </div>
                                         <label class="col-lg-2 control-label">Band Background Color</label>
                                        <div class="col-lg-4">
                                           <input type="text" name="bg_color" id="bg_color" value="<?=$theme_data['bg_color']?>" class="form-control" data-jscolor="">
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-10">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="is_default" value="1" <?=($theme_data['is_default']==1)?'checked':'';?>> <b>Is Default Theme Band</b></label>
                                              </div>
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
                                <div id="music-band" class="tab-pane fade">
                                     <h3>Music Band</h3>
                                      <form role="form" class="form-horizontal" id="edit_banner_slider" name="edit_banner_slider" method="post" enctype='multipart/form-data'> 
                                        <input type="hidden" name="band_id"  value="<?php echo $music_data['band_id'];?>" >
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Band Title<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                                <textarea class="form-control" rows="5" id="band_title2" name="band_title" ><?php echo $music_data['band_title']?></textarea>
                                            </div>
                                             <label class="col-lg-2 control-label">Band Text Line</label>
                                            <div class="col-lg-4">
                                                 <textarea class="form-control" rows="5" id="band_text2" name="band_text" ><?php echo $music_data['band_text']?></textarea>
                                            </div>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Button1</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="button1" id="button1" value="<?=$music_data['button1']?>" class="form-control" >
                                            </div>
                                            <label class="col-lg-2 control-label">Button1 URL</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="button1_url" id="button1_url" value="<?=$music_data['button1_url']?>" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="col-lg-2 control-label">Font Family</label>
                                            <div class="col-lg-2">
                                                <select name="button1_font_family" id="button1_font_family" class="form-control">
                                                    <?php echo $obj2->getFontFamilyOptions($music_data['button1_font_family']); ?>    
                                                </select>
                                            </div>
                                        
                                            <label class="col-lg-2 control-label">Font Size</label>
                                            <div class="col-lg-2">
                                                <select name="button1_font_size" id="button1_font_size" class="form-control">
                                                    <?php echo $obj2->getFontSizeOptions($music_data['button1_font_size']); ?>    
                                                </select>
                                            </div>
                                            <label class="col-lg-2 control-label">Font Color</label>
                                            <div class="col-lg-2">
                                                <input type="text" name="button1_font_color" id="button1_font_color" value="<?=$music_data['button1_font_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Background Color</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button1_bg_color" id="button1_bg_color" value="<?=$music_data['button1_bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            <label class="col-lg-2 control-label">Icon Code</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button1_icon_code" id="button1_icon_code" value="<?=$music_data['button1_icon_code']?>" class="form-control">
                                            </div>
                                            <label class="col-lg-2 control-label">Button1 Show</label>
                                            <div class="col-lg-2">
                                                <select name="button1_show" id="button1_show" class="form-control">
                                                    <option value="1" <?php if($music_data['button1_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                                    <option value="0" <?php if($music_data['button1_show'] == '0'){?> selected <?php } ?>>No</option> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Button2</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="button2" id="button2" value="<?=$music_data['button2']?>" class="form-control" >
                                            </div>
                                             <label class="col-lg-2 control-label">Button2 URL</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="button2_url" id="button2_url" value="<?=$music_data['button2_url']?>" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="col-lg-2 control-label">Font Family</label>
                                            <div class="col-lg-2">
                                                <select name="button2_font_family" id="button2_font_family" class="form-control">
                                                    <?php echo $obj2->getFontFamilyOptions($music_data['button2_font_family']); ?>    
                                                </select>
                                            </div>
                                        
                                            <label class="col-lg-2 control-label">Font Size</label>
                                            <div class="col-lg-2">
                                                <select name="button2_font_size" id="button2_font_size" class="form-control">
                                                    <?php echo $obj2->getFontSizeOptions($music_data['button2_font_size']); ?>    
                                                </select>
                                            </div>
                                            <label class="col-lg-2 control-label">Font Color</label>
                                            <div class="col-lg-2">
                                                <input type="text" name="button2_font_color" id="button2_font_color" value="<?=$music_data['button2_font_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Background Color</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button2_bg_color" id="button2_bg_color" value="<?=$music_data['button2_bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            <label class="col-lg-2 control-label">Icon Code</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button2_icon_code" id="button2_icon_code" value="<?=$music_data['button2_icon_code']?>" class="form-control">
                                            </div>
                                            <label class="col-lg-2 control-label">Button2 Show</label>
                                            <div class="col-lg-2">
                                                <select name="button2_show" id="button2_show" class="form-control">
                                                    <option value="1" <?php if($music_data['button2_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                                    <option value="0" <?php if($music_data['button2_show'] == '0'){?> selected <?php } ?>>No</option> 
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
                                                        <option value="<?=$i?>" <?php if($music_data['band_row_no'] == $i){?> selected <?php } ?>><?=$i?></option> 
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </div>
                                             <label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                                <select name="band_status" id="band_status" class="form-control">
                                                    <option value="1" <?php if($music_data['band_status'] == '1'){?> selected <?php } ?>>Active</option> 
                                                    <option value="0" <?php if($music_data['band_status'] == '0'){?> selected <?php } ?>>Inactive</option> 
                                                </select>
                                            </div>
                                        </div>   
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Band Type<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                                <input type="text" name="band_type" id="band_type" value="music-band" class="form-control" readonly>
                                            </div>
                                             <label class="col-lg-2 control-label">Band Background Color</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="bg_color" id="bg_color" value="<?=$music_data['bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-10">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="is_default" value="1" <?=($music_data['is_default']==1)?'checked':'';?>> <b>Is Default Theme Band</b></label>
                                                  </div>
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
                                <div id="icon-band" class="tab-pane fade">
                                  <h3>Icon Band</h3>
                                      <form role="form" class="form-horizontal" id="edit_banner_slider" name="edit_banner_slider" method="post" enctype='multipart/form-data'> 
                                        <input type="hidden" name="band_id"  value="<?php echo $icon_data['band_id'];?>" >
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Band Title<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                                <textarea class="form-control" rows="5" id="band_title3" name="band_title"><?php echo $icon_data['band_title']?></textarea>
                                            </div>
                                             <label class="col-lg-2 control-label">Band Text Line</label>
                                            <div class="col-lg-4">
                                                 <textarea class="form-control" rows="5" id="band_text3" name="band_text" ><?php echo $icon_data['band_text']?></textarea>
                                            </div>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Button1</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="button1" id="button1" value="<?=$icon_data['button1']?>" class="form-control" >
                                            </div>
                                            <label class="col-lg-2 control-label">Button1 URL</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="button1_url" id="button1_url" value="<?=$icon_data['button1_url']?>" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="col-lg-2 control-label">Font Family</label>
                                            <div class="col-lg-2">
                                                <select name="button1_font_family" id="button1_font_family" class="form-control">
                                                    <?php echo $obj2->getFontFamilyOptions($icon_data['button1_font_family']); ?>    
                                                </select>
                                            </div>
                                        
                                            <label class="col-lg-2 control-label">Font Size</label>
                                            <div class="col-lg-2">
                                                <select name="button1_font_size" id="button1_font_size" class="form-control">
                                                    <?php echo $obj2->getFontSizeOptions($icon_data['button1_font_size']); ?>    
                                                </select>
                                            </div>
                                            <label class="col-lg-2 control-label">Font Color</label>
                                            <div class="col-lg-2">
                                                <input type="text" name="button1_font_color" id="button1_font_color" value="<?=$icon_data['button1_font_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Background Color</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button1_bg_color" id="button1_bg_color" value="<?=$icon_data['button1_bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            <label class="col-lg-2 control-label">Icon Code</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button1_icon_code" id="button1_icon_code" value="<?=$icon_data['button1_icon_code']?>" class="form-control">
                                            </div>
                                            <label class="col-lg-2 control-label">Button1 Show</label>
                                            <div class="col-lg-2">
                                                <select name="button1_show" id="button1_show" class="form-control">
                                                    <option value="1" <?php if($icon_data['button1_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                                    <option value="0" <?php if($icon_data['button1_show'] == '0'){?> selected <?php } ?>>No</option> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Button2</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="button2" id="button2" value="<?=$icon_data['button2']?>" class="form-control" >
                                            </div>
                                             <label class="col-lg-2 control-label">Button2 URL</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="button2_url" id="button2_url" value="<?=$icon_data['button2_url']?>" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="col-lg-2 control-label">Font Family</label>
                                            <div class="col-lg-2">
                                                <select name="button2_font_family" id="button2_font_family" class="form-control">
                                                    <?php echo $obj2->getFontFamilyOptions($icon_data['button2_font_family']); ?>    
                                                </select>
                                            </div>
                                        
                                            <label class="col-lg-2 control-label">Font Size</label>
                                            <div class="col-lg-2">
                                                <select name="button2_font_size" id="button2_font_size" class="form-control">
                                                    <?php echo $obj2->getFontSizeOptions($icon_data['button2_font_size']); ?>    
                                                </select>
                                            </div>
                                            <label class="col-lg-2 control-label">Font Color</label>
                                            <div class="col-lg-2">
                                                <input type="text" name="button2_font_color" id="button2_font_color" value="<?=$icon_data['button2_font_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Background Color</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button2_bg_color" id="button2_bg_color" value="<?=$icon_data['button2_bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            <label class="col-lg-2 control-label">Icon Code</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button2_icon_code" id="button2_icon_code" value="<?=$icon_data['button2_icon_code']?>" class="form-control">
                                            </div>
                                            <label class="col-lg-2 control-label">Button2 Show</label>
                                            <div class="col-lg-2">
                                                <select name="button2_show" id="button2_show" class="form-control">
                                                    <option value="1" <?php if($icon_data['button2_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                                    <option value="0" <?php if($icon_data['button2_show'] == '0'){?> selected <?php } ?>>No</option> 
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
                                                        <option value="<?=$i?>" <?php if($icon_data['band_row_no'] == $i){?> selected <?php } ?>><?=$i?></option> 
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </div>
                                             <label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                                <select name="band_status" id="band_status" class="form-control">
                                                    <option value="1" <?php if($icon_data['band_status'] == '1'){?> selected <?php } ?>>Active</option> 
                                                    <option value="0" <?php if($icon_data['band_status'] == '0'){?> selected <?php } ?>>Inactive</option> 
                                                </select>
                                            </div>
                                        </div>   
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Band Type<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                               <input type="text" name="band_type" id="band_type" value="icon-band" class="form-control" readonly>
                                            </div>
                                             <label class="col-lg-2 control-label">Band Background Color</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="bg_color" id="bg_color" value="<?=$icon_data['bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            
                                        </div>   
                                        <div class="form-group">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-10">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="is_default" value="1" <?=($icon_data['is_default']==1)?'checked':'';?>> <b>Is Default Theme Band</b></label>
                                                  </div>
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
                                <div id="Nudge-Board" class="tab-pane fade">
                                  <h3>Nudge Board</h3>
                                      <form role="form" class="form-horizontal" id="edit_banner_slider" name="edit_banner_slider" method="post" enctype='multipart/form-data'> 
                                        <input type="hidden" name="band_id"  value="<?php echo $board_data['band_id'];?>" >
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Band Title<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                                <textarea class="form-control" rows="5" id="band_title3" name="band_title"><?php echo $board_data['band_title']?></textarea>
                                            </div>
                                             <label class="col-lg-2 control-label">Band Text Line</label>
                                            <div class="col-lg-4">
                                                 <textarea class="form-control" rows="5" id="band_text3" name="band_text" ><?php echo $board_data['band_text']?></textarea>
                                            </div>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Button1</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="button1" id="button1" value="<?=$board_data['button1']?>" class="form-control" >
                                            </div>
                                            <label class="col-lg-2 control-label">Button1 URL</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="button1_url" id="button1_url" value="<?=$board_data['button1_url']?>" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="col-lg-2 control-label">Font Family</label>
                                            <div class="col-lg-2">
                                                <select name="button1_font_family" id="button1_font_family" class="form-control">
                                                    <?php echo $obj2->getFontFamilyOptions($board_data['button1_font_family']); ?>    
                                                </select>
                                            </div>
                                        
                                            <label class="col-lg-2 control-label">Font Size</label>
                                            <div class="col-lg-2">
                                                <select name="button1_font_size" id="button1_font_size" class="form-control">
                                                    <?php echo $obj2->getFontSizeOptions($board_data['button1_font_size']); ?>    
                                                </select>
                                            </div>
                                            <label class="col-lg-2 control-label">Font Color</label>
                                            <div class="col-lg-2">
                                                <input type="text" name="button1_font_color" id="button1_font_color" value="<?=$board_data['button1_font_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Background Color</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button1_bg_color" id="button1_bg_color" value="<?=$board_data['button1_bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            <label class="col-lg-2 control-label">Icon Code</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button1_icon_code" id="button1_icon_code" value="<?=$board_data['button1_icon_code']?>" class="form-control">
                                            </div>
                                            <label class="col-lg-2 control-label">Button1 Show</label>
                                            <div class="col-lg-2">
                                                <select name="button1_show" id="button1_show" class="form-control">
                                                    <option value="1" <?php if($board_data['button1_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                                    <option value="0" <?php if($board_data['button1_show'] == '0'){?> selected <?php } ?>>No</option> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Button2</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="button2" id="button2" value="<?=$board_data['button2']?>" class="form-control" >
                                            </div>
                                             <label class="col-lg-2 control-label">Button2 URL</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="button2_url" id="button2_url" value="<?=$board_data['button2_url']?>" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="col-lg-2 control-label">Font Family</label>
                                            <div class="col-lg-2">
                                                <select name="button2_font_family" id="button2_font_family" class="form-control">
                                                    <?php echo $obj2->getFontFamilyOptions($board_data['button2_font_family']); ?>    
                                                </select>
                                            </div>
                                        
                                            <label class="col-lg-2 control-label">Font Size</label>
                                            <div class="col-lg-2">
                                                <select name="button2_font_size" id="button2_font_size" class="form-control">
                                                    <?php echo $obj2->getFontSizeOptions($board_data['button2_font_size']); ?>    
                                                </select>
                                            </div>
                                            <label class="col-lg-2 control-label">Font Color</label>
                                            <div class="col-lg-2">
                                                <input type="text" name="button2_font_color" id="button2_font_color" value="<?=$board_data['button2_font_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Background Color</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button2_bg_color" id="button2_bg_color" value="<?=$board_data['button2_bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            <label class="col-lg-2 control-label">Icon Code</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button2_icon_code" id="button2_icon_code" value="<?=$board_data['button2_icon_code']?>" class="form-control">
                                            </div>
                                            <label class="col-lg-2 control-label">Button2 Show</label>
                                            <div class="col-lg-2">
                                                <select name="button2_show" id="button2_show" class="form-control">
                                                    <option value="1" <?php if($board_data['button2_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                                    <option value="0" <?php if($board_data['button2_show'] == '0'){?> selected <?php } ?>>No</option> 
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
                                                        <option value="<?=$i?>" <?php if($board_data['band_row_no'] == $i){?> selected <?php } ?>><?=$i?></option> 
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </div>
                                             <label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                                <select name="band_status" id="band_status" class="form-control">
                                                    <option value="1" <?php if($board_data['band_status'] == '1'){?> selected <?php } ?>>Active</option> 
                                                    <option value="0" <?php if($board_data['band_status'] == '0'){?> selected <?php } ?>>Inactive</option> 
                                                </select>
                                            </div>
                                        </div>   
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Band Type<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                               <input type="text" name="band_type" id="band_type" value="nudge-board" class="form-control" readonly>
                                            </div>
                                             <label class="col-lg-2 control-label">Band Background Color</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="bg_color" id="bg_color" value="<?=$board_data['bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            
                                        </div>   
                                        <div class="form-group">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-10">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="is_default" value="1" <?=($board_data['is_default']==1)?'checked':'';?>> <b>Is Default Band</b></label>
                                                  </div>
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
                                <div id="Fun-tit-bits" class="tab-pane fade">
                                  <h3>Fun tit bits</h3>
                                      <form role="form" class="form-horizontal" id="edit_banner_slider" name="edit_banner_slider" method="post" enctype='multipart/form-data'> 
                                        <input type="hidden" name="band_id"  value="<?php echo $bits_data['band_id'];?>" >
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Band Title<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                                <textarea class="form-control" rows="5" id="band_title3" name="band_title"><?php echo $bits_data['band_title']?></textarea>
                                            </div>
                                             <label class="col-lg-2 control-label">Band Text Line</label>
                                            <div class="col-lg-4">
                                                 <textarea class="form-control" rows="5" id="band_text3" name="band_text" ><?php echo $bits_data['band_text']?></textarea>
                                            </div>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Button1</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="button1" id="button1" value="<?=$bits_data['button1']?>" class="form-control" >
                                            </div>
                                            <label class="col-lg-2 control-label">Button1 URL</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="button1_url" id="button1_url" value="<?=$bits_data['button1_url']?>" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="col-lg-2 control-label">Font Family</label>
                                            <div class="col-lg-2">
                                                <select name="button1_font_family" id="button1_font_family" class="form-control">
                                                    <?php echo $obj2->getFontFamilyOptions($bits_data['button1_font_family']); ?>    
                                                </select>
                                            </div>
                                        
                                            <label class="col-lg-2 control-label">Font Size</label>
                                            <div class="col-lg-2">
                                                <select name="button1_font_size" id="button1_font_size" class="form-control">
                                                    <?php echo $obj2->getFontSizeOptions($bits_data['button1_font_size']); ?>    
                                                </select>
                                            </div>
                                            <label class="col-lg-2 control-label">Font Color</label>
                                            <div class="col-lg-2">
                                                <input type="text" name="button1_font_color" id="button1_font_color" value="<?=$bits_data['button1_font_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Background Color</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button1_bg_color" id="button1_bg_color" value="<?=$bits_data['button1_bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            <label class="col-lg-2 control-label">Icon Code</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button1_icon_code" id="button1_icon_code" value="<?=$bits_data['button1_icon_code']?>" class="form-control">
                                            </div>
                                            <label class="col-lg-2 control-label">Button1 Show</label>
                                            <div class="col-lg-2">
                                                <select name="button1_show" id="button1_show" class="form-control">
                                                    <option value="1" <?php if($bits_data['button1_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                                    <option value="0" <?php if($bits_data['button1_show'] == '0'){?> selected <?php } ?>>No</option> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Button2</label>
                                            <div class="col-lg-4">
                                                <input type="text" name="button2" id="button2" value="<?=$bits_data['button2']?>" class="form-control" >
                                            </div>
                                             <label class="col-lg-2 control-label">Button2 URL</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="button2_url" id="button2_url" value="<?=$bits_data['button2_url']?>" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="col-lg-2 control-label">Font Family</label>
                                            <div class="col-lg-2">
                                                <select name="button2_font_family" id="button2_font_family" class="form-control">
                                                    <?php echo $obj2->getFontFamilyOptions($bits_data['button2_font_family']); ?>    
                                                </select>
                                            </div>
                                        
                                            <label class="col-lg-2 control-label">Font Size</label>
                                            <div class="col-lg-2">
                                                <select name="button2_font_size" id="button2_font_size" class="form-control">
                                                    <?php echo $obj2->getFontSizeOptions($bits_data['button2_font_size']); ?>    
                                                </select>
                                            </div>
                                            <label class="col-lg-2 control-label">Font Color</label>
                                            <div class="col-lg-2">
                                                <input type="text" name="button2_font_color" id="button2_font_color" value="<?=$bits_data['button2_font_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Background Color</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button2_bg_color" id="button2_bg_color" value="<?=$bits_data['button2_bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            <label class="col-lg-2 control-label">Icon Code</label>
                                            <div class="col-lg-2">
                                               <input type="text" name="button2_icon_code" id="button2_icon_code" value="<?=$bits_data['button2_icon_code']?>" class="form-control">
                                            </div>
                                            <label class="col-lg-2 control-label">Button2 Show</label>
                                            <div class="col-lg-2">
                                                <select name="button2_show" id="button2_show" class="form-control">
                                                    <option value="1" <?php if($bits_data['button2_show'] == '1'){?> selected <?php } ?>>Yes</option>   
                                                    <option value="0" <?php if($bits_data['button2_show'] == '0'){?> selected <?php } ?>>No</option> 
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
                                                        <option value="<?=$i?>" <?php if($bits_data['band_row_no'] == $i){?> selected <?php } ?>><?=$i?></option> 
                                                        <?php
                                                    }
                                                    ?> 
                                                </select>
                                            </div>
                                             <label class="col-lg-2 control-label">Status<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                                <select name="band_status" id="band_status" class="form-control">
                                                    <option value="1" <?php if($bits_data['band_status'] == '1'){?> selected <?php } ?>>Active</option> 
                                                    <option value="0" <?php if($bits_data['band_status'] == '0'){?> selected <?php } ?>>Inactive</option> 
                                                </select>
                                            </div>
                                        </div>   
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Band Type<span style="color:red">*</span></label>
                                            <div class="col-lg-4">
                                               <input type="text" name="band_type" id="band_type" value="fun-tit-bits" class="form-control" readonly>
                                            </div>
                                             <label class="col-lg-2 control-label">Band Background Color</label>
                                            <div class="col-lg-4">
                                               <input type="text" name="bg_color" id="bg_color" value="<?=$bits_data['bg_color']?>" class="form-control" data-jscolor="">
                                            </div>
                                            
                                        </div>   
                                        <div class="form-group">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-10">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="is_default" value="1" <?=($bits_data['is_default']==1)?'checked':'';?>> <b>Is Default Band</b></label>
                                                  </div>
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
                              </div>

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

            elements : "band_title1,band_text1,band_title2,band_text2,band_title3,band_text3",

            plugins : "style,advimage,advlink,emotions",

            theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",

            theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",

            theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",

        });



    </script>

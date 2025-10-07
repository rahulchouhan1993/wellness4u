<?php

require_once('config/class.mysql.php');

require_once('classes/class.solutions.php');

require_once('../init.php');

$obj = new Solutions();



$edit_action_id = '259';
//die();

$page_name = 'wellness_solution_items';
list($sub_cat1_value,$sub_cat2_value,$sub_cat3_value,$sub_cat4_value,$sub_cat5_value,$sub_cat6_value,$sub_cat7_value,$sub_cat8_value,$sub_cat9_value,$sub_cat10_value,$prof_cat1_value,$prof_cat2_value,$prof_cat3_value,$prof_cat4_value,$prof_cat5_value,$prof_cat6_value,$prof_cat7_value,$prof_cat8_value,$prof_cat9_value,$prof_cat10_value) = $obj->getFavCatDropdownValueVivek($page_name);

$value=0;
if($prof_cat1_value=='')
{
 $value=$value+1;
}
if($prof_cat2_value=='')
{
 $value=$value+1;
}
if($prof_cat3_value=='')
{
$value=$value+1;
}
if($prof_cat4_value=='')
{
$value=$value+1;
}
if($prof_cat5_value=='')
{
$value=$value+1;
}
if($prof_cat6_value=='')
{
$value=$value+1;
}
if($prof_cat7_value=='')
{
$value=$value+1;
}
if($prof_cat8_value=='')
{
$value=$value+1;
}
if($prof_cat9_value=='')
{
$value=$value+1;
}
if($prof_cat10_value=='')
{
 $value=$value+1;
}
$total_count = 10-$value;


$prof_cat1_value=  explode(',', $prof_cat1_value);
$prof_cat2_value=  explode(',', $prof_cat2_value);
$prof_cat3_value=  explode(',', $prof_cat3_value);
$prof_cat4_value=  explode(',', $prof_cat4_value);
$prof_cat5_value=  explode(',', $prof_cat5_value);
$prof_cat6_value=  explode(',', $prof_cat6_value);
$prof_cat7_value=  explode(',', $prof_cat7_value);
$prof_cat8_value=  explode(',', $prof_cat8_value);
$prof_cat9_value=  explode(',', $prof_cat9_value);
$prof_cat10_value=  explode(',', $prof_cat10_value);

$sub_cat1_value=  explode(',', $sub_cat1_value);
$sub_cat2_value=  explode(',', $sub_cat2_value);
$sub_cat3_value=  explode(',', $sub_cat3_value);
$sub_cat4_value=  explode(',', $sub_cat4_value);
$sub_cat5_value=  explode(',', $sub_cat5_value);
$sub_cat6_value=  explode(',', $sub_cat6_value);
$sub_cat7_value=  explode(',', $sub_cat7_value);
$sub_cat8_value=  explode(',', $sub_cat8_value);
$sub_cat9_value=  explode(',', $sub_cat9_value);
$sub_cat10_value=  explode(',', $sub_cat10_value);
$j=1;

$prof_cat_value[$j]=  implode('\',\'', $prof_cat1_value);
$prof_cat_value[$j+1]=  implode('\',\'', $prof_cat2_value);
$prof_cat_value[$j+2]=  implode('\',\'', $prof_cat3_value);
$prof_cat_value[$j+3]=  implode('\',\'', $prof_cat4_value);
$prof_cat_value[$j+4]=  implode('\',\'', $prof_cat5_value);
$prof_cat_value[$j+5]=  implode('\',\'', $prof_cat6_value);
$prof_cat_value[$j+6]=  implode('\',\'', $prof_cat7_value);
$prof_cat_value[$j+7]=  implode('\',\'', $prof_cat8_value);
$prof_cat_value[$j+8]=  implode('\',\'', $prof_cat9_value);
$prof_cat_value[$j+9]=  implode('\',\'', $prof_cat10_value);

$sub_cat_value[$j]=  implode('\',\'', $sub_cat1_value);
$sub_cat_value[$j+1]=  implode('\',\'', $sub_cat2_value);
$sub_cat_value[$j+2]=  implode('\',\'', $sub_cat3_value);
$sub_cat_value[$j+3]=  implode('\',\'', $sub_cat4_value);
$sub_cat_value[$j+4]=  implode('\',\'', $sub_cat5_value);
$sub_cat_value[$j+5]=  implode('\',\'', $sub_cat6_value);
$sub_cat_value[$j+6]=  implode('\',\'', $sub_cat7_value);
$sub_cat_value[$j+7]=  implode('\',\'', $sub_cat8_value);
$sub_cat_value[$j+8]=  implode('\',\'', $sub_cat9_value);
$sub_cat_value[$j+9]=  implode('\',\'', $sub_cat10_value);



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

$tr_rss_content = 'none';



if(isset($_POST['btnSubmit']))

{
  
    $page = $_POST['page'];
    
    $user_name = $_SESSION['admin_username'];
    
    $user_id = $_SESSION['admin_id'];
    
    if($_POST['user_type']=='Admin')
    {
        $user_type=1;
    }
    else if($_POST['user_type']=='Practitioner')
    {
        $user_type=2;
    }
    else if($_POST['user_type']=='User')
    {
        $user_type=3;
    }
    
    
    $topic_subject = $_POST['topic_subject'];
    
    $narration = $_POST['narration'];
    
    $wellbgn_ref_num = $_POST['wellbgn_ref_num'];
    
    $newkeywords = $_POST['newkeywords'];
    
    $newselected_keywords = $_POST['newselected_keywords'];
    
    $newkeyword_count = $_POST['newkeyword_count'];
    
    $reference_title = $_POST['reference_title'];

    $banner_id = $_POST['hdnbanner_id'];
    
    $keywords = $_POST['keywords'];
    
    $selected_keywords = $_POST['selected_keywords'];
    
    $sol_item_keyword_id = $_POST['sol_item_keyword_id'];
    
    $keyword_count = $_POST['keyword_count'];

    $status = strip_tags(trim($_POST['status']));

    $box_title = strip_tags(trim($_POST['box_title']));

    $box_desc = trim($_POST['box_desc']);

    $banner_type = $_POST['banner_type'];

    $credit_line = strip_tags(trim($_POST['credit_line']));

    $credit_line_url = strip_tags(trim($_POST['credit_line_url']));

    $sound_clip_id = strip_tags(trim($_POST['sound_clip_id'])); 

    $rss_feed_item_id = trim($_POST['rss_feed_item_id']);

    $sol_item_cat_id = trim($_POST['sol_item_cat_id']);

    

	

    if($box_title == "")

    {

        $error = true;

        $err_msg = "Please enter item title.";

    }



    if($banner_type == 'Video')

    {   

        $display_trfile = 'none';

        $display_trtext = '';

        $tr_rss_content = 'none';

        $banner = trim($_POST['banner2']);

        if($banner == '')

        {

            $error = true;

            $err_msg .= '<br>Please enter video url';

        }

    }

    elseif($banner_type == 'rss')

    {

        $display_trfile = 'none';

        $display_trtext = 'none';

        $tr_rss_content = '';

        if($rss_feed_item_id == '')

        {

            $error = true;

            $err_msg .= '<br>Please select rss feed';

        }

    }	

    elseif($banner_type == 'text')

    {

        $display_trfile = 'none';

        $display_trtext = 'none';

        $tr_rss_content = 'none';

    }	

    else

    {  

        $display_trfile = '';

        $display_trtext = 'none';

        $tr_rss_content = 'none';



        if(isset($_FILES['banner']['tmp_name']) && $_FILES['banner']['tmp_name'] != '')

        {

            $banner = $_FILES['banner']['name'];

            $file4 = substr($banner, -4, 4);



            if($banner_type == 'Image')

            {

                if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))

                {

                    $error = true;

                    $err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for banner';

                }	 

                elseif( $_FILES['banner']['type'] != 'image/jpeg' and $_FILES['banner']['type'] != 'image/pjpeg'  and $_FILES['banner']['type'] != 'image/gif' and $_FILES['banner']['type'] != 'image/png' )

                {

                    $error = true;

                    $err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for banner';

                }



                $image_size = $_FILES['banner']['size']/1024;	 

                $max_image_allowed_file_size = 2000; // size in KB

                if($image_size > $max_image_allowed_file_size )

                {

                    $error = true;

                    $err_msg .=  "<br>Size of image file should be less than $max_image_allowed_file_size kb";

                }

            }

            elseif($banner_type == 'Flash')

            {

                if(($file4 != '.swf')and($file4 != '.SWF'))

                {

                    $error = true;

                    $err_msg .= '<br>Please Upload Only(swf) files for banner ';

                }	 

                elseif( $_FILES['banner']['type'] != 'application/x-shockwave-flash'  )

                {

                    $error = true;

                    $err_msg .= '<br>Please Upload Only(swf) files for banner';

                }



                $flash_size = $_FILES['banner']['size']/1024;

                $max_flash_allowed_file_size = 2000; // size in KB

                if($flash_size > $max_flash_allowed_file_size )

                {

                    $error = true;

                    $err_msg .=  "<br>Size of flash file should be less than $max_flash_allowed_file_size kb";

                }

            }

            elseif($banner_type == 'Audio')

            {   

                if(($file4 != '.mp3')and($file4 != '.wav') and ($file4 !='.MP3') and ($file4 != '.WAV') and ($file4 !='.mid') and ($file4 != '.MID'))

                {

                    $error = true;

                    $err_msg .= '<br>Please Upload Only(mp3/wav/mid) files for banner ';

                }



                $banner_size = $_FILES['banner']['size']/1024;	 

                $max_allowed_file_size = 200000; // size in KB

                if($banner_size > $max_allowed_file_size )

                {

                    $error = true;

                    $err_msg .=  "<br>Size of audio file should be less than $max_allowed_file_size kb";

                }	 

            }

            elseif($banner_type == 'Pdf')

            {   

                if(($file4 != '.pdf')and($file4 != '.PDF'))

                {

                    $error = true;

                    $err_msg .= '<br>Please Upload Only(pdf) files for banner ';

                }

                $banner_size = $_FILES['banner']['size']/1024;	 

                $max_audio_allowed_file_size = 2000; // size in KB

                if($banner_size > $max_audio_allowed_file_size )

                {

                    $error = true;

                    $err_msg .=  "<br>Size of pdf file should be less than $max_audio_allowed_file_size kb";

                }

            }



            if(!$error)

            {	

                $banner = time()."_".$banner;

                $temp_dir = SITE_PATH.'/uploads/';

                $temp_file = $temp_dir.$banner;



                if(!move_uploaded_file($_FILES['banner']['tmp_name'], $temp_file)) 

                {

                    if(file_exists($temp_file)) { unlink($temp_file); } // Remove temp file

                    $error = true;

                    $err_msg .= '<br>Couldn\'t Upload banner 1';

                    $banner = trim($_POST['hdnbanner']);

                }

            }

            else

            {

                $banner = '';

            }

        }  

        else

        {

            $banner = trim($_POST['hdnbanner']);

            $file4=substr($banner, -4, 4);



            if($banner_type == 'Image')

            {

                if(($file4 != '.jpg')and($file4 != '.JPG') and ($file4 !='jpeg') and ($file4 != 'JPEG') and ($file4 !='.gif') and ($file4 != '.GIF') and ($file4 !='.png') and ($file4 != '.PNG'))

                {

                    $error = true;

                    $err_msg .= '<br>Please Upload Only(jpg/gif/jpeg/png) files for banner';

                }

            }

            elseif($banner_type == 'Flash')

            {

                if(($file4 != '.swf')and($file4 != '.SWF'))

                {

                    $error = true;

                    $err_msg .= '<br>Please Upload Only(swf) files for banner ';

                }

            }

            elseif($banner_type == 'Audio')

            {

                if(($file4 != '.mp3')and($file4 != '.wav') and ($file4 !='.MP3') and ($file4 != '.WAV') and ($file4 !='.mid') and ($file4 != '.MID'))

                {

                        $error = true;

                        $err_msg .= '<br>Please Upload Only(mp3/wav/mid) files for banner ';

                }

            }	 

            elseif($banner_type == 'Pdf')

            {

                if(($file4 != '.pdf')and($file4 != '.PDF'))

                {

                    $error = true;

                    $err_msg .= '<br>Please Upload Only(pdf) files for banner ';

                }

            }	 

        }

    }

    

    if($sol_item_cat_id == '')

    {

        $error = true;

        $err_msg .= "<br>Please select category.";

    }



    if(!$error)

    {  

        if($obj->updateSolutionItem($topic_subject,$narration,$user_name,$user_id,$user_type,$wellbgn_ref_num,$newkeywords,$newselected_keywords,$newkeyword_count,$reference_title,$keywords,$selected_keywords,$sol_item_keyword_id,$keyword_count,$banner_id,$status,$box_title,$banner_type,$banner,$box_desc,$credit_line,$credit_line_url,$sound_clip_id,$rss_feed_item_id,$sol_item_cat_id))

        {

            $msg = "Record Edited Successfully!";	

            header('location: index.php?page='.$page.'&mode=wellness_solution_items&msg='.urlencode($msg));

        }

        else

        {

            $error = true;

            $err_msg = "Currently there is some problem.Please try again later.";

        }

    }	

}


else if(isset($_GET['id']))

{
  
   
	$banner_id = $_GET['id'];

	//echo $bannerid;
       
        
	list($topic_subject,$narration,$wellbgn_ref_num,$user_type,$user_name,$reference_title,$image_id,$page_name,$box_title,$banner_type,$box_desc,$banner,$status,$credit_line,$credit_line_url,$sound_clip_id,$rss_feed_item_id,$sol_item_cat_id) = $obj->getSolutionItemDetails($banner_id);
//        print_r($wellbgn_ref_num);die();
         if(isset($_GET['name'])!='')
            {
              $page_name_value=$_GET['name'];
            }
            else
            {
                
              $page_name_value=$page_name;
            }
            
        $page_name_data[]=$page_name_value;
//        $page_name_data[]='wellness_solution_items';
        $page_name_data_implode=implode('\',\'',$page_name_data);
           
        
        $keyworddata = $obj->getKeywordDataByPageNameAndIdDetails($banner_id,$page_name_data_implode);
        
//        echo '<pre>';
//        print_r($page_name_data_implode);
//        echo '</pre>';
//        die();
//        $title = $obj->getTitleNameByIdVivek($image_id);
        
    if($_GET['name']=='fav_categories')
    {
      $reference_title = $obj->getTitleNameByIdVivek($image_id);
    }
    else if($_GET['name']=='main_symptoms')
    {
      $reference_title = $obj->getTitleNameByIdFromBodymainsymptomVivek($image_id);
    }        
	

//        if($box_title == '')
//
//        {
//
//            header('location: index.php?mode=wellness_solution_items');
//
//            exit(0);
//
//        }
//
//        

	if($banner_type == 'Video')

	{

            $display_trfile = 'none';

            $display_trtext = '';

            $tr_rss_content = 'none';

	}

        elseif($banner_type == 'rss')

        {

            $display_trfile = 'none';

            $display_trtext = 'none';

            $tr_rss_content = '';

        }

        elseif($banner_type == 'text')

        {

            $display_trfile = 'none';

            $display_trtext = 'none';

            $tr_rss_content = 'none';

        }	

	else

	{

            $display_trfile = '';

            $display_trtext = 'none';

            $tr_rss_content = 'none';

	}

}

else

{

    header('location: index.php?mode=wellness_solution_items');

}	



?>

<script src="js/AC_ActiveX.js" type="text/javascript"></script>

<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>

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

	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">

	<tbody>

		<tr>

			<td>

				<table border="0" width="100%" cellpadding="0" cellspacing="0">

				<tbody>

					<tr>

						<td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>

						<td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>

						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Wellness Solution Item </td>

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

							<form action="#" method="post" name="frmedit_sressbuster" id="frmedit_sressbuster" enctype="multipart/form-data" >

							<input type="hidden" name="hdnbanner_id" value="<?php echo $banner_id;?>" />

                            <input type="hidden" name="box_title" value="<?php echo $box_title;?>" />

                            <input type="hidden" name="box_desc" value="<?php echo $box_desc;?>" />

                            <input type="hidden" name="credit_line" value="<?php echo $credit_line;?>" />

                            <input type="hidden" name="hdnbanner" value="<?php echo stripslashes($banner);?>" />
                            
                            <input type="hidden" name="page" id="page" value="<?php echo $_GET['page'];?>" />

							<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">

							<tbody>
<tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>
                                                            
                                    <tr>    
                                        <td align="right"><strong>Reference Number</strong></td>

                                      
                                        <td align="center"><strong>:</strong></td>
                                             <td align="left">

                                            <input type="text"  id="wellbgn_ref_num" name="wellbgn_ref_num" value="<?php echo $wellbgn_ref_num; ?>"  style="width:200px;"/>

                                   	</td>
                                        

                                    </tr>
                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

							<tr>    
                                        <td align="right"><strong>User Type</strong></td>

                                      
                                        <td align="center"><strong>:</strong></td>
                                             <td align="left">

                                                 <?php if($user_type=='1') 
                                                 {
                                                     $user_type_value='Admin';
                                                 }
                                                else if($user_type=='2') 
                                                 {
                                                     $user_type_value='Practitioner';
                                                 }
                                                else if($user_type=='3') 
                                                 {
                                                     $user_type_value='User';
                                                 }?>
                                            <input type="text"  id="user_type" name="user_type" value="<?php echo $user_type_value; ?>" readonly style="width:200px;"/>

                                   	</td>
                                        

                                    </tr>
                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

<tr>    
                                        <td align="right"><strong>User Name</strong></td>

                                      
                                        <td align="center"><strong>:</strong></td>
                                             <td align="left">

                                            <input type="text"  id="user_name" name="user_name" value="<?php echo $user_name; ?>" readonly style="width:200px;"/>

                                   	</td>
                                        

                                    </tr>
                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>	

                                 <tr>

									<td width="20%" align="right"><strong>Status</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left"><select id="status" name="status">

                                    								<option value="1" <?php if($status == '1'){ ?> selected <?php } ?>>Active</option>

                                                                    <option value="0" <?php if($status == '0'){ ?> selected <?php } ?>>Inactive</option>

                                                                    </select></td>

								</tr>
                                                                
                                                                <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                     <tr>

                                        <td align="right"><strong>Reference Page Name</strong></td>

                                      
                                        <td align="center"><strong>:</strong></td>
                                             <td align="left">

                                            <input type="text"  id="page_name" name="page_name" value="<?php echo $page_name; ?>" readonly style="width:200px;"/>

                                   	</td>
                                    </tr>
                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>    
                                        <td align="right"><strong>Reference Title</strong></td>

                                      
                                        <td align="center"><strong>:</strong></td>
                                             <td align="left">

                                            <input type="text"  id="reference_title" name="reference_title" value="<?php echo $reference_title; ?>" readonly style="width:200px;"/>

                                   	</td>
                                        

                                    </tr>
                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td width="20%" align="right"><strong>Topic/Subject</strong></td>

                                        <td width="5%" align="center"><strong>:</strong></td>

                                        <td width="75%" align="left"><input type="text"  id="topic_subject" name="topic_subject" value="<?php echo $topic_subject; ?>" style="width:600px;"/></td>

                                    </tr>
                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td align="right" valign="top"><strong>Narration</strong></td>

                                        <td align="center" valign="top"><strong>:</strong></td>

                                        
                                        <td align="left"><textarea id="narration" style="width:500px; height: 250px;" name="narration" ><?php echo $narration; ?></textarea></td>
                                       
                                    </tr>
                                   
                                    <tr>

                                        <td colspan="3" align="center">&nbsp;</td>

                                    </tr>


                                
								<tr>

									<td width="20%" align="right"><strong>Box Title</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left"><input type="text" id="box_title" name="box_title" value="<?php echo $box_title; ?>" onmouseout="getKewordAllDataFromFavCatTabByBoxDesAndBoxTitle();" style="width:600px;"/></td>

								</tr>

                                <tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right"><strong>Credit Line</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left"><input type="text" style="width:600px;"  id="credit_line" name="credit_line" value="<?php echo $credit_line; ?>"/></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                <tr>

									<td width="20%" align="right"><strong>Credit Line URL</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left"><input type="text" style="width:600px;" id="credit_line_url" name="credit_line_url" value="<?php echo $credit_line_url; ?>"/></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right"><strong>Banner Type</strong></td>

									<td width="5%" align="center"><strong>:</strong></td>

									<td width="75%" align="left">

										<select name="banner_type" id="banner_type" onChange="BannerBox1()">

											<?php echo $obj->getSolutionItemTypeOptions($banner_type); ?>

										</select>

									</td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right" valign="top"><strong>Banner</strong></td>

									<td width="5%" align="center" valign="top"><strong>:</strong></td>

									<td width="75%" align="left">

									<?php 

                                                                        if($banner_type == 'rss')

                                                                        {

                                                                            

                                                                        }

                                                                        else 

                                                                        {

									if($banner != '')

									{  

										if($banner_type == 'Image')

										{ ?>

										<img border="0" src="<?php echo SITE_URL.'/uploads/'. $banner;?>" width="100" height="100"  /> 

							        	<?php

										}		

										elseif($banner_type == 'Flash')

										{ 

										  ?>

										<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" WIDTH="<?php echo $width; ?>" HEIGHT="<?php echo $height; ?>" id="myMovieName">

											<PARAM NAME=movie VALUE="<?php echo SITE_URL.'/uploads/'. $banner;?>">

											<PARAM NAME=quality VALUE=high>

											<param name="wmode" value="transparent">

											<EMBED src="<?php echo SITE_URL.'/uploads/'. $banner; ?>" quality=high WIDTH="<?php echo $width; ?>" HEIGHT="<?php echo $height; ?>" wmode="transparent" NAME="myMovieName" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>

										</OBJECT>

										<?php

										}

										 elseif($banner_type == 'Video')

										{   ?>

                                         <iframe width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="<?php echo $obj->getStressBusterBannerString($banner); ?>" frameborder="0" allowfullscreen></iframe>

										<?php

										}

										 elseif($banner_type == 'Audio')

										{   ?>

                                      	 <embed type="application/x-shockwave-flash" flashvars="audioUrl=<?php echo SITE_URL.'/uploads/'. $banner;?>" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="300" height="27" quality="best"></embed>

                                        <?php

										}

                                                                                elseif($banner_type == 'Pdf')

										{   ?>

                                         <a href="<?php echo SITE_URL.'/uploads/'. $banner;?>" target="_blank"><?php echo $banner;?></a> 

                                        <?php

										}

									}

                                                                        }

                                                                        ?>

									</td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr id="trfile" style="display:<?php echo $display_trfile;?>">

									<td width="20%" align="right" valign="top">&nbsp;</td>

									<td width="5%" align="center" valign="top">&nbsp;</td>

									<td width="75%" align="left">

										<input type="file" name="banner" id="banner" />

									</td>

								</tr>

								<tr id="trtext" style="display:<?php echo $display_trtext;?>">

									<td width="20%" align="right" valign="top">&nbsp;</td>

									<td width="5%" align="center" valign="top">&nbsp;</td>

									<td width="75%" align="left">

										<input type="text" name="banner2" id="banner2" value="<?php echo $banner;?>" />

									</td>

								</tr>

                                                                <tr id="tr_rss_content" style="display:<?php echo $tr_rss_content;?>">

                                        <td align="right"><strong>Rss Feeds</strong></td>

                                        <td align="center"><strong>:</strong></td>

                                        <td align="left">

                                            <select name="rss_feed_item_id" id="rss_feed_item_id" onchange="getDescriptionDataVivek();return false;" style="width:400px;">

                                                <option value="">Select Rss Feed</option>

                                                <?php echo $obj->getRssFeedOptions($rss_feed_item_id); ?>

                                            </select>

                                   	</td>

                                    </tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

                                 <tr>

									<td width="20%" align="right" valign="top"><strong>Sound Clip</strong></td>

									<td width="5%" align="center" valign="top"><strong>:</strong></td>

									<td width="75%" align="left"><select name="sound_clip_id" id="sound_clip_id" onchange="Playsound(sound_clip_id)">

                                                                    <option value="">Select Music File </option>

                                    								<?php echo $obj->getSoundClipOptions($sound_clip_id); ?>

                                                                    </select>

                                                                    <div id="playmusic"></div></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

								<tr>

									<td width="20%" align="right" valign="top"><strong>Box Description</strong></td>

									<td width="5%" align="center" valign="top"><strong>:</strong></td>

                                                                        <td width="75%" align="left"><textarea id="box_desc" style="width:500px; height: 250px;" name="box_desc" onmouseout="getKewordAllDataFromFavCatTabByBoxDesAndBoxTitle();"><?php echo $box_desc; ?></textarea></td>

								</tr>

								<tr>

									<td colspan="3" align="center">&nbsp;</td>

								</tr>

<!--                                                                <tr>

                                                                    <td align="right" valign="top"><strong>Category</strong></td>

                                                                    <td align="center" valign="top"><strong>:</strong></td>

                                                                    <td align="left">

                                                                        <select name="sol_item_cat_id" id="sol_item_cat_id" style="width:200px;" >

                                                                            <option value="" <?php if($sol_item_cat_id == ''){ ?> selected="" <?php } ?>>Select Category</option>

                                                                            <?php echo $obj->getSolutionCategoryOptions($sol_item_cat_id );?>

                                                                        </select>

                                                                    </td>

                                                                </tr>-->

                                                                            <?php for($i=0;$i<1;$i++) {  $prof_cat_value[$i+1]?>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                   
                                    <tr>
                                        
                                        <td align="right" valign="top"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Sub Category<?php echo $i+1 ;?>:&nbsp;&nbsp;</strong></td>
                                        <td align="center" valign="top"><strong>:</strong></td>

                                        <td align="left" >
                                            <select name="sol_item_cat_id" id="sol_item_cat_id" style="width:250px; ">
                                                <?php echo $obj->getFavCategoryViveks($prof_cat_value[$i+1],$sub_cat_value[$i+1],$sol_item_cat_id)?>
                                            </select>
                                        </td>
                                       
                                    </tr>
                                    
                                   
                                   
                                    <?php }?>
                                    <tr >
                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>
                                                                </tr>
                              <input type="hidden"  id="keyword_count" name="keyword_count" value="<?php echo count($keyworddata); ?>"/>

                                    <?php 
                                   
                                        for($j=0;$j<count($keyworddata);$j++) {
                                                                    
                                                                  ?>   
                                                                <tr>
                                                                    <td align="right" valign="top"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keywords:</strong></td>
                                                                    <td align="center" valign="top"><strong>:</strong></td>
                                                                    <td align="left" >
                                                                        <input name="sol_item_keyword_id[]" type="hidden" id="sol_item_keyword_id" value="<?php echo$keyworddata[$j]['sol_item_keyword_id'];?>">
                                                                    
                                                                    <input name="keywords[]" type="text" id="keywords" value="<?php echo $keyworddata[$j]['keyword_name'];?>"   style="width:150px; height: 25px;">&nbsp;&nbsp;
                                                                    <input name="selected[]" type="checkbox" id="selected_<?php echo $j;?>"   onchange="checkDataSelectedOrNot(<?php echo $j;?>);" <?php if($keyworddata[$j]['selected_keyword']=='active') { echo 'checked';}?>>
                                                                    <input name="selected_keywords[]" type="hidden" id="selected_keywords_<?php echo $j;?>" value="<?php echo $keyworddata[$j]['selected_keyword'];?>">
                                                                     
                                                                    </td>
                                                                    
                                                                </tr>
                                                                 <tr>
                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>
                                                                </tr>
                                                                
                                                                 <?php
                                        
                                        
                                        }?>

                                                                <tr id="databox">
                                                                   
                                                                </tr> 
                                                                <tr>

                                                                    <td colspan="3" align="center">&nbsp;</td>

                                                                </tr>

								<tr>

									<td>&nbsp;</td>

									<td>&nbsp;</td>

									<td align="left">

                                            <input type="Submit" name="btnSubmit" value="Submit" />&nbsp;
<?php // echo $_GET['page'];die();?>
                                            <input type="button" name="btnCancel" value="Cancel" onclick="window.location.href='index.php?page=<?php echo $_GET['page'];?>&mode=wellness_solution_items'">

                                        </td>

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
        
<script>
    
     function getDescriptionDataVivek()
      {
        
	var rss_feed_item_id = $("#rss_feed_item_id").val();
        //var sub_cat = $("#fav_cat_id_"+idval).val();
//        alert(rss_feed_item_id);
	var dataString = 'action=getdescriptiondataoption&rss_feed_item_id='+rss_feed_item_id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
//			alert(result);
                        //alert(sub_cat);
			$("#box_desc").html(result);
		}
	});
}
function checkNewDataSelectedOrNot(id)
        {
             if ($('#newselected_'+id).is(":checked"))
           {
               var val='active';
            $('#newselected_keywords_'+id).val(val);
           }
           else
           { 
                var val='inactive';
             $('#newselected_keywords_'+id).val(val);
           }
           
//            var selected_keywords=$('#selected_keywords_'+id).val();
//            alert(selected_keywords);
        } 
  function checkDataSelectedOrNot(id)
        {
             if ($('#selected_'+id).is(":checked"))
           {
               
               var val='active';
            $('#selected_keywords_'+id).val(val);
           }
           else
           { 
                var val='inactive';
             $('#selected_keywords_'+id).val(val);
           }
           
//            var selected_keywords=$('#selected_keywords_'+id).val();
//            alert(selected_keywords);
        }

function getKewordAllDataFromFavCatTabByBoxDesAndBoxTitle()
      {
       
	var box_desc = $("#box_desc").val();
        var box_title = $("#box_title").val();
        var rss_feed_item_id = $("#rss_feed_item_id").val();
       
	var dataString = 'action=getkeyworddataoption&box_desc_data='+box_desc+'&box_title='+box_title+'&rss_feed_item_id='+rss_feed_item_id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
//			alert(result);
                        //alert(sub_cat);
			$("#databox").html(result);
		}
	});
}
 
 $( document ).ready(function() {
        var box_desc = $("#box_desc").val();
        var box_title = $("#box_title").val();
        var rss_feed_item_id = $("#rss_feed_item_id").val();
//        var page_name = 'wellness_solution_items';
	var dataString = 'action=getkeyworddataoption&box_desc_data='+box_desc+'&box_title='+box_title+'&rss_feed_item_id='+rss_feed_item_id;
	$.ajax({
		type: "POST",
		url: "include/remote.php",
		data: dataString,
		cache: false,
		success: function(result)
		{
//			alert(result);
                        //alert(sub_cat);
			$("#databox").html(result);
		}
	});
 });
 </script>
 
 <script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			mode : "exact",
			theme : "advanced",
			elements : "narration,box_desc",
			plugins : "style,advimage,advlink,emotions",
			theme_advanced_buttons1 : "bold,italic,underline,indicime,indicimehelp,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,outdent,indent,|,forecolor,backcolor",
			theme_advanced_buttons3 : "blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview",
		});
	</script>
 
</div>
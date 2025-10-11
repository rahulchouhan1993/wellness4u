<?php

require_once('config/class.mysql.php');

require_once('classes/class.scrollingwindows.php');

$obj = new Scrolling_Windows();


//add by ample 07-04-20
require_once('classes/class.contents.php'); 
$obj2 = new Contents();
$add_action_id = '158';

$edit_action_id = '159';



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

$arr_fav_cat_type_id = array();

$arr_fav_cat_id = array();

if(isset($_POST['btnSubmit']))

{

    $page =$_POST['page'];

    

    $fav_cat_id = $_POST['hdnfav_cat_id'];

    

    $id =$_POST['hdnfav_id'];

    

    $fav_cat_type_id = strip_tags(trim($_POST['fav_cat_type_id']));

    

    $fav_cat_id_parent = $_POST['fav_cat_id'];

    $fav_cat_id_parent_name = $obj->getFavCategoryNameRamakant($fav_cat_id_parent);

    

    $fav_cat = strip_tags(trim($_POST['fav_cat']));

    

    $fav_cat_keyword_data =$_POST['fav_cat_keyword_data'];

    

    $all_keyword_data = $fav_cat_id_parent_name.','.$fav_cat.''.$fav_cat_keyword_data;

    $all_keyword_data_explode=explode(',',$all_keyword_data);

    

    $sol_item_id = $_POST['sol_item_id'];  

    

    $fav_cat_status = strip_tags(trim($_POST['fav_cat_status']));

    $cat_status = strip_tags(trim($_POST['status']));

    $fav_code = strip_tags(trim($_POST['fav_code']));

    $uom = $_POST['uom'];  

    $comment = $_POST['comment'];   

    $show_hide = strip_tags(trim($_POST['show_hide']));   


    //add by ample 07-04-20
    $link = $_POST['link'];
    $ref_table = $_POST['ref_table'];
    $group_code = $_POST['group_code']; 
    $wellbgn_ref_num = $_POST['wellbgn_ref_num'];
    if (is_array($wellbgn_ref_num) && !empty($wellbgn_ref_num)) {
        $wellbgn_ref_num_implode = implode(',', $wellbgn_ref_num);
    } else {
        $wellbgn_ref_num_implode = '';
    }
    //add by ample 23-04-20
    $page_icon=trim($_POST['page_icon']);
    $page_icon_type=trim($_POST['page_icon_type']);

    $data_view_url=trim($_POST['data_view_url']); //add by ample 28-04-20

    if($fav_cat == '')

    {

        $error = true;

        $err_msg = 'Please enter category';

    }

    elseif($obj->chkIfFavCategoryAlreadyExists_Edit($fav_cat,$fav_cat_id,$str_fav_cat_type_id))

    {

        $error = true;

        $err_msg = 'Category is already exist';

    }



    if(!$error)

    {
            //update by ample 
        if($obj->updatefavCategory($all_keyword_data_explode,$sol_item_id,$fav_code,$uom,$comment,$id,$fav_cat_id,$fav_cat_id_parent,$fav_cat,$fav_cat_type_id,$cat_status,$fav_cat_status,$show_hide,$link,$ref_table,$group_code,$wellbgn_ref_num_implode,$page_icon,$page_icon_type,$data_view_url))

        {

            $msg = "Record Updated Successfully!";

            header('location: index.php?page='.$page.'&mode=fav_categories&msg='.urlencode($msg));

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

    $fav_cat_id = $_GET['id'];

    //list($fav_cat,$fav_cat_type_id,$fav_cat_status) = $obj->getFavCategoryDetails($fav_cat_id);

    //update by ample 

    list($sol_item_id,$fav_code,$fav_cat,$fav_cat_type_id,$cat_status,$fav_parent_cat,$show_hide,$favcat_id,$fav_cat_status,$comment,$uom,$link,$ref_table,$group_code_id,$ref_num,$page_icon,$page_icon_type,$data_view_url) = $obj->getFavCategoryDetailsRamakant($fav_cat_id);




    $favcat_id = $obj->getBmsIdFromSymtumsCustomCategoryTableViveks($fav_cat_id);

    $FavCategory = $obj->getSymtumsCustomCategoryAllDataViveks($favcat_id,$_GET['id']);

     foreach($FavCategory as $rec)

     {

       $fav_cat_id_data[]=$rec['fav_cat_type_id'];

       $sub_cat_id_data[]=$rec['fav_parent_cat'];

     }

   

    if (is_array($fav_cat_id_data) && !empty($fav_cat_id_data)) {
        $fav_cat_id_data_implode = implode("','", $fav_cat_id_data);
    } else {
        $fav_cat_id_data_implode = '';
    }
    
    if (is_array($sub_cat_id_data) && !empty($sub_cat_id_data)) {
        $sub_cat_id_data_implode = implode("','", $sub_cat_id_data);
    } else {
        $sub_cat_id_data_implode = '';
    }


     $fav_cat_name=$obj->getSubCatNameByProfileCatIdFromFavCatTableVivek($fav_cat_id_data_implode,$sub_cat_id_data_implode);

     $fav_cat_name_implode=implode(',',$fav_cat_name);

     			

    if($fav_cat == '')

    {

        header('location: index.php?mode=fav_categories');	

    }	

}	

else

{

    header('location: index.php?mode=fav_categories');

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

    ?>

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

						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Category</td>

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

							<form action="#" method="post" name="frmedit_daily_meal" id="frmedit_daily_meal" enctype="multipart/form-data" >

							<input type="hidden" name="hdnfav_cat_id" id="hdnfav_cat_id" value="<?php echo $favcat_id;?>" />

                                                        <input type="hidden" name="hdnfav_id" id="hdnfav_cat_id" value="<?php echo $fav_cat_id;?>" />

                                                        <input type="hidden" name="sol_item_id" id="sol_item_id" value="<?php echo $sol_item_id;?>">

				                        <input type="hidden" name="fav_cat_keyword_data" id="fav_cat_keyword_data" value="<?php echo $fav_cat_name_implode;?>">

	                                                <input type="hidden" name="page" id="page" value="<?php echo $_GET['page'];?>" />



                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0">

							<tbody>

                                                                <tr>

                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>

                                                                </tr>

                                                                 <tr>

                                                                    <td colspan="10" height="30" align="left" valign="middle">

                                                                      <table>

                                                                          

                                                                          

                                                                            <tr>

                                                                                <td width="70%" align="left" valign="top"><strong>Fav Code:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                                                                                <td width="20%" align="center" valign="top">

                                                                                <input name="fav_code" type="text" id="fav_code" value="<?php echo $fav_code; ?>" style="width:150px; height: 23px;" >

                                                                                </td>

                                                                              

                                                                                

                                                                               

                                                                            </tr>

                                                                       </table>

                                                                    </td>

                                                                </tr>

                                                                <tr>

                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>

                                                                </tr>

                                                               

                                                                <tr>

                                                                                <td width="15%" height="30" align="left" valign="middle"><strong>Category:</strong></td>

                                                                                <td width="15%" height="30" align="left" valign="middle"><input name="fav_cat" type="text" id="fav_cat" value="<?php echo $fav_cat; ?>" style="width:150px; height: 23px;" required=""></td>

                                                                               <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;UOM(Units Of Measurment):</strong></td>

                                                                                <td width="15%" height="30" align="left" valign="middle">

                                                                                    <select name="uom" id="uom" style="width:150px; height: 23px;">

                                                                                        <?php $arr_cucat_parent_cat_id=23; echo $obj->getFavCategoryRamakant($arr_cucat_parent_cat_id,$uom)?>

                                                                                    </select>

                                                                                </td>

                                                                                <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Comment:</strong></td>

                                                                                <td width="15%" height="30" align="left" valign="middle">

                                                                                    <textarea name="comment" type="text" id="comment"  style="width:150px; height: 23px;" required=""><?php echo $comment; ?></textarea>



                                                                                </td>

                                                                                <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Status:&nbsp;&nbsp;</strong></td>

                                                                                

                                                                                <td width="10%" height="30" align="left" valign="middle">

                                                                                    <select name="fav_cat_status" id="fav_cat_status" style="width:150px; height: 23px;" required="">

                                                                                        <option value="1" <?php if($fav_cat_status == 1) { echo 'selected'; } ?> >Active</option>

                                                                                        <option value="0" <?php if($fav_cat_status == 0) { echo 'selected'; } ?>>InActive</option>

                                                                                    </select>

                                                                                </td>

                                                                      

                                                                </tr>

                                                                 <tr>


                                        <td width="10%" height="30" align="left" valign="middle"><strong>Link:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                          <input type="text"  id="link" name="link" style="width:150px;" value="<?php echo $link; ?>"/>

                                        </td>

                                        

                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;Reference Table:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                             <select name="ref_table" id="ref_table" style="width:150px; " onchange="GetRefNumber('<?=$ref_num?>','<?=$group_code_id?>'); getgrupdropdown('<?=$group_code_id?>');"  class="tbl_link">


                                                 <!-- add by ample 08-11-19 -->
                                                 <?php echo $obj2->getTableNameFrom_tbltabldropdown('8',$ref_table); ?>


                                            </select>

                                        </td>

                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Group Code:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                             <select name="group_code" id="group_code" style="width:150px;"  onchange="GetRefNumberbyGroup('<?=$group_code_id?>','<?=$ref_num?>');">
                                                <option value="">Select</option>

                                            </select>
                                           

                                        </td>


                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;Reference Number:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                             <select name="wellbgn_ref_num[]" id="wellbgn_ref_num" style="width:150px; " multiple >

                                                    <!-- <option value="">Select Reference Number</option> -->

                                            </select>
                                           

                                        </td>

                                    </tr>

                                    <!--add by ample 23-04-20 -->
                                    <tr>

                                        <td width="10%" height="30" align="left" valign="middle"><strong>Page Icon:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('IMG',0,'page_icon');">Gallery 1</button>
                                            <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('OT',0,'page_icon');">Gallery 2</button>
                                            <?php 
                                                $banner_name=$banner_file="";
                                                if(!empty($page_icon_type))
                                                {
                                                    if($page_icon_type=='Image')
                                                    {
                                                        $banner_data=$obj2->get_data_from_tblicons('',$page_icon);
                                                        $banner_name=$banner_data[0]['icons_name'];
                                                        $banner_file=$banner_data[0]['image'];
                                                    }
                                                    else
                                                    {
                                                        $banner_data=$obj2->get_data_from_tblmindjumble('',$page_icon);
                                                        $banner_name=$banner_data[0]['box_title'];
                                                        $banner_file=$banner_data[0]['box_banner'];
                                                    }
                                                }
                                            ?>
                                            <?php 
                                            if(!empty($banner_file))
                                            {

                                                    ?>
                                                    <a href="<?php echo SITE_URL.'/uploads/'. $banner_file;?>" target="_blank"><?php echo $banner_file;?></a> 
                                                    <?php
                                            }
                                            ?>
                                        </td>

                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="hidden" name="page_icon" id="page_icon"  value="<?=$page_icon?>" readonly />
                                            <input type="text" name="page_icon_type" id="page_icon_type" value="<?=$page_icon_type?>" readonly/>
                                        </td>

                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text"  id="page_icon_name" value="<?=$banner_name;?>" disabled/>
                                        </td>

                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text"  id="page_icon_file" value="<?=$banner_file;?>" disabled />
                                        </td>

                                        <td width="10%" height="30" align="left" valign="middle">
                                           <button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData('page_icon');">Reset</button>
                                        </td>

                                        <td width="10%" height="30" align="left" valign="middle"><strong>Data View URL:</strong></td>
                                        <td width="10%" height="30" align="left" valign="middle">
                                            <input type="text"  id="data_view_url" name="data_view_url" style="width:150px;" value="<?php echo $data_view_url; ?>"/>
                                        </td>

                                    </tr>


                                                                <tr>

                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>

                                                                </tr>

								 

                                                               <tr>

                                                                    <td width="15%" height="30" align="left" valign="middle"><strong>Profile Category:</strong></td>

                                                                    <td width="15%" height="30" align="left" valign="middle">

                                                                        <select  name="fav_cat_type_id" id="fav_cat_type_id" onchange="getMainCategoryOptionAddMore()" style="width:150px; height: 23px;" required="">

                                                                            <option value="">Select Type</option>

                                                                            <?php echo $obj->getFavCategoryTypeOptions($fav_cat_type_id);?>

                                                                        </select>

                                                                    </td>

                                                                    <td width="15%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;fav Category:</strong></td>

                                                                    <td width="15%" height="30" align="left" valign="middle">

                                                                        <select name="fav_cat_id" id="fav_cat_id" style="width:150px; height: 23px;">

                                                                            <?php echo $obj->getFavCategoryRamakant($fav_cat_type_id,$fav_parent_cat)?>

                                                                        </select>

                                                                    </td>

                                                                    <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td>

                                                                    <td width="10%" height="30" align="left" valign="middle">

                                                                        <select name="show_hide" id="show_hide" style="width:150px; height: 23px;" required="">

                                                                            <?php echo $obj->getShowHideOption($show_hide); ?>

                                                                        </select>

                                                                    </td>

                                                                    

                                                                    <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Status:&nbsp;&nbsp;</strong></td>

                                                                    <td width="10%" height="30" align="left" valign="middle">

                                                                        <select name="status" id="status" style="width:150px; height: 23px;" required="">

                                                                            <option value="1" <?php if($cat_status == 1) { echo 'selected'; } ?> >Active</option>

                                                                            <option value="0" <?php if($cat_status == 0) { echo 'selected'; } ?>>InActive</option>

                                                                        </select>

                                                                    </td>

                                                                </tr>

                                                            

								<tr>

									<td colspan="10" align="center" valign="top">&nbsp;</td>

								</tr>

                                <tr>

                                    <td align="left">
                                        <a href="index.php?mode=update_banner_favcategory&favcat_id=<?=$favcat_id;?>&custom_fav_id=<?=$fav_cat_id;?>"><button type="button" class="btn btn-info btn-xs">Banner Setting</button></a>
                                    </td>

                                </tr>

                                                                <tr>

									<td>&nbsp;</td>

									<td>&nbsp;</td>

                                                                        <td>&nbsp;</td>

									<td>&nbsp;</td>

									<td align="left" valign="top"><input type="Submit" name="btnSubmit" value="Submit" /></td>

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

function getMainCategoryOptionAddMore()

{

        

	var parent_cat_id = $("#fav_cat_type_id").val();

        //var sub_cat = $("#fav_cat_id_"+idval).val();

        //alert(parent_cat_id);

	var dataString = 'action=getmaincategoryoption&parent_cat_id='+parent_cat_id;

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


function GetRefNumber(selected="",group_code="")
{   
    var table_name = $("#ref_table").val();
    var dataString = 'action=getrefnumber&table_name='+table_name+'&selected='+selected+'&group_code='+group_code;

    $.ajax({
        type: "POST",
        url: "include/remote.php",
        data: dataString,
        cache: false,
        success: function(result)
        {
           // alert(result);
            $("#wellbgn_ref_num").html(result);
        }

    });  

}



function getgrupdropdown(selected="")
{
    var table_name = $("#ref_table").val();
    var dataString = 'action=getgrupdropdown&table_name='+table_name+'&selected='+selected;
    $.ajax({
            type: "POST",
            url: "include/remote.php",
            data: dataString,
            cache: false,
            success: function(result)
            {   
                
                    $("#group_code").html(result);
            }

    });        
}


function GetRefNumberbyGroup(selected_group_code="",selected="")
{   

        var table_name = $("#ref_table").val();
        var group_code = $("#group_code").val();

        // if(selected_group_code)
        // {
        //     selected=selected_group_code;
        // }

    var dataString = 'action=getrefnumber&table_name='+table_name+'&group_code='+group_code+'&selected='+selected;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

            $("#wellbgn_ref_num").html(result);

        }

    });     
}

$(document).ready(function()
    {
       $('.tbl_link').trigger('change');
    });


        </script>

</div>
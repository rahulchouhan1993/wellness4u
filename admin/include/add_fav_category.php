<?php

require_once('config/class.mysql.php');

require_once('classes/class.scrollingwindows.php');

$obj = new Scrolling_Windows();



//add by ample 07-04-20
require_once('classes/class.contents.php'); 
$obj2 = new Contents();
$add_action_id = '158';



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



$arr_fav_cat_type_id = array();

$arr_fav_cat_id = array();



$cat_cnt = 0;

$cat_total_cnt = 1;



$arr_cucat_parent_cat_id = array('');

$arr_cucat_cat_id = array('');

$arr_cucat_show = array('');

$show_hide = array();



if(isset($_POST['btnSubmit']))

{

    $fav_cat = strip_tags(trim($_POST['fav_cat']));

    $comment = $_POST['comment'];

    $uom = $_POST['uom'];

    $fav_code = $_POST['fav_code'];

     
    //$fav_cat_type_id = strip_tags(trim($_POST['fav_cat_type_id']));

    $show_hide = $_POST['show_hide'];

    $arr_cucat_parent_cat_id = $_POST['fav_cat_type_id'];

    $arr_cucat_cat_id = $_POST['fav_cat_id'];

    $cat_total_cnt = $_POST['cat_total_cnt'];


    //add by ample 07-04-20
    $link = $_POST['link'];
    $ref_table = $_POST['ref_table'];
    $group_code = $_POST['group_code']; 
    $wellbgn_ref_num = $_POST['wellbgn_ref_num'];
    $wellbgn_ref_num_implode = implode(',',$wellbgn_ref_num);

    //add by ample 23-04-20
    $page_icon=trim($_POST['page_icon']);
    $page_icon_type=trim($_POST['page_icon_type']);

    $data_view_url=trim($_POST['data_view_url']); //add by ample 28-04-20
    

//    echo '<pre>';

//    print_r($arr_cucat_parent_cat_id);

//    echo '</pre>';

//    die();

    

    

//    foreach ($_POST['fav_cat_type_id'] as $key => $value) 

//	{$cat_total_cnt

//		array_push($arr_fav_cat_type_id,$value);

//	}

//	

//	foreach ($_POST['fav_cat_id'] as $key => $value) 

//	{

//		array_push($arr_fav_cat_id,$value);

//	}

//    

//        

//     if($arr_fav_cat_type_id[0] == '')

//        {

//                $str_fav_cat_type_id = '';

//        }

//        else

//        {

//                $str_fav_cat_type_id = implode(',',$arr_fav_cat_type_id);

//        }

//    

//       if($arr_fav_cat_id[0] == '')

//        {

//                $str_fav_cat_id = '';

//        }

//        else

//        {

//           $str_fav_cat_id = implode(',',$arr_fav_cat_id);

//        }    

        

    

    if($fav_cat == '')

    {

        $error = true;

        $err_msg = 'Please enter category';

    }

    

    

//    elseif($obj->chkIfFavCategoryAlreadyExists($fav_cat,$str_fav_cat_type_id))

//    {

//        $error = true;

//        $err_msg = 'Category is already exist';

//    }

//    

//    if($str_fav_cat_type_id == '')

//    {

//        $error = true;

//        $err_msg .= '<br>Please enter profile category';

//    }

//   

//    if($show_hide == '')

//    {

//        $error = true;

//        $err_msg .= '<br>Please select show/hide';

//    }

    

    if(!$error)

    {
        //update by ample
        if($obj->addFavCategory($fav_code,$uom,$comment,$fav_cat,$arr_cucat_parent_cat_id,$arr_cucat_cat_id,$show_hide,$cat_total_cnt,$link,$ref_table,$group_code,$wellbgn_ref_num_implode,$page_icon,$page_icon_type,$data_view_url))

        {

            $msg = "Record Added Successfully!";

            header('location: index.php?mode=fav_categories&msg='.urlencode($msg));

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

    $fav_cat = '';

    $fav_cat_type_id = '';

}



//$add_more_row_cat_str = 'abcdddd';

$add_more_row_cat_str = '<tr id="row_cat_\'+cat_cnt+\'"><td width="10%" height="30" align="left" valign="middle" style="padding-top: 10px; padding-bottom:10px"><strong>Profile Category:</strong></td><td width="14%" height="30" align="left" valign="middle"><select  name="fav_cat_type_id[]" id="fav_cat_type_id_\'+cat_cnt+\'" onchange="getMainCategoryOptionAddMore(\'+cat_cnt+\')" style="width:150px; height: 23px;">'.$obj->getFavCategoryTypeOptions('').'</select></td><td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;fav Category:</strong></td><td width="15%" height="30" align="left" valign="middle"><select name="fav_cat_id[]" id="fav_cat_id_\'+cat_cnt+\'" style="width:150px; height: 23px;">'.$obj->getFavCategoryRamakant('','').'</select></td><td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td><td width="15%" height="30" align="left" valign="middle"><select name="show_hide[]" id="show_hide_\'+cat_cnt+\'" style="width:150px; height: 23px;">'.$obj->getShowHideOption('').'</select></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(\'+cat_cnt+\');"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td></tr>';

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

						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Category</td>

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

							<p class="err_msg"><?php if(isset($_GET['msg']) && $_GET['msg'] != '' ) { echo urldecode($_GET['msg']); }?></p>

							<div id="pagination_contents" align="center"> 

								<p>

                                <form action="#" method="post" name="frm_place" id="frm_place" enctype="multipart/form-data" AUTOCOMPLETE="off">

                                <input type="hidden" name="cat_cnt" id="cat_cnt" value="<?php echo $cat_cnt;?>">

				<input type="hidden" name="cat_total_cnt" id="cat_total_cnt" value="<?php echo $cat_total_cnt;?>">

                                <table border="0" width="100%" cellpadding="0" cellspacing="0">

                                <tbody>

                                      <tr>

                                                                    <td colspan="10" height="30" align="left" valign="middle">

                                                                      <table>

                                                                          

                                                                          

                                                                            <tr>

                                                                                <td width="55%" align="left" valign="top"><strong>Fav Code:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></td>

                                                                                

                                                                                <td width="20%" align="center" valign="top">

                                                                                <input name="fav_code" type="text" id="fav_code" value="<?php echo $fav_code; ?>" style="width:150px; height: 23px;" required="">

                                                                                </td>

                                                                              

                                                                                

                                                                               

                                                                            </tr>

                                                                       </table>

                                                                    </td>

                                                                </tr>

                                                                <tr>

                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>

                                                                </tr>

                                    <tr>


                                        <td width="10%" height="30" align="left" valign="middle"><strong>Category:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                           <input name="fav_cat" type="text" id="fav_cat" value="<?php echo $fav_cat; ?>" style="width:150px; height: 23px;" required="">

                                        </td>

                                        

                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;UOM(Units Of  Measurment):</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                            <select name="uom" id="uom" style="width:150px; height: 23px;">

                                                <?php echo $obj->getFavCategoryRamakant('23',$fav_cat_id)?>

                                            </select>

                                        </td>

                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Comment:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                            <textarea name="comment" type="text" id="comment"  style="width:150px; height: 23px;" ></textarea>

                                           

                                        </td>

                                    </tr>

                                    <tr>


                                        <td width="10%" height="30" align="left" valign="middle"><strong>Link:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                          <input type="text"  id="link" name="link" style="width:150px;" value="<?php echo $link; ?>"/>

                                        </td>

                                        

                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;Reference Table:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                             <select name="ref_table" id="ref_table" style="width:150px; " onchange="GetRefNumber(); getgrupdropdown();">


                                                 <!-- add by ample 08-11-19 -->
                                                 <?php echo $obj2->getTableNameFrom_tbltabldropdown('8'); ?>


                                            </select>

                                        </td>

                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Group Code:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                             <select name="group_code" id="group_code" style="width:150px;"  onchange="GetRefNumberbyGroup();">
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
                                        </td>

                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="hidden" name="page_icon" id="page_icon" readonly />
                                            <input type="text" name="page_icon_type" id="page_icon_type" readonly/>
                                        </td>

                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text"  id="page_icon_name" disabled/>
                                        </td>

                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text"  id="page_icon_file" disabled />
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

                                    

                                    <?php

                                    for($i=0;$i<$cat_total_cnt;$i++)

                                    { ?>

                                    

                                    <tr id="row_cat_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">

                                        <td width="10%" height="30" align="left" valign="middle"><strong>Profile Category:</strong></td>

                                        <td width="14%" height="30" align="left" valign="middle">

                                            <select  name="fav_cat_type_id[]" id="fav_cat_type_id_<?php echo $i;?>" onchange="getMainCategoryOptionAddMore(<?php echo $i;?>)" style="width:150px; height: 23px;" required="">

<!--                                                <option value="">Select Type</option>-->

                                                <?php  echo $obj->getFavCategoryTypeOptions($arr_cucat_parent_cat_id[$i]);?>

                                            </select>

                                        </td>

                               

                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;fav Category:</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                            <select name="fav_cat_id[]" id="fav_cat_id_<?php echo $i;?>" style="width:150px; height: 23px;">

                                                <?php echo $obj->getFavCategoryRamakant($arr_cucat_parent_cat_id[$i],$arr_cucat_cat_id[$i])?>

                                            </select>

                                        </td>

                                        <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td>

                                        <td width="15%" height="30" align="left" valign="middle">

                                            <select name="show_hide[]" id="show_hide_<?php echo $i;?>" style="width:150px; height: 23px;" required="">

                                                <?php echo $obj->getShowHideOption($arr_cucat_show[$i]); ?>

                                            </select>

                                        </td>

                            

                                        <?php

                                            if($i == 0)

                                            { ?>

                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="addMoreRowCategory();"><img src="images/add.gif" width="10" height="8" border="0" />Add More</a></td>

                                            <?php  	

                                            }

                                            else

                                            { ?>

                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(<?php echo $i;?>);"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td>

                                                    

                                            <?php	

                                            }

                                            ?>

                                        

                                    </tr>

                                    <tr>

                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>

                                    </tr>

                                    

                                    <?php  	

                                    } ?>

                                    <tr>

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

    function addMoreRowCategory()

    {

            var cat_cnt = parseInt($("#cat_cnt").val());

            cat_cnt = cat_cnt + 1;

            //alert("cat_cnt"+cat_cnt);

            $("#row_cat_first").after('<?php echo $add_more_row_cat_str;?>');

            $("#cat_cnt").val(cat_cnt);



            var cat_total_cnt = parseInt($("#cat_total_cnt").val());

            cat_total_cnt = cat_total_cnt + 1;

            $("#cat_total_cnt").val(cat_total_cnt);

    }

    function removeRowCategory(idval)

    {

            //alert("row_cat_"+idval);

            $("#row_cat_"+idval).remove();



            var cat_total_cnt = parseInt($("#cat_total_cnt").val());

            cat_total_cnt = cat_total_cnt - 1;

            $("#cat_total_cnt").val(cat_total_cnt);

    }

    

 function getMainCategoryOptionAddMore(idval)

{

        

	var parent_cat_id = $("#fav_cat_type_id_"+idval).val();

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

			$("#fav_cat_id_"+idval).html(result);

		}

	});

}


function GetRefNumber()

{
        var table_name = $("#ref_table").val();
        var group_code = $("#group_code").val();
        
    var dataString = 'action=getrefnumber&table_name='+table_name+'&group_code='+group_code;

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

function getgrupdropdown()
{
    var table_name = $("#ref_table").val();
    var dataString = 'action=getgrupdropdown&table_name='+table_name;

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

function GetRefNumberbyGroup()
{
        var table_name = $("#ref_table").val();
        var group_code = $("#group_code").val();

    var dataString = 'action=getrefnumber&table_name='+table_name+'&group_code='+group_code;

    $.ajax({

        type: "POST",

        url: "include/remote.php",

        data: dataString,

        cache: false,

        success: function(result)

        {

                        //alert(result);

                        

            $("#wellbgn_ref_num").html(result);

        }

    });     
}


    

</script>

</div>
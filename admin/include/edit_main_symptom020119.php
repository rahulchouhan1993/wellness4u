<?php
require_once('config/class.mysql.php');
require_once('classes/class.bodyparts.php');

$obj = new BodyParts();
require_once('classes/class.solutions.php');
$obj2 = new Solutions();
$edit_action_id = '229';

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

//$data = $obj->getKeywordNameformBodySymptomVivek($arr_cucat_cat_id='');
$fav_cat_type_id='16,15,10,37,2,45,42,53,55';
$fav_cat_type_id_explode = explode(',',$fav_cat_type_id); 
$fav_cat_type_id_implode = implode('\',\'',$fav_cat_type_id_explode);
$data = $obj->getKeywordNameformFavCatVivek($fav_cat_type_id_implode);
$tdata='"'.implode('","',$data).'"';

$error = false;
$err_msg = "";


 
if(isset($_POST['btnSubmit']))
{
        $page =$_POST['page'];
	$id = $_POST['hdnbms_id'];
        $sol_item_id = $_POST['sol_item_id']; 
	$bms_name = strip_tags(trim($_POST['bms_name']));
        $comment = $_POST['comment']; 
        $sym_code = $_POST['sym_code']; 
        
        $symptom_id = $_POST['hdnsymptom_id'];
        $fav_cat_type_id = strip_tags(trim($_POST['fav_cat_type_id']));
        $fav_cat_id_parent = $_POST['fav_cat_id'];
        $show_hide = strip_tags(trim($_POST['show_hide']));  
        $symtum_status = $_POST['symtum_status'];  
        
//        $fav_cat_keyword_data = $_POST['fav_cat_keyword_data'];
       
        $keywords = $_POST['keywords'];
        $key_fav_cat_type_id = $_POST['key_fav_cat_type_id'];
        $key_fav_cat_id = $_POST['key_fav_cat_id'];
        $sub_cat_link = $_POST['sub_cat_link'];
        //$cat_total_cnt1 = $_POST['cat_total_cnt1'];
        
//        $keywords_implode=implode(',',$keywords);
        
//        $keywordsold = $_POST['keywordsold'];
//        $keywordsold_implode=implode(',',$keywordsold);
        
//        $fav_cat_id_parent_name = $obj->getFavCategoryNameRamakant($fav_cat_id_parent);
//        $all_keyword_data = $fav_cat_keyword_data.','.$keywordsold_implode.','.$bms_name.''.$keywords_implode.','.$fav_cat_id_parent_name;
//        $all_keyword_data_explode=explode(',',$all_keyword_data);
//        
//        $cat_total_cnt1 = $_POST['cat_total_cnt1'];
//       
//        $total_count = $_POST['total_count'];
//        $symptom_keyword_id = $_POST['symptom_keyword_id'];
//        $explode_symptom_keyword_id=  explode(',', $symptom_keyword_id);
        
        
	if($bms_name == '')
	{
            $error = true;
            $err_msg = 'Please enter symptom';
	}
     
	if(!$error)
	{
//            if($obj->updateMainSymptom($all_keyword_data_explode,$sol_item_id,$cat_total_cnt1,$keywords,$explode_symptom_keyword_id,$sym_code,$id,$bms_name,$keywordsold,$total_count,$comment,$hdnbmsid,$fav_cat_type_id,$fav_cat_id_parent,$show_hide,$symtum_status))
            if($obj->updateMainSymptom($id,$sol_item_id,$bms_name,$keywords,$sym_code,$symptom_id,$fav_cat_type_id,$fav_cat_id_parent,$comment,$show_hide,$symtum_status,$key_fav_cat_type_id,$key_fav_cat_id,$sub_cat_link))
            {
                $msg = "Record Updated Successfully!";
                header('location: index.php?page='.$page.'&mode=main_symptoms&msg='.urlencode($msg));
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
	$bms_id = $_GET['id'];
	list($sol_item_id,$sym_code,$bms_name,$symptom_id,$fav_cat_type_id,$fav_parent_cat,$keywords,$symtum_status,$show_hide,$comment) = $obj->getMainSymptomDetailsRamakant($bms_id);
	
        $keyword_data = $obj->getkeyworddata($symptom_id);
        $cat_cnt1 = count($keyword_data)-1;
        $cat_total_cnt1 = count($keyword_data);
        if($bms_name == '')
	{
		header('location: index.php?mode=main_symptoms');	
	}
}	
else
{
        $cat_cnt1 = 0;
        $cat_total_cnt1 = 1;
	header('location: index.php?mode=main_symptoms');
}

$add_more_row_cat_str1 = '<tr id="row_cats_\'+cat_cnt1+\'"><td width="10%" height="30" align="left" valign="middle" style="padding-top: 10px; padding-bottom:10px"><strong>Keywords:</strong></td><td width="14%" height="30" align="left" valign="middle"><input type ="text" name="keywords[]" id="keywords_\'+cat_cnt1+\'" onkeyup="suggestionsearch(\'+cat_cnt1+\');"  style="width:150px; height: 23px;"/></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory1(\'+cat_cnt1+\');"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td></tr>';

//$add_more_row_cat_str = '<tr id="row_cat_\'+cat_cnt+\'"><td width="10%" height="30" align="left" valign="middle" style="padding-top: 10px; padding-bottom:10px"><strong>Profile Category:</strong></td><td width="14%" height="30" align="left" valign="middle"><select  name="fav_cat_type_id[]" id="fav_cat_type_id_\'+cat_cnt+\'" onchange="getMainCategoryOptionAddMore(\'+cat_cnt+\')" style="width:150px; height: 23px;">'.$obj->getFavCategoryTypeOptions('').'</select></td><td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;fav Category:</strong></td><td width="15%" height="30" align="left" valign="middle"><select name="fav_cat_id[]" id="fav_cat_id_\'+cat_cnt+\'" style="width:150px; height: 23px;">'.$obj->getFavCategoryRamakant('','').'</select></td><td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td><td width="15%" height="30" align="left" valign="middle"><select name="show_hide[]" id="show_hide_\'+cat_cnt+\'" style="width:150px; height: 23px;">'.$obj2->getShowHideOption('').'</select></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(\'+cat_cnt+\');"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td></tr>';
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Edit Symptom</td>
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
							<form action="#" method="post" name="frmedit_my_relation" id="frmedit_my_relation" enctype="multipart/form-data" >
							<input type="hidden" name="hdnbms_id" id="hdnbms_id" value="<?php echo $bms_id;?>" />
                                                        <input type="hidden" name="hdnsymptom_id" id="hdnsymptom_id" value="<?php echo $symptom_id;?>" />
                                                        <!--<input type="hidden" name="total_count" id="total_count" value="<?php echo count($total_count);?>" />-->
                                                        <input type="hidden" name="symptom_keyword_id" id="symptom_keyword_id" value="<?php echo $symptom_keyword_id_implode;?>" />
                                                        <input type="hidden" name="cat_total_cnt1" id="cat_total_cnt1" value="<?php echo $cat_total_cnt1;?>">
                                                        <input type="hidden" name="cat_cnt1" id="cat_cnt1" value="<?php echo $cat_cnt1;?>">
				                        <input type="hidden" name="sol_item_id" id="sol_item_id" value="<?php echo $sol_item_id;?>">
				                        <input type="hidden" name="fav_cat_keyword_data" id="fav_cat_keyword_data" value="<?php echo $fav_cat_keyword_data;?>">
				                        <input type="hidden" name="page" id="page" value="<?php echo $_GET['page'];?>" />
                                                        <table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" id="tblrow">
							<tbody>
                                                             <tr>
                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                
                                                                   
                                                                                <td width="10%" align="left" valign="top"><strong>Symptom Code</strong></td>
                                                                                <td width="10%" align="left" valign="top"><input name="sym_code" type="text" id="sym_code" value="<?php echo $sym_code; ?>" style="width:150px; height: 23px;" ></td>
                                                                                <td width="10%" align="left" valign="top"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Symptom:</strong></td>
                                                                                <td width="10%" align="left" valign="top"><input name="bms_name" type="text" id="bms_name" value="<?php echo $bms_name; ?>" style="width:150px; height: 23px;" required=""></td>
                                                                                <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Comment:</strong></td>
                                                                                <td width="15%" height="30" align="left" valign="middle">
                                                                                    <textarea name="comment" type="text" id="comment"  style="width:150px; height: 23px;" ><?php echo $comment; ?></textarea>

                                                                                </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td width="10%" height="30" align="left" valign="middle"><strong>Profile Category:</strong></td>
                                                                    <td width="10%" height="30" align="left" valign="middle">
                                                                        <select  name="fav_cat_type_id" id="fav_cat_type_id" onchange="getMainCategoryOptionAddMore()" style="width:150px; height: 23px;" required="">
                                                                            <option value="">Select Type</option>
                                                                            <?php echo $obj->getFavCategoryTypeOptions($fav_cat_type_id);?>
                                                                        </select>
                                                                    </td>
                                                                    <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;fav Category:</strong></td>
                                                                    <td width="10%" height="30" align="left" valign="middle">
                                                                        <select name="fav_cat_id" id="fav_cat_id" style="width:150px; height: 23px;">
                                                                            <?php echo $obj->getFavCategoryRamakant($fav_cat_type_id,$fav_parent_cat)?>
                                                                        </select>
                                                                    </td>
                                                                    <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td>
                                                                    <td width="10%" height="30" align="left" valign="middle">
                                                                        <select name="show_hide" id="show_hide" style="width:150px; height: 23px;" required="">
                                                                            <?php echo $obj->getShowHideOption($show_hide); ?>
                                                                        </select>
                                                                    </td>
                                                                    
                                                                    <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;Status:&nbsp;&nbsp;</strong></td>
                                                                    <td width="10%" height="30" align="left" valign="middle">
                                                                        <select name="symtum_status" id="symtum_status" style="width:150px; height: 23px;" required="">
                                                                            <option value="1" <?php if($symtum_status == 1) { echo 'selected'; } ?> >Active</option>
                                                                            <option value="0" <?php if($symtum_status == 0) { echo 'selected'; } ?>>InActive</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                
                                                                
                                                                <tr>
                                                                    <td colspan="10" height="30" align="left" valign="middle">&nbsp;</td>
                                                                </tr>
                                                                <tr>
									<td colspan="10" align="center" valign="top">&nbsp;</td>
								</tr>
                                                                <?php
                                                                    if(count($keyword_data)>0)
                                                                    {
                                                                    for($i=0;$i<count($keyword_data);$i++)
                                                                    { ?>
                                    
                                        <tr id="row_cats_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">
                                        <td width="5%" height="30" align="left" valign="middle"><strong>Suggestions cat:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select  name="key_fav_cat_type_id[]" id="key_fav_cat_type_id_<?php echo $i;?>" onchange="getMainCategoryOptionAddMoreKey(<?php echo $i;?>)" style="width:150px; height: 23px;" >
                                                
                                                <?php  echo $obj->getFavCategoryTypeOptions($keyword_data[$i]['key_prof_cat']);?>
                                            
                                            </select>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle"><strong>Suggestions Fav:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="key_fav_cat_id[]" id="key_fav_cat_id_<?php echo $i;?>" style="width:150px; height: 23px;">
                                                <?php echo $obj->getFavCategoryRamakant($keyword_data[$i]['key_prof_cat'],$keyword_data[$i]['key_sub_cat'])?>
                                            </select>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle"><strong>Link:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="sub_cat_link[]" id="sub_cat_link_<?php echo $i;?>" style="width:150px; height: 23px;">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($keyword_data[$i]['fetch_link'] == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($keyword_data[$i]['fetch_link'] == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($keyword_data[$i]['fetch_link'] == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($keyword_data[$i]['fetch_link'] == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle"><strong>Keywords:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input name="keywords[]" type="text" id="keywords_<?php echo $i;?>" value="<?php echo $keyword_data[$i]['keywords'];?>" onkeyup="autocompleteSportsTeams(<?php echo $i;?>); return false;" style="width:150px; height: 25px;">
                                        </td>
                                        
                                        
                                        <?php
                                            if($i == 0)
                                            { ?>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="addMoreRowCategory1();"><img src="images/add.gif" width="10" height="8" border="0" />Add More</a></td>
                                            <?php  	
                                            }
                                            else
                                            { ?>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory1(<?php echo $i;?>);"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td>
                                                    
                                            <?php	
                                            }
                                            ?>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    
                                    <?php  	
                                    } 
                                                                    }
                                                                    else
                                                                    {
                                                                       for($i=0;$i<count($cat_total_cnt1);$i++)
                                                                    { ?>
                                    
                                                                            <tr id="row_cats_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">
                                                                            <td width="5%" height="30" align="left" valign="middle"><strong>Suggestions cat:</strong></td>
                                                                            <td width="15%" height="30" align="left" valign="middle">
                                                                                <select  name="key_fav_cat_type_id[]" id="key_fav_cat_type_id_<?php echo $i;?>" onchange="getMainCategoryOptionAddMoreKey(<?php echo $i;?>)" style="width:150px; height: 23px;" >

                                                                                    <?php  echo $obj->getFavCategoryTypeOptions($keyword_data[$i]['key_prof_cat']);?>

                                                                                </select>
                                                                            </td>
                                                                            <td width="5%" height="30" align="left" valign="middle"><strong>Suggestions Fav:</strong></td>
                                                                            <td width="15%" height="30" align="left" valign="middle">
                                                                                <select name="key_fav_cat_id[]" id="key_fav_cat_id_<?php echo $i;?>" style="width:150px; height: 23px;">
                                                                                    <?php echo $obj->getFavCategoryRamakant($keyword_data[$i]['key_prof_cat'],$keyword_data[$i]['key_sub_cat'])?>
                                                                                </select>
                                                                            </td>
                                                                            <td width="5%" height="30" align="left" valign="middle"><strong>Link:</strong></td>
                                                                            <td width="15%" height="30" align="left" valign="middle">
                                                                                <select name="sub_cat_link[]" id="sub_cat_link_<?php echo $i;?>" style="width:150px; height: 23px;">
                                                                                    <option value="">Select</option>
                                                                                    <option value="tbl_bodymainsymptoms" <?php if($keyword_data[$i]['fetch_link'] == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                                                    <option value="tblsolutionitems" <?php if($keyword_data[$i]['fetch_link'] == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                                                    <option value="tbldailymealsfavcategory" <?php if($keyword_data[$i]['fetch_link'] == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                                                    <option value="tbldailyactivity" <?php if($keyword_data[$i]['fetch_link'] == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                                                                </select>
                                                                            </td>
                                                                            <td width="5%" height="30" align="left" valign="middle"><strong>Keywords:</strong></td>
                                                                            <td width="15%" height="30" align="left" valign="middle">
                                                                                <input name="keywords[]" type="text" id="keywords_<?php echo $i;?>" value="<?php echo $keyword_data[$i]['keywords'];?>" onkeyup="autocompleteSportsTeams(<?php echo $i;?>); return false;" style="width:150px; height: 25px;">
                                                                            </td>


                                                                            <?php
                                                                                if($i == 0)
                                                                                { ?>
                                                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="addMoreRowCategory1();"><img src="images/add.gif" width="10" height="8" border="0" />Add More</a></td>
                                                                                <?php  	
                                                                                }
                                                                                else
                                                                                { ?>
                                                                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory1(<?php echo $i;?>);"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td>

                                                                                <?php	
                                                                                }
                                                                                ?>

                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                                                        </tr>

                                                                        <?php  	
                                                                        } 
                                                                    }
                                                                ?>
                                                                
								<tr>
									<td colspan="10" align="center" valign="top">&nbsp;</td>
								</tr>
                                                 
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
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
        
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
      $( document ).ready(function(){
          $("#keywords_id").hide();
          $("#row_keywords_id2").hide();
          
          
      });
      
function addMoreRowCategory1()
    {
//            var cat_cnt1 = parseInt($("#cat_cnt1").val());
//            cat_cnt1 = cat_cnt1 + 1;
//            //alert("cat_cnt"+cat_cnt);
//            $("#row_cats_first").after('<?php echo $add_more_row_cat_str1;?>');
//            $("#cat_cnt1").val(cat_cnt1);
//
//            var cat_total_cnt1 = parseInt($("#cat_total_cnt1").val());
//            cat_total_cnt1 = cat_total_cnt1 + 1;
//            $("#cat_total_cnt1").val(cat_total_cnt1);

var cat_cnt1 = parseInt($("#cat_cnt1").val());
            cat_cnt1 = cat_cnt1 + 1;
            //alert("cat_cnt"+cat_cnt);
            var new_row ='<tr><td colspan="10" align="center" valign="top">&nbsp;</td></tr>'+
                          '<tr id="row_cats_'+cat_cnt1+'">'+
                                '<td width="5%" height="30" align="left" valign="middle"><strong>Suggestions cat:</strong></td>'+
                                '<td width="15%" height="30" align="left" valign="middle">'+
                                    '<select  name="key_fav_cat_type_id[]" id="key_fav_cat_type_id_'+cat_cnt1+'" onchange="getMainCategoryOptionAddMoreKey('+cat_cnt1+')" style="width:150px; height: 23px;" >'+

                                        '<?php  echo $obj->getFavCategoryTypeOptions('');?>'+
                                   '</select>'+
                               '</td>'+
                               '<td width="5%" height="30" align="left" valign="middle"><strong>Suggestions fav:</strong></td>'+
                                        '<td width="15%" height="30" align="left" valign="middle">'+
                                            '<select name="key_fav_cat_id[]" id="key_fav_cat_id_'+cat_cnt1+'" style="width:150px; height: 23px;">'+
                                                '<?php echo $obj->getFavCategoryRamakant('','')?>'+
                                           '</select>'+
                                        '</td>'+
                                '<td width="5%" height="30" align="left" valign="middle"><strong>Link:</strong></td>'+
                                        '<td width="15%" height="30" align="left" valign="middle">'+
                                            '<select name="sub_cat_link[]" id="sub_cat_link_'+cat_cnt1+'" style="width:150px; height: 23px;">'+
                                                '<option value="">Select</option>'+
                                                '<option value="tbl_bodymainsymptoms">tbl_bodymainsymptoms</option>'+
                                                '<option value="tblsolutionitems">tblsolutionitems</option>'+
                                                '<option value="tbldailymealsfavcategory" >tbldailymealsfavcategory</option>'+
                                                '<option value="tbldailyactivity">tbldailyactivity</option>'+
                                            '</select>'+
                                        '</td>'+
                                         '<td width="5%" height="30" align="left" valign="middle"><strong>Keywords:</strong></td>'+
                                        '<td width="15%" height="30" align="left" valign="middle">'+
                                            '<input name="keywords[]" type="text" id="keywords_'+cat_cnt1+'" onkeyup="autocompleteSportsTeams('+cat_cnt1+'); return false;" style="width:150px; height: 25px;">'+
                                        '</td>'+
                                        '<td>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory1('+cat_cnt1+');"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td></tr>'
                ;
            
            $("#row_cats_first").after(new_row);
            $("#cat_cnt1").val(cat_cnt1);

            var cat_total_cnt1 = parseInt($("#cat_total_cnt1").val());
            cat_total_cnt1 = cat_total_cnt1 + 1;
            $("#cat_total_cnt1").val(cat_total_cnt1);

    }
    function removeRowCategory1(idval)
    {
            //alert("row_cat_"+idval);
            $("#row_cats_"+idval).remove();

            var cat_total_cnt1 = parseInt($("#cat_total_cnt1").val());
            cat_total_cnt1 = cat_total_cnt1 - 1;
            $("#cat_total_cnt1").val(cat_total_cnt1);
    }
    
    
function suggestionsearchold(num) {
//    alert(num);
    var availableTags = [
        <?php echo $tdata; ?>
    ];


    $( "#keywordsold_"+num).autocomplete({
      source: availableTags
    });
//    $( "#interpretaion_"+num).val()
  
  }
function suggestionsearch(num) {
//    alert(num);
    var availableTags = [
        <?php echo $tdata; ?>
    ];


    $( "#keywords_"+num).autocomplete({
      source: availableTags
    });
//    $( "#interpretaion_"+num).val()
  
  }  
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

function getMainCategoryOptionAddMoreKey(idval)
{
        
	var parent_cat_id = $("#key_fav_cat_type_id_"+idval).val();
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
			$("#key_fav_cat_id_"+idval).html(result);
		}
	});
} 

function loadSportsTeams(num){
    //Gets the name of the sport entered.
    //var sportSelected= $("#sport").val();
    var key_prof_cat_id = $("#key_fav_cat_type_id_"+num).val();
    var key_subcat_id = $("#key_fav_cat_id_"+num).val();
    var link = $("#sub_cat_link_"+num).val();
    //alert(key_subcat_id);
    var teamList = "";
    var dataString = 'action=getkeywordsuggestions&key_prof_cat_id='+key_prof_cat_id+'&key_subcat_id='+key_subcat_id+'&link='+link;
    $.ajax({
            url: "include/remote.php?",
            data: dataString,
            type: "POST",
            async: false
            //data: { sport: sportSelected}
     }).done(function(teams){
         //alert(teams);
        teamList = teams.split(',');
        
     });
    //Returns the javascript array of sports teams for the selected sport.
  return teamList;
}


function autocompleteSportsTeams(num){
  var teams = loadSportsTeams(num);
  $("#keywords_"+num).autocomplete({
    source: teams
  });
}
</script>
</div>

<?php
require_once('config/class.mysql.php');
require_once('classes/class.bodyparts.php');
require_once('classes/class.scrollingwindows.php');

$obj = new BodyParts();

$obj2 = new Scrolling_Windows();

$add_action_id = '228';

//print_r($_SESSION);
//$fav_cat_type_id='16,15,10,37,2,45,42,53,55';
//$fav_cat_type_id_explode = explode(',',$fav_cat_type_id); 
//$fav_cat_type_id_implode = implode('\',\'',$fav_cat_type_id_explode);
//$data = $obj->getKeywordNameformFavCatVivek($fav_cat_type_id_implode);
//echo '<pre>';
//print_r($data);
//echo '</pre>';
//die();
//$tdata='"'.implode('","',$data).'"';

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

$cat_cnt1 = 0;
$cat_total_cnt1 = 1;

$arr_cucat_parent_cat_id = array('');
$arr_cucat_cat_id = array('');
$arr_cucat_show = array('');
$show_hide = array();


if(isset($_POST['btnSubmit']))
{
	$bms_name = strip_tags(trim($_POST['bms_name']));
	//$bmst_id = trim($_POST['bmst_id']);
	$daily_code = $_POST['daily_code'];
        $comment = $_POST['comment'];
        $show_hide = $_POST['show_hide'];
        $arr_cucat_parent_cat_id = $_POST['fav_cat_type_id'];
        $arr_cucat_cat_id = $_POST['fav_cat_id'];
        $cat_total_cnt = $_POST['cat_total_cnt'];
        $keywords = $_POST['keywords'];
        $key_fav_cat_type_id = $_POST['key_fav_cat_type_id'];
        $key_fav_cat_id = $_POST['key_fav_cat_id'];
        $sub_cat_link = $_POST['sub_cat_link'];
        $cat_total_cnt1 = $_POST['cat_total_cnt1'];
        
        
	if($bms_name == '')
	{
            $error = true;
            $err_msg = 'Please enter symptom';
	}
  
	if(!$error)
	{
	    if($obj->addMainSymptomRamakant($sub_cat_link,$key_fav_cat_id,$key_fav_cat_type_id,$keywords,$cat_total_cnt1,$daily_code,$bms_name,$comment,$show_hide,$arr_cucat_parent_cat_id,$arr_cucat_cat_id,$cat_total_cnt))
            {
                    $msg = "Record Added Successfully!";
                    header('location: index.php?mode=main_symptoms&msg='.urlencode($msg));
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
	$bms_name = '';
        $bmst_id = '';
}
$add_more_row_cat_str = '<tr id="row_cat_\'+cat_cnt+\'"><td width="10%" height="30" align="left" valign="middle" style="padding-top: 10px; padding-bottom:10px"><strong>Profile Category:</strong></td><td width="14%" height="30" align="left" valign="middle"><select  name="fav_cat_type_id[]" id="fav_cat_type_id_\'+cat_cnt+\'" onchange="getMainCategoryOptionAddMore(\'+cat_cnt+\')" style="width:150px; height: 23px;">'.$obj2->getFavCategoryTypeOptions('').'</select></td><td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;fav Category:</strong></td><td width="15%" height="30" align="left" valign="middle"><select name="fav_cat_id[]" id="fav_cat_id_\'+cat_cnt+\'" style="width:150px; height: 23px;">'.$obj2->getFavCategoryRamakant('','').'</select></td><td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td><td width="15%" height="30" align="left" valign="middle"><select name="show_hide[]" id="show_hide_\'+cat_cnt+\'" style="width:150px; height: 23px;">'.$obj2->getShowHideOption('').'</select></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory(\'+cat_cnt+\');"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td></tr>';

$add_more_row_cat_str1 = '<tr id="row_cats_\'+cat_cnt1+\'"><td width="10%" height="30" align="left" valign="middle" style="padding-top: 10px; padding-bottom:10px"><strong>Keywords:</strong></td><td width="14%" height="30" align="left" valign="middle"><input type ="text" name="keywords[]" id="keywords_\'+cat_cnt1+\'" onkeyup="suggestionsearch(\'+cat_cnt1+\');"  style="width:150px; height: 23px;"/></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removeRowCategory1(\'+cat_cnt1+\');"><img src="images/del.gif" width="10" height="8" border="0" />Delete</a></td></tr>';
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Add Symptom</td>
                        <td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
                    </tr>
                </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>                
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
                                <input type="hidden" name="cat_cnt1" id="cat_cnt1" value="<?php echo $cat_cnt1;?>">
				<input type="hidden" name="cat_total_cnt1" id="cat_total_cnt1" value="<?php echo $cat_total_cnt1;?>">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                         <td width="10%" height="30" align="left" valign="middle"><strong>Symptom Code:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input name="daily_code" type="text" id="daily_code" value="<?php echo $daily_code; ?>" style="width:150px; height: 23px;">
                                        </td> 
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Symptom:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input type="text" name="bms_name" id="bms_name" value="<?php echo $bms_name;?>"  style="width:150px; height: 23px;">
                                        </td>
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comment:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <textarea name="comment" type="text" id="comment"  style="width:150px; height: 23px;"></textarea>
                                           
                                        </td>
                                         
                                        
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                    <?php
                                    for($i=0;$i<$cat_total_cnt;$i++)
                                    { ?>
                                    
                                    <tr id="row_cat_<?php if($i == 0){ echo 'second';}else{ echo $i;}?>">
                                        <td width="10%" height="30" align="left" valign="middle"><strong>Profile Category:</strong></td>
                                        <td width="14%" height="30" align="left" valign="middle">
                                            <select  name="fav_cat_type_id[]" id="fav_cat_type_id_<?php echo $i;?>" onchange="getMainCategoryOptionAddMore(<?php echo $i;?>)" style="width:150px; height: 23px;" >
<!--                                                <option value="">Select Type</option>-->
                                                <?php  echo $obj2->getFavCategoryTypeOptions($arr_cucat_parent_cat_id[$i]);?>
                                            </select>
                                        </td>
                               
                                        <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;fav Category:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="fav_cat_id[]" id="fav_cat_id_<?php echo $i;?>" style="width:150px; height: 23px;">
                                                <?php echo $obj2->getFavCategoryRamakant($arr_cucat_parent_cat_id[$i],$arr_cucat_cat_id[$i])?>
                                            </select>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Show/Hide:&nbsp;&nbsp;</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="show_hide[]" id="show_hide_<?php echo $i;?>" style="width:150px; height: 23px;" >
                                                <?php echo $obj2->getShowHideOption($arr_cucat_show[$i]); ?>
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
<!--                                    <tr>
                                         <td width="10%" height="30" align="left" valign="middle"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keywords:</strong></td>
                                         <td width="15%" height="30" align="left" valign="middle">
                                             <select name="keywords[]" id="keywords" style="width:150px; height: 23px;">
                                                <?php echo $obj->getKeywordNameVivek($arr_cucat_parent_cat_id,$arr_cucat_cat_id)?>
                                            </select>
                                           
                                        </td>
                                        
                                    <tr>
                                   
       <?php
                                    for($i=0;$i<$cat_total_cnt1;$i++)
                                    { ?>
                                    
-->                                    <<tr id="row_cats_<?php if($i == 0){ echo 'first';}else{ echo $i;}?>">
                                        <td width="5%" height="30" align="left" valign="middle"><strong>Suggestions cat:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select  name="key_fav_cat_type_id[]" id="key_fav_cat_type_id_<?php echo $i;?>" onchange="getMainCategoryOptionAddMoreKey(<?php echo $i;?>)" style="width:150px; height: 23px;" >
<!--                                                <option value="">Select Type</option>-->
                                                <?php  echo $obj2->getFavCategoryTypeOptions($arr_cucat_parent_cat_id[$i]);?>
                                            </select>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle"><strong>Suggestions fav:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="key_fav_cat_id[]" id="key_fav_cat_id_<?php echo $i;?>" style="width:150px; height: 23px;">
                                                <?php echo $obj2->getFavCategoryRamakant($arr_cucat_parent_cat_id[$i],$arr_cucat_cat_id[$i])?>
                                            </select>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle"><strong>Link:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <select name="sub_cat_link[]" id="sub_cat_link_<?php echo $i;?>" style="width:150px; height: 23px;">
                                                <option value="">Select</option>
                                                <option value="tbl_bodymainsymptoms" <?php if($sub_cat_link[$i] == 'tbl_bodymainsymptoms'){ echo 'selected'; } ?>>tbl_bodymainsymptoms</option>
                                                <option value="tblsolutionitems" <?php if($sub_cat_link[$i] == 'tblsolutionitems'){ echo 'selected'; } ?>>tblsolutionitems</option>
                                                <option value="tbldailymealsfavcategory" <?php if($sub_cat_link[$i] == 'tbldailymealsfavcategory'){ echo 'selected'; } ?>>tbldailymealsfavcategory</option>
                                                <option value="tbldailyactivity" <?php if($sub_cat_link[$i] == 'tbldailyactivity'){ echo 'selected'; } ?>>tbldailyactivity</option>
                                            </select>
                                        </td>
                                        <td width="5%" height="30" align="left" valign="middle"><strong>Keywords:</strong></td>
                                        <td width="15%" height="30" align="left" valign="middle">
                                            <input name="keywords[]" type="text" id="keywords_<?php echo $i;?>" onkeyup="autocompleteSportsTeams(<?php echo $i;?>); return false;" style="width:150px; height: 25px;">
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
//                                            ?>
                                        
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
    function addMoreRowCategory()
    {
            var cat_cnt = parseInt($("#cat_cnt").val());
            cat_cnt = cat_cnt + 1;
            //alert("cat_cnt"+cat_cnt);
            $("#row_cat_second").after('<?php echo $add_more_row_cat_str;?>');
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
    
    function addMoreRowCategory1()
    {
            var cat_cnt1 = parseInt($("#cat_cnt1").val());
            cat_cnt1 = cat_cnt1 + 1;
            //alert("cat_cnt"+cat_cnt);
            
            var new_row = '<tr id="row_cats_'+cat_cnt1+'">'+
                                '<td width="5%" height="30" align="left" valign="middle"><strong>Suggestions cat:</strong></td>'+
                                '<td width="15%" height="30" align="left" valign="middle">'+
                                    '<select  name="key_fav_cat_type_id[]" id="key_fav_cat_type_id_'+cat_cnt1+'" onchange="getMainCategoryOptionAddMoreKey('+cat_cnt1+')" style="width:150px; height: 23px;" >'+

                                        '<?php  echo $obj2->getFavCategoryTypeOptions('');?>'+
                                   '</select>'+
                               '</td>'+
                               '<td width="5%" height="30" align="left" valign="middle"><strong>Suggestions fav:</strong></td>'+
                                        '<td width="15%" height="30" align="left" valign="middle">'+
                                            '<select name="key_fav_cat_id[]" id="key_fav_cat_id_'+cat_cnt1+'" style="width:150px; height: 23px;">'+
                                                '<?php echo $obj2->getFavCategoryRamakant('','')?>'+
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

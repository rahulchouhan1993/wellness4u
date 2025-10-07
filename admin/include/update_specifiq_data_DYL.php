<?php
// create new page for banner of DLY by ample 30-01-20
require_once('config/class.mysql.php');
require_once('classes/class.mindjumble.php');
require_once('../init.php');

$obj = new Mindjumble();

require_once('classes/class.scrollingwindows.php');
$obj1 = new Scrolling_Windows();

require_once('classes/class.contents.php'); 
$obj2 = new Contents();

if(!$obj->isAdminLoggedIn())
{

	header("Location: index.php?mode=login");
	exit(0);
}
else
{
   $admin_id = $_SESSION['admin_id']; 
}
$error='';
// if(!$obj->chkValidActionPermission($admin_id,$edit_action_id))
// 	{	
// 	  	header("Location: index.php?mode=invalid");
// 		exit(0);
// 	}
$id=$_GET['DYL_id'];
if(isset($_POST['save']))
{


	//update ample 08-06-20
	$data=array();
	$count_row=count($_POST['text_show']);
	for ($i=0; $i < $count_row; $i++) { 
		$data[] = array( 'text_show' =>$_POST['text_show'][$i] ,
					   	'text_order' =>$_POST['text_order'][$i] ,
					   	'data_source' =>implode(',', $_POST['data_source'][$i]) ,
					   	'specifiq_text' =>$_POST['specifiq_text'][$i] ,
					   	'icon_type' =>$_POST['icon_type'][$i] ,
					   	'icon_source' =>implode(',', $_POST['icon_source'][$i]) ,
					   	'rank_show' =>$_POST['rank_show'][$i] ,
				);	
	}


	$res=$obj2->update_specifiq_data_DYL($id,$data,$count_row);

	if($res)
	{	
		$_SESSION['banner_msg'] = 'Specific Data Updated Successfully!';
		header("Location: index.php?mode=edit-design-your-life&id=".$id);
		exit(0);
	}

}

$data=$obj2->get_specifiq_data_DYL($id);


?>

<style type="text/css">
  .box
  {
  	border: 1px solid #eee;
    padding: 2.5%;
    margin: 2.5px 0;
    border-radius: 5px;
  }
</style>
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Update Design Your Life Specific Text Data</td>
                        <td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
                    </tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<br>
				<a href="index.php?mode=edit-design-your-life&id=<?=$_GET['DYL_id']?>"><button class="btn btn-default">Back</button></a>
				<table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
				<tbody>
					<tr>
						<td class="mainbox-body">
							
							<div class="col-sm-2"></div>
							<div class="col-sm-8">
								<br>
								<form method="post" action="">
								<div id="banner_box">
								<?php 
								if(empty($data))
								{
									?>
									<input type="hidden" name="count_row" id="count_row" value="0" />
									<div class="box" id="row0">
										<div class="row">
											<div class="col-lg-4">
												<label>Text Show:</label>
												<select class="form-control" name="text_show[]" required>
				                                        <option value="1">Yes</option>
				                                        <option value="0">No</option>
				                                    </select> 
											</div>
											<div class="col-lg-4">
												<label>Text Order:</label>
												<select class="form-control" name="text_order[]" required>
				                                        <option value="">Select</option>
		                                                <?php 
		                                                for ($i=1; $i <= 20; $i++) { 
		                                                	?>
		                                                	<option value="<?=$i;?>" ><?=$i;?></option>
		                                                	<?php
		                                                }
		                                                ?>
				                                    </select> 
											</div>
											<div class="col-lg-4">
												<label>Rank Show:</label>
												<select class="form-control" name="rank_show[]" required>
														<option value="0">No</option>
				                                        <option value="1">Yes</option>
				                                    </select> 
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<label>Data Source:</label>
												<select name="data_source[0][]" class="form-control tbl_link" id="data_source_0" onchange="update_specifiq_box('0')" multiple required>
	                                                    <option value="ProfCat2" selected>ProfCat2</option>
	                                                    <option value="ProfCat3">ProfCat3</option>
	                                                    <option value="ProfCat4">ProfCat4</option>
	                                                </select> <br>
	                                                <span class="text-danger">You can choose more than one option by using the ctrl key.</span>
											</div>
											<div class="col-lg-6">
												<label>Specifiq Text:</label>
												<select name="specifiq_text[]" id="specifiq_text_0" class="form-control" required>
	                                                    <option value="">Select</option>
	                                                </select>
	                                                <input type="hidden" id="specifiq_text_select_0" value="">
											</div>
										</div><div class="row">
											<div class="col-lg-6">
												<label>Icon Type:</label>
												<select name="icon_type[]" id="icon_type" class="form-control">
		                                                <option value="0">No Icon</option>
		                                                <option value="1">Drop-Down</option>
		                                                <option value="2">Checkbox</option>
		                                                <option value="3">Radio</option>
	                                            	</select>
											</div>
											<div class="col-lg-6">
												<label>Icon Source:</label>
												<select name="icon_source[0][]" id="icon_source" class="form-control" multiple>
	                                                    <option value="Location"  >Location Category</option>
	                                                    <option value="User_Response"  >User Response</option> 
	                                                    <option value="User_What_Next" >User What Next</option>
	                                                    <option value="Alert_Update" >Alert Update</option>
	                                                    <option value="Comment" >Comment</option>
	                                                    <option value="Scale" >Scale</option>
	                                                    <option value="Time" >Time</option>
	                                                    <option value="Duration" >Duration</option>
	                                                    <option value="Date" >Date</option>
	                                                </select>
											</div>
										</div>
										<button type="button" class="btn btn-info btn-xs add_more_banner">Add More</button>
			                        </div>
									<?php
								}
								else
								{	
									?>
									<input type="hidden" name="count_row" id="count_row" value="<?=count($data)?>" />
									<?php
									foreach ($data as $key => $value) {
											$data_source=explode(',', $value['data_source']);
											$icon_source=explode(',', $value['icon_source']);
										?>
										<div class="box" id="row<?=$key;?>">
										<div class="row">
											<div class="col-lg-4">
												<label>Text Show:</label>
												<select class="form-control" name="text_show[]" required>
				                                        <option value="1" <?=($value['text_show']=='1')? 'selected' : ''; ?>>Yes</option>
				                                        <option value="0" <?=($value['text_show']=='0')? 'selected' : ''; ?>>No</option>
				                                    </select> 
											</div>
											<div class="col-lg-4">
												<label>Text Order:</label>
												<select class="form-control" name="text_order[]" required>
				                                        <option value="">Select</option>
		                                                <?php 
		                                                for ($i=1; $i <= 20; $i++) { 
		                                                	?>
		                                                	<option value="<?=$i;?>" <?=($value['text_order']==$i)? 'selected' : ''; ?> ><?=$i;?></option>
		                                                	<?php
		                                                }
		                                                ?>
				                                    </select> 
											</div>
											<div class="col-lg-4">
												<label>Rank Show:</label>
												<select class="form-control" name="rank_show[]" required>
													<option value="0" <?=($value['rank_show']=='0')? 'selected' : ''; ?>>No</option>
													<option value="1" <?=($value['rank_show']=='1')? 'selected' : ''; ?>>Yes</option>
				                                </select> 
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<label>Data Source:</label>
												<select name="data_source[<?=$key;?>][]" class="form-control tbl_link" id="data_source_<?=$key;?>" onchange="update_specifiq_box('<?=$key;?>')" multiple required>
	                                                    <option value="ProfCat2" <?=(in_array("ProfCat2", $data_source))? 'selected' : '' ;?> >ProfCat2</option>
                                                    	<option value="ProfCat3" <?=(in_array("ProfCat3", $data_source))? 'selected' : '' ;?> >ProfCat3</option>
                                                    	<option value="ProfCat4" <?=(in_array("ProfCat4", $data_source))? 'selected' : '' ;?> >ProfCat4</option>
	                                                </select> <br>
	                                                <span class="text-danger">You can choose more than one option by using the ctrl key.</span>
											</div>
											<div class="col-lg-6">
												<label>Specifiq Text:</label>
												<select name="specifiq_text[]" id="specifiq_text_<?=$key;?>" class="form-control" required>
	                                                    <option value="">Select</option>
	                                                </select>
	                                                <input type="hidden" id="specifiq_text_select_<?=$key;?>" value="<?=$value['specifiq_text'];?>">
											</div>
										</div><div class="row">
											<div class="col-lg-6">
												<label>Icon Type:</label>
												<select name="icon_type[]" id="icon_type" class="form-control">
		                                                <option value="0" <?=($value['icon_type'] == '0')? 'selected' : '' ;?> >No Icon</option>
                                                		<option value="1" <?=($value['icon_type'] == '1')? 'selected' : '' ;?> >Drop-Down</option>
														<option value="2" <?=($value['icon_type'] == '2')? 'selected' : '' ;?> >Checkbox</option>
														<option value="3" <?=($value['icon_type'] == '3')? 'selected' : '' ;?> >Radio</option>
												</select>
											</div>
											<div class="col-lg-6">
												<label>Icon Source:</label>
												<select name="icon_source[<?=$key;?>][]" id="icon_source" class="form-control" multiple>
	                                                    <option value="Location" <?=(in_array("Location", $icon_source))? 'selected' : '' ;?> >Location Category</option>
	                                                    <option value="User_Response" <?=(in_array("User_Response", $icon_source))? 'selected' : '' ;?>>User Response</option>
	                                                    <option value="User_What_Next" <?=(in_array("User_What_Next", $icon_source))? 'selected' : '' ;?>>User What Next</option>
	                                                    <option value="Alert_Update" <?=(in_array("Alert_Update", $icon_source))? 'selected' : '' ;?>>Alert Update</option>
	                                                    <option value="Comment" <?=(in_array("Comment", $icon_source))? 'selected' : '' ;?>>Comment</option>
	                                                    <option value="Scale" <?=(in_array("Scale", $icon_source))? 'selected' : '' ;?>>Scale</option>
	                                                    <option value="Time" <?=(in_array("Time", $icon_source))? 'selected' : '' ;?>>Time</option>
	                                                    <option value="Duration" <?=(in_array("Duration", $icon_source))? 'selected' : '' ;?>>Duration</option>
	                                                    <option value="Date" <?=(in_array("Date", $icon_source))? 'selected' : '' ;?> >Date</option>
	                                                </select>
											</div>
										</div>
													<?php 
				                                	if($key==0)
				                                	{
				                                		?>
				                                		<button type="button" class="btn btn-info btn-xs add_more_banner">Add More</button>
				                                		<?php
				                                	}
				                                	else
				                                	{
				                                		?>
				                                		<button type="button" class="btn btn-warning btn-xs add_field_button" onclick="remove_banner('<?=$key;?>')">Remove</button>
				                                		<?php
				                                	}
				                                	?>
										
			                        </div>
										<?php
									}
								}
								?>
								
		                    	</div>
		                    	<hr>
		                    	<input type="Submit" name="save" class="btn btn-default" value="Save" />
		                    	<br>
			                </form>
			                </div>
			                <div class="col-sm-2"></div>
			               
						</td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
</tbody>
</table>
</div>

<script type="text/javascript">
//update ample 08-06-20	
	$(document).ready(function() {
	var max_fields      = 20; //maximum input boxes allowed
	var wrapper   		= $("#banner_box"); //Fields wrapper
	var add_button      = $(".add_more_banner"); //Add button ID
	


		var x = 1; //initlal text box count
		$(add_button).click(function(e){ //on add input button click
			e.preventDefault();
			if(x < max_fields){ //max input box allowed
				x++; //text box increment

				var count_row=parseInt($("#count_row").val());
				var new_row= count_row+1;
				var html="";

				html+='<div class="box" id="row'+new_row+'">'+
										'<div class="row">'+
											'<div class="col-lg-4">'+
												'<label>Text Show:</label>'+
												'<select class="form-control" name="text_show[]" required>'+
				                                        '<option value="1">Yes</option>'+
				                                       '<option value="0">No</option>'+
				                                    '</select> '+
											'</div>'+
											'<div class="col-lg-4">'+
												'<label>Text Order:</label>'+
												'<select class="form-control" name="text_order[]" required>'+
				                                       ' <option value="">Select</option>'+
		                                                '<option value="1">1</option>'+
		                                                '<option value="2">2</option>'+
		                                                '<option value="3">3</option>'+
		                                                '<option value="4">4</option>'+
		                                                '<option value="5">5</option>'+
		                                                '<option value="6">6</option>'+
		                                                '<option value="7">7</option>'+
		                                                '<option value="8">8</option>'+
		                                                '<option value="9">9</option>'+
		                                                '<option value="10">10</option>'+
		                                                '<option value="11">11</option>'+
		                                                '<option value="12">12</option>'+
		                                                '<option value="13">13</option>'+
		                                                '<option value="14">14</option>'+
		                                                '<option value="15">15</option>'+
		                                                '<option value="16">16</option>'+
		                                                '<option value="17">17</option>'+
		                                                '<option value="18">18</option>'+
		                                                '<option value="19">19</option>'+
		                                                '<option value="20">20</option>'+
				                                    '</select>'+ 
											'</div>'+
											'<div class="col-lg-4">'+
												'<label>Rank Show:</label>'+
												'<select class="form-control" name="rank_show[]" required>'+
														'<option value="0">No</option>'+
				                                        '<option value="1">Yes</option>'+
				                                    '</select> '+
											'</div>'+
										'</div>'+
										'<div class="row">'+
											'<div class="col-lg-6">'+
												'<label>Data Source:</label>'+
												'<select name="data_source['+new_row+'][]" class="form-control tbl_link" id="data_source_'+new_row+'" onchange="update_specifiq_box('+new_row+')" multiple required>'+
	                                                    '<option value="ProfCat2">ProfCat2</option>'+
	                                                    '<option value="ProfCat3">ProfCat3</option>'+
	                                                    '<option value="ProfCat4">ProfCat4</option>'+
	                                                '</select> <br>'+
	                                                '<span class="text-danger">You can choose more than one option by using the ctrl key.</span>'+
											'</div>'+
											'<div class="col-lg-6">'+
												'<label>Specifiq Text:</label>'+
												'<select name="specifiq_text[]" id="specifiq_text_'+new_row+'" class="form-control" required>'+
	                                                    '<option value="">Select</option>'+
	                                                '</select>'+
	                                                '<input type="hidden" id="specifiq_text_select_'+new_row+'" value="">'+
											'</div>'+
										'</div><div class="row">'+
											'<div class="col-lg-6">'+
												'<label>Icon Type:</label>'+
												'<select name="icon_type[]" id="icon_type" class="form-control">'+
		                                                '<option value="0">No Icon</option>'+
		                                                '<option value="1">Drop-Down</option>'+
		                                                '<option value="2">Checkbox</option>'+
		                                                '<option value="3">Radio</option>'+
	                                            	'</select>'+
											'</div>'+
											'<div class="col-lg-6">'+
												'<label>Icon Source:</label>'+
												'<select name="icon_source['+new_row+'][]" id="icon_source" class="form-control" multiple>'+
	                                                    '<option value="Location"  >Location Category</option>'+
	                                                    '<option value="User_Response"  >User Response</option> '+
	                                                    '<option value="User_What_Next" >User What Next</option>'+
	                                                    '<option value="Alert_Update" >Alert Update</option>'+
	                                                    '<option value="Comment" >Comment</option>'+
	                                                    '<option value="Scale" >Scale</option>'+
	                                                    '<option value="Time" >Time</option>'+
	                                                    '<option value="Duration" >Duration</option>'+
	                                                '</select>'+
											'</div>'+
										'</div>'+
										'<button type="button" class="btn btn-warning btn-xs add_field_button" onclick="remove_banner('+new_row+')">Remove</button>'+
			                        '</div>';

				$(wrapper).append(html); //add input box
				$("#count_row").val(new_row);
			}
		});

	});

	function remove_banner(row) {
		$("#row"+row).remove();
			var count_row = parseInt($("#count_row").val());
            count_row = count_row - 1;
            $("#count_row").val(count_row);
	}

	//ADD by ample 27-05-20
	 function update_specifiq_box(box_id)
    {
        get_data_of_profCat(box_id);
    }

    //add by ample 27-05-20
    function get_data_of_profCat(box_id)
    {
        
        var DYL_id='<?=$_GET["DYL_id"]?>';
        var source=$('#data_source_'+box_id).val();
        var selected=$('#specifiq_text_select_'+box_id).val();

        var dataString = 'action=GetPRofCatData_DLY&source='+source+'&selected='+selected+'&data_id='+DYL_id;

            $.ajax({

                type: "POST",

                url: "include/remote.php",

                data: dataString,

                cache: false,

                success: function(result)

                {

                    // alert(result);

                    // console.log(result);

                    $("#specifiq_text_"+box_id).html(result);

                }

            }); 
    }
    //add by ample
    $(document).ready(function()
    {
       $('.tbl_link').trigger('change');
    });

</script>

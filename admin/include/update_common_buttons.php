<?php
// create new page for banner of DLY by ample 30-01-20
require_once('config/class.mysql.php');
require_once('classes/class.mindjumble.php');
require_once('../init.php');

$obj2 = new Mindjumble();

require_once('classes/class.scrollingwindows.php');
$obj1 = new Scrolling_Windows();

require_once('classes/class.contents.php'); 
$obj = new Contents();

if(!$obj->isAdminLoggedIn())
{

	header("Location: index.php?mode=login");
	exit(0);
}
else
{
   $admin_id = $_SESSION['admin_id']; 
}
$edit_action_id = '381';
$tblID='10';
$BP_ID='88';
$BT_ID='89';
$error='';
$bg_color = '000000';
$font_color='FFFFFF';
$icon_code='fa-hand-o-right';
if(!$obj->chkValidActionPermission($admin_id,$edit_action_id))
	{	
	  	header("Location: index.php?mode=invalid");
		exit(0);
	}
$id=$_GET['data_id'];
if(isset($_POST['save']))
{

	// echo "<pre>";

	// print_r($_POST);

	// die('--');

	$data=array();
	$count_row=count($_POST['button_show']);
	for ($i=0; $i < $count_row; $i++) { 
		//add-on by ample 07-08-20
		$data[] = array( 'button_category' =>$_POST['button_category'][$i] ,
					   	'button_name' =>$_POST['button_name'][$i] ,
					   	'button_heading' =>$_POST['button_heading'][$i],
					   	'button_show' =>$_POST['button_show'][$i] ,
					   	'button_order' =>$_POST['button_order'][$i] ,
					   	'link' =>$_POST['link'][$i],
					   	'font_color' =>$_POST['font_color'][$i],
					   	'bg_color' =>$_POST['bg_color'][$i],
					   	'icon_code' =>$_POST['icon_code'][$i],
					   	'narration' =>$_POST['narration'][$i],
					   	'icon_type' =>$_POST['icon_type'][$i] ,
					   	'icon_source' =>implode(',', $_POST['icon_source'][$i]) ,
					   	'rank_show' =>$_POST['rank_show'][$i] ,
					   	'banner' =>$_POST['banner'][$i] ,
					   	'banner_type' =>$_POST['banner_type'][$i],
					   	'button_type' =>$_POST['button_type'][$i],
					   	'popup_type' =>$_POST['popup_type'][$i],
				);	
	}


	$res=$obj->update_common_buttons($id,$data);

	if($res)
	{	
		$_SESSION['banner_msg'] = 'Buttons Data Updated Successfully!';
		header("Location: index.php?mode=edit-common-button-setting&id=".$id);
		exit(0);
	}

}

$data=$obj->get_common_buttons_data($id);

// echo "<pre>";

// print_r($data);

// die('-----');


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

<!-- <script type="text/javascript" src="js/jscolor.js"></script>  -->
<script type="text/javascript" src="js/jscolor-2.1.1.js"></script> 
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Update Special Buttons Section</td>
                        <td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
                    </tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<br>
				<a href="index.php?mode=edit-common-button-setting&id=<?=$_GET['data_id']?>"><button class="btn btn-default">Back</button></a>
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
												<label>Button Category:</label>
												<select name="button_category[]" id="fav_cat_type_id_0" class="form-control" onchange="getMainCategoryOptionNew(0)" required>
                                                    <?php echo $obj1->getFavCategoryTypeOptions('')?>
                                                </select>
											</div>
											<div class="col-lg-4">
												<label>Button Name:</label>
												<select name="button_name[]" id="fav_cat_id_0"  class="form-control" required>
                                                    <option value="">Select</option>
                                                </select>
											</div>
											<div class="col-lg-4">
												<label>Button Heading:</label>
												<input type="text" name="button_heading[]" id="button_heading" class="form-control" value=""  placeholder="Button Heading" required>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-4">
												<label>Button Show:</label>
												<select class="form-control" name="button_show[]">
			                                        <option value="1">Yes</option>
			                                        <option value="0">No</option>
			                                    </select> 
											</div>
											<div class="col-lg-4">
												<label>Button Order:</label>
												<select class="form-control" name="button_order[]" required>
			                                        <option value="0">Select</option>
			                                        <?php 
			                                        	for ($i=1; $i < 21; $i++) { 
			                                        		?>
			                                        		<option value="<?=$i;?>"><?=$i?></option>
			                                        		<?php
			                                        	}
			                                        ?>
			                                    </select> 
											</div>
											<div class="col-lg-4">
												<label>Link:</label>
												 <input type="text"  id="link" name="link[]" class="form-control" placeholder="Button Link"/>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-4">
												<label>Font Colour:</label>
												  <input type="text" class="color form-control" data-jscolor="" name="font_color[]"  value="<?php echo $font_color; ?>"/>
											</div>
											<div class="col-lg-4">
												<label>Background Colour:</label>
												<input type="text" class="color form-control" data-jscolor=""  name="bg_color[]" value="<?php echo $bg_color; ?>"/>
											</div>
											<div class="col-lg-4">
												<label>Icon Code:</label>
												<input type="text" name="icon_code[]" class="form-control" value="<?php echo $icon_code; ?>"/>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<label>Icon Type:</label>
												<select name="icon_type[]" id="icon_type" class="form-control">
		                                                <option value="0">No Icon</option>
		                                                <option value="1">Drop-Down</option>
		                                                <option value="2">Checkbox</option>
		                                                <option value="3">Radio</option>
	                                            	</select>
	                                            <label>Rank Show:</label>
												<select class="form-control" name="rank_show[]" required>
														<option value="0">No</option>
				                                        <!-- <option value="1">Yes</option> -->
				                                         <?php 
			                                        	for ($i=1; $i < 21; $i++) { 
					                                        		?>
					                                        		<option value="<?=$i;?>"><?=$i?></option>
					                                        		<?php
					                                        	}
			                                        ?>
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
										<div class="row">
											<div class="col-lg-6">
												<label>Button Type:</label>
												<select name="button_type[]" id="button_position" class="form-control">
                                                	<?php echo $obj1->getFavCategoryRamakant($BT_ID,'')?>
                                            	</select>
											</div>
											<div class="col-lg-6">
												<label>PopUp Type:</label>
												<select name="popup_type[]" id="icon_source" class="form-control">
	                                                    <option value="0">No Popup</option>
		                                                <option value="1">Add-to-Fav</option>
		                                                <option value="2">Add-to-Library</option>
	                                                </select>
											</div>
										</div>
										<div class="row" style="padding: 5px 0;">
											<div class="col-lg-3">
												<label>Banners:</label>
												<input type="hidden" name="banner[]" id="banner" value="" readonly="">
											</div>
											<div class="col-lg-3">
												<button type="button" class="btn btn-primary btn-xs" onclick="galleryData('IMG',0,'banner');">Gallery 1</button>
											</div>
											<div class="col-lg-3">
												<button type="button" class="btn btn-primary btn-xs" onclick="galleryData('OT',0,'banner');">Gallery 2</button>
											</div>
											<div class="col-lg-3">
												<button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData('banner');">Reset</button>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-4">
												<input type="text" name="banner_type[]" id="banner_type" class="form-control" value="" readonly="" placeholder="Banner Type">
											</div>
											<div class="col-lg-4">
												<input type="text" id="banner_name" value="" disabled="" class="form-control" placeholder="Banner Name">
											</div>
											<div class="col-lg-4">
												<input type="text" id="banner_file" value="" disabled="" class="form-control" placeholder="Banner File">
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<label>Narration:</label>
												<textarea class="form-control" name="narration[]" rows="3"></textarea>
											</div>
										</div>
										<br>
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
											$icon_source=explode(',', $value['icon_source']);
										?>
									<div class="box" id="row<?=$key;?>">
										<div class="row">
											<div class="col-lg-4">
												<label>Button Category:</label>
												<select name="button_category[]" id="fav_cat_type_id_<?=$key;?>" class="form-control" onchange="getMainCategoryOptionNew('<?=$key;?>')" required>
                                                    <?php echo $obj1->getFavCategoryTypeOptions($value['button_category'])?>
                                                </select>
											</div>
											<div class="col-lg-4">
												<label>Button Name:</label>
												<select name="button_name[]" id="fav_cat_id_<?=$key;?>"  class="form-control" required>
                                                    <option value="">Select</option>
                                                    <?php echo $obj1->getFavCategoryRamakant($value['button_category'],$value['button_name'])?>
                                                </select>
											</div>
											<div class="col-lg-4">
												<label>Button Heading:</label>
												<input type="text" name="button_heading[]" id="button_heading" class="form-control" value="<?=$value['button_heading'];?>"  placeholder="Button Heading" required>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-4">
												<label>Button Show:</label>
												<select class="form-control" name="button_show[]">
			                                        <option value="1" <?=($value['button_show']=='1')? 'selected' : ''; ?>>Yes</option>
				                                    <option value="0" <?=($value['button_show']=='0')? 'selected' : ''; ?>>No</option>
			                                    </select> 
											</div>
											<div class="col-lg-4">
												<label>Button Order:</label>
												<select class="form-control" name="button_order[]" required>
			                                        <option value="0">Select</option>
			                                        <?php 
			                                        	for ($i=1; $i < 21; $i++) { 
			                                        		?>
			                                        		<option value="<?=$i;?>" <?=($value['button_order']==$i)? 'selected' : ''; ?> ><?=$i?></option>
			                                        		<?php
			                                        	}
			                                        ?>
			                                    </select> 
											</div>
											<div class="col-lg-4">
												<label>Link:</label>
												 <input type="text"  id="link" name="link[]" value="<?=$value['link'];?>" class="form-control" placeholder="Button Link"/>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-4">
												<label>Font Colour:</label>
												  <input type="text" class="color form-control" data-jscolor="" name="font_color[]"  value="<?php echo $value['font_color']; ?>"/>
											</div>
											<div class="col-lg-4">
												<label>Background Colour:</label>
												<input type="text" class="color form-control" data-jscolor=""  name="bg_color[]" value="<?php echo $value['bg_color']; ?>"/>
											</div>
											<div class="col-lg-4">
												<label>Icon Code:</label>
												<input type="text" name="icon_code[]" class="form-control" value="<?php echo $value['icon_code']; ?>"/>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<label>Icon Type:</label>
												<select name="icon_type[]" id="icon_type" class="form-control">
		                                                <option value="0" <?=($value['icon_type'] == '0')? 'selected' : '' ;?> >No Icon</option>
                                                		<option value="1" <?=($value['icon_type'] == '1')? 'selected' : '' ;?> >Drop-Down</option>
														<option value="2" <?=($value['icon_type'] == '2')? 'selected' : '' ;?> >Checkbox</option>
														<option value="3" <?=($value['icon_type'] == '3')? 'selected' : '' ;?> >Radio</option>
												</select>
												<label>Rank Show:</label>
												<select class="form-control" name="rank_show[]" required>
													<option value="0" <?=($value['rank_show']=='0')? 'selected' : ''; ?>>No</option>
													<!-- <option value="1" <?=($value['rank_show']=='1')? 'selected' : ''; ?>>Yes</option> -->
			                                        <?php 
			                                        	for ($i=1; $i < 21; $i++) { 
			                                        		?>
			                                        		<option value="<?=$i;?>" <?=($value['rank_show']==$i)? 'selected' : ''; ?> ><?=$i?></option>
			                                        		<?php
			                                        	}
			                                        ?>
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
										<div class="row">
											<div class="col-lg-6">
												<label>Button Type:</label>
												<select name="button_type[]" id="button_type" class="form-control">
                                                	<?php echo $obj1->getFavCategoryRamakant($BT_ID,$value['button_type'])?>
                                            	</select>
											</div>
											<div class="col-lg-6">
												<label>PopUp Type:</label>
												<select name="popup_type[]" id="popup_type" class="form-control">
	                                                    <option value="0" <?=($value['popup_type'] == '0')? 'selected' : '' ;?> >No Popup</option>
		                                                <option value="1" <?=($value['popup_type'] == '1')? 'selected' : '' ;?>>Add-to-Fav</option>
		                                                <option value="2" <?=($value['popup_type'] == '2')? 'selected' : '' ;?> >Add-to-Library</option>
	                                                </select>
											</div>
										</div>
										<div class="row" style="padding: 5px 0;">
											<div class="col-lg-3">
												<label>Banners:</label>
												<input type="hidden" name="banner[]" id="banner<?=$key;?>" readonly="" value="<?=$value['banner'];?>">
											</div>
											<div class="col-lg-3">
												<button type="button" class="btn btn-primary btn-xs" onclick="galleryData('IMG',0,'banner<?=$key;?>');">Gallery 1</button>
											</div>
											<div class="col-lg-3">
												<button type="button" class="btn btn-primary btn-xs" onclick="galleryData('OT',0,'banner<?=$key;?>');">Gallery 2</button>
											</div>
											<div class="col-lg-3">
												<button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData('banner<?=$key;?>');">Reset</button>
											</div>
										</div>
										<?php 
			                                        $banner_name=$banner_file=$banner_credit=$banner_credit_url="";
			                                        if(!empty($value['banner_type']))
			                                        {
			                                            if($value['banner_type']=='Image')
			                                            {
			                                                $banner_data=$obj->get_data_from_tblicons('',$value['banner']);
			                                                $banner_name=$banner_data[0]['icons_name'];
			                                                $banner_file=$banner_data[0]['image'];
			                                                $banner_credit=$banner_data[0]['credit'];
			                                                $banner_credit_url=$banner_data[0]['credit_url'];
			                                            }
			                                            else
			                                            {
			                                                $banner_data=$obj->get_data_from_tblmindjumble('',$value['banner']);
			                                                $banner_name=$banner_data[0]['box_title'];
			                                                $banner_file=$banner_data[0]['box_banner'];
			                                                $banner_credit=$banner_data[0]['credit_line'];
			                                                $banner_credit_url=$banner_data[0]['credit_line_url'];
			                                            }
			                                        }

			                                        ?>
			                                        <?php 
			                                        if(!empty($banner_file))
			                                        {
			                                                ?>
			                                                <div class="row">
																<div class="col-lg-4">
			                                                <a href="<?php echo SITE_URL.'/uploads/'. $banner_file;?>" target="_blank"><?php echo $banner_file;?></a> 
			                                            		</div>
			                                            	</div>
			                                                <?php
			                                        }
			                                        ?>
										<div class="row">
											<div class="col-lg-4">
												<input type="text" name="banner_type[]" id="banner<?=$key;?>_type" class="form-control" readonly="" placeholder="Banner Type" value="<?=$value['banner_type'];?>">
											</div>
											<div class="col-lg-4">
												<input type="text" id="banner<?=$key;?>_name" disabled="" class="form-control" placeholder="Banner Name" value="<?=$banner_name;?>">
											</div>
											<div class="col-lg-4">
												<input type="text" id="banner<?=$key;?>_file" disabled="" class="form-control" placeholder="Banner File" value="<?=$banner_file;?>">
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<label>Narration:</label>
												<textarea class="form-control" name="narration[]" rows="3"><?php echo $value['narration']; ?></textarea>
											</div>
										</div>
										<br>
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
		                    	<div class="text-center">
		                    	<input type="Submit" name="save" class="btn btn-success text-center" value="Save" />
		                    	</div>
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

				var gallery1="'IMG',0,'banner"+new_row+"'";
				var gallery2="'OT',0,'banner"+new_row+"'";
				var gallery="'banner"+new_row+"'";

				html+='<div class="box" id="row'+new_row+'">'+
										'<div class="row">'+
											'<div class="col-lg-4">'+
												'<label>Button Category:</label>'+
												'<select name="button_category[]" id="fav_cat_type_id_'+new_row+'" class="form-control" onchange="getMainCategoryOptionNew('+new_row+')" required>'+
                                                    '<?php echo $obj1->getFavCategoryTypeOptions('');?>'+
                                                '</select>'+
											'</div>'+
											'<div class="col-lg-4">'+
												'<label>Button Name:</label>'+
												'<select name="button_name[]" id="fav_cat_id_'+new_row+'"  class="form-control" required>'+
                                                    '<option value="">Select</option>'+
                                                    '<?php echo $obj1->getFavCategoryRamakant('','');?>'+
                                                '</select>'+
											'</div>'+
											'<div class="col-lg-4">'+
												'<label>Button Heading:</label>'+
												'<input type="text" name="button_heading[]" id="button_heading" class="form-control" value=""  placeholder="Button Heading" required>'+
											'</div>'+
										'</div>'+
										'<div class="row">'+
											'<div class="col-lg-4">'+
												'<label>Button Show:</label>'+
												'<select class="form-control" name="button_show[]">'+
			                                        '<option value="1">Yes</option>'+
			                                        '<option value="0">No</option>'+
			                                    '</select>'+
											'</div>'+
											'<div class="col-lg-4">'+
												'<label>Button Order:</label>'+
												'<select class="form-control" name="button_order[]" required>'+
			                                        	'<option value="">Select</option>'+
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
												'<label>Link:</label>'+
												'<input type="text"  id="link" name="link[]" class="form-control" placeholder="Button Link"/>'+
											'</div>'+
										'</div>'+
										'<div class="row">'+
											'<div class="col-lg-4">'+
												'<label>Font Colour:</label>'+
												  '<input type="text" class="color form-control" name="font_color[]" data-jscolor=""  value="<?php echo $font_color; ?>"/>'+
											'</div>'+
											'<div class="col-lg-4">'+
												'<label>Background Colour:</label>'+
												'<input type="text" class="color form-control"  name="bg_color[]" data-jscolor="" value="<?php echo $bg_color; ?>"/>'+
											'</div>'+
											'<div class="col-lg-4">'+
												'<label>Icon Code:</label>'+
												'<input type="text" name="icon_code[]" class="form-control" value="<?php echo $icon_code; ?>"/>'+
											'</div>'+
										'</div>'+
										'<div class="row">'+
											'<div class="col-lg-6">'+
												'<label>Icon Type:</label>'+
												'<select name="icon_type[]" id="icon_type" class="form-control">'+
		                                                '<option value="0">No Icon</option>'+
		                                                '<option value="1">Drop-Down</option>'+
		                                                '<option value="2">Checkbox</option>'+
		                                                '<option value="3">Radio</option>'+
	                                            	'</select>'+
	                                            '<label>Rank Show:</label>'+
												'<select class="form-control" name="rank_show[]" required>'+
														'<option value="0">No</option>'+
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
				                                    '</select> '+
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
										'<div class="row">'+
											'<div class="col-lg-6">'+
												'<label>Button Type:</label>'+
												'<select name="button_type[]" id="button_position" class="form-control">'+
                                                	'<?php echo $obj1->getFavCategoryRamakant($BT_ID,'')?>'+
                                            	'</select>'+
											'</div>'+
											'<div class="col-lg-6">'+
												'<label>PopUp Type:</label>'+
												'<select name="popup_type[]" id="icon_source" class="form-control">'+
	                                                    '<option value="0">No Popup</option>'+
		                                                '<option value="1">Add-to-Fav</option>'+
		                                                '<option value="2">Add-to-Library</option>'+
	                                                '</select>'+
											'</div>'+
										'</div>'+
										'<div class="row" style="padding: 5px 0;">'+
											'<div class="col-lg-3">'+
												'<label>Banners:</label>'+
												'<input type="hidden" name="banner[]" id="id="banner'+new_row+'"" value="" readonly="">'+
											'</div>'+
											'<div class="col-lg-3">'+
												'<button type="button" class="btn btn-primary btn-xs" onclick="galleryData('+gallery1+');">Gallery 1</button>'+
											'</div>'+
											'<div class="col-lg-3">'+
												'<button type="button" class="btn btn-primary btn-xs" onclick="galleryData('+gallery2+');">Gallery 2</button>'+
											'</div>'+
											'<div class="col-lg-3">'+
												'<button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData('+gallery+');">Reset</button>'+
											'</div>'+
										'</div>'+
										'<div class="row">'+
											'<div class="col-lg-4">'+
												'<input type="text" name="banner_type[]" id="banner'+new_row+'_type" class="form-control" value="" readonly="" placeholder="Banner Type">'+
											'</div>'+
											'<div class="col-lg-4">'+
												'<input type="text" id="banner'+new_row+'_name" value="" disabled="" class="form-control" placeholder="Banner Name">'+
											'</div>'+
											'<div class="col-lg-4">'+
												'<input type="text" id="banner'+new_row+'_file" value="" disabled="" class="form-control" placeholder="Banner File">'+
											'</div>'+
										'</div>'+
										'<div class="row">'+
											'<div class="col-lg-12">'+
												'<label>Narration:</label>'+
												'<textarea class="form-control" name="narration[]" rows="3"></textarea>'+
											'</div>'+
										'</div>'+
										'<br>'+
										'<button type="button" class="btn btn-warning btn-xs add_field_button" onclick="remove_banner('+new_row+')">Remove</button>'+
			                        '</div>';

				$(wrapper).append(html); //add input box
				$("#count_row").val(new_row);
				jscolor.init();
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


    function getMainCategoryOptionNew(id)

    {

            var parent_cat_id = $("#fav_cat_type_id_"+id).val();

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

                            $("#fav_cat_id_"+id).html(result);

                    }

            });

    }
</script>

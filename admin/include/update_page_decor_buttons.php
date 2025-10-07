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
$edit_action_id = '374';
$tblID='10';
$BP_ID='88';
$error='';
$bg_color = '000000';
$font_color='FFFFFF';
$icon_code='fa-hand-o-right';
if(!$obj->chkValidActionPermission($admin_id,$edit_action_id))
	{	
	  	header("Location: index.php?mode=invalid");
		exit(0);
	}
$id=$_GET['PD_id'];
if(isset($_POST['save']))
{

	// echo "<pre>";

	// print_r($_POST);

	// die('--');

	$data=array();
	$count_row=count($_POST['button_show']);
	for ($i=0; $i < $count_row; $i++) { 
		$data[] = array( 'button_category' =>$_POST['button_category'][$i] ,
					   	'button_name' =>$_POST['button_name'][$i] ,
					   	'button_heading' =>$_POST['button_heading'][$i],
					   	'button_show' =>$_POST['button_show'][$i] ,
					   	'button_order' =>$_POST['button_order'][$i] ,
					   	'button_position' =>$_POST['button_position'][$i] ,
					   	'link' =>$_POST['link'][$i],
					   	'ref_table' =>$_POST['ref_table'][$i],
					   	'font_color' =>$_POST['font_color'][$i],
					   	'bg_color' =>$_POST['bg_color'][$i],
					   	'icon_code' =>$_POST['icon_code'][$i],
					   	'narration' =>$_POST['narration'][$i],
				);	
	}


	$res=$obj->update_page_decor_buttons($id,$data);

	if($res)
	{	
		$_SESSION['banner_msg'] = 'Buttons Data Updated Successfully!';
		header("Location: index.php?mode=edit-page-decor&id=".$id);
		exit(0);
	}

}

$data=$obj->get_button_data_page_decor($id);

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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Update addons Button Section</td>
                        <td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
                    </tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<br>
				<a href="index.php?mode=edit-page-decor&id=<?=$_GET['PD_id']?>"><button class="btn btn-default">Back</button></a>
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
			                                        	for ($i=1; $i < 12; $i++) { 
			                                        		?>
			                                        		<option value="<?=$i;?>"><?=$i?></option>
			                                        		<?php
			                                        	}
			                                        ?>
			                                    </select> 
											</div>
											<div class="col-lg-4">
												<label>Button Position:</label>
												 <select name="button_position[]" id="button_position" class="form-control">
                                                	<?php echo $obj1->getFavCategoryRamakant($BP_ID,'')?>
                                            	</select>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<label>Link:</label>
												 <input type="text"  id="link" name="link[]" class="form-control" placeholder="Button Link"/>
											</div>
											<div class="col-lg-6">
												<label>Table:</label>
                                             	<select name="ref_table[]" id="ref_table" class="form-control" >
                                                 <?php echo $obj->getTableNameFrom_tbltabldropdown($tblID); ?>
                                            	</select>
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
											// $data_source=explode(',', $value['data_source']);
											// $icon_source=explode(',', $value['icon_source']);
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
			                                        	for ($i=1; $i < 12; $i++) { 
			                                        		?>
			                                        		<option value="<?=$i;?>" <?=($value['button_order']==$i)? 'selected' : ''; ?> ><?=$i?></option>
			                                        		<?php
			                                        	}
			                                        ?>
			                                    </select> 
											</div>
											<div class="col-lg-4">
												<label>Button Position:</label>
												 <select name="button_position[]" id="button_position" class="form-control">
                                                	<?php echo $obj1->getFavCategoryRamakant($BP_ID,$value['button_position'])?>
                                            	</select>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<label>Link:</label>
												 <input type="text"  id="link" name="link[]" value="<?=$value['link'];?>" class="form-control" placeholder="Button Link"/>
											</div>
											<div class="col-lg-6">
												<label>Table:</label>
                                             	<select name="ref_table[]" id="ref_table" class="form-control" >
                                                 <?php echo $obj->getTableNameFrom_tbltabldropdown($tblID,$value['ref_table']); ?>
                                            	</select>
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
	var max_fields      = 11; //maximum input boxes allowed
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
			                                    '</select>'+
											'</div>'+
											'<div class="col-lg-4">'+
												'<label>Button Position:</label>'+
												 '<select name="button_position[]" id="button_position" class="form-control">'+
                                                	'<?php echo $obj1->getFavCategoryRamakant($BP_ID,'')?>'+
                                            	'</select>'+
											'</div>'+
										'</div>'+
										'<div class="row">'+
											'<div class="col-lg-6">'+
												'<label>Link:</label>'+
												 '<input type="text"  id="link" name="link[]" class="form-control" placeholder="Button Link"/>'+
											'</div>'+
											'<div class="col-lg-6">'+
												'<label>Table:</label>'+
                                             	'<select name="ref_table[]" id="ref_table" class="form-control" >'+
                                                 '<?php echo $obj->getTableNameFrom_tbltabldropdown($tblID); ?>'+
                                            	'</select>'+
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

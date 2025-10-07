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
$id=$_GET['favcat_id'];
$cf_id=$_GET['custom_fav_id'];
if(isset($_POST['save']))
{

	$data=array();
	$count_row=count($_POST['banner_show']);
	for ($i=0; $i < $count_row; $i++) { 
		$data[] = array( 'banner_show' =>$_POST['banner_show'][$i] ,
					   	'banner_order' =>$_POST['banner_order'][$i] ,
					   	'banner' =>$_POST['banner'][$i] ,
					   	'banner_type' =>$_POST['banner_type'][$i] ,
					   	'credit_line' =>$_POST['credit_line'][$i] ,
					   	'credit_line_url' =>$_POST['credit_line_url'][$i] ,
					   	'sound_clip' =>$_POST['sound_clip'][$i] ,
				);	
	}


	$res=$obj2->update_banners_favcategory($id,$data,$count_row);

	if($res)
	{	
		$_SESSION['banner_msg'] = 'Banners Updated Successfully!';
		header("Location: index.php?mode=edit_fav_category&id=".$cf_id);
		exit(0);
	}

}

$data=$obj2->get_banners_favcategory($id);


?>

<style type="text/css">
    table.table-borderless td,
table.table-borderless th {
    border: 0!important;
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Update FavCategory Banners</td>
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
			                        <table class="table table-borderless" id="row0">
			                            <tr>
			                                <td>
			                                    <label>Banner Show:</label>
			                                </td>
			                                <td>
			                                    <select class="form-control" name="banner_show[]">
			                                        <option value="1">Yes</option>
			                                        <option value="0">No</option>
			                                    </select>  
			                                </td>
			                                <td>
			                                    <label>Banner Order:</label>
			                                </td>
			                                <td>
			                                    <select class="form-control" name="banner_order[]">
			                                        <option value="">Select</option>
	                                                <option value="1">1</option>
	                                                <option value="2">2</option>
	                                                <option value="3">3</option>
	                                                <option value="4">4</option>
	                                                <option value="5">5</option>
	                                                <option value="6">6</option>
	                                                <option value="7">7</option>
	                                                <option value="8">8</option>
	                                                <option value="9">9</option>
	                                                <option value="10">10</option>
	                                                <option value="11">11</option>
			                                    </select> 
			                                </td>
			                            </tr>
			                            <tr>
			                                <td>
			                                    <label>Banner:</label>
			                                </td>
			                                <td>
			                                    <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('IMG',0,'banner');">Gallery 1</button>
			                                    <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('OT',0,'banner');">Gallery 2</button>
			                                </td>
			                                <td></td>
			                                <td>
			                                    <button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData('banner');">Reset</button>
			                                </td>
			                            </tr>
			                            <tr>
			                                <td>
			                                    <input type="hidden" name="banner[]" id="banner" value="" readonly="">
			                                </td>
			                                <td>
			                                   <input type="text" name="banner_type[]" id="banner_type" class="form-control" value="" readonly="" placeholder="Banner Type">
			                                </td>
			                                <td>
			                                    <input type="text" id="banner_name" value="" disabled="" class="form-control" placeholder="Banner Name">
			                                </td>
			                                <td>
			                                    <input type="text" id="banner_file" value="" disabled="" class="form-control" placeholder="Banner File">
			                                </td>
			                            </tr>
			                            <tr>
			                                <td>
			                                    <label>Credit Line:</label>
			                                </td>
			                                <td>
			                                    <input type="text" class="form-control" name="credit_line[]"> 
			                                </td>
			                                <td>
			                                    <label>Credit Line URL:</label>
			                                </td>
			                                <td>
			                                    <input type="text" class="form-control" value="http://" name="credit_line_url[]"> 
			                                </td> 
			                            </tr>
			                            <tr>
			                                <td>
			                                    <label>Sound Clip:</label>
			                                </td>
			                                <td>
			                                    <select name="sound_clip[]" class="form-control">
	                                                <option value="">Select Music File </option>
	                                                <?php echo $obj->getSoundClipOptions_new(); ?>
	                                            </select>
			                                </td>
			                                <td></td>
			                                <td></td> 
			                            </tr>
			                            <tr>
			                                <td>
			                                    <button type="button" class="btn btn-info btn-xs add_more_banner">Add More</button>
			                                </td>
			                            </tr>
			                        </table>
									<?php
								}
								else
								{	
									?>
									<input type="hidden" name="count_row" id="count_row" value="<?=count($data)?>" />
									<?php
									foreach ($data as $key => $value) {
										?>
										
				                        <table class="table table-borderless" id="row<?=$key;?>">
				                            <tr>
				                                <td>
				                                    <label>Banner Show:</label>
				                                </td>
				                                <td>
				                                    <select class="form-control" name="banner_show[]">
				                                        <option value="1" <?=($value['banner_show']=='1')? 'selected' : ''; ?> >Yes</option>
				                                        <option value="0" <?=($value['banner_show']=='0')? 'selected' : ''; ?>>No</option>
				                                    </select>  
				                                </td>
				                                <td>
				                                    <label>Banner Order:</label>
				                                </td>
				                                <td>
				                                    <select class="form-control" name="banner_order[]">
				                                        <option value="">Select</option>
		                                                <?php 
		                                                for ($i=1; $i <= 11; $i++) { 
		                                                	?>
		                                                	<option value="<?=$i;?>" <?=($value['banner_order']==$i)? 'selected' : ''; ?> ><?=$i;?></option>
		                                                	<?php
		                                                }
		                                                ?>
				                                    </select> 
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>
				                                    <label>Banner:</label>
				                                </td>
				                                <td>
				                                    <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('IMG',0,'banner<?=$key;?>');">Gallery 1</button>
				                                    <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('OT',0,'banner<?=$key;?>');">Gallery 2</button>
				                                </td>
				                                <td></td>
				                                <td>
				                                    <button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData('banner<?=$key;?>');">Reset</button>
				                                </td>
				                            </tr>
				                            <tr>

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
				                                <td>
				                                    <input type="hidden" name="banner[]" id="banner<?=$key;?>" readonly="" value="<?=$value['banner'];?>">
				                                </td>
				                                <td>
				                                   <input type="text" name="banner_type[]" id="banner<?=$key;?>_type" class="form-control" readonly="" placeholder="Banner Type" value="<?=$value['banner_type'];?>">
				                                   <?php 
			                                        if(!empty($banner_file))
			                                        {
			                                                ?>
			                                                <a href="<?php echo SITE_URL.'/uploads/'. $banner_file;?>" target="_blank"><?php echo $banner_file;?></a> 
			                                                <?php
			                                        }
			                                        ?>
				                                </td>
				                                <td>
				                                    <input type="text" id="banner<?=$key;?>_name" disabled="" class="form-control" placeholder="Banner Name" value="<?=$banner_name;?>">
				                                </td>
				                                <td>
				                                    <input type="text" id="banner<?=$key;?>_file" disabled="" class="form-control" placeholder="Banner File" value="<?=$banner_file;?>">
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>
				                                    <label>Credit Line:</label>
				                                </td>
				                                <td>
				                                    <input type="text" class="form-control" id="banner<?=$key;?>_credit" name="credit_line[]" value="<?=$banner_credit;?>" readonly> 
				                                </td>
				                                <td>
				                                    <label>Credit Line URL:</label>
				                                </td>
				                                <td>
				                                    <input type="text" class="form-control" name="credit_line_url[]" id="banner<?=$key;?>_credit_url" value="<?=$banner_credit_url;?>" readonly> 
				                                </td> 
				                            </tr>
				                            <tr>
				                                <td>
				                                    <label>Sound Clip:</label>
				                                </td>
				                                <td>
				                                    <select name="sound_clip[]" class="form-control">
		                                                <option value="">Select Music File </option>
		                                                <?php echo $obj->getSoundClipOptions_new($value['sound_clip']); ?>
		                                            </select>
				                                </td>
				                                <td></td>
				                                <td></td> 
				                            </tr>
				                            <tr>
				                                <td>
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
				                                </td>
				                            </tr>
				                        </table>
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
	
	$(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
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


				html+='<table class="table table-borderless" id="row'+new_row+'">'+
		                            '<tr>'+
		                                '<td>'+
		                                    '<label>Banner Show:</label>'+
		                                '</td>'+
		                                '<td>'+
		                                    '<select class="form-control" name="banner_show[]">'+
		                                        '<option value="1">Yes</option>'+
		                                        '<option value="0">No</option>'+
		                                    '</select>'+
		                                '</td>'+
		                                '<td>'+
		                                    '<label>Banner Order:</label>'+
		                                '</td>'+
		                                '<td>'+
		                                    '<select class="form-control" name="banner_order[]">'+
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
		                                '</td>'+
		                            '</tr>'+
		                            '<tr>'+
                                        '<td>'+
                                            '<label>Banner:</label>'+
                                        '</td>'+
                                        '<td>'+
                                            '<button type="button" class="btn btn-primary btn-xs" onclick="galleryData('+gallery1+');">Gallery 1</button>'+
                                            '<button type="button" class="btn btn-primary btn-xs" onclick="galleryData('+gallery2+');">Gallery 2</button>'+
                                        '</td>'+
                                        '<td></td>'+
                                        '<td>'+
                                            '<button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData();">Reset</button>'+
                                        '</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td>'+
                                            '<input type="hidden" name="banner[]" id="banner'+new_row+'" value="" readonly="">'+
                                        '</td>'+
                                        '<td>'+
                                           '<input type="text" name="banner_type[]" id="banner'+new_row+'_type" class="form-control" value="" readonly="" placeholder="Banner Type">'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="text" id="banner'+new_row+'_name" value="" disabled="" class="form-control" placeholder="Banner Name">'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="text" id="banner'+new_row+'_file" value="" disabled="" class="form-control" placeholder="Banner File">'+
                                        '</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td>'+
                                            '<label>Credit Line:</label>'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="text" class="form-control" id="banner'+new_row+'_credit" name="credit_line[]" readonly>'+ 
                                        '</td>'+
                                        '<td>'+
                                            '<label>Credit Line URL:</label>'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="text" class="form-control" id="banner'+new_row+'_credit_url" value="http://" name="credit_line_url[]" readonly>'+ 
                                        '</td>'+
                                    '</tr>'+
                                    '<tr>'+
		                                '<td>'+
		                                    '<label>Sound Clip:</label>'+
		                                '</td>'+
		                                '<td>'+
		                                    '<select name="sound_clip[]" class="form-control">'+
                                                '<option value="">Select Music File </option>'+
                                                '<?php echo $obj->getSoundClipOptions_new(); ?>'+
                                            '</select>'+
		                                '</td>'+
		                                '<td></td>'+
		                                '<td></td>'+
		                            '</tr>'+
		                            '<tr>'+
		                                '<td>'+
		                                    '<button type="button" class="btn btn-warning btn-xs add_field_button" onclick="remove_banner('+new_row+')">Remove</button>'+
		                                '</td>'+
		                            '</tr>'+
		                        '</table>';

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


</script>

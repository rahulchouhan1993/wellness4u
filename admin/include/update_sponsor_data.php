<?php
// create new page for sponsor 19-08-20
require_once('config/class.mysql.php');

require_once('../init.php');

require_once('classes/class.rewardpoints.php');
$obj = new RewardPoint();

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
$edit_action_id = '165';

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
	$count_row=count($_POST['sponsor_list']);
	for ($i=0; $i < $count_row; $i++) { 
		//add-on by ample 07-08-20
		$data[] = array( 'sponsor_type_id' =>$_POST['sponsor_type_id'][$i] ,
					   	'sponsor_list' =>$_POST['sponsor_list'][$i] ,
					   	'sponsor_name' =>$_POST['sponsor_name'][$i],
					   	'sponsor_remark' =>$_POST['remark'][$i],
					   	'status' =>$_POST['status'][$i],
				);		
	}


	$res=$obj->update_sponsor_data($id,$data);

	if($res)
	{	
		$_SESSION['MSG'] = 'Sponsor Data Updated Successfully!';
		header("Location: index.php?mode=edit_reward_list&id=".$id);
		exit(0);
	}

}

$data=$obj->get_sponsor_data($id);


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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Update sponsor Data</td>
                        <td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
                    </tr>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<br>
				<a href="index.php?mode=edit_reward_list&id=<?=$_GET['data_id']?>"><button class="btn btn-default">Back</button></a>
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
											<div class="col-lg-6">
												<label>Sponsor Type</label>
												<select name="sponsor_type_id[]" id="sponsor_type_id_0" class="form-control" required>
                                                    <?php echo $obj->getFavCategoryRamakant('68','')?>
                                                </select>
											</div>
											<div class="col-lg-6">
												<label>Sponsor List</label>
												<select name="sponsor_list[]" id="sponsor_list_0"  class="form-control" onchange="get_sponsor_list(this)" required>
                                                    <option value="self">Self</option>
                                                    <option value="user">User</option>
                              						<option value="wa">Wellness associate</option>
                                                </select>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<label>Sponsor Name</label>
												<select name="sponsor_name[]" id="sponsor_name_0"  class="form-control" required>
                                                    <option value="Wellness">Wellness</option>
                                                </select>
											</div>
											<div class="col-lg-6">
												<label>Status</label>
												<select name="status[]"  class="form-control" required>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<label>Remark:</label>
												<textarea class="form-control" name="remark[]" rows="3"></textarea>
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
										?>
									<div class="box" id="row<?=$key;?>">
										<div class="row">
											<div class="col-lg-6">
												<label>Sponsor Type</label>
												<select name="sponsor_type_id[]" id="sponsor_type_id_<?=$key;?>" class="form-control" required>
                                                    <?php echo $obj->getFavCategoryRamakant('68',$value['sponsor_type'])?>
                                                </select>
											</div>
											<div class="col-lg-6">
												<label>Sponsor List</label>
												<select name="sponsor_list[]" id="sponsor_list_<?=$key;?>"  class="form-control tbl_link" onchange="get_sponsor_list(this,'<?=$key;?>','<?=$value['sponsor_name']?>')" required>
                                                    <option value="self" <?=($value['sponsor'] == 'self')? 'selected' : '' ;?> >Self</option>
                                                    <option value="user" <?=($value['sponsor'] == 'user')? 'selected' : '' ;?> >User</option>
                              						<option value="wa" <?=($value['sponsor'] == 'wa')? 'selected' : '' ;?> >Wellness associate</option>
                                                </select>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<label>Sponsor Name</label>
												<select name="sponsor_name[]" id="sponsor_name_<?=$key;?>"  class="form-control" required>
                                                    <option value="Wellness">Wellness</option>
                                                </select>
											</div>
											<div class="col-lg-6">
												<label>Status</label>
												<select name="status[]" class="form-control" required>
                                                    <option value="1" <?=($value['status'] == '1')? 'selected' : '' ;?> >Active</option>
                                                    <option value="0" <?=($value['status'] == '0')? 'selected' : '' ;?> >Inactive</option>
                                                </select>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<label>Remark:</label>
												<textarea class="form-control" name="remark[]" rows="3"><?=$value['sponsor_remark']?></textarea>
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
											'<div class="col-lg-6">'+
												'<label>Sponsor Type</label>'+
												'<select name="sponsor_type_id[]" id="sponsor_type_id_'+new_row+'" class="form-control" required>'+
                                                    '<?php echo $obj->getFavCategoryRamakant('68','')?>'+
                                                '</select>'+
											'</div>'+
											'<div class="col-lg-6">'+
												'<label>Sponsor List</label>'+
												'<select name="sponsor_list[]" id="sponsor_list_'+new_row+'"  class="form-control" onchange="get_sponsor_list(this,'+new_row+')" required>'+
                                                    '<option value="self">Self</option>'+
                                                    '<option value="user">User</option>'+
                              						'<option value="wa">Wellness associate</option>'+
                                                '</select>'+
											'</div>'+
										'</div>'+
										'<div class="row">'+
											'<div class="col-lg-6">'+
												'<label>Sponsor Name</label>'+
												'<select name="sponsor_name[]" id="sponsor_name_'+new_row+'"  class="form-control" required>'+
                                                   ' <option value="Wellness">Wellness</option>'+
                                                '</select>'+
											'</div>'+
											'<div class="col-lg-6">'+
												'<label>Sponsor List</label>'+
												'<select name="status[]" class="form-control" required>'+
                                                    '<option value="1">Active</option>'+
                                                    '<option value="0">Inactive</option>'+
                                                '</select>'+
											'</div>'+
											
										'</div>'+
										'<div class="row">'+
											'<div class="col-lg-12">'+
												'<label>Remark:</label>'+
												'<textarea class="form-control" name="remark[]" rows="3"></textarea>'+
											'</div>'+
										'</div>'+
										'<br>'+
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

function get_sponsor_list(select,id="0",select_value="")
    {
    	var sponsor=select.value;

    	//alert(sponsor);

    	  var dataString = 'action=get_sponsor_list&sponsor='+sponsor+'&sponsor_name='+select_value;

            $.ajax({

                    type: "POST",

                    url: "include/remote.php",

                    data: dataString,

                    cache: false,

                    success: function(result)

                    {

                            //alert(result);

                            //alert(sub_cat);

                            $("#sponsor_name_"+id).html(result);

                    }

            });

    }

    //add by ample
    $(document).ready(function()
    {
       $('.tbl_link').trigger('change');
    });


</script>

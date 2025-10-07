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

// if(!$obj->chkValidActionPermission($admin_id,$edit_action_id))
// 	{	
// 	  	header("Location: index.php?mode=invalid");
// 		exit(0);
// 	}
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
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Update Design Your Life Banners</td>
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
								<form>
								<div id="banner_box">
								<input type="hidden" name="count_row" id="count_row" value="0" />
		                        <table class="table table-borderless" id="row0">
		                            <tr>
		                                <td>
		                                    <label>Banner Show:</label>
		                                </td>
		                                <td>
		                                    <select class="form-control" name="banner_show[]">
		                                        <option>Yes</option>
		                                        <option>No</option>
		                                    </select>  
		                                </td>
		                                <td>
		                                    <label>Banner Order:</label>
		                                </td>
		                                <td>
		                                    <select class="form-control" name="banner_order[]">
		                                        <option>1</option>
		                                        <option>2</option>
		                                        <option>3</option>
		                                        <option>4</option>
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
		                                    <input type="text" class="form-control" name="credit_line_url[]"> 
		                                </td> 
		                            </tr>
		                            <tr>
		                                <td>
		                                    <button type="button" class="btn btn-info btn-xs add_more_banner">Add More</button>
		                                </td>
		                            </tr>
		                        </table>
		                    	</div>
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

				html+='<table class="table table-borderless" id="row'+new_row+'">'+
		                            '<tr>'+
		                                '<td>'+
		                                    '<label>Banner Show:</label>'+
		                                '</td>'+
		                                '<td>'+
		                                    '<select class="form-control" name="banner_show[]">'+
		                                        '<option>Yes</option>'+
		                                        '<option>No</option>'+
		                                    '</select>'+
		                                '</td>'+
		                                '<td>'+
		                                    '<label>Banner Order:</label>'+
		                                '</td>'+
		                                '<td>'+
		                                    '<select class="form-control" name="banner_order[]">'+
		                                        '<option>1</option>'+
		                                        '<option>2</option>'+
		                                        '<option>3</option>'+
		                                        '<option>4</option>'+
		                                    '</select>'+
		                                '</td>'+
		                            '</tr>'+
		                            '<tr>'+
                                        '<td>'+
                                            '<label>Banner:</label>'+
                                        '</td>'+
                                        '<td>'+
                                            '<button type="button" class="btn btn-primary btn-xs" onclick="galleryData();">Gallery 1</button>'+
                                            '<button type="button" class="btn btn-primary btn-xs" onclick="galleryData();">Gallery 2</button>'+
                                        '</td>'+
                                        '<td></td>'+
                                        '<td>'+
                                            '<button type="button" class="btn btn-danger btn-xs" onclick="ResetgalleryData();">Reset</button>'+
                                        '</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td>'+
                                            '<input type="hidden" name="banner[]" id="banner" value="" readonly="">'+
                                        '</td>'+
                                        '<td>'+
                                           '<input type="text" name="banner_type[]" id="banner_type" class="form-control" value="" readonly="" placeholder="Banner Type">'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="text" id="banner_name" value="" disabled="" class="form-control" placeholder="Banner Name">'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="text" id="banner_file" value="" disabled="" class="form-control" placeholder="Banner File">'+
                                        '</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td>'+
                                            '<label>Credit Line:</label>'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="text" class="form-control" name="credit_line[]">'+ 
                                        '</td>'+
                                        '<td>'+
                                            '<label>Credit Line URL:</label>'+
                                        '</td>'+
                                        '<td>'+
                                            '<input type="text" class="form-control" name="credit_line_url[]">'+ 
                                        '</td>'+
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
	}


</script>

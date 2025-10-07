<?php

require_once('../classes/config.php');

require_once('../classes/admin.php');

$admin_main_menu_id = '31';

$add_action_id = '32';

$page_id = '81';

$obj = new Admin();

if(!$obj->isAdminLoggedIn())

{

	header("Location: login.php");

	exit(0);

}

else

{

	$admin_id = $_SESSION['admin_id'];

}



if(!$obj->chkIfAccessOfMenu($admin_id,$admin_main_menu_id))

{

	header("Location: invalid.php");

	exit(0);

}







?><!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?php echo SITE_NAME;?> - Admin</title>

	<?php require_once 'head.php'; ?>

	<link href="assets/css/tokenize2.css" rel="stylesheet" />

</head>

<body hoe-navigation-type="vertical" hoe-nav-placement="left" theme-layout="wide-layout">

<?php include_once('header.php');?>

<div class="container">

	<div class="row">

		<div class="col-sm-10">

			<div class="panel">

				<div class="panel-body">

					<div class="row mail-header">

						<div class="col-md-6">

							<h3><?php echo $obj->getAdminActionName($add_action_id);?></h3>

						</div>

					</div>

					<hr>

					<center><div id="error_msg"></div></center>
					<?php echo $obj->getPageIcon($page_id);?> 
					<?php echo $obj->getPageContents($page_id);  ?>
					<br>
				</div>

			</div>

		</div>

		<div class="col-sm-2"><?php include_once('wa_right_sidebar.php'); ?></div>

	</div>

</div>

<?php include_once('footer.php');?>

<!--Common plugins-->

<?php require_once('script.php'); ?>

<script type="text/javascript" src="js/jquery.validate.min.js"></script>

<script src="js/tokenize2.js"></script>

<script src="admin-js/add-event-validator.js" type="text/javascript"></script>

<script>

$(document).ready(function()

{ 

        $('#event_contents').summernote();

        $('.vloc_speciality_offered').tokenize2();

	$('.clsdatepicker').datepicker();

        $('.clsdatepicker2').datepicker();

        $("input[name^='vc_cert_reg_date']").attr('autocomplete', 'off');

        $("input[id^='capitals']").attr('autocomplete', 'off');

        $("input[id^='vc_cert_validity_date']").attr('autocomplete', 'off');

        $("input[id^='start_date']").attr('autocomplete', 'off');

        $("input[id^='end_date']").attr('autocomplete', 'off');

        $("input[id^='judge_cert_reg_date']").attr('autocomplete', 'off');

        $("input[id^='judge_cert_validity_date']").attr('autocomplete', 'off');

        $("input[id^='org_cert_reg_date']").attr('autocomplete', 'off');

        $("input[id^='org_cert_validity_date']").attr('autocomplete', 'off');

       

});





function getStateOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		

                //alert(country_id);

                

		if(country_id == null)

		{

			country_id = '-1';

		}

		

		if(state_id == null)

		{

			state_id = '-1';

		}

		

		

		var dataString ='country_id='+country_id+'&state_id='+state_id+'&action=getstateoption';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

                               // alert(result);

				$("#state_id_"+id_val).html(result);

                                $('#city_id_'+id_val).val('');

				getCityOptionAddMore(id_val);

			}

		});

	}

	

	function getCityOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		var city_id = $('#city_id_'+id_val).val();

		

		if(country_id == null)

		{

			country_id = '-1';

		}

				

		if(state_id == null)

		{

			state_id = '-1';

		}

		

		if(city_id == null)

		{

			city_id = '-1';

		}

		

		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&action=getcityoption';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

                                //alert(result);

				$("#capitals_"+id_val).html(result);

				getAreaOptionAddMore(id_val);

			}

		});

	}

	

	function getAreaOptionAddMore(id_val)

	{

		var country_id = $('#country_id_'+id_val).val();

		var state_id = $('#state_id_'+id_val).val();

		var city_id = $('#city_id_'+id_val).val();

		var area_id = $('#area_id_'+id_val).val();

		

		if(country_id == null)

		{

			country_id = '-1';

		}

				

		if(state_id == null)

		{

			state_id = '-1';

		}

		

		if(city_id == null)

		{

			state_id = '-1';

		}

		

		if(area_id == null)

		{

			area_id = '-1';

		}

		

		var dataString ='country_id='+country_id+'&state_id='+state_id+'&city_id='+city_id+'&area_id='+area_id+'&action=getareaoption';

		$.ajax({

			type: "POST",

			url: "ajax/remote.php",

			data: dataString,

			cache: false,      

			success: function(result)

			{

				$("#area_id_"+id_val).html(result);

			}

		});

	}



	function addMoreRowCertificate(i_val)

	{

		

		var cert_cnt = parseInt($("#cert_cnt_"+i_val).val());

		

		cert_cnt = cert_cnt + 1;

		var new_row = '	<div id="row_cert_'+i_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

							'<input type="hidden" name="vc_cert_id_'+i_val+'[]" id="vc_cert_id_'+i_val+'_'+cert_cnt+'" value="0">'+

							'<input type="hidden" name="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" id="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" value="">'+

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Type</label>'+

								'<div class="col-lg-5">'+

									'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control">'+

										'<option value="">Select</option>'+

                                                                                ' <?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

									'</select>'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Name</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Number</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Issued By</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Issued Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Vaidity Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

								'</div>'+

							'</div>'+

							'<div class="form-group small-title">'+

									'<label class="col-lg-1 control-label">Scan Image</label>'+

									'<div class="col-lg-5">'+

										'<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+

									'</div>'+

								'</div>'+

							'<div class="form-group">'+

								'<div class="col-lg-2">'+

									'<a href="javascript:void(0);" onclick="removeRowCertificate('+i_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

								'</div>'+

							'</div>'+

						'</div>';

		

		$("#row_cert_"+i_val+"_first").after(new_row);

		$("#cert_cnt_"+i_val).val(cert_cnt);

		

		var cert_total_cnt = parseInt($("#cert_total_cnt_"+i_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+i_val).val(cert_total_cnt);

		

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

	}

        

        function addMoreRowCertificateJudge(j_val)

	{

		//alert(j_val);

                //j_val = j_val+1;

		var cert_cnt = parseInt($("#cert_cnt_"+j_val).val());

		cert_cnt = cert_cnt + 1;

		var new_row = '	<div id="row_judge_cert_'+j_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

							'<input type="hidden" name="judge_cert_id_'+j_val+'[]" id="judge_cert_id_'+j_val+'_'+cert_cnt+'" value="0">'+

							'<input type="hidden" name="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" id="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" value="">'+

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Type</label>'+

								'<div class="col-lg-5">'+

									'<select name="judge_cert_type_id_'+j_val+'[]" id="judge_cert_type_id_'+j_val+'_'+cert_cnt+'" class="form-control">'+

										'<option value="">Select</option>'+

                                                                                ' <?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

									'</select>'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Name</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="judge_cert_name_'+j_val+'[]" id="judge_cert_name_'+j_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Number</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="judge_cert_no_'+j_val+'[]" id="judge_cert_no_'+j_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Issued By</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="judge_cert_issued_by_'+j_val+'[]" id="judge_cert_issued_by_'+j_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Issued Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="judge_cert_reg_date_'+j_val+'[]" id="judge_cert_reg_date_'+j_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Vaidity Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="judge_cert_validity_date_'+j_val+'[]" id="judge_cert_validity_date_'+j_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

								'</div>'+

							'</div>'+

							'<div class="form-group small-title">'+

									'<label class="col-lg-1 control-label">Scan Image</label>'+

									'<div class="col-lg-5">'+

										'<input type="file" name="judge_cert_scan_file_'+j_val+'[]" id="judge_cert_scan_file_'+j_val+'_'+cert_cnt+'" class="form-control" >'+

									'</div>'+

								'</div>'+

							'<div class="form-group">'+

								'<div class="col-lg-2">'+

									'<a href="javascript:void(0);" onclick="removeRowCertificateJudge('+j_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

								'</div>'+

							'</div>'+

						'</div>';

		

                //alert(new_row);

		$("#row_judge_cert_"+j_val+"_first").after(new_row);

		$("#cert_cnt_"+j_val).val(cert_cnt);

		

		var cert_total_cnt = parseInt($("#cert_total_cnt_"+j_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+j_val).val(cert_total_cnt);

		

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

	}

        

        function addMoreRowCertificateOrg(k_val)

	{

		

		var cert_cnt = parseInt($("#cert_cnt_"+k_val).val());

		cert_cnt = cert_cnt + 1;

		var new_row = '	<div id="row_org_cert_'+k_val+'_'+cert_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

							'<input type="hidden" name="org_cert_id_'+k_val+'[]" id="org_cert_id_'+k_val+'_'+cert_cnt+'" value="0">'+

							'<input type="hidden" name="hdnorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" id="hdnorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" value="">'+

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Type</label>'+

								'<div class="col-lg-5">'+

									'<select name="org_cert_type_id_'+k_val+'[]" id="org_cert_type_id_'+k_val+'_'+cert_cnt+'" class="form-control">'+

										'<option value="">Select</option>'+

                                                                                ' <?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

									'</select>'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Name</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="org_cert_name_'+k_val+'[]" id="org_cert_name_'+k_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Number</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="org_cert_no_'+k_val+'[]" id="org_cert_no_'+k_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Issued By</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="org_cert_issued_by_'+k_val+'[]" id="org_cert_issued_by_'+k_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

								'</div>'+

							'</div>'+	

							'<div class="form-group small-title">'+

								'<label class="col-lg-1 control-label">Issued Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="org_cert_reg_date_'+k_val+'[]" id="org_cert_reg_date_'+k_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

								'</div>'+

								

								'<label class="col-lg-1 control-label">Vaidity Date</label>'+

								'<div class="col-lg-5">'+

									'<input type="text" name="org_cert_validity_date_'+k_val+'[]" id="org_cert_validity_date_'+k_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

								'</div>'+

							'</div>'+

							'<div class="form-group small-title">'+

									'<label class="col-lg-1 control-label">Scan Image</label>'+

									'<div class="col-lg-5">'+

										'<input type="file" name="org_cert_scan_file_'+k_val+'[]" id="org_cert_scan_file_'+k_val+'_'+cert_cnt+'" class="form-control" >'+

									'</div>'+

								'</div>'+

							'<div class="form-group">'+

								'<div class="col-lg-2">'+

									'<a href="javascript:void(0);" onclick="removeRowCertificateOrg('+k_val+','+cert_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

								'</div>'+

							'</div>'+

						'</div>';

		

		$("#row_org_cert_"+k_val+"_first").after(new_row);

		$("#cert_cnt_"+k_val).val(cert_cnt);

		

		var cert_total_cnt = parseInt($("#cert_total_cnt_"+k_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+k_val).val(cert_total_cnt);

		

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

	}

	

	function removeRowCertificate(i_val,cert_cnt)

	{

		$("#row_cert_"+i_val+"_"+cert_cnt).remove();



		var cert_total_cnt = parseInt($("#cert_total_cnt_"+i_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+i_val).val(cert_total_cnt);

		

	}

	

        function removeRowCertificateJudge(j_val,cert_cnt)

	{

		$("#row_judge_cert_"+j_val+"_"+cert_cnt).remove();



		var cert_total_cnt = parseInt($("#cert_total_cnt_"+j_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+j_val).val(cert_total_cnt);

		

	}

        

        function removeRowCertificateOrg(k_val,cert_cnt)

	{

		$("#row_org_cert_"+k_val+"_"+cert_cnt).remove();



		var cert_total_cnt = parseInt($("#cert_total_cnt_"+k_val).val());

		cert_total_cnt = cert_total_cnt + 1;

		$("#cert_total_cnt_"+k_val).val(cert_total_cnt);

		

	}

        

        

	function addMoreRowLocation()

	{

		//alert("Hiii");

		var cat_cnt = parseInt($("#cat_cnt").val());

		cat_cnt = cat_cnt + 1;

		

		var i_val = cat_cnt;

                var j_val = cat_cnt;

                var k_val = cat_cnt;

		var cert_cnt = 0;

		var new_row = 	'<div id="row_loc_'+cat_cnt+'" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

							'<input type="hidden" name="cert_cnt_'+cat_cnt+'" id="cert_cnt_'+cat_cnt+'" value="'+cert_cnt+'">'+

							'<input type="hidden" name="cert_total_cnt_'+cat_cnt+'" id="cert_total_cnt_'+cat_cnt+'" value="1">'+

							'<input type="hidden" name="cert_loop_cnt[]" id="cert_loop_cnt_'+cat_cnt+'" value="'+cat_cnt+'">'+

							'<input type="hidden" name="hdnvloc_doc_file[]" id="hdnvloc_doc_file_'+cat_cnt+'" value="">'+

							'<input type="hidden" name="hdnvloc_menu_file[]" id="hdnvloc_menu_file_'+cat_cnt+'" value="">'+

							'<input type="hidden" name="vloc_id[]" id="vloc_id_'+cat_cnt+'" value="0">'+

                                                        '<input type="hidden" name="hdn_default_cat_id" id="hdn_default_cat_id_'+cat_cnt+'" value="<?php echo $default_vloc_cat_id; ?>">'+

							'<div class="form-group left-label">'+

								'<label class="col-lg-3 control-label"><strong>Event Details:</strong></label>'+

							'</div>'+

                                                        '<div class="form-group">'+

                                                                    '<label class="col-lg-2 control-label">Event Format<span style="color:red">*</span></label>'+

                                                                    '<div class="col-lg-4">'+

                                                                        '<select name="event_format[]" required="" id="event_format_'+cat_cnt+'" class="form-control" onchange="CheckTeamType('+cat_cnt+');">'+

                                                                            '<option value="">Select Event Format</option>'+

                                                                            '<?php echo $obj->getFavCategoryRamakant('74',''); ?>'+

                                                                        '</select>'+

                                                                    '</div>'+

                                                            '</div>'+

							'<div class="form-group">';

                                                        <?php

                                                            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'location_category'))

                                                            { ?>

                                                    new_row +='<label class="col-lg-2 control-label">Location Category</label>'+

								'<div class="col-lg-4">'+

									'<select name="vloc_parent_cat_id[]" id="vloc_parent_cat_id_'+cat_cnt+'" class="form-control"  onchange="getMainCategoryOptionAddMoreCommonLOCPlus(\'vloc\','+cat_cnt+');"  >'+

										'<?php echo $obj2->getMainProfileOptionLOC($arr_vloc_parent_cat_id[0],'1','0',$default_vloc_parent_cat_id);?>'+

									'</select>'+

								'</div>'+

								'<div class="col-lg-2"></div>'+

								'<div class="col-lg-4">'+

									'<select name="vloc_cat_id[]" id="vloc_cat_id_'+cat_cnt+'" class="form-control">'+

										'<?php echo $obj->getMainCategoryOptionLOC($arr_vloc_parent_cat_id[0],$arr_vloc_cat_id[0],'1','',$default_vloc_cat_id); ?>'+

									'</select>'+

								'</div>';

                                                            <?php

								}

								else

								{ ?>

                                                    new_row +='<input type="hidden" name="vloc_parent_cat_id[]" id="vloc_parent_cat_id" value="">';

                                                    new_row +='<input type="hidden" name="vloc_cat_id[]" id="vloc_cat_id" value="">';

                                                            <?php 

                                                                } 

                                                                ?>          

                                                    new_row +='</div>';

                                                         <?php

                                                                if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'country_id'))

                                                                { ?>

                                                        new_row +='<div class="form-group" >'+

                                                        

								'<label class="col-lg-2 control-label">Country<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select name="country_id[]" id="country_id_'+cat_cnt+'" onchange="getStateOptionAddMore('+cat_cnt+')" class="form-control" required>'+

										'<?php echo $obj->getCountryOption(''); ?>'+

									'</select>'+

								'</div>'+

								'<label class="col-lg-2 control-label">State<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select name="state_id[]" id="state_id_'+cat_cnt+'" onchange="getCityOptionAddMore('+cat_cnt+')" class="form-control" required>'+

										'<?php echo $obj->getStateOption('',''); ?>'+

									'</select>'+

								'</div>'+

							'</div>';

                                                        <?php

                                                                }

                                                                else

                                                                { ?>

                                                                        new_row +='<input type="hidden" name="country_id[]" id="country_id" value="">';	

                                                                        new_row +='<input type="hidden" name="state_id[]" id="state_id" value="">';	

                                                                <?php

                                                                } ?>

                                                              

							new_row +='<div class="form-group">';	

                                                                <?php

                                                                if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'city_id'))

                                                                { ?>

								new_row +='<label class="col-lg-2 control-label">City<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

                                                                        '<input type="text" required="" name="city_id[]" id="city_id_'+cat_cnt+'" placeholder="Select your city" list="capitals_'+cat_cnt+'" class="form-control" onchange="getlocation('+cat_cnt+')" />'+

									'<datalist id="capitals_'+cat_cnt+'">'+

                                                                        '<?php echo $obj->getCityOptions(); ?>'+

                                                                    '</datalist>'+

								'</div>'+

								'<label class="col-lg-2 control-label">Area<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select name="area_id[]" id="area_id_'+cat_cnt+'" class="form-control" required>'+

										'<?php echo $obj->getAreaOption('','','',''); ?>'+

									'</select>'+

								'</div>';

                                                                 <?php

                                                                }

                                                                else

                                                                { ?>

                                                                        new_row +='<input type="hidden" name="city_id[]" id="city_id" value="">';	

                                                                        new_row +='<input type="hidden" name="area_id[]" id="area_id" value="">';	

                                                                <?php

                                                                } ?>

							new_row +='</div>'+

                                                        '<div class="form-group">';

                                                                 <?php

                                                                if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'venue_details'))

                                                                { ?>

								new_row +='<label class="col-lg-2 control-label">Venue <span style="color:red">*</span></label>'+

								'<div class="col-lg-10">'+

                                                                    '<textarea name="venue[]" id="venue_'+cat_cnt+'" class="form-control" required></textarea>'+

								'</div>';

                                                                <?php

                                                                }

                                                                else

                                                                { ?>

                                                                       new_row +='<input type="hidden" name="venue_details" id="venue_details" value="">';	

                                                                <?php

                                                                } ?>

                                                                

							new_row +='</div>'+

                                                        '<div class="form-group small-title">';

                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'start_date'))

                                                                    { ?>

									new_row +='<label class="col-lg-2 control-label">Start Date <span style="color:red">*</span></label>'+

									'<div class="col-lg-4">'+

										'<input type="text" required name="start_date[]" id="start_date_'+cat_cnt+'" style="width:200px; float:left;"  placeholder="Start Date" class="form-control clsdatepicker">'+

                                                                                '<select name="start_time[]" id="start_time_'+cat_cnt+'" class="form-control" style="width:120px;" required>'+

                                                                                   '<option value="">Select Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                                '</select>'+

                                                                        '</div>'+

									'<label class="col-lg-2 control-label">End Date<span style="color:red">*</span></label>'+

									'<div class="col-lg-4">'+

										'<input required type="text" name="end_date[]" id="end_date_'+cat_cnt+'" style="width:200px; float:left;  placeholder="End Date" class="form-control clsdatepicker">'+

                                                                                '<select required name="end_time[]" id="end_time_'+cat_cnt+'" class="form-control" style="width:100px;">'+

                                                                                   '<option value="">Select Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                                '</select>'+

                                                                        '</div>';

                                                                         <?php

                                                                            }

                                                                            else

                                                                            { ?>

                                                                                new_row +='<input type="hidden" name="start_date[]" id="start_date" value="">'+

                                                                                '<input type="hidden" name="start_time[]" id="start_time" value="">'+

                                                                                '<input type="hidden" name="end_date[]" id="end_date" value="">'+

                                                                                '<input type="hidden" name="end_time[]" id="end_time" value="">';

                                                                            <?php

                                                                            } ?>

                                                                        

								new_row +='</div>'+

                                                                '<div class="form-group">';

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'time_zone'))

                                                                    { ?>

                                                                    new_row +='<label class="col-lg-2 control-label">Time Zone<span style="color:red">*</span></label>'+

                                                                    '<div class="col-lg-10">'+

                                                                        '<select required name="time_zone[]" id="time_zone_'+cat_cnt+'" class="form-control">'+

                                                                            '<option value="">Select Time Zone</option>'+

                                                                            '<?php echo $obj->getFavCategoryRamakant('59',''); ?>'+

                                                                        '</select>'+

                                                                    '</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="time_zone[]" id="time_zone" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                    

                                                            new_row +='</div>'+

                                                                    

                                                            '<div class="form-group left-label">'+

                                                                    '<label class="col-lg-3 control-label"><strong>Sessions:</strong></label>'+

                                                            '</div>'+

                                                            '<div class="form-group">'+

									'<label class="col-lg-2 control-label">Slot 1<span style="color:red">*</span></label>'+

									'<div class="col-lg-4">'+

                                                                            '<select name="slot1_start_time[]" id="slot1_start_time_'+cat_cnt+'" required=""  style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                   '<option value="">From Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                            '<select name="slot1_end_time[]" id="slot1_end_time_'+cat_cnt+'" required=""  style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                   '<option value="">To Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                        '</div>'+

									

									'<label class="col-lg-2 control-label">Slot 2</label>'+

									'<div class="col-lg-4">'+

                                                                            '<select name="slot2_start_time[]" id="slot2_start_time_'+cat_cnt+'"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                   '<option value="">From Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                            '<select name="slot2_end_time[]" id="slot2_end_time_'+cat_cnt+'"  style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                   '<option value="">To Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                        '</div>'+

                                                            '</div>'+

                                                        '<div class="form-group">'+

									'<label class="col-lg-2 control-label">Slot 3</label>'+

									'<div class="col-lg-4">'+

                                                                            '<select name="slot3_start_time[]" id="slot3_start_time_'+cat_cnt+'"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                   '<option value="">From Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                            '<select name="slot3_end_time[]" id="slot3_end_time_'+cat_cnt+'"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                   '<option value="">To Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                        '</div>'+

									

									'<label class="col-lg-2 control-label">Slot 4</label>'+

									'<div class="col-lg-4">'+

                                                                            '<select name="slot4_start_time[]" id="slot4_start_time_'+cat_cnt+'"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                  '<option value="">From Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                            '<select name="slot4_end_time[]" id="slot4_end_time_'+cat_cnt+'"  style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                   '<option value="">To Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                        '</div>'+

                                                            '</div>'+

                                                            '<div class="form-group">'+

									'<label class="col-lg-2 control-label">Slot 5</label>'+

									'<div class="col-lg-4">'+

                                                                            '<select name="slot5_start_time[]" id="slot5_start_time_'+cat_cnt+'"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                   '<option value="">From Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                            '<select name="slot5_end_time[]" id="slot5_end_time_'+cat_cnt+'"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                   '<option value="">To Time</option>'+

                                                                                   '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                        '</div>'+

									

									'<label class="col-lg-2 control-label">Slot 6</label>'+

									'<div class="col-lg-4">'+

                                                                            '<select name="slot6_start_time[]" id="slot6_start_time_'+cat_cnt+'"   style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                   '<option value="">From Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                            '<select name="slot6_end_time[]" id="slot6_end_time_'+cat_cnt+'"  style="width:130px; height: 34px; font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;">'+

                                                                                   '<option value="">To Time</option>'+

                                                                                    '<?php echo $obj->getTimeOptionsNew('0','23',$bes_time ); ?>'+

                                                                             '</select>'+

                                                                        '</div>'+

                                                            '</div>'+ 

                                                            '<div class="form-group">';

                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'venue_image'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Venue Image/Pdf <span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<input required type="file" name="venue_image_file[]" id="venue_image_file_'+cat_cnt+'" class="form-control">'+

								'</div>';

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="venue_image_file[]" id="venue_image_file" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                    <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'event_image'))

                                                                    { ?>        

								new_row +='<label class="col-lg-2 control-label">Event Image/Pdf</label>'+

								'<div class="col-lg-4">'+

									'<input type="file" name="event_image_file[]" id="event_image_file_'+cat_cnt+'" class="form-control">'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="event_image_file[]" id="event_image_file" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                

							new_row +='</div>'+

                                                         '<div class="form-group">';

                                                            

                                                                 <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'no_of_groups'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">No of Groups <span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

                                                                    '<input type="text" name="no_of_groups[]" required onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_groups_'+cat_cnt+'" class="form-control">'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="no_of_groups[]" id="no_of_groups" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                  <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'no_of_teams'))

                                                                    { ?>          

                                                                new_row +='<label class="col-lg-2 control-label" id="no_of_teams_level_'+cat_cnt+'">No of Teams <span style="color:red">*</span></label>'+

								'<div class="col-lg-4" id="no_of_teams_div_'+cat_cnt+'">'+

                                                                    '<input type="text" name="no_of_teams[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_teams_'+cat_cnt+'" class="form-control">'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="no_of_teams[]" id="no_of_teams" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

							new_row +='</div>'+

                                                       '<div class="form-group">';

                                                        <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'no_of_participants'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">No of participants per team <span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

                                                                    '<input type="text" required name="no_of_participants[]" onKeyPress="return isNumberKey(event);" maxlength="5" id="no_of_participants_'+cat_cnt+'" class="form-control">'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="no_of_participants[]" id="no_of_participants" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'no_of_judges'))

                                                                    { ?>

                                                                

                                                                

                                                                new_row +='<label class="col-lg-2 control-label">No of judges <span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

                                                                    '<input type="text" required name="no_of_judges[]" onKeyPress="return isNumberKey(event);" maxlength="3" id="no_of_judges_'+cat_cnt+'" class="form-control">'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="no_of_judges[]" id="no_of_judges" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

							new_row +='</div>'+

                                                        '<div class="form-group">';

                                                            <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'rules_regulation_pdf'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Rules and regulation Image/Pdf <span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<input type="file" required name="vloc_menu_file[]" id="vloc_menu_file_'+cat_cnt+'" class="form-control">'+

								'</div>';

								<?php }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="vloc_menu_file[]" id="vloc_menu_file" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'institution_profile_pdf'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Institution Profile Pdf</label>'+

								'<div class="col-lg-4">'+

									'<input type="file" name="vloc_doc_file[]" id="vloc_doc_file_'+cat_cnt+'" class="form-control">'+

								'</div>';

                                                                 <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="vloc_doc_file[]" id="vloc_doc_file" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

							new_row +='</div>'+

                                                        '<div class="form-group left-label">'+

								'<label class="col-lg-3 control-label"><strong>Participants Criteria:</strong></label>'+

							'</div>'+

                                                        

                                                        '<div class="form-group">';

                                                

                                                        <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'institution_profile_pdf'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select name="participants_title[]" id="participants_title_'+cat_cnt+'" class="form-control" required>'+                                                                            

                                                                                '<?php echo $obj->getPersonTitleOption('');?>'+

                                                                                '<option value="All">All</option>'+

									'</select>'+

								'</div>';

                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="participants_title[]" id="participants_title" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_special_remark'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Special Remarks<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

                                                                        '<textarea required class="form-control" name="parti_remarks[]" id="parti_remarks_'+cat_cnt+'"></textarea>'+

                                                                '</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="parti_remarks[]" id="parti_remarks" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                

							new_row +='</div>'+

                                                       

                                                        '<div class="form-group">';

                                                         <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_from_age_group'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">From Age Group</label>'+

								'<div class="col-lg-4">'+

									 '<input  type="text" name="from_age[]" id="from_age_'+cat_cnt+'"  placeholder="From age" class="form-control" >'+

								'</div>';

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="from_age[]" id="from_age" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_to_age_group'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">To Age Group</label>'+

								'<div class="col-lg-4">'+

                                                                       '<input  type="text" name="to_age[]" id="to_age_'+cat_cnt+'"  placeholder="To age" class="form-control" >'+

                                                                '</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="to_age[]" id="to_age" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                       new_row +='</div>'+

                                                       '<div class="form-group">';

                                                               <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_from_height'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Height From</label>'+

								'<div class="col-lg-4">'+

									'<select name="from_height[]" id="from_height_'+cat_cnt+'" class="form-control" >'+

                                                                            '<option value="">Select Height</option>'+

										'<?php   echo $obj->getHeightOptions(0);?>'+	

                                                                       '</select>'+

								'</div>';

								 <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="from_height[]" id="from_height" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

								<?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_to_height'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Height To</label>'+

								'<div class="col-lg-4">'+

                                                                    '<select name="to_height[]" id="to_height_'+cat_cnt+'" class="form-control" >'+

                                                                            '<option value="">Select Height</option>'+

										'<?php   echo $obj->getHeightOptions(0);?>'+

                                                                        '</select>'+

								'</div>';

                                                                 <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="to_height[]" id="to_height" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

							new_row +='</div>'+

                                                        '<div class="form-group">';

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_from_weight'))

                                                                    { ?>

                                                                new_row +='<label class="col-lg-2 control-label">From Weight</label>'+

								'<div class="col-lg-4">'+

									'<select name="from_weight[]" id="from_weight_'+cat_cnt+'" class="form-control" >'+

                                                                            '<option value="">Select Weight</option>'+

										'<?php

										for($we=45;$we<=200;$we++)

										{ ?>'+

											'<option value="<?php echo $we;?>" <?php if($weight == $we) { ?> selected="selected" <?php } ?>><?php echo $we;?> Kgs</option>'+

										'<?php

										} ?>'+	

                                                                        '</select>'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="from_weight[]" id="from_weight" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

								<?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'participants_to_weight'))

                                                                    { ?>

                                                                new_row +='<label class="col-lg-2 control-label">Weight</label>'+

								'<div class="col-lg-4">'+

                                                                    '<select name="to_weight[]" id="to_weight_'+cat_cnt+'" class="form-control" >'+

                                                                            '<option value="">Select Weight</option>'+

										'<?php

										for($we=45;$we<=200;$we++)

										{ ?>'+

											'<option value="<?php echo $we;?>" <?php if($weight == $we) { ?> selected="selected" <?php } ?>><?php echo $we;?> Kgs</option>'+

										'<?php

										} ?>'+	

                                                                        '</select>'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="to_weight[]" id="to_weight" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                       new_row +='</div>'+

                                                       

                                                       '<div class="form-group left-label">'+

								'<label class="col-lg-6 control-label"><strong>Participants Registration, Certification & Memberships:(As applicable)</strong></label>'+

							'</div>'+

                                                       

							'<div id="row_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

								'<input type="hidden" name="vc_cert_id_'+i_val+'[]" id="vc_cert_id_'+i_val+'_'+cert_cnt+'" value="0">'+

								'<input type="hidden" name="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" id="hdnvc_cert_scan_file_'+i_val+'_'+cert_cnt+'" value="">'+

								'<div class="form-group small-title">';

                                                                 <?php

                                                                        if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_type'))

                                                                        { ?>

									 new_row +='<label class="col-lg-1 control-label">Type</label>'+

									'<div class="col-lg-5">'+

										'<select name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_'+i_val+'_'+cert_cnt+'" class="form-control" >'+

											'<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

										'</select>'+

									'</div>';

									<?php

                                                                        }

                                                                        else

                                                                        { ?>

                                                                                new_row +='<input type="hidden" name="vc_cert_type_id_'+i_val+'[]" id="vc_cert_type_id_" value="">';



                                                                        <?php

                                                                        } ?>

                                                                        <?php

                                                                        if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_name'))

                                                                        { ?>

									new_row +='<label class="col-lg-1 control-label">Name</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_'+i_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

									'</div>';

                                                                        <?php

                                                                        }

                                                                        else

                                                                        { ?>

                                                                                new_row +='<input type="hidden" name="vc_cert_name_'+i_val+'[]" id="vc_cert_name_" value="">';



                                                                        <?php

                                                                        } ?>

								new_row +='</div>'+	

								'<div class="form-group small-title">';

                                                                    <?php

                                                                        if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_number'))

                                                                        { ?>

									new_row +='<label class="col-lg-1 control-label">Number</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="vc_cert_no_'+i_val+'[]" id="vc_cert_no_'+i_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

									'</div>';

									<?php

                                                                            }

                                                                            else

                                                                            { ?>

                                                                                   new_row +='<input type="hidden" name="vc_cert_no_'+i_val+'[]" id="vc_cert_name_" value="">';



                                                                            <?php

                                                                            } ?>



                                                                               <?php

                                                                            if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_issue_by'))

                                                                            { ?>

									new_row +='<label class="col-lg-1 control-label">Issued By</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

									'</div>';

                                                                        <?php

                                                                            }

                                                                            else

                                                                            { ?>

                                                                                    new_row +='<input type="hidden" name="vc_cert_issued_by_'+i_val+'[]" id="vc_cert_issued_by_'+i_val+'" value="">';



                                                                            <?php

                                                                            } ?>  

								new_row +='</div>'+	

								'<div class="form-group small-title">';

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_issue_date'))

                                                                    { ?>

									 new_row +='<label class="col-lg-1 control-label">Issued Date</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

									'</div>';

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="vc_cert_reg_date_'+i_val+'[]" id="vc_cert_reg_date_'+i_val+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>  

									 <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_validity_date'))

                                                                    { ?>

									 new_row +='<label class="col-lg-1 control-label">Vaidity Date</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

									'</div>';

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="vc_cert_validity_date_'+i_val+'[]" id="vc_cert_validity_date_'+i_val+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>  

								 new_row +='</div>'+

								'<div class="form-group small-title">';

                                                                                 <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'vc_certificate_scan_copy'))

                                                                    { ?>

										new_row +='<label class="col-lg-1 control-label">Scan Image</label>'+

										'<div class="col-lg-5">'+

											'<input type="file" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'_'+cert_cnt+'" class="form-control" >'+

										'</div>';

                                                                    <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="vc_cert_scan_file_'+i_val+'[]" id="vc_cert_scan_file_'+i_val+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>       

									new_row +='</div>'+

								'<div class="form-group">'+

									'<div class="col-lg-2">'+

										'<a href="javascript:void(0);" onclick="addMoreRowCertificate('+i_val+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>'+

									'</div>'+

								'</div>'+

							'</div>'+

                                                         

                                                         '<div class="form-group left-label">'+

								'<label class="col-lg-3 control-label"><strong>Judge Criteria:</strong></label>'+

							'</div>'+

                                                        

                                                        '<div class="form-group">';

                                                            <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_gender'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select name="judge_title[]" id="judge_title_'+cat_cnt+'" class="form-control" required>'+                                                                           

                                                                                '<?php echo $obj->getPersonTitleOption('');?>'+

                                                                                '<option value="All">All</option>'+

									'</select>'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="judge_title" id="judge_title_'+cat_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>  

                                                                            <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_special_remark'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Special Remarks<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									

                                                                        '<textarea class="form-control" name="judge_remarks[]" id="judge_remarks_'+cat_cnt+'" required></textarea>'+

                                                                '</div>';

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="judge_remarks[]" id="judge_remarks_'+cat_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

							new_row +='</div>'+

                                                        '<div class="form-group left-label">'+

								'<label class="col-lg-6 control-label"><strong>Judge Registration, Certification & Memberships:(As applicable)</strong></label>'+

							'</div>'+

                                                        

                                                        '<div id="row_judge_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

								'<input type="hidden" name="judge_cert_id_'+j_val+'[]" id="judge_cert_id_'+j_val+'_'+cert_cnt+'" value="0">'+

								'<input type="hidden" name="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" id="hdnjudge_cert_scan_file_'+j_val+'_'+cert_cnt+'" value="">'+

								'<div class="form-group small-title">';

                                                                 <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_type'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Type</label>'+

									'<div class="col-lg-5">'+

										'<select name="judge_cert_type_id_'+j_val+'[]" id="judge_cert_type_id_'+j_val+'_'+cert_cnt+'" class="form-control">'+

											'<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

										'</select>'+

									'</div>';

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="judge_cert_type_id_'+j_val+'[]" id="judge_cert_type_id_'+j_val+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_name'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Name</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="judge_cert_name_'+j_val+'[]" id="judge_cert_name_'+j_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

									'</div>';

                                                                         <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="judge_cert_name_'+j_val+'[]" id="judge_cert_name_'+j_val+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

								new_row +='</div>'+	

								'<div class="form-group small-title">';

                                                                 <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_number'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Number</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="judge_cert_no_'+j_val+'[]" id="judge_cert_no_'+j_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

									'</div>';

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="judge_cert_no_'+j_val+'[]" id="judge_cert_no_'+j_val+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_issue_by'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Issued By</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="judge_cert_issued_by_'+j_val+'[]" id="judge_cert_issued_by_'+j_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

									'</div>';

                                                                         <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="judge_cert_issued_by_'+j_val+'[]" id="judge_cert_issued_by_'+j_val+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

								new_row +='</div>'+	

								'<div class="form-group small-title">';

                                                                 <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_issue_date'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Issued Date</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="judge_cert_reg_date_'+j_val+'[]" id="judge_cert_reg_date_'+j_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

									'</div>';

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="judge_cert_reg_date_'+j_val+'[]" id="judge_cert_reg_date_'+j_val+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                    <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_validity_date'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Vaidity Date</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="judge_cert_validity_date_'+j_val+'[]" id="judge_cert_validity_date_'+j_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

									'</div>';

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="judge_cert_validity_date_'+j_val+'[]" id="judge_cert_validity_date_'+j_val+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

								new_row +='</div>'+

								'<div class="form-group small-title">';

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'judge_certificate_scan_copy'))

                                                                    { ?>

										new_row +='<label class="col-lg-1 control-label">Scan Image</label>'+

										'<div class="col-lg-5">'+

											'<input type="file" name="judge_cert_scan_file_'+j_val+'[]" id="judge_cert_scan_file_'+j_val+'_'+cert_cnt+'" class="form-control" >'+

										'</div>';

                                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="judge_cert_scan_file_'+j_val+'[]" id="judge_cert_scan_file_'+j_val+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

									new_row +='</div>'+

								'<div class="form-group">'+

									'<div class="col-lg-2">'+

										'<a href="javascript:void(0);" onclick="addMoreRowCertificateJudge('+j_val+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>'+

									'</div>'+

								'</div>'+

							'</div>'+

                                                        

                                                        '<div class="form-group left-label">'+

								'<label class="col-lg-3 control-label"><strong>Organiser Social Media Details:</strong></label>'+

							'</div>'+



                                                       '<div class="form-group">';

                                                       <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_facebook_page'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Facebook</label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="facebook_page_link[]" id="facebook_page_link_'+cat_cnt+'"  placeholder="Facebook Page Link" class="form-control" >'+

								'</div>';

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="facebook_page_link[]" id="facebook_page_link_'+cat_cnt+'" value="">';'

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_twitter_page'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Twitter</label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="twitter_page_link[]" id="twitter_page_link_'+cat_cnt+'" placeholder="Twitter Page Link" class="form-control" >'+

								'</div>';

                                                                 <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="twitter_page_link[]" id="twitter_page_link_'+cat_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

							new_row +='</div>'+

                                                        

                                                        '<div class="form-group">';

                                                        <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_instagram_page'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Instagram</label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="instagram_page_link[]" id="instagram_page_link_'+cat_cnt+'" placeholder="Instgram Page Link" class="form-control" >'+

								'</div>';

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="instagram_page_link[]" id="instagram_page_link_'+cat_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_youtube_channel'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Youtube</label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="youtube_page_link[]" id="youtube_page_link_'+cat_cnt+'"  placeholder="Youtube Channel Link" class="form-control" >'+

								'</div>';

                                                                 <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="youtube_page_link[]" id="youtube_page_link_'+cat_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

							new_row +='</div>'+

                                                        '<div class="form-group left-label">'+

								'<label class="col-lg-3 control-label"><strong>Organiser Contact Details:</strong></label>'+

							'</div>'+

                                                        '<div class="form-group">';

                                                        <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_gender'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Gender<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select name="contact_person_title[]" id="contact_person_title_'+cat_cnt+'" class="form-control" required>'+

										'<?php echo $obj->getPersonTitleOption('');?>'+

									'</select>'+

								'</div>';

								 <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="contact_person_title[]" id="contact_person_title_'+cat_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                   <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_contact_person'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Contact Person<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="contact_person[]" id="contact_person_'+cat_cnt+'"  placeholder="Contact Person" class="form-control" required>'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="contact_person[]" id="contact_person_'+cat_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

							new_row +='</div>'+

							'<div class="form-group">';

                                                        <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_email'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Contact Email<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="contact_email[]" id="contact_email_'+cat_cnt+'"  placeholder="Contact Email" class="form-control" required>'+

								'</div>';

								<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="contact_email[]" id="contact_email_'+cat_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                   <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_contact_number'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Contact Number<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="contact_number[]" id="contact_number_'+cat_cnt+'"  placeholder="Contact Number" class="form-control" required>'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="contact_number[]" id="contact_number_'+cat_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

							new_row +='</div>'+

							'<div class="form-group">';

                                                        <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_designation'))

                                                                    { ?>

								new_row +='<label class="col-lg-2 control-label">Contact Designation<span style="color:red">*</span></label>'+

								'<div class="col-lg-4">'+

									'<select required name="contact_designation[]" id="contact_designation_'+cat_cnt+'" class="form-control">'+

										'<option value="">Select</option>'+

                                                                                '<?php echo $obj->getFavCategoryRamakant('44',''); ?>'+

									'</select>'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="contact_designation[]" id="contact_designation_'+cat_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'organiser_remarks'))

                                                                    { ?>

								

								new_row +='<label class="col-lg-2 control-label">Remark</label>'+

								'<div class="col-lg-4">'+

									'<input type="text" name="contact_remark[]" id="contact_remark_'+cat_cnt+'"  placeholder="Remark" class="form-control">'+

								'</div>';

                                                                <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="contact_remark[]" id="contact_remark_'+cat_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

							new_row +='</div>'+

                                                        '<div class="form-group left-label">'+

								'<label class="col-lg-6 control-label"><strong>Organisers Licences, Registration, Certification & Memberships:</strong></label>'+

							'</div>'+

                                                        '<div id="row_org_cert_'+cat_cnt+'_first" style="border:1px solid #CCC;padding:5px;margin: 10px 0px;">'+

								'<input type="hidden" name="org_cert_id_'+k_val+'[]" id="org_cert_id_'+k_val+'_'+cert_cnt+'" value="0">'+

								'<input type="hidden" name="hdnorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" id="hdnjorg_cert_scan_file_'+k_val+'_'+cert_cnt+'" value="">'+

								'<div class="form-group small-title">';

                                                                 <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_type'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Type</label>'+

									'<div class="col-lg-5">'+

										'<select name="org_cert_type_id_'+k_val+'[]" id="org_cert_type_id_'+k_val+'_'+cert_cnt+'" class="form-control" >'+

											'<?php echo $obj->getFavCategoryRamakant('47',''); ?>'+

										'</select>'+

									'</div>';

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="org_cert_type_id_'+k_val+'[]" id="org_cert_type_id_'+k_val+'_'+cert_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_name'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Name</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="org_cert_name_'+k_val+'[]" id="org_cert_name_'+k_val+'_'+cert_cnt+'" value="" placeholder="Name" class="form-control">'+

									'</div>';

                                                                         <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="org_cert_name_'+k_val+'[]" id="org_cert_name_'+k_val+'_'+cert_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

								new_row +='</div>'+	

								'<div class="form-group small-title">';

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_number'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Number</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="org_cert_no_'+k_val+'[]" id="org_cert_no_'+k_val+'_'+cert_cnt+'" value="" placeholder="Number" class="form-control">'+

									'</div>';

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="org_cert_no_'+k_val+'[]" id="org_cert_no_'+k_val+'_'+cert_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                    <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_issue_by'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Issued By</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="org_cert_issued_by_'+k_val+'[]" id="org_cert_issued_by_'+k_val+'_'+cert_cnt+'" value="" placeholder="Issued By" class="form-control">'+

									'</div>';

                                                                         <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="org_cert_issued_by_'+k_val+'[]" id="org_cert_issued_by_'+k_val+'_'+cert_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

								new_row +='</div>'+	

								'<div class="form-group small-title">';

                                                                <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_issue_date'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Issued Date</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="org_cert_reg_date_'+k_val+'[]" id="org_cert_reg_date_'+k_val+'_'+cert_cnt+'" value="" placeholder="Issued Date" class="form-control clsdatepicker2">'+

									'</div>';

									<?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="org_cert_reg_date_'+k_val+'[]" id="org_cert_reg_date_'+k_val+'_'+cert_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

                                                                             <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_validity_date'))

                                                                    { ?>

									new_row +='<label class="col-lg-1 control-label">Vaidity Date</label>'+

									'<div class="col-lg-5">'+

										'<input type="text" name="org_cert_validity_date_'+k_val+'[]" id="org_cert_validity_date_'+k_val+'_'+cert_cnt+'" value="" placeholder="Validity Date" class="form-control clsdatepicker">'+

									'</div>';

                                                                        <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="org_cert_validity_date_'+k_val+'[]" id="org_cert_validity_date_'+k_val+'_'+cert_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

								new_row +='</div>'+

								'<div class="form-group small-title">';

                                                                 <?php

                                                                    if($obj->chkIfShowVendorAccessFormFieldFromVAFID($vaf_id,'org_certificate_scan_copy'))

                                                                    { ?>

										new_row +='<label class="col-lg-1 control-label">Scan Image</label>'+

										'<div class="col-lg-5">'+

											'<input type="file" name="org_cert_scan_file_'+k_val+'[]" id="org_cert_scan_file_'+k_val+'_'+cert_cnt+'" class="form-control" >'+

										'</div>';

                                                                    <?php

                                                                    }

                                                                    else

                                                                    { ?>

                                                                            new_row +='<input type="hidden" name="org_cert_scan_file_'+k_val+'[]" id="org_cert_scan_file_'+k_val+'_'+cert_cnt+'" value="">';

                                                                            

                                                                    <?php

                                                                    } ?>

									new_row +='</div>'+

								'<div class="form-group">'+

									'<div class="col-lg-2">'+

										'<a href="javascript:void(0);" onclick="addMoreRowCertificateOrg('+k_val+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Add More" data-original-title=""><i class="fa fa-plus"></i></a>'+

									'</div>'+

								'</div>'+

							'</div>'+

                                                        

							'<div class="form-group">'+

								'<div class="col-lg-2">'+

									'<a href="javascript:void(0);" onclick="removeRowLocation('+cat_cnt+');" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Remove it" data-original-title=""><i class="fa fa-minus"></i></a>'+

								'</div>'+

							'</div>'+

						'</div>';	

		

		$("#row_loc_first").after(new_row);

		$("#cat_cnt").val(cat_cnt);

		

		var cat_total_cnt = parseInt($("#cat_total_cnt").val());

		cat_total_cnt = cat_total_cnt + 1;

		$("#cat_total_cnt").val(cat_total_cnt);

		

		$('.vloc_speciality_offered').tokenize2();

		$('.clsdatepicker').datepicker();

		$('.clsdatepicker2').datepicker({endDate: new Date});

	}



	function removeRowLocation(idval)

	{

		$("#row_loc_"+idval).remove();



		var cat_total_cnt = parseInt($("#cat_total_cnt").val());

		cat_total_cnt = cat_total_cnt - 1;

		$("#cat_total_cnt").val(cat_total_cnt);

		

	}



function getMainCategoryOptionAddMore(id)

    {

           // alert(id);

            var parent_cat_id = $("#profile_cat_"+id).val();

            //var sub_cat = $("#fav_cat_id_"+idval).val();

            //alert(parent_cat_id);

             var dataString = 'action=FavcategoryByprofCatEvent&parent_cat_id='+parent_cat_id+'&id_no='+id;

            

           $.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

                         //alert(result);  

			$("#fav_cat_"+id).html(result);

			

		}

	});

    }

    function getlocation(id_val)

       {

           var city = $("#city_id_"+id_val).val();

           //alert(city);

            var dataString ='city='+city+'&action=getlocation';

            $.ajax({

                   type: "POST",

                    url: 'ajax/remote.php', 

                   data: dataString,

                   cache: false,

                   success: function(result)

                        {

                            //alert(result);

                         var JSONObject = JSON.parse(result);

                         //var rslt=JSONObject[0]['status'];   

                        $('#area_id_'+id_val).html(JSONObject[0]['place_option']);

                       }

              }); 

       }

       

function CheckTeamType(idval)

    {

      

      var event_format = $("#event_format_"+idval).val();

      

      if(event_format == '504')

      {

        $('#no_of_teams_level_'+idval).hide();  

        $('#no_of_teams_div_'+idval).hide();  

      }

      else

      {

         $('#no_of_teams_level_'+idval).show();  

         $('#no_of_teams_div_'+idval).show();   

      }

      

    }

    

    function getMainCategoryOptionAddMoreSingle(id)

    {

           // alert(id);

            var parent_cat_id = $("#profile_cat_"+id).val();

            //var sub_cat = $("#fav_cat_id_"+idval).val();

            //alert(parent_cat_id);

             var dataString = 'action=FavcategoryByprofCatEventSingle&parent_cat_id='+parent_cat_id+'&id_no='+id;

            

           $.ajax({

		type: "POST",

		url: "ajax/remote.php",

		data: dataString,

		cache: false,

		success: function(result)

		{

                         //alert(result);  

			$("#fav_cat_"+id).html(result);

			

		}

	});

    }

    

</script>

</body>

</html>
<?php

ini_set("memory_limit","200M");

if (ini_get("pcre.backtrack_limit") < 1000000) { ini_set("pcre.backtrack_limit",1000000); };

@set_time_limit(1000000);



// include('config.php');



include('classes/config.php');

$obj = new frontclass();

$obj2 = new frontclass2();



$page_id = '61';



list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = $obj->getPageDetails($page_id);



$ref = base64_encode('my_rewards.php');



if(!$obj->isLoggedIn())



{



//	header("Location: login.php?ref=".$ref);

    echo "<script>window.location.href='login.php?ref=$ref'</script>";



	exit(0);



}



else

{

	$user_id = $_SESSION['user_id'];

	$obj->doUpdateOnline($_SESSION['user_id']);

}





if($obj->chkUserPlanFeaturePermission($user_id,'34'))

{

	$page_access = 1;

}

else

{

	$page_access =0;

}



// echo "<pre>";print_r($page_access);echo "</pre>";







$return = false;

$error = false;

$tr_err_date = 'none';

$err_date = '';



$idmonthwisechart = 'none';

$summary_cnt = 0;

if(isset($_POST['btnSubmit']))	

{

	$start_day = '1';

	$start_month = trim($_POST['start_month']);

	$start_year = trim($_POST['start_year']);



	$end_day = '1';

	$end_month = trim($_POST['end_month']);

	$end_year = trim($_POST['end_year']);



	if($start_month == '')

	{

		$error = true;

		$tr_err_date = '';

		$err_date = 'Please select start month';

	}



	elseif($start_year == '')

	{

		$error = true;

		$tr_err_date = '';

		$err_date = 'Please select start year';

	}



	elseif(!checkdate($start_month,$start_day,$start_year))

	{

		$error = true;

		$tr_err_date = '';

		$err_date = 'Please select valid start date';

	}



	elseif(mktime(0,0,0,$start_month,$start_day,$start_year) > time())

	{



		$error = true;

		$tr_err_date = '';

		$err_date = 'Please select today or previous day for start date ';

	}

	else

	{

		$start_date = $start_year.'-'.$start_month.'-'.$start_day;

	}











	if($end_month == '')



	{



		$error = true;



		if($tr_err_date == 'none')



		{



			$tr_err_date = '';



			$err_date = 'Please select end month';



		}



		else



		{



			$err_date .= '<br>Please select end month';



		}	



	}



	elseif($end_year == '')



	{



		$error = true;



		if($tr_err_date == 'none')



		{



			$tr_err_date = '';



			$err_date = 'Please select end year';



		}



		else



		{



			$err_date .= '<br>Please select end year';



		}	



	}



	else



	{



		$end_date = $end_year.'-'.$end_month.'-'.$end_day;

		$end_day = date('t',strtotime($end_date)); 

		$end_date = $end_year.'-'.$end_month.'-'.$end_day;

		if(strtotime($start_date) > strtotime($end_date))

		{

			$error = true;

			if($tr_err_date == 'none')

			{

				$tr_err_date = '';

				$err_date = 'Please select end month/year less than start month/year';

			}

			else

			{

				$err_date .= '<br>Please select end month/year less than start month/year';

			}	

		}	

	}	





	if(!$error)

	{

		list($return,$arr_reward_modules,$arr_reward_summary) = $obj->getMyRewardsChart($user_id,$start_date,$end_date);

	}

}



else

{

	$now = time();

	$user_add_date = $obj->getUserRegistrationTimestamp($user_id);



	//update by ample add strtotime 06-11-20

	if($user_add_date=='0000-00-00 00:00:00')
	{
		$user_add_date='2011-01-01 00:00:00';
	}

	$start_year = date("Y",strtotime($user_add_date));

	$start_month = date("m",strtotime($user_add_date));

	$start_day = date("d",strtotime($user_add_date));

	$end_year = date("Y",$now);

	$end_month = date("m",$now);

	$end_day = date('t',$now); 

	$error = false;

	$return = false;


	$start_date = $start_year.'-'.$start_month.'-'.$start_day;

	$end_date = $end_year.'-'.$end_month.'-'.$end_day;

	list($return,$arr_reward_modules,$arr_reward_summary) = $obj->getMyRewardsChart($user_id,$start_date,$end_date);


}




$summary_cnt = count($arr_reward_summary);

//add by ample 12-11-20
//$obj->update_user_reward_points();
//$my_points=$obj->get_user_points($user_id);


?><!DOCTYPE html>

<html lang="en">

<head>

 <?php include_once('head.php');?>

</head>

<body id="boxed">

<?php //include_once('analyticstracking.php'); ?>

<?php //include_once('analyticstracking_ci.php'); ?>

<?php //include_once('analyticstracking_y.php'); ?>

<div class="boxed-wrapper">

<!--header-->

<!-- <header> -->

 <?php //include 'topbar.php'; ?>

<?php include_once('header.php');?>

<!-- </header> -->

<!--header End --> 	

 <!--breadcrumb--> 

 <div class="container"> 

    <div class="breadcrumb">

                    <div class="row">

                    <div class="col-md-8">	

                      <?php echo $obj->getBreadcrumbCode($page_id);?> 

                       </div>

                         <div class="col-md-4">

                         <?php

                                    if($obj->isLoggedIn())

                                    { 

                                        echo $obj->getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);

                                    }

                                    ?>

                         </div>

                       </div>

                </div>

            </div>

<!--breadcrumb end --> 

<!--container-->              

<div class="container" >

<div class="row">	

<div class="col-md-12">	

<?php echo $obj->getPageContents($page_id);?>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">

				<tr>

					<td align="left" valign="top">            

						<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#339900">

							<tr>

								<td align="center" valign="top" bgcolor="#FFFFFF">

								<?php



								// echo $page_access;

                                if($page_access==0)  //keep 1

                                { ?>

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="my_tbl">

										<tr>

											<td height="200" align="center" valign="top" class="mainnav">                                    

												<form action="#" id="frmactivity" method="post" name="frmactivity">

												<table width="100%" border="0" cellspacing="0" cellpadding="0">

													<tr>

														<td width="10%" height="45" align="left" valign="middle" class="Header_brown">Start Month:</td>

														<td width="35%" align="left" valign="middle">



								                         <div class="row" style="margin-top:15px;">

															 <div class="col-xs-4">														

																<select name="start_month" id="start_month" class="form-control">

																<option value="">Month</option>

																<?php echo $obj->getMonthOptions($start_month); ?>

															</select>



	                                                     </div>

                                                  <div class="col-xs-4">	  												

                           	                      	<select name="start_year" id="start_year" class="form-control">



																<option value="">Year</option>



															<?php



															for($i=2011;$i<=intval(date("Y"));$i++)



															{ ?>



																<option value="<?php echo $i;?>" <?php if($start_year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>



															<?php



															} ?>	



															</select>



                                                            </div>



                                                            </div>



													  </td>



														<td width="10%" height="45" align="left" valign="middle" class="Header_brown">End Month:</td>



														<td width="35%" align="left" valign="middle">



		                                                                  <div class="row" style="margin-top:15px;">

                                                                              <div class="col-xs-4">														

                                                                              <select name="end_month" id="end_month" class="form-control">

															                     	<option value="">Month</option>

																                 <?php echo $obj->getMonthOptions($end_month); ?>

														                      </select>

	                                                                          </div>	



                                                                  <div class="col-xs-4">												

     	                                                             <select name="end_year" id="end_year" class="form-control">

																<option value="">Year</option>

																	<?php

																	for($i=2011;$i<=intval(date("Y"));$i++)



																	{ ?>



																		<option value="<?php echo $i;?>" <?php if($end_year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>



																	<?php



																	} ?>	

														  </select>

	                                                   </div>

	                                                </div>								

	                                             </td>



												<td width="10%" height="45" align="left" valign="middle"><input type="submit" name="btnSubmit" id="btnSubmit" value="View" /></td>



					   						</tr>



                                                    <tr id="tr_err_date" style="display:<?php echo $tr_err_date;?>;" valign="top">

														<td align="left" colspan="5" class="err_msg" id="err_date" valign="top"><?php echo $err_date;?></td>

													</tr>

												</table>

												</form>                                       

											<?php

                                            if($return && count($arr_reward_modules) > 0)

                                            { ?>

                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="report">

                                                <tbody>

                                                    <tr>

                                                        <td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>

                                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td width="20%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($start_date));?></td>

                                                        <td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>

                                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>

                                                        <td width="19%" height="30" align="left" valign="middle"><?php echo date("t M Y",strtotime($end_date));?></td>

                                                        <td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

                                                        <td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

                                                        <td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>

                                                    </tr>

                                                    <tr>	



                                                        <td height="30" align="left" valign="middle"><strong>Name</strong></td>



                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>



                                                        <td height="30" align="left" valign="middle"><?php echo $obj->getUserFullNameById($user_id);?></td>



                                                        <td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>



                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>



                                                        <td height="30" align="left" valign="middle"><?php echo $obj->getUserUniqueId($user_id);?></td>



                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>



                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>



                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>



                                                    </tr>



                                                </tbody>



                                                </table>



                                               <?php /*?> <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">



                                                <tbody>	



                                                    <tr>	



                                                        <td align="left"><strong>Important:</strong></td>



                                                    </tr>



                                                    <tr>	



                                                        <td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>



                                                    </tr>



                                                </tbody>



                                                </table><?php */?>



                                                



                                                <div id="tabs_container2" style="margin-left:10px; margin-top:20px;">



                                                    



                                                    <?php



                                                    // echo $value['records'][$i]['reward_module_id'];

                                                     //echo $key;

                                                    ?>



										 <ul class="nav nav-tabs">

										    <li class="active"><a data-toggle="tab" href="#Summary">Summary Reward Chart</a></li>

										    <li><a data-toggle="tab" href="#Monthwise">Monthwise Reward Chart</a></li>

										    <li >

										      <div style="text-align:right">

										      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

										        <input type="button" class="btn btn-secondary" name="btnShowRewardCatlog" id="btnShowRewardCatlog" value="Show Rewards Catlog" onclick="javascript:window.open('my_rewards_catlog.php', '_blank');"  />
										        &nbsp;
										        <input type="button" class="btn btn-secondary" name="btnShowRewardScheme" id="btnShowRewardScheme" value="Show Rewards Scheme" onclick="javascript:window.open('my_rewards_scheme.php', '_blank');"  />
										        &nbsp;
										        <input type="button" class="btn btn-secondary" name="btnViewPointEncashed" id="btnViewPointEncashed" value="View Encashed Rewards" onclick="javascript:window.open('my_encashed_rewards.php', '_blank');" >&nbsp;
										       <!--  <input type="button" class="btn btn-secondary" name="btnRedeamAllModuleWise" id="btnRedeamAllModuleWise" value="Redeem for Total Points(All Modules)" onclick="viewAllModuleRedeamPopup('<?php echo $summary_cnt;?>');"  /> -->
										        <a href="my_rewards_redeem.php" target="_blank"><input type="button" class="btn btn-secondary" name="btnRedeamAllModuleWise" value="Redeem Points " /> </a>

										      </div>

										     </li>

										  </ul>







											  <div class="tab-content">

											    <div id="Summary" class="tab-pane fade in active">

											      <h3>Summary Reward Chart</h3>

											     <div > 



                                                       <table width="100%" border="0" cellpadding="0" cellspacing="0" class="report">

                                                            <tbody>	

                                                                <tr>	

                                                                    <td colspan="2" align="left" height="30">&nbsp;</td>

                                                                </tr>

                                                                <tr>	

                                                                    <td align="left"></td>

                                                                    <td align="right">

                                                                    </td>

                                                                </tr>



                                                              

                                                            </tbody>

                                                            </table>

                                                            <table width="100%" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">

                                                            <tbody>

                                                                <tr bgcolor="#CCCCCC">

                                                                    <td width="10%" height="30" align="center" valign="middle"><strong>SNo</strong></td>

                                                                    <td width="20%" height="30" align="center" valign="middle"><strong>Particulars</strong></td>

                                                                    <td width="10%" height="30" align="center" valign="middle"><strong>Total Entries</strong></td>

                                                                  
                                                                    <td width="10%" height="30" align="center" valign="middle"><strong>Number of days Posted</strong></td>

                                                                    <td width="10%" height="30" align="center" valign="middle"><strong></strong></td>


                                                                </tr>



                                                                <?php

                                                              

                                                                $i = 0;

																$j = 1;

                                                                $summary_total_entries = 0;

                                                                // $total_summary_points_from_entry = 0;

                                                                $total_summary_no_of_days_posted = 0;

                //                                                 $total_summary_bonus_points = 0;

                //                                                 $total_summary_total_points = 0;

																// $total_summary_encashed_points = 0;

																// $total_summary_balance_points = 0;



                                                             

																foreach($arr_reward_summary as $key => $val)

                                                                {

                                                                    $total_summary_total_entries += $val['summary_total_entries'];

                                                                    // $total_summary_points_from_entry += $val['summary_points_from_entry'];

                                                                    $total_summary_no_of_days_posted += $val['summary_no_of_days_posted'];

                 //                                                    $total_summary_bonus_points += $val['summary_bonus_points'];

                 //                                                    $total_summary_total_points += $val['summary_total_points'];

																	// $total_summary_encashed_points += $val['summary_total_encashed_points'];

																	// $total_summary_balance_points += $val['summary_total_balance_points'];

                                                                ?>



                                                                <tr>



                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $j;?></strong></td>

                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_reward_module_title'];?></strong></td>

                                                                    <td height="30" align="right" valign="middle" style="padding-right:2px;">

                                                                        <strong><?php echo $val['summary_total_entries'];?></strong>

                                                                    <?php 

                                                                 

                                                                    if($val['summary_total_entries'] > 0) //keep 0

                                                                    { ?>

                                                                        &nbsp;<input type="button" name="btnViewEntriesDetailsList" id="btnViewEntriesDetailsList" value="View" onclick="viewEntriesDetailsList('<?php echo $start_date;?>','<?php echo $end_date;?>','<?php echo $key;?>','<?php echo $val['summary_reward_module_title'];?>');"  />

                                                                    <?php



																	}



																	else



																	{ ?>



                                                                    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;



                                                                    <?php



                                                                    } ?>    



                                                                    </td>



                                                                  


                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $val['summary_no_of_days_posted'];?></strong></td>


                                                                    <td height="30" align="center" valign="middle">
                                                                    	<?php
                                                                    	if($obj->chkIfUserCanRedeamGift($user_id,$key))


																		{ ?>


                                                                        <a href="my_rewards_redeem.php?module_id=<?=$key;?>" target="_blank"> <input type="button" name="btnRedeamModuleWise" id="btnRedeamModuleWise" value="Redeem"  /> </a>


                                                                        <?php


																		} ?>
                                                                    </td>
                                                                  

                                                                    <input type="hidden" name="hdnsummary_reward_module_id_<?php echo $i;?>" id="hdnsummary_reward_module_id_<?php echo $i;?>" value="<?php echo $key;?>"  />



                                                                        <input type="hidden" name="hdnsummary_reward_module_title_<?php echo $i;?>" id="hdnsummary_reward_module_title_<?php echo $i;?>" value="<?php echo $val['summary_reward_module_title'];?>"  />



                                                                        <input type="hidden" name="hdnsummary_total_balance_points_<?php echo $i;?>" id="hdnsummary_total_balance_points_<?php echo $i;?>" value="100"  />
                                                                   



                                                               


                                                                </tr>



                                                                <?php



																	$j++;



																	$i++;



                                                                } ?>  



                                                                <tr>



                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>



                                                                    <td height="30" align="center" valign="middle"><strong>Base Total</strong></td>



                                                                    <td height="30" align="right" valign="middle" style="padding-right:2px;"><strong><?php echo $total_summary_total_entries;?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>




                                                                    <td height="30" align="center" valign="middle"><strong><?php echo $total_summary_no_of_days_posted;?></strong></td>

                                                                    <td height="30" align="center" valign="middle"><strong></strong></td>

                                                                </tr>



                                                              </tbody>



                                                              </table>



                                                          </div>



    </div>



    <div id="Monthwise" class="tab-pane fade">



      <h3>Monthwise Reward Chart</h3>



      <div  >     




                                                                    



                                                                <?php





                                                                foreach($arr_reward_modules as $key => $value)



                                                                { ?>



                                                                



                                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="report">



                                                                <tbody>



                                                                    <tr>



                                                                        <td width="15%" height="30" align="left" valign="middle"><strong>For the period from </strong></td>



                                                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>



                                                                        <td width="20%" height="30" align="left" valign="middle"><?php echo date("d M Y",strtotime($key));?></td>



                                                                        <td width="15%" height="30" align="left" valign="middle"><strong>to </strong></td>



                                                                        <td width="2%" height="30" align="left" valign="middle"><strong>:</strong></td>



                                                                        <td width="19%" height="30" align="left" valign="middle"><?php echo date("t M Y",strtotime($key));?></td>



                                                                        <td width="11%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>



                                                                        <td width="2%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>



                                                                        <td width="14%" height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>



                                                                    </tr>



                                                                    <tr>	



                                                                        <td height="30" align="left" valign="middle"><strong>Name</strong></td>



                                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>



                                                                        <td height="30" align="left" valign="middle"><?php echo $obj->getUserFullNameById($user_id);?></td>



                                                                        <td height="30" align="left" valign="middle"><strong>CWRI Regn No</strong></td>



                                                                        <td height="30" align="left" valign="middle"><strong>:</strong></td>



                                                                        <td height="30" align="left" valign="middle"><?php echo $obj->getUserUniqueId($user_id);?></td>



                                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>



                                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>



                                                                        <td height="30" align="left" valign="middle"><strong>&nbsp;</strong></td>



                                                                    </tr>



                                                                </tbody>



                                                                </table>



                                                               <?php /*?> <table width="920" border="0" cellpadding="0" cellspacing="0" class="report">



                                                                <tbody>	



                                                                    <tr>	



                                                                        <td align="left"><strong>Important:</strong></td>



                                                                    </tr>



                                                                    <tr>	



                                                                        <td align="left"><p>Disclaimers..<br />Just a guide, not an exact scientific research, depends on many factors, as well as accuracy of your Input  DATA.</p></td>



                                                                    </tr>



                                                                </tbody>



                                                                </table><?php */?>



                                                                <table width="100%" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">



                                                                <tbody>



                                                                    <tr bgcolor="#CCCCCC">



                                                                        <td width="5%" height="30" align="center" valign="middle" ><strong>SNo</strong></td>



                                                                        <td width="30%" height="30" align="center" valign="middle"><strong>Particulars</strong></td>



                                                                        <td width="15%" height="30" align="center" valign="middle"><strong>Total Entries</strong></td>




                                                                        <td width="10%" height="30" align="center" valign="middle"><strong>Number of days Posted</strong></td>




                                                                    </tr>



                                                                    <?php



                                                                    for($i=0,$j=1;$i<count($value['records']);$i++,$j++)



                                                                    { ?>



                                                                    <tr>



                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $j;?></strong></td>



                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['reward_module_title'];?></strong></td>




                                                                        <td height="30" align="right" valign="middle" style="padding-right:2px;">



                                                                            <strong><?php echo $value['records'][$i]['total_entries'];?></strong>



                                                                        <?php 



                                                                        if($value['records'][$i]['total_entries'] > 0)



                                                                        { ?>



                                                                            &nbsp;<input type="button" name="btnViewEntriesDetailsList" id="btnViewEntriesDetailsList" value="View" onclick="viewEntriesDetailsList('<?php echo $key;?>','<?php echo date('Y-m-t',strtotime($key));?>','<?php echo $value['records'][$i]['reward_module_id'];?>','<?php echo $value['records'][$i]['reward_module_title'];?>');"  />



                                                                        <?php



																		}



																		else



																		{ ?>



																			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;



																		<?php



																		} ?>   



                                                                        </td>



                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['records'][$i]['no_of_days_posted'];?></strong></td>



                                                                    </tr>



                                                                    <?php



                                                                    } ?>  



                                                                    <tr>



                                                                        <td height="30" align="center" valign="middle"><strong></strong></td>



                                                                        <td height="30" align="center" valign="middle"><strong>Base Total</strong></td>



                                                                     



                                                                        <td height="30" align="right" valign="middle" style="padding-right:2px;"><strong><?php echo $value['total_total_entries'];?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>






                                                                        <td height="30" align="center" valign="middle"><strong><?php echo $value['total_no_of_days_posted'];?></strong></td>




                                                                    </tr>




                                                                  </tbody>



                                                                  </table>

                                                <?php



												} ?>  

                                                				</div> 



                                                               </div>



    </div>

  </div>                                         



											<?php

                                            }

                                            else 

                                            { ?>

												<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

													<tr align="center">

														<td height="5" class="Header_brown">No Records Found</td>

													</tr>

												</table>	

											<?php 

                                            } ?>

                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

													<tr align="center">

														<td height="30" class="Header_brown">&nbsp;</td>

													</tr>

												</table>	

											</td>

                                        </tr>

									</table>

								<?php 

								} 

								else 

								{ ?>

									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

										<tr align="center">

											<td height="5" class="Header_brown"><?php echo $obj->getCommonSettingValue('3');?></td>

										</tr>

									</table>

								<?php 

								} ?>

                                </td>

							</tr>

						</table>

						<table width="100%" border="0" cellspacing="0" cellpadding="0">

							<tr>

								<td>&nbsp;</td>

							</tr>

						</table>

                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                            <tr>

                                <td align="left" valign="top">

                                    <?php echo $obj->getScrollingWindowsCodeMainContent($page_id);?>

                                    <?php echo $obj->getPageContents2($page_id);?>

                                </td>

                            </tr>

                        </table>

                    </td>

				</tr>

			</table>

  </div>	

</div>

</div>

<!--container-->                     

       <!--  Footer-->

 <?php include_once('footer.php');?>            

  <!--  Footer-->

</div>

<div id="page_loading_bg" class="page_loading_bg" style="display:none;">

	<div id="page_loading_img" class="page_loading_img"><img border="0" src="<?php echo SITE_URL;?>/images/loading.gif" /></div>

</div>

<!-- Bootstrap Core JavaScript -->

 <!--default footer end here-->

       <!--scripts and plugins -->

        <!--must need plugin jquery-->

        <script src="csswell/js/jquery.min.js"></script>        

        <!--bootstrap js plugin-->

        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  

</body>



</html>



<style>

.report {

    font-size: 12px!important;

}

</style>

<script>

	

</script>




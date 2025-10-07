<?php 
include('classes/config.php');
$page_id = '144';
$obj = new frontclass();
$obj2 = new frontclass2();

$page_data = $obj->getPageDetails($page_id);
$ref = base64_encode($page_data['menu_link']);


if(!$obj->isLoggedIn())

{

//    header("Location: login.php?ref=".$ref);
     echo "<script>window.location.href='login.php?ref=$ref'</script>";

    exit(0);

}

else

{

    $user_id = $_SESSION['user_id'];

    $obj->doUpdateOnline($_SESSION['user_id']);

}

$return = false;
$error = false;
$tr_err_date = 'none';
$err_date = '';

$tbldaterange = '';
$tblsingledate = 'none';
$tblmonthdate = 'none';
$tblweekhdate = 'none';
$div_start_scale_value = 'none';
$div_end_scale_value = 'none';
$div_start_criteria_scale_value = 'none';
$div_end_criteria_scale_value = 'none';
$div_module_key = 'none';
$idscaleshow = 'none';
$idcriteriascaleshow = 'none';
$spntriggercriteria = 'none';
$show_pdf_button = false;


if(isset($_POST['btn_submit']))
{
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>    
    <?php include_once('head.php');?>
    <link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css">
    <script type="text/javascript" src="w_js/jquery-1.12.4.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="w_js/datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script>
    <style>
        #explore .date button:hover, #explore .date .active {
        background: #e1452b;
        color: #fff;
        margin-top: 20px;
    }
      button {
    border: 0px;
    /* width: 120px; */
    min-width: 150px;
    height: 40px;
    background: #fff;
    border-radius: 20px;
    color: #4e4e4e;
    font-weight: 400px;
    /* margin-right: 20px; */
    padding: 0 15px;
    -webkit-box-shadow: 0px 2px 9px rgba(15, 15, 15, 0.8);
    -moz-box-shadow: 0px 2px 9px rgba(15, 15, 15, 0.8);
    -sm-box-shadow: 0px 2px 9px rgba(15, 15, 15, 0.8);
    -o-box-shadow: 0px 2px 9px rgba(15, 15, 15, 0.8);
    box-shadow: 0px 2px 9px rgba(15, 15, 15, 0.8);
    -webkit-transition: all linear 0.3s;
    -o-transition: all linear 0.3s;
    -moz-transition: all linear 0.3s;
    transition: all linear 0.3s;
}
button, input, select, textarea {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
}
    </style>
</head>
<body>
<?php include_once('analyticstracking.php'); ?>

<?php include_once('analyticstracking_ci.php'); ?>

<?php include_once('analyticstracking_y.php'); ?>
<?php include_once('header.php');?>

<section id="checkout">
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
		<div class="row">
                    
                    <div class="col-md-8" id="explore" style="background-repeat:repeat; padding:5px;">
                       
                        <div class="col-md-12">
                        <!--<h2> <span class="Header_brown"><?php //echo $obj->getPageTitle($page_id);?></span></h2>-->
                        <?php echo $obj->getPageContents($page_id);?>
                        </div>
                        <form role="form" class="form-horizontal" id="event_listing" name="event_listing" enctype="multipart/form-data" method="post"> 
                            <?php if($error){ ?>
                                <span style="color:red;"><?php echo $err_msg; ?></span>
                            <?php } ?>
                            <div class='col-md-12' style="margin-bottom:20px;">
                                <div class="col-md-6">
                                    <span style="font-size:15px; font-weight: bold;" class="Header_brown">Date Selection Type</span>
                                     <select name="date_type" id="date_type" class="form-control" onchange="toggleDateSelectionTypeUser('date_type')">
                                        <option value="date_range" <?php if($date_type == 'date_range'){?> selected <?php } ?> >Date Range</option>
                                        <option value="single_date" <?php if($date_type == 'single_date'){?> selected <?php } ?>>Single Date</option>
                                        <option value="month_wise" <?php if($date_type == 'month_wise'){?> selected <?php } ?>>Month wise</option>
                                        <option value="week_wise" <?php if($date_type == 'week_wise'){?> selected <?php } ?>>Week wise</option>
                                    </select> 
                                </div>
                            </div>
                                
                            <div class='col-md-12' id="tbldaterange" style="display:<?php echo $tbldaterange;?> ; margin-bottom:20px;">
                                <div class="col-md-6">
                                    <span style="font-size:15px; font-weight: bold;" class="Header_brown">Start Date</span>
                                     <input type="text" name="start_date" id="start_date" placeholder="Select Date" class="form-control" autocomplete="off"> 
                                </div>
                                <div class="col-md-6">
                                    <span style="font-size:15px; font-weight: bold;" class="Header_brown">End Date</span>
                                     <input type="text" name="end_date" id="end_date" placeholder="Select Date" class="form-control" autocomplete="off" > 
                                </div>
                            </div>
                                
                            <div class='col-md-12' id="tblsingledate" style="display:<?php echo $tblsingledate;?> ; margin-bottom:20px;">
                                <div class="col-md-6">
                                    <span style="font-size:15px; font-weight: bold;" class="Header_brown">Date</span>
                                     <input type="text" name="single_date" id="single_date" placeholder="Select Date" class="form-control" autocomplete="off" > 
                                </div>
                                
                            </div>  
                                
                            <div class='col-md-12' id="tblmonthdate" style="display:<?php echo $tblmonthdate;?> ; margin-bottom:20px;">
                                <div class="col-md-6">
                                    <span style="font-size:15px; font-weight: bold;" class="Header_brown">Month</span>
                                     <select  class="form-control" name="start_month" id="start_month">
                                         
                                        <?php echo $obj->getMonthOptions($start_month); ?>
                                         
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <span style="font-size:15px; font-weight: bold;" class="Header_brown">Year</span>
                                     <select  class="form-control" name="start_year" id="start_year">
                                        <?php
                                        for($i=2011;$i<=intval(date("Y"));$i++)
                                        { ?>
                                            <option value="<?php echo $i;?>" <?php if($start_year == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                        <?php
                                        } ?>	
                                </select>
                                </div>
                            </div> 
                                
                            <div class='col-md-12' id="tblweekdate" style="display:<?php echo $tblweekhdate;?> ; margin-bottom:20px;">
                                <div class="col-md-4">
                                    <span style="font-size:15px; font-weight: bold;" class="Header_brown">Week</span>
                                     <select  class="form-control" name="start_week" id="start_week">
                                         <?php echo $obj->getDayOfWeekOptions($start_week); ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <span style="font-size:15px; font-weight: bold;" class="Header_brown">Month</span>
                                     <select  class="form-control" name="start_month_week" id="start_month">
                                        <?php echo $obj->getMonthOptions($start_month_week); ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <span style="font-size:15px; font-weight: bold;" class="Header_brown">Year</span>
                                     <select  class="form-control" name="start_year_week" id="start_year">
                                        <?php
                                        for($i=2011;$i<=intval(date("Y"));$i++)
                                        { ?>
                                            <option value="<?php echo $i;?>" <?php if($start_year_week == $i) { ?> selected="selected" <?php } ?>><?php echo $i;?></option>
                                        <?php
                                        } ?>	
                                </select>
                                </div>
                            </div> 
                                
                            <div class='col-md-12' style="margin-bottom:20px;">
                                <div class="col-md-6">
                                    <span style="font-size:15px; font-weight: bold;" class="Header_brown">Module</span>
                                     <select name="report_module" id="report_module" onchange="getModuleWiseKeywordsOptions();" class="form-control">
                                        <?php echo $obj->Get_Digital_Life_drop($page); ?>
                                     </select>
                                </div>
                                
                            </div>
                                
                                <div class='col-md-12' id="keywordshow" style="display: none; margin-bottom:20px;">
                                <div class="col-md-12">
                                    <span style="font-size:15px; font-weight: bold;" class="Header_brown">Keywords</span>
                                    <input type="text" name="keywords" id="keywords" placeholder="Select keywords" list="capitals" class="input-text-box input-half-width"/>
                                    <datalist id="capitals" autocomplete="off">
                                        
                                    </datalist>
                                </div>
                                
                            </div>    
                             <div class="col-md-2 date" >
                                <button type="submit" name="btn_submit" class="active">Explore Reports</button>
                            </div>
                        </form>
                        
                        <div class="col-md-12">
                            
                       </div>
                    </div>
		<div class="col-md-2"> <?php include_once('left_sidebar.php'); ?></div>
		<div class="col-md-2"><?php  include_once('right_sidebar.php'); ?></div>			
		</div>
     
</div>
    
<div class="container">

<div class="container">
   
</div>

<style>
.col-item
{
    border: 2px solid #2323A1;
    border-radius: 5px;
    background: #FFF;
}
.col-item .photo img
{
    margin: 0 auto;
    width: 100%;
}

.col-item .info
{
    padding: 10px;
    border-radius: 0 0 5px 5px;
    margin-top: 1px;
}
.col-item:hover .info {
    background-color: rgba(215, 215, 244, 0.5); 
}
.col-item .price
{
    /*width: 50%;*/
    float: left;
    margin-top: 5px;
}

.col-item .price h5
{
    line-height: 20px;
    margin: 0;
}

.price-text-color
{
    color: #00990E;
}

.col-item .info .rating
{
    color: #003399;
}

.col-item .rating
{
    /*width: 50%;*/
    float: left;
    font-size: 17px;
    text-align: right;
    line-height: 52px;
    margin-bottom: 10px;
    height: 52px;
}

.col-item .separator
{
    border-top: 1px solid #FFCCCC;
}

.clear-left
{
    clear: left;
}

.col-item .separator p
{
    line-height: 20px;
    margin-bottom: 0;
    margin-top: 10px;
    text-align: center;
}

.col-item .separator p i
{
    margin-right: 5px;
}
.col-item .btn-add
{
    width: 50%;
    float: left;
}

.col-item .btn-add
{
    border-right: 1px solid #CC9999;
}

.col-item .btn-details
{
    width: 50%;
    float: left;
    padding-left: 10px;
}
.controls
{
    margin-top: 20px;
}
[data-slide="prev"]
{
    margin-right: 10px;
}
</style>

<!-- Product Slider - END -->

</div>
    
</section>
<?php include_once('footer.php');?>	 
    <script>
      
     $(document).ready(function()
            {
                $('.vloc_speciality_offered').tokenize2();
                $('#start_date').attr('autocomplete', 'off');
                $('#end_date').attr('autocomplete', 'off');
                $('#single_date').attr('autocomplete', 'off');
                $('#capitals').attr('autocomplete', 'off');
                
                $('#start_date').datepicker(
                        {
                            dateFormat: 'dd-mm-yy'
                        }        
                ); 
        
                $('#end_date').datepicker(
                        {
                            dateFormat: 'dd-mm-yy'
                        }        
                ); 
        
                $('#single_date').datepicker(
                        {
                            dateFormat: 'dd-mm-yy'
                        }        
                ); 
                
            }
        ); 
      

function toggleDateSelectionTypeUser(id_val)

{

	var date_type = document.getElementById(id_val).value;

	if (date_type == "date_range") 

	{ 	

            document.getElementById('tbldaterange').style.display = '';

            document.getElementById('tblsingledate').style.display = 'none';

            document.getElementById('tblmonthdate').style.display = 'none';
            
            document.getElementById('tblweekdate').style.display = 'none';
            

	}

	else if (date_type == "single_date") 

	{ 	

            document.getElementById('tbldaterange').style.display = 'none';

            document.getElementById('tblsingledate').style.display = '';

            document.getElementById('tblmonthdate').style.display = 'none';
            
            document.getElementById('tblweekdate').style.display = 'none';

	}

	else if (date_type == "month_wise") 

	{ 	

            document.getElementById('tbldaterange').style.display = 'none';

            document.getElementById('tblsingledate').style.display = 'none';

            document.getElementById('tblmonthdate').style.display = '';
            
            document.getElementById('tblweekdate').style.display = 'none';

	}
        
        else if (date_type == "week_wise") 

	{ 	

            document.getElementById('tbldaterange').style.display = 'none';

            document.getElementById('tblsingledate').style.display = 'none';

            document.getElementById('tblmonthdate').style.display = 'none';
            
            document.getElementById('tblweekdate').style.display = '';

	}

}
   
   
function getModuleWiseKeywordsOptions()
{

    var page_id = $('#report_module').val();
//    var date_type = $('#date_type'.val();
//    var start_date ='';
//    var end_date = '';
//    var single_date ='';
//    var start_month ='';
    //alert(page_id);
    var dataString ='page_id='+page_id+'&action=getmodulewisekeywordsoptions';
    $.ajax({
           type: "POST",
           url: 'remote2.php', 
           data: dataString,
           cache: false,
           success: function(result)
                {
                 
                 $('#keywordshow').show();
                 $('#capitals').html(result);
                 
               }
      }); 

} 
   
    function isNumberKey(evt){  <!--Function to accept only numeric values-->
    //var e = evt || window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
        return false;
        return true;
	}
</script>
</body>
</html>
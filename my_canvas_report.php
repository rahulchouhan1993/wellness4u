<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set("memory_limit", "200M");
if (ini_get("pcre.backtrack_limit") < 1000000) {
    ini_set("pcre.backtrack_limit", 1000000);
};
@set_time_limit(1000000);
include ('classes/config.php');
$page_id = '193';
$obj = new frontclass();
$obj2 = new commonFrontclass();
$page_data = $obj->getPageDetails($page_id);
//update by ample 24-03-20
$ref = base64_encode('my_canvas_report.php');
if (!$obj->isLoggedIn()) {
    //    header("Location: login.php?ref=".$ref);
    echo "<script>window.location.href='login.php?ref=$ref'</script>";
    exit(0);
} else {
    $user_id = $_SESSION['user_id'];
    $obj->doUpdateOnline($_SESSION['user_id']);
}

  if(isset($_POST) && !empty($_POST))
  {

    // echo '<pre>';

    // print_r($_POST);

    $date_type=$_POST['date_type'];
    $date_arr=array();
    $keywords=$_POST['keywords'];

    $error=false;

    if($date_type)
    {
        if($date_type=='single_date')
        {   
            if(!empty($_POST['single_date']))
            {
                $error=false;
                $date_arr[]=$_POST['single_date'];
            }
            else
            {
                 $error=true;
                 $error_msg='Required field is empty';
            }
            
        }
        else if($date_type=='date_range')
        {   
            if(!empty($_POST['start_date']) || !empty($_POST['start_date']))
            {
                $error=false;
                $date_arr[]=$_POST['start_date'];
                $date_arr[]=$_POST['end_date'];
            }
            else
            {
                $error=true;
                $error_msg='Required field is empty';
            }
            
        }
    }
    else
    {
       $error=true;
       $error_msg='Required field is empty';
    }

    if($error==false)
    {
            $data=$obj->get_canvas_report($date_type,$date_arr,$keywords);

        if(!empty($data))
        {
            $_SESSION['report_data'] = $data;

            //commented by rahul 
            // $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

            //new code added by rahul
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                // Handle multiple IPs (comma separated)
                $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $ip = trim($ipList[0]); // take first one (original client)
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            $log_data=array(
                                'visitor_id'=>$user_id,
                                'visitor_type'=>'User',
                                'page_id'=>$page_id,
                                'ip_address'=>$ip,
                                'visit_date'=>date('Y-m-d H:i:s'),
                                'report_id'=>0,
                                'pg_log_status'=>1
                                );
            $res=$obj2->added_page_log_data($log_data);

            header( "Location:mycanvas_report_data.php" );

        }
        else
        {
            $error=true;
            $error_msg='No data found!';
        }
    }
    
  }

  $access_btn=$obj->check_user_subcription_plan_status($page_id);

?>

    <!DOCTYPE html>

    <html lang="en">

    <head>

        <?php include_once ('head.php'); ?>
    <style>

    .fstElement {
     /*display: initial !important; */
    position: relative;
    border: 1px solid #D7D7D7;
    box-sizing: border-box;
    color: #232323;
    font-size: 10px;
    background-color: #fff;
    width:100%;
    }

    .fstMultipleMode .fstControls {
        box-sizing: border-box;
        padding:inherit !important; 
        overflow: hidden;
        width:inherit !important;
        cursor: text;
    }

</style>

    </head>

    <body>

        <?php include_once ('analyticstracking.php'); ?>

        <?php include_once ('analyticstracking_ci.php'); ?>

        <?php include_once ('analyticstracking_y.php'); ?>

        <?php include_once ('header.php'); ?>

            <div class="container">

                <div class="breadcrumb">

                    <div class="row">

                        <div class="col-md-8">

                            <?php echo $obj->getBreadcrumbCode($page_id); ?>

                        </div>

                        <div class="col-md-4">

                            <?php
                                if ($obj->isLoggedIn()) {
                                    echo $obj->getWelcomeUserBoxCode($_SESSION['name'], $_SESSION['user_id']);
                                }
                                ?>

                        </div>

                    </div>

                </div>

            </div>

            <!--breadcrumb end -->

            <!--container-->

            <div class="container">

                <div class="row">

                    <div class="col-md-12">

                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                            <tr>

                                <td align="left" valign="top">
                                    <?php echo $obj->getPageContents($page_id); ?>
                                </td>

                            </tr>

                        </table>

                        <div class="alert alert-danger alert-dismissible fade in" id="plan_msg" style="display: none;">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                           Your current plan page limit exceeded now!
                      </div>

                        <?php 

                        if($error==true)
                        {
                           ?>
                           <div class="alert alert-danger alert-dismissible">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>Error!</strong> <?=$error_msg?>.
                            </div>
                           <?php
                        }

                        ?>

                        <form method="post" action="">
                            <div class="row">
                              <div class="form-group col-md-2">
                                <label>Date Selection</label>
                                <select name="date_type" id="date_type" class="form-control" onchange="toggleDateSelectionTypeUserNew('date_type');getkeywords();changeAttr();" required="">

                                    <option value="single_date">Single Date</option>
                                    <option value="date_range" >Date Range</option>

                                </select>
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-2" id="tblsingledate">
                                <label>Date:</label>
                                <input  name="single_date" id="single_date" type="text" class="form-control" onchange="getkeywords()" autocomplete="off">
                              </div>
                            </div>
                            <div class="row" id="tbldaterange"  style="display: none;">
                              <div class="form-group col-md-2">
                                <label>Start Date:</label>
                                <input  name="start_date" id="start_date" type="text" class="form-control" onchange="getkeywords()" autocomplete="off">
                              </div>
                              <div class="form-group col-md-2">
                                <label>End Date:</label>
                                <input  name="end_date" id="end_date" type="text" class="form-control" onchange="getkeywords()" autocomplete="off">
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-4">
                                <label>Keywords:</label>
                                    <select class="multipleSelect2 multipleInputDynamic form-control" name="keywords[]" id="keywords"  placeholder="Select your keywords" multiple >
                                    </select>
                              </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <?php 

                               if($access_btn==1)
                               {
                                  ?>
                                  <button type="submit" class="btn btn-info">Get Report Data</button>
                                  <?php
                               }
                               else
                               {
                                  ?>
                                  <button type="button" class="btn btn-info" onclick="plan_msg()">Get Report Data</button>
                                  <?php
                               }

                               ?>
                                    
                                </div>
                            </div>
                        </form>

                    </div>

                </div>

            </div>

    <?php include_once ('footer.php'); ?>

        <!--  Footer-->

        <div id="page_loading_bg" class="page_loading_bg" style="display:none;">

            <div id="page_loading_img" class="page_loading_img"><img border="0" src="<?php echo SITE_URL; ?>/images/loading.gif" /></div>

        </div>

        </div>

        </div>

        <script src="admin/js/fastselect.standalone.js"></script>

        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

        <script type="text/javascript">


            //add by ample
            $('#keywords').fastselect();
            $("input").attr("autocomplete", "off");
            $(document).ready(function () 
            {
                $("input").attr("autocomplete", "off");
            });


        function changeAttr()
        {
            
            $('#keywords').fastselect();
            $('#keywords').html('<option>No Keywords</option>').data('fastselect').destroy();
            $('#keywords').fastselect();
        }

        //new function for keywords (added condition with dates)
        function getkeywords()
        {

            var date_type=$('#date_type').val();
            error1=false;
            if(date_type=='date_range')
            {
             var start_date=$('#start_date').val();
             var end_date=$('#end_date').val();
             if(start_date=='')
             {
                alert('Please select start date');
                return false;
             }
             else
             if(end_date=='')
             {
                alert('Please select end date');
                return false;
             }
             else                
             if(!(start_date) && !(end_date) )
             {
                error1=true;
                alert('Please select date');
                return false;

             }
             var arr=[start_date,end_date]; 
            }
            else if(date_type=='single_date')
            {
              var single_date=$('#single_date').val();
             if(!(single_date))
             {
                error1=true;
                alert('Please select date');
                return false;
             }
              var arr=[single_date]; 
            }

            if(error1!=true)
            {   
                 $.ajax({
                type: "POST",
                url: "remote.php",
                data: {action:'getkeywords_mycanvas',date_type:date_type,arr:arr},
                cache: false,
                success: function(result)
                { 
                  // alert(result);
                  // console.log(result);
                  if(result!='')
                  {
                    $('#keywords').fastselect();
                    $('#keywords').html(result).data('fastselect').destroy();
                    $('#keywords').fastselect();
                  }
                  else
                  {
                    //alert('No details.');
                    $("#keywords").html('<option>Select list</option>');
                  }
                }
              }); 
            }
            else
            {
                alert('Please select date first');
                return false;
            }
            
        }

         //added by ample

          function plan_msg()
          {
            $('#plan_msg').fadeIn();
            $("html").animate({ scrollTop: 0 }, "slow");
          }

        </script>

    </body>

    </html>
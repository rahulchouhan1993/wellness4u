<?php

include ('classes/config.php');

$page_id = '151';

$obj = new frontclass();

$obj2 = new frontclass2();

$page_data = $obj->getPageDetails($page_id);

$ref = base64_encode($page_data['menu_link']);

$error = false;

$err_msg = '';

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'geteventstate')

{

    $country_id = $_REQUEST['event_country'];

    $state_id = '';

    $state_option = $obj->GetEventSateOption($country_id, $state_id);

    echo $state_option;

    exit(0);

}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'geteventcity')

{

    $country_id = $_REQUEST['event_country'];

    $state_id = $_REQUEST['event_state'];

    $city_id = '';

    $state_option = $obj->GetEventCityOption($country_id, $state_id = '', $city_id);

    //
    

    echo $state_option;

    exit(0);

}

//geteventarea


if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'geteventarea')

{

    $country_id = $_REQUEST['event_country'];

    $state_id = '';

    $city_id = $_REQUEST['event_city'];

    $area_id = '';

    $state_option = $obj->GetEventAreaOption($country_id, $state_id, $city_id, $area_id);

    echo $state_option;

    exit(0);

}


// $loc= $obj->getEventFullLocationOption();
// echo "<pre>";
// print_r($loc);
// die();

$event_data = array();

if (isset($_POST['btn_submit']))

{   

    // echo "<pre>";
    // print_r($_POST);
    // die('--sss');
    $error='0';
    // if(empty($_POST['event_type']) && empty($_POST['from_day_month_year']) && empty($_POST['to_day_month_year']) && empty($_POST['event_location']))
    // {
    //     $error='1';
    //     $err_msg='Please choose any filter/option!';
    // }
    // else
    // {   
        // $country_id = $_POST['event_country'];
        // $state_id = $_POST['event_state'];
        // $city_id = $_POST['event_city'];
        // $area_id = $_POST['event_area'];
        // $upcoming_current = $_POST['upcoming_current'];

        $area_id=$obj->GetAreaID($_POST['event_location']);
        $from_day_month_year = $_POST['from_day_month_year'];
        $to_day_month_year = $_POST['to_day_month_year'];
        $event_type = $_POST['event_type'];

        if(!empty($from_day_month_year) || !empty($to_day_month_year))
        {   

            if(empty($from_day_month_year) || empty($to_day_month_year))
            {
                $error='1';
                $err_msg='Please select both start/end date!';
            }
        }
        if(!empty($from_day_month_year) && !empty($to_day_month_year))
        {   

            if($from_day_month_year > $to_day_month_year)
            {
                $error='1';
                $err_msg='Please select right date!';
            }
        }

        if($error!='1')
        {
             $tdata = array();

            // $tdata['country_id'] = $country_id;
            // $tdata['state_id'] = $state_id;
            // $tdata['city_id'] = $city_id;
            // $tdata['area_id'] = $area_id;

            $tdata['area_id'] = $area_id;

            $tdata['from_day_month_year'] = $from_day_month_year;

            $tdata['to_day_month_year'] = $to_day_month_year;

            $tdata['event_type'] = ($event_type != '' ? $event_type : '');

            // echo "<pre>";
            // print_r($tdata);
            // die();
            

            $event_data = $obj->GetEventDataFront($tdata);

            // echo "<pre>";
            // print_r($event_data);
            // die();
            

            $tags_arr = '';

            if (count($event_data) > 0)

            {

                for ($i = 0;$i < count($event_data);$i++)

                {

                    //array_push($tags_arr, $event_data[$i]['event_tags']);
                    

                    $tags_arr .= $event_data[$i]['event_tags'] . ',';

                }

            }

            $tags_arr = explode(',', $tags_arr);

            $tags_arr = array_values(array_filter(array_unique($tags_arr)));

        }
    //}

}

else

{

    $country_id = '';

    $state_id = '';

    $city_id = '';

    $area_id = '';

    $from_day_month_year = '';

    $to_day_month_year = '';

    $event_type = '';

}

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include_once ('head.php'); ?>
            <link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css">
            <script type="text/javascript" src="w_js/jquery-1.12.4.min.js" charset="UTF-8"></script>
            <script type="text/javascript" src="w_js/datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script>
            <style>
            #explore .date button:hover,
            #explore .date .active {
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
            
            button,
            input,
            select,
            textarea {
                font-family: inherit;
                font-size: inherit;
                line-height: inherit;
            }
            </style>
    </head>

    <body>
        <?php include_once ('analyticstracking.php'); ?>
            <?php include_once ('analyticstracking_ci.php'); ?>
                <?php include_once ('analyticstracking_y.php'); ?>
                    <?php include_once ('header.php'); ?>
                        <section id="checkout">
                            <div class="container">
                                <div class="breadcrumb">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <?php echo $obj->getBreadcrumbCode($page_id); ?>
                                        </div>
                                        <div class="col-md-4">
                                            <?php

                                            if ($obj->isLoggedIn())

                                            {

                                                echo $obj->getWelcomeUserBoxCode($_SESSION['name'], $_SESSION['user_id']);

                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="explore" style="background-repeat:repeat; padding:5px;">
                                        <div class="col-md-12">
                                            <!--<h2> <span class="Header_brown"><?php //echo $obj->getPageTitle($page_id);
                                            ?></span></h2>-->
                                            <?php echo $obj->getPageContents($page_id); ?>
                                        </div>
                                        <form role="form" class="form-horizontal" id="event_listing" name="event_listing" enctype="multipart/form-data" method="post">
                                            <?php if ($error)
                                                { ?> <span style="color:red;"><?php echo $err_msg; ?></span>
                                                                                                <?php
                                                } ?>
                                                    <div class='col-md-12' style="margin-bottom:20px;">
                                                        <!-- <div class="col-md-2">
                                                            <span style="font-size:15px; font-weight: bold;" class="Header_brown">Select Country</span>
                                                            <br>
                                                            <select name="event_country" id="event_country" class="form-control" onchange="GetEventCity();" required="">
                                                                <option value="">Select Country</option>
                                                                <?php echo $obj->SelectEventCountry($country_id); ?>
                                                            </select>
                                                        </div> -->
                                                        <!-- <div class="col-md-2"> -->
                                                        <!--<span style="font-size:15px; font-weight: bold;" class="Header_brown">Select State</span>-->
                                                        <!-- select name="event_state" id="event_state" onchange="GetEventCity()" class="form-control" required="">



                                     <option value="">Select state</option>



                                     <?php echo $obj->GetEventSateOption($country_id, $state_id); ?>



                            </select -->
                                                        <!-- </div>

 -->
                                                        <!-- <div class="col-md-2">
                                                            <span style="font-size:15px; font-weight: bold;" class="Header_brown">Select City</span>
                                                            <br>
                                                            <select name="event_city" id="event_city" onchange="GetEventArea()" class="form-control" required="">
                                                                <option value="">Select City</option>
                                                                <?php echo $obj->GetEventCityOption($country_id, $state_id, $city_id); ?>
                                                            </select>
                                                        </div> -->
                                                        <!-- <div class="col-md-2">
                                                            <span style="font-size:15px; font-weight: bold;" class="Header_brown">Select Area</span>
                                                            <br>
                                                            <select name="event_area" id="event_area" class="form-control" required="">
                                                                <option value="">Select Area</option>
                                                                <?php echo $obj->GetEventAreaOption($country_id, $state_id, $city_id, $area_id); ?>
                                                            </select>
                                                        </div> -->
                                                        <!--                            <div class="col-md-3">



                               <span style="font-size:15px; font-weight: bold;" class="Header_brown">upcoming/current</span>



                               <select name="upcoming_current" id="upcoming_current" class="form-control" required="" onchange="ShowHideDate();">



                                   <option value="">Select upcoming/current</option>



                                   <option value="1" <?php //if($upcoming_current == 1) { echo 'selected'; }
 ?>>current</option>



                                   <option value="2" selected >current/upcoming</option>



                            </select>


    
                            </div> -->
                                                    <div class="col-md-3">
                                                            <!--<span style="font-size:15px; font-weight: bold;" class="Header_brown">Select Event Type</span>-->
                                                            <br>
                                                            <select name="event_type" id="event_type" class="form-control">
                                                                <option value="">All Event Type</option>
                                                                <?php echo $obj->getFavCategoryRamakant('60', $event_type); ?>
                                                            </select>
                                                        </div>


                                                        <div class="col-md-2">
                                                            <!--<span style="font-size:15px; font-weight: bold;" class="Header_brown">From Date</span>-->
                                                            <br>
                                                            <input type="text" value="<?php echo $from_day_month_year; ?>" name="from_day_month_year" id="from_day_month_year" placeholder="Select Date" class="form-control datepicker" autocomplete="off"> 
                                                        </div>
                                                        <div class="col-md-2" id="datehideshow">
                                                            <!--<span style="font-size:15px; font-weight: bold;" class="Header_brown">To Date</span>-->
                                                            <br>
                                                            <input type="text" value="<?php echo $to_day_month_year; ?>" name="to_day_month_year" id="to_day_month_year" placeholder="Select Date" class="form-control datepicker" autocomplete="off"> 
                                                        </div>

                                                        <div class="col-md-3">
                                                            <!--<span style="font-size:15px; font-weight: bold;" class="Header_brown">Select Event Type</span>-->
                                                            <br>
                                                            <input list="locations" class="form-control" name="event_location" id="event_location" placeholder="Search by Location" value="<?=$_POST['event_location'];?>">

                                                                <datalist id="locations">
                                                                  <?php 
                                                                  echo $obj->getEventFullLocationOption($area_id);
                                                                  ?>
                                                                </datalist>
                                                                <a href="javascript:void(0);" onclick="erase_input();"><i class="fa fa-eraser" id="erase_icon" aria-hidden="true" style="font-size: 14px;"></i></a>
                                                        </div>
                                                        
                                                        <div class="col-md-2 date">
                                                            <button type="submit" name="btn_submit" class="active">Explore Events</button>

                                                                 

                                                        </div>
                                                    </div>
                                        </form>
                                        <div class="col-md-12"> <span style="font-size:15px; font-weight: bold;" class="Header_brown">Search by Tags..</span>
                                            <br>
                                            <?php 
                                            $tags_arr = $tags_arr ?? [];
                                            if (count($tags_arr) > 0) {
                                                for ($i = 0; $i < count($tags_arr); $i++) { ?>
                                                <a href="event-search.php?event_location=<?php echo $_POST['event_location']; ?>&from_day_month_year=<?php echo $_POST['from_day_month_year']; ?>&to_day_month_year=<?php echo $_POST['to_day_month_year']; ?>&event_type=<?php echo $_POST['event_type']; ?>&tags=<?php echo $tags_arr[$i]; ?>&action=search_event" target="_blank" class="breadcrumb_link">
                                                    <?php echo $tags_arr[$i]; ?>
                                                </a>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php } } ?>
                                        </div>
                                    </div>
                                    <!--        <div class="col-md-2"> <?php //include_once('left_sidebar.php');
                                    ?></div>

                                        <div class="col-md-2"><?php //include_once('right_sidebar.php');
                                 ?></div>--></div>
                                <?php

                                    if (isset($_POST['btn_submit']))

                                    {

                                        if (count($event_data) > 0)
                                        {

                                            if ($event_type == '')

                                            {

                                                $event_type_data = $obj->getEventType('60');

                                            }

                                            else

                                            {

                                                $event_type_data = $obj->getEventTypebyid('60', $event_type);

                                            }

                                            

                                            
                                    ?>
                                                                        <?php

                                            //Event type loop started from here
                                            

                                            for ($i = 0;$i < count($event_type_data);$i++)

                                            {

                                                $tdata['event_type'] = $event_type_data[$i]['fav_cat_id'];


                                                $event_display_data = $obj->GetEventDataFront($tdata);



                                                if (count($event_display_data) > 0)

                                                {

                                    ?>
                                        <div class="">
                                            <div class="">
                                                <div class="col-md-12 controls pull-left hidden-xs" style="background-color: #FFCCCC; min-height: 30px; padding: 5px;">
                                                    <h3><?php echo $event_type_data[$i]['fav_cat']; ?></h3> </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- Controls -->
                                                    <div class="controls pull-right hidden-xs">
                                                        <a class="left fa fa-chevron-left btn btn" href="#carousel-example_<?php echo $i; ?>" data-slide="prev"></a>
                                                        <a class="right fa fa-chevron-right btn" href="#carousel-example_<?php echo $i; ?>" data-slide="next"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="carousel-example_<?php echo $i; ?>" class="carousel slide hidden-xs" data-interval="false">
                                                <!-- Wrapper for slides -->
                                                <div class="carousel-inner">
                                                    <!-- active lisitng start -->
                                                    <div class="item active">
                                                        <div class="row">
                                                            <?php

                                                $event_count = count($event_display_data);

                                                //$count_loop = 3;
                                                

                                                $loop_count = min(array(
                                                    "$event_count",
                                                    "4"
                                                ));

                                                for ($j = 0;$j < $loop_count;$j++)
                                                {

                                ?>
                        <div class="col-sm-3">
                            <div class="col-item">
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-6" style="color: #AA1144;">
                                            <h5><a href="event-details.php?token=<?php echo base64_encode($event_display_data[$j]['event_id']); ?>" target="_blank" class="hidden-sm"><?php echo substr($event_display_data[$j]['event_name'], 0, 50); ?></a></h5>
                                            <h5 class="price-text-color"></h5> </div>
                                        <div class="rating  col-md-6">
                                            <h5><?php echo $event_display_data[$j]['reference_number']; ?></h5> </div>
                                    </div>
                                </div>
                                <div class="photo"> <img src="wa/uploads/<?php echo $event_display_data[$j]['event_image']; ?>" style="width:266px; height: 177px;" class="img-responsive" alt="" /> </div>
                                <div class="info">
                                    <div class="separator clear-left">
                                        <p style="text-align: left; font-size: 12px;">
                                            <?php echo substr(strip_tags($event_display_data[$j]['event_contents']) , 0, 40); ?>
                                        </p>
                                    </div>
                                    <div class="separator clear-left" style="text-align: left; font-size: 12px;">
                                        <p class="btn-details"> <i class="fa fa-clock-o"></i>
                                            <?php echo date("d-m-Y", strtotime($event_display_data[$j]['start_date'])) . '<br>' . $event_display_data[$j]['start_time']; ?>
                                        </p>
                                        <p class="btn-details"> <i class="fa fa-clock-o"></i>
                                            <?php echo date("d-m-Y", strtotime($event_display_data[$j]['end_date'])) . '<br>' . $event_display_data[$j]['end_time']; ?>
                                        </p>
                                    </div>
                                    <div class="separator clear-left">
                                        <p style="text-align: left; font-size: 12px; font-weight: bold;">
                                            <?php echo substr($event_display_data[$j]['venue_details'], 0, 30); ?>
                                        </p>
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add">
                                            <?php 

                                            if(!empty($event_display_data[$j]['online_registration_link']))
                                            {
                                                ?>
                                                <a href="<?=$event_display_data[$j]['online_registration_link']?>" target="_blank" title="<?=$event_display_data[$j]['online_registration_id'];?>"><button style="min-width: 50px;height: 25px;">Online</button></a>
                                                <?php
                                            }

                                            ?>

                                            
                                        </p>
                                        <p class="btn-details"> <i class="fa fa-list"></i><a href="event-details.php?token=<?php echo base64_encode($event_display_data[$j]['event_id']); ?>" target="_blank" class="hidden-sm">View details</a> </p>
                                    </div>
                                    <div class="clearfix"> </div>
                                </div>
                            </div>
                        </div>
                                                                <?php
                } ?>
                                                        </div>
                                                    </div>
                                                    <!-- Active Listing Close -->
                                                    <!-- hidden Listing start -->
                                                    <?php

                $loop_count_top = count($event_display_data) - 4;

                $loop_count_top_counter = ceil($loop_count_top / 4);

                // echo $loop_count_top_counter;
                

                // die();
                

                for ($l = 0;$l < $loop_count_top_counter;$l++)

                {

                    ?>
                                                        <div class="item">
                                                            <div class="row">
                                                                <?php

                    static $m = 4;

                    $loop_count2 = count($event_display_data) - ($m + 1);

                    $loop_count_child = min(array(
                        "$loop_count2",
                        "3"
                    ));

                    for ($k = 0;$k <= $loop_count_child;$k++)
                    {

                        //echo '<br>$loop_count_child'.$k+$m;
                        

                        
                    ?>
                                <div class="col-sm-3">
                                    <div class="col-item">
                                        <div class="info">
                                            <div class="row">
                                                <div class="price col-md-6" style="color: #AA1144;">
                                                    <h5><a href="event-details.php?token=<?php echo base64_encode($event_display_data[$m]['event_id']); ?>" target="_blank" class="hidden-sm"><?php echo $event_display_data[$m]['event_name']; ?></a></h5>
                                                    <h5 class="price-text-color"></h5> </div>
                                                <div class="rating col-md-6">
                                                    <h5><?php echo $event_display_data[$m]['reference_number']; ?></h5> </div>
                                            </div>
                                        </div>
                                        <div class="photo"> <img src="wa/uploads/<?php echo $event_display_data[$m]['event_image']; ?>" style="width:266px; height: 177px;" class="img-responsive" alt="a" /> </div>
                                        <div class="info">
                                            <div class="separator clear-left">
                                                <p style="text-align: left; font-size: 12px;">
                                                    <?php echo substr(strip_tags($event_display_data[$m]['event_contents']) , 0, 40) ?>
                                                </p>
                                            </div>
                                            <div class="separator clear-left" style="text-align: left; font-size: 12px;">
                                                <p class="btn-details"> <i class="fa fa-clock-o"></i>
                                                    <?php echo date("d-m-Y", strtotime($event_display_data[$m]['start_date'])) . '<br>' . $event_display_data[$m]['start_time']; ?>
                                                </p>
                                                <p class="btn-details"> <i class="fa fa-clock-o"></i>
                                                    <?php echo date("d-m-Y", strtotime($event_display_data[$m]['end_date'])) . '<br>' . $event_display_data[$m]['end_time']; ?>
                                                </p>
                                            </div>
                                            <div class="separator clear-left">
                                                <p style="text-align: left; font-size: 12px; font-weight: bold;">
                                                    <?php echo substr($event_display_data[$m]['venue_details'], 0, 30); ?>
                                                </p>
                                            </div>
                                            <div class="separator clear-left">
                                                <p class="btn-add">

                                            <?php 

                                            if(!empty($event_display_data[$m]['online_registration_link']))
                                            {
                                                ?>
                                                <a href="<?=$event_display_data[$m]['online_registration_link']?>" target="_blank" title="<?=$event_display_data[$m]['online_registration_id'];?>"><button style="min-width: 50px;height: 25px;">Online</button></a>
                                                <?php
                                            }

                                            ?>

                                                 </p>
                                                <p class="btn-details"> <i class="fa fa-list"></i><a href="event-details.php?token=<?php echo base64_encode($event_display_data[$m]['event_id']); ?>" target="_blank" class="hidden-sm">View details</a> </p>
                                            </div>
                                            <div class="clearfix"> </div>
                                        </div>
                                    </div>
                                </div>
                                                                    <?php

                        $m++;

                    }

?>
                                                            </div>
                                                        </div>
                                                        <?php
                } ?>
                                                            <!-- Hidden listing close -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="height: 50px;"></div>
                                        <?php
            }
            else
            {

?>
                                            <!--<div class="row" style="height: 50px;">At present No Events is going on try another date combination</div>-->
                                            <?php

            } ?>
                                                <?php

        }

        //Event type loop End from here
        

        
    } //Main if condition close here
    

    else
    {

?>
                                                    <div class="row" style="height: 50px;">At present No Events is going on at this category please try another category and date combination</div>
                                                    <?php

    }

}

?>
                            </div>
    <div class="container">
        <div class="container"> </div>
        <style>
        .col-item {
            border: 2px solid #2323A1;
            border-radius: 5px;
            background: #FFF;
        }
        
        .col-item .photo img {
            margin: 0 auto;
            width: 100%;
        }
        
        .col-item .info {
            padding: 10px;
            border-radius: 0 0 5px 5px;
            margin-top: 1px;
        }
        
        .col-item:hover .info {
            background-color: rgba(215, 215, 244, 0.5);
        }
        
        .col-item .price {
            /*width: 50%;*/
            float: left;
            margin-top: 5px;
        }
        
        .col-item .price h5 {
            line-height: 20px;
            margin: 0;
        }
        
        .price-text-color {
            color: #00990E;
        }
        
        .col-item .info .rating {
            color: #003399;
        }
        
        .col-item .rating {
            /*width: 50%;*/
            float: left;
            font-size: 17px;
            text-align: right;
            line-height: 52px;
            margin-bottom: 10px;
            height: 52px;
        }
        
        .col-item .separator {
            border-top: 1px solid #FFCCCC;
        }
        
        .clear-left {
            clear: left;
        }
        
        .col-item .separator p {
            line-height: 20px;
            margin-bottom: 0;
            margin-top: 10px;
            text-align: center;
        }
        
        .col-item .separator p i {
            margin-right: 5px;
        }
        
        .col-item .btn-add {
            width: 50%;
            float: left;
        }
        
        .col-item .btn-add {
            border-right: 1px solid #CC9999;
        }
        
        .col-item .btn-details {
            width: 50%;
            float: left;
            padding-left: 10px;
        }
        
        .controls {
            margin-top: 20px;
        }
        
        [data-slide="prev"] {
            margin-right: 10px;
        }
        </style>
        <!-- Product Slider - END -->
    </div>
</section>
<?php include_once ('footer.php'); ?>
    <script>
    // $(document).ready(function() {
    //     $('.vloc_speciality_offered').tokenize2();
    //     $('#from_day_month_year').attr('autocomplete', 'off');
    //     $('#to_day_month_year').attr('autocomplete', 'off');
    //     $('#from_day_month_year').datepicker({
    //         dateFormat: 'dd-mm-yy',
    //         minDate: '0D',
    //         onSelect: function(selectedDate) {
    //             //$('#to_day_month_year').datepicker('option', 'minDate', selectedDate);
    //             var date2 = $('#from_day_month_year').datepicker('getDate');
    //             date2.setDate(date2.getDate() + 2);
    //             $("#to_day_month_year").datepicker('option', 'minDate', date2);
    //         }
    //     });
    //     $('#to_day_month_year').datepicker({
    //         dateFormat: 'dd-mm-yy'
    //             //minDate: $("#from_day_month_year").val();
    //     });
    // });

    $( "#from_day_month_year" ).datepicker({ 
        dateFormat: 'dd-mm-yy', 
        minDate:'0d'
    });

     $('#to_day_month_year').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate:'0d'
        });

    function GetEventState() {
        var event_country = $("#event_country").val();
        var dataString = 'event_country=' + event_country + '&action=geteventstate';
        $.ajax({
            type: "POST",
            url: 'event-listing.php',
            data: dataString,
            cache: false,
            success: function(result) {
                //   alert(result);
                $('#event_state').html(result);
            }
        });
    }

    function GetEventCity() {
        var event_country = $("#event_country").val();
        var event_state = 0;
        var dataString = 'event_country=' + event_country + '&event_state=' + event_state + '&action=geteventcity';
        $.ajax({
            type: "POST",
            url: 'event-listing.php',
            data: dataString,
            cache: false,
            success: function(result) {
                //   alert(result);
                $('#event_city').html(result);
            }
        });
    }

    function GetEventArea() {
        var event_country = $("#event_country").val();
        var event_state = 0;
        var event_city = $("#event_city").val();
        var dataString = 'event_country=' + event_country + '&event_state=' + event_state + '&event_city=' + event_city + '&action=geteventarea';
        $.ajax({
            type: "POST",
            url: 'event-listing.php',
            data: dataString,
            cache: false,
            success: function(result) {
                //   alert(result);
                $('#event_area').html(result);
            }
        });
    }

    function ShowHideDate() {
        var flag = $("#upcoming_current").val();
        if(flag == 1) {
            $("#datehideshow").hide();
        } else {
            $("#datehideshow").show();
        }
    }

    function isNumberKey(evt) { <!--Function to accept only numeric values-->
        //var e = evt || window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if(charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) return false;
        return true;
    }
    //copy by ample
    function erase_input()
     {
       $("#event_location").val('');
     }

    </script>
    </body>

    </html>

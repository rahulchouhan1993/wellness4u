<?php 

include('classes/config.php');

$page_id = '212';

$obj = new frontclass();

$obj2 = new frontclass2();


$page_data = $obj->getPageDetails($page_id);


$ref = base64_encode($page_data['menu_link']);


if(isset($_SESSION['adm_vendor_id']) && !empty($_SESSION['adm_vendor_id']))
    {
        $vendor_id=$_SESSION['adm_vendor_id'];

    }
    else
    {
        if($obj->isLoggedIn())
         {
         
              $user_id = $_SESSION['user_id'];
         
         }
         else
         {
               header("Location: login.php?ref=".$ref);
               exit();
         }

    }


//$events=$obj->get_today_task_events();

// echo '<pre>';

// print_r($events);

// die('-ss');

?>

<!DOCTYPE html>

<html lang="en">

  <head>    
  <?php include_once('head.php');?>
  <style type="text/css">
  	.bg-box
  	{
  		padding: 15px;
  	}
  </style>
  </head>

  <body>

  <?php include_once('header.php');?>

  <link rel="stylesheet" type="text/css" href="fullcalendar/core/main.min.css" />
  <link rel="stylesheet" type="text/css" href="fullcalendar/daygrid/main.min.css" />
  <link rel="stylesheet" type="text/css" href="fullcalendar/timegrid/main.min.css" />
  <link rel="stylesheet" type="text/css" href="fullcalendar/list/main.min.css" />
  <link rel="stylesheet" type="text/css" href="fullcalendar/bootstrap/main.min.css" />

  <script src="fullcalendar/core/main.min.js"></script>
  <script src="fullcalendar/daygrid/main.min.js"></script>
  <script src="fullcalendar/timegrid/main.min.js"></script>
  <script src="fullcalendar/list/main.min.js"></script>
  <script src="fullcalendar/bootstrap/main.min.js"></script>




    <section id="checkout">
      <div class="container">
        <div class="breadcrumb">
          <div class="row">
            <div class="col-md-8">  
              <?php echo $obj->getBreadcrumbCode($page_id);?> 
            </div>
            <div class="col-md-4">
            </div>
          </div>
        </div>
        <div class="">
          <span id="response_msg"></span>
          <span id="error_msg"></span>
          <div class="col-md-10" id="bgimage" style="background-repeat:repeat; padding:5px;">
            <div class="row">
              <div class="col-md-12" id="testdata">
                <?php echo $obj->getPageIcon($page_id);?>
                <span class="Header_brown"><?php echo $page_data['page_title'];?></span><br /><br />
                <?php echo $obj->getPageContents($page_id);?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
               <br>
              	  <div id='calendar'></div>
              </div>
            </div>
        </div>
        <div class="col-md-2">
            <?php include_once('left_sidebar.php'); ?>
            <?php include_once('right_sidebar.php'); ?>
            </div>
      </div>
    </div>
  </section>
<?php include_once('footer.php');?> 

<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'dayGrid', 'timeGrid', 'list', 'bootstrap' ],
    timeZone: 'Asia/Calcutta',
    themeSystem: 'bootstrap',
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    weekNumbers: true,
    eventLimit: true, // allow "more" link when too many events
    // events: 'https://fullcalendar.io/demo-events.json'
    events: {
    url: 'remote.php',
    method: 'POST',
    extraParams: {
      action: 'my_calendar_data',
    },
    failure: function() {
      alert('there was an error while fetching events!');
    }
  }
  });

  calendar.render();
});

// get_event_data();

// function get_event_data()
// {
//    $.ajax({
//         type: "POST",
//         url: "remote.php",
//         data: {action:'my_calendar_data'},
//         cache: false,
//         success: function(result)
//         { 
//           alert(result);
//           console.log(result);
//         }
//       }); 
// }
</script>

  </body>

</html>
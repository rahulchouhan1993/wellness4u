<?php 

include('classes/config.php');

$page_id = '999';

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


?>

<!DOCTYPE html>

<html lang="en">

  <head>    
  <?php include_once('head.php');?>
  <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />
  <!-- If you use the default popups, use this. -->
<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />
<link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />


<script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.js"></script>
<script src="https://uicdn.toast.com/tui.dom/v3.0.0/tui-dom.js"></script>
<script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
<script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
<script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
  </head>

  <body>

  <?php include_once('header.php');?>


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
              	<h1>Toast Calendar</h1> <br>
              		 <div id="menu">
      <span id="menu-navi">
        <button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">Today</button>
        <button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev">
          <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
        </button>
        <button type="button" class="btn btn-default btn-sm move-day" data-action="move-next">
          <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
        </button>
      </span>
      <span id="renderRange" class="render-range"></span>
    </div>

              		<div id="calendar" style="height: 800px;"></div>
              </div>
            </div>
        </div>
        <div class="col-md-2"><?php include_once('right_sidebar.php'); ?></div>
      </div>
    </div>
  </section>
<?php include_once('footer.php');?> 




<script type="text/javascript">




  var calendar = new tui.Calendar('#calendar', {
    defaultView: 'month',
    taskView: true,  // e.g. true, false, or ['task', 'milestone'])
    scheduleView: ['time']  // e.g. true, false, or ['allday', 'time'])

  });


  calendar.today();

  calendar.prev();

  calendar.next();

  // daily view
calendar.changeView('day', true);

// weekly view
calendar.changeView('week', true);

calendar.changeView('month', true);




</script>


  </body>

</html>

<?php

include('config.php');
require_once('admin/config/class.mysql.php');
require_once('admin/classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();

$day = date('j');
$all_data=getAllIconsDetailsValueVivek($day);
$txtdetail=$_GET['txtdetail'];

//$theme_data=getThemeDataValueVivek();
//echo '<pre>';
//print_r($all_data);
//echo '</pre>';
//die();

?>
<html lang="en">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="description" content="<?php echo $meta_description;?>" />

    <meta name="keywords" content="<?php echo $meta_keywords;?>" />

    <meta name="title" content="<?php echo $meta_title;?>" />

    <title>wellnessway4u.com</title>

    <link href="cwri.css" rel="stylesheet" type="text/css" />

     <link href="csswell/bootstrap/css/bootstrap.min.css" rel="stylesheet">       <link href="csswell/bootstrap/css/ww4ustyle.css" rel="stylesheet" type="text/css" />

    <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>

    <script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>

    

    <script type="text/javascript" src="js/jquery.bxSlider.js"></script>

    

    <script type="text/JavaScript" src="js/jquery.autoSuggestMDT.js"></script>

    <link href="css/autoSuggest.css" rel="stylesheet" type="text/css" />

        

    <script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>

    <script type="text/javascript" src="js/selectToUISlider.jQuery.js"></script>

    <link rel="stylesheet" href="css/redmond/jquery-ui-1.7.1.custom.css" type="text/css" />

    <link rel="Stylesheet" href="css/ui.slider.extras.css" type="text/css" />

         

    <style type="text/css">@import "css/jquery.datepick.css";</style> 

    <script type="text/javascript" src="js/jquery.datepick.js"></script>

    

    <link href="css/ticker-style.css" rel="stylesheet" type="text/css" />

    <script src="js/jquery.ticker.js" type="text/javascript"></script>

    

    <script type="text/JavaScript" src="js/commonfn.js"></script>

    

    
    <link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />

    <script type="text/javascript" src="js/ddsmoothmenu.js"></script>

    

</head>


<div class="container" style="margin:40px;">
    
<div class="row" style="text-align: center;">
    
 <?php foreach($all_data as $rec) {?>   
<div class="col-md-2">
    <strong style="color: #993366; font-family: verdana, geneva; font-size: 12px;">
        <a href="index.php?icons_id=<?php echo $rec['icons_id'];?>&theme_id=<?php echo $_GET['theme_id'];?>">
            <div class="img-circle">
                <img title="<?php echo $rec['icons_name'];?>" src="uploads/<?php echo $rec['image']; ?>" alt="" width="150" height="150" />
            </div>
           <h4><?php echo $rec['icons_name'];?></h4>
        </a> 
    </strong>
</div>
    <?php } ?>
<!--    <div class="col-md-2">
    <strong style="color: #993366; font-family: verdana, geneva; font-size: 12px;">
        <a href="problem.php">
            <div class="img-circle">
                <img title="Share Your Problem" src="uploads/1475308297_My-Situation-wellness-way-4-u-04.jpg" alt="Share Your Problem" width="150" height="150" />
            </div>
            <h4>Share Your Problem</h4>
        </a> 
    </strong>
</div>
    <div class="col-md-2">
    <strong style="color: #993366; font-family: verdana, geneva; font-size: 12px;">
        <a href="problem.php">
            <div class="img-circle">
                <img title="Share Your Problem" src="uploads/1475308297_My-Situation-wellness-way-4-u-04.jpg" alt="Share Your Problem" width="150" height="150" />
            </div>
            <h4>Share Your Problem</h4>
        </a> 
    </strong>
</div>
    <div class="col-md-2">
    <strong style="color: #993366; font-family: verdana, geneva; font-size: 12px;">
        <a href="problem.php">
            <div class="img-circle">
                <img title="Share Your Problem" src="uploads/1475308297_My-Situation-wellness-way-4-u-04.jpg" alt="Share Your Problem" width="150" height="150" />
            </div>
            <h4>Share Your Problem</h4>
        </a> 
    </strong>
</div>-->
</div>
</div>
<!--html end-->
                                                  
<!--container-->                 

            

           <!--  Footer-->

  <footer> 

   <div class="container">

   <div class="row">

   <div class="col-md-12">	

   <?php include_once('footer.php');?>            

  </div>

  </div>

  </div>

  </footer>

  <!--  Footer-->



<?php

$music = '';

if($music !='') 

{ ?>

    <div class="floatdiv">

        <embed src="<?php echo SITE_URL.'uploads/'. $music;?>" autostart="true" loop="true" width="50" height="30" type="<?php echo $type; ?>"></embed>

        <br><span class="footer">(Toggle BG Music)</span><br>

        <a href="<?php echo $credit_url; ?>" target="_blank"><span class="footer"><?php echo $credit; ?></span></a>

    </div>

<?php 

} ?>  



<!-- Bootstrap Core JavaScript -->



 <!--default footer end here-->

       <!--scripts and plugins -->

        <!--must need plugin jquery-->

       <!-- <script src="csswell/js/jquery.min.js"></script>-->        

        <!--bootstrap js plugin-->

        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 

</body>

</html>


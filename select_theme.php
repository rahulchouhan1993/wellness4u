<?php

include('config.php');
require_once('admin/config/class.mysql.php');
require_once('admin/classes/class.scrollingwindows.php');
$obj = new Scrolling_Windows();
$display_data=getAllIconsDisplayTypeDetailsVivek();

$day = date('j');
$theme_data=getThemeDataValueVivek($day);

//echo '<pre>';
//print_r($theme_data);
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
    
<div class="row" style="text-align: center;" >
    
<?php for($i=0; $i<count($theme_data); $i++){?>  
    
<div class="col-md-2">
    <strong style="color: #993366; font-family: verdana, geneva; font-size: 12px;">
        <a href="index.php?theme_id=<?php echo $theme_data[$i]['theam_id'];?>&icons_id=<?php echo $_GET['icons_id'];?>">
            <div class="img-circle">
               <img title="<?php echo $theme_data[$i]['theam_name'];?>" id="bgimage_<?php echo $i;?>"  src="uploads/<?php echo $theme_data[$i]['image'];?>" alt="Select Theme" width="150" height="150" />
            </div>
            <!--<h4>Share Your Problem</h4>-->
            <h4  style="margin-top:20px;"><?php echo $theme_data[$i]['theam_name'];?></h4>
        </a> 
    </strong>
</div>
        
                                                       
<?php }?>
    
    <?php // foreach($theme_data as $rec){?>  
    
<!--<div class="col-md-2">
    <strong style="color: #993366; font-family: verdana, geneva; font-size: 12px;">
        <a href="index1.php?theme_id=//<?php echo $rec['theam_id'];?>">
            <div class="img-circle">
                <input type="text" name="theam_id" id="theam_id_//<?php echo $i;?>" value="<?php echo $rec['theam_id'];?>"  class="form-control" readonly/>
    
                <img title="Share Your Problem" id="bgimage" src="uploads/1475308297_My-Situation-wellness-way-4-u-04.jpg" alt="Share Your Problem" width="150" height="150" />
            </div>
            <h4>Share Your Problem</h4>
            <h4  style="margin-top:20px;"></h4>
        </a> 
    </strong>
</div>-->
        
                                                       
<?php // }?>    
<!--<div class="col-md-2">
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
<script>
//$( document ).ready(function(){
//function ChangeTheamMDTVivek(idval)
//{
// alert('hii');   
////   var count_data = document.getElementById('count_data').value;
//////   var idval=0;
//// alert(count_data);
////   for(var idval = 0; idval < count_data; idval++)
////   {
//       
//    var theam_id = document.getElementById('theam_id_'+idval).value;
//     
//   
//    link='remote.php?action=changtheammdt&theam_id='+theam_id;
//    var linkComp = link.split( "?");
//    var result;
//    var obj = new ajaxObject(linkComp[0], fin);
//    obj.update(linkComp[1],"GET");
//    obj.callback = function (responseTxt, responseStat) {
//        // we'll do something to process the data here.
//        result = responseTxt.split("::");
//        $('#bgimage_'+idval).css("background-image", "url("+result[0]+")");
//        $('#color_code').css("background-color", result[1]); 
//    }
//    }
//}
//});
</script>
        <script src="csswell/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 

</body>

</html>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?php echo $meta_description;?>" />
	<meta name="keywords" content="<?php echo $meta_keywords;?>" />
	<meta name="title" content="<?php echo $meta_title;?>" />
	<title><?php echo $meta_title;?></title>
	<link href="cwri.css" rel="stylesheet" type="text/css" />
	<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
	<script type="text/JavaScript" src="js/jquery-1.4.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.min.css" />
    <link rel="stylesheet" type="text/css" href="css/examples.min.css" />
    <link type="text/css" rel="stylesheet" href="css/shCoreDefault.min.css" />
    <link type="text/css" rel="stylesheet" href="css/shThemejqPlot.min.css" />
    <script  language="javascript" src="js/jquery.min.js"></script>
	<script  language="javascript" src="js/jquery.jqplot.min.js"></script>
	
<!-- Additional plugins go here -->

    <script class="include" language="javascript" type="text/javascript" src="js/jqplot.dateAxisRenderer.min.js"></script>

<!-- End additional plugins -->
    
	<script  language="javascript">
  $(document).ready(function(){
  var line1=[[4,'2008-06-30 8:00AM'], [6.5,'2008-07-01 8:00AM'], [5.7,'2008-7-02 8:00AM'], [9,'2008-7-03 8:00AM'], [8.2,'2008-8-25 8:00AM']];
  var plot2 = $.jqplot('chart2', [line1], {
      title:'Customized Date Axis',
      axes:{
        yaxis:{
          renderer:$.jqplot.DateAxisRenderer,
          tickOptions:{formatString:'%b %#d, %#I %p'},
          min:'June 16, 2008 8:00AM',
          tickInterval:'1 day'
        }
      },
      series:[{lineWidth:4, markerOptions:{style:'square'}}]
  });
});
</script>
</head>
<body>
<?php include_once('analyticstracking.php'); ?>
<?php include_once('analyticstracking_ci.php'); ?>
<?php include_once('analyticstracking_y.php'); ?>
<div id="chart2" style="height:800px; width:650px;"></div>
</body>
</html>
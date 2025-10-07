<?php
include('../config.php');
$pdf = $_GET['pdf'];

$dir      = SITE_PATH."/uploads/"; //zelfde map
$file = $pdf;
//echo $file;
if ((isset($file))&&(file_exists($dir.$file))) { 
   header("Content-type: application/force-download"); 
   header('Content-Disposition: inline; filename="' . $dir.$file . '"'); 
   header("Content-Transfer-Encoding: Binary"); 
   header("Content-length: ".filesize($dir.$file)); 
   header('Content-Type: application/octet-stream'); 
   /*Note that if I comment out the line below, the behaviour is like mendix: the download is not recognized as a Worddoc but as a zip-file or unknown extension*/
   header('Content-Disposition: attachment; filename="' . $file . '"'); 
   readfile("$dir$file"); 
}
?>
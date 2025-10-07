<?php 

include('classes/config.php');

$obj = new frontclass();





if(isset($_GET['id']))

{

	$page_id = $_GET['id'];

}

else

{

	header('location: message.php');

	exit(0);

}



$page_data = $obj->getPageDetails($page_id);



if($page_data['page_name'] == '')



{



	header('location: message.php');



	exit(0);



}	







if($obj->isLoggedIn())



{



	$user_id = $_SESSION['user_id'];



	$obj->doUpdateOnline($_SESSION['user_id']);



}

?>

<!DOCTYPE html>

<html lang="en">

<head>    

    <?php include_once('head.php');?>

</head>

<body>

<?php include_once('analyticstracking.php'); ?>



<?php include_once('analyticstracking_ci.php'); ?>



<?php include_once('analyticstracking_y.php'); ?>

<?php include_once('header.php');?>

    

<div id='changemusic'></div>

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

                    

                    <div class="col-md-8" id="bgimage" style="background-repeat:repeat; padding:5px;">

                        <!-- code write by ample 11-12-19 -->
                         <?php if($page_data['page_icon']!='') { 

                                if($page_data['page_icon_type']=='Image')
                                {   

                                    $imgData=$obj->getImgData($page_data['page_icon']);
                                    if(!empty($imgData['image']))
                                    {
                                        ?>
                                        <img src="uploads/<?php echo $imgData['image']; ?>" style="width:128px; height: 128px;">
                                        <?php
                                    }
                                }
                                else
                                {   
                                    $fileData=$obj->getFileData($page_data['page_icon']);
                                    ?>
                                    <a href="<?php echo SITE_URL.'/uploads/'. $fileData['box_banner'];?>" target="_blank"><?php echo $fileData['box_banner'];?></a> 
                                    <?php
                                }
                            ?>
                         <?php } ?>
                         <br>
                        <span class="Header_brown"><?php echo $page_data['page_title'];?></span><br /><br />

                        <?php echo $obj->getPageContents($page_id);?>

                        <br><p></p> <br><p></p> <br><p></p> <br>

                     

                        <div  class="col-md-8" >

                             <?php echo $obj->getScrollingWindowsCodeMainContent($page_id);?>

                            <?php echo $obj->getPageContents2($page_id);?>

                        </div>

                    </div>

		<div class="col-md-2"> <?php include_once('left_sidebar.php'); ?></div>

		<div class="col-md-2"><?php include_once('right_sidebar.php'); ?></div>

		</div>

	</div>

</section>

<?php include_once('footer.php');?>	 

  

</body>

</html>
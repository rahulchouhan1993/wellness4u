<?php
include('classes/config.php');

$page_id = '44';
$obj = new frontclass();
$obj2 = new frontclass2();
$page_data = $obj->getPageDetails($page_id);

if($obj->isLoggedIn())

{

    $obj->doUpdateOnline($_SESSION['user_id']);

    $user_id = $_SESSION['user_id'];

}

else

{

    $user_id = 0;

}



//add by ample 03-06-20 

$data=$rss_data=$banner_data=array();
$Keyword="";
$title="";
if(isset($_GET['title']))
{

  $readonly=$_GET['title'];
  $title=$_GET['title'];
  if(!empty($title))
  {
    $title=base64_decode($title);

  }
}

if(isset($_GET['search']))
{

  $readonly=$_GET['search'];
  $title=$_GET['search'];
}



$error=false;

if(isset($_POST) && !empty($_POST))
{ 
   $title=trim($_POST['query']);
   $search_Keyword=trim($_POST['Keyword']);

   $category=$_POST['category'];

   if(empty($title) && empty($search_Keyword) && empty($category))
   {

      $error=true;

   }
   else
   {  
        $search_Keyword=explode(',',$search_Keyword);

        if(!empty($title))
          {
            $banner_data=$obj->get_data_from_wellness_items($title);
          }



          $keyword_filter=preg_replace("/^'|[^A-Za-z0-9\'-]|'$/", ' ', $title); //add by ample 11-05-20                 
          $keywords= explode(' ',$keyword_filter);
          $exclusion_data = $obj->getExclusionAllName('Menu','68'); //update by ample 28-08-20 

          $exclusion_data = array_unique($exclusion_data);

          if(!empty($keywords))
          {
            foreach ($keywords as $key => $value) {
               if(in_array(strtolower($value),$exclusion_data)) 
               {
                  unset($keywords[$key]);
               }
            }
          }

          $category_ids=array();
          if(!empty($category))
          {
              foreach ($category as $index => $row) {
                  $category_ids[]=$obj->getFavCategoryNameRamakant($row);
              }
          }
          
          $all_keywords = array_merge($keywords, $search_Keyword,$category_ids);

          foreach ($all_keywords as $key2 => $value2) {
            $category[]=$obj->getFavCategoryID_by_favname($value2);
          }

          $all_keywords = array_unique($all_keywords);

          $all_keywords = array_filter($all_keywords);

          $all_keywords=array_values($all_keywords);

          $data=$obj->get_data_from_wellness_items_for_keywords($all_keywords,$category);

          $rss_data=$obj->get_filter_data_rss_feed_items($title,$all_keywords);

          // $mj_data=$obj->get_filter_data_mindjumble($title,$all_keywords);
   }

    // $alltags=array();
    // if(!empty($banner_data))
    // {
    //   foreach ($banner_data as $key => $value) {
    //       $tags=explode(',', $value['tags']);

    //       $alltags=array_merge($alltags,$tags);
    //   }
    // }

    // $alltags = array_unique($alltags);
    // $keywords=array_merge($keywords,$alltags);

   // echo "<pre>";

   // print_r($banner_data);

   // die('--');

}
else
{
  if(!empty($title))
  {
    $banner_data=$obj->get_data_from_wellness_items($title);


    $keyword_filter=preg_replace("/^'|[^A-Za-z0-9\'-]|'$/", ' ', $title); //add by ample 11-05-20                 
    $keywords= explode(' ',$keyword_filter);
    $exclusion_data = $obj->getExclusionAllName('Page','6');

    $exclusion_data = array_unique($exclusion_data);

    if(!empty($keywords))
    {
      foreach ($keywords as $key => $value) {
         if(in_array(strtolower($value),$exclusion_data)) 
         {
            unset($keywords[$key]);
         }
      }
    }
    $keywords = array_unique($keywords);
    $keywords=array_values($keywords);


    

    $data=$obj->get_data_from_wellness_items_for_keywords($keywords);


    $rss_data=$obj->get_filter_data_rss_feed_items($title,$keywords);


     // print_r($keywords); die();

    // $alltags=array();
    // if(!empty($banner_data))
    // {
    //   foreach ($banner_data as $key => $value) {
    //       $tags=explode(',', $value['tags']);

    //       $alltags=array_merge($alltags,$tags);
    //   }
    // }

    // $alltags = array_unique($alltags);
    // $keywords=array_merge($keywords,$alltags);

  }
}

  // echo "<pre>";

  //  print_r($banner_data);

  //  die('--');

?>


<!DOCTYPE html>

<html lang="en">


<head>    
    <?php include_once('head.php');?>
    <style type="text/css">
      .result-box
      {
          border: 1px solid #ccc;
          background: #eee;
          padding: 15px;
          box-shadow: 1px 2px 3px #ccc;
          margin: 5px 0;
      }
      .img-responsive
      {
          width: 100%;
          height: 150px;
          object-fit: cover;
      }
      .info
      {
          border: 1px solid #eee;
          padding: 5px;
      }
      .info .title,.result-text-box .title
      {
            color: green;
            font-size: 15px;
            font-weight: 600;
            overflow: hidden;
            height: 40px;
      }
      .icons i
      {
          padding: 2px;
          font-size: 11px;
      }
      .icons .btn
      {
        font-size: 11px;
        padding: 2px 5px;
        margin-bottom: 2.5px;
      }
      .rss-desc img
      {
        width: 125px;
      }
      .rss-desc
      {
        display: block;
        text-overflow: ellipsis;
        word-wrap: break-word;
        overflow: hidden;
        height: 75px;
      }
      form .bootstrap-tagsinput
      {
        border: 1px solid #ccc;
        border-radius: 4px;
        min-height: 34px;
        font-size: 1.1rem;
      }
      .bootstrap-tagsinput .badge [data-role="remove"]::after,.bootstrap-tagsinput .badge [data-role="remove"]:after {
        content: "×";
      }
      .library-box
      {
        border: 1px dotted #555;
        padding: 2.5px;
        margin: 2.5px;
        text-align: center;
      }
      .library-box img
      {
        text-align: center;
        margin: auto;
      }
      .category-icon
      {
        padding: 5px;
        cursor: pointer;
      }
      .category-icon img
      {
        border: 1px solid #fff;
        border-radius: 5px;
        padding: 1px;
      }
      .category-icon img.cat-select
      {
        border: 1px solid #dc071a;
      }
      .description
      {
        display: block;
        text-overflow: ellipsis;
        word-wrap: break-word;
        overflow: hidden;
        height: 250px;
      }
      .result-box.wrap-box
      {
        min-height: 225px;
      }
    </style>
</head>
<body>
<?php include_once('analyticstracking.php'); ?>

<?php include_once('analyticstracking_ci.php'); ?>

<?php include_once('analyticstracking_y.php'); ?>
<?php include_once('header.php');?>

<link href="w_css/tagsinput.css" rel="stylesheet" />
<script src="w_js/tagsinput.js"></script>






<div id='changemusic'></div>


<body>


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

    </div>

<!--breadcrumb end --> 

<!--container-->              

<div class="container" id="hidealldata">

	<div class="row">	

		<div class="col-md-8" id="bgimage" style="background-repeat:repeat; padding:5px;">	

			<div class="row">

	                <div class="col-md-12">

	                <?php echo $obj->getPageContents($page_id);?>

	                </div>
                  <!-- <div class="col-md-2">

                  </div> -->

              	</div>

              	<div class="row">


                      <?php 

                        if($error==true)
                        {
                           ?>
                           <div class="alert alert-danger alert-dismissible">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>Error!</strong> Required query or keyword or category.
                            </div>
                           <?php
                        }

                        ?>

              	</div>

              	<div class="main col-md-12">

              			<form action="" method="post">
	              			<div class="row">
        							  <div class="form-group">
                          <div class="col-md-6">
        							    <label>Your Query</label>
        							    <input type="text" class="form-control" name="query" value="<?=$title;?>" <?=(!empty($readonly))? 'readonly' : '' ;?> >
                          </div>
                          <div class="col-md-6">
                            <label>Your Keyword</label>
                            <input type="text" class="form-control" name="Keyword" value="<?=($_POST['Keyword'])? $_POST['Keyword'] : '';?>" list="keywords" data-role="tagsinput" autocomplete="off">
                              <!-- <datalist id="keywords">
                                <?php 
                                  if(!empty($keywords))
                                  {
                                    foreach ($keywords as $key => $value) {
                                      ?>
                                      <option value="<?=$value;?>">
                                      <?php
                                    }
                                  }
                                ?>
                              </datalist> -->
                          </div>
        							  </div>
        							</div>
                      <div class="row col-md-12" style="margin-top: 5px;">
                        <div class="form-group">
                         <?php $icon_data=$obj->getManageFavCatDropdownDataOptionIcon(34,$category); 
                            if(!empty($icon_data))
                            {
                              foreach ($icon_data as $key => $icon) {
                                 ?>
                                  <span class="category-icon">
                                    <?=$icon;?>
                                  </span>
                                 <?php
                              }
                            }
                         ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <br>
          						  <button type="submit" class="btn btn-default">Search</button>
                      </div>
        						</form>

                    <br>

                    <br>

                     <div class="banner-slider">
            <?php

            if(count($banner_data)>0)   
            {   

                ?>
                  <div class="row">
                           <div class="col-md-12">
                              <!-- Controls -->
                              <div class="controls pull-right hidden-xs">
                                 <a class="left fa fa-chevron-left btn btn" href="#carousel-example"
                                    data-slide="prev"></a><a class="right fa fa-chevron-right btn" href="#carousel-example"
                                    data-slide="next"></a>
                              </div>
                           </div>
                        </div>
                <div id="carousel-example" class="carousel slide hidden-xs" data-interval="false" >
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                       <!-- active lisitng start -->
                       <div class="item active">
                          <div class="row">
                            <?php
                            $event_count = count($banner_data);
                            $loop_count = min(array("$event_count","3"));
                            for($j=0;$j<$loop_count;$j++) {  
                                    $img=$file=$img_data=$title=$desc=$credit=$credit_url="";

                                        $credit=$banner_data[$j]['gallery'][0]['credit_line'];
                                        $credit_url=$banner_data[$j]['gallery'][0]['credit_line_url'];                                    


                                    if($banner_data[$j]['gallery'][0]['banner_type']=='Image')
                                    {
                                        $imgData=$obj->getImgData($banner_data[$j]['gallery'][0]['banner']);
                                        if(!empty($imgData['image']))
                                        {
                                            $img_data='<img src="'.SITE_URL.'/uploads/'.$imgData['image'].'"  class="img-responsive" alt="" />';
                                        }  
                                        else
                                        {
                                             $img_data='<img src="images/no-image.png" class="img-responsive" alt="" />';
                                        }
                                    }
                                    else
                                    {   
                                        $fileData=$obj->getFileData($banner_data[$j]['gallery'][0]['banner']);
                                        if($banner_data[$j]['gallery'][0]['banner_type']=='Video')
                                        {
                                            $img_data='<iframe width="275px" height="175px" src="'.$fileData["banner"].'" frameborder="0" allowfullscreen></iframe>';
                                        }
                                        elseif($banner_data[$j]['gallery'][0]['banner_type']=='Sound' || $banner_data[$j]['gallery'][0]['banner_type']=='Audio')
                                        {
                                            $img_data='<embed src="'.SITE_URL.'/uploads/'.$fileData["banner"].'" autostart="true" loop="true" height="150px" width="100%"></embed>';
                                        }
                                        elseif($banner_data[$j]['gallery'][0]['banner_type']=='Pdf')
                                        {
                                            $img_data='<a href="'.SITE_URL.'/uploads/'.$fileData['banner'].'" target="_blank"><img src="'.SITE_URL.'/images/pdf-icon.png" style="object-fit: contain;" class="img-responsive" alt="" /></a>';
                                        }
                                        else
                                        {
                                            $img_data='<img src="images/no-image.png" class="img-responsive" alt="" />';
                                        }
                                    }
                                        
                                ?>     
                              <div class="col-sm-4">
                                <div class="col-item">
                                   <div class="photo text-center">
                                        <?= $img_data ?>
                                         <?php
                                          if($credit && $credit_url)
                                           {
                                            ?>
                                            <div class="clear-left">
                                                <p style="font-size: 10px;margin: 0;margin-top: 5px;">
                                                    <a href="<?=$credit_url;?>" target="_blank"><?=$credit;?></a>
                                                </p>
                                             </div>
                                             <?php
                                            }
                                          ?>
                                    </div>
                                   <div class="info">
                                    <div class="clearfix">
                                             <!--  <b><?=$banner_data[$j]['reference_title'];?></b> <br> -->
                                               <b class="title">
                                                     <?php 
                                                        if($banner_data[$j]['credit_url'])
                                                        { 
                                                          ?>
                                                           <a href="<?=$banner_data[$j]['credit_url'];?>" target="_blank"><?=$banner_data[$j]['topic_subject'];?></a>
                                                           <?php
                                                        }
                                                        else
                                                        {
                                                          ?>
                                                          <a href="javascript:void(0)"><?=$banner_data[$j]['topic_subject'];?></a>
                                                          <?php
                                                        }
                                                      ?>
                                                </b> <br>
                                               <?=$banner_data[$j]['narration'];?>
                                                <!--  <b><?=$banner_data[$j]['tags'];?></b> <br> -->
                                                <?php
                                                if($banner_data[$j]['credit'] && $banner_data[$j]['credit_url'])
                                                 {
                                                  ?>
                                                  
                                                      <p style="font-size: 10px;margin: 0;margin-top: -5px;">
                                                          <a href="<?=$banner_data[$j]['credit_url'];?>" target="_blank"><?=$banner_data[$j]['credit'];?></a>
                                                      </p>
                                                   
                                                   <?php
                                                  }
                                                ?>
                                     </div>
                                  </div>
                                </div>
                             </div>
                            <?php } ?>
                          </div>
                       </div>
                       <!-- Active Listing Close -->
                       <!-- hidden Listing start -->
                  <?php
                   $loop_count_top = count($banner_data)-3 ;
                   $loop_count_top_counter = ceil($loop_count_top/3);
                   for($l=0;$l<$loop_count_top_counter;$l++)
                   {  
                      ?>
                        <div class="item">
                            <div class="row">
                        <?php
                        static $m =3;
                        $loop_count2 = count($banner_data)-($m+1) ;
                        $loop_count_child = min(array("$loop_count2","3"));
                        for($k=0;$k<=$loop_count_child;$k++) 
                        {
                             $img=$file=$img_data=$title=$desc=$credit=$credit_url="";

                                  $credit=$banner_data[$m]['gallery'][0]['credit'];
                                  $credit_url=$banner_data[$m]['gallery'][0]['credit_url'];                                    

                                    if($banner_data[$m]['gallery'][0]['banner_type']=='Image')
                                    {
                                        $imgData=$obj->getImgData($banner_data[$m]['gallery'][0]['banner']);
                                        if(!empty($imgData['image']))
                                        {
                                            $img_data='<img src="'.SITE_URL.'/uploads/'.$imgData['image'].'" class="img-responsive" alt="" />';
                                        }  
                                        else
                                        {
                                             $img_data='<img src="images/no-image.png" class="img-responsive" alt="" />';
                                        }
                                      }
                                    else
                                    {   
                                        $fileData=$obj->getFileData($banner_data[$m]['gallery'][0]['banner']);
                                        if($banner_data[$m]['gallery'][0]['banner_type']=='Video')
                                        {
                                            $img_data='<iframe width="275px" height="175px" src="'.$fileData["banner"].'" frameborder="0" allowfullscreen></iframe>';
                                        }
                                        elseif($banner_data[$m]['gallery'][0]['banner_type']=='Sound' || $banner_data[$m]['gallery'][0]['banner_type']=='Audio')
                                        {
                                            $img_data='<embed src="'.SITE_URL.'/uploads/'.$fileData["banner"].'" autostart="true" loop="true" height="150px" width="100%"></embed>';
                                        }
                                        elseif($banner_data[$m]['gallery'][0]['banner_type']=='Pdf')
                                        {
                                            $img_data='<a href="'.SITE_URL.'/uploads/'.$fileData['banner'].'" target="_blank"><img src="'.SITE_URL.'/images/pdf-icon.png" style="object-fit: contain;" class="img-responsive" alt="" /></a>';
                                        }
                                        else
                                        {
                                            $img_data='<img src="images/no-image.png" class="img-responsive" alt="" />';
                                        }

                                    }
                          ?>
                            <div class="col-sm-4">
                                <div class="col-item">
                                   <div class="photo text-center">
                                      <?=$img_data ; ?>
                                      <?php 
                                     if($credit && $credit_url)
                                       {  
                                        ?>
                                          <div class="clear-left">
                                            <p style="font-size: 10px;margin: 0;margin-top: 5px;">
                                                <a href="<?=$credit_url;?>" target="_blank"><?=$credit;?></a>
                                            </p>
                                         </div>
                                         <?php 
                                        } ?>
                                      </div>
                                   <div class="info">
                                    <div class="clearfix">
                                        <!-- <b><?=$banner_data[$m]['reference_title'];?></b> <br> -->
                                               <b class="title">
                                                    <?php 
                                                        if($banner_data[$m]['credit_url'])
                                                        { 
                                                          ?>
                                                           <a href="<?=$banner_data[$m]['credit_url'];?>" target="_blank"><?=$banner_data[$m]['topic_subject'];?></a>
                                                           <?php
                                                        }
                                                        else
                                                        {
                                                          ?>
                                                          <a href="javascript:void(0)"><?=$banner_data[$m]['topic_subject'];?></a>
                                                          <?php
                                                        }
                                                      ?>
                                                  
                                                </b> <br>
                                               <?=$banner_data[$m]['narration'];?> 
                                              <!--  <b><?=$banner_data[$m]['tags'];?></b> <br> -->

                                              <?php
                                                if($banner_data[$m]['credit'] && $banner_data[$m]['credit_url'])
                                                 {
                                                  ?>
                                                  
                                                      <p style="font-size: 10px;margin: 0;margin-top: -5px;">
                                                          <a href="<?=$banner_data[$m]['credit_url'];?>" target="_blank"><?=$banner_data[$m]['credit'];?></a>
                                                      </p>
                                                   
                                                   <?php
                                                  }
                                                ?>

                                     </div>
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
                   }
                   ?>
                   <!-- hidden Listing close -->
                    </div>
                 </div> <br>
                <?php 
                }
              ?>
            </div>

            <!-- banner close -->

            <!-- wsi data start -->

                    <div class="row">
                      <div class="col-md-12">
                          <div class="result-show">
                                <?php
                                if(!empty($data))
                                { 
                                  ?>
                                  <div class="row">
                                  <?php
                                  foreach ($data as $key => $value) {
                                      $cat_ids=$cat_id="";
                                      $sol_item_cat=array();
                                       $key=$key+1;
                                       $cat_ids=explode(',', $value['category_ids']);

                                        if(!empty($cat_ids))
                                        {
                                            foreach ($cat_ids as $index => $row) {
                                               $sol_item_cat[] = $obj->getSolutionCategoryName($row);
                                            }
                                        }
                                        $cat_id=implode(',', $sol_item_cat);
                                     ?>
                                     
                                     <div class="col-md-6">
                                      <div class="row result-box wrap-box">
                                         <div class="col-md-12">
                                          <div class="text-center">
                                            <?php 
                                              $img_data=$credit=$credit_url="";
                                              if(!empty($value['gallery'][0]))
                                              {
                                                  if($value['gallery'][0]['banner_type']=='Image')
                                                    {
                                                        $imgData=$obj->getImgData($value['gallery'][0]['banner']);
                                                        if(!empty($imgData['image']))
                                                        {
                                                            $img_data='<img src="'.SITE_URL.'/uploads/'.$imgData['image'].'"  class="img-responsive" alt="" />';
                                                        }  
                                                        else
                                                        {
                                                             $img_data='<img src="images/no-image.png" class="img-responsive" alt="" />';
                                                        }
                                                    }
                                                    else
                                                    {   
                                                        $fileData=$obj->getFileData($value['gallery'][0]['banner']);
                                                        if($value['gallery'][0]['banner_type']=='Video')
                                                        {
                                                            $img_data='<iframe width="100%" height="150px" src="'.$fileData["banner"].'" frameborder="0" allowfullscreen></iframe>';
                                                        }
                                                        elseif($value['gallery'][0]['banner_type']=='Sound' || $value['gallery'][0]['banner_type']=='Audio')
                                                        {
                                                            $img_data='<embed src="'.SITE_URL.'/uploads/'.$fileData["banner"].'" autostart="true" loop="true" height="150px" width="100%"></embed>';
                                                        }
                                                        elseif($value['gallery'][0]['banner_type']=='Pdf')
                                                        {
                                                            $img_data='<a href="'.SITE_URL.'/uploads/'.$fileData['banner'].'" target="_blank"><img src="'.SITE_URL.'/images/pdf-icon.png" style="object-fit: contain;" class="img-responsive" alt="" /></a>';
                                                        }
                                                        else
                                                        {
                                                            $img_data='<img src="images/no-image.png" class="img-responsive" alt="" />';
                                                        }
                                                    }
                                                  // $credit=$value['gallery'][0]['credit_line'];
                                                  // $credit_url=$value['gallery'][0]['credit_line_url']; 
                                              }
                                              else
                                              { 
                                                $imgData=$obj->getDefultImgData('659','44');
                                                      if(!empty($imgData['image']))
                                                        {
                                                            $img_data='<img src="'.SITE_URL.'/uploads/'.$imgData['image'].'"  class="img-responsive" alt="" />';
                                                        }  
                                                        else
                                                        {
                                                             $img_data='<img src="images/no-image.png" class="img-responsive" alt="" />';
                                                        }
                                              }
                                            ?>
                                              <?=$img_data;?>
                                               <!-- <?php 
                                               if($credit && $credit_url)
                                                 {  
                                                  ?>
                                                    <div class="text-center">
                                                      <p style="font-size: 10px;margin: 0;margin-top: 5px;">
                                                          <a href="<?=$credit_url;?>" target="_blank"><?=$credit;?></a>
                                                      </p>
                                                   </div>
                                                   <?php 
                                                  } ?> -->
                                                <div class="text-center">
                                                      <button class="btn btn-default btn-sm" onclick="view_banners(<?=$value['sol_item_id'];?>)" style="padding: 2px 4px;font-size: 9px;">Scroll images</button>
                                                   </div>
                                          </div>
                                            <div class="result-text-box">
                                              
                                               <!-- <b><?=$value['reference_title'];?></b> <br> -->
                                               <div class="title" data-toggle="tooltip" title="<?=$value['topic_subject'];?>">
                                                <?php
                                                     $title= $value['topic_subject'];?>
                                                      <?php 
                                                        if($value['credit_url'])
                                                        { 
                                                          ?>
                                                           <a href="<?=$value['credit_url'];?>" target="_blank"><?=$title;?></a>
                                                           <?php
                                                        }
                                                        else
                                                        {
                                                          ?>
                                                          <a href="javascript:void(0)"><?=$title;?></a>
                                                          <?php
                                                        }
                                                      ?>
                                               </div>
                                               <div class="description">
                                                  
                                                  <?php 
                                                  echo  $value['narration'];

                                                  ?>
                                                  <?php 
                                             if($value['credit'] && $value['credit_url'])
                                               {  
                                                ?>
                                                  <div class="clear-left">
                                                    <p style="font-size: 10px;">
                                                        <a href="<?=$value['credit_url'];?>" target="_blank"><?=$value['credit'];?></a>
                                                    </p>
                                                 </div>
                                                 <?php 
                                                } ?>
                                                 
                                               </div> 

                                                <?php echo ((strlen($value['narration']) > 550) ? '<a href="wsi_read_more.php?type=wsi&token='.base64_encode($value["sol_item_id"]).'" target="_blank"><button class="btn btn-default btn-sm" style="padding: 2px 4px;font-size: 9px;">Read More</button></a>' : ''); ?>
                                               
                                            </div>
                                         </div>
                                         <div class="col-md-12" style="margin-top:10px;">
                                          <?php $button_data=$obj->get_button_data_WSI($value['sol_item_id']);

                                               if(!empty($button_data))
                                               {
                                                 ?>
                                                  <div class="icons">
                                                    <?php 
                                                      foreach ($button_data as $b_key => $b_value) {
                                                        if($b_value['popup_type']==0)
                                                        {
                                                          if(!empty($b_value['link']))
                                                          {
                                                              ?>
                                                               <a href="<?=$b_value['link'];?>" target="_blank"><button class="btn" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button></a>
                                                              <?php
                                                          }
                                                          else
                                                          {
                                                            ?>
                                                             <a href="javascript:void(0);"><button class="btn" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button></a>
                                                            <?php
                                                          }
                                                        }
                                                        elseif($b_value['popup_type']==2)
                                                        {
                                                          ?>
                                                          <button class="btn" onclick="openFavLibraryBox('Text','','<?=$title;?>','<?=$cat_id?>',<?=$value['sol_item_id'];?>,'wsi','Library')" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button>
                                                          <?php
                                                        }
                                                        
                                                      }
                                                    ?>
                                                  </div>
                                                 <?php
                                               }

                                               ?>
                                         </div>
                                     </div>
                                    </div>
                                     <?php
                                     if($key%2==0)
                                     {
                                       ?>
                                        </div>
                                        <div class="row">
                                       <?php
                                     }
                                  }
                                  ?>
                                  </div>
                                  <?php
                                }
                                // else
                                // {
                                //   echo "<h6>No more data found!</h6>";
                                // }
                                ?>
                          </div>

                          <!-- Mind jumble data start -->

                          <!-- <div class="row">
                            <div class="col-md-12">
                               <?php 
                                if(!empty($mj_data))
                                {
                                  ?>
                                  <br>
                                  <div class="row">
                                  <?php
                                  foreach ($mj_data as $key => $value) 
                                  {
                                    $key=$key+1;
                                    ?>
                                     <div class="col-md-6">
                                      <div class="row result-box wrap-box">
                                        <div class="col-md-12">
                                          <div class="text-center">
                                            <?php 

                                              if($value['banner_type']=='Image')
                                              {
                                                $img_data='<img src="'.SITE_URL.'/uploads/'.$value['banner'].'"  class="img-responsive" alt="" />';
                                              }
                                              elseif ($value['banner_type']=='Video') {
                                                $img_data='<iframe width="100%" height="150px" src="'.$value["banner"].'" frameborder="0" allowfullscreen></iframe>';
                                              }
                                              elseif ($value['banner_type']=='Sound' || $value['banner_type']=='Audio') {
                                                 $img_data='<embed src="'.SITE_URL.'/uploads/'.$value["banner"].'" autostart="true" loop="true" height="150px" width="100%"></embed>';
                                              }
                                              elseif ($value['banner_type']=='Pdf') {
                                                $img_data='<a href="'.SITE_URL.'/uploads/'.$value['banner'].'" target="_blank"><img src="'.SITE_URL.'/images/pdf-icon.png" style="object-fit: contain;" class="img-responsive" alt="" /></a>';
                                              }
                                              else
                                              { 
                                                $imgData=$obj->getDefultImgData('659','44');
                                                      if(!empty($imgData['image']))
                                                        {
                                                            $img_data='<img src="'.SITE_URL.'/uploads/'.$imgData['image'].'"  class="img-responsive"  alt="" />';
                                                        }  
                                                        else
                                                        {
                                                             $img_data='<img src="images/no-image.png" class="img-responsive"  alt="" />';
                                                        }
                                              }
                                            ?>
                                            <?=$img_data;?>
                                        </div>
                                          <div class="title" data-toggle="tooltip" title="<?=$value['topic_subject'];?>"> 
                                              <?php $title= $value['topic_subject']; ?>
                                                      <?php 
                                                        if($value['credit_url'])
                                                        { 
                                                          ?>
                                                           <a href="<?=$value['credit_url'];?>" target="_blank"><?=$title;?></a>
                                                           <?php
                                                        }
                                                        else
                                                        {
                                                          ?>
                                                          <a href="javascript:void(0)"><?=$title;?></a>
                                                          <?php
                                                        }
                                                      ?>
                                              
                                            </div>
                                          <div class="description">

                                              <?php 

                                                   echo $value['short_narration'];

                                                  ?>

                                                  <?php 
                                             if($value['credit_line'] && $value['credit_line_url'])
                                               {  
                                                ?>
                                                  <div class="clear-left">
                                                    <p style="font-size: 10px;margin: 0;margin-top: 5px;">
                                                        <a href="<?=$value['credit_line_url'];?>" target="_blank"><?=$value['credit_line'];?></a>
                                                    </p>
                                                 </div>
                                                 <?php 
                                                } ?>

                                          </div>

                                          <?php echo ((strlen($value['short_narration']) > 550) ? '<a href="wsi_read_more.php?type=mj&token='.base64_encode($value["sol_item_id"]).'" target="_blank"><button class="btn btn-default btn-sm" style="padding: 2px 4px;font-size: 9px;">Read More</button></a>' : ''); ?>
                                          
                                           
                                      </div>
                                      <div class="col-md-12" style="margin-top: 10px;">
                                        
                                          <?php $button_data=$obj->get_common_button_setting_data('Menu',25);
                                               // print_r($button_data);

                                            if(!empty($button_data))
                                               {
                                                 ?>
                                                  <div class="icons">
                                                    <?php 
                                                      foreach ($button_data as $b_key => $b_value) 
                                                      {
                                                        if($b_value['popup_type']==0)
                                                        {
                                                          if(!empty($b_value['link']))
                                                          {
                                                              ?>
                                                               <a href="<?=$b_value['link'];?>" target="_blank"><button class="btn" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button></a>
                                                              <?php
                                                          }
                                                          else
                                                          {
                                                            ?>
                                                             <a href="javascript:void(0);"><button class="btn" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button></a>
                                                            <?php
                                                          }
                                                        }
                                                        elseif($b_value['popup_type']==1)
                                                        {
                                                          ?>
                                                          <button class="btn" onclick="openFavLibraryBox('Text','','<?=$title;?>','',<?=$value['sol_item_id'];?>,'wsi-mj','Library')" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button>
                                                          <?php
                                                        }
                                                        elseif($b_value['popup_type']==2)
                                                        {
                                                          ?>
                                                          <button class="btn" onclick="openFavLibraryBox('<?=$value['box_type'];?>','<?=$value['banner'];?>','<?=$title;?>','',<?=$value['sol_item_id'];?>,'mj','Favourite')" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button>
                                                          <?php
                                                        }
                                                        
                                                      }
                                                    ?>
                                              </div>
                                          <?php
                                         }

                                     ?>
                                      </div>
                                      </div>
                                    </div>
                                    <?php
                                    if($key%2==0)
                                     {
                                       ?>
                                        </div>
                                        <div class="row">
                                       <?php
                                     }
                                  }
                                  ?>
                                  </div>
                                  <?php
                                }
                               ?>
                            </div>
                          </div> -->

                          <!-- rss data start -->
                          
                          <div class="row">
                            <div class="col-md-12">
                               <?php 
                                if(!empty($rss_data))
                                {
                                  ?>
                                  <br>
                                  <!-- <h1>RSS</h1> -->
                                  <?php
                                  foreach ($rss_data as $key => $value) {
                                    $key=$key+1;
                                    ?>
                                      <div class="col-md-12 result-box">
                                      <div class="">
                                          <span class="text-right pull-right"><?=$value['rss_feed_item_pubDate'];?></span>
                                          
                                          <b class="title" >
                                              <?php echo $value['rss_feed_item_title']; ?>
                                            </b> <br>
                                          <div class="rss-desc">
                                              <?php echo $value['rss_feed_item_desc']; ?>
                                             <!--  <?php //echo substr($value['rss_feed_item_desc'], 0, 350) .((strlen($value['rss_feed_item_desc']) > 350) ? '...' : ''); ?> --> 
                                          </div>
                                          <?=($value['rss_feed_item_link'])? '<a href="'.$value['rss_feed_item_link'].'">'.$value['rss_feed_item_link'].'</a><br>' : '';?>
                                          <?=($value['rss_feed_item_category'])? '<p><b>Category: </b>'.$value['rss_feed_item_category'].'&nbsp;&nbsp;' : '';?>
                                          <?=($value['rss_feed_item_author'])? '  <b>Author: </b>'.$value['rss_feed_item_author'].'</p>' : '';?>
                                          <p>

                                          	<?php echo ((strlen($value['rss_feed_item_desc']) > 350) ? '<a href="wsi_read_more.php?type=rss&token='.base64_encode($value["rss_feed_item_id"]).'" target="_blank"><button class="btn btn-default btn-sm" style="padding: 2px 4px;font-size: 9px;">Read More</button></a>' : ''); ?>
                                          </p>
                                          <?php $button_data=$obj->get_button_data_RSS($value['rss_feed_item_id']);
                                               // print_r($button_data);

                                               if(!empty($button_data))
                                               {
                                                 ?>
                                                 <br>
                                                  <div class="icons">
                                                    <?php 
                                                      foreach ($button_data as $b_key => $b_value) {
                                                        if($b_value['popup_type']==0)
                                                        {
                                                          if(!empty($b_value['link']))
                                                          {
                                                              ?>
                                                               <a href="<?=$b_value['link'];?>" target="_blank"><button class="btn" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button></a>
                                                              <?php
                                                          }
                                                          else
                                                          {
                                                            ?>
                                                             <a href="javascript:void(0);"><button class="btn" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button></a>
                                                            <?php
                                                          }
                                                        }
                                                        elseif($b_value['popup_type']==2)
                                                        {
                                                          ?>
                                                          <button class="btn" onclick="openFavLibraryBox('Text','','<?=$value['rss_feed_item_title']?>','<?=$value['rss_feed_item_category']?>',<?=$value['rss_feed_item_id'];?>,'wsi-rss','Library')" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button>
                                                          <?php
                                                        }
                                                        
                                                      }
                                                    ?>
                                                  </div>
                                                 <?php
                                               }

                                               ?>

                                               <!-- <div class="text-right">
                                                   <button class="btn btn-default btn-sm" onclick="addScrollingContentToFav(<?=$value['rss_feed_item_id'];?>,'2','0')" style="padding: 2px 4px;font-size: 9px;">Add to Fav</button>
                                               </div> -->
                                      </div>
                                    </div>
                                    <?php
                                  }
                                  ?>
                                  <?php
                                }
                               ?>
                            </div>
                          </div>

                          
                          
                      </div>
                      <!-- <div class="col-md-2">
                      </div> -->
                    </div>
           
          </div>

		</div>                
		
		<div class="col-md-2">	
			<!-- ad right_sidebar-->
		     <?php include_once('left_sidebar.php'); ?> 
    </div>
    <div class="col-md-2">    
		      <!-- ad right_sidebar end -->      	
		      <?php include_once('right_sidebar.php'); ?>
		</div>
 			
   </div>	
</div>


<?php include_once('footer.php');?>  
<!-- copy by ample 15-05-20 -->
<script type="text/javascript">



      //new code by ample 14-11-19
       $('.datepicker').on('focus', function(e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");  
    });

       //code by ample 08-01-20
       $('.input-text-box.dlist').on('focus', function(e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");  
    });


        $(document).ready(function(){
             //code by ample 08-01-20
              $('.input-text-box.dlist').attr('autocomplete', 'off');

               $('#day_month_year').attr('autocomplete', 'off');

                $('#day_month_year').datepicker(

                        {

                            dateFormat: 'dd-mm-yy',

                            minDate: '-1D',

                            maxDate: '+0D',

                        }        

                );

            });



  function view_banners(sol_item_id)
  {

      var dataString ='sol_item_id='+sol_item_id +'&action=view_banners_solutionitems';

      $.ajax({

              type: "POST",

              url: 'remote.php', 

              data: dataString,

              cache: false,

              success: function(result)

                  {

                    //alert(result);
                    BootstrapDialog.show({

                            title: 'Banners',

                            message:result

                    }); 
                  }

             });
  }


  function add_on_category(id)
  {

      var ck=$('#category'+id).is(':checked');

      if(ck==true)
      {
        $('#category'+id).attr('checked', false); // Deprecated
        $('#category'+id).prop('checked', false);
        $('#cat_img'+id).removeClass("cat-select");

      }
      else
      { 
        $('.cat_category').attr('checked', false); // Deprecated
        $('.cat_category').prop('checked', false);
        $('#category'+id).attr('checked', true); // Deprecated
        $('#category'+id).prop('checked', true);
        $('.cat_class').removeClass("cat-select");
        $('#cat_img'+id).addClass("cat-select");

      }
  }

  $('[data-toggle="tooltip"]').tooltip();
  imagePreview();

</script>

</body>

</html>


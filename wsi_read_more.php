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

$data=array();
$type=$_GET['type'];
$token=base64_decode($_GET['token']);

if(empty($type) && empty($token))
{
      header("Location: my_wellness_solutions_item.php?");
      exit();
}
else
{
    if($type=='wsi')
    {
       $data=$obj->getSolutionItemDetailMain($token);

        if(!empty($data))
        {
            
            $data['gallery']=$obj->get_gallery_data_wellness_items($token);
            
        }
    }
    elseif($type=='mj')
    {
           $data=$obj->get_wsi_mindjumpble_data($token);
    }
    elseif($type=='rss')
    {
           $data=$obj->get_wsi_rss_feed_data($token);
    }
    else
    {
       header("Location: my_wellness_solutions_item.php?");
       exit();
    }

   
   if(empty($data))
   {

      header("Location: my_wellness_solutions_item.php?");
      exit();

   }

}

$error=false;


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
          height: 350px;
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
        overflow: auto;
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
        height: 275px;
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
            <div class="col-md-12">

                <?php 

                  if($type=='wsi')
                  {
                    ?>
                    <div class="row result-box wrap-box">
                       <div class="col-md-12">
                        <div class="text-center">
                          <?php 
                            $img_data=$credit=$credit_url="";
                            if(!empty($data['gallery'][0]))
                            {
                                if($data['gallery'][0]['banner_type']=='Image')
                                  {
                                      $imgData=$obj->getImgData($data['gallery'][0]['banner']);
                                      if(!empty($imgData['image']))
                                      {
                                          $img_data='<img src="'.SITE_URL.'/uploads/'.$imgData['image'].'" height="350px"  class="img-responsive" alt="" />';
                                      }  
                                      else
                                      {
                                           $img_data='<img src="images/no-image.png" class="img-responsive" height="350px" alt="" />';
                                      }
                                  }
                                  else
                                  {   
                                      $fileData=$obj->getFileData($data['gallery'][0]['banner']);
                                      if($data['gallery'][0]['banner_type']=='Video')
                                      {
                                          $img_data='<iframe width="100%" height="350px" src="'.$fileData["banner"].'" frameborder="0" allowfullscreen></iframe>';
                                      }
                                      elseif($data['gallery'][0]['banner_type']=='Sound' || $data['gallery'][0]['banner_type']=='Audio')
                                      {
                                          $img_data='<embed src="'.SITE_URL.'/uploads/'.$fileData["banner"].'" autostart="true" loop="true" height="350px" width="100%"></embed>';
                                      }
                                      elseif($data['gallery'][0]['banner_type']=='Pdf')
                                      {
                                          $img_data='<a href="'.SITE_URL.'/uploads/'.$fileData['banner'].'" target="_blank"><img src="'.SITE_URL.'/images/pdf-icon.png" style="object-fit: contain;" class="img-responsive" alt="" /></a>';
                                      }
                                      else
                                      {
                                          $img_data='<img src="images/no-image.png" height="350px" class="img-responsive" alt="" />';
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
                                          $img_data='<img src="'.SITE_URL.'/uploads/'.$imgData['image'].'" height="350px"  class="img-responsive" alt="" />';
                                      }  
                                      else
                                      {
                                           $img_data='<img src="images/no-image.png" height="350px" class="img-responsive" alt="" />';
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
                                    <button class="btn btn-default btn-sm" onclick="view_banners(<?=$data['sol_item_id'];?>)" style="padding: 2px 4px;font-size: 9px;">Scroll images</button>
                                 </div>
                        </div>
                          <div class="result-text-box">
                            
                             <!-- <b><?=$value['reference_title'];?></b> <br> -->
                             <div class="title" data-toggle="tooltip" title="<?=$data['topic_subject'];?>">
                              <?php
                                   $title= $data['topic_subject'];?>
                                    <?php 
                                      if($data['credit_url'])
                                      { 
                                        ?>
                                         <a href="<?=$data['credit_url'];?>" target="_blank"><?=$title;?></a>
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
                                echo  $data['narration'];

                                ?>
                                <?php 
                           if($data['credit'] && $data['credit_url'])
                             {  
                              ?>
                                <div class="clear-left">
                                  <p style="font-size: 10px;">
                                      <a href="<?=$data['credit_url'];?>" target="_blank"><?=$data['credit'];?></a>
                                  </p>
                               </div>
                               <?php 
                              } ?>

                             </div> 
                          </div>
                       </div>
                       <div class="col-md-12" style="margin-top:10px;">
                        <?php $button_data=$obj->get_button_data_WSI($data['sol_item_id']);

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
                                      elseif($b_value['popup_type']==1)
                                      {
                                        ?>
                                        <button class="btn" onclick="addScrollingContentToFav(<?=$data['sol_item_id'];?>,'1','0')" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button>
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
                    <?php
                  }
                  elseif ($type=='mj') {
                    ?>
                      <div class="row result-box wrap-box">
                        <div class="col-md-12">
                          <div class="text-center">
                            <?php 

                              if($data['box_type']=='Image')
                              {
                                $img_data='<img src="'.SITE_URL.'/uploads/'.$data['box_banner'].'"  class="img-responsive" alt="" />';
                              }
                              elseif ($data['box_type']=='Video') {
                                $img_data='<iframe width="100%" height="100%" src="'.$data["box_banner"].'" frameborder="0" allowfullscreen></iframe>';
                              }
                              elseif ($data['box_type']=='Sound' || $data['box_type']=='Audio') {
                                 $img_data='<embed src="'.SITE_URL.'/uploads/'.$data["box_banner"].'" autostart="true" loop="true" height="100%" width="100%"></embed>';
                              }
                              elseif ($data['box_type']=='Pdf') {
                                $img_data='<a href="'.SITE_URL.'/uploads/'.$data['box_banner'].'" target="_blank"><img src="'.SITE_URL.'/images/pdf-icon.png" style="object-fit: contain;" class="img-responsive" alt="" /></a>';
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
                          <div class="title" data-toggle="tooltip" title="<?=$data['box_title'];?>"> 
                              <?php $title= $data['box_title']; ?>
                                      <?php 
                                        if($data['credit_line_url'])
                                        { 
                                          ?>
                                           <a href="<?=$data['credit_line_url'];?>" target="_blank"><?=$title;?></a>
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

                                   echo $data['short_narration'];

                                  ?>

                                  <?php 
                             if($data['credit_line'] && $data['credit_line_url'])
                               {  
                                ?>
                                  <div class="clear-left">
                                    <p style="font-size: 10px;margin: 0;margin-top: 5px;">
                                        <a href="<?=$data['credit_line_url'];?>" target="_blank"><?=$data['credit_line'];?></a>
                                    </p>
                                 </div>
                                 <?php 
                                } ?>
                          </div>
                           
                      </div>
                      <div class="col-md-12" style="margin-top: 10px;">
                        
                          <?php $button_data=$obj->get_common_button_setting_data('Menu',25);

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
                                          <button class="btn" onclick="addScrollingContentToFav(<?=$data['mind_jumble_box_id'];?>,'3','0')" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button>
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
                    <?php
                  }
                  elseif ($type=='rss') {
                    ?>
                    <div class="row result-box">
                      <div class="col-md-12 ">
                          <span class="text-right pull-right"><?=$data['rss_feed_item_pubDate'];?></span>
                          
                          <b class="title" >
                              <?php echo $data['rss_feed_item_title']; ?>
                            </b> <br>
                          <div class="rss-desc">
                              <?php echo $data['rss_feed_item_desc']; ?>
                          </div>
                          <?=($data['rss_feed_item_link'])? '<a href="'.$data['rss_feed_item_link'].'">'.$data['rss_feed_item_link'].'</a><br>' : '';?>
                          <?=($data['rss_feed_item_category'])? '<p><b>Category: </b>'.$data['rss_feed_item_category'].'&nbsp;&nbsp;' : '';?>
                          <?=($data['rss_feed_item_author'])? '  <b>Author: </b>'.$data['rss_feed_item_author'].'</p>' : '';?>

                          <?php $button_data=$obj->get_button_data_RSS($data['rss_feed_item_id']);


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
                                        elseif($b_value['popup_type']==1)
                                        {
                                          ?>
                                          <button class="btn" onclick="addScrollingContentToFav(<?=$data['rss_feed_item_id'];?>,'2','0')" style="color:#<?=$b_value['font_color']?>;background-color: #<?=$b_value['bg_color']?>" title="<?=$b_value['button_heading'];?>"><i class="fa <?=$b_value['icon_code'];?>"></i> </button>
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
                    <?php
                  }
                  else
                  {
                    echo "No Data Found!";
                  }

                ?>

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


function ChangeTheamMDT()

{

    var theam_id = $("#theam_id").val();

    var dataString ='theam_id='+theam_id +'&action=changtheammdt';

    $.ajax({

            type: "POST",

            url: 'remote2.php', 

            data: dataString,

            cache: false,

            success: function(result)

                 {

                  var JSONObject = JSON.parse(result);

                 //$('#bgimage').html(JSONObject[0]['image']);

                 $('#bgimage').css("background-image", "url("+JSONObject[0]['image']+")");

                 $('#color_code').css("background-color", JSONObject[0]['color_code']);

                }

           });

}



function ChangeTheAvatar()

{

    var avat_id = $("#avat_id").val();
    $('#change_avatar').hide();

    var dataString ='avat_id='+avat_id +'&action=ChangeTheAvatar';

    $.ajax({

            type: "POST",

            url: 'remote2.php', 

            data: dataString,

            cache: false,

            success: function(result)

                 {

                  //   alert(result);
                  $('#change_avatar').show();
                 $('#change_avatar').html(result);

                }

           });

}



function ChangeTheMusic()

{

    var music_id1 = $("#music_id").val();

    var dataString ='music_id1='+music_id1 +'&action=ChangeTheMusic';

    $.ajax({

            type: "POST",

            url: 'remote2.php', 

            data: dataString,

            cache: false,

            success: function(result)

                 {

                 $('#changemusic').html(result);

                }

           });

}


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


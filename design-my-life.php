<?php 
   include('classes/config.php');
   
   $page_id = '127';
   
   $obj = new frontclass();
   
   $obj2 = new frontclass2();
   
   
   
   $page_data = $obj->getPageDetails($page_id);
   
   $ref = base64_encode($page_data['menu_link']);


      $ref_num = $_GET['ref_num'];

     $group_code = $_GET['group_id'];

     $fav_cat_id = $_GET['fav_cat_id'];

        if($ref_num!="")
              {
                  $ref = base64_encode($page_data['menu_link'].'?ref_num='.$ref_num.'&group_id='.$group_code);
                  
              }
              else
              {
                  $ref = base64_encode($page_data['menu_link']);

              }

   if(isset($_SESSION['adm_vendor_id']) && !empty($_SESSION['adm_vendor_id']))
    {
      $vendor_id=$_SESSION['adm_vendor_id'];

    }
    else
    {
           if($obj->isLoggedIn())
         {
         
              $user_id = $_SESSION['user_id'];
              $obj->doUpdateOnline($_SESSION['user_id']);
         
         }
         else
         {
               header("Location: login.php?ref=".$ref);
               exit();
         }

    }
   
   // $now = time();
   // $today_year = date("Y",$now);
   // $today_month = date("m",$now);
   // $today_day = date("d",$now); 
   // $year = $today_year;
   // $month = $today_month;
   // $day = $today_day;
    $day_month_year = date("Y-m-d");
   // $header_data = $obj->GetHeaderDatabyPageKR($_GET['ref_num']);
   
   
   // if(isset($_GET['group_id']))
   // {
   //    $group_code = $_GET['group_id'];
   //    $ref_num = $_GET['ref_num'];
      
   //    $design_my_life_data = $obj->GetDesignMyLifeData($day_month_year, $group_id, $ref_num);
      
   // }
   
   // else if(isset($_GET['ref_num']))
   
   // {
   
    
     //add by ample 09-04-20
     $activity_title="";
     if(isset($_GET['title']) && !empty($_GET['title']))
     {
       $activity_title=base64_decode($_GET['title']);
     }
    
     //$design_my_life_data = $obj->GetDesignMyLifeDatabyRef($ref_num);
     //add by ample 11-02-20 //comment by ample 28-10-20
     //$design_my_life_data = $obj->GetDesignMyLifeData($day_month_year, $group_code, $ref_num);

     // echo "<pre>";
     // print_r($design_my_life_data);
     // die();
   
     // if(!$obj->isLoggedIn())
   
     //   {
              // if($ref_num!="")
              // {
              //     $ref = base64_encode($page_data['menu_link'].'?ref_num='.$ref_num.'&group_id='.$group_code);
              
              //     //echo $ref;
              //    // die();
                  
              // }
              // else
              // {
              //     $ref = base64_encode($page_data['menu_link']);
                  
              //     //echo $ref;
              //     //die();
              // }
              
       //         header("Location: login.php?ref=".$ref);
   
       //         exit();
   
       // }
   
     //$box_title = $obj->GetTitlenamebyID($design_my_life_data['box_title']);
   
     // $profile_category = $obj->GetProfilecatname($design_my_life_data['prof_cat_id']);
     // $sub_cat_option = $obj->getSubCatOptions($design_my_life_data['prof_cat_id'],$design_my_life_data['sub_cat_id']);
     // $narration = $design_my_life_data['narration'];
     
   
   //}

   
   if(isset($_POST['btn_submit']))
   
   {
   
   
              // if($design_my_life_data['ref_code']!="")
   
              // {
   
              //   $ref = base64_encode($page_data['menu_link'].'?ref_num='.$design_my_life_data['ref_code']);
   
              // }
   
              // else
   
              // {
   
              //  $ref = base64_encode($page_data['menu_link']);
   
              // }
   
   
       $data = $_POST;
        
        $data['redirect_page'] = $_GET['redirect_page']; //add by ample 24-04-20
        $data['redirect_id'] = $_GET['redirect_id']; //add by ample 24-04-20
        $data['redirect'] = $_GET['redirect']; //add by ample 27-04-20
        //add by ample
        if(empty($data['title_id']))
        {
            $data['title_id']=$activity_title;
        }
       $data['user_id'] = $_SESSION['user_id'];
       $data['vendor_id'] = $_SESSION['adm_vendor_id'];
        $data['post_by']='User';

       if($data['redirect']=='OnlineHub')
       {
          $query_data=$obj->getAdviserQueryDetails($data['redirect_id']);

          if($_SESSION['user_id'])
          {
            $data['vendor_id']=$query_data[0]['vendor_id'];
            $data['post_by']='User';
          }
          
          if($_SESSION['adm_vendor_id'])
          {
            $data['user_id']=$query_data[0]['user_id'];
            $data['post_by']='Vendor';
          }

       }

       //        echo '<pre>';
       // print_r($data);
       // die('dd');


        //update by ample
       if($obj->Post_user_design_data($data))
   
       { 
   
           header("Location: message.php?msg=8&ref_code='".$data['ref_code']."'&box_title='".$data['title_id']."'&sub_cat_id='".$data['sub_cat_id']."'"); // 18 is old message id
   
           exit();
   
           
   
       }
   
   
   }

   // $icon_data = $obj->getDesignIconByGroupRef($day_month_year,$group_code,$ref_num);

   // echo "<pre>";

   // print_r($icon_data);

   // die('--icon test');


  
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="stylesheet" href="w_css/editor.css">
      <?php include_once('head.php');?>
      <link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css">
      <script type="text/javascript" src="w_js/jquery-1.12.4.min.js" charset="UTF-8"></script>
      <script type="text/javascript" src="w_js/datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script>
      <style>
         .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
         color: #555;
         cursor: default;
         background-color: #9EFF98;
         border: 1px solid #ddd;
         border-bottom-color: transparent;
         }
         .btn-light-green {
         text-decoration: none;
         border: 0!important;
         display: block;
         background-color: #DFF0D8;
         -webkit-transition: all .2s cubic-bezier(.15,.69,.83,.67);
         transition: all .2s cubic-bezier(.15,.69,.83,.67);
         width: 200px;
         text-align: center;
         font-family: ProximaNova-Bold,Helvetica,Arial,sans-serif;
         font-size: 14px;
         font-weight: 700;
         color: #3D763E !important;
         padding: 5px;
         margin: 0px 5px 0px 0px;
         float: left;
         }

         /*  bhoechie tab */
         div.bhoechie-tab-container{
         z-index: 10;
         background-color: #ffffff;
         padding: 0 !important;
         border-radius: 4px;
         -moz-border-radius: 4px;
         border:1px solid #ddd;
         margin-top: 20px;
         //margin-left: 50px;
         -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
         box-shadow: 0 6px 12px rgba(0,0,0,.175);
         -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
         background-clip: padding-box;
         opacity: 0.97;
         filter: alpha(opacity=97);
         }
         div.bhoechie-tab-menu{
         padding-right: 0;
         padding-left: 0;
         padding-bottom: 0;
         }
         div.bhoechie-tab-menu div.list-group{
         margin-bottom: 0;
         }
         div.bhoechie-tab-menu div.list-group>a{
         margin-bottom: 0;
         }
         div.bhoechie-tab-menu div.list-group>a .glyphicon,
         div.bhoechie-tab-menu div.list-group>a .fa {
         color: #5A55A3;
         }
         div.bhoechie-tab-menu div.list-group>a:first-child{
         border-top-right-radius: 0;
         -moz-border-top-right-radius: 0;
         }
         div.bhoechie-tab-menu div.list-group>a:last-child{
         border-bottom-right-radius: 0;
         -moz-border-bottom-right-radius: 0;
         }
         div.bhoechie-tab-menu div.list-group>a.active,
         div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
         div.bhoechie-tab-menu div.list-group>a.active .fa{
         background-color: #5A55A3;
         background-image: #5A55A3;
         color: #ffffff;
         }
         div.bhoechie-tab-menu div.list-group>a.active:after{
         content: '';
         position: absolute;
         left: 100%;
         top: 50%;
         margin-top: -13px;
         border-left: 0;
         border-bottom: 13px solid transparent;
         border-top: 13px solid transparent;
         border-left: 10px solid #5A55A3;
         }
         div.bhoechie-tab-content{
         background-color: #ffffff;
         /* border: 1px solid #eeeeee; */
         //padding-left: 20px;
         padding-top: 10px;
         }
         div.bhoechie-tab div.bhoechie-tab-content:not(.active){
         display: none;
         }
         .comment-form-container {
         background: #F0F0F0;
         border: #e0dfdf 1px solid;
         padding: 20px;
         border-radius: 2px;
         }
         .input-row {
         margin-bottom: 20px;
         }
         .input-field {
         width: 100%;
         border-radius: 2px;
         padding: 10px;
         border: #e0dfdf 1px solid;
         }
         .btn-submit {
         padding: 10px 20px;
         background: #333;
         border: #1d1d1d 1px solid;
         color: #f0f0f0;
         font-size: 0.9em;
         width: 100px;
         border-radius: 2px;
         cursor: pointer;
         }
         ul {
         list-style-type: none;
         }
         .comment-row {
         border-bottom: #e0dfdf 1px solid;
         margin-bottom: 15px;
         padding: 15px;
         }
         .outer-comment {
         padding: 10px;
         border: #dedddd 1px solid;
         background: #FFF;
         }
         span.commet-row-label {
         font-style: italic;
         }
         span.posted-by {
         color: #09F;
         }
         .comment-info {
         font-size: 0.8em;
         }
         .comment-text {
         margin: 10px 0px;
         }
         .btn-reply {
         font-size: 0.8em;
         text-decoration: underline;
         color: #888787;
         cursor: pointer;
         }
         #comment-message {
         margin-left: 20px;
         color: #189a18;
         display: none;
         }
         .like-unlike {
         vertical-align: text-bottom;
         cursor: pointer;
         }
         .post-action {
         margin-top: 15px;
         font-size: 0.8em;
         }
         span.posted-at {
         color: #929292;
         }

         #explore .date button:hover, #explore .date .active {
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
         button, input, select, textarea {
         font-family: inherit;
         font-size: inherit;
         line-height: inherit;
         }
         .img_back {
         background-color: lightskyblue;
         }
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
             input[type="time"]{
              height: 50px;
            }

            /*add by ample checkbox style */
            .checkbox-style
            {
            	max-height: 100px;
    			float: left;
    			overflow: auto;
    			/*border: 1px solid #ccc;*/
    			padding: 2.5px;
    			margin: 2.5px 0px;
          clear: both;
            }
            .Header_brown
            {
              clear: both;
            }
          .special-title{
                background: #fbf081;
                padding: 10px;
                font-size: 17px;
          }

            </style>
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
               <span id="error_msg"></span>
               <div class="col-md-10" id="bgimage" style="background-repeat:repeat; padding:5px;">
                  <div class="col-md-12" id="testdata">
                     <!--<h2> <span class="Header_brown"><?php //echo $obj->getPageTitle($page_id);?></span></h2>-->
                     <?php 
                        echo $obj->getPageContents($page_id);
                                                
                        ?>
                  </div>

                  <div style="clear: both;"></div>
                  <div class="alert alert-danger alert-dismissible fade in" id="plan_msg" style="display: none;">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                   Your current plan page limit exceeded now!
              </div>

                <!--added by ample 28-12-20 -->
                <div class="clear-fix" style="padding-bottom: 10px; margin-bottom: 10px; display: block;">
                    <div class="col-md-12" >
                    <a href="reset_mood.php?page_id=<?=$page_id;?>" target="_blank" ><button type="button" class="btn btn-danger btn-sm" style="border-radius: 0;">Reset Mood</button></a>
                      <?php //echo base64_encode()?>
                  </div>
                </div>
                 <div class="clear-fix" style="clear:both;"><br></div>
                  <div class="row">
                    <div class="col-md-9">

                     <?php 

                     if(!empty($activity_title))
                     {
                        ?>
                        <h5 class="text-center" style="text-shadow: 1px 1px 1px #777; color: #be29ec; font-size: 15px;"><?=$activity_title;?> <br> <span style="color: chocolate;">(<?=$obj->getFavCategoryName($fav_cat_id);?>)</span>
                        </h5>
                        <br>
                        <?php
                     }

                     ?>
 
                     <div class="col-md-12">
                        <?php 
                           //$icon_data = $obj->getDesignIconByProfCat($_GET['favcattyid'],$_GET['favid'],$day_month_year);
                           //$icon_data = $obj->getDesignIconByProfCatKR($day_month_year,$group_code,$ref_num);
                            //chnage by ample 28-10-20
                            $icon_data = $obj->getDesignIconByGroupRef($day_month_year,$group_code,$ref_num);
                           
                              //echo "<pre>";print_r($icon_data);echo "</pre>"; die();
                           
                            if(count($icon_data)>0)
                           
                             {
                           
                           
                           
                               for($i=0;$i<count($icon_data);$i++)
                           
                               {
                           
                                   echo '<span><img src="uploads/'.$icon_data[$i]['image'].'" id="img_'.$icon_data[$i]['fav_cat_id'].'" style="width:60px; height:60px; padding:5px; cursor: pointer;" onclick="GetDesignMyLife('.$icon_data[$i]['design_id'].')" title="'.$obj->getFavCategoryNameVivek($icon_data[$i]['fav_cat_id']).'">&nbsp;&nbsp;&nbsp;</span>';  
                           
                           
                           
                                   // echo '<input type="text" id="ref_c'.$i.'" >';
                           
                               }
                           
                             }
                           //comment by ample 29-10-20
                            //  else
                           
                            //  {
                           
                           
                           
                            //     echo '<span><img src="uploads/'.$icon_data[0]['image'].'" id="img_'.$icon_data[0]['fav_cat_id'].'" style="width:60px; height:60px; padding:5px; cursor: pointer;" title="'.$obj->getFavCategoryNameVivek($icon_data[0]['fav_cat_id']).'">&nbsp;&nbsp;&nbsp;</span>';
                           
                           
                           
                            //     echo '<script type="text/javascript">
                           
                            //     $("document").ready(function(){
                           
                            //      GetDesignMyLife('.$icon_data[0]['design_id'].');
                           
                            //      });
                           
                            //    </script>';
                           
                           
                           
                            // }
                           
                           ?> 

                     <div class="col-md-12" id="mydesignlifedata">    
                     </div>
                      
                    </div>
                    </div>
                    <div class="col-md-3">
                        <br>
                         <div id='change_avatar' class="text-center"></div>
                         <!-- comment by email as 07-07-2020 -->
                      <!--    <?php 
                        // add by ample 16-12-19  

                      foreach ($design_my_life_data as $key => $value) {

                          if($value['level']==0)
                          {
                            $value['level']="";
                          }

                        ?>
                        <br>
                          <div class="pull-right col-md-12">
                              <p>
                              <?=($value['level_heading'])? $value['level_heading'].'-'.$value['level'] : '' ;?>  </p> <p>
                              <?=($value['level_title_heading'])? $value['level_title_heading'].'-'.$value['level_title'] : '' ;?> </p>
                            
                             <?php if($value['level_icon']!='') { 
                              
                              if($value['level_icon_type']=='Image')
                              {   

                                  $imgData=$obj->getImgData($value['level_icon']);
                                  if(!empty($imgData['image']))
                                  {   
                                      ?>
                                      <div class="text-center">
                                      <img src="uploads/<?php echo $imgData['image']; ?>" style="width:55px; height: 55px;" title="<?=$value['level_icon_heading'];?>">
                                      </div>
                                      <?php
                                  }
                              }
                              else
                              {   
                                  $fileData=$obj->getFileData($value['level_icon']);
                                  ?>
                                  <a href="<?php echo SITE_URL.'/uploads/'. $fileData['banner'];?>" target="_blank"><?php echo $fileData['banner'];?></a> 
                                  <?php
                              }
                          ?>
                          <?php } ?>
                           <br>
                          </div>
                          <?php
                      }


                      ?> -->

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
      <div id="confirm" class="modal hide fade">
         <div class="modal-body">
            Are you sure?
         </div>
         <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
         </div>
      </div>
      <?php include_once('footer.php');?>   
      <script src="w_css/editor.js"></script>
      <script>

        $('input').on('focus', function(e) 
        {
          e.preventDefault();
          $(this).attr("autocomplete", "off");  
         });

         $(document).ready(function() {

            $('input').attr('autocomplete','off');

           $('#DLY_submit').click(function (event) 
                {
                  event.preventDefault();
                  alert('dd');
                 //get text in div and assign to textarea
                 var str = $( '.Editor-editor' ).text();

                 alert(str);
                 return false;
                 //$('#txtEditor').val(str);
                });
         
            // $("#comment").Editor();
         
             $('#start_date').attr('autocomplete', 'off');
         
             $('#end_date').attr('autocomplete', 'off');
         
             $('#single_date').attr('autocomplete', 'off');
         
             
         
            $("ul.nav-tabs a").click(function (e) {
         
               e.preventDefault();  
         
                 $(this).tab('show');
         
             });
         
         
         
           });
         
      </script>
      <script>
         function GetDesignMyLife(idval)
         
         {
         
             // alert('hi');
         
             // var dataString ='sub_cat_id='+idval +'&action=getmydesignlifedata'; //comernt by ample 28-10-20

             var dataString ='design_id='+idval +'&action=getmydesignlifedata';
         
             $('img').removeClass('img_back');
         
             $("#img_"+idval).addClass("img_back");
         
             
         
             $.ajax({
         
                     type: "POST",
         
                     url: 'remote2.php', 
         
                     data: dataString,
         
                     cache: false,
         
                     success: function(result)
         
                          {
         
                            //alert(result);
         
                            $('#mydesignlifedata').html(result);
         
                          }
         
                    });
         
         }
         
         
         
         
         
         function getcurrentactivetab(id)
         
             {
         
             //alert('hhh');
         
             var formData = new FormData($('#frm_'+id)[0]); 
         
             formData.append("submit",'submit');
         
             jQuery.ajax({
         
             url:'mycanvas.php',
         
             type: "POST",
         
             data:formData,
         
             processData: false,
         
             contentType: false,
         
             //beforeSend: function(){ $("#loader").show();$("#hidebtn").hide();},
         
             success: function(result)
         
                 {
         
                 //alert(result);
         
                 var JSONObject = JSON.parse(result);
         
                 var rslt = JSONObject['error_code'];
         
                 if(rslt==1)
         
                     {
         
                       $("#proceeddml_"+id).show();
         
                       $("#moreoptions_"+id).show();
         
                     }
         
                    
         
                 else
         
                     {
         
                         //$('#error_msg').html(JSONObject['er_msg']);  
         
                     }       
         
                 }
         
             });
         
         }
         
         
         
         function proceeddmlpage(id)
         
         {
         
           window.location.href="design-my-life.php";  
         
         }
         
         
         
         function moreoptionstab(id)
         
         {
         
            $("#proceeddml_"+id).hide();
         
            $("#moreoptions_"+id).hide(); 
         
         }
         


             function ShowTime(id)
         
             {
         
               //alert(id);
         
               $('#bes_time_'+id).show();  
                $('#time_note_'+id).show(); //add by ample 22-04-20
             }
         
             
         
             function ShowDuration(id)
         
             {
         
               //alert("hiiii");
         
               $('#duration_'+id).show();  
                $('#unit_'+id).show(); //add by ample 22-04-20
         
             }
         
             
         
              function ShowScale(id)
         
             {
         
               //alert("hiiii");
         
               $('#scale_'+id).show();  
         
             }
         
             
         
             function ShowLocation(id)
         
             {
         
               // alert("hiiii");
         
               $('#location_'+id).show();  
         
             }
         
             
         
             function ShowAlert(id)
         
             {
         
               //alert("hiiii");
         
               $('#alert_'+id).show();  
         
             }
         
         
         
             function ShowUserInteraction(id)
         
             {
         
               //alert("hiiii");
         
               $('#User_Interaction_'+id).show();  
         
             }
         
             
         
             function ShowUserview(id)
         
             {
         
               //alert("hiiii");
         
               $('#User_view_'+id).show();  
         
             }
         
             
         
             function ShowComment(id)
         
             {
         
               // alert(id);
         
               $('#comment_'+id).show();  
         
             }
         
         
         
             function ShowUserDate(id)
         
             {
         
               $('#userdate_'+id).show();   
         
             }
         
         
         
             function Showtime(id)
         
             {
         
               $('#bes_time_'+id).show();  
               $('#time_note_'+id).show(); //add by ample 22-04-20
         
             }
         
         
         
             function DurationShow(id)
         
             {
         
               $('#duration_'+id).show();  
               $('#unit_'+id).show(); //add by ample 22-04-20
         
             }
         
         
         
             // 
         
         
         
         
         
             
         
             
         
             function Display_Solution(idval)
         
             {
         
                 var bms_name = $("#fav_cat_2_"+idval).val();
         
                 var table = $("#fetch_link").val();
         
                 var sub_cat3 = $("#sub_cat3").val();
         
                 var icon_code = $("#icon_code").val();
         
                 
         
                 var table2 = $("#fetch_link_2").val();
         
                 var sub_cat4 = $("#sub_cat4").val();
         
                 
         
                 
         
                 //return false;
         
                 
         
                 $('.dlist').show();  
         
                 var dataString ='fetch_link='+table +'&bms_name='+bms_name+'&sub_cat3='+sub_cat3+'&fetch_link_2='+table2+'&sub_cat4='+sub_cat4+'&action=getbescomment';
         
                 $.ajax({
         
                     type: "POST",
         
                     url: 'remote2.php', 
         
                     data: dataString,
         
                     cache: false,
         
                     success: function(result)
         
                          {
         
                             //alert(result);
         
                             $('#comment_backend_'+idval).html(result);
         
                         }
         
                    });
         
             }
         
             
         
             
         
             function isNumberKey(evt){  <!--Function to accept only numeric values-->
         
             //var e = evt || window.event;
         
            var charCode = (evt.which) ? evt.which : evt.keyCode
         
             if (charCode != 46 && charCode > 31 
         
            && (charCode < 48 || charCode > 57))
         
                 return false;
         
                 return true;
         
            }
         
              
         
      </script>
      <script>
         function toggleDateSelectionType(id_val)
         
         
         
         {
         
         // alert(id_val);
         
         // console.log(id_val);
         
            var sc_listing_date_type = document.getElementById(id_val).value;
         
            if (sc_listing_date_type == "days_of_month") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = '';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "single_date") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = '';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "date_range") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = '';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "days_of_week") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = '';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "month_wise") 
         
            {   
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = '';
         
            }
         
            else
         
            {   
         
         
         
                document.getElementById('tr_days_of_month').style.display = 'none';
         
                document.getElementById('tr_single_date').style.display = 'none';
         
                document.getElementById('tr_date_range').style.display = 'none';
         
                document.getElementById('tr_days_of_week').style.display = 'none';
         
                document.getElementById('tr_month_date').style.display = 'none';
         
            }
         
         
         
         }
         
         
         
         
         
         function toggleDateSelectionType_multiple(id_val,num)
         
         
         
         {
         
         // alert(id_val);
         
         // console.log(id_val+'_'+num);
         
            var sc_listing_date_type = document.getElementById(id_val+num).value;
         
         
         
            $('.tab_show'+num).show();
         
            if (sc_listing_date_type == "days_of_month") 
         
            {   
         
                document.getElementById('tr_days_of_month_'+num).style.display = '';
         
                document.getElementById('tr_single_date_'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_'+num).style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "single_date") 
         
            {   
         
                document.getElementById('tr_days_of_month_'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_'+num).style.display = '';
         
                document.getElementById('tr_date_range_'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_'+num).style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "date_range") 
         
            {   
         
                document.getElementById('tr_days_of_month_'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_'+num).style.display = '';
         
                document.getElementById('tr_days_of_week_'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_'+num).style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "days_of_week") 
         
            {   
         
                document.getElementById('tr_days_of_month_'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_'+num).style.display = '';
         
                document.getElementById('tr_month_date_'+num).style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "month_wise") 
         
            {   
         
                document.getElementById('tr_days_of_month_'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_'+num).style.display = '';
         
            }
         
            else
         
            {   
         
         
         
                document.getElementById('tr_days_of_month_'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_'+num).style.display = 'none';
         
            }
         
         
         
         }
         
         
         
         
         
         
         
         function toggleDateSelectionType_multiple_lo(id_val,num)
         
         
         
         {
         
         // alert(num);
         
         // console.log(id_val+'_'+num);
         
            var sc_listing_date_type = document.getElementById(id_val+num).value;

         
         $('.tab_show'+num).show();
         
            if (sc_listing_date_type == "days_of_month") 
         
            {   
         
                document.getElementById('tr_days_of_month_lo'+num).style.display = '';
         
                document.getElementById('tr_single_date_lo'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_lo'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_lo'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_lo'+num).style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "single_date") 
         
            {   
         
                document.getElementById('tr_days_of_month_lo'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_lo'+num).style.display = '';
         
                document.getElementById('tr_date_range_lo'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_lo'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_lo'+num).style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "date_range") 
         
            {   
         
                document.getElementById('tr_days_of_month_lo'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_lo'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_lo'+num).style.display = '';
         
                document.getElementById('tr_days_of_week_lo'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_lo'+num).style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "days_of_week") 
         
            {   
         
                document.getElementById('tr_days_of_month_lo'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_lo'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_lo'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_lo'+num).style.display = '';
         
                document.getElementById('tr_month_date_lo'+num).style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "month_wise") 
         
            {   
         
                document.getElementById('tr_days_of_month_lo'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_lo'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_lo'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_lo'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_lo'+num).style.display = '';
         
            }
         
            else
         
            {   
         
         
         
                document.getElementById('tr_days_of_month_lo'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_lo'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_lo'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_lo'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_lo'+num).style.display = 'none';
         
            }
         
         
         
         }

         //specail case date type by ample 28-05-20

        function toggleDateSelectionType_multiple_SP(id_val,num)
         
         
         
         {
         
         // alert(num);
         
         // console.log(id_val+'_'+num);
         
            var sc_listing_date_type = document.getElementById(id_val+num).value;

         
         $('.tab_show'+num).show();
         
            if (sc_listing_date_type == "days_of_month") 
         
            {   
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = '';
         
                document.getElementById('tr_single_date_SP'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_SP'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_SP'+num).style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "single_date") 
         
            {   
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_SP'+num).style.display = '';
         
                document.getElementById('tr_date_range_SP'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_SP'+num).style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "date_range") 
         
            {   
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_SP'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_SP'+num).style.display = '';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_SP'+num).style.display = 'none';
         
            }
         
            else if (sc_listing_date_type == "days_of_week") 
         
            {   
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_SP'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_SP'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = '';
         
                document.getElementById('tr_month_date_SP'+num).style.display = 'none';
         
            }
         
         
         
            else if (sc_listing_date_type == "month_wise") 
         
            {   
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_SP'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_SP'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_SP'+num).style.display = '';
         
            }
         
            else
         
            {   
         
         
         
                document.getElementById('tr_days_of_month_SP'+num).style.display = 'none';
         
                document.getElementById('tr_single_date_SP'+num).style.display = 'none';
         
                document.getElementById('tr_date_range_SP'+num).style.display = 'none';
         
                document.getElementById('tr_days_of_week_SP'+num).style.display = 'none';
         
                document.getElementById('tr_month_date_SP'+num).style.display = 'none';
         
            }
         
         
         
         }
         
         
        function addMoreRowLocation()
         
         {
         
                    
         
           var sub_cat_id = $("#sub_cat_id").val();
         
             var cat_cnt = parseInt($("#cat_cnt").val());

             var max_cat_cnt = parseInt($("#max_box_count").val()); //add by ample 11-05-20

             cat_cnt = cat_cnt + 1;
            //add by ample 11-05-20
             if(cat_cnt>max_cat_cnt)
             {
                alert("Limit is over now you can't add more");
                return false;
             }
         
         
                        var dataString ='sub_cat_id='+sub_cat_id +'&action=getProfCat2DataDesignLife'+'&cat_cnt='+cat_cnt;
         
                        $.ajax({
         
                                type: "POST",
         
                                url: 'remote2.php', 
         
                                data: dataString,
         
                                cache: false,
         
                                success: function(result)
         
                                     {
         
                                        //alert(result);
         
                                      $("#row_loc_first").append(result);
         
                                    }
         
                               });

         
            $("#cat_cnt").val(cat_cnt);
                  
            var cat_total_cnt = parseInt($("#cat_total_cnt").val());
         
            cat_total_cnt = cat_total_cnt + 1;
         
            $("#cat_total_cnt").val(cat_total_cnt);
         
         } 
         
         
        
         
         
          function callDatecalender(num)
         
          {
         
            // alert(num);
         
             $('#single_date'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
         
             $('#start_date'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
         
             $('#end_date'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
         
            $('#single_date_lo'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
         
            $('#start_date_lo'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
         
            $('#end_date_lo'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'}); 

            //11-06-20 add by ample

            $('#single_date_SP'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
         
            $('#start_date_SP'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'});
         
            $('#end_date_SP'+num).datepicker({ minDate: 0 , dateFormat : 'dd-mm-yy'}); 

         
          }
         
         
         
         function removeRowLocation(idval)
         
         {
         
            $("#row_loc_"+idval).remove();
         
         
         
            var cat_total_cnt = parseInt($("#cat_total_cnt").val());
         
            cat_total_cnt = cat_total_cnt - 1;
         
            $("#cat_total_cnt").val(cat_total_cnt);
         
            
         
         }
         
                
         
                
         
         function addMoreRowLoc()
         
         {
          

          var sub_cat_id = $("#sub_cat_id").val();
         
           var cat_cnt = parseInt($("#box_cnt").val());

           var max_cat_cnt = parseInt($("#max_input_box_count").val()); //add by ample 11-05-20
         
            cat_cnt = cat_cnt + 1;
            //add by ample 11-05-20
             if(cat_cnt>max_cat_cnt)
             {
                alert("Limit is over now you can't add more");
                return false;
             }
         
                        var dataString ='sub_cat_id='+sub_cat_id +'&action=getInputDataDesignLife'+'&cat_cnt='+cat_cnt;
         
                        $.ajax({
         
                                type: "POST",
         
                                url: 'remote2.php', 
         
                                data: dataString,
         
                                cache: false,
         
                                success: function(result)
         
                                     {
         
                                      //alert(result);
         
                                      $("#row_inp_first").append(result);
         
                                    }
         
                               });

         
            $("#box_cnt").val(cat_cnt);
         
         
            var cat_total_cnt = parseInt($("#box_total_cnt").val());
         
            cat_total_cnt = cat_total_cnt + 1;
         
            $("#box_total_cnt").val(cat_total_cnt);
         
         }
         
         
         
         function removeRowLoc(idval)
         
         {
         
            $("#row_inp_"+idval).remove();
         
         
         
            var cat_total_cnt = parseInt($("#box_total_cnt").val());
         
            cat_total_cnt = cat_total_cnt - 1;
         
            $("#box_total_cnt").val(cat_total_cnt);
         
            
         
         }   
         
         
         
          function Showloop(id)
         
         {
         
         //alert(id);
         
         $("#comment_show_icon_"+id).show(); 
         
         $("#location_show_icon_"+id).show(); 
         
         $("#User_view_icon_"+id).show(); 
         
         $("#User_Interaction_icon_"+id).show(); 
         
         $("#alert_show_icon_"+id).show(); 
         
         $("#user_date_show_icon_"+id).show();
         
         $("#scale_show_icon_"+id).show();
         
         $("#time_show_icon_"+id).show();
         
         $("#duration_show_icon_"+id).show();
         
         
         
         
         
         
         
         }
         
         
         
         function ShowloopLoc(id)
         
         {
         
         // alert(id);
         
         $("#comment_show_icon_lo"+id).show(); 
         
         $("#location_show_icon_lo"+id).show(); 
         
         $("#User_view_icon_lo"+id).show(); 
         
         $("#User_Interaction_icon_lo"+id).show(); 
         
         $("#alert_show_icon_lo"+id).show(); 
         
         $("#user_date_show_icon_lo"+id).show();
         
         $("#scale_show_icon_lo"+id).show();
         
         $("#time_show_icon_lo"+id).show();
         
         $("#duration_show_icon_lo"+id).show();
         
         }


         
         // function ShowComment(id)
         
         // {
         
         // $('#comment_'+id).show();  
         
         // }
         
         
         
         
         
          function ShowComment_Lo(id)
         
            {
         
              // alert(id);
         
              $('#comment_lo'+id).show();  
         
            }
         
         
         
         
         
         function ShowLocation_Lo(id)
         
            {
         
              // alert("hiiii");
         
              $('#location_lo'+id).show();  
         
            }
         
         
         
              function ShowUserview_Lo(id)
         
            {
         
              //alert("hiiii");
         
              $('#User_view_lo'+id).show();  
         
            }
         
         
         
            function ShowUserInteraction_Lo(id)
         
            {
         
              //alert("hiiii");
         
              $('#User_Interaction_lo'+id).show();  
         
            }
         
         
         
          function ShowAlert_Lo(id)
         
            {
         
              //alert("hiiii");
         
              $('#alert_lo'+id).show();  
         
            }
         
         
         
            function ShowUserDate_Lo(id)
         
            {
         
              //alert("hiiii");
         
              $('#userdate_lo'+id).show();  
         
            }
         
         
         
         
         
           function ShowScale_Lo(id)
         
            {
         
              // alert("hiiii");
         
              $('#scale_lo'+id).show();  
         
            }
         
         
         
            
         
          function Showtime_Lo(id)
         
            {
         
              // alert(id);
         
              $('#bes_time_lo'+id).show();  
              $('#time_note_lo'+id).show(); // add by ample 22-04-20
         
            }
         
            
         
            function DurationShow_Lo(id)
         
            {
         
              //alert("hiiii");
         
              $('#duration_lo'+id).show();  
              $('#unit_lo'+id).show(); //add by ample 22-04-20
         
            }


        //special case icone copy by ample 28-05-20
         function ShowloopSP(id)
         
         {
         
         // alert(id);
         
         $("#comment_show_icon_SP"+id).show(); 
         
         $("#location_show_icon_SP"+id).show(); 
         
         $("#User_view_icon_SP"+id).show(); 
         
         $("#User_Interaction_icon_SP"+id).show(); 
         
         $("#alert_show_icon_SP"+id).show(); 
         
         $("#user_date_show_icon_SP"+id).show();
         
         $("#scale_show_icon_SP"+id).show();
         
         $("#time_show_icon_SP"+id).show();
         
         $("#duration_show_icon_SP"+id).show();
         
         }



            function ShowComment_SP(id)
         
            {
         
              // alert(id);
         
              $('#comment_SP'+id).show();  
         
            }
         
         
         
         
         
         function ShowLocation_SP(id)
         
            {
         
              // alert("hiiii");
         
              $('#location_SP'+id).show();  
         
            }
         
         
         
              function ShowUserview_SP(id)
         
            {
         
              //alert("hiiii");
         
              $('#User_view_SP'+id).show();  
         
            }
         
         
         
            function ShowUserInteraction_SP(id)
         
            {
         
              //alert("hiiii");
         
              $('#User_Interaction_SP'+id).show();  
         
            }
         
         
         
          function ShowAlert_SP(id)
         
            {
         
              //alert("hiiii");
         
              $('#alert_SP'+id).show();  
         
            }
         
         
         
            function ShowUserDate_SP(id)
         
            {
         
              //alert("hiiii");
         
              $('#userdate_SP'+id).show();  
         
            }
         
         
         
         
         
           function ShowScale_SP(id)
         
            {
         
              // alert("hiiii");
         
              $('#scale_SP'+id).show();  
         
            }
         
         
         
            
         
          function Showtime_SP(id)
         
            {
         
              // alert(id);
         
              $('#bes_time_SP'+id).show();  
              $('#time_note_SP'+id).show(); // add by ample 22-04-20
         
            }
         
            
         
            function DurationShow_SP(id)
         
            {
         
              //alert("hiiii");
         
              $('#duration_SP'+id).show();  
              $('#unit_SP'+id).show(); //add by ample 22-04-20
         
            }
         
         
         
         
         
            function erase_input(id)
         
             {
         
               $("#fav_cat_2_"+id).val('');
         
             }    
             //copy by ample
             function erase_inputs(id)
         
             {
         
               $("#user_input_"+id).val('');
         
             }   

//add by ample 13-04-20 in remote
//              $( ".Editor-editor" ).mouseleave(function() {
//    var str = $( ".Editor-editor" ).html();
//     $("#comment_main").val(str);
// });  

      //update by ample 15-04-20 

        //add by ample 07-05-20
        function openBoxTitle(page_cat_id=0,popTitle="")
        { 
          
          if(popTitle=='')
          {
            popTitle='Examples for Reference';
          }
          var dataString ='action=getboxtitle_DYL&page_cat_id='+page_cat_id;
          $.ajax({
            type: "POST",
            url: "remote2.php",
            data: dataString,
            cache: false,
            success: function(result)
            {
             BootstrapDialog.show({

                        title:popTitle ,

                        message:result

                    });
            }

          });

        }

        function openExampleBox(data_id=0,type_id="",popTitle="")
        { 

          if(popTitle=='')
          {
            popTitle='Examples for Reference';
          }
          var dataString ='action=openExampleBox&type_id='+type_id+'&data_id='+data_id;
          $.ajax({
            type: "POST",
            url: "remote2.php",
            data: dataString,
            cache: false,
            success: function(result)
            {
             BootstrapDialog.show({

                         title:popTitle ,

                        message:result

                    });
            }

          });

        }
          //added by ample

        function plan_msg()
        {
          $('#plan_msg').fadeIn();
          $("html").animate({ scrollTop: 0 }, "slow");
        }
      </script>
   </body>
</html>
<?php 

include('classes/config.php');

$page_id = '120';

$obj = new frontclass();

$obj2 = new frontclass2();



$page_data = $obj->getPageDetails($page_id);

$ref = base64_encode($page_data['menu_link']);



if(!$obj->isLoggedIn())



{

  $obj->doUpdateOnline($_SESSION['user_id']);

  header("Location: login.php?ref=".$ref);

  exit();



}

 else {

     $user_id = $_SESSION['user_id'];

     $obj->doUpdateOnline($_SESSION['user_id']);

}



$error = false;

if(isset($_POST['user_data_uploads']))

{

   $data = array();

   $data['user_id'] = $_SESSION['user_id'];

   $data['banner_type'] = $_POST['banner_type'];

   $data['rss_text'] = $_POST['rss_text'];

   $data['video_url'] = $_POST['video_url'];

   $data['image_video_audio_pdf_credit_line'] = $_POST['image_video_audio_pdf_credit_line'];

   $data['image_video_audio_pdf_credit_url'] = $_POST['image_video_audio_pdf_credit_url'];

   $data['documents_credit_line'] = $_POST['documents_credit_line'];

   $data['documents_credit_url'] = $_POST['documents_credit_url'];

   $data['from_page'] = "Design your life";

   $data['ref_code'] = $_POST['ref_code'];

   $data['box_title']= $_POST['box_title'];

   $data['sub_cat_id']= $_POST['sub_cat_id'];

   $tags= $_POST['tags'];

   $data['get_tags']=implode(',', $tags);

  // echo "<pre>";print_r($get_tagss);echo "</pre>";

  // exit;

   

   $targetFolder = SITE_PATH . '/uploads';

   

   if(!empty($_FILES['image_video_audio_pdf']['name']))

   {

   

   $tempFile = $_FILES['image_video_audio_pdf']['tmp_name'];

   $picture_size_limit = 5120;

   $image_video_audio_pdf = date('dmYHis') . '_' . $_FILES['image_video_audio_pdf']['name'];

   

   $image_video_audio_pdf = str_replace(' ', '-', $image_video_audio_pdf);

   

   $targetPath = $targetFolder;

   $targetFile = rtrim($targetPath, '/') . '/' . $image_video_audio_pdf;

   $mimetype = $_FILES['image_video_audio_pdf']['type'];

   $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF','mp3','MP3','mp4','MP4'); // File extensions

   $fileParts = pathinfo($_FILES['image_video_audio_pdf']['name']);

   if (in_array($fileParts['extension'], $fileTypes))

        {

            $vloc_doc_file = $_FILES['image_video_audio_pdf']['name'];

            $size_in_kb = $_FILES['image_video_audio_pdf']['size'] / 1024;

            $file4 = substr($vloc_doc_file, -4, 4);

            //echo $file4;

            if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF') and ($file4 != '.MP4') and ($file4 != '.mp4') and ($file4 != '.MP3') and ($file4 != '.mp3'))

            {

                    $error = true;

                    $err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for upload';

            }

            elseif ($size_in_kb > $picture_size_limit)

            {

                    $error = true;

                    $err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb ';

            }



            if (!$error)

            {

                    //$image_video_audio_pdf = $filename;

                    

                    $data['image_video_audio_pdf']= $image_video_audio_pdf;

                    if (!move_uploaded_file($tempFile, $targetFile))

                    {

                            if (file_exists($targetFile))

                            {

                                unlink($targetFile);

                            } // Remove temp file

                            $error = true;

                            $err_msg = 'Couldn\'t upload file for upload pdf';

                    }

            }

    }

    else

    {

            $error = true;

            $err_msg = 'Invalid file type for upload doc';

    }

   }

   

   if(!empty($_FILES['documents']['name']))

   {

    $picture_size_limit = 5120;

    $tempFile = $_FILES['documents']['tmp_name'];

    $documents = date('dmYHis') . '_' . $_FILES['documents']['name'];

    $documents = str_replace(' ', '-', $documents);



    $targetPath = $targetFolder;

    $targetFile = rtrim($targetPath, '/') . '/' . $documents;

    $mimetype = $_FILES['documents']['type'];

    $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf', 'PDF','DOC','DOCX','doc','docx'); // File extensions

    $fileParts = pathinfo($_FILES['documents']['name']);

    if (in_array($fileParts['extension'], $fileTypes))

        {

            $vloc_doc_file = $_FILES['documents']['name'];

            $size_in_kb = $_FILES['documents']['size'] / 1024;

            $file4 = substr($vloc_doc_file, -4, 4);

            //echo $file4.'<br>';

            if (($file4 != '.jpg') and ($file4 != '.JPG') and ($file4 != 'jpeg') and ($file4 != 'JPEG') and ($file4 != '.gif') and ($file4 != '.GIF') and ($file4 != '.png') and ($file4 != '.PNG') and ($file4 != '.pdf') and ($file4 != '.PDF') and ($file4 != '.DOC') and ($file4 != '.DOCX') and ($file4 != '.doc') and ($file4 != '.docx') and ($file4 != 'DOC') and ($file4 != 'DOCX') and ($file4 != 'doc') and ($file4 != 'docx') )

            {

                    $error = true;

                    $err_msg = 'Please upload only(jpg/gif/jpeg/png/pdf) file for upload ';

            }

            elseif ($size_in_kb > $picture_size_limit)

            {

                    $error = true;

                    $err_msg = 'Please upload image with size upto ' . $picture_size_limit . ' kb ';

            }



            if (!$error)

            {

                    //$documents = $filename;

                    $data['documents']=$documents;

                    if (!move_uploaded_file($tempFile, $targetFile))

                    {

                            if (file_exists($targetFile))

                            {

                                    unlink($targetFile);

                            } // Remove temp file

                            $error = true;

                            $err_msg = 'Couldn\'t upload file for upload doc';

                    }

            }

    }

    else

    {

            $error = true;

            $err_msg = 'Invalid file type for upload doc';

    }

   }

   

   if(!$error)

   {

        





     

       if($obj->AddUserUploads($data))

       {

          header("Location: message.php?msg=23");

          exit();  

       }

       else

       {

            $error = true;

            $err_msg = 'There is some error please try again latar';      

       }

       

   }

   

   

    

}



?>

<!DOCTYPE html>

<html lang="en">

<head>    

    

    <?php include_once('head.php');?>

    <!-- <link rel="stylesheet" href="w_js/datepicker/css/bootstrap-datepicker.css"> -->

    

    <!-- <script type="text/javascript" src="w_js/jquery-1.12.4.min.js" charset="UTF-8"></script> -->



    <!-- <script type="text/javascript" src="w_js/datepicker/js/bootstrap-datepicker.js" charset="UTF-8"></script> -->

    <!-- <link rel="stylesheet" href="https://rawgit.com/dbrekalo/attire/master/dist/css/build.min.css"> -->

    <!-- <script src="https://rawgit.com/dbrekalo/attire/master/dist/js/build.min.js"></script> -->

   

    <script src="admin/js/fastselect.standalone.js"></script>

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

</style>

<style>

   

    

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



.fstMultipleMode .fstControls {

    width: 83em !important;

  

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

                        <div class="col-md-12" id="">

                        <?php echo $obj->getPageContents($page_id);?>

                        </div>

                        <div class="col-md-12" style="background-color: #FFF7F5; margin-bottom: 10px;">

                        <?php echo $_GET['box_title'];?>&nbsp;&nbsp;&nbsp;

                        <button type="submit" name="btn_submit" class="active">Preview</button>

                            <br>

                            <?php echo $obj->getFavCategoryNameVivek($_GET['sub_cat_id']); ?>

                           

                        </div>

                         

                        <div class="col-md-12" style="">

                            <form name="frm_signup" id="frm_signup" method="post" enctype="multipart/form-data">

                                <input type="hidden" name="ref_code" id="ref_code" value="<?php echo $_GET['ref_code']; ?>"/>

                                <input type="hidden" name="box_title" id="box_title" value="<?php echo $_GET['box_title']; ?>"/>

                                <input type="hidden" name="sub_cat_id" id="sub_cat_id" value="<?php echo $_GET['sub_cat_id']; ?>"/>

                            <div id="checkout-signup-tab">

                                    <span id="err_msg_signup"><?php if($error) { echo $err_msg; } ?></span>

                                    <div id="signup-box">

                                            <div class="form-group">

                                                <select required="" class="input-text-box input-half-width" name="banner_type" id="banner_type" onchange="BannerBox1();">
                                                  <!-- update by ample-->
                                                        <option value="">Select</option>

                                                        <option value="Image">Image</option>

                                                        <option value="Video">Video</option>

                                                        <option value="Audio">Audio</option>

                                                        <option value="Pdf">Pdf</option>

                                                        <option value="rss">Rss Feed</option>

                                                        <option value="text">Text</option>



                                                    </select>

                                            </div>

                                        

                                         <div class="form-group" id="image_doc_div" style="display: none;">

                                             <input type="file" name="image_video_audio_pdf" id="image_video_audio_pdf" placeholder="image" class="input-text-box" >

                                         </div>

                                        <div class="form-group" id="rss_text_div" style="display: none;">

                                             <input type="text" name="rss_text" id="rss_text" placeholder="RSS Feed URL / your text input" class="input-text-box" >

                                         </div>

                                        <div class="form-group" id="video_div" style="display: none;">

                                             <input type="text" name="video_url" id="video_url" placeholder="You tube Video URL" class="input-text-box" >

                                         </div>

                                        

                                        <div class="form-group" id="credit_line_div" style="display: none;">

                                             <input type="text" name="image_video_audio_pdf_credit_line" id="image_video_audio_pdf_credit_line" placeholder="Credit Line" class="input-text-box" >

                                         </div>

                                        <div class="form-group" id="credit_line_url" style="display: none;">

                                             <input type="text" name="image_video_audio_pdf_credit_url" id="image_video_audio_pdf_credit_url" placeholder="Credit Url" class="input-text-box" >

                                         </div>

                                        

                                         <div class="form-group">

                                             <input type="file" name="documents" id="documents" placeholder="documents" class="input-text-box" >

                                         </div>

                                        <div class="form-group">

                                             <input type="text" name="documents_credit_line" id="documents_credit_line" placeholder="Credit Line" class="input-text-box" >

                                         </div>

                                        <div class="form-group">

                                             <input type="text" name="documents_credit_url" id="documents_credit_url" placeholder="Credit Url" class="input-text-box" >

                                         </div>

                                        <?php 

                                        // echo $_GET['sub_cat_id'];

                                        // echo $obj->getIngredientsByIngrdientType($_GET['sub_cat_id'],'423','127');

                                        //echo $obj->getIngredientsByIngrdientType(0,'423','127');

                                        ?> <!-- fav id,comman,pagename -->

                                         <div class="form-group">

                                        <select class="multipleSelect2 input-text-box" name="tags[]" id="tags" placeholder="Tags" multiple >

                                           <!--   $data['sub_cat_id'] -->

                                         <?php echo $obj->getIngredientsByIngrdientType($_GET['sub_cat_id'],'423','70');?> <!-- fav id,comman,page_cat id -->

                                        </select>

                                      </div>

                                        <script>

                                            $('.multipleSelect2').fastselect();

                                        </script>



                                         <!--  <div class="form-group">

                                             <input type="text" name="tags" id="tags" placeholder="Tags" class="input-text-box" >

                                         </div> -->







                                        <div class="form-group">

                                            <hr>

                                                <button type="submit" class="btn-red" name="user_data_uploads" id="user_data_uploads" >Upload</button>

                                        </div>  

                                    </div>

                            </div>

                            </form>

                        </div>

                    </div>

    <div class="col-md-2"><?php include_once('right_sidebar.php'); ?></div>

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

<script>



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

 function BannerBox1()

{



  var banner_type = document.getElementById('banner_type').value;



  if (banner_type == "video") 

  { 



           document.getElementById('rss_text_div').style.display = 'none';  

           

           document.getElementById('video_div').style.display = 'block';  



     document.getElementById('image_doc_div').style.display = 'none';



     document.getElementById('credit_line_div').style.display = '';

           

           document.getElementById('credit_line_url').style.display = '';

           



  }

        else if (banner_type == "image") 

  { 



           document.getElementById('rss_text_div').style.display = 'none';  



     document.getElementById('image_doc_div').style.display = 'block';



     document.getElementById('credit_line_div').style.display = '';

           

           document.getElementById('credit_line_url').style.display = '';

           document.getElementById('video_div').style.display = 'none';  



  }

        else if (banner_type == "audio") 

  { 



           document.getElementById('rss_text_div').style.display = 'none';  



     document.getElementById('image_doc_div').style.display = 'block';



     document.getElementById('credit_line_div').style.display = '';

           

           document.getElementById('credit_line_url').style.display = '';

           document.getElementById('video_div').style.display = 'none';  



  }

        else if (banner_type == "pdf") 

  { 



           document.getElementById('rss_text_div').style.display = 'none';  



     document.getElementById('image_doc_div').style.display = 'block';



     document.getElementById('credit_line_div').style.display = '';

           

           document.getElementById('credit_line_url').style.display = '';

           document.getElementById('video_div').style.display = 'none';  



  }



        else if(banner_type == "rss") 



  { 



           document.getElementById('rss_text_div').style.display = 'block';  



     document.getElementById('image_doc_div').style.display = 'none';



     document.getElementById('credit_line_div').style.display = '';

           

           document.getElementById('credit_line_url').style.display = '';

           document.getElementById('video_div').style.display = 'none';  



  }



        else if(banner_type == "text") 



  { 



           document.getElementById('rss_text_div').style.display = 'block';  



     document.getElementById('image_doc_div').style.display = 'none';



     document.getElementById('credit_line_div').style.display = '';

           

           document.getElementById('credit_line_url').style.display = '';

           document.getElementById('video_div').style.display = 'none';  



  }



  else



  {



           document.getElementById('rss_text_div').style.display = 'none'; 

     document.getElementById('image_doc_div').style.display = 'none';

     document.getElementById('credit_line_div').style.display = 'none';

           document.getElementById('credit_line_url').style.display = 'none';

           document.getElementById('video_div').style.display = 'none';  



  }



}

</script>

</body>

</html>
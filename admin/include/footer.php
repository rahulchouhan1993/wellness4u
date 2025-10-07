
<div id="Gallery1" style="position: fixed; bottom: 5px; right: 5px;">
	<button type="button" class="btn btn-primary btn-xs" onclick="galleryData('IMG',0);">Gallery 1</button>
</div>

<div id="Gallery2" style="position: fixed; bottom: 35px; right: 5px;">
  <button type="button" class="btn btn-primary btn-xs" onclick="galleryData('OT',0);">Gallery 2</button>
</div>


<!-- Modal add by ample 20-11-19 -->
<div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Gallery</h4>
      </div>
      <div class="modal-body">
        
            <div class="row">
                <div class="col-md-12">
                    <div id="showGallery">

                    </div>
                </div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tbody>
	<tr>
		<td style="background-image: url(images/bottom_line_bg.gif);"><img src="images/spacer.gif" alt="" border="0" width="1" height="7"></td>
	</tr>
	<tr>
		<td class="bottom-menu" align="center">
			<a href="../index.php" class="bottom-menu-links" target="_blank">View SITE </a>
			<?php
			if(isset($_SESSION['admin_id']))
			{
			?>
			&nbsp;&nbsp;|&nbsp;<a href="info.php" class="bottom-menu-links" target="_blank">PHP Information</a>
			<?php
			}
			?>	
		</td>
	</tr>
	<tr>
		<td class="bottom-copyright" align="center">&nbsp;Copyright &copy;  -2011 Chaitanya Wellness Research Institute. &nbsp;</td>
	</tr>
</tbody>
</table>
<div id="page_loading_bg" class="page_loading_bg" style="display:none;">
	<div id="page_loading_img" class="page_loading_img"><img border="0" src="<?php echo SITE_URL;?>/images/loading.gif" /></div>
</div> 

<div class="QTPopup">
	<div class="popupGrayBg"></div>
	<div class="QTPopupCntnr">
		<div class="gpBdrRight">
			<div class="caption">
				<div id="caption_text">Feedback and Suggestions</div>
			</div>
			<a href="#" class="closeBtn" title="Close"></a>
			<div id="prwcontent" style="margin:5px;">
			<br />
			</div>
		</div>
	</div>
</div>


 <!-- latest jQuery library -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

<script type="text/javascript">
    // code write by ample 04-12-19 update 05-12-19
    function galleryData(type="",category="",id_field="")
    {   
      if(category==0)
      {
         category='';
      }
      else
      {
         category=category.value;
      }
        $.ajax({
            url: "include/remote.php",
            type:'get',
            data: {action:'galleryData',type:type,category:category,id_field:id_field },
            //dataType: 'json',
            success: function(response) {
              //Do Something
              //window.location.reload(true);
              //alert(response);
              $('#showGallery').html(response);
              $('#galleryModal').modal('show');
            },
            error: function(xhr) {
            //Do Something to handle error
                //alert(xhr);
            }
        });

    }
    // code by ample 06-12-19 & update 17-02-20 for credit
    function selected_gallery_data(id="",id_field="",cat="",name="",file="",credit="",credit_url="")
    {
      //alert(icons_id);
      //alert(id_field);
      // console.log(icons_id);
      // console.log(id_field);
      $('#'+id_field).val(id);
      $('#'+id_field+'_type').val(cat);
      $('#'+id_field+'_name').val(name);
      $('#'+id_field+'_file').val(file);
      $('#'+id_field+'_credit').val(credit);
      $('#'+id_field+'_credit_url').val(credit_url);
      $('#galleryModal').modal('hide');
    }
    // code by ample 11-12-19 & update 17-02-20 for credit
    function ResetgalleryData(id_field="")
    {
        $('#'+id_field).val("");
        $('#'+id_field+'_type').val("");
        $('#'+id_field+'_name').val("");
        $('#'+id_field+'_file').val("");
        $('#'+id_field+'_credit').val("");
        $('#'+id_field+'_credit_url').val("");
    }
    // $('.selected_gallery_data').on('click',function(){
    //     alert('test');
    // });
    // $(function() {
    // $(".selected_gallery_data").on('click', function() {
    // alert("inside onclick");
    //   });
    //  $(".selected_gallery_data").click(function() {
    //     alert('test-4654646');
    //   });
    // });
</script>
<!-- add by ample 16-04-20 -->
<div class="feedback" onclick="FeedBackForm(<?=$page_id;?>)"><button class="btn btn-default btn-feedback"> <i class="fa fa-question-circle" aria-hidden="true"></i> Help us Improve </button></div>



<!-- Modal by ample-->
<div id="feedbackModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Feedback Form</h4>
      </div>
      <div class="modal-body">
        	<form action="" method="post" id="FormFeedback">
        	<div class="form-group">
			    <label>Subject:</label>
			    <select class="form-control" name="page_id" required="">
			    	<?php 
			    		if(isset($page_id))
			    		{
			    			echo $obj->getFeeadBackPage($page_id);
			    		}
			    		else
			    		{
			    			echo '<option value="0" selected>General</option>';
			    		}
			    		?>
			    </select>
			  </div>
        	 <div class="form-group">
			    <label>Name:</label>
			    <input type="name" class="form-control" value="<?=$_SESSION['adm_vendor_name'];?>" disabled>
			  </div>
			  <div class="form-group">
			    <label>Email:</label>
			    <input type="email" class="form-control" value="<?=$_SESSION['adm_vendor_email'];?>" disabled>
			  </div>
			  <div class="form-group">
				  <label>Feedback and Suggestions:</label>
				  <textarea class="form-control" rows="3" name="feedback" id="user_feedback" required></textarea>
				</div>
				<input type="hidden" name="action" value="FormFeedbackSave">
			  <button type="button" class="btn btn-default" onclick="FormFeedbackSave()">Submit</button>
			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


			<!--footer start-->


			<!-- comment by ample 23-10-19-->
           <!-- <script src="../../venders\js\commonfn.js"></script>-->
           <script src="../..\js\commonfn.js"></script>


			<div class="footer">

				<div class="row">

					<div class="col-sm-12">

						<span>&copy; Copyright 2017. <?php echo SITE_NAME;?> - Business Associates</span>

					</div>

				</div>

			</div>

			<!--footer end-->

		</section><!--end main content-->

	</div>

</div><!--end wrapper-->

<script type="text/javascript">
		
		function FeedBackForm(page_id="0")

		{	

			$('#feedbackModal').modal('show');

		}

		function FormFeedbackSave()
		{	

			var feedback= $('#user_feedback').val();

			if(feedback=='')
			{
				alert('Feedback field in empty');
				return false;			
			}

				var form_data = $('#FormFeedback').serialize();

				$.ajax({

					type: "POST",

					url: "ajax/remote.php",

					data: form_data,

					cache: false,

					success: function(result)

					{
						if(result==true)
						{
							alert('Thank You For Your Feedback/Suggestion!');
						}
						else
						{
							alert('Try later!');
						}
			    		location.reload();
					}

				});
		}


</script>
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
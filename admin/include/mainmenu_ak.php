<?php
//require('config/class.mysql.php');
?>
<table class="sidebox-border" border="0" width="100%" cellpadding="0" cellspacing="0">
<tbody>
	<tr>
		<td>
			<table border="0" width="100%" cellpadding="0" cellspacing="1">
			<tbody>
				<tr>
					<td style="background-image: url(images/sidebox_title_bg.gif);" class="sidebox-title-bg" height="24">
						<table style="cursor: pointer;" onClick="fn_switch_box('sidebox_blocks');" border="0" width="100%" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td>&nbsp;</td>
								<td><img src="images/sidebox_icon_home.gif" alt="" border="0" width="23" height="22"></td>
								<td class="sidebox-title" width="100%">&nbsp;Administration</td>
								<td style="padding-right: 5px;" align="right">
									<img id="img_open_sidebox_blocks" src="images/arrow_right.gif" style="display: none;" alt="" width="7" height="8">
									<img id="img_close_sidebox_blocks" src="images/arrow_down.gif" alt="" width="7" height="8">
								</td>
							</tr>
						</tbody>
						</table>
					</td>
				</tr>
				<tr id="sidebox_blocks">
					<td>
						<table border="0" width="100%" cellpadding="10" cellspacing="0">
						<tbody>
							<tr>
								<td class="sidebox-body">
									<ul>
                                      <?php for($i=0;$i<count($arr_menu_id);$i++)
  			  							 {    ?>
										<li><a href="index.php?mode=<?php echo $arr_menu_mode[$i]; ?>" class="sidebox-link"><?php echo $arr_menu_name[$i]; ?></a></li>
                                        <?php } ?>
										<!--<li><a href="index.php?mode=ngo_sliders" class="sidebox-link">Manage Ngo Sliders</a></li>
										<li><a href="index.php?mode=nature_sliders" class="sidebox-link">Manage Nature Sliders</a></li>-->
										<!-- <li><a href="index.php?mode=top_banner" class="sidebox-link">Manage Top Banner</a></li>-->
										<li><a href="index.php?mode=myaccount" class="sidebox-link">My Account</a></li>
										<li><a href="index.php?mode=change_password" class="sidebox-link">Change Password</a></li>
										<li><a href="index.php?mode=logout" class="sidebox-link">Logout</a></li>
									</ul>
								</td>
							</tr>
						</tbody>
						</table>
					</td>
				</tr>
			</tbody>
			</table>
		</td>
	</tr>
</tbody>
</table>
<br />
<br />
<br />
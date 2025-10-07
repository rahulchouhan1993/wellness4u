<?php

  list($arr_banner_id,$arr_page_id,$arr_page,$arr_position_id,$arr_banner,$arr_url,$arr_banner_type,$arr_position,$arr_side,$arr_width,$arr_height) = getbanners($page_id,'Right');
  
  //print_r($arr_width);
?>
                                                <?php
                                                /*
						if(isLoggedIn())
						{ 
							echo getWelcomeUserBoxCode($_SESSION['name'],$_SESSION['user_id']);
						?>
						<table width="160" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
						<?php
						}
                                                 * 
                                                 */
						?>
                        
                        <?php 
				for($i=0;$i<count($arr_banner_id);$i++)
					{
						 if($arr_banner[$i] != '') 
						 { ?>
						<table width="160" border="0" cellpadding="0" cellspacing="1">
							<tr>
								<td align="center" valign="middle" class="footer">
                               
								   <?php if($arr_banner_type[$i] == 'Flash') { ?>
                                <a href="<?php echo $arr_url[$i]; ?>" target="_blank"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>"><param name="movie" value="<?php echo SITE_URL."/uploads/".$arr_banner[$i];?>" /><param name="quality" value="high" /><embed src="<?php echo SITE_URL."/uploads/".$arr_banner[$i];?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>"></embed></object></a>
                                   <?php } elseif($arr_banner_type[$i] == 'Image') { ?>
                                   <a href="<?php echo $arr_url[$i]; ?>" target="_blank"><img src="<?php echo SITE_URL."/uploads/".$arr_banner[$i];?>" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>" border="0" /></a>
                                   <?php } elseif($arr_banner_type[$i] == 'Video') { 
                                   ?>
                                   <a href="<?php echo $arr_url[$i]; ?>" target="_blank"><iframe width="<?php echo $arr_width[$i]; ?>" height="<?php echo $arr_height[$i]; ?>" src="<?php echo getBannerString($arr_banner[$i]); ?>" frameborder="0" allowfullscreen></iframe></a>
                                   <?php } elseif($arr_banner_type[$i] == 'Google Ads') { 
                                            echo $arr_banner[$i];
                                              }
											  ?>
                                </td>
							</tr>
						</table>
                        <table width="160" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
                        <?php } 
						
						
					} ?>
                         
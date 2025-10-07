<?php
list($top_banner,$top_position,$top_height,$top_weight) = GetTopBanner();
list($arr_banner_id,$arr_page_id,$arr_page,$arr_position_id,$arr_banner,$arr_url,$arr_banner_type,$arr_position,$arr_side,$arr_width,$arr_height) = getbanners($page_id,'Top');

list($arr_banner_id_banner,$arr_page_id_banner,$arr_page_banner,$arr_position_id_banner,$arr_banner_banner,$arr_url_banner,$arr_banner_type_banner,$arr_position_banner,$arr_side_banner,$arr_width_banner,$arr_height_banner) = getbanners($page_id,'Banner');
	
//echo '<br><pre>';
//print_r($arr_banner_banner);
//echo '<br></pre>';
if(isset($arr_banner_banner[0]) && $arr_banner_banner[0] != '')
{
	$top_banner = $arr_banner_banner[0];
}	
?>
<table width="1000" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td width="10" background="images/left_body_back.jpg">&nbsp;</td>
    	<td width="980" align="center" valign="top"  background="images/top_back.jpg" style="background-repeat: repeat-x;" bgcolor="#FFFFFF">
        	<table width="960" border="0" cellspacing="0" cellpadding="0">
                <tr>
	                <td height="15"><img src="images/spacer.gif" width="1" height="1" /></td>
                </tr>
            </table>
            <table width="960" border="0" cellspacing="0" cellpadding="0">
                <tr>
                	<td width="184" height="100" align="center" valign="top"><img src="images/ww4u_logo.png" width="102" height="100" /></td>
                	<td width="776" height="100" align="left" valign="middle">
                		<table width="728" border="0" cellspacing="0" cellpadding="0">
                			<tr>
                				<td height="90">
							<?php 
                            for($i=0;$i<count($arr_banner_id);$i++)
                            {
                                if($arr_banner[$i] != '') 
                                { ?>
                                    <table width="728" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="728" align="center" valign="middle">
                                            <?php 
                                            if($arr_banner_type[$i] == 'Flash') 
                                            { ?>
                                                 <a href="<?php echo $url1; ?>" target="_blank"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>"><param name="movie" value="<?php echo SITE_URL."/uploads/".$arr_banner[$i];?>" /><param name="quality" value="high" /><embed src="<?php echo SITE_URL."/uploads/".$arr_banner[$i];?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>"></embed></object></a>
                                            <?php 
                                            }
                                            elseif($arr_banner_type[$i] == 'Image') 
                                            { ?>
                                                <a href="<?php echo $url1; ?>" target="_blank"><img src="<?php echo SITE_URL."/uploads/".$arr_banner[$i];?>" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>" border="0" /></a>
                                            <?php 
                                            }
                                            elseif($arr_banner_type[$i] == 'Video') 
                                            { ?>
                                                <a href="<?php echo $url1; ?>" target="_blank"><iframe width="<?php echo $arr_width[$i]; ?>" height="<?php echo $arr_height[$i]; ?>" src="<?php echo getBannerString($arr_banner[$i]); ?>" frameborder="0" allowfullscreen></iframe></a>
                                            <?php 
                                            }
                                            elseif($arr_banner_type[$i] == 'Google Ads') 
                                            {
                                                echo $arr_banner[$i];
                                            } ?>
                                            </td>
                                        </tr>
                                    </table>
                               <?php 
                               }
                            } ?>
                                
                                
                                
                                
                                </td>
                			</tr>
            			</table>
                 	</td>
                </tr>
          	</table>
            <table width="960" border="0" cellspacing="0" cellpadding="0">
                <tr>
                	<td height="45" align="center" valign="bottom">
                    	<table width="840" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="14" height="32" align="right" valign="top"><img border="0" src="images/left.jpg" width="14" height="32" /></td>
                                <td width="812" height="32" align="left" valign="middle">
                                    <table height="30px" bgcolor="#71706e" border="0" cellspacing="0" cellpadding="0" width="812">
                                        <tr>
                                            <td align="left" height="32">
                                                <div id="smoothmenu1" class="ddsmoothmenu">
                                                    <ul>
                                                <?php
												$arr_active_menu_items = getAllActiveMenuItems(0);
												if(count($arr_active_menu_items) > 0)
												{
													foreach($arr_active_menu_items as $key => $val  )
													{
														if($val['menu_details']['link_enable'] == '1')
														{ 
															$menu_link1 = $val['menu_details']['menu_link'];
															if($menu_link1 == '')
															{
																$menu_link1 = '#';
															}
														}
														else
														{
															$menu_link1 = '#';
														}	
													?>
														 <li style="border-right: 1px solid #333333;">
                                                         	<a href="<?php echo $menu_link1;?>"><?php echo $val['menu_details']['menu_title'];?></a>
														<?php
														if(count($val['submenu_details']) > 0)
														{ ?>
															<ul>
															<?php	
															foreach($val['submenu_details'][0] as $key2 => $val2  )
															{ 
																if($val2['menu_details']['link_enable'] == '1')
																{ 
																	$menu_link2 = $val2['menu_details']['menu_link'];
																	if($menu_link2 == '')
																	{
																		$menu_link2 = '#';
																	}
																}
																else
																{
																	$menu_link2 = '#';
																}	
															?>
																<li>
                                                                	<a href="<?php echo $menu_link2;?>"><?php echo $val2['menu_details']['menu_title'];?></a>
																	<?php
																	if(count($val2['submenu_details']) > 0)
																	{ ?>
																		<ul>
																		<?php	
																		foreach($val2['submenu_details'][0] as $key3 => $val3  )
																		{
																			if($val3['menu_details']['link_enable'] == '1')
																			{ 
																				$menu_link3 = $val3['menu_details']['menu_link'];
																				if($menu_link3 == '')
																				{
																					$menu_link3 = '#';
																				}
																			}
																			else
																			{
																				$menu_link3 = '#';
																			}	
																		 ?>
																			<li style="border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;">
                                                                            	<a href="<?php echo $menu_link3;?>"><?php echo $val3['menu_details']['menu_title'];?></a>
																			</li>
																		<?php
																		} ?>
																		</ul>
																	<?php    
																	} ?>
																</li>
															<?php
															} ?>
															</ul>
														<?php    
														} ?>
														</li>
													<?php
													} ?>
                                                <?php        
												} ?>
                                                	<?php
													if(isLoggedIn() || isLoggedInPro())
													{ ?>
                                                        <li><a href="logout.php">Logout</a></li>
													<?php
                                                    }
                                                    else
                                                    { ?>
                                                        <li><a href="login.php">Login&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
													<?php
                                                    } ?>
                                                	</ul>	
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="14" height="32" align="left" valign="top" ><img border="0" src="images/right.jpg" width="14" height="32" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table width="960" border="0" cellpadding="0" cellspacing="0">
            	<tr>
            		<td height="150" align="left" valign="top">
                    	<div class="imgtopbanner">
                            <span id="header_top_banner"><img border="0" src="<?php echo SITE_URL.'/uploads/'.$top_banner; ?>" width="960" height="150" /></span>
                            <div class="imgtoplogo">
                                <a href="<?php echo SITE_URL;?>"><img src="images/cwri_logo.png" width="127" height="105" border="0" /></a>                            
                            </div>
                            <?php /*?><div class="imgtopstrip">
                                <img src="images/top_banner.png" width="408" height="28" />
                            </div><?php */?>
                        </div>
                   	</td>
            	</tr>
            </table>
            <table width="960" border="0" cellspacing="0" cellpadding="0">
                <tr>
                	<td height="5" bgcolor="#DC214C"><img src="images/spacer.gif" width="1" height="1" /></td>
                </tr>
            </table>
            <table width="960" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="10"><img src="images/spacer.gif" width="1" height="1" /></td>
                </tr>
            </table>  
            <?php echo getScrollingBarCode($page_id)?>
            
<?php
function Make_Note_FavList_Details($ufs_id)
{
	global $link;
	$menu_title = ''; 
	$sc_id = ''; 
	$ufs_note = '';
	$ufs_cat_id = '0';
	$ufs_priority = '';    
	$ufs_add_date = '';    
		
	$sql = "SELECT TA.* , TS.menu_title FROM `tblusersfavscrolling` AS TA
			LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
			WHERE `ufs_id` = '".$ufs_id."' ";
	
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$menu_title = stripslashes($row['menu_title']);
		$sc_id = stripslashes($row['sc_id']);
		$ufs_note = stripslashes($row['ufs_note']);
		$ufs_cat_id = stripslashes($row['ufs_cat_id']);
		$ufs_priority = stripslashes($row['ufs_priority']);
		$ufs_add_date = stripslashes($row['ufs_add_date']);
	}
	return array($menu_title,$sc_id,$ufs_note,$ufs_cat_id,$ufs_priority,$ufs_add_date);
}

function Save_Note_FavList($ufs_id,$ufs_note,$ufs_cat_id,$ufs_priority)
{
	global $link;
	$return = false;
	$sql = "UPDATE `tblusersfavscrolling` SET `ufs_note` = '".addslashes($ufs_note)."' ,`ufs_priority` = '".addslashes($ufs_priority)."' , `ufs_cat_id` = '".addslashes($ufs_cat_id)."'   where ufs_id = '".$ufs_id."'";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if($result)
	{
		$return = true;	
	}
	return $return;	
}

function Make_Note_FavList($ufs_id,$page_id)
{
	list($menu_title,$sc_id,$ufs_note,$ufs_cat_id,$ufs_priority,$ufs_add_date) = Make_Note_FavList_Details($ufs_id);
	
			$output .='<table border="0" width="75%" cellpadding="0" cellspacing="0">
						<tr>
							 <td width="30%" height="40" align="right" valign="top">&nbsp;</td>
							 <td width="5%" height="40" align="center" valign="top">&nbsp;</td>
							 <td width="45%" height="40" align="left" valign="top">&nbsp;</td>
						</tr>
						<tr>
							 <td width="30%" height="40" align="right" valign="top"><strong>Page Name</strong></td>
							 <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>
							 <td width="45%" height="40" align="left" valign="top">'.$menu_title.'</td>
						</tr>';
			  $output .='<tr>
						   <td width="30%" height="40" align="right" valign="top"><strong>Note:</strong></td>
						   <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>
						   <td width="45%" height="40" align="left" valign="top"><textarea  cols="30" rows="5" type="text" id="note" name="note">'.$ufs_note.'</textarea></td>
					   </tr>';
					   
			$output .='<tr>
						   <td width="30%" height="40" align="right" valign="top"><strong>Category:</strong></td>
						   <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>
						   <td width="45%" height="40" align="left" valign="top">
								<select name="ufs_cat_id2" id="ufs_cat_id2" style="width:200px;">
								<option value="0">Select Category</option>'.getFavCategoryOptions($ufs_cat_id).'
								</select> 
							</td>';	
							
						if($ufs_priority == '1')
						{
							$sel_no = '';
							$sel_yes = ' selected ';
						}
						else
						{
							$sel_no = ' selected ';
							$sel_yes = '';
						}	
							
			$output .='<tr>
						   <td width="30%" height="40" align="right" valign="top"><strong>Priority:</strong></td>
						   <td width="5%" height="40" align="center" valign="top"><strong>:</strong></td>
						   <td width="45%" height="40" align="left" valign="top">
								<select name="ufs_priority" id="ufs_priority" style="width:200px;">
									<option value="0" '.$sel_no.'>No</option>
									<option value="1" '.$sel_yes.'>Yes</option>
								</select> 
							</td>';					
					   
			  $output .='<tr>
							 <td width="30%" height="20" align="right" valign="top">&nbsp;</td>
							 <td width="5%" height="20" align="center" valign="top">&nbsp;</td>
							 <td width="45%" height="20" align="left" valign="top">&nbsp;</td>
						</tr>
						<tr>
						    <td width="30%" height="20" align="right" valign="top">&nbsp;</td>
						    <td width="5%" height="20" align="center" valign="top">&nbsp;</td>
						    <td width="45%" height="20" align="left" valign="top"><input class="btnNote" name="btnNote" id="btnNote"  type="button" value="Save" onclick="Save_Note_FavList('.$ufs_id.')" />
					   </tr>';
			$output .='</table>';
	 
	return $output;
}

function search_myfavlist($user_id,$page_id,$start_date,$end_date,$ufs_cat_id)
{	
    list($arr_ufs_id,$arr_page_id,$arr_menu_title,$arr_sc_id,$arr_ufs_note,$arr_ufs_cat_id,$arr_ufs_cat,$arr_ufs_priority,$arr_ufs_add_date,$arr_user_name,$arr_ufs_type) = GetMyFavListDetails($user_id,$page_id,$start_date,$end_date,$ufs_cat_id);
		
    $output .='<table width="790" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
                    <tr>
                        <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr No</strong></td>
                        <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Page Name</strong></td>
                        <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Window Title</strong></td>
                        <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Slider Title</strong></td>
                        <td width="15%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Content</strong></td>
                        <td width="15%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Note</strong></td>
                        <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Category</strong></td>
                        <td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Priority</strong></td>
                        <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Date</strong></td>
                        <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Make Note</strong></td>
                        <td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Delete</strong></td>
                    </tr>';
    if(count($arr_ufs_id) > 0)	
    {
        for($i=0,$j=1;$i<count($arr_ufs_id);$i++,$j++)
        {
            if($arr_ufs_type[$i] == '1')
            {
                $sw_header = '';
                list($sc_title,$sc_content_type,$sc_content,$box_desc,$credit_line,$credit_line_url,$rss_feed_item_id)  = getSolutionItemDetails($arr_sc_id[$i]);
                if($sc_content_type == 'Flash') { 
                    $str_content = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="50" ><param name="movie" value="'.SITE_URL."/uploads/".$sc_content.'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'.SITE_URL."/uploads/".$sc_content.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="50"  wmode="transparent"></embed></object>';
                } elseif($sc_content_type == 'Image') { 
                    $str_content = '<img src="'.SITE_URL."/uploads/".$sc_content.'" width="50" height="50" border="0" />';
                } elseif($sc_content_type == 'Video') { 
                    $str_content = '<iframe width="50" src="'.getSressBusterBannerString($sc_content).'" frameborder="0" allowfullscreen></iframe>';
                } elseif($sc_content_type == 'Audio') { 
                    $str_content = '<embed type="application/x-shockwave-flash" flashvars="audioUrl='.SITE_URL."/uploads/".$sc_content.'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="50" height="50" quality="best"  wmode="transparent"></embed>';
                } elseif($sc_content_type == 'Pdf') { 
                    $str_content = '<a href="'.SITE_URL."/uploads/".$sc_content.'" target="_blank">'.$sc_title.'</a>';   
                } elseif($sc_content_type == 'rss') { 
                    list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = getRssFeedItemDetails($rss_feed_item_id);
                    $str_content .= '<a href="'.$rss_feed_item_link.'" target="_blank">'.$rss_feed_item_title.'</a>';   
                } elseif($sc_content_type == 'text') { 
                    $str_content .= $box_desc;   
                }         
            }
            else
            {
                list($sw_header,$sc_title,$sc_content_type,$sc_content,$sc_image,$sc_video,$sc_flash,$rss_feed_item_id)  = getScrollingContentDetailsForFavList($arr_sc_id[$i]);
                if($sc_content_type == 'image' )
                {
                    $str_content = '<img border="0" width="50" src="'.SITE_URL.'/uploads/'.$sc_image.'" >';
                }
                elseif($sc_content_type == 'video' )
                {
                    $str_content = '<iframe width="50" height="50" src="'.getBannerString($sc_video).'" frameborder="0" allowfullscreen></iframe>';
                }
                elseif($sc_content_type == 'flash' )
                {
                    $str_content = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="50" height="50"><param name="movie" value="'.SITE_URL."/uploads/".$sc_flash.'" /><param name="quality" value="high" /><embed src="'.SITE_URL."/uploads/".$sc_flash.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="50" height="50"></embed></object>';
                }
                elseif($sc_content_type == 'rss' )
                {
                    list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = getRssFeedItemDetails($rss_feed_item_id);
                    $str_content = $rss_feed_item_title;
                }
                else
                {
                    $str_content = $sc_content;
                }
            }
						
            $date = date('d-M-Y',strtotime($arr_ufs_add_date[$i]));

            if($arr_ufs_priority[$i] == '1' )
            {
                    $priority = 'Yes';
            }
            else
            {
                    $priority = 'No';
            }

            //if($arr_ufs_cat_id[$i] > 0)
            //{
                    $ufs_cat = $arr_ufs_cat[$i];
            //}
            //else
            //{
                    //$ufs_cat = '';
            //}					
											
							
		$output .= '	<tr>
                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$j.'</td>
                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$arr_menu_title[$i].'</td>
                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$sw_header.'</td>
                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$sc_title.'</td>
                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$str_content.'</td>
                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$arr_ufs_note[$i].'</td>
                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$ufs_cat.'</td>
                                    <td  align="center" valign="top" bgcolor="#FFFFFF">'.$priority.'</td>
                                    <td  align="center" class="footer" valign="top" bgcolor="#FFFFFF">'. $date .'</td>
                                    <td  align="center" valign="top" bgcolor="#FFFFFF" class="footer">';
		$output .= '            <input class="btnNote" name="btnNote" id="btnNote"  type="button" value="Note" onclick="MakeNoteForFavList(\''.$arr_ufs_id[$i].'\',\''.$arr_page_id[$i].'\')"/></td>';
		$output .= '        <td  align="center" valign="top" bgcolor="#FFFFFF" class="footer">
					<input  type="button" value="Delete"  onclick="Delete_MyFavItem(\''.$arr_ufs_id[$i].'\')"/>
                                    </td>
				</tr>';
        }
    }
    else
    {
    $output .= '	<tr style="background:#FFFFFF;"><td align="center" colspan="11">No Record Found</td></tr>';	   
    }
    $output .= '</table>';
    return $output;
}

function viewUserFavList($user_id,$page_id,$start_date,$end_date,$ufs_cat_id)
  	{	
		list($arr_ufs_id,$arr_page_id,$arr_menu_title,$arr_sc_id,$arr_ufs_note,$arr_ufs_cat_id,$arr_ufs_cat,$arr_ufs_priority,$arr_ufs_add_date,$arr_user_name,$arr_ufs_type) = GetMyFavListDetails($user_id,$page_id,$start_date,$end_date,$ufs_cat_id);
		
         $output .='<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
						<tr>
							<td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Sr No</strong></td>
							<td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>User</strong></td>
							<td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Page Name</strong></td>
							<td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Window Title</strong></td>
							<td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Slider Title</strong></td>
							<td width="15%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Content</strong></td>
							<td width="15%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Note</strong></td>
							<td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Category</strong></td>
							<td width="10%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Priority</strong></td>
							<td width="5%"  align="center" valign="middle" bgcolor="#FFFFFF"><strong>Date</strong></td>
							
						</tr>';
				if(count($arr_ufs_id) > 0)	
				{
					for($i=0,$j=1;$i<count($arr_ufs_id);$i++,$j++)
					{ 
						if($arr_ufs_type[$i] == '1')
                                                {
                                                    $sw_header = '';
                                                    list($sc_title,$sc_content_type,$sc_content,$box_desc,$credit_line,$credit_line_url,$rss_feed_item_id)  = getSolutionItemDetails($arr_sc_id[$i]);
                                                    if($sc_content_type == 'Flash') { 
                                                        $str_content = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="50" ><param name="movie" value="'.SITE_URL."/uploads/".$sc_content.'" /> <param name="wmode" value="transparent" /><param name="quality" value="high" /><embed src="'.SITE_URL."/uploads/".$sc_content.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="50"  wmode="transparent"></embed></object>';
                                                    } elseif($sc_content_type == 'Image') { 
                                                        $str_content = '<img src="'.SITE_URL."/uploads/".$sc_content.'" width="50" height="50" border="0" />';
                                                    } elseif($sc_content_type == 'Video') { 
                                                        $str_content = '<iframe width="50" src="'.getSressBusterBannerString($sc_content).'" frameborder="0" allowfullscreen></iframe>';
                                                    } elseif($sc_content_type == 'Audio') { 
                                                        $str_content = '<embed type="application/x-shockwave-flash" flashvars="audioUrl='.SITE_URL."/uploads/".$sc_content.'" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="50" height="50" quality="best"  wmode="transparent"></embed>';
                                                    } elseif($sc_content_type == 'Pdf') { 
                                                        $str_content = '<a href="'.SITE_URL."/uploads/".$sc_content.'" target="_blank">'.$sc_title.'</a>';   
                                                    } elseif($sc_content_type == 'rss') { 
                                                        list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = getRssFeedItemDetails($rss_feed_item_id);
                                                        $str_content = '<a href="'.$rss_feed_item_link.'" target="_blank">'.$rss_feed_item_title.'</a>';   
                                                    } elseif($sc_content_type == 'text') { 
                                                        $str_content .= $box_desc;   
                                                    }       
                                                }
                                                else
                                                {
                                                    list($sw_header,$sc_title,$sc_content_type,$sc_content,$sc_image,$sc_video,$sc_flash,$rss_feed_item_id)  = getScrollingContentDetailsForFavList($arr_sc_id[$i]);
                                                    if($sc_content_type == 'image' )
                                                    {
                                                        $str_content = '<img border="0" width="50" src="'.SITE_URL.'/uploads/'.$sc_image.'" >';
                                                    }
                                                    elseif($sc_content_type == 'video' )
                                                    {
                                                        $str_content = '<iframe width="50" height="50" src="'.getBannerString($sc_video).'" frameborder="0" allowfullscreen></iframe>';
                                                    }
                                                    elseif($sc_content_type == 'flash' )
                                                    {
                                                        $str_content = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="50" height="50"><param name="movie" value="'.SITE_URL."/uploads/".$sc_flash.'" /><param name="quality" value="high" /><embed src="'.SITE_URL."/uploads/".$sc_flash.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="50" height="50"></embed></object>';
                                                    }
                                                    elseif($sc_content_type == 'rss' )
                                                    {
                                                        list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = getRssFeedItemDetails($rss_feed_item_id);
                                                        $str_content = $rss_feed_item_title;
                                                    }
                                                    else
                                                    {
                                                        $str_content = $sc_content;
                                                    }
                                                }
						
						
						$date = date('d-M-Y',strtotime($arr_ufs_add_date[$i]));
						
						if($arr_ufs_priority[$i] == '1' )
						{
							$priority = 'Yes';
						}
						else
						{
							$priority = 'No';
						}
						
						//if($arr_ufs_cat_id[$i] > 0)
						//{
							$ufs_cat = $arr_ufs_cat[$i];
						//}
						//else
						//{
							//$ufs_cat = '';
						//}					
											
							
		$output .= '	<tr>
							<td  align="center" valign="top" bgcolor="#FFFFFF">'.$j.'</td>
							<td  align="center" valign="top" bgcolor="#FFFFFF">'.$arr_user_name[$i].'</td>
							<td  align="center" valign="top" bgcolor="#FFFFFF">'.$arr_menu_title[$i].'</td>
							<td  align="center" valign="top" bgcolor="#FFFFFF">'.$sw_header.'</td>
							<td  align="center" valign="top" bgcolor="#FFFFFF">'.$sc_title.'</td>
							<td  align="center" valign="top" bgcolor="#FFFFFF">'.$str_content.'</td>
							<td  align="center" valign="top" bgcolor="#FFFFFF">'.$arr_ufs_note[$i].'</td>
							<td  align="center" valign="top" bgcolor="#FFFFFF">'.$ufs_cat.'</td>
							<td  align="center" valign="top" bgcolor="#FFFFFF">'.$priority.'</td>
							<td  align="center" class="footer" valign="top" bgcolor="#FFFFFF">'. $date .'</td>
					   </tr>';
					}
				}
				else
				{
		$output .= '	<tr style="background:#FFFFFF;"><td align="center" colspan="10">No Record Found</td></tr>';	   
				}
		$output .= '</table>';
	 
	return $output;
}

function chkIfScrollingWindowActivateForPage($page_id)
{
	global $link;
	
	$return = false;
	
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."' AND `show_in_manage_menu` = '1' AND `show_in_list` = '1' AND `adviser_panel` = '0' AND `vender_panel` = '0'";
	//echo'<br><br>sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		$return = true;
	}
	
	return $return;
}
function getUserRegistrationTimestamp($user_id)
{
	global $link;
	
	$user_add_date = '';
	
	$sql = "SELECT * FROM `tblusers` WHERE `user_id` = '".$user_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result);
		$user_add_date = stripslashes($row['user_add_date']);
	}
	return $user_add_date;
}
function getMenuTitleOfPage($page_id)
{
	global $link;
	
	$menu_title = '';
	
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result);
		$menu_title = stripslashes($row['menu_title']);
	}
	return $menu_title;

}
function getRewardConversionValue($reward_module_id,$start_date,$end_date)
{
	global $link;
	$value = '0';
	
	
	$sql = "SELECT * FROM `tblrewardpoints` WHERE `reward_point_deleted` = '0' AND `reward_point_status` = '1'  AND `reward_point_module_id` = '".$reward_module_id."' AND EXTRACT(YEAR_MONTH FROM reward_point_date) <= '".date('Ym',strtotime($start_date))."' ORDER BY `reward_point_date` DESC LIMIT 1";
	//echo '<br>'.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result); 
		$reward_point_cutoff_type_id = $row['reward_point_cutoff_type_id'];
		$value = stripslashes($row['reward_point_conversion_value']);
		if($reward_point_cutoff_type_id > 0)
		{
	
		}		
	}
	return $value;	
}
function getTotalEncashedPointsOfModule($reward_module_id,$start_date,$end_date,$user_id)
{
	global $link;
	$value = 0;
	
	$sql = "SELECT * FROM `tblrewardredeamed` WHERE DATE(redeam_date) >= '".$start_date."' AND DATE(redeam_date) <= '".$end_date."' AND `reward_module_id` = '".$reward_module_id."' AND `user_id` = '".$user_id."' ORDER BY `redeam_date` DESC ";
	//echo'<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while ($row = mysql_fetch_assoc($result)) 
		{
			$value += $row['encashed_points'];
		}	
	}
	
	return $value;
}
function getTotalEntriesOfModule($reward_module_id,$start_date,$end_date,$user_id)
{
	global $link;
	$value = '0';
	
	if($user_id != '')
	{
		$str_user_id = " AND user_id = '".$user_id."' ";	
	}
	else
	{
		$str_user_id = "";	
	}
	
	//echo '<br>Testkk: reward_module_id = '.$reward_module_id;
	if($reward_module_id == '1')
	{
		$sql = "SELECT * FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'breakfast' ".$str_user_id." ORDER BY `meal_date` ASC ";
	}
	elseif($reward_module_id == '2')
	{
		$sql = "SELECT * FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'brunch' ".$str_user_id." ORDER BY `meal_date` ASC ";
	}
	elseif($reward_module_id == '3')
	{
		$sql = "SELECT * FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'lunch' ".$str_user_id." ORDER BY `meal_date` ASC ";
	}
	elseif($reward_module_id == '4')
	{
		$sql = "SELECT * FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'snacks' ".$str_user_id." ORDER BY `meal_date` ASC ";
	}
	elseif($reward_module_id == '5')
	{
		$sql = "SELECT * FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'dinner' ".$str_user_id." ORDER BY `meal_date` ASC ";
	}
	elseif($reward_module_id == '6')
	{
		$sql = "SELECT * FROM `tblusersdailyactivity` WHERE `activity_date` >= '".$start_date."' AND `activity_date` <= '".$end_date."' ".$str_user_id." ORDER BY `activity_date` ASC ";
	}
	elseif($reward_module_id == '7')
	{
		$sql = "SELECT * FROM `tbluserswae` WHERE `wae_date` >= '".$start_date."' AND `wae_date` <= '".$end_date."' ".$str_user_id." AND `wae_old_data` = '0'  ORDER BY `wae_date` ASC ";
	}
	elseif($reward_module_id == '8')
	{
		$sql = "SELECT * FROM `tblusersgs` WHERE `gs_date` >= '".$start_date."' AND `gs_date` <= '".$end_date."' ".$str_user_id." AND `gs_old_data` = '0' ORDER BY `gs_date` ASC ";
	}
	elseif($reward_module_id == '9')
	{
		$sql = "SELECT * FROM `tbluserssleep` WHERE `sleep_date` >= '".$start_date."' AND `sleep_date` <= '".$end_date."' ".$str_user_id." AND `sleep_old_data` = '0'  ORDER BY `sleep_date` ASC ";
	}
	elseif($reward_module_id == '10')
	{
		$sql = "SELECT * FROM `tblusersmc` WHERE `mc_date` >= '".$start_date."' AND `mc_date` <= '".$end_date."' ".$str_user_id." AND `mc_old_data` = '0'  ORDER BY `mc_date` ASC ";
	}
	elseif($reward_module_id == '11')
	{
		$sql = "SELECT * FROM `tblusersmr` WHERE `mr_date` >= '".$start_date."' AND `mr_date` <= '".$end_date."' ".$str_user_id." AND `mr_old_data` = '0'  ORDER BY `mr_date` ASC ";
	}
	elseif($reward_module_id == '12')
	{
		$sql = "SELECT * FROM `tblusersmle` WHERE `mle_date` >= '".$start_date."' AND `mle_date` <= '".$end_date."' ".$str_user_id." AND `mle_old_data` = '0'  ORDER BY `mle_date` ASC ";
	}
	elseif($reward_module_id == '13')
	{
		$sql = "SELECT * FROM `tblusersadct` WHERE `adct_date` >= '".$start_date."' AND `adct_date` <= '".$end_date."' ".$str_user_id." AND `adct_old_data` = '0'  ORDER BY `adct_date` ASC ";
	}
	elseif($reward_module_id == '14')
	{
		$sql = "SELECT * FROM `tblfeedback` WHERE DATE(feedback_add_date) >= '".$start_date."' AND DATE(feedback_add_date) <= '".$end_date."' ".$str_user_id." ORDER BY `feedback_add_date` ASC ";
	}
	elseif($reward_module_id == '16')
	{
		$sql = "SELECT * FROM `tblreferal` WHERE DATE(add_date) >= '".$start_date."' AND DATE(add_date) <= '".$end_date."' ".$str_user_id." ORDER BY `add_date` ASC ";
	}
        elseif($reward_module_id == '17')
	{
		$sql = "SELECT * FROM `tblusersbps` WHERE `bps_date` >= '".$start_date."' AND `bps_date` <= '".$end_date."' ".$str_user_id." AND `bps_old_data` = '0'   ORDER BY `bps_date` ASC ";
	}
        elseif($reward_module_id == '18')
        {
                $sql = "SELECT * FROM `tblusersmdt` WHERE `mdt_date` >= '".$start_date."' AND `mdt_date` <= '".$end_date."' ".$str_user_id." AND `mdt_old_data` = '0' AND `bms_entry_type` = 'situation'  ORDER BY `mdt_date` ASC ";
        }
	else
	{
		$sql = '';
	}
	//echo'<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		$value = mysql_num_rows($result);
	}
	return $value;
}
function getTotalNoOfDaysOfEntries($reward_module_id,$start_date,$end_date,$user_id)
{
	global $link;
	$value = '0';
	
	if($user_id != '')
	{
		$str_user_id = " AND user_id = '".$user_id."' ";	
	}
	else
	{
		$str_user_id = "";	
	}
	
	if($reward_module_id == '1')
	{
		$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'breakfast' ".$str_user_id." ORDER BY `meal_date` ASC ";
	}
	elseif($reward_module_id == '2')
	{
		$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'brunch' ".$str_user_id." ORDER BY `meal_date` ASC ";
	}
	elseif($reward_module_id == '3')
	{
		$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'lunch' ".$str_user_id." ORDER BY `meal_date` ASC ";
	}
	elseif($reward_module_id == '4')
	{
		$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'snacks' ".$str_user_id." ORDER BY `meal_date` ASC ";
	}
	elseif($reward_module_id == '5')
	{
		$sql = "SELECT DISTINCT `meal_date` FROM `tblusersmeals` WHERE `meal_date` >= '".$start_date."' AND `meal_date` <= '".$end_date."' AND `meal_type` = 'dinner' ".$str_user_id." ORDER BY `meal_date` ASC ";
	}
	elseif($reward_module_id == '6')
	{
		$sql = "SELECT DISTINCT `activity_date` FROM `tblusersdailyactivity` WHERE `activity_date` >= '".$start_date."' AND `activity_date` <= '".$end_date."' ".$str_user_id." ORDER BY `activity_date` ASC ";
	}
	elseif($reward_module_id == '7')
	{
		$sql = "SELECT DISTINCT `wae_date` FROM `tbluserswae` WHERE `wae_date` >= '".$start_date."' AND `wae_date` <= '".$end_date."' ".$str_user_id."  AND `wae_old_data` = '0'  ORDER BY `wae_date` ASC ";
	}
	elseif($reward_module_id == '8')
	{
		$sql = "SELECT DISTINCT `gs_date` FROM `tblusersgs` WHERE `gs_date` >= '".$start_date."' AND `gs_date` <= '".$end_date."' ".$str_user_id." AND `gs_old_data` = '0' ORDER BY `gs_date` ASC ";
	}
	elseif($reward_module_id == '9')
	{
		$sql = "SELECT DISTINCT `sleep_date` FROM `tbluserssleep` WHERE `sleep_date` >= '".$start_date."' AND `sleep_date` <= '".$end_date."' ".$str_user_id." AND `sleep_old_data` = '0'  ORDER BY `sleep_date` ASC ";
	}
	elseif($reward_module_id == '10')
	{
		$sql = "SELECT DISTINCT `mc_date` FROM `tblusersmc` WHERE `mc_date` >= '".$start_date."' AND `mc_date` <= '".$end_date."' ".$str_user_id." AND `mc_old_data` = '0'  ORDER BY `mc_date` ASC ";
	}
	elseif($reward_module_id == '11')
	{
		$sql = "SELECT DISTINCT `mr_date` FROM `tblusersmr` WHERE `mr_date` >= '".$start_date."' AND `mr_date` <= '".$end_date."' ".$str_user_id." AND `mr_old_data` = '0'  ORDER BY `mr_date` ASC ";
	}
	elseif($reward_module_id == '12')
	{
		$sql = "SELECT DISTINCT `mle_date` FROM `tblusersmle` WHERE `mle_date` >= '".$start_date."' AND `mle_date` <= '".$end_date."' ".$str_user_id." AND `mle_old_data` = '0'  ORDER BY `mle_date` ASC ";
	}
	elseif($reward_module_id == '13')
	{
		$sql = "SELECT DISTINCT `adct_date` FROM `tblusersadct` WHERE `adct_date` >= '".$start_date."' AND `adct_date` <= '".$end_date."' ".$str_user_id." AND `adct_old_data` = '0'  ORDER BY `adct_date` ASC ";
	}
	elseif($reward_module_id == '14')
	{
		$sql = "SELECT DISTINCT DATE(feedback_add_date) FROM `tblfeedback` WHERE DATE(feedback_add_date) >= '".$start_date."' AND DATE(feedback_add_date) <= '".$end_date."' ".$str_user_id." ORDER BY `feedback_add_date` ASC ";
	}
	elseif($reward_module_id == '16')
	{
		$sql = "SELECT DISTINCT DATE(add_date) FROM `tblreferal` WHERE DATE(add_date) >= '".$start_date."' AND DATE(add_date) <= '".$end_date."' ".$str_user_id." ORDER BY `add_date` ASC ";
	}
        elseif($reward_module_id == '17')
	{
		$sql = "SELECT DISTINCT `bps_date` FROM `tblusersbps` WHERE `bps_date` >= '".$start_date."' AND `bps_date` <= '".$end_date."' ".$str_user_id." AND `bps_old_data` = '0' ORDER BY `bps_date` ASC ";
	}
        elseif($reward_module_id == '18')
        {
                $sql = "SELECT DISTINCT `mdt_date` FROM `tblusersmdt` WHERE `mdt_date` >= '".$start_date."' AND `mdt_date` <= '".$end_date."' ".$str_user_id." AND `mdt_old_data` = '0' AND `bms_entry_type` = 'situation'  ORDER BY `mdt_date` ASC ";
        }
	else
	{
		$sql = '';
	}
	//echo'<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		$value = mysql_num_rows($result);
	}
	return $value;
}
function getTotalBonusPointsOfEntries($reward_module_id,$start_date,$end_date,$user_id)
{
	global $link;
	$value = '0';
	
	return $value;
}

function getMonthsListBetweenTwoDates($start_date,$end_date)
{
	$arr_start_month_day = array();
	$arr_end_month_day = array();
	
	if($start_date != '' && $end_date != '')
	{
		$start    = new DateTime($start_date);
		$start->modify('first day of this month');
		$end      = new DateTime($end_date);
		$end->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);
		
		foreach ($period as $dt)
		{
			//echo $dt->format("Y-m") . "<br>\n";
			array_push($arr_start_month_day , $dt->format("Y-m-01"));
			array_push($arr_end_month_day , $dt->format("Y-m-t"));
		}
		
		$arr_start_month_day = array_reverse($arr_start_month_day);
		$arr_end_month_day = array_reverse($arr_end_month_day);

	}	
	
	return array($arr_start_month_day,$arr_end_month_day);
}

function getMyRewardsChart($user_id,$start_date,$end_date)
{
	global $link;
	$return = false;
	$arr_reward_modules = array();
	$arr_reward_summary = array();
	
	//echo'<br>Testkk start_date = '.$start_date;
	//echo'<br>Testkk end_date = '.$end_date;
	
	list($arr_start_month_day,$arr_end_month_day) = getMonthsListBetweenTwoDates($start_date,$end_date);
	
	if(count($arr_start_month_day) > 0)
	{
		for($k=0;$k<count($arr_start_month_day);$k++)
		{
			$sql = "SELECT * FROM `tblrewardmodules` WHERE `reward_module_deleted` = '0' AND `reward_module_status` = '1'  AND `show_in_report` = '1' ORDER BY `listing_order` ASC ";
			$result = mysql_query($sql,$link);
			if( ($result) && (mysql_num_rows($result) > 0) )
			{
				$return = true;
				
				
				
				$i = 0;
				$arr_reward_modules[$arr_start_month_day[$k]]['total_reward_conversion_value'] = 0;
				$arr_reward_modules[$arr_start_month_day[$k]]['total_total_entries'] = 0;
				$arr_reward_modules[$arr_start_month_day[$k]]['total_points_from_entry'] = 0;
				$arr_reward_modules[$arr_start_month_day[$k]]['total_no_of_days_posted'] = 0;
				$arr_reward_modules[$arr_start_month_day[$k]]['total_bonus_points'] = 0;
				$arr_reward_modules[$arr_start_month_day[$k]]['total_total_points'] = 0;
				$arr_reward_modules[$arr_start_month_day[$k]]['total_encashed_points'] = 0;
				$arr_reward_modules[$arr_start_month_day[$k]]['total_balance_points'] = 0;
				
				while ($row = mysql_fetch_assoc($result)) 
				{
					if($row['page_id'] == '0')
					{
						$title = stripslashes($row['reward_module_title']);
					}
					else
					{
						$title = getMenuTitleOfPage($row['page_id']);
						if($title == '')
						{
							$title = stripslashes($row['reward_module_title']);
						}
					}
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_module_id'] = $row['reward_module_id'];
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_module_title'] = $title;	
					
					$arr_reward_summary[$row['reward_module_id']]['summary_reward_module_title'] = $title;
					
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_conversion_value'] = getRewardConversionValue($row['reward_module_id'],$arr_start_month_day[$k],$arr_end_month_day[$k]);
					$arr_reward_modules[$arr_start_month_day[$k]]['total_reward_conversion_value'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_conversion_value'];
					
					
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_entries'] = getTotalEntriesOfModule($row['reward_module_id'],$arr_start_month_day[$k],$arr_end_month_day[$k],$user_id);
					
					$arr_reward_modules[$arr_start_month_day[$k]]['total_total_entries'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_entries'];
					
					$arr_reward_summary[$row['reward_module_id']]['summary_total_entries'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_entries'];
					
					
					
					
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_module_id'] = $row['reward_module_id'];	
					
					
					if($arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_conversion_value'] == '' || $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_conversion_value'] == '0')
					{
						$points_from_entry = '0';
					}
					else
					{
						$points_from_entry = round($arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_entries'] / $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['reward_conversion_value'],2);
					}
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['points_from_entry'] = $points_from_entry;
					$arr_reward_modules[$arr_start_month_day[$k]]['total_points_from_entry'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['points_from_entry'];
					
					$arr_reward_summary[$row['reward_module_id']]['summary_points_from_entry'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['points_from_entry'];
					
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['no_of_days_posted'] = getTotalNoOfDaysOfEntries($row['reward_module_id'],$arr_start_month_day[$k],$arr_end_month_day[$k],$user_id);
					$arr_reward_modules[$arr_start_month_day[$k]]['total_no_of_days_posted'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['no_of_days_posted'];
					
					$arr_reward_summary[$row['reward_module_id']]['summary_no_of_days_posted'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['no_of_days_posted'];
					
					
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['bonus_points'] = getTotalBonusPointsOfEntries($row['reward_module_id'],$arr_start_month_day[$k],$arr_end_month_day[$k],$user_id);
					$arr_reward_modules[$arr_start_month_day[$k]]['total_bonus_points'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['bonus_points'];
					
					$arr_reward_summary[$row['reward_module_id']]['summary_bonus_points'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['bonus_points'];
					
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_points'] = $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['points_from_entry'] + $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['bonus_points'];
					$arr_reward_modules[$arr_start_month_day[$k]]['total_total_points'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_points'];
					
					$arr_reward_summary[$row['reward_module_id']]['summary_total_points'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_points'];
					
					$encashed_points = getTotalEncashedPointsOfModule($row['reward_module_id'],$arr_start_month_day[$k],$arr_end_month_day[$k],$user_id);
					
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['encashed_points'] = $encashed_points;
					$arr_reward_modules[$arr_start_month_day[$k]]['total_encashed_points'] += $encashed_points;
					
					$arr_reward_summary[$row['reward_module_id']]['summary_total_encashed_points'] +=  $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['encashed_points'];
					
					$arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['balance_points'] = $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['total_points'] - $encashed_points;
					$arr_reward_modules[$arr_start_month_day[$k]]['total_balance_points'] += $arr_reward_modules[$arr_start_month_day[$k]]['records'][$i]['balance_points'];
					
					$arr_reward_summary[$row['reward_module_id']]['summary_total_balance_points'] =  $arr_reward_summary[$row['reward_module_id']]['summary_total_points'] - $arr_reward_summary[$row['reward_module_id']]['summary_total_encashed_points'];
					
					$i++;
					
					
				}
			}
		}	
	}	
	return array($return,$arr_reward_modules,$arr_reward_summary);
}
function getDateArrayBetweenTwoDates($start_date,$end_date)
{
	$arr_date = array();
	$start    = new DateTime($start_date);
	//$start->modify('first day of this month');
	$end      = new DateTime($end_date);
	//$end->modify('first day of next month');
	$interval = DateInterval::createFromDateString('1 day');
	$period   = new DatePeriod($start, $interval, $end);
	
	foreach ($period as $dt)
	{
		//echo $dt->format("Y-m-d") ."<br>\n";
		array_push($arr_date , $dt->format("Y-m-d"));
	}
	return $arr_date;
}	
function getDayArrayBetweenTwoDates($start_date,$end_date)
{
	$arr_day = array();
	$start    = new DateTime($start_date);
	//$start->modify('first day of this month');
	$end      = new DateTime($end_date);
	//$end->modify('first day of next month');
	$interval = DateInterval::createFromDateString('1 day');
	$period   = new DatePeriod($start, $interval, $end);
	
	foreach ($period as $dt)
	{
		//echo $dt->format("Y-m-d") ."<br>\n";
		array_push($arr_day , $dt->format("d"));
	}
	return $arr_date;
}	

function getYoutubeString($banner)
{
	$search = 'v=';
	$pos = strpos($banner, $search);
	$str = strlen($banner);
	$rest = substr($banner, $pos+2, $str);
	return 'http://www.youtube.com/embed/'.$rest;
}

function showRewardCatlog($reward_list_module_id)
{
	global $link;
	$output = '';
	$output .= '<div style="float:left; padding-left:10px; margin-top:15px; clear:both;">
					 <strong>Particulars:</strong> <select id="tempreward_list_module_id" name="tempreward_list_module_id" style="width:200px;" onchange="showRewardCatlogUpdated()">
						<option value="">All Particulars</option>
						'.getRewardModuleOptions($reward_list_module_id).'
					</select>
				</div>';
	$output .= '<div style="float:left;padding-left:10px;margin-top:15px;width:550px;height:300px;overflow:scroll;">';
	$output .= '	<table width="530" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
					<tbody>
						<tr>
							<td width="10%" height="30" align="center" valign="middle"><strong>SNo</strong></td>
							<td width="20%" height="30" align="center" valign="middle"><strong>Particular</strong></td>
							<td width="20%" height="30" align="center" valign="middle"><strong>Total Points</strong></td>
							<td width="50%" height="30" align="center" valign="middle"><strong>Rewards</strong></td>
						</tr>';
	if($reward_list_module_id == '')
	{	
		$sql_str_rlmd = "";
	}
	else
	{
		$sql_str_rlmd = " AND rp.reward_list_module_id = '".$reward_list_module_id."' ";
	}				
						
	$sql = "SELECT rp.* , rm.reward_module_title , rc.reward_criteria_title AS reward_list_conversion_title , rc2.reward_criteria_title AS reward_list_cutoff_title FROM `tblrewardlist` AS rp LEFT JOIN `tblrewardmodules` AS rm ON rp.reward_list_module_id = rm.reward_module_id LEFT JOIN `tblrewardcriteria` AS rc ON rp.reward_list_conversion_type_id = rc.reward_criteria_id LEFT JOIN `tblrewardcriteria` AS rc2 ON rp.reward_list_cutoff_type_id = rc2.reward_criteria_id WHERE rp.reward_list_status = '1' AND rp.reward_list_deleted = '0' AND rm.reward_module_deleted = '0' ".$sql_str_rlmd." ORDER BY rp.reward_list_date DESC , rm.reward_module_title ASC ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$j = 1;
		while ($row = mysql_fetch_assoc($result)) 
		{
			$reward_file_type = stripslashes($row['reward_list_file_type']);
			$reward_file = stripslashes($row['reward_list_file']);
			$reward_module_title = stripslashes($row['reward_module_title']);
			
			$reward_file_str = '';
			
			if($reward_file != '')
			{  
				if($reward_file_type == 'Pdf')
				{
					$reward_file_str = '<a target="_blank" href="'.SITE_URL.'/uploads/'.$reward_file.'"><img border="0" src="images/pdf-download-icon.png" width="50" height="50"  /> </a>';
				}
				elseif($reward_file_type == 'Video')
				{   
					$video_url = getYoutubeString($reward_file);
					$reward_file_str = '<a target="_blank" href="'.$video_url.'">'.$video_url.'</a>';
				}
				else
				{ 
					//$reward_file_str = '<img border="0" src="'.SITE_URL.'/uploads/'. $reward_file.'" height="50"  />'; 
					
					$reward_file_str = '<ul class="zoomonhoverul">
						<li class="zoomonhover"><a href="'.SITE_URL.'/uploads/'. $reward_file.'" class="preview"><img src="'.SITE_URL.'/uploads/'. $reward_file.'" width="100" alt="gallery thumbnail" /></a></li>
					</ul>';

				}		
			}
				
			

	$output .= '		<tr>
							<td height="30" align="center" valign="middle">'.$j.'</td>
							<td height="30" align="center" valign="middle">'.$reward_module_title.'</td>
							<td height="30" align="center" valign="middle">'.stripslashes($row['reward_list_conversion_value']).'</td>
							<td height="30" align="left" valign="middle">
								<div style="width:240px;float:left;margin-left:5px;margin-right:5px;">
									<div style="width:135px;float:left;">'.stripslashes($row['reward_list_name']).'</div>
									<div style="width:100px;float:left;text-align:right;margin-right:5px;">'.$reward_file_str.'</div>
								</div>
							</td>
						</tr>';
			$j++;			
		}
	}
	else
	{
	$output .= '		<tr>
							<td colspan="4" height="30" align="center" valign="middle">No Records Found</td>
						</tr>';		
	}	
	
	$output .= '	</tbody>
					</table>
				</div>';
	return $output;
}
function viewEntriesDetailsList($user_id,$start_date,$end_date,$reward_module_id)
{
	global $link;
	$output = '';
	
	$output .= '<div style="margin-top:15px;width:420px;height:400px;overflow:scroll;">';
	$output .= '	<table width="400" border="1" cellpadding="0" cellspacing="0" class="report" style="border-collapse:collapse;">
					<tbody>
						<tr>
							<td width="10%" height="30" align="center" valign="middle"><strong>SNo</strong></td>
							<td width="60%" height="30" align="center" valign="middle"><strong>Date</strong></td>
							<td width="30%" height="30" align="center" valign="middle"><strong>Total Entries</strong></td>
						</tr>';
	
	if($start_date == '' || $end_date == '' || $reward_module_id == '')
	{
	$output .= '		<tr>
							<td colspan="3" height="30" align="center" valign="middle">No Records Found!</td>
						</tr>';	
	}	
	else
	{
		$arr_date = getDateArrayBetweenTwoDates($start_date,$end_date);
		
		if(count($arr_date) > 0 )
		{
			//for($i=0,$j=1;$i<count($arr_date);$i++,$j++)
			for($i=count($arr_date)-1,$j=1;$i>=0;$i--,$j++)
			{
				$total_entry = getTotalEntriesOfModule($reward_module_id,$arr_date[$i],$arr_date[$i],$user_id);
				if($total_entry == '0' || $total_entry == '')
				{
					$total_entry = '-';
				}	
	
	$output .= '		<tr>
							<td height="30" align="center" valign="middle">'.$j.'</td>
							<td height="30" align="center" valign="middle">'.date('d-m-Y',strtotime($arr_date[$i])).'</td>
							<td height="30" align="center" valign="middle">'.$total_entry.'</td>
						</tr>';
			}
		}
		else
		{
	$output .= '		<tr>
							<td colspan="3" height="30" align="center" valign="middle">No Records Found.</td>
						</tr>';		
		}	
	}
	$output .= '	</tbody>
					</table>
				</div>';
	return $output;
}

function getBreadcrumbPages($page_id)
{
	global $link;
	$str_page_id = '';
	
	$parent_id = getParentPages($page_id);
	//echo '<br>page_id = '.$page_id.' , parent_id = '.$parent_id;
	if($parent_id  == '0')
	{
		//if($page_id != '1')
		//{
		//	array_push($arr_page_id,'1');
		//}		
		//array_push($arr_page_id,$page_id);
		$str_page_id = $page_id;	
		
	}
	else
	{
		$str_page_id .= $page_id.','.getBreadcrumbPages($parent_id);	
		//array_push($arr_page_id,getBreadcrumbPages($parent_id));
	}
	
	return $str_page_id;
}

function getBreadcrumbCode($page_id)
{
	global $link;
	$output = '';
	
	$str_page_id = getBreadcrumbPages($page_id);
	//echo'<br>str_page_id = '.$str_page_id;
	$arr_page_id = explode(',',$str_page_id);
	//echo'<br><pre>';
	//print_r($arr_page_id);
	//echo'<br></pre>';
	
	if($page_id != '1')
	{
		array_push($arr_page_id , '1');
	}
	$arr_page_id = array_reverse($arr_page_id);
	for($i=0;$i<count($arr_page_id);$i++)
	{
		list($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu) = getPageDetails($arr_page_id[$i]);
		
		if($link_enable == '1')
		{
			if($menu_link != '')
			{
				$menu_link = SITE_URL.'/'.$menu_link;
			}
			else
			{
				$menu_link = '#';
			}		
		}
		else
		{
			$menu_link = '#';
		}
		
		if($arr_page_id[$i] == $page_id)
		{
			$output .= ' '.$menu_title.'&gt;'; 
		}
		else
		{
			$output .= ' <a href="'.$menu_link.'" target="_self" class="breadcrumb_link">'.$menu_title.'</a> &gt;'; 
		}
	}
	
	$output = substr($output,0,-4);
	
	return $output;
}

function getParentPages($page_id)
{
	global $link;
	$parent_id = 0;
	
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."' AND `show_in_manage_menu` = '1' ";
	//echo'<br><br>sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		$row = mysql_fetch_assoc($result);
		$parent_id = $row['parent_menu'];
	}
	return $parent_id;
}

function addScrollingContentToFav($user_id,$page_id,$str_sc_id,$ufs_type='0')
{
	global $link;
	$return = false;
	$arr_sc_id = array();
	
	if($str_sc_id != '')
	{
		$pos = strpos($str_sc_id, ',');
		if ($pos !== false) 
		{
			$arr_sc_id = explode(',',$str_sc_id);
		}
		else
		{
			array_push($arr_sc_id , $str_sc_id);
		}
		
		//echo 'str_sc_id = '.$str_sc_id.'<br><br><pre>';
		//print_r($arr_sc_id);
		//echo '</pre>';
		
		//$del_sql = "DELETE FROM `tblusersfavscrolling` WHERE `user_id` = '".$user_id."' AND `page_id` = '".$page_id."'";
		//$result2 = mysql_query($del_sql,$link);
		//if($result2)
		//{
			
		//}	
		
		for($i=0;$i<count($arr_sc_id);$i++)
		{
			if(!chkIfOptionAlreadyAddedToFav($user_id,$page_id,$sc_id,$ufs_type))
			{
				$sql = "INSERT INTO `tblusersfavscrolling` (`user_id`,`page_id`,`sc_id`,`ufs_type`,`ufs_status`) VALUES ('".$user_id."','".$page_id."','".$arr_sc_id[$i]."','".$ufs_type."','1')";
				//echo"<br>".$sql;
				$result = mysql_query($sql,$link);
				if($result)
				{
					$return = true;	
				}
			}	
		}	
	}
	return $return;
}
function chkIfOptionAlreadyAddedToFav($user_id,$page_id,$sc_id,$ufs_type)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblusersfavscrolling` WHERE `page_id` = '".$page_id."' AND `user_id` = '".$user_id."'  AND `sc_id` = '".$sc_id."' AND `ufs_type` = '".$ufs_type."' ";
	//echo'<br><br>sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{	
		$return = true;
	}
	
	return $return;
}
function get_clean_br_string($string)
{ 
	$output = '';
	//echo '<br><br>string = '.$string;
	$string = trim($string);
	if($string != '')
	{
		$pos = strpos($string, ' ');
		if($pos !== FALSE)
		{	
			$temp_arr = explode(' ',$string);
			//echo'<br><br><pre>';
			//print_r($temp_arr);
			//echo'<br><br></pre>';
			foreach($temp_arr as $key => $val)
			{
				$temp_len = strlen($val);
				if($temp_len > 20)
				{
					$str = substr($val, 0, 10) . ' ' ;
					$temp_str2 =  substr($val, 10);
					if( strlen($temp_str2)> 10)
					{
						//echo '<br>test : '.$temp_str2;
						$temp_str2 = get_clean_br_string($temp_str2);
					}
					$str .= $temp_str2;	
				}
				else
				{
					$str = $val;
				}
				//echo '<br>Test str = '.$str;
				$output .= $str. ' ';
			}
		}
		else
		{
			$temp_len = strlen($string);
			if($temp_len > 15)
			{
				//$str = substr($val, 0, 10) . ' ' . substr($val, 10);
				$str = substr($string, 0, 15) . ' ' ;
				$temp_str2 =  substr($string, 15);
				if( strlen($temp_str2)> 15)
				{
					//echo '<br>test : '.$temp_str2;
					$temp_str2 = get_clean_br_string($temp_str2);
				}
				$str .= $temp_str2;	
			}
			else
			{
				$str = $string;
			}
			$output .= $str. ' ';
		}		
	}	
	
	return $output;
}
function getRssFeedItemDetails($rss_feed_item_id)
{
	global $link;
	$rss_feed_item_title = '';
	$rss_feed_item_desc = '';
	$rss_feed_item_link = '';
	$rss_feed_item_json = '';
	
	$sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_item_id` = '".$rss_feed_item_id."' AND `rss_feed_item_status` = '1' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result);
		$rss_feed_item_title = stripslashes($row['rss_feed_item_title']);
		$rss_feed_item_desc = stripslashes($row['rss_feed_item_desc']);
		$rss_feed_item_link = stripslashes($row['rss_feed_item_link']);
		$rss_feed_item_json = stripslashes($row['rss_feed_item_json']);
	}
	return array($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json);
}
function getScrollingWindowsCode($page_id)
{
	global $link;
	$output = '';
	$user_id = $_SESSION['user_id'];
	
	//$sql1 = "SELECT * FROM `tblscrollingwindows` WHERE `page_id` = '".$page_id."' AND `sw_status` = '1' AND `sw_show_in_contents` = '0' ORDER BY `sw_order` ASC , `sw_add_date` DESC ";
        $sql1 = "SELECT * FROM `tblscrollingwindows` WHERE FIND_IN_SET('".$page_id."', page_id) AND `sw_status` = '1' AND `sw_show_in_contents` = '0' ORDER BY `sw_order` ASC , `sw_add_date` DESC ";
    $result1 = mysql_query($sql1,$link);
    if( ($result1) && (mysql_num_rows($result1) > 0) )
    {
        $return = true;
        $i = 1;
        //$output .= '<div style="float:left;width:580px;">';
        while ($row1 = mysql_fetch_assoc($result1)) 
        {
            $sw_header = stripslashes($row1['sw_header']);
            $sw_header_hide = stripslashes($row1['sw_header_hide']);
            $sw_footer_hide = stripslashes($row1['sw_footer_hide']);
            $sw_header_font_family = stripslashes($row1['sw_header_font_family']);
            $sw_header_font_size = stripslashes($row1['sw_header_font_size']);
            $sw_header_font_color = stripslashes($row1['sw_header_font_color']);
            
            $sw_header_bg_color = stripslashes($row1['sw_header_bg_color']);
            if($sw_header_bg_color == '')
            {
                $sw_header_bg_color = '666666';
            }
            
            
            $sw_box_border_color = stripslashes($row1['sw_box_border_color']);
            if($sw_box_border_color == '')
            {
                $sw_box_border_color = '666666';
            }

            $header_style = '';
            
            if($sw_header_font_family != '')
            {
                $header_style = 'font-family:'.$sw_header_font_family.';';
            }

            if($sw_header_font_size != '')
            {
                $header_style .= 'font-size:'.$sw_header_font_size.'px;';
            }
            else
            {
                $header_style .= 'font-size:11px';
            }

            if($sw_header_font_color != '')
            {
                    $header_style .= 'color:#'.$sw_header_font_color.';';
            }
            
            if($row1['sw_show_header_credit'] == '1')
            {
                $sw_header = '<a href="'.stripslashes($row1['sw_header_credit_link']).'" target="_blank" style="color:#ffffff;'.$header_style.'">'.$sw_header.'</a>';			
            }

            if($row1['sw_header_image'] != '')
            {
                    $sw_header_image = '<img border="0" width="30" height="30" src="'.SITE_URL.'/uploads/'.stripslashes($row1['sw_header_image']).'">';
            }
            else
            {
                    $sw_header_image = '';
            }

            $sw_footer = stripslashes($row1['sw_footer']);
            

            $sw_footer_font_family = stripslashes($row1['sw_footer_font_family']);
            $sw_footer_font_size = stripslashes($row1['sw_footer_font_size']);

            $sw_footer_font_color = stripslashes($row1['sw_footer_font_color']);
            $sw_footer_bg_color = stripslashes($row1['sw_footer_bg_color']);
            if($sw_footer_bg_color == '')
            {
                $sw_footer_bg_color = '666666';
            }


            $footer_style = '';
            
            if($sw_footer_font_family != '')
            {
                    $footer_style = 'font-family:'.$sw_footer_font_family.';';
            }

            if($sw_footer_font_size != '')
            {
                    $footer_style .= 'font-size:'.$sw_footer_font_size.'px;';
            }
            else
            {
                    $footer_style .= 'font-size:11px';
            }

            if($sw_footer_font_color != '')
            {
                    $footer_style .= 'color:#'.$sw_footer_font_color.';';
            }
            
            if($row1['sw_show_footer_credit'] == '1')
            {
                    $sw_footer = '<a href="'.stripslashes($row1['sw_footer_credit_link']).'" target="_blank" style="color:#ffffff;'.$footer_style.'">'.$sw_footer.'</a>';			
            }

            if($row1['sw_footer_image'] != '')
            {
                    $sw_footer_image = '<img border="0" width="30" height="30" src="'.SITE_URL.'/uploads/'.stripslashes($row1['sw_footer_image']).'">';
            }
            else
            {
                    $sw_footer_image = '';
            }

            $today_day = date('j');
            $today_date = date('Y-m-d');
	
            $sql = "SELECT * FROM `tblscrollingcontents` WHERE ( (`sc_listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', sc_days_of_month) ) OR (`sc_listing_date_type` = 'single_date' AND `sc_single_date` = '".$today_date."') OR (`sc_listing_date_type` = 'date_range' AND `sc_start_date` <= '".$today_date."' AND `sc_end_date` >= '".$today_date."') ) AND ( `sw_id` = '".$row1['sw_id']."' ) AND ( `sc_status` = '1' ) ORDER BY `sc_order` ASC , `sc_add_date` DESC ";
            //echo '<br>sql = '.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                //$output .= '<div style="float:left;width:160px; margin-left:20px; ">';
                //$output .= '<form name="frmScrollingWindows" id="frmScrollingWindows" action="#" method="post" onsubmit="return addScrollingContentToFav();">';
                $output .= '<form name="frmScrollingWindows" id="frmScrollingWindows" action="#" method="post" >';
                $output .= '	<input type="hidden" name="hdnpage_id" id="hdnpage_id" value="'.$page_id.'">';
                $output .= '<table width="160" border="0" cellpadding="0" cellspacing="1" bgcolor="#'.$sw_box_border_color.'">';
                
                if($sw_header_hide == '0')
                {
                $output .= '	<tr>';
                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF">'; 
                $output .= '            <table width="160" border="0" cellpadding="0" cellspacing="0" bgcolor="#'.$sw_header_bg_color.'">';    
                $output .= '                <tr>';
                if($sw_header_image == '')
                {
                $output .= '                    <td width="160" bgcolor="#'.$sw_header_bg_color.'" height="30" align="center" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$header_style.'" >'.$sw_header.'</td>';
                }
                else
                {
                $output .= '                    <td width="125" bgcolor="#'.$sw_header_bg_color.'" height="30" align="left" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$header_style.'" >'.$sw_header.'</td>';
                $output .= '                    <td width="35" bgcolor="#'.$sw_header_bg_color.'" height="30" align="right" valign="middle" >'.$sw_header_image.'</td>';   
                }
                
                $output .= '                </tr>';
                $output .= '            </table>';    
                $output .= '        </td>';
                $output .= '	</tr>';
                }
                
                $output .= '	<tr>';
                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF" class="slider">';    
                
                $output .= '            <div style="" id="slider'.$i.'" >';

                $j = 0;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $sc_id = $row['sc_id'];
                    $sc_title = stripslashes($row['sc_title']);
                    $sc_title_font_family = stripslashes($row['sc_title_font_family']);
                    $sc_title_font_size = stripslashes($row['sc_title_font_size']);
                    $sc_content = get_clean_br_string(stripslashes($row['sc_content']));
                    $sc_content_font_family = stripslashes($row['sc_content_font_family']);
                    $sc_content_font_size = stripslashes($row['sc_content_font_size']);

                    $sc_content_type = stripslashes($row['sc_content_type']);

                    $sc_title_font_color = stripslashes($row['sc_title_font_color']);
                    $sc_content_font_color = stripslashes($row['sc_content_font_color']);
                    $sc_title_hide = stripslashes($row['sc_title_hide']);
                    $sc_add_fav_hide = stripslashes($row['sc_add_fav_hide']);
                    $sc_credit_link = stripslashes($row['sc_credit_link']);
                    					
					
                    $sc_title_style = '';
                    if($sc_title_font_family != '')
                    {
                            $sc_title_style = 'font-family:'.$sc_title_font_family.';';
                    }

                    if($sc_title_font_size != '')
                    {
                            $sc_title_style .= 'font-size:'.$sc_title_font_size.'px;';
                    }

                    if($sc_title_font_color != '')
                    {
                            $sc_title_style .= 'color:#'.$sc_title_font_color.';';
                    }

                    $output .= '<div style="min-height:100px;">';
                    $output .= '			<table width="150" border="0" cellspacing="0" cellpadding="0">';
                    
                    if($sc_title_hide == '0')
                    {
                    $output .= '				<tr>';
                    $output .= '					<td height="30" colspan="2" align="center" valign="top" style="'.$sc_title_style.'" >';
                    if($sc_credit_link == '')
                    {
                        $output .= ''.$sc_title.'';
                    }
                    else
                    {
                        $output .= '<a href="'.$sc_credit_link.'" style="'.$sc_title_style.'" target="_blank">'.$sc_title.'</a>';
                    }
                    
                    $output .= '</td>';
                    $output .= '				</tr>';
                    }

                    if($sc_content_type == 'text')
                    {
                            $sc_content_style = '';
                            if($sc_content_font_family != '')
                            {
                                    $sc_content_style = 'font-family:'.$sc_content_font_family.';';
                            }

                            if($sc_content_font_size != '')
                            {
                                    $sc_content_style .= 'font-size:'.$sc_content_font_size.'px;';
                            }

                            if($sc_content_font_color != '')
                            {
                                    $sc_content_style .= 'color:#'.$sc_content_font_color.';';
                            }

                            $output .= '<tr>';
                            $output .= '<td colspan="2" height="60" align="left" valign="top" style="padding-left:3px;'.$sc_content_style.'">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$sc_content.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_content.'</a>';
                            }
                            $output .= '</td>';
                            $output .= '</tr>';

                    }
                    elseif($sc_content_type == 'text_and_image')
                    {
                            $sc_content_style = '';
                            if($sc_content_font_family != '')
                            {
                                    $sc_content_style = 'font-family:'.$sc_content_font_family.';';
                            }

                            if($sc_content_font_size != '')
                            {
                                    $sc_content_style .= 'font-size:'.$sc_content_font_size.'px;';
                            }

                            if($sc_content_font_color != '')
                            {
                                    $sc_content_style .= 'color:#'.$sc_content_font_color.';';
                            }

                            if($row['sc_image'] != '')
                            {
                                    $sc_image = '<img border="0" width="50" src="'.SITE_URL.'/uploads/'.stripslashes($row['sc_image']).'" />';
                            }
                            else
                            {
                                    $sc_image = '';	
                            }


                            $output .= '				<tr>';
                            $output .= '					<td width="60" height="60" align="left" valign="top">';
                            $output .= '						<table width="50" border="0" cellspacing="0" cellpadding="0">';
                            $output .= '							<tr>';
                            $output .= '								<td align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:10px;">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$sc_image.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_image.'</a>';
                            }
                            $output .= '</td>';
                            $output .= '							</tr>';
                            $output .= '						</table>';
                            $output .= '					</td>';
                            $output .= '					<td width="90" height="60" align="left" valign="top" style="padding-left:3px;'.$sc_content_style.'">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$sc_content.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_content.'</a>';
                            }
                            $output .= '</td>';
                            $output .= '				</tr>';	

                    }
                    elseif($sc_content_type == 'image')
                    {
                            if($row['sc_image'] != '')
                            {
                                    $sc_image = '<img border="0" width="150" src="'.SITE_URL.'/uploads/'.stripslashes($row['sc_image']).'" />';
                            }
                            else
                            {
                                    $sc_image = '';	
                            }

                            $output .= '				<tr>';
                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$sc_image.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_image.'</a>';
                            }
                            $output .= '</td>';
                            $output .= '				</tr>';	
                    }	
                    elseif($sc_content_type == 'video')
                    {
                            if($row['sc_video'] != '')
                            {
                                    $sc_video = '<iframe width="150" height="150" src="'.getBannerString($row['sc_video']).'" frameborder="0" allowfullscreen></iframe>';
                            }
                            else
                            {
                                    $sc_video = '';	
                            }

                            $output .= '				<tr>';
                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$sc_video.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_video.'</a>';
                            }
                            $output .= '       </td>';
                            $output .= '				</tr>';	
                    }	
                    elseif($sc_content_type == 'flash')
                    {
                            if($row['sc_flash'] != '')
                            {
                                    $sc_flash = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="100"><param name="movie" value="'.SITE_URL."/uploads/".$row['sc_flash'].'" /><param name="quality" value="high" /><embed src="'.SITE_URL."/uploads/".$row['sc_flash'].'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="100"></embed></object>';
                            }
                            else
                            {
                                    $sc_flash = '';	
                            }

                            $output .= '				<tr>';
                            $output .= '					<td colspan="2" height="60" align="left" valign="top">'.$sc_flash.'</td>';
                            $output .= '				</tr>';	
                    }	
                    elseif($sc_content_type == 'rss')
                    {
                            $rss_feed_item_id = $row['rss_feed_item_id'];
                            list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = getRssFeedItemDetails($rss_feed_item_id);

                            $output .= '				<tr>';
                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$rss_feed_item_title.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$rss_feed_item_title.'</a>';
                            }
                            $output .= '        </td>';
                            $output .= '				</tr>';	
                            $output .= '				<tr>';
                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$rss_feed_item_desc.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$rss_feed_item_desc.'</a>';
                            }
                            $output .= '        </td>';
                            $output .= '				</tr>';	
                    }	



                    if(stripslashes($row['sc_show_credit']) == '1')
                    {

                            if(stripslashes($row['sc_credit_name']) != '')
                            {
                                    $sc_show_credit = '1';
                                    $sc_credit_name = stripslashes($row['sc_credit_name']);
                                    if(stripslashes($row['sc_credit_link']) != '')
                                    {
                                            $sc_credit_link = stripslashes($row['sc_credit_link']);
                                    }
                                    else
                                    {
                                            $sc_credit_link = '';	
                                    }	
                            }
                            else
                            {
                                    $sc_show_credit = '0';	
                                    $sc_credit_name = '';	
                                    $sc_credit_link = '';	
                            }	
                    }	
                    else
                    {
                            $sc_show_credit = '0';	
                            $sc_credit_name = '';	
                            $sc_credit_link = '';	
                    }
                    
                    if($sc_add_fav_hide == '0')
                    { 
				
                    $output .= '				<tr>
                                    <td height="30" align="left" valign="middle" style="padding-left:2px;">';
                    if(!chkIfOptionAlreadyAddedToFav($user_id,$page_id,$sc_id,'0'))
                    {								
                    $output .= '					<input type="button" name="select_scrolloing_content_'.$i.'_'.$j.'" id="select_scrolloing_content_'.$i.'_'.$j.'" value="Add to Fav" onclick="addScrollingContentToFav(\''.$sc_id.'\')" style="width:60px;font-size:9px;">';
                    }
                    $output .= '                    </td>
												<td height="30" align="right" valign="middle">';
                    if($sc_show_credit == '1')
                    {
                    $output .= '					<a href="'.$sc_credit_link.'" target="_blank">'.$sc_credit_name.'</a>';
                    }
                    $output .= '                    </td>
                                                                            </tr>';
                    }
                    else
                    {
                    
                    
                    
                        if($sc_show_credit == '1')
                        {
                            $output .= '				<tr>
                                        <td colspan="2" height="30" align="center" valign="middle" style="padding-left:2px;">';
                        $output .= '					<a href="'.$sc_credit_link.'" target="_blank">'.$sc_credit_name.'</a>';
                        $output .= '                    </td>
                                                                                </tr>';  
                        }
                      
                    }

                    $output .= '			</table>';

                    $output .= '</div>';


                    $j = $j+1;
                }
				
                $output .= '			</div>';


                $output .= '		</td>';
                $output .= '	</tr>';
                if($sw_footer_hide == '0')
                {
                $output .= '	<tr>';
                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF">'; 
                $output .= '            <table width="160" border="0" cellpadding="0" cellspacing="0" bgcolor="#'.$sw_footer_bg_color.'">';    
                $output .= '                <tr>';
                if($sw_footer_image == '')
                {
                $output .= '                    <td width="160" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="center" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$footer_style.'" >'.$sw_footer.'</td>';
                }
                else
                {
                $output .= '                    <td width="125" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="left" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$footer_style.'" >'.$sw_footer.'</td>';
                $output .= '                    <td width="35" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="right" valign="middle" >'.$sw_footer_image.'</td>';    
                }
                $output .= '                </tr>';
                $output .= '            </table>';    
                $output .= '        </td>';
                $output .= '	</tr>';    
                
                }
                $output .= '</table>
                            <table width="160" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td height="10"><img src="images/spacer.gif" width="1" height="1" /></td>
                                </tr>
                            </table>';
                $output .= '	</form>';
                //$output .= '</div>';
                $i = $i+1;
            }
        }
        //$output .= '</div>';
    }
	return $output;	
}

function getScrollingWindowsCodeMainContent($page_id)
{
    global $link;
    $output = '';
    $user_id = $_SESSION['user_id'];

    //$sql1 = "SELECT * FROM `tblscrollingwindows` WHERE `page_id` = '".$page_id."' AND `sw_status` = '1' AND `sw_show_in_contents` = '1' ORDER BY `sw_order` ASC , `sw_add_date` DESC ";
    $sql1 = "SELECT * FROM `tblscrollingwindows` WHERE FIND_IN_SET('".$page_id."', page_id) AND `sw_status` = '1' AND `sw_show_in_contents` = '1' ORDER BY `sw_order` ASC , `sw_add_date` DESC ";
    $result1 = mysql_query($sql1,$link);
    if( ($result1) && (mysql_num_rows($result1) > 0) )
    {
        $return = true;
        $i = 1;
        $output .= '<div class="divcenterouter">';
        $output .= '<div class="divcenterinner">';
        //$output .= '<div style="float:left;max-width:580px;">';
        while ($row1 = mysql_fetch_assoc($result1)) 
        {
            $sw_header = stripslashes($row1['sw_header']);
            $sw_header_hide = stripslashes($row1['sw_header_hide']);
            $sw_footer_hide = stripslashes($row1['sw_footer_hide']);
            $sw_header_font_family = stripslashes($row1['sw_header_font_family']);
            $sw_header_font_size = stripslashes($row1['sw_header_font_size']);
            $sw_header_font_color = stripslashes($row1['sw_header_font_color']);
            
            $sw_header_bg_color = stripslashes($row1['sw_header_bg_color']);
            if($sw_header_bg_color == '')
            {
                $sw_header_bg_color = '666666';
            }
            
            
            $sw_box_border_color = stripslashes($row1['sw_box_border_color']);
            if($sw_box_border_color == '')
            {
                $sw_box_border_color = '666666';
            }

            $header_style = '';
            
            if($sw_header_font_family != '')
            {
                $header_style = 'font-family:'.$sw_header_font_family.';';
            }

            if($sw_header_font_size != '')
            {
                $header_style .= 'font-size:'.$sw_header_font_size.'px;';
            }
            else
            {
                $header_style .= 'font-size:11px';
            }

            if($sw_header_font_color != '')
            {
                    $header_style .= 'color:#'.$sw_header_font_color.';';
            }
            
            if($row1['sw_show_header_credit'] == '1')
            {
                $sw_header = '<a href="'.stripslashes($row1['sw_header_credit_link']).'" target="_blank" style="color:#ffffff;'.$header_style.'">'.$sw_header.'</a>';			
            }

            if($row1['sw_header_image'] != '')
            {
                    $sw_header_image = '<img border="0" width="30" height="30" src="'.SITE_URL.'/uploads/'.stripslashes($row1['sw_header_image']).'">';
            }
            else
            {
                    $sw_header_image = '';
            }

            $sw_footer = stripslashes($row1['sw_footer']);
            

            $sw_footer_font_family = stripslashes($row1['sw_footer_font_family']);
            $sw_footer_font_size = stripslashes($row1['sw_footer_font_size']);

            $sw_footer_font_color = stripslashes($row1['sw_footer_font_color']);
            $sw_footer_bg_color = stripslashes($row1['sw_footer_bg_color']);
            if($sw_footer_bg_color == '')
            {
                $sw_footer_bg_color = '666666';
            }


            $footer_style = '';
            
            if($sw_footer_font_family != '')
            {
                    $footer_style = 'font-family:'.$sw_footer_font_family.';';
            }

            if($sw_footer_font_size != '')
            {
                    $footer_style .= 'font-size:'.$sw_footer_font_size.'px;';
            }
            else
            {
                    $footer_style .= 'font-size:11px';
            }

            if($sw_footer_font_color != '')
            {
                    $footer_style .= 'color:#'.$sw_footer_font_color.';';
            }
            
            if($row1['sw_show_footer_credit'] == '1')
            {
                    $sw_footer = '<a href="'.stripslashes($row1['sw_footer_credit_link']).'" target="_blank" style="color:#ffffff;'.$footer_style.'">'.$sw_footer.'</a>';			
            }

            if($row1['sw_footer_image'] != '')
            {
                    $sw_footer_image = '<img border="0" width="30" height="30" src="'.SITE_URL.'/uploads/'.stripslashes($row1['sw_footer_image']).'">';
            }
            else
            {
                    $sw_footer_image = '';
            }

            $today_day = date('j');
            $today_date = date('Y-m-d');
	
            $sql = "SELECT * FROM `tblscrollingcontents` WHERE ( (`sc_listing_date_type` = 'days_of_month' AND FIND_IN_SET('".$today_day."', sc_days_of_month) ) OR (`sc_listing_date_type` = 'single_date' AND `sc_single_date` = '".$today_date."') OR (`sc_listing_date_type` = 'date_range' AND `sc_start_date` <= '".$today_date."' AND `sc_end_date` >= '".$today_date."') ) AND ( `sw_id` = '".$row1['sw_id']."' ) AND ( `sc_status` = '1' ) ORDER BY `sc_order` ASC , `sc_add_date` DESC ";
            //echo '<br>sql = '.$sql;
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                $output .= '<div style="float:left;width:160px; margin-left:20px; ">';
                
                
                
                $output .= '<form name="frmScrollingWindows" id="frmScrollingWindows" action="#" method="post" >';
                $output .= '	<input type="hidden" name="hdnpage_id" id="hdnpage_id" value="'.$page_id.'">';
                $output .= '<table width="160" border="0" cellpadding="0" cellspacing="1" bgcolor="#'.$sw_box_border_color.'">';
                
                if($sw_header_hide == '0')
                {
                $output .= '	<tr>';
                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF">'; 
                $output .= '            <table width="160" border="0" cellpadding="0" cellspacing="0" bgcolor="#'.$sw_header_bg_color.'">';    
                $output .= '                <tr>';
                if($sw_header_image == '')
                {
                $output .= '                    <td width="160" bgcolor="#'.$sw_header_bg_color.'" height="30" align="center" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$header_style.'" >'.$sw_header.'</td>';
                }
                else
                {
                $output .= '                    <td width="125" bgcolor="#'.$sw_header_bg_color.'" height="30" align="left" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$header_style.'" >'.$sw_header.'</td>';
                $output .= '                    <td width="35" bgcolor="#'.$sw_header_bg_color.'" height="30" align="right" valign="middle" >'.$sw_header_image.'</td>';    
                }
                $output .= '                </tr>';
                $output .= '            </table>';    
                $output .= '        </td>';
                $output .= '	</tr>';
                }
                
                $output .= '	<tr>';
                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF" class="slider">';    
                
                $output .= '            <div style="" id="slider_main'.$i.'" >';

                $j = 0;
                while ($row = mysql_fetch_assoc($result)) 
                {
                    $sc_id = $row['sc_id'];
                    $sc_title = stripslashes($row['sc_title']);
                    $sc_title_font_family = stripslashes($row['sc_title_font_family']);
                    $sc_title_font_size = stripslashes($row['sc_title_font_size']);
                    $sc_content = get_clean_br_string(stripslashes($row['sc_content']));
                    $sc_content_font_family = stripslashes($row['sc_content_font_family']);
                    $sc_content_font_size = stripslashes($row['sc_content_font_size']);

                    $sc_content_type = stripslashes($row['sc_content_type']);

                    $sc_title_font_color = stripslashes($row['sc_title_font_color']);
                    $sc_content_font_color = stripslashes($row['sc_content_font_color']);
                    $sc_title_hide = stripslashes($row['sc_title_hide']);
                    $sc_add_fav_hide = stripslashes($row['sc_add_fav_hide']);
                    $sc_credit_link = stripslashes($row['sc_credit_link']);
                    					
					
                    $sc_title_style = '';
                    if($sc_title_font_family != '')
                    {
                            $sc_title_style = 'font-family:'.$sc_title_font_family.';';
                    }

                    if($sc_title_font_size != '')
                    {
                            $sc_title_style .= 'font-size:'.$sc_title_font_size.'px;';
                    }

                    if($sc_title_font_color != '')
                    {
                            $sc_title_style .= 'color:#'.$sc_title_font_color.';';
                    }

                    $output .= '<div style="min-height:100px;">';
                    $output .= '			<table width="150" border="0" cellspacing="0" cellpadding="0">';
                    
                    if($sc_title_hide == '0')
                    {
                    $output .= '				<tr>';
                    $output .= '					<td height="30" colspan="2" align="center" valign="top" style="'.$sc_title_style.'" >';
                    if($sc_credit_link == '')
                    {
                        $output .= ''.$sc_title.'';
                    }
                    else
                    {
                        $output .= '<a href="'.$sc_credit_link.'" style="'.$sc_title_style.'" target="_blank">'.$sc_title.'</a>';
                    }
                    
                    $output .= '</td>';
                    $output .= '				</tr>';
                    }

                    if($sc_content_type == 'text')
                    {
                            $sc_content_style = '';
                            if($sc_content_font_family != '')
                            {
                                    $sc_content_style = 'font-family:'.$sc_content_font_family.';';
                            }

                            if($sc_content_font_size != '')
                            {
                                    $sc_content_style .= 'font-size:'.$sc_content_font_size.'px;';
                            }

                            if($sc_content_font_color != '')
                            {
                                    $sc_content_style .= 'color:#'.$sc_content_font_color.';';
                            }

                            $output .= '<tr>';
                            $output .= '<td colspan="2" height="60" align="left" valign="top" style="padding-left:3px;'.$sc_content_style.'">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$sc_content.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_content.'</a>';
                            }
                            $output .= '</td>';
                            $output .= '</tr>';

                    }
                    elseif($sc_content_type == 'text_and_image')
                    {
                            $sc_content_style = '';
                            if($sc_content_font_family != '')
                            {
                                    $sc_content_style = 'font-family:'.$sc_content_font_family.';';
                            }

                            if($sc_content_font_size != '')
                            {
                                    $sc_content_style .= 'font-size:'.$sc_content_font_size.'px;';
                            }

                            if($sc_content_font_color != '')
                            {
                                    $sc_content_style .= 'color:#'.$sc_content_font_color.';';
                            }

                            if($row['sc_image'] != '')
                            {
                                    $sc_image = '<img border="0" width="50" src="'.SITE_URL.'/uploads/'.stripslashes($row['sc_image']).'" />';
                            }
                            else
                            {
                                    $sc_image = '';	
                            }


                            $output .= '				<tr>';
                            $output .= '					<td width="60" height="60" align="left" valign="top">';
                            $output .= '						<table width="50" border="0" cellspacing="0" cellpadding="0">';
                            $output .= '							<tr>';
                            $output .= '								<td align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:10px;">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$sc_image.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_image.'</a>';
                            }
                            $output .= '</td>';
                            $output .= '							</tr>';
                            $output .= '						</table>';
                            $output .= '					</td>';
                            $output .= '					<td width="90" height="60" align="left" valign="top" style="padding-left:3px;'.$sc_content_style.'">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$sc_content.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_content.'</a>';
                            }
                            $output .= '</td>';
                            $output .= '				</tr>';	

                    }
                    elseif($sc_content_type == 'image')
                    {
                            if($row['sc_image'] != '')
                            {
                                    $sc_image = '<img border="0" width="150" src="'.SITE_URL.'/uploads/'.stripslashes($row['sc_image']).'" />';
                            }
                            else
                            {
                                    $sc_image = '';	
                            }

                            $output .= '				<tr>';
                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$sc_image.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_image.'</a>';
                            }
                            $output .= '</td>';
                            $output .= '				</tr>';	
                    }	
                    elseif($sc_content_type == 'video')
                    {
                            if($row['sc_video'] != '')
                            {
                                    $sc_video = '<iframe width="150" height="150" src="'.getBannerString($row['sc_video']).'" frameborder="0" allowfullscreen></iframe>';
                            }
                            else
                            {
                                    $sc_video = '';	
                            }

                            $output .= '				<tr>';
                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$sc_video.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$sc_video.'</a>';
                            }
                            $output .= '       </td>';
                            $output .= '				</tr>';	
                    }	
                    elseif($sc_content_type == 'flash')
                    {
                            if($row['sc_flash'] != '')
                            {
                                    $sc_flash = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="100" height="100"><param name="movie" value="'.SITE_URL."/uploads/".$row['sc_flash'].'" /><param name="quality" value="high" /><embed src="'.SITE_URL."/uploads/".$row['sc_flash'].'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100" height="100"></embed></object>';
                            }
                            else
                            {
                                    $sc_flash = '';	
                            }

                            $output .= '				<tr>';
                            $output .= '					<td colspan="2" height="60" align="left" valign="top">'.$sc_flash.'</td>';
                            $output .= '				</tr>';	
                    }	
                    elseif($sc_content_type == 'rss')
                    {
                            $rss_feed_item_id = $row['rss_feed_item_id'];
                            list($rss_feed_item_title,$rss_feed_item_desc,$rss_feed_item_link,$rss_feed_item_json) = getRssFeedItemDetails($rss_feed_item_id);

                            $output .= '				<tr>';
                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$rss_feed_item_title.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$rss_feed_item_title.'</a>';
                            }
                            $output .= '        </td>';
                            $output .= '				</tr>';	
                            $output .= '				<tr>';
                            $output .= '					<td colspan="2" height="60" align="left" valign="top">';
                            if($sc_credit_link == '')
                            {
                                $output .= ''.$rss_feed_item_desc.'';
                            }
                            else
                            {
                                $output .= '<a href="'.$sc_credit_link.'" target="_blank" style="text-decoration:none;'.$sc_content_style.'">'.$rss_feed_item_desc.'</a>';
                            }
                            $output .= '        </td>';
                            $output .= '				</tr>';	
                    }	



                    if(stripslashes($row['sc_show_credit']) == '1')
                    {

                            if(stripslashes($row['sc_credit_name']) != '')
                            {
                                    $sc_show_credit = '1';
                                    $sc_credit_name = stripslashes($row['sc_credit_name']);
                                    if(stripslashes($row['sc_credit_link']) != '')
                                    {
                                            $sc_credit_link = stripslashes($row['sc_credit_link']);
                                    }
                                    else
                                    {
                                            $sc_credit_link = '';	
                                    }	
                            }
                            else
                            {
                                    $sc_show_credit = '0';	
                                    $sc_credit_name = '';	
                                    $sc_credit_link = '';	
                            }	
                    }	
                    else
                    {
                            $sc_show_credit = '0';	
                            $sc_credit_name = '';	
                            $sc_credit_link = '';	
                    }
                    
                    if($sc_add_fav_hide == '0')
                    { 
				
                    $output .= '				<tr>
                                    <td height="30" align="left" valign="middle" style="padding-left:2px;">';
                    if(!chkIfOptionAlreadyAddedToFav($user_id,$page_id,$sc_id,'0'))
                    {								
                    $output .= '					<input type="button" name="select_scrolloing_content_'.$i.'_'.$j.'" id="select_scrolloing_content_'.$i.'_'.$j.'" value="Add to Fav" onclick="addScrollingContentToFav(\''.$sc_id.'\')" style="width:60px;font-size:9px;">';
                    }
                    $output .= '                    </td>
												<td height="30" align="right" valign="middle">';
                    if($sc_show_credit == '1')
                    {
                    $output .= '					<a href="'.$sc_credit_link.'" target="_blank">'.$sc_credit_name.'</a>';
                    }
                    $output .= '                    </td>
                                                                            </tr>';
                    }
                    else
                    {
                    
                    
                    
                        if($sc_show_credit == '1')
                        {
                            $output .= '				<tr>
                                        <td colspan="2" height="30" align="center" valign="middle" style="padding-left:2px;">';
                        $output .= '					<a href="'.$sc_credit_link.'" target="_blank">'.$sc_credit_name.'</a>';
                        $output .= '                    </td>
                                                                                </tr>';  
                        }
                      
                    }

                    $output .= '			</table>';

                    $output .= '</div>';


                    $j = $j+1;
                }
				
                $output .= '			</div>';


                $output .= '		</td>';
                $output .= '	</tr>';
                if($sw_footer_hide == '0')
                {
                $output .= '	<tr>';
                $output .= '        <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF">'; 
                $output .= '            <table width="160" border="0" cellpadding="0" cellspacing="0" bgcolor="#'.$sw_footer_bg_color.'">';    
                $output .= '                <tr>';
                if($sw_footer_image == '')
                {
                $output .= '                    <td width="160" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="center" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$footer_style.'" >'.$sw_footer.'</td>';
                }
                else
                {
                $output .= '                    <td width="125" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="left" valign="middle" style="color:#FFFFFF;font-weight:bold;'.$footer_style.'" >'.$sw_footer.'</td>';
                $output .= '                    <td width="35" bgcolor="#'.$sw_footer_bg_color.'" height="30" align="right" valign="middle" >'.$sw_footer_image.'</td>';    
                }
                $output .= '                </tr>';
                $output .= '            </table>';    
                $output .= '        </td>';
                $output .= '	</tr>';    
                
                }
                $output .= '</table>
                            <table width="160" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td height="10"><img src="images/spacer.gif" width="1" height="1" /></td>
                                </tr>
                            </table>';
                $output .= '	</form>';
                $output .= '</div>';
                
                if($i % 3 == 0)
                {
                $output .= '<div style="clear:both;height:5px;"></div>';        
                }
                
                $i = $i+1;
                
                
            }
        }
        $output .= '</div></div><div style="clear:both;height:5px;"></div>';
    }
    return $output;	
}

function getSlidersCode()
{
	global $link;
	$output = '';
	
	$arr_parents_slider_id = array();
	$arr_slider_name = array();
	$arr_output = array();
	
	$sql1 = "SELECT * FROM `tblparentsliders` ORDER BY `parent_slider_add_date` ASC ";
	
	$result1 = mysql_query($sql1,$link);
	if( ($result1) && (mysql_num_rows($result1) > 0) )
	{
		$return = true;
		$i = 1;
		while ($row1 = mysql_fetch_assoc($result1)) 
		{
			array_push($arr_parents_slider_id , $row['parents_slider_id']);
			array_push($arr_slider_name , $row['slider_name']);
	
	    	$sql = "SELECT * FROM `tblslidercontents` WHERE `parents_slider_id` = '".$row1['parents_slider_id']."' ORDER BY `slider_add_date` DESC ";
			
			$result = mysql_query($sql,$link);
			if( ($result) && (mysql_num_rows($result) > 0) )
			{
				$output = '<table width="160" border="0" cellpadding="0" cellspacing="1" bgcolor="#666666">';
				$output .= '	<tr>';
				$output .= '		<td height="30" align="left" valign="middle" class="Header_white" style="background-image:url(images/back2.jpg); padding-left:10px;">'.$row1['slider_name'].'</td>';
				$output .= '	</tr>';
				$output .= '	<tr>';
				$output .= '		<td align="left" valign="top" bgcolor="#FFFFFF" class="slider">';
				$output .= '			<div id="slider'.$i.'" >';
				$i = $i+1;
				
				while ($row = mysql_fetch_assoc($result)) 
				{
					$slider_desc = stripslashes($row['slider_desc']);
					if(strlen($slider_desc) > 50)
					{
						$slider_desc = substr($slider_desc,0,47);
						$slider_desc = $slider_desc.'...<a class="slider_title" target="_blank" href="'.stripslashes($row['slider_link']).'">More</a>';
					}
				
				$output .= '<div style="height:100px;">';
				
				$output .= '			<table width="150" border="0" cellspacing="0" cellpadding="0">';
				$output .= '				<tr>';
				$output .= '					<td height="30" colspan="2" align="left" valign="top" style="padding-left:10px;"><a target="_blank" class="slider_title" href="'.stripslashes($row['slider_link']).'"><strong>'.stripslashes($row['slider_title']).'</strong></a></td>';
				$output .= '				</tr>';
				$output .= '				<tr>';
				$output .= '					<td width="60" height="60" align="left" valign="top">';
				$output .= '						<table width="50" border="0" cellspacing="0" cellpadding="0">';
				$output .= '							<tr>';
				$output .= '								<td align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:10px;"><a target="_blank" href="'.stripslashes($row['slider_link']).'"><img border="0" width="50" src="'.SITE_URL.'/uploads/'.stripslashes($row['slider_image']).'" /></a></td>';
				$output .= '							</tr>';
				$output .= '						</table>';
				$output .= '					</td>';
				$output .= '					<td width="90" height="60" align="left" valign="top" style="padding-left:3px;">'.$slider_desc.'</td>';
				$output .= '				</tr>';
				//$output .= '				<tr>';
				//$output .= '					<td colspan="2">&nbsp;</td>';
				//$output .= '				</tr>';
				$output .= '			</table>';
				
				$output .= '</div>';
				
				}
				
				$output .= '			</div>';
				
				
				$output .= '		</td>';
				$output .= '	</tr>';
				$output .= '</table>';
				
			    array_push($arr_output , $output);
				
				
			}
 		 }
		 
							$cols = 3;
							$count = count($arr_output);
							
							if($count%$cols > 0){
							for($i=0;$i<($cols-$count%$cols);$i++){
							$arr_output[] = '&nbsp;';
							}
							}
			$new_output = '<table width="100%" cellpadding="5" cellspacing="0" border="0">';
							
							foreach($arr_output as $key => $td){
							if($key%$cols == 0) 
			$new_output .=	'<tr>';
			$new_output .= 		'<td valign="top" align="left">'.$td.'</td>';
							if($key%$cols == ($cols - 1)) 
			$new_output .=	'</tr>';
							}
			$new_output .= '</table>'; 
  }
	return $new_output;	
}

function getNatureSliderCode()
{
	global $link;
	$output = '';
	
	$sql = "SELECT * FROM `tblslidercontents` WHERE `slider_type` = '1' ORDER BY `slider_add_date` DESC ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$output .= '<table width="160" border="0" cellpadding="0" cellspacing="1" bgcolor="#666666">';
		$output .= '	<tr>';
		$output .= '		<td height="30" align="left" valign="middle" bgcolor="#E5E5E5" class="Header_white" style=" background-image:url(images/back2.jpg); padding-left:10px;">Save Earth</td>';
		$output .= '	</tr>';
		$output .= '	<tr>';
		$output .= '		<td align="left" valign="top" bgcolor="#FFFFFF" class="slider">';
		$output .= '			<div id="slider2">';
		
		while ($row = mysql_fetch_assoc($result)) 
		{
			$slider_desc = stripslashes($row['slider_desc']);
			if(strlen($slider_desc) > 50)
			{
				$slider_desc = substr($slider_desc,0,47);
				$slider_desc = $slider_desc.'...<a class="slider_title" href="'.stripslashes($row['slider_link']).'">More</a>';
			}
		
		$output .= '<div>';
		
		$output .= '			<table width="150" border="0" cellspacing="0" cellpadding="0">';
		$output .= '				<tr>';
		$output .= '					<td height="30" colspan="2" align="left" valign="top" style="padding-left:10px;"><a class="slider_title" href="'.stripslashes($row['slider_link']).'"><strong>'.stripslashes($row['slider_title']).'</strong></a></td>';
		$output .= '				</tr>';
		$output .= '				<tr>';
		$output .= '					<td width="60" height="60" align="left" valign="top">';
		$output .= '						<table width="50" border="0" cellspacing="0" cellpadding="0">';
		$output .= '							<tr>';
		$output .= '								<td align="left" valign="top" bgcolor="#FFFFFF" style="padding-left:10px;"><a href="'.stripslashes($row['slider_link']).'"><img border="0" width="50" src="'.SITE_URL.'/uploads/'.stripslashes($row['slider_image']).'" /></a></td>';
		$output .= '							</tr>';
		$output .= '						</table>';
		$output .= '					</td>';
		$output .= '					<td width="90" height="60" align="left" valign="top" style="padding-left:3px;">'.$slider_desc.'</td>';
		$output .= '				</tr>';
		//$output .= '				<tr>';
		//$output .= '					<td colspan="2">&nbsp;</td>';
		//$output .= '				</tr>';
		$output .= '			</table>';
		
		$output .= '</div>';
		}
		
		$output .= '			</div>';
		
		
		$output .= '		</td>';
		$output .= '	</tr>';
		$output .= '</table>';
	}
	return $output;	
}

function getWelcomeUserBoxCode($name,$user_id,$col='2',$show_custid ='')
{
	global $link;
        
        if($col == '1')
        {
            $width = '80';
        }
        else
        {
            $width = '120';
        }
        
	$output = '';
	$output .= '            <table width="'.$width.'" border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">';
	$output .= '                <tr>';
	$output .= '                    <td >';
	$output .= '                        <table width="'.$width.'" border="0" cellspacing="0" cellpadding="0">';
	$output .= '                            <tr>';
	if($show_custid == '1')
        {
        $output .= '                                <td >Welcome '.$name.'</td>';    
        $output .= '                                <td >Cust Id: '.getUserUniqueId($user_id).'</td>';
	}
        else
        {
        $output .= '                                <td >Welcome '.$name.'</td>';    
        }
        $output .= '				</tr>';
	$output .= '                        </table>';
	$output .= '			</td>';
	$output .= '                </tr>';
	$output .= '		</table>';
	return $output;	
}

function getHeightOptions($height_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblheights` ORDER BY `height_cms` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if($row['height_id'] == $height_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['height_id'].'" '.$sel.'>'.$row['height_cms'].' cms ('.$row['height_feet_inch'].' feet)</option>';
		}
	}
	return $option_str;
}

function addUsersWAEQuestion($user_id,$wae_date,$selected_wae_id_arr,$scale_arr,$remarks_arr,$my_target_arr,$adviser_target_arr,$wae_set_id)
{
	global $link;
	$return = false;
        
        if($wae_set_id == '' || $wae_set_id == '999999999')
        {
           $wae_set_id = '0'; 
        }
	
	$sql = "UPDATE `tbluserswae` SET `wae_old_data` = '1' WHERE `user_id` = '".$user_id."' AND  `wae_date` = '".$wae_date."' AND  `wae_set_id` = '".$wae_set_id."' ";
	$result = mysql_query($sql,$link);
	
	for($i=0;$i<count($selected_wae_id_arr);$i++)
	{
		if($selected_wae_id_arr[$i] > 0)
		{
			$sql = "INSERT INTO `tbluserswae` (`user_id`,`wae_date`,`selected_wae_id`,`scale`,`remarks`,`my_target`,`adviser_target`,`wae_set_id`) VALUES ('".$user_id."','".$wae_date."','".$selected_wae_id_arr[$i]."','".$scale_arr[$i]."','".$remarks_arr[$i]."','".$my_target_arr[$i]."','".$adviser_target_arr[$i]."','".$wae_set_id."')";
			//echo"<br>".$sql;
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}	
	return $return;
}

function addUsersGSQuestion($user_id,$gs_date,$selected_gs_id_arr,$scale_arr,$remarks_arr,$my_target_arr,$adviser_target_arr,$gs_set_id)
{
	global $link;
	$return = false;
        
        if($gs_set_id == '' || $gs_set_id == '999999999')
        {
           $gs_set_id = '0'; 
        }
	
	$sql = "UPDATE `tblusersgs` SET `gs_old_data` = '1' WHERE `user_id` = '".$user_id."' AND  `gs_date` = '".$gs_date."' AND  `gs_set_id` = '".$gs_set_id."' ";
	$result = mysql_query($sql,$link);
	
	for($i=0;$i<count($selected_gs_id_arr);$i++)
	{
		if($selected_gs_id_arr[$i] > 0)
		{
			$sql = "INSERT INTO `tblusersgs` (`user_id`,`gs_date`,`selected_gs_id`,`scale`,`remarks`,`my_target`,`adviser_target`,`gs_set_id`) VALUES ('".$user_id."','".$gs_date."','".$selected_gs_id_arr[$i]."','".$scale_arr[$i]."','".$remarks_arr[$i]."','".$my_target_arr[$i]."','".$adviser_target_arr[$i]."','".$gs_set_id."')";
			//echo"<br>".$sql;
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}	
	return $return;
}

function addUsersSleepQuestion($user_id,$sleep_date,$selected_sleep_id_arr,$scale_arr,$remarks_arr,$my_target_arr,$adviser_target_arr,$sleep_set_id)
{
	global $link;
	$return = false;
        
        if($sleep_set_id == '' || $sleep_set_id == '999999999')
        {
           $sleep_set_id = '0'; 
        }
	
	$sql = "UPDATE `tbluserssleep` SET `sleep_old_data` = '1' WHERE `user_id` = '".$user_id."' AND  `sleep_date` = '".$sleep_date."' AND  `sleep_set_id` = '".$sleep_set_id."' ";
	$result = mysql_query($sql,$link);
	
	for($i=0;$i<count($selected_sleep_id_arr);$i++)
	{
		if($selected_sleep_id_arr[$i] > 0)
		{
			$sql = "INSERT INTO `tbluserssleep` (`user_id`,`sleep_date`,`selected_sleep_id`,`scale`,`remarks`,`my_target`,`adviser_target`,`sleep_set_id`) VALUES ('".$user_id."','".$sleep_date."','".$selected_sleep_id_arr[$i]."','".$scale_arr[$i]."','".$remarks_arr[$i]."','".$my_target_arr[$i]."','".$adviser_target_arr[$i]."','".$sleep_set_id."')";
                        //echo"<br>".$sql;
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}	
	return $return;
}

function addUsersMCQuestion($user_id,$mc_date,$selected_mc_id_arr,$scale_arr,$remarks_arr,$my_target_arr,$adviser_target_arr,$mc_set_id)
{
	global $link;
	$return = false;
	
	if($mc_set_id == '' || $mc_set_id == '999999999')
        {
           $mc_set_id = '0'; 
        }
	
	$sql = "UPDATE `tblusersmc` SET `mc_old_data` = '1' WHERE `user_id` = '".$user_id."' AND  `mc_date` = '".$mc_date."' AND  `mc_set_id` = '".$mc_set_id."' ";
	$result = mysql_query($sql,$link);
	
	for($i=0;$i<count($selected_mc_id_arr);$i++)
	{
		if($selected_mc_id_arr[$i] > 0)
		{
			$sql = "INSERT INTO `tblusersmc` (`user_id`,`mc_date`,`selected_mc_id`,`scale`,`remarks`,`my_target`,`adviser_target`,`mc_set_id`) VALUES ('".$user_id."','".$mc_date."','".$selected_mc_id_arr[$i]."','".$scale_arr[$i]."','".$remarks_arr[$i]."','".$my_target_arr[$i]."','".$adviser_target_arr[$i]."','".$mc_set_id."')";
			//echo"<br>".$sql;
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}	
	return $return;
}

function addUsersMRQuestion($user_id,$mr_date,$selected_mr_id_arr,$scale_arr,$remarks_arr,$my_target_arr,$adviser_target_arr,$mr_set_id)
{
	global $link;
	$return = false;
        
        if($mr_set_id == '' || $mr_set_id == '999999999')
        {
           $mr_set_id = '0'; 
        }
	
	$sql = "UPDATE `tblusersmr` SET `mr_old_data` = '1' WHERE `user_id` = '".$user_id."' AND  `mr_date` = '".$mr_date."' AND  `mr_set_id` = '".$mr_set_id."' ";
	$result = mysql_query($sql,$link);
	
	for($i=0;$i<count($selected_mr_id_arr);$i++)
	{
		if($selected_mr_id_arr[$i] > 0)
		{
			$sql = "INSERT INTO `tblusersmr` (`user_id`,`mr_date`,`selected_mr_id`,`scale`,`remarks`,`my_target`,`adviser_target`,`mr_set_id`) VALUES ('".$user_id."','".$mr_date."','".$selected_mr_id_arr[$i]."','".$scale_arr[$i]."','".$remarks_arr[$i]."','".$my_target_arr[$i]."','".$adviser_target_arr[$i]."','".$mr_set_id."')";
			//echo"<br>".$sql;
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}	
	return $return;
}

function addUsersMLEQuestion($user_id,$mle_date,$selected_mle_id_arr,$scale_arr,$remarks_arr,$my_target_arr,$adviser_target_arr,$mle_set_id)
{
	global $link;
	$return = false;
        
        if($mle_set_id == '' || $mle_set_id == '999999999')
        {
           $mle_set_id = '0'; 
        }
	
	$sql = "UPDATE `tblusersmle` SET `mle_old_data` = '1' WHERE `user_id` = '".$user_id."' AND  `mle_date` = '".$mle_date."' AND  `mle_set_id` = '".$mle_set_id."' ";
	$result = mysql_query($sql,$link);
	
	for($i=0;$i<count($selected_mle_id_arr);$i++)
	{
		if($selected_mle_id_arr[$i] > 0)
		{
			$sql = "INSERT INTO `tblusersmle` (`user_id`,`mle_date`,`selected_mle_id`,`scale`,`remarks`,`my_target`,`adviser_target`,`mle_set_id`) VALUES ('".$user_id."','".$mle_date."','".$selected_mle_id_arr[$i]."','".$scale_arr[$i]."','".$remarks_arr[$i]."','".$my_target_arr[$i]."','".$adviser_target_arr[$i]."','".$mle_set_id."')";
			//echo"<br>".$sql;
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}	
	return $return;
}

function addUsersAdctQuestion($user_id,$adct_date,$selected_adct_id_arr,$scale_arr,$remarks_arr,$my_target_arr,$adviser_target_arr,$adct_set_id)
{
	global $link;
	$return = false;
        
        if($adct_set_id == '' || $adct_set_id == '999999999')
        {
           $adct_set_id = '0'; 
        }
	
	$sql = "UPDATE `tblusersadct` SET `adct_old_data` = '1' WHERE `user_id` = '".$user_id."' AND  `adct_date` = '".$adct_date."' AND  `adct_set_id` = '".$adct_set_id."' ";
	$result = mysql_query($sql,$link);
	
	for($i=0;$i<count($selected_adct_id_arr);$i++)
	{
		if($selected_adct_id_arr[$i] > 0)
		{
			$sql = "INSERT INTO `tblusersadct` (`user_id`,`adct_date`,`selected_adct_id`,`scale`,`remarks`,`my_target`,`adviser_target`,`adct_set_id`) VALUES ('".$user_id."','".$adct_date."','".$selected_adct_id_arr[$i]."','".$scale_arr[$i]."','".$remarks_arr[$i]."','".$my_target_arr[$i]."','".$adviser_target_arr[$i]."','".$adct_set_id."')";
                        //echo"<br>".$sql;
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}	
	return $return;
}

function addUsersBES($user_id,$bes_date,$bms_id_arr,$scale_arr,$remarks_arr,$bes_time_arr,$bes_duration_arr,$my_target_arr,$adviser_target_arr)
{
	global $link;
	$return = false;
        
        $sql = "UPDATE `tblusersbes` SET `bes_old_data` = '1' WHERE `user_id` = '".$user_id."' AND  `bes_date` = '".$bes_date."' ";
	$result = mysql_query($sql,$link);
	
	for($i=0;$i<count($bms_id_arr);$i++)
	{
		if($bms_id_arr[$i] > 0)
		{
			$sql = "INSERT INTO `tblusersbes` (`user_id`,`bes_date`,`bms_id`,`scale`,`remarks`,`bes_time`,`bes_duration`,`my_target`,`adviser_target`) "
                                . "VALUES ('".$user_id."','".$bes_date."','".$bms_id_arr[$i]."','".$scale_arr[$i]."','".$remarks_arr[$i]."',"
                                . "'".$bes_time_arr[$i]."','".$bes_duration_arr[$i]."','".$my_target_arr[$i]."','".$adviser_target_arr[$i]."')";
                        //echo"<br>".$sql;
			$result = mysql_query($sql,$link);
			if($result)
			{
				$return = true;	
			}
		}	
	}	
	return $return;
}

function addUsersMDT($user_id,$bes_date,$bms_id_arr,$bms_type_arr,$scale_arr,$bes_time,$bes_duration,$trigger_id_arr,$trigger_type_arr,$scale_t_arr,$remarks_t_arr)
{
	global $link;
	$return = false;
        
        //$sql = "UPDATE `tblusersbes` SET `bes_old_data` = '1' WHERE `user_id` = '".$user_id."' AND  `bes_date` = '".$bes_date."' ";
	//$result = mysql_query($sql,$link);
	
	for($i=0;$i<count($bms_id_arr);$i++)
	{
            if($bms_id_arr[$i] > 0)
            {
                $sql = "INSERT INTO `tblusersmdt` (`user_id`,`mdt_date`,`bms_id`,`bms_type`,`bms_entry_type`,`scale`,`mdt_time`,`mdt_duration`) "
                        . "VALUES ('".$user_id."','".$bes_date."','".$bms_id_arr[$i]."','".$bms_type_arr[$i]."','situation','".$scale_arr[$i]."',"
                        . "'".$bes_time."','".$bes_duration."')";
                //echo"<br>".$sql;
                $result = mysql_query($sql,$link);
                if($result)
                {
                    $return = true;	
                }
            }	
	}	
        
        for($i=0;$i<count($trigger_id_arr);$i++)
	{
            if($trigger_id_arr[$i] > 0)
            {
                $sql = "INSERT INTO `tblusersmdt` (`user_id`,`mdt_date`,`bms_id`,`bms_type`,`bms_entry_type`,`scale`,`remarks`,`mdt_time`,`mdt_duration`) "
                        . "VALUES ('".$user_id."','".$bes_date."','".$trigger_id_arr[$i]."','".$trigger_type_arr[$i]."','trigger','".$scale_t_arr[$i]."',"
                        . "'".addslashes($remarks_t_arr[$i])."','".$bes_time."','".$bes_duration."')";
                //echo"<br>".$sql;
                $result = mysql_query($sql,$link);
                if($result)
                {
                    $return = true;	
                }
            }	
	}	
	return $return;
}

function updateUsersMDT($user_id,$bes_date,$arr_bms_id,$arr_bms_type,$arr_bms_entry_type,$arr_scale,$arr_remarks,$arr_mdt_time,$arr_mdt_duration)
{
	global $link;
	$return = false;
        
        $sql = "UPDATE `tblusersmdt` SET `mdt_old_data` = '1' WHERE `user_id` = '".$user_id."' AND  `mdt_date` = '".$bes_date."' ";
	$result = mysql_query($sql,$link);
	
	for($i=0;$i<count($arr_bms_id);$i++)
	{
            
            $sql = "INSERT INTO `tblusersmdt` (`user_id`,`mdt_date`,`bms_id`,`bms_type`,`bms_entry_type`,`scale`,`remarks`,`mdt_time`,`mdt_duration`) "
                    . "VALUES ('".$user_id."','".$bes_date."','".$arr_bms_id[$i]."','".$arr_bms_type[$i]."','".$arr_bms_entry_type[$i]."',"
                    . "'".$arr_scale[$i]."','".addslashes($arr_remarks[$i])."','".addslashes($arr_mdt_time[$i])."','".addslashes($arr_mdt_duration[$i])."')";
            //echo"<br>".$sql;
            $result = mysql_query($sql,$link);
            if($result)
            {
                $return = true;	
            }
            	
	}	
        
        
	return $return;
}

function chkHeightExists($height_cms)
{
	global $link;
	$return = false;
	
	$sql = "SELECT * FROM `tblheights` WHERE `height_cms` = '".$height_cms."' ";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$return = true;
	}
	return $return;
}

function getCityOptions($state_id,$city_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblcities` WHERE `state_id` = '".$state_id."' ORDER BY `city` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if($row['city_id'] == $city_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['city_id'].'" '.$sel.'>'.stripslashes($row['city']).'</option>';
		}
	}
	return $option_str;
}

function getGoToPageDropdownOptions($pdm_id,$page_id)
{
	global $link;
	$option_str = '';		
        
        $sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '".$pdm_id."' AND `pd_deleted` = '0' ";
        $result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
        {
            $row = mysql_fetch_array($result);
            $page_id_str = stripslashes($row['page_id_str']);
	
            $sql = "SELECT * FROM `tblpages` WHERE `page_id` IN (".$page_id_str.") AND `show_in_list` = '1' ORDER BY `menu_title` ASC";    
            $result = mysql_query($sql,$link);
            if( ($result) && (mysql_num_rows($result) > 0) )
            {
                while($row = mysql_fetch_array($result) ) 
                {
                    if($row['page_id'] == $page_id)
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['page_id'].'" '.$sel.'>'.stripslashes($row['menu_title']).'</option>';
                }
            }
        }
	return $option_str;
}

function getPlaceOptions($state_id,$city_id,$place_id)
{
	global $link;
	$option_str = '';		
	
	$sql = "SELECT * FROM `tblplaces` WHERE `state_id` = '".$state_id."' AND `city_id` = '".$city_id."' ORDER BY `place` ASC";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result) ) 
		{
			if($row['place_id'] == $place_id)
			{
				$sel = ' selected ';
			}
			else
			{
				$sel = '';
			}		
			$option_str .= '<option value="'.$row['place_id'].'" '.$sel.'>'.stripslashes($row['place']).'</option>';
		}
	}
	return $option_str;
}

function getPageContents($page_id)
{
	global $link;
	$page_contents = '';
	
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$temp = stripslashes($row['page_contents']);
		$temp = str_replace('&nbsp;',' ',$temp);
		$page_contents = html_entity_decode ($temp);
	}
	return $page_contents;
}

function getPageContents2($page_id)
{
	global $link;
	$page_contents = '';
	
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$temp = stripslashes($row['page_contents2']);
		$temp = str_replace('&nbsp;',' ',$temp);
		$page_contents = html_entity_decode ($temp);
	}
	return $page_contents;
}

function getPageName($page_id)
{
	global $link;
	$page_name = '';
	
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$page_name = stripslashes($row['page_name']);
	}
	return $page_name;
}

function getMenuLink($page_id)
{
	global $link;
	$menu_link = '';
	
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$menu_link = stripslashes($row['menu_link']);
	}
	return $menu_link;
}

function getPageTitle($page_id)
{
	global $link;
	$page_title = '';
	
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$page_title = stripslashes($row['page_title']);
	}
	return $page_title;
}


function getPageDetails($page_id)
{
	global $link;
	$page_name = '';
	$page_title = '';
	$page_contents = '';
        $page_contents2 = '';
	$meta_title = '';
	$meta_keywords = '';
	$meta_description = '';
	$menu_title = '';
	$menu_link = '';
	$link_enable = 0;
	$parent_menu = 0;
	
	$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";
	//echo '<br>Testkk: sql = '.$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_array($result);
		$page_name = stripslashes($row['page_name']);
		$page_title = stripslashes($row['page_title']);
		$page_contents = stripslashes($row['page_contents']);
                $page_contents2 = stripslashes($row['page_contents2']);
		$meta_title = stripslashes($row['meta_title']);
		$meta_keywords = stripslashes($row['meta_keywords']);
		$meta_description = stripslashes($row['meta_description']);
		$menu_title = stripslashes($row['menu_title']);
		$menu_link = stripslashes($row['menu_link']);
		$link_enable = stripslashes($row['link_enable']);
		$parent_menu = stripslashes($row['parent_menu']);
		
		//echo '<br>menu_title = '.$menu_title;
	}
	
	
	return array($page_name,$page_title,$page_contents,$meta_title,$meta_keywords,$meta_description,$menu_title,$menu_link,$link_enable,$parent_menu,$page_contents2);
}

function getTimeOptions($start_time,$end_time,$time)
{
	$start = $start_time *60 + 0;
	$end = $end_time * 60+0;
	
	for($i = $start; $i<$end; $i += 15)
	{
		
		$minute = $i % 60;
		$hour = ($i - $minute)/60;
		
		
		if( ($hour >=24) && ($hour <= 36) )
		{
			$hour = $hour - 24;
		}
		
		
		if( ($hour >= 0) && ($hour < 12)  )
		{
			$str = 'AM';
		}
		else
		{
			$str = 'PM';
		} 
				
		$val = sprintf('%02d:%02d', $hour, $minute);
		
		$val = $val.' '.$str;
		if($time == $val)
		{
			$selected = ' selected ';
		}
		else
		{
			$selected = '';
		}
		$option_str .= '<option value="'.$val.'" '.$selected.' >'.$val.'</option>';
	} 
	return $option_str;
}

function getTimeOptionsNew($start_time,$end_time,$time)
{
	if($end_time == $start_time)
	{
		
	}
	elseif($end_time < $start_time)
	{
		$end_time = 24 + $end_time;
		$start = $start_time *60 + 0;
		$end = $end_time * 60+0;
		
		$i = $start;
		while($i<$end)
		{
			$minute = $i % 60;
			$hour = ($i - $minute)/60;
			
			if($hour > 23)
			{
				$hour = $hour - 24;
			}
			
			
			if( ($hour >= 0) && ($hour < 12)  )
			{
				$str = 'AM';
			}
			else
			{
				$str = 'PM';
			} 
					
			$val = sprintf('%02d:%02d', $hour, $minute);
			
			$val = $val.' '.$str;
			if($time == $val)
			{
				$selected = ' selected ';
			}
			else
			{
				$selected = '';
			}
			$option_str .= '<option value="'.$val.'" '.$selected.' >'.$val.'</option>';
			$i = $i + 15;
		} 
	}
	else
	{
		$start = $start_time *60 + 0;
		$end = $end_time * 60+0;
		
		for($i = $start; $i<$end; $i += 15)
		{
			
			$minute = $i % 60;
			$hour = ($i - $minute)/60;
			
			
			if( ($hour >=24) && ($hour <= 36) )
			{
				$hour = $hour - 24;
			}
			
			
			if( ($hour >= 0) && ($hour < 12)  )
			{
				$str = 'AM';
			}
			else
			{
				$str = 'PM';
			} 
					
			$val = sprintf('%02d:%02d', $hour, $minute);
			
			$val = $val.' '.$str;
			if($time == $val)
			{
				$selected = ' selected ';
			}
			else
			{
				$selected = '';
			}
			$option_str .= '<option value="'.$val.'" '.$selected.' >'.$val.'</option>';
		} 
	}	
	return $option_str;
}

function getSkipTimeOptions($start_time,$end_time,$time)
{
	if($end_time == $start_time)
	{
		
	}
	elseif($end_time < $start_time)
	{
		$end_time = 24 + $end_time;
		$start = $start_time *60 + 0;
		$end = $end_time * 60+0;
		
		$i = $start;
		while($i<$end)
		{
			$minute = $i % 60;
			$hour = ($i - $minute)/60;
			
			if($hour > 23)
			{
				$hour = $hour - 24;
			}
			
			
			if( ($hour >= 0) && ($hour < 12)  )
			{
				$str = 'AM';
			}
			else
			{
				$str = 'PM';
			} 
					
			$val = sprintf('%02d:%02d', $hour, $minute);
			
			$val = $val.' '.$str;
			if($time == $val)
			{
				$selected = ' selected ';
			}
			else
			{
				$selected = '';
			}
			$option_str .= '<option value="'.$val.'" '.$selected.' >'.$val.'</option>';
			$i = $i + 5;
		} 
	}
	else
	{
		$org_start_time = $start_time;
		$tmp_str = explode(" ",$start_time);
		$temp_time = explode(":",$tmp_str[0]);
		$start_time = $temp_time[0];
		
		$start = $start_time *60 + 0;
		$end = $end_time * 60+0;
		
		for($i = $start; $i<$end; $i += 5)
		{
			
			$minute = $i % 60;
			$hour = ($i - $minute)/60;
			
			
			if( ($hour >=24) && ($hour <= 36) )
			{
				$hour = $hour - 24;
			}
			
			if( ($hour >= 0) && ($hour < 12)  )
			{
				$str = 'AM';
			}
			else
			{
				$str = 'PM';
			} 
					
			$val = sprintf('%02d:%02d', $hour, $minute);
			
			$val = $val.' '.$str;
			if(chkIsGreaterTimeValue($val,$org_start_time))
			{
				if($time == $val)
				{
					$selected = ' selected ';
				}
				else
				{
					$selected = '';
				}
				$option_str .= '<option value="'.$val.'" '.$selected.' >'.$val.'</option>';
			}	
		} 
	}	
	return $option_str;
}

function getYesterdayLastActivityTime($user_id,$yesterday_date)
{
	global $link;
	$last_activity_time = '23:45 PM';
	
	$sql = "SELECT * FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` = '".$yesterday_date."' ORDER BY `activity_add_date` LIMIT 1";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			$last_activity_time = $row['activity_time'];
		}	
	}
	return $last_activity_time;
}

function chkIsGreaterTimeValue($first_time,$second_time)
{
	$return = true;
	//echo"<br>Testkk first_time = ".$first_time;
	//echo"<br>Testkk second_time = ".$second_time;
	if( ($first_time != '') && ($second_time != '') )
	{
		$tmp_first_time_str = explode(" ",$first_time);
		$tmp_first_time = explode(":",$tmp_first_time_str[0]);
		$first_time_hr = $tmp_first_time[0];
		$first_time_min = $tmp_first_time[1];
		
		$tmp_second_time_str = explode(" ",$second_time);
		$tmp_second_time = explode(":",$tmp_second_time_str[0]);
		$second_time_hr = $tmp_second_time[0];
		$second_time_min = $tmp_second_time[1];
		
		if($first_time_hr == $second_time_hr)
		{
			if($first_time_min >= $second_time_min)
			{
				$return = true;
			}
			else
			{
				$return = false;
			}
		}
		elseif($first_time_hr > $second_time_hr)
		{
			$return = true;
		}
		else
		{
			$return = false;
		}
	}
	return $return;
}

function convertMinutesToTimeFormat($tmp_next_start_time)
{
	$minute = $tmp_next_start_time % 60;
	$hour = ($tmp_next_start_time - $minute)/60;
	
	
	if( ($hour >=24) && ($hour <= 36) )
	{
		$hour = $hour - 24;
	}
	
	
	if( ($hour >= 0) && ($hour < 12)  )
	{
		$str = 'AM';
	}
	else
	{
		$str = 'PM';
	} 
			
	$val = sprintf('%02d:%02d', $hour, $minute);
	
	$val = $val.' '.$str;
	return $val;
}

function convertTimeFormatToMinutes($str_time)
{
	$tmp_time = explode(":",$str_time);
	$hr_time = $tmp_time[0];
	
	$tmp_min = explode(" ",$tmp_time[1]);
	$min_time = $tmp_min[0];
	
	$val = $hr_time * 60 + 0 + $min_time;
	
	return $val;
}

function getDurationBetweenTwoTimes($time1,$time2)
{
    $duration = 0;
    
    $time_in_mins1 = convertTimeFormatToMinutes($time1);
    $time_in_mins2 = convertTimeFormatToMinutes($time2);
    
    if($time_in_mins1 > $time_in_mins2)
    {
        $duration = (1440 - $time_in_mins1) + $time_in_mins2;
    }
    elseif($time_in_mins1 < $time_in_mins2)
    {
        $duration = $time_in_mins2 - $time_in_mins1;
    }
    
    if($duration > 0)
    {
        if($duration > 59)
        {
            $hours = floor($duration / 60);
            $minutes = ($duration % 60);
            if($minutes > 0)
            {
                $duration = $hours.' Hrs '.$minutes.' Mins';  
            }
            else
            {
                $duration = $hours.' Hrs';
            }    
        }
        else
        {
            $duration = $duration.' Mins'; 
        }
    }
    else
    {
       $duration = $duration.' Mins'; 
    }
    
    return $duration;
}
	
function getActivityTimeList($actvity_start_time,$actvity_end_time,$time_interval,$mins_arr,$skip_time_arr)
{
	$arr_activity_time = array();
	
	//echo"<br>Testkk: actvity_start_time = ".$actvity_start_time;
	//echo"<br>Testkk: actvity_end_time = ".$actvity_end_time;
	//echo"<br>Testkk: time_interval = ".$time_interval;
	
	//echo"<br>Testkk: mins_arr - <br>";
	//debug_array($mins_arr);	
	//echo"<br><br>";
	
	//echo"<br>Testkk: skip_time_arr - <br>";
	//debug_array($skip_time_arr);	
	//echo"<br><br>";
	
	//echo"<br>Testkk: skip_time_arr[0] = ".$skip_time_arr[0];
	if($skip_time_arr[0] == '')
	{
		$tmp_start_time = explode(":",$actvity_start_time);
		$start_time = $tmp_start_time[0];
	
		$tmp_start_min = explode(" ",$tmp_start_time[1]);
		$start_min = $tmp_start_min[0];
	
		$tmp_end_time = explode(":",$actvity_end_time);
		$end_time = $tmp_end_time[0];
	}
	else
	{
		if($actvity_start_time == $skip_time_arr[0])
		{
			$tmp_start_time = explode(":",$actvity_start_time);
			$start_time = $tmp_start_time[0];
		
			$tmp_start_min = explode(" ",$tmp_start_time[1]);
			$start_min = $tmp_start_min[0];
		
			$tmp_end_time = explode(":",$actvity_end_time);
			$end_time = $tmp_end_time[0];
		}
		elseif(chkIsGreaterTimeValue($actvity_start_time,$skip_time_arr[0]))
		{
			$tmp_start_time = explode(":",$actvity_start_time);
			$start_time = $tmp_start_time[0];
		
			$tmp_start_min = explode(" ",$tmp_start_time[1]);
			$start_min = $tmp_start_min[0];
		
			$tmp_end_time = explode(":",$actvity_end_time);
			$end_time = $tmp_end_time[0];
		}
		else
		{
			$tmp_start_time = explode(":",$skip_time_arr[0]);
			$start_time = $tmp_start_time[0];
		
			$tmp_start_min = explode(" ",$tmp_start_time[1]);
			$start_min = $tmp_start_min[0];
		
			$tmp_end_time = explode(":",$actvity_end_time);
			$end_time = $tmp_end_time[0];
		}	
	}	
	
	//echo"<br>Testkk: start_time = ".$start_time;
	//echo"<br>Testkk: start_min = ".$start_min;
	//echo"<br>Testkk: end_time = ".$end_time;
	
	$start = $start_time *60 + 0 + $start_min;
	$end = $end_time * 60+0;
	
	//echo"<br>Testkk: start = ".$start;
	//echo"<br>Testkk: end = ".$end;
	
	$tmp_next_start_time = $start;
	
	$arr_new_activity_time = array();
	
	
	for($i=0;$i<count($mins_arr);$i++)
	{
		if($i == '0')
		{
			if($skip_time_arr[$i] == '')
			{
			
			}
			else
			{
				$tmp_next_start_time = convertTimeFormatToMinutes($skip_time_arr[$i]);	
			}
			
			$val = convertMinutesToTimeFormat($tmp_next_start_time);
			array_push($arr_new_activity_time,$val);
		}
		else
		{
			if( ($mins_arr[$i-1] == '0') || ($mins_arr[$i-1] == '') )
			{
				break;
			}
			else
			{	
				if($skip_time_arr[$i] == '')
				{
					$tmp_next_start_time = $tmp_next_start_time + $mins_arr[$i-1];
				}
				else
				{
					//$tmp_next_start_time = convertTimeFormatToMinutes($skip_time_arr[$i]) + $mins_arr[$i-1];	
					$tmp_next_start_time = convertTimeFormatToMinutes($skip_time_arr[$i]);	
				}
				
				$val = convertMinutesToTimeFormat($tmp_next_start_time);
				array_push($arr_new_activity_time,$val);
			}	
		}
	}
	
	if( ($mins_arr[$i-1] == '0') || ($mins_arr[$i-1] == '') )
	{
		
	}
	else
	{	
		$tmp_next_start_time = $tmp_next_start_time + $mins_arr[$i-1];
		$val = convertMinutesToTimeFormat($tmp_next_start_time);
		array_push($arr_new_activity_time,$val);
	}	
	
	
	//echo"<br>Testkk: arr_new_activity_time - <br>";
	//debug_array($arr_new_activity_time);	
	//echo"<br><br>";
	
	return $arr_new_activity_time;
}

function getActivitiesRows($today_wakeup_time,$mins_arr,$activity_id_arr,$other_activity_arr,$proper_guidance_arr,$precaution_arr,$tr_err_activity,$err_activity,$skip_time_arr)
{
	//debug_array($skip_time_arr);
	$today_end_time = '24:00 PM';
	$ret_str = '';
	$ret_str .='<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="15%" height="30" align="center" valign="middle" bgcolor="#CCCCCC" ><strong>Time</strong></td>
							<td width="15%" height="30" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
							<td width="35%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>Activity</strong></td>
							<td width="35%" height="30" align="center" valign="middle" bgcolor="#CCCCCC"><strong>Duration</strong></td>
						</tr>
						<tr>
							<td height="30" colspan="4">&nbsp;</td>
						</tr>';
	if($today_wakeup_time != '')
	{
		$arr_activity_time = getActivityTimeList($today_wakeup_time,$today_end_time,15,$mins_arr,$skip_time_arr);
		//debug_array($arr_activity_time);	
		for($i=0;$i<count($arr_activity_time);$i++)
		{								
			if($i == 0)
			{
				$skip_time_start = $today_wakeup_time;
			}
			else
			{
				$temp_prev_activity_time = $arr_activity_time[$i-1];
				$temp_prev_activity_time = explode(" ",$temp_prev_activity_time);
				$temp_prev_activity_time = $temp_prev_activity_time[0];
				
				$temp_prev_mins = $mins_arr[$i-1];
				$temp_time = strtotime($temp_prev_activity_time);
				$skip_time_start = date("H:i A", strtotime('+'.$temp_prev_mins.' minutes', $temp_time));
				
				//echo"<br>Testkk: temp_prev_activity_time = ".$temp_prev_activity_time;
				//echo"<br>Testkk: temp_prev_mins = ".$temp_prev_mins;
				//echo"<br>Testkk: skip_time_start = ".$skip_time_start;
				//$skip_time_start = $arr_activity_time[$i];
			}	
			
		$ret_str .='	<tr id="tr1_'.$i.'">
							<td colspan="4" height="45" align="left" valign="middle" >
								<span><strong>Skip Time to</strong></span>
								<span>
									<select name="skip_time[]" id="skip_time_'.$i.'" class="skip_time">
										<option value="">Select Time</option>
										'.getSkipTimeOptions($skip_time_start,'24',$skip_time_arr[$i]).'
									</select>
								</span>
							</td>
						</tr>';
		$ret_str .='	<tr id="tr2_'.$i.'">
							<td height="45" align="center" valign="middle" >
								<strong>'.$arr_activity_time[$i].'</strong><input type="hidden" name="activity_time[]" id="activity_time_'.$i.'" value="'.$arr_activity_time[$i].'" />
							</td>
							<td height="45" align="center" valign="middle" >-</td>
							<td height="45" align="left" valign="middle" >
								<input name="activity_id[]" type="text" class="input_activity" id="activity_id_'.$i.'" size="58" value="" />
							</td>
							<td height="45" align="center" valign="middle">';
							
		/* // old minute selectbox 
		$ret_str .='			<select name="mins[]" id="mins_'.$i.'" class="mins">
									<option value="0">Select Duration</option>';
									$j = 15;
									while($j <= 300)
									{
										if($mins_arr[$i] == $j)
										{
											$sel = ' selected ';
										}
										else
										{
											$sel = '';
										}	
		$ret_str .='				<option value="'.$j.'" '.$sel.'>'.$j.' Mins</option>';
								$j = $j + 15;
								}	
		$ret_str .='			</select>';
		 */
		 
		$ret_str .='		<strong>Duration in Mins</strong>&nbsp<input style="width:30px;" type="text" maxlength="3" name="mins[]" id="mins_'.$i.'" value="'.$mins_arr[$i].'" class="mins"><input type="button" class="btnnew" name="btngetactivityrows[]" id="btngetactivityrows_'.$i.'" value="Set" style="width:30px;" >'; 
		                      
		$ret_str .='		</td>
						</tr>';				
						if($activity_id_arr[$i] == '9999999999')
						{
							$tr_other_activity = '';
						}
						else
						{
							$tr_other_activity = 'none';
						}
		$ret_str .='	<tr id="tr3_'.$i.'" style="display:'.$tr_other_activity.'">
							<td align="left" valign="middle" colspan="2">&nbsp;</td>';
		$ret_str .='		<td height="35" align="left" valign="bottom" colspan="2">
								<input name="other_activity[]" type="text" class="input" id="other_activity_'.$i.'" value="'.$other_activity_arr[$i].'" />
							</td>
						</tr>';					
		$ret_str .='	<tr id="tr4_'.$i.'">
							<td align="left" valign="middle" colspan="2">&nbsp;</td>';
		$ret_str .='		<td height="35" align="left" valign="bottom" colspan="2">Do you do under proper guidance?</td>
						</tr>';	
		$ret_str .='	<tr id="tr5_'.$i.'">
							<td height="30" align="left" valign="middle" colspan="2">&nbsp;</td>';
		$ret_str .='		<td height="30" align="left" valign="middle" colspan="2">';
								
								if($proper_guidance_arr[$i] == '1')
								{
									$chked1 = ' checked="checked" ';
									$chked2 = '';
								}
								elseif($proper_guidance_arr[$i] == '0')
								{
									$chked1 = '';
									$chked2 = ' checked="checked" ';
								}
								else
								{
									$chked1 = '';
									$chked2 = '';
								}	
		$ret_str .='			<input type="radio" name="proper_guidance_'.$i.'[]" id="proper_guidance_'.$i.'" value="1" '.$chked1.' />Yes &nbsp;';
		$ret_str .='			<input type="radio" name="proper_guidance_'.$i.'[]" id="proper_guidance_'.$i.'" value="0" '.$chked2.' />No
							</td>
						</tr>';	
		$ret_str .='	<tr id="tr6_'.$i.'">
							<td align="left" valign="middle" colspan="2">&nbsp;</td>';
		$ret_str .='		<td align="left" valign="middle" colspan="2">
								<textarea name="precaution[]" id="precaution_'.$i.'" cols="25" rows="3">'.$precaution_arr[$i].'</textarea>
							</td>
						</tr>';	
		$ret_str .='	<tr id="tr7_'.$i.'">
							<td align="left" valign="middle" colspan="2">&nbsp;</td>';
		$ret_str .='		<td align="left" valign="middle" colspan="2">
								(Including any Precaution taken)
							</td>
						</tr>';	
		$ret_str .='	<tr id="tr8_'.$i.'"  style="display:'.$tr_err_activity[$i].'">
							<td height="20" align="left" valign="middle" colspan="4" class="err_msg">'.$err_activity[$i].'</td>
						</tr>';	
		$ret_str .='	<tr id="tr9_'.$i.'">
							<td height="20" align="left" valign="middle" class="border_bottom" colspan="4">&nbsp;</td>
						</tr>';	
		}	
	}
	$ret_str .='</table>';	
	return $ret_str;	
}

function debug_array($arr)
{
	echo"<br><pre>";
	print_r($arr);
	echo"</br></pre>";
}

function getUsersDailyMealsDetails($user_id,$meal_date)
{
	global $link;
	
	$arr_user_meal_id = array(); 
	$arr_meal_date = array(); 
	$arr_meal_time = array(); 
	$arr_meal_id = array(); 
	$arr_meal_others = array(); 
	$arr_meal_like = array(); 
	$arr_meal_quantity = array(); 
	$arr_meal_measure = array(); 
	$arr_meal_consultant_remark = array();
	$arr_meal_type = array();
		
	$sql = "SELECT * FROM `tblusersmeals` WHERE `user_id` = '".$user_id."' AND `meal_date` = '".$meal_date."' AND `meal_time` != '' ORDER BY `user_meal_id` ASC";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($arr_user_meal_id , $row['user_meal_id']);
			array_push($arr_meal_date , stripslashes($row['meal_date']));
			array_push($arr_meal_time , stripslashes($row['meal_time']));
			array_push($arr_meal_id , stripslashes($row['meal_id']));
			array_push($arr_meal_others , stripslashes($row['meal_others']));
			array_push($arr_meal_like , stripslashes($row['meal_like']));
			array_push($arr_meal_quantity , stripslashes($row['meal_quantity']));
			array_push($arr_meal_measure , stripslashes($row['meal_measure']));
			array_push($arr_meal_consultant_remark , stripslashes($row['meal_consultant_remark']));
			array_push($arr_meal_type , stripslashes($row['meal_type']));
		}	
	}
	return array($arr_user_meal_id,$arr_meal_date,$arr_meal_time,$arr_meal_id,$arr_meal_others,$arr_meal_like,$arr_meal_quantity,$arr_meal_measure,$arr_meal_consultant_remark,$arr_meal_type);

}

function getUsersDailyActivityDetails($user_id,$activity_date)
{
	global $link;
	
	$yesterday_sleep_time = '';
	$today_wakeup_time = '';
	$activity_time_arr = array();
	$mins_arr = array(); 
	$activity_id_arr = array(); 
	$other_activity_arr = array(); 
	$proper_guidance_arr = array(); 
	$precaution_arr = array(); 
			
	$sql = "SELECT * FROM `tblusersdailyactivity` WHERE `user_id` = '".$user_id."' AND `activity_date` = '".$activity_date."' AND `activity_time` != '' ORDER BY `user_activity_id` ASC";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			$yesterday_sleep_time = $row['yesterday_sleep_time'];
			$today_wakeup_time = $row['today_wakeup_time'];
			array_push($activity_time_arr , $row['activity_time']);
			array_push($mins_arr , $row['mins']);
			array_push($activity_id_arr , stripslashes($row['activity_id']));
			array_push($other_activity_arr , stripslashes($row['other_activity']));
			array_push($proper_guidance_arr , stripslashes($row['proper_guidance']));
			array_push($precaution_arr , stripslashes($row['precaution']));
		}	
	}
	return array($yesterday_sleep_time,$today_wakeup_time,$mins_arr,$activity_id_arr,$other_activity_arr,$proper_guidance_arr,$precaution_arr,$activity_time_arr);

}

function getUsersWAEQuestionDetails($user_id,$wae_date,$wae_set_id)
{
	global $link;
	
	$selected_wae_id_arr = array(); 
	$scale_arr = array(); 
	$remarks_arr = array(); 
        $my_target_arr = array(); 
        $adviser_target_arr = array(); 
        
        if($wae_set_id == '999999999')
        {
            $sql_str_pro = " AND `wae_set_id` = '0' ";
        }
        elseif($wae_set_id == '')
        {
            $sql_str_pro = "";
        }
        else
        {
            $sql_str_pro = " AND `wae_set_id` = '".$wae_set_id."' ";
        }
			
        $sql = "SELECT * FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_date` = '".$wae_date."' AND `wae_old_data` = '0' ".$sql_str_pro." ORDER BY `selected_wae_id` ASC";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($selected_wae_id_arr , $row['selected_wae_id']);
			array_push($scale_arr , stripslashes($row['scale']));
			array_push($remarks_arr , stripslashes($row['remarks']));
                        array_push($my_target_arr , stripslashes($row['my_target']));
                        array_push($adviser_target_arr , stripslashes($row['adviser_target']));
		}	
	}
	return array($scale_arr,$remarks_arr,$selected_wae_id_arr,$my_target_arr,$adviser_target_arr);

}

function getUsersLastMyTargetWAEValue($user_id,$wae_set_id,$selected_wae_id)
{
	global $link;
	
	$my_target = ''; 
        $adviser_target = ''; 
        
        if($wae_set_id == '999999999')
        {
            $sql_str_pro = " AND `wae_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `wae_set_id` = '".$wae_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_old_data` = '0' AND `selected_wae_id` = '".$selected_wae_id."' ".$sql_str_pro." ORDER BY `wae_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $adviser_target = stripslashes($row['adviser_target']);
    	}
	return array($my_target,$adviser_target);

}

function getUsersLastMyTargetWAEDateString($user_id,$wae_set_id,$selected_wae_id)
{
	global $link;
	
	$output = '';
        
        if($wae_set_id == '999999999')
        {
            $sql_str_pro = " AND `wae_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `wae_set_id` = '".$wae_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_old_data` = '0' AND `selected_wae_id` = '".$selected_wae_id."' ".$sql_str_pro." ORDER BY `wae_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $my_target_date = stripslashes($row['user_wae_add_date']);
            if($my_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($my_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersLastAdviserTargetWAEDateString($user_id,$wae_set_id,$selected_wae_id)
{
	global $link;
	
	$output = '';
        
        if($wae_set_id == '999999999')
        {
            $sql_str_pro = " AND `wae_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `wae_set_id` = '".$wae_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tbluserswae` WHERE `user_id` = '".$user_id."' AND `wae_old_data` = '0' AND `selected_wae_id` = '".$selected_wae_id."' ".$sql_str_pro." ORDER BY `wae_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $adviser_target = stripslashes($row['adviser_target']);
            $adviser_target_date = stripslashes($row['user_wae_add_date']);
            if($adviser_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($adviser_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersGSQuestionDetails($user_id,$gs_date,$gs_set_id)
{
	global $link;
	
	$selected_gs_id_arr = array(); 
	$scale_arr = array(); 
	$remarks_arr = array(); 
        $my_target_arr = array(); 
        $adviser_target_arr = array(); 
        
        if($gs_set_id == '999999999')
        {
            $sql_str_pro = " AND `gs_set_id` = '0' ";
        }
        elseif($gs_set_id == '')
        {
            $sql_str_pro = "";
        }
        else
        {
            $sql_str_pro = " AND `gs_set_id` = '".$gs_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_date` = '".$gs_date."' AND `gs_old_data` = '0' ".$sql_str_pro." ORDER BY `selected_gs_id` ASC";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($selected_gs_id_arr , $row['selected_gs_id']);
			array_push($scale_arr , stripslashes($row['scale']));
			array_push($remarks_arr , stripslashes($row['remarks']));
                        array_push($my_target_arr , stripslashes($row['my_target']));
                        array_push($adviser_target_arr , stripslashes($row['adviser_target']));
		}	
	}
	return array($scale_arr,$remarks_arr,$selected_gs_id_arr,$my_target_arr,$adviser_target_arr);

}

function getUsersLastMyTargetGSValue($user_id,$gs_set_id,$selected_gs_id)
{
	global $link;
	
	$my_target = ''; 
        $adviser_target = ''; 
        
        if($gs_set_id == '999999999')
        {
            $sql_str_pro = " AND `gs_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `gs_set_id` = '".$gs_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_old_data` = '0' AND `selected_gs_id` = '".$selected_gs_id."' ".$sql_str_pro." ORDER BY `gs_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $adviser_target = stripslashes($row['adviser_target']);
    	}
	return array($my_target,$adviser_target);

}

function getUsersLastMyTargetGSDateString($user_id,$gs_set_id,$selected_gs_id)
{
	global $link;
	
	$output = '';
        
        if($gs_set_id == '999999999')
        {
            $sql_str_pro = " AND `gs_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `gs_set_id` = '".$gs_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_old_data` = '0' AND `selected_gs_id` = '".$selected_gs_id."' ".$sql_str_pro." ORDER BY `gs_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $my_target_date = stripslashes($row['user_gs_add_date']);
            if($my_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($my_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersLastAdviserTargetGSDateString($user_id,$gs_set_id,$selected_gs_id)
{
	global $link;
	
	$output = '';
        
        if($gs_set_id == '999999999')
        {
            $sql_str_pro = " AND `gs_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `gs_set_id` = '".$gs_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersgs` WHERE `user_id` = '".$user_id."' AND `gs_old_data` = '0' AND `selected_gs_id` = '".$selected_gs_id."' ".$sql_str_pro." ORDER BY `gs_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $adviser_target = stripslashes($row['adviser_target']);
            $adviser_target_date = stripslashes($row['user_gs_add_date']);
            if($adviser_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($adviser_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersSleepQuestionDetails($user_id,$sleep_date,$sleep_set_id)
{
	global $link;
	
	$selected_sleep_id_arr = array(); 
	$scale_arr = array(); 
	$remarks_arr = array(); 
        $my_target_arr = array(); 
        $adviser_target_arr = array(); 
        
        if($sleep_set_id == '999999999')
        {
            $sql_str_pro = " AND `sleep_set_id` = '0' ";
        }
        elseif($sleep_set_id == '')
        {
            $sql_str_pro = "";
        }
        else
        {
            $sql_str_pro = " AND `sleep_set_id` = '".$sleep_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_date` = '".$sleep_date."' AND `sleep_old_data` = '0' ".$sql_str_pro." ORDER BY `selected_sleep_id` ASC";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($selected_sleep_id_arr , $row['selected_sleep_id']);
			array_push($scale_arr , stripslashes($row['scale']));
			array_push($remarks_arr , stripslashes($row['remarks']));
                        array_push($my_target_arr , stripslashes($row['my_target']));
                        array_push($adviser_target_arr , stripslashes($row['adviser_target']));
		}	
	}
	return array($scale_arr,$remarks_arr,$selected_sleep_id_arr,$my_target_arr,$adviser_target_arr);

}

function getUsersLastMyTargetSleepValue($user_id,$sleep_set_id,$selected_sleep_id)
{
	global $link;
	
	$my_target = ''; 
        $adviser_target = ''; 
        
        if($sleep_set_id == '999999999')
        {
            $sql_str_pro = " AND `sleep_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `sleep_set_id` = '".$sleep_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_old_data` = '0' AND `selected_sleep_id` = '".$selected_sleep_id."' ".$sql_str_pro." ORDER BY `sleep_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $adviser_target = stripslashes($row['adviser_target']);
    	}
	return array($my_target,$adviser_target);
}

function getUsersLastMyTargetSleepDateString($user_id,$sleep_set_id,$selected_sleep_id)
{
	global $link;
	
	$output = '';
        
        if($sleep_set_id == '999999999')
        {
            $sql_str_pro = " AND `sleep_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `sleep_set_id` = '".$sleep_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_old_data` = '0' AND `selected_sleep_id` = '".$selected_sleep_id."' ".$sql_str_pro." ORDER BY `sleep_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $my_target_date = stripslashes($row['user_sleep_add_date']);
            if($my_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($my_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersLastAdviserTargetSleepDateString($user_id,$sleep_set_id,$selected_sleep_id)
{
	global $link;
	
	$output = '';
        
        if($sleep_set_id == '999999999')
        {
            $sql_str_pro = " AND `sleep_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `sleep_set_id` = '".$sleep_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tbluserssleep` WHERE `user_id` = '".$user_id."' AND `sleep_old_data` = '0' AND `selected_sleep_id` = '".$selected_sleep_id."' ".$sql_str_pro." ORDER BY `sleep_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $adviser_target = stripslashes($row['adviser_target']);
            $adviser_target_date = stripslashes($row['user_sleep_add_date']);
            if($adviser_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($adviser_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersMCQuestionDetails($user_id,$mc_date,$mc_set_id)
{
	global $link;
	
	$selected_mc_id_arr = array(); 
	$scale_arr = array(); 
	$remarks_arr = array(); 
        $my_target_arr = array(); 
        $adviser_target_arr = array(); 
        
        if($mc_set_id == '999999999')
        {
            $sql_str_pro = " AND `mc_set_id` = '0' ";
        }
        elseif($mc_set_id == '')
        {
            $sql_str_pro = "";
        }
        else
        {
            $sql_str_pro = " AND `mc_set_id` = '".$mc_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_date` = '".$mc_date."' AND `mc_old_data` = '0' ".$sql_str_pro." ORDER BY `selected_mc_id` ASC";
        //echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($selected_mc_id_arr , $row['selected_mc_id']);
			array_push($scale_arr , stripslashes($row['scale']));
			array_push($remarks_arr , stripslashes($row['remarks']));
                        array_push($my_target_arr , stripslashes($row['my_target']));
                        array_push($adviser_target_arr , stripslashes($row['adviser_target']));
		}	
	}
	return array($scale_arr,$remarks_arr,$selected_mc_id_arr,$my_target_arr,$adviser_target_arr);

}

function getUsersLastMyTargetMCValue($user_id,$mc_set_id,$selected_mc_id)
{
	global $link;
	
	$my_target = ''; 
        $adviser_target = ''; 
        
        if($mc_set_id == '999999999')
        {
            $sql_str_pro = " AND `mc_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `mc_set_id` = '".$mc_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_old_data` = '0' AND `selected_mc_id` = '".$selected_mc_id."' ".$sql_str_pro." ORDER BY `mc_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $adviser_target = stripslashes($row['adviser_target']);
    	}
	return array($my_target,$adviser_target);
}

function getUsersLastMyTargetMCDateString($user_id,$mc_set_id,$selected_mc_id)
{
	global $link;
	
	$output = '';
        
        if($mc_set_id == '999999999')
        {
            $sql_str_pro = " AND `mc_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `mc_set_id` = '".$mc_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_old_data` = '0' AND `selected_mc_id` = '".$selected_mc_id."' ".$sql_str_pro." ORDER BY `mc_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $my_target_date = stripslashes($row['user_mc_add_date']);
            if($my_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($my_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersLastAdviserTargetMCDateString($user_id,$mc_set_id,$selected_mc_id)
{
	global $link;
	
	$output = '';
        
        if($mc_set_id == '999999999')
        {
            $sql_str_pro = " AND `mc_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `mc_set_id` = '".$mc_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmc` WHERE `user_id` = '".$user_id."' AND `mc_old_data` = '0' AND `selected_mc_id` = '".$selected_mc_id."' ".$sql_str_pro." ORDER BY `mc_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $adviser_target = stripslashes($row['adviser_target']);
            $adviser_target_date = stripslashes($row['user_mc_add_date']);
            if($adviser_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($adviser_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersMRQuestionDetails($user_id,$mr_date,$mr_set_id)
{
	global $link;
	
	$selected_mr_id_arr = array(); 
	$scale_arr = array(); 
	$remarks_arr = array();
        $my_target_arr = array(); 
        $adviser_target_arr = array(); 
        
        if($mr_set_id == '999999999')
        {
            $sql_str_pro = " AND `mr_set_id` = '0' ";
        }
        elseif($mr_set_id == '')
        {
            $sql_str_pro = " ";
        }
        else
        {
            $sql_str_pro = " AND `mr_set_id` = '".$mr_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_date` = '".$mr_date."' AND `mr_old_data` = '0' ".$sql_str_pro." ORDER BY `selected_mr_id` ASC";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($selected_mr_id_arr , $row['selected_mr_id']);
			array_push($scale_arr , stripslashes($row['scale']));
			array_push($remarks_arr , stripslashes($row['remarks']));
                        array_push($my_target_arr , stripslashes($row['my_target']));
                        array_push($adviser_target_arr , stripslashes($row['adviser_target']));
		}	
	}
	return array($scale_arr,$remarks_arr,$selected_mr_id_arr,$my_target_arr,$adviser_target_arr);

}

function getUsersLastMyTargetMRValue($user_id,$mr_set_id,$selected_mr_id)
{
	global $link;
	
	$my_target = ''; 
        $adviser_target = ''; 
        
        if($mr_set_id == '999999999')
        {
            $sql_str_pro = " AND `mr_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `mr_set_id` = '".$mr_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_old_data` = '0' AND `selected_mr_id` = '".$selected_mr_id."' ".$sql_str_pro." ORDER BY `mr_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $adviser_target = stripslashes($row['adviser_target']);
    	}
	return array($my_target,$adviser_target);
}

function getUsersLastMyTargetMRDateString($user_id,$mr_set_id,$selected_mr_id)
{
	global $link;
	
	$output = '';
        
        if($mr_set_id == '999999999')
        {
            $sql_str_pro = " AND `mr_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `mr_set_id` = '".$mr_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_old_data` = '0' AND `selected_mr_id` = '".$selected_mr_id."' ".$sql_str_pro." ORDER BY `mr_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $my_target_date = stripslashes($row['user_mr_add_date']);
            if($my_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($my_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersLastAdviserTargetMRDateString($user_id,$mr_set_id,$selected_mr_id)
{
	global $link;
	
	$output = '';
        
        if($mr_set_id == '999999999')
        {
            $sql_str_pro = " AND `mr_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `mr_set_id` = '".$mr_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmr` WHERE `user_id` = '".$user_id."' AND `mr_old_data` = '0' AND `selected_mr_id` = '".$selected_mr_id."' ".$sql_str_pro." ORDER BY `mr_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $adviser_target = stripslashes($row['adviser_target']);
            $adviser_target_date = stripslashes($row['user_mr_add_date']);
            if($adviser_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($adviser_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersMLEQuestionDetails($user_id,$mle_date,$mle_set_id)
{
	global $link;
	
	$selected_mle_id_arr = array(); 
	$scale_arr = array(); 
	$remarks_arr = array(); 
        $my_target_arr = array(); 
        $adviser_target_arr = array(); 
        
        if($mle_set_id == '999999999')
        {
            $sql_str_pro = " AND `mle_set_id` = '0' ";
        }
        elseif($mle_set_id == '')
        {
            $sql_str_pro = "";
        }
        else
        {
            $sql_str_pro = " AND `mle_set_id` = '".$mle_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_date` = '".$mle_date."' AND `mle_old_data` = '0' ".$sql_str_pro." ORDER BY `selected_mle_id` ASC";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($selected_mle_id_arr , $row['selected_mle_id']);
			array_push($scale_arr , stripslashes($row['scale']));
			array_push($remarks_arr , stripslashes($row['remarks']));
                        array_push($my_target_arr , stripslashes($row['my_target']));
                        array_push($adviser_target_arr , stripslashes($row['adviser_target']));
		}	
	}
	return array($scale_arr,$remarks_arr,$selected_mle_id_arr,$my_target_arr,$adviser_target_arr);

}

function getUsersLastMyTargetMLEValue($user_id,$mle_set_id,$selected_mle_id)
{
	global $link;
	
	$my_target = ''; 
        $adviser_target = ''; 
        
        if($mle_set_id == '999999999')
        {
            $sql_str_pro = " AND `mle_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `mle_set_id` = '".$mle_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_old_data` = '0' AND `selected_mle_id` = '".$selected_mle_id."' ".$sql_str_pro." ORDER BY `mle_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $adviser_target = stripslashes($row['adviser_target']);
    	}
	return array($my_target,$adviser_target);
}

function getUsersLastMyTargetMLEDateString($user_id,$mle_set_id,$selected_mle_id)
{
	global $link;
	
	$output = '';
        
        if($mle_set_id == '999999999')
        {
            $sql_str_pro = " AND `mle_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `mle_set_id` = '".$mle_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_old_data` = '0' AND `selected_mle_id` = '".$selected_mle_id."' ".$sql_str_pro." ORDER BY `mle_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $my_target_date = stripslashes($row['user_mle_add_date']);
            if($my_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($my_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersLastAdviserTargetMLEDateString($user_id,$mle_set_id,$selected_mle_id)
{
	global $link;
	
	$output = '';
        
        if($mle_set_id == '999999999')
        {
            $sql_str_pro = " AND `mle_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `mle_set_id` = '".$mle_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersmle` WHERE `user_id` = '".$user_id."' AND `mle_old_data` = '0' AND `selected_mle_id` = '".$selected_mle_id."' ".$sql_str_pro." ORDER BY `mle_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $adviser_target = stripslashes($row['adviser_target']);
            $adviser_target_date = stripslashes($row['user_mle_add_date']);
            if($adviser_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($adviser_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersADCTQuestionDetails($user_id,$adct_date,$adct_set_id)
{
	global $link;
	
	$selected_adct_id_arr = array(); 
	$scale_arr = array(); 
	$remarks_arr = array();
        $my_target_arr = array(); 
        $adviser_target_arr = array(); 
        
        if($adct_set_id == '999999999')
        {
            $sql_str_pro = " AND `adct_set_id` = '0' ";
        }
        elseif($adct_set_id == '')
        {
            $sql_str_pro = "";
        }
        else
        {
            $sql_str_pro = " AND `adct_set_id` = '".$adct_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_date` = '".$adct_date."' AND `adct_old_data` = '0' ".$sql_str_pro." ORDER BY `selected_adct_id` ASC";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
			array_push($selected_adct_id_arr , $row['selected_adct_id']);
			array_push($scale_arr , stripslashes($row['scale']));
			array_push($remarks_arr , stripslashes($row['remarks']));
                        array_push($my_target_arr , stripslashes($row['my_target']));
                        array_push($adviser_target_arr , stripslashes($row['adviser_target']));
		}	
	}
	return array($scale_arr,$remarks_arr,$selected_adct_id_arr,$my_target_arr,$adviser_target_arr);

}

function getUsersLastMyTargetADCTValue($user_id,$adct_set_id,$selected_adct_id)
{
	global $link;
	
	$my_target = ''; 
        $adviser_target = ''; 
        
        if($adct_set_id == '999999999')
        {
            $sql_str_pro = " AND `adct_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `adct_set_id` = '".$adct_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_old_data` = '0' AND `selected_adct_id` = '".$selected_adct_id."' ".$sql_str_pro." ORDER BY `adct_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $adviser_target = stripslashes($row['adviser_target']);
        }
	return array($my_target,$adviser_target);

}

function getUsersLastMyTargetADCTDateString($user_id,$adct_set_id,$selected_adct_id)
{
	global $link;
	
	$output = '';
        
        if($adct_set_id == '999999999')
        {
            $sql_str_pro = " AND `adct_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `adct_set_id` = '".$adct_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_old_data` = '0' AND `selected_adct_id` = '".$selected_adct_id."' ".$sql_str_pro." ORDER BY `adct_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $my_target = stripslashes($row['my_target']);
            $my_target_date = stripslashes($row['user_adct_add_date']);
            if($my_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($my_target_date)).'</span>';
            }
    	}
	return $output;

}

function getUsersLastAdviserTargetADCTDateString($user_id,$adct_set_id,$selected_adct_id)
{
	global $link;
	
	$output = '';
        
        if($adct_set_id == '999999999')
        {
            $sql_str_pro = " AND `adct_set_id` = '0' ";
        }
        else
        {
            $sql_str_pro = " AND `adct_set_id` = '".$adct_set_id."' ";
        }
			
	$sql = "SELECT * FROM `tblusersadct` WHERE `user_id` = '".$user_id."' AND `adct_old_data` = '0' AND `selected_adct_id` = '".$selected_adct_id."' ".$sql_str_pro." ORDER BY `adct_date` DESC LIMIT 1";
	//echo "<br>Testkk sql = ".$sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            $row = mysql_fetch_array($result);
            $adviser_target = stripslashes($row['adviser_target']);
            $adviser_target_date = stripslashes($row['user_adct_add_date']);
            if($adviser_target != '')
            {
                $output .= '<span style="font-size:11px;color:#0000FF;">Set on '.date('d-m-Y',strtotime($adviser_target_date)).'</span>';
            }
    	}
	return $output;

}

function getScrollingContentDetailsForFavList($sc_id)
{
	global $link;
	
	$sw_header = '';
	$sc_title = '';
	$sc_content_type = '';
	$sc_content = '';
	$sc_image = '';
	$sc_video = '';
	$sc_flash = '';
	$rss_feed_item_id = '';
	
	$sql = "SELECT tsc.* , tsw.sw_header FROM `tblscrollingcontents` AS tsc LEFT JOIN `tblscrollingwindows` AS tsw ON tsc.sw_id = tsw.sw_id WHERE tsc.sc_id = '".$sc_id."'";
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		$row = mysql_fetch_assoc($result);
		$sw_header = stripslashes($row['sw_header']);
		$sc_title = stripslashes($row['sc_title']);
		$sc_content_type = stripslashes($row['sc_content_type']);
		$sc_content = stripslashes($row['sc_content']);
		$sc_image = stripslashes($row['sc_image']);
		$sc_video = stripslashes($row['sc_video']);
		$sc_flash = stripslashes($row['sc_flash']);
		$rss_feed_item_id = stripslashes($row['rss_feed_item_id']);
	}
	return array($sw_header,$sc_title,$sc_content_type,$sc_content,$sc_image,$sc_video,$sc_flash,$rss_feed_item_id);
}

function GetMyFavListDetails($user_id,$page_id,$start_date,$end_date,$ufs_cat_id)
{
	global $link;
	$arr_ufs_id = array(); 
	$arr_page_id = array(); 
	$arr_menu_title = array(); 
	$arr_sc_id = array(); 
	$arr_ufs_note = array();
	$arr_ufs_cat_id = array();
	$arr_ufs_cat = array();
	$arr_ufs_priority = array();    
	$arr_ufs_add_date = array();   
	$arr_user_name = array(); 
        $arr_ufs_type = array(); 
		
	if($page_id != '')
	{
		$str_page_id = " AND TA.page_id = '".$page_id."' ";	
	}
	else
	{
		$str_page_id = "";	
	}
	
	if($ufs_cat_id != '')
	{
		$str_ufs_cat_id = " AND TA.ufs_cat_id = '".$ufs_cat_id."' ";	
	}
	else
	{
		$str_ufs_cat_id = "";	
	}
	
	if($user_id != '')
	{
		$str_user_id = " AND TA.user_id = '".$user_id."' ";	
	}
	else
	{
		$str_user_id = "";	
	}
	
	$sql = "SELECT TA.* , TS.menu_title , TFC.fav_cat , TU.name FROM `tblusersfavscrolling` AS TA
			LEFT JOIN `tblpages` TS ON TA.page_id = TS.page_id
			LEFT JOIN `tblfavcategory` TFC ON TA.ufs_cat_id = TFC.fav_cat_id
			LEFT JOIN `tblusers` TU ON TA.user_id = TU.user_id
			WHERE DATE(TA.ufs_add_date) >= '".date('Y-m-d',strtotime($start_date))."' AND DATE(TA.ufs_add_date) <= '".date('Y-m-d',strtotime($end_date))."' ".$str_user_id." ".$str_page_id." ".$str_ufs_cat_id." AND TA.ufs_status = '1' ORDER BY TS.menu_title ASC,TA.ufs_add_date DESC";			
	
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
		while($row = mysql_fetch_array($result))
		{
		  	array_push($arr_ufs_id , $row['ufs_id']);
			array_push($arr_page_id , stripslashes($row['page_id']));
			array_push($arr_menu_title , stripslashes($row['menu_title']));
			array_push($arr_sc_id , stripslashes($row['sc_id']));
			array_push($arr_ufs_note , stripslashes($row['ufs_note']));
			array_push($arr_ufs_cat_id , stripslashes($row['ufs_cat_id']));
			array_push($arr_ufs_cat , stripslashes($row['fav_cat']));
			array_push($arr_ufs_priority , stripslashes($row['ufs_priority']));
			array_push($arr_ufs_add_date , stripslashes($row['ufs_add_date']));
			array_push($arr_user_name , stripslashes($row['name']));
                        array_push($arr_ufs_type , stripslashes($row['ufs_type']));
		}
	}
	return array($arr_ufs_id,$arr_page_id,$arr_menu_title,$arr_sc_id,$arr_ufs_note,$arr_ufs_cat_id,$arr_ufs_cat,$arr_ufs_priority,$arr_ufs_add_date,$arr_user_name,$arr_ufs_type);

}

function View_user_referral($user_id,$start_date,$end_date)
{
	global $link;
	
	$arr_email_id = array(); 
	$arr_status = array();
	$arr_date = array(); 
	$arr_user_name = array();
	
	if($user_id != '')
	{
		$str_user_id = " AND TR.user_id = '".$user_id."' ";	
	}
	else
	{
		$str_user_id = "";	
	}   
	
	$sql = "SELECT TR.* , TU.name FROM `tblreferal` AS TR LEFT JOIN `tblusers` AS TU ON TR.user_id = TU.user_id WHERE DATE(TR.add_date) >= '".date('Y-m-d',strtotime($start_date))."' AND DATE(TR.add_date) <= '".date('Y-m-d',strtotime($end_date))."'  ".$str_user_id ." ORDER By TR.add_date DESC";
	//echo $sql;
	$result = mysql_query($sql,$link);
	if( ($result) && (mysql_num_rows($result) > 0) )
	{
            while($row = mysql_fetch_assoc($result))
            {
                 //echo $sql2.'</br>';
                 array_push($arr_email_id , stripslashes($row['email_id']));
                 array_push($arr_status , stripslashes($row['status']));
                 array_push($arr_date , stripslashes($row['add_date']));
				 array_push($arr_user_name , stripslashes($row['name']));
                 //echo'<br/>'.$row['library_add_date'];
            }
	}
	return array($arr_email_id,$arr_status,$arr_date,$arr_user_name);
}
?>

<?php
include_once("class.paging.php");
include_once("class.admin.php");
class Scrolling_Windows extends Admin
{
	public function getCommonSettingValue($cs_id)
	{
		$this->connectDB();
		
		$cs_value = '';
				
		$sql = "SELECT * FROM `tblcommonsettings` WHERE `cs_id` = '".$cs_id."' ";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$cs_value = stripslashes($row['cs_value']);
		}
		return $cs_value;
	}
	
	public function setCommonSettingValue($cs_id,$cs_value)
	{
		$this->connectDB();
		$upd_sql = "UPDATE `tblcommonsettings` SET `cs_value` = '".addslashes($cs_value)."' WHERE `cs_id` = '".$cs_id."'";
		
		$this->execute_query($upd_sql);
		return $this->result;
	}
	
	
	public function getRssFeedItemTitle($rss_feed_item_id)
	{
		$this->connectDB();
		
		$rss_feed_item_title = '';
				
		$sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_item_id` = '".$rss_feed_item_id."' ";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$rss_feed_item_title = stripslashes($row['rss_feed_item_title']);
		}
		return $rss_feed_item_title;
	}
	
	public function getRssFeedOptions($rss_feed_item_id)
	{
		$this->connectDB();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_item_status` = '1' ORDER BY `rss_feed_item_title` ASC";
		//echo $sql;
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow()) 
			{
				if($row['rss_feed_item_id'] == $rss_feed_item_id)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				
				
				$option_str .= '<option value="'.$row['rss_feed_item_id'].'" '.$sel.'>'.stripslashes($row['rss_feed_item_title']).'</option>';
			}
		}
		return $option_str;
	}
        
        public function getFavCategoryTypeOptions($fav_cat_type_id)
	{
            $this->connectDB();
            $option_str = '';		

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_status` = '1' AND `prct_cat_deleted` = '0' ORDER BY `prct_cat` ASC";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                    if($row['prct_cat_id'] == $fav_cat_type_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['prct_cat_id'].'" '.$sel.'>'.stripslashes($row['prct_cat']).'</option>';
                }
            }
            return $option_str;
	}
        
        public function getFavCategoryTypeName($fav_cat_type_id)
	{
            $this->connectDB();

            $fav_cat_type = '';

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` = '".$fav_cat_type_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $fav_cat_type = stripslashes($row['prct_cat']);
            }
            return $fav_cat_type;
	}

	public function getAllFavCategories($search,$status,$fav_cat_type_id)
	{
            $this->connectDB();

            $admin_id = $_SESSION['admin_id'];
            $edit_action_id = '159';
            $delete_action_id = '161';
            
            $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
            $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
            
            if($search == '')
            {
                $str_sql_search = '';
            }
            else
            {
                $str_sql_search = " AND `fav_cat` LIKE '%".$search."%' ";
            }

            if($status == '')
            {
                $str_sql_status = '';
            }
            else
            {
                $str_sql_status = " AND `fav_cat_status` = '".$status."'";
            }

            if($fav_cat_type_id == '')
            {
                $str_sql_type = '';
            }
            else
            {
                $str_sql_type = " AND `fav_cat_type_id` = '".$fav_cat_type_id."'";
            }
            
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_deleted` = '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_type." ORDER BY fav_cat ASC ";
            $this->execute_query($sql);
            $total_records = $this->numRows();
            $record_per_page = 50;
            $scroll = 5;
            $page = new Page(); 
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
            $page->set_link_parameter("Class = paging");
            $page->set_qry_string($str="mode=fav_categories");
            $result=$this->execute_query($page->get_limit_query($sql));
            $output = '';		
            if($this->numRows() > 0)
            {
                if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )
                {
                    $i = $page->start + 1;
                }
                else
                {
                    $i = 1;
                }

                $obj = new Scrolling_Windows();
                while($row = $this->fetchRow())
                {
                    if($row['fav_cat_status'] == '1')
                    {
                        $fav_cat_status = 'Active';
                    }
                    else
                    {
                        $fav_cat_status = 'Inactive';
                    }

                    $fav_cat_type = $obj->getFavCategoryTypeName($row['fav_cat_type_id']);
                    

                    $output .= '<tr class="manage-row">';
                    $output .= '<td height="30" align="center">'.$i.'</td>';
                    $output .= '<td height="30" align="center"><strong>'.stripslashes($row['fav_cat']).'</strong></td>';
                    $output .= '<td height="30" align="center"><strong>'.$fav_cat_type.'</strong></td>';
                    $output .= '<td height="30" align="center"><strong>'.$fav_cat_status.'</strong></td>';
                    $output .= '<td height="30" align="center">';
                    if($edit) {
                    $output .= '<a href="index.php?mode=edit_fav_category&id='.$row['fav_cat_id'].'" ><img src = "images/edit.gif" border="0"></a>';
                    }
                    $output .= '</td>';
                    $output .= '<td height="30" align="center">';
                    if($delete) {
                    $output .= '<a href=\'javascript:fn_confirmdelete("Fav Category","sql/delfavcategory.php?id='.$row['fav_cat_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
                    }
                    $output .= '</td>';
                    $output .= '</tr>';
                    //$output .= '<tr class="manage-row" height="30"><td colspan="5" align="center">&nbsp;</td></tr>';
                    $i++;
                }
            }
            else
            {
                $output = '<tr class="manage-row" height="30"><td colspan="6" align="center">NO RECORDS FOUND</td></tr>';
            }

            $page->get_page_nav();
            return $output;
	}
	
	public function chkIfFavCategoryAlreadyExists($fav_cat,$fav_cat_type_id)
	{
            $this->connectDB();
            $return = false;

            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat` = '".addslashes($fav_cat)."' AND `fav_cat_type_id` = '".$fav_cat_type_id."' AND `fav_cat_deleted` = '0' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $return = true;
            }
            return $return;
	}
	
	public function chkIfFavCategoryAlreadyExists_Edit($fav_cat,$fav_cat_id,$fav_cat_type_id)
	{
            $this->connectDB();
            $return = false;

            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat` = '".addslashes($fav_cat)."' AND `fav_cat_id` != '".$fav_cat_id."' AND `fav_cat_type_id` = '".$fav_cat_type_id."' AND `fav_cat_deleted` = '0' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $return = true;
            }
            return $return;
	}
	
	public function addFavCategory($fav_cat,$fav_cat_type_id)
	{
            $this->connectDB();
            $return = false;

            $sql = "INSERT INTO `tblfavcategory` (`fav_cat`,`fav_cat_type_id`,`fav_cat_status`,`fav_cat_deleted`) VALUES ('".addslashes($fav_cat)."','".addslashes($fav_cat_type_id)."','1','0')";
            $this->execute_query($sql);
            return $this->result;
	}
	
	public function updatefavCategory($fav_cat_id,$fav_cat,$fav_cat_status,$fav_cat_type_id)
	{
            $this->connectDB();
            $upd_sql = "UPDATE `tblfavcategory` SET `fav_cat` = '".addslashes($fav_cat)."', `fav_cat_type_id` = '".$fav_cat_type_id."' , `fav_cat_status` = '".addslashes($fav_cat_status)."' WHERE `fav_cat_id` = '".$fav_cat_id."'";
            $this->execute_query($upd_sql);
            return $this->result;
	}
	
	public function getFavCategoryDetails($fav_cat_id)
	{
            $this->connectDB();
            $fav_cat = '';
            $fav_cat_type_id = '';
            $fav_cat_status = '';

            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."'";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $fav_cat = stripslashes($row['fav_cat']);
                $fav_cat_type_id = stripslashes($row['fav_cat_type_id']);
                $fav_cat_status = stripslashes($row['fav_cat_status']);
            }
            return array($fav_cat,$fav_cat_type_id,$fav_cat_status);
	}
	
	public function deleteFavCategory($fav_cat_id)
	{
            $this->connectDB();
            $del_sql1 = "UPDATE `tblfavcategory` SET `fav_cat_deleted` = '1' WHERE `fav_cat_id` = '".$fav_cat_id."'"; 
            $this->execute_query($del_sql1);
            return $this->result;
	}

	

	public function chkIfScrollingContentOrderAlreadyExists_Edit($sc_order,$sw_id,$sc_id)
	{
		$this->connectDB();
		$return = false;
				
		$sql = "SELECT * FROM `tblscrollingcontents` WHERE `sc_id` != '".$sc_id."' AND `sw_id` = '".$sw_id."' AND `sc_order` = '".$sc_order."' AND `sc_status` = '1'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function chkIfScrollingContentOrderAlreadyExists($sc_order,$sw_id)
	{
		$this->connectDB();
		$return = false;
				
		$sql = "SELECT * FROM `tblscrollingcontents` WHERE `sw_id` = '".$sw_id."' AND `sc_order` = '".$sc_order."' AND `sc_status` = '1'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function chkIfScrollingWindowOrderAlreadyExists_Edit($sw_order,$page_id,$sw_id,$sw_show_in_contents = '0')
	{
		$this->connectDB();
		$return = false;
				
		$sql = "SELECT * FROM `tblscrollingwindows` WHERE `sw_id` != '".$sw_id."' AND `page_id` = '".$page_id."' AND `sw_show_in_contents` = '".$sw_show_in_contents."' AND `sw_order` = '".$sw_order."' AND `sw_deleted` = '0' AND `sw_status` = '1'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function chkIfScrollingBarOrderAlreadyExists($sb_order,$page_id)
	{
		$this->connectDB();
		$return = false;
				
		$sql = "SELECT * FROM `tblscrollingbars` WHERE `page_id` = '".$page_id."' AND `sb_order` = '".$sb_order."' AND `sb_status` = '1' AND `sb_deleted` = '0'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function chkIfScrollingBarOrderAlreadyExists_Edit($sb_order,$page_id,$sb_id)
	{
		$this->connectDB();
		$return = false;
				
		$sql = "SELECT * FROM `tblscrollingbars` WHERE `sb_id` != '".$sb_id."' AND `page_id` = '".$page_id."' AND `sb_order` = '".$sb_order."' AND `sb_status` = '1' AND `sb_deleted` = '0'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	
	
	public function chkIfScrollingWindowOrderAlreadyExists($sw_order,$page_id,$sw_show_in_contents = '0')
	{
		$this->connectDB();
		$return = false;
				
		$sql = "SELECT * FROM `tblscrollingwindows` WHERE `page_id` = '".$page_id."' AND `sw_order` = '".$sw_order."' AND `sw_show_in_contents` = '".$sw_show_in_contents."' AND `sw_deleted` = '0' AND `sw_status` = '1'";
		//echo '<br>'.$sql;
                $this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$return = true;
		}
		return $return;
	}
	
	public function getBannerString($banner)
	{
		$search = 'v=';
		$pos = strpos($banner, $search);
		$str = strlen($banner);
		$rest = substr($banner, $pos+2, $str);
		return 'http://www.youtube.com/embed/'.$rest;
	}
	
	public function getScollingWindowHeaderTitle($sw_id)
	{
		$this->connectDB();
		$sw_header = '';
				
		$sql = "SELECT * FROM `tblscrollingwindows` WHERE `sw_id` = '".$sw_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$sw_header = stripslashes($row['sw_header']);
		}
		return $sw_header;
	}
	
	public function get_clean_br_string($string)
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
							$temp_str2 = $this->get_clean_br_string($temp_str2);
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
						$temp_str2 = $this->get_clean_br_string($temp_str2);
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
	
	public function getScollingWindowPageTitle($sw_id)
	{
		$this->connectDB();
		$menu_title = '';
				
		$sql = "SELECT * FROM `tblscrollingwindows` WHERE `sw_id` = '".$sw_id."'";
		//$sql = "SELECT tsw.* , tp.menu_title FROM `tblscrollingwindows` AS tsw LEFT JOIN `tblpages` AS tp ON tsw.page_id = tp.page_id WHERE tsw.sw_id = '".$sw_id."'  ORDER BY tp.menu_title ASC , tsw.sw_order ASC , tsw.sw_add_date DESC";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$page_id = stripslashes($row['page_id']);
                        $menu_title = $this->getCommaSeperatedPageName($page_id);
		}
		return $menu_title;
	}
	
	public function getFontFamilyOptions($font_family)
	{
		$option_str = '';		
		
		$arr_font_family = array('Tahoma','Verdana','Arial Black','Comic Sans MS','Lucida Console','Palatino Linotype','MS Sans Serif4','System','Georgia1','Impact','Courier');
		sort($arr_font_family);
		
			for($i=0;$i<count($arr_font_family);$i++)
			{
				if($arr_font_family[$i] == $font_family)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				
				
				$option_str .= '<option value="'.$arr_font_family[$i].'" '.$sel.'>'.$arr_font_family[$i].'</option>';
			}
		
		return $option_str;
	}
	
	public function getFontSizeOptions($font_size)
	{
		$option_str = '';		
		
		$arr_font_size = array('8','9','10','11','12','13','14','16','18','20','22','24','28','30','32');
		sort($arr_font_size);
		
			for($i=0;$i<count($arr_font_size);$i++)
			{
				if($arr_font_size[$i] == $font_size)
				{
					$sel = ' selected ';
				}
				else
				{
					$sel = '';
				}		
				
				
				$option_str .= '<option value="'.$arr_font_size[$i].'" '.$sel.'>'.$arr_font_size[$i].'px</option>';
			}
		
		return $option_str;
	}
	
	public function updateScrollingWindow($sw_id,$page_id,$sw_header,$sw_header_image,$sw_show_header_credit,$sw_header_credit_link,$sw_footer,$sw_footer_image,$sw_show_footer_credit,$sw_footer_credit_link,$sw_status,$sw_header_font_family,$sw_header_font_size,$sw_footer_font_family,$sw_footer_font_size,$sw_order,$sw_header_font_color,$sw_footer_font_color,$sw_show_in_contents,$sw_header_bg_color,$sw_footer_bg_color,$sw_box_border_color,$sw_header_hide,$sw_footer_hide)
	{
		$this->connectDB();
		$upd_sql = "UPDATE `tblscrollingwindows` SET `page_id` = '".addslashes($page_id)."' , "
                        . "`sw_header` = '".addslashes($sw_header)."' , "
                        . "`sw_header_font_family` = '".addslashes($sw_header_font_family)."' , "
                        . "`sw_header_font_size` = '".addslashes($sw_header_font_size)."' , "
                        . "`sw_header_image` = '".addslashes($sw_header_image)."' , "
                        . "`sw_show_header_credit` = '".addslashes($sw_show_header_credit)."' , "
                        . "`sw_header_credit_link` = '".addslashes($sw_header_credit_link)."' , "
                        . "`sw_footer` = '".addslashes($sw_footer)."' , "
                        . "`sw_footer_font_family` = '".addslashes($sw_footer_font_family)."' , "
                        . "`sw_footer_font_size` = '".addslashes($sw_footer_font_size)."'  , "
                        . "`sw_footer_image` = '".addslashes($sw_footer_image)."' , "
                        . "`sw_show_footer_credit` = '".addslashes($sw_show_footer_credit)."' , "
                        . "`sw_footer_credit_link` = '".addslashes($sw_footer_credit_link)."' , "
                        . "`sw_status` = '".addslashes($sw_status)."'  , "
                        . "`sw_order` = '".addslashes($sw_order)."' , "
                        . "`sw_header_font_color` = '".addslashes($sw_header_font_color)."' , "
                        . "`sw_footer_font_color` = '".addslashes($sw_footer_font_color)."' ,"
                        . "`sw_show_in_contents` = '".addslashes($sw_show_in_contents)."' ,"
                        . "`sw_header_bg_color` = '".addslashes($sw_header_bg_color)."' ,"
                        . "`sw_footer_bg_color` = '".addslashes($sw_footer_bg_color)."' ,"
                        . "`sw_box_border_color` = '".addslashes($sw_box_border_color)."' ,"
                        . "`sw_header_hide` = '".addslashes($sw_header_hide)."' ,"
                        . "`sw_footer_hide` = '".addslashes($sw_footer_hide)."' "
                        . " WHERE `sw_id` = '".$sw_id."'";
		
		$this->execute_query($upd_sql);
		return $this->result;
	}

	public function getScrollingWindowDetails($sw_id)
	{
		$this->connectDB();
		$return = false;
		$page_id = '';
		$sw_header = '';
		$sw_header_font_family = '';
		$sw_header_font_size = '';
		$sw_header_image = '';
		$sw_show_header_credit = '';
		$sw_header_credit_link = '';
		$sw_footer = '';
		$sw_footer_font_family = '';
		$sw_footer_font_size = '';
		$sw_footer_image = '';
		$sw_show_footer_credit = '';
		$sw_footer_credit_link = '';
		$sw_status = '';
		$sw_order = '';
                $sw_show_in_contents = '0';
                $sw_header_bg_color = '';
                $sw_footer_bg_color = '';
                $sw_box_border_color = '';
                $sw_header_hide = '0';
                $sw_footer_hide = '0';
				
		$sql = "SELECT * FROM `tblscrollingwindows` WHERE `sw_id` = '".$sw_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$return = true;
			$page_id = stripslashes($row['page_id']);
			$sw_header = stripslashes($row['sw_header']);
			$sw_header_font_family = stripslashes($row['sw_header_font_family']);
			$sw_header_font_size = stripslashes($row['sw_header_font_size']);
			$sw_header_image = stripslashes($row['sw_header_image']);
			$sw_show_header_credit = stripslashes($row['sw_show_header_credit']);
			$sw_header_credit_link = stripslashes($row['sw_header_credit_link']);
			$sw_footer = stripslashes($row['sw_footer']);
			$sw_footer_font_family = stripslashes($row['sw_footer_font_family']);
			$sw_footer_font_size = stripslashes($row['sw_footer_font_size']);
			$sw_footer_image = stripslashes($row['sw_footer_image']);
			$sw_show_footer_credit = stripslashes($row['sw_show_footer_credit']);
			$sw_footer_credit_link = stripslashes($row['sw_footer_credit_link']);
			$sw_status = stripslashes($row['sw_status']);
			$sw_order = stripslashes($row['sw_order']);
			$sw_header_font_color = stripslashes($row['sw_header_font_color']);
			$sw_footer_font_color = stripslashes($row['sw_footer_font_color']);
                        $sw_show_in_contents = stripslashes($row['sw_show_in_contents']);
                        $sw_header_bg_color = stripslashes($row['sw_header_bg_color']);
                        $sw_footer_bg_color = stripslashes($row['sw_footer_bg_color']);
                        $sw_box_border_color = stripslashes($row['sw_box_border_color']);
                        $sw_header_hide = stripslashes($row['sw_header_hide']);
                        $sw_footer_hide = stripslashes($row['sw_footer_hide']);
		}
		return array($return,$page_id,$sw_header,$sw_header_image,$sw_show_header_credit,$sw_header_credit_link,$sw_footer,$sw_footer_image,$sw_show_footer_credit,$sw_footer_credit_link,$sw_status,$sw_header_font_family,$sw_header_font_size,$sw_footer_font_family,$sw_footer_font_size,$sw_order,$sw_header_font_color,$sw_footer_font_color,$sw_show_in_contents,$sw_header_bg_color,$sw_footer_bg_color,$sw_box_border_color,$sw_header_hide,$sw_footer_hide);
	}
	

	public function addScrollingWindow($page_id,$sw_header,$sw_header_image,$sw_show_header_credit,$sw_header_credit_link,$sw_footer,$sw_footer_image,$sw_show_footer_credit,$sw_footer_credit_link,$sw_header_font_family,$sw_header_font_size,$sw_footer_font_family,$sw_footer_font_size,$sw_order,$sw_header_font_color,$sw_footer_font_color,$sw_show_in_contents,$sw_header_bg_color,$sw_footer_bg_color,$sw_box_border_color,$sw_header_hide,$sw_footer_hide)
	{
		$this->connectDB();
		$return = false;
		
		$sql = "INSERT INTO `tblscrollingwindows` (`page_id`,`sw_header`,`sw_header_font_family`,`sw_header_font_size`,"
                        . "`sw_header_image`,`sw_show_header_credit`,`sw_header_credit_link`,`sw_footer`,`sw_footer_font_family`,"
                        . "`sw_footer_font_size`,`sw_footer_image`,`sw_show_footer_credit`,`sw_footer_credit_link`,`sw_status`,"
                        . "`sw_deleted`,`sw_order`,`sw_header_font_color`,`sw_footer_font_color`,`sw_show_in_contents`,`sw_header_bg_color`,"
                        . "`sw_footer_bg_color`,`sw_box_border_color`,`sw_header_hide`,`sw_footer_hide`) "
                        . "VALUES ('".$page_id."','".addslashes($sw_header)."','".addslashes($sw_header_font_family)."',"
                        . "'".addslashes($sw_header_font_size)."','".addslashes($sw_header_image)."','".addslashes($sw_show_header_credit)."',"
                        . "'".addslashes($sw_header_credit_link)."','".addslashes($sw_footer)."','".addslashes($sw_footer_font_family)."',"
                        . "'".addslashes($sw_footer_font_size)."','".addslashes($sw_footer_image)."','".addslashes($sw_show_footer_credit)."',"
                        . "'".addslashes($sw_footer_credit_link)."','1','0','".addslashes($sw_order)."','".addslashes($sw_header_font_color)."',"
                        . "'".addslashes($sw_footer_font_color)."','".$sw_show_in_contents."','".addslashes($sw_header_bg_color)."',"
                        . "'".addslashes($sw_footer_bg_color)."','".addslashes($sw_box_border_color)."','".addslashes($sw_header_hide)."',"
                        . "'".addslashes($sw_footer_hide)."')";
		
		$this->execute_query($sql);
		return $this->result;
	}
	
	public function deleteScrollingWindow($sw_id)
	{
		$this->connectDB();
		$del_sql1 = "DELETE FROM `tblscrollingwindows` WHERE `sw_id` = '".$sw_id."'"; 
		$this->execute_query($del_sql1);
		
		$del_sql2 = "DELETE FROM `tblscrollingcontents` WHERE `sw_id` = '".$sw_id."'"; 
		$this->execute_query($del_sql2);
		return $this->result;
	}
	
	public function getFavCategoryOptions($fav_cat_id)
	{
            $this->connectDB();
            $option_str = '';		

            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_type_id` IN (1,2) AND  `fav_cat_status` = '1' AND `fav_cat_deleted` = '0' ORDER BY `fav_cat` ASC";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                    if($row['fav_cat_id'] == $fav_cat_id)
                    {
                        $sel = ' selected ';
                    }
                    else
                    {
                        $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['fav_cat_id'].'" '.$sel.'>'.stripslashes($row['fav_cat']).'</option>';
                }
            }
            return $option_str;
	}
	
	public function GetUsersOptions($user_id)
	{
		$this->connectDB();
		$option_str = '';
		$sql = "SELECT * FROM `tblusers` ORDER BY `name` ASC";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )
			{
				$i = $page->start + 1;
			}
			else
			{
				$i = 1;
			}
			while($row = $this->fetchRow())
			{
				if($user_id == $row['user_id'])
				{
					$selected = ' selected ';
				}
				else
				{
					$selected = '';
				}
				$option_str .= '<option value="'.$row['user_id'].'" '.$selected.' >'.stripslashes($row['name']).'</option>';
			}
		}
		return $option_str;
	}

	public function getScrollingWindowsPagesOptions($page_id)
	{
		$this->connectDB();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_manage_menu` = '1' AND `show_in_list` = '1' ORDER BY `menu_title` ASC";
		//echo $sql;
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow()) 
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
		return $option_str;
	}
	
	public function getScrollingBarPagesOptions($page_id)
	{
		$this->connectDB();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblpages` WHERE `show_in_manage_menu` = '1' AND `show_in_list` = '1' ORDER BY `menu_title` ASC";
		//echo $sql;
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow()) 
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
		return $option_str;
	}
	
	public function getScrollingBarPagesOptionsMulti($arr_page_id)
	{
		$this->connectDB();
		$option_str = '';		
		
		$sql = "SELECT * FROM `tblpages` WHERE `show_in_manage_menu` = '1' AND `show_in_list` = '1' ORDER BY `menu_title` ASC";
		//echo $sql;
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow()) 
			{
				if(in_array($row['page_id'], $arr_page_id))
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
		return $option_str;
	}
        
        public function getCommaSeperatedPageName($page_id_str)
        {
            $this->connectDB();
            $output = '';
            
            $sql = "SELECT * FROM `tblpages` WHERE `show_in_manage_menu` = '1' AND `show_in_list` = '1' AND `page_id` IN (".$page_id_str.") ORDER BY `menu_title` ASC";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow()) 
                {
                    $page_name = stripslashes($row['menu_title']);
                    $output .= $page_name.' ,';
                }
                $output = substr($output,0,-1);
            }
            return $output;
        }
	
	public function getAllScrollingWindows($page_id)
	{
		$this->connectDB();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '152';
		$delete_action_id = '153';
		$view_action_id = '150';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		$view = $this->chkValidActionPermission($admin_id,$view_action_id);
		
		//$sql = "SELECT tsw.* , tp.menu_title FROM `tblscrollingwindows` AS tsw LEFT JOIN `tblpages` AS tp ON tsw.page_id = tp.page_id  ORDER BY tp.menu_title ASC , tsw.sw_order ASC , tsw.sw_add_date DESC";
                $sql = "SELECT * FROM `tblscrollingwindows` WHERE `sw_deleted` = '0'  ORDER BY sw_add_date DESC , sw_order ASC ";
		$this->execute_query($sql);
		$total_records = $this->numRows();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=scrolling_windows");
	 	$result=$this->execute_query($page->get_limit_query($sql));
		$output = '';		
		if($this->numRows() > 0)
		{
			if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )
			{
				$i = $page->start + 1;
			}
			else
			{
				$i = 1;
			}
				
			while($row = $this->fetchRow())
			{
                            $obj2 = new Scrolling_Windows();
                            
                            if($row['sw_header_hide'] == '1')
                            {
                                $header_str = '<span style="color:#FF0000;">'.stripslashes($row['sw_header']).'</span>';
                            }
                            else
                            {
                                $header_str = stripslashes($row['sw_header']);
                            }
                            
                            if($row['sw_footer_hide'] == '1')
                            {
                                $footer_str = '<span style="color:#FF0000;">'.stripslashes($row['sw_footer']).'</span>';
                            }
                            else
                            {
                                $footer_str = stripslashes($row['sw_footer']);
                            }
                            
				if($row['sw_header_image'] != '')
				{
					$header_image = '<img border="0" src="'.SITE_URL.'/uploads/'.stripslashes($row['sw_header_image']).'" width="50" >';
				}
				else
				{
					$header_image = '';
				}
				
				if($row['sw_footer_image'] != '')
				{
					$footer_image = '<img border="0" src="'.SITE_URL.'/uploads/'.stripslashes($row['sw_footer_image']).'" width="50" >';
				}
				else
				{
					$footer_image = '';
				}
				
				if($row['sw_status'] == '1')
				{
					$sw_status = 'Active';
				}
				else
				{
					$sw_status = 'Inactive';
				}
                                
                                if($row['sw_show_in_contents'] == '1')
				{
                                    $sw_show_in_contents = 'Main Content';
				}
				else
				{
                                    $sw_show_in_contents = 'Side Bar';
				}
                                
                                $page_name_str = $obj2->getCommaSeperatedPageName($row['page_id']);     
						
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center">'.$i.'</td>';
				$output .= '<td height="30" align="center"><strong>'.$page_name_str.'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.$header_str.'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.$header_image.'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.$footer_str.'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.$footer_image.'</strong></td>';
                                $output .= '<td height="30" align="center"><strong>'.$sw_show_in_contents.'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.$sw_status.'</strong></td>';
				$output .= '<td height="30" align="center">';
						if($view) {
				$output .= '<a href="index.php?mode=scrolling_contents&id='.$row['sw_id'].'">View Sliders</a>';
							}
				$output .= '</td>';
				$output .= '<td height="30" align="center"><strong>'.stripslashes($row['sw_order']).'</strong></td>';
				$output .= '<td height="30" align="center">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_scrolling_window&id='.$row['sw_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td height="30" align="center">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Scrolling Windows","sql/delscrollingwindow.php?id='.$row['sw_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
							}
				$output .= '</td>';
				$output .= '</tr>';
				$output .= '<tr class="manage-row" height="30"><td colspan="12" align="center">&nbsp;</td></tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="30"><td colspan="12" align="center">NO RECORDS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function getAllCommaSeperatedPagesName($str_page_id)
	{
		$this->connectDB();
		$page_name = '';
		
		if($str_page_id != '')
		{	
			$sql = "SELECT * FROM `tblpages` WHERE `page_id` IN (".$str_page_id.")";
			$this->execute_query($sql);
			if($this->numRows() > 0)
			{
				while($row = $this->fetchRow())
				{
					$page_name .= stripslashes($row['menu_title']).',';
				}
				$page_name = substr($page_name,0,-1);
			}
			else
			{
				$page_name = 'All';
			}	
		}
		else
		{
			$page_name = 'All';
		}		
		return $page_name;
	}
	
	public function getDayArrayBetweenTwoDates($start_date,$end_date)
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
		array_push($arr_day ,date("d",strtotime($end_date)));
		return $arr_day;
	}	
	
	public function getAllScrollingBars($search,$page_id,$status,$start_date,$end_date)
	{
		$this->connectDB();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '198';
		$delete_action_id = '199';
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		
		$sql = "SELECT * FROM `tblscrollingbars` WHERE `sb_deleted` = '0' ";
		
		if($search != '')
		{
			$sql .= " AND `sb_content` like '%".$search."%' ";
		}
		
		if($status != '')
		{
			$sql .= " AND `sb_status` = '".$status."' ";
		}
		
		if($page_id != '' )
		{
			if($page_id == '0')
			{
				$sql .= " AND `page_id` = '' ";
			}
			else
			{
				$sql .= " AND ( FIND_IN_SET('".$page_id."', page_id) OR `page_id` = '' ) ";
			}		
		}
		
		if(strtotime($start_date) != '' && strtotime($end_date) != '')
		{
			$chk_start_date = date('Y-m-d',strtotime($start_date));
			$chk_end_date = date('Y-m-d',strtotime($end_date));
			
			$arr_date = $this->getDayArrayBetweenTwoDates($chk_start_date,$chk_end_date);
			
			$sql .= " AND ( ";
			
			$sql .= " (`sb_listing_date_type` = 'single_date' AND `sb_single_date` >= '".$chk_start_date."' AND `sb_single_date` <= '".$chk_end_date."') ";
			$sql .= " OR (`sb_listing_date_type` = 'date_range' AND `sb_start_date` <= '".$chk_end_date."' AND `sb_end_date` >= '".$chk_start_date."') ";
			$sql .= " OR (`sb_listing_date_type` = 'days_of_month' AND (  ";
			
			for($i=0;$i<count($arr_date);$i++)
			{
			$sql .= " FIND_IN_SET('".$arr_date[$i]."', sb_days_of_month) OR";
			}
			$sql = substr($sql,0,-2);
			$sql .= "  ) )";
			
			$sql .= "  ) ";
		}
		
		$sql .= " ORDER BY sb_order ASC , sb_add_date DESC";
		//echo '<br>'.$sql;
		$this->execute_query($sql);
		$total_records = $this->numRows();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=scrolling_bars");
	 	$result=$this->execute_query($page->get_limit_query($sql));
		$output = '';		
		if($this->numRows() > 0)
		{
			if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )
			{
				$i = $page->start + 1;
			}
			else
			{
				$i = 1;
			}
				
			while($row = $this->fetchRow())
			{
				$obj = new Scrolling_Windows();
				$page_name = $obj->getAllCommaSeperatedPagesName($row['page_id']);
				
				if($row['sb_content_image'] != '')
				{
					$sb_content_image = '<img border="0" src="'.SITE_URL.'/uploads/'.stripslashes($row['sb_content_image']).'" width="50" >';
				}
				else
				{
					$sb_content_image = '';
				}
				
				if($row['sb_status'] == '1')
				{
					$sb_status = 'Active';
				}
				else
				{
					$sb_status = 'Inactive';
				}
				
				if($row['sb_listing_date_type'] == 'days_of_month')
				{
					$date_type = 'Days of Month';
					$date_value = stripslashes($row['sb_days_of_month']);
				}
				elseif($row['sb_listing_date_type'] == 'single_date')
				{
					$date_type = 'Single Date';
					$date_value = date('d-m-Y',strtotime($row['sb_single_date']));
				}
				elseif($row['sb_listing_date_type'] == 'date_range')
				{
					$date_type = 'Date Range';
					$date_value = date('d-m-Y',strtotime($row['sb_start_date'])).' - '.date('d-m-Y',strtotime($row['sb_end_date']));
				}
						
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center">'.$i.'</td>';
				$output .= '<td height="30" align="center"><strong>'.$page_name.'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.stripslashes($row['sb_content']).'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.$sb_content_image.'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.stripslashes($row['sb_content_credit_name']).'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.stripslashes($row['sb_content_credit_link']).'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.$date_type.'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.$date_value.'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.$sb_status.'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.stripslashes($row['sb_order']).'</strong></td>';
				$output .= '<td height="30" align="center">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_scrolling_bar&id='.$row['sb_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td height="30" align="center">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Scrolling Bar","sql/delscrollingbar.php?id='.$row['sb_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
							}
				$output .= '</td>';
				$output .= '</tr>';
				$output .= '<tr class="manage-row" height="30"><td colspan="12" align="center">&nbsp;</td></tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="30"><td colspan="12" align="center">NO RECORDS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function getAllScrollingContents($sw_id)
	{
		$this->connectDB();
		
		$admin_id = $_SESSION['admin_id'];
		$edit_action_id = '156';
		$delete_action_id = '157';
		$view_action_id = '154';
		
		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
		$view = $this->chkValidActionPermission($admin_id,$view_action_id);
		
		$sql = "SELECT * FROM `tblscrollingcontents` WHERE `sw_id` = '".$sw_id."' ORDER BY sc_order ASC , sc_add_date DESC";
		$this->execute_query($sql);
		$total_records = $this->numRows();
		$record_per_page = 50;
		$scroll = 5;
		$page = new Page(); 
    	$page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
		$page->set_link_parameter("Class = paging");
		$page->set_qry_string($str="mode=scrolling_contents&id=".$sw_id);
	 	$result=$this->execute_query($page->get_limit_query($sql));
		$output = '';		
		if($this->numRows() > 0)
		{
			if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )
			{
				$i = $page->start + 1;
			}
			else
			{
				$i = 1;
			}
				
			while($row = $this->fetchRow())
			{
                            if($row['sc_title_hide'] == '1')
                            {
                                $title_str = '<span style="color:#FF0000;">'.stripslashes($row['sc_title']).'</span>';
                            }
                            else
                            {
                                $title_str = stripslashes($row['sc_title']);
                            }
				if($row['sc_image'] != '')
				{
					$sc_image = '<img border="0" src="'.SITE_URL.'/uploads/'.stripslashes($row['sc_image']).'" width="50" >';
				}
				else
				{
					$sc_image = '';
				}
				
				if($row['sc_listing_date_type'] == 'days_of_month')
				{
					$date_type = 'Days of Month';
					$date_value = stripslashes($row['sc_days_of_month']);
				}
				elseif($row['sc_listing_date_type'] == 'single_date')
				{
					$date_type = 'Single Date';
					$date_value = date('d-m-Y',strtotime($row['sc_single_date']));
				}
				elseif($row['sc_listing_date_type'] == 'date_range')
				{
					$date_type = 'Date Range';
					$date_value = date('d-m-Y',strtotime($row['sc_start_date'])).' - '.date('d-m-Y',strtotime($row['sc_end_date']));
				}
				
				if($row['sc_status'] == '1')
				{
					$sc_status = 'Active';
				}
				else
				{
					$sc_status = 'Inactive';
				}
				
				
				$sc_content_type = stripslashes($row['sc_content_type']);
				$obj2 = new Scrolling_Windows();
				if($sc_content_type == 'rss')
				{
					$content = $obj2->getRssFeedItemTitle($row['rss_feed_item_id']);
				}
				else
				{
					
					$content = $obj2->get_clean_br_string(stripslashes($row['sc_content']));
				}	
				
				$output .= '<tr class="manage-row">';
				$output .= '<td height="30" align="center">'.$i.'</td>';
				$output .= '<td height="30" align="center"><strong>'.$title_str.'</strong></td>';
				$output .= '<td height="30" align="center"><strong>'.$sc_image.'</strong></td>';
				$output .= '<td height="30" align="center">'.$content.'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['sc_credit_name']).'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['sc_credit_link']).'</td>';
				$output .= '<td height="30" align="center">'.$date_type.'</td>';
				$output .= '<td height="30" align="center">'.$date_value.'</td>';
				$output .= '<td height="30" align="center">'.$sc_status.'</td>';
				$output .= '<td height="30" align="center">'.stripslashes($row['sc_order']).'</td>';
				$output .= '<td height="30" align="center">';
						if($edit) {
				$output .= '<a href="index.php?mode=edit_scrolling_content&id='.$sw_id.'&sc_id='.$row['sc_id'].'" ><img src = "images/edit.gif" border="0"></a>';
							}
				$output .= '</td>';
				$output .= '<td height="30" align="center">';
						if($delete) {
				$output .= '<a href=\'javascript:fn_confirmdelete("Scrolling Content","sql/delscrollingcontent.php?id='.$sw_id.'&sc_id='.$row['sc_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
							}
				$output .= '</td>';
				$output .= '</tr>';
				$output .= '<tr class="manage-row" height="30"><td colspan="12" align="center">&nbsp;</td></tr>';
				$i++;
			}
		}
		else
		{
			$output = '<tr class="manage-row" height="20"><td colspan="12" align="center">NO RECORDS FOUND</td></tr>';
		}
		
		$page->get_page_nav();
		return $output;
	}
	
	public function createThumbNailSingle($src_name,$dst_name, $new_w )
	{
		$system = explode('.',$src_name);
		$cmp = $system[count($system)-1];
		
		if( ($cmp == 'jpg') || ($cmp == 'jpeg') || ($cmp == 'JPG') || ($cmp == 'JPEG') )
		{
			$img = imagecreatefromjpeg("$src_name");
			if($img)
			{
				$old_x = imagesx($img);
				$old_y = imagesy($img);
				
			
				$thumb_w = $new_w;
				$thumb_h = floor( $old_y * ( $new_w / $old_x ) );
		
				$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
				imagecopyresampled($dst_img,$img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
		
				imagejpeg( $dst_img, "$dst_name" );
			}	
		}
		elseif( ($cmp == 'gif') || ($cmp == 'GIF') )
		{
			$img = imagecreatefromgif( "$src_name" );
			if($img)
			{
				$old_x = imagesx($img);
				$old_y = imagesy($img);
				
				$thumb_w = $new_w;
				$thumb_h = floor( $old_y * ( $new_w / $old_x ) );
		
				$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
				imagecopyresampled($dst_img,$img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
				
				imagegif( $dst_img, "$dst_name" );
			}	
		}
		elseif( ($cmp == 'png') || ($cmp == 'PNG') )
		{
			$img = imagecreatefrompng( "$src_name" );
			if($img)
			{
				$old_x = imagesx($img);
				$old_y = imagesy($img);
				
				$thumb_w = $new_w;
				$thumb_h = floor( $old_y * ( $new_w / $old_x ) );
		
				$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
				imagecopyresampled($dst_img,$img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
				
				imagepng( $dst_img, "$dst_name" );
			}	
		}
	}
	
	public function addScrollingContent($sw_id,$sc_title,$sc_title_font_family,$sc_title_font_size,$sc_content_type,$sc_content,$sc_content_font_family,$sc_content_font_size,$sc_image,$sc_video,$sc_flash,$sc_show_credit,$sc_credit_name,$sc_credit_link,$sc_listing_date_type,$sc_days_of_month,$sc_single_date,$sc_start_date,$sc_end_date,$sc_order,$sc_title_font_color,$sc_content_font_color,$rss_feed_item_id,$sc_title_hide,$sc_add_fav_hide)
	{
		$this->connectDB();
		$return = false;
		$time = time();
		
		$sql = "INSERT INTO `tblscrollingcontents` (`sw_id`,`sc_title`,`sc_title_font_family`,`sc_title_font_size`,`sc_content_type`,"
                        . "`sc_content`,`sc_content_font_family`,`sc_content_font_size`,`sc_image`,`sc_video`,`sc_flash`,`sc_show_credit`,"
                        . "`sc_credit_name`,`sc_credit_link`,`sc_status`,`sc_listing_date_type`,`sc_days_of_month`,`sc_single_date`,"
                        . "`sc_start_date`,`sc_end_date`,`sc_order`,`sc_title_font_color`,`sc_content_font_color`,`rss_feed_item_id`,`sc_title_hide`,`sc_add_fav_hide`) "
                        . "VALUES ('".$sw_id."','".addslashes($sc_title)."','".addslashes($sc_title_font_family)."','".addslashes($sc_title_font_size)."' ,"
                        . "'".addslashes($sc_content_type)."' ,'".addslashes($sc_content)."' ,'".addslashes($sc_content_font_family)."' ,"
                        . "'".addslashes($sc_content_font_size)."' ,'".addslashes($sc_image)."', '".addslashes($sc_video)."' ,"
                        . "'".addslashes($sc_flash)."' ,'".addslashes($sc_show_credit)."' ,'".addslashes($sc_credit_name)."' ,"
                        . "'".addslashes($sc_credit_link)."','1','".addslashes($sc_listing_date_type)."','".addslashes($sc_days_of_month)."',"
                        . "'".addslashes($sc_single_date)."','".addslashes($sc_start_date)."','".addslashes($sc_end_date)."',"
                        . "'".addslashes($sc_order)."','".addslashes($sc_title_font_color)."','".addslashes($sc_content_font_color)."',"
                        . "'".addslashes($rss_feed_item_id)."','".$sc_title_hide."','".$sc_add_fav_hide."')";
		$this->execute_query($sql);
		return $this->result;
	}
	
	public function addScrollingBar($page_id,$sb_listing_date_type,$sb_days_of_month,$sb_single_date,$sb_start_date,$sb_end_date,$sb_content,$sb_content_font_family,$sb_content_font_size,$sb_content_font_color,$sb_content_image,$sb_show_content_credit,$sb_content_credit_name,$sb_content_credit_link,$sb_order)
	{
		$this->connectDB();
		$return = false;
		$time = time();
		
		$sql = "INSERT INTO `tblscrollingbars` (`page_id`,`sb_content`,`sb_content_font_family` ,`sb_content_font_size` ,`sb_content_font_color` ,`sb_show_content_credit`,`sb_content_credit_name`,`sb_content_credit_link`,`sb_content_image`,`sb_listing_date_type` ,`sb_days_of_month`,`sb_single_date`, `sb_start_date`,`sb_end_date`,`sb_status`,`sb_order`) VALUES ('".addslashes($page_id)."','".addslashes($sb_content)."','".addslashes($sb_content_font_family)."' ,'".addslashes($sb_content_font_size)."' ,'".addslashes($sb_content_font_color)."','".addslashes($sb_show_content_credit)."' ,'".addslashes($sb_content_credit_name)."' ,'".addslashes($sb_content_credit_link)."','".addslashes($sb_content_image)."','".addslashes($sb_listing_date_type)."','".addslashes($sb_days_of_month)."','".addslashes($sb_single_date)."','".addslashes($sb_start_date)."','".addslashes($sb_end_date)."','1','".addslashes($sb_order)."')";
		$this->execute_query($sql);
		return $this->result;
	}
	
	public function deleteScrollingContent($sc_id)
	{
		$this->connectDB();
		$del_sql1 = "DELETE FROM `tblscrollingcontents` WHERE `sc_id` = '".$sc_id."'"; 
		$this->execute_query($del_sql1);
		return $this->result;
	}
	
	public function deleteScrollingBar($sb_id)
	{
		$this->connectDB();
		$del_sql1 = "DELETE FROM `tblscrollingbars` WHERE `sb_id` = '".$sb_id."'"; 
		$this->execute_query($del_sql1);
		return $this->result;
	}
	
	public function updateScrollingContent($sc_id,$sc_title,$sc_content,$sc_image,$sc_credit_name,$sc_credit_link,$sc_status,$sc_listing_date_type,$sc_days_of_month,$sc_single_date,$sc_start_date,$sc_end_date,$sc_show_credit,$sc_title_font_family,$sc_title_font_size,$sc_content_font_family,$sc_content_font_size,$sc_order,$sc_content_type,$sc_video,$sc_flash,$sc_title_font_color,$sc_content_font_color,$rss_feed_item_id,$sc_title_hide,$sc_add_fav_hide)
	{
		$this->connectDB();
		$upd_sql = "UPDATE `tblscrollingcontents` SET "
                        . "`sc_title` = '".addslashes($sc_title)."' ,"
                        . "`sc_title_font_family` = '".addslashes($sc_title_font_family)."' ,"
                        . "`sc_title_font_size` = '".addslashes($sc_title_font_size)."' ,"
                        . "`sc_content` = '".addslashes($sc_content)."' ,"
                        . "`sc_content_font_family` = '".addslashes($sc_content_font_family)."' ,"
                        . "`sc_content_font_size` = '".addslashes($sc_content_font_size)."'  ,"
                        . "`sc_image` = '".addslashes($sc_image)."' ,"
                        . "`sc_show_credit` = '".addslashes($sc_show_credit)."' ,"
                        . "`sc_credit_name` = '".addslashes($sc_credit_name)."' ,"
                        . "`sc_credit_link` = '".addslashes($sc_credit_link)."' ,"
                        . "`sc_status` = '".addslashes($sc_status)."' ,"
                        . "`sc_listing_date_type` = '".addslashes($sc_listing_date_type)."' ,"
                        . "`sc_days_of_month` = '".addslashes($sc_days_of_month)."' ,"
                        . "`sc_single_date` = '".addslashes($sc_single_date)."' ,"
                        . "`sc_start_date` = '".addslashes($sc_start_date)."' ,"
                        . "`sc_end_date` = '".addslashes($sc_end_date)."' ,"
                        . "`sc_order` = '".addslashes($sc_order)."' ,"
                        . "`sc_content_type` = '".addslashes($sc_content_type)."' ,"
                        . "`sc_video` = '".addslashes($sc_video)."' ,"
                        . "`sc_flash` = '".addslashes($sc_flash)."'  ,"
                        . "`sc_title_font_color` = '".addslashes($sc_title_font_color)."'  ,"
                        . "`sc_content_font_color` = '".addslashes($sc_content_font_color)."'  ,"
                        . "`rss_feed_item_id` = '".addslashes($rss_feed_item_id)."' , "
                        . "`sc_title_hide` = '".$sc_title_hide."' , "
                        . "`sc_add_fav_hide` = '".$sc_add_fav_hide."' "
                        . " WHERE `sc_id` = '".$sc_id."'";
		
		$this->execute_query($upd_sql);
		return $this->result;
	}
	
	public function updateScrollingBar($sb_id,$page_id,$sb_listing_date_type,$sb_days_of_month,$sb_single_date,$sb_start_date,$sb_end_date,$sb_content,$sb_content_font_family,$sb_content_font_size,$sb_content_font_color,$sb_content_image,$sb_show_content_credit,$sb_content_credit_name,$sb_content_credit_link,$sb_order,$sb_status)
	{
		$this->connectDB();
		$upd_sql = "UPDATE `tblscrollingbars` SET `page_id` = '".addslashes($page_id)."' ,`sb_listing_date_type` = '".addslashes($sb_listing_date_type)."' ,`sb_days_of_month` = '".addslashes($sb_days_of_month)."' ,`sb_single_date` = '".addslashes($sb_single_date)."' ,`sb_start_date` = '".addslashes($sb_start_date)."' ,`sb_end_date` = '".addslashes($sb_end_date)."' ,`sb_content` = '".addslashes($sb_content)."' ,`sb_content_font_family` = '".addslashes($sb_content_font_family)."' ,`sb_content_font_size` = '".addslashes($sb_content_font_size)."'  ,`sb_content_font_color` = '".addslashes($sb_content_font_color)."' ,`sb_content_image` = '".addslashes($sb_content_image)."' ,`sb_show_content_credit` = '".addslashes($sb_show_content_credit)."' ,`sb_content_credit_name` = '".addslashes($sb_content_credit_name)."' ,`sb_content_credit_link` = '".addslashes($sb_content_credit_link)."' ,`sb_status` = '".addslashes($sb_status)."' ,`sb_order` = '".addslashes($sb_order)."' WHERE `sb_id` = '".$sb_id."'";
		
		$this->execute_query($upd_sql);
		return $this->result;
	}
	
	public function getScrollingContentDetails($sc_id)
	{
		$this->connectDB();
		
		$sc_title = '';
		$sc_title_font_family = '';
		$sc_title_font_size = '';
		$sc_content_type = '';
		$sc_content = '';
		$sc_content_font_family = '';
		$sc_content_font_size = '';
		$sc_image = '';
		$sc_video = '';
		$sc_flash = '';
		$sc_show_credit = '';
		$sc_credit_name = '';
		$sc_credit_link = '';
		$sc_status = '';	
		$sc_listing_date_type = '';
		$sc_days_of_month = '';
		$sc_single_date = '';
		$sc_start_date = '';
		$sc_end_date = '';
		$sc_order = '';	
		$sc_title_font_color = '';
		$sc_content_font_color = '';
		$rss_feed_item_id = '';
                $sc_title_hide = '0';
                $sc_add_fav_hide = '0';
		
		$sql = "SELECT * FROM `tblscrollingcontents` WHERE `sc_id` = '".$sc_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$sc_title = stripslashes($row['sc_title']);
			$sc_title_font_family = stripslashes($row['sc_title_font_family']);
			$sc_title_font_size = stripslashes($row['sc_title_font_size']);
			$sc_content = stripslashes($row['sc_content']);
			$sc_content_font_family = stripslashes($row['sc_content_font_family']);
			$sc_content_font_size = stripslashes($row['sc_content_font_size']);
			$sc_image = stripslashes($row['sc_image']);
			$sc_show_credit = stripslashes($row['sc_show_credit']);
			$sc_credit_name = stripslashes($row['sc_credit_name']);
			$sc_credit_link = stripslashes($row['sc_credit_link']);
			$sc_status = stripslashes($row['sc_status']);
			$sc_listing_date_type = stripslashes($row['sc_listing_date_type']);
			$sc_days_of_month = stripslashes($row['sc_days_of_month']);
			$sc_single_date = stripslashes($row['sc_single_date']);
			$sc_start_date = stripslashes($row['sc_start_date']);
			$sc_end_date = stripslashes($row['sc_end_date']);
			$sc_order = stripslashes($row['sc_order']);
			$sc_content_type = stripslashes($row['sc_content_type']);
			$sc_video = stripslashes($row['sc_video']);
			$sc_flash = stripslashes($row['sc_flash']);
			$sc_title_font_color = stripslashes($row['sc_title_font_color']);
			$sc_content_font_color = stripslashes($row['sc_content_font_color']);
			$rss_feed_item_id = stripslashes($row['rss_feed_item_id']);
                        $sc_title_hide = stripslashes($row['sc_title_hide']);
                        $sc_add_fav_hide = stripslashes($row['sc_add_fav_hide']);
		}
		return array($sc_title,$sc_content,$sc_image,$sc_credit_name,$sc_credit_link,$sc_status,$sc_listing_date_type,$sc_days_of_month,$sc_single_date,$sc_start_date,$sc_end_date,$sc_show_credit,$sc_title_font_family,$sc_title_font_size,$sc_content_font_family,$sc_content_font_size,$sc_order,$sc_content_type,$sc_video,$sc_flash,$sc_title_font_color,$sc_content_font_color,$rss_feed_item_id,$sc_title_hide,$sc_add_fav_hide);
	}
	
	public function getScrollingBarDetails($sb_id)
	{
		$this->connectDB();
		$return = false;
		$page_id = '';
		$sb_content = '';
		$sb_content_font_family = '';
		$sb_content_font_size = '';
		$sb_content_font_color = '';
		$sb_content_image = '';
		$sb_content_show_credit = '';
		$sb_content_credit_name = '';
		$sb_content_credit_link = '';
		$sb_status = '';	
		$sb_listing_date_type = '';
		$sb_days_of_month = '';
		$sb_single_date = '';
		$sb_start_date = '';
		$sb_end_date = '';
		$sb_order = '';	
		
		$sql = "SELECT * FROM `tblscrollingbars` WHERE `sb_id` = '".$sb_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$return = true;
			$page_id = stripslashes($row['page_id']);
			$sb_content = stripslashes($row['sb_content']);
			$sb_content_font_family = stripslashes($row['sb_content_font_family']);
			$sb_content_font_size = stripslashes($row['sb_content_font_size']);
			$sb_content_font_color = stripslashes($row['sb_content_font_color']);
			$sb_content_image = stripslashes($row['sb_content_image']);
			$sb_content_show_credit = stripslashes($row['sb_content_show_credit']);
			$sb_content_credit_name = stripslashes($row['sb_content_credit_name']);
			$sb_content_credit_link = stripslashes($row['sb_content_credit_link']);
			$sb_status = stripslashes($row['sb_status']);
			$sb_listing_date_type = stripslashes($row['sb_listing_date_type']);
			$sb_days_of_month = stripslashes($row['sb_days_of_month']);
			$sb_single_date = stripslashes($row['sb_single_date']);
			$sb_start_date = stripslashes($row['sb_start_date']);
			$sb_end_date = stripslashes($row['sb_end_date']);
			$sb_order = stripslashes($row['sb_order']);
		}
		return array($return,$page_id,$sb_content,$sb_content_font_family,$sb_content_font_size,$sb_content_font_color,$sb_content_image,$sb_content_show_credit,$sb_content_credit_name,$sb_content_credit_link,$sb_status,$sb_listing_date_type,$sb_days_of_month,$sb_single_date,$sb_start_date,$sb_end_date,$sb_order);
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>
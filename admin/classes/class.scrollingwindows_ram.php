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
                $option_str .='<option value="">Select Type</option>';
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
                    $option_str .= '<option value="'.$row['prct_cat_id'].'" '.$sel.'>'.stripslashes($row['prct_cat']).$row['prct_cat_id'].'</option>';
                }
            }
            return $option_str;
	}
        public function getFavCategoryTypetattya($fav_cat_type_id)
	{ 
            $this->connectDB();
            $option_str = '';		

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT * FROM `tbladmin` WHERE `status` = '1' ORDER BY `fname` ASC";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $option_str .='<option value="">Select posted by</option>';
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
                    $option_str .= '<option value="'.$row['admin_id'].'" '.$sel.'>'.stripslashes($row['fname']).' '.$row['lname'].'</option>';
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
	
	//public function addFavCategory($fav_cat,$fav_cat_type_id)
        public function addFavCategory($fav_code,$uom,$comment,$fav_cat,$arr_fav_cat_type_id,$arr_fav_cat_id,$show_hide,$cat_total_cnt)
	{
            $this->connectDB();
            $return = false;
            
            $favcatid = $this->getFavtidbyname($fav_cat);
            
            if($favcatid > 0)
            {
              $fav_cat_id = $favcatid;  
            }
            else
            {
            //$sql = "INSERT INTO `tblfavcategory` (`fav_cat`,`fav_cat_type_id`,`fav_parent_cat`,`fav_cat_status`,`fav_cat_deleted`,`show_hide`) VALUES ('".addslashes($fav_cat)."','".addslashes($str_fav_cat_type_id)."','".addslashes($str_fav_cat_id)."','1','0','".$show_hide."')";
            $sql = "INSERT INTO `tblfavcategory` (`fav_code`,`uom`,`comment`,`fav_cat`,`fav_cat_status`,`fav_cat_deleted`) VALUES ('".$fav_code."','".$uom."','".addslashes($comment)."','".addslashes($fav_cat)."','1','0')";
            $this->execute_query($sql);
            $fav_cat_id = $this->getInsertID();
            
            }
            
            
           if(count($cat_total_cnt) > 0)
            {
                    for($i=0; $i<$cat_total_cnt; $i++)
                    {
                            $tdata_cat = array();
                            $tdata_cat['fav_cat_id'] = $fav_cat_id;
                            $tdata_cat['fav_cat_type_id'] = $arr_fav_cat_type_id[$i];
                            $tdata_cat['fav_parent_cat'] = $arr_fav_cat_id[$i];
                            $tdata_cat['show_hide'] = $show_hide[$i];
                            $tdata_cat['fav_cat_status'] = 1;
                            $this->addcustomfavcategory($tdata_cat);	
                        //$sql2 = "INSERT INTO `tblcustomfavcategory` (`favcat_id`,`fav_cat_type_id`,`fav_parent_cat`,`show_hide`) VALUES ('".addslashes($tdata_cat['fav_cat_id'])."','".addslashes($tdata_cat['fav_cat_type_id'])."','".addslashes($tdata_cat['fav_parent_cat'])."','".addslashes($tdata_cat['show_hide'])."')";
                        //die();
                        //$this->execute_query($sql2);
                        //return $this->result;
                    }
                    
            }
            return $this->result;
	}
	
	public function updatefavCategory($all_keyword_data_explode,$sol_item_id,$fav_code,$uom,$comment,$id,$fav_cat_id,$fav_cat_id_parent,$fav_cat,$fav_cat_type_id,$cat_status,$fav_cat_status,$show_hide)
	{            
            $this->connectDB();
            $upd_sql = "UPDATE `tblfavcategory` SET `fav_code` = '".addslashes($fav_code)."',`fav_cat` = '".addslashes($fav_cat)."',`fav_cat_status` = '".$fav_cat_status."',`uom` = '".$uom."',`comment` = '".addslashes($comment)."' WHERE `fav_cat_id` = '".$fav_cat_id."'";
            $this->execute_query($upd_sql);
            
            $upd_sql = "UPDATE `tblcustomfavcategory` SET `fav_cat_type_id` = '".addslashes($fav_cat_type_id)."', `fav_parent_cat` = '".$fav_cat_id_parent."' ,`show_hide` = '".addslashes($show_hide)."' , `cat_status` ='".$cat_status."', `updated_by` = '".$_SESSION['admin_id']."' WHERE `id` = '".$id."'";
            $this->execute_query($upd_sql);
           
            
             $del_sql = "DELETE FROM `tbl_wellness_solution_item_keyword` WHERE `sol_item_id` = '".$sol_item_id."' and `page_name` = 'fav_categories'"; 
             $this->execute_query($del_sql);
        
         if(count($all_keyword_data_explode) > 0)
            {
                for($m=0; $m<count($all_keyword_data_explode); $m++)
                { 
                      
                        $data_keyword = array();
                        $data_keyword['sol_item_id'] = $sol_item_id;
                         $data_keyword['keyword_name'] = $all_keyword_data_explode[$m];
                         $page='fav_categories';
                        $sqladd = "INSERT INTO `tbl_wellness_solution_item_keyword` (`sol_item_id`,`keyword_name`,`page_name`,`selected_keyword`) VALUES ('".addslashes($data_keyword['sol_item_id'])."','".$data_keyword['keyword_name']."','".$page."','active')";
                        $this->execute_query($sqladd);
                }
            }
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
        
        //Ramakant code started
        
        public function getAllCategoryChkeckbox($parent_cat_id,$arr_selected_cat_id,$cat_id='',$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id1" id="all_selected_cat_id1" value="1" onclick="toggleCheckBoxes(\'selected_cat_id1\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id1[]" id="selected_cat_id1_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategoryChkeckbox2($parent_cat_id,$arr_selected_cat_id,$cat_id='',$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id2" id="all_selected_cat_id2" value="1" onclick="toggleCheckBoxes(\'selected_cat_id2\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id2[]" id="selected_cat_id2_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategoryChkeckbox3($parent_cat_id,$arr_selected_cat_id,$cat_id='',$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id3" id="all_selected_cat_id3" value="1" onclick="toggleCheckBoxes(\'selected_cat_id3\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id3[]" id="selected_cat_id3_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategoryChkeckbox4($parent_cat_id,$arr_selected_cat_id,$cat_id='',$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id4" id="all_selected_cat_id4" value="1" onclick="toggleCheckBoxes(\'selected_cat_id4\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id4[]" id="selected_cat_id4_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategoryChkeckbox5($parent_cat_id,$arr_selected_cat_id,$cat_id='',$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id5" id="all_selected_cat_id5" value="1" onclick="toggleCheckBoxes(\'selected_cat_id5\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id5[]" id="selected_cat_id5_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategoryChkeckbox6($parent_cat_id,$arr_selected_cat_id,$cat_id='',$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id6" id="all_selected_cat_id6" value="1" onclick="toggleCheckBoxes(\'selected_cat_id6\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id6[]" id="selected_cat_id6_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategoryChkeckbox7($parent_cat_id,$arr_selected_cat_id,$cat_id='',$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id7" id="all_selected_cat_id7" value="1" onclick="toggleCheckBoxes(\'selected_cat_id7\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id7[]" id="selected_cat_id7_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategoryChkeckbox8($parent_cat_id,$arr_selected_cat_id,$cat_id='',$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id8" id="all_selected_cat_id8" value="1" onclick="toggleCheckBoxes(\'selected_cat_id8\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id8[]" id="selected_cat_id8_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategoryChkeckbox9($parent_cat_id,$arr_selected_cat_id,$cat_id='',$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id9" id="all_selected_cat_id9" value="1" onclick="toggleCheckBoxes(\'selected_cat_id9\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id9[]" id="selected_cat_id9_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        public function getAllCategoryChkeckbox10($parent_cat_id,$arr_selected_cat_id,$cat_id='',$adviser_panel = '',$width = '400',$height = '350')
        {
            $this->connectDB();
            $output = '';
            
            if($adviser_panel == '')
            {
                $sql_str_search = "";
            }
            else 
            {
//                $sql_str_search = " AND `adviser_panel` = '%".$adviser_panel."%' ";
            }

//            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE 1 ".$sql_str_search." ORDER BY `prct_cat` ASC";    
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$parent_cat_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                
                $output .= '<div style="width:'.$width.'px;float:left;margin-bottom:20px;">
                                <input type="checkbox" name="all_selected_cat_id10" id="all_selected_cat_id10" value="1" onclick="toggleCheckBoxes(\'selected_cat_id10\'); getSelectedUserListIds(); " />&nbsp;<strong>Select All</strong> 
                            </div>
                            <div style="clear:both;"></div>';
                $output .= '<div style="width:'.$width.'px;height:'.$height.'px;float:left;overflow:scroll;">';
                $output .= '	<ul style="list-style:none;padding:0px;margin:0px;">';
                $i = 1;
                while($row = $this->fetchRow()) 
                {

                    $prct_cat_id = $row['favcat_id'];
                    $cat_name = stripslashes($row['fav_cat']);

                    if(in_array($prct_cat_id,$arr_selected_cat_id))
                    {
                        $selected = ' checked ';
                    }
                    else
                    {
                        $selected = '';
                    }
                    
                    //$liwidth = $width - 20;
                    $liwidth = 300;

                    $output .= '<li style="padding:0px;width:'.$liwidth.'px;float:left;"><input type="checkbox" '.$selected.' name="selected_cat_id10[]" id="selected_cat_id10_'.$i.'" value="'.$prct_cat_id.'"  />&nbsp;<strong>'.$cat_name.'</strong></li>';
                    $i++;
                }
                $output .= '</div>';
            }
            return $output;
        }
        
        
        public function getFavCategoryRamakant($fav_cat_type_id,$fav_cat_id)
	{
            $this->connectDB();
            $option_str = '';		
            //echo 'aaa->'.$fav_cat_type_id;
            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            echo $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$fav_cat_type_id."' and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
            //echo $sql;
            $this->execute_query($sql);
            $option_str .= '<option value="">Select Category</option>';
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                    if($row['favcat_id'] == $fav_cat_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }	
                    $cat_name = $row['fav_cat'];
                    $option_str .= '<option value="'.$row['favcat_id'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
                }
            }
            //echo $option_str;
            
            return $option_str;
	}
         public function getSymptomNameByFavId($fav_cat_type_id,$fav_cat_id)
            {
                $this->connectDB();

                $meal_item = '';

                $sql = "SELECT * FROM `tblsymtumscustomcategory` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' and `fav_parent_cat` = '".$fav_cat_id."' ";
                $this->execute_query($sql);
                if($this->numRows() > 0)
                {
                    while($row = $this->fetchRow())
                    {
                    $meal_item[] = stripslashes($row['bmsid']);
                    }
                }
                
                return $meal_item;
            }  
         public function getSymptomName($bmsid)
	{
            $this->connectDB();
            $option_str = '';		
            //echo 'aaa->'.$fav_cat_type_id;
            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
          echo $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE bms_id IN('".$bmsid."')  ORDER BY bms_id ASC";
            //echo $sql;
            $this->execute_query($sql);
            $option_str .= '<option value="">Select Category</option>';
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                    if($row['bms_id'] == $bmsid)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }	
                    $bms_name = $row['bms_name'];
                    $option_str .= '<option value="'.$row['bms_id'].'" '.$sel.'>'.stripslashes($bms_name).'</option>';
                }
            }
            //echo $option_str;
            
            return $option_str;
	}
       
        public function getAllFavCategoryRamakant($fav_cat_id)
	{
            $this->connectDB();
            $option_str = '';		
            //echo 'aaa->'.$fav_cat_type_id;
            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE  tblfavcategory.fav_cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
            //echo $sql;
            $this->execute_query($sql);
            $option_str .= '<option value="">Select Category</option>';
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                    if($row['favcat_id'] == $fav_cat_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }	
                    $cat_name = $row['fav_cat'];
                    $option_str .= '<option value="'.$row['favcat_id'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
                }
            }
            //echo $option_str;
            
            return $option_str;
	}
        public function getFavCategoryTypeOptionsRamakant($fav_cat_type_arr)
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
                    
                 if (in_array($row['prct_cat_id'], $fav_cat_type_arr))
                    //if($row['prct_cat_id'] == $fav_cat_type_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['prct_cat_id'].'" '.$sel.'>'.stripslashes($row['prct_cat']).$row['prct_cat_id'].'</option>';
                }
            }
            return $option_str;
	}
        
        public function getFavCategoryDetailsRamakant($id)
	{
            $this->connectDB();
            $fav_cat = '';
            $fav_cat_type_id = '';
            $fav_cat_status = '';

            //$sql = "SELECT * FROM `tblcustomfavcategory` WHERE `id` = '".$id."'";
            
           $sql = "SELECT tblcustomfavcategory.*,tblfavcategory.fav_cat_id,tblfavcategory.comment,tblfavcategory.uom,tblfavcategory.sol_item_id,tblfavcategory.fav_cat_status,tblfavcategory.fav_code from tblcustomfavcategory "
                    . "JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.id = '".$id."' ";
            
           //SELECT table1.*, table2.col1, table2.col3 FROM table1 JOIN table2 USING(id)
           
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                
                //$fav_cat = stripslashes($row['fav_cat']);
                $fav_cat = $this->getFavCategoryNameRamakant($row['favcat_id']);
                $favcat_id = $row['favcat_id'];
                $fav_cat_type_id = stripslashes($row['fav_cat_type_id']);
                $fav_parent_cat = stripslashes($row['fav_parent_cat']);
                $cat_status = stripslashes($row['cat_status']);
                $fav_cat_status = stripslashes($row['fav_cat_status']);
                $show_hide = stripslashes($row['show_hide']);
                $comment = $row['comment'];
                $uom = $row['uom'];
                $fav_code = $row['fav_code'];
                $sol_item_id = $row['sol_item_id'];
            }
            return array($sol_item_id,$fav_code,$fav_cat,$fav_cat_type_id,$cat_status,$fav_parent_cat,$show_hide,$favcat_id,$fav_cat_status,$comment,$uom);
	}
        
        public function getFavCategoryRamakantEdit($fav_cat_arr)
	{
            $this->connectDB();
            $option_str = '';		

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_status` = '1' AND `fav_cat_deleted` = '0' ORDER BY `fav_cat_id` ASC";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                    if (in_array($row['fav_cat_id'], $fav_cat_arr))
                    //if($row['fav_cat_id'] == $fav_cat_id)
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
        
        public function getShowHideOption($val,$type='1')
	{	
		$output = '';
		
		if($type == '2')
		{
			$output .= '<option value="" >All Options</option>';
		}
		else
		{
			$output .= '<option value="" >Select Option</option>';
		}
		
		
		if($val == '1' )
		{
			$selected = ' selected ';	
		}
		else
		{
			$selected = '';	
		}
		$output .= '<option value="1" '.$selected.'>Show</option>';
		
		if($val == '0' )
		{
			$selected = ' selected ';	
		}
		else
		{
			$selected = '';	
		}
		$output .= '<option value="0" '.$selected.'>Hide</option>';
					
		return $output;
	}
        
        public function Get_favcat_id_name($favcat_id) {
          
                $this->connectDB();
		$sw_header = '';
		$sql = "SELECT `fav_cat` FROM `tblfavcategory` WHERE `fav_cat_id` = '".$favcat_id."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			//$sw_header = stripslashes($row['fav_cat']);
		}
		return $row['fav_cat']; 
            
        }
        
        
        public function addcustomfavcategory($tdata_cat) {
          
            $this->connectDB();
            $return = false;
            //$sql = "INSERT INTO `tblfavcategory` (`fav_cat`,`fav_cat_type_id`,`fav_parent_cat`,`fav_cat_status`,`fav_cat_deleted`,`show_hide`) VALUES ('".addslashes($fav_cat)."','".addslashes($str_fav_cat_type_id)."','".addslashes($str_fav_cat_id)."','1','0','".$show_hide."')";
            $sql = "INSERT INTO `tblcustomfavcategory` (`favcat_id`,`fav_cat_type_id`,`fav_parent_cat`,`show_hide`,`updated_by`) VALUES ('".addslashes($tdata_cat['fav_cat_id'])."','".addslashes($tdata_cat['fav_cat_type_id'])."','".addslashes($tdata_cat['fav_parent_cat'])."','".addslashes($tdata_cat['show_hide'])."','".$_SESSION['admin_id']."')";
            $this->execute_query($sql); 
            return $this->result;
        }
        
        public function getFavtidbyname($fav_cat) {
                $this->connectDB();
		$sw_header = '';
		$sql = "SELECT `fav_cat_id` FROM `tblfavcategory` WHERE `fav_cat` = '".$fav_cat."'";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$sw_header = stripslashes($row['fav_cat_id']);
		}
		return $sw_header;   
        }
        
        public function getAllFavCategoriesRamakant($search,$fav_code,$status,$fav_cat_type_id,$fav_cat_id)
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
                
                //$str_sql_search = " AND `fav_cat` LIKE '%".$search."%' ";
                $arr_fav_cat = $this->getfavcatidarrayRamakant($search);
                $arr_fav_cat = implode($arr_fav_cat, '\',\'');
                $str_sql_search = " AND `favcat_id` IN ('".$arr_fav_cat."') ";
                
            }
             if($fav_code == '')
            {
                $str_sql_fav_code = '';
            }
            else
            {
                
                //$str_sql_search = " AND `fav_cat` LIKE '%".$search."%' ";
                $arr_fav_code = $this->getfavcatidarraytattya($fav_code);
                $arr_fav_code = implode($arr_fav_code, '\',\'');
                $str_sql_fav_code = " AND `fav_code` IN ('".$arr_fav_code."') ";
                
            }
            if($status == '')
            {
                $str_sql_status = '';
            }
            else
            {
                $str_sql_status = " AND `cat_status` = '".$status."'";
            }

            if($fav_cat_type_id == '')
            {
                $str_sql_type = '';
            }
            else
            {
                $str_sql_type = " AND `fav_cat_type_id` = '".$fav_cat_type_id."'";
            }
            
            if($fav_cat_id == '')
            {
                $str_sql_fav_parent = '';
            }
            else
            {
                $str_sql_fav_parent = " AND `fav_parent_cat` = '".$fav_cat_id."'";
            }
            
            $sql = "SELECT * FROM `tblcustomfavcategory` WHERE `cat_deleted` = '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_type." ".$str_sql_fav_parent." ORDER BY id DESC ";
            $this->execute_query($sql);
            $total_records = $this->numRows();
            $record_per_page = 50;
            $scroll = 5;
            $page = new Page(); 
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
            $page->set_link_parameter("Class = paging");
            $page_mode = $_GET['page'];
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
                    if($row['cat_status'] == '1')
                    {
                        $fav_cat_status = 'Active';
                    }
                    else
                    {
                        $fav_cat_status = 'Inactive';
                    }

                    $fav_cat_type = $obj->getFavCategoryTypeName($row['fav_cat_type_id']);
                    $fav_cat_name = $obj->getFavCategoryNameRamakant($row['favcat_id']);
                    $sol_item_id = $obj->getSolItemIdRamakant($row['favcat_id']);
                    
                    if($row['fav_parent_cat']!='')
                    {
                        $fav_cat_parent = $obj->getFavCategoryNameRamakant($row['fav_parent_cat']);
                    }
                    else
                    {
                        $fav_cat_parent = '';
                    }
  
                    $output .= '<tr class="manage-row">';
                    $output .= '<td height="30" align="center">'.$i.'</td>';
                    $output .= '<td height="30" align="center">'.$obj->getFavNameById($row['favcat_id']).'</td>';
                    $output .= '<td height="30" align="center">'.stripslashes($fav_cat_name).'</td>';
                    $output .= '<td height="30" align="center">'.$fav_cat_parent.'</td>';
                    $output .= '<td height="30" align="center">'.$fav_cat_type.'</td>';
                    $output .= '<td height="30" align="center">'.$fav_cat_status.'</td>';
                    $output .= '<td height="30" align="center">'.$obj->getAdminNameRam($row['updated_by']).'</td>';
                    $output .= '<td height="30" align="center">'.date("d-m-Y h:i:s",strtotime($row['add_date'])).'</td>';
                    $output .= '<td height="30" align="center">';
                    
                    if($sol_item_id==0)
                    {
                      
                       $output .= '<a href="index.php?mode=add_wellness_solution_item&image_id='.$row['favcat_id'].'&name=fav_categories" ><img src = "images/sidebox_icon_pages.gif" border="0"></a>';
                       $output .= '<td height="30" align="center">';
                       $output .= '</td>';
                       
                    }
                    else
                    {
                     $output .= '<td height="30" align="center">';
                     $output .= '<a href="index.php?mode=edit_wellness_solution_item&id='.$sol_item_id.'&name=fav_categories" ><img src = "images/sidebox_icon_pages.gif" border="0"></a>';
                     $output .= '</td>';
                       
                    }
                     
                     $output .= '<td height="30" align="center">';
                    if($edit) {
                    $output .= '<a href="index.php?mode=edit_fav_category&id='.$row['id'].'&page='.$page_mode.'" ><img src = "images/edit.gif" border="0"></a>';
                    }
                    $output .= '</td>';
                    $output .= '<td height="30" align="center">';
                    if($delete) {
                    $output .= '<a href=\'javascript:fn_confirmdelete("Fav Category","sql/delfavcategory.php?id='.$row['id'].'&page='.$page_mode.'")\' ><img src = "images/del.gif" border="0" ></a>';
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
//         public function getAllFavCategoriesRamakantOld($search,$status,$fav_cat_type_id,$fav_cat_id)
//	{
//            $this->connectDB();
//
//            $admin_id = $_SESSION['admin_id'];
//            $edit_action_id = '159';
//            $delete_action_id = '161';
//            
//            $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
//            $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
//            
//            if($search == '')
//            {
//                $str_sql_search = '';
//            }
//            else
//            {
//                
//                //$str_sql_search = " AND `fav_cat` LIKE '%".$search."%' ";
//                $arr_fav_cat = $this->getfavcatidarrayRamakant($search);
//                $arr_fav_cat = implode($arr_fav_cat, '\',\'');
//                $str_sql_search = " AND `favcat_id` IN ('".$arr_fav_cat."') ";
//                
//            }
//
//            if($status == '')
//            {
//                $str_sql_status = '';
//            }
//            else
//            {
//                $str_sql_status = " AND `cat_status` = '".$status."'";
//            }
//
//            if($fav_cat_type_id == '')
//            {
//                $str_sql_type = '';
//            }
//            else
//            {
//                $str_sql_type = " AND `fav_cat_type_id` = '".$fav_cat_type_id."'";
//            }
//            
//            if($fav_cat_id == '')
//            {
//                $str_sql_fav_parent = '';
//            }
//            else
//            {
//                $str_sql_fav_parent = " AND `fav_parent_cat` = '".$fav_cat_id."'";
//            }
//            
//            $sql = "SELECT * FROM `tblcustomfavcategory` WHERE `cat_deleted` = '0' ".$str_sql_search." ".$str_sql_status." ".$str_sql_type." ".$str_sql_fav_parent." ORDER BY id DESC ";
//            $this->execute_query($sql);
//            $total_records = $this->numRows();
//            $record_per_page = 50;
//            $scroll = 5;
//            $page = new Page(); 
//            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
//            $page->set_link_parameter("Class = paging");
//            $page->set_qry_string($str="mode=fav_categories");
//            $result=$this->execute_query($page->get_limit_query($sql));
//            $output = '';		
//            if($this->numRows() > 0)
//            {
//                if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )
//                {
//                    $i = $page->start + 1;
//                }
//                else
//                {
//                    $i = 1;
//                }
//
//                $obj = new Scrolling_Windows();
//                while($row = $this->fetchRow())
//                {
//                    if($row['cat_status'] == '1')
//                    {
//                        $fav_cat_status = 'Active';
//                    }
//                    else
//                    {
//                        $fav_cat_status = 'Inactive';
//                    }
//
//                    $fav_cat_type = $obj->getFavCategoryTypeName($row['fav_cat_type_id']);
//                    $fav_cat_name = $obj->getFavCategoryNameRamakant($row['favcat_id']);
//                    
//                    if($row['fav_parent_cat']!='')
//                    {
//                        $fav_cat_parent = $obj->getFavCategoryNameRamakant($row['fav_parent_cat']);
//                    }
//                    else
//                    {
//                        $fav_cat_parent = '';
//                    }
//
//                    $output .= '<tr class="manage-row">';
//                    $output .= '<td height="30" align="center">'.$i.'</td>';
//                    $output .= '<td height="30" align="center"><strong>'.stripslashes($fav_cat_name).'</strong></td>';
//                    $output .= '<td height="30" align="center"><strong>'.$fav_cat_parent.'</strong></td>';
//                    $output .= '<td height="30" align="center"><strong>'.$fav_cat_type.'</strong></td>';
//                    $output .= '<td height="30" align="center"><strong>'.$fav_cat_status.'</strong></td>';
//                    $output .= '<td height="30" align="center"><strong>'.$obj->getAdminNameRam($row['updated_by']).'</strong></td>';
//                    $output .= '<td height="30" align="center"><strong>'.date("d-m-Y",strtotime($row['add_date'])).'</strong></td>';
//                    $output .= '<td height="30" align="center">';
//                    if($edit) {
//                    $output .= '<a href="index.php?mode=edit_fav_category&id='.$row['id'].'" ><img src = "images/edit.gif" border="0"></a>';
//                    }
//                    $output .= '</td>';
//                    $output .= '<td height="30" align="center">';
//                    if($delete) {
//                    $output .= '<a href=\'javascript:fn_confirmdelete("Fav Category","sql/delfavcategory.php?id='.$row['id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
//                    }
//                    $output .= '</td>';
//                    $output .= '</tr>';
//                    //$output .= '<tr class="manage-row" height="30"><td colspan="5" align="center">&nbsp;</td></tr>';
//                    $i++;
//                }
//            }
//            else
//            {
//                $output = '<tr class="manage-row" height="30"><td colspan="6" align="center">NO RECORDS FOUND</td></tr>';
//            }
//
//            $page->get_page_nav();
//            return $output;
//	}
        public function getFavCategoryNameRamakant($fav_cat_id)
	{
            $this->connectDB();

            $fav_cat_type = '';

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $fav_cat_type = stripslashes($row['fav_cat']);
            }
            return $fav_cat_type;
	}
         public function getSolItemIdRamakant($fav_cat_id)
	{
            $this->connectDB();

            $fav_cat_type = '';

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_id` = '".$fav_cat_type_id."' ";
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $row = $this->fetchRow();
                $fav_cat_type = stripslashes($row['sol_item_id']);
            }
            return $fav_cat_type;
	}
        
        public function chkIfFavCategoryAlreadyExists_EditRam($fav_cat,$fav_cat_id,$fav_cat_type_id)
	{
            $this->connectDB();
            $return = false;
            
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat` = '".addslashes($fav_cat)."' AND `fav_cat_id` != '".$fav_cat_id."' AND `fav_cat_deleted` = '0' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $return = true;
            }
            return $return;
	}
        
        public function deleteFavCategoryRamakant($fav_cat_id)
	{
            $this->connectDB();
            $del_sql1 = "UPDATE `tblcustomfavcategory` SET `cat_deleted` = '1' WHERE `id` = '".$fav_cat_id."'"; 
            $this->execute_query($del_sql1);
            return $this->result;
	}
        
        public function getFavCatOptions($fav_cat_id)
	{
            $this->connectDB();
            $option_str = '';		

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_status` = '1' AND `fav_cat_deleted` = '0' ORDER BY `fav_cat` ASC";
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
        
        public function getfavcatidarrayRamakant($search) {
            $this->connectDB();
            $option_str = array();		

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT `fav_cat_id` FROM `tblfavcategory` WHERE `fav_cat_status` = '1' AND `fav_cat_deleted` = '0' AND `fav_cat` LIKE '%".$search."%' ORDER BY `fav_cat_id` ASC";
            
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                  $option_str[] =  $row['fav_cat_id'];
                }
            }
            return $option_str;   
        }
            public function getfavcatidarraytattya($fav_code) {
            $this->connectDB();
            $option_str = array();		

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT `fav_code` FROM `tblfavcategory` WHERE `fav_cat_status` = '1' AND `fav_cat_deleted` = '0' AND `fav_cat` LIKE '%".$fav_code."%' ORDER BY `fav_code` ASC";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                  $option_str[] =  $row['fav_code'];
                }
            }
            return $option_str;   
        }
        public function getAdminNameRam($id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['fname'].' '.$row['lname'];
            }
            return $return;
	}
        
        public function getFavNameById($favcat_id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$favcat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['fav_code'];
            }
            return $return;
	}
        
        
        public function getInterpretationOption($fav_cat_type_id,$fav_cat_id)
	{
            $this->connectDB();
            $option_str = '';		
            //echo 'aaa->'.$fav_cat_type_id;
            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT * FROM `tblsymtumscustomcategory` "
                    . "LEFT JOIN tblbodymainsymptoms ON tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id WHERE tblsymtumscustomcategory.fav_cat_type_id = '".$fav_cat_type_id."' and tblbodymainsymptoms.bms_status = 1 ORDER BY tblbodymainsymptoms.bms_name ASC";
            //echo $sql;
            $this->execute_query($sql);
//            $option_str .= '<option value="">Select Category</option>';
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                    if($row['bmsid'] == $fav_cat_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }	
                    $cat_name[] = $row['bms_name'];
                   
//                    $option_str .= '<option value="'.$row['bmsid'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
//                    $option_str .= '<option value="'.$row['bmsid'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
                }
            }
            //echo $option_str;
            
            return $cat_name;
	}
        
  public function getSymptomsDataOption($fav_cat_type_id,$fav_cat_id)
	{
            $this->connectDB();
            $option_str = '';		
            //echo 'aaa->'.$fav_cat_type_id;
            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT * FROM `tblbodymainsymptoms` WHERE `bms_status`='1' ORDER BY bms_name ASC";
           //echo $sql;
            $this->execute_query($sql);
//            $option_str .= '<option value="">Select Category</option>';
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                    if($row['bmsid'] == $fav_cat_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }	
                    $cat_name[] = $row['bms_name'];
                   
//                    $option_str .= '<option value="'.$row['bmsid'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
//                    $option_str .= '<option value="'.$row['bmsid'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
                }
            }
            //echo $option_str;
            
            return $cat_name;
	}
             

//tatya
public function getMonthsOptionsMultiple($arr_month)

{

    

    $option_str = '';

    

    $arr_record = array (

        1 => 'January',

        2 => 'February',

        3 => 'March',

        4 => 'April',

        5 => 'May',

        6 => 'June',

        7 => 'July',

        8 => 'August',

        9 => 'September',

        10 => 'October',

        11 => 'November',

        12 => 'December'

    );



    foreach($arr_record as $k => $v )

    {

            if(in_array($k ,$arr_month))

            {

                $selected = ' selected ';

            }

            else

            {

                $selected = '';

            }

            $option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';

    }	

    return $option_str;

}
        public function getDayOfWeekOptionsMultiple($day_of_week)

{

    

    $option_str = '';

    

    $arr_day_of_week = array (

        1 => 'Sunday',

        2 => 'Monday',

        3 => 'Tuesday',

        4 => 'Wednesday',

        5 => 'Thursday',

        6 => 'Friday',

        7 => 'Saturday'

    );



    foreach($arr_day_of_week as $k => $v )

    {

            if(in_array($k ,$day_of_week))

            {

                $selected = ' selected ';

            }

            else

            {

                $selected = '';

            }

            $option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';

    }	

    return $option_str;

}
        
        
        //ramakannt code ended
        


//vivek//

function getModuleWiseCriteriaOptionsPCM($report_module,$module_criteria)

{

    global $link;

    $option_str = '';

    

    if($report_module == '12')

    {

        if($module_criteria == '3')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="3" '.$sel.'>Duration</option>';

        

        if($module_criteria == '4')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="4" '.$sel.'>Time</option>';

        

        if($module_criteria == '8')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="8" '.$sel.'>Calories Burnt</option>';

    }

    elseif($report_module == '13')

    {

        if($module_criteria == '4')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="4" '.$sel.'>Time</option>';

        

        if($module_criteria == '5')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="5" '.$sel.'>Quantity</option>';

        

        if($module_criteria == '6')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="6" '.$sel.'>My Desire</option>';

    }

    elseif($report_module == '113')

    {

         

    }

    elseif($report_module == '45' )

    {

        /*

        if($module_criteria == '9')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="9" '.$sel.'>Triggers</option>';

         * 

         */

        if($module_criteria == '3')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="3" '.$sel.'>Duration</option>';

        

        if($module_criteria == '4')

        {

            $sel = ' selected ';

        }

        else

        {

            $sel = '';

        }		

        $option_str .= '<option value="4" '.$sel.'>Time</option>';

         

    }

    elseif($report_module == '')

    {

         

    }

    else 

    {

        

    }

    

    if($module_criteria == '7')

    {

        $sel = ' selected ';

    }

    else

    {

        $sel = '';

    }		

    $option_str .= '<option value="7" '.$sel.'>Days</option>';

    

    return $option_str;

}

function getModuleWiseCriteriaScaleValues($num,$user_id,$report_module,$pro_user_id,$module_criteria,$criteria_scale_range,$start_criteria_scale_value,$end_criteria_scale_value)

{
 $obj = new Scrolling_Windows();
    global $link;

    $option_str = '';

    if($criteria_scale_range == '')

    {

        $div_start_criteria_scale_value = 'none';

        $div_end_criteria_scale_value = 'none';

        $start_criteria_scale_value = '';

        $end_criteria_scale_value = '';

    }

    elseif($criteria_scale_range == '6')

    {

        $div_start_criteria_scale_value = '';

        $div_end_criteria_scale_value = '';

        $option_str .= '<span class="Header_brown"><strong>Criteria Value:</strong>&nbsp;&nbsp;&nbsp;</span>';

    }

    else

    {

        $div_start_criteria_scale_value = '';

        $div_end_criteria_scale_value = 'none';

        $end_criteria_scale_value = '';

        $option_str .= '<span class="Header_brown"><strong>Criteria Value:</strong>&nbsp;&nbsp;&nbsp;</span>';

    }

    

    //echo 'module_criteria = '.$module_criteria; 

    if($module_criteria == '1' || $module_criteria == '2' || $module_criteria == '9')

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">

                        <select name="start_criteria_scale_value[]" id="start_criteria_scale_value'.$num.'" style="width:50px;">

                        ';

        for($i=1;$i<=10;$i++)

        {

            if($i == $start_criteria_scale_value)

            {

                $sel = ' selected ';

            }

            else

            {

                $sel = '';

            }		

            $option_str .= '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';

        }    

        $option_str .= '</select></span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">

                        &nbsp; - &nbsp;

                        <select name="end_criteria_scale_value[]" id="end_criteria_scale_value'.$num.'" style="width:50px;">

                        ';

        for($i=1;$i<=10;$i++)

        {

            if($i == $end_criteria_scale_value)

            {

                $sel = ' selected ';

            }

            else

            {

                $sel = '';

            }		

            $option_str .= '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';

        }    

        $option_str .= '</select></span>';

    }

    elseif($module_criteria == '4' )

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';

        $option_str .= '<select name="start_criteria_scale_value[]" id="start_criteria_scale_value'.$num.'" style="width:100px;">

                        ';

        $option_str .= $obj->getTimeOptionsVivek(0,24,$start_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">

                        &nbsp; - &nbsp;';

        $option_str .= '<select name="end_criteria_scale_value[]" id="end_criteria_scale_value'.$num.'" style="width:100px;">

                        ';

        $option_str .= $obj->getTimeOptionsVivek(0,24,$end_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

    }

    elseif($module_criteria == '5' )

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';

        $option_str .= '<select name="start_criteria_scale_value[]" id="start_criteria_scale_value'.$num.'" style="width:100px;">

                        ';

        $option_str .= $obj->getMealQuantityOptionsVivek($start_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">

                        &nbsp; - &nbsp;';

        $option_str .= '<select name="end_criteria_scale_value[]" id="end_criteria_scale_value'.$num.'" style="width:100px;">

                        ';

        $option_str .= $obj->getMealQuantityOptionsVivek($end_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

    }

    elseif($module_criteria == '6' )

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';

        $option_str .= '<select name="start_criteria_scale_value[]" id="start_criteria_scale_value'.$num.'" style="width:100px;">

                        ';

        $option_str .= $obj->getMealLikeOptionsVivek($start_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">';

        $option_str .= '<input type="hidden" name="end_criteria_scale_value[]" id="end_criteria_scale_value'.$num.'" value="'.$end_criteria_scale_value.'">';

        $option_str .= '</span>';

    }

    elseif($module_criteria == '7' )

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">';

        $option_str .= '<select name="start_criteria_scale_value[]" id="start_criteria_scale_value'.$num.'" style="width:100px;">

                        ';

        $option_str .= $obj->getDayOfWeekOptionsVivek($start_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">&nbsp; - &nbsp';

        $option_str .= '<select name="end_criteria_scale_value[]" id="end_criteria_scale_value'.$num.'" style="width:100px;">

                        ';

        $option_str .= $obj->getDayOfWeekOptionsVivek($end_criteria_scale_value);

        $option_str .= '</select>';

        $option_str .= '</span>';

    }

    elseif($module_criteria == '3')

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">

                        <input style="width:50px;" maxlength="3" type="text" name="start_criteria_scale_value[]" id="start_criteria_scale_value'.$num.'" value="'.$start_criteria_scale_value.'"> (Mins)</span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">&nbsp; - &nbsp;

                        <input style="width:50px;" maxlength="3" type="text" name="end_criteria_scale_value[]" id="end_criteria_scale_value'.$num.'" value="'.$end_criteria_scale_value.'"> (Mins)</span>';

    }

    elseif($module_criteria == '8')

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">

                        <input style="width:50px;" maxlength="4" type="text" name="start_criteria_scale_value[]" id="start_criteria_scale_value'.$num.'" value="'.$start_criteria_scale_value.'"></span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">&nbsp; - &nbsp;

                        <input style="width:50px;" maxlength="4" type="text" name="end_criteria_scale_value[]" id="end_criteria_scale_value'.$num.'" value="'.$end_criteria_scale_value.'"></span>';

    }

    else

    {

        $option_str .= '<span id="div_start_criteria_scale_value" style="display:'.$div_start_criteria_scale_value.'">

                        <input type="hidden" name="start_criteria_scale_value[]" id="start_criteria_scale_value'.$num.'" value="'.$start_criteria_scale_value.'"></span>';

        

        $option_str .= '<span id="div_end_criteria_scale_value" style="display:'.$div_end_criteria_scale_value.'">

                        <input type="hidden" name="end_criteria_scale_value[]" id="end_criteria_scale_value'.$num.'" value="'.$end_criteria_scale_value.'"></span>';

    }

    

  

    return $option_str;

}


function getMealQuantityOptionsVivek($breakfast_quantity)

{

	global $link;

	$option_str = '';		

	

	if($breakfast_quantity == '1')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}	

	$option_str .= '<option value="1" '.$sel.'>1</option>';

	

	

	if($breakfast_quantity == '1/4')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="1/4" '.$sel.'>1/4</option>';

	

	if($breakfast_quantity == '1/3')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="1/3" '.$sel.'>1/3</option>';

	

	if($breakfast_quantity == '1/2')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="1/2" '.$sel.'>1/2</option>';													

	

	if($breakfast_quantity == '2')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="2" '.$sel.'>2</option>';

	

	if($breakfast_quantity == '2/3')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="2/3" '.$sel.'>2/3</option>';

														

													

	for($j=3;$j<=1000;$j++) 

	{

		if($breakfast_quantity == $j)

		{

			$sel = ' selected ';

		}

		else

		{

			$sel = '';

		}		

		$option_str .= '<option value="'.$j.'" '.$sel.'>'.$j.'</option>';

	}

	return $option_str;

}


function getMealLikeOptionsVivek($breakfast_meal_like)

{

	global $link;

	$arr_food_like = array('Like','Dislike','Favourite','Allergic');

	$option_str = '';		

		

	for($i=0;$i<count($arr_food_like);$i++)

	{

		if($breakfast_meal_like == $arr_food_like[$i])

		{

			$sel = ' selected ';

		}

		else

		{

			$sel = '';

		}		

		$option_str .= '<option value="'.$arr_food_like[$i].'" '.$sel.'>'.$arr_food_like[$i].'</option>';

	}



	if($breakfast_meal_like == '')

	{

		$sel = ' selected ';

	}

	else

	{

		$sel = '';

	}

	$option_str .= '<option value="" '.$sel.'>None</option>';

	return $option_str;

}

function getDayOfWeekOptionsVivek($day_of_week)

{

    global $link;

    $option_str = '';

    

    $arr_day_of_week = array (

        1 => 'Sunday',

        2 => 'Monday',

        3 => 'Tuesday',

        4 => 'Wednesday',

        5 => 'Thursday',

        6 => 'Friday',

        7 => 'Saturday'

    );



    foreach($arr_day_of_week as $k => $v )

    {

            if($k == $day_of_week)

            {

                $selected = ' selected ';

            }

            else

            {

                $selected = '';

            }

            $option_str .= '<option value="'.$k.'" '.$selected.' >'.$v.'</option>';

    }	

    return $option_str;

}

function getTimeOptionsVivek($start_time,$end_time,$time)

{

	$start = $start_time *60 + 0;

	$end = $end_time * 60+0;

	

	for($i = $start; $i<$end; $i += 15)

	{

		$option_str='';

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


public function getInterpretationAddOption($fav_cat_id)
	{
            $this->connectDB();
            //echo 'aaa->'.$fav_cat_type_id;
            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT * FROM `tblsymtumscustomcategory` "
                    . "LEFT JOIN tblbodymainsymptoms ON tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id WHERE tblsymtumscustomcategory.fav_parent_cat = '".$fav_cat_id."' and tblbodymainsymptoms.bms_status = 1 ORDER BY tblbodymainsymptoms.bms_name ASC";
            //echo $sql;
            $this->execute_query($sql);
//            $option_str .= '<option value="">Select Category</option>';
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                    if($row['bmsid'] == $fav_cat_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }	
                    $cat_name[] = $row['bms_name'];
                   
//                    $option_str .= '<option value="'.$row['bmsid'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
//                    $option_str .= '<option value="'.$row['bmsid'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
                }
            }
            //echo $option_str;
            
            return $cat_name;
	}

//start vivek
public function getInterpretationOptionVivek($fav_cat_type_id,$fav_cat_id)
	{
            $this->connectDB();
            $option_str = '';		
            //echo 'aaa->'.$fav_cat_type_id;
            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT * FROM `tblsymtumscustomcategory` "
                    . "LEFT JOIN tblbodymainsymptoms ON tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id WHERE tblsymtumscustomcategory.fav_cat_type_id = '".$fav_cat_type_id."' and tblbodymainsymptoms.bms_status = 1 ORDER BY tblbodymainsymptoms.bms_name ASC";
            //echo $sql;
            $this->execute_query($sql);
//            $option_str .= '<option value="">Select Category</option>';
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                    if($row['bmsid'] == $fav_cat_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }	
                    $cat_name[] = $row['bms_name'];
                   
//                    $option_str .= '<option value="'.$row['bmsid'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
//                    $option_str .= '<option value="'.$row['bmsid'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
                }
            }
            //echo $option_str;
            
            return $cat_name;
	}
        
        
//        public function getSymptomDataOption($parent_cat_id,$fav_cat_id)
//	{
//            $this->connectDB();
//            $cat_name = '';		
//            //echo 'aaa->'.$fav_cat_type_id;
//            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
//            $sql = "SELECT * FROM `tblsymtumscustomcategory` "
//                    . "LEFT JOIN tblbodymainsymptoms ON tblsymtumscustomcategory.bmsid = tblbodymainsymptoms.bms_id WHERE tblsymtumscustomcategory.fav_cat_type_id = '".$parent_cat_id."' and tblbodymainsymptoms.bms_status = 1 ORDER BY tblbodymainsymptoms.bms_name ASC";
//            //echo $sql;
//            $this->execute_query($sql);
//            if($this->numRows() > 0)
//            {
//                while($row = $this->fetchRow())
//                {
//                    
//                    $cat_name[] = $row['bms_name'];
//                    
//                   
//                }
//            }
//            //echo $option_str;
//            
//            return $cat_name;
//	}
//        end start
        
//        vivek start
        
         public function getSelectedSubCatbyidVivek($page_cat_id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['sub_cat1'];
            }
            return $return;
	}
         public function getSelectedSubCat2byidVivek($page_cat_id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['sub_cat2'];
            }
            return $return;
	}
         public function getSelectedSubCat3byidVivek($page_cat_id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['sub_cat3'];
            }
            return $return;
	}
         public function getSelectedSubCat4byidVivek($page_cat_id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['sub_cat4'];
            }
            return $return;
	}
         public function getSelectedSubCat5byidVivek($page_cat_id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['sub_cat5'];
            }
            return $return;
	}
         public function getSelectedSubCat6byidVivek($page_cat_id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['sub_cat6'];
            }
            return $return;
	}
         public function getSelectedSubCat7byidVivek($page_cat_id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['sub_cat7'];
            }
            return $return;
	} public function getSelectedSubCat8byidVivek($page_cat_id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['sub_cat8'];
            }
            return $return;
	}
         public function getSelectedSubCat9byidVivek($page_cat_id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['sub_cat9'];
            }
            return $return;
	}
         public function getSelectedSubCat10byidVivek($page_cat_id)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['sub_cat10'];
            }
            return $return;
	}
        
        public function getDescriptionNameById($cs_id)
	{
		$this->connectDB();
		
		$cs_value = '';
				
		$sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_item_id` = '".$cs_id."' ";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$cs_value = stripslashes($row['rss_feed_item_desc']);
		}
		return $cs_value;
	}
        
         public function getRssTitleNameById($cs_id)
	{
		$this->connectDB();
		
		$cs_value = '';
				
		$sql = "SELECT * FROM `tblrssfeeditems` WHERE `rss_feed_item_id` = '".$cs_id."' ";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			$row = $this->fetchRow();
			$cs_value = stripslashes($row['rss_feed_item_title']);
		}
		return $cs_value;
	}
        
         public function chkDescriptionNameInTable($box_desc_data_explode)
	{
		$this->connectDB();
		 $obj = new Scrolling_Windows();
		$cs_value = array();
		$cs_value_data=array();
                
                for($i=0;$i<count($box_desc_data_explode);$i++)
                {
                  if($box_desc_data_explode[$i]!='')  
                  { 
                      
                        $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat` LIKE '%".$box_desc_data_explode[$i]."%'";
                        $this->execute_query($sql);
                        if($this->numRows() > 0)
                        {
                                while($row = $this->fetchRow())
                                {
                                $cs_value_data[] = stripslashes($row['fav_cat']);
                                }
                        }
                  }
                }
               
            for($i=0;$i<count($box_desc_data_explode);$i++)
                {
                  if($box_desc_data_explode[$i]!='')  
                  { 
                      
                        $sql = "SELECT * FROM `tbldailymeals` WHERE `meal_item` LIKE '%".$box_desc_data_explode[$i]."%'";
                        $this->execute_query($sql);
                        if($this->numRows() > 0)
                        {
                                while($row = $this->fetchRow())
                                {
                                $cs_value_data[] = stripslashes($row['meal_item']);
                                $fav_id = $obj->getfavCatIdFromDailyMealFavCat($row['meal_id']);
                                
                                foreach($fav_id as $rec)
                                {
                                $cs_value_data[] = $obj->getFavSubCatnamebyidVivek($rec);
                                }
                                
                                $cs_value_data[] = $obj->getFavSubCatnamebyidVivek($row['food_type']);
                                $cs_value_data[] = $obj->getFavSubCatnamebyidVivek($row['food_veg_nonveg']);
                               
                                }
                        }
                    
                  } 
                }
            for($i=0;$i<count($box_desc_data_explode);$i++)
                {
                  if($box_desc_data_explode[$i]!='')  
                  { 
                      
                        $sql = "SELECT * FROM `tbldailyactivity` WHERE `activity` LIKE '%".$box_desc_data_explode[$i]."%'";
                        $this->execute_query($sql);
                        if($this->numRows() > 0)
                        {
                                while($row = $this->fetchRow())
                                {
                                $cs_value_data[] = stripslashes($row['activity']);
                                $cs_value_data[] = $obj->getFavSubCatnamebyidVivek($row['activity_level_code']);
                                $cs_value_data[] = $obj->getFavSubCatnamebyidVivek($row['activity_category']);
                               
                                }
                        }
                    
                  } 
                }    
                
                $filtered = array_filter($cs_value_data);
                $cs_value = array_unique($filtered);
                $cs_value = array_values($cs_value);
//                 print_r($cs_value);die();
 
                $option = array();
//                $opt = '<input name="newkeyword_count" type="text" id="newkeyword_count" value="'.count($cs_value).'">';
                for($j=0;$j<count($cs_value); $j++)
                {
            
                $option[] = ' <div>
                                <div align="right" valign="top"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Keywords</strong></div>
                                <div align="center" valign="top"><strong>:</strong></div>
                                <div align="left" >
                                <input name="newkeyword_count" type="hidden" id="newkeyword_count" value="'.count($cs_value).'">
                                <input name="newkeywords[]" type="text" id="newkeywords_'.$j.'" value="'.$cs_value[$j].'"  style="width:150px; height: 25px;">&nbsp;&nbsp;
                                <input name="newselected[]" type="checkbox" id="newselected_'.$j.'"  onchange="checkNewDataSelectedOrNot('.$j.');" checked>
                                <input name="newselected_keywords[]" type="hidden" id="newselected_keywords_'.$j.'" value="active">

                                </div>

                            </div>';
                }
		return $option;
//                return $cs_value;
	}
        
          public function getfavCatIdFromDailyMealFavCat($cs_id)
	{
		$this->connectDB();
		
		$cs_value = array();
				
		$sql = "SELECT * FROM `tbldailymealsfavcategory` WHERE `meal_id` = '".$cs_id."' ";
		$this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow())
                        {
			$cs_value[] = stripslashes($row['fav_cat_id']);
                        }
		}
		return $cs_value;
	}
        
        public function getFavSubCatnamebyidVivek($fav_cat)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$fav_cat."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row['fav_cat'];
            }
            return $return;
	}
        
         public function getBmsIdFromSymtumsCustomCategoryTableViveks($fav_cat_type_id)
	{
            $this->connectDB();
            $option_str = '';		
           $sql = "SELECT * FROM `tblcustomfavcategory` WHERE id ='".$fav_cat_type_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
               
                $row = $this->fetchRow();
                $option_str = $row['favcat_id'];
               
            }
            //echo $option_str;
            
            return $option_str;
	}
         public function getSubCatNameByProfileCatIdFromFavCatTableVivek($fav_cat_type_id,$sub_cat_id_data)
	{
            $this->connectDB();
            $return = array();
            
           $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id IN('".$fav_cat_type_id."') and tblfavcategory.fav_cat_id IN('".$sub_cat_id_data."') ";
           $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    while($row = $this->fetchRow())
                    {
                    $return[] = $row['fav_cat'];
                    }
            }
            return $return;
	}
  
public function getSymtumsCustomCategoryAllDataViveks($fav_cat_type_id,$id)
	{
            $this->connectDB();
            $option_str = array();		
           $sql = "SELECT * FROM `tblcustomfavcategory` WHERE `favcat_id` ='".$fav_cat_type_id."' and `id` != '".$id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
               
                while($row = $this->fetchRow())
                {   
                   $option_str[] = $row;
                }
            }
            //echo $option_str;
            
            return $option_str;
	}
        
          public function getKeywordDataOptionsFromTblWellnessSolItemKeyword($sol_item_id,$keyword_name)
	{ 
            $this->connectDB();
            $option_str = '';		

            $sql = "SELECT * FROM `tbl_wellness_solution_item_keyword` WHERE `selected_keyword` = 'active' AND `sol_item_id` = '".$sol_item_id."' ORDER BY `keyword_name` ASC";
          
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
               
                while($row = $this->fetchRow())
                {
                    if($row['keyword_name'] == $keyword_name)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }		
                    $option_str .= '<option value="'.$row['keyword_name'].'" '.$sel.'>'.stripslashes($row['keyword_name']).'</option>';
                }
            }
            return $option_str;
	}
       
         public function getExclusionAllName($page_name)
	{
		$this->connectDB();
		
		$cs_value = array();
				
		$sql = "SELECT * FROM `tbl_exclusion` where `page_name` = '".$page_name."'";
	        $this->execute_query($sql);
		if($this->numRows() > 0)
		{
			while($row = $this->fetchRow())
                        {
                            $cs_value[] = strtolower($row['exl_name']);
                        }
		}
		return $cs_value;
	}
        public function getPageFavCatDropdownData($page_name,$parent_cat_id)
	{
            $this->connectDB();

            $fav_cat_type = array();

            $sql = "SELECT * FROM `tbl_page_fav_cat_dropdown` WHERE `page_name` = '".$page_name."' and `is_deleted`='0' and `pag_cat_status` = '1' ORDER BY `page_cat_id` Desc ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
              $row = $this->fetchRow();
               $prof_cat = explode(',',$row['prof_cat1']);
               if(in_array($parent_cat_id,$prof_cat))
               {
                    $fav_cat_type[] = $row['sub_cat1'];
               }
            }
            return $fav_cat_type;
	}
        
        public function getFavCategoryVivek($fav_cat_type_id,$sub_cat_id,$fav_cat_id)
	{
            $this->connectDB();
            $option_str = '';		
            //echo 'aaa->'.$fav_cat_type_id;
            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
             $sql = "SELECT * FROM `tblcustomfavcategory` "
                    . "LEFT JOIN tblfavcategory ON tblcustomfavcategory.favcat_id = tblfavcategory.fav_cat_id WHERE tblcustomfavcategory.fav_cat_type_id = '".$fav_cat_type_id."' and tblfavcategory.fav_cat_id IN('".$sub_cat_id."') and tblfavcategory.fav_cat_status = 1 and tblfavcategory.fav_cat_deleted = 0 and tblcustomfavcategory.cat_deleted=0 and tblcustomfavcategory.cat_status = 1 ORDER BY tblfavcategory.fav_cat ASC";
           //echo $sql;
            $this->execute_query($sql);
            $option_str .= '<option value="">Select Category</option>';
            if($this->numRows() > 0)
            {
                while($row = $this->fetchRow())
                {
                    if($row['favcat_id'] == $fav_cat_id)
                    {
                            $sel = ' selected ';
                    }
                    else
                    {
                            $sel = '';
                    }	
                    $cat_name = $row['fav_cat'];
                    $option_str .= '<option value="'.$row['favcat_id'].'" '.$sel.'>'.stripslashes($cat_name).'</option>';
                }
            }
            //echo $option_str;
            
            return $option_str;
	}
        public function getPageCatDropdownData($page_name)
	{
            $this->connectDB();

            $fav_cat_type = array();

            $sql = "SELECT * FROM `tbl_page_cat_dropdown` WHERE `page_name` = '".$page_name."' and `is_deleted`='0' and `pag_cat_status`='1' ORDER BY `page_cat_id` Desc ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
              $row = $this->fetchRow();
               
                $fav_cat_type[] = $row['prof_cat1'];
               
            }
            return $fav_cat_type;
	}
        
        public function getFavCategoryTypeOptionsVivek($fav_cat_type_id,$prof_cat_pdd_implode)
	{ 
            $this->connectDB();
            $option_str = '';		

            //$sql = "SELECT * FROM `tblfavcategorytype` WHERE `fav_cat_type_status` = '1' AND `fav_cat_type_deleted` = '0' ORDER BY `fav_cat_type` ASC";
            $sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` IN('".$prof_cat_pdd_implode."') AND `prct_cat_status` = '1' AND `prct_cat_deleted` = '0' ORDER BY `prct_cat` ASC";
            //echo $sql;
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                $option_str .='<option value="">Select Type</option>';
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
                    $option_str .= '<option value="'.$row['prct_cat_id'].'" '.$sel.'>'.stripslashes($row['prct_cat']).$row['prct_cat_id'].'</option>';
                }
            }
            return $option_str;
	}
       
        
//        vivek end
        //Ramakant new
        public function getfavcategorynamebyid($id)
        {
            $this->connectDB();
            
            
            $sql = "SELECT `fav_cat` FROM `tblfavcategory` WHERE `fav_cat_id` = '".$id."' ";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
              $row = $this->fetchRow();
            }
            return $row['fav_cat'];
        }
        
        public function getProflecategorynamebyid($id)
        {
            $this->connectDB();
           
            
            $sql = "SELECT `prct_cat` FROM `tblprofilecustomcategories` WHERE `prct_cat_id` = '".$id."' ";    
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
              $row = $this->fetchRow();
            }
            return $row['prct_cat'];
        }
        
        public function getSelecteddataSubCatbyid($page_cat_id,$columns)
	{
            $this->connectDB();
            $return = '';
            
            $sql = "SELECT $columns FROM `tbl_data_dropdown` WHERE `page_cat_id` = '".$page_cat_id."' ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
                    $row = $this->fetchRow();
                    $return = $row[''.$columns.''];
            }
            return $return;
            //print_r($return);
	}
        
        //ramakant end
   public function addVendorLocation2($tdata)
    {
		
        $this->connectDB();
        $return = 0;
		
		try {
			$sql = "INSERT INTO `tblvendorlocations` (`vendor_id`,`contact_person`,`contact_person_title`,`contact_email`,`contact_designation`,`contact_number`,`contact_remark`,`country_id`,`state_id`,`city_id`,`area_id`,`vloc_parent_cat_id`,`vloc_cat_id`,`vloc_speciality_offered`,`vloc_doc_file`,`vloc_menu_file`,`vloc_default`,`vloc_status`,`added_by_admin`,`vloc_add_date`) 
					VALUES (:vendor_id,:contact_person,:contact_person_title,:contact_email,:contact_designation,:contact_number,:contact_remark,:country_id,:state_id,:city_id,:area_id,:vloc_parent_cat_id,:vloc_cat_id,:vloc_speciality_offered,:vloc_doc_file,:vloc_menu_file,:vloc_default,:vloc_status,:added_by_admin,:vloc_add_date)";
			$this->execute_query($sql);
            $this->execute_query(array(
				':vendor_id' => $tdata['vendor_id'],
				':contact_person' => addslashes($tdata['contact_person']),
				':contact_person_title' => addslashes($tdata['contact_person_title']),
				':contact_email' => addslashes($tdata['contact_email']),
				':contact_designation' => addslashes($tdata['contact_designation']),
				':contact_number' => addslashes($tdata['contact_number']),
				':contact_remark' => addslashes($tdata['contact_remark']),
				':country_id' => addslashes($tdata['country_id']),
				':state_id' => addslashes($tdata['state_id']),
				':city_id' => addslashes($tdata['city_id']),
				':area_id' => addslashes($tdata['area_id']),
				':vloc_parent_cat_id' => addslashes($tdata['vloc_parent_cat_id']),
				':vloc_cat_id' => addslashes($tdata['vloc_cat_id']),
				':vloc_speciality_offered' => addslashes($tdata['vloc_speciality_offered']),
				':vloc_doc_file' => addslashes($tdata['vloc_doc_file']),
				':vloc_menu_file' => addslashes($tdata['vloc_menu_file']),
				':vloc_default' => addslashes($tdata['vloc_default']),
				':vloc_status' => '1',
				':added_by_admin' => $tdata['admin_id'],
				':vloc_add_date' => date('Y-m-d H:i:s')
				
            ));
			$return = $this->lastInsertId();
			$DBH->commit();
		} catch (Exception $e) {
			$stringData = '[addVendorLocation] Catch Error:'.$e->getMessage().', sql:'.$sql;
			$this->debuglog($stringData);
            return 0;
        }
        return $return;
    }
    
    public function addVendorLocation($tdata) {
          
            $this->connectDB();
            $return = 0;
            $sql = "INSERT INTO `tblvendorlocations` (`vendor_id`,`contact_person`,`contact_person_title`,`contact_email`,`contact_designation`,`contact_number`,`contact_remark`,`country_id`,`state_id`,`city_id`,`area_id`,`vloc_parent_cat_id`,`vloc_cat_id`,`vloc_speciality_offered`,`vloc_doc_file`,`vloc_menu_file`,`vloc_default`,`vloc_status`,`added_by_admin`,`vloc_add_date`) VALUES ('".addslashes($tdata['vendor_id'])."','".addslashes($tdata['contact_person'])."','".addslashes($tdata['contact_person_title'])."','".addslashes($tdata['contact_email'])."','".addslashes($tdata['contact_designation'])."','".addslashes($tdata['contact_number'])."','".addslashes($tdata['contact_remark'])."','".addslashes($tdata['country_id'])."','".addslashes($tdata['state_id'])."','".addslashes($tdata['city_id'])."','".addslashes($tdata['area_id'])."','".addslashes($tdata['vloc_parent_cat_id'])."','".addslashes($tdata['vloc_cat_id'])."','".addslashes($tdata['vloc_speciality_offered'])."','".addslashes($tdata['vloc_doc_file'])."','".addslashes($tdata['vloc_menu_file'])."','".addslashes($tdata['vloc_default'])."','1','".$tdata['admin_id']."','".date('Y-m-d H:i:s')."')";
            $this->execute_query($sql); 
            $return = $this->lastVendorLocationInsertId();
            return $return;
        }
    public function addVendorCerification($tdata) {
          
            $this->connectDB();
            $return = 0;
            $sql = "INSERT INTO `tblvendorcertifications` (`vendor_id`,`vloc_id`,`vc_cert_type_id`,`vc_cert_name`,`vc_cert_no`,`vc_cert_reg_date`,`vc_cert_validity_date`,`vc_cert_issued_by`,`vc_cert_scan_file`,`vc_cert_status`,`added_by_admin`,`vc_cert_add_date`) VALUES ('".addslashes($tdata['vendor_id'])."','".addslashes($tdata['vloc_id'])."','".addslashes($tdata['vc_cert_type_id'])."','".addslashes($tdata['vc_cert_name'])."','".addslashes($tdata['vc_cert_no'])."','".addslashes($tdata['vc_cert_reg_date'])."','".addslashes($tdata['vc_cert_validity_date'])."','".addslashes($tdata['vc_cert_issued_by'])."','".addslashes($tdata['vc_cert_scan_file'])."','".$tdata['vc_cert_status']."','".$tdata['admin_id']."','".date('Y-m-d H:i:s')."')";
            $this->execute_query($sql); 
            $return = $this->lastVendorCertificationInsertId();                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
            return $return; 
        }    

    public function addVendor($tdata)
    {
        $this->connectDB();
        $return = false;
            $sql = "INSERT INTO `tblvendors` (`vendor_username`,`vendor_password`,`vendor_email`,`vendor_name`,`vendor_parent_cat_id`,`vendor_cat_id`,`vendor_status`,`vendor_add_date`,`added_by_admin`,`va_id`,`new_vendor`) VALUES ('".addslashes($tdata['vendor_username'])."','".addslashes($tdata['vendor_password'])."','".addslashes($tdata['vendor_email'])."','".addslashes($tdata['vendor_name'])."','".addslashes($tdata['vendor_parent_cat_id'])."','".addslashes($tdata['vendor_cat_id'])."','".addslashes($tdata['vendor_status'])."','".date('Y-m-d H:i:s')."','".$tdata['admin_id']."','".$tdata['va_id']."','".$tdata['new_vendor']."')";
            $this->execute_query($sql); 
        
                $vendor_id = $this->vendorlastInsertId();
                
			if($vendor_id > 0)
			{
				$return = true;
				if(count($tdata['vloc_parent_cat_id']) > 0)
				{
					for($i=0;$i<count($tdata['vloc_parent_cat_id']);$i++)
					{
						$tdata_vloc = array();
						$tdata_vloc['vendor_id'] = $vendor_id;
						$tdata_vloc['contact_person'] = $tdata['contact_person'][$i];
						$tdata_vloc['contact_person_title'] = $tdata['contact_person_title'][$i];
						$tdata_vloc['contact_email'] = $tdata['contact_email'][$i];
						$tdata_vloc['contact_designation'] = $tdata['contact_designation'][$i];
						$tdata_vloc['contact_number'] = $tdata['contact_number'][$i];
						$tdata_vloc['contact_remark'] = $tdata['contact_remark'][$i];
						$tdata_vloc['country_id'] = $tdata['country_id'][$i];
						$tdata_vloc['state_id'] = $tdata['state_id'][$i];
						$tdata_vloc['city_id'] = $tdata['city_id'][$i];
						$tdata_vloc['area_id'] = $tdata['area_id'][$i];
						$tdata_vloc['vloc_parent_cat_id'] = $tdata['vloc_parent_cat_id'][$i];
						$tdata_vloc['vloc_cat_id'] = $tdata['vloc_cat_id'][$i];
						$tdata_vloc['vloc_speciality_offered'] = $tdata['vloc_speciality_offered'][$i];
						$tdata_vloc['vloc_doc_file'] = $tdata['vloc_doc_file'][$i];
						$tdata_vloc['vloc_menu_file'] = $tdata['vloc_menu_file'][$i];
						if($i == 0)
						{
							$tdata_vloc['vloc_default'] = 1;	
						}
						else
						{
							$tdata_vloc['vloc_default'] = 0;	
						}
						$tdata_vloc['vloc_status'] = 1;
						$tdata_vloc['admin_id'] = $tdata['admin_id'];
						
						$vloc_id = $this->addVendorLocation($tdata_vloc);		
						if($vloc_id > 0)
						{
							for($k=0;$k<count($tdata['vc_cert_type_id'][$i]);$k++)
							{
								$tdata_vc = array();
								$tdata_vc['vendor_id'] = $vendor_id;
								$tdata_vc['vloc_id'] = $vloc_id;
								$tdata_vc['vc_cert_type_id'] = $tdata['vc_cert_type_id'][$i][$k];
								$tdata_vc['vc_cert_name'] = $tdata['vc_cert_name'][$i][$k];
								$tdata_vc['vc_cert_no'] = $tdata['vc_cert_no'][$i][$k];
								$tdata_vc['vc_cert_reg_date'] = $tdata['vc_cert_reg_date'][$i][$k];
								$tdata_vc['vc_cert_validity_date'] = $tdata['vc_cert_validity_date'][$i][$k];
								$tdata_vc['vc_cert_issued_by'] = $tdata['vc_cert_issued_by'][$i][$k];
								$tdata_vc['vc_cert_scan_file'] = $tdata['vc_cert_scan_file'][$i][$k];
								$tdata_vc['vc_cert_status'] = 1;
								$tdata_vc['admin_id'] = $tdata['admin_id'];
								$vc_cert_id = $this->addVendorCerification($tdata_vc);		
							}			
						}
					}
				}
			}
                        else
                        {
                            $return = false;
                        }
                        return $return; 
      // return $this->result;
                        
    }
//	
    
     public function vendorlastInsertId()
	{
            $this->connectDB();
            $option_str = '';		
           $sql = "SELECT MAX(`vendor_id`) as vendor_id FROM `tblvendors` WHERE 1 ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
               
                $row = $this->fetchRow();
                $option_str = $row['vendor_id'];
               
            }
            //echo $option_str;
            
            return $option_str;
	}
    public function lastVendorLocationInsertId()
	{
            $this->connectDB();
            $option_str = '';		
           $sql = "SELECT MAX(`vloc_id`) as vloc_id FROM `tblvendorlocations` WHERE 1 ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
               
                $row = $this->fetchRow();
                $option_str = $row['vloc_id'];
               
            }
            //echo $option_str;
            
            return $option_str;
	}
        
    public function lastVendorCertificationInsertId()
	{
            $this->connectDB();
            $option_str = '';		
           $sql = "SELECT MAX(`vc_cert_id`) as vc_cert_id FROM `tblvendorcertifications` WHERE 1 ";
            $this->execute_query($sql);
            if($this->numRows() > 0)
            {
               
                $row = $this->fetchRow();
                $option_str = $row['vc_cert_id'];
               
            }
            //echo $option_str;
            
            return $option_str;
	}
}

?>
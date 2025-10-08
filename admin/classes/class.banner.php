<?php
include_once("class.paging.php");
include_once("class.admin.php");

class Banner extends Admin
{

    public function getAllBannerSizeMasters($search,$status){
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $admin_id = $_SESSION['admin_id'];
        $edit_action_id = '286';
        $delete_action_id = '287';
        $view_item_action_id = '284';
        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);
        $view_item = $this->chkValidActionPermission($admin_id,$view_item_action_id);
        if($search == ''){
            $str_sql_search = "";
        }else{
            $str_sql_search = " AND TP.position like '%".$search."%' ";
        }

        if($status == ''){
            $str_sql_status = "";
        }else{
            //commented by rahul
            //$str_sql_status = " AND TB.bci_status = '".$status."' ";
            $str_sql_status = " AND TB.bs_status = '".$status."' ";
        }
        $sql = "SELECT * FROM `tblbannerssizes` AS TB "
                . "LEFT JOIN `tblposition` AS TP ON TB.position_id = TP.position_id "
                . "WHERE TB.bs_deleted = '0' ".$str_sql_search." ".$str_sql_status." "
                . "ORDER BY TB.bs_add_date DESC ";
        $STH = $DBH->prepare($sql);
		$STH->execute();
        $total_records = $STH->rowCount();
        $record_per_page = 25;
        $scroll = 5;
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
        $page->set_link_parameter("Class = paging");
        $page->set_qry_string($str="mode=banners_sizes_master");
        $STH2 = $DBH->prepare($page->get_limit_query($sql));
        $STH2->execute();
        $output = '';		
        if($STH2->rowCount() > 0){
            if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ){
                $i = $page->start + 1;
            }else{
                $i = 1;
            }
            while($row = $STH2->fetch(PDO::FETCH_ASSOC)){
                $obj2 = new Banner();
                if($row['bs_status'] == '1'){
                    $status = 'Active';
                }else{
                    $status = 'Inactive';
                }
                $date_value = date('d-m-Y',strtotime($row['bs_effective_date']));
                //commented by rahul
                // $output .= '<tr class="manage-row">';
                // $output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
                // $output .= '<td height="30" align="center">'.stripslashes($row['position']).'</td>';
                // $output .= '<td height="30" align="center">'.stripslashes($row['bs_width']).'</td>';
                // $output .= '<td height="30" align="center">'.stripslashes($row['bs_height']).'</td>';
                // $output .= '<td height="30" align="center">'.stripslashes($row['bs_banner_type']).'</td>';
                // $output .= '<td height="30" align="center">'.stripslashes($row['bs_currency']).'</td>';
                // $output .= '<td height="30" align="center">'.stripslashes($row['bs_amount']).'</td>';
                // $output .= '<td height="30" align="center">'.$date_value.'</td>';
                // $output .= '<td height="30" align="center">'.$status.'</td>';
                // $output .= '<td align="center" nowrap="nowrap">';

                $output .= '<tr class="manage-row">';
                $output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';
                $output .= '<td align="center" nowrap="nowrap">';
                if($edit) {
                    $output .= '<a href="index.php?mode=edit_banner_size&id='.$row['bs_id'].'" ><img src = "images/edit.gif" border="0"></a>';
                }
                $output .= '</td>';
                $output .= '<td align="center" nowrap="nowrap">';
                if($delete) {
                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delbannersize.php?id='.$row['bs_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
                }
                $output .= '</td>';
                $output .= '<td height="30" align="center">'.stripslashes($row['bs_width']).'</td>';
                $output .= '<td height="30" align="center">'.stripslashes($row['bs_height']).'</td>';
                $output .= '<td height="30" align="center">'.stripslashes($row['bs_remarks']).'</td>';
                $output .= '<td height="30" align="center">'.$status.'</td>';
                
                $output .= '</tr>';
                $i++;
            }
        }else{
            $output = '<tr class="manage-row" height="20"><td colspan="14" align="center">NO RECORDS FOUND</td></tr>';
        }
        $page->get_page_nav();
        return $output;
    }

    

    

    public function addBannerSizeMaster($position_id,$bs_width,$bs_height,$arr_bs_banner_type,$arr_bs_currency,$arr_bs_amount,$bs_effective_date,$bs_remarks,$admin_id,$bs_status){
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $updated_on_date = date('Y-m-d H:i:s');
        for($i=0;$i<count($arr_bs_banner_type);$i++){
            //commented by rahul

            // $sql = "INSERT INTO `tblbannerssizes` (`position_id`,`bs_width`,`bs_height`,`bs_remarks`,`bs_banner_type`,`bs_currency`,`bs_amount`,`bs_effective_date`,`bs_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`,`bs_deleted`) " . "VALUES ('".addslashes($position_id)."','".addslashes($bs_width)."','".addslashes($bs_height)."','".addslashes($bs_remarks)."','".addslashes($arr_bs_banner_type[$i])."','".addslashes($arr_bs_currency[$i])."',". "'".addslashes($arr_bs_amount[$i])."','".addslashes($bs_effective_date)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."',0)";
            // $STH = $DBH->prepare($sql);
            // $STH->execute();

            // Prepare the SQL with placeholders
            $sql = "INSERT INTO tblbannerssizes 
                    (position_id, bs_width, bs_height, bs_remarks, bs_banner_type, bs_currency, bs_amount, bs_effective_date, bs_status, added_by_admin, updated_by_admin, updated_on_date, bs_deleted)
                    VALUES 
                    (:position_id, :bs_width, :bs_height, :bs_remarks, :bs_banner_type, :bs_currency, :bs_amount, :bs_effective_date, :bs_status, :added_by_admin, :updated_by_admin, :updated_on_date, :bs_deleted)";

            // Prepare the statement
            $STH = $DBH->prepare($sql);

            // Bind the parameters and execute inside a loop (for multiple banners)
            $STH->execute([
                ':position_id'     => $position_id[$i] ?? 0,
                ':bs_width'        => $bs_width[$i],
                ':bs_height'       => $bs_height[$i],
                ':bs_remarks'      => $bs_remarks[$i],
                ':bs_banner_type'  => $arr_bs_banner_type[$i],
                ':bs_currency'     => $arr_bs_currency[$i],
                ':bs_amount'       => $arr_bs_amount[$i],
                ':bs_effective_date'=> $bs_effective_date[$i] ?? '0000-00-00',
                ':added_by_admin'  => $admin_id,
                ':updated_by_admin'=> $admin_id,
                ':updated_on_date' => $updated_on_date,
                ':bs_status'         => $bs_status[$i] ?? 0,
                ':bs_deleted'      => 0
            ]);
        }
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }

    public function updateBannerSizeMaster($bs_id,$position_id,$bs_width,$bs_height,$arr_bs_banner_type,$arr_bs_currency,$arr_bs_amount,$bs_effective_date,$bs_remarks,$admin_id,$bs_status){
       
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $updated_on_date = date('Y-m-d H:i:s');
            $sql = "UPDATE tblbannerssizes SET
            bs_remarks       = :bs_remarks,
            updated_on_date  = :updated_on_date,
             bs_status  = :bs_status
        WHERE bs_id = :bs_id AND bs_deleted = 0";

            // Prepare the statement
            $STH = $DBH->prepare($sql);

            // Loop through each banner if needed (for multiple banners)
            $STH->execute([
                ':bs_remarks'        => $bs_remarks,
                ':updated_on_date'   => $updated_on_date,
                ':bs_id'             => $bs_id,
                ':bs_status'         => $bs_status ?? 0
            ]);
            

            // Check if update succeeded
            if($STH->rowCount() > 0){
                $return = true;
            } else {
                $return = false;
            }

            return $return;
    }

    public function deleteBannerSizeMaster($bs_id)

	{

    $my_DBH = new mysqlConnection();
	$DBH = $my_DBH->raw_handle();
	$DBH->beginTransaction();
         $return=false;
            $sql = "UPDATE `tblbannerssizes` SET "

                    . "`bs_deleted` = '1' "

                    . "WHERE `bs_id` = '".$bs_id."'";

	    //echo $sql;

           $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

        

    // Banner Size Master Functions - Start 

    

    

        // Banner Contract Items Functions - Start

    

        public function getAllBannerContractItems($banner_cont_id,$search,$status)

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();


            $admin_id = $_SESSION['admin_id'];

            $edit_action_id = '245';

            $delete_action_id = '246';

            $view_item_action_id = '243';

            $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

            $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

            $view_item = $this->chkValidActionPermission($admin_id,$view_item_action_id);



            if($search == '')

            {

                $str_sql_search = "";

            }

            else

            {

                $str_sql_search = " AND TB.page like '%".$search."%' ";

            }



            if($status == '')

            {

                $str_sql_status = "";

            }

            else

            {

                $str_sql_status = " AND TB.bci_status` = '".$status."' ";

            }



            $sql = "SELECT * FROM `tblbannercontractitems` AS TB "

                    . "LEFT JOIN `tblposition` AS TP ON TB.position_id = TP.position_id "

                    . "WHERE TB.banner_cont_id = '".$banner_cont_id."' AND  TB.bci_deleted = '0' ".$str_sql_search." ".$str_sql_status." "

                    . "ORDER BY TB.page ASC, TP.position ASC , TB.bci_add_date DESC ";

            //echo '<br>'.$sql;

            $STH = $DBH->prepare($sql);
            $STH->execute();

            $total_records = $STH->rowCount();

            $record_per_page=25;

            $scroll = 5;

            $page = new Page(); 

            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

            $page->set_link_parameter("Class = paging");

            $page->set_qry_string($str="mode=document_items");

            $STH2 = $DBH->prepare($page->get_limit_query($sql));
            $STH2->execute();

            $output = '';		

            if($STH2->rowCount() > 0)

            {

                if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

                {

                    $i = $page->start + 1;

                }

                else

                {

                    $i = 1;

                }



                while($row = $STH2->fetch(PDO::FETCH_ASSOC))

                {

                    $obj2 = new Banner();

                    

                    if($row['bci_status'] == '1')

                    {

                        $status = 'Active';

                    }

                    else

                    {

                        $status = 'Inactive';

                    }

                    

                    if($row['banner_type'] == 'Google Ads')

                    {

                        $banner = 'Google Ads';

                    }

                    else

                    {

                        $banner = stripslashes($row['banner']);

                    }



                    if($row['added_by_admin'] == '0')

                    {

                        $added_by_admin = '';

                    }

                    else

                    {

                        $added_by_admin = $obj2->getUsenameOfAdmin($row['added_by_admin']);

                    }

                    

                    $page_name = $obj2->getPageName($row['page_id']);



                    $date_value = date('d-m-Y',strtotime($row['bci_add_date']));



                    $output .= '<tr class="manage-row">';

                    $output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

                    $output .= '<td height="30" align="center">'.$page_name.'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($row['position']).'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($row['width']).'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($row['height']).'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($row['banner_type']).'</td>';

                    $output .= '<td height="30" align="center">'.$banner.'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($row['url']).'</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($view_item) {

                    $output .= '<a href="#" >Display Options</a>';

                    }

                    $output .= '</td>';

                    $output .= '<td height="30" align="center">'.$status.'</td>';

                    $output .= '<td height="30" align="center">'.$date_value.'</td>';

                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($edit) {

                    $output .= '<a href="index.php?mode=edit_document_item&id='.$row['banner_cont_id'].'&bid='.$row['bci_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                    }

                    $output .= '</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($delete) {

                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/deldocumentitem.php?id='.$row['bci_id'].'&cid='.$row['banner_cont_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

                    }

                    $output .= '</td>';

                    $output .= '</tr>';

                    $i++;

                }

            }

            else

            {

                $output = '<tr class="manage-row" height="20"><td colspan="14" align="center">NO RECORDS FOUND</td></tr>';

            }



            $page->get_page_nav();

            return $output;

	}

        

        public function addBannerContractItems($banner_cont_id,$arr_page_id,$arr_position_id,$arr_width,$arr_height,$arr_banner_type,$arr_banner,$arr_url,$arr_bci_order,$arr_bci_frequency,$admin_id)

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
    $return = false;



            $updated_on_date = date('Y-m-d H:i:s');

            

            for($i=0;$i<count($arr_page_id);$i++)

            {

                $sql = "INSERT INTO `tblbannercontractitems` (`banner_cont_id`,`page_id`,`position_id`,`banner`,"

                    . "`url`,`banner_type`,`width`,`height`,`bci_order`,`bci_frequency`,`bci_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`) "

                    . "VALUES ('".addslashes($banner_cont_id)."','".addslashes($arr_page_id[$i])."','".addslashes($arr_position_id[$i])."',"

                    . "'".addslashes($arr_banner[$i])."','".addslashes($arr_url[$i])."','".addslashes($arr_banner_type[$i])."',"

                    . "'".addslashes($arr_width[$i])."','".addslashes($arr_height[$i])."','".addslashes($arr_bci_order[$i])."','".addslashes($arr_bci_frequency[$i])."','1','".$admin_id."','".$admin_id."','".$updated_on_date."')";

                $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
            }
        }
        

        public function deleteBannerContractItem($bci_id)

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
    $return=false;
            $sql = "UPDATE `tblbannercontractitems` SET "

                    . "`bci_deleted` = '1' "

                    . "WHERE `bci_id` = '".$bci_id."'";

	    //echo $sql;

           $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
            }
        
        
        

        public function getBannerContractItemDetails($bci_id)

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
            $banner_cont_id = '';

            $page_id = '';

            $position_id = '';

            $banner = '';

            $url = '';

            $banner_type = '';

            $width = '';

            $height = '';

            $bci_status = '';

            $bci_order = '';

            $bci_frequency = '';



            $sql = "SELECT * FROM `tblbannercontractitems` WHERE `bci_id` = '".$bci_id."' AND `bci_deleted` = '0' ";

            //echo $sql;

            $STH = $DBH->prepare($sql);
            $STH->execute();

            if($STH->rowCount() > 0)

            {

              $row = $STH->fetch(PDO::FETCH_ASSOC);

                $banner_cont_id = stripslashes($row['banner_cont_id']);

                $page_id = stripslashes($row['page_id']);

                $position_id = stripslashes($row['position_id']);

                $banner = stripslashes($row['banner']);

                $url = stripslashes($row['url']);

                $banner_type = stripslashes($row['banner_type']);

                $width = stripslashes($row['width']);

                $height = stripslashes($row['height']);

                $bci_status = stripslashes($row['bci_status']);

                $bci_order = stripslashes($row['bci_order']);

                $bci_frequency = stripslashes($row['bci_frequency']);

            }

            return array($banner_cont_id,$page_id,$position_id,$banner,$url,$banner_type,$width,$height,$bci_order,$bci_frequency,$bci_status);

	}

        

        public function updateBannerContractItem($bci_id,$banner_cont_id,$page_id,$position_id,$width,$height,$banner_type,$banner,$url,$bci_order,$bci_frequency,$bci_status,$admin_id)

	{

    $my_DBH = new mysqlConnection(); 
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
     $return=false;
            $updated_on_date = date('Y-m-d H:i:s');

            

            $sql = "UPDATE `tblbannercontractitems` SET "

                    . "`page_id` = '".addslashes($page_id)."' ,"

                    . "`position_id` = '".addslashes($position_id)."' ,"

                    . "`width` = '".addslashes($width)."' ,"

                    . "`height` = '".addslashes($height)."' ,"

                    . "`banner_type` = '".addslashes($banner_type)."' ,"

                    . "`banner` = '".addslashes($banner)."' ,"

                    . "`url` = '".addslashes($url)."' ,"

                    . "`bci_order` = '".addslashes($bci_order)."' ,"

                    . "`bci_frequency` = '".addslashes($bci_frequency)."' ,"

                    . "`bci_status` = '".addslashes($bci_status)."' ,"

                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"

                    . "`updated_on_date` = '".addslashes($updated_on_date)."' "

                    . "WHERE `banner_cont_id` = '".$banner_cont_id."' AND `bci_id` = '".$bci_id."' ";

	    //echo $sql;

           $STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;
            }
        
        

        

        // Banner Contract Item Functions - End

        

        // Banner Contracts Functions - Start

        

        public function getCurrencyOptions($currency)

	{

            $option_str = '';		



            $arr_currency = array('INR','USD','GBP','EUR');

            sort($arr_currency);



            for($i=0;$i<count($arr_currency);$i++)

            {

                    if($arr_currency[$i] == $currency)

                    {

                            $sel = ' selected ';

                    }

                    else

                    {

                            $sel = '';

                    }		

                    $option_str .= '<option value="'.$arr_currency[$i].'" '.$sel.'>'.$arr_currency[$i].'</option>';

            }

            return $option_str;

	}

        

        public function getPRCTCategoryName($prct_cat_id)

        {

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
            $prct_cat = '';



            //$sql = "SELECT * FROM `tblprofilecustomcategories` WHERE `prct_cat_id` = '".$prct_cat_id."' AND `prct_cat_deleted` = '0' ";

            $sql = "SELECT * FROM `tblfavcategory` WHERE `fav_cat_id` = '".$prct_cat_id."' AND `fav_cat_deleted` = '0' ";

            $STH = $DBH->prepare($sql);
            $STH->execute();

            if($STH->rowCount() > 0)

            {

              $row = $STH->fetch(PDO::FETCH_ASSOC);

                $prct_cat = stripcslashes($row['fav_cat']);

            }    



            return $prct_cat;

        }

        

        public function getContractsTransactionTypeName($ctt_id)

        {

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
            $ctt_name = '';



            $sql = "SELECT * FROM `tblcontractstranstype` WHERE `ctt_id` = '".$ctt_id."' AND `ctt_deleted` = '0' ";

            $STH = $DBH->prepare($sql);
            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $ctt_name = stripcslashes($row['ctt_name']);

            }    



            return $ctt_name;

        }

        

        public function getAllBannerContracts($search,$status)

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();


            $admin_id = $_SESSION['admin_id'];

            $edit_action_id = '241';

            $delete_action_id = '242';

            $view_item_action_id = '243';

            $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

            $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

            $view_item = $this->chkValidActionPermission($admin_id,$view_item_action_id);



            if($search == '')

            {

                    $str_sql_search = "";

            }

            else

            {

                    $str_sql_search = " AND (`banner_contract_no` LIKE '%".$search."%' OR `banner_order_no` LIKE '%".$search."%')";

            }



            if($status == '')

            {

                $str_sql_status = "";

            }

            else

            {

                $str_sql_status = " AND `banner_cont_status` = '".$status."' ";

            }



            $sql = "SELECT * FROM `tblbannercontracts` WHERE `banner_cont_deleted` = '0' ".$str_sql_search."  ".$str_sql_status."  ORDER BY `banner_cont_add_date` DESC ";		

            //echo '<br>'.$sql;

            $STH = $DBH->prepare($sql);
            $STH->execute();

            $total_records = $STH->rowCount();

            $record_per_page=25;

            $scroll = 5;

            $page = new Page(); 

            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

            $page->set_link_parameter("Class = paging");

            $page->set_qry_string($str="mode=document_master");

            $STH2 = $DBH->prepare($page->get_limit_query($sql));
            $STH2->execute();

            $output = '';		

            if($STH2->rowCount() > 0)

            {

                if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

                {

                    $i = $page->start + 1;

                }

                else

                {

                    $i = 1;

                }



                while($row = $STH2->fetch(PDO::FETCH_ASSOC))

                {

                    $obj2 = new Banner();

                    

                    $client_name = $obj2->getClientName($row['banner_client_id']);

                    

                    if($row['banner_broker_id'] > 0)

                    {

                        $broker_name = $obj2->getClientName($row['banner_broker_id']);

                    }

                    else

                    {

                        $broker_name = '';

                    }

                    

                    if($row['banner_cont_status'] == '1')

                    {

                        $status = 'Active';

                    }

                    else

                    {

                        $status = 'Inactive';

                    }



                    if($row['added_by_admin'] == '0')

                    {

                        $added_by_admin = '';

                    }

                    else

                    {

                        $added_by_admin = $obj2->getUsenameOfAdmin($row['added_by_admin']);

                    }



                    $contract_date = date('d-m-Y',strtotime($row['banner_contract_date']));

                    $booked_date = date('d-m-Y',strtotime($row['banner_booked_date']));

                    $date_value = date('d-m-Y',strtotime($row['banner_cont_add_date']));

                    

                    $ctt_name = $obj2->getContractsTransactionTypeName($row['ctt_id']);

                    $prct_cat = $obj2->getPRCTCategoryName($row['prct_cat_id']);



                    $output .= '<tr class="manage-row">';

                    $output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

                    $output .= '<td height="30" align="center">'.$client_name.'</td>';

                    $output .= '<td height="30" align="center">'.$ctt_name.'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($row['banner_contract_no']).'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($row['banner_order_no']).'</td>';

                    $output .= '<td height="30" align="center">'.$broker_name.'</td>';

                    $output .= '<td height="30" align="center">'.$contract_date.'</td>';

                    $output .= '<td height="30" align="center">'.$booked_date.'</td>';

                    $output .= '<td height="30" align="center">'.$prct_cat.'</td>';

                    $output .= '<td height="30" align="center">'.stripslashes($row['currency']).' '.stripslashes($row['banner_cont_amount']).'</td>';

                    $output .= '<td height="30" align="center">'.$status.'</td>';

                    $output .= '<td height="30" align="center">'.$date_value.'</td>';

                    $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($view_item) {

                    $output .= '<a href="index.php?mode=document_items&id='.$row['banner_cont_id'].'" >View</a>';

                    }

                    $output .= '</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($edit) {

                    $output .= '<a href="index.php?mode=edit_document_master&id='.$row['banner_cont_id'].'" ><img src = "images/edit.gif" border="0"></a>';

                    }

                    $output .= '</td>';

                    $output .= '<td align="center" nowrap="nowrap">';

                    if($delete) {

                    $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/deldocumentmaster.php?id='.$row['banner_cont_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

                    }

                    $output .= '</td>';

                    $output .= '</tr>';

                    $i++;

                }

            }

            else

            {

                $output = '<tr class="manage-row" height="20"><td colspan="14" align="center">NO RECORDS FOUND</td></tr>';

            }



            $page->get_page_nav();

            return $output;

	}

        

        public function getEarlierDocumentRefOptions($banner_client_id,$old_document_ref_no)

        {

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
            $option_str = '';



            $sql = "SELECT * FROM `tblbannercontracts` WHERE `banner_client_id` = '".$banner_client_id."' AND `banner_cont_deleted` = '0' ORDER BY banner_contract_no ASC";

            $STH = $DBH->prepare($sql);
            $STH->execute();

            if($STH->rowCount() > 0)

            {

                while($row = $STH->fetch(PDO::FETCH_ASSOC))

                {

                    if($row['banner_contract_no'] == $old_document_ref_no)

                    {

                        $selected = ' selected ';

                    }

                    else

                    {

                        $selected = '';

                    }

                    $option_str .= '<option value="'.$row['banner_contract_no'].'" '.$selected.' >'.stripslashes($row['banner_contract_no']).'</option>';

                }	 

            }



            return $option_str;

        }

        

        public function addBannerContract($banner_client_id,$banner_broker_id,$banner_contract_no,$banner_order_no,$banner_contract_date,$banner_booked_date,$banner_cont_amount,$currency,$prct_cat_id,$ctt_id,$old_document_ref_no,$admin_id)

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
            $return = false;



            $updated_on_date = date('Y-m-d H:i:s');



            $sql = "INSERT INTO `tblbannercontracts` (`banner_client_id`,`banner_broker_id`,`banner_contract_no`,`banner_order_no`,"

                    . "`banner_contract_date`,`banner_booked_date`,`banner_cont_amount`,`banner_cont_status`,`added_by_admin`,`updated_by_admin`"

                    . ",`updated_on_date`,`currency`,`prct_cat_id`,`ctt_id`,`old_document_ref_no`) "

                    . "VALUES ('".addslashes($banner_client_id)."','".addslashes($banner_broker_id)."','".addslashes($banner_contract_no)."',"

                    . "'".addslashes($banner_order_no)."','".addslashes($banner_contract_date)."','".addslashes($banner_booked_date)."',"

                    . "'".addslashes($banner_cont_amount)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."',"

                    . "'".addslashes($currency)."','".addslashes($prct_cat_id)."','".addslashes($ctt_id)."','".  addslashes($old_document_ref_no)."')";

            $STH = $DBH->prepare($sql);
           $STH->execute();
       if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

        }

        public function getClientsOptions($contract_id,$contract_person_type = '')

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
            $option_str = '';	

            

            if($contract_person_type == '')

            {

                $str_sql_type = "";

            }

            else

            {

                $str_sql_type = " AND `contract_person_type` = '".$contract_person_type."' ";

            }



            $sql = "SELECT * FROM `tblcontracts` WHERE `contract_deleted` = '0' ".$str_sql_type." ORDER BY `company_name` ASC";

            //echo $sql;

            $STH2 = $DBH->prepare($sql);
            $STH2->execute();

            if($STH2->rowCount() > 0)

            {

                while($row = $STH2->fetch(PDO::FETCH_ASSOC)) 

                {

                    if($row['contract_id'] == $contract_id)

                    {

                        $sel = ' selected ';

                    }

                    else

                    {

                        $sel = '';

                    }		

                    $option_str .= '<option value="'.$row['contract_id'].'" '.$sel.'>'.$row['company_name'].'</option>';

                }

            }

            return $option_str;

	}

        

        public function deleteBannerContract($banner_cont_id)

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
     $return=false;
            $sql = "UPDATE `tblbannercontracts` SET "

                    . "`banner_cont_deleted` = '1' "

                    . "WHERE `banner_cont_id` = '".$banner_cont_id."'";

	    //echo $sql;

            $STH = $DBH->prepare($sql);
           $STH->execute();
       if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

        }

        public function getBannerContractDetails($banner_cont_id)

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
            $banner_client_id = '';

            $banner_broker_id = '';

            $banner_contract_no = '';

            $banner_order_no = '';

            $banner_contract_date = '';

            $banner_booked_date = '';

            $banner_cont_amount = '';

            $banner_cont_status = '';

            $currency = '';

            $prct_cat_id = '';

            $ctt_id = '';

            $old_document_ref_no = '';



            $sql = "SELECT * FROM `tblbannercontracts` WHERE `banner_cont_id` = '".$banner_cont_id."' AND `banner_cont_deleted` = '0' ";

            //echo $sql;

            $STH = $DBH->prepare($sql);
            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $banner_client_id = stripslashes($row['banner_client_id']);

                $banner_broker_id = stripslashes($row['banner_broker_id']);

                $banner_contract_no = stripslashes($row['banner_contract_no']);

                $banner_order_no = stripslashes($row['banner_order_no']);

                $banner_contract_date = stripslashes($row['banner_contract_date']);

                $banner_booked_date = stripslashes($row['banner_booked_date']);

                $banner_cont_amount = stripslashes($row['banner_cont_amount']);

                $banner_cont_status = stripslashes($row['banner_cont_status']);

                $currency = stripslashes($row['currency']);

                $prct_cat_id = stripslashes($row['prct_cat_id']);

                $ctt_id = stripslashes($row['ctt_id']);

                $old_document_ref_no = stripslashes($row['old_document_ref_no']);

            }

            return array($banner_client_id,$banner_broker_id,$banner_contract_no,$banner_order_no,$banner_contract_date,$banner_booked_date,$banner_cont_amount,$banner_cont_status,$currency,$prct_cat_id,$ctt_id,$old_document_ref_no);

	}

        

        public function updateBannerContract($banner_client_id,$banner_broker_id,$banner_contract_no,$banner_order_no,$banner_contract_date,$banner_booked_date,$banner_cont_amount,$banner_cont_status,$banner_cont_id,$admin_id,$currency,$prct_cat_id,$ctt_id,$old_document_ref_no)

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
     $return=false;
            $updated_on_date = date('Y-m-d H:i:s');

            

            $sql = "UPDATE `tblbannercontracts` SET "

                    . "`banner_client_id` = '".addslashes($banner_client_id)."' ,"

                    . "`banner_broker_id` = '".addslashes($banner_broker_id)."' ,"

                    . "`banner_contract_no` = '".addslashes($banner_contract_no)."' ,"

                    . "`banner_order_no` = '".addslashes($banner_order_no)."' ,"

                    . "`banner_contract_date` = '".addslashes($banner_contract_date)."' ,"

                    . "`banner_booked_date` = '".addslashes($banner_booked_date)."' ,"

                    . "`banner_cont_amount` = '".addslashes($banner_cont_amount)."' ,"

                    . "`banner_cont_status` = '".addslashes($banner_cont_status)."' ,"

                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"

                    . "`updated_on_date` = '".addslashes($updated_on_date)."' ,"

                    . "`currency` = '".addslashes($currency)."' ,"

                    . "`prct_cat_id` = '".addslashes($prct_cat_id)."' ,"

                    . "`ctt_id` = '".addslashes($ctt_id)."' ,"

                    . "`old_document_ref_no` = '".addslashes($old_document_ref_no)."' "

                    . "WHERE `banner_cont_id` = '".$banner_cont_id."'";

	    //echo $sql;

            $STH = $DBH->prepare($sql);
           $STH->execute();
       if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

        

        // Banner Contracts Functions - End

        

        

        public function getAllContracts($contract_person_type,$search,$status,$country_id,$arr_state_id,$arr_city_id,$arr_place_id,$start_date)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '233';

		$delete_action_id = '234';

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

               

		if($contract_person_type == '' )

		{

                    $str_sql_contract_person_type = "";

		}

		else

		{

                    $str_sql_contract_person_type = " AND `contract_person_type` = '".$contract_person_type."' ";

		}

		

		

		

		if($country_id == '' || $country_id == '0')

		{

			$str_sql_country_id = "";

		}

		else

		{

			$str_sql_country_id = " AND `country_id` = '".$country_id."' ";

		}

		

		if(count($arr_state_id) > 0 )

		{

			if($arr_state_id[0] == '')

			{

				$str_sql_state_id = "";

			}

			else

			{

				$str_state_id = implode(',',$arr_state_id);

				$str_sql_state_id = " AND FIND_IN_SET('".$str_state_id."', state_id) ";

			}	

		}

		else

		{

			$str_sql_state_id = "";

		}

		

		if(count($arr_city_id) > 0 )

		{

			if($arr_city_id[0] == '')

			{

				$str_sql_city_id = "";

			}

			else

			{

				$str_city_id = implode(',',$arr_city_id);

				$str_sql_city_id = " AND FIND_IN_SET('".$str_city_id."', city_id) ";

			}	

		}

		else

		{

			$str_sql_city_id = "";

		}

		

		if(count($arr_place_id) > 0 )

		{

			if($arr_place_id[0] == '')

			{

				$str_sql_place_id = "";

			}

			else

			{

				$str_place_id = implode(',',$arr_place_id);

				$str_sql_place_id = " AND FIND_IN_SET('".$str_place_id."', place_id) ";

			}	

		}

		else

		{

			$str_sql_place_id = "";

		}

                 

                

                if($search == '')

		{

			$str_sql_search = "";

		}

		else

		{

			$str_sql_search = " AND (`contract_person` LIKE '%".$search."%' OR `company_name` LIKE '%".$search."%')";

		}

		

		if($status == '')

		{

                    $str_sql_status = "";

		}

		else

		{

                    $str_sql_status = " AND `contract_status` = '".$status."' ";

		}

		

                $sql = "SELECT * FROM `tblcontracts` WHERE `contract_deleted` = '0' ".$str_sql_contract_person_type."  ".$str_sql_search."  ".$str_sql_status."  ".$str_sql_country_id."  ".$str_sql_state_id."  ".$str_sql_city_id."  ".$str_sql_place_id." ORDER BY `contract_person` ASC , `contract_add_date` DESC";		

		//echo '<br>'.$sql;

                $STH = $DBH->prepare($sql);
                $STH->execute();

		$total_records = $STH->rowCount();

		$record_per_page = 50;

		$scroll = 5;

		$page = new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=clients_master");

	 	$STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();

		$output = '';		

		if($STH2->rowCount() > 0)

		{

			if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

			{

				$i = $page->start + 1;

			}

			else

			{

				$i = 1;

			}

			

			while($row = $STH2->fetch(PDO::FETCH_ASSOC))

			{

				if($row['contract_status'] == '1')

				{

					$status = 'Active';

				}

				else

				{

					$status = 'Inactive';

				}

				

				if($row['contract_person_type'] == '1')

				{

					$contract_person_type = 'Broker';

				}

				else

				{

                                    $contract_person_type = 'Client';

				}

                                

                                if($row['added_by_admin'] == '0')

				{

                                    $added_by_admin = '';

				}

				else

				{

                                    $obj2 = new Banner();

                                    $added_by_admin = $obj2->getUsenameOfAdmin($row['added_by_admin']);

				}

                                

                                $date_value = date('d-m-Y',strtotime($row['contract_add_date']));

				

                                $output .= '<tr class="manage-row">';

				$output .= '<td height="30" align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['company_name']).'</td>';

				$output .= '<td height="30" align="center">'.$contract_person_type.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['contract_person']).'</td>';

                                $output .= '<td height="30" align="center">'.stripslashes($row['contract_email']).'</td>';

                                $output .= '<td height="30" align="center">'.stripslashes($row['contract_mobile']).'</td>';

                                $output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center">'.$date_value.'</td>';

                                $output .= '<td height="30" align="center">'.$added_by_admin.'</td>';

				$output .= '<td align="center" nowrap="nowrap">';

					if($edit) {

				$output .= '<a href="index.php?mode=edit_client&id='.$row['contract_id'].'" ><img src = "images/edit.gif" border="0"></a>';

							}

				$output .= '</td>';

				$output .= '<td align="center" nowrap="nowrap">';

					if($delete) {

				$output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/delclient.php?id='.$row['contract_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';

							}

				$output .= '</td>';

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="10" align="center">NO RECORDS FOUND</td></tr>';

		}

		

		$page->get_page_nav();

		return $output;

	}

        

        public function addContractRecord($contract_person,$contract_person_type,$company_name,$contract_email,$contract_mobile,$address,$country_id,$state_id,$city_id,$place_id,$admin_id)

	{

		$my_DBH = new mysqlConnection(); 
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$return = false;

                

                $updated_on_date = date('Y-m-d H:i:s');

				

		$sql = "INSERT INTO `tblcontracts` (`contract_person`,`company_name`,`contract_person_type`,`contract_email`,`address`,"

                        . "`country_id`,`state_id`,`city_id`,`place_id`,`contract_mobile`,`contract_status`,`added_by_admin`,`updated_by_admin`,`updated_on_date`) "

                        . "VALUES ('".addslashes($contract_person)."','".addslashes($company_name)."','".addslashes($contract_person_type)."',"

                        . "'".addslashes($contract_email)."','".addslashes($address)."','".addslashes($country_id)."','".addslashes($state_id)."',"

                        . "'".addslashes($city_id)."','".addslashes($place_id)."','".addslashes($contract_mobile)."','1','".$admin_id."','".$admin_id."','".$updated_on_date."')";

		 $STH = $DBH->prepare($sql);
              $STH->execute();
          if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

        

        public function updateContractRecord($contract_person,$contract_person_type,$company_name,$contract_email,$contract_mobile,$address,$country_id,$state_id,$city_id,$place_id,$contract_status,$contract_id,$admin_id)

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
     $return=false;
            $updated_on_date = date('Y-m-d H:i:s');

            

            $sql = "UPDATE `tblcontracts` SET "

                    . "`contract_person` = '".addslashes($contract_person)."' ,"

                    . "`contract_person_type` = '".addslashes($contract_person_type)."' ,"

                    . "`company_name` = '".addslashes($company_name)."' ,"

                    . "`contract_email` = '".addslashes($contract_email)."' ,"

                    . "`contract_mobile` = '".addslashes($contract_mobile)."' ,"

                    . "`address` = '".addslashes($address)."' ,"

                    . "`country_id` = '".addslashes($country_id)."' ,"

                    . "`state_id` = '".addslashes($state_id)."' ,"

                    . "`city_id` = '".addslashes($city_id)."' ,"

                    . "`place_id` = '".addslashes($place_id)."' ,"

                    . "`contract_status` = '".addslashes($contract_status)."' ,"

                    . "`updated_by_admin` = '".addslashes($admin_id)."' ,"

                    . "`updated_on_date` = '".addslashes($updated_on_date)."' "

                    . "WHERE `contract_id` = '".$contract_id."'";

	    //echo $sql;

            $STH = $DBH->prepare($sql);
           $STH->execute();
          if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

        

        public function getContractDetails($contract_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$contract_person = '';

                $contract_person_type = '';

                $company_name = '';

                $contract_email = '';

                $contract_mobile = '';

                $address = '';

                $country_id = '';

                $state_id = '';

                $city_id = '';

                $place_id = '';

                $contract_status = '';

		

		$sql = "SELECT * FROM `tblcontracts` WHERE `contract_id` = '".$contract_id."' AND `contract_deleted` = '0' ";

		//echo $sql;

                $STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

                   $row = $STH->fetch(PDO::FETCH_ASSOC);

                    $contract_person = stripslashes($row['contract_person']);

                    $contract_person_type = stripslashes($row['contract_person_type']);

                    $company_name = stripslashes($row['company_name']);

                    $contract_email = stripslashes($row['contract_email']);

                    $contract_mobile = stripslashes($row['contract_mobile']);

                    $address = stripslashes($row['address']);

                    $country_id = stripslashes($row['country_id']);

                    $state_id = stripslashes($row['state_id']);

                    $city_id = stripslashes($row['city_id']);

                    $place_id = stripslashes($row['place_id']);

                    $contract_status = $row['contract_status'];

		}

		return array($contract_person,$contract_person_type,$company_name,$contract_email,$contract_mobile,$address,$country_id,$state_id,$city_id,$place_id,$contract_status);

	}

        

        public function getClientName($contract_id)

	{

    $my_DBH = new mysqlConnection();
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
            $company_name = '';



            $sql = "SELECT * FROM `tblcontracts` WHERE `contract_id` = '".$contract_id."' AND `contract_deleted` = '0' ";

            //echo $sql;

            $STH = $DBH->prepare($sql);
            $STH->execute();

            if($STH->rowCount() > 0)

            {

                $row = $STH->fetch(PDO::FETCH_ASSOC);

                $company_name = stripslashes($row['company_name']);

            }

            return $company_name;

	}

        

       

        

        public function deleteContractRecord($contract_id)

	{

    $my_DBH = new mysqlConnection(); 
    $DBH = $my_DBH->raw_handle();
    $DBH->beginTransaction();
    $return=false;
            $sql = "UPDATE `tblcontracts` SET "

                    . "`contract_deleted` = '1' "

                    . "WHERE `contract_id` = '".$contract_id."'";

	    //echo $sql;

            $STH = $DBH->prepare($sql);
           $STH->execute();
       if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;


	}

	

        

	public function GetAllPositions()

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$arr_position_id  = array();

		$arr_position  = array();

		$arr_side  = array(); 

		$arr_height  = array();

		$arr_width  = array();

		$arr_google_ads  = array();

		

		$sql = "SELECT * FROM `tblposition`";

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC))

			{

				array_push($arr_position_id , $row['position_id']);

				array_push($arr_position , stripslashes($row['position']));

				array_push($arr_side , stripslashes($row['side']));

				array_push($arr_height , stripslashes($row['height']));

				array_push($arr_width , stripslashes($row['width']));

				array_push($arr_google_ads , stripslashes($row['google_ads']));

			}

		}

		return array($arr_position_id,$arr_position,$arr_side,$arr_height,$arr_width,$arr_google_ads);

	}


    //commented by rahul
	// public function GetAllPages($search)

	// {

    //         $obj = new Banner();
	// 	$my_DBH = new mysqlConnection();
    //             $DBH = $my_DBH->raw_handle();
    //             $DBH->beginTransaction();

		

	// 	$admin_id = $_SESSION['admin_id'];

	// 	$edit_action_id = '80';

	// 	$delete_action_id = '82';

		

	// 	$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

	// 	$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

	// 	if($search == '')

	// 	{

	// 		$sql = "SELECT * FROM `tblbanners` AS TB

	// 				LEFT JOIN `tblposition` AS TP ON TB.position_id = TP.position_id

	// 				WHERE TB.page_id IN (SELECT page_id FROM tblpages WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_list` = '1')

	// 				ORDER BY TB.banner_add_date DESC, TB.page ASC, TP.position ASC , TB.status DESC  ";

	// 	}

	// 	else

	// 	{

	// 		$sql = "SELECT * FROM `tblbanners` AS TB

	// 				LEFT JOIN `tblposition` AS TP ON TB.position_id = TP.position_id

	// 				WHERE  TB.page_id IN (SELECT page_id FROM tblpages WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_list` = '1') AND TB.page like '%".$search."%' 

	// 				ORDER BY TB.banner_add_date DESC, TB.page ASC, TP.position ASC , TB.status DESC  ";

	// 	}		

	// 	$STH = $DBH->prepare($sql);
    //             $STH->execute();

	// 	$total_records=$STH->rowCount();

	// 	$record_per_page=100;

	// 	$scroll=5;

	// 	$page=new Page(); 

    //             $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

	// 	$page->set_link_parameter("Class = paging");

	// 	$page->set_qry_string($str="mode=banner");

	//  	$STH2 = $DBH->prepare($page->get_limit_query($sql));
    //             $STH2->execute();

	// 	$output = '';		

	// 	if($STH2->rowCount() > 0)

	// 	{

	// 		if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

	// 		{

	// 			$i = $page->start + 1;

	// 		}

	// 		else

	// 		{

	// 			$i = 1;

	// 		}

	// 		while($row = $STH2->fetch(PDO::FETCH_ASSOC))

	// 		{

	// 			if($row['status'] == 1)

	// 			{

	// 				 $status = 'Active'; 

	// 			}

	// 			else

	// 			{ 

	// 				$status = 'Inactive';

	// 			}

				

	// 			$output .= '<tr class="manage-row">';

	// 			$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

	// 			$output .= '<td height="30" align="center">'.stripslashes($row['page']).'</td>';

	// 			$output .= '<td height="30" align="center">'.stripslashes($row['position']).'</td>';

	// 			$output .= '<td height="30" align="center">'.stripslashes($row['width']).'</td>';

	// 			$output .= '<td height="30" align="center">'.stripslashes($row['height']).'</td>';

	// 			if($row['banner_type'] == 'Google Ads')

	// 			{

	// 				$output .= '<td height="30" align="center">Google Ads</td>';

	// 			}
    //                             elseif($row['banner_type'] == 'Affilite Ads' || $row['banner_type'] == 'Other Ads')

	// 			{

	// 				$output .= '<td height="30" align="center">'.$row['banner_type'].'</td>';

	// 			}

	// 			else

	// 			{

	// 				$output .= '<td height="30" align="center">'.stripslashes($row['banner']).'</td>';

	// 			}

    //                             $output .= '<td height="30" align="center">'.stripslashes($row['url']).'</td>';
    //                             $output .= '<td height="30" align="center">'.stripslashes($row['client_name']).'</td>';
	// 			$output .= '<td height="30" align="center">'.stripslashes($row['banner_add_date']).'</td>';
    //                             $output .= '<td height="30" align="center">'.$obj->getAdminNameRam($row['posted_by_admin']).'</td>';
    //                             $output .= '<td height="30" align="center">'.$status.'</td>';

	// 			$output .= '<td height="30" align="center" nowrap="nowrap">';

	// 			if($edit) 

	// 			{

	// 				$output .= '<a href="index.php?mode=edit_banner&banner_id='.$row['banner_id'].'" ><img src = "images/edit.gif" border="0"></a>';

	// 			}

	// 			$output .= '</td>';

	// 			$output .= '<td height="30" align="center" nowrap="nowrap">';

	// 			if($delete) 

	// 			{

	// 				$output .= '<a href=\'javascript:fn_confirmdelete("Banner","sql/delbanner.php?banner_id='.$row['banner_id'].'&ad=0")\' ><img src = "images/del.gif" border="0" ></a>';

	// 			}

	// 			$output .= '</td>';

	// 			$output .= '</tr>';

	// 			$i++;

	// 		}

	// 	}

	// 	else

	// 	{

	// 		$output = '<tr class="manage-row" height="20"><td colspan="9" align="center">NO PAGES FOUND</td></tr>';

	// 	}

	// 	$page->get_page_nav();

	// 	return $output;

	// }


    public function GetAllPages($search)
    {
        $obj = new Banner();
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $admin_id = $_SESSION['admin_id'];
        $edit_action_id = '80';
        $delete_action_id = '82';

        $edit = $this->chkValidActionPermission($admin_id, $edit_action_id);
        $delete = $this->chkValidActionPermission($admin_id, $delete_action_id);

        $search_for_page = strip_tags(trim($search['search_for_page']));
        $search_for_client = strip_tags(trim($search['search_for_client']));
        $posted_by = strip_tags(trim($search['posted_by']));
        $search_condition = [];

        if (!empty($search_for_page)) {
            $search_condition[] = "TB.page LIKE '%" . addslashes($search_for_page) . "%'";
        }

        if (!empty($search_for_client)) {
            $search_condition[] = "TB.client_name LIKE '%" . addslashes($search_for_client) . "%'";
        }

        // Base query
        $sql = "
            SELECT * FROM `tblbanners` AS TB
            LEFT JOIN `tblposition` AS TP ON TB.position_id = TP.position_id
            WHERE TB.page_id IN (
                SELECT page_id FROM tblpages 
                WHERE adviser_panel = '0' 
                AND vender_panel = '0' 
                AND show_in_list = '1'
            )
        ";

        // Append search conditions if any
        if (!empty($search_condition)) {
            $sql .= " AND (" . implode(" AND ", $search_condition) . ")";
        }

        // Add ordering
        $sql .= " ORDER BY TB.banner_add_date DESC, TB.page ASC, TP.position ASC, TB.status DESC";


        $STH = $DBH->prepare($sql);
        $STH->execute();

        $total_records = $STH->rowCount();
        $record_per_page = 100;
        $scroll = 5;

        $page = new Page();
        $page->set_page_data($_SERVER['PHP_SELF'], $total_records, $record_per_page, $scroll, true, true, true);
        $page->set_link_parameter("Class = paging");
        $page->set_qry_string($str = "mode=banner");

        $STH2 = $DBH->prepare($page->get_limit_query($sql));
        $STH2->execute();

        $output = '';

        if ($STH2->rowCount() > 0) {
            if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) {
                $i = $page->start + 1;
            } else {
                $i = 1;
            }

            while ($row = $STH2->fetch(PDO::FETCH_ASSOC)) {
                $status = ($row['status'] == 1) ? 'Active' : 'Inactive';

                $output .= '<tr class="manage-row">';
                $output .= '<td height="30" align="center" nowrap="nowrap">' . $i . '</td>';
                $output .= '<td height="30" align="center">' . stripslashes($row['page']) . '</td>';
                $output .= '<td height="30" align="center">' . stripslashes($row['position']) . '</td>';
                $output .= '<td height="30" align="center">' . stripslashes($row['width']) . '</td>';
                $output .= '<td height="30" align="center">' . stripslashes($row['height']) . '</td>';

                if ($row['banner_type'] == 'Google Ads') {
                    $output .= '<td height="30" align="center">Google Ads</td>';
                } elseif ($row['banner_type'] == 'Affilite Ads' || $row['banner_type'] == 'Other Ads') {
                    $output .= '<td height="30" align="center">' . $row['banner_type'] . '</td>';
                } else {
                    $output .= '<td height="30" align="center">' . stripslashes($row['banner']) . '</td>';
                }

                $output .= '<td height="30" align="center">' . stripslashes($row['url']) . '</td>';
                $output .= '<td height="30" align="center">' . stripslashes($row['client_name']) . '</td>';
                $output .= '<td height="30" align="center">' . stripslashes($row['banner_add_date']) . '</td>';
                $output .= '<td height="30" align="center">' . $obj->getAdminNameRam($row['posted_by_admin']) . '</td>';
                $output .= '<td height="30" align="center">' . $status . '</td>';

                $output .= '<td height="30" align="center" nowrap="nowrap">';
                if ($edit) {
                    $output .= '<a href="index.php?mode=edit_banner&banner_id=' . $row['banner_id'] . '"><img src="images/edit.gif" border="0"></a>';
                }
                $output .= '</td>';

                $output .= '<td height="30" align="center" nowrap="nowrap">';
                if ($delete) {
                    $output .= '<a href=\'javascript:fn_confirmdelete("Banner","sql/delbanner.php?banner_id=' . $row['banner_id'] . '&ad=0")\'><img src="images/del.gif" border="0"></a>';
                }
                $output .= '</td>';
                $output .= '</tr>';

                $i++;
            }
        } else {
            $output = '<tr class="manage-row" height="20"><td colspan="9" align="center">NO PAGES FOUND</td></tr>';
        }

        $page->get_page_nav();
        return $output;
    }


	public function getAllAdviserBanners($search)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '188';

		$delete_action_id = '189';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		if($search == '')

		{

			$sql = "SELECT * FROM `tblbanners` AS TB

					LEFT JOIN `tblposition` AS TP ON TB.position_id = TP.position_id

					WHERE TB.page_id IN (SELECT page_id FROM tblpages WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_list` = '1')

					ORDER BY TB.page ASC, TP.position ASC , TB.banner_add_date DESC, TB.status DESC  ";

		}

		else

		{

			$sql = "SELECT * FROM `tblbanners` AS TB

					LEFT JOIN `tblposition` AS TP ON TB.position_id = TP.position_id

					WHERE TB.page_id IN (SELECT page_id FROM tblpages WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_list` = '1') AND TB.page like '%".$search."%' 

					ORDER BY TB.page ASC, TP.position ASC , TB.banner_add_date DESC, TB.status DESC  ";

		}		

		$STH = $DBH->prepare($sql);
                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=adviser_banners");

	 	$STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();

		$output = '';		

		if($STH2->rowCount() > 0)

		{

			if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

			{

				$i = $page->start + 1;

			}

			else

			{

				$i = 1;

			}

			while($row = $STH2->fetch(PDO::FETCH_ASSOC))

			{

				if($row['status'] == 1)

				{

					 $status = 'Active'; 

				}

				else

				{ 

					$status = 'Inactive';

				}

				

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['page']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['position']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['width']).'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['height']).'</td>';

				if($row['banner_type'] == 'Google Ads')

				{

					$output .= '<td height="30" align="center">Google Ads</td>';

				}

				else

				{

					$output .= '<td height="30" align="center">'.stripslashes($row['banner']).'</td>';

				}

				$output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($edit) 

				{

					$output .= '<a href="index.php?mode=edit_adviser_banner&banner_id='.$row['banner_id'].'" ><img src = "images/edit.gif" border="0"></a>';

				}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($delete) 

				{

					$output .= '<a href=\'javascript:fn_confirmdelete("Banner","sql/delbanner.php?banner_id='.$row['banner_id'].'&ad=1")\' ><img src = "images/del.gif" border="0" ></a>';

				}

				$output .= '</td>';

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="9" align="center">NO PAGES FOUND</td></tr>';

		}

		$page->get_page_nav();

		return $output;

	}

	

	public function getAllAdviserBannerSettings($pro_user_id,$ab_status)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$admin_id = $_SESSION['admin_id'];

		$edit_action_id = '210';

		$delete_action_id = '211';

		

		$edit = $this->chkValidActionPermission($admin_id,$edit_action_id);

		$delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

		

		if($pro_user_id == '' || $pro_user_id == '0')

		{

			$str_sql_pro_user_id = "";

		}

		else

		{

			$str_sql_pro_user_id = " AND TAB.pro_user_id = '".$pro_user_id."' ";

		}

		

		if($ab_status == '')

		{

			$str_sql_ab_status = "";

		}

		else

		{

			$str_sql_ab_status = " AND TAB.ab_status = '".$ab_status."' ";

		}

		

		

	

		$sql = "SELECT TAB.*,TPU.name FROM `tbladviserbanners` AS TAB

				LEFT JOIN `tblprofusers` AS TPU ON TAB.pro_user_id = TPU.pro_user_id

				WHERE TAB.ab_deleted = '0' ".$str_sql_pro_user_id." ".$str_sql_ab_status."

				ORDER BY TAB.ab_add_date DESC";

		$STH = $DBH->prepare($sql);
                $STH->execute();

		$total_records=$STH->rowCount();

		$record_per_page=100;

		$scroll=5;

		$page=new Page(); 

                $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

		$page->set_link_parameter("Class = paging");

		$page->set_qry_string($str="mode=adviser_banner_settings");

	 	$STH2 = $DBH->prepare($page->get_limit_query($sql));
                $STH2->execute();

		$output = '';		

		if($STH2->rowCount() > 0)

		{

			if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 )

			{

				$i = $page->start + 1;

			}

			else

			{

				$i = 1;

			}

			while($row = $STH2->fetch(PDO::FETCH_ASSOC))

			{

				if($row['ab_status'] == '1')

				{

					$status = 'Active';

				}

				else

				{

					$status = 'Inactive';

				}

				

				$banner = '<img border="0" src="'.SITE_URL.'/uploads/'.stripslashes($row['banner']).'" width="200">';

				$banner_add_date = date('m/d/Y',strtotime($row['ab_add_date']));

				

				$output .= '<tr class="manage-row">';

				$output .= '<td height="30"  align="center" nowrap="nowrap" >'.$i.'</td>';

				$output .= '<td height="30" align="center">'.stripslashes($row['name']).'</td>';

				$output .= '<td height="30" align="center">'.$banner.'</td>';

				$output .= '<td height="30" align="center">'.$status.'</td>';

				$output .= '<td height="30" align="center">'.$banner_add_date.'</td>';

				

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($edit) 

				{

					$output .= '<a href="index.php?mode=edit_adviser_banner_setting&ab_id='.$row['ab_id'].'" ><img src = "images/edit.gif" border="0"></a>';

				}

				$output .= '</td>';

				$output .= '<td height="30" align="center" nowrap="nowrap">';

				if($delete) 

				{

					$output .= '<a href=\'javascript:fn_confirmdelete("Banner","sql/deladviser_banner_setting.php?ab_id='.$row['ab_id'].'&ad=1")\' ><img src = "images/del.gif" border="0" ></a>';

				}

				$output .= '</td>';

				$output .= '</tr>';

				$i++;

			}

		}

		else

		{

			$output = '<tr class="manage-row" height="20"><td colspan="7" align="center">NO RECORDS FOUND</td></tr>';

		}

		$page->get_page_nav();

		return $output;

	}



	public function Add_banner($admin_id,$page_id,$page_name,$position_id,$arr_banner,$arr_url,$arr_banner_type,$arr_client_name,$valid_from,$valid_till){
        
		$my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;
		for($i=0;$i<count($arr_banner);$i++){
            if(empty($valid_till[$i])){
                $valid_till[$i] = '0000-00-00';
            }
            $page_name = $this->getPageName($page_id[$i]);
			$sql = "INSERT INTO `tblbanners`(`posted_by_admin`,`page_id`,`page`,`position_id`,`banner`,`url`,`banner_type`,`client_name`,`status`,`valid_from`,`valid_till`) VALUES ('".addslashes($admin_id)."','".addslashes($page_id[$i])."','".addslashes($page_name)."','".addslashes($position_id[$i])."','".addslashes($arr_banner[$i])."','".addslashes($arr_url[$i])."','".addslashes($arr_banner_type[$i])."','".addslashes($arr_client_name[$i])."','1','".addslashes($valid_from[$i])."','".addslashes($valid_till[$i])."')";
            $STH = $DBH->prepare($sql);
            $STH->execute();
        }
        if($STH->rowCount() > 0){
            $return = true;
        }
        return $return;
    }
	

	public function addAdviserBannerSetting($pro_user_id,$banner)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                    $return=false;
		$sql = "INSERT INTO `tbladviserbanners`(`pro_user_id`,`banner`,`ab_status`) VALUES ('".addslashes($pro_user_id)."','".addslashes($banner)."','1')";

		//echo $sql;

		 $STH = $DBH->prepare($sql);
                 $STH->execute();
                 if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

	

	public function getBannerDetails($banner_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$page_id = '';

		$pisition_id = '';

		$width = '';

		$height = '';

		$banner = '';

		$url = '';

		$client_name = '';

		$status = '';

		

		$sql = "SELECT * FROM `tblbanners` AS TA

				LEFT JOIN `tblposition` AS TS ON TA.position_id = TS.position_id	

				 WHERE TA.banner_id = '".$banner_id."'";

		

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

		$row = $STH->fetch(PDO::FETCH_ASSOC);

			$page_id = stripslashes($row['page_id']);

			$position_id = stripslashes($row['position_id']);

			$width = stripslashes($row['width']);

			$height = stripslashes($row['height']);

			$banner_type = stripslashes($row['banner_type']);

			if($banner_type == 'Google Ads')

			{

				$banner = 'Google Ads';

			}

			else

			{

				$banner = stripslashes($row['banner']);

			}	

			$url = stripslashes($row['url']);

			

			$client_name = stripslashes($row['client_name']);

			$status = stripslashes($row['status']);

            $valid_from = stripslashes($row['valid_from']);
            $valid_till = stripslashes($row['valid_till']);
			

		}

		return array($page_id,$position_id,$width,$height,$banner,$url,$banner_type,$client_name,$status,$valid_from,$valid_till);

	

	}

	

	public function getAdviserBannerSettingDetails($ab_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$pro_user_id = '';

		$banner = '';

		$ab_status = '';

		

		$sql = "SELECT * FROM `tbladviserbanners` WHERE `ab_id` = '".$ab_id."'";

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$pro_user_id = stripslashes($row['pro_user_id']);

			$banner = stripslashes($row['banner']);

			$ab_status = stripslashes($row['ab_status']);

		}

		return array($banner,$ab_status,$pro_user_id);

	

	}

	

	public function getGoogleAds_Details($position_id,$banner_type)

	{

		$my_DBH = new mysqlConnection(); 
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$position = '';

		$side = '';

		$width = '';

		$height = '';

		$google_ads = '';

		

		$sql ="SELECT * FROM `tblposition` WHERE  `position_id` = '".$position_id."' ";	

		

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$position = stripslashes($row['position']);

			$side = stripslashes($row['side']);

			$width = stripslashes($row['width']);

			$height = stripslashes($row['height']);

			$google_ads = stripslashes($row['google_ads']);

		}	

		return array($position,$side,$width,$height,$google_ads);

	}	

	

	public function getPageName($page_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		

		$page_name = '';

		

		$sql = "SELECT * FROM `tblpages` WHERE `page_id` = '".$page_id."'";

		//echo $sql;

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			$row = $STH->fetch(PDO::FETCH_ASSOC);

			$page_name = stripslashes($row['page_name']);

			

		}

		return  $page_name;

	

	}

	

	public function Update_Banner($admin_id,$page_id,$page,$position_id,$banner,$url,$banner_type,$client_name,$status,$banner_id,$valid_from,$valid_till)

	{
        if(empty($valid_till)){
            $valid_till = '0000-00-00';
        }
		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                    $return=false;
		$sql = "UPDATE `tblbanners` SET `posted_by_admin` = '".addslashes($admin_id)."' ,`page_id` = '".addslashes($page_id)."' ,`page` = '".addslashes($page)."' , `position_id` = '".addslashes($position_id)."' , `banner` = '".addslashes($banner)."', `banner_type` = '".addslashes($banner_type)."', `url` = '".addslashes($url)."' ,`status` = '".addslashes($status)."' ,`client_name` = '".addslashes($client_name)."', `valid_from` = '".addslashes($valid_from)."', `valid_till` = '".addslashes($valid_till)."' WHERE `banner_id` = '".$banner_id."'";

	    //echo $sql;

		 $STH = $DBH->prepare($sql);
               $STH->execute();
            if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;


	}

	

	public function updateAdviserBannerSetting($ab_id,$banner,$ab_status,$pro_user_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		$sql = "UPDATE `tbladviserbanners` SET `banner` = '".addslashes($banner)."' ,`ab_status` = '".addslashes($ab_status)."' WHERE `ab_id` = '".$ab_id."'";

	    //echo $sql;

		 $STH = $DBH->prepare($sql);
                 $STH->execute();
               if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;


	}

	

	public function Update_google_ads($arr_position_id,$arr_position,$arr_google_ads)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		for($i=0;$i<count($arr_position_id);$i++)

		{

			$sql = "UPDATE `tblposition` SET `google_ads` = '".addslashes($arr_google_ads[$i])."'  WHERE `position` = '".$arr_position[$i]."'";

	   		 $STH = $DBH->prepare($sql);
                   $STH->execute();
              if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;

	}

        }

	public function DeleteBanner($banner_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $return=false;
		

		$sql = "DELETE from `tblbanners` WHERE `banner_id` = '".$banner_id."'";

		 $STH = $DBH->prepare($sql);
           $STH->execute();
       if($STH->rowCount() > 0)
		{
			$return = true;
		}
		return $return;


	}

	

	public function DeleteAdviserBannerSetting($ab_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                   $return=false;
		

		$sql = "DELETE from `tbladviserbanners` WHERE `ab_id` = '".$ab_id."'";

		 $STH = $DBH->prepare($sql);
                $STH->execute();
              if($STH->rowCount() > 0)
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

	

	public function getPositionsHTML($position)

	{

		$output .='<select name="position" id ="position">

						<option value = "">Select Position</option>

						<option value="Top"';

						if($position == 'Top') { 

		$output .=	'selected';  

						} 

		$output .='>Top</option>';

		$output .='<option value="Left"';

					if($position == 'Left') { 

		$output .=	'selected';  

						}

		$output .='>Left</option>';

		$output .='<option value="Left Middle"';

                     if($position == 'Left Middle') { 

		$output .=	'selected';  

						}

		$output .='>Left Middle</option>';

		$output .='<option value="Right Top"';

		              if($position == 'Right Top') { 

        $output .=	'selected';  

						}

		$output .='>Right Top</option>';

		$output .='<option value="Right Middle"';

					if($position == 'Right Middle') { 

		$output .=	'selected';  

						}

		$output .='>Right Middle</option>';

		$output .='<option value="Right Bottom"';

		            if($position == 'Right Bottom') { 

		$output .=	'selected';  

						}

		$output .='>Right Bottom</option>';

		return $output; 

	}

	

	public function getPageOptions($page_id)
	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
		$option_str = '';		
		$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '0' AND `vender_panel` = '0' AND `show_in_list` = '1' ORDER BY `page_name` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['page_id'] == $page_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['page_id'].'" '.$sel.'>'.$row['page_name'].'</option>';

			}

		}

		return $option_str;

	}

	

	public function getPageOptionsAdviser($page_id)

	{

		$my_DBH = new mysqlConnection(); 
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tblpages` WHERE `adviser_panel` = '1' AND `vender_panel` = '0' AND `show_in_list` = '1' ORDER BY `page_name` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['page_id'] == $page_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['page_id'].'" '.$sel.'>'.$row['page_name'].'</option>';

			}

		}

		return $option_str;

	}

	

	public function getPositions($position_id)

	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();

		$option_str = '';		

		

		$sql = "SELECT * FROM `tblposition`  ORDER BY `position` ASC";

		//echo $sql;

		$STH = $DBH->prepare($sql);
                $STH->execute();

		if($STH->rowCount() > 0)

		{

			while($row = $STH->fetch(PDO::FETCH_ASSOC)) 

			{

				if($row['position_id'] == $position_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$row['position_id'].'" '.$sel.'>'.$row['position'].'</option>';

			}

		}

		return $option_str;

	}

	
         public function getAdminNameRam($id)
	{
        $my_DBH = new mysqlConnection(); 
	$DBH = $my_DBH->raw_handle();
	$DBH->beginTransaction();         
	$return = '';
            
            $sql = "SELECT * FROM `tbladmin` WHERE `admin_id` = '".$id."' ";
            $STH = $DBH->prepare($sql);
            $STH->execute();
            if($STH->rowCount() > 0)
            {
                    $row = $STH->fetch(PDO::FETCH_ASSOC);
                    $return = $row['fname'].' '.$row['lname'];
            }
            return $return;
	}

    //09/03/2019 page option from data_drop_down
        
        public function getPageOptionsFromDatadrop($pdm_id,$page_id='')
	{

		$my_DBH = new mysqlConnection();
                $DBH = $my_DBH->raw_handle();
                $DBH->beginTransaction();
                $obj2 = new Banner();
		$option_str = '';		
		$sql = "SELECT * FROM `tblpagedropdowns` WHERE `pdm_id` = '".$pdm_id."' AND `pd_status` = '1'";

		//echo $sql;
		$STH = $DBH->prepare($sql);
                $STH->execute();
		if($STH->rowCount() > 0)
		{
                        $row = $STH->fetch(PDO::FETCH_ASSOC);
			
                        $page_arr = explode(',', $row['page_id_str']);
                        
                        for($i=0;$i<count($page_arr);$i++)
                        {
			if($page_arr[$i] == $page_id)

				{

					$sel = ' selected ';

				}

				else

				{

					$sel = '';

				}		

				$option_str .= '<option value="'.$page_arr[$i].'" '.$sel.'>'.$obj2->getPageName($page_arr[$i]).'</option>';

			}

		}

		return $option_str;

	}

    //add by ample 12-10-20
    public function getBannerSliderData($search,$status,$post_by,$post_date) { 
        $my_DBH = new mysqlConnection(); 
        $DBH = $my_DBH->raw_handle(); 
        $DBH->beginTransaction(); 
        $admin_id = $_SESSION['admin_id']; 
        $edit_action_id = '385'; 
        $delete_action_id = '387'; 
        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id); 
        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);  
        $sql_str_search=$sql_str_status=$str_posted_by=$str_posted_date="";
        if($search != '') 
        { 
            $sql_str_search = " AND (banner_title like '%".$search."%' OR banner_text_line1 like '%".$search."%' OR banner_text_line2 like '%".$search."%')"; 
        } 
        if($status != '') 
        { 
            $sql_str_status = " AND banner_status = '".$status."' "; 
        } 
        if($post_by) 
        { 
            $str_posted_by = " AND created_by = '".$post_by."' "; 
        }
        if(!empty($post_date)) 
        { 
            $str_posted_date = " AND DATE(created_at) = '".date("Y-m-d", strtotime($post_date))."' "; 
        }
        $sql = "SELECT * FROM `tblbannerslider` WHERE is_deleted = '0' ".$sql_str_search." ".$sql_str_status." ".$str_posted_by." ".$str_posted_date." ORDER BY banner_id DESC"; 
        $STH = $DBH->prepare($sql); 
        $STH->execute(); 
        $total_records = $STH->rowCount(); 
        $record_per_page = 50; 
        $scroll = 5; 
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true); 
        $page->set_link_parameter("Class = paging"); 
        $page->set_qry_string($str="mode=manage-page-decor"); 
        $STH2 = $DBH->prepare($page->get_limit_query($sql)); 
        $STH2->execute(); 
        $output = ''; 
        if($STH2->rowCount() > 0) 
            { 
                if( isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ) 
                    { 
                        $i = $page->start + 1; 
                    } 
                    else 
                    { 
                        $i = 1; 
                    } 
                while($row = $STH2->fetch(PDO::FETCH_ASSOC)) 
                    { 

                        $status=($row['banner_status'] == '1')? "Active" :"Inactive";

                        $data=$this->getRedirectSchedule($row['banner_id'],'bannerSlider');

                       $output .= '<tr class="manage-row">'; 
                       $output .= '<td height="30" align="center">'.$i.'</td>'; 
                       $output .= '<td height="30" align="center">'.$status.'</td>'; 
                       $output .= '<td height="30" align="center">'.$this->getUsenameOfAdmin($row['created_by']).'</td>'; 
                       $output .= '<td height="30" align="center">'.date("d-m-Y H:i:s",strtotime($row['created_at'])).'</td>'; 
                       $output .= '<td align="center" nowrap="nowrap">'; 
                       if($edit) 
                        { 
                            $output .= '<a href="index.php?mode=edit_banner_slider&id='.$row['banner_id'].'"><img src="images/edit.gif" border="0"></a>'; 
                        } 
                        $output .= '</td>'; 
                        $output .= '<td align="center" nowrap="nowrap">'; 
                        if($delete) 
                            { 
                                $output .= '<a href=\'javascript:fn_confirmdelete("Record","sql/deleteBannerSlider.php?id='.$row['banner_id'].'")\'><img src="images/del.gif" border="0"></a>'; 
                            } 
                        $output .= '<td height="30" align="center"><img src="'.SITE_URL.'/uploads/'.$row['banner_image'].'" height="125px" width="125px" /></td>'; 
                        $output .= '<td height="30" align="center">'.stripslashes($row['banner_title']).'</td>'; 
                        $output .= '<td height="30" align="center">'.stripslashes($row['banner_text_line1']).'</td>';  
                        $output .= '<td height="30" align="center">'.stripslashes($row['banner_text_line2']).'</td>'; 
                        $output .= '<td height="30" align="center">'.stripslashes($row['admin_notes']).'</td>';
                        $output .= '<td height="30" align="center">';

                            if(!empty($data))
                            {
                                $output .='<table class="table table-condensed"><thead><tr><th>Schedule</th><th>Location</th></tr></thead><tbody>';
                                foreach ($data as $key => $value) {
                                    
                                    $output .='<tr>';
                                    $output .='<td>';
                                                if($value['publish_date_type']=='single_date')
                                                {
                                                   $output .=date('d-m-Y', strtotime($value['publish_single_date'])); 
                                                }
                                                elseif ($value['publish_date_type']=='date_range') {
                                                   $output .='Start:'.date('d-m-Y', strtotime($value['publish_start_date'])); 
                                                   $output .='<br>End:'.date('d-m-Y', strtotime($value['publish_end_date'])); 
                                                }
                                                elseif ($value['publish_date_type']=='month_wise') {
                                                    $month_wise=explode(',', $value['publish_month_wise']);
                                                    $publish_month_wise=array();
                                                    if(!empty($month_wise))
                                                    {
                                                        foreach ($month_wise as  $mw) {
                                                            $publish_month_wise[]=$this->getMonthName($mw);
                                                        }
                                                    }
                                                    $output .=implode(',', $publish_month_wise); 
                                                }
                                                elseif ($value['publish_date_type']=='days_of_week') {
                                                    $week_wise=explode(',', $value['publish_days_of_week']);
                                                    $publish_week_wise=array();
                                                    if(!empty($week_wise))
                                                    {
                                                        foreach ($week_wise as  $ww) {
                                                            $publish_week_wise[]=$this->getWeekName($ww);
                                                        }
                                                    }
                                                    $output .=implode(',', $publish_week_wise);
                                                }
                                                elseif ($value['publish_date_type']=='days_of_month') {
                                                    $output .=$value['publish_days_of_month']; 
                                                }
                                    $output .='</td>';
                                    $output .='<td>';
                                                 if(!empty($value['state_id']))   
                                                 {
                                                     $output .='State:' .$this->GetStateName($value['state_id']);
                                                 }
                                                 if(!empty($value['city_id']))   
                                                 {
                                                     $output .='<br>City:' .$this->GetCityName($value['city_id']);
                                                 }
                                                 if(!empty($value['area_id']))   
                                                 {
                                                     $output .='<br>Area:' .$this->GetAreaName($value['area_id']);
                                                 }
                                    $output .='</td>';
                                    $output .='</tr>';
                                }
                                $output .='</tbody></thead></table>';
                            }

                        $output .= '</td>';
                        $output .= '<td height="30" align="center">'.$row['banner_order'].'</td>';
                        $output .= '</td>'; 
                        $output .= '</tr>'; 
                    $i++; 
                } 
            } 
            else 
            { 
                $output = '<tr class="manage-row" height="30">
                <td colspan="11" align="center">NO RECORDS FOUND</td>
                </tr>'; 
            } 
        $page->get_page_nav(); 
        return $output; 
    }
    //added by ample 17-06-20
    public function getBannerSlider($id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tblbannerslider` WHERE banner_id ='".$id."' ";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
        }
        return $data;     
    } 
    //added by ample 12-10-20 & update 28-10-20
    public function updateBannerSliderData($admin_id,$data,$id)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql="UPDATE `tblbannerslider` SET 
            `updated_by`='".$admin_id."',`updated_at`='".date('Y-m-d H:i:s')."',`banner_title`='".addslashes($data['banner_title'])."',`banner_text_line1`='".addslashes($data['banner_text_line1'])."',`banner_text_line2`='".addslashes($data['banner_text_line2'])."',`banner_image`='".$data['banner_image']."',`button1`='".$data['button1']."',`button1_url`='".$data['button1_url']."',`button1_font_family`='".$data['button1_font_family']."',`button1_font_size`='".$data['button1_font_size']."',`button1_font_color`='".$data['button1_font_color']."',`button1_bg_color`='".$data['button1_bg_color']."',`button1_icon_code`='".$data['button1_icon_code']."',`button1_show`='".$data['button1_show']."',`button2`='".$data['button2']."',`button2_url`='".$data['button2_url']."',`button2_font_family`='".$data['button2_font_family']."',`button2_font_size`='".$data['button2_font_size']."',`button2_font_color`='".$data['button2_font_color']."',`button2_bg_color`='".$data['button2_bg_color']."',`button2_icon_code`='".$data['button2_icon_code']."',`button2_show`='".$data['button2_show']."',`banner_order`='".$data['banner_order']."',`banner_status`='".$data['banner_status']."',`admin_notes`='".addslashes($data['admin_notes'])."' WHERE `banner_id`='".$id."'";
        $STH = $DBH->query($sql);
        // print_r($STH); die('--');
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }

    //add by ample 13-10-20 & update 28-10-20
    public function addBannerSliderData($admin_id,$data,$DYL_id="")
    {   

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql = "INSERT INTO `tblbannerslider` (`created_by`,`banner_title`,`banner_text_line1`,`banner_text_line2`,`banner_image`,`button1`,`button1_url`,`button1_font_family`,`button1_font_size`,`button1_font_color`,`button1_bg_color`,`button1_icon_code`,`button1_show`,`button2`,`button2_url`,`button2_font_family`,`button2_font_size`,`button2_font_color`,`button2_bg_color`,`button2_icon_code`,`button2_show`,`banner_order`,`banner_status`,`admin_notes`) VALUES (".$admin_id.",'".addslashes($data['banner_title'])."','".addslashes($data['banner_text_line1'])."','".addslashes($data['banner_text_line2'])."','".$data['banner_image']."','".$data['button1']."','".$data['button1_url']."','".$data['button1_font_family']."','".$data['button1_font_size']."','".$data['button1_font_color']."','".$data['button1_bg_color']."','".$data['button1_icon_code']."','".$data['button1_show']."','".$data['button2']."','".$data['button1_url']."','".$data['button2_font_family']."','".$data['button2_font_size']."','".$data['button2_font_color']."','".$data['button2_bg_color']."','".$data['button2_icon_code']."','".$data['button2_show']."','".$data['banner_order']."','".$data['banner_status']."','".addslashes($data['admin_notes'])."')";

        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }  
    //copy by ample 
    public function getStateOption($country_id,$state_id="")
    {
        $DBH = new mysqlConnection();

        $output = '';


        $country_sql_str = "";


            if($country_id != '' && $country_id != 0)

            {

                $country_sql_str = " AND country_id = '".$country_id."' ";  

            }


      

            try {

                $sql = "SELECT state_id,state FROM `tblstates` WHERE `state_deleted` = '0' ".$country_sql_str." ORDER BY state ASC";    

                $STH = $DBH->query($sql);

                if( $STH->rowCount() > 0 )

                {

                    while($r= $STH->fetch(PDO::FETCH_ASSOC))

                    {


                            if($r['state_id'] == $state_id )

                            {

                                $selected = ' selected ';   

                            }

                            else

                            {

                                $selected = ''; 

                            }

                        

                        

                        $output .= '<option value="'.$r['state_id'].'" '.$selected.'>'.stripslashes($r['state']).'</option>';

                    }

                }

            } catch (Exception $e) {

                $stringData = '[getStateOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;

                $this->debuglog($stringData);

                return $output;

            }       

        

        return $output;

    }
    //copy by ample 13-10-20
    public function getCityOption($country_id,$state_id,$city_id="")

    {

        //echo 'hiiiiii';

        $DBH = new mysqlConnection();

        $output = '<option value="">All City</option>';

        $state_sql_str = "";

        $country_sql_str = "";

 

            if($country_id != '' && $country_id != 0)

            {

                $country_sql_str = " AND country_id = '".$country_id."' ";  

            }

    

            

            if($state_id != '' && $state_id != 0)

            {

                $state_sql_str = " AND state_id = '".$state_id."' ";    

            }


        



            try {

                $sql = "SELECT city_id,city FROM `tblcities` WHERE `city_deleted` = '0' ".$country_sql_str." ".$state_sql_str." ORDER BY city ASC"; 

                $STH = $DBH->query($sql);

                if( $STH->rowCount() > 0 )

                {

                    while($r= $STH->fetch(PDO::FETCH_ASSOC))

                    {


                            if($r['city_id'] == $city_id )

                            {

                                $selected = ' selected ';   

                            }

                            else

                            {

                                $selected = ''; 

                            }

                        
                        $output .= '<option value="'.$r['city_id'].'" '.$selected.'>'.stripslashes($r['city']).'</option>';

                    }

                }

            } catch (Exception $e) {

                $stringData = '[getCityOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;

                $this->debuglog($stringData);

                return $output;

            }       

        

        return $output;

    }
    //copy by ample 14-10-20
    public function getAreaOption($country_id,$state_id,$city_id,$area_id="")

    {

        $DBH = new mysqlConnection();

        $output = '<option value="">All Area</option>';

        $city_sql_str = "";

        $state_sql_str = "";

        $country_sql_str = "";


            if($country_id != '' && $country_id != 0)

            {

                $country_sql_str = " AND country_id = '".$country_id."' ";  

            }

            if($state_id != '' && $state_id != 0)

            {

                $state_sql_str = " AND state_id = '".$state_id."' ";    

            }


            if($city_id != '' && $city_id != 0)

            {

                $city_sql_str = " AND city_id = '".$city_id."' ";   

            }




            try {

                $sql = "SELECT area_id,area_name FROM `tblarea` WHERE `area_deleted` = '0' ".$country_sql_str." ".$state_sql_str." ".$city_sql_str." ORDER BY area_name ASC";   

                $STH = $DBH->query($sql);

                if( $STH->rowCount() > 0 )

                {

                    while($r= $STH->fetch(PDO::FETCH_ASSOC))

                    {


                            if($r['area_id'] == $area_id )

                            {

                                $selected = ' selected ';   

                            }

                            else

                            {

                                $selected = ''; 

                            }
                    

                        $output .= '<option value="'.$r['area_id'].'" '.$selected.'>'.stripslashes($r['area_name']).'</option>';

                    }

                }

            } catch (Exception $e) {

                $stringData = '[getAreaOption] Catch Error:'.$e->getMessage().' , sql:'.$sql;

                $this->debuglog($stringData);

                return $output;

            }       


        return $output;

    }   
    //add by ample 14-10-20
    function getAdminUser_banner_slider()
    {
         $my_DBH = new mysqlConnection();
            $DBH = $my_DBH->raw_handle();
            $DBH->beginTransaction();
            $data=array();
            $return=false;
            $sql="SELECT DISTINCT created_by FROM `tblbannerslider` ";
            $STH = $DBH->query($sql);
            if($STH->rowCount()  > 0)
            {   
                while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row['created_by'];
                }

            }
        return $data;  
    }
    // add by ample 14-10-20
    public function deleteBannerSlider($id="")
    {   
        $admin_id = $_SESSION['admin_id'];  
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $del_sql1 = "UPDATE `tblbannerslider` SET `is_deleted` =1,`deleted_by`='".$admin_id."',`deleted_at`='".date('Y-m-d H:i:s')."'  WHERE `banner_id` = '".$id."'"; 
        $STH = $DBH->prepare($del_sql1);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }  
     //add by ample 16-10-20
    public function addBandSetting($admin_id,$data,$PD_id="")
    {   

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql = "INSERT INTO `tblbandsetting` (`created_by`,`band_title`,`band_text`,`button1`,`button1_url`,`button1_font_family`,`button1_font_size`,`button1_font_color`,`button1_bg_color`,`button1_icon_code`,`button1_show`,`button2`,`button2_url`,`button2_font_family`,`button2_font_size`,`button2_font_color`,`button2_bg_color`,`button2_icon_code`,`button2_show`,`band_row_no`,`band_status`,`data_content`,`data_link`,`bg_image`,`bg_color`,`band_type`) VALUES (".$admin_id.",'".addslashes($data['band_title'])."','".addslashes($data['band_text'])."','".$data['button1']."','".$data['button1_url']."','".$data['button1_font_family']."','".$data['button1_font_size']."','".$data['button1_font_color']."','".$data['button1_bg_color']."','".$data['button1_icon_code']."','".$data['button1_show']."','".$data['button2']."','".$data['button1_url']."','".$data['button2_font_family']."','".$data['button2_font_size']."','".$data['button2_font_color']."','".$data['button2_bg_color']."','".$data['button2_icon_code']."','".$data['button2_show']."','".$data['band_row_no']."','".$data['band_status']."','".$data['data_content']."','".$data['data_link']."','".$data['bg_image']."','".$data['bg_color']."','".$data['band_type']."')";

        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {   
             $band_id = $DBH->lastInsertId();
                    if(!empty($PD_id))
                    {
                        $this->updatePageDecor_ID($PD_id,$band_id);
                    }
            $return = true;
        }
        return $return;
    } 
     //add by ample 28-12-20
    public function addBandSetting_reset($admin_id,$data,$PD_id="")
    {   

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql = "INSERT INTO `tblbandsetting` (`created_by`,`band_title`,`band_text`,`button1`,`button1_url`,`button1_font_family`,`button1_font_size`,`button1_font_color`,`button1_bg_color`,`button1_icon_code`,`button1_show`,`button2`,`button2_url`,`button2_font_family`,`button2_font_size`,`button2_font_color`,`button2_bg_color`,`button2_icon_code`,`button2_show`,`band_row_no`,`band_status`,`data_content`,`data_link`,`bg_image`,`bg_color`,`band_type`,`page_decor_id`,`is_default`) VALUES (".$admin_id.",'".addslashes($data['band_title'])."','".addslashes($data['band_text'])."','".$data['button1']."','".$data['button1_url']."','".$data['button1_font_family']."','".$data['button1_font_size']."','".$data['button1_font_color']."','".$data['button1_bg_color']."','".$data['button1_icon_code']."','".$data['button1_show']."','".$data['button2']."','".$data['button1_url']."','".$data['button2_font_family']."','".$data['button2_font_size']."','".$data['button2_font_color']."','".$data['button2_bg_color']."','".$data['button2_icon_code']."','".$data['button2_show']."','".$data['band_row_no']."','".$data['band_status']."','".$data['data_content']."','".$data['data_link']."','".$data['bg_image']."','".$data['bg_color']."','".$data['band_type']."',".$PD_id.",".$data['is_default'].")";
        
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {   
            $band_id = $DBH->lastInsertId();
            $return = true;
        }
        return $return;
    } 
    //added by ample 16-10-20
    public function updatePageDecor_ID($PD_id,$band_id)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql="UPDATE `tbl_page_decor` SET 
            `band_id`='".$band_id."' WHERE `id`='".$PD_id."'";
        $STH = $DBH->query($sql);
        //print_r($STH);
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    //added by ample 16-10-20
    public function getBandSetting($id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tblbandsetting` WHERE band_id ='".$id."' ";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
        }
        return $data;     
    } 
    //added by ample 16-10-20
    public function editBandSetting($admin_id,$data,$id)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql="UPDATE `tblbandsetting` SET 
            `updated_by`='".$admin_id."',`updated_at`='".date('Y-m-d H:i:s')."',`band_title`='".addslashes($data['band_title'])."',`band_text`='".addslashes($data['band_text'])."',`button1`='".$data['button1']."',`button1_url`='".$data['button1_url']."',`button1_font_family`='".$data['button1_font_family']."',`button1_font_size`='".$data['button1_font_size']."',`button1_font_color`='".$data['button1_font_color']."',`button1_bg_color`='".$data['button1_bg_color']."',`button1_icon_code`='".$data['button1_icon_code']."',`button1_show`='".$data['button1_show']."',`button2`='".$data['button2']."',`button2_url`='".$data['button2_url']."',`button2_font_family`='".$data['button2_font_family']."',`button2_font_size`='".$data['button2_font_size']."',`button2_font_color`='".$data['button2_font_color']."',`button2_bg_color`='".$data['button2_bg_color']."',`button2_icon_code`='".$data['button2_icon_code']."',`button2_show`='".$data['button2_show']."',`band_row_no`='".$data['band_row_no']."',`band_status`='".$data['band_status']."',`data_content`='".$data['data_content']."',`data_link`='".$data['data_link']."',`bg_image`='".$data['bg_image']."',`bg_color`='".$data['bg_color']."',`band_type`='".$data['band_type']."' WHERE `band_id`='".$id."'";
        $STH = $DBH->query($sql);
        // print_r($STH); die('--');
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    public function editBandSetting_reset($admin_id,$data,$id)
    {

        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return=false;

        $sql="UPDATE `tblbandsetting` SET 
            `updated_by`='".$admin_id."',`updated_at`='".date('Y-m-d H:i:s')."',`band_title`='".addslashes($data['band_title'])."',`band_text`='".addslashes($data['band_text'])."',`button1`='".$data['button1']."',`button1_url`='".$data['button1_url']."',`button1_font_family`='".$data['button1_font_family']."',`button1_font_size`='".$data['button1_font_size']."',`button1_font_color`='".$data['button1_font_color']."',`button1_bg_color`='".$data['button1_bg_color']."',`button1_icon_code`='".$data['button1_icon_code']."',`button1_show`='".$data['button1_show']."',`button2`='".$data['button2']."',`button2_url`='".$data['button2_url']."',`button2_font_family`='".$data['button2_font_family']."',`button2_font_size`='".$data['button2_font_size']."',`button2_font_color`='".$data['button2_font_color']."',`button2_bg_color`='".$data['button2_bg_color']."',`button2_icon_code`='".$data['button2_icon_code']."',`button2_show`='".$data['button2_show']."',`band_row_no`='".$data['band_row_no']."',`band_status`='".$data['band_status']."',`data_content`='".$data['data_content']."',`data_link`='".$data['data_link']."',`bg_image`='".$data['bg_image']."',`bg_color`='".$data['bg_color']."',`band_type`='".$data['band_type']."',`is_default`=".$data['is_default']." WHERE `band_id`='".$id."'";
        $STH = $DBH->query($sql);
        // print_r($STH); die('--');
        if($STH->rowCount() > 0)
        {   
            $return = true;
        }
        return $return;
    }
    //add by ample 29-10-20
    public function getRedirectSchedule($redirect_id="",$redirect="")
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tbl_common_scheduled` WHERE redirect='".$redirect."' AND redirect_id =".$redirect_id;
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
           while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
        }
        return $data;     
    }
    //copy by ample 29-10-20
    public function getMonthName($no_month) {
        $option_str = '';
        $arr_record = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
        return $arr_record[$no_month];
    }
    //copy by ample 29-10-20
    public function getWeekName($no_week) {
        $option_str = '';
        $arr_day_of_week = array(1 => 'Sunday', 2 => 'Monday', 3 => 'Tuesday', 4 => 'Wednesday', 5 => 'Thursday', 6 => 'Friday', 7 => 'Saturday');
        return $arr_day_of_week[$no_week];
    }
    public function GetStateName($state_id) {
        $DBH = new mysqlConnection();
        $option_str = '';
        $sql = "SELECT `state` FROM `tblstates` WHERE `state_id` = " . $state_id . " ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $option_str = $row['state'];
        }
        return $option_str;
    }
    public function GetCityName($city_id) {
        $DBH = new mysqlConnection();
        $option_str = '';
        $sql = "SELECT `city` FROM `tblcities` WHERE `city_id` = " . $city_id . " ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $option_str = $row['city'];
        }
        return $option_str;
    }
    public function GetAreaName($area_id) {
        $DBH = new mysqlConnection();
        $option_str = '';
        $sql = "SELECT `area_name` FROM `tblarea` WHERE `area_id` = " . $area_id . " ";
        $STH = $DBH->query($sql);
        if ($STH->rowCount() > 0) {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $option_str = $row['area_name'];
        }
        return $option_str;
    }
    //added by ample 16-10-20
    public function get_reset_mood_setting($page_decor_id,$band_type)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tblbandsetting` WHERE page_decor_id ='".$page_decor_id."' AND band_type ='".$band_type."'";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
        }
        return $data;     
    }

    public function getBannerSizeById($bs_id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $data =array();
        $sql = "SELECT * FROM `tblbannerssizes` WHERE bs_id ='".$bs_id."' ";
        $STH = $DBH->query($sql);
        if( $STH->rowCount() > 0 )
        {
            $row = $STH->fetch(PDO::FETCH_ASSOC);
            $data = $row;
        }
        return $data;     
    }
}

?>
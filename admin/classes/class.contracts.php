<?php
include_once("class.paging.php");
include_once("class.admin.php");

class Contracts extends Admin
{
    public function getAllContractsTransactionType($search,$status)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();

        $admin_id = $_SESSION['admin_id'];
        $edit_action_id = '273';
        $delete_action_id = '274';

        $edit = $this->chkValidActionPermission($admin_id,$edit_action_id);
        $delete = $this->chkValidActionPermission($admin_id,$delete_action_id);

        if($search == '')
        {
            $str_sql_search = '';
        }
        else
        {
            $str_sql_search = " AND `ctt_name` LIKE '%".$search."%' ";
        }

        if($status == '')
        {
            $str_sql_status = '';
        }
        else
        {
            $str_sql_status = " AND `ctt_status` = '".$status."'";
        }

        $sql = "SELECT * FROM `tblcontractstranstype` WHERE `ctt_deleted` = '0' ".$str_sql_search." ".$str_sql_status." ORDER BY ctt_name ASC ";
        //$this->execute_query($sql);
        $STH = $DBH->prepare($sql);
        $STH->execute();
        $total_records = $STH->rowCount();
        $record_per_page = 100;
        $scroll = 5;
        $page = new Page(); 
        $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);
        $page->set_link_parameter("Class = paging");
        $page->set_qry_string($str="mode=contracts_trans_type");
        //$result=$this->execute_query($page->get_limit_query($sql));
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
                if($row['ctt_status'] == '1')
                {
                    $status = 'Active';
                }
                else
                {
                    $status = 'Inactive';
                }

                $output .= '<tr class="manage-row">';
                $output .= '<td height="30" align="center">'.$i.'</td>';
                $output .= '<td height="30" align="center"><strong>'.stripslashes($row['ctt_name']).'</strong></td>';
                $output .= '<td height="30" align="center"><strong>'.$status.'</strong></td>';
                $output .= '<td height="30" align="center">';
                if($edit) {
                $output .= '<a href="index.php?mode=edit_contracts_trans_type&id='.$row['ctt_id'].'" ><img src = "images/edit.gif" border="0"></a>';
                }
                $output .= '</td>';
                $output .= '<td height="30" align="center">';
                if($delete) {
                $output .= '<a href=\'javascript:fn_confirmdelete("Category","sql/delcontractstranstype.php?id='.$row['ctt_id'].'")\' ><img src = "images/del.gif" border="0" ></a>';
                }
                $output .= '</td>';
                $output .= '</tr>';
                //$output .= '<tr class="manage-row" height="30"><td colspan="5" align="center">&nbsp;</td></tr>';
                $i++;
            }
        }
        else
        {
            $output = '<tr class="manage-row" height="30"><td colspan="5" align="center">NO RECORDS FOUND</td></tr>';
        }

        $page->get_page_nav();
        return $output;
    }
    
    public function chkIfContractsTransactionTypeAlreadyExists($ctt_name)
    {
        $my_DBH = new mysqlConnection();
       $DBH = $my_DBH->raw_handle();
       $DBH->beginTransaction();
        $return = false;

        $sql = "SELECT * FROM `tblcontractstranstype` WHERE `ctt_name` = '".addslashes($ctt_name)."' AND `ctt_deleted` = '0' ";
         $STH = $DBH->prepare($sql);
         $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }

    public function chkIfContractsTransactionTypeAlreadyExists_Edit($ctt_name,$ctt_id)
    {
        $my_DBH = new mysqlConnection();
       $DBH = $my_DBH->raw_handle();
       $DBH->beginTransaction();
        $return = false;

        $sql = "SELECT * FROM `tblcontractstranstype` WHERE `ctt_name` = '".addslashes($ctt_name)."' AND `ctt_id` != '".$ctt_id."' AND `ctt_deleted` = '0' ";
         $STH = $DBH->prepare($sql);
         $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }

    public function addContractsTransactionType($ctt_name)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;

        $sql = "INSERT INTO `tblcontractstranstype` (`ctt_name`,`ctt_status`) VALUES ('".addslashes($ctt_name)."','1')";
        $STH = $DBH->prepare($sql);
         $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }

    public function updateContractsTransactionType($ctt_id,$ctt_name,$ctt_status)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $upd_sql = "UPDATE `tblcontractstranstype` SET `ctt_name` = '".addslashes($ctt_name)."', `ctt_status` = '".addslashes($ctt_status)."' WHERE `ctt_id` = '".$ctt_id."'";
         $STH = $DBH->prepare($upd_sql);
         $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }

    public function getContractsTransactionTypeDetails($ctt_id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $ctt_name = '';
        $ctt_status = '';

        $sql = "SELECT * FROM `tblcontractstranstype` WHERE `ctt_id` = '".$ctt_id."'";
        $STH = $DBH->prepare($sql);
         $STH->execute();
        if($STH->rowCount() > 0)
        {
           $row = $STH->fetch(PDO::FETCH_ASSOC);
            $ctt_name = stripslashes($row['ctt_name']);
            $ctt_status = stripslashes($row['ctt_status']);
        }
        return array($ctt_name,$ctt_status);
    }
    
    public function deleteContractsTransactionType($ctt_id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $return = false;
        $sql = "UPDATE `tblcontractstranstype` SET `ctt_deleted` = '1' WHERE `ctt_id` = '".$ctt_id."'";
        $STH = $DBH->prepare($sql);
        $STH->execute();
        if($STH->rowCount() > 0)
        {
            $return = true;
        }
        return $return;
    }
    
    public function getContractsTransactionTypeOptions($ctt_id)
    {
        $my_DBH = new mysqlConnection();
        $DBH = $my_DBH->raw_handle();
        $DBH->beginTransaction();
        $option_str = '';

        $sql = "SELECT * FROM `tblcontractstranstype` WHERE `ctt_status` = '1' AND `ctt_deleted` = '0' ORDER BY ctt_name ASC";
         $STH = $DBH->prepare($sql);
         $STH->execute();
        if($STH->rowCount() > 0)
        {
            while($row = $STH->fetch(PDO::FETCH_ASSOC))
            {
                if($row['ctt_id'] == $ctt_id)
                {
                    $selected = ' selected ';
                }
                else
                {
                    $selected = '';
                }
                $option_str .= '<option value="'.$row['ctt_id'].'" '.$selected.' >'.stripslashes($row['ctt_name']).'</option>';
            }	 
        }
       
        return $option_str;
    }

    
}
?>
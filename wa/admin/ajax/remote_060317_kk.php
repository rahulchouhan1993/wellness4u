<?php
include_once('../../classes/config.php');
require_once('../../classes/admin.php');
$obj = new Admin();
if(!$obj->isAdminLoggedIn())
{
	exit(0);
}


$error = false;
$err_msg = '';
$action = $_REQUEST['action'];
if($action=='adminlist')
{
	$admin_id = $_SESSION['admin_id'];
	$txtsearch = '';
	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')
	{
		$txtsearch = trim($_POST['txtsearch']);
	}
    $superadmin = $obj->getAllSubadmins($txtsearch);
    
	$option='';
	//start pagination for notification
    
    $adjacents = 1;
    $records_per_page = 10;
    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);
    $page = ($page == 0 ? 1 : $page);
    $start = ($page-1) * $records_per_page;
    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.

    $data = array_slice($superadmin, $start, $records_per_page);
	$count = count($superadmin);
	
    $next = $page + 1;    
    $prev = $page - 1;
    $last_page = ceil($count/$records_per_page);
    $second_last = $last_page - 1; 
    $pagination = '';
    
    if($last_page > 1)
	{
        $pagination .= '<div class="pagination">';
		if($page > 1)
		{
			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$prev.');">&laquo; Previous&nbsp;&nbsp;</a>';
		}
		else
		{
			$pagination.= '<span class="disabled paginate_button">&laquo; Previous&nbsp;&nbsp;</span>';   
		}
			
		if($last_page < 7 + ($adjacents * 2))
		{   
			for ($counter = 1; $counter <= $last_page; $counter++)
			{
				if ($counter == $page)
				{
					$pagination.= '<span class="current paginate_button">'.$counter.'</span>';
				}
				else
				{
					$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     
				}
			}
		}
		elseif($last_page > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))
			{
				for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if($counter == $page)
					{
						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';
					}
					else
					{
						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     
					}
				}
				$pagination.= '...';
				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';
				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   
			}
			elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';
				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';
				$pagination.= '...';
				for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if($counter == $page)
					{
						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';
					}
					else
					{
						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     
					}
				}
				$pagination.= '..';
				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$second_last.');">'.$second_last.'</a>';
				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$last_page.');">'.$last_page.'</a>';   
			}
			else
			{
				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(1);">1</a>';
				$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page(2);">2</a>';
				$pagination.= '..';
				for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)
				{
					if($counter == $page)
					{
						$pagination.= '<span class="current paginate_button">'.$counter.'</span>';
					}
					else
					{
						$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$counter.');">'.$counter.'</a>';     
					}
				}
			}
		}
		
		if($page < $counter - 1)
		{
			$pagination.= '<a href="javascript:void(0);" class="paginate_button" onClick="change_page('.$next.');">Next &raquo;</a>';
		}
		else
		{
			$pagination.= '<span class="disabled paginate_button">Next &raquo;</span>';
		}
		$pagination.= '</div>';       
    } 
	
	$option.= '	<div class="table-responsive">
					<table id="datatable" class="table table-hover" >
						<thead>
							<tr>
								<th>Sr No</th>
								<th>Username</th>
								<th>Email</th>
								<th>Full Name</th>
								<th>Contact No</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>';
	$edit_action_id = '3';
	$delete_action_id = '4';					
	if(is_array($data) && count($data) > 0)
	{
		if($obj->chkIfAccessOfMenuAction($admin_id,$edit_action_id))
		{
			$edit_action = true;
		}	
		else
		{
			$edit_action = false;
		}
		
		if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))
		{
			$delete_action = true;
		}	
		else
		{
			$delete_action = false;
		}
		
    	foreach($data as $record)
		{
            if($record['status'] == 1 )
			{
				$status = 'Active';
			}
			else
			{
				$status = 'InActive'; 
			}
			
			
			
                                         
			$option.='		<tr>
								<td>'.$i.'</td>
								<td>'.$record['username'].'</td>
								<td>'.$record['email'].'</td>
								<td>'.$record['fname'].' '.$record['lname'].'</td>
								<td>'.$record['contact_no'].'</td>
								<td>'.$status.'</td>
								<td>';
			if($edit_action)
			{			
			$option.='				<a href="edit_admin.php?token='.base64_encode($record['admin_id']).'"><i class="fa fa-pencil"></i></a>&nbsp;';
			}
			
			if($delete_action)
			{
			$option.='				<a href="javascript:void(0);" onclick="deleteAdmin('.$record['admin_id'].')";><i class="fa fa-trash"></i></a>';
			}
			
			$option.='			</td>
							</tr>';
			$i++;
		}
	}
	else
	{
		$option.='			<tr><td colspan="7" style="color:red;text-align:center">No record</d></tr>';
	}
	
	$option.='			</tbody>
					</table>
				</div>';
	
	if(count($data)>0 && !empty($data))
	{
	  $option.= $pagination;
	}
	echo $option;
}
elseif($action == 'deleteadmin')
{
    $admin_id = $_POST['admin_id'];
    
    if($admin_id!='')
    {
        if($obj->deleteAdminUser($admin_id))
        {
			$tdata = array();
			$response = array('status'=>1);
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);
        }
        else
        {
			$tdata = array();
			$response = array('status'=>0,'msg'=>'Error while deleting try again latar.');
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);  
        }
    }
}
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
	
	$status = '';
	if(isset($_POST['status']) && trim($_POST['status']) != '')
	{
		$status = trim($_POST['status']);
	}
	
    $superadmin = $obj->getAllSubadmins($txtsearch,$status);
    
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
	
	$edit_action_id = '3';
	$delete_action_id = '4';	
	
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
								<th>';
	if($delete_action)
	{
	$option.= '					<input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deleteMultipleAdmin();">';	
	}			
								
	$option.= '					</th>
							</tr>
						</thead>
						<tbody>';
					
	if(is_array($data) && count($data) > 0)
	{
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
			$option.='				<a href="edit_admin.php?token='.base64_encode($record['admin_id']).'" title="Edit Admin"><i class="fa fa-pencil"></i></a>&nbsp;';
			$option.='				<a href="reset_admin_password.php?id='.$record['admin_id'].'" title="Reset Admin Password"><i class="fa fa-key"></i></a>&nbsp;';
			}
			
			$option.='			</td>
								<td>';
								
			if($delete_action)
			{
			$option.='				<input type="checkbox" name="chkbox_records[]" value="'.$record['admin_id'].'">';
			}			
			
			$option.='			</td>
							</tr>';
			$i++;
		}
	}
	else
	{
		$option.='			<tr><td colspan="8" style="color:red;text-align:center">No record</d></tr>';
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
elseif($action == 'deletemultipleadmin')
{
    $chkbox_records = trim($_POST['chkbox_records']);
	$admin_id = $_SESSION['admin_id'];
	
	if($chkbox_records!='')
    {
		$delete_action_id = '4';	
		if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))
		{
			$return = false;
			$arr_admin_id = explode(',',$chkbox_records);
			for($i=0; $i<count($arr_admin_id); $i++)
			{
				if($obj->deleteAdminUser($arr_admin_id[$i]))
				{
					$return = true;
				}
			}
			
			if($return)
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
		else
		{
			$tdata = array();
			$response = array('status'=>0,'msg'=>'Sorry you dont have access.');
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);  
		}
    }
	else
	{
		$tdata = array();
		$response = array('status'=>0,'msg'=>'Please select any record.');
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);  
	}
}
elseif($action=='catlist')
{
	$admin_id = $_SESSION['admin_id'];
	$txtsearch = '';
	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')
	{
		$txtsearch = trim($_POST['txtsearch']);
	}
	
	$status = '';
	if(isset($_POST['status']) && trim($_POST['status']) != '')
	{
		$status = trim($_POST['status']);
	}
	
	$cat = $obj->GetAllCat($txtsearch,$status);
   
	$option='';
	//start pagination for notification
    
    $adjacents = 1;
    $records_per_page = 10;
    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);
    $page = ($page == 0 ? 1 : $page);
    $start = ($page-1) * $records_per_page;
    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.

    $data = array_slice($cat, $start, $records_per_page);
	$count = count($cat);
	
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
	
	$edit_action_id = '7';
	$delete_action_id = '8';	
	
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
	
	$option.= '	<div class="table-responsive">
					<table id="datatable" class="table table-hover" >
						<thead>
							<tr>
								<th>Sr No</th>
								<th>Main Profile</th>
								<th>Status</th>
								<th>Action</th>
								<th>';
	if($delete_action)
	{
	$option.= '					<input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deleteMultipleCategory();">';	
	}		
	
	
	$option.= '					</th>
							</tr>
						</thead>
						<tbody>';
					
	if(is_array($data) && count($data) > 0)
	{
		foreach($data as $record)
		{
            if($record['cat_status'] == 1 )
			{
				$status = 'Active';
			}
			else
			{
				$status = 'InActive'; 
			}
			
			$option.='		<tr>
								<td>'.$i.'</td>
								<td>'.$record['cat_name'].'</td>
								<td>'.$status.'</td>
								<td>';
			if($edit_action)
			{			
			$option.='				<a href="edit_category.php?token='.base64_encode($record['cat_id']).'"><i class="fa fa-pencil"></i></a>&nbsp;';
			}
			
			
			
			$option.='			</td>
								<td>';
								
			if($delete_action)
			{
			$option.='				<input type="checkbox" name="chkbox_records[]" value="'.$record['cat_id'].'">';
			}					
			
			$option.='			</td>
							</tr>';
			$i++;
		}
	}
	else
	{
		$option.='			<tr><td colspan="5" style="color:red;text-align:center">No record</d></tr>';
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
elseif($action == 'deletemultiplecategory')
{
    $chkbox_records = trim($_POST['chkbox_records']);
	$admin_id = $_SESSION['admin_id'];
    
    if($chkbox_records!='')
    {
		$delete_action_id = '8';	
		if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))
		{
			$return = false;
			$arr_cat_id = explode(',',$chkbox_records);
			for($i=0; $i<count($arr_cat_id); $i++)
			{
				if($obj->DeleteCat($arr_cat_id[$i],$admin_id))
				{
					$return = true;
				}
			}
			
			if($return)
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
		else
		{
			$tdata = array();
			$response = array('status'=>0,'msg'=>'Sorry you dont have access.');
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);  
		}
    }
	else
	{
		$tdata = array();
		$response = array('status'=>0,'msg'=>'Please select any record.');
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);  
	}
}
elseif($action=='maincatlist')
{
	$admin_id = $_SESSION['admin_id'];
	$txtsearch = '';
	$parent_cat_id = '';
	$status = '';
	
	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')
	{
		$txtsearch = trim($_POST['txtsearch']);
	}
	
	if(isset($_POST['parent_cat_id']) && trim($_POST['parent_cat_id']) != '')
	{
		$parent_cat_id = trim($_POST['parent_cat_id']);
	}
	
	if(isset($_POST['status']) && trim($_POST['status']) != '')
	{
		$status = trim($_POST['status']);
	}
	
	$cat = $obj->GetAllMainCat($txtsearch,$parent_cat_id,$status);
   
	$option='';
	//start pagination for notification
    
    $adjacents = 1;
    $records_per_page = 10;
    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);
    $page = ($page == 0 ? 1 : $page);
    $start = ($page-1) * $records_per_page;
    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.

    $data = array_slice($cat, $start, $records_per_page);
	$count = count($cat);
	
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
	
	$edit_action_id = '11';
	$delete_action_id = '12';		
	
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
	
	$option.= '	<div class="table-responsive">
					<table id="datatable" class="table table-hover" >
						<thead>
							<tr>
								<th>Sr No</th>
								<th>Category</th>
								<th>Main Profile</th>
								<th>Status</th>
								<th>Action</th>
								<th>';
	if($delete_action)
	{
	$option.= '					<input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deleteMultipleMainCategory();">';	
	}		
	
	
	$option.= '					</th>
							</tr>
						</thead>
						<tbody>';					
				
	if(is_array($data) && count($data) > 0)
	{
		foreach($data as $record)
		{
            if($record['cat_status'] == 1 )
			{
				$status = 'Active';
			}
			else
			{
				$status = 'InActive'; 
			}
			
			
			$option.='		<tr>
								<td>'.$i.'</td>
								<td>'.$record['cat_name'].'</td>
								<td>'.$obj->GetCatName($record['parent_cat_id']).'</td>
								<td>'.$status.'</td>
								<td>';
			if($edit_action)
			{			
			$option.='				<a href="edit_main_category.php?token='.base64_encode($record['cat_id']).'"><i class="fa fa-pencil"></i></a>&nbsp;';
			}
			
			
			
			$option.='			</td>
								<td>';
								
			if($delete_action)
			{
			$option.='				<input type="checkbox" name="chkbox_records[]" value="'.$record['cat_id'].'">';
			}					
			
			$option.='			</td>
							</tr>';
			
			$i++;
		}
	}
	else
	{
		$option.='			<tr><td colspan="6" style="color:red;text-align:center">No record</d></tr>';
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
elseif($action == 'deletemultiplemaincategory')
{
    $chkbox_records = trim($_POST['chkbox_records']);
	$admin_id = $_SESSION['admin_id'];
    
    if($chkbox_records!='')
    {
		$delete_action_id = '12';	
		if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))
		{
			$return = false;
			$arr_cat_id = explode(',',$chkbox_records);
			for($i=0; $i<count($arr_cat_id); $i++)
			{
				if($obj->DeleteMainCat($arr_cat_id[$i],$admin_id))
				{
					$return = true;
				}
			}
			
			if($return)
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
		else
		{
			$tdata = array();
			$response = array('status'=>0,'msg'=>'Sorry you dont have access.');
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);  
		}
    }
	else
	{
		$tdata = array();
		$response = array('status'=>0,'msg'=>'Please select any record.');
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);  
	}
}
elseif($action=='adminmenulist')
{
	$admin_id = $_SESSION['admin_id'];
	$txtsearch = '';
	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')
	{
		$txtsearch = trim($_POST['txtsearch']);
	}
	
	$status = '';
	if(isset($_POST['status']) && trim($_POST['status']) != '')
	{
		$status = trim($_POST['status']);
	}
	
    $arr_records = $obj->getAllAdminMenusList($txtsearch,$status);
    
	$option='';
	//start pagination for notification
    
    $adjacents = 1;
    $records_per_page = 10;
    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);
    $page = ($page == 0 ? 1 : $page);
    $start = ($page-1) * $records_per_page;
    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.

    $data = array_slice($arr_records, $start, $records_per_page);
	$count = count($arr_records);
	
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
	
	$edit_action_id = '15';
	$delete_action_id = '16';	
	
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
	
	$option.= '	<div class="table-responsive">
					<table id="datatable" class="table table-hover" >
						<thead>
							<tr>
								<th>Sr No</th>
								<th>Menu Title</th>
								<th>Menu Link</th>
								<th>Order Of Menu</th>
								<th>Status</th>
								<th>Action</th>
								<th>';
	if($delete_action)
	{
	$option.= '					<input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deleteMultipleAdminMenu();">';	
	}		
	
	$option.= '					</th>
							</tr>
						</thead>
						<tbody>';
					
	if(is_array($data) && count($data) > 0)
	{
		foreach($data as $record)
		{
            if($record['am_status'] == 1 )
			{
				$status = 'Active';
			}
			else
			{
				$status = 'InActive'; 
			}
			
			$option.='		<tr>
								<td>'.$i.'</td>
								<td>'.$record['am_title'].'</td>
								<td>'.$record['am_link'].'</td>
								<td>'.$record['am_order'].'</td>
								<td>'.$status.'</td>
								<td>';
			if($edit_action)
			{			
			$option.='				<a href="edit_admin_menu.php?token='.base64_encode($record['am_id']).'" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;';
			$option.='				<a href="manage_admin_actions.php?am_id='.$record['am_id'].'" title="View Actions"><i class="fa fa-eye"></i></a>&nbsp;';
			}
			
			$option.='			</td>
								<td>';
								
			if($delete_action)
			{
			$option.='				<input type="checkbox" name="chkbox_records[]" value="'.$record['am_id'].'">';
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
elseif($action == 'deletemultipleadminmenu')
{
	$chkbox_records = trim($_POST['chkbox_records']);
	$admin_id = $_SESSION['admin_id'];
    
    if($chkbox_records!='')
    {
		$delete_action_id = '16';	
		if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))
		{
			$return = false;
			$arr_am_id = explode(',',$chkbox_records);
			for($i=0; $i<count($arr_am_id); $i++)
			{
				$tdata = array();
				$tdata['am_id'] = $arr_am_id[$i];
				$tdata['deleted_by_admin'] = $admin_id;
				if($obj->deleteAdminMenu($tdata))
				{
					$return = true;
				}
			}
			
			if($return)
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
		else
		{
			$tdata = array();
			$response = array('status'=>0,'msg'=>'Sorry you dont have access.');
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);  
		}
    }
	else
	{
		$tdata = array();
		$response = array('status'=>0,'msg'=>'Please select any record.');
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);  
	}
}
elseif($action=='adminactionlist')
{
	$admin_id = $_SESSION['admin_id'];
	$am_id = trim($_POST['am_id']);
	$txtsearch = '';
	if(isset($_POST['txtsearch']) && trim($_POST['txtsearch']) != '')
	{
		$txtsearch = trim($_POST['txtsearch']);
	}
	
	$status = '';
	if(isset($_POST['status']) && trim($_POST['status']) != '')
	{
		$status = trim($_POST['status']);
	}
    $arr_records = $obj->getAllAdminActionList($am_id,$txtsearch,$status);
    
	$option='';
	//start pagination for notification
    
    $adjacents = 1;
    $records_per_page = 10;
    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);
    $page = ($page == 0 ? 1 : $page);
    $start = ($page-1) * $records_per_page;
    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.

    $data = array_slice($arr_records, $start, $records_per_page);
	$count = count($arr_records);
	
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
	
	$edit_action_id = '15';
	$delete_action_id = '16';		
	
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
	
	$option.= '	<div class="table-responsive">
					<table id="datatable" class="table table-hover" >
						<thead>
							<tr>
								<th>Sr No</th>
								<th>Action Title</th>
								<th>Status</th>
								<th>Action</th>
								<th>';

	if($delete_action)
	{
	$option.= '					<input type="button" id="btndelete" name="btndelete" value="Delete" class="btn btn-primary" onclick="deleteMultipleAdminAction();">';	
	}	
	
	$option.= '					</th>
							</tr>
						</thead>
						<tbody>';
				
	if(is_array($data) && count($data) > 0)
	{
    	foreach($data as $record)
		{
            if($record['aa_status'] == 1 )
			{
				$status = 'Active';
			}
			else
			{
				$status = 'InActive'; 
			}
			
			$option.='		<tr>
								<td>'.$i.'</td>
								<td>'.$record['aa_title'].'</td>
								<td>'.$status.'</td>
								<td>';
			if($edit_action)
			{			
			$option.='				<a href="edit_admin_action.php?am_id='.$record['am_id'].'&token='.base64_encode($record['aa_id']).'" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;';
			}
			
			$option.='			</td>
								<td>';
								
			if($delete_action)
			{
			$option.='				<input type="checkbox" name="chkbox_records[]" value="'.$record['aa_id'].'">';
			}			
			
			$option.='			</td>
							</tr>';
			$i++;
		}
	}
	else
	{
		$option.='			<tr><td colspan="4" style="color:red;text-align:center">No record</d></tr>';
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
elseif($action == 'deletemultipleadminaction')
{
	$chkbox_records = trim($_POST['chkbox_records']);
	$admin_id = $_SESSION['admin_id'];
    
    if($chkbox_records!='')
    {
		$delete_action_id = '16';	
		if($obj->chkIfAccessOfMenuAction($admin_id,$delete_action_id))
		{
			$return = false;
			$arr_aa_id = explode(',',$chkbox_records);
			for($i=0; $i<count($arr_aa_id); $i++)
			{
				$tdata = array();
				$tdata['aa_id'] = $arr_aa_id[$i];
				$tdata['deleted_by_admin'] = $admin_id;
				if($obj->deleteAdminAction($tdata))
				{
					$return = true;
				}
			}
			
			if($return)
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
		else
		{
			$tdata = array();
			$response = array('status'=>0,'msg'=>'Sorry you dont have access.');
			$tdata[] = $response;
			echo json_encode($tdata);
			exit(0);  
		}
    }
	else
	{
		$tdata = array();
		$response = array('status'=>0,'msg'=>'Please select any record.');
		$tdata[] = $response;
		echo json_encode($tdata);
		exit(0);  
	}
}
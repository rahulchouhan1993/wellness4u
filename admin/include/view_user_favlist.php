<?php
require_once('config/class.mysql.php');
require_once('classes/class.library.php');  
$obj = new Library();

require_once('classes/class.scrollingwindows.php');  
$obj1 = new Scrolling_Windows();

$view_action_id = '164';

if(!$obj->isAdminLoggedIn())
{
  header("Location: index.php?mode=login");
  exit(0);
}

if(!$obj->chkValidActionPermission($admin_id,$view_action_id))
{ 
  header("Location: index.php?mode=invalid");
  exit(0);
}

if(isset($_POST['btnActive']))
{
   $user_id  = $_POST['user_id'];
   $active  = $_POST['chk_button'];
   //print_r($active);
   if(is_array($active) && count($active) >0)
   {
    $count = count($active);
    for($i=0 ; $i<$count ; $i++) 
    { 
      $active_library = $obj->Active_library($active[$i]);
    }
    $msg = 'Selected users deleted.';
  }
}

if(isset($_POST['btnInactive']))
{
  $user_id  = $_POST['user_id'];
  $inactive  = $_POST['chk_button'];
  //print_r($inactive);
  if(is_array($inactive) && count($inactive) >0)
  {
    for($i=0 ; $i<count($inactive); $i++) 
    { 
      $inactive_library = $obj->InActive_library($inactive[$i]);
    }
    $msg = 'Selected users deleted.';
  }
}

if(isset($_POST['btnLibrary']))
{

    $user_id=$_POST['user_id'];

} 
  
list($arr_user_name,$arr_priority,$arr_library_id,$arr_category,$arr_note,$arr_file,$arr_title,$arr_type,$arr_status,$arr_date) = $obj->View_FavLibrary_details($user_id);
?>
<div id="central_part_contents">
  <div id="notification_contents"><!--notification_contents--></div>    
  <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td>
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
            <td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
            <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage User FavList</td>
            <td style="background-image: url(images/mainbox_title_right.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
          </tr>
        </tbody>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table class="mainbox-border" border="0" width="100%" cellpadding="10" cellspacing="1">
        <tbody>
          <tr>
            <td class="mainbox-body">
              <p class="err_msg"><?php if(isset($_GET['msg']) && $_GET['msg'] != '' ) { echo urldecode($_GET['msg']); }?></p>
              <div id="pagination_contents" align="center"> 
                <p>
                                 <form action="#" method="post" name="frm_library"  enctype="multipart/form-data" >
                                <table border="0" width="100%" cellpadding="1" cellspacing="1">
                                  <tr>
                                      <td width="25%" align="right"><strong>Select User : </strong></td>
                          <td width="5%" align="center">
                                            <select name="user_id" id="user_id">
                                                <option value="">Select</option>
                                                <?php echo $obj->GetUsersOptions($user_id);?>
                                            </select>
                                        </td>
                                        <td width="25%" align="left">
                                          <input type="submit" id="btnLibrary" name="btnLibrary" value="View FavList" />
                                      </td>
                                    </tr>
                                 </table>
                                </p>
                <div id="library">
                        <?php if(count($arr_library_id)>0) { ?> 
                                  <table border="0" width="100%" cellpadding="7" cellspacing="1">
                                        <tr>
                                            <td><input type="submit" id="btnDelete" name="btnActive" value="Active" />
                                                <input type="submit" id="btnDelete" name="btnInactive" value="Inactive" /></td>
                                        </tr>
                                    </table>      
                                    <table border="1" width="100%" cellpadding="7" cellspacing="1">
                                    <tr class="manage-header">
                                        <td width="5%" class="manage-header" align="center">#</td>
                                        <td width="5%" class="manage-header" align="center">Sno</td>
                                        <td width="5%" class="manage-header" align="center">User</td>
                                        <td width="5%" class="manage-header" align="center">Priority</td>
                                        <td width="5%" class="manage-header" align="center">Category</td>
                                        <td width="15%" class="manage-header" align="center">Title</td>
                                        <td width="20%" class="manage-header" align="center">File</td>
                                        <td width="25%" class="manage-header" align="center">Note</td>
                                        <td width="10%" class="manage-header" align="center">Date</td>
                                        <td width="5%" class="manage-header" align="center">Status</td>
                                       
                                    </tr>
                                  <?php   
                                    for($i=0,$j=1;$i<count($arr_library_id);$i++,$j++)
                                    {   
                                        if($arr_status[$i] == 1)
                                        {
                                            $status = 'Active';
                                        }
                                        else
                                        {
                                            $status = 'Inactive';
                                        }
                                    
                                       // $date = date('d-M-Y h:i A',strtotime($arr_date[$i]));
                      $time= strtotime($arr_date[$i]);
                    $time=$time+19800;
                    $date = date('d-M-Y h:i A',$time);
                     
                     ?>
                                       <tr class="manage-row">
                                         <td align="center"><input type="checkbox" id="chk_button_<?php echo $i; ?>" name="chk_button[]" value=<?php echo $arr_library_id[$i]; ?> /></td>
                                         <td align="center"><?php echo $j; ?></td>
                                          <td align="center"><?php echo $arr_user_name[$i]; ?></td>
                                          <td align="center"><?php echo $obj1->getFavCategoryNameRamakant($arr_priority[$i]); ?></td>
                                         <td align="center"><?php echo $arr_category[$i]; ?></td>
                                         <td align="center"><?php echo $arr_title[$i]; ?></td>
                                         <td align="center"><a href="<?php echo SITE_URL."/uploads/".$arr_file[$i]; ?>" target="_blank"><?php echo $arr_file[$i]; ?></a></td>
                                         <td align="center"><?php echo $arr_note[$i]; ?></td>
                                         <td align="center"><?php echo $date ?></td>
                                         <td align="center"><?php echo $status; ?></td>
                                        
                                     <?php } ?>    
                                </tr>                                  
                               </table> 
                                <?php }
                                  else
                                  {
                                    ?>
                                    <p class="text-center">No Records</p>
                                    <?php
                                  }
                                 ?> 
                                </div>
                <p></p>
              <!--pagination_contents-->
              </div>
              <p></p>
                        </form>
            </td>
          </tr>
        </tbody>
        </table>
      </td>
    </tr>
  </tbody>
  </table>
  <br>
</div>
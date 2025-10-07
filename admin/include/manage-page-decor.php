<?php
   require_once('config/class.mysql.php');
   require_once('classes/class.contents.php');
   $obj = new Contents();
   
   $add_action_id = '373';
   $view_action_id = '372';
   
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

   if(isset($_POST['btnSubmit']))
   {
      $search = strip_tags(trim($_POST['search']));
      $status = strip_tags(trim($_POST['status']));
   }
?>
<div id="central_part_contents">
   <div id="notification_contents">
      <!--notification_contents-->
   </div>
   <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
      <tbody>
         <tr>
            <td>
               <table border="0" width="100%" cellpadding="0" cellspacing="0">
                  <tbody>
                     <tr>
                        <td style="background-image: url(images/mainbox_title_left.gif);" valign="top" width="9"><img src="images/spacer.gif" alt="" border="0" width="9" height="21"></td>
                        <td style="background-image: url(images/mainbox_title_bg.gif);" valign="middle" width="21"><img src="images/mainbox_title_icon.gif" alt="" border="0" width="21" height="5"></td>
                        <td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Page Decor</td>
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
                              <form action="#" method="post" name="frm_place" id="frm_place" enctype="multipart/form-data" AUTOCOMPLETE="off">
                              <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle"><strong>Search Record By admin notes, narration, Ref code</strong></td>
                                    </tr>
                                    <tr>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td height="30" align="left" valign="middle"><strong>Search:</strong></td>
                                        <td height="30" align="left" valign="middle">
                                           <input type="text" name="search" id="search" value="<?php echo $search;?>" style="width:200px;"  />
                                        </td>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td height="30" align="left" valign="middle"><strong>Status:</strong></td>
                                        <td height="30" align="left" valign="middle">
                                           <select name="status" id="status" style="width:200px;">
                                                <option value="">All Status</option>
                                                <option value="0" <?php if($status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                                <option value="1" <?php if($status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                            </select>
                                        </td>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td height="30" align="left" valign="middle">&nbsp;</td>
                                        <td height="30" align="left" valign="middle">
                                            <input type="submit" name="btnSubmit" id="btnSubmit" value="Search" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" height="30" align="left" valign="middle">&nbsp;</td>
                                    </tr>
                                </tbody>
                                </table>
                              </form>
                              </p>
                              <table border="1" width="100%" cellpadding="2" cellspacing="2">
                                 <tbody>
                                    <tr>
                                       <td colspan="16" align="left" nowrap="nowrap">
                                          <?php if($obj->chkValidActionPermission($admin_id,$add_action_id))
                                             {   ?>
                                          <a href="index.php?mode=add-page-decor"><img src="images/add.gif" width="10" height="8" border="0" />Add New</a>
                                          <?php } ?>
                                       </td>
                                    </tr>
                                    <tr class="manage-header">
                                       <td class="manage-header" align="center" >S.No.</td>
                                       <td class="manage-header" align="center">Status</td>
                                       <td class="manage-header" align="center">Added By</td>
                                       <td class="manage-header" align="center">Date</td>
                                       <td class="manage-header" align="center">Edit</td>
                                       <td class="manage-header" align="center">Del</td>
                                       <td class="manage-header" align="center">Ref Code</td>
                                       <td class="manage-header" align="center">Admin Notes</td>
                                       <td class="manage-header" align="center">Narration</td>
                                       <td class="manage-header" align="center">Page Type</td>
                                       <td class="manage-header" align="center">Page Name</td>
                                       <td class="manage-header" align="center">Page Heading</td>
                                       <td class="manage-header" align="center">Data Source</td>
                                       <td class="manage-header" align="center">Prof Cat</td>
                                       <td class="manage-header" align="center">Sub Cat</td>
                                       <td class="manage-header" align="center">Order</td>
                                    </tr>
                                    <?php
                                       echo $obj->getPageDecorListData($search,$status);
                                       
                                       ?>
                                 </tbody>
                              </table>
                              <p></p>
                              <!--pagination_contents-->
                           </div>
                           <p></p>
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
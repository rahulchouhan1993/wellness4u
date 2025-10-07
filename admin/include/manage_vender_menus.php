<?php
require_once('config/class.mysql.php');
require_once('classes/class.contents.php');

$obj = new Contents();

$view_action_id = '283';

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
}

$arr_inactive_menu_items = $obj->getAllInactiveMenuItemsVender();
$arr_active_menu_items = $obj->getAllActiveMenuItemsVender(0);
//echo '<br><pre>';
//print_r($arr_active_menu_items);
//echo '<br></pre>';
?>
<style type="text/css">
	.placeholder{background-color:#cfcfcf;}
	ul{margin:0;padding:0;padding-left:30px;}
	ul.sortable,ul.sortable ul{margin:0 0 0 25px;padding:0;list-style-type:none;}
	ol{margin:0;padding:0;padding-left:30px;}
	ol.sortable,ol.sortable ol{margin:0 0 0 25px;padding:0;list-style-type:none;}
	.sortable li{margin:7px 0 0 0;padding:0px;max-width:300px;}
	.sortable li div{padding:5px;margin:0;cursor:move;border:1px solid #999;background:#c2c2c2;color:#333;}
</style>
<script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.nestedSortable.js"></script>
<script type="text/javascript">
	$(function(){
		//$("ol.sortable").nestedSortable({
		/*$("#sortable2").nestedSortable({
		
			placeholder: 'placeholder',
			forcePlaceholderSize:true,
			handle: 'div',
			helper: 'clone',
			items: 'li',
			opacity: .6,
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div'
		}).disableSelection();*/
		
		$("#sortable2").nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',
			helper: 'clone',
			items: 'li',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			maxLevels: 3,
			isTree: true,
			expandOnHover: 700,
			startCollapsed: true
		}); 
		
		$('#btnSave').click(function(){
			//serialized = $("#sortable2").nestedSortable('serialize');
			//$('#result').text(serialized+'\n\n');
			Serialize("#sortable2")
		}); 
		
		$( "#sortable1, #sortable2" ).sortable({
			connectWith: ".sortable"
			}).disableSelection();
		});
	
	function RecurNodes(node,level , order)
	{
		level = level + 1;
		node = $(node);
		//alert('tempid = '+tempid+ ' , nodeid = '+node.attr('id'));
		
		//var menu_title = $('#hdnmenu_title_'+node.attr('id')).val();
		//var menu_link = $('#hdnmenu_link_'+node.attr('id')).val();
		//if(menu_link == '')
		//{
		//	menu_link = '#';
		//}
		//var val = '<n id="' + node.attr('id') + '" lvl="' + level + '" order="' + order + '">';
		var val = node.attr('id') + '_' + level + '_' + order + '::::';
		//var val = '<li id="' + node.attr('id') + '"><a href="'+menu_link+'">'+menu_title+'</a>';
		var childNodes = node.children('ol').children('li');
		if(childNodes && childNodes.length > 0)
		{
			//alert('childNodes.length = '+childNodes.length);
			//val += '<c>';
			//val += '<ul>';
			for(var i=0; i<childNodes.length; i++) val += RecurNodes(childNodes[i],level , i);
			//val += '</c>';
			//val += '</ul>';
		}
		//return val + '</n>';
		return val ;
		//return val + '</li>';
	}

	function Serialize(selector)
	{
		var nodes = $(selector).children('li');
		//var result = '<ns><c>';
		//var result = '<ul>';
		var result = '';
		for(var i=0; i<nodes.length; i++)
		{
			level = 0;
			result += RecurNodes(nodes[i],level , i);
		}		
		//result += '</c></ns>';
		//result += '</ul>';
		//$("#result").text(result);
		
		
		$.ajax({
			url: 'remote.php',
			method: 'post',
			type: 'POST',
			data: ({action : 'updateMenuOrdersVender' , result : result}),
			success: function(resstr){
				try{
					if(resstr != '')
					{
						result = resstr.split("::::");
						alert(result[2]);
					}
				} catch(err){
					s=resstr;
					alert('Something went wrong please try again later!');
				}
			}
		});
		
	}
	
	function showSettingDiv(idval)
	{
		//$('#setting_div_'+idval).fadeIn('slow');
		$(".QTPopup").animate({width: 'show'}, 'slow');
	}
	
	function hideSettingDiv(idval)
	{
		$('#setting_div_'+idval).fadeOut('slow');
	}
</script>
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
						<td style="background-image: url(images/mainbox_title_bg.gif);" class="mainbox-title" width="100%">Manage Menus </td>
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
								<table border="1" width="100%" cellpadding="15" cellspacing="0" style="border-collapse:collapse;">
								<tbody>
                                	<tr>
                                    	<td align="center" width="50%" valign="middle" style="background-color:#cccccc;"><strong>Inactive Menu Items</strong></td>
                                        <td align="center" width="50%" valign="middle" style="background-color:#cccccc;"><strong>Active Menu Items</strong></td>
                                    </tr>
                                	<tr>
                                    	<td align="left" width="50%" valign="top" style="min-height:600px;">
                                        	<p><strong>Inactive Menu Items</strong></p>
                                            <p>Drag the item into the "<strong>Menu Structure</strong>" section to activate menu item.</p>
                                        
                                        	<ol id="sortable1" class="sortable" style="height:700px; overflow-y:scroll;">
                                            <?php
											for($i=0;$i<count($arr_inactive_menu_items);$i++ )
											{ ?>
												<li id="<?php echo $arr_inactive_menu_items[$i]['page_id'];?>">
                                                	<div style="position:relative;">
                                                    	<input type="hidden" name="hdnmenu_title_<?php echo $arr_inactive_menu_items[$i]['page_id'];?>" id="hdnmenu_title_<?php echo $arr_inactive_menu_items[$i]['page_id'];?>" value="<?php echo $arr_inactive_menu_items[$i]['menu_title'];?>"  />
                                                        <input type="hidden" name="hdnmenu_link_<?php echo $arr_inactive_menu_items[$i]['page_id'];?>" id="hdnmenu_link_<?php echo $arr_inactive_menu_items[$i]['page_id'];?>" value="<?php echo $arr_inactive_menu_items[$i]['menu_link'];?>"  />
                                                    	<strong><?php echo $arr_inactive_menu_items[$i]['menu_title'];?></strong>
                                                    	<?php /*?><div style=" display:none;position:absolute; cursor:pointer;  border:hidden; padding:0px;  right:0px; top:5px;"><img border="0" src="images/edit.png" height="16" alt="Edit"   /></div> <?php */?>   
                                                	</div>
                                                
                                                </li>
                                            <?php
											} ?>
                                            </ol>
                                        </td>
                                        <td align="left" valign="top" style="min-height:600px;">
                                        	<p><strong>Menu Structure</strong></p>
                                            <p>Drag each item into the order you prefer. </p>
                                        	<ol id="sortable2" class="sortable" style="height:700px; overflow-y:scroll;">
										<?php
                                        if(count($arr_active_menu_items) > 0)
                                        {
                                            foreach($arr_active_menu_items as $key => $val  )
                                            { ?>
												<li id="<?php echo $key;?>">
                                                	<div>
                                                    	<strong><?php echo $val['menu_details']['menu_title'];?></strong>
                                                    </div>
												<?php
                                                if(count($val['submenu_details']) > 0)
                                                { ?>
                                                    <ol>
													<?php	
                                                    foreach($val['submenu_details'][0] as $key2 => $val2  )
                                                    { ?>
                                                        <li id="<?php echo $key2;?>">
                                                            <div>
                                                                <strong><?php echo $val2['menu_details']['menu_title'];?></strong>
                                                            </div>
                                                            <?php
															if(count($val2['submenu_details']) > 0)
															{ ?>
																<ol>
																<?php	
																foreach($val2['submenu_details'][0] as $key3 => $val3  )
																{ ?>
																	<li id="<?php echo $key3;?>">
																		<div>
																			<strong><?php echo $val3['menu_details']['menu_title'];?></strong>
																		</div>
																	</li>
																<?php
																} ?>
																</ol>
															<?php    
															} ?>
                                                        </li>
                                                    <?php
                                                    } ?>
                                                    </ol>
                                                <?php    
                                                } ?>
                                                </li>
                                            <?php
											}
										} ?>
                                            </ol>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="2" align="center" valign="middle" style="background-color:#cccccc;"><input type="button" name="btnSave" id="btnSave" value="Save"   />
                                        <pre id="result" />
                                        </td>
                                    </tr>
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
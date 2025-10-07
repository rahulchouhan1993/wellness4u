<?php
doPageVisitLog($page_id);
list($top_banner,$top_position,$top_height,$top_weight) = GetTopBanner();
list($arr_banner_id,$arr_page_id,$arr_page,$arr_position_id,$arr_banner,$arr_url,$arr_banner_type,$arr_position,$arr_side,$arr_width,$arr_height) = getbanners($page_id,'Top');

list($arr_banner_id_banner,$arr_page_id_banner,$arr_page_banner,$arr_position_id_banner,$arr_banner_banner,$arr_url_banner,$arr_banner_type_banner,$arr_position_banner,$arr_side_banner,$arr_width_banner,$arr_height_banner) = getbanners($page_id,'Banner');
	
//echo '<br><pre>';
//print_r($arr_banner_banner);
//echo '<br></pre>';
if(isset($arr_banner_banner[0]) && $arr_banner_banner[0] != '')
{
    $top_banner = $arr_banner_banner[0];
}	
?>




<div class="navbar navbar-default navbar-static-top yamm sticky" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                    
                    
                    <a class="navbar-brand" href="<?php echo SITE_URL;?>"><img src="uploads/cwri_logo.png" width="127" height="150" border="0" /></a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-left">
                         <?php
                                                $arr_active_menu_items = getAllActiveMenuItems(0);
                                                if(count($arr_active_menu_items) > 0)
                                                {
                                                    foreach($arr_active_menu_items as $key => $val  )
                                                    {
                                                        if($val['menu_details']['link_enable'] == '1')
                                                        { 
                                                            $menu_link1 = $val['menu_details']['menu_link'];
                                                            if($menu_link1 == '')
                                                            {
                                                                $menu_link1 = '#';
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $menu_link1 = '#';
                                                        } ?>
                                                        <li>
                                                            <a href="<?php echo $menu_link1;?>"><?php echo $val['menu_details']['menu_title'];?></a>
                                                        <?php
                                                        if(count($val['submenu_details']) > 0)
                                                        { ?>
                                                            <ul>
                                                            <?php	
                                                            foreach($val['submenu_details'][0] as $key2 => $val2  )
                                                            { 
                                                                if($val2['menu_details']['link_enable'] == '1')
                                                                { 
                                                                    $menu_link2 = $val2['menu_details']['menu_link'];
                                                                    if($menu_link2 == '')
                                                                    {
                                                                        $menu_link2 = '#';
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    $menu_link2 = '#';
                                                                } ?>
                                                                <li>
                                                                    <a href="<?php echo $menu_link2;?>"><?php echo $val2['menu_details']['menu_title'];?></a>
                                                                <?php
                                                                if(count($val2['submenu_details']) > 0)
                                                                { ?>
                                                                    <ul>
                                                                    <?php	
                                                                    foreach($val2['submenu_details'][0] as $key3 => $val3  )
                                                                    {
                                                                        if($val3['menu_details']['link_enable'] == '1')
                                                                        { 
                                                                            $menu_link3 = $val3['menu_details']['menu_link'];
                                                                            if($menu_link3 == '')
                                                                            {
                                                                                $menu_link3 = '#';
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $menu_link3 = '#';
                                                                        } ?>
									<li style="border-left: 1px solid #ffffff;border-right: 1px solid #ffffff;">
                                                                            <a href="<?php echo $menu_link3;?>"><?php echo $val3['menu_details']['menu_title'];?></a>
                                                                        </li>
                                                                    <?php
                                                                    } ?>
                                                                    </ul>
                                                                <?php    
                                                                } ?>
                                                                </li>
                                                            <?php
                                                            } ?>
                                                            </ul>
                                                        <?php    
                                                        } ?>
                                                        </li>
                                                    <?php
                                                    } ?>
                                                <?php        
                                                } ?>
                                                    <?php
                                                    if(isLoggedIn() || isLoggedInPro())
                                                    { ?>
                                                        <li><a href="logout.php">Logout</a></li>
                                                    <?php
                                                    }
                                                    else
                                                    { ?>
                                                        <li><a href="login.php">Login&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                                                    <?php
                                                    } ?>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--container-->
        </div>
   <?php echo getScrollingBarCode($page_id)?>
<?php
list($top_banner,$top_position,$top_height,$top_weight) = GetTopBanner();
list($arr_banner_id,$arr_page_id,$arr_page,$arr_position_id,$arr_banner,$arr_url,$arr_banner_type,$arr_position,$arr_side,$arr_width,$arr_height) = getbanners($page_id,'Top');

$default_adviser_top_banner = false;
$adviser_top_banner = getAdviserTopBanner($_SESSION['pro_user_id']);
if($adviser_top_banner == '')
{
	//list($arr_banner_id_banner,$arr_page_id_banner,$arr_page_banner,$arr_position_id_banner,$arr_banner_banner,$arr_url_banner,$arr_banner_type_banner,$arr_position_banner,$arr_side_banner,$arr_width_banner,$arr_height_banner) = getbanners($page_id,'Banner');
	
	//if(isset($arr_banner_banner[0]) && $arr_banner_banner[0] != '')
	//{
	//	$top_banner = $arr_banner_banner[0];
	//}	
	$default_adviser_top_banner = true;
	$top_banner = 'default_adviser_top_banner.jpg';
}
else
{
	$top_banner = $adviser_top_banner;
}
?>

            
    <div class="container">
    
    <div class="row" style="margin-bottom:25px;">	
    <!-- logo -->
<div class="col-md-2" style="height:100px;">
                    
                        <?php //<img src="images/ww4u_logo.png" width="102" height="100" /> ?>
                        <a class="navbar-brand" href="<?php echo SITE_URL;?>"><img src="../uploads/cwri_logo.png" width="100px" height="100px" border="0" /></a>
                        
                       <!-- <a href="<?php echo SITE_URL;?>"><img src="images/cwri_logo.png" width="100" height="100" border="0" /></a>-->
                   
  </div>
   <div class="col-md-8">
                                
                            <?php 
                            for($i=0;$i<count($arr_banner_id);$i++)
                            {
                                if($arr_banner[$i] != '') 
                                { ?>


<div class="row">	
<div class="col-md-12">
                                            <?php 
                                            if($arr_banner_type[$i] == 'Flash') 
                                            { ?>
                                                <a href="<?php echo $url1; ?>" target="_blank"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>"><param name="movie" value="<?php echo SITE_URL."../uploads/".$arr_banner[$i];?>" /><param name="quality" value="high" /><embed src="<?php echo SITE_URL."../uploads/".$arr_banner[$i];?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>"></embed></object></a>
                                            <?php 
                                            }
                                            elseif($arr_banner_type[$i] == 'Image') 
                                            { ?>
                                                <a href="<?php echo $url1; ?>" target="_blank"><img src="<?php echo SITE_URL."../uploads/".$arr_banner[$i];?>" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>" border="0" /></a>
                                            <?php 
                                            }
                                            elseif($arr_banner_type[$i] == 'Video') 
                                            { ?>
                                                <a href="<?php echo $url1; ?>" target="_blank"><iframe width="<?php echo $arr_width[$i]; ?>" height="<?php echo $arr_height[$i]; ?>" src="<?php echo getBannerString($arr_banner[$i]); ?>" frameborder="0" allowfullscreen></iframe></a>
                                            <?php 
                                            }
                                            elseif($arr_banner_type[$i] == 'Google Ads') 
                                            {
                                                echo $arr_banner[$i];
                                            } ?>
                                     </div>
                                     </div>
                               <?php 
                               }
                            } ?>
     </div>
</div>
</div>
 
     <!-- Static navbar -->
 <div class="container">
      <nav class="navbar navbar-default">
       
          <div class="navbar-header">
                                                <div id="smoothmenu1" class="ddsmoothmenu">
                                                    <ul>
                                                <?php
                                                $arr_active_menu_items = getAllActiveMenuItemsAdviser(0);
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
                                                            else
                                                            {
                                                                $menu_link1 = SITE_URL.'/'.$menu_link1;
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
                                                                    else
                                                                    {
                                                                        $menu_link2 = SITE_URL.'/'.$menu_link2;
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
                                                                            else
                                                                            {
                                                                                $menu_link3 = SITE_URL.'/'.$menu_link3;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $menu_link3 = '#';
                                                                        } ?>
                                                                        <li>
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
                                                    if(isLoggedInPro())
                                                    { ?>
                                                        <li><a href="<?php echo SITE_URL.'/'?>logout.php">Logout</a></li>
                                                    <?php
                                                    }
                                                    else
                                                    { ?>
                                                        <li><a href="<?php echo SITE_URL.'/'?>prof_login.php">Login&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                                                    <?php
                                                    } ?>
                                                    </ul>	
                                                </div>
</div>
</nav></div>
           
            
     <!-- Tips bar  -->
<div class="container">
<div class="row">	
<div class="col-md-12">	                   	
            <?php echo getScrollingBarCode($page_id)?>
 </div>
 </div>
 </div>
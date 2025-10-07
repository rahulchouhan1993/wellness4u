<?php
$page_id = '37';
$arr_active_menu_items = $obj->getAllActiveMenuItems(0);

list($top_banner,$top_position,$top_height,$top_weight) = $obj->GetTopBanner();

list($arr_banner_id,$arr_page_id,$arr_page,$arr_position_id,$arr_banner,$arr_url,$arr_banner_type,$arr_position,$arr_side,$arr_width,$arr_height) = $obj->getbanners($page_id,'Top');

list($arr_banner_id_banner,$arr_page_id_banner,$arr_page_banner,$arr_position_id_banner,$arr_banner_banner,$arr_url_banner,$arr_banner_type_banner,$arr_position_banner,$arr_side_banner,$arr_width_banner,$arr_height_banner) = $obj->getbanners($page_id,'Banner');

//echo '<br><pre>';
//print_r($arr_banner_type);
//echo '<br></pre>';


if(isset($arr_banner_banner[0]) && $arr_banner_banner[0] != '')

{

    $top_banner = $arr_banner_banner[0];

}

//echo '<pre>';
//print_r($top_banner);
//echo '</pre>';

?>
<header>
	<nav>
            <div class="container">
                <div class="col-md-2">
                    <a href="index.php" class="logo">
                        <img src="images/cwri_logo.png" class="img-responsive" alt="logo.png">
                    </a>
                </div>
                <div class="col-md-10" class="img-responsive">

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

                                                <a href="<?php echo $url1; ?>" target="_blank"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>"><param name="movie" value="<?php echo SITE_URL."/uploads/".$arr_banner[$i];?>" /><param name="quality" value="high" /><embed src="<?php echo SITE_URL."/uploads/".$arr_banner[$i];?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>"></embed></object></a>

                                            <?php 

                                            }

                                            elseif($arr_banner_type[$i] == 'Image') 

                                            { 
                                                
                                                //echo 'hiiii';
                                                ?>

                                                <a href="<?php echo $url1; ?>" target="_blank"><img src="<?php echo SITE_URL."/uploads/".$arr_banner[$i];?>" width="<?php echo $arr_width[$i];?>" height="<?php echo $arr_height[$i]; ?>" border="0" /></a>

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

                                            } 
                                            elseif($arr_banner_type[$i] == 'Affilite Ads'|| $arr_banner_type[$i] == 'Other Ads') 

                                            {

                                                echo $arr_banner[$i];

                                            } 
                                            
                                            ?>

                                  </div></div>

                               <?php 

                               }

                            } ?>

     </div>
                
            </div>
            <div class="container">
			<div class="navbar-header">
				<button type="button"  class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
                            
                    </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="navbar-left">
                                    
                                    <?php 
                                    
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



                                                    if($obj->isLoggedIn() || $obj->isLoggedInPro())



                                                    { ?>



                                                        <li><a href="logout.php">Logout</a></li>



                                                    <?php



                                                    }



                                                    else



                                                    { ?>



                                                        <li><a href="login-new.php">Login&nbsp;&nbsp;&nbsp;&nbsp;</a></li>



                                                    <?php



                                                    } ?>

				</ul>
            </div>
		
	</div>
	</nav>
</header>
<?php
